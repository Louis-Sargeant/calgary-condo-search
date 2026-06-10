<?php
/**
 * Calgary-focused site section shortcodes.
 *
 * @package CalgaryCondoLeads
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Adds reusable Calgary-only content sections for the lead-generation site.
 */
final class Calgary_Condo_Site_Sections {
    /**
     * Wire shortcodes.
     */
    public function __construct() {
        add_shortcode('ccl_quick_search', [$this, 'render_quick_search_shortcode']);
        add_shortcode('ccl_area_grid', [$this, 'render_area_grid_shortcode']);
        add_shortcode('ccl_price_grid', [$this, 'render_price_grid_shortcode']);
        add_shortcode('ccl_market_snapshot', [$this, 'render_market_snapshot_shortcode']);
        add_shortcode('ccl_building_checklist', [$this, 'render_building_checklist_shortcode']);
        add_shortcode('ccl_buyer_path', [$this, 'render_buyer_path_shortcode']);
        add_shortcode('ccl_building_cta', [$this, 'render_building_cta_shortcode']);
        add_shortcode('ccl_seller_cta', [$this, 'render_seller_cta_shortcode']);
        add_shortcode('ccl_site_footer', [$this, 'render_site_footer_shortcode']);
    }

    /**
     * Normalize shortcode attributes.
     *
     * @param array<string,mixed> $atts Shortcode attributes.
     * @param array<string,mixed> $defaults Default values.
     * @param string              $shortcode Shortcode tag.
     * @return array<string,string>
     */
    private function shortcode_atts(array $atts, array $defaults, string $shortcode): array {
        $normalized = shortcode_atts($defaults, $atts, $shortcode);

        return array_map('strval', $normalized);
    }

    /**
     * Render high-intent quick search links.
     *
     * @param array<string,mixed> $atts Shortcode attributes.
     */
    public function render_quick_search_shortcode(array $atts = []): string {
        $atts = $this->shortcode_atts(
            $atts,
            [
                'eyebrow' => 'Start Your Calgary Condo Search',
                'title' => 'Find the right Calgary condo faster',
                'subtitle' => 'Jump into the searches buyers use most, then use the IDX listings to compare real-time options.',
            ],
            'ccl_quick_search'
        );

        $items = [
            ['title' => 'New Listings', 'text' => 'Fresh Calgary condo listings as they hit the market.', 'url' => '/calgary-condos/?sort=newest'],
            ['title' => 'Inner-City Condos', 'text' => 'Downtown, Beltline, Mission, East Village, and nearby walkable areas.', 'url' => '/inner-city-calgary-condos/'],
            ['title' => 'Concrete Buildings', 'text' => 'Search stronger building options and ask about construction type before you book.', 'url' => '/calgary-concrete-condos/'],
            ['title' => 'Pet-Friendly Condos', 'text' => 'Find buildings where pet rules fit your lifestyle.', 'url' => '/calgary-pet-friendly-condos/'],
        ];

        return $this->render_link_grid($atts, $items, 'ccl-quick-search');
    }

    /**
     * Render neighbourhood/area links.
     *
     * @param array<string,mixed> $atts Shortcode attributes.
     */
    public function render_area_grid_shortcode(array $atts = []): string {
        $atts = $this->shortcode_atts(
            $atts,
            [
                'eyebrow' => 'Calgary Condo Areas',
                'title' => 'Search condos by Calgary area',
                'subtitle' => 'Start with the neighbourhoods Calgary condo buyers ask about most, then narrow your search by building, budget, and lifestyle fit.',
            ],
            'ccl_area_grid'
        );

        $areas = [
            ['title' => 'Downtown Calgary', 'text' => 'High-rise living near the core, river pathways, offices, dining, and transit.', 'url' => '/downtown-calgary-condos/'],
            ['title' => 'Beltline', 'text' => 'One of Calgary’s strongest condo markets for walkability, lifestyle, and convenience.', 'url' => '/beltline-condos/'],
            ['title' => 'East Village', 'text' => 'Modern condo towers, river access, newer buildings, and an urban lifestyle feel.', 'url' => '/east-village-condos/'],
            ['title' => 'Mission', 'text' => 'Popular inner-city condo area near 4th Street, restaurants, and river pathways.', 'url' => '/mission-condos/'],
            ['title' => 'Eau Claire', 'text' => 'Premium central condo living near the Bow River and downtown amenities.', 'url' => '/eau-claire-condos/'],
            ['title' => 'Luxury Condos', 'text' => 'Higher-end Calgary condo options with stronger building amenities and views.', 'url' => '/calgary-luxury-condos/'],
        ];

        return $this->render_link_grid($atts, $areas, 'ccl-area-grid');
    }

