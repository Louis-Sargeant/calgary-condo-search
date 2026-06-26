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
        $search_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.35-4.35"/></svg>';
        $value_icon  = '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 9.5 12 3l9 6.5V20a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.5Z"/><path d="M9 21V13h6v8"/><path d="M12 10v1m0 0c-.83 0-1.5.45-1.5 1s.67 1 1.5 1 1.5.45 1.5 1-.67 1-1.5 1M12 15v1"/></svg>';
        $school_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12.5V17c0 1.66 2.69 3 6 3s6-1.34 6-3v-4.5"/></svg>';
        $park_icon   = '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22v-5"/><path d="M5 17l7-10 7 10H5z"/></svg>';
        $cards = [
            ['title' => 'I Want to Browse Condos', 'copy' => 'Start with the approved live Calgary condo search, then narrow by area, building, budget, and showing fit.', 'micro' => 'Live listings from Calgary\'s approved IDX feed, updated daily.', 'button' => 'Search Calgary Condos', 'url' => '/all-calgary-condos/', 'icon' => $search_icon],
            ['title' => 'I Own a Condo', 'copy' => 'Request a building-aware value report that accounts for competition, fees, condition, and buyer demand.', 'micro' => 'Free building-aware report. No obligation, no spam.', 'button' => 'Get My Condo Value Report', 'category' => 'Condo Value Report', 'icon' => $value_icon],
            ['title' => 'Top School Catchments', 'copy' => 'Filter active condo listings dynamically mapped to Calgary&#8217;s top-ranked designated public and separate school boundaries.', 'micro' => 'Match your condo search to Calgary\'s best school zones.', 'button' => 'Explore School Catchments', 'category' => 'Condo Alerts', 'icon' => $school_icon],
            ['title' => 'Parks &amp; Pet-Friendly Areas', 'copy' => 'Locate premium buildings within immediate walking distance to inner-city off-leash dog runs, pathways, and green spaces.', 'micro' => 'Find off-leash parks and pathways walking distance from your condo.', 'button' => 'Explore Pet-Friendly Areas', 'category' => 'Building Risk Report', 'icon' => $park_icon],
        ];
        ob_start(); ?>
        <section class="ccl-section ccl-home-intent" aria-labelledby="ccl-home-intent-title">
        <div class="ccl-wrap">
        <div class="ccl-home-section-heading"><p class="ccl-eyebrow">Choose your path</p><h2 id="ccl-home-intent-title">One clear next step for every condo visitor.</h2><p>Browse live listings, set alerts, get a value report, or review a building risk before you move forward.</p></div>
        <div class="ccl-home-intent__grid">
        <?php foreach ($cards as $card) : ?><article class="ccl-home-card ccl-home-intent-card"><?php if (!empty($card['icon'])) : ?><div class="ccl-intent-card-icon"><?php echo $card['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div><?php endif; ?><h3><?php echo esc_html($card['title']); ?></h3><p><?php echo esc_html($card['copy']); ?></p><?php if (!empty($card['micro'])) : ?><p class="ccl-home-intent-card__micro"><?php echo esc_html($card['micro']); ?></p><?php endif; ?><?php if (isset($card['url'])) : ?><a class="ccl-home-cta ccl-home-cta--gold" href="<?php echo esc_url(home_url($card['url'])); ?>" target="_self"><?php echo esc_html($card['button']); ?></a><?php else : ?><button type="button" class="ccl-home-cta ccl-home-cta--gold" data-ccl-lead-open data-lead-source="Homepage Buyer Intent" data-requested-category="<?php echo esc_attr($card['category']); ?>" data-clicked-cta="<?php echo esc_attr($card['button']); ?>"><?php echo esc_html($card['button']); ?></button><?php endif; ?></article><?php endforeach; ?>
        </div>
        </div></section><?php return (string) ob_get_clean();
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
        $phone_tel     = defined('CCL_CONTACT_PHONE_TEL') ? CCL_CONTACT_PHONE_TEL : '+14038006996';
        $hero_success  = isset($_GET['ccl_status']) && 'success' === sanitize_key(wp_unslash($_GET['ccl_status']));
        ob_start(); ?>
        <div class="ccl-page-shell ccl-premium-homepage-shell ccl-home-tight ccl-home-search-first" data-ccl-condo-home>
            <section id="clean-calgary-hero" class="ccl-home-hero" aria-labelledby="clean-calgary-hero-title">
                <div class="ccl-home-hero__overlay"></div>
                <div class="ccl-home-hero__content">
                    <p class="ccl-eyebrow">Calgary Condo Search</p>
                    <h1 id="clean-calgary-hero-title">Find the Right Calgary Condo Before You Book a Showing</h1>
                    <p class="ccl-home-hero__subtitle">Search active Calgary condo listings with building intelligence. Compare condo fees, bylaws, reserve fund health, parking, storage, and resale fit before booking a showing.</p>
                    <a class="ccl-home-cta ccl-home-cta--gold ccl-home-hero__primary-cta" href="<?php echo esc_url(home_url('/all-calgary-condos/')); ?>" target="_self">Search Calgary Condos</a>
                    <div class="ccl-hero-lead-panel" id="condo-alerts" aria-label="Get Calgary Condo Alerts">
                        <?php if ($hero_success) : ?>
                            <p class="ccl-hero-lead-panel__success" role="status"><?php esc_html_e('Thanks — your Calgary condo alert request was received.', 'calgary-condo-leads'); ?></p>
                        <?php else : ?>
                        <p class="ccl-hero-lead-panel__hook"><?php esc_html_e('Get Calgary Condo Alerts — New listings, price drops & building intel', 'calgary-condo-leads'); ?></p>
                        <form class="ccl-hero-lead-panel__form" method="post" action="">
                            <?php wp_nonce_field('ccl_alert_form', 'ccl_nonce'); ?>
                            <input type="hidden" name="ccl_action" value="alert_form">
                            <input type="hidden" name="ccl_lead_source" value="Homepage Hero Lead Row">
                            <input type="hidden" name="ccl_requested_category" value="Condo Alerts">
                            <div class="ccl-hero-lead-panel__fields">
                                <input type="text" name="ccl_name" placeholder="<?php esc_attr_e('Your Name', 'calgary-condo-leads'); ?>" autocomplete="name" required aria-label="<?php esc_attr_e('Your Name', 'calgary-condo-leads'); ?>">
                                <input type="email" name="ccl_email" placeholder="<?php esc_attr_e('Email Address', 'calgary-condo-leads'); ?>" autocomplete="email" required aria-label="<?php esc_attr_e('Email Address', 'calgary-condo-leads'); ?>">
                                <input type="tel" name="ccl_phone" placeholder="<?php esc_attr_e('Phone Number', 'calgary-condo-leads'); ?>" autocomplete="tel" aria-label="<?php esc_attr_e('Phone Number', 'calgary-condo-leads'); ?>">
                                <button type="submit" class="ccl-home-cta ccl-home-cta--gold ccl-hero-lead-panel__submit"><?php esc_html_e('Send Me Condo Alerts', 'calgary-condo-leads'); ?></button>
                            </div>
                            <label class="ccl-hp" for="ccl-hero-lead-website"><?php esc_html_e('Website', 'calgary-condo-leads'); ?><input id="ccl-hero-lead-website" type="text" name="ccl_website" tabindex="-1" autocomplete="off"></label>
                            <p class="ccl-hero-lead-panel__trust"><?php esc_html_e('No spam. Calgary condo updates only.', 'calgary-condo-leads'); ?></p>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
            <div class="ccl-cro-trust-strip" aria-label="<?php esc_attr_e('Calgary condo trust signals', 'calgary-condo-leads'); ?>">
                <span>Updated Daily</span><span aria-hidden="true">·</span><span>Local Calgary Expertise</span><span aria-hidden="true">·</span><span>Building-Aware Search</span>
            </div>
            <?php echo $this->render_buyer_intent(); ?>
            <?php echo $this->render_area_first(); ?>
            <?php echo $this->render_building_first(); ?>
            <?php echo $this->render_live_idx(); ?>
            <?php echo $this->render_trust_risk(); ?>
            <!-- Mobile sticky bar: only visible on small screens, fixed at bottom -->
            <div class="ccl-mobile-sticky-bar" aria-label="<?php esc_attr_e('Quick Calgary condo actions', 'calgary-condo-leads'); ?>">
                <a class="ccl-mobile-sticky-bar__btn ccl-mobile-sticky-bar__btn--search" href="<?php echo esc_url(home_url('/all-calgary-condos/')); ?>">Search Condos</a>
                <a class="ccl-mobile-sticky-bar__btn ccl-mobile-sticky-bar__btn--call" href="tel:<?php echo esc_attr($phone_tel); ?>">Call Calgary Direct</a>
            </div>
        </div>
        <?php return (string) ob_get_clean();
    }
}

new Calgary_Condo_Homepage();
