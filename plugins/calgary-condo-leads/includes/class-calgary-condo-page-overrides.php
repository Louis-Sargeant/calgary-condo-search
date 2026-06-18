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
            return do_shortcode($this->price_reduced_layout($content));
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
     * Price Reduced page wrapper. The IDX controls whether price-change history appears on cards.
     */
    private function price_reduced_layout(string $content): string {
        $idx = trim($content);
        if ('' === $idx) {
            $idx = '[mrp account_id=67196 listing_def=search-1439357 context=recip perm_attr=tmpl~v2 ][/mrp]';
        }

        return <<<HTML
<section class="ccl-section ccl-section--white ccl-compare-hero">
    <div class="ccl-wrap ccl-compare-hero__inner">
        <div>
            <p class="ccl-eyebrow">Calgary Price Reduced Condos</p>
            <h1>Condos with recent price reductions.</h1>
            <p>This page uses the price-reduced IDX search. Some listing cards only show the current asking price because the myRealPage card template does not always expose the previous price or reduction amount.</p>
        </div>
        <div class="ccl-compare-hero__actions">
            <a class="ccl-btn ccl-btn--primary" href="#idx-search">View Price Reduced Condos</a>
            <a class="ccl-btn ccl-btn--dark" href="/building-alerts/">Get Price Drop Alerts</a>
        </div>
    </div>
</section>

[ccl_idx_shell eyebrow="Live Price Reduced Condo Search" title="Current Calgary condos from the price-reduced search" subtitle="The feed below is filtered through the saved price-reduced search. If the IDX card only shows one price, use the Details button or request a price-drop alert for verification."]{$idx}[/ccl_idx_shell]
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
            <p>Stay on this page for the plain-English condo market breakdown, then use the official CREB housing statistics link as the source document when you want the full board report.</p>
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
