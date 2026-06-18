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
    /**
     * Official CREB source.
     */
    private const CREB_MARKET_UPDATE_URL = 'https://www.creb.com/Housing_Statistics/';

    /**
     * Wire hooks.
     */
    public function __construct() {
        add_action('template_redirect', [$this, 'render_market_update'], 0);
        add_filter('nav_menu_link_attributes', [$this, 'rewrite_market_menu_attributes'], 10, 4);
        add_action('wp_footer', [$this, 'rewrite_market_links'], 1);
    }

    /**
     * Render the market stats page before fallback/template logic runs.
     */
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

    /**
     * Rewrite menu links before output.
     *
     * @param array<string,string> $atts Link attributes.
     * @param WP_Post             $menu_item Menu item.
     * @param stdClass            $args Menu args.
     * @param int                 $depth Menu depth.
     * @return array<string,string>
     */
    public function rewrite_market_menu_attributes(array $atts, $menu_item, $args, int $depth): array {
        $title = isset($menu_item->title) ? strtolower(trim((string) $menu_item->title)) : '';
        $href = isset($atts['href']) ? strtolower((string) $atts['href']) : '';

        if (in_array($title, ['market update', 'market stats', 'market statistics'], true) || false !== strpos($href, 'creb.com/housing_statistics')) {
            $atts['href'] = home_url('/market-update/');
            unset($atts['target'], $atts['rel']);
        }

        return $atts;
    }

    /**
     * Rewrite any hard-coded market links after page load.
     */
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
                if (label === 'market update' || label === 'market stats' || href.indexOf('creb.com/housing_statistics') !== -1) {
                    link.setAttribute('href', '/market-update/');
                    link.removeAttribute('target');
                    link.removeAttribute('rel');
                }
            });
        });
        </script>
        <?php
    }

    /**
     * Page-specific styles.
     */
    private function styles(): string {
        return <<<'CSS'
<style>
.ccl-market-page{font-family:inherit;color:#0A1A2F;background:#f6f7f8}.ccl-market-wrap{width:min(1180px,calc(100% - 40px));margin:0 auto}.ccl-market-hero{position:relative;overflow:hidden;background:#07162a;color:#fff;padding:76px 0 62px}.ccl-market-hero:before{content:"";position:absolute;inset:0;background:linear-gradient(90deg,rgba(7,22,42,.96),rgba(7,22,42,.78),rgba(7,22,42,.52)),url('https://images.unsplash.com/photo-1518005020951-eccb494ad742?auto=format&fit=crop&w=1800&q=80') center/cover;opacity:.94}.ccl-market-hero__inner{position:relative;display:grid;grid-template-columns:minmax(0,1fr) minmax(320px,.62fr);gap:38px;align-items:center}.ccl-market-eyebrow{display:inline-flex;align-items:center;gap:8px;margin:0 0 14px;color:#F0C75E;font-weight:900;letter-spacing:.12em;text-transform:uppercase;font-size:13px}.ccl-market-hero h1{margin:0 0 18px;font-size:clamp(40px,5.4vw,70px);line-height:.96;letter-spacing:-.05em;color:#fff}.ccl-market-hero p{font-size:18px;line-height:1.58;max-width:740px;color:rgba(255,255,255,.9);margin:0 0 28px}.ccl-market-actions{display:flex;flex-wrap:wrap;gap:14px}.ccl-market-btn{display:inline-flex;align-items:center;justify-content:center;min-height:48px;padding:0 22px;border-radius:14px;font-weight:900;text-decoration:none;box-shadow:0 18px 38px rgba(0,0,0,.18)}.ccl-market-btn--gold{background:#F0C75E;color:#0A1A2F}.ccl-market-btn--dark{background:#fff;color:#0A1A2F}.ccl-stat-panel{background:rgba(255,255,255,.11);border:1px solid rgba(255,255,255,.2);border-radius:28px;padding:26px;backdrop-filter:blur(10px)}.ccl-stat-panel h2{margin:0 0 14px;color:#fff;font-size:28px;line-height:1.1}.ccl-stat-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px}.ccl-stat-tile{border-radius:18px;background:rgba(255,255,255,.12);padding:16px}.ccl-stat-tile span{display:block;color:rgba(255,255,255,.72);font-size:12px;text-transform:uppercase;letter-spacing:.08em;font-weight:900}.ccl-stat-tile strong{display:block;color:#fff;font-size:30px;line-height:1.1;margin:7px 0}.ccl-stat-tile em{font-style:normal;color:#ffb4a8;font-weight:900}.ccl-market-section{padding:62px 0;background:#fff}.ccl-market-section--soft{background:#f6f7f8}.ccl-market-section h2{margin:0 0 16px;font-size:clamp(30px,4vw,48px);line-height:1;letter-spacing:-.04em;color:#0A1A2F}.ccl-market-section p{font-size:17px;line-height:1.7;color:#4b5563;max-width:850px}.ccl-data-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:16px;margin-top:28px}.ccl-data-card{background:#fff;border:1px solid rgba(10,26,47,.1);border-radius:22px;padding:22px;box-shadow:0 18px 45px rgba(10,26,47,.07)}.ccl-data-card span{display:block;color:#64748b;font-size:12px;text-transform:uppercase;letter-spacing:.08em;font-weight:900}.ccl-data-card strong{display:block;margin:8px 0 4px;font-size:28px;letter-spacing:-.03em;color:#0A1A2F}.ccl-data-card em{font-style:normal;font-weight:900;color:#b42318}.ccl-data-card .up{color:#147a3d}.ccl-price-grid{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:15px;margin-top:28px}.ccl-price-card{background:#0A1A2F;color:#fff;border-radius:22px;padding:20px;box-shadow:0 18px 45px rgba(10,26,47,.14)}.ccl-price-card span{display:block;color:#F0C75E;text-transform:uppercase;letter-spacing:.08em;font-size:12px;font-weight:900}.ccl-price-card strong{display:block;font-size:28px;margin:8px 0 4px}.ccl-price-card em{font-style:normal;color:#ffb4a8;font-weight:900}.ccl-area-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:14px;margin-top:26px}.ccl-area-card{border:1px solid rgba(10,26,47,.1);background:#fff;border-radius:20px;padding:18px}.ccl-area-card span{display:block;color:#64748b;text-transform:uppercase;letter-spacing:.08em;font-size:12px;font-weight:900}.ccl-area-card strong{display:block;font-size:24px;margin:8px 0}.ccl-area-card em{font-style:normal;font-weight:900;color:#b42318}.ccl-market-note{padding:18px 20px;border-left:5px solid #F0C75E;background:#fff9e6;border-radius:14px;color:#0A1A2F;font-weight:800;margin-top:22px}.ccl-market-source{display:grid;grid-template-columns:minmax(0,1fr) minmax(260px,.45fr);gap:26px;align-items:center;padding:32px;border-radius:28px;background:#fff;border:1px solid rgba(10,26,47,.1);box-shadow:0 20px 54px rgba(10,26,47,.08)}.ccl-market-mini{display:grid;gap:14px}.ccl-market-mini a{display:block;padding:16px 18px;border-radius:16px;background:#0A1A2F;color:#fff;text-decoration:none;font-weight:900}.ccl-market-mini a:first-child{background:#F0C75E;color:#0A1A2F}.ccl-market-strip{background:#0A1A2F;color:#fff;padding:46px 0}.ccl-market-strip__inner{display:flex;align-items:center;justify-content:space-between;gap:24px}.ccl-market-strip h2{margin:0;color:#fff;font-size:34px;line-height:1.05}.ccl-market-strip p{margin:8px 0 0;color:rgba(255,255,255,.78);max-width:720px}@media(max-width:980px){.ccl-data-grid,.ccl-price-grid,.ccl-area-grid{grid-template-columns:repeat(2,minmax(0,1fr))}.ccl-market-hero__inner,.ccl-market-source{grid-template-columns:1fr}}@media(max-width:620px){.ccl-data-grid,.ccl-price-grid,.ccl-area-grid,.ccl-stat-grid{grid-template-columns:1fr}.ccl-market-actions{display:grid}.ccl-market-btn{width:100%}.ccl-market-strip__inner{display:block}}
</style>
CSS;
    }

    /**
     * Render page HTML.
     */
    private function layout(): string {
        $creb_url = esc_url(self::CREB_MARKET_UPDATE_URL);

        return <<<HTML
<main class="ccl-market-page">
    <section class="ccl-market-hero">
        <div class="ccl-market-wrap ccl-market-hero__inner">
            <div>
                <p class="ccl-market-eyebrow">Calgary Market Stats • May 2026</p>
                <h1>Apartment prices ease as inventory remains elevated.</h1>
                <p>Here is the monthly Calgary market stats page buyers actually need: sales, listings, inventory, months of supply, benchmark prices, and area price movement — with CREB kept as the official source.</p>
                <div class="ccl-market-actions">
                    <a class="ccl-market-btn ccl-market-btn--gold" href="/calgary-condos/">Search Calgary Condos</a>
                    <a class="ccl-market-btn ccl-market-btn--dark" href="/price-reduced-condos/">View Price Drops</a>
                </div>
            </div>
            <aside class="ccl-stat-panel">
                <h2>City of Calgary snapshot</h2>
                <div class="ccl-stat-grid">
                    <div class="ccl-stat-tile"><span>Sales</span><strong>2,162</strong><em>↓ 15.5% Y/Y</em></div>
                    <div class="ccl-stat-tile"><span>New Listings</span><strong>4,226</strong><em>↓ 12.7% Y/Y</em></div>
                    <div class="ccl-stat-tile"><span>Inventory</span><strong>6,752</strong><em class="up">↑ 0.1% Y/Y</em></div>
                    <div class="ccl-stat-tile"><span>Months Supply</span><strong>3.12</strong><em class="up">↑ 18.5% Y/Y</em></div>
                </div>
            </aside>
        </div>
    </section>

    <section class="ccl-market-section">
        <div class="ccl-market-wrap">
            <p class="ccl-market-eyebrow">Monthly Housing Statistics</p>
            <h2>May 2026 Calgary market at a glance</h2>
            <p>Sales slowed while inventory stayed elevated. Total residential benchmark price was $570,500, down 3.0% year over year. Apartment benchmark price was $300,400, down 9.1% year over year.</p>
            <div class="ccl-data-grid">
                <article class="ccl-data-card"><span>Sales</span><strong>2,162</strong><em>↓ 15.5% Y/Y</em></article>
                <article class="ccl-data-card"><span>New Listings</span><strong>4,226</strong><em>↓ 12.7% Y/Y</em></article>
                <article class="ccl-data-card"><span>Inventory</span><strong>6,752</strong><em class="up">↑ 0.1% Y/Y</em></article>
                <article class="ccl-data-card"><span>Months of Supply</span><strong>3.12</strong><em class="up">↑ 18.5% Y/Y</em></article>
            </div>
        </div>
    </section>

    <section class="ccl-market-section ccl-market-section--soft">
        <div class="ccl-market-wrap">
            <p class="ccl-market-eyebrow">Benchmark Price Movement</p>
            <h2>Prices by property type</h2>
            <p>The apartment segment is where buyers need to be sharp. More supply creates more choice, but the building, fees, rules, documents, and resale path still matter more than the headline number.</p>
            <div class="ccl-price-grid">
                <article class="ccl-price-card"><span>Total Residential</span><strong>$570,500</strong><em>↓ 3.0% Y/Y</em></article>
                <article class="ccl-price-card"><span>Detached</span><strong>$747,800</strong><em>↓ 2.4% Y/Y</em></article>
                <article class="ccl-price-card"><span>Semi-Detached</span><strong>$691,100</strong><em>↓ 1.0% Y/Y</em></article>
                <article class="ccl-price-card"><span>Row</span><strong>$422,300</strong><em>↓ 6.4% Y/Y</em></article>
                <article class="ccl-price-card"><span>Apartment</span><strong>$300,400</strong><em>↓ 9.1% Y/Y</em></article>
            </div>
        </div>
    </section>

    <section class="ccl-market-section">
        <div class="ccl-market-wrap">
            <p class="ccl-market-eyebrow">Calgary Area Price Map</p>
            <h2>Benchmark price by district</h2>
            <p>Use the area numbers to understand direction, then compare the actual condo building before making a move.</p>
            <div class="ccl-area-grid">
                <article class="ccl-area-card"><span>North West</span><strong>$636,900</strong><em>↓ 1.7% Y/Y</em></article>
                <article class="ccl-area-card"><span>North</span><strong>$526,500</strong><em>↓ 5.4% Y/Y</em></article>
                <article class="ccl-area-card"><span>North East</span><strong>$467,800</strong><em>↓ 7.5% Y/Y</em></article>
                <article class="ccl-area-card"><span>West</span><strong>$726,600</strong><em>↓ 0.5% Y/Y</em></article>
                <article class="ccl-area-card"><span>City Centre</span><strong>$568,800</strong><em>↓ 3.4% Y/Y</em></article>
                <article class="ccl-area-card"><span>East</span><strong>$400,800</strong><em>↓ 6.8% Y/Y</em></article>
                <article class="ccl-area-card"><span>South</span><strong>$582,300</strong><em>↓ 1.3% Y/Y</em></article>
                <article class="ccl-area-card"><span>South East</span><strong>$556,200</strong><em>↓ 3.9% Y/Y</em></article>
            </div>
            <div class="ccl-market-note">Source basis: CREB City of Calgary Monthly Statistics, May 2026. The on-site stats page summarizes the board data and links to the official CREB source for verification.</div>
        </div>
    </section>

    <section class="ccl-market-section ccl-market-section--soft">
        <div class="ccl-market-wrap ccl-market-source">
            <div>
                <p class="ccl-market-eyebrow">Official Source</p>
                <h2>Full CREB report stays one click away.</h2>
                <p>Clients stay on your branded market stats page first. The official CREB report opens separately for anyone who wants to verify the board data.</p>
            </div>
            <div class="ccl-market-mini">
                <a href="{$creb_url}" target="_blank" rel="noopener noreferrer">Open CREB Housing Statistics</a>
                <a href="/price-reduced-condos/">View Price Drop Condos</a>
                <a href="/building-alerts/">Set Building Alerts</a>
            </div>
        </div>
    </section>

    <section class="ccl-market-strip">
        <div class="ccl-market-wrap ccl-market-strip__inner">
            <div>
                <h2>Want the market read for a specific condo building?</h2>
                <p>Send the building, area, budget, and timeline. We will help compare the stats, price drops, documents, fees, rules, and resale path.</p>
            </div>
            <a class="ccl-market-btn ccl-market-btn--gold" href="/building-alerts/">Get Condo Guidance</a>
        </div>
    </section>
</main>
HTML;
    }
}

new Calgary_Condo_Market_Update_Page();
