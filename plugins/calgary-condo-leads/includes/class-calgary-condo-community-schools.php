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
                        <a class="ccl-school-community__pill" href="#" data-ccl-school-modal-url><?php esc_html_e('Open School Finder', 'calgary-condo-leads'); ?></a>
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
                    <article class="ccl-school-community__luxury-card">
                        <h3><?php esc_html_e('Condo Building Deep-Dive', 'calgary-condo-leads'); ?></h3>
                        <p><?php esc_html_e('Go beyond the unit and compare building age, bylaws, parking, pets, fees, documents, and resale fit.', 'calgary-condo-leads'); ?></p>
                        <div class="ccl-school-community__pills">
                            <a class="ccl-school-community__pill" href="/calgary-condo-buildings/" target="_self"><?php esc_html_e('Browse Buildings', 'calgary-condo-leads'); ?></a>
                            <a class="ccl-school-community__pill" href="#building-risk-report" data-ccl-open-building-risk-modal><?php esc_html_e('Ask About Building Risk', 'calgary-condo-leads'); ?></a>
                        </div>
                    </article>
                </div>
            </div>
        </section>
        <div class="ccl-school-modal" data-ccl-school-modal hidden>
            <div class="ccl-school-modal__overlay" data-ccl-school-modal-close></div>
            <div class="ccl-school-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="ccl-school-modal-title">
                <button class="ccl-school-modal__close" type="button" aria-label="<?php esc_attr_e('Close school finder', 'calgary-condo-leads'); ?>" data-ccl-school-modal-close>&times;</button>
                <h2 id="ccl-school-modal-title"><?php esc_html_e('Calgary School Finder', 'calgary-condo-leads'); ?></h2>
                <p class="ccl-school-modal__message" data-ccl-school-modal-message hidden><?php esc_html_e('School finder link is being connected.', 'calgary-condo-leads'); ?></p>
                <iframe class="ccl-school-modal__iframe" title="<?php esc_attr_e('School finder', 'calgary-condo-leads'); ?>" data-ccl-school-modal-iframe hidden></iframe>
            </div>
        </div>
        <?php
        return (string) ob_get_clean();
    }
}

new Calgary_Condo_Community_Schools();
