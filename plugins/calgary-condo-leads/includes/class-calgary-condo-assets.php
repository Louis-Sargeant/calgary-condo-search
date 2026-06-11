<?php
/**
 * Additional front-end asset loading and layout helpers for Calgary Condo Leads.
 *
 * @package CalgaryCondoLeads
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Loads supplementary styles for newer lead-generation sections.
 */
final class Calgary_Condo_Assets {
    /**
     * Wire hooks.
     */
    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_extended_styles'], 20);
        add_shortcode('ccl_idx_shell', [$this, 'render_idx_shell_shortcode']);
        add_shortcode('ccl_faq', [$this, 'render_faq_shortcode']);
        add_shortcode('ccl_sticky_cta', [$this, 'render_sticky_cta_shortcode']);
        add_shortcode('ccl_lead_magnet', [$this, 'render_lead_magnet_shortcode']);
        add_shortcode('ccl_building_scorecard', [$this, 'render_building_scorecard_shortcode']);
    }

    /**
     * Enqueue styles that depend on the main Calgary Condo Leads stylesheet.
     */
    public function enqueue_extended_styles(): void {
        wp_enqueue_style(
            'calgary-condo-leads-extended',
            CCL_PLUGIN_URL . 'assets/css/calgary-condo-leads-extended.css',
            ['calgary-condo-leads'],
            CCL_VERSION
        );
    }

    /**
     * Render a conversion-focused wrapper around the existing IDX shortcode or embed.
     *
     * @param array<string,mixed> $atts Shortcode attributes.
     * @param string|null         $content Enclosed IDX shortcode or embed.
     */
    public function render_idx_shell_shortcode(array $atts = [], ?string $content = null): string {
        $atts = shortcode_atts(
            [
                'eyebrow' => 'Live Calgary Condo Listings',
                'title' => 'Search the current Calgary condo inventory',
                'subtitle' => 'Use the live IDX search below, then compare the building, fees, rules, parking, storage, and resale path before booking showings.',
                'note' => 'Property details should be independently verified before making decisions.',
            ],
            $atts,
            'ccl_idx_shell'
        );

        $idx_content = trim((string) $content);
        $idx_output = '' !== $idx_content
            ? wp_kses_post(do_shortcode($idx_content))
            : '<p class="ccl-idx-shell__empty">Add the existing IDX shortcode inside this wrapper.</p>';

        ob_start();
        ?>
        <section id="idx-search" class="ccl-section ccl-section--white ccl-idx-shell" aria-label="<?php echo esc_attr($atts['eyebrow']); ?>">
            <div class="ccl-wrap">
                <div class="ccl-idx-shell__header">
                    <div>
                        <p class="ccl-eyebrow"><?php echo esc_html($atts['eyebrow']); ?></p>
                        <h2><?php echo esc_html($atts['title']); ?></h2>
                        <p><?php echo esc_html($atts['subtitle']); ?></p>
                    </div>
                    <a class="ccl-btn ccl-btn--dark" href="#condo-alerts"><?php esc_html_e('Get Condo Alerts', 'calgary-condo-leads'); ?></a>
                </div>
                <div class="ccl-idx-shell__frame">
                    <?php echo $idx_output; ?>
                </div>
                <p class="ccl-idx-shell__note"><?php echo esc_html($atts['note']); ?></p>
            </div>
        </section>
        <?php

        return (string) ob_get_clean();
    }

    /**
     * Render Calgary condo buyer FAQ content for SEO and objection handling.
     *
     * @param array<string,mixed> $atts Shortcode attributes.
     */
    public function render_faq_shortcode(array $atts = []): string {
        $atts = shortcode_atts(
            [
                'eyebrow' => 'Calgary Condo Questions',
                'title' => 'What buyers should ask before choosing a condo',
                'subtitle' => 'Use these questions to separate the right Calgary condo from the wrong building, weak documents, bad rules, or poor resale fit.',
            ],
            $atts,
            'ccl_faq'
        );

        $questions = [
            [
                'question' => 'What should I check before buying a Calgary condo?',
                'answer' => 'Review the condo documents, fees, reserve fund, bylaws, insurance, parking, storage, pet rules, rental rules, building condition, and resale demand before writing an offer.',
            ],
            [
                'question' => 'Are condo fees the most important thing to compare?',
                'answer' => 'Condo fees matter, but they are only one piece. Compare what is included, whether fees have been rising, the reserve fund health, insurance deductibles, amenities, utilities, and upcoming repairs.',
            ],
            [
                'question' => 'How do I know if a condo building is strong?',
                'answer' => 'Look at management quality, maintenance history, reserve fund planning, insurance, recent meeting minutes, owner-occupancy signals, buyer demand, and how similar units have performed.',
            ],
            [
                'question' => 'Should I search by area, building, or budget first?',
                'answer' => 'Start with lifestyle and budget, then narrow by building quality. A good price in the wrong building can cost more later than a stronger unit with better documents and resale demand.',
            ],
            [
                'question' => 'Can I set alerts for a specific Calgary condo building?',
                'answer' => 'Yes. Use building alerts when you want to watch specific buildings, areas, price ranges, or condo styles and move quickly when the right listing appears.',
            ],
        ];

        ob_start();
        ?>
        <section class="ccl-section ccl-faq" aria-label="<?php echo esc_attr($atts['eyebrow']); ?>">
            <div class="ccl-wrap">
                <div class="ccl-section__header">
                    <p class="ccl-eyebrow"><?php echo esc_html($atts['eyebrow']); ?></p>
                    <h2><?php echo esc_html($atts['title']); ?></h2>
                    <p><?php echo esc_html($atts['subtitle']); ?></p>
                </div>
                <div class="ccl-faq__list">
                    <?php foreach ($questions as $item) : ?>
                        <details class="ccl-faq__item">
                            <summary><?php echo esc_html($item['question']); ?></summary>
                            <p><?php echo esc_html($item['answer']); ?></p>
                        </details>
                    <?php endforeach; ?>
                </div>
                <div class="ccl-faq__cta">
                    <strong><?php esc_html_e('Not sure which building is safe to pursue?', 'calgary-condo-leads'); ?></strong>
                    <a class="ccl-btn ccl-btn--primary" href="#condo-alerts"><?php esc_html_e('Ask About A Building', 'calgary-condo-leads'); ?></a>
                </div>
            </div>
        </section>
        <?php

        return (string) ob_get_clean();
    }

    /**
     * Render an optional sticky conversion bar for search and alert actions.
     *
     * @param array<string,mixed> $atts Shortcode attributes.
     */
    public function render_sticky_cta_shortcode(array $atts = []): string {
        $atts = shortcode_atts(
            [
                'text' => 'Ready to compare Calgary condos with a plan?',
                'primary_text' => 'Search Listings',
                'primary_url' => '#idx-search',
                'secondary_text' => 'Get Alerts',
                'secondary_url' => '#condo-alerts',
            ],
            $atts,
            'ccl_sticky_cta'
        );

        ob_start();
        ?>
        <aside class="ccl-sticky-cta" aria-label="<?php esc_attr_e('Calgary condo search actions', 'calgary-condo-leads'); ?>">
            <div class="ccl-sticky-cta__inner">
                <strong><?php echo esc_html($atts['text']); ?></strong>
                <div class="ccl-sticky-cta__actions">
                    <a class="ccl-btn ccl-btn--primary" href="<?php echo esc_url($atts['primary_url']); ?>"><?php echo esc_html($atts['primary_text']); ?></a>
                    <a class="ccl-btn ccl-btn--dark" href="<?php echo esc_url($atts['secondary_url']); ?>"><?php echo esc_html($atts['secondary_text']); ?></a>
                </div>
            </div>
        </aside>
        <?php

        return (string) ob_get_clean();
    }

    /**
     * Render a lead-magnet CTA section for condo checklist and building guidance requests.
     *
     * @param array<string,mixed> $atts Shortcode attributes.
     */
    public function render_lead_magnet_shortcode(array $atts = []): string {
        $atts = shortcode_atts(
            [
                'eyebrow' => 'Free Calgary Condo Buyer Checklist',
                'title' => 'Before you book showings, know what to check',
                'subtitle' => 'Get a sharper condo search plan focused on buildings, fees, rules, parking, storage, documents, and resale fit.',
                'button_text' => 'Send Me The Checklist',
                'button_url' => '#condo-alerts',
            ],
            $atts,
            'ccl_lead_magnet'
        );

        $points = [
            'Building and document red flags to watch for.',
            'Questions to ask before booking showings.',
            'How to compare condo fees, rules, parking, and resale fit.',
        ];

        ob_start();
        ?>
        <section class="ccl-section ccl-section--white ccl-lead-magnet" aria-label="<?php echo esc_attr($atts['eyebrow']); ?>">
            <div class="ccl-wrap ccl-lead-magnet__card">
                <div>
                    <p class="ccl-eyebrow"><?php echo esc_html($atts['eyebrow']); ?></p>
                    <h2><?php echo esc_html($atts['title']); ?></h2>
                    <p><?php echo esc_html($atts['subtitle']); ?></p>
                    <a class="ccl-btn ccl-btn--primary" href="<?php echo esc_url($atts['button_url']); ?>"><?php echo esc_html($atts['button_text']); ?></a>
                </div>
                <ul class="ccl-lead-magnet__list">
                    <?php foreach ($points as $point) : ?>
                        <li><?php echo esc_html($point); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>
        <?php

        return (string) ob_get_clean();
    }

    /**
     * Render a building scorecard section for buyer self-qualification.
     *
     * @param array<string,mixed> $atts Shortcode attributes.
     */
    public function render_building_scorecard_shortcode(array $atts = []): string {
        $atts = shortcode_atts(
            [
                'eyebrow' => 'Calgary Condo Building Scorecard',
                'title' => 'Score the building before you chase the unit',
                'subtitle' => 'A condo can look good online and still be the wrong move. Use this scorecard to think through the building before booking showings or writing an offer.',
                'button_text' => 'Ask About A Building',
                'button_url' => '#condo-alerts',
            ],
            $atts,
            'ccl_building_scorecard'
        );

        $items = [
            ['label' => 'Documents', 'text' => 'Reserve fund, bylaws, minutes, budget, insurance, and disclosure package.'],
            ['label' => 'Fees', 'text' => 'Monthly fee trend, what is included, deductibles, utilities, and special-assessment risk.'],
            ['label' => 'Rules', 'text' => 'Pets, rentals, renovations, smoking, parking, storage, and move-in restrictions.'],
            ['label' => 'Resale', 'text' => 'Floor plan, building reputation, competing listings, buyer demand, and exit plan.'],
        ];

        ob_start();
        ?>
        <section class="ccl-section ccl-building-scorecard" aria-label="<?php echo esc_attr($atts['eyebrow']); ?>">
            <div class="ccl-wrap ccl-building-scorecard__grid">
                <div class="ccl-building-scorecard__intro">
                    <p class="ccl-eyebrow"><?php echo esc_html($atts['eyebrow']); ?></p>
                    <h2><?php echo esc_html($atts['title']); ?></h2>
                    <p><?php echo esc_html($atts['subtitle']); ?></p>
                    <a class="ccl-btn ccl-btn--primary" href="<?php echo esc_url($atts['button_url']); ?>"><?php echo esc_html($atts['button_text']); ?></a>
                </div>
                <div class="ccl-building-scorecard__cards">
                    <?php foreach ($items as $item) : ?>
                        <article class="ccl-building-scorecard__card">
                            <span><?php echo esc_html($item['label']); ?></span>
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

new Calgary_Condo_Assets();
