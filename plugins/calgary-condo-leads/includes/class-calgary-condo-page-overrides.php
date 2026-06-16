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
     * Wire filters.
     */
    public function __construct() {
        add_filter('the_content', [$this, 'replace_page_content'], 999);
    }

    /**
     * Replace page bodies with approved clean layouts.
     *
     * @param string $content Original page content.
     * @return string
     */
    public function replace_page_content(string $content): string {
        if (is_admin() || !is_singular('page') || !is_main_query() || !in_the_loop()) {
            return $content;
        }

        if (is_page('calgary-condos')) {
            return do_shortcode($this->calgary_condos_layout());
        }

        if (is_page('condo-buildings')) {
            return do_shortcode($this->compare_buildings_layout());
        }

        return $content;
    }

    /**
     * Calgary Condos listing page.
     */
    private function calgary_condos_layout(): string {
        return <<<'SHORTCODES'
[ccl_hero title="Search Calgary Condos With a Fighter In Your Corner" subtitle="Search current Calgary condo listings first. Then compare the building, fees, rules, parking, storage, and resale path before you book a showing." primary_text="Search Calgary Condos" primary_url="#mrp-listings" secondary_text="Compare Condo Buildings" secondary_url="/condo-buildings/" panel_title="Get Calgary condo matches sent to you" panel_text="Tell us what you want and we will help you narrow the search."]

<section id="mrp-listings" class="ccl-section ccl-section--white ccl-live-idx">
    <div class="ccl-wrap">
        <div class="ccl-section__header">
            <p class="ccl-eyebrow">Calgary Condo Listings</p>
            <h2>Live Calgary condo search</h2>
            <p>Use the live myRealPage search below to compare current Calgary condo listings.</p>
        </div>
        [mrp account_id=67196 searchform_def=idx.browse embed=true context=recip init_attr=omni-city%3ACalgary%5BCalgary%20%2Ccity%29%5D,property_type-DWELLING_TYPE%40APAR]
    </div>
</section>

[ccl_buyer_path]
[ccl_building_cta title="Compare a Calgary condo building before you book" subtitle="Send the building or area you are considering and get help checking fees, rules, parking, storage, documents, and resale path." button_text="Compare Condo Buildings" button_url="/condo-buildings/"]
[ccl_alert_form title="Get Calgary Condo Alerts" subtitle="Tell us your preferred area, budget, parking needs, timeline, and must-haves." button_text="Send My Condo Match Request"]
[ccl_site_footer]
SHORTCODES;
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
}

new Calgary_Condo_Page_Overrides();
