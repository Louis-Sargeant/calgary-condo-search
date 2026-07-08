<?php
/**
 * Admin-only first-batch building profile importer.
 *
 * @package CalgaryCondoLeads
 */

if (!defined('ABSPATH')) {
    exit;
}

final class Calgary_Condo_Building_Batch_Importer {
    private const PAGE_SLUG = 'ccl-building-batch-importer';
    private const DRY_RUN_ACTION = 'ccl_building_batch_importer_dry_run';
    private const IMPORT_ACTION = 'ccl_building_batch_importer_import';
    private const DRY_RUN_NONCE_ACTION = 'ccl_building_batch_importer_dry_run_nonce';
    private const IMPORT_NONCE_ACTION = 'ccl_building_batch_importer_import_nonce';
    private const BATCH_DATA_FILE = CCL_PLUGIN_DIR . 'data/building-first-batch.php';
    private const DUPLICATE_DETECTION_LIMIT = 2;

    public function __construct() {
        if (!is_admin()) {
            return;
        }

        add_action('admin_menu', [$this, 'register_admin_page']);
        add_action('admin_post_' . self::DRY_RUN_ACTION, [$this, 'handle_dry_run']);
        add_action('admin_post_' . self::IMPORT_ACTION, [$this, 'handle_import']);
    }

    public function register_admin_page(): void {
        add_management_page(
            __('Calgary Building Batch Import', 'calgary-condo-leads'),
            __('Calgary Building Batch Import', 'calgary-condo-leads'),
            'manage_options',
            self::PAGE_SLUG,
            [$this, 'render_admin_page']
        );
    }

    public function render_admin_page(): void {
        if (!current_user_can('manage_options')) {
            wp_die(esc_html__('You do not have permission to access this page.', 'calgary-condo-leads'));
        }

        $dry_run_data = get_transient($this->dry_run_transient_key());
        $import_data = get_transient($this->import_transient_key());
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('Calgary Building Batch Import', 'calgary-condo-leads'); ?></h1>
            <p><?php esc_html_e('Imports the first production building batch from a structured PHP source array. The importer is repeatable and updates existing matching posts instead of creating duplicates.', 'calgary-condo-leads'); ?></p>
            <p><code><?php echo esc_html(str_replace(CCL_PLUGIN_DIR, 'plugins/calgary-condo-leads/', self::BATCH_DATA_FILE)); ?></code></p>

            <h2><?php esc_html_e('Step 1: Dry-run (no writes)', 'calgary-condo-leads'); ?></h2>
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <input type="hidden" name="action" value="<?php echo esc_attr(self::DRY_RUN_ACTION); ?>" />
                <?php wp_nonce_field(self::DRY_RUN_NONCE_ACTION, 'ccl_building_batch_importer_nonce'); ?>
                <?php submit_button(__('Run dry-run first batch import', 'calgary-condo-leads')); ?>
            </form>

            <?php if (is_array($dry_run_data) && !empty($dry_run_data['summary'])) : ?>
                <h2><?php esc_html_e('Dry-run summary', 'calgary-condo-leads'); ?></h2>
                <?php $this->render_summary($dry_run_data['summary']); ?>
                <?php $this->render_rows($dry_run_data['summary']); ?>

                <h2><?php esc_html_e('Step 2: Confirm import writes', 'calgary-condo-leads'); ?></h2>
                <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                    <input type="hidden" name="action" value="<?php echo esc_attr(self::IMPORT_ACTION); ?>" />
                    <input type="hidden" name="dry_run_token" value="<?php echo esc_attr((string) ($dry_run_data['token'] ?? '')); ?>" />
                    <?php wp_nonce_field(self::IMPORT_NONCE_ACTION, 'ccl_building_batch_importer_nonce'); ?>
                    <label>
                        <input type="checkbox" name="confirm_import" value="yes" required />
                        <?php esc_html_e('I confirm I want to create/update ccl_building posts from the first batch source.', 'calgary-condo-leads'); ?>
                    </label>
                    <?php submit_button(__('Run confirmed import', 'calgary-condo-leads'), 'primary'); ?>
                </form>
            <?php endif; ?>

            <?php if (is_array($import_data) && !empty($import_data['summary'])) : ?>
                <h2><?php esc_html_e('Import results', 'calgary-condo-leads'); ?></h2>
                <?php $this->render_summary($import_data['summary']); ?>
                <?php $this->render_rows($import_data['summary']); ?>
            <?php endif; ?>
        </div>
        <?php
    }

