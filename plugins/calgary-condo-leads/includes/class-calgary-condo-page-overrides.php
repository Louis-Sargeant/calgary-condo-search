<?php
/**
 * Page-level fallback overrides for the Calgary condo lead-generation site.
 *
 * @package CalgaryCondoLeads
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Forces key pages to use clean, non-repetitive lead-generation layouts.
 */
final class Calgary_Condo_Page_Overrides {
    /**
     * Official CREB housing statistics page.
     */
    private const CREB_MARKET_UPDATE_URL = 'https://www.creb.com/Housing_Statistics/';

    /**
     * Wire filters.
     */
    public function __construct() {
        add_filter('the_content', [$this, 'replace_page_content'], 999);
        add_filter('nav_menu_link_attributes', [$this, 'rewrite_market_menu_attributes'], 20, 4);
        add_action('template_redirect', [$this, 'render_virtual_market_update_page'], 1);
        add_action('wp_footer', [$this, 'rewrite_market_links'], 99);
        add_action('wp_footer', [$this, 'add_price_drop_badges'], 100);
    }

    /**
     * Replace page bodies with approved clean fallback layouts.
     *
     * @param string $content Original page content.
     * @return string
     */
    public function replace_page_content(string $content): string {
        if (is_admin() || !is_singular('page') || !is_main_query() || !in_the_loop()) {
            return $content;
        }

        if (is_page('calgary-condos')) {
            return do_shortcode('[ccl_homepage_tight]');
        }

        if (is_page('price-reduced-condos')) {
            return do_shortcode($this->price_reduced_layout());
        }

        if (is_page('condo-buildings')) {
            return do_shortcode($this->compare_buildings_layout());
        }

        if (is_page(['market-report', 'market-update'])) {
            return do_shortcode($this->market_update_layout());
        }

        if (is_page('calgary-communities')) {
            return do_shortcode($this->calgary_communities_layout());
        }

        return $content;
    }

    /**
     * Render /market-update/ on-site even when no WordPress page exists yet.
     */
    public function render_virtual_market_update_page(): void {
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
        echo '<main id="primary" class="site-main ccl-virtual-market-update">';
        echo do_shortcode($this->market_update_layout()); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- shortcode output is intentionally rendered.
        echo '</main>';
        get_footer();
        exit;
    }

