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
            ['name' => 'Downtown Core', 'url' => '/downtown-core-condos/', 'title_url' => '/calgary-condo-buildings/downtown-core/', 'copy' => 'Core towers near offices, transit, river pathways, and central services.', 'filters' => 'downtown,inner-city', 'photo' => 'https://images.unsplash.com/photo-1486325212027-8081e485255e?auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Eau Claire', 'url' => '/eau-claire-condos/', 'title_url' => '/calgary-condo-buildings/eau-claire/', 'copy' => 'Premium river-adjacent condos with downtown convenience and luxury positioning.', 'filters' => 'downtown,inner-city', 'photo' => 'https://images.unsplash.com/photo-1563213126-a4273aed2016?auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Mission', 'url' => '/mission-condos/', 'title_url' => '/calgary-condo-buildings/mission/', 'copy' => 'Walkable inner-city living near 4th Street, restaurants, and the river.', 'filters' => 'inner-city,sw', 'photo' => 'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?auto=format&fit=crop&w=800&q=80'],
            ['name' => 'East Village', 'url' => '/east-village-condos/', 'title_url' => '/calgary-condo-buildings/east-village/', 'copy' => 'Modern urban towers near the library, river pathways, and downtown east amenities.', 'filters' => 'downtown,inner-city,se', 'photo' => 'https://images.unsplash.com/photo-1460317442991-0ec209397118?auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Kensington', 'url' => '/kensington-condos/', 'title_url' => '/calgary-condo-buildings/kensington/', 'copy' => 'Boutique inner-city condo options around Sunnyside, Hillhurst, transit, and cafés.', 'filters' => 'inner-city,nw', 'photo' => 'https://images.unsplash.com/photo-1569880153113-76e33fc52d5f?auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Bridgeland', 'url' => '/bridgeland-condos/', 'title_url' => '/calgary-condo-buildings/bridgeland/', 'copy' => 'Neighbourhood condo living with river access, local shops, and CTrain convenience.', 'filters' => 'inner-city,ne', 'photo' => 'https://images.unsplash.com/photo-1519501025264-65ba15a82390?auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Seton', 'url' => '/seton-condos/', 'title_url' => '/calgary-condo-buildings/seton/', 'copy' => 'Southeast condo options near health, retail, recreation, and newer amenities.', 'filters' => 'se', 'photo' => 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Mahogany', 'url' => '/mahogany-condos/', 'title_url' => '/calgary-condo-buildings/mahogany/', 'copy' => 'Lake-community condos with southeast lifestyle amenities and newer options.', 'filters' => 'se', 'photo' => 'https://images.unsplash.com/photo-1509909756405-be0199881695?auto=format&fit=crop&w=800&q=80'],
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
                'fees' => '$0.70-$0.82/sq ft',
                'amenities' => 'Gym, owners lounge, concierge',
                'year_built' => '2016',
                'pet_policy' => 'Pets with board approval',
            ],
            [
                'name' => 'Keynote Urban Village',
                'area' => 'Beltline / Victoria Park',
                'type' => 'High-rise',
                'image' => 'https://images.unsplash.com/photo-1486325212027-8081e485255e?auto=format&fit=crop&w=1200&q=80',
                'fees' => '$0.64-$0.76/sq ft',
                'amenities' => 'Fitness centre, hot tub, owners room',
                'year_built' => '2010-2013',
                'pet_policy' => 'Pet-friendly with restrictions',
            ],
            [
                'name' => 'Arriva',
                'area' => 'Victoria Park',
                'type' => 'Luxury high-rise',
                'image' => 'https://images.unsplash.com/photo-1516455207990-7a41ce80f7ee?auto=format&fit=crop&w=1200&q=80',
                'fees' => '$0.88-$1.05/sq ft',
                'amenities' => 'Concierge, secure parking, storage',
                'year_built' => '2007',
                'pet_policy' => 'Case-by-case board approval',
            ],
            [
                'name' => 'Vogue',
                'area' => 'Downtown West End',
                'type' => 'High-rise',
                'image' => 'https://images.unsplash.com/photo-1479839672679-a46483c0e7c8?auto=format&fit=crop&w=1200&q=80',
                'fees' => '$0.58-$0.69/sq ft',
                'amenities' => 'Sky gym, yoga studio, concierge',
                'year_built' => '2017',
                'pet_policy' => 'Pets with size limits',
            ],
            [
                'name' => 'Princeton Grand',
                'area' => 'Eau Claire',
                'type' => 'Luxury low-rise',
                'image' => 'https://images.unsplash.com/photo-1448630360428-65456885c650?auto=format&fit=crop&w=1200&q=80',
                'fees' => '$1.10-$1.35/sq ft',
                'amenities' => 'Concierge, fitness room, guest suite',
                'year_built' => '2002',
                'pet_policy' => 'Smaller pets typically permitted',
            ],
            [
                'name' => 'Evolution',
                'area' => 'East Village',
                'type' => 'High-rise',
                'image' => 'https://images.unsplash.com/photo-1511818966892-d7d671e672a2?auto=format&fit=crop&w=1200&q=80',
                'fees' => '$0.67-$0.80/sq ft',
                'amenities' => 'Gym, sauna, steam, concierge',
                'year_built' => '2015',
                'pet_policy' => 'Pet-friendly bylaws',
            ],
            [
                'name' => 'Bridgeland Crossing',
                'area' => 'Bridgeland',
                'type' => 'Mid-rise',
                'image' => 'https://images.unsplash.com/photo-1430285561322-7808604715df?auto=format&fit=crop&w=1200&q=80',
                'fees' => '$0.55-$0.69/sq ft',
                'amenities' => 'Fitness studio, courtyard, guest suites',
                'year_built' => '2016-2019',
                'pet_policy' => 'Pets generally allowed',
            ],
            [
                'name' => 'Union Square',
                'area' => 'Beltline',
                'type' => 'Concrete high-rise',
                'image' => 'https://images.unsplash.com/photo-1465800872432-8cf1ac6ddc32?auto=format&fit=crop&w=1200&q=80',
                'fees' => '$0.62-$0.74/sq ft',
                'amenities' => 'Owner lounge, concierge, secure parkade',
                'year_built' => '2009',
                'pet_policy' => '',
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
            ['title' => 'Top School Catchments', 'copy' => 'Filter active condo listings dynamically mapped to Calgary&#8217;s top-ranked designated public and separate school boundaries.', 'micro' => 'Match your condo search to Calgary\'s best school zones.', 'button' => 'Explore School Catchments', 'url' => '/top-school-catchments/', 'category' => 'Condo Alerts', 'icon' => $school_icon],
            ['title' => 'Parks &amp; Pet-Friendly Areas', 'copy' => 'Locate premium buildings within immediate walking distance to inner-city off-leash dog runs, pathways, and green spaces.', 'micro' => 'Find off-leash parks and pathways walking distance from your condo.', 'button' => 'Explore Pet-Friendly Areas', 'url' => '/parks-pet-friendly-areas/', 'category' => 'Building Risk Report', 'icon' => $park_icon],
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
        $filters = [
            'all'        => 'All',
            'downtown'   => 'Downtown',
            'inner-city' => 'Inner City',
            'nw'         => 'NW',
            'ne'         => 'NE',
            'sw'         => 'SW',
            'se'         => 'SE',
        ];
        ob_start(); ?>
        <section class="ccl-section ccl-home-area-first" aria-labelledby="ccl-home-area-title" data-ccl-area-filter>
            <div class="ccl-wrap">
                <div class="ccl-home-section-heading">
                    <p class="ccl-eyebrow">Area-first search</p>
                    <h2 id="ccl-home-area-title">Choose your Calgary condo area first.</h2>
                    <p>Pick the lifestyle lane before comparing fees, bylaws, parking, storage, and resale fit.</p>
                </div>
                <div class="ccl-home-area-filters" role="toolbar" aria-label="Filter Calgary condo areas">
                    <?php foreach ($filters as $key => $label) : ?>
                        <button type="button" class="ccl-home-area-filter<?php echo 'all' === $key ? ' is-active' : ''; ?>" data-area-filter="<?php echo esc_attr($key); ?>" aria-pressed="<?php echo 'all' === $key ? 'true' : 'false'; ?>">
                            <?php echo esc_html($label); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
                <div class="ccl-home-area-grid">
                    <?php foreach ($this->area_cards() as $area) : ?>
                        <article class="ccl-home-card ccl-home-area-card" data-area-filters="<?php echo esc_attr($area['filters'] ?? ''); ?>">
                            <?php if (!empty($area['photo'])) : ?>
                                <img class="ccl-home-area-card__photo" src="<?php echo esc_url($area['photo']); ?>" alt="<?php echo esc_attr($area['name'] . ' condos in Calgary'); ?>" loading="lazy">
                            <?php endif; ?>
                            <span>Calgary condo area</span>
                            <h3>
                                <?php if (!empty($area['title_url'])) : ?>
                                    <a class="ccl-home-area-card__title-link" href="<?php echo esc_url(home_url($area['title_url'])); ?>" target="_self"><?php echo esc_html($area['name']); ?></a>
                                <?php else : ?>
                                    <?php echo esc_html($area['name']); ?>
                                <?php endif; ?>
                            </h3>
                            <p><?php echo esc_html($area['copy']); ?></p>
                            <a class="ccl-home-cta ccl-home-cta--gold" href="<?php echo esc_url(home_url($area['url'])); ?>" target="_self">View area condos →</a>
                        </article>
                    <?php endforeach; ?>
                </div>
                <p class="ccl-home-area-empty" data-ccl-area-empty hidden>No communities match this filter yet. Try another area.</p>
            </div>
            <style>
                .ccl-home-area-card__photo {
                    display: block;
                    width: calc(100% + 52px);
                    height: 160px;
                    margin: -26px -26px 16px;
                    object-fit: cover;
                }

                .ccl-home-area-card {
                    min-height: 360px;
                }

                .ccl-home-area-filters {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 10px;
                    margin: 0 0 22px;
                }

                .ccl-home-area-filter {
                    appearance: none;
                    border: 1px solid rgba(201, 163, 85, 0.45);
                    background: #171717;
                    color: #f4efe6;
                    border-radius: 999px;
                    padding: 10px 16px;
                    font-size: 13px;
                    font-weight: 700;
                    letter-spacing: 0.04em;
                    text-transform: uppercase;
                    cursor: pointer;
                    transition: all 0.2s ease;
                }

                .ccl-home-area-filter:hover,
                .ccl-home-area-filter:focus-visible {
                    border-color: rgba(201, 163, 85, 0.95);
                    color: #fff;
                    outline: none;
                }

                .ccl-home-area-filter.is-active {
                    background: linear-gradient(135deg, #d4af37, #a67c2d);
                    border-color: rgba(212, 175, 55, 0.95);
                    color: #111;
                    box-shadow: 0 10px 22px rgba(0, 0, 0, 0.35);
                }

                .ccl-home-area-empty {
                    margin: 16px 0 0;
                    color: #d0c5b3;
                }
            </style>
            <script>
                (function () {
                    var sections = document.querySelectorAll('[data-ccl-area-filter]');
                    if (!sections.length) {
                        return;
                    }

                    sections.forEach(function (section) {
                        var buttons = section.querySelectorAll('.ccl-home-area-filter');
                        var cards = section.querySelectorAll('.ccl-home-area-card');
                        var emptyState = section.querySelector('[data-ccl-area-empty]');

                        if (!buttons.length || !cards.length) {
                            return;
                        }

                        var applyFilter = function (filter) {
                            var visibleCount = 0;

                            cards.forEach(function (card) {
                                var rawFilters = card.getAttribute('data-area-filters') || '';
                                var splitFilters = rawFilters.split(',');
                                var tokens = splitFilters
                                    .map(function (value) {
                                        return value.trim();
                                    })
                                    .filter(function (value) {
                                        return '' !== value;
                                    });
                                var isVisible = 'all' === filter || tokens.includes(filter);

                                card.hidden = !isVisible;
                                if (isVisible) {
                                    visibleCount++;
                                }
                            });

                            buttons.forEach(function (button) {
                                var isActive = button.getAttribute('data-area-filter') === filter;
                                button.classList.toggle('is-active', isActive);
                                button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
                            });

                            if (emptyState) {
                                emptyState.hidden = visibleCount !== 0;
                            }
                        };

                        buttons.forEach(function (button) {
                            button.addEventListener('click', function () {
                                applyFilter(button.getAttribute('data-area-filter') || 'all');
                            });
                        });

                        applyFilter('all');
                    });
                })();
            </script>
        </section>
        <?php return (string) ob_get_clean();
    }

    private function render_building_first(): string {
        ob_start(); ?>
        <section class="ccl-section ccl-home-building-first" aria-labelledby="ccl-home-building-title">
            <div class="ccl-wrap">
                <div class="ccl-home-section-heading">
                    <p class="ccl-eyebrow">Building-first search</p>
                    <h2 id="ccl-home-building-title">Search by building, not just price.</h2>
                    <p>These profiles help buyers ask better questions. When a live page is not available, request building-specific guidance instead of guessing.</p>
                </div>
                <div class="ccl-home-building-grid">
                    <?php foreach ($this->building_cards() as $building) : ?>
                        <?php $building_url = $this->building_card_url($building); ?>
                        <?php
                        $highlights = [];
                        if (!empty($building['fees'])) {
                            $highlights[] = 'Fees: ' . (string) $building['fees'];
                        }
                        if (!empty($building['amenities'])) {
                            $highlights[] = 'Amenities: ' . (string) $building['amenities'];
                        }
                        if (!empty($building['year_built'])) {
                            $highlights[] = 'Built: ' . (string) $building['year_built'];
                        }
                        if (!empty($building['pet_policy'])) {
                            $highlights[] = 'Pets: ' . (string) $building['pet_policy'];
                        }
                        ?>
                        <article class="ccl-home-card ccl-home-building-card">
                            <span><?php echo esc_html($building['area']); ?></span>
                            <?php if (!empty($building['image'])) : ?>
                                <a href="<?php echo esc_url($building_url); ?>" target="_self">
                                    <img src="<?php echo esc_url((string) $building['image']); ?>" alt="<?php echo esc_attr($building['name'] . ' condo building in Calgary'); ?>" loading="lazy" style="display:block;width:100%;aspect-ratio:16/10;object-fit:cover;border-radius:14px;margin:0 0 14px;">
                                </a>
                            <?php endif; ?>
                            <h3><a href="<?php echo esc_url($building_url); ?>" target="_self"><?php echo esc_html($building['name']); ?></a></h3>
                            <p><?php echo esc_html($building['type']); ?> in <?php echo esc_html($building['area']); ?>.</p>
                            <?php if (!empty($highlights)) : ?>
                                <p><?php echo esc_html(implode(' • ', $highlights)); ?></p>
                            <?php endif; ?>
                            <a class="ccl-home-cta ccl-home-cta--glass" href="<?php echo esc_url($building_url); ?>" target="_self">View Building Profile</a>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php return (string) ob_get_clean();
    }

    private function render_live_idx(): string {
        $idx = '[mrp account_id=67196 listing_def=search-1439357 context=recip perm_attr=tmpl~v2,ibf_property_type~DWELLING_TYPE%40APAR,ibf_price_to~300000 ][/mrp]';
        ob_start(); ?>
        <section id="idx-search" class="ccl-section ccl-home-live-idx" aria-labelledby="ccl-home-idx-title">
            <div class="ccl-wrap">
                <div class="ccl-home-idx-frame">
                    <div class="ccl-home-section-heading">
                        <p class="ccl-eyebrow">LIVE MLS®</p>
                        <h2 id="ccl-home-idx-title">Calgary Condos Under $300,000</h2>
                        <p>Browse live Calgary condo listings priced under $300,000, automatically updated through our myRealPage IDX feed.</p>
                    </div>
                    <div class="ccl-home-idx-frame__embed"><?php echo do_shortcode($idx); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
                    <div class="ccl-home-live-idx__actions">
                        <a class="ccl-home-cta ccl-home-cta--gold" href="<?php echo esc_url(home_url('/under-300k/')); ?>" target="_self">View All Under $300K Condos</a>
                        <a class="ccl-home-cta ccl-home-cta--glass" href="<?php echo esc_url(home_url('/building-alerts/')); ?>" target="_self">Get Instant Condo Alerts</a>
                    </div>
                </div>
            </div>
        </section>
        <?php return (string) ob_get_clean();
    }

    private function render_trust_risk(): string { ob_start(); ?>
        <section class="ccl-section ccl-home-trust-risk" aria-labelledby="ccl-home-risk-title"><div class="ccl-wrap"><div class="ccl-home-section-heading"><p class="ccl-eyebrow">Trust, lifestyle, and risk checks</p><h2 id="ccl-home-risk-title">Buy the building with your eyes open.</h2><p>Use condo due diligence, school context, and community guidance to shortlist stronger Calgary condo options.</p></div><div class="ccl-home-trust-grid"><article class="ccl-home-card"><h3>Building-risk guidance</h3><p>Review reserve fund signals, bylaws, insurance, fee pressure, management, special-assessment risk, and resale fit before booking every showing.</p><button type="button" class="ccl-home-cta ccl-home-cta--gold" data-ccl-lead-open data-requested-category="Building Risk Report" data-lead-source="Homepage Trust Section" data-clicked-cta="Request Building Risk Guidance">Request Building Risk Guidance</button></article><article class="ccl-home-card"><h3>School and lifestyle finder</h3><p>Match your condo search to commute, school-area questions, parks, CTrain access, river pathways, groceries, and the way you actually live.</p><button type="button" class="ccl-home-cta ccl-home-cta--gold" data-ccl-lead-open data-requested-category="General Calgary Condo Help" data-lead-source="Homepage Trust Section" data-clicked-cta="Ask About Schools and Lifestyle">Ask About Schools and Lifestyle</button></article><article class="ccl-home-card"><h3>Community guidance</h3><p>Compare Beltline, Downtown Core, Eau Claire, Mission, East Village, Kensington, Bridgeland, Seton, Mahogany, and other Calgary condo markets.</p><a class="ccl-home-cta ccl-home-cta--gold" href="<?php echo esc_url(home_url('/calgary-communities/')); ?>" target="_self">Explore Community Guidance</a></article></div></div></section><?php return (string) ob_get_clean(); }

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
                    <p class="ccl-home-hero__subtitle">Search active Calgary condo listings with building intelligence before you book a showing.</p>
                    <div class="ccl-hero-lead-panel" id="condo-alerts" aria-label="<?php esc_attr_e('Get New Listings & Price Drops First', 'calgary-condo-leads'); ?>">
                        <h2 class="ccl-hero-lead-panel__title"><?php esc_html_e('Get New Listings & Price Drops First', 'calgary-condo-leads'); ?></h2>
                        <p class="ccl-hero-lead-panel__support"><?php esc_html_e('New listings, price drops & building updates.', 'calgary-condo-leads'); ?></p>
                        <?php if ($hero_success) : ?>
                            <p class="ccl-hero-lead-panel__success" role="status"><?php esc_html_e('Thanks — your Calgary condo alert request was received.', 'calgary-condo-leads'); ?></p>
                        <?php else : ?>
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
                            <p class="ccl-hero-lead-panel__trust"><span aria-hidden="true">✓ </span><?php esc_html_e('Free Calgary condo alerts • No spam • Unsubscribe anytime', 'calgary-condo-leads'); ?></p>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
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