    public function handle_dry_run(): void {
        $this->assert_admin_request(self::DRY_RUN_NONCE_ACTION, 'ccl_building_batch_importer_nonce');

        $rows = $this->load_source_rows();
        $summary = $this->run_import($rows, false);
        set_transient(
            $this->dry_run_transient_key(),
            [
                'token' => wp_generate_uuid4(),
                'summary' => $summary,
                'created_at' => time(),
            ],
            30 * MINUTE_IN_SECONDS
        );
        delete_transient($this->import_transient_key());

        $this->redirect_to_admin_page();
    }

    public function handle_import(): void {
        $this->assert_admin_request(self::IMPORT_NONCE_ACTION, 'ccl_building_batch_importer_nonce');

        $confirm = isset($_POST['confirm_import']) ? sanitize_text_field(wp_unslash($_POST['confirm_import'])) : '';
        $token = isset($_POST['dry_run_token']) ? sanitize_text_field(wp_unslash($_POST['dry_run_token'])) : '';
        $dry_run_data = get_transient($this->dry_run_transient_key());

        if ('yes' !== $confirm || !is_array($dry_run_data) || $token === '' || !hash_equals((string) ($dry_run_data['token'] ?? ''), $token)) {
            wp_die(esc_html__('Import confirmation is invalid or expired. Please run dry-run again.', 'calgary-condo-leads'));
        }

        $rows = $this->load_source_rows();
        $summary = $this->run_import($rows, true);
        set_transient(
            $this->import_transient_key(),
            [
                'summary' => $summary,
                'created_at' => time(),
            ],
            30 * MINUTE_IN_SECONDS
        );

        $this->redirect_to_admin_page();
    }

    /**
     * @return array<int,array<string,mixed>>
     */
    private function load_source_rows(): array {
        $rows = [];
        if (!file_exists(self::BATCH_DATA_FILE)) {
            return $rows;
        }

        $data = require self::BATCH_DATA_FILE;
        if (!is_array($data)) {
            return $rows;
        }

        foreach ($data as $row) {
            if (!is_array($row)) {
                continue;
            }
            $rows[] = $row;
        }

        return $rows;
    }

    /**
     * @param array<int,array<string,mixed>> $rows
     * @return array<string,mixed>
     */
    private function run_import(array $rows, bool $write): array {
        $counts = [
            'created' => 0,
            'updated' => 0,
            'skipped' => 0,
            'failed' => 0,
        ];
        $results = [];
        $seen_slugs = [];

        foreach ($rows as $row_number => $row) {
            $prepared = $this->prepare_row($row, $row_number + 1);
            if ('' === $prepared['name'] || '' === $prepared['community'] || '' === $prepared['slug']) {
                $counts['failed']++;
                $results[] = $this->row_result($prepared, 'failed', __('Missing required name/community values.', 'calgary-condo-leads'));
                continue;
            }

            if (isset($seen_slugs[$prepared['slug']])) {
                $counts['skipped']++;
                $results[] = $this->row_result($prepared, 'skipped', __('Duplicate slug in source batch. Earlier row already processed.', 'calgary-condo-leads'));
                continue;
            }
            $seen_slugs[$prepared['slug']] = true;

            $match = $this->find_existing_building($prepared['slug'], $prepared['name']);
            if ('duplicate' === $match['status']) {
                $counts['failed']++;
                $results[] = $this->row_result($prepared, 'failed', __('Multiple existing buildings matched slug/title. Resolve duplicates manually first.', 'calgary-condo-leads'));
                continue;
            }

            $existing_id = (int) ($match['post_id'] ?? 0);
            $is_update = $existing_id > 0;
            $has_changes = !$is_update || $this->has_changes($existing_id, $prepared);
            if (!$has_changes) {
                $counts['skipped']++;
                $results[] = $this->row_result($prepared, 'skipped', __('Already up-to-date.', 'calgary-condo-leads'), $existing_id);
                continue;
            }

            $persisted_id = $existing_id;
            if ($write) {
                $persisted_id = $this->persist_building($existing_id, $prepared);
                if ($persisted_id <= 0) {
                    $counts['failed']++;
                    $results[] = $this->row_result($prepared, 'failed', __('Unable to persist building.', 'calgary-condo-leads'), $existing_id);
                    continue;
                }
            }

            if ($is_update) {
                $counts['updated']++;
                $results[] = $this->row_result($prepared, 'updated', $write ? __('Updated.', 'calgary-condo-leads') : __('Would update.', 'calgary-condo-leads'), $persisted_id);
                continue;
            }

            $counts['created']++;
            $results[] = $this->row_result($prepared, 'created', $write ? __('Created.', 'calgary-condo-leads') : __('Would create.', 'calgary-condo-leads'), $persisted_id);
        }

        return [
            'mode' => $write ? 'import' : 'dry-run',
            'counts' => $counts,
            'rows' => $results,
            'generated_at' => current_time('mysql'),
        ];
    }

