<?php
/**
 * Server-side routing for homepage search intent.
 *
 * @package CalgaryCondoLeads
 */

if (!defined('ABSPATH')) {
    exit;
}

final class Calgary_Condo_Search_Router {
    public function __construct() {
        add_action('template_redirect', [$this, 'route_homepage_search'], 1);
    }

    public function route_homepage_search(): void {
        if (is_admin() || !is_page('calgary-condos')) {
            return;
        }

        $query = isset($_GET['ccl_q']) ? sanitize_text_field((string) wp_unslash($_GET['ccl_q'])) : '';
        $status = isset($_GET['ccl_status']) ? sanitize_key((string) wp_unslash($_GET['ccl_status'])) : '';

        if ('' === $query && '' === $status) {
            return;
        }

        $destination = $this->resolve_destination($query, $status);
        if ('' === $destination) {
            return;
        }

        wp_safe_redirect(home_url($destination), 302);
        exit;
    }

    private function resolve_destination(string $query, string $status): string {
        $clean_query = strtolower(trim(preg_replace('/\s+/', ' ', preg_replace('/[^a-z0-9$ ]+/', ' ', $query))));

        $routes = [
            '/southeast-calgary-condos/' => ['southeast', 'south east', 'se', 'se calgary', 'south east calgary', 'southeast calgary'],
            '/southwest-calgary-condos/' => ['southwest', 'south west', 'sw', 'sw calgary', 'south west calgary', 'southwest calgary'],
            '/northwest-calgary-condos/' => ['northwest', 'north west', 'nw', 'nw calgary', 'north west calgary', 'northwest calgary'],
            '/northeast-calgary-condos/' => ['northeast', 'north east', 'ne', 'ne calgary', 'north east calgary', 'northeast calgary'],
        ];

        foreach ($routes as $destination => $aliases) {
            foreach ($aliases as $alias) {
                if ($clean_query === $alias || str_contains($clean_query, $alias)) {
                    return $destination;
                }
            }
        }

        if (str_contains($clean_query, 'under 400k') || str_contains($clean_query, 'under $400k') || str_contains($clean_query, '400k')) {
            return '/under-400k/';
        }

        if (str_contains($clean_query, 'price reduced') || str_contains($clean_query, 'reduced') || 'price-reduced' === $status || 'price-drops' === $status) {
            return '/price-reduced/';
        }

        if (str_contains($clean_query, 'building alerts') || 'alerts' === $clean_query) {
            return '/building-alerts/';
        }

        return '/all-calgary-condos/';
    }

}

new Calgary_Condo_Search_Router();
