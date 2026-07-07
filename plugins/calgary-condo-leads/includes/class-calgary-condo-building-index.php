<?php
/**
 * Calgary condo building index renderer.
 *
 * @package CalgaryCondoLeads
 */

if (!defined('ABSPATH')) {
    exit;
}

final class Calgary_Condo_Building_Index {
    private const INDEX_TERMS = [
        'beltline' => ['name' => 'Beltline', 'taxonomy' => 'ccl_building_community'],
        'downtown-core' => ['name' => 'Downtown Core', 'taxonomy' => 'ccl_building_community'],
        'eau-claire' => ['name' => 'Eau Claire', 'taxonomy' => 'ccl_building_community'],
        'east-village' => ['name' => 'East Village', 'taxonomy' => 'ccl_building_community'],
        'mission' => ['name' => 'Mission', 'taxonomy' => 'ccl_building_community'],
        'victoria-park' => ['name' => 'Victoria Park', 'taxonomy' => 'ccl_building_community'],
        'bridgeland' => ['name' => 'Bridgeland', 'taxonomy' => 'ccl_building_community'],
        'sunnyside' => ['name' => 'Sunnyside', 'taxonomy' => 'ccl_building_community'],
        'lower-mount-royal' => ['name' => 'Lower Mount Royal', 'taxonomy' => 'ccl_building_community'],
        'marda-loop' => ['name' => 'Marda Loop', 'taxonomy' => 'ccl_building_community'],
        'inglewood' => ['name' => 'Inglewood', 'taxonomy' => 'ccl_building_community'],
        'seton' => ['name' => 'Seton', 'taxonomy' => 'ccl_building_community'],
        'mahogany' => ['name' => 'Mahogany', 'taxonomy' => 'ccl_building_community'],
        'auburn-bay' => ['name' => 'Auburn Bay', 'taxonomy' => 'ccl_building_community'],
        'legacy' => ['name' => 'Legacy', 'taxonomy' => 'ccl_building_community'],
        'sage-hill' => ['name' => 'Sage Hill', 'taxonomy' => 'ccl_building_community'],
        'university-district' => ['name' => 'University District', 'taxonomy' => 'ccl_building_community'],
        'luxury-high-rise-condos' => ['name' => 'Luxury High-Rise', 'taxonomy' => 'ccl_building_profile'],
        'concrete-buildings' => ['name' => 'Concrete Buildings', 'taxonomy' => 'ccl_building_profile'],
        'pet-friendly-buildings' => ['name' => 'Pet-Friendly Buildings', 'taxonomy' => 'ccl_building_profile'],
        'pet-friendly-condo-buildings' => ['name' => 'Pet-Friendly Buildings', 'taxonomy' => 'ccl_building_profile'],
        'underground-parking' => ['name' => 'Underground Parking', 'taxonomy' => 'ccl_building_profile'],
        'newer-condo-buildings' => ['name' => 'Newer Condo Buildings', 'taxonomy' => 'ccl_building_profile'],
        'low-rise-condo-buildings' => ['name' => 'Low-Rise Condo Buildings', 'taxonomy' => 'ccl_building_profile'],
    ];

    public function __construct() {
        add_action('template_redirect', [$this, 'maybe_render_index'], 1);
    }

    public function maybe_render_index(): void {
        if (is_admin()) {
            return;
        }

        $path = trim((string) parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH), '/');
        if (0 !== strpos($path, 'calgary-condo-buildings/')) {
            return;
        }

        $slug = trim(substr($path, strlen('calgary-condo-buildings/')), '/');
        if ('' === $slug || false !== strpos($slug, '/')) {
            return;
        }

        $term = $this->resolve_term($slug);
        if (null === $term) {
            return;
        }

        global $wp_query;
        if ($wp_query instanceof WP_Query) {
            $wp_query->is_404 = false;
            $wp_query->is_page = true;
            $wp_query->is_singular = true;
        }