    /**
     * @param array<string,mixed> $row
     * @return array<string,mixed>
     */
    private function prepare_row(array $row, int $row_number): array {
        $name = sanitize_text_field((string) ($row['name'] ?? $row['building_name'] ?? ''));
        $community = sanitize_text_field((string) ($row['community'] ?? $row['building_community'] ?? ''));
        $slug = sanitize_title((string) ($row['slug'] ?? $name));
        $address = sanitize_text_field((string) ($row['address'] ?? $row['building_address'] ?? ''));
        $year_built = sanitize_text_field((string) ($row['year_built'] ?? $row['building_year_built'] ?? ''));
        $building_type = sanitize_text_field((string) ($row['building_type'] ?? $row['building_construction_type'] ?? ''));
        $amenities = sanitize_textarea_field((string) ($row['amenities'] ?? $row['ccl_building_amenities'] ?? ''));
        $story = sanitize_textarea_field((string) ($row['story'] ?? $row['description'] ?? $row['building_story'] ?? ''));
        $listings_page_url = sanitize_text_field((string) ($row['listings_page_url'] ?? $row['building_listings_page_url'] ?? ''));

        return [
            'row_number' => $row_number,
            'name' => $name,
            'slug' => $slug,
            'community' => $community,
            'meta' => [
                'building_community' => $community,
                'building_address' => $address,
                'building_year_built' => $year_built,
                'building_construction_type' => $building_type,
                'ccl_building_amenities' => $amenities,
                'building_listings_page_url' => $listings_page_url,
            ],
            'content' => $story,
        ];
    }

    /**
     * @return array<string,mixed>
     */
    private function find_existing_building(string $slug, string $name): array {
        $slug_matches = get_posts([
            'post_type' => Calgary_Condo_Building_CPT::POST_TYPE,
            'post_status' => 'any',
            'name' => $slug,
            'posts_per_page' => self::DUPLICATE_DETECTION_LIMIT,
            'fields' => 'ids',
            'no_found_rows' => true,
        ]);

        if (count($slug_matches) > 1) {
            return ['status' => 'duplicate', 'post_id' => 0];
        }

        if (!empty($slug_matches)) {
            return ['status' => 'matched_slug', 'post_id' => (int) $slug_matches[0]];
        }

        global $wpdb;
        $query = $wpdb->prepare(
            "SELECT ID FROM {$wpdb->posts} WHERE post_type = %s AND post_title = %s ORDER BY ID ASC LIMIT %d",
            Calgary_Condo_Building_CPT::POST_TYPE,
            $name,
            self::DUPLICATE_DETECTION_LIMIT
        );
        $title_matches = $wpdb->get_col($query);
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
     * @param array<string,mixed> $prepared
     */
    private function has_changes(int $post_id, array $prepared): bool {
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
                continue;
            }

            $current = trim((string) get_post_meta($post_id, $meta_key, true));
            if ($current !== $incoming) {
                return true;
            }
        }

        $target_status = $this->determine_target_status($post_id, $prepared);
        $current_status = (string) get_post_field('post_status', $post_id);
        if ($current_status !== $target_status) {
            return true;
        }

        $community_terms = wp_get_post_terms($post_id, 'ccl_building_community', ['fields' => 'names']);
        if (is_wp_error($community_terms)) {
            error_log('Calgary building batch importer: unable to read ccl_building_community terms for post ' . $post_id . '.');
            return true;
        }

        $community_terms = array_values($community_terms);
        if (count($community_terms) !== 1) {
            error_log('Calgary building batch importer: unexpected ccl_building_community term count for post ' . $post_id . '.');
            return true;
        }

        $incoming_community = (string) ($prepared['meta']['building_community'] ?? '');
        $current_community = trim((string) $community_terms[0]);

