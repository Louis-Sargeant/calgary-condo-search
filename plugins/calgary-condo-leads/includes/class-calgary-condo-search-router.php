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

        if ('' === $query && in_array($status, ['success', 'error'], true)) {
            return;
        }

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
        $clean_query = $this->normalize_search_term($query, true);

        $building_destination = $this->resolve_building_directory_destination($clean_query);
        if ('' !== $building_destination) {
            return $building_destination;
        }

        if ($this->is_address_like($clean_query)) {
            return '/all-calgary-condos/';
        }

        $routes = [
            '/southeast-calgary-condos/' => ['southeast', 'south east', 'se', 'se calgary', 'south east calgary', 'southeast calgary'],
            '/southwest-calgary-condos/' => ['southwest', 'south west', 'sw', 'sw calgary', 'south west calgary', 'southwest calgary'],
            '/northwest-calgary-condos/' => ['northwest', 'north west', 'nw', 'nw calgary', 'north west calgary', 'northwest calgary'],
            '/northeast-calgary-condos/' => ['northeast', 'north east', 'ne', 'ne calgary', 'north east calgary', 'northeast calgary'],
        ];

        foreach ($routes as $destination => $aliases) {
            foreach ($aliases as $alias) {
                if ($this->term_matches($clean_query, $alias)) {
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

    private function resolve_building_directory_destination(string $clean_query): string {
        if (!class_exists('Calgary_Condo_Building_Directory')) {
            return '';
        }

        $routes = Calgary_Condo_Building_Directory::visual_directory_search_routes();
        uksort($routes, static fn (string $first, string $second): int => strlen($second) <=> strlen($first));

        foreach ($routes as $term => $destination) {
            if ($this->term_matches($clean_query, $term)) {
                return $destination;
            }
        }

        return '';
    }

    private function normalize_search_term(string $term, bool $keep_dollar = false): string {
        $pattern = $keep_dollar ? '/[^a-z0-9$ ]+/' : '/[^a-z0-9 ]+/';

        return strtolower(trim((string) preg_replace('/\s+/', ' ', (string) preg_replace($pattern, ' ', $term))));
    }

    private function term_matches(string $clean_query, string $term): bool {
        $clean_term = $this->normalize_search_term($term);

        if ('' === $clean_term) {
            return false;
        }

        return (bool) preg_match('/(^|\s)' . preg_quote($clean_term, '/') . '($|\s)/', $this->normalize_search_term($clean_query));
    }

    private function is_address_like(string $clean_query): bool {
        return (bool) preg_match('/(^|\s)\d+(?!k)[a-z]?(\s|$)/', $clean_query)
            || (bool) preg_match('/(^|\s)(?!\d+k(\s|$))[a-z]?\d[a-z0-9]*\d[a-z]?(\s|$)/', $clean_query);
    }

}

new Calgary_Condo_Search_Router();
