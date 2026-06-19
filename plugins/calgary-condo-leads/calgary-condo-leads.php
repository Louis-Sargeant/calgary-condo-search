<?php
/**
 * Plugin Name: Calgary Condo Leads
 * Description: Lead-generation shortcodes and styling for Calgary Condo Search pages using the myRealPage IDX plugin.
 * Version: 1.0.64
 * Author: Louis Sargeant
 * Text Domain: calgary-condo-leads
 * Requires at least: 6.0
 * Requires PHP: 7.4
 */

if (!defined('ABSPATH')) {
    exit;
}

define('CCL_VERSION', '1.0.64');
define('CCL_PLUGIN_FILE', __FILE__);
define('CCL_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CCL_PLUGIN_URL', plugin_dir_url(__FILE__));

if (!defined('CCL_CONTACT_PHONE_DISPLAY')) {
    define('CCL_CONTACT_PHONE_DISPLAY', '+1 (403) 800' . '-6996');
}

if (!defined('CCL_CONTACT_PHONE_TEL')) {
    define('CCL_CONTACT_PHONE_TEL', '+1403' . '8006996');
}

require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-leads.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-site-sections.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-assets.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-trust-strip.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-intent-capture.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-building-risk-modal.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-homepage.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-area-pages.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-building-directory.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-building-cpt.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-building-index.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-community-schools.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-chat-widget.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-visual-assets.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-page-overrides.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-market-update-page.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-cleanup.php';

Calgary_Condo_Leads::instance();
