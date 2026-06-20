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
    private const SEEDED_REGIONAL_PAGES_VERSION_OPTION = 'ccl_seed_regional_pages_version';

    private const AREAS = [
        'southeast-calgary-condos' => [
            'label' => 'Southeast Calgary',
            'title' => 'Southeast Calgary Condos',
            'subtitle' => 'Search Southeast Calgary condos, then compare the building, fees, rules, parking, storage, and resale path before booking showings.',
            'guidance' => 'Southeast Calgary condo buyers often compare lake communities, newer suburban buildings, transit access, shopping, parks, and ownership costs. Review the corporation, fee inclusions, parking, storage, pet rules, reserve fund, and resale fit before choosing by price alone.',
        ],
        'southwest-calgary-condos' => [
            'label' => 'Southwest Calgary',
            'title' => 'Southwest Calgary Condos',
            'subtitle' => 'Search Southwest Calgary condos, then compare the building, fees, rules, parking, storage, and resale path before booking showings.',
            'guidance' => 'Southwest Calgary condo buyers often balance established inner-city access, C-Train convenience, parks, shopping, and quieter residential pockets. Compare older low-rise buildings differently than newer concrete or amenity-rich projects because fees, documents, and resale demand can vary block by block.',
        ],
        'northwest-calgary-condos' => [
            'label' => 'Northwest Calgary',
            'title' => 'Northwest Calgary Condos',
            'subtitle' => 'Search Northwest Calgary condos with building-first guidance before you chase listings.',
            'guidance' => 'Northwest Calgary condo searches often revolve around university access, hospitals, river pathways, C-Train stations, and established communities. Before booking showings, check the building age, envelope history, parking setup, storage, pet rules, and how similar units have been selling.',
        ],
        'northeast-calgary-condos' => [
            'label' => 'Northeast Calgary',
            'title' => 'Northeast Calgary Condos',
            'subtitle' => 'Search Northeast Calgary condos and narrow the right building, budget, and ownership fit.',
            'guidance' => 'Northeast Calgary can offer practical condo budgets, airport access, transit options, and newer suburban communities. The right buy still depends on the specific corporation, fee inclusions, parking, visitor parking, management, insurance, bylaws, and future buyer pool.',
        ],
        'downtown-calgary-condos' => [
            'label' => 'Downtown Calgary',
            'title' => 'Downtown Calgary Condos',
            'subtitle' => 'Search Downtown Calgary condos and compare lifestyle, fees, parking, storage, and resale strength.',
            'guidance' => 'Downtown Calgary condo buying is building-specific. River proximity, plus-15 access, office core convenience, concrete construction, views, concierge-style amenities, parking, storage, and fee levels can change value dramatically between towers.',
        ],
        'beltline-condos' => [
            'label' => 'Beltline',
            'title' => 'Beltline Condos',
            'subtitle' => 'Search Beltline condos and compare the buildings that fit your budget, lifestyle, and timeline.',
            'guidance' => 'Beltline is one of Calgary’s most active condo areas, but not every building fits every buyer. Compare walkability, nightlife noise, age, construction, elevators, amenities, parking, short-term-rental rules, pet rules, and resale demand before chasing the best-looking unit.',
        ],
        'east-village-condos' => [
            'label' => 'East Village',
            'title' => 'East Village Condos',
            'subtitle' => 'Search East Village condos near the river, library, restaurants, pathways, and downtown east amenities.',
            'guidance' => 'East Village appeals to buyers who want newer towers, river access, walkability, and a more urban lifestyle. Compare building age, parking assignment, storage, amenities, short-term-rental rules, condo fees, and how much future supply may affect resale.',
        ],
        'mission-condos' => [
            'label' => 'Mission',
            'title' => 'Mission Condos',
            'subtitle' => 'Search Mission condos and compare walkability, building age, river access, rules, and resale fit.',
            'guidance' => 'Mission condo buyers often want restaurants, river pathways, 4th Street access, and inner-city convenience. The best unit depends on the building’s age, parking, storage, noise exposure, pet rules, fee trend, documents, and long-term resale demand.',
        ],
        'eau-claire-condos' => [
            'label' => 'Eau Claire',
            'title' => 'Eau Claire Condos',
            'subtitle' => 'Search Eau Claire condos and compare premium buildings, river proximity, fees, documents, and resale strength.',
            'guidance' => 'Eau Claire is a premium Calgary condo area where building quality, river proximity, concierge-style services, parking, storage, reserve fund health, and monthly fee inclusions can dramatically affect ownership cost and resale appeal.',
        ],
        'calgary-luxury-condos' => [
            'label' => 'Calgary Luxury Condos',
            'title' => 'Calgary Luxury Condos',
            'subtitle' => 'Search higher-end Calgary condos and compare the building, services, views, privacy, amenities, and resale path.',
            'guidance' => 'Luxury condo buying is not just price. Compare construction quality, concierge or security, elevator access, parking count, storage, view protection, amenities, privacy, fee inclusions, building reputation, and the depth of the future buyer pool.',
        ],
    ];

    private const REGIONAL_MRP_SHORTCODES = [
        'southeast-calgary-condos' => '[mrp account_id=67196 listing_def=search-1439654 context=recip perm_attr=tmpl~v2]',
        'southwest-calgary-condos' => '[mrp account_id=67196 listing_def=search-1439299 context=recip perm_attr=tmpl~v2 ][/mrp]',
        'northwest-calgary-condos' => '[mrp account_id=67196 listing_def=search-1439583 context=recip perm_attr=tmpl~v2 ][/mrp]',
        'northeast-calgary-condos' => '',
    ];

    private const SEEDED_REGIONAL_PAGES = [
        'southwest-calgary-condos' => [
            'title' => 'Southwest Calgary Condos',
            'intro' => 'Search Southwest Calgary condos, then compare the building, fees, rules, parking, storage, and resale path before booking showings.',
            'listings_heading' => 'Live Southwest Calgary Condo Listings',
            'shortcode' => '[mrp account_id=67196 listing_def=search-1439299 context=recip perm_attr=tmpl~v2 ][/mrp]',
        ],
        'northwest-calgary-condos' => [
            'title' => 'Northwest Calgary Condos',
            'intro' => 'Search Northwest Calgary condos with building-first guidance before you chase listings.',
            'listings_heading' => 'Live Northwest Calgary Condo Listings',
            'shortcode' => '[mrp account_id=67196 listing_def=search-1439583 context=recip perm_attr=tmpl~v2 ][/mrp]',
        ],
    ];

    public function __construct() {
        add_action('admin_init', [$this, 'seed_regional_pages']);
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

        if ('southeast-calgary-condos' !== $slug && (is_page() || is_singular('page'))) {
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

    public function seed_regional_pages(): void {
        if (!is_admin() || !current_user_can('edit_pages')) {
            return;
        }

        if ((string) get_option(self::SEEDED_REGIONAL_PAGES_VERSION_OPTION, '') === CCL_VERSION) {
            return;
        }

        $all_pages_confirmed = true;

        foreach (self::SEEDED_REGIONAL_PAGES as $slug => $page) {
            $existing_page = get_page_by_path($slug, OBJECT, 'page');

            if ($existing_page instanceof WP_Post) {
                continue;
            }

            $inserted_page_id = wp_insert_post([
                'post_type' => 'page',
                'post_status' => 'publish',
                'post_title' => (string) $page['title'],
                'post_name' => $slug,
                'post_content' => $this->regional_page_content($page),
                'comment_status' => 'closed',
                'ping_status' => 'closed',
            ], true);

            if (is_wp_error($inserted_page_id) || 0 === (int) $inserted_page_id) {
                $all_pages_confirmed = false;
            }
        }

        if ($all_pages_confirmed) {
            update_option(self::SEEDED_REGIONAL_PAGES_VERSION_OPTION, CCL_VERSION, false);
        }
    }

    private function regional_page_content(array $page): string {
        $title = (string) $page['title'];
        $intro = (string) $page['intro'];
        $listings_heading = (string) $page['listings_heading'];
        $shortcode = (string) $page['shortcode'];

        return <<<HTML
<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">{$title}</h1>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>{$intro}</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Compare the building before the unit.</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Review the condo corporation, monthly fees, bylaws, parking, storage, pet rules, rental rules, reserve fund, insurance, recent minutes, and resale fit before choosing a unit by price alone.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/building-alert-request/" target="_self">Get Building Alerts</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:heading -->
<h2 class="wp-block-heading">{$listings_heading}</h2>
<!-- /wp:heading -->

<!-- wp:shortcode -->
{$shortcode}
<!-- /wp:shortcode -->
HTML;
    }

    private function layout(array $area, string $slug): string {
        $label = esc_html((string) $area['label']);
        $title = esc_html((string) $area['title']);
        $subtitle = esc_html((string) $area['subtitle']);
        $guidance = esc_html((string) ($area['guidance'] ?? 'Use the live IDX search, then compare the building details that influence long-term ownership and resale.'));
        $idx_section = 'northwest-calgary-condos' === $slug
            ? $this->northwest_manual_idx_feed()
            : $this->regional_idx_section($slug, $label);
        $lead_modal = do_shortcode('[ccl_lead_modal title="Get a ' . $label . ' condo shortlist" subtitle="Send your preferred buildings, budget, parking needs, pet needs, and timing. We will help narrow the right ' . $label . ' options without inventing listing data."]');

        return <<<HTML
<main class="ccl-inner-page-shell ccl-area-page ccl-area-page--{$slug}">
    <section class="ccl-section ccl-section--white ccl-compare-hero ccl-area-hero">
        <div class="ccl-wrap ccl-compare-hero__inner">
            <div>
                <p class="ccl-eyebrow">Calgary Condo Search</p>
                <h1>{$title}</h1>
                <p>{$subtitle}</p>
            </div>
            <div class="ccl-compare-hero__actions">
                <a href="#idx-search" target="_self" class="ccl-btn ccl-btn--primary ccl-region-cta-button">View {$label} Condos</a>
                <a href="/building-alert-request/" target="_self" class="ccl-btn ccl-btn--dark ccl-region-alert-button">Get Building Alerts</a>
            </div>
        </div>
    </section>

    <section class="ccl-section ccl-area-guidance">
        <div class="ccl-wrap ccl-portal-intro__grid">
            <div>
                <p class="ccl-eyebrow">{$label} Buyer Guidance</p>
                <h2>Compare the building before the unit.</h2>
                <p>{$guidance}</p>
            </div>
            <div class="ccl-portal-intro__panel">
                <strong>Before you book showings</strong>
                <ul>
                    <li>Confirm parking, storage, pet rules, rental rules, and fee inclusions.</li>
                    <li>Review reserve fund, minutes, insurance, bylaws, and upcoming repair signals.</li>
                    <li>Ask how the building compares for resale before choosing by price alone.</li>
                </ul>
            </div>
        </div>
    </section>

    {$idx_section}
    {$lead_modal}
</main>
HTML;
    }
    private function northwest_manual_idx_feed(): string {
        $northwest_feed = do_shortcode('[mrp account_id=67196 listing_def=search-1439583 context=recip perm_attr=tmpl~v2 ][/mrp]');

        return <<<HTML
<div id="mrp-nw-listings-feed-container" class="ccl-manual-mrp-feed ccl-manual-mrp-feed--northwest" style="width: 100% !important; margin-top: 40px !important; padding: 20px 0 !important;">
    {$northwest_feed}
</div>
HTML;
    }

    private function regional_idx_section(string $slug, string $label): string {
        $shortcode = trim((string) (self::REGIONAL_MRP_SHORTCODES[$slug] ?? ''));
        $feed = '' !== $shortcode
            ? do_shortcode($shortcode)
            : '<p class="ccl-region-idx-placeholder">' . esc_html(sprintf(__('Live %s condo listings will appear here once the saved myRealPage search is connected.', 'calgary-condo-leads'), $label)) . '</p>';

        return <<<HTML
<section id="idx-search" class="ccl-section ccl-section--white ccl-region-idx-section">
    <div class="ccl-wrap">
        <h2>Live {$label} Condo Listings</h2>
        <p>Browse current {$label} condo listings below, then compare the building, fees, rules, parking, storage, and resale fit before booking showings.</p>
        <div class="ccl-region-idx-feed">
            {$feed}
        </div>
    </div>
</section>
HTML;
    }

}

new Calgary_Condo_Area_Pages();
