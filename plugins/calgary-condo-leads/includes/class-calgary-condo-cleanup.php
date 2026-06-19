<?php
/**
 * Final visual cleanup layer for live Calgary condo portal pages.
 *
 * @package CalgaryCondoLeads
 */

if (!defined('ABSPATH')) {
    exit;
}

final class Calgary_Condo_Cleanup {
    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue'], 40);
        add_action('template_redirect', [$this, 'render_all_condos_route'], 0);
    }

    public function enqueue(): void {
        wp_enqueue_style(
            'calgary-condo-leads-cleanup',
            CCL_PLUGIN_URL . 'assets/css/calgary-condo-leads-cleanup.css',
            ['calgary-condo-leads-extended'],
            CCL_VERSION
        );
    }

    public function render_all_condos_route(): void {
        if (is_admin()) {
            return;
        }

        $path = trim((string) parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH), '/');

        if ('' === $path) {
            wp_safe_redirect(home_url('/calgary-condos/'), 301);
            exit;
        }

        if ('calgary-condos' !== $path) {
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
        echo '<main id="primary" class="site-main ccl-virtual-calgary-condos">';
        echo do_shortcode('[ccl_homepage_tight]');
        echo '</main>';
        get_footer();
        exit;
    }
}

new Calgary_Condo_Cleanup();
