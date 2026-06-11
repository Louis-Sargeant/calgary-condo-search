<?php
/**
 * Trust strip shortcode for Calgary Condo Leads.
 *
 * @package CalgaryCondoLeads
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Adds credibility and trust signals near conversion points.
 */
final class Calgary_Condo_Trust_Strip {
    /**
     * Wire hooks.
     */
    public function __construct() {
        add_shortcode('ccl_trust_strip', [$this, 'render_shortcode']);
    }

    /**
     * Render the trust strip.
     *
     * @param array<string,mixed> $atts Shortcode attributes.
     */
    public function render_shortcode(array $atts = []): string {
        $atts = shortcode_atts(
            [
                'eyebrow' => 'Why Buyers Use This Calgary Condo Search',
                'title' => 'A cleaner way to search, compare, and choose the right condo path',
            ],
            $atts,
            'ccl_trust_strip'
        );

        $proof_points = [
            [
                'label' => 'Live IDX Search',
                'text' => 'Search current condo inventory through the approved IDX path.',
            ],
            [
                'label' => 'Building-First Guidance',
                'text' => 'Compare documents, fees, rules, parking, storage, and resale fit before chasing a unit.',
            ],
            [
                'label' => 'Buyer Alert Funnel',
                'text' => 'Turn browsing into saved searches, building alerts, and better-timed showings.',
            ],
            [
                'label' => 'Cleaner Decisions',
                'text' => 'Education sections support the search experience without changing IDX data.',
            ],
        ];

        ob_start();
        ?>
        <section class="ccl-section ccl-trust-strip" aria-label="<?php echo esc_attr($atts['eyebrow']); ?>">
            <div class="ccl-wrap">
                <div class="ccl-trust-strip__header">
                    <p class="ccl-eyebrow"><?php echo esc_html($atts['eyebrow']); ?></p>
                    <h2><?php echo esc_html($atts['title']); ?></h2>
                </div>
                <div class="ccl-trust-strip__grid">
                    <?php foreach ($proof_points as $point) : ?>
                        <article class="ccl-trust-strip__item">
                            <strong><?php echo esc_html($point['label']); ?></strong>
                            <p><?php echo esc_html($point['text']); ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php

        return (string) ob_get_clean();
    }
}

new Calgary_Condo_Trust_Strip();
