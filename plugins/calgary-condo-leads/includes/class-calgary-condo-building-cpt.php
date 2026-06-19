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
    private const FALLBACK = 'Details coming soon — verify building information before making decisions.';

    public function __construct() {
        add_action('init', [$this, 'register_post_type']);
        add_action('init', [$this, 'register_taxonomies']);
        add_filter('the_content', [$this, 'render_building_profile']);
    }

    public function register_post_type(): void {
        if (post_type_exists('ccl_building')) {
            return;
        }

        register_post_type('ccl_building', [
            'labels' => [
                'name' => __('Calgary Condo Buildings', 'calgary-condo-leads'),
                'singular_name' => __('Condo Building', 'calgary-condo-leads'),
                'add_new_item' => __('Add New Condo Building', 'calgary-condo-leads'),
                'edit_item' => __('Edit Condo Building', 'calgary-condo-leads'),
                'view_item' => __('View Condo Building', 'calgary-condo-leads'),
                'search_items' => __('Search Calgary Condo Buildings', 'calgary-condo-leads'),
            ],
            'public' => true,
            'has_archive' => true,
            'rewrite' => ['slug' => 'calgary-condo-buildings'],
            'menu_icon' => 'dashicons-building',
            'show_in_rest' => true,
            'supports' => ['title', 'editor', 'excerpt', 'thumbnail', 'custom-fields'],
        ]);
    }

    public function register_taxonomies(): void {
        if (!taxonomy_exists('ccl_building_community')) {
            register_taxonomy('ccl_building_community', ['ccl_building'], [
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
            register_taxonomy('ccl_building_profile', ['ccl_building'], [
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

    public function render_building_profile(string $content): string {
        if (is_admin() || !is_singular('ccl_building') || !in_the_loop() || !is_main_query()) {
            return $content;
        }

        $overview = $content ? '<div class="ccl-building-profile-overview">' . wp_kses_post($content) . '</div>' : '';

        return '<div class="ccl-building-profile-layout"><main class="ccl-building-profile-main">'
            . $overview
            . $this->panel('Building Specs', $this->definition_list([
                'Year Built' => 'year_built',
                'Number of Units' => 'number_of_units',
                'Number of Stories' => 'number_of_stories',
                'Developer' => 'developer',
                'Construction Type' => 'construction_type',
                'Community' => 'community',
                'Address' => 'address',
            ]))
            . $this->panel('Amenities Checklist', $this->amenities())
            . $this->panel('Bylaw Restrictions Highlights', $this->definition_list([
                'Pet Rules' => 'pet_rules',
                'Short-Term Rental Restrictions' => 'short_term_rental_restrictions',
                'Age Limits' => 'age_limits',
                'Rental Rules' => 'rental_rules',
                'Smoking Rules' => 'smoking_rules',
                'Renovation Rules' => 'renovation_rules',
                'Move-In / Move-Out Rules' => 'move_in_move_out_rules',
            ]) . '<p class="ccl-building-profile-note">' . esc_html__('Always verify current bylaws, condo documents, and board rules before writing an offer.', 'calgary-condo-leads') . '</p>')
            . $this->panel('Financial Health & Condo Documents', $this->definition_list([
                'Reserve Fund Study Status' => 'reserve_fund_study_status',
                'Condo Fee Inclusions' => 'condo_fee_inclusions',
                'Insurance Notes' => 'insurance_notes',
                'Recent Special Assessment Signals' => 'recent_special_assessment_signals',
                'Upcoming Repair Signals' => 'upcoming_repair_signals',
                'Meeting Minutes Notes' => 'meeting_minutes_notes',
                'Document Review Notes' => 'document_review_notes',
            ]) . '<p class="ccl-building-profile-note">' . esc_html__('This section is for buyer due diligence. Confirm all documents with a licensed professional before purchase.', 'calgary-condo-leads') . '</p>')
            . $this->inventory()
            . '</main>' . $this->lead_sidebar() . '</div>';
    }

    private function field(string $key): string {
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

    private function amenities(): string {
        $items = ['Concierge','Underground Parking','Gym','Rooftop Deck','Visitor Parking','Storage Lockers','Bike Storage','Guest Suite','Party Room'];
        $html = '<ul class="ccl-building-amenities">';
        foreach ($items as $item) {
            $key = sanitize_key(str_replace(' ', '_', strtolower($item)));
            $confirmed = filter_var(get_post_meta(get_the_ID(), $key, true), FILTER_VALIDATE_BOOLEAN);
            $html .= '<li class="' . esc_attr($confirmed ? 'is-confirmed' : 'is-unconfirmed') . '"><span aria-hidden="true">' . esc_html($confirmed ? '✓' : '—') . '</span>' . esc_html($item) . '<small>' . esc_html($confirmed ? 'Stored as confirmed' : 'Not confirmed yet') . '</small></li>';
        }
        return $html . '</ul>';
    }

    private function panel(string $title, string $body): string {
        return '<section class="ccl-building-profile-panel"><h2>' . esc_html($title) . '</h2>' . $body . '</section>';
    }

    private function inventory(): string {
        $shortcode = trim((string) get_post_meta(get_the_ID(), 'building_mrp_shortcode', true));
        $body = $shortcode ? do_shortcode($shortcode) : '<p>' . esc_html__('Live building-specific listings will appear here once the myRealPage saved search is connected for this address.', 'calgary-condo-leads') . '</p>';
        return '<section class="ccl-building-profile-panel ccl-building-profile-inventory"><h2>' . esc_html__('Current Listings In This Building', 'calgary-condo-leads') . '</h2>' . $body . '</section>';
    }

    private function lead_sidebar(): string {
        return '<aside class="ccl-building-profile-sidebar"><div class="ccl-building-profile-cta"><h2>' . esc_html__('Compare this building first', 'calgary-condo-leads') . '</h2><p>' . esc_html__('Send the building name, budget, parking needs, pet needs, and timing. We will help compare the building before you chase the unit.', 'calgary-condo-leads') . '</p><a class="ccl-building-profile-button" href="' . esc_url('/building-alerts/') . '" target="_self">' . esc_html__('Get a condo shortlist', 'calgary-condo-leads') . '</a><a class="ccl-building-profile-phone" href="' . esc_url('tel:+14038006996') . '">' . esc_html__('Call Calgary Direct: +1 (403) 800-6996', 'calgary-condo-leads') . '</a></div></aside>';
    }
}

new Calgary_Condo_Building_CPT();
