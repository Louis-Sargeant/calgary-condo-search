<?php
/**
 * Calgary condo building CPT and profile renderer.
 *
 * @package CalgaryCondoLeads
 */

if (!defined('ABSPATH')) {
    exit;
}

final class Calgary_Condo_Building_CPT {
    public const POST_TYPE = 'ccl_building';
    private const FALLBACK = 'Details coming soon — verify building information before making decisions.';
    private const META_BOX_ID = 'ccl-building-details';
    private const META_BOX_NONCE_ACTION = 'ccl_building_details_save';
    private const META_BOX_NONCE_NAME = 'ccl_building_details_nonce';
    private const META_FIELDS = [
        'building_address' => [
            'label' => 'Building Address',
            'type' => 'text',
        ],
        'building_community' => [
            'label' => 'Building Community',
            'type' => 'text',
        ],
        'building_year_built' => [
            'label' => 'Year Built',
            'type' => 'text',
        ],
        'building_developer' => [
            'label' => 'Building Developer',
            'type' => 'text',
        ],
        'building_units' => [
            'label' => 'Building Units',
            'type' => 'text',
        ],
        'building_stories' => [
            'label' => 'Building Stories',
            'type' => 'text',
        ],
        'building_construction_type' => [
            'label' => 'Construction Type',
            'type' => 'text',
        ],
        'building_condo_fee_details' => [
            'label' => 'Condo Fee Details',
            'type' => 'textarea',
        ],
        'building_fee_inclusions' => [
            'label' => 'Fee Inclusions',
            'type' => 'textarea',
        ],
        'building_pet_rules' => [
            'label' => 'Pet Rules',
            'type' => 'textarea',
        ],
        'building_rental_rules' => [
            'label' => 'Rental Rules',
            'type' => 'textarea',
        ],
        'building_underground_parking' => [
            'label' => 'Underground Parking',
            'type' => 'textarea',
        ],
        'building_visitor_parking' => [
            'label' => 'Visitor Parking',
            'type' => 'textarea',
        ],
        'building_storage_lockers' => [
            'label' => 'Storage Lockers',
            'type' => 'textarea',
        ],
        'building_gym' => [
            'label' => 'Gym',
            'type' => 'textarea',
        ],
        'building_concierge' => [
            'label' => 'Concierge',
            'type' => 'textarea',
        ],
        'building_rooftop_deck' => [
            'label' => 'Rooftop Deck',
            'type' => 'textarea',
        ],
        'building_guest_suite' => [
            'label' => 'Guest Suite',
            'type' => 'textarea',
        ],
        'building_mrp_shortcode' => [
            'label' => 'MRP Shortcode',
            'type' => 'textarea',
        ],
    ];

    public function __construct() {
        add_action('init', [$this, 'register_post_type']);
        add_action('init', [$this, 'register_taxonomies']);
        add_action('init', [$this, 'ensure_default_terms'], 20);
        add_action('add_meta_boxes', [$this, 'register_building_details_meta_box']);
        add_action('admin_menu', [$this, 'ensure_buildings_admin_submenu'], 100);
        add_action('admin_init', [$this, 'redirect_legacy_buildings_admin_screen']);
        add_action('save_post_' . self::POST_TYPE, [$this, 'save_building_details']);
        add_filter('the_content', [$this, 'render_building_profile']);
        add_filter('body_class', [$this, 'add_building_body_class']);
    }

