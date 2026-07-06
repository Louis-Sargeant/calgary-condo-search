<?php
/**
 * Unified lead modal for Calgary Condo portal CTAs.
 *
 * @package CalgaryCondoLeads
 */

if (!defined('ABSPATH')) {
    exit;
}

final class Calgary_Condo_Lead_Modal {
    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue']);
        add_action('wp_footer', [$this, 'render_modal'], 40);
    }

    public function enqueue(): void {
        if (is_admin()) {
            return;
        }

        wp_enqueue_script(
            'calgary-condo-unified-lead-modal',
            CCL_PLUGIN_URL . 'assets/js/calgary-condo-unified-lead-modal.js',
            [],
            CCL_VERSION,
            true
        );
    }

    public function render_modal(): void {
        if (is_admin()) {
            return;
        }

        $feedback = Calgary_Condo_Leads::current_feedback();
        $show_feedback = 'unified-modal' === $feedback['target'] && '' !== $feedback['status'];
        ?>
        <div id="ccl-unified-lead-modal" class="ccl-unified-lead-modal" aria-hidden="true" data-ccl-open-on-load="<?php echo $show_feedback ? 'true' : 'false'; ?>">
            <div class="ccl-unified-lead-modal__overlay" data-ccl-lead-close></div>
            <div class="ccl-unified-lead-modal__panel" role="dialog" aria-modal="true" aria-labelledby="ccl-unified-lead-title">
                <button type="button" class="ccl-unified-lead-modal__close" data-ccl-lead-close aria-label="<?php esc_attr_e('Close Calgary condo request form', 'calgary-condo-leads'); ?>">×</button>
                <p class="ccl-unified-lead-modal__eyebrow"><?php esc_html_e('Calgary Condo Help', 'calgary-condo-leads'); ?></p>
                <h2 id="ccl-unified-lead-title"><?php esc_html_e('Get the Calgary Condo List You Actually Want', 'calgary-condo-leads'); ?></h2>
                <p class="ccl-unified-lead-modal__copy"><?php esc_html_e('Tell us where you want to focus and we’ll send the active listings, building notes, and next-step guidance.', 'calgary-condo-leads'); ?></p>
                <p class="ccl-unified-lead-modal__context" data-ccl-lead-context><?php esc_html_e('You’re requesting: General Calgary Condo Help', 'calgary-condo-leads'); ?></p>
                <?php if ($show_feedback && 'success' === $feedback['status']) : ?>
                    <p class="ccl-unified-lead-modal__success" role="status"><?php echo esc_html($feedback['message']); ?></p>
                <?php elseif ($show_feedback && 'error' === $feedback['status']) : ?>
                    <p class="ccl-unified-lead-modal__error" role="alert"><?php echo esc_html($feedback['message']); ?></p>
                <?php endif; ?>
                <?php if (!$show_feedback || 'error' === $feedback['status']) : ?>
                <form class="ccl-unified-lead-modal__form" method="post" action="<?php echo esc_url($this->current_url()); ?>#condo-alerts">
                    <?php wp_nonce_field('ccl_alert_form', 'ccl_nonce'); ?>
                    <input type="hidden" name="ccl_action" value="alert_form">
                    <input type="hidden" id="ccl_lead_source" name="ccl_lead_source" value="Calgary Condo Portal">
                    <input type="hidden" id="ccl_requested_category" name="ccl_requested_category" value="General Calgary Condo Help">
                    <input type="hidden" id="ccl_requested_page" name="ccl_requested_page" value="<?php echo esc_attr($this->page_label()); ?>">
                    <input type="hidden" id="ccl_requested_url" name="ccl_requested_url" value="<?php echo esc_url($this->current_url()); ?>">
                    <input type="hidden" id="ccl_intent" name="ccl_intent" value="General inquiry">
                    <input type="hidden" id="ccl_clicked_cta" name="ccl_clicked_cta" value="">
                    <input type="hidden" id="ccl_confirmation_context" name="ccl_confirmation_context" value="request-condo-help">
                    <input type="hidden" name="ccl_feedback_target" value="unified-modal">
                    <input type="hidden" name="ccl_area" value="General Calgary Condo Help">
                    <input type="hidden" name="ccl_budget" value="">
                    <input type="hidden" name="ccl_timeline" value="">
                    <label for="ccl-unified-lead-name"><?php esc_html_e('Name', 'calgary-condo-leads'); ?> <span aria-hidden="true">*</span><input id="ccl-unified-lead-name" type="text" name="ccl_name" autocomplete="name" required></label>
                    <label for="ccl-unified-lead-email"><?php esc_html_e('Email', 'calgary-condo-leads'); ?> <span aria-hidden="true">*</span><input id="ccl-unified-lead-email" type="email" name="ccl_email" autocomplete="email" required></label>
                    <label for="ccl-unified-lead-phone"><?php esc_html_e('Phone', 'calgary-condo-leads'); ?><input id="ccl-unified-lead-phone" type="tel" name="ccl_phone" autocomplete="tel"></label>
                    <label for="ccl-unified-lead-message"><?php esc_html_e('Message / Notes', 'calgary-condo-leads'); ?><textarea id="ccl-unified-lead-message" name="ccl_message" rows="4" placeholder="<?php esc_attr_e('Area, building, budget, timing, or risk question...', 'calgary-condo-leads'); ?>"></textarea></label>
                    <label class="ccl-hp" for="ccl-unified-lead-website"><?php esc_html_e('Website', 'calgary-condo-leads'); ?><input id="ccl-unified-lead-website" type="text" name="ccl_website" tabindex="-1" autocomplete="off"></label>
                    <button type="submit" class="ccl-unified-lead-modal__submit" data-ccl-lead-submit><?php esc_html_e('Send Me the Active Condo List', 'calgary-condo-leads'); ?></button>
                    <p class="ccl-unified-lead-modal__trust"><?php esc_html_e('No spam. You’ll get a direct Calgary condo response from Louis Sargeant.', 'calgary-condo-leads'); ?></p>
                </form>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    private function page_label(): string {
        $title = wp_get_document_title();
        return '' !== $title ? $title : $this->current_url();
    }

    private function current_url(): string {
        return Calgary_Condo_Leads::current_frontend_url();
    }
}

new Calgary_Condo_Lead_Modal();
