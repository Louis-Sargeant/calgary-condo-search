<?php
/**
 * Force the /calgary-condos/ route to use the current strict portal layout.
 *
 * @package CalgaryCondoLeads
 */

if (!defined('ABSPATH')) {
    exit;
}

final class Calgary_Condo_All_Condos_Route {
    public function __construct() {
        add_action('template_redirect', [$this, 'render'], 0);
    }

    public function render(): void {
        if (is_admin()) {
            return;
        }

        $path = trim((string) parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH), '/');
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
        echo do_shortcode('[ccl_homepage_tight]'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo '</main>';
        get_footer();
        exit;
    }
}

new Calgary_Condo_All_Condos_Route();
