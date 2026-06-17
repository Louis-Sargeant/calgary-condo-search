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
            'southeast' => ['southeast', 'south east', 'se', 'se calgary', 'south east calgary', 'southeast calgary'],
            'southwest' => ['southwest', 'south west', 'sw', 'sw calgary', 'south west calgary', 'southwest calgary'],
            'northwest' => ['northwest', 'north west', 'nw', 'nw calgary', 'north west calgary', 'northwest calgary'],
            'northeast' => ['northeast', 'north east', 'ne', 'ne calgary', 'north east calgary', 'northeast calgary'],
        ];

        foreach ($routes as $area => $aliases) {
            foreach ($aliases as $alias) {
                if ($clean_query === $alias || str_contains($clean_query, $alias)) {
                    return '/calgary-condos/?ccl_area=' . $area . '#mrp-listings';
                }
            }
        }

        if (str_contains($clean_query, 'downtown')) {
            return '/downtown-calgary-condos/';
        }

        if (str_contains($clean_query, 'beltline')) {
            return '/beltline-condos/';
        }

        if (str_contains($clean_query, 'luxury')) {
            return '/calgary-luxury-condos/';
        }

        if (str_contains($clean_query, '300')) {
            return '/calgary-condos-under-300k/';
        }

        if (str_contains($clean_query, 'open house') || str_contains($clean_query, 'open houses')) {
            return '/calgary-condos/?ccl_filter=open-houses#mrp-listings';
        }

        if (str_contains($clean_query, 'price drop') || str_contains($clean_query, 'reduced')) {
            return '/calgary-condos/?ccl_filter=price-drops#mrp-listings';
        }

        if ('newest' === $status) {
            return '/calgary-condos/?ccl_filter=newest#mrp-listings';
        }

        if ('price-reduced' === $status || 'price-drops' === $status) {
            return '/calgary-condos/?ccl_filter=price-drops#mrp-listings';
        }

        if ('open-house' === $status || 'open-houses' === $status) {
            return '/calgary-condos/?ccl_filter=open-houses#mrp-listings';
        }

        return '';
    }
}

new Calgary_Condo_Search_Router();
