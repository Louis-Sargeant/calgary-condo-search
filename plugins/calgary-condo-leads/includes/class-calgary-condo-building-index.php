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
        'kensington' => ['name' => 'Kensington', 'taxonomy' => 'ccl_building_community'],
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
        'pet-friendly-condo-buildings' => ['name' => 'Pet-Friendly', 'taxonomy' => 'ccl_building_profile'],
        'underground-parking' => ['name' => 'Underground Parking', 'taxonomy' => 'ccl_building_profile'],
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

        if (!isset(self::INDEX_TERMS[$slug])) {
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
        echo $this->render_index($slug); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        get_footer();
        exit;
    }

    private function render_index(string $slug): string {
        $term = self::INDEX_TERMS[$slug];
        $query = new WP_Query([
            'post_type' => 'ccl_building',
            'post_status' => 'publish',
            'posts_per_page' => 24,
            'orderby' => 'title',
            'order' => 'ASC',
            'tax_query' => [
                [
                    'taxonomy' => $term['taxonomy'],
                    'field' => 'slug',
                    'terms' => $slug,
                ],
            ],
        ]);

        ob_start();
        ?>
        <main class="ccl-inner-page-shell ccl-building-index">
            <header class="ccl-building-index__header">
                <p class="ccl-building-index__eyebrow"><?php esc_html_e('Calgary Building Database', 'calgary-condo-leads'); ?></p>
                <h1><?php echo esc_html(sprintf(__('Browse %s Condo Buildings', 'calgary-condo-leads'), $term['name'])); ?></h1>
                <p><?php esc_html_e('Compare Calgary condo buildings by profile before you book showings. Review building type, address, ownership fit, and available inventory where the myRealPage feed is connected.', 'calgary-condo-leads'); ?></p>
            </header>
            <?php if ($query->have_posts()) : ?>
                <div class="ccl-building-index-grid">
                    <?php while ($query->have_posts()) : $query->the_post(); ?>
                        <?php echo $this->render_card(get_the_ID()); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    <?php endwhile; ?>
                </div>
            <?php else : ?>
                <section class="ccl-building-profile-panel ccl-building-index__empty">
                    <p><?php esc_html_e('Building profiles for this category are being connected. For current listings and building guidance, request a condo shortlist.', 'calgary-condo-leads'); ?></p>
                </section>
            <?php endif; ?>
            <?php echo $this->lead_card(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            <?php echo $this->live_inventory_slot($term['name']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        </main>
        <?php
        wp_reset_postdata();
        return (string) ob_get_clean();
    }

    private function render_card(int $post_id): string {
        $active_count = trim((string) get_post_meta($post_id, 'building_active_listings_count', true));
        $active_label = '' !== $active_count ? $active_count : __('Connect IDX feed', 'calgary-condo-leads');
        $photo = get_the_post_thumbnail($post_id, 'medium_large', ['class' => 'ccl-building-index-card__image']);
        if (!$photo) {
            $photo = '<span>' . esc_html__('Photo coming soon', 'calgary-condo-leads') . '</span>';
        }

        ob_start();
        ?>
        <article class="ccl-building-index-card">
            <a href="<?php echo esc_url(get_permalink($post_id)); ?>" target="_self">
                <div class="ccl-building-index-card__photo"><?php echo wp_kses_post($photo); ?></div>
                <h3><?php echo esc_html(get_the_title($post_id)); ?></h3>
                <p><?php echo esc_html($this->meta($post_id, 'building_address')); ?></p>
                <ul>
                    <li><?php echo esc_html__('Community:', 'calgary-condo-leads') . ' ' . esc_html($this->meta($post_id, 'building_community')); ?></li>
                    <li><?php echo esc_html__('Year Built:', 'calgary-condo-leads') . ' ' . esc_html($this->meta($post_id, 'building_year_built')); ?></li>
                    <li><?php echo esc_html__('Units:', 'calgary-condo-leads') . ' ' . esc_html($this->meta($post_id, 'building_units')); ?></li>
                    <li><?php echo esc_html__('Stories:', 'calgary-condo-leads') . ' ' . esc_html($this->meta($post_id, 'building_stories')); ?></li>
                    <li><?php echo esc_html__('Active Listings:', 'calgary-condo-leads') . ' ' . esc_html($active_label); ?></li>
                </ul>
            </a>
        </article>
        <?php
        return (string) ob_get_clean();
    }

    private function meta(int $post_id, string $key): string {
        $value = get_post_meta($post_id, $key, true);
        return is_scalar($value) && '' !== trim((string) $value) ? (string) $value : __('Coming soon', 'calgary-condo-leads');
    }

    private function lead_card(): string {
        return '<div class="ccl-building-lead-card"><button type="button" class="ccl-building-lead-card__button" data-ccl-lead-open data-lead-source="Building Profile Searches" data-requested-category="Building Shortlist" data-intent="Building profile list request">' . esc_html__('Get a condo shortlist', 'calgary-condo-leads') . '</button><a href="' . esc_url('tel:+14038006996') . '" target="_self" class="phone-link-block ccl-building-lead-card__phone">' . esc_html__('Call Calgary Direct: +1 (403) 800-6996', 'calgary-condo-leads') . '</a></div>';
    }

    private function live_inventory_slot(string $community_name): string {
        $beltline_mrp_shortcode = '';
        $heading = sprintf(__('Live %s Condo Listings', 'calgary-condo-leads'), $community_name);
        $intro = sprintf(__('Browse current %s condo opportunities below. Use the building directory above to compare buildings, fees, bylaws, parking, storage, and resale fit before booking showings.', 'calgary-condo-leads'), $community_name);

        ob_start();
        ?>
        <section id="ccl-building-index-live-inventory" aria-labelledby="ccl-building-index-live-inventory-title">
            <h2 id="ccl-building-index-live-inventory-title"><?php echo esc_html($heading); ?></h2>
            <p><?php echo esc_html($intro); ?></p>
            <!-- Paste your myRealPage [mrp_listings ...] shortcode here -->
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
