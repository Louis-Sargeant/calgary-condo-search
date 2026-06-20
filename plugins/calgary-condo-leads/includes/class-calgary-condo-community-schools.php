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
        <section class="ccl-section ccl-section--white ccl-school-community">
            <div class="ccl-wrap">
                <div class="ccl-section__header ccl-section__header--centered">
                    <p class="ccl-eyebrow"><?php echo esc_html((string) $atts['eyebrow']); ?></p>
                    <h2><?php echo esc_html((string) $atts['title']); ?></h2>
                    <p><?php echo esc_html((string) $atts['subtitle']); ?></p>
                </div>
                <div class="ccl-school-community__luxury-grid">
                    <article class="ccl-school-community__luxury-card">
                        <h3><?php esc_html_e('Public & Catholic Schools', 'calgary-condo-leads'); ?></h3>
                        <p><?php esc_html_e('Review Calgary school options near the condo communities you are comparing.', 'calgary-condo-leads'); ?></p>
                        <a class="ccl-school-community__pill" href="/calgary-school-finder/" target="_self" data-ccl-open-school-finder-modal><?php esc_html_e('Open School Finder', 'calgary-condo-leads'); ?></a>
                    </article>
                    <article class="ccl-school-community__luxury-card">
                        <h3><?php esc_html_e('Explore Communities', 'calgary-condo-leads'); ?></h3>
                        <p><?php esc_html_e('Compare Calgary condo areas by lifestyle, commute, amenities, and building type.', 'calgary-condo-leads'); ?></p>
                        <div class="ccl-school-community__pills">
                            <a class="ccl-school-community__pill" href="/southeast-calgary-condos/" target="_self"><?php esc_html_e('Southeast Calgary', 'calgary-condo-leads'); ?></a>
                            <a class="ccl-school-community__pill" href="/southwest-calgary-condos/" target="_self"><?php esc_html_e('Southwest Calgary', 'calgary-condo-leads'); ?></a>
                            <a class="ccl-school-community__pill" href="/northwest-calgary-condos/" target="_self"><?php esc_html_e('Northwest Calgary', 'calgary-condo-leads'); ?></a>
                            <a class="ccl-school-community__pill" href="/northeast-calgary-condos/" target="_self"><?php esc_html_e('Northeast Calgary', 'calgary-condo-leads'); ?></a>
                        </div>
                    </article>
                    <article class="ccl-school-community__luxury-card ccl-risk-dashboard" aria-labelledby="ccl-risk-dashboard-title">
                        <div class="ccl-risk-dashboard__header">
                            <span class="ccl-risk-dashboard__step"><?php esc_html_e('Diagnostic dashboard', 'calgary-condo-leads'); ?></span>
                            <h3 id="ccl-risk-dashboard-title"><?php esc_html_e('Building Risk Intelligence', 'calgary-condo-leads'); ?></h3>
                            <p><?php esc_html_e('Preview the ownership signals buyers should review before booking showings or writing an offer.', 'calgary-condo-leads'); ?></p>
                        </div>
                        <div class="ccl-risk-dashboard__metrics" aria-label="Building risk report preview metrics">
                            <div class="ccl-risk-dashboard__metric"><span><?php esc_html_e('Reserve Fund Health', 'calgary-condo-leads'); ?></span><i style="--ccl-risk-level: 82%"></i></div>
                            <div class="ccl-risk-dashboard__metric"><span><?php esc_html_e('Special Assessment Risk', 'calgary-condo-leads'); ?></span><i style="--ccl-risk-level: 64%"></i></div>
                            <div class="ccl-risk-dashboard__metric"><span><?php esc_html_e('Concrete vs Wood Frame', 'calgary-condo-leads'); ?></span><i style="--ccl-risk-level: 74%"></i></div>
                            <div class="ccl-risk-dashboard__metric"><span><?php esc_html_e('Pet / Rental Policy Fit', 'calgary-condo-leads'); ?></span><i style="--ccl-risk-level: 58%"></i></div>
                            <div class="ccl-risk-dashboard__metric"><span><?php esc_html_e('Insurance & Condo Fee Pressure', 'calgary-condo-leads'); ?></span><i style="--ccl-risk-level: 70%"></i></div>
                            <div class="ccl-risk-dashboard__metric"><span><?php esc_html_e('Resale Liquidity', 'calgary-condo-leads'); ?></span><i style="--ccl-risk-level: 77%"></i></div>
                        </div>
                        <div class="ccl-school-community__pills ccl-risk-dashboard__actions">
                            <a class="ccl-school-community__pill" href="/calgary-condo-buildings/" target="_self"><?php esc_html_e('Browse Buildings', 'calgary-condo-leads'); ?></a>
                            <a class="ccl-school-community__pill ccl-risk-dashboard__cta" href="/building-alerts/" target="_self" data-ccl-open-building-risk-modal><?php esc_html_e('Request Building Risk Report', 'calgary-condo-leads'); ?></a>
                        </div>
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
