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
        'downtown' => '/downtown-core-condos/',
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
            ['name' => 'Beltline', 'url' => '/beltline-condos/', 'title_url' => '/calgary-condo-buildings/beltline/', 'copy' => 'High-rise choice, restaurants, nightlife, parks, and quick downtown access.', 'filters' => 'downtown,inner-city', 'photo' => 'https://images.unsplash.com/photo-1480714378408-67cf0d13bc1b?auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Downtown Core', 'url' => '/downtown-condos/', 'title_url' => '/calgary-condo-buildings/downtown-core/', 'copy' => 'Core towers near offices, transit, river pathways, and central services.', 'filters' => 'downtown,inner-city', 'photo' => 'https://images.unsplash.com/photo-1486325212027-8081e485255e?auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Eau Claire', 'url' => '/eau-claire-condos/', 'title_url' => '/calgary-condo-buildings/eau-claire/', 'copy' => 'Premium river-adjacent condos with downtown convenience and luxury positioning.', 'filters' => 'downtown,inner-city', 'photo' => 'https://images.unsplash.com/photo-1563213126-a4273aed2016?auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Mission', 'url' => '/mission-condos/', 'title_url' => '/calgary-condo-buildings/mission/', 'copy' => 'Walkable inner-city living near 4th Street, restaurants, and the river.', 'filters' => 'inner-city,sw', 'photo' => 'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?auto=format&fit=crop&w=800&q=80'],
            ['name' => 'East Village', 'url' => '/east-village-condos/', 'title_url' => '/calgary-condo-buildings/east-village/', 'copy' => 'Modern urban towers near the library, river pathways, and downtown east amenities.', 'filters' => 'downtown,inner-city,se', 'photo' => 'https://images.unsplash.com/photo-1460317442991-0ec209397118?auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Hillhurst', 'url' => '/hillhurst-condos/', 'title_url' => '/hillhurst-condos/', 'copy' => 'Northwest inner-city condos close to Kensington Village, SAIT, transit, river pathways, and downtown access.', 'filters' => 'inner-city,nw', 'photo' => 'https://images.unsplash.com/photo-1569880153113-76e33fc52d5f?auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Bridgeland/Riverside', 'url' => '/bridgeland-riverside-condos/', 'title_url' => '/calgary-condo-buildings/bridgeland/', 'copy' => 'Inner-city condo living near the river, CTrain, cafés, restaurants, and quick downtown access.', 'filters' => 'inner-city,ne', 'photo' => 'https://images.unsplash.com/photo-1519501025264-65ba15a82390?auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Seton', 'url' => '/southeast-calgary-condos/', 'title_url' => '/calgary-condo-buildings/seton/', 'copy' => 'Southeast condo options near health, retail, recreation, and newer amenities.', 'filters' => 'se', 'photo' => 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Mahogany', 'url' => '/mahogany-condos/', 'title_url' => '/mahogany-condos/', 'copy' => 'Lake-community condos with southeast lifestyle amenities and newer options.', 'filters' => 'se', 'photo' => 'https://images.unsplash.com/photo-1509909756405-be0199881695?auto=format&fit=crop&w=800&q=80'],
        ];
    }

    /** @return array<int,array<string,string>> */
    private function building_cards(): array {
        return [
            [
                'name' => 'The Guardian',
                'area' => 'Victoria Park / Beltline',
                'type' => 'High-rise',
                'image' => 'https://images.unsplash.com/photo-1460317442991-0ec209397118?auto=format&fit=crop&w=1200&q=80',
                'amenities' => 'Gym, owners lounge, concierge',
                'year_built' => '2016',
            ],
            [
                'name' => 'Keynote Urban Village',
                'area' => 'Beltline / Victoria Park',
                'type' => 'High-rise',
                'image' => 'https://images.unsplash.com/photo-1486325212027-8081e485255e?auto=format&fit=crop&w=1200&q=80',
                'amenities' => 'Fitness centre, hot tub, owners room',
                'year_built' => '2010-2013',
            ],
            [
                'name' => 'Arriva',
                'area' => 'Victoria Park',
                'type' => 'Luxury high-rise',
                'image' => 'https://images.unsplash.com/photo-1516455207990-7a41ce80f7ee?auto=format&fit=crop&w=1200&q=80',
                'amenities' => 'Concierge, secure parking, storage',
                'year_built' => '2007',
            ],
            [
                'name' => 'Vogue',
                'area' => 'Downtown West End',
                'type' => 'High-rise',
                'image' => 'https://images.unsplash.com/photo-1479839672679-a46483c0e7c8?auto=format&fit=crop&w=1200&q=80',
                'amenities' => 'Sky gym, yoga studio, concierge',
                'year_built' => '2017',
            ],
            [
                'name' => 'Princeton Grand',
                'area' => 'Eau Claire',
                'type' => 'Luxury low-rise',
                'image' => 'https://images.unsplash.com/photo-1448630360428-65456885c650?auto=format&fit=crop&w=1200&q=80',
                'amenities' => 'Concierge, fitness room, guest suite',
                'year_built' => '2002',
            ],
            [
                'name' => 'Evolution',
                'area' => 'East Village',
                'type' => 'High-rise',
                'image' => 'https://images.unsplash.com/photo-1511818966892-d7d671e672a2?auto=format&fit=crop&w=1200&q=80',
                'amenities' => 'Gym, sauna, steam, concierge',
                'year_built' => '2015',
            ],
            [
                'name' => 'Bridgeland Crossing',
                'area' => 'Bridgeland',
                'type' => 'Mid-rise',
                'image' => 'https://images.unsplash.com/photo-1430285561322-7808604715df?auto=format&fit=crop&w=1200&q=80',
                'amenities' => 'Fitness studio, courtyard, guest suites',
                'year_built' => '2016-2019',
            ],
            [
                'name' => 'Union Square',
                'area' => 'Beltline',
                'type' => 'Concrete high-rise',
                'image' => 'https://images.unsplash.com/photo-1465800872432-8cf1ac6ddc32?auto=format&fit=crop&w=1200&q=80',
                'amenities' => 'Owner lounge, concierge, secure parkade',
                'year_built' => '2009',
            ],
        ];
    }

    private function building_card_url(array $building): string {
        $building_name = isset($building['name']) ? sanitize_text_field((string) $building['name']) : '';
        if ('' === $building_name) {
            return home_url('/all-calgary-condos/');
        }

        $post_type = class_exists('Calgary_Condo_Building_CPT') ? Calgary_Condo_Building_CPT::POST_TYPE : 'ccl_building';
        $building_post = get_page_by_path(sanitize_title($building_name), OBJECT, $post_type);

        if ($building_post instanceof WP_Post) {
            $building_permalink = get_permalink($building_post->ID);
            if (is_string($building_permalink) && '' !== $building_permalink) {
                return $building_permalink;
            }
        }

        return add_query_arg('s', $building_name . ' condo', home_url('/all-calgary-condos/'));
    }

    private function render_buyer_intent(): string {
        $search_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.35-4.35"/></svg>';
        $value_icon  = '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 9.5 12 3l9 6.5V20a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.5Z"/><path d="M9 21V13h6v8"/><path d="M12 10v1m0 0c-.83 0-1.5.45-1.5 1s.67 1 1.5 1 1.5.45 1.5 1-.67 1-1.5 1M12 15v1"/></svg>';
        $school_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12.5V17c0 1.66 2.69 3 6 3s6-1.34 6-3v-4.5"/></svg>';
        $park_icon   = '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22v-5"/><path d="M5 17l7-10 7 10H5z"/></svg>';
        $cards = [
            ['title' => 'Browse Calgary Condos', 'copy' => 'Start with the approved live Calgary condo search, then narrow by area, building, budget, and showing fit.', 'micro' => 'Live listings from Calgary\'s approved IDX feed, updated daily.', 'button' => 'Search Calgary Condos', 'url' => '/all-calgary-condos/', 'icon' => $search_icon],
            ['title' => 'Get My Condo Value', 'copy' => 'Request a building-aware value report that accounts for competition, fees, condition, and buyer demand.', 'micro' => 'Free building-aware report. No obligation, no spam.', 'button' => 'Get My Condo Value', 'category' => 'Condo Value Report', 'icon' => $value_icon],
            ['title' => 'Top School Catchments', 'url' => '/top-school-catchments-2/', 'copy' => 'Filter active condo listings dynamically mapped to Calgary school boundaries.', 'micro' => 'Match your condo search to Calgary\'s best school zones.', 'button' => 'Explore School Catchments', 'icon' => $school_icon],
            ['title' => 'Parks &amp; Pet-Friendly Areas', 'url' => '/pet-friendly-calgary-condos/', 'copy' => 'Locate premium buildings within immediate walking distance to inner-city off-leash dog runs, pathways, and green spaces.', 'micro' => 'Find off-leash parks and pathways walking distance from your condo.', 'button' => 'Explore Pet-Friendly Areas', 'icon' => $park_icon],
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

    private function render_area_first(): string {
        ob_start(); ?>
        <section class="ccl-section ccl-home-area-first" aria-labelledby="ccl-home-area-title">
            <div class="ccl-wrap">
                <div class="ccl-home-section-heading">
                    <p class="ccl-eyebrow">Area-first search</p>
                    <h2 id="ccl-home-area-title">Choose your Calgary condo area first.</h2>
                    <p>Pick the lifestyle lane before comparing fees, bylaws, parking, storage, and resale fit.</p>
                </div>
                <div class="ccl-home-area-grid">
                    <?php foreach ($this->area_cards() as $area) : ?>
                        <article class="ccl-home-card ccl-home-area-card" data-area-filters="<?php echo esc_attr($area['filters'] ?? ''); ?>">
                            <?php if (!empty($area['photo'])) : ?>
                                <img class="ccl-home-area-card__photo" src="<?php echo esc_url($area['photo']); ?>" alt="<?php echo esc_attr($area['name'] . ' condos in Calgary'); ?>" loading="lazy">
                            <?php endif; ?>
                            <span>Calgary condo area</span>
                            <h3><?php echo esc_html($area['name']); ?></h3>
                            <p><?php echo esc_html($area['copy']); ?></p>
                            <a class="ccl-home-cta ccl-home-cta--gold" href="<?php echo esc_url(home_url($area['url'])); ?>" target="_self">View area condos →</a>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
            <style>
                .ccl-home-area-card__photo {
                    display: block;
                    /* 100% + 2× card padding (26px each side) to bleed edge-to-edge */
                    width: calc(100% + 52px);
                    height: 160px;
                    /* Pull flush to card top and sides, then add space below */
                    margin: -26px -26px 16px;
                    object-fit: cover;
                }

                /* Equal height: flex column + min-height pushes CTA to bottom on shorter cards */
                .ccl-home-area-card {
                    min-height: 360px;
                }
            </style>
        </section>
        <?php return (string) ob_get_clean();
    }

    private function render_building_first(): string {
        ob_start(); ?>
        <section class="ccl-section ccl-home-building-first" aria-labelledby="ccl-home-building-title">
            <div class="ccl-wrap">
                <div class="ccl-home-section-heading">
                    <p class="ccl-eyebrow">Property Index</p>
                    <h2 id="ccl-home-building-title">Calgary Condo Search — Building Directory</h2>
                    <p>Every building, indexed.</p>
                </div>
                <div class="ccl-building-directory-simple">
                    <?php foreach ($this->building_cards() as $building) : ?>
                        <?php $building_url = $this->building_card_url($building); ?>
                        <a class="ccl-building-plaque" href="<?php echo esc_url($building_url); ?>">
                            <span class="ccl-building-plaque__name"><?php echo esc_html($building['name']); ?></span>
                            <span class="ccl-building-plaque__community"><?php echo esc_html($building['area']); ?></span>
                            <?php
                            $stats = [];
                            if (!empty($building['year_built'])) {
                                $stats[] = 'Built ' . (string) $building['year_built'];
                            }
                            if (!empty($building['type'])) {
                                $stats[] = (string) $building['type'];
                            }
                            ?>
                            <?php if (!empty($stats)) : ?>
                                <span class="ccl-building-plaque__stats"><?php echo esc_html(implode(' · ', $stats)); ?></span>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <style>
        .ccl-building-directory-simple {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 16px;
            max-width: 1180px;
            margin-top: 28px;
        }
        .ccl-building-plaque {
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 6px;
            padding: 22px 24px 22px 28px;
            background: #15171c;
            border: 1px solid #2a2d35;
            border-radius: 4px;
            text-decoration: none;
            overflow: hidden;
            transition: background 0.18s ease, border-color 0.18s ease;
        }
        .ccl-building-plaque::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: transparent;
            transition: background 0.18s ease;
        }
        .ccl-building-plaque:hover,
        .ccl-building-plaque:focus-visible {
            background: #1b1e25;
            border-color: #3a3e48;
            outline: none;
        }
        .ccl-building-plaque:hover::before,
        .ccl-building-plaque:focus-visible::before {
            background: #c9a24a;
        }
        .ccl-building-plaque__name {
            font-size: 1rem;
            font-weight: 600;
            color: #c9a24a;
            line-height: 1.3;
            letter-spacing: 0.01em;
            transition: color 0.18s ease;
        }
        .ccl-building-plaque:hover .ccl-building-plaque__name,
        .ccl-building-plaque:focus-visible .ccl-building-plaque__name {
            color: #e3c374;
        }
        .ccl-building-plaque__community {
            font-size: 0.82rem;
            color: #ece7da;
            opacity: 0.8;
            letter-spacing: 0.015em;
        }
        .ccl-building-plaque__stats {
            font-size: 0.75rem;
            color: #a9a596;
            margin-top: 4px;
            letter-spacing: 0.01em;
        }
        </style>
        <?php return (string) ob_get_clean();
    }

    private function render_trust_risk(): string { ob_start(); ?>
        <section class="ccl-section ccl-home-trust-risk" aria-labelledby="ccl-home-risk-title"><div class="ccl-wrap"><div class="ccl-home-section-heading"><p class="ccl-eyebrow">Trust, lifestyle, and risk checks</p><h2 id="ccl-home-risk-title">Buy the building with your eyes open.</h2><p>Use condo due diligence, school context, and community guidance to shortlist stronger Calgary condo options.</p></div><div class="ccl-home-trust-grid"><article class="ccl-home-card"><h3>Building-risk guidance</h3><p>Review reserve fund signals, bylaws, insurance, fee pressure, management, special-assessment risk, and resale fit before booking every showing.</p><button type="button" class="ccl-home-cta ccl-home-cta--gold" data-ccl-lead-open data-requested-category="Building Risk Report" data-lead-source="Homepage Trust Section" data-clicked-cta="Request Building Risk Guidance">Request Building Risk Guidance</button></article><article class="ccl-home-card"><h3>School and lifestyle finder</h3><p>Match your condo search to commute, school-area questions, parks, CTrain access, river pathways, groceries, and the way you actually live.</p><button type="button" class="ccl-home-cta ccl-home-cta--gold" data-ccl-lead-open data-requested-category="General Calgary Condo Help" data-lead-source="Homepage Trust Section" data-clicked-cta="Ask About Schools and Lifestyle">Ask About Schools and Lifestyle</button></article><article class="ccl-home-card"><h3>Community guidance</h3><p>Compare Beltline, Downtown Core, Eau Claire, Mission, East Village, Hillhurst, Bridgeland, Seton, Mahogany, and other Calgary condo markets.</p><a class="ccl-home-cta ccl-home-cta--gold" href="<?php echo esc_url(home_url('/calgary-communities/')); ?>" target="_self">Explore Community Guidance</a></article></div></div></section><?php return (string) ob_get_clean(); }

    public function render(array $atts = [], ?string $content = null): string {
        $phone_tel     = defined('CCL_CONTACT_PHONE_TEL') ? CCL_CONTACT_PHONE_TEL : '+14038006996';
        $feedback      = Calgary_Condo_Leads::current_feedback();
        $hero_feedback = 'homepage-hero' === $feedback['target'] ? $feedback : ['status' => '', 'message' => '', 'target' => '', 'context' => 'generic'];
        ob_start(); ?>
        <div class="ccl-page-shell ccl-premium-homepage-shell ccl-home-tight ccl-home-search-first" data-ccl-condo-home>
            <section id="clean-calgary-hero" class="ccl-home-hero" aria-labelledby="clean-calgary-hero-title">
                <div class="ccl-home-hero__overlay"></div>
                <div class="ccl-home-hero__content">
                    <p class="ccl-eyebrow">Calgary Condo Search</p>
                    <h1 id="clean-calgary-hero-title">Find the Right Calgary Condo Before You Book a Showing</h1>
                    <p class="ccl-home-hero__subtitle">Search active Calgary condo listings with building intelligence before you book a showing.</p>
                    <div class="ccl-hero-lead-panel" id="condo-alerts" aria-label="<?php esc_attr_e('Get New Listings & Price Drops First', 'calgary-condo-leads'); ?>">
                        <h2 class="ccl-hero-lead-panel__title"><?php esc_html_e('Get New Listings & Price Drops First', 'calgary-condo-leads'); ?></h2>
                        <p class="ccl-hero-lead-panel__support"><?php esc_html_e('New listings, price drops & building updates.', 'calgary-condo-leads'); ?></p>
                        <?php if ('success' === $hero_feedback['status']) : ?>
                            <p class="ccl-hero-lead-panel__success" role="status"><?php echo esc_html($hero_feedback['message']); ?></p>
                        <?php elseif ('error' === $hero_feedback['status']) : ?>
                            <p class="ccl-hero-lead-panel__error" role="alert"><?php echo esc_html($hero_feedback['message']); ?></p>
                        <?php else : ?>
                        <form class="ccl-hero-lead-panel__form" method="post" action="">
                            <?php wp_nonce_field('ccl_alert_form', 'ccl_nonce'); ?>
                            <input type="hidden" name="ccl_action" value="alert_form">
                            <input type="hidden" name="ccl_lead_source" value="Homepage Hero Lead Row">
                            <input type="hidden" name="ccl_requested_category" value="Condo Alerts">
                            <input type="hidden" name="ccl_confirmation_context" value="building-alerts">
                            <input type="hidden" name="ccl_feedback_target" value="homepage-hero">
                            <div class="ccl-hero-lead-panel__fields">
                                <input type="text" name="ccl_name" placeholder="<?php esc_attr_e('Your Name', 'calgary-condo-leads'); ?>" autocomplete="name" required aria-label="<?php esc_attr_e('Your Name', 'calgary-condo-leads'); ?>">
                                <input type="email" name="ccl_email" placeholder="<?php esc_attr_e('Email Address', 'calgary-condo-leads'); ?>" autocomplete="email" required aria-label="<?php esc_attr_e('Email Address', 'calgary-condo-leads'); ?>">
                                <input type="tel" name="ccl_phone" placeholder="<?php esc_attr_e('Phone Number', 'calgary-condo-leads'); ?>" autocomplete="tel" aria-label="<?php esc_attr_e('Phone Number', 'calgary-condo-leads'); ?>">
                                <button type="submit" class="ccl-home-cta ccl-home-cta--gold ccl-hero-lead-panel__submit"><?php esc_html_e('Send Me Condo Alerts', 'calgary-condo-leads'); ?></button>
                            </div>
                            <label class="ccl-hp" for="ccl-hero-lead-website"><?php esc_html_e('Website', 'calgary-condo-leads'); ?><input id="ccl-hero-lead-website" type="text" name="ccl_website" tabindex="-1" autocomplete="off"></label>
                            <p class="ccl-hero-lead-panel__trust"><span aria-hidden="true">✓ </span><?php esc_html_e('Free Calgary condo alerts • No spam • Unsubscribe anytime', 'calgary-condo-leads'); ?></p>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
            <?php echo $this->render_buyer_intent(); ?>
            <?php echo $this->render_area_first(); ?>
            <?php echo $this->render_building_first(); ?>
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
