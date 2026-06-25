<?php
if (!defined('ABSPATH')) {
    exit;
}

final class Calgary_Condo_Homepage {
    private const AREA_ROUTES = [
        'southeast' => '/southeast-calgary-condos/',
        'southwest' => '/southwest-calgary-condos/',
        'northwest' => '/northwest-calgary-condos/',
        'northeast' => '/northeast-calgary-condos/',
        'downtown' => '/downtown-calgary-condos/',
        'beltline' => '/beltline-condos/',
    ];

    public function __construct() {
        add_shortcode('ccl_homepage_tight', [$this, 'render']);
        add_action('template_redirect', [$this, 'redirect_legacy_query_routes'], 1);
    }

    public function redirect_legacy_query_routes(): void {
        if (is_admin() || !is_page('calgary-condos')) {
            return;
        }

        $area = isset($_GET['ccl_area']) ? sanitize_key((string) wp_unslash($_GET['ccl_area'])) : '';
        $filter = isset($_GET['ccl_filter']) ? sanitize_key((string) wp_unslash($_GET['ccl_filter'])) : '';

        if (isset(self::AREA_ROUTES[$area])) {
            wp_safe_redirect(home_url(self::AREA_ROUTES[$area]), 301);
            exit;
        }

        if ('under-400k' === $filter) {
            wp_safe_redirect(home_url('/condos-under-400k/'), 301);
            exit;
        }

        if ('price-drops' === $filter || 'price-reduced' === $filter) {
            wp_safe_redirect(home_url('/price-reduced-condos/'), 301);
            exit;
        }
    }

    /** @return array<int,array<string,string>> */
    private function area_cards(): array {
        return [
            ['name' => 'Beltline', 'url' => '/beltline-condos/', 'copy' => 'High-rise choice, restaurants, nightlife, parks, and quick downtown access.'],
            ['name' => 'Downtown Core', 'url' => '/downtown-calgary-condos/', 'copy' => 'Core towers near offices, transit, river pathways, and central services.'],
            ['name' => 'Eau Claire', 'url' => '/eau-claire-condos/', 'copy' => 'Premium river-adjacent condos with downtown convenience and luxury positioning.'],
            ['name' => 'Mission', 'url' => '/mission-condos/', 'copy' => 'Walkable inner-city living near 4th Street, restaurants, and the river.'],
            ['name' => 'East Village', 'url' => '/east-village-condos/', 'copy' => 'Modern urban towers near the library, river pathways, and downtown east amenities.'],
            ['name' => 'Kensington', 'url' => '/kensington-condos/', 'copy' => 'Boutique inner-city condo options around Sunnyside, Hillhurst, transit, and cafés.'],
            ['name' => 'Bridgeland', 'url' => '/bridgeland-condos/', 'copy' => 'Neighbourhood condo living with river access, local shops, and CTrain convenience.'],
            ['name' => 'Seton', 'url' => '/seton-condos/', 'copy' => 'Southeast condo options near health, retail, recreation, and newer amenities.'],
            ['name' => 'Mahogany', 'url' => '/mahogany-condos/', 'copy' => 'Lake-community condos with southeast lifestyle amenities and newer options.'],
        ];
    }

