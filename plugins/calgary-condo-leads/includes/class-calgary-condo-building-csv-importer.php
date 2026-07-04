<?php
/**
 * Admin-only CSV importer for building records.
 *
 * @package CalgaryCondoLeads
 */

if (!defined('ABSPATH')) {
    exit;
}

final class Calgary_Condo_Building_CSV_Importer {
    private const PAGE_SLUG = 'ccl-building-csv-importer';
    private const DRY_RUN_ACTION = 'ccl_building_csv_importer_dry_run';
    private const IMPORT_ACTION = 'ccl_building_csv_importer_import';
    private const BUNDLED_DRY_RUN_ACTION = 'ccl_building_bundled_csv_dry_run';
    private const DRY_RUN_NONCE_ACTION = 'ccl_building_csv_importer_dry_run_nonce';
    private const IMPORT_NONCE_ACTION = 'ccl_building_csv_importer_import_nonce';
    private const BUNDLED_DRY_RUN_NONCE_ACTION = 'ccl_building_bundled_csv_dry_run_nonce';
    private const CSV_FILE_FIELD = 'ccl_building_csv_file';
    private const BUNDLED_CSV_FILE = 'buildings-50.csv';

    private const REQUIRED_COLUMNS = [
        'building_name',
        'building_community',
    ];

    private const OPTIONAL_COLUMNS = [
        'building_address'                      => 'text',
        'building_year_built'                   => 'text',
        'building_developer'                    => 'text',
        'building_units'                        => 'text',
        'building_stories'                      => 'text',
        'building_construction_type'            => 'text',
        'building_condo_fee_details'            => 'textarea',
        'building_fee_inclusions'               => 'textarea',
        'building_pet_rules'                    => 'textarea',
        'building_rental_rules'                 => 'textarea',
        'building_underground_parking'          => 'textarea',
        'building_visitor_parking'              => 'textarea',
        'building_storage_lockers'              => 'textarea',
        'building_gym'                          => 'textarea',
        'building_concierge'                    => 'textarea',
        'building_rooftop_deck'                 => 'textarea',
        'building_guest_suite'                  => 'textarea',
        'building_mrp_shortcode'                => 'textarea',
        // Phase 2 fields.
        'building_area'                         => 'text',
        'building_amenities'                    => 'textarea',
        'building_pet_policy'                   => 'textarea',
        'building_parking_notes'                => 'textarea',
        'building_storage_notes'                => 'textarea',
        'building_condo_fee_notes'              => 'textarea',
        'building_bylaws_notes'                 => 'textarea',
        'building_reserve_fund_notes'           => 'textarea',
        'building_insurance_notes'              => 'textarea',
        'building_special_assessment_notes'     => 'textarea',
        'building_idx_search_id'                => 'text',
        'building_active_listing_count_fallback' => 'text',
    ];

    /**
     * Short/alias column names mapped to canonical building_* meta keys.
     * Applied after lowercasing; columns not in this map pass through unchanged.
     *
     * @var array<string,string>
     */
    private const COLUMN_ALIASES = [
        'address'                    => 'building_address',
        'building_type'              => 'building_construction_type',
        'year_built'                 => 'building_year_built',
        'floors'                     => 'building_stories',
        'area'                       => 'building_area',
        'amenities'                  => 'building_amenities',
        'pet_policy'                 => 'building_pet_policy',
        'parking_notes'              => 'building_parking_notes',
        'storage_notes'              => 'building_storage_notes',
        'condo_fee_notes'            => 'building_condo_fee_notes',
        'bylaws_notes'               => 'building_bylaws_notes',
        'reserve_fund_notes'         => 'building_reserve_fund_notes',
        'insurance_notes'            => 'building_insurance_notes',
        'special_assessment_notes'   => 'building_special_assessment_notes',
        'active_listing_count_fallback' => 'building_active_listing_count_fallback',
    ];

    private const DUPLICATE_DETECTION_LIMIT = 2;

