<?php
/**
 * Dedicated on-site Market Stats page renderer.
 *
 * @package CalgaryCondoLeads
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Renders a branded market statistics page at /market-update/.
 */
final class Calgary_Condo_Market_Update_Page {
    private const CREB_MARKET_UPDATE_URL = 'https://www.creb.com/Housing_Statistics/';

    public function __construct() {
        add_action('template_redirect', [$this, 'render_market_update'], 0);
        add_filter('nav_menu_link_attributes', [$this, 'rewrite_market_menu_attributes'], 10, 4);
        add_filter('nav_menu_item_title', [$this, 'rewrite_market_menu_title'], 10, 4);
        add_action('wp_footer', [$this, 'rewrite_market_links'], 1);
    }

    public function render_market_update(): void {
        if (is_admin()) {
            return;
        }

        $path = trim((string) parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH), '/');
        if (!in_array($path, ['market-update', 'market-report', 'market-stats'], true)) {
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
        echo $this->styles(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- controlled CSS output.
        echo $this->layout(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- controlled page HTML output.
        get_footer();
        exit;
    }

    public function rewrite_market_menu_attributes(array $atts, $menu_item, $args, int $depth): array {
        $title = isset($menu_item->title) ? strtolower(trim((string) $menu_item->title)) : '';
        $href = isset($atts['href']) ? strtolower((string) $atts['href']) : '';

        if (in_array($title, ['market update', 'market report', 'market stats', 'market statistics'], true) || false !== strpos($href, 'creb.com/housing_statistics') || false !== strpos($href, '/market-update')) {
            $atts['href'] = home_url('/market-update/');
            unset($atts['target'], $atts['rel']);
        }

        return $atts;
    }

    public function rewrite_market_menu_title($title, $item, $args, $depth): string {
        $plain_title = strtolower(trim(wp_strip_all_tags((string) $title)));
        $url = isset($item->url) ? strtolower((string) $item->url) : '';

        if (in_array($plain_title, ['market update', 'market report', 'market statistics'], true) || false !== strpos($url, '/market-update') || false !== strpos($url, 'creb.com/housing_statistics')) {
            return 'Market Stats';
        }

        return (string) $title;
    }

    public function rewrite_market_links(): void {
        if (is_admin()) {
            return;
        }
        ?>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('a').forEach(function (link) {
                var label = (link.textContent || '').trim().toLowerCase();
                var href = (link.getAttribute('href') || '').toLowerCase();
                if (label === 'market update' || label === 'market report' || label === 'market stats' || href.indexOf('/market-update') !== -1 || href.indexOf('creb.com/housing_statistics') !== -1) {
                    link.setAttribute('href', '/market-update/');
                    link.removeAttribute('target');
                    link.removeAttribute('rel');
                    if (label === 'market update' || label === 'market report') {
                        link.textContent = 'Market Stats';
                    }
                }
            });
        });
        </script>
        <?php
    }

    private function stats(): array {
        $fallback = [
            'month_label' => 'May 2026',
            'eyebrow' => 'Calgary Market Stats • May 2026',
            'headline' => 'Apartment prices ease as inventory remains elevated.',
            'intro' => 'Monthly Calgary market stats: sales, listings, inventory, months of supply, benchmark prices, and area price movement.',
            'source_label' => 'CREB City of Calgary Monthly Statistics, May 2026',
            'source_url' => self::CREB_MARKET_UPDATE_URL,
            'summary' => 'Sales slowed while inventory stayed elevated. Total residential benchmark price was $570,500, down 3.0% year over year. Apartment benchmark price was $300,400, down 9.1% year over year.',
            'snapshot' => [],
            'property_prices' => [],
            'district_prices' => [],
        ];

        $file = CCL_PLUGIN_DIR . 'data/market-stats.php';
        if (!is_readable($file)) {
            return $fallback;
        }

        $data = include $file;
        if (!is_array($data)) {
            return $fallback;
        }

        return array_replace_recursive($fallback, $data);
    }

    private function e($value): string {
        return esc_html((string) $value);
    }

    private function cards(array $items, string $class): string {
        $html = '';
        foreach ($items as $item) {
            $direction_class = ('up' === ($item['direction'] ?? '')) ? ' class="up"' : '';
            $html .= '<article class="' . esc_attr($class) . '"><span>' . $this->e($item['label'] ?? '') . '</span><strong>' . $this->e($item['value'] ?? '') . '</strong><em' . $direction_class . '>' . $this->e($item['change'] ?? '') . '</em></article>';
        }
        return $html;
    }