    /** @return array<int,array<string,string>> */
    private function building_cards(): array {
        return [
            ['name' => 'The Guardian', 'area' => 'Victoria Park / Beltline', 'type' => 'High-rise'],
            ['name' => 'Keynote Urban Village', 'area' => 'Beltline / Victoria Park', 'type' => 'High-rise'],
            ['name' => 'Arriva', 'area' => 'Victoria Park', 'type' => 'Luxury high-rise'],
            ['name' => 'Sasso', 'area' => 'Victoria Park', 'type' => 'High-rise'],
            ['name' => 'Vetro', 'area' => 'Victoria Park', 'type' => 'High-rise'],
            ['name' => 'Colours', 'area' => 'Beltline', 'type' => 'Concrete high-rise'],
            ['name' => 'Union Square', 'area' => 'Beltline', 'type' => 'Concrete high-rise'],
            ['name' => 'Avenue West End', 'area' => 'Downtown West End', 'type' => 'Luxury high-rise'],
            ['name' => 'Vogue', 'area' => 'Downtown West End', 'type' => 'High-rise'],
            ['name' => 'Princeton Grand', 'area' => 'Eau Claire', 'type' => 'Luxury low-rise'],
            ['name' => 'Churchill Estates', 'area' => 'Downtown Commercial Core', 'type' => 'Luxury tower'],
            ['name' => 'Evolution', 'area' => 'East Village', 'type' => 'High-rise'],
            ['name' => 'Verve', 'area' => 'East Village', 'type' => 'High-rise'],
            ['name' => 'Ink', 'area' => 'East Village', 'type' => 'Entry-level high-rise'],
            ['name' => 'Bridgeland Crossing', 'area' => 'Bridgeland', 'type' => 'Mid-rise'],
            ['name' => 'Radius', 'area' => 'Bridgeland', 'type' => 'Concrete mid-rise'],
        ];
    }

    private function render_buyer_intent(): string {
        $cards = [
            ['title' => 'I want to browse condos', 'copy' => 'Start with the approved live Calgary condo search, then narrow by area, building, budget, and showing fit.', 'button' => 'Search Calgary Condos', 'url' => '/all-calgary-condos/'],
            ['title' => 'I own a condo', 'copy' => 'Request a building-aware value report that accounts for competition, fees, condition, and buyer demand.', 'button' => 'Get My Condo Value Report', 'category' => 'Condo Value Report'],
            ['title' => '🎓 Top School Catchments', 'copy' => 'Filter active condo listings dynamically mapped to Calgary’s top-ranked designated public and separate school boundaries.', 'button' => 'Set Up Condo Alerts', 'category' => 'Condo Alerts'],
            ['title' => '🌳 Parks & Pet-Friendly Fields', 'copy' => 'Locate premium buildings within immediate walking distance to inner-city off-leash dog runs, pathways, and green spaces.', 'button' => 'Ask About Building Risk', 'category' => 'Building Risk Report'],
        ];
        ob_start(); ?>
        <section class="ccl-section ccl-home-intent" aria-labelledby="ccl-home-intent-title"><div class="ccl-wrap"><div class="ccl-home-section-heading"><p class="ccl-eyebrow">Choose your path</p><h2 id="ccl-home-intent-title">One clear next step for every condo visitor.</h2><p>Browse live listings, set alerts, get a value report, or review a building risk before you move forward.</p></div><div class="ccl-home-intent__grid">
        <?php foreach ($cards as $card) : ?><article class="ccl-home-card ccl-home-intent-card"><h3><?php echo esc_html($card['title']); ?></h3><p><?php echo esc_html($card['copy']); ?></p><?php if (isset($card['url'])) : ?><a class="ccl-home-cta ccl-home-cta--gold" href="<?php echo esc_url(home_url($card['url'])); ?>" target="_self"><?php echo esc_html($card['button']); ?></a><?php else : ?><button type="button" class="ccl-home-cta ccl-home-cta--gold" data-ccl-lead-open data-lead-source="Homepage Buyer Intent" data-requested-category="<?php echo esc_attr($card['category']); ?>" data-clicked-cta="<?php echo esc_attr($card['button']); ?>"><?php echo esc_html($card['button']); ?></button><?php endif; ?></article><?php endforeach; ?>
        </div></div></section><?php return (string) ob_get_clean();
    }