    public function __construct() {
        if (!is_admin()) {
            return;
        }

        add_action('admin_menu', [$this, 'register_admin_page']);
        add_action('admin_post_' . self::DRY_RUN_ACTION, [$this, 'handle_dry_run']);
        add_action('admin_post_' . self::IMPORT_ACTION, [$this, 'handle_import']);
        add_action('admin_post_' . self::BUNDLED_DRY_RUN_ACTION, [$this, 'handle_bundled_dry_run']);
    }

    public function register_admin_page(): void {
        add_management_page(
            __('Calgary Building CSV Importer', 'calgary-condo-leads'),
            __('Calgary Building CSV Importer', 'calgary-condo-leads'),
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
        $bundled_path = CCL_PLUGIN_DIR . 'data/' . self::BUNDLED_CSV_FILE;
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('Calgary Building CSV Importer', 'calgary-condo-leads'); ?></h1>
            <p><?php esc_html_e('Step 1 uploads a CSV and runs a dry-run preview. Step 2 requires explicit confirmation before any writes.', 'calgary-condo-leads'); ?></p>

            <?php if (file_exists($bundled_path)) : ?>
                <h2><?php esc_html_e('Bundled CSV: buildings-50.csv', 'calgary-condo-leads'); ?></h2>
                <p><?php esc_html_e('Run a dry-run from the bundled 50-building CSV included with this plugin.', 'calgary-condo-leads'); ?></p>
                <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                    <input type="hidden" name="action" value="<?php echo esc_attr(self::BUNDLED_DRY_RUN_ACTION); ?>" />
                    <?php wp_nonce_field(self::BUNDLED_DRY_RUN_NONCE_ACTION, 'ccl_building_bundled_csv_nonce'); ?>
                    <?php submit_button(__('Dry-run bundled buildings-50.csv', 'calgary-condo-leads'), 'secondary'); ?>
                </form>
                <hr />
            <?php endif; ?>

            <h2><?php esc_html_e('Step 1: Dry-run (no writes)', 'calgary-condo-leads'); ?></h2>
            <form method="post" enctype="multipart/form-data" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <input type="hidden" name="action" value="<?php echo esc_attr(self::DRY_RUN_ACTION); ?>" />
                <?php wp_nonce_field(self::DRY_RUN_NONCE_ACTION, 'ccl_building_csv_importer_nonce'); ?>
                <input type="file" name="<?php echo esc_attr(self::CSV_FILE_FIELD); ?>" accept=".csv,text/csv" required />
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
                    <?php wp_nonce_field(self::IMPORT_NONCE_ACTION, 'ccl_building_csv_importer_nonce'); ?>
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
        </div>
        <?php
    }

    public function handle_dry_run(): void {
        $this->assert_admin_request(self::DRY_RUN_NONCE_ACTION, 'ccl_building_csv_importer_nonce');

        $rows = $this->parse_uploaded_csv();
        $summary = $this->run_import($rows, false);
        $data = [
            'token' => wp_generate_uuid4(),
            'rows' => $rows,
            'summary' => $summary,
            'created_at' => time(),
        ];

        set_transient($this->dry_run_transient_key(), $data, 30 * MINUTE_IN_SECONDS);
        delete_transient($this->import_transient_key());

        $this->redirect_to_admin_page();
    }

    public function handle_import(): void {
        $this->assert_admin_request(self::IMPORT_NONCE_ACTION, 'ccl_building_csv_importer_nonce');

        $confirm = isset($_POST['confirm_import']) ? sanitize_text_field(wp_unslash($_POST['confirm_import'])) : '';
        $token = isset($_POST['dry_run_token']) ? sanitize_text_field(wp_unslash($_POST['dry_run_token'])) : '';
        $dry_run_data = get_transient($this->dry_run_transient_key());

        if ('yes' !== $confirm || !is_array($dry_run_data) || $token === '' || !hash_equals((string) ($dry_run_data['token'] ?? ''), $token)) {
            wp_die(esc_html__('Import confirmation is invalid or expired. Please run dry-run again.', 'calgary-condo-leads'));
        }

        $rows = is_array($dry_run_data['rows'] ?? null) ? $dry_run_data['rows'] : [];
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

    public function handle_bundled_dry_run(): void {
        $this->assert_admin_request(self::BUNDLED_DRY_RUN_NONCE_ACTION, 'ccl_building_bundled_csv_nonce');

        $rows = $this->parse_bundled_csv();
        $summary = $this->run_import($rows, false);
        $data = [
            'token' => wp_generate_uuid4(),
            'rows' => $rows,
            'summary' => $summary,
            'created_at' => time(),
        ];

        set_transient($this->dry_run_transient_key(), $data, 30 * MINUTE_IN_SECONDS);
        delete_transient($this->import_transient_key());

        $this->redirect_to_admin_page();
    }

    /**
     * Parse the bundled plugin CSV file from the data directory.
     *
     * @return array<int,array<string,mixed>>
     */
    private function parse_bundled_csv(): array {
        $path = CCL_PLUGIN_DIR . 'data/' . self::BUNDLED_CSV_FILE;
        if (!file_exists($path)) {
            wp_die(esc_html__('Bundled CSV file not found.', 'calgary-condo-leads'));
        }

        $handle = fopen($path, 'rb');
        if (false === $handle) {
            wp_die(
                esc_html(
                    sprintf(
                        /* translators: %s: file path */
                        __('Unable to read bundled CSV file: %s', 'calgary-condo-leads'),
                        basename($path)
                    )
                )
            );
        }

        return $this->parse_csv_handle($handle);
    }

    /**
     * @return array<int,array<string,mixed>>
     */
    private function parse_uploaded_csv(): array {
        if (!isset($_FILES[self::CSV_FILE_FIELD]) || !is_array($_FILES[self::CSV_FILE_FIELD])) {
            wp_die(esc_html__('Please upload a CSV file.', 'calgary-condo-leads'));
        }

        $file = $_FILES[self::CSV_FILE_FIELD];
        $error = (int) ($file['error'] ?? UPLOAD_ERR_NO_FILE);
        if (UPLOAD_ERR_OK !== $error) {
            wp_die(esc_html__('CSV upload failed. Please try again.', 'calgary-condo-leads'));
        }

        $filename = sanitize_file_name((string) ($file['name'] ?? ''));
        $tmp_name = (string) ($file['tmp_name'] ?? '');
        if ('' === $filename || '' === $tmp_name || !is_uploaded_file($tmp_name)) {
            wp_die(esc_html__('Invalid CSV upload.', 'calgary-condo-leads'));
        }

        $extension = strtolower((string) pathinfo($filename, PATHINFO_EXTENSION));
        $checked_filetype = wp_check_filetype_and_ext($tmp_name, $filename);
        $detected_extension = strtolower((string) ($checked_filetype['ext'] ?? ''));
        if ('csv' !== $extension && 'csv' !== $detected_extension) {
            wp_die(esc_html__('Only CSV files are allowed.', 'calgary-condo-leads'));
        }

        $handle = fopen($tmp_name, 'rb');
        if (false === $handle) {
            wp_die(esc_html__('Unable to read uploaded CSV.', 'calgary-condo-leads'));
        }

        return $this->parse_csv_handle($handle);
    }

    /**
     * Parse rows from an open CSV file handle. Closes the handle when done.
     *
     * @param resource $handle Open file handle positioned at the start of the file.
     * @return array<int,array<string,mixed>>
     */
    private function parse_csv_handle($handle): array {
        $header_row = fgetcsv($handle);
        if (!is_array($header_row) || empty($header_row)) {
            fclose($handle);
            wp_die(esc_html__('CSV is missing a header row.', 'calgary-condo-leads'));
        }

        if (isset($header_row[0]) && is_string($header_row[0])) {
            $header_row[0] = preg_replace('/^\xEF\xBB\xBF/', '', $header_row[0]);
        }

        $header = [];
        foreach ($header_row as $column_name) {
            $header[] = $this->normalize_column_name((string) $column_name);
        }

        foreach (self::REQUIRED_COLUMNS as $required_column) {
            if (!in_array($required_column, $header, true)) {
                fclose($handle);
                wp_die(
                    esc_html(
                        sprintf(
                            /* translators: %s: required column name */
                            __('CSV is missing required column: %s', 'calgary-condo-leads'),
                            $required_column
                        )
                    )
                );
            }
        }

        $rows = [];
        $row_number = 1;
        while (($values = fgetcsv($handle)) !== false) {
            $row_number++;
            if (!is_array($values)) {
                continue;
            }

            $row = ['_row_number' => $row_number];
            $has_data = false;
            foreach ($header as $index => $column_name) {
                if ('' === $column_name) {
                    continue;
                }

                $value = isset($values[$index]) ? (string) $values[$index] : '';
                $row[$column_name] = $value;
                if ('' !== trim($value)) {
                    $has_data = true;
                }
            }

            if (!$has_data) {
                continue;
            }

            $rows[] = $row;
        }

        fclose($handle);

        return $rows;
    }

    /**
     * @param array<int,array<string,mixed>> $rows
     */
    private function run_import(array $rows, bool $write): array {
        $counts = [
            'created' => 0,
            'updated' => 0,
            'skipped' => 0,
            'failed' => 0,
        ];
        $results = [];
        $seen_keys = [];
        $existing_index = $this->build_existing_index();

        foreach ($rows as $row) {
            $prepared = $this->prepare_row($row);
            $row_number = (int) ($prepared['row_number'] ?? 0);
            $name = (string) ($prepared['name'] ?? '');
            $community = (string) ($prepared['community'] ?? '');
            $import_key = (string) ($prepared['import_key'] ?? '');

            if ('' === $name || '' === $community || '' === $import_key) {
                $counts['failed']++;
                $results[] = $this->row_result($row_number, $name, $community, $import_key, 'failed', __('Missing required building_name or building_community.', 'calgary-condo-leads'));
                continue;
            }

            if (isset($seen_keys[$import_key])) {
                $counts['skipped']++;
                $results[] = $this->row_result($row_number, $name, $community, $import_key, 'skipped', __('Duplicate key in uploaded CSV. Earlier row already processed.', 'calgary-condo-leads'));
                continue;
            }
            $seen_keys[$import_key] = true;

            $existing_ids = $existing_index[$import_key] ?? [];
            if (count($existing_ids) >= self::DUPLICATE_DETECTION_LIMIT) {
                $counts['failed']++;
                $results[] = $this->row_result($row_number, $name, $community, $import_key, 'failed', __('Duplicate existing buildings match this normalized key.', 'calgary-condo-leads'));
                continue;
            }

            $existing_id = !empty($existing_ids) ? (int) $existing_ids[0] : 0;
            $is_update = $existing_id > 0;
            $has_changes = !$is_update || $this->has_changes($existing_id, $prepared);
            if (!$has_changes) {
                $counts['skipped']++;
                $results[] = $this->row_result($row_number, $name, $community, $import_key, 'skipped', __('Already up-to-date.', 'calgary-condo-leads'), $existing_id);
                continue;
            }

            $persisted_id = $existing_id;
            if ($write) {
                $persisted_id = $this->persist_building($existing_id, $prepared);
                if ($persisted_id <= 0) {
                    $counts['failed']++;
                    $results[] = $this->row_result($row_number, $name, $community, $import_key, 'failed', __('Unable to persist building.', 'calgary-condo-leads'), $existing_id);
                    continue;
                }
            }

            if ($is_update) {
                $counts['updated']++;
                $results[] = $this->row_result($row_number, $name, $community, $import_key, 'updated', $write ? __('Updated.', 'calgary-condo-leads') : __('Would update.', 'calgary-condo-leads'), $persisted_id);
                continue;
            }

            $counts['created']++;
            $results[] = $this->row_result($row_number, $name, $community, $import_key, 'created', $write ? __('Created.', 'calgary-condo-leads') : __('Would create.', 'calgary-condo-leads'), $persisted_id);

            if ($write && $persisted_id > 0) {
                $existing_index[$import_key] = [$persisted_id];
            }
        }

        return [
            'mode' => $write ? 'import' : 'dry-run',
            'counts' => $counts,
            'rows' => $results,
            'generated_at' => current_time('mysql'),
        ];
    }

    /**
     * @return array<string,array<int,int>>
     */
    private function build_existing_index(): array {
        $query = new WP_Query([
            'post_type' => Calgary_Condo_Building_CPT::POST_TYPE,
            'post_status' => 'any',
            'posts_per_page' => -1,
            'fields' => 'ids',
            'no_found_rows' => true,
        ]);

        $index = [];
        foreach ($query->posts as $post_id) {
            $id = (int) $post_id;
            if ($id <= 0) {
                continue;
            }

            $name = get_the_title($id);
            $community = (string) get_post_meta($id, 'building_community', true);
            $import_key = $this->build_import_key((string) $name, $community);
            if ('' === $import_key) {
                continue;
            }

            if (!isset($index[$import_key])) {
                $index[$import_key] = [];
            }

            $index[$import_key][] = $id;
        }

        return $index;
    }

    /**
     * @param array<string,mixed> $row
     * @return array<string,mixed>
     */
    private function prepare_row(array $row): array {
        $name = sanitize_text_field((string) ($row['building_name'] ?? ''));
        $community = sanitize_text_field((string) ($row['building_community'] ?? ''));
        $slug = sanitize_title((string) ($row['slug'] ?? ''));
        $meta = [
            'building_community' => $community,
        ];
        $provided_columns = [
            'building_community' => true,
        ];

        foreach (self::OPTIONAL_COLUMNS as $column => $field_type) {
            $provided = array_key_exists($column, $row);
            $provided_columns[$column] = $provided;
            if (!$provided) {
                continue;
            }

            $value = wp_unslash((string) $row[$column]);
            $meta[$column] = 'textarea' === $field_type
                ? sanitize_textarea_field($value)
                : sanitize_text_field($value);
        }

        return [
            'row_number' => (int) ($row['_row_number'] ?? 0),
            'name' => $name,
            'community' => $community,
            'slug' => $slug,
            'meta' => $meta,
            'provided_columns' => $provided_columns,
            'import_key' => $this->build_import_key($name, $community),
        ];
    }

    /**
     * @param array<string,mixed> $prepared
     */
    private function has_changes(int $post_id, array $prepared): bool {
        if (get_the_title($post_id) !== (string) $prepared['name']) {
            return true;
        }

        $current_community = (string) get_post_meta($post_id, 'building_community', true);
        if ($current_community !== (string) $prepared['community']) {
            return true;
        }

        $provided_columns = is_array($prepared['provided_columns'] ?? null) ? $prepared['provided_columns'] : [];
        $meta = is_array($prepared['meta'] ?? null) ? $prepared['meta'] : [];

        foreach (self::OPTIONAL_COLUMNS as $column => $field_type) {
            if (!($provided_columns[$column] ?? false)) {
                continue;
            }

            if ('building_mrp_shortcode' === $column && '' === (string) ($meta[$column] ?? '')) {
                continue;
            }

            $incoming = (string) ($meta[$column] ?? '');
            $current = (string) get_post_meta($post_id, $column, true);
            if ($current !== $incoming) {
                return true;
            }
        }

        $community_terms = wp_get_post_terms($post_id, 'ccl_building_community', ['fields' => 'names']);
        if (is_wp_error($community_terms) || count($community_terms) !== 1) {
            return true;
        }

        return 0 !== strcasecmp((string) $community_terms[0], (string) $prepared['community']);
    }

    /**
     * @param array<string,mixed> $prepared
     */
    private function persist_building(int $existing_id, array $prepared): int {
        $name = (string) ($prepared['name'] ?? '');
        $community = (string) ($prepared['community'] ?? '');
        if ('' === $name || '' === $community) {
            return 0;
        }

        $postarr = [
            'post_type' => Calgary_Condo_Building_CPT::POST_TYPE,
            'post_status' => 'publish',
            'post_title' => $name,
        ];

        if ($existing_id > 0) {
            $postarr['ID'] = $existing_id;
            $existing_slug = get_post_field('post_name', $existing_id);
            if (is_wp_error($existing_slug)) {
                return 0;
            }
            if (is_string($existing_slug) && '' !== $existing_slug) {
                $postarr['post_name'] = $existing_slug;
            }
            $post_id = wp_update_post($postarr, true);
        } else {
            $provided_slug = (string) ($prepared['slug'] ?? '');
            if ('' !== $provided_slug) {
                $postarr['post_name'] = $provided_slug;
            }
            $post_id = wp_insert_post($postarr, true);
        }

        if (is_wp_error($post_id) || !$post_id) {
            return 0;
        }

        $post_id = (int) $post_id;
        update_post_meta($post_id, 'building_community', $community);

        $provided_columns = is_array($prepared['provided_columns'] ?? null) ? $prepared['provided_columns'] : [];
        $meta = is_array($prepared['meta'] ?? null) ? $prepared['meta'] : [];

        foreach (self::OPTIONAL_COLUMNS as $column => $field_type) {
            if (!($provided_columns[$column] ?? false)) {
                continue;
            }

            $value = (string) ($meta[$column] ?? '');
            if ('building_mrp_shortcode' === $column) {
                if ('' === $value) {
                    continue;
                }

                update_post_meta($post_id, $column, $value);
                continue;
            }

            if ('' === $value) {
                delete_post_meta($post_id, $column);
                continue;
            }

            update_post_meta($post_id, $column, $value);
        }

        $term_result = wp_set_post_terms($post_id, [$community], 'ccl_building_community', false);
        if (is_wp_error($term_result)) {
            return 0;
        }

        return $post_id;
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
                    <th><?php esc_html_e('Import Key', 'calgary-condo-leads'); ?></th>
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
                    <td><code><?php echo esc_html((string) ($row['key'] ?? '')); ?></code></td>
                    <td><?php echo esc_html((string) ($row['action'] ?? '')); ?></td>
                    <td><?php echo esc_html((string) ($row['message'] ?? '')); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php
    }

    /**
     * @return array<string,mixed>
     */
    private function row_result(int $row_number, string $name, string $community, string $import_key, string $action, string $message, int $post_id = 0): array {
        return [
            'row_number' => $row_number,
            'name' => $name,
            'community' => $community,
            'key' => $import_key,
            'action' => $action,
            'message' => $message,
            'post_id' => $post_id,
        ];
    }

    private function assert_admin_request(string $nonce_action, string $nonce_name): void {
        if (!current_user_can('manage_options')) {
            wp_die(esc_html__('You do not have permission to perform this action.', 'calgary-condo-leads'));
        }

        check_admin_referer($nonce_action, $nonce_name);
    }

    private function normalize_column_name(string $column_name): string {
        $normalized = strtolower(trim($column_name));
        return self::COLUMN_ALIASES[$normalized] ?? $normalized;
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

        return trim($value);
    }

    private function dry_run_transient_key(): string {
        return 'ccl_building_csv_importer_dry_run_' . get_current_user_id();
    }

    private function import_transient_key(): string {
        return 'ccl_building_csv_importer_import_' . get_current_user_id();
    }

    private function redirect_to_admin_page(): void {
        $url = admin_url('tools.php?page=' . self::PAGE_SLUG);
        wp_safe_redirect($url);
        exit;
    }
}

new Calgary_Condo_Building_CSV_Importer();
