<?php
/**
 * Premium visual upgrade asset loader.
 *
 * @package CalgaryCondoLeads
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Loads the stronger visual layer after the base plugin stylesheet.
 */
function ccl_enqueue_visual_upgrade_assets(): void {
    wp_enqueue_style(
        'calgary-condo-leads-visual',
        CCL_PLUGIN_URL . 'assets/css/calgary-condo-leads-visual.css',
        ['calgary-condo-leads'],
        CCL_VERSION
    );
}

add_action('wp_enqueue_scripts', 'ccl_enqueue_visual_upgrade_assets', 30);
