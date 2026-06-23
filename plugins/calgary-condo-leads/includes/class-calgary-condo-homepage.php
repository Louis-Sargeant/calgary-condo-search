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

    private function render_condo_map_explorer(): string {
        $communities = [
            [
                'name' => 'Beltline',
                'group' => 'Inner City Calgary',
                'summary' => 'Central high-rise condo living with strong walkability, restaurants, downtown access, and active inventory.',
                'url' => '/beltline-condos/',
                'x' => 46,
                'y' => 52,
                'status' => 'Live feed',
            ],
            [
                'name' => 'Kensington',
                'group' => 'Inner City Calgary',
                'summary' => 'Walkable Sunnyside and Hillhurst market area near restaurants, river pathways, transit, and boutique condo options.',
                'url' => '/kensington-condos/',
                'x' => 39,
                'y' => 38,
                'status' => 'Live feed',
            ],
            [
                'name' => 'Bridgeland',
                'group' => 'Inner City Calgary',
                'summary' => 'Neighbourhood condo market near river pathways, local shops, downtown access, and established urban amenities.',
                'url' => '/bridgeland-condos/',
                'x' => 60,
                'y' => 39,
                'status' => 'Next feed',
            ],
            [
                'name' => 'Downtown Core',
                'group' => 'Inner City Calgary',
                'summary' => 'Core condo towers close to office districts, CTrain access, restaurants, river pathways, and downtown services.',
                'url' => '/downtown-calgary-condos/',
                'x' => 49,
                'y' => 45,
                'status' => 'Next feed',
            ],
            [
                'name' => 'East Village',
                'group' => 'Inner City Calgary',
                'summary' => 'Modern condo towers, river access, newer buildings, walkability, and an urban lifestyle feel.',
                'url' => '/east-village-condos/',
                'x' => 56,
                'y' => 48,
                'status' => 'Next feed',
            ],
            [
                'name' => 'Mission',
                'group' => 'Inner City Calgary',
                'summary' => 'Popular inner-city condo pocket near 4th Street, restaurants, river pathways, and established urban amenities.',
                'url' => '/mission-condos/',
                'x' => 48,
                'y' => 62,
                'status' => 'Next feed',
            ],
            [
                'name' => 'Seton',
                'group' => 'Suburban Condo Markets',
                'summary' => 'Growing southeast condo market near the South Health Campus, shopping, recreation, and newer suburban amenities.',
                'url' => '/seton-condos/',
                'x' => 73,
                'y' => 72,
                'status' => 'Next feed',
            ],
            [
                'name' => 'Mahogany',
                'group' => 'Suburban Condo Markets',
                'summary' => 'Lake-community condo market with southeast amenities, newer developments, and lifestyle-driven buyer appeal.',
                'url' => '/mahogany-condos/',
                'x' => 68,
                'y' => 79,
                'status' => 'Next feed',
            ],
        ];

        ob_start();
        ?>
        <section id="ccl-condo-map-explorer" class="ccl-section ccl-dark-luxury-section ccl-condo-map-explorer" aria-labelledby="ccl-condo-map-explorer-title">
            <div class="ccl-wrap ccl-condo-map-explorer__wrap">
                <div class="ccl-condo-map-explorer__header">
                    <p class="ccl-eyebrow">Calgary Condo Map Explorer</p>
                    <h2 id="ccl-condo-map-explorer-title">Explore Calgary condos by area first.</h2>
                    <p>Start with the part of Calgary that matches your lifestyle, commute, and building preferences. Then narrow into live condo feeds, building quality, fees, bylaws, parking, and resale fit.</p>
                </div>

                <div class="ccl-condo-map-explorer__shell" aria-label="Interactive Calgary condo area explorer">
                    <div class="ccl-condo-map-explorer__map" role="list" aria-label="Calgary condo communities">
                        <div class="ccl-condo-map-explorer__map-glow ccl-condo-map-explorer__map-glow--northwest"></div>
                        <div class="ccl-condo-map-explorer__map-glow ccl-condo-map-explorer__map-glow--southeast"></div>
                        <div class="ccl-condo-map-explorer__map-grid"></div>

                        <div class="ccl-condo-map-explorer__quadrant ccl-condo-map-explorer__quadrant--nw">NW</div>
                        <div class="ccl-condo-map-explorer__quadrant ccl-condo-map-explorer__quadrant--ne">NE</div>
                        <div class="ccl-condo-map-explorer__quadrant ccl-condo-map-explorer__quadrant--sw">SW</div>
                        <div class="ccl-condo-map-explorer__quadrant ccl-condo-map-explorer__quadrant--se">SE</div>

                        <div class="ccl-condo-map-explorer__axis ccl-condo-map-explorer__axis--vertical"></div>
                        <div class="ccl-condo-map-explorer__axis ccl-condo-map-explorer__axis--horizontal"></div>

                        <?php foreach ($communities as $community) : ?>
                            <a
                                class="ccl-condo-map-pin"
                                href="<?php echo esc_url(home_url($community['url'])); ?>"
                                role="listitem"
                                style="left: <?php echo esc_attr((string) $community['x']); ?>%; top: <?php echo esc_attr((string) $community['y']); ?>%;"
                                aria-label="<?php echo esc_attr($community['name'] . ' condos'); ?>"
                            >
                                <span class="ccl-condo-map-pin__dot" aria-hidden="true"></span>
                                <span class="ccl-condo-map-pin__label"><?php echo esc_html($community['name']); ?></span>
                                <span class="ccl-condo-map-pin__card">
                                    <span class="ccl-condo-map-pin__status"><?php echo esc_html($community['status']); ?></span>
                                    <strong><?php echo esc_html($community['name']); ?> Condo Buildings</strong>
                                    <span><?php echo esc_html($community['summary']); ?></span>
                                    <em>View active condos</em>
                                </span>
                            </a>
                        <?php endforeach; ?>
                    </div>

                    <aside class="ccl-condo-map-explorer__panel" aria-label="Calgary condo map guidance">
                        <p class="ccl-eyebrow">Building-first search lanes</p>
                        <h3>Choose the area, then compare the building.</h3>
                        <p>Move from area fit to building fit: fees, bylaws, reserve fund signals, parking, storage, management, and resale risk.</p>

                        <div class="ccl-condo-map-explorer__actions">
                            <a class="ccl-btn ccl-btn--primary" href="/all-calgary-condos/">View All Calgary Condos</a>
                            <button type="button" class="ccl-btn ccl-btn--secondary ccl-alert-button" data-ccl-lead-open data-lead-source="Map Explorer" data-requested-category="Condo Area Guidance" data-intent="Map explorer lead">Get Area Guidance</button>
                        </div>

                        <div class="ccl-condo-map-explorer__legend">
                            <span><i class="ccl-condo-map-explorer__legend-dot ccl-condo-map-explorer__legend-dot--live"></i> Live feed connected</span>
                            <span><i class="ccl-condo-map-explorer__legend-dot ccl-condo-map-explorer__legend-dot--next"></i> Feed being built</span>
                        </div>
                    </aside>
                </div>
            </div>
        </section>
        <?php
        return (string) ob_get_clean();
    }

    public function render(array $atts = [], ?string $content = null): string {
        $phone_display = defined('CCL_CONTACT_PHONE_DISPLAY') ? CCL_CONTACT_PHONE_DISPLAY : '+1 (403) 800-6996';

        ob_start();
        /*
         * Homepage section mode inventory:
         * - Hero (#clean-calgary-hero): ccl-dark-luxury-section.
         * - Calgary Condo Interactive Map Explorer (#ccl-condo-map-explorer): ccl-dark-luxury-section.
         * - Buyer portal intro (.ccl-portal-intro): ccl-dark-luxury-section.
         * - CTA choice cards (.ccl-intent-capture): ccl-dark-luxury-section (shortcode-owned wrapper).
         * - Final shortlist CTA / lead modal (.ccl-lead-modal-launch): ccl-dark-luxury-section (modal launch wrapper).
         * - Footer / floating lead button: existing footer/lead modal presentation preserved.
         */
        ?>
        <div class="ccl-page-shell ccl-premium-homepage-shell ccl-home-tight ccl-home-search-first" data-ccl-condo-home>
            <style>
                #clean-calgary-hero,
                #clean-calgary-hero * {
                    box-sizing: border-box !important;
                }

                @media (max-width: 767px) {
                    .ccl-premium-homepage-shell {
                        overflow-x: hidden !important;
                    }

                    #clean-calgary-hero {
                        min-height: 590px !important;
                        padding: 56px 18px 82px !important;
                        background-position: center top !important;
                    }

                    #clean-calgary-hero-overlay {
                        background: linear-gradient(180deg, rgba(3,10,22,0.84) 0%, rgba(7,18,34,0.72) 46%, rgba(3,8,18,0.88) 100%) !important;
                    }

                    #clean-calgary-hero-content {
                        max-width: 100% !important;
                        overflow-x: hidden !important;
                    }

                    #clean-calgary-hero-title {
                        width: 100% !important;
                        max-width: 354px !important;
                        font-size: clamp(2rem, 10.2vw, 2.7rem) !important;
                        line-height: 1.04 !important;
                        letter-spacing: -0.04em !important;
                        margin-bottom: 18px !important;
                        overflow-wrap: anywhere !important;
                        word-break: normal !important;
                    }

                    #clean-calgary-hero-title-line-two {
                        white-space: normal !important;
                    }

                    #clean-calgary-hero-subtitle {
                        max-width: 350px !important;
                        font-size: 1rem !important;
                        line-height: 1.48 !important;
                        margin-bottom: 20px !important;
                    }

                    #clean-calgary-hero-phone {
                        max-width: 340px !important;
                        font-size: 1.28rem !important;
                        line-height: 1.24 !important;
                    }
                }
            </style>

            <section id="clean-calgary-hero" class="ccl-dark-luxury-section" aria-labelledby="clean-calgary-hero-title" style="background-image: url('https://media-production.lp-cdn.com/cdn-cgi/image/format=auto,quality=85/https://media-production.lp-cdn.com/media/a4d49880-59d1-42e4-a404-c5e1cf16111b') !important; background-size: cover !important; background-position: center !important; background-repeat: no-repeat !important; position: relative !important; width: 100% !important; min-height: 620px !important; padding: 90px 20px !important; display: flex !important; align-items: center !important; justify-content: center !important; box-sizing: border-box !important; overflow: hidden !important;">
                <div id="clean-calgary-hero-overlay" style="background: rgba(0,0,0,0.52) !important; position: absolute !important; inset: 0 !important; z-index: 1 !important; pointer-events: none !important;"></div>
                <div id="clean-calgary-hero-content" style="z-index: 2 !important; position: relative !important; width: 100% !important; max-width: 1180px !important; margin: 0 auto !important; text-align: center !important; color: #ffffff !important; box-sizing: border-box !important;">
                    <h1 id="clean-calgary-hero-title" style="color: #FFF4E0 !important; font-size: clamp(2.85rem, 5.25vw, 5.15rem) !important; line-height: 0.98 !important; font-weight: 900 !important; letter-spacing: -0.052em !important; text-align: center !important; max-width: 1120px !important; margin: 0 auto 24px auto !important; text-shadow: 0 7px 28px rgba(0,0,0,0.9), 0 2px 6px rgba(0,0,0,0.85) !important;">Calgary Condos—<br><span id="clean-calgary-hero-title-line-two" style="white-space: nowrap !important;">Compared by Building First.</span></h1>
                    <p id="clean-calgary-hero-subtitle" style="color: #F5E5C9 !important; font-size: clamp(1.1rem, 2vw, 1.45rem) !important; line-height: 1.55 !important; font-weight: 700 !important; text-align: center !important; max-width: 930px !important; margin: 0 auto 28px auto !important; text-shadow: 0 5px 20px rgba(0,0,0,0.95), 0 2px 7px rgba(0,0,0,0.9) !important;">Before you buy, compare what matters. Uncover the truth about Calgary’s top buildings—from true condo fees, strict pet bylaws, and rental restrictions, to reserve fund health, underground parking allocations, and long-term resale value. Search active CREB® listings with absolute clarity.</p>
                    <form action="<?php echo esc_url(home_url('/all-calgary-condos/')); ?>" method="get" target="_self" class="ccl-hero-workspace ccl-keyword-search-form" role="search" aria-label="Calgary condo keyword search">
                        <input
                            type="text"
                            id="ccl-hero-keyword-search"
                            name="keyword"
                            class="ccl-hero-workspace__input ccl-keyword-search-input"
                            placeholder="Search condos, buildings, or areas"
                            autocomplete="off"
                            autocapitalize="none"
                            spellcheck="false"
                        >
                        <button type="submit" class="ccl-hero-workspace__button ccl-keyword-search-submit">Find Matches</button>
                    </form>
                    <p id="clean-calgary-hero-phone" style="color: #FFF4E0 !important; text-align: center !important; margin: 24px auto 0 auto !important; font-size: 2.5rem !important; line-height: 1.15 !important; font-weight: 900 !important; text-shadow: 0 7px 26px rgba(0,0,0,0.95), 0 2px 8px rgba(0,0,0,0.9) !important;">Call Calgary Direct: <?php echo esc_html($phone_display); ?></p>
                </div>
            </section>


            <?php echo $this->render_condo_map_explorer(); ?>

            <section class="ccl-section ccl-dark-luxury-section ccl-portal-intro" aria-labelledby="ccl-portal-intro-title">
                <div class="ccl-wrap ccl-portal-intro__grid">
                    <div>
                        <p class="ccl-eyebrow">Buyer-Focused Calgary Condo Portal</p>
                        <h2 id="ccl-portal-intro-title">Do not choose a condo from photos alone.</h2>
                        <p>Calgary condo buyers need more than a list of units. A smart search starts with the building: construction type, reserve fund signals, insurance, fee history, bylaws, parking, storage, elevators, amenities, management, and resale demand.</p>
                    </div>
                    <div class="ccl-portal-intro__panel">
                        <strong>What this portal helps you compare</strong>
                        <ul>
                            <li>Downtown, Beltline, East Village, Mission, Bridgeland, suburban, and southeast condo options.</li>
                            <li>Budget searches including under $400K and price-reduced condos without inventing listing data.</li>
                            <li>Building-first due diligence before you book a showing or write an offer.</li>
                        </ul>
                    </div>
                </div>
            </section>

            <?php echo do_shortcode('[ccl_intent_capture]'); ?>

            <?php echo do_shortcode('[ccl_lead_modal]'); ?>

        </div>
        <?php
        return (string) ob_get_clean();
    }
}

new Calgary_Condo_Homepage();