    /**
     * Rewrite WordPress menu Market Update links before they render.
     *
     * @param array<string,string> $atts Menu link attributes.
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
     * Rewrite visible Market Update menu links to the on-site page.
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
     * Add a truthful Price Drop badge to cards on the price-reduced IDX page.
     *
     * The feed itself is the price-reduced search. myRealPage does not always expose the previous price,
     * so this marks the card category without inventing an old price or discount amount.
     */
    public function add_price_drop_badges(): void {
        if (is_admin() || !is_page('price-reduced-condos')) {
            return;
        }
        ?>
        <style>
            body.page-id-0 .ccl-price-drop-badge,
            .ccl-price-drop-badge {
                position: absolute;
                left: 8px;
                top: 8px;
                z-index: 20;
                display: inline-flex;
                align-items: center;
                gap: 4px;
                padding: 5px 8px;
                border-radius: 999px;
                background: #0A1A2F;
                color: #fff;
                font-size: 11px;
                font-weight: 800;
                letter-spacing: .04em;
                text-transform: uppercase;
                box-shadow: 0 8px 18px rgba(10, 26, 47, .22);
                pointer-events: none;
            }
            .ccl-price-drop-badge::before {
                content: "↓";
                display: inline-block;
                width: 16px;
                height: 16px;
                line-height: 16px;
                text-align: center;
                border-radius: 50%;
                background: #F0C75E;
                color: #0A1A2F;
                font-weight: 900;
            }
            .ccl-price-drop-host {
                position: relative !important;
            }
        </style>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            function hasListingSignals(el) {
                var text = (el.textContent || '').toLowerCase();
                return text.indexOf('mls') !== -1 && (text.indexOf('$') !== -1 || text.indexOf('details') !== -1);
            }

            function badgeCards() {
                var candidates = Array.prototype.slice.call(document.querySelectorAll('.ccl-idx-shell__frame *'));
                var hosts = [];

                candidates.forEach(function (el) {
                    if (hosts.length >= 48) {
                        return;
                    }

                    var rect = el.getBoundingClientRect();
                    if (rect.width < 180 || rect.width > 520 || rect.height < 180 || rect.height > 760) {
                        return;
                    }

                    if (!hasListingSignals(el)) {
                        return;
                    }

                    var hasChildHost = hosts.some(function (host) {
                        return host.contains(el);
                    });
                    if (hasChildHost) {
                        return;
                    }

                    var image = el.querySelector('img');
                    var details = (el.textContent || '').toLowerCase().indexOf('details') !== -1;
                    if (image && details) {
                        hosts.push(el);
                    }
                });

                hosts.forEach(function (host) {
                    if (host.querySelector(':scope > .ccl-price-drop-badge')) {
                        return;
                    }
                    host.classList.add('ccl-price-drop-host');
                    var badge = document.createElement('span');
                    badge.className = 'ccl-price-drop-badge';
                    badge.textContent = 'Price Drop';
                    host.insertBefore(badge, host.firstChild);
                });
            }

            badgeCards();
            window.setTimeout(badgeCards, 800);
            window.setTimeout(badgeCards, 1800);
        });
        </script>
        <?php
    }

    /**
     * Price Reduced page wrapper. The IDX controls whether price-change history appears on cards.
     */
    private function price_reduced_layout(): string {
        $idx = '[mrp account_id=67196 listing_def=search-1439357 context=recip perm_attr=tmpl~v2 ][/mrp]';

        return <<<HTML
<section class="ccl-section ccl-section--white ccl-compare-hero">
    <div class="ccl-wrap ccl-compare-hero__inner">
        <div>
            <p class="ccl-eyebrow">Calgary Price Drop Condos</p>
            <h1>Condos with recent price drops.</h1>
            <p>This page uses the price-reduced IDX search. Cards are marked as Price Drop listings, but we do not invent an old price or discount amount if myRealPage does not provide it.</p>
        </div>
        <div class="ccl-compare-hero__actions">
            <a class="ccl-btn ccl-btn--primary" href="#idx-search">View Price Drop Condos</a>
            <a class="ccl-btn ccl-btn--dark" href="/building-alerts/">Get Price Drop Alerts</a>
        </div>
    </div>
</section>

[ccl_idx_shell eyebrow="Live Price Drop Condo Search" title="Current Calgary condos from the price-drop search" subtitle="The feed below is filtered through the saved price-reduced search. The badge identifies these as price-drop listings; use Details or alerts to verify exact history."]{$idx}[/ccl_idx_shell]
[ccl_alert_form title="Get Calgary Condo Price Drop Alerts" subtitle="Tell us your target area, building, budget, and timing. We will help watch price reductions without you having to keep checking every day." button_text="Send My Price Drop Alert Request"]
[ccl_site_footer]
HTML;
    }

    /**
     * Compare Calgary condo buildings page.
     */
    private function compare_buildings_layout(): string {
        return <<<'SHORTCODES'
<section class="ccl-section ccl-section--white ccl-compare-hero">
    <div class="ccl-wrap ccl-compare-hero__inner">
        <div>
            <p class="ccl-eyebrow">Compare Calgary Condo Buildings</p>
            <h1>Compare the building before you book the showing.</h1>
            <p>Price and photos are only the start. Strong Calgary condo buyers compare the building, fees, rules, documents, parking, storage, lifestyle fit, and resale path before making a move.</p>
        </div>
        <div class="ccl-compare-hero__actions">
            <a class="ccl-btn ccl-btn--primary" href="#condo-alerts">Request Building Comparison</a>
            <a class="ccl-btn ccl-btn--dark" href="tel:+14038006996">Call +1 (403) 800-6996</a>
        </div>
    </div>
</section>

[ccl_market_snapshot title="What to compare before you book a showing" subtitle="Two units can look similar online and carry very different risk. Compare the building, fees, rules, documents, parking, storage, and resale path before you spend time on showings."]
[ccl_building_checklist title="Building comparison checklist" subtitle="Use this checklist to separate strong Calgary condo options from weak ones before you write an offer."]
[ccl_alert_form title="Request a Calgary Building Comparison" subtitle="Tell us the areas, buildings, budget, parking needs, pet rules, and timeline. We will help narrow the right options before you book showings." button_text="Send My Building Comparison Request"]
[ccl_site_footer]
SHORTCODES;
    }

    /**
     * Market Update page. Keeps users on-site and links CREB as the official source.
     */
    private function market_update_layout(): string {
        $creb_url = esc_url(self::CREB_MARKET_UPDATE_URL);

        return <<<HTML
<section class="ccl-section ccl-section--white ccl-compare-hero">
    <div class="ccl-wrap ccl-compare-hero__inner">
        <div>
            <p class="ccl-eyebrow">Calgary Market Update</p>
            <h1>Calgary condo market update.</h1>
            <p>This page keeps clients on your site first, then gives them the official CREB source link when they want the full board report.</p>
        </div>
        <div class="ccl-compare-hero__actions">
            <a class="ccl-btn ccl-btn--primary" href="/calgary-condos/">Search Calgary Condos</a>
            <a class="ccl-btn ccl-btn--dark" href="{$creb_url}" target="_blank" rel="noopener noreferrer">Open CREB Source</a>
        </div>
    </div>
</section>

[ccl_market_snapshot eyebrow="Calgary Condo Market Update" title="Use market data, then compare the building" subtitle="Market data gives the big picture. The individual building still needs to be checked for fees, rules, reserve fund strength, parking, storage, documents, and resale path."]
[ccl_building_cta title="Want help reading the Calgary condo market?" subtitle="Send the building, area, or price range you are watching and get guidance before booking showings." button_text="Compare Condo Buildings" button_url="/condo-buildings/"]
<section class="ccl-section ccl-section--white">
    <div class="ccl-wrap">
        <p class="ccl-eyebrow">Official Source</p>
        <h2>CREB Board housing statistics</h2>
        <p>The full CREB Board report opens in a new tab so buyers do not lose this site. We do not copy the full board report into this page.</p>
        <a class="ccl-btn ccl-btn--primary" href="{$creb_url}" target="_blank" rel="noopener noreferrer">Open CREB Housing Statistics</a>
    </div>
</section>
[ccl_site_footer]
HTML;
    }

    /**
     * Calgary Communities page.
     */
    private function calgary_communities_layout(): string {
        return <<<'SHORTCODES'
<section class="ccl-section ccl-section--white ccl-compare-hero">
    <div class="ccl-wrap ccl-compare-hero__inner">
        <div>
            <p class="ccl-eyebrow">Calgary Communities</p>
            <h1>Compare the community before you compare the condo.</h1>
            <p>Search schools, commute, parks, walkability, nearby amenities, and condo lifestyle fit before you shortlist buildings or book showings.</p>
        </div>
        <div class="ccl-compare-hero__actions">
            <a class="ccl-btn ccl-btn--primary" href="/calgary-condos/">Search Calgary Condos</a>
            <a class="ccl-btn ccl-btn--dark" href="/condo-buildings/">Compare Buildings</a>
        </div>
    </div>
</section>

[ccl_school_community]
[ccl_area_grid title="Explore Calgary condo communities" subtitle="Start with the Calgary condo areas buyers ask about most, then narrow by building, budget, schools, commute, and lifestyle fit."]
[ccl_price_grid]
[ccl_alert_form title="Get Community-Based Condo Alerts" subtitle="Tell us the areas, school needs, commute, budget, parking needs, and timeline. We will help narrow the right Calgary condo options." button_text="Send My Community Search Request"]
[ccl_site_footer]
SHORTCODES;
    }
}

new Calgary_Condo_Page_Overrides();