    /**
     * Render price-range links.
     *
     * @param array<string,mixed> $atts Shortcode attributes.
     */
    public function render_price_grid_shortcode(array $atts = []): string {
        $atts = $this->shortcode_atts(
            $atts,
            [
                'eyebrow' => 'Calgary Condo Prices',
                'title' => 'Search condos by budget',
                'subtitle' => 'Use price-range pages to quickly focus on Calgary condo options that fit your plan before booking showings.',
            ],
            'ccl_price_grid'
        );

        $ranges = [
            ['title' => 'Under $300K', 'text' => 'Entry-level Calgary condo options and budget-conscious searches.', 'url' => '/calgary-condos-under-300k/'],
            ['title' => '$300K - $500K', 'text' => 'A common search range for Calgary apartment condos and inner-city options.', 'url' => '/calgary-condos-300k-500k/'],
            ['title' => '$500K - $750K', 'text' => 'More space, stronger locations, better views, or newer buildings.', 'url' => '/calgary-condos-500k-750k/'],
            ['title' => 'Luxury Condos', 'text' => 'Premium Calgary condo buildings, larger floor plans, and higher-end amenities.', 'url' => '/calgary-luxury-condos/'],
        ];

        return $this->render_link_grid($atts, $ranges, 'ccl-price-grid');
    }

    /**
     * Render a market education section without fake market statistics.
     *
     * @param array<string,mixed> $atts Shortcode attributes.
     */
    public function render_market_snapshot_shortcode(array $atts = []): string {
        $atts = $this->shortcode_atts(
            $atts,
            [
                'eyebrow' => 'Calgary Condo Market Snapshot',
                'title' => 'What matters before you fall in love with the photos',
                'subtitle' => 'The best Calgary condo is not always the nicest-looking unit online. Strong buyers compare the building, monthly costs, rules, and future resale path before booking showings.',
            ],
            'ccl_market_snapshot'
        );

        $items = [
            ['title' => 'Building strength', 'text' => 'Age, construction type, maintenance history, management quality, amenities, elevators, parking, and reserve-fund signals.'],
            ['title' => 'True monthly cost', 'text' => 'Price matters, but condo fees, utilities, parking, storage, insurance, taxes, and special-assessment risk can change the real number.'],
            ['title' => 'Lifestyle fit', 'text' => 'Pet rules, rental rules, noise, commute, walkability, visitor parking, storage, views, and building culture all affect long-term satisfaction.'],
            ['title' => 'Exit plan', 'text' => 'A good buy should also be sellable later. Floor plan, location, fees, building reputation, and buyer demand matter for resale.'],
        ];

        return $this->render_info_grid($atts, $items, 'ccl-market-snapshot');
    }

    /**
     * Render a building checklist section.
     *
     * @param array<string,mixed> $atts Shortcode attributes.
     */
    public function render_building_checklist_shortcode(array $atts = []): string {
        $atts = $this->shortcode_atts(
            $atts,
            [
                'eyebrow' => 'Condo Building Checklist',
                'title' => 'Questions to ask before writing an offer',
                'subtitle' => 'Use this checklist to separate strong Calgary condo options from risky ones before you spend time on showings or paperwork.',
            ],
            'ccl_building_checklist'
        );

        $items = [
            ['title' => 'Documents', 'text' => 'Reserve fund study, bylaws, minutes, budget, insurance certificate, financials, engineering reports, and disclosure documents.'],
            ['title' => 'Fees and risk', 'text' => 'Monthly fee trend, what is included, upcoming repairs, special-assessment history, insurance deductibles, and reserve-fund health.'],
            ['title' => 'Rules', 'text' => 'Pets, rentals, short-term rentals, renovations, smoking, move-in rules, parking, storage, and amenity restrictions.'],
            ['title' => 'Unit details', 'text' => 'Parking stall, storage locker, exposure, noise, heat source, appliances, floor plan, balcony, views, and condition.'],
            ['title' => 'Building demand', 'text' => 'Days on market, similar sales, competing listings, buyer pool, and how the building is viewed by local condo buyers.'],
            ['title' => 'Offer strategy', 'text' => 'Price, conditions, document-review timing, possession date, deposits, and how clean the offer needs to be to compete.'],
        ];

        return $this->render_info_grid($atts, $items, 'ccl-building-checklist');
    }