        status_header(200);
        nocache_headers();
        get_header();
        echo $this->render_index($slug, $term); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        get_footer();
        exit;
    }

    /**
     * @param string $slug URL slug from the /calgary-condo-buildings/{slug}/ path.
     * @return array{name:string,taxonomy:string}|null
     */
    private function resolve_term(string $slug): ?array {
        if ('kensington' === $slug) {
            return null;
        }

        if (Calgary_Condo_Building_Data_Mode::is_array_first() && isset(self::INDEX_TERMS[$slug])) {
            return self::INDEX_TERMS[$slug];
        }

        foreach (['ccl_building_community', 'ccl_building_profile'] as $taxonomy) {
            $term = get_term_by('slug', $slug, $taxonomy);
            if ($term instanceof WP_Term && !is_wp_error($term)) {
                return ['name' => $term->name, 'taxonomy' => $taxonomy];
            }
        }

        return self::INDEX_TERMS[$slug] ?? null;
    }

    /**
     * @param array{name:string,taxonomy:string} $term
     */
    private function render_index(string $slug, array $term): string {
        $posts = get_posts([
            'post_type' => Calgary_Condo_Building_CPT::POST_TYPE,
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
            'no_found_rows' => true,
            'update_post_meta_cache' => true,
            'update_post_term_cache' => true,
            'tax_query' => [
                [
                    'taxonomy' => $term['taxonomy'],
                    'field' => 'slug',
                    'terms' => $slug,
                ],
            ],
        ]);

        update_object_term_cache($posts, Calgary_Condo_Building_CPT::POST_TYPE);
        $entries = array_map([Calgary_Condo_Building_Directory::class, 'build_directory_entry_from_post'], $posts);
        $context_note = 'ccl_building_community' === $term['taxonomy']
            ? sprintf(__('Currently filtered to %s.', 'calgary-condo-leads'), $term['name'])
            : sprintf(__('Currently filtered to the %s building profile.', 'calgary-condo-leads'), $term['name']);

        ob_start();
        ?>
        <main class="ccl-inner-page-shell ccl-building-page ccl-building-index-page">
            <?php
            echo Calgary_Condo_Building_Directory::render_premium_directory(
                $entries,
                [
                    'section_id' => 'ccl-building-index-' . sanitize_html_class($slug),
                    'context_note' => $context_note,
                    'empty_message' => __('Building profiles for this route are being connected. Request a shortlist and we will point you to the right building pages.', 'calgary-condo-leads'),
                ]
            ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            ?>
            <?php echo $this->lead_card(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            <?php echo $this->live_inventory_slot($slug, $term['name']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        </main>
        <?php

        return (string) ob_get_clean();
    }

    private function lead_card(): string {
        return '<div class="ccl-building-lead-card"><h2>' . esc_html__('Need help narrowing the shortlist?', 'calgary-condo-leads') . '</h2><p>' . esc_html__('Tell us the buildings or communities you are considering and we will help compare fit, rules, and current opportunities.', 'calgary-condo-leads') . '</p><button type="button" class="ccl-building-lead-card__button" data-ccl-lead-open data-lead-source="Building Profile Searches" data-requested-category="Building Shortlist" data-intent="Building profile list request">' . esc_html__('Get a condo shortlist', 'calgary-condo-leads') . '</button><a href="' . esc_url('tel:+14038006996') . '" target="_self" class="phone-link-block ccl-building-lead-card__phone">' . esc_html__('Call Calgary Direct: +1 (403) 800-6996', 'calgary-condo-leads') . '</a></div>';
    }

    private function live_inventory_slot(string $slug, string $community_name): string {
        $beltline_mrp_shortcode = 'beltline' === $slug ? "[mrp account_id=67196 listing_def=search-1439738 context=recip perm_attr=tmpl~v2]
[/mrp]" : '';
        $heading = sprintf(__('Live %s Condo Listings', 'calgary-condo-leads'), $community_name);
        $intro = sprintf(__('Browse current %s condo opportunities below. Use the building index above to compare buildings, fees, bylaws, parking, storage, and resale fit before booking showings.', 'calgary-condo-leads'), $community_name);

        ob_start();
        ?>
        <section id="ccl-building-index-live-inventory" aria-labelledby="ccl-building-index-live-inventory-title">
            <h2 id="ccl-building-index-live-inventory-title"><?php echo esc_html($heading); ?></h2>
            <p><?php echo esc_html($intro); ?></p>
            <?php
            if (!empty($beltline_mrp_shortcode)) {
                echo do_shortcode($beltline_mrp_shortcode); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            } else {
                echo '<div class="ccl-mrp-placeholder">' . esc_html(sprintf(__('Live %s listings will appear here once the myRealPage saved search shortcode is connected.', 'calgary-condo-leads'), $community_name)) . '</div>';
            }
            ?>
        </section>
        <?php

        return (string) ob_get_clean();
    }
}

new Calgary_Condo_Building_Index();
