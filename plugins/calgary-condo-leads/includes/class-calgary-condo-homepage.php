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

    public function render(array $atts = [], ?string $content = null): string {
        $phone_display = defined('CCL_CONTACT_PHONE_DISPLAY') ? CCL_CONTACT_PHONE_DISPLAY : '+1 (403) 800-6996';

        ob_start();
        /*
         * Homepage section mode inventory:
         * - Hero (#clean-calgary-hero): ccl-dark-luxury-section.
         * - Explore Calgary Condos navigation (#calgary-explore-navbar): ccl-dark-luxury-section.
         * - Search All Calgary Condos CTA (#idx-search): ccl-dark-luxury-section.
         * - Building database directory (#calgary-building-directory-database): ccl-dark-luxury-section (shortcode-owned wrapper).
         * - Buyer portal intro (.ccl-portal-intro): ccl-dark-luxury-section.
         * - CTA choice cards (.ccl-intent-capture): ccl-dark-luxury-section (shortcode-owned wrapper).
         * - Calgary condo areas buyers ask about first (.ccl-area-grid): ccl-dark-luxury-section (shortcode-owned wrapper).
         * - Building directory / popular condo buildings (.ccl-building-section): ccl-dark-luxury-section (shortcode-owned wrapper).
         * - Schools & Community (#ccl-schools-lifestyle-section): ccl-dark-luxury-section (shortcode-owned wrapper).
         * - Building Risk Intelligence (.ccl-lead-modal-launch): ccl-dark-luxury-section (modal launch wrapper).
         * - Market Stats (.ccl-market-snapshot when rendered): ccl-dark-luxury-section (shortcode-owned wrapper).
         * - Footer / floating lead button: existing footer/lead modal presentation preserved.
         */
        ?>
        <div class="ccl-page-shell ccl-premium-homepage-shell ccl-home-tight ccl-home-search-first" data-ccl-condo-home>
            <style>
                #clean-calgary-hero,
                #clean-calgary-hero * {
                    box-sizing: border-box !important;
                }

                #calgary-explore-navbar,
                #calgary-explore-navbar * {
                    box-sizing: border-box !important;
                }

                #calgary-explore-navbar a {
                    text-decoration: none !important;
                    box-shadow: none !important;
                }

                #calgary-explore-navbar-nav.ccl-region-nav .nav-item-link:hover,
                #calgary-explore-navbar-nav.ccl-region-nav .nav-item-link:focus {
                    color: #121212 !important;
                    background: linear-gradient(180deg, #FFF4E0 0%, #E6C687 30%, #D4AF37 50%, #B38F43 85%, #7A5C1B 100%) !important;
                    border-color: rgba(245,229,201,0.44) !important;
                    text-decoration: none !important;
                }

                #calgary-explore-navbar-nav::-webkit-scrollbar {
                    height: 6px !important;
                }

                #calgary-explore-navbar-nav::-webkit-scrollbar-thumb {
                    background: rgba(0,0,0,0.18) !important;
                    border-radius: 999px !important;
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

                    #calgary-explore-navbar-inner {
                        padding: 0 16px !important;
                    }

                    #calgary-explore-navbar-nav {
                        flex-wrap: nowrap !important;
                        overflow-x: auto !important;
                        justify-content: flex-start !important;
                        padding-bottom: 8px !important;
                        -webkit-overflow-scrolling: touch !important;
                    }

                    #calgary-explore-navbar-nav a {
                        flex: 0 0 auto !important;
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

            <section id="calgary-explore-navbar" class="ccl-dark-luxury-section" aria-labelledby="calgary-explore-navbar-title" style="background: rgba(5, 7, 11, 0.78) !important; color: #FFF4E0 !important; width: 100% !important; padding: 22px 0 !important; box-sizing: border-box !important; border-bottom: 1px solid rgba(212,175,55,0.30) !important; box-shadow: 0 18px 44px rgba(0,0,0,0.22) !important; backdrop-filter: blur(16px) !important;">
                <div id="calgary-explore-navbar-inner" style="max-width: 1180px !important; width: 100% !important; margin: 0 auto !important; padding: 0 20px !important; box-sizing: border-box !important;">
                    <h2 id="calgary-explore-navbar-title" style="color: #FFF4E0 !important; font-size: clamp(1.35rem, 2.25vw, 2rem) !important; line-height: 1.15 !important; font-weight: 800 !important; text-align: left !important; margin: 0 0 14px 0 !important;">Explore Calgary Condos</h2>
                    <nav id="calgary-explore-navbar-nav" class="ccl-region-nav" aria-label="Explore Calgary Condos" style="display: flex !important; flex-wrap: wrap !important; align-items: center !important; justify-content: flex-start !important; gap: 10px !important; width: 100% !important; overflow-x: auto !important; box-sizing: border-box !important;">
                        <?php // Keep this Explore row limited to quadrant links; the all-city CTA lives directly below. ?>
                        <a id="calgary-explore-link-southeast" class="nav-item-link" href="/southeast-calgary-condos/" target="_self" style="background: rgba(5, 7, 11, 0.52) !important; color: #F5E5C9 !important; border: 1px solid rgba(212,175,55,0.35) !important; box-shadow: 0 14px 34px rgba(0,0,0,0.28) !important; border-radius: 999px !important; padding: 10px 16px !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; font-weight: 700 !important; line-height: 1.1 !important; text-decoration: none !important; white-space: nowrap !important;">Southeast Calgary</a>
                        <a id="calgary-explore-link-southwest" class="nav-item-link" href="/southwest-calgary-condos/" target="_self" style="background: rgba(5, 7, 11, 0.52) !important; color: #F5E5C9 !important; border: 1px solid rgba(212,175,55,0.35) !important; box-shadow: 0 14px 34px rgba(0,0,0,0.28) !important; border-radius: 999px !important; padding: 10px 16px !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; font-weight: 700 !important; line-height: 1.1 !important; text-decoration: none !important; white-space: nowrap !important;">Southwest Calgary</a>
                        <a id="calgary-explore-link-northwest" class="nav-item-link" href="/northwest-calgary-condos/" target="_self" style="background: rgba(5, 7, 11, 0.52) !important; color: #F5E5C9 !important; border: 1px solid rgba(212,175,55,0.35) !important; box-shadow: 0 14px 34px rgba(0,0,0,0.28) !important; border-radius: 999px !important; padding: 10px 16px !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; font-weight: 700 !important; line-height: 1.1 !important; text-decoration: none !important; white-space: nowrap !important;">Northwest Calgary</a>
                        <a id="calgary-explore-link-northeast" class="nav-item-link" href="/northeast-calgary-condos/" target="_self" style="background: rgba(5, 7, 11, 0.52) !important; color: #F5E5C9 !important; border: 1px solid rgba(212,175,55,0.35) !important; box-shadow: 0 14px 34px rgba(0,0,0,0.28) !important; border-radius: 999px !important; padding: 10px 16px !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; font-weight: 700 !important; line-height: 1.1 !important; text-decoration: none !important; white-space: nowrap !important;">Northeast Calgary</a>
                    </nav>
                </div>
            </section>


            <section id="idx-search" class="ccl-section ccl-dark-luxury-section ccl-idx-shell ccl-home-master-feed-cta ccl-home-search-bridge" aria-labelledby="ccl-idx-title">
                <div class="ccl-wrap">
                    <div class="ccl-home-search-bridge__panel ccl-idx-shell__header ccl-idx-shell__header--compact">
                        <div class="ccl-home-search-bridge__content">
                            <p class="ccl-eyebrow">Calgary Condo Search</p>
                            <h2 id="ccl-idx-title" class="ccl-idx-title">Search All Calgary Condos</h2>
                            <p class="ccl-idx-copy">View every active Calgary condo listing in one place, then narrow by building, area, price, and lifestyle fit.</p>
                        </div>
                        <div class="ccl-idx-shell__actions ccl-home-search-bridge__actions">
                            <a class="ccl-btn ccl-btn--primary" href="/all-calgary-condos/" target="_self">View All Calgary Condos</a>
                            <button type="button" class="ccl-btn ccl-btn--secondary ccl-alert-button" data-ccl-lead-open data-lead-source="Homepage" data-requested-category="Condo Alerts" data-intent="Active listings request">Get Condo Alerts</button>
                        </div>
                    </div>
                </div>
            </section>

            <?php echo do_shortcode('[ccl_building_database_directory]'); ?>

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

            <?php echo do_shortcode('[ccl_area_grid title="Calgary condo areas buyers ask about first" subtitle="Start with a Calgary area, then narrow by building quality, monthly cost, rules, commute, lifestyle fit, and resale path."]'); ?>

            <?php echo do_shortcode('[ccl_building_directory]'); ?>

            <?php echo do_shortcode('[ccl_school_community]'); ?>

            <?php echo do_shortcode('[ccl_lead_modal]'); ?>

        </div>
        <?php
        return (string) ob_get_clean();
    }
}

new Calgary_Condo_Homepage();