    public function register_post_type(): void {
        if (post_type_exists(self::POST_TYPE)) {
            return;
        }

        register_post_type(self::POST_TYPE, [
            'labels' => [
                'name' => __('Calgary Condo Buildings', 'calgary-condo-leads'),
                'singular_name' => __('Condo Building', 'calgary-condo-leads'),
                'menu_name' => __('Buildings', 'calgary-condo-leads'),
                'add_new_item' => __('Add New Condo Building', 'calgary-condo-leads'),
                'edit_item' => __('Edit Condo Building', 'calgary-condo-leads'),
                'view_item' => __('View Condo Building', 'calgary-condo-leads'),
                'search_items' => __('Search Calgary Condo Buildings', 'calgary-condo-leads'),
            ],
            'public' => true,
            'show_ui' => true,
            'capability_type' => 'post',
            'map_meta_cap' => true,
            'has_archive' => true,
            'rewrite' => ['slug' => 'calgary-condo-buildings'],
            'menu_icon' => 'dashicons-building',
            'show_in_menu' => 'edit.php?post_type=ccl_lead',
            'show_in_rest' => true,
            'supports' => ['title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'revisions'],
        ]);
    }

    public function register_taxonomies(): void {
        if (!taxonomy_exists('ccl_building_community')) {
            register_taxonomy('ccl_building_community', [self::POST_TYPE], [
                'labels' => [
                    'name' => __('Building Communities', 'calgary-condo-leads'),
                    'singular_name' => __('Building Community', 'calgary-condo-leads'),
                ],
                'public' => true,
                'hierarchical' => true,
                'show_in_rest' => true,
                'rewrite' => ['slug' => 'calgary-condo-buildings/community'],
            ]);
        }

        if (!taxonomy_exists('ccl_building_profile')) {
            register_taxonomy('ccl_building_profile', [self::POST_TYPE], [
                'labels' => [
                    'name' => __('Building Profiles', 'calgary-condo-leads'),
                    'singular_name' => __('Building Profile', 'calgary-condo-leads'),
                ],
                'public' => true,
                'hierarchical' => true,
                'show_in_rest' => true,
                'rewrite' => ['slug' => 'calgary-condo-buildings/profile'],
            ]);
        }
    }

    public function ensure_buildings_admin_submenu(): void {
        $parent_slug = 'edit.php?post_type=ccl_lead';
        $legacy_slug = 'edit.php?post_type=building';
        $canonical_slug = 'edit.php?post_type=' . self::POST_TYPE;

        remove_submenu_page($parent_slug, $legacy_slug);

        global $submenu;
        if (!isset($submenu[$parent_slug]) || !is_array($submenu[$parent_slug])) {
            return;
        }

        foreach ($submenu[$parent_slug] as $item) {
            if (!is_array($item)) {
                continue;
            }

            if (($item[2] ?? '') === $canonical_slug) {
                return;
            }
        }

        add_submenu_page(
            $parent_slug,
            __('Buildings', 'calgary-condo-leads'),
            __('Buildings', 'calgary-condo-leads'),
            'edit_posts',
            $canonical_slug
        );
    }

    public function register_building_details_meta_box(): void {
        add_meta_box(
            self::META_BOX_ID,
            __('Building Details', 'calgary-condo-leads'),
            [$this, 'render_building_details_meta_box'],
            self::POST_TYPE,
            'normal',
            'default'
        );
    }

    public function render_building_details_meta_box(\WP_Post $post): void {
        wp_nonce_field(self::META_BOX_NONCE_ACTION, self::META_BOX_NONCE_NAME);
        ?>
        <table class="form-table" role="presentation">
            <tbody>
                <?php foreach (self::META_FIELDS as $meta_key => $field) : ?>
                    <?php $value = (string) get_post_meta($post->ID, $meta_key, true); ?>
                    <tr>
                        <th scope="row">
                            <label for="<?php echo esc_attr($meta_key); ?>"><?php echo esc_html__($field['label'], 'calgary-condo-leads'); ?></label>
                        </th>
                        <td>
                            <?php if ('textarea' === $field['type']) : ?>
                                <textarea
                                    class="large-text"
                                    rows="3"
                                    id="<?php echo esc_attr($meta_key); ?>"
                                    name="<?php echo esc_attr($meta_key); ?>"
                                ><?php echo esc_textarea($value); ?></textarea>
                            <?php else : ?>
                                <input
                                    class="regular-text"
                                    type="text"
                                    id="<?php echo esc_attr($meta_key); ?>"
                                    name="<?php echo esc_attr($meta_key); ?>"
                                    value="<?php echo esc_attr($value); ?>"
                                />
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
    }

    public function redirect_legacy_buildings_admin_screen(): void {
        if (!is_admin()) {
            return;
        }

        $post_type = '';
        if (isset($_GET['post_type'])) {
            $post_type = sanitize_key(wp_unslash($_GET['post_type']));
        }

        if ('building' !== $post_type) {
            return;
        }

        $target_url = admin_url('edit.php?post_type=' . self::POST_TYPE);
        wp_safe_redirect($target_url);
        exit;
    }

    public function save_building_details(int $post_id): void {
        if (!isset($_POST[self::META_BOX_NONCE_NAME])) {
            return;
        }

        $nonce = sanitize_text_field(wp_unslash($_POST[self::META_BOX_NONCE_NAME]));
        if (!wp_verify_nonce($nonce, self::META_BOX_NONCE_ACTION)) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (wp_is_post_revision($post_id) || wp_is_post_autosave($post_id)) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        foreach (self::META_FIELDS as $meta_key => $field) {
            if (!isset($_POST[$meta_key])) {
                continue;
            }

            $value = wp_unslash($_POST[$meta_key]);
            $sanitized = 'textarea' === $field['type']
                ? sanitize_textarea_field($value)
                : sanitize_text_field($value);

            if ('' === $sanitized) {
                delete_post_meta($post_id, $meta_key);
                continue;
            }

            update_post_meta($post_id, $meta_key, $sanitized);
        }

        $community = (string) get_post_meta($post_id, 'building_community', true);
        wp_set_post_terms($post_id, '' === $community ? [] : [$community], 'ccl_building_community', false);
    }



    public function ensure_default_terms(): void {
        $communities = ['Beltline', 'Downtown Core', 'Eau Claire', 'East Village', 'Mission', 'Victoria Park', 'Bridgeland', 'Sunnyside', 'Lower Mount Royal', 'Marda Loop', 'Inglewood', 'Seton', 'Mahogany', 'Auburn Bay', 'Legacy', 'Sage Hill', 'University District'];
        $profiles = [
            'luxury-high-rise-condos' => 'Luxury High-Rise',
            'concrete-buildings' => 'Concrete Buildings',
            'pet-friendly-buildings' => 'Pet-Friendly Buildings',
            'pet-friendly-condo-buildings' => 'Pet-Friendly Buildings',
            'underground-parking' => 'Underground Parking',
            'newer-condo-buildings' => 'Newer Condo Buildings',
            'low-rise-condo-buildings' => 'Low-Rise Condo Buildings',
            'price-reduced' => 'Price-Reduced',
            'under-400k' => 'Under $400K',
        ];

        foreach ($communities as $term) {
            if (!term_exists($term, 'ccl_building_community')) {
                wp_insert_term($term, 'ccl_building_community');
            }
        }

        foreach ($profiles as $slug => $term) {
            if (!term_exists($term, 'ccl_building_profile')) {
                wp_insert_term($term, 'ccl_building_profile', ['slug' => $slug]);
            }
        }
    }
    /** @param string[] $classes */
    public function add_building_body_class(array $classes): array {
        if (is_singular(self::POST_TYPE)) {
            $classes[] = 'ccl-building-profile-single';
        }

        return $classes;
    }

    public function render_building_profile(string $content): string {
        if (is_admin() || !is_singular(self::POST_TYPE) || !in_the_loop() || !is_main_query()) {
            return $content;
        }

        $post_id = get_the_ID();
        $building_name = get_the_title($post_id);
        $community = $this->first_meta_value($post_id, ['building_community', 'ccl_building_community']);
        $address = $this->first_meta_value($post_id, ['building_address', 'ccl_building_address']);
        $building_type = $this->first_meta_value($post_id, ['building_construction_type', 'ccl_building_type']);
        $year_built = $this->first_meta_value($post_id, ['building_year_built', 'ccl_building_year_built']);
        $inventory_shortcode = trim((string) get_post_meta($post_id, 'building_mrp_shortcode', true));
        $has_inventory = '' !== $inventory_shortcode;
        $amenities = $this->public_amenities($post_id);
        $pet_rental_note = $this->public_pet_rental_note($post_id);
        $story = $this->public_story($content, $building_name, $community);

        $snapshot = [
            __('Building Name', 'calgary-condo-leads') => $building_name,
            __('Community', 'calgary-condo-leads') => $community,
            __('Address', 'calgary-condo-leads') => $address,
            __('Building Type', 'calgary-condo-leads') => $building_type,
            __('Year Built', 'calgary-condo-leads') => $year_built,
        ];

        if (!empty($amenities)) {
            $snapshot[__('General Amenities', 'calgary-condo-leads')] = implode(', ', $amenities);
        }

        if ('' !== $pet_rental_note) {
            $snapshot[__('Public Pet / Rental Note', 'calgary-condo-leads')] = $pet_rental_note;
        }

        $positioning = '' !== $community
            ? sprintf(
                /* translators: 1: building name, 2: community */
                __('%1$s in %2$s with building-first guidance before you book a showing.', 'calgary-condo-leads'),
                $building_name,
                $community
            )
            : sprintf(
                /* translators: %s: building name */
                __('%s profile with building-first guidance before you book a showing.', 'calgary-condo-leads'),
                $building_name
            );

        ob_start();
        ?>
        <main class="ccl-inner-page-shell ccl-building-profile-page-shell">
            <article class="ccl-building-profile-page">
                <header class="ccl-building-profile-page__hero">
                    <p class="ccl-building-profile-page__eyebrow"><?php esc_html_e('Calgary Condo Building Profile', 'calgary-condo-leads'); ?></p>
                    <h1><?php echo esc_html($building_name); ?></h1>
                    <?php if ('' !== $community) : ?>
                        <p class="ccl-building-profile-page__location"><?php echo esc_html($community); ?></p>
                    <?php endif; ?>
                    <p class="ccl-building-profile-page__positioning"><?php echo esc_html($positioning); ?></p>
                    <div class="ccl-building-profile-page__hero-actions">
                        <button type="button" class="ccl-btn ccl-building-profile-page__primary-cta" data-ccl-lead-open data-lead-source="Building Profile" data-requested-category="Building Risk Report" data-clicked-cta="Get My Building Review"><?php esc_html_e('Get My Building Review', 'calgary-condo-leads'); ?></button>
                        <a href="#ccl-building-current-listings" class="ccl-building-profile-page__secondary-cta"><?php esc_html_e('View Current Listings', 'calgary-condo-leads'); ?></a>
                    </div>
                </header>

                <section class="ccl-building-profile-page__card" aria-labelledby="ccl-building-snapshot-title">
                    <h2 id="ccl-building-snapshot-title"><?php esc_html_e('Public Building Snapshot', 'calgary-condo-leads'); ?></h2>
                    <ul class="ccl-building-profile-page__snapshot-grid" role="list">
                        <?php foreach ($snapshot as $label => $value) : ?>
                            <?php if ('' === trim((string) $value)) { continue; } ?>
                            <li class="ccl-building-profile-page__snapshot-card">
                                <span class="ccl-building-profile-page__snapshot-label"><?php echo esc_html($label); ?></span>
                                <span class="ccl-building-profile-page__snapshot-value"><?php echo esc_html($value); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php if ('' === trim($address . $building_type . $year_built)) : ?>
                        <p class="ccl-building-profile-page__note"><?php esc_html_e('Some public building details are still being verified.', 'calgary-condo-leads'); ?></p>
                    <?php endif; ?>
                </section>

                <section class="ccl-building-profile-page__card" aria-labelledby="ccl-building-story-title">
                    <h2 id="ccl-building-story-title"><?php esc_html_e('Building Story', 'calgary-condo-leads'); ?></h2>
                    <p><?php echo esc_html($story); ?></p>
                </section>

                <section id="ccl-building-current-listings" class="ccl-building-profile-page__card" aria-labelledby="ccl-building-listings-title">
                    <h2 id="ccl-building-listings-title"><?php esc_html_e('Current Listings', 'calgary-condo-leads'); ?></h2>
                    <?php if ($has_inventory) : ?>
                        <div class="ccl-building-profile-page__idx"><?php echo do_shortcode($inventory_shortcode); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
                    <?php else : ?>
                        <p><?php esc_html_e('View current MLS listings available in this building. Verified listing data — including price, beds/baths, square footage, photos, and active status — is sourced directly from the MLS feed.', 'calgary-condo-leads'); ?></p>
                        <button type="button" class="ccl-btn ccl-building-profile-page__section-cta" data-ccl-lead-open data-lead-source="Building Profile" data-requested-category="Building Alerts" data-clicked-cta="Get Active Listings for This Building"><?php esc_html_e('Get Active Listings for This Building', 'calgary-condo-leads'); ?></button>
                    <?php endif; ?>
                </section>

                <section class="ccl-building-profile-page__card" aria-labelledby="ccl-building-guidance-title">
                    <h2 id="ccl-building-guidance-title"><?php esc_html_e('Buyer Verification Guidance', 'calgary-condo-leads'); ?></h2>
                    <p><?php esc_html_e('Before booking a showing or writing an offer, request a building-specific review covering condo documents, reserve fund health, insurance notes, special assessment risk, recent sales context, bylaws, parking/storage details, and buyer-fit concerns.', 'calgary-condo-leads'); ?></p>
                </section>

                <section class="ccl-building-profile-page__lead ccl-building-profile-page__card" aria-labelledby="ccl-building-lead-title">
                    <h2 id="ccl-building-lead-title"><?php esc_html_e('Need Building-Level Due Diligence Before You Move Forward?', 'calgary-condo-leads'); ?></h2>
                    <p><?php esc_html_e('Get a building-specific review before you commit to a showing or offer.', 'calgary-condo-leads'); ?></p>
                    <div class="ccl-building-profile-page__hero-actions">
                        <button type="button" class="ccl-btn ccl-building-profile-page__primary-cta" data-ccl-lead-open data-lead-source="Building Profile" data-requested-category="Building Risk Report" data-clicked-cta="Get My Building Review"><?php esc_html_e('Get My Building Review', 'calgary-condo-leads'); ?></button>
                        <a href="/building-alert-request/" class="ccl-building-profile-page__secondary-cta"><?php esc_html_e('Request Condo Help', 'calgary-condo-leads'); ?></a>
                    </div>
                </section>
            </article>
        </main>
        <?php
        return (string) ob_get_clean();
    }

    private function first_meta_value(int $post_id, array $keys): string {
        foreach ($keys as $key) {
            $value = get_post_meta($post_id, $key, true);
            if (!is_scalar($value)) {
                continue;
            }

            $clean = trim((string) $value);
            if ('' !== $clean) {
                return $clean;
            }
        }

        return '';
    }

    private function public_story(string $content, string $building_name, string $community): string {
        $clean_content = trim(preg_replace('/\s+/', ' ', wp_strip_all_tags($content)));

        if ('' !== $clean_content && !$this->contains_private_due_diligence_terms($clean_content) && !$this->looks_like_placeholder_copy($clean_content)) {
            return $clean_content;
        }

        if ('' !== $community) {
            return sprintf(
                /* translators: 1: building name, 2: community */
                __('%1$s sits within Calgary\'s %2$s condo market. Use this profile to understand location and lifestyle fit, then verify building-specific details before you tour units or write an offer.', 'calgary-condo-leads'),
                $building_name,
                $community
            );
        }

        return sprintf(
            /* translators: %s: building name */
            __('%s is a Calgary condo option where buyers should confirm location fit, current inventory access, and building-specific details before moving forward.', 'calgary-condo-leads'),
            $building_name
        );
    }

    /** @return string[] */
    private function public_amenities(int $post_id): array {
        $amenity_map = [
            'building_gym' => __('Fitness room', 'calgary-condo-leads'),
            'building_concierge' => __('Concierge', 'calgary-condo-leads'),
            'building_rooftop_deck' => __('Rooftop deck', 'calgary-condo-leads'),
            'building_guest_suite' => __('Guest suite', 'calgary-condo-leads'),
            'building_underground_parking' => __('Underground parking', 'calgary-condo-leads'),
            'building_visitor_parking' => __('Visitor parking', 'calgary-condo-leads'),
            'building_storage_lockers' => __('Storage lockers', 'calgary-condo-leads'),
        ];

        $amenities = [];

        foreach ($amenity_map as $meta_key => $label) {
            $value = trim((string) get_post_meta($post_id, $meta_key, true));
            if ('' === $value || preg_match('/^(no|none|n\/a)$/i', $value)) {
                continue;
            }

            $amenities[] = $label;
        }

        $legacy_amenities = trim((string) get_post_meta($post_id, 'ccl_building_amenities', true));
        if ('' !== $legacy_amenities && !$this->contains_private_due_diligence_terms($legacy_amenities)) {
            $amenities[] = $legacy_amenities;
        }

        return array_values(array_unique(array_filter($amenities)));
    }

    private function public_pet_rental_note(int $post_id): string {
        $pet = trim((string) get_post_meta($post_id, 'building_pet_rules', true));
        if ('' === $pet) {
            $pet = trim((string) get_post_meta($post_id, 'ccl_building_pet_bylaws', true));
        }

        $rental = trim((string) get_post_meta($post_id, 'building_rental_rules', true));
        if ('' === $rental) {
            $rental = trim((string) get_post_meta($post_id, 'ccl_building_rental_constraints', true));
        }

        $notes = [];
        if ($this->is_safe_public_policy_note($pet)) {
            $notes[] = sprintf(__('Pets: %s', 'calgary-condo-leads'), $this->truncate_note($pet));
        }

        if ($this->is_safe_public_policy_note($rental)) {
            $notes[] = sprintf(__('Rentals: %s', 'calgary-condo-leads'), $this->truncate_note($rental));
        }

        return implode(' ', $notes);
    }

    private function is_safe_public_policy_note(string $value): bool {
        if ('' === $value) {
            return false;
        }

        if (mb_strlen($value) > 180) {
            return false;
        }

        return !$this->contains_private_due_diligence_terms($value);
    }

    private function truncate_note(string $value): string {
        $clean = trim(preg_replace('/\s+/', ' ', wp_strip_all_tags($value)));
        if (mb_strlen($clean) <= 120) {
            return $clean;
        }

        return rtrim(mb_substr($clean, 0, 117)) . '...';
    }

    private function contains_private_due_diligence_terms(string $value): bool {
        $disallowed_terms = [
            'reserve fund',
            'special assessment',
            'insurance risk',
            'meeting-minute',
            'meeting minute',
            'financial statement',
            'bylaw interpretation',
            'offer-risk',
            'offer risk',
            'buyer strategy',
            'sales analysis',
            'document review',
            'red flag',
            'upcoming building costs',
        ];

        $normalized = strtolower($value);
        foreach ($disallowed_terms as $term) {
            if (false !== strpos($normalized, $term)) {
                return true;
            }
        }

        return false;
    }

    private function looks_like_placeholder_copy(string $value): bool {
        $placeholder_terms = [
            'details coming soon',
            'still being verified',
            'placeholder',
            'to be verified',
        ];

        $normalized = strtolower($value);
        foreach ($placeholder_terms as $term) {
            if (false !== strpos($normalized, $term)) {
                return true;
            }
        }

        return false;
    }

}

new Calgary_Condo_Building_CPT();
