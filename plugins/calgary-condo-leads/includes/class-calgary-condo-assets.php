<?php
/**
 * Additional front-end asset loading for Calgary Condo Leads.
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
}

new Calgary_Condo_Assets();
