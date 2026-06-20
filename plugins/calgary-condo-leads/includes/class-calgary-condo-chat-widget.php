<?php
if (!defined('ABSPATH')) {
    exit;
}

final class Calgary_Condo_Chat_Widget {
    public function __construct() {
        add_action('wp_footer', [$this, 'render_floating_lead_widget'], 50);
    }

    public function render_floating_lead_widget(): void {
        if (is_admin()) {
            return;
        }
        ?>
        <a href="/contact/" target="_self" class="ccl-floating-lead-widget" aria-label="Request Calgary condo help">
            <span aria-hidden="true">✉</span>
            <span>Request Condo Help</span>
        </a>
        <?php
    }
}

new Calgary_Condo_Chat_Widget();
