<?php
if (!defined('ABSPATH')) {
    exit;
}

final class Calgary_Condo_Homepage {
    private const SEARCH_SHORTCODES = [
        'all' => '[mrp account_id=67196 listing_def=search-1439659 context=recip perm_attr=tmpl~v2]',
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
        $page_number = isset($_GET['_pg']) ? absint(wp_unslash($_GET['_pg'])) : 0;
        $is_paginated_idx = $page_number > 1;
        $featured_communities = ['Beltline', 'Downtown', 'Eau Claire', 'East Village', 'Mission', 'Kensington'];
        $featured_cards = [
            [
                'title' => 'Inner-City Condos',
                'copy' => 'Walkable buildings near restaurants, parks, river paths, and downtown offices.',
            ],
            [
                'title' => 'Luxury High-Rise Living',
                'copy' => 'Premium views, concierge-style amenities, and concrete construction options.',
            ],
            [
                'title' => 'Smart Buyer Filters',
                'copy' => 'Compare buildings by lifestyle, location, budget, parking, and pet rules.',
            ],
        ];

        ob_start();
        ?>
        <div class="ccl-page-shell ccl-home-tight ccl-home-search-first<?php echo $is_paginated_idx ? ' ccl-home-search-first--paginated' : ''; ?>" data-ccl-condo-home>
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
                    color: #111111 !important;
                    background: #fff7ec !important;
                    border-color: #FF9900 !important;
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
                    #clean-calgary-hero {
                        min-height: 620px !important;
                        padding: 64px 16px !important;
                    }

