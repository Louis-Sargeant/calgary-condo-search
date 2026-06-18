<?php
/**
 * Dedicated on-site Market Update page renderer.
 *
 * @package CalgaryCondoLeads
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Renders a stronger branded market update page at /market-update/.
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
     * Render the market update page before fallback/template logic runs.
     */
    public function render_market_update(): void {
        if (is_admin()) {
            return;
        }

        $path = trim((string) parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH), '/');
        if (!in_array($path, ['market-update', 'market-report'], true)) {
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

        if ('market update' === $title || false !== strpos($href, 'creb.com/housing_statistics')) {
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
                if (label === 'market update' || href.indexOf('creb.com/housing_statistics') !== -1) {
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
.ccl-market-page{font-family:inherit;color:#0A1A2F;background:#f6f7f8}.ccl-market-wrap{width:min(1180px,calc(100% - 40px));margin:0 auto}.ccl-market-hero{position:relative;overflow:hidden;background:#07162a;color:#fff;padding:86px 0 72px}.ccl-market-hero:before{content:"";position:absolute;inset:0;background:linear-gradient(90deg,rgba(7,22,42,.96),rgba(7,22,42,.76),rgba(7,22,42,.42)),url('https://images.unsplash.com/photo-1605146769289-440113cc3d00?auto=format&fit=crop&w=1800&q=80') center/cover;opacity:.96}.ccl-market-hero__inner{position:relative;display:grid;grid-template-columns:minmax(0,1.15fr) minmax(280px,.85fr);gap:42px;align-items:center}.ccl-market-eyebrow{display:inline-flex;align-items:center;gap:8px;margin:0 0 16px;color:#F0C75E;font-weight:900;letter-spacing:.12em;text-transform:uppercase;font-size:13px}.ccl-market-hero h1{margin:0 0 18px;font-size:clamp(40px,6vw,74px);line-height:.95;letter-spacing:-.05em;color:#fff}.ccl-market-hero p{font-size:18px;line-height:1.65;max-width:680px;color:rgba(255,255,255,.88);margin:0 0 28px}.ccl-market-actions{display:flex;flex-wrap:wrap;gap:14px}.ccl-market-btn{display:inline-flex;align-items:center;justify-content:center;min-height:48px;padding:0 22px;border-radius:14px;font-weight:900;text-decoration:none;box-shadow:0 18px 38px rgba(0,0,0,.18)}.ccl-market-btn--gold{background:#F0C75E;color:#0A1A2F}.ccl-market-btn--dark{background:#fff;color:#0A1A2F}.ccl-market-card{background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.18);border-radius:26px;padding:28px;backdrop-filter:blur(10px)}.ccl-market-card h2{margin:0 0 18px;color:#fff;font-size:28px;line-height:1.1}.ccl-market-card ul{margin:0;padding:0;list-style:none;display:grid;gap:14px}.ccl-market-card li{padding:14px 14px;border-radius:16px;background:rgba(255,255,255,.1);color:rgba(255,255,255,.9);font-weight:700}.ccl-market-section{padding:64px 0;background:#fff}.ccl-market-section--soft{background:#f6f7f8}.ccl-market-section h2{margin:0 0 16px;font-size:clamp(30px,4vw,48px);line-height:1;letter-spacing:-.04em;color:#0A1A2F}.ccl-market-section p{font-size:17px;line-height:1.7;color:#4b5563;max-width:820px}.ccl-market-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:20px;margin-top:28px}.ccl-market-info{padding:26px;border-radius:24px;background:#fff;border:1px solid rgba(10,26,47,.1);box-shadow:0 18px 45px rgba(10,26,47,.07)}.ccl-market-section--soft .ccl-market-info{background:#fff}.ccl-market-info strong{display:block;margin-bottom:10px;color:#0A1A2F;font-size:20px;line-height:1.2}.ccl-market-info p{margin:0;font-size:15px}.ccl-market-strip{background:#0A1A2F;color:#fff;padding:46px 0}.ccl-market-strip__inner{display:flex;align-items:center;justify-content:space-between;gap:24px}.ccl-market-strip h2{margin:0;color:#fff;font-size:34px;line-height:1.05}.ccl-market-strip p{margin:8px 0 0;color:rgba(255,255,255,.78);max-width:720px}.ccl-market-source{display:grid;grid-template-columns:minmax(0,1fr) minmax(260px,.45fr);gap:26px;align-items:center;padding:32px;border-radius:28px;background:#fff;border:1px solid rgba(10,26,47,.1);box-shadow:0 20px 54px rgba(10,26,47,.08)}.ccl-market-source h2{font-size:38px}.ccl-market-note{padding:18px 20px;border-left:5px solid #F0C75E;background:#fff9e6;border-radius:14px;color:#0A1A2F;font-weight:700}.ccl-market-mini{display:grid;gap:14px}.ccl-market-mini a{display:block;padding:16px 18px;border-radius:16px;background:#0A1A2F;color:#fff;text-decoration:none;font-weight:900}.ccl-market-mini a:first-child{background:#F0C75E;color:#0A1A2F}@media(max-width:860px){.ccl-market-hero__inner,.ccl-market-source{grid-template-columns:1fr}.ccl-market-grid{grid-template-columns:1fr}.ccl-market-strip__inner{display:block}.ccl-market-actions{display:grid}.ccl-market-btn{width:100%}}
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
                <p class="ccl-market-eyebrow">Calgary Market Update</p>
                <h1>Calgary condo market moves fast. Read it before you chase listings.</h1>
                <p>Use this page as the on-site market hub: plain-English guidance, condo buyer strategy, links back to your searches, and the official CREB source available without sending clients away first.</p>
                <div class="ccl-market-actions">
                    <a class="ccl-market-btn ccl-market-btn--gold" href="/calgary-condos/">Search Calgary Condos</a>
                    <a class="ccl-market-btn ccl-market-btn--dark" href="/price-reduced-condos/">View Price Drops</a>
                </div>
            </div>
            <aside class="ccl-market-card">
                <h2>What buyers should watch</h2>
                <ul>
                    <li>Inventory: more choice can shift negotiation power.</li>
                    <li>Days on market: stale listings may create opportunity.</li>
                    <li>Price drops: sellers showing motivation deserve a closer look.</li>
                    <li>Building quality: market data never replaces document review.</li>
                </ul>
            </aside>
        </div>
    </section>

    <section class="ccl-market-section">
        <div class="ccl-market-wrap">
            <p class="ccl-market-eyebrow">How to use the numbers</p>
            <h2>Market data is the starting point. The building is the decision.</h2>
            <p>Calgary condo buyers should use market reports to understand direction, then compare the building, documents, condo fees, reserve fund, rules, parking, storage, location, and resale path before writing an offer.</p>
            <div class="ccl-market-grid">
                <article class="ccl-market-info"><strong>For buyers</strong><p>Watch price drops, days on market, and inventory. Good opportunities still need document review and building comparison.</p></article>
                <article class="ccl-market-info"><strong>For sellers</strong><p>Pricing must be sharper when buyers have options. Presentation, positioning, and timing matter more in a competitive condo stack.</p></article>
                <article class="ccl-market-info"><strong>For investors</strong><p>Do not buy on rent alone. Check bylaws, fees, insurance, rental rules, building condition, and exit strategy.</p></article>
            </div>
        </div>
    </section>

    <section class="ccl-market-section ccl-market-section--soft">
        <div class="ccl-market-wrap ccl-market-source">
            <div>
                <p class="ccl-market-eyebrow">Official source</p>
                <h2>CREB Board housing statistics stay available as the source.</h2>
                <p>The full CREB report opens separately. Clients stay on your branded page first, then they can verify the board data when they want the official report.</p>
                <div class="ccl-market-note">We are not copying or pretending to own the board report. Your site interprets the market and links to the official source.</div>
            </div>
            <div class="ccl-market-mini">
                <a href="{$creb_url}" target="_blank" rel="noopener noreferrer">Open CREB Housing Statistics</a>
                <a href="/condo-buildings/">Compare Condo Buildings</a>
                <a href="/building-alerts/">Set Building Alerts</a>
            </div>
        </div>
    </section>

    <section class="ccl-market-strip">
        <div class="ccl-market-wrap ccl-market-strip__inner">
            <div>
                <h2>Want the market read for a specific building?</h2>
                <p>Send the condo building, area, price range, and timeline. We will help narrow what is worth chasing and what should be avoided.</p>
            </div>
            <a class="ccl-market-btn ccl-market-btn--gold" href="/building-alerts/">Get Condo Guidance</a>
        </div>
    </section>
</main>
HTML;
    }
}

new Calgary_Condo_Market_Update_Page();
