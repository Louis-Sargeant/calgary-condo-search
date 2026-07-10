<?php
/**
 * Versioned auto-seed runner for ccl_building posts.
 *
 * Hooks into `init` at priority 30 (after the CPT and default terms are
 * registered).  Compares the stored `ccl_building_seed_version` option against
 * CURRENT_SEED_VERSION and runs any outstanding batch data files.  Safe to
 * run repeatedly: existing buildings are matched by slug or exact title and
 * only updated when a field actually changes.  Empty import values are never
 * written, so existing meta (e.g. building_listings_page_url) is preserved.
 *
 * @package CalgaryCondoLeads
 */

if (!defined('ABSPATH')) {
    exit;
}

final class Calgary_Condo_Building_Seed_Runner {

    const OPTION_KEY = 'ccl_building_seed_version';

    /**
     * Increment this constant whenever a new batch data file is added.
     * Batch 1 = version 1, Batch 2 = version 2, …
     */
    const CURRENT_SEED_VERSION = 8;

    private const BATCH_FILES = [
        1 => 'building-first-batch.php',
        2 => 'building-second-batch.php',
        3 => 'building-third-batch.php',
        4 => 'building-fourth-batch.php',
        5 => 'building-fifth-batch.php',
        6 => 'building-sixth-batch.php',
        7 => 'building-seventh-batch.php',
        8 => 'building-eighth-batch.php',
    ];

    private const DUPLICATE_DETECTION_LIMIT = 2;

    /**
     * Register the init hook.  Call once from the main plugin file.
     */
    public static function register(): void {
        add_action('init', [static::class, 'maybe_run'], 30);
    }

    /**
     * Run any seed batches whose version number exceeds the stored option.
     * The static guard ensures this is a no-op if somehow called more than
     * once in the same request (WP caches options, but be explicit).
     */
    public static function maybe_run(): void {
        static $ran = false;
        if ($ran) {
            return;
        }
        $ran = true;

        $saved = (int) get_option(self::OPTION_KEY, 0);

        if ($saved >= self::CURRENT_SEED_VERSION) {
            return;
        }

        for ($v = $saved + 1; $v <= self::CURRENT_SEED_VERSION; $v++) {
            if (!isset(self::BATCH_FILES[$v])) {
                continue;
            }

            $file = CCL_PLUGIN_DIR . 'data/' . self::BATCH_FILES[$v];
            $counts = self::run_batch($file);

            // Log a summary for each batch whether or not there were failures.
            error_log(
                sprintf(
                    'CCL seed runner v%d: created=%d updated=%d skipped=%d failed=%d (file: %s)',
                    $v,
                    $counts['created'],
                    $counts['updated'],
                    $counts['skipped'],
                    $counts['failed'],
                    basename($file)
                )
            );

            // Always advance the stored version so a partially-failed batch
            // is not retried on every page load.  Individual failures are
            // logged above and can be corrected via the admin importer UI.
            update_option(self::OPTION_KEY, $v, false);
        }
    }

    // -------------------------------------------------------------------------
    // Private helpers
    // -------------------------------------------------------------------------

    /**
     * Load a batch data file and upsert each building row.
     *
     * @return array{created:int,updated:int,skipped:int,failed:int}
     */
    private static function run_batch(string $file): array {
        $counts = [
            'created' => 0,
            'updated' => 0,
            'skipped' => 0,
            'failed'  => 0,
        ];

        if (!file_exists($file)) {
            error_log('CCL seed runner: batch file not found — ' . $file);
            return $counts;
        }

        $data = require $file;
        if (!is_array($data)) {
            error_log('CCL seed runner: batch file did not return an array — ' . $file);
            return $counts;
        }

        $seen_slugs = [];

        foreach ($data as $row) {
            if (!is_array($row)) {
                $counts['failed']++;
                continue;
            }

            $prepared = self::prepare_row($row);

            if ('' === $prepared['name'] || '' === $prepared['community'] || '' === $prepared['slug']) {
                $counts['failed']++;
                error_log('CCL seed runner: missing required fields — ' . wp_json_encode($row));
                continue;
            }

            if (isset($seen_slugs[$prepared['slug']])) {
                $counts['skipped']++;
                continue;
            }
            $seen_slugs[$prepared['slug']] = true;

            $match = self::find_existing_building($prepared['slug'], $prepared['name']);

            if ('duplicate' === $match['status']) {
                $counts['failed']++;
                error_log('CCL seed runner: duplicate buildings found for slug/title — ' . $prepared['slug']);
                continue;
            }

            $existing_id = (int) ($match['post_id'] ?? 0);

            if ($existing_id > 0 && !self::has_changes($existing_id, $prepared)) {
                $counts['skipped']++;
                continue;
            }

            $persisted_id = self::persist_building($existing_id, $prepared);

            if ($persisted_id <= 0) {
                $counts['failed']++;
                error_log('CCL seed runner: failed to persist building — ' . $prepared['name']);
                continue;
            }

            if ($existing_id > 0) {
                $counts['updated']++;
            } else {
                $counts['created']++;
            }
        }

        return $counts;
    }

