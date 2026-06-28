<?php
/**
 * Admin-only dry-run building seeder/importer.
 *
 * @package CalgaryCondoLeads
 */

if (!defined('ABSPATH')) {
    exit;
}

final class Calgary_Condo_Building_Seeder {
    private const PAGE_SLUG = 'ccl-building-seeder';
    private const DRY_RUN_ACTION = 'ccl_building_seeder_dry_run';
    private const IMPORT_ACTION = 'ccl_building_seeder_import';
    private const DATA_MODE_ACTION = 'ccl_building_data_mode_update';
    private const DRY_RUN_NONCE_ACTION = 'ccl_building_seeder_dry_run_nonce';
    private const IMPORT_NONCE_ACTION = 'ccl_building_seeder_import_nonce';
    private const DATA_MODE_NONCE_ACTION = 'ccl_building_data_mode_nonce';
    private const IMPORT_KEY_META = '_ccl_building_import_key';
    private const DUPLICATE_DETECTION_LIMIT = 2;
    private const MISMATCH_REPORT_POST_LIMIT = 1000;
    private const LEGACY_POST_TYPES = [
        'ccl_buildings',
        'ccl_condo_building',
        'ccl_condo_buildings',
    ];

    /**
     * Source data stays hard-coded and unchanged in frontend files.
     *
     * @var array<int,array<string,string>>
     */
    private const SOURCE_BUILDINGS = [
        ['name' => 'The Guardian', 'area' => 'Victoria Park / Beltline', 'type' => 'High-rise', 'focus' => 'Downtown access, views, newer tower product'],
        ['name' => 'Keynote Urban Village', 'area' => 'Beltline / Victoria Park', 'type' => 'High-rise', 'focus' => 'Walkability, amenities, downtown lifestyle'],
        ['name' => 'Arriva', 'area' => 'Victoria Park', 'type' => 'Luxury high-rise', 'focus' => 'Larger plans, premium building profile'],
        ['name' => 'Sasso', 'area' => 'Victoria Park', 'type' => 'High-rise', 'focus' => 'Stampede Park access, Beltline value'],
        ['name' => 'Vetro', 'area' => 'Victoria Park', 'type' => 'High-rise', 'focus' => 'Beltline location and amenity access'],
        ['name' => 'Colours', 'area' => 'Beltline', 'type' => 'Concrete high-rise', 'focus' => 'Urban loft-style layouts'],
        ['name' => 'Union Square', 'area' => 'Beltline', 'type' => 'Concrete high-rise', 'focus' => 'Central Beltline ownership'],
        ['name' => 'Avenue West End', 'area' => 'Downtown West End', 'type' => 'Luxury high-rise', 'focus' => 'River pathway and downtown access'],
        ['name' => 'Vogue', 'area' => 'Downtown West End', 'type' => 'High-rise', 'focus' => 'Downtown living, concierge-style positioning'],
        ['name' => 'Princeton Grand', 'area' => 'Eau Claire', 'type' => 'Luxury low-rise', 'focus' => 'Premium riverfront positioning'],
        ['name' => 'Churchill Estates', 'area' => 'Downtown Commercial Core', 'type' => 'Luxury tower', 'focus' => 'Large suites and central business district access'],
        ['name' => 'Evolution', 'area' => 'East Village', 'type' => 'High-rise', 'focus' => 'River pathways, library, downtown east growth'],
        ['name' => 'Verve', 'area' => 'East Village', 'type' => 'High-rise', 'focus' => 'Modern East Village lifestyle'],
        ['name' => 'Ink', 'area' => 'East Village', 'type' => 'Entry-level high-rise', 'focus' => 'Entry-level downtown ownership'],
        ['name' => 'Bridgeland Crossing', 'area' => 'Bridgeland', 'type' => 'Mid-rise', 'focus' => 'C-Train, river, inner-city neighbourhood feel'],
        ['name' => 'Radius', 'area' => 'Bridgeland', 'type' => 'Concrete mid-rise', 'focus' => 'Modern building, inner-city lifestyle'],
    ];

