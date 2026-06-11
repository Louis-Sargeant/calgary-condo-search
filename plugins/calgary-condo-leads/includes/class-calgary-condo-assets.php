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
}

new Calgary_Condo_Assets();
