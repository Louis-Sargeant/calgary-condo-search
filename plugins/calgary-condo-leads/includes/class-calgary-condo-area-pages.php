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
        'all-calgary-condos' => [
            'label'    => 'All Calgary',
            'title'    => 'Calgary Condos',
            'subtitle' => 'Search all Calgary condos, then compare the building, fees, rules, parking, storage, and resale path before booking showings.',
            'intro'    => 'Calgary offers condo options across every quadrant, price range, and building type. Buyers compare fees, parking, storage, pet rules, reserve fund health, and resale fit before booking showings.',
            'guidance' => 'Calgary condo buyers have options across every quadrant, price range, and building type. Before choosing by price or photos alone, compare the condo corporation, fee inclusions, parking, storage, pet rules, rental rules, reserve fund, bylaws, and how similar units have sold in that specific building.',
        ],
        'southeast-calgary-condos' => [
            'label'    => 'Southeast Calgary',
            'title'    => 'Southeast Calgary Condos',
            'subtitle' => 'Search Southeast Calgary condos, then compare the building, fees, rules, parking, storage, and resale path before booking showings.',
            'intro'    => 'Southeast Calgary offers newer suburban condo buildings near lake communities, retail hubs, transit, and established residential areas. Compare the building, fees, bylaws, parking, storage, and resale path before choosing by price alone.',
            'guidance' => 'Southeast Calgary condo buyers often compare lake communities, newer suburban buildings, transit access, shopping, parks, and ownership costs. Review the corporation, fee inclusions, parking, storage, pet rules, reserve fund, and resale fit before choosing by price alone.',
        ],
        'southwest-calgary-condos' => [
            'label'    => 'Southwest Calgary',
            'title'    => 'Southwest Calgary Condos',
            'subtitle' => 'Search Southwest Calgary condos, then compare the building, fees, rules, parking, storage, and resale path before booking showings.',
            'intro'    => 'Southwest Calgary balances established inner-city access, C-Train convenience, parks, and quieter residential pockets. Compare fees, parking, storage, pet rules, reserve fund health, and resale fit before booking showings.',
            'guidance' => 'Southwest Calgary condo buyers often balance established inner-city access, C-Train convenience, parks, shopping, and quieter residential pockets. Compare older low-rise buildings differently than newer concrete or amenity-rich projects because fees, documents, and resale demand can vary block by block.',
        ],
        'northwest-calgary-condos' => [
            'label'    => 'Northwest Calgary',
            'title'    => 'Northwest Calgary Condos',
            'subtitle' => 'Search Northwest Calgary condos with building-first guidance before you chase listings.',
            'intro'    => 'Northwest Calgary condo searches often revolve around university access, hospitals, river pathways, and C-Train stations. Before booking showings, compare building age, envelope history, parking, storage, pet rules, and how similar units have been selling.',
            'guidance' => 'Northwest Calgary condo searches often revolve around university access, hospitals, river pathways, C-Train stations, and established communities. Before booking showings, check the building age, envelope history, parking setup, storage, pet rules, and how similar units have been selling.',
        ],
        'northeast-calgary-condos' => [
            'label'    => 'Northeast Calgary',
            'title'    => 'Northeast Calgary Condos',
            'subtitle' => 'Search Northeast Calgary condos and narrow the right building, budget, and ownership fit.',
            'intro'    => 'Northeast Calgary can offer practical condo budgets, airport access, transit options, and newer suburban communities. The right buy depends on the corporation, fee inclusions, parking, visitor parking, management, and the future buyer pool.',
            'guidance' => 'Northeast Calgary can offer practical condo budgets, airport access, transit options, and newer suburban communities. The right buy still depends on the specific corporation, fee inclusions, parking, visitor parking, management, insurance, bylaws, and future buyer pool.',
        ],
        'downtown-calgary-condos' => [
            'label'    => 'Downtown Calgary',
            'title'    => 'Downtown Calgary Condos',
            'subtitle' => 'Search Downtown Calgary condos and compare lifestyle, fees, parking, storage, and resale strength.',
            'intro'    => 'Downtown Calgary condo buying is building-specific. River proximity, Plus-15 access, concrete construction, views, concierge amenities, parking, storage, and fee levels can change value dramatically between towers.',
            'guidance' => 'Downtown Calgary condo buying is building-specific. River proximity, plus-15 access, office core convenience, concrete construction, views, concierge-style amenities, parking, storage, and fee levels can change value dramatically between towers.',
        ],
        'downtown-condos' => [
            'label'           => 'Downtown',
            'title'           => 'Downtown Condos',
            'subtitle'        => 'Search Downtown condos and compare walkability, building fit, fees, parking, storage, and resale strength.',
            'intro'           => 'Downtown Calgary is one of the city’s strongest condo markets, offering quick access to office towers, river pathways, restaurants, transit, and entertainment. Buyers can find everything from established apartment-style condos to newer high-rise residences, making Downtown a strong option for professionals, investors, and buyers who want maximum walkability.',
            'guidance'        => 'Downtown condo buyers often prioritize office access, transit, river pathways, and walkability. Compare each building’s fee structure, parking, storage, pet and rental rules, and resale demand before choosing by photos or price alone.',
            'lead_form_label' => 'Get Downtown Condo Alerts — Be the first to know about new listings, price changes, and downtown condos that match your criteria.',
        ],
        'downtown-core-condos' => [
            'label'    => 'Downtown Core',
            'title'    => 'Downtown Core Condos',
            'subtitle' => 'Search Downtown Core condos and compare lifestyle, fees, parking, storage, and resale strength.',
            'intro'    => 'Downtown Core condo buying is building-specific. Plus-15 access, office core convenience, concrete construction, views, parking, storage, and fee levels can change value dramatically between towers.',
            'guidance' => 'Downtown Core condo buying is building-specific. River proximity, plus-15 access, office core convenience, concrete construction, views, concierge-style amenities, parking, storage, and fee levels can change value dramatically between towers.',
        ],
        'beltline-condos' => [
            'label'    => 'Beltline',
            'title'    => 'Beltline Condos',
            'subtitle' => 'Search Beltline condos and compare the buildings that fit your budget, lifestyle, and timeline.',
            'intro'    => 'Beltline is one of Calgary’s most walkable condo communities, offering easy access to downtown offices, restaurants, cafés, parks, and transit. Buyers can choose from affordable apartments to luxury high-rise residences, making Beltline a popular option for first-time buyers, professionals, investors, and downsizers.',
            'guidance' => 'Beltline is one of Calgary’s most active condo areas, but not every building fits every buyer. Compare walkability, nightlife noise, age, construction, elevators, amenities, parking, short-term-rental rules, pet rules, and resale demand before chasing the best-looking unit.',
        ],
        'east-village-condos' => [
            'label'    => 'East Village',
            'title'    => 'East Village Condos',
            'subtitle' => 'Search East Village condos and compare newer riverfront towers, amenities, fees, and long-term resale fit.',
            'intro'    => 'East Village attracts buyers who want newer concrete towers, Bow River pathways, the Central Library district, and quick downtown access. Strong decisions come from comparing each building’s fee structure, amenities, parking setup, storage, rental rules, and how future tower supply may affect resale.',
            'guidance' => 'East Village condo buyers often prioritize river access, newer construction, and urban convenience. Before booking showings, compare fee inclusions, parking assignment, storage, short-term-rental restrictions, amenity quality, and how similar units are reselling by building.',
        ],
        'mission-condos' => [
            'label'    => 'Mission',
            'title'    => 'Mission Condos',
            'subtitle' => 'Search Mission condos and compare walkability, building quality, ownership costs, and resale strength.',
            'intro'    => 'Mission remains one of Calgary’s most in-demand lifestyle condo communities, with 4th Street restaurants, Elbow River pathways, and fast downtown access. Compare building condition, condo fees, parking, storage, pet bylaws, and noise exposure before selecting a unit by photos alone.',
            'guidance' => 'Mission condo searches usually balance lifestyle and building quality. Before you book showings, review age and maintenance history, fee trend, parking and storage setup, pet and rental rules, and how each building performs when similar units hit the market.',
        ],
        'eau-claire-condos' => [
            'label'    => 'Eau Claire',
            'title'    => 'Eau Claire Condos',
            'subtitle' => 'Search Eau Claire condos and compare premium riverfront buildings, services, fees, and resale path.',
            'intro'    => 'Eau Claire is a premium inner-city condo market for buyers who want Bow River pathways, Prince’s Island Park access, and quieter luxury living near downtown. The right purchase comes from comparing concierge level, fee inclusions, parking and storage, view protection, and reserve fund strength by building.',
            'guidance' => 'Eau Claire condo buying is highly building-specific. Compare service level, amenity quality, parking and storage access, reserve fund planning, and monthly fee inclusions so your ownership costs and future resale position are clear before offering.',
        ],
        'kensington-condos' => [
            'label'    => 'Kensington',
            'title'    => 'Kensington Condos',
            'subtitle' => 'Search Kensington condos and compare walkability, building quality, rules, fees, and resale fit.',
            'intro'    => 'Kensington and Hillhurst are strong Calgary condo areas for buyers who want walkability, restaurants, shops, LRT access, river pathways, and a village-style inner-city lifestyle close to downtown. Before booking a showing, compare the building, condo fees, parking, storage, pet rules, amenities, bylaws, and resale fit.',
            'guidance' => 'Kensington condo buyers often want village-style walkability, cafés, transit, and quick inner-city access. Before choosing by photos alone, compare condo fees, parking, storage, pet rules, reserve fund strength, and how each building performs for long-term resale demand.',
        ],
        'hillhurst-condos' => [
            'label'    => 'Hillhurst',
            'title'    => 'Hillhurst Condos',
            'subtitle' => 'Search Hillhurst condos and compare walkability, building quality, rules, fees, and resale fit.',
            'intro'    => 'Hillhurst is home to the popular Kensington Village shopping and dining district, offering inner-city condo living near SAIT, the Bow River pathways, downtown Calgary, and the Sunnyside CTrain station. Buyers should compare building age, condo fees, parking, storage, pet rules, and resale demand before choosing between older low-rise buildings and newer infill-style condo options.',
            'guidance' => 'Hillhurst condo buyers often want village-style walkability, cafés, transit, and quick inner-city access. Before choosing by photos alone, compare condo fees, parking, storage, pet rules, reserve fund strength, and how each building performs for long-term resale demand.',
            'lead_form_label' => 'Get Hillhurst Condo Alerts — Be the first to know about new listings, price changes, and Hillhurst condos that match your criteria.',
        ],
        'bridgeland-condos' => [
            'label'    => 'Bridgeland',
            'title'    => 'Bridgeland Condos',
            'subtitle' => 'Search Bridgeland condos and compare building details, fees, parking, and lifestyle fit.',
            'intro'    => 'Bridgeland is a strong Calgary condo area for buyers who want inner-city access, restaurants, pathways, transit, river access, and a neighbourhood feel close to downtown. Before booking a showing, compare the building, condo fees, parking, storage, amenities, bylaws, pet rules, and resale fit.',
            'guidance' => 'Bridgeland combines inner-city convenience, river pathways, and strong neighbourhood demand. Compare each building by construction type, fee trend, bylaws, parking, storage, pet rules, and future buyer appeal before booking showings.',
        ],
        'bridgeland-riverside-condos' => [
            'label'    => 'Bridgeland/Riverside',
            'title'    => 'Bridgeland/Riverside Condos',
            'subtitle' => 'Search Bridgeland/Riverside condos and compare building details, fees, parking, and lifestyle fit.',
            'intro'    => 'Bridgeland/Riverside offers inner-city condo living with quick access to the Bow River pathway system, CTrain, cafés, restaurants, parks, and downtown Calgary. Buyers should compare building age, amenities, parking, storage, condo fees, and resale strength before choosing between established buildings and newer condo developments.',
            'guidance' => 'Bridgeland/Riverside combines inner-city convenience, river pathways, and strong neighbourhood demand. Compare each building by construction type, fee trend, bylaws, parking, storage, pet rules, and future buyer appeal before booking showings.',
            'lead_form_label' => 'Get Bridgeland/Riverside Condo Alerts — Be the first to know about new listings, price changes, and Bridgeland/Riverside condos that match your criteria.',
        ],
        'inglewood-condos' => [
            'label'    => 'Inglewood',
            'title'    => 'Inglewood Condos',
            'subtitle' => 'Search Inglewood condos and compare building character, fees, rules, parking, and resale fit.',
            'intro'    => 'Inglewood is a strong Calgary condo area for buyers who want character, local shops, restaurants, river pathways, downtown access, and a neighbourhood feel. Before booking a showing, compare the building, condo fees, parking, storage, bylaws, pet rules, and resale fit.',
            'guidance' => 'Inglewood condo buyers want character, local shops, restaurants, river pathways, and downtown access. Compare the building age, parking, storage, bylaws, pet rules, fee trend, and long-term resale fit before chasing the best-looking listing.',
        ],
        'sunnyside-condos' => [
            'label'    => 'Sunnyside',
            'title'    => 'Sunnyside Condos',
            'subtitle' => 'Search Sunnyside condos and compare building quality, walkability, fees, rules, and resale fit.',
            'intro'    => 'Sunnyside is an inner-city Calgary condo area offering Bow River pathways, village-style walkability, transit access, and quick downtown connections. Compare building age, fees, parking, storage, pet rules, and resale fit before booking showings.',
            'guidance' => 'Sunnyside condo buyers want Bow River pathways, village-style walkability, transit access, and quick downtown connections. Compare building age, fees, parking, storage, pet rules, and how similar units sell before booking showings.',
        ],
        'chinatown-condos' => [
            'label'    => 'Chinatown',
            'title'    => 'Chinatown Condos',
            'subtitle' => 'Search Chinatown condos and compare central location, building quality, fees, rules, and resale fit.',
            'intro'    => 'Chinatown is a central Calgary condo area offering downtown access, transit connections, and an urban lifestyle close to shops, restaurants, and the river. Before booking a showing, compare the building, fees, parking, storage, bylaws, and resale fit.',
            'guidance' => 'Chinatown condo buyers want central Calgary access, transit connections, and an urban lifestyle close to shops, restaurants, and the river. Compare the building, fees, parking, storage, bylaws, and resale fit before booking showings.',
        ],
        'crescent-heights-condos' => [
            'label'    => 'Crescent Heights',
            'title'    => 'Crescent Heights Condos',
            'subtitle' => 'Search Crescent Heights condos and compare skyline views, building quality, fees, rules, and resale fit.',
            'intro'    => 'Crescent Heights offers inner-city Calgary condo options with skyline views, river pathways, transit access, and established neighbourhood character. Compare building age, fees, parking, storage, pet rules, and long-term resale before booking showings.',
            'guidance' => 'Crescent Heights condo buyers want inner-city options with skyline views, river pathways, transit access, and established neighbourhood character. Compare building age, fees, parking, storage, pet rules, and long-term resale before booking showings.',
        ],
        'lower-mount-royal-condos' => [
            'label'    => 'Lower Mount Royal',
            'title'    => 'Lower Mount Royal Condos',
            'subtitle' => 'Search Lower Mount Royal condos and compare 17th Avenue access, building quality, fees, rules, and resale fit.',
            'intro'    => 'Lower Mount Royal is a sought-after inner-city Calgary condo area near 17th Avenue, restaurants, shops, and downtown access. Before booking a showing, compare the building, fees, parking, storage, bylaws, pet rules, and resale strength.',
            'guidance' => 'Lower Mount Royal condo buyers want proximity to 17th Avenue, restaurants, shops, and downtown. Before booking a showing, compare the building, fees, parking, storage, bylaws, pet rules, and resale strength in each specific building.',
        ],
        'cliff-bungalow-condos' => [
            'label'    => 'Cliff Bungalow',
            'title'    => 'Cliff Bungalow Condos',
            'subtitle' => 'Search Cliff Bungalow condos and compare quiet inner-city living, building quality, fees, rules, and resale fit.',
            'intro'    => 'Cliff Bungalow is a quiet inner-city Calgary condo area near 4th Street, Mission restaurants, river pathways, and downtown access. Compare building age, fees, parking, storage, pet rules, and resale fit before booking showings.',
            'guidance' => 'Cliff Bungalow condo buyers want a quiet inner-city area near 4th Street, Mission restaurants, river pathways, and downtown access. Compare building age, fees, parking, storage, pet rules, and resale fit before booking showings.',
        ],
        'bankview-condos' => [
            'label'    => 'Bankview',
            'title'    => 'Bankview Condos',
            'subtitle' => 'Search Bankview condos and compare city views, inner-city access, building quality, fees, rules, and resale fit.',
            'intro'    => 'Bankview offers inner-city Calgary condo options with city views, 17th Avenue access, and a residential neighbourhood feel. Before booking a showing, compare the building, fees, parking, storage, bylaws, pet rules, and long-term resale fit.',
            'guidance' => 'Bankview condo buyers want inner-city options with city views, 17th Avenue access, and a residential neighbourhood feel. Before booking a showing, compare the building, fees, parking, storage, bylaws, pet rules, and long-term resale fit.',
        ],
        'erlton-condos' => [
            'label'    => 'Erlton',
            'title'    => 'Erlton Condos',
            'subtitle' => 'Search Erlton condos and compare Elbow River access, Stampede proximity, building quality, fees, rules, and resale fit.',
            'intro'    => 'Erlton is a central Calgary condo area offering Stampede access, the Elbow River pathway, C-Train connections, and inner-city convenience. Compare the building, fees, parking, storage, pet rules, and resale fit before booking showings.',
            'guidance' => 'Erlton condo buyers want central Calgary access, Stampede proximity, the Elbow River pathway, and C-Train connections. Compare the building, fees, parking, storage, pet rules, and resale fit before booking showings.',
        ],
        'seton-condos' => [
            'label'    => 'Seton',
            'title'    => 'Seton Condos',
            'subtitle' => 'Search Seton condos and compare newer southeast buildings, amenities, and ownership fit.',
            'intro'    => 'Seton offers newer southeast Calgary condo options near health services, retail, and recreation hubs. Before booking a showing, compare fee inclusions, parking configuration, storage, pet and rental rules, reserve planning, and resale positioning by building.',
            'guidance' => 'Seton condo buyers usually compare newer southeast inventory near health, retail, and recreation hubs. To avoid surprises, review fee inclusions, parking configuration, storage, pet and rental rules, reserve planning, and resale positioning by building.',
        ],
        'mahogany-condos' => [
            'label'    => 'Mahogany',
            'title'    => 'Mahogany Condos',
            'subtitle' => 'Search Mahogany condos and compare lake-community lifestyle, building quality, and resale path.',
            'intro'    => 'Mahogany offers lake-community condo options with a distinct lifestyle, established amenities, and southeast Calgary convenience. Compare building age, parking, storage, fees, bylaws, reserve fund health, and resale fit before booking showings.',
            'guidance' => 'Mahogany condo options can vary by building age, amenities, parking, storage, and fee structure. Compare bylaws, reserve fund health, pet and rental rules, and resale demand so the unit also fits your long-term ownership plan.',
        ],
        'calgary-luxury-condos' => [
            'label'    => 'Calgary Luxury Condos',
            'title'    => 'Calgary Luxury Condos',
            'subtitle' => 'Search higher-end Calgary condos and compare the building, services, views, privacy, amenities, and resale path.',
            'intro'    => 'Luxury condo buying in Calgary is not just about price. Compare construction quality, concierge services, elevator access, parking count, storage, view protection, amenities, privacy, fee inclusions, building reputation, and the depth of the future buyer pool.',
            'guidance' => 'Luxury condo buying is not just price. Compare construction quality, concierge or security, elevator access, parking count, storage, view protection, amenities, privacy, fee inclusions, building reputation, and the depth of the future buyer pool.',
        ],
        'top-school-catchments-2' => [
            'label'             => 'Top School Catchments',
            'title'             => 'Top School Catchments',
            'subtitle'          => 'Search Calgary condos within top public, separate, and specialized school catchment areas. Compare communities, commute times, amenities, and resale value before choosing your next home.',
            'intro'             => 'Calgary school catchments can have a major impact on lifestyle, long-term resale value, and buyer demand. Browse condo listings located near sought-after school boundaries while comparing neighbourhood amenities, transit access, parks, recreation, and everyday convenience.',
            'guidance'          => 'School catchments and enrollment policies can change. Always verify school boundaries directly with the Calgary Board of Education or Calgary Catholic School District before making a purchase decision.',
            'hero_eyebrow'      => 'Calgary Condo Lifestyle Search',
            'guidance_eyebrow'  => 'School Catchment Buyer Guidance',
            'primary_cta_text'  => 'Search School Catchment Condos',
            'idx_heading'       => 'Live Top School Catchment Condo Listings',
            'idx_copy'          => 'Browse current Calgary condo listings near top school catchment areas, then compare commute, amenities, ownership costs, and resale fit before booking showings.',
            'dark_premium_hero' => true,
        ],
        'pet-friendly-calgary-condos' => [
            'label'             => 'Parks & Pet-Friendly Areas',
            'title'             => 'Parks & Pet-Friendly Areas',
            'subtitle'          => 'Search Calgary pet-friendly condos near off-leash parks, pathways, river walks, and green spaces while comparing building rules, amenities, and lifestyle.',
            'intro'             => 'Discover Calgary condos close to off-leash parks, pathways, dog-friendly walking areas, and outdoor recreation. Compare communities with convenient access to river pathways, green spaces, parks, transit, shops, and daily amenities while reviewing condo rules, pet restrictions, parking, storage, and ownership costs.',
            'guidance'          => 'Every condominium has its own pet bylaws, including rules around pet size, number of pets, and permitted pet types. Always review the condominium bylaws and board regulations before purchasing.',
            'hero_eyebrow'      => 'Calgary Condo Lifestyle Search',
            'guidance_eyebrow'  => 'Pet-Friendly Buyer Guidance',
            'primary_cta_text'  => 'Search Pet-Friendly Condos',
            'idx_heading'       => 'Live Parks & Pet-Friendly Condo Listings',
            'idx_copy'          => 'Browse current Calgary pet-friendly condo listings near parks and pathways, then compare bylaws, amenities, ownership costs, and long-term resale fit before booking showings.',
            'dark_premium_hero' => true,
        ],
    ];

    private const REGIONAL_MRP_SHORTCODES = [
        'all-calgary-condos'       => '[mrp account_id=67196 listing_def=search-1439659 context=recip perm_attr=tmpl~v2][/mrp]',
        'southeast-calgary-condos' => '[mrp account_id=67196 listing_def=search-1439652 context=recip perm_attr=tmpl~v2][/mrp]',
        'southwest-calgary-condos' => '[mrp account_id=67196 listing_def=search-1439299 context=recip perm_attr=tmpl~v2 ][/mrp]',
        'northwest-calgary-condos' => '[mrp account_id=67196 listing_def=search-1439583 context=recip perm_attr=tmpl~v2 ][/mrp]',
        'northeast-calgary-condos' => '[mrp account_id=67196 listing_def=search-1439655 context=recip perm_attr=tmpl~v2][/mrp]',
        'downtown-calgary-condos'  => '[mrp account_id=67196 listing_def=search-1440045 context=recip perm_attr=tmpl~v2][/mrp]',
        'downtown-condos'          => '[mrp account_id=67196 listing_def=search-1440045 context=recip perm_attr=tmpl~v2][/mrp]',
        'beltline-condos'          => '[mrp account_id=67196 listing_def=search-1439738 context=recip perm_attr=tmpl~v2][/mrp]',
    ];

    /**
     * Slugs that the PHP class always renders, overriding any matching WordPress page.
     * Only includes slugs that have verified IDX shortcodes defined above.
     */
    private const AREA_PAGE_OVERRIDES = [
        'all-calgary-condos',
        'southeast-calgary-condos',
        'southwest-calgary-condos',
        'northwest-calgary-condos',
        'northeast-calgary-condos',
        'downtown-calgary-condos',
        'downtown-condos',
        'beltline-condos',
        'east-village-condos',
        'mission-condos',
        'eau-claire-condos',
        'hillhurst-condos',
        'bridgeland-riverside-condos',
        'top-school-catchments-2',
        'pet-friendly-calgary-condos',
    ];

    /**
     * Area pages that should keep the existing myRealPage shortcode configured in page content.
     */
    private const PAGE_CONFIGURED_MRP_SHORTCODE_SLUGS = [
        'east-village-condos',
        'mission-condos',
        'eau-claire-condos',
        'hillhurst-condos',
        'bridgeland-riverside-condos',
        'top-school-catchments-2',
        'pet-friendly-calgary-condos',
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

        if (!in_array($slug, self::AREA_PAGE_OVERRIDES, true) && (is_page() || is_singular('page'))) {
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
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/contact/" target="_self" data-ccl-lead-open data-requested-category="Building Alerts" data-lead-source="Regional Condo Page" data-clicked-cta="Get Building Alerts">Get Building Alerts</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:heading -->
<h2 class="wp-block-heading">{$listings_heading}</h2>
<!-- /wp:heading -->

<!-- wp:shortcode -->

<!-- /wp:shortcode -->
HTML;
    }

    private function layout(array $area, string $slug): string {
        $raw_label = (string) $area['label'];
        $label = esc_html($raw_label);
        $title = esc_html((string) $area['title']);
        $subtitle = esc_html((string) $area['subtitle']);
        $hero_eyebrow = esc_html((string) ($area['hero_eyebrow'] ?? 'Calgary Condo Search'));
        $guidance_eyebrow = esc_html((string) ($area['guidance_eyebrow'] ?? ($raw_label . ' Buyer Guidance')));
        $primary_cta_text = esc_html((string) ($area['primary_cta_text'] ?? ('View ' . $raw_label . ' Condos')));
        $hero_theme_class = !empty($area['dark_premium_hero']) ? ' ccl-dark-luxury-section' : ' ccl-section--white';
        $guidance = esc_html((string) ($area['guidance'] ?? 'Use the live IDX search, then compare the building details that influence long-term ownership and resale.'));
        $idx_section = 'northwest-calgary-condos' === $slug
            ? $this->northwest_manual_idx_feed()
            : $this->regional_idx_section($slug, $area, $raw_label);
        $lead_modal = do_shortcode('[ccl_lead_modal title="Get a ' . $label . ' condo shortlist" subtitle="Send your preferred buildings, budget, parking needs, pet needs, and timing. We will help narrow the right ' . $label . ' options without inventing listing data."]');
        $intro_content = $this->area_intro_blocks($area, $slug);

        return <<<HTML
<main class="ccl-inner-page-shell ccl-area-page ccl-area-page--{$slug}">
    <section class="ccl-section ccl-compare-hero ccl-area-hero{$hero_theme_class}">
        <div class="ccl-wrap ccl-compare-hero__inner">
            <div>
                <p class="ccl-eyebrow">{$hero_eyebrow}</p>
                <h1>{$title}</h1>
                <p>{$subtitle}</p>
            </div>
            <div class="ccl-compare-hero__actions">
                <a href="#idx-search" target="_self" class="ccl-btn ccl-btn--primary ccl-region-cta-button">{$primary_cta_text}</a>
                <a href="/contact/" target="_self" class="ccl-btn ccl-btn--dark ccl-region-alert-button ccl-lead-trigger" data-ccl-lead-open data-requested-category="Building Alerts" data-lead-source="Regional Condo Page" data-clicked-cta="Get Building Alerts">Get Building Alerts</a>
            </div>
        </div>
    </section>

    {$intro_content}

    <section class="ccl-section ccl-area-guidance">
        <div class="ccl-wrap ccl-portal-intro__grid">
            <div>
                <p class="ccl-eyebrow">{$guidance_eyebrow}</p>
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

    private function area_intro_blocks(array $area, string $slug): string {
        $intro = (string) ($area['intro'] ?? '');
        if ('' === $intro) {
            return '';
        }
        $intro      = esc_html($intro);
        $raw_label  = (string) $area['label'];
        $label      = esc_html($raw_label);
        $lead_label = esc_html((string) ($area['lead_form_label'] ?? ('Get ' . $raw_label . ' Condo Alerts — Be the first to know about new listings, price changes, and condos that match your criteria.')));
        $id_slug  = sanitize_html_class($slug);
        $nonce    = wp_nonce_field('ccl_alert_form', 'ccl_nonce', true, false);
        $scheme   = is_ssl() ? 'https://' : 'http://';
        $host     = isset($_SERVER['HTTP_HOST']) ? sanitize_text_field(wp_unslash($_SERVER['HTTP_HOST'])) : '';
        $uri      = isset($_SERVER['REQUEST_URI']) ? sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI'])) : '/';
        $action   = esc_url(remove_query_arg('ccl_status', $scheme . $host . $uri) . '#condo-alerts');

        return <<<HTML
<section class="ccl-section ccl-beltline-intro">
    <div class="ccl-wrap">
        <p>{$intro}</p>
    </div>
</section>
<section id="condo-alerts" class="ccl-section ccl-beltline-lead-form">
    <div class="ccl-wrap">
        <p class="ccl-form__label">{$lead_label}</p>
        <form class="ccl-form" method="post" action="{$action}">
            {$nonce}
            <input type="hidden" name="ccl_action" value="alert_form">
            <input type="hidden" name="ccl_area" value="{$label}">
            <label for="ccl-{$id_slug}-name">Your Name <span aria-hidden="true">*</span>
                <input id="ccl-{$id_slug}-name" type="text" name="ccl_name" autocomplete="name" required>
            </label>
            <label for="ccl-{$id_slug}-email">Email Address <span aria-hidden="true">*</span>
                <input id="ccl-{$id_slug}-email" type="email" name="ccl_email" autocomplete="email" required>
            </label>
            <label for="ccl-{$id_slug}-phone">Phone Number
                <input id="ccl-{$id_slug}-phone" type="tel" name="ccl_phone" autocomplete="tel">
            </label>
            <label class="ccl-hp" for="ccl-{$id_slug}-website">Website
                <input id="ccl-{$id_slug}-website" type="text" name="ccl_website" tabindex="-1" autocomplete="off">
            </label>
            <button type="submit" class="ccl-btn ccl-btn--primary">Send Me {$label} Alerts</button>
            <p class="ccl-form__note">No spam. Calgary condo updates only.</p>
        </form>
    </div>
</section>
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

    private function regional_idx_section(string $slug, array $area, string $raw_label): string {
        $shortcode = $this->regional_mrp_shortcode($slug);
        $label = esc_html($raw_label);
        $idx_heading = esc_html((string) ($area['idx_heading'] ?? ('Live ' . $raw_label . ' Condo Listings')));
        $idx_copy = esc_html((string) ($area['idx_copy'] ?? ('Browse current ' . $raw_label . ' condo listings below, then compare the building, fees, rules, parking, storage, and resale fit before booking showings.')));
        $feed = '' !== $shortcode
            ? do_shortcode($shortcode)
            : '<p class="ccl-region-idx-placeholder">' . esc_html(sprintf(__('Live %s condo listings will appear here once the saved myRealPage search is connected.', 'calgary-condo-leads'), $label)) . '</p>';

        return <<<HTML
<section id="idx-search" class="ccl-idx-premium-section mr-custom-wrapper ccl-section ccl-section--white ccl-region-idx-section" aria-labelledby="ccl-idx-title">
    <div class="ccl-wrap">
        <h2 id="ccl-idx-title" class="ccl-idx-title">{$idx_heading}</h2>
        <p class="ccl-idx-copy">{$idx_copy}</p>
        <div class="ccl-region-idx-feed">
            {$feed}
        </div>
    </div>
</section>
HTML;
    }

    private function regional_mrp_shortcode(string $slug): string {
        $configured = trim((string) (self::REGIONAL_MRP_SHORTCODES[$slug] ?? ''));
        if ('' !== $configured) {
            return $configured;
        }

        if (!in_array($slug, self::PAGE_CONFIGURED_MRP_SHORTCODE_SLUGS, true)) {
            return '';
        }

        $existing_page = get_page_by_path($slug, OBJECT, 'page');
        if (!$existing_page instanceof WP_Post) {
            return '';
        }

        $content = (string) $existing_page->post_content;
        $pattern = '/' . get_shortcode_regex(['mrp']) . '/s';
        if (preg_match($pattern, $content, $matches)) {
            return trim((string) ($matches[0] ?? ''));
        }

        return '';
    }

}

new Calgary_Condo_Area_Pages();
