<?php
/**
 * Final visual cleanup layer for live Calgary condo portal pages.
 *
 * @package CalgaryCondoLeads
 */

if (!defined('ABSPATH')) {
    exit;
}

final class Calgary_Condo_Cleanup {
    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue'], 40);
    }

    public function enqueue(): void {
        wp_enqueue_style(
            'calgary-condo-leads-cleanup',
            CCL_PLUGIN_URL . 'assets/css/calgary-condo-leads-cleanup.css',
            ['calgary-condo-leads-extended'],
            CCL_VERSION
        );
    }
}

new Calgary_Condo_Cleanup();