    /**
     * Render buyer guidance steps.
     *
     * @param array<string,mixed> $atts Shortcode attributes.
     */
    public function render_buyer_path_shortcode(array $atts = []): string {
        $atts = $this->shortcode_atts(
            $atts,
            [
                'eyebrow' => 'Calgary Condo Buyer Plan',
                'title' => 'Before you book a showing, know what to check',
                'subtitle' => 'A strong Calgary condo search is not just price and photos. The building, fees, bylaws, parking, reserve fund, and resale plan matter.',
            ],
            'ccl_buyer_path'
        );

        $steps = [
            ['number' => '01', 'title' => 'Pick the right search lane', 'text' => 'Area, budget, building age, parking, pet rules, commute, and lifestyle fit.'],
            ['number' => '02', 'title' => 'Compare the building', 'text' => 'Condo fees, amenities, management, reserve fund health, bylaws, and resale demand.'],
            ['number' => '03', 'title' => 'Move with a plan', 'text' => 'Shortlist the best units, avoid weak buildings, and write cleaner offers when the right condo appears.'],
        ];

        ob_start();
        ?>
        <section class="ccl-section ccl-buyer-path">
            <div class="ccl-wrap">
                <div class="ccl-section__header">
                    <p class="ccl-eyebrow"><?php echo esc_html($atts['eyebrow']); ?></p>
                    <h2><?php echo esc_html($atts['title']); ?></h2>
                    <p><?php echo esc_html($atts['subtitle']); ?></p>
                </div>
                <div class="ccl-step-grid">
                    <?php foreach ($steps as $step) : ?>
                        <article class="ccl-step-card">
                            <span><?php echo esc_html($step['number']); ?></span>
                            <h3><?php echo esc_html($step['title']); ?></h3>
                            <p><?php echo esc_html($step['text']); ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php

        return (string) ob_get_clean();
    }

    /**
     * Render building research CTA.
     *
     * @param array<string,mixed> $atts Shortcode attributes.
     */
    public function render_building_cta_shortcode(array $atts = []): string {
        $atts = $this->shortcode_atts(
            $atts,
            [
                'eyebrow' => 'Building Research',
                'title' => 'Want to watch a Calgary condo building?',
                'subtitle' => 'Get building alerts, compare listings, and ask questions about fees, amenities, parking, pet rules, and resale value before you book a showing.',
                'button_text' => 'Set Up Building Alerts',
                'button_url' => '#condo-alerts',
            ],
            'ccl_building_cta'
        );

        ob_start();
        ?>
        <section class="ccl-section ccl-building-cta">
            <div class="ccl-wrap ccl-feature-band">
                <div>
                    <p class="ccl-eyebrow"><?php echo esc_html($atts['eyebrow']); ?></p>
                    <h2><?php echo esc_html($atts['title']); ?></h2>
                    <p><?php echo esc_html($atts['subtitle']); ?></p>
                </div>
                <a class="ccl-btn ccl-btn--primary" href="<?php echo esc_url($atts['button_url']); ?>"><?php echo esc_html($atts['button_text']); ?></a>
            </div>
        </section>
        <?php

        return (string) ob_get_clean();
    }

    /**
     * Render condo seller valuation CTA.
     *
     * @param array<string,mixed> $atts Shortcode attributes.
     */
    public function render_seller_cta_shortcode(array $atts = []): string {
        $atts = $this->shortcode_atts(
            $atts,
            [
                'eyebrow' => 'Condo Owners',
                'title' => 'Own a Calgary condo and want the real number?',
                'subtitle' => 'Get a Calgary condo value check built around your building, recent sales, competition, condition, fees, and buyer demand.',
                'button_text' => 'Request Condo Value Report',
                'button_url' => '/condo-value-report/',
                'secondary_text' => 'Call Calgary Number',
            ],
            'ccl_seller_cta'
        );

        $phone_display = defined('CCL_CONTACT_PHONE_DISPLAY') ? CCL_CONTACT_PHONE_DISPLAY : '+1 (403) 800-6996';
        $phone_tel = defined('CCL_CONTACT_PHONE_TEL') ? CCL_CONTACT_PHONE_TEL : '+14038006996';

        ob_start();
        ?>
        <section class="ccl-section ccl-section--white ccl-seller-cta">
            <div class="ccl-wrap ccl-seller-card">
                <div>
                    <p class="ccl-eyebrow"><?php echo esc_html($atts['eyebrow']); ?></p>
                    <h2><?php echo esc_html($atts['title']); ?></h2>
                    <p><?php echo esc_html($atts['subtitle']); ?></p>
                </div>
                <div class="ccl-seller-card__actions">
                    <a class="ccl-btn ccl-btn--primary" href="<?php echo esc_url($atts['button_url']); ?>"><?php echo esc_html($atts['button_text']); ?></a>
                    <a class="ccl-btn ccl-btn--dark" href="tel:<?php echo esc_attr($phone_tel); ?>"><?php echo esc_html($atts['secondary_text']); ?>: <?php echo esc_html($phone_display); ?></a>
                </div>
            </div>
        </section>
        <?php

        return (string) ob_get_clean();
    }

