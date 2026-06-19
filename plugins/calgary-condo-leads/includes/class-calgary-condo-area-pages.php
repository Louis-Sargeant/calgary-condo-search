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
        $guidance = esc_html((string) ($area['guidance'] ?? 'Use the live IDX search, then compare the building details that influence long-term ownership and resale.'));
        $idx = self::ALL_CONDOS_IDX;
        $idx_shell = do_shortcode('[ccl_idx_shell eyebrow="Live ' . $label . ' Condo Search" title="Current ' . $label . ' condo listings" subtitle="Use the IDX feed below, then ask for building-first guidance before booking showings."]' . $idx . '[/ccl_idx_shell]');
        $lead_modal = do_shortcode('[ccl_lead_modal title="Get a ' . $label . ' condo shortlist" subtitle="Send your preferred buildings, budget, parking needs, pet needs, and timing. We will help narrow the right ' . $label . ' options without inventing listing data."]');

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
                <a class="ccl-btn ccl-btn--primary" href="#idx-search" target="_self">View {$label} Condos</a>
                <a class="ccl-btn ccl-btn--dark" href="/building-alerts/" target="_self">Get Building Alerts</a>
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

    {$idx_shell}
    {$lead_modal}
</main>
HTML;
    }
}

new Calgary_Condo_Area_Pages();
