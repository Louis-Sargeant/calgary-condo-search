<?php
/**
 * Building risk report inquiry modal.
 *
 * @package CalgaryCondoLeads
 */

if (!defined('ABSPATH')) {
    exit;
}

final class Calgary_Condo_Building_Risk_Modal {
    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue']);
        add_action('wp_footer', [$this, 'render_modal']);
    }

    public function enqueue(): void {
        if (is_admin()) {
            return;
        }

        wp_enqueue_script(
            'calgary-condo-building-risk-modal',
            CCL_PLUGIN_URL . 'assets/js/calgary-condo-building-risk-modal.js',
            [],
            CCL_VERSION,
            true
        );
    }

    public function render_modal(): void {
        if (is_admin()) {
            return;
        }
        ?>
        <div class="ccl-building-risk-modal" data-ccl-risk-modal hidden>
            <div class="ccl-building-risk-modal__overlay" data-ccl-close-building-risk-modal></div>
            <div class="ccl-building-risk-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="ccl-building-risk-modal-title">
                <button class="ccl-building-risk-modal__close" type="button" aria-label="<?php esc_attr_e('Close building risk report request', 'calgary-condo-leads'); ?>" data-ccl-close-building-risk-modal>&times;</button>
                <div class="ccl-building-risk-modal__intro">
                    <p class="ccl-eyebrow"><?php esc_html_e('Building Due Diligence', 'calgary-condo-leads'); ?></p>
                    <h2 id="ccl-building-risk-modal-title"><?php esc_html_e('Request a Calgary Condo Building Risk Report', 'calgary-condo-leads'); ?></h2>
                    <p><?php esc_html_e('Tell us which building you’re considering and we’ll help flag the ownership details buyers should review before booking showings — including condo fees, bylaws, reserve fund signals, insurance, parking, pet rules, rental restrictions, and resale fit.', 'calgary-condo-leads'); ?></p>
                </div>
                <form class="ccl-building-risk-modal__form" method="post" action="<?php echo esc_url($this->current_url()); ?>#condo-alerts">
                    <?php wp_nonce_field('ccl_alert_form', 'ccl_nonce'); ?>
                    <input type="hidden" name="ccl_action" value="alert_form">
                    <input type="hidden" name="ccl_area" value="Building risk inquiry">
                    <input type="hidden" name="ccl_budget" value="">
                    <input type="hidden" name="ccl_timeline" value="">
                    <label for="ccl-risk-name"><?php esc_html_e('Name', 'calgary-condo-leads'); ?> <span aria-hidden="true">*</span>
                        <input id="ccl-risk-name" type="text" name="ccl_name" autocomplete="name" required>
                    </label>
                    <label for="ccl-risk-email"><?php esc_html_e('Email', 'calgary-condo-leads'); ?> <span aria-hidden="true">*</span>
                        <input id="ccl-risk-email" type="email" name="ccl_email" autocomplete="email" required>
                    </label>
                    <label for="ccl-risk-phone"><?php esc_html_e('Phone', 'calgary-condo-leads'); ?>
                        <input id="ccl-risk-phone" type="tel" name="ccl_phone" autocomplete="tel">
                    </label>
                    <label for="ccl-risk-message"><?php esc_html_e('Which condo building or address are you investigating?', 'calgary-condo-leads'); ?>
                        <textarea id="ccl-risk-message" name="ccl_message" rows="5" placeholder="<?php esc_attr_e('Building name, address, unit number, or community...', 'calgary-condo-leads'); ?>"></textarea>
                    </label>
                    <label class="ccl-hp" for="ccl-risk-website"><?php esc_html_e('Website', 'calgary-condo-leads'); ?>
                        <input id="ccl-risk-website" type="text" name="ccl_website" tabindex="-1" autocomplete="off">
                    </label>
                    <button type="submit" class="ccl-building-risk-modal__submit"><?php esc_html_e('Request Building Risk Report', 'calgary-condo-leads'); ?></button>
                </form>
            </div>
        </div>
        <?php
    }

    private function current_url(): string {
        $scheme = is_ssl() ? 'https://' : 'http://';
        $host = isset($_SERVER['HTTP_HOST']) ? sanitize_text_field(wp_unslash($_SERVER['HTTP_HOST'])) : '';
        $uri = isset($_SERVER['REQUEST_URI']) ? sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI'])) : '/';
        return remove_query_arg(['ccl_status'], $scheme . $host . $uri);
    }
}

new Calgary_Condo_Building_Risk_Modal();