    private function hero_tiles(array $items): string {
        $html = '';
        foreach (array_slice($items, 0, 4) as $item) {
            $direction_class = ('up' === ($item['direction'] ?? '')) ? ' class="up"' : '';
            $html .= '<div class="ccl-stat-tile"><span>' . $this->e($item['label'] ?? '') . '</span><strong>' . $this->e($item['value'] ?? '') . '</strong><em' . $direction_class . '>' . $this->e($item['change'] ?? '') . '</em></div>';
        }
        return $html;
    }

    private function styles(): string {
        return <<<'CSS'
<style>
.ccl-market-page{font-family:inherit;color:#0A1A2F;background:#f6f7f8}.ccl-market-wrap{width:min(1180px,calc(100% - 40px));margin:0 auto}.ccl-market-hero{position:relative;overflow:hidden;background:#07162a;color:#fff;padding:76px 0 62px}.ccl-market-hero:before{content:"";position:absolute;inset:0;background:linear-gradient(90deg,rgba(7,22,42,.96),rgba(7,22,42,.78),rgba(7,22,42,.52)),url('https://images.unsplash.com/photo-1518005020951-eccb494ad742?auto=format&fit=crop&w=1800&q=80') center/cover;opacity:.94}.ccl-market-hero__inner{position:relative;display:grid;grid-template-columns:minmax(0,1fr) minmax(320px,.62fr);gap:38px;align-items:center}.ccl-market-eyebrow{display:inline-flex;align-items:center;gap:8px;margin:0 0 14px;color:#F0C75E;font-weight:900;letter-spacing:.12em;text-transform:uppercase;font-size:13px}.ccl-market-hero h1{margin:0 0 18px;font-size:clamp(40px,5.4vw,70px);line-height:.96;letter-spacing:-.05em;color:#fff}.ccl-market-hero p{font-size:18px;line-height:1.58;max-width:740px;color:rgba(255,255,255,.9);margin:0 0 28px}.ccl-market-actions{display:flex;flex-wrap:wrap;gap:14px}.ccl-market-btn{display:inline-flex;align-items:center;justify-content:center;min-height:48px;padding:0 22px;border-radius:14px;font-weight:900;text-decoration:none;box-shadow:0 18px 38px rgba(0,0,0,.18)}.ccl-market-btn--gold{background:#F0C75E;color:#0A1A2F}.ccl-market-btn--dark{background:#fff;color:#0A1A2F}.ccl-stat-panel{background:rgba(255,255,255,.11);border:1px solid rgba(255,255,255,.2);border-radius:28px;padding:26px;backdrop-filter:blur(10px)}.ccl-stat-panel h2{margin:0 0 14px;color:#fff;font-size:28px;line-height:1.1}.ccl-stat-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px}.ccl-stat-tile{border-radius:18px;background:rgba(255,255,255,.12);padding:16px}.ccl-stat-tile span{display:block;color:rgba(255,255,255,.72);font-size:12px;text-transform:uppercase;letter-spacing:.08em;font-weight:900}.ccl-stat-tile strong{display:block;color:#fff;font-size:30px;line-height:1.1;margin:7px 0}.ccl-stat-tile em{font-style:normal;color:#ffb4a8;font-weight:900}.ccl-stat-tile em.up{color:#a8f0c2}.ccl-market-section{padding:62px 0;background:#fff}.ccl-market-section--soft{background:#f6f7f8}.ccl-market-section h2{margin:0 0 16px;font-size:clamp(30px,4vw,48px);line-height:1;letter-spacing:-.04em;color:#0A1A2F}.ccl-market-section p{font-size:17px;line-height:1.7;color:#4b5563;max-width:850px}.ccl-data-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:16px;margin-top:28px}.ccl-data-card{background:#fff;border:1px solid rgba(10,26,47,.1);border-radius:22px;padding:22px;box-shadow:0 18px 45px rgba(10,26,47,.07)}.ccl-data-card span{display:block;color:#64748b;font-size:12px;text-transform:uppercase;letter-spacing:.08em;font-weight:900}.ccl-data-card strong{display:block;margin:8px 0 4px;font-size:28px;letter-spacing:-.03em;color:#0A1A2F}.ccl-data-card em{font-style:normal;font-weight:900;color:#b42318}.ccl-data-card em.up{color:#147a3d}.ccl-price-grid{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:15px;margin-top:28px}.ccl-price-card{background:#0A1A2F;color:#fff;border-radius:22px;padding:20px;box-shadow:0 18px 45px rgba(10,26,47,.14)}.ccl-price-card span{display:block;color:#F0C75E;text-transform:uppercase;letter-spacing:.08em;font-size:12px;font-weight:900}.ccl-price-card strong{display:block;font-size:28px;margin:8px 0 4px}.ccl-price-card em{font-style:normal;color:#ffb4a8;font-weight:900}.ccl-price-card em.up{color:#a8f0c2}.ccl-area-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:14px;margin-top:26px}.ccl-area-card{border:1px solid rgba(10,26,47,.1);background:#fff;border-radius:20px;padding:18px}.ccl-area-card span{display:block;color:#64748b;text-transform:uppercase;letter-spacing:.08em;font-size:12px;font-weight:900}.ccl-area-card strong{display:block;font-size:24px;margin:8px 0}.ccl-area-card em{font-style:normal;font-weight:900;color:#b42318}.ccl-area-card em.up{color:#147a3d}.ccl-market-note{padding:18px 20px;border-left:5px solid #F0C75E;background:#fff9e6;border-radius:14px;color:#0A1A2F;font-weight:800;margin-top:22px}@media(max-width:980px){.ccl-data-grid,.ccl-price-grid,.ccl-area-grid{grid-template-columns:repeat(2,minmax(0,1fr))}.ccl-market-hero__inner{grid-template-columns:1fr}}@media(max-width:620px){.ccl-data-grid,.ccl-price-grid,.ccl-area-grid,.ccl-stat-grid{grid-template-columns:1fr}.ccl-market-actions{display:grid}.ccl-market-btn{width:100%}}
</style>
CSS;
    }

    private function layout(): string {
        $stats = $this->stats();
        $month = $this->e($stats['month_label'] ?? 'Current Month');
        $source_label = $this->e($stats['source_label'] ?? 'CREB monthly housing statistics');

        $snapshot = is_array($stats['snapshot'] ?? null) ? $stats['snapshot'] : [];
        $property_prices = is_array($stats['property_prices'] ?? null) ? $stats['property_prices'] : [];
        $district_prices = is_array($stats['district_prices'] ?? null) ? $stats['district_prices'] : [];

        $hero_tiles = $this->hero_tiles($snapshot);
        $snapshot_cards = $this->cards($snapshot, 'ccl-data-card');
        $price_cards = $this->cards($property_prices, 'ccl-price-card');
        $area_cards = $this->cards($district_prices, 'ccl-area-card');

        $eyebrow = $this->e($stats['eyebrow'] ?? 'Calgary Market Stats');
        $headline = $this->e($stats['headline'] ?? 'Calgary market stats');
        $intro = $this->e($stats['intro'] ?? 'Monthly Calgary market statistics.');
        $summary = $this->e($stats['summary'] ?? 'Monthly Calgary market summary.');

        return <<<HTML
<main class="ccl-inner-page-shell ccl-market-page">
    <section class="ccl-market-hero">
        <div class="ccl-market-wrap ccl-market-hero__inner">
            <div>
                <p class="ccl-market-eyebrow">{$eyebrow}</p>
                <h1>{$headline}</h1>
                <p>{$intro}</p>
                <div class="ccl-market-actions">
                    <a class="ccl-market-btn ccl-market-btn--gold" href="/all-calgary-condos/" target="_self">Search Calgary Condos</a>
                    <a class="ccl-market-btn ccl-market-btn--dark" href="/price-reduced-condos/" target="_self">View Price Drops</a>
                </div>
            </div>
            <aside class="ccl-stat-panel">
                <h2>City of Calgary snapshot</h2>
                <div class="ccl-stat-grid">{$hero_tiles}</div>
            </aside>
        </div>
    </section>

    <section class="ccl-market-section">
        <div class="ccl-market-wrap">
            <p class="ccl-market-eyebrow">Monthly Housing Statistics</p>
            <h2>{$month} Calgary market at a glance</h2>
            <p>{$summary}</p>
            <div class="ccl-data-grid">{$snapshot_cards}</div>
        </div>
    </section>

    <section class="ccl-market-section ccl-market-section--soft">
        <div class="ccl-market-wrap">
            <p class="ccl-market-eyebrow">Benchmark Price Movement</p>
            <h2>Prices by property type</h2>
            <p>The apartment segment is where buyers need to be sharp. More supply creates more choice, but the building, fees, rules, documents, and resale path still matter more than the headline number.</p>
            <div class="ccl-price-grid">{$price_cards}</div>
        </div>
    </section>

    <section class="ccl-market-section">
        <div class="ccl-market-wrap">
            <p class="ccl-market-eyebrow">Calgary Area Price Map</p>
            <h2>Benchmark price by district</h2>
            <p>Use the area numbers to understand direction, then compare the actual condo building before making a move.</p>
            <div class="ccl-area-grid">{$area_cards}</div>
            <div class="ccl-market-note">Source basis: {$source_label}. The on-site stats page summarizes the board data and links to the official CREB source for verification.</div>
        </div>
    </section>

</main>
HTML;
    }
}

new Calgary_Condo_Market_Update_Page();