                    #clean-calgary-hero-title {
                        font-size: clamp(2.2rem, 11vw, 3.9rem) !important;
                        max-width: 760px !important;
                    }

                    #clean-calgary-hero-title-line-two {
                        white-space: normal !important;
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

            <?php if (!$is_paginated_idx) : ?>
            <section class="ccl-react-portal" aria-labelledby="ccl-react-portal-title">
                <div class="ccl-react-portal__glow ccl-react-portal__glow--orange" aria-hidden="true"></div>
                <div class="ccl-react-portal__glow ccl-react-portal__glow--blue" aria-hidden="true"></div>
                <div class="ccl-react-portal__glow ccl-react-portal__glow--white" aria-hidden="true"></div>

                <nav class="ccl-react-portal__nav" aria-label="Calgary Condo Search portal navigation">
                    <div class="ccl-react-portal__nav-inner">
                        <a href="/" class="ccl-react-portal__brand">Calgary Condo Search</a>
                        <div class="ccl-react-portal__links">
                            <a href="#communities">Communities</a>
                            <a href="#featured">Building Types</a>
                            <a href="#search">Search</a>
                        </div>
                        <a href="#search" class="ccl-react-portal__start">Start Search</a>
                    </div>
                </nav>

                <div class="ccl-react-portal__hero">
                    <div class="ccl-react-portal__hero-grid">
                        <div class="ccl-react-portal__panel ccl-react-portal__panel--hero">
                            <p class="ccl-react-portal__badge">Calgary Condo Portal</p>
                            <h1 id="ccl-react-portal-title">Find Your Perfect Calgary Condo</h1>
                            <p class="ccl-react-portal__lead">Explore premium condo opportunities across Calgary’s most in-demand inner-city communities, including Beltline, Downtown, Eau Claire, East Village, and surrounding walkable neighbourhoods.</p>

                            <div id="search" class="ccl-react-portal__search">
                                <form action="/calgary-condos/" method="GET" class="ccl-react-portal__search-box" role="search" aria-label="Search Calgary condos">
                                    <label class="screen-reader-text" for="ccl-react-portal-search-input">Search by community, building style, price range, or lifestyle</label>
                                    <input id="ccl-react-portal-search-input" name="q" type="text" placeholder="Search by community, building style, price range, or lifestyle..." />
                                    <button type="submit">Find Matches</button>
                                </form>
                                <p class="ccl-react-portal__note">Static placeholder only. Search logic and IDX/API connections are not active yet.</p>
                            </div>
                        </div>

                        <aside class="ccl-react-portal__panel ccl-react-portal__feature" aria-label="Featured Calgary condo search focus">
                            <div class="ccl-react-portal__feature-card">
                                <div>
                                    <p class="ccl-react-portal__kicker">Featured Focus</p>
                                    <h2>Building-first condo search for serious Calgary buyers.</h2>
                                </div>
                                <div class="ccl-react-portal__community-stack">
                                    <?php foreach (array_slice($featured_communities, 0, 4) as $community) : ?>
                                        <div><?php echo esc_html($community); ?></div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>

                <section id="communities" class="ccl-react-portal__communities" aria-labelledby="ccl-react-portal-communities-title">
                    <div class="ccl-react-portal__panel">
                        <h2 id="ccl-react-portal-communities-title">Popular Calgary Condo Communities</h2>
                        <div class="ccl-react-portal__community-grid">
                            <?php foreach ($featured_communities as $community) : ?>
                                <a href="<?php echo esc_url('/' . sanitize_title($community) . '/'); ?>"><?php echo esc_html($community); ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </section>

                <section id="featured" class="ccl-react-portal__cards" aria-label="Featured Calgary condo building types">
                    <?php foreach ($featured_cards as $card) : ?>
                        <article class="ccl-react-portal__info-card">
                            <h3><?php echo esc_html($card['title']); ?></h3>
                            <p><?php echo esc_html($card['copy']); ?></p>
                        </article>
                    <?php endforeach; ?>
                </section>
            </section>

            <?php endif; ?>

            <section id="idx-search" class="ccl-section ccl-section--white ccl-idx-shell ccl-tight-idx" aria-labelledby="ccl-live-calgary-listings-title">
                <div class="ccl-wrap">
                    <div class="ccl-idx-shell__header ccl-idx-shell__header--compact">
                        <div>
                            <p class="ccl-eyebrow">Live Calgary Condo Search</p>
                            <h2 id="ccl-live-calgary-listings-title"><?php echo $is_paginated_idx ? esc_html(sprintf('Live Calgary Condo Listings — Page %d', $page_number)) : esc_html('Live Calgary Condo Listings'); ?></h2>
                            <p><?php echo $is_paginated_idx ? esc_html('Continue browsing live Calgary condo listings without repeating the full search portal content on every IDX pagination page.') : esc_html('Search Calgary condos, save the right matches, and get building-first guidance before booking showings.'); ?></p>
                        </div>
                        <a class="ccl-small-link" href="/building-alerts/" target="_self">Get condo alerts</a>
                    </div>
                    <div class="ccl-idx-shell__frame">
                        <?php echo do_shortcode('[mrp account_id=67196 listing_def=search-1439659 context=recip perm_attr=tmpl~v2]'); ?>
                    </div>
                </div>
            </section>

            <?php if ($is_paginated_idx) : ?>
                <section class="ccl-section ccl-section--white ccl-paginated-condo-note" aria-labelledby="ccl-paginated-condo-note-title">
                    <div class="ccl-wrap">
                        <p class="ccl-eyebrow">Calgary Condo Listings</p>
                        <h2 id="ccl-paginated-condo-note-title">Keep browsing active Calgary condos.</h2>
                        <p>This paginated results view stays focused on live listings. Return to the main Calgary condo portal when you want building guides, area links, alerts, and buyer resources.</p>
                        <a class="ccl-btn ccl-btn--primary" href="/calgary-condos/" target="_self">Back to Calgary Condo Portal</a>
                    </div>
                </section>
            <?php else : ?>

            <?php echo do_shortcode('[ccl_building_database_directory]'); ?>

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
            <?php endif; ?>

        </div>
        <?php
        return (string) ob_get_clean();
    }
}

new Calgary_Condo_Homepage();
