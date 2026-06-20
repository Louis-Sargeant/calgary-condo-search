<?php
if (!defined('ABSPATH')) {
    exit;
}

final class Calgary_Condo_Community_Schools {
    public function __construct() {
        add_shortcode('ccl_school_community', [$this, 'render']);
    }

    public function render(array $atts = []): string {
        $atts = shortcode_atts([
            'eyebrow' => 'Schools & Community',
            'title' => 'Search the area, schools, and lifestyle before you book a showing.',
            'subtitle' => 'A Calgary condo search should include the area around the building: schools, commute, parks, amenities, walkability, and community feel.',
        ], $atts, 'ccl_school_community');

        $cbe_school_finder_url = '#';
        $ccsd_school_finder_url = '#';

        ob_start();
        ?>
        <section class="ccl-section ccl-lifestyle-hub ccl-school-community ccl-lifestyle-contrast-panel ccl-lifestyle-dark-fix" aria-labelledby="ccl-lifestyle-hub-title">
            <div class="ccl-wrap">
                <div class="ccl-lifestyle-hub__header">
                    <p class="ccl-lifestyle-hub__eyebrow"><?php echo esc_html((string) $atts['eyebrow']); ?></p>
                    <h2 id="ccl-lifestyle-hub-title"><?php echo esc_html((string) $atts['title']); ?></h2>
                    <p class="ccl-lifestyle-hub__copy"><?php echo esc_html((string) $atts['subtitle']); ?></p>
                </div>
                <div class="ccl-lifestyle-hub__grid">
                    <div class="ccl-lifestyle-hub__panel-stack">
                        <article class="ccl-lifestyle-hub__panel">
                            <span class="ccl-lifestyle-hub__panel-kicker"><?php esc_html_e('School catchments', 'calgary-condo-leads'); ?></span>
                            <h3><?php esc_html_e('Public & Catholic Schools', 'calgary-condo-leads'); ?></h3>
                            <p><?php esc_html_e('Review Calgary school options near the condo communities you are comparing before you book showings.', 'calgary-condo-leads'); ?></p>
                            <button type="button" class="ccl-lifestyle-hub__primary-action" data-ccl-open-school-finder-modal><?php esc_html_e('Open School Finder', 'calgary-condo-leads'); ?></button>
                        </article>
                        <article class="ccl-lifestyle-hub__panel">
                            <span class="ccl-lifestyle-hub__panel-kicker"><?php esc_html_e('High-demand condo markets', 'calgary-condo-leads'); ?></span>
                            <h3><?php esc_html_e('Explore Communities', 'calgary-condo-leads'); ?></h3>
                            <p><?php esc_html_e('Compare proven inner-city Calgary condo areas by lifestyle, commute, amenities, and building type.', 'calgary-condo-leads'); ?></p>
                            <div class="ccl-lifestyle-hub__actions" aria-label="Explore Calgary condo communities">
                                <a class="ccl-lifestyle-hub__community-link" href="/beltline-condos/" target="_self"><?php esc_html_e('Beltline', 'calgary-condo-leads'); ?><span aria-hidden="true">→</span></a>
                                <a class="ccl-lifestyle-hub__community-link" href="/downtown-core-condos/" target="_self"><?php esc_html_e('Downtown Core', 'calgary-condo-leads'); ?><span aria-hidden="true">→</span></a>
                                <a class="ccl-lifestyle-hub__community-link" href="/eau-claire-condos/" target="_self"><?php esc_html_e('Eau Claire', 'calgary-condo-leads'); ?><span aria-hidden="true">→</span></a>
                                <a class="ccl-lifestyle-hub__community-link" href="/mission-condos/" target="_self"><?php esc_html_e('Mission', 'calgary-condo-leads'); ?><span aria-hidden="true">→</span></a>
                            </div>
                        </article>
                    </div>
                    <article class="ccl-risk-inspector" aria-labelledby="ccl-risk-inspector-title">
                        <div class="ccl-risk-inspector__header">
                            <span class="ccl-risk-inspector__kicker"><?php esc_html_e('Diagnostic dashboard', 'calgary-condo-leads'); ?></span>
                            <h3 id="ccl-risk-inspector-title"><?php esc_html_e('Building Risk Intelligence', 'calgary-condo-leads'); ?></h3>
                            <p><?php esc_html_e('A premium pre-showing screen for ownership signals that can shape condo value, financing, and resale confidence.', 'calgary-condo-leads'); ?></p>
                        </div>
                        <div class="ccl-risk-inspector__rows" aria-label="Building risk report preview metrics">
                            <div class="ccl-risk-inspector__row"><span class="ccl-risk-inspector__badge ccl-risk-inspector__badge--green" aria-hidden="true"></span><div><strong><?php esc_html_e('Reserve Fund Health', 'calgary-condo-leads'); ?></strong><p><?php esc_html_e('Review fund strength before booking showings.', 'calgary-condo-leads'); ?></p></div></div>
                            <div class="ccl-risk-inspector__row"><span class="ccl-risk-inspector__badge ccl-risk-inspector__badge--amber" aria-hidden="true"></span><div><strong><?php esc_html_e('Special Assessment Risk', 'calgary-condo-leads'); ?></strong><p><?php esc_html_e('Flag upcoming capital work and owner cost exposure.', 'calgary-condo-leads'); ?></p></div></div>
                            <div class="ccl-risk-inspector__row"><span class="ccl-risk-inspector__badge ccl-risk-inspector__badge--green" aria-hidden="true"></span><div><strong><?php esc_html_e('Concrete vs Wood Frame', 'calgary-condo-leads'); ?></strong><p><?php esc_html_e('Compare construction type, sound transfer, and buyer demand.', 'calgary-condo-leads'); ?></p></div></div>
                            <div class="ccl-risk-inspector__row"><span class="ccl-risk-inspector__badge ccl-risk-inspector__badge--orange" aria-hidden="true"></span><div><strong><?php esc_html_e('Pet / Rental Policy Fit', 'calgary-condo-leads'); ?></strong><p><?php esc_html_e('Check bylaws against your lifestyle or investment plan.', 'calgary-condo-leads'); ?></p></div></div>
                            <div class="ccl-risk-inspector__row"><span class="ccl-risk-inspector__badge ccl-risk-inspector__badge--amber" aria-hidden="true"></span><div><strong><?php esc_html_e('Insurance & Condo Fee Pressure', 'calgary-condo-leads'); ?></strong><p><?php esc_html_e('Spot cost trends that may affect monthly affordability.', 'calgary-condo-leads'); ?></p></div></div>
                            <div class="ccl-risk-inspector__row"><span class="ccl-risk-inspector__badge ccl-risk-inspector__badge--orange" aria-hidden="true"></span><div><strong><?php esc_html_e('Resale Liquidity', 'calgary-condo-leads'); ?></strong><p><?php esc_html_e('Evaluate market depth before you commit to a building.', 'calgary-condo-leads'); ?></p></div></div>
                        </div>
                        <button type="button" class="ccl-risk-inspector__cta" data-ccl-lead-open data-lead-source="Building Risk Intelligence" data-requested-category="Building Risk Report" data-intent="Building risk report request"><?php esc_html_e('Ask About Building Risk', 'calgary-condo-leads'); ?></button>
                    </article>
                </div>
            </div>
        </section>
        <div class="ccl-school-finder-modal" data-ccl-school-finder-modal hidden>
            <div class="ccl-school-finder-modal__overlay" data-ccl-school-finder-close></div>
            <div class="ccl-school-finder-modal__dialog" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e('Calgary school finder', 'calgary-condo-leads'); ?>">
                <button type="button" class="ccl-school-finder-modal__close" data-ccl-school-finder-close aria-label="<?php esc_attr_e('Close school finder', 'calgary-condo-leads'); ?>"><?php esc_html_e('✕ Close and Return to Portal', 'calgary-condo-leads'); ?></button>
                <h2><?php esc_html_e('Calgary School Finder', 'calgary-condo-leads'); ?></h2>
                <div class="ccl-school-finder-modal__tabs" aria-label="<?php esc_attr_e('Choose a school finder', 'calgary-condo-leads'); ?>">
                    <button type="button" class="ccl-school-finder-modal__tab" data-ccl-school-finder-url="<?php echo esc_url($cbe_school_finder_url); ?>"><?php esc_html_e('CBE School Finder', 'calgary-condo-leads'); ?></button>
                    <button type="button" class="ccl-school-finder-modal__tab" data-ccl-school-finder-url="<?php echo esc_url($ccsd_school_finder_url); ?>"><?php esc_html_e('CCSD School Finder', 'calgary-condo-leads'); ?></button>
                </div>
                <iframe class="ccl-school-finder-modal__iframe" data-ccl-school-finder-iframe title="<?php esc_attr_e('Calgary school finder', 'calgary-condo-leads'); ?>" hidden></iframe>
                <div class="ccl-school-finder-modal__message" data-ccl-school-finder-message>
                    <?php esc_html_e('School finder link is being connected.', 'calgary-condo-leads'); ?>
                </div>
            </div>
        </div>
        <?php
        return (string) ob_get_clean();
    }
}

new Calgary_Condo_Community_Schools();