    /**
     * Normalise a raw data row into a prepared array.
     *
     * @param  array<string,mixed> $row
     * @return array<string,mixed>
     */
    private static function prepare_row(array $row): array {
        $name      = sanitize_text_field((string) ($row['name'] ?? $row['building_name'] ?? ''));
        $community = sanitize_text_field((string) ($row['community'] ?? $row['building_community'] ?? ''));
        $slug      = sanitize_title((string) ($row['slug'] ?? $name));
        $address   = sanitize_text_field((string) ($row['address'] ?? $row['building_address'] ?? ''));
        $year_built     = sanitize_text_field((string) ($row['year_built'] ?? $row['building_year_built'] ?? ''));
        $building_type  = sanitize_text_field((string) ($row['building_type'] ?? $row['building_construction_type'] ?? ''));
        $developer      = sanitize_text_field((string) ($row['developer'] ?? $row['building_developer'] ?? ''));
        $storeys        = sanitize_text_field((string) ($row['storeys'] ?? $row['building_stories'] ?? ''));
        $amenities      = sanitize_textarea_field((string) ($row['amenities'] ?? $row['ccl_building_amenities'] ?? ''));
        $story          = sanitize_textarea_field((string) ($row['story'] ?? $row['description'] ?? $row['building_story'] ?? ''));
        $listings_url   = sanitize_text_field((string) ($row['listings_page_url'] ?? $row['building_listings_page_url'] ?? ''));

        return [
            'name'      => $name,
            'slug'      => $slug,
            'community' => $community,
            'content'   => $story,
            'meta'      => [
                'building_community'         => $community,
                'building_address'           => $address,
                'building_year_built'        => $year_built,
                'building_developer'         => $developer,
                'building_stories'           => $storeys,
                'building_construction_type' => $building_type,
                'ccl_building_amenities'     => $amenities,
                'building_listings_page_url' => $listings_url,
            ],
        ];
    }

    /**
     * Find an existing ccl_building post by slug (post_name) then exact title.
     *
     * @return array{status:string,post_id:int}
     */
    private static function find_existing_building(string $slug, string $name): array {
        $slug_matches = get_posts([
            'post_type'      => Calgary_Condo_Building_CPT::POST_TYPE,
            'post_status'    => 'any',
            'name'           => $slug,
            'posts_per_page' => self::DUPLICATE_DETECTION_LIMIT,
            'fields'         => 'ids',
            'no_found_rows'  => true,
        ]);

        if (count($slug_matches) > 1) {
            return ['status' => 'duplicate', 'post_id' => 0];
        }

        if (!empty($slug_matches)) {
            return ['status' => 'matched_slug', 'post_id' => (int) $slug_matches[0]];
        }

        global $wpdb;
        $title_matches = $wpdb->get_col(
            $wpdb->prepare(
                "SELECT ID FROM {$wpdb->posts} WHERE post_type = %s AND post_title = %s ORDER BY ID ASC LIMIT %d",
                Calgary_Condo_Building_CPT::POST_TYPE,
                $name,
                self::DUPLICATE_DETECTION_LIMIT
            )
        );

        if (!is_array($title_matches)) {
            $title_matches = [];
        }

        if (count($title_matches) > 1) {
            return ['status' => 'duplicate', 'post_id' => 0];
        }

        if (!empty($title_matches)) {
            return ['status' => 'matched_title', 'post_id' => (int) $title_matches[0]];
        }

        return ['status' => 'new', 'post_id' => 0];
    }