        return $current_community !== $incoming_community;
    }

    /**
     * @param array<string,mixed> $prepared
     */
    private function persist_building(int $existing_id, array $prepared): int {
        $name = (string) ($prepared['name'] ?? '');
        $slug = (string) ($prepared['slug'] ?? '');
        if ('' === $name || '' === $slug) {
            return 0;
        }

        $postarr = [
            'post_type' => Calgary_Condo_Building_CPT::POST_TYPE,
            'post_title' => $name,
            'post_name' => $slug,
            'post_status' => $this->determine_target_status($existing_id, $prepared),
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
        $meta = is_array($prepared['meta'] ?? null) ? $prepared['meta'] : [];
        foreach ($meta as $meta_key => $incoming_value) {
            $value = trim((string) $incoming_value);

            if ('' === $value) {
                continue;
            }

            update_post_meta($post_id, $meta_key, $value);
        }

        $community = (string) ($prepared['meta']['building_community'] ?? '');
        if ('' !== $community) {
            $term_result = wp_set_post_terms($post_id, [$community], 'ccl_building_community', false);
            if (is_wp_error($term_result)) {
                error_log('Calgary building batch importer: unable to set ccl_building_community term for post ' . $post_id . '.');
                return 0;
            }
        }

        return $post_id;
    }

    /**
     * @param array<string,mixed> $prepared
     */
    private function determine_target_status(int $existing_id, array $prepared): string {
        $meta = is_array($prepared['meta'] ?? null) ? $prepared['meta'] : [];
        $incoming_content = trim((string) ($prepared['content'] ?? ''));
        $current_content = $existing_id > 0 ? trim((string) get_post_field('post_content', $existing_id)) : '';

        $community = trim((string) ($meta['building_community'] ?? ''));
        $building_type = trim((string) ($meta['building_construction_type'] ?? ''));
        $story = '' !== $incoming_content ? $incoming_content : $current_content;

        if ('' !== $community && '' !== $building_type && '' !== $story) {
            return 'publish';
        }

        return 'draft';
    }

    /**
     * @param array<string,mixed> $prepared
     * @return array<string,mixed>
     */
    private function row_result(array $prepared, string $action, string $message, int $post_id = 0): array {
        return [
            'row_number' => (int) ($prepared['row_number'] ?? 0),
            'name' => (string) ($prepared['name'] ?? ''),
            'community' => (string) ($prepared['community'] ?? ''),
            'slug' => (string) ($prepared['slug'] ?? ''),
            'action' => $action,
            'message' => $message,
            'post_id' => $post_id,
        ];
    }

    /**
     * @param array<string,mixed> $summary
     */
    private function render_summary(array $summary): void {
        $counts = is_array($summary['counts'] ?? null) ? $summary['counts'] : [];
        ?>
        <p><strong><?php echo esc_html(sprintf(__('Mode: %s', 'calgary-condo-leads'), (string) ($summary['mode'] ?? ''))); ?></strong></p>
        <ul>
            <li><?php echo esc_html(sprintf(__('Created: %d', 'calgary-condo-leads'), (int) ($counts['created'] ?? 0))); ?></li>
            <li><?php echo esc_html(sprintf(__('Updated: %d', 'calgary-condo-leads'), (int) ($counts['updated'] ?? 0))); ?></li>
            <li><?php echo esc_html(sprintf(__('Skipped: %d', 'calgary-condo-leads'), (int) ($counts['skipped'] ?? 0))); ?></li>
            <li><?php echo esc_html(sprintf(__('Failed: %d', 'calgary-condo-leads'), (int) ($counts['failed'] ?? 0))); ?></li>
        </ul>
        <?php
    }

    /**
     * @param array<string,mixed> $summary
     */
    private function render_rows(array $summary): void {
        $rows = is_array($summary['rows'] ?? null) ? $summary['rows'] : [];
        if (empty($rows)) {
            return;
        }
        ?>
        <table class="widefat striped">
            <thead>
                <tr>
                    <th><?php esc_html_e('Row', 'calgary-condo-leads'); ?></th>
                    <th><?php esc_html_e('Building', 'calgary-condo-leads'); ?></th>
                    <th><?php esc_html_e('Community', 'calgary-condo-leads'); ?></th>
                    <th><?php esc_html_e('Slug', 'calgary-condo-leads'); ?></th>
                    <th><?php esc_html_e('Action', 'calgary-condo-leads'); ?></th>
                    <th><?php esc_html_e('Details', 'calgary-condo-leads'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row) : ?>
                    <tr>
                        <td><?php echo esc_html((string) ($row['row_number'] ?? '')); ?></td>
                        <td><?php echo esc_html((string) ($row['name'] ?? '')); ?></td>
                        <td><?php echo esc_html((string) ($row['community'] ?? '')); ?></td>
                        <td><code><?php echo esc_html((string) ($row['slug'] ?? '')); ?></code></td>
                        <td><?php echo esc_html((string) ($row['action'] ?? '')); ?></td>
                        <td><?php echo esc_html((string) ($row['message'] ?? '')); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
    }

    private function assert_admin_request(string $nonce_action, string $nonce_name): void {
        if (!current_user_can('manage_options')) {
            wp_die(esc_html__('You do not have permission to perform this action.', 'calgary-condo-leads'));
        }

        check_admin_referer($nonce_action, $nonce_name);
    }

    private function dry_run_transient_key(): string {
        return 'ccl_building_batch_importer_dry_run_' . get_current_user_id();
    }

    private function import_transient_key(): string {
        return 'ccl_building_batch_importer_import_' . get_current_user_id();
    }

    private function redirect_to_admin_page(): void {
        wp_safe_redirect(admin_url('tools.php?page=' . self::PAGE_SLUG));
        exit;
    }
}

new Calgary_Condo_Building_Batch_Importer();
