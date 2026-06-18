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
        $phone_tel = defined('CCL_CONTACT_PHONE_TEL') ? CCL_CONTACT_PHONE_TEL : '+14038006996';
        $idx_content = trim((string) $content);

        $tabs = [
            ['key' => 'all', 'label' => 'All Calgary Condos', 'url' => '/calgary-condos/'],
            ['key' => 'southeast', 'label' => 'Southeast Calgary', 'url' => '/southeast-calgary-condos/'],
            ['key' => 'southwest', 'label' => 'Southwest Calgary', 'url' => '/southwest-calgary-condos/'],
            ['key' => 'northwest', 'label' => 'Northwest Calgary', 'url' => '/northwest-calgary-condos/'],
            ['key' => 'northeast', 'label' => 'Northeast Calgary', 'url' => '/northeast-calgary-condos/'],
            ['key' => 'downtown', 'label' => 'Downtown', 'url' => '/downtown-calgary-condos/'],
            ['key' => 'beltline', 'label' => 'Beltline', 'url' => '/beltline-condos/'],
            ['key' => 'under-400k', 'label' => 'Under $400K', 'url' => '/condos-under-400k/'],
            ['key' => 'price-drops', 'label' => 'Price Drops', 'url' => '/price-reduced-condos/'],
        ];

        ob_start();
        ?>
        <div class="ccl-home-tight ccl-home-search-first" data-ccl-condo-home>
            <section class="ccl-tight-hero" aria-labelledby="ccl-home-title">
                <div class="ccl-tight-hero__overlay">
                    <div class="ccl-wrap ccl-tight-hero__inner">
                        <p class="ccl-eyebrow">Calgary Condo Search</p>
                        <h1 id="ccl-home-title">Calgary condos, compared by building first.</h1>
                        <p class="ccl-tight-hero__subtitle">Search live myRealPage IDX listings, then use buyer-focused Calgary condo guidance to compare buildings, condo fees, bylaws, parking, storage, documents, pet rules, rental rules, and resale fit before you book showings.</p>

                        <nav class="ccl-home-search ccl-home-search--links" aria-label="Calgary condo search shortcuts">
                            <a class="ccl-home-search__main" href="/calgary-condos/">Search All Calgary Condos</a>
                            <a href="/southeast-calgary-condos/">Southeast</a>
                            <a href="/downtown-calgary-condos/">Downtown</a>
                            <a href="/calgary-condo-buildings/">Buildings</a>
                            <a href="/condos-under-400k/">Under $400K</a>
                        </nav>

                        <button class="ccl-btn ccl-btn--primary" type="button" data-ccl-modal-open>Get a condo shortlist</button>
                        <a class="ccl-tight-hero__phone" href="tel:<?php echo esc_attr($phone_tel); ?>">Call Calgary direct: <?php echo esc_html($phone_display); ?></a>
                    </div>
                </div>
            </section>

            <section class="ccl-home-explore" aria-labelledby="ccl-explore-title">
                <div class="ccl-wrap">
                    <h2 id="ccl-explore-title">Explore Calgary Condos</h2>
                    <nav class="ccl-home-tabs" aria-label="Calgary condo quick searches">
                        <?php foreach ($tabs as $tab) : ?>
                            <a class="<?php echo 'all' === $tab['key'] ? 'is-active' : ''; ?>" href="<?php echo esc_url($tab['url']); ?>"><?php echo esc_html($tab['label']); ?></a>
                        <?php endforeach; ?>
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