    /**
     * Render Calgary-only site footer.
     *
     * @param array<string,mixed> $atts Shortcode attributes.
     */
    public function render_site_footer_shortcode(array $atts = []): string {
        $phone_display = defined('CCL_CONTACT_PHONE_DISPLAY') ? CCL_CONTACT_PHONE_DISPLAY : '+1 (403) 800-6996';
        $phone_tel = defined('CCL_CONTACT_PHONE_TEL') ? CCL_CONTACT_PHONE_TEL : '+14038006996';

        $atts = $this->shortcode_atts(
            $atts,
            [
                'title' => 'Calgary Condo Search',
                'description' => 'Calgary condo search, building alerts, and condo value reports with a fighter in your corner.',
                'brokerage' => 'Operated by Louis Sargeant, REALTOR®, Real Broker.',
                'disclaimer' => 'Property and building information must be independently verified.',
            ],
            'ccl_site_footer'
        );

        ob_start();
        ?>
        <footer class="ccl-site-footer" aria-label="<?php esc_attr_e('Calgary Condo Search footer', 'calgary-condo-leads'); ?>">
            <div class="ccl-wrap ccl-site-footer__inner">
                <div>
                    <strong><?php echo esc_html($atts['title']); ?></strong>
                    <p><?php echo esc_html($atts['description']); ?></p>
                    <p class="ccl-site-footer__muted"><?php echo esc_html($atts['brokerage']); ?></p>
                    <a class="ccl-site-footer__phone" href="tel:<?php echo esc_attr($phone_tel); ?>"><?php echo esc_html($phone_display); ?></a>
                    <p class="ccl-site-footer__muted"><?php echo esc_html($atts['disclaimer']); ?></p>
                </div>
                <nav class="ccl-site-footer__links" aria-label="<?php esc_attr_e('Calgary Condo Search footer links', 'calgary-condo-leads'); ?>">
                    <a href="/calgary-condos/">Calgary Condos</a>
                    <a href="/condo-buildings/">Condo Buildings</a>
                    <a href="/condo-value-report/">Condo Value Report</a>
                    <a href="/market-report/">Market Report</a>
                    <a href="/building-alerts/">Building Alerts</a>
                </nav>
            </div>
        </footer>
        <?php

        return (string) ob_get_clean();
    }

    /**
     * Render a reusable link grid.
     *
     * @param array<string,string> $atts Heading attributes.
     * @param array<int,array<string,string>> $items Grid items.
     * @param string $class_name Section class.
     */
    private function render_link_grid(array $atts, array $items, string $class_name): string {
        ob_start();
        ?>
        <section class="ccl-section ccl-section--white <?php echo esc_attr($class_name); ?>">
            <div class="ccl-wrap">
                <div class="ccl-section__header">
                    <p class="ccl-eyebrow"><?php echo esc_html($atts['eyebrow']); ?></p>
                    <h2><?php echo esc_html($atts['title']); ?></h2>
                    <p><?php echo esc_html($atts['subtitle']); ?></p>
                </div>
                <div class="ccl-link-grid">
                    <?php foreach ($items as $item) : ?>
                        <a class="ccl-link-card" href="<?php echo esc_url($item['url']); ?>">
                            <strong><?php echo esc_html($item['title']); ?></strong>
                            <span><?php echo esc_html($item['text']); ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php

        return (string) ob_get_clean();
    }

    /**
     * Render a reusable non-link information grid.
     *
     * @param array<string,string> $atts Heading attributes.
     * @param array<int,array<string,string>> $items Grid items.
     * @param string $class_name Section class.
     */
    private function render_info_grid(array $atts, array $items, string $class_name): string {
        ob_start();
        ?>
        <section class="ccl-section <?php echo esc_attr($class_name); ?>">
            <div class="ccl-wrap">
                <div class="ccl-section__header">
                    <p class="ccl-eyebrow"><?php echo esc_html($atts['eyebrow']); ?></p>
                    <h2><?php echo esc_html($atts['title']); ?></h2>
                    <p><?php echo esc_html($atts['subtitle']); ?></p>
                </div>
                <div class="ccl-info-grid">
                    <?php foreach ($items as $item) : ?>
                        <article class="ccl-card ccl-info-card">
                            <h3><?php echo esc_html($item['title']); ?></h3>
                            <p><?php echo esc_html($item['text']); ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php

        return (string) ob_get_clean();
    }
}

new Calgary_Condo_Site_Sections();
