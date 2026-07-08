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

        $building_post_type = class_exists('Calgary_Condo_Building_CPT')
            ? Calgary_Condo_Building_CPT::POST_TYPE
            : 'ccl_building';
        if (is_singular($building_post_type)) {
            return;
        }
        ?>
        <button type="button" class="ccl-floating-lead-widget" aria-label="Request Calgary condo help" data-ccl-lead-open data-lead-source="Floating Help Button" data-requested-category="General Calgary Condo Help" data-intent="Help request">
            <span aria-hidden="true">✉</span>
            <span>Request Condo Help</span>
        </button>
        <?php
    }
}

new Calgary_Condo_Chat_Widget();
