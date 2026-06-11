<?php
/**
 * Intent capture shortcodes for Calgary Condo Leads.
 *
 * @package CalgaryCondoLeads
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Adds buyer, seller, and building-risk conversion panels.
 */
final class Calgary_Condo_Intent_Capture {
    /**
     * Wire shortcodes.
     */
    public function __construct() {
        add_shortcode('ccl_intent_capture', [$this, 'render_intent_capture_shortcode']);
        add_shortcode('ccl_next_step_band', [$this, 'render_next_step_band_shortcode']);
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
     * Render visitor-intent cards.
     *
     * @param array<string,mixed> $atts Shortcode attributes.
     */
    public function render_intent_capture_shortcode(array $atts = []): string {
        $atts = $this->shortcode_atts(
            $atts,
            [
                'eyebrow' => 'Calgary Condo Search Help',
                'title' => 'Choose the move that matches your condo search',
                'subtitle' => 'Most buyers do not need more random listings. They need the right search lane, stronger building filters, and a clear next step.',
            ],
            'ccl_intent_capture'
        );

        $cards = [
            [
                'label' => 'I want to browse condos',
                'text' => 'Start with the live IDX search, then compare the building, fees, rules, parking, storage, and resale fit before booking showings.',
                'button' => 'Search Calgary Condos',
                'url' => '#idx-search',
            ],
            [
                'label' => 'I want alerts',
                'text' => 'Get notified around your preferred Calgary area, budget, building style, and timing so the right listing does not get missed.',
                'button' => 'Set Up Condo Alerts',
                'url' => '#condo-alerts',
            ],
            [
                'label' => 'I own a condo',
                'text' => 'Request a value check based on your building, recent competition, condition, fees, demand, and current buyer pool.',
                'button' => 'Request Value Report',
                'url' => '/condo-value-report/',
            ],
            [
                'label' => 'I am worried about the building',
                'text' => 'Ask about documents, reserve fund signals, bylaws, insurance, special-assessment risk, pet rules, rental rules, and resale concerns.',
                'button' => 'Ask About Building Risk',
                'url' => '#condo-alerts',
            ],
        ];

        ob_start();
        ?>
        <section class="ccl-section ccl-section--white ccl-intent-capture" aria-label="<?php echo esc_attr($atts['eyebrow']); ?>">
            <div class="ccl-wrap">
                <div class="ccl-section__header">
                    <p class="ccl-eyebrow"><?php echo esc_html($atts['eyebrow']); ?></p>
                    <h2><?php echo esc_html($atts['title']); ?></h2>
                    <p><?php echo esc_html($atts['subtitle']); ?></p>
                </div>
                <div class="ccl-intent-capture__grid">
                    <?php foreach ($cards as $card) : ?>
                        <article class="ccl-intent-card">
                            <h3><?php echo esc_html($card['label']); ?></h3>
                            <p><?php echo esc_html($card['text']); ?></p>
                            <a class="ccl-btn ccl-btn--dark" href="<?php echo esc_url($card['url']); ?>"><?php echo esc_html($card['button']); ?></a>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php

        return (string) ob_get_clean();
    }

    /**
     * Render a compact next-step CTA band.
     *
     * @param array<string,mixed> $atts Shortcode attributes.
     */
    public function render_next_step_band_shortcode(array $atts = []): string {
        $atts = $this->shortcode_atts(
            $atts,
            [
                'eyebrow' => 'Next Step',
                'title' => 'Not sure which Calgary condo is worth seeing?',
                'subtitle' => 'Send your area, budget, and building questions. Get a cleaner shortlist before wasting time on weak buildings or bad-fit listings.',
                'primary_text' => 'Get Condo Guidance',
                'primary_url' => '#condo-alerts',
                'secondary_text' => 'Search Listings',
                'secondary_url' => '#idx-search',
            ],
            'ccl_next_step_band'
        );

        ob_start();
        ?>
        <section class="ccl-section ccl-next-step-band" aria-label="<?php echo esc_attr($atts['eyebrow']); ?>">
            <div class="ccl-wrap ccl-next-step-band__inner">
                <div>
                    <p class="ccl-eyebrow"><?php echo esc_html($atts['eyebrow']); ?></p>
                    <h2><?php echo esc_html($atts['title']); ?></h2>
                    <p><?php echo esc_html($atts['subtitle']); ?></p>
                </div>
                <div class="ccl-next-step-band__actions">
                    <a class="ccl-btn ccl-btn--primary" href="<?php echo esc_url($atts['primary_url']); ?>"><?php echo esc_html($atts['primary_text']); ?></a>
                    <a class="ccl-btn ccl-btn--secondary" href="<?php echo esc_url($atts['secondary_url']); ?>"><?php echo esc_html($atts['secondary_text']); ?></a>
                </div>
            </div>
        </section>
        <?php

        return (string) ob_get_clean();
    }
}

new Calgary_Condo_Intent_Capture();