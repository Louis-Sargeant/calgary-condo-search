<?php
if (!defined('ABSPATH')) {
    exit;
}

final class Calgary_Condo_Homepage {
    private const SEARCH_SHORTCODES = [
        'all' => '[mrp account_id=67196 listing_def=search-1439299 context=recip perm_attr=tmpl~v2 ][/mrp]',
        'under-400k' => '[mrp account_id=67196 listing_def=search-1439371 context=recip perm_attr=tmpl~v2 ][/mrp]',
        'price-drops' => '[mrp account_id=67196 listing_def=search-1439357 context=recip perm_attr=tmpl~v2 ][/mrp]',
    ];

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
        $idx_content = trim((string) $content);

        ob_start();
        ?>
        <div class="ccl-home-tight ccl-home-search-first" data-ccl-condo-home>
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

                #calgary-explore-navbar a:hover,
                #calgary-explore-navbar a:focus {
                    text-decoration: none !important;
                    transform: translateY(-1px) !important;
                }

                #calgary-explore-navbar-nav::-webkit-scrollbar {
                    height: 6px !important;
                }

                #calgary-explore-navbar-nav::-webkit-scrollbar-thumb {
                    background: rgba(0,0,0,0.18) !important;
                    border-radius: 999px !important;
                }

                @media (max-width: 767px) {
                    #clean-calgary-hero {
                        min-height: 620px !important;
                        padding: 64px 16px !important;
                    }

                    #clean-calgary-hero-title {
                        font-size: clamp(2.35rem, 13vw, 4.1rem) !important;
                    }

                    #clean-calgary-hero-phone {
                        font-size: 1.65rem !important;
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

            <section id="clean-calgary-hero" aria-labelledby="clean-calgary-hero-title" style="background-image: url('https://media-production.lp-cdn.com/cdn-cgi/image/format=auto,quality=85/https://media-production.lp-cdn.com/media/a4d49880-59d1-42e4-a404-c5e1cf16111b') !important; background-size: cover !important; background-position: center !important; background-repeat: no-repeat !important; position: relative !important; width: 100% !important; min-height: 620px !important; padding: 90px 20px !important; display: flex !important; align-items: center !important; justify-content: center !important; box-sizing: border-box !important; overflow: hidden !important;">
                <div id="clean-calgary-hero-overlay" style="background: rgba(0,0,0,0.48) !important; position: absolute !important; inset: 0 !important; z-index: 1 !important; pointer-events: none !important;"></div>
                <div id="clean-calgary-hero-content" style="z-index: 2 !important; position: relative !important; width: 100% !important; max-width: 1180px !important; margin: 0 auto !important; text-align: center !important; color: #ffffff !important; box-sizing: border-box !important;">
                    <h1 id="clean-calgary-hero-title" style="color: #ffffff !important; font-size: clamp(3rem, 6vw, 5.8rem) !important; line-height: 0.95 !important; font-weight: 900 !important; letter-spacing: -0.055em !important; text-align: center !important; max-width: 1050px !important; margin: 0 auto 24px auto !important; text-shadow: 0 6px 24px rgba(0,0,0,0.75) !important;">Calgary Condos—Compared by Building First.</h1>
                    <p id="clean-calgary-hero-subtitle" style="color: #ffffff !important; font-size: clamp(1.1rem, 2vw, 1.45rem) !important; line-height: 1.55 !important; font-weight: 600 !important; text-align: center !important; max-width: 900px !important; margin: 0 auto 28px auto !important; text-shadow: 0 4px 18px rgba(0,0,0,0.8) !important;">Before you buy, compare what matters. Uncover the truth about Calgary’s top buildings—from true condo fees, strict pet bylaws, and rental restrictions, to reserve fund health, underground parking allocations, and long-term resale value. Search active CREB® listings with absolute clarity.</p>
                    <p id="clean-calgary-hero-phone" style="color: #ffffff !important; text-align: center !important; margin: 24px auto 0 auto !important; font-size: 2.5rem !important; line-height: 1.15 !important; font-weight: 800 !important; text-shadow: 0 6px 22px rgba(0,0,0,0.85) !important;">Call Calgary Direct: <?php echo esc_html($phone_display); ?></p>
                </div>
            </section>

            <section id="calgary-explore-navbar" aria-labelledby="calgary-explore-navbar-title" style="background: #ffffff !important; color: #000000 !important; width: 100% !important; padding: 22px 0 !important; box-sizing: border-box !important; border-bottom: 1px solid rgba(0,0,0,0.08) !important;">
                <div id="calgary-explore-navbar-inner" style="max-width: 1180px !important; width: 100% !important; margin: 0 auto !important; padding: 0 20px !important; box-sizing: border-box !important;">
                    <h2 id="calgary-explore-navbar-title" style="color: #000000 !important; font-size: clamp(1.35rem, 2.25vw, 2rem) !important; line-height: 1.15 !important; font-weight: 800 !important; text-align: left !important; margin: 0 0 14px 0 !important;">Explore Calgary Condos</h2>
                    <nav id="calgary-explore-navbar-nav" aria-label="Explore Calgary condos navigation" style="display: flex !important; flex-wrap: wrap !important; align-items: center !important; justify-content: flex-start !important; gap: 10px !important; width: 100% !important; overflow-x: auto !important; box-sizing: border-box !important;">
                        <a id="calgary-explore-link-all" href="/calgary-condos/" style="background: #fff7ec !important; color: #111111 !important; border: 1px solid #FF9900 !important; border-radius: 999px !important; padding: 10px 16px !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; font-weight: 800 !important; line-height: 1.1 !important; text-decoration: none !important; white-space: nowrap !important;">All Calgary Condos</a>
                        <a id="calgary-explore-link-southeast" href="/southeast-calgary-condos/" style="background: #f7f7f7 !important; color: #111111 !important; border: 1px solid rgba(0,0,0,0.14) !important; border-radius: 999px !important; padding: 10px 16px !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; font-weight: 700 !important; line-height: 1.1 !important; text-decoration: none !important; white-space: nowrap !important;">Southeast Calgary</a>
                        <a id="calgary-explore-link-southwest" href="/southwest-calgary-condos/" style="background: #f7f7f7 !important; color: #111111 !important; border: 1px solid rgba(0,0,0,0.14) !important; border-radius: 999px !important; padding: 10px 16px !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; font-weight: 700 !important; line-height: 1.1 !important; text-decoration: none !important; white-space: nowrap !important;">Southwest Calgary</a>
                        <a id="calgary-explore-link-northwest" href="/northwest-calgary-condos/" style="background: #f7f7f7 !important; color: #111111 !important; border: 1px solid rgba(0,0,0,0.14) !important; border-radius: 999px !important; padding: 10px 16px !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; font-weight: 700 !important; line-height: 1.1 !important; text-decoration: none !important; white-space: nowrap !important;">Northwest Calgary</a>
                        <a id="calgary-explore-link-northeast" href="/northeast-calgary-condos/" style="background: #f7f7f7 !important; color: #111111 !important; border: 1px solid rgba(0,0,0,0.14) !important; border-radius: 999px !important; padding: 10px 16px !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; font-weight: 700 !important; line-height: 1.1 !important; text-decoration: none !important; white-space: nowrap !important;">Northeast Calgary</a>
                        <a id="calgary-explore-link-downtown" href="/downtown-calgary-condos/" style="background: #f7f7f7 !important; color: #111111 !important; border: 1px solid rgba(0,0,0,0.14) !important; border-radius: 999px !important; padding: 10px 16px !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; font-weight: 700 !important; line-height: 1.1 !important; text-decoration: none !important; white-space: nowrap !important;">Downtown</a>
                        <a id="calgary-explore-link-beltline" href="/beltline-condos/" style="background: #f7f7f7 !important; color: #111111 !important; border: 1px solid rgba(0,0,0,0.14) !important; border-radius: 999px !important; padding: 10px 16px !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; font-weight: 700 !important; line-height: 1.1 !important; text-decoration: none !important; white-space: nowrap !important;">Beltline</a>
                        <a id="calgary-explore-link-under-400k" href="/condos-under-400k/" style="background: #f7f7f7 !important; color: #111111 !important; border: 1px solid rgba(0,0,0,0.14) !important; border-radius: 999px !important; padding: 10px 16px !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; font-weight: 700 !important; line-height: 1.1 !important; text-decoration: none !important; white-space: nowrap !important;">Under $400K</a>
                    </nav>
                </div>
            </section>

            <section class="ccl-section ccl-section--white ccl-portal-intro" aria-labelledby="ccl-portal-intro-title">
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

            <section id="mrp-listings" class="ccl-section ccl-section--white ccl-idx-shell ccl-tight-idx">
                <div class="ccl-wrap">
                    <div class="ccl-idx-shell__header ccl-idx-shell__header--compact">
                        <div>
                            <p class="ccl-eyebrow">Live Calgary Condo Search</p>
                            <h2>All Calgary condo listings</h2>
                            <p>Search Calgary condos, save the right matches, and get building-first guidance before booking showings.</p>
                        </div>
                        <a class="ccl-small-link" href="/building-alerts/">Get condo alerts</a>
                    </div>
                    <div class="ccl-idx-shell__frame">
                        <?php if ('' !== $idx_content) : ?>
                            <?php echo wp_kses_post(do_shortcode($idx_content)); ?>
                        <?php else : ?>
                            <?php echo do_shortcode(self::SEARCH_SHORTCODES['all']); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        </div>
        <?php
        return (string) ob_get_clean();
    }
}

new Calgary_Condo_Homepage();