    private function render_area_first(): string { ob_start(); ?>
        <section class="ccl-section ccl-home-area-first" aria-labelledby="ccl-home-area-title"><div class="ccl-wrap"><div class="ccl-home-section-heading"><p class="ccl-eyebrow">Area-first search</p><h2 id="ccl-home-area-title">Choose your Calgary condo area first.</h2><p>Pick the lifestyle lane before comparing fees, bylaws, parking, storage, and resale fit.</p></div><div class="ccl-home-area-grid"><?php foreach ($this->area_cards() as $area) : ?><a class="ccl-home-card ccl-home-area-card" href="<?php echo esc_url(home_url($area['url'])); ?>" target="_self"><span>Calgary condo area</span><h3><?php echo esc_html($area['name']); ?></h3><p><?php echo esc_html($area['copy']); ?></p><strong>View area condos →</strong></a><?php endforeach; ?></div></div></section><?php return (string) ob_get_clean(); }

    private function render_building_first(): string { ob_start(); ?>
        <section class="ccl-section ccl-home-building-first" aria-labelledby="ccl-home-building-title"><div class="ccl-wrap"><div class="ccl-home-section-heading"><p class="ccl-eyebrow">Building-first search</p><h2 id="ccl-home-building-title">Search by building, not just price.</h2><p>These profiles help buyers ask better questions. When a live page is not available, request building-specific guidance instead of guessing.</p></div><div class="ccl-home-building-grid"><?php foreach ($this->building_cards() as $building) : ?><article class="ccl-home-card ccl-home-building-card"><span><?php echo esc_html($building['area']); ?></span><h3><?php echo esc_html($building['name']); ?></h3><p><?php echo esc_html($building['type']); ?> buyers should compare fees, documents, parking, storage, bylaws, insurance, management, and resale fit.</p><button type="button" class="ccl-home-cta ccl-home-cta--glass" data-ccl-lead-open data-requested-category="Building Risk Report" data-lead-source="Building Directory Card" data-clicked-cta="<?php echo esc_attr('Building profile request: ' . $building['name']); ?>">Ask About This Building</button></article><?php endforeach; ?></div></div></section><?php return (string) ob_get_clean(); }

    private function render_live_idx(): string {
        $idx = '[mrp account_id=67196 listing_def=search-1439357 context=recip perm_attr=tmpl~v2 ][/mrp]';
        ob_start(); ?>
        <section id="idx-search" class="ccl-section ccl-home-live-idx" aria-labelledby="ccl-home-idx-title"><div class="ccl-wrap"><div class="ccl-home-idx-frame"><div class="ccl-home-section-heading"><p class="ccl-eyebrow">Live IDX</p><h2 id="ccl-home-idx-title">Live Calgary Condo Listings</h2><p>Browse current listings after choosing your area, building, or alert path.</p></div><div class="ccl-home-idx-frame__embed"><?php echo do_shortcode($idx); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div></div></div></section><?php return (string) ob_get_clean();
    }

    private function render_trust_risk(): string { ob_start(); ?>
        <section class="ccl-section ccl-home-trust-risk" aria-labelledby="ccl-home-risk-title"><div class="ccl-wrap"><div class="ccl-home-section-heading"><p class="ccl-eyebrow">Trust, lifestyle, and risk checks</p><h2 id="ccl-home-risk-title">Buy the building with your eyes open.</h2><p>Use condo due diligence, school context, and community guidance to shortlist stronger Calgary condo options.</p></div><div class="ccl-home-trust-grid"><article class="ccl-home-card"><h3>Building-risk guidance</h3><p>Review reserve fund signals, bylaws, insurance, fee pressure, management, special-assessment risk, and resale fit before booking every showing.</p><button type="button" class="ccl-home-cta ccl-home-cta--gold" data-ccl-lead-open data-requested-category="Building Risk Report" data-lead-source="Homepage Trust Section" data-clicked-cta="Request Building Risk Guidance">Request Building Risk Guidance</button></article><article class="ccl-home-card"><h3>School and lifestyle finder</h3><p>Match your condo search to commute, school-area questions, parks, CTrain access, river pathways, groceries, and the way you actually live.</p><button type="button" class="ccl-home-cta ccl-home-cta--glass" data-ccl-lead-open data-requested-category="General Calgary Condo Help" data-lead-source="Homepage Trust Section" data-clicked-cta="Ask About Schools and Lifestyle">Ask About Schools and Lifestyle</button></article><article class="ccl-home-card"><h3>Community guidance</h3><p>Compare Beltline, Downtown Core, Eau Claire, Mission, East Village, Kensington, Bridgeland, Seton, Mahogany, and other Calgary condo markets.</p><a class="ccl-home-cta ccl-home-cta--glass" href="<?php echo esc_url(home_url('/calgary-communities/')); ?>" target="_self">Explore Community Guidance</a></article></div></div></section><?php return (string) ob_get_clean(); }