    public function __construct() {
        if (!is_admin()) {
            return;
        }

        add_action('admin_menu', [$this, 'register_admin_page']);
        add_action('admin_post_' . self::DRY_RUN_ACTION, [$this, 'handle_dry_run']);
        add_action('admin_post_' . self::IMPORT_ACTION, [$this, 'handle_import']);
        add_action('admin_post_' . self::DATA_MODE_ACTION, [$this, 'handle_data_mode_update']);
    }

    public function register_admin_page(): void {
        add_management_page(
            __('Calgary Building Seeder', 'calgary-condo-leads'),
            __('Calgary Building Seeder', 'calgary-condo-leads'),
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
            <h1><?php esc_html_e('Calgary Condo Building Seeder (Admin Only)', 'calgary-condo-leads'); ?></h1>
            <p><?php esc_html_e('Step 1 runs a dry-run and previews the results. Step 2 requires explicit confirmation before any writes.', 'calgary-condo-leads'); ?></p>
            <?php $this->render_data_mode_controls(); ?>

            <h2><?php esc_html_e('Step 1: Dry-run (no writes)', 'calgary-condo-leads'); ?></h2>
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <input type="hidden" name="action" value="<?php echo esc_attr(self::DRY_RUN_ACTION); ?>" />
                <?php wp_nonce_field(self::DRY_RUN_NONCE_ACTION, 'ccl_building_seeder_nonce'); ?>
                <?php submit_button(__('Run dry-run', 'calgary-condo-leads')); ?>
            </form>

            <?php if (is_array($dry_run_data) && !empty($dry_run_data['summary'])) : ?>
                <h2><?php esc_html_e('Dry-run summary', 'calgary-condo-leads'); ?></h2>
                <?php $this->render_summary($dry_run_data['summary']); ?>
                <?php $this->render_rows($dry_run_data['summary']); ?>

                <h2><?php esc_html_e('Step 2: Confirm import writes', 'calgary-condo-leads'); ?></h2>
                <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                    <input type="hidden" name="action" value="<?php echo esc_attr(self::IMPORT_ACTION); ?>" />
                    <input type="hidden" name="dry_run_token" value="<?php echo esc_attr((string) ($dry_run_data['token'] ?? '')); ?>" />
                    <?php wp_nonce_field(self::IMPORT_NONCE_ACTION, 'ccl_building_seeder_nonce'); ?>
                    <label>
                        <input type="checkbox" name="confirm_import" value="yes" required />
                        <?php esc_html_e('I confirm I want to create/update ccl_building posts using the dry-run preview above.', 'calgary-condo-leads'); ?>
                    </label>
                    <?php submit_button(__('Run confirmed import', 'calgary-condo-leads'), 'primary'); ?>
                </form>
            <?php endif; ?>

            <?php if (is_array($import_data) && !empty($import_data['summary'])) : ?>
                <h2><?php esc_html_e('Import results', 'calgary-condo-leads'); ?></h2>
                <?php $this->render_summary($import_data['summary']); ?>
                <?php $this->render_rows($import_data['summary']); ?>
            <?php endif; ?>

            <?php $this->render_admin_diagnostics(); ?>
            <?php $this->render_mismatch_report(); ?>
        </div>
        <?php
    }

    public function handle_dry_run(): void {
        $this->assert_admin_request(self::DRY_RUN_NONCE_ACTION, 'ccl_building_seeder_nonce');

        $summary = $this->run_import(false);
        $data = [
            'token' => wp_generate_uuid4(),
            'summary' => $summary,
            'created_at' => time(),
        ];

        set_transient($this->dry_run_transient_key(), $data, 30 * MINUTE_IN_SECONDS);
        delete_transient($this->import_transient_key());

        error_log('Calgary Condo Building Seeder dry-run: ' . wp_json_encode($summary['counts']));

        $this->redirect_to_admin_page();
    }

    public function handle_import(): void {
        $this->assert_admin_request(self::IMPORT_NONCE_ACTION, 'ccl_building_seeder_nonce');

        $confirm = isset($_POST['confirm_import']) ? sanitize_text_field(wp_unslash($_POST['confirm_import'])) : '';
        $token = isset($_POST['dry_run_token']) ? sanitize_text_field(wp_unslash($_POST['dry_run_token'])) : '';
        $dry_run_data = get_transient($this->dry_run_transient_key());

        if ('yes' !== $confirm || !is_array($dry_run_data) || $token === '' || !hash_equals((string) ($dry_run_data['token'] ?? ''), $token)) {
            wp_die(esc_html__('Import confirmation is invalid or expired. Please run dry-run again.', 'calgary-condo-leads'));
        }

        $summary = $this->run_import(true);
        set_transient(
            $this->import_transient_key(),
            [
                'summary' => $summary,
                'created_at' => time(),
            ],
            30 * MINUTE_IN_SECONDS
        );

        error_log('Calgary Condo Building Seeder import: ' . wp_json_encode($summary['counts']));

        $this->redirect_to_admin_page();
    }

    public function handle_data_mode_update(): void {
        $this->assert_admin_request(self::DATA_MODE_NONCE_ACTION, 'ccl_building_data_mode_nonce');

        if (!isset($_POST['ccl_building_data_mode'])) {
            $this->redirect_to_admin_page();
        }

        $mode = sanitize_key(wp_unslash($_POST['ccl_building_data_mode']));
        $allowed_modes = [
            Calgary_Condo_Building_Data_Mode::MODE_CPT_FIRST,
            Calgary_Condo_Building_Data_Mode::MODE_ARRAY_FIRST,
        ];
        if (!in_array($mode, $allowed_modes, true)) {
            $mode = Calgary_Condo_Building_Data_Mode::MODE_CPT_FIRST;
        }

        update_option(Calgary_Condo_Building_Data_Mode::OPTION_KEY, $mode, false);

        $this->redirect_to_admin_page();
    }

    private function run_import(bool $write): array {
        $counts = [
            'created' => 0,
            'updated' => 0,
            'skipped' => 0,
            'failed' => 0,
        ];
        $rows = [];

        foreach (self::SOURCE_BUILDINGS as $source) {
            $prepared = $this->prepare_source($source);

            if ('' === $prepared['name'] || '' === $prepared['community']) {
                $counts['failed']++;
                $rows[] = $this->row_result($prepared, 'failed', __('Missing required name/community source fields.', 'calgary-condo-leads'));
                continue;
            }

            $existing_ids = $this->find_existing_ids($prepared['import_key']);
            if (count($existing_ids) > 1) {
                $counts['failed']++;
                $rows[] = $this->row_result($prepared, 'failed', __('Duplicate import key exists in current data.', 'calgary-condo-leads'));
                continue;
            }

            $existing_id = !empty($existing_ids) ? (int) $existing_ids[0] : 0;
            $existing_post_type = '';
            if ($existing_id > 0) {
                $resolved_post_type = get_post_type($existing_id);
                if (is_string($resolved_post_type)) {
                    $existing_post_type = $resolved_post_type;
                }
            }
            $is_update = $existing_id > 0;
            $needs_post_type_migration = $is_update && Calgary_Condo_Building_CPT::POST_TYPE !== $existing_post_type;
            $has_changes = !$is_update || $this->has_changes($existing_id, $prepared, $existing_post_type);

            if (!$has_changes) {
                $counts['skipped']++;
                $rows[] = $this->row_result($prepared, 'skipped', __('Already up-to-date.', 'calgary-condo-leads'), $existing_id);
                continue;
            }

            if ($write) {
                $persisted_id = $this->persist_building($existing_id, $prepared);
                if ($persisted_id <= 0) {
                    $counts['failed']++;
                    $rows[] = $this->row_result($prepared, 'failed', __('Unable to persist building.', 'calgary-condo-leads'), $existing_id);
                    continue;
                }
            }

            if ($is_update) {
                $counts['updated']++;
                if ($needs_post_type_migration) {
                    $rows[] = $this->row_result(
                        $prepared,
                        'updated',
                        $write
                            ? sprintf(__('Updated and migrated post type from %1$s to %2$s.', 'calgary-condo-leads'), $existing_post_type, Calgary_Condo_Building_CPT::POST_TYPE)
                            : sprintf(__('Would update and migrate post type from %1$s to %2$s.', 'calgary-condo-leads'), $existing_post_type, Calgary_Condo_Building_CPT::POST_TYPE),
                        $existing_id
                    );
                } else {
                    $rows[] = $this->row_result($prepared, 'updated', $write ? __('Updated.', 'calgary-condo-leads') : __('Would update.', 'calgary-condo-leads'), $existing_id);
                }
            } else {
                $counts['created']++;
                $rows[] = $this->row_result($prepared, 'created', $write ? __('Created.', 'calgary-condo-leads') : __('Would create.', 'calgary-condo-leads'));
            }
        }

        return [
            'mode' => $write ? 'import' : 'dry-run',
            'counts' => $counts,
            'rows' => $rows,
            'generated_at' => current_time('mysql'),
        ];
    }

    private function prepare_source(array $source): array {
        $name = sanitize_text_field((string) ($source['name'] ?? ''));
        $area = sanitize_text_field((string) ($source['area'] ?? ''));
        $type = sanitize_text_field((string) ($source['type'] ?? ''));
        $focus = sanitize_text_field((string) ($source['focus'] ?? ''));
        $community = $this->extract_community($area);
        $mrp_shortcode = sanitize_text_field((string) ($source['mrp_shortcode'] ?? ''));

        return [
            'name' => $name,
            'area' => $area,
            'community' => $community,
            'type' => $type,
            'focus' => $focus,
            'mrp_shortcode' => $mrp_shortcode,
            'import_key' => $this->build_import_key($name, $community),
        ];
    }

    /**
     * @return array<int,int>
     */
    private function find_existing_ids(string $import_key): array {
        if ('' === $import_key) {
            return [];
        }

        $query = new WP_Query([
            'post_type' => $this->queryable_post_types(),
            'post_status' => 'any',
            'posts_per_page' => self::DUPLICATE_DETECTION_LIMIT,
            'fields' => 'ids',
            'meta_query' => [
                [
                    'key' => self::IMPORT_KEY_META,
                    'value' => $import_key,
                ],
            ],
            'no_found_rows' => true,
        ]);

        return array_map('intval', $query->posts);
    }

    /**
     * @return array<int,string>
     */
    private function queryable_post_types(): array {
        $post_types = array_merge([Calgary_Condo_Building_CPT::POST_TYPE], self::LEGACY_POST_TYPES);
        $seen = [];
        $normalized = [];
        foreach ($post_types as $post_type) {
            $candidate = sanitize_key((string) $post_type);
            if ('' === $candidate || isset($seen[$candidate])) {
                continue;
            }
            $seen[$candidate] = true;
            $normalized[] = $candidate;
        }

        return $normalized;
    }

    /**
     * Returns true when data differs or when the existing post type is legacy.
     */
    private function has_changes(int $post_id, array $source, string $post_type): bool {
        if ($post_type !== Calgary_Condo_Building_CPT::POST_TYPE) {
            return true;
        }

        if (get_the_title($post_id) !== $source['name']) {
            return true;
        }

        if ((string) get_post_field('post_content', $post_id) !== $source['focus']) {
            return true;
        }

        if ((string) get_post_field('post_excerpt', $post_id) !== $source['area']) {
            return true;
        }

        if ((string) get_post_meta($post_id, 'building_community', true) !== $source['community']) {
            return true;
        }

        if ((string) get_post_meta($post_id, 'building_construction_type', true) !== $source['type']) {
            return true;
        }

        if ((string) get_post_meta($post_id, self::IMPORT_KEY_META, true) !== $source['import_key']) {
            return true;
        }

        $community_terms = wp_get_post_terms($post_id, 'ccl_building_community', ['fields' => 'names']);
        if (is_wp_error($community_terms)) {
            return true;
        }

        if (count($community_terms) !== 1) {
            return true;
        }

        return 0 !== strcasecmp((string) $community_terms[0], $source['community']);
    }

    private function persist_building(int $existing_id, array $source): int {
        $postarr = [
            'post_type' => Calgary_Condo_Building_CPT::POST_TYPE,
            'post_status' => 'publish',
            'post_title' => $source['name'],
            'post_content' => $source['focus'],
            'post_excerpt' => $source['area'],
        ];

        if ($existing_id > 0) {
            $postarr['ID'] = $existing_id;
            $post_id = wp_update_post($postarr, true);
        } else {
            $post_id = wp_insert_post($postarr, true);
        }

        if (is_wp_error($post_id) || !$post_id) {
            return 0;
        }

        update_post_meta($post_id, self::IMPORT_KEY_META, $source['import_key']);
        update_post_meta($post_id, 'building_community', $source['community']);
        update_post_meta($post_id, 'building_construction_type', $source['type']);

        if ('' !== (string) ($source['mrp_shortcode'] ?? '')) {
            update_post_meta($post_id, 'building_mrp_shortcode', (string) $source['mrp_shortcode']);
        }

        $term_result = wp_set_post_terms($post_id, [$source['community']], 'ccl_building_community', false);
        if (is_wp_error($term_result)) {
            return 0;
        }

        return (int) $post_id;
    }

    private function build_import_key(string $name, string $community): string {
        $normalized_name = $this->normalize_for_key($name);
        $normalized_community = $this->normalize_for_key($community);

        return $normalized_name . '|' . $normalized_community;
    }

    private function normalize_for_key(string $value): string {
        $value = strtolower(trim($value));
        $value = remove_accents($value);
        $value = (string) preg_replace('/[^a-z0-9]+/', ' ', $value);
        $value = (string) preg_replace('/\s+/', ' ', $value);

        return trim($value);
    }

    private function extract_community(string $area): string {
        foreach (explode('/', $area) as $part) {
            $candidate = trim((string) $part);
            if ('' !== $candidate) {
                return $candidate;
            }
        }

        return trim($area);
    }

    private function row_result(array $source, string $action, string $message, int $post_id = 0): array {
        return [
            'name' => $source['name'],
            'community' => $source['community'],
            'key' => $source['import_key'],
            'action' => $action,
            'message' => $message,
            'post_id' => $post_id,
        ];
    }

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

    private function render_rows(array $summary): void {
        $rows = is_array($summary['rows'] ?? null) ? $summary['rows'] : [];
        if (empty($rows)) {
            return;
        }
        ?>
        <table class="widefat striped">
            <thead>
                <tr>
                    <th><?php esc_html_e('Building', 'calgary-condo-leads'); ?></th>
                    <th><?php esc_html_e('Community', 'calgary-condo-leads'); ?></th>
                    <th><?php esc_html_e('Import Key', 'calgary-condo-leads'); ?></th>
                    <th><?php esc_html_e('Action', 'calgary-condo-leads'); ?></th>
                    <th><?php esc_html_e('Details', 'calgary-condo-leads'); ?></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($rows as $row) : ?>
                <tr>
                    <td><?php echo esc_html((string) ($row['name'] ?? '')); ?></td>
                    <td><?php echo esc_html((string) ($row['community'] ?? '')); ?></td>
                    <td><code><?php echo esc_html((string) ($row['key'] ?? '')); ?></code></td>
                    <td><?php echo esc_html((string) ($row['action'] ?? '')); ?></td>
                    <td><?php echo esc_html((string) ($row['message'] ?? '')); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php
    }

    private function render_data_mode_controls(): void {
        $mode = Calgary_Condo_Building_Data_Mode::get_mode();
        ?>
        <h2><?php esc_html_e('Building data source mode', 'calgary-condo-leads'); ?></h2>
        <p><?php esc_html_e('Use this switch for controlled cutover or instant rollback between CPT-first and array-first fallback mode.', 'calgary-condo-leads'); ?></p>
        <?php $cpt_mode_id = 'ccl_building_data_mode_cpt_first'; ?>
        <?php $array_mode_id = 'ccl_building_data_mode_array_first'; ?>
        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <input type="hidden" name="action" value="<?php echo esc_attr(self::DATA_MODE_ACTION); ?>" />
            <?php wp_nonce_field(self::DATA_MODE_NONCE_ACTION, 'ccl_building_data_mode_nonce'); ?>
            <input id="<?php echo esc_attr($cpt_mode_id); ?>" type="radio" name="ccl_building_data_mode" value="<?php echo esc_attr(Calgary_Condo_Building_Data_Mode::MODE_CPT_FIRST); ?>" <?php checked($mode, Calgary_Condo_Building_Data_Mode::MODE_CPT_FIRST); ?> />
            <label for="<?php echo esc_attr($cpt_mode_id); ?>">
                <?php esc_html_e('CPT-first mode (Phase 1 default)', 'calgary-condo-leads'); ?>
            </label>
            <br />
            <input id="<?php echo esc_attr($array_mode_id); ?>" type="radio" name="ccl_building_data_mode" value="<?php echo esc_attr(Calgary_Condo_Building_Data_Mode::MODE_ARRAY_FIRST); ?>" <?php checked($mode, Calgary_Condo_Building_Data_Mode::MODE_ARRAY_FIRST); ?> />
            <label for="<?php echo esc_attr($array_mode_id); ?>">
                <?php esc_html_e('Array-first fallback mode (instant rollback)', 'calgary-condo-leads'); ?>
            </label>
            <?php submit_button(__('Save data source mode', 'calgary-condo-leads')); ?>
        </form>
        <?php
    }

    private function render_admin_diagnostics(): void {
        $counts = $this->build_post_type_status_counts(['building', Calgary_Condo_Building_CPT::POST_TYPE]);
        $queryable_post_types = $this->queryable_post_types();
        ?>
        <h2><?php esc_html_e('Admin diagnostics (temporary)', 'calgary-condo-leads'); ?></h2>
        <p><?php esc_html_e('Read-only diagnostics for troubleshooting Buildings admin visibility.', 'calgary-condo-leads'); ?></p>
        <ul>
            <li><?php echo esc_html(sprintf(__('CPT constant slug: %s', 'calgary-condo-leads'), Calgary_Condo_Building_CPT::POST_TYPE)); ?></li>
            <li><?php echo esc_html(sprintf(__('Canonical admin list URL: %s', 'calgary-condo-leads'), admin_url('edit.php?post_type=' . Calgary_Condo_Building_CPT::POST_TYPE))); ?></li>
            <li><?php echo esc_html(sprintf(__('Legacy admin list URL: %s', 'calgary-condo-leads'), admin_url('edit.php?post_type=building'))); ?></li>
            <li><?php echo esc_html(sprintf(__('Seeder query post_type values: %s', 'calgary-condo-leads'), implode(', ', $queryable_post_types))); ?></li>
            <li><?php esc_html_e('Seeder query post_status: any', 'calgary-condo-leads'); ?></li>
            <li><?php echo esc_html(sprintf(__('Seeder write post_type: %s', 'calgary-condo-leads'), Calgary_Condo_Building_CPT::POST_TYPE)); ?></li>
            <li><?php esc_html_e('Seeder write post_status: publish', 'calgary-condo-leads'); ?></li>
        </ul>
        <table class="widefat striped">
            <thead>
                <tr>
                    <th><?php esc_html_e('Post Type', 'calgary-condo-leads'); ?></th>
                    <th><?php esc_html_e('Post Status', 'calgary-condo-leads'); ?></th>
                    <th><?php esc_html_e('Count', 'calgary-condo-leads'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($counts as $row) : ?>
                    <tr>
                        <td><code><?php echo esc_html($row['post_type']); ?></code></td>
                        <td><code><?php echo esc_html($row['post_status']); ?></code></td>
                        <td><?php echo esc_html((string) $row['count']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
    }

    /**
     * @param array<int,string> $post_types
     * @return array<int,array{post_type:string,post_status:string,count:int}>
     */
    private function build_post_type_status_counts(array $post_types): array {
        global $wpdb;

        $normalized_types = [];
        foreach ($post_types as $post_type) {
            $candidate = sanitize_key((string) $post_type);
            if ('' === $candidate || in_array($candidate, $normalized_types, true)) {
                continue;
            }
            $normalized_types[] = $candidate;
        }

        if (empty($normalized_types)) {
            return [];
        }

        $placeholders = implode(', ', array_fill(0, count($normalized_types), '%s'));
        $sql = "SELECT post_type, post_status, COUNT(*) AS post_count
            FROM {$wpdb->posts}
            WHERE post_type IN ($placeholders)
            GROUP BY post_type, post_status
            ORDER BY post_type ASC, post_status ASC";
        $prepared = $wpdb->prepare($sql, ...$normalized_types);
        if (!is_string($prepared)) {
            return [];
        }

        $results = $wpdb->get_results($prepared, ARRAY_A);
        if (!is_array($results)) {
            $results = [];
        }

        $rows = [];
        $existing = [];
        foreach ($results as $result) {
            $post_type = sanitize_key((string) ($result['post_type'] ?? ''));
            $post_status = sanitize_key((string) ($result['post_status'] ?? ''));
            $count = (int) ($result['post_count'] ?? 0);
            $key = $post_type . '|' . $post_status;
            $existing[$key] = true;
            $rows[] = [
                'post_type' => $post_type,
                'post_status' => $post_status,
                'count' => $count,
            ];
        }

        foreach ($normalized_types as $post_type) {
            $key = $post_type . '|(none)';
            if (!isset($existing[$key])) {
                $rows[] = [
                    'post_type' => $post_type,
                    'post_status' => '(none)',
                    'count' => 0,
                ];
            }
        }

        return $rows;
    }

    private function render_mismatch_report(): void {
        $report = $this->build_mismatch_report();
        ?>
        <h2><?php esc_html_e('Array ↔ CPT mismatch report', 'calgary-condo-leads'); ?></h2>
        <p><?php esc_html_e('Admin-only read-only report. This does not create, update, or delete any building posts.', 'calgary-condo-leads'); ?></p>

        <?php if (!empty($report['cpt_limit_hit'])) : ?>
            <div class="notice notice-warning inline" role="status">
                <p><strong><?php echo esc_html(sprintf(__('Mismatch report is limited to the first %d ccl_building posts.', 'calgary-condo-leads'), self::MISMATCH_REPORT_POST_LIMIT)); ?></strong></p>
            </div>
        <?php endif; ?>

        <h3><?php esc_html_e('In hard-coded arrays but missing from ccl_building posts', 'calgary-condo-leads'); ?></h3>
        <?php $this->render_mismatch_rows($report['array_missing_in_cpt']); ?>

        <h3><?php esc_html_e('In ccl_building posts but not found in hard-coded arrays', 'calgary-condo-leads'); ?></h3>
        <?php $this->render_mismatch_rows($report['cpt_missing_in_array']); ?>
        <?php
    }

    /**
     * @return array{array_missing_in_cpt:array<int,array{name:string,community:string,key:string}>,cpt_missing_in_array:array<int,array{name:string,community:string,key:string}>,cpt_limit_hit:bool}
     */
    private function build_mismatch_report(): array {
        $array_rows = [];
        foreach (Calgary_Condo_Building_Directory::fallback_buildings() as $source) {
            $name = sanitize_text_field((string) ($source['name'] ?? ''));
            $community = $this->extract_community(sanitize_text_field((string) ($source['area'] ?? '')));
            $key = $this->build_import_key($name, $community);
            if ('' === $key) {
                continue;
            }
            $array_rows[$key] = [
                'name' => $name,
                'community' => $community,
                'key' => $key,
            ];
        }

        $cpt_rows = [];
        $posts = get_posts([
            'post_type' => Calgary_Condo_Building_CPT::POST_TYPE,
            'post_status' => 'publish',
            'posts_per_page' => self::MISMATCH_REPORT_POST_LIMIT + 1,
            'orderby' => 'title',
            'order' => 'ASC',
            'no_found_rows' => true,
            'update_post_meta_cache' => true,
        ]);
        $cpt_limit_hit = count($posts) > self::MISMATCH_REPORT_POST_LIMIT;
        if ($cpt_limit_hit) {
            $posts = array_slice($posts, 0, self::MISMATCH_REPORT_POST_LIMIT);
        }

        foreach ($posts as $post) {
            $name = sanitize_text_field((string) $post->post_title);
            $community = sanitize_text_field((string) get_post_meta($post->ID, 'building_community', true));
            $key = $this->build_import_key($name, $community);
            if ('' === $key) {
                continue;
            }
            $cpt_rows[$key] = [
                'name' => $name,
                'community' => $community,
                'key' => $key,
            ];
        }

        $array_missing_in_cpt = array_values(array_diff_key($array_rows, $cpt_rows));
        $cpt_missing_in_array = array_values(array_diff_key($cpt_rows, $array_rows));

        return [
            'array_missing_in_cpt' => $array_missing_in_cpt,
            'cpt_missing_in_array' => $cpt_missing_in_array,
            'cpt_limit_hit' => $cpt_limit_hit,
        ];
    }

    /**
     * @param array<int,array{name:string,community:string,key:string}> $rows
     */
    private function render_mismatch_rows(array $rows): void {
        if (empty($rows)) {
            echo '<p>' . esc_html__('None.', 'calgary-condo-leads') . '</p>';
            return;
        }
        ?>
        <table class="widefat striped">
            <thead>
                <tr>
                    <th><?php esc_html_e('Building', 'calgary-condo-leads'); ?></th>
                    <th><?php esc_html_e('Community', 'calgary-condo-leads'); ?></th>
                    <th><?php esc_html_e('Import Key', 'calgary-condo-leads'); ?></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($rows as $row) : ?>
                <tr>
                    <td><?php echo esc_html($row['name']); ?></td>
                    <td><?php echo esc_html($row['community']); ?></td>
                    <td><code><?php echo esc_html($row['key']); ?></code></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php
    }

    private function assert_admin_request(string $nonce_action, string $nonce_name): void {
        if (!current_user_can('manage_options')) {
            wp_die(esc_html__('You do not have permission to run this action.', 'calgary-condo-leads'));
        }

        check_admin_referer($nonce_action, $nonce_name);
    }

    private function admin_page_url(): string {
        return add_query_arg([
            'page' => self::PAGE_SLUG,
        ], admin_url('tools.php'));
    }

    private function redirect_to_admin_page(): void {
        wp_safe_redirect($this->admin_page_url());
        exit;
    }

    private function dry_run_transient_key(): string {
        return 'ccl_building_seeder_dry_run_' . get_current_user_id();
    }

    private function import_transient_key(): string {
        return 'ccl_building_seeder_import_' . get_current_user_id();
    }
}

new Calgary_Condo_Building_Seeder();
