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
        $communities = ['Beltline', 'Downtown Core', 'Eau Claire', 'East Village', 'Mission', 'Victoria Park', 'Kensington', 'Bridgeland', 'Sunnyside', 'Lower Mount Royal', 'Marda Loop', 'Inglewood', 'Seton', 'Mahogany', 'Auburn Bay', 'Legacy', 'Sage Hill', 'University District'];
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
    public function render_building_profile(string $content): string {
        if (is_admin() || !is_singular(self::POST_TYPE) || !in_the_loop() || !is_main_query()) {
            return $content;
        }

        $overview = $content ? '<div class="ccl-building-profile-overview">' . wp_kses_post($content) . '</div>' : '';

        return '<div class="ccl-inner-page-shell ccl-building-profile"><div class="ccl-building-profile-grid"><main class="ccl-building-profile-main">'
            . $overview
            . $this->panel('Building Specs', $this->definition_list([
                'Building Name' => 'post_title',
                'Address' => 'building_address',
                'Community' => 'building_community',
                'Year Built' => 'building_year_built',
                'Developer' => 'building_developer',
                'Number of Units' => 'building_units',
                'Number of Stories' => 'building_stories',
                'Construction Type' => 'building_construction_type',
            ]))
            . $this->panel('Condo Fees & Ownership Notes', $this->definition_list([
                'Condo Fee Details' => 'building_condo_fee_details',
                'Fee Inclusions' => 'building_fee_inclusions',
                'Insurance Notes' => 'building_insurance_notes',
                'Reserve Fund Study Status' => 'building_reserve_fund_status',
                'Special Assessment Notes' => 'building_special_assessment_notes',
            ]))
            . $this->panel('Bylaws & Restrictions', $this->definition_list([
                'Pet Rules' => 'building_pet_rules',
                'Rental Rules' => 'building_rental_rules',
                'Short-Term Rental Restrictions' => 'building_short_term_rental_rules',
                'Age Limits' => 'building_age_limits',
                'Smoking Rules' => 'building_smoking_rules',
                'Renovation Rules' => 'building_renovation_rules',
                'Move-In / Move-Out Rules' => 'building_move_rules',
            ]))
            . $this->panel('Parking, Storage & Amenities', $this->definition_list([
                'Underground Parking' => 'building_underground_parking',
                'Visitor Parking' => 'building_visitor_parking',
                'Storage Lockers' => 'building_storage_lockers',
                'Bike Storage' => 'building_bike_storage',
                'Gym' => 'building_gym',
                'Concierge' => 'building_concierge',
                'Rooftop Deck' => 'building_rooftop_deck',
                'Guest Suite' => 'building_guest_suite',
                'Party Room' => 'building_party_room',
            ]))
            . '</main><aside class="ccl-building-profile-sidebar">'
            . $this->inventory()
            . $this->lead_sidebar()
            . '</aside></div></div>';
    }

    private function field(string $key): string {
        if ('post_title' === $key) {
            return get_the_title();
        }

        $value = get_post_meta(get_the_ID(), $key, true);
        return is_scalar($value) && '' !== trim((string) $value) ? (string) $value : self::FALLBACK;
    }

    private function definition_list(array $fields): string {
        $html = '<dl class="ccl-building-profile-list">';
        foreach ($fields as $label => $key) {
            $html .= '<div><dt>' . esc_html($label) . '</dt><dd>' . wp_kses_post($this->field($key)) . '</dd></div>';
        }
        return $html . '</dl>';
    }

    private function panel(string $title, string $body): string {
        return '<section class="ccl-building-profile-panel"><h2>' . esc_html($title) . '</h2>' . $body . '</section>';
    }

    private function inventory(): string {
        $shortcode = trim((string) get_post_meta(get_the_ID(), 'building_mrp_shortcode', true));
        $body = $shortcode ? do_shortcode($shortcode) : '<p>' . esc_html__('Live building-specific listings will appear here once the myRealPage saved search is connected for this address.', 'calgary-condo-leads') . '</p>';
        return '<section class="ccl-building-profile-panel ccl-building-inventory-slot"><h2>' . esc_html__('Current Listings In This Building', 'calgary-condo-leads') . '</h2>' . $body . '</section>';
    }

    private function lead_sidebar(): string {
        return '<div class="ccl-building-lead-card"><h2>' . esc_html__('Compare this building first', 'calgary-condo-leads') . '</h2><p>' . esc_html__('Send the building name, budget, parking needs, pet needs, and timing. We will help compare the building before you chase the unit.', 'calgary-condo-leads') . '</p><button type="button" class="ccl-building-lead-card__button" data-ccl-lead-open data-lead-source="Building Profile Searches" data-requested-category="Building Shortlist" data-intent="Building profile list request">' . esc_html__('Get a condo shortlist', 'calgary-condo-leads') . '</button><a href="' . esc_url('tel:+14038006996') . '" target="_self" class="phone-link-block ccl-building-lead-card__phone">' . esc_html__('Call Calgary Direct: +1 (403) 800-6996', 'calgary-condo-leads') . '</a></div>';
    }

}

new Calgary_Condo_Building_CPT();