    public function render(array $atts = [], ?string $content = null): string {
        $phone_display = defined('CCL_CONTACT_PHONE_DISPLAY') ? CCL_CONTACT_PHONE_DISPLAY : '+1 (403) 800-6996';
        ob_start(); ?>
        <div class="ccl-page-shell ccl-premium-homepage-shell ccl-home-tight ccl-home-search-first" data-ccl-condo-home>
            <section id="clean-calgary-hero" class="ccl-home-hero" aria-labelledby="clean-calgary-hero-title">
                <div class="ccl-home-hero__overlay"></div><div class="ccl-home-hero__content"><p class="ccl-eyebrow">Calgary Condo Search</p><h1 id="clean-calgary-hero-title">Calgary Condos—<span>Compared by Building First.</span></h1><p class="ccl-home-hero__subtitle">Search active Calgary condo listings with a cleaner buyer path. Start with an area, building, or alert, then compare condo fees, bylaws, reserve fund signals, parking, storage, and resale fit before booking showings.</p><form action="<?php echo esc_url(home_url('/all-calgary-condos/')); ?>" method="get" target="_self" class="ccl-home-search-card ccl-keyword-search-form" role="search" aria-label="Calgary condo keyword search"><label class="screen-reader-text" for="ccl-hero-keyword-search">Search Calgary condos, buildings, or areas</label><input type="search" id="ccl-hero-keyword-search" name="keyword" class="ccl-home-search-card__input ccl-keyword-search-input" placeholder="Search Calgary condos, buildings, or areas" autocomplete="off" autocapitalize="none" spellcheck="false"><button type="submit" class="ccl-home-cta ccl-home-cta--gold ccl-home-search-card__button ccl-keyword-search-submit">Search Calgary Condos</button></form><div class="ccl-home-quick-actions" aria-label="Popular Calgary condo actions"><a class="ccl-home-cta ccl-home-cta--gold" href="<?php echo esc_url(home_url('/all-calgary-condos/')); ?>" target="_self">All Calgary Condos</a><button type="button" class="ccl-home-cta ccl-home-cta--gold" data-ccl-lead-open data-requested-category="Condo Alerts" data-lead-source="Homepage Hero Quick Action" data-clicked-cta="Building Alerts">Top School Catchments</button><a class="ccl-home-cta ccl-home-cta--glass" href="<?php echo esc_url(home_url('/calgary-condo-buildings/')); ?>" target="_self">Browse Buildings</a><a class="ccl-home-cta ccl-home-cta--glass" href="<?php echo esc_url(home_url('/condos-under-400k/')); ?>" target="_self">Parks &amp; Pet-Friendly</a><a class="ccl-home-cta ccl-home-cta--glass" href="<?php echo esc_url(home_url('/price-reduced-condos/')); ?>" target="_self">Price Reduced</a></div><p class="ccl-home-hero__phone">Call Calgary Direct: <?php echo esc_html($phone_display); ?></p></div>
            </section>
            <?php echo $this->render_buyer_intent(); ?>
            <?php echo $this->render_area_first(); ?>
            <?php echo $this->render_building_first(); ?>
            <?php echo $this->render_live_idx(); ?>
            <?php echo $this->render_trust_risk(); ?>
        </div>
        <?php return (string) ob_get_clean();
    }
}

new Calgary_Condo_Homepage();