    /**
     * Return true if the stored post differs from the prepared data.
     *
     * Empty import values are treated as "no opinion" and do not trigger an
     * update, which preserves existing meta such as building_listings_page_url.
     *
     * @param array<string,mixed> $prepared
     */
    private static function has_changes(int $post_id, array $prepared): bool {
        if (get_the_title($post_id) !== (string) $prepared['name']) {
            return true;
        }

        if ((string) get_post_field('post_name', $post_id) !== (string) $prepared['slug']) {
            return true;
        }

        $incoming_content = trim((string) ($prepared['content'] ?? ''));
        if ('' !== $incoming_content && (string) get_post_field('post_content', $post_id) !== $incoming_content) {
            return true;
        }

        $meta = is_array($prepared['meta'] ?? null) ? $prepared['meta'] : [];
        foreach ($meta as $meta_key => $incoming_value) {
            $incoming = trim((string) $incoming_value);
            if ('' === $incoming) {
                // Empty import value — do not overwrite existing.
                continue;
            }
            $current = trim((string) get_post_meta($post_id, $meta_key, true));
            if ($current !== $incoming) {
                return true;
            }
        }

        $target_status = self::determine_target_status($post_id, $prepared);
        $current_status = (string) get_post_field('post_status', $post_id);
        if ($current_status !== $target_status) {
            return true;
        }

        $community_terms = wp_get_post_terms($post_id, 'ccl_building_community', ['fields' => 'names']);
        if (is_wp_error($community_terms)) {
            return true;
        }

        $incoming_community = (string) ($prepared['meta']['building_community'] ?? '');

        // Building has no community terms but we have one to set — needs update.
        if (empty($community_terms) && '' !== $incoming_community) {
            return true;
        }

        // Building has exactly one community term — compare directly.
        if (1 === count($community_terms)) {
            return trim((string) $community_terms[0]) !== $incoming_community;
        }

        // Multiple terms: only flag a change when the incoming community is not
        // already among them (avoids spurious updates when extra terms exist).
        return !in_array($incoming_community, array_map('trim', $community_terms), true);
    }

    /**
     * Create or update a ccl_building post from prepared data.
     *
     * Empty meta values are never written so that existing post meta
     * (e.g. building_listings_page_url set to /the-guardian-active-listings/)
     * is preserved rather than overwritten with an empty string.
     *
     * @param array<string,mixed> $prepared
     */
    private static function persist_building(int $existing_id, array $prepared): int {
        $name = (string) ($prepared['name'] ?? '');
        $slug = (string) ($prepared['slug'] ?? '');
        if ('' === $name || '' === $slug) {
            return 0;
        }

        $postarr = [
            'post_type'   => Calgary_Condo_Building_CPT::POST_TYPE,
            'post_title'  => $name,
            'post_name'   => $slug,
            'post_status' => self::determine_target_status($existing_id, $prepared),
        ];

        $incoming_content = trim((string) ($prepared['content'] ?? ''));

        if ($existing_id > 0) {
            $postarr['ID'] = $existing_id;
            if ('' !== $incoming_content) {
                $postarr['post_content'] = $incoming_content;
            }
            $post_id = wp_update_post($postarr, true);
        } else {
            $postarr['post_content'] = $incoming_content;
            $post_id = wp_insert_post($postarr, true);
        }

        if (is_wp_error($post_id) || !$post_id) {
            return 0;
        }

        $post_id = (int) $post_id;
        $meta    = is_array($prepared['meta'] ?? null) ? $prepared['meta'] : [];

        foreach ($meta as $meta_key => $incoming_value) {
            $value = trim((string) $incoming_value);
            if ('' === $value) {
                // Preserve existing meta — never overwrite with an empty string.
                continue;
            }
            update_post_meta($post_id, $meta_key, $value);
        }

        $community = (string) ($prepared['meta']['building_community'] ?? '');
        if ('' !== $community) {
            $term_result = wp_set_post_terms($post_id, [$community], 'ccl_building_community', false);
            if (is_wp_error($term_result)) {
                error_log('CCL seed runner: unable to set ccl_building_community for post ' . $post_id . '.');
                // Community term failure is non-fatal; post was already saved.
            }
        }

        return $post_id;
    }

    /**
     * A building is published when it has a community, a building type, and a
     * story (description).  Otherwise it is saved as a draft.
     *
     * @param array<string,mixed> $prepared
     */
    private static function determine_target_status(int $existing_id, array $prepared): string {
        $meta             = is_array($prepared['meta'] ?? null) ? $prepared['meta'] : [];
        $incoming_content = trim((string) ($prepared['content'] ?? ''));
        $current_content  = $existing_id > 0 ? trim((string) get_post_field('post_content', $existing_id)) : '';

        $community     = trim((string) ($meta['building_community'] ?? ''));
        $building_type = trim((string) ($meta['building_construction_type'] ?? ''));
        $story         = '' !== $incoming_content ? $incoming_content : $current_content;

        if ('' !== $community && '' !== $building_type && '' !== $story) {
            return 'publish';
        }

        return 'draft';
    }
}
