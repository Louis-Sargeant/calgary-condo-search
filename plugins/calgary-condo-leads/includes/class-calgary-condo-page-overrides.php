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
 * Forces the live Calgary Condos page to use the clean IDX-first layout.
 */
final class Calgary_Condo_Page_Overrides {
    /**
     * Wire filters.
     */
    public function __construct() {
        add_filter('the_content', [$this, 'replace_calgary_condos_content'], 999);
    }

    /**
     * Replace the Calgary Condos page body with the approved clean layout.
     *
     * @param string $content Original page content.
     * @return string
     */
    public function replace_calgary_condos_content(string $content): string {
        if (is_admin() || !is_singular('page') || !is_main_query() || !in_the_loop()) {
            return $content;
        }

        if (!is_page('calgary-condos')) {
            return $content;
        }

        $layout = <<<'SHORTCODES'
[ccl_hero title="Search Calgary Condos With a Fighter In Your Corner" subtitle="Find Calgary condos, compare buildings, get alerts, and request guidance before you book a showing." primary_text="Search Calgary Condos" primary_url="#mrp-listings" secondary_text="Get My Condo Value Report" secondary_url="#condo-alerts" panel_title="Get Calgary condo matches sent to you" panel_text="Tell us what you want and we will help you narrow the search."]

[ccl_quick_search]
[ccl_trust_strip]

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

[ccl_value_cards]
[ccl_area_grid]
[ccl_price_grid]
[ccl_buyer_path]
[ccl_building_cta]

[ccl_alert_form title="Get Calgary Condo Alerts" subtitle="Tell us your preferred area, budget, parking needs, timeline, and must-haves." button_text="Send My Condo Match Request"]

[ccl_seller_cta]
[ccl_site_footer]
SHORTCODES;

        return do_shortcode($layout);
    }
}

new Calgary_Condo_Page_Overrides();
