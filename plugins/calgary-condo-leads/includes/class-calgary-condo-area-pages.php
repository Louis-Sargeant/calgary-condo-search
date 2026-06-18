<?php
/**
 * Dedicated area condo pages for homepage tabs.
 *
 * @package CalgaryCondoLeads
 */

if (!defined('ABSPATH')) {
    exit;
}

final class Calgary_Condo_Area_Pages {
    private const ALL_CONDOS_IDX = '[mrp account_id=67196 listing_def=search-1439299 context=recip perm_attr=tmpl~v2 ][/mrp]';

    private const AREAS = [
        'southwest-calgary-condos' => [
            'label' => 'Southwest Calgary',
            'title' => 'Southwest Calgary Condos',
            'subtitle' => 'Search Southwest Calgary condos, then compare the building, fees, rules, parking, storage, and resale path before booking showings.',
        ],
        'northwest-calgary-condos' => [
            'label' => 'Northwest Calgary',
            'title' => 'Northwest Calgary Condos',
            'subtitle' => 'Search Northwest Calgary condos with building-first guidance before you chase listings.',
        ],
        'northeast-calgary-condos' => [
            'label' => 'Northeast Calgary',
            'title' => 'Northeast Calgary Condos',
            'subtitle' => 'Search Northeast Calgary condos and narrow the right building, budget, and ownership fit.',
        ],
        'downtown-calgary-condos' => [
            'label' => 'Downtown Calgary',
            'title' => 'Downtown Calgary Condos',
            'subtitle' => 'Search Downtown Calgary condos and compare lifestyle, fees, parking, storage, and resale strength.',
        ],
        'beltline-condos' => [
            'label' => 'Beltline',
            'title' => 'Beltline Condos',
            'subtitle' => 'Search Beltline condos and compare the buildings that fit your budget, lifestyle, and timeline.',
        ],
    ];

    public function __construct() {
        add_action('template_redirect', [$this, 'render_area_page'], 0);
    }

    public function render_area_page(): void {
        if (is_admin()) {
            return;
        }

        $slug = trim((string) parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH), '/');
        if (!isset(self::AREAS[$slug])) {
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
        echo $this->layout(self::AREAS[$slug], $slug); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        get_footer();
        exit;
    }

    private function layout(array $area, string $slug): string {
        $label = esc_html((string) $area['label']);
        $title = esc_html((string) $area['title']);
        $subtitle = esc_html((string) $area['subtitle']);
        $idx = self::ALL_CONDOS_IDX;

        return <<<HTML
<main class="ccl-area-page ccl-area-page--{$slug}">
    <section class="ccl-section ccl-section--white ccl-compare-hero ccl-area-hero">
        <div class="ccl-wrap ccl-compare-hero__inner">
            <div>
                <p class="ccl-eyebrow">Calgary Condo Search</p>
                <h1>{$title}</h1>
                <p>{$subtitle}</p>
            </div>
            <div class="ccl-compare-hero__actions">
                <a class="ccl-btn ccl-btn--primary" href="#idx-search">View {$label} Condos</a>
                <a class="ccl-btn ccl-btn--dark" href="/building-alerts/">Get Building Alerts</a>
            </div>
        </div>
    </section>

    [ccl_idx_shell eyebrow="Live {$label} Condo Search" title="Current {$label} condo listings" subtitle="Use the IDX feed below, then ask for building-first guidance before booking showings."]{$idx}[/ccl_idx_shell]
</main>
HTML;
    }
}

new Calgary_Condo_Area_Pages();
