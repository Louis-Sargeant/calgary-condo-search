<?php
/**
 * Plugin Name: Calgary Condo Leads
 * Description: Self-contained lead-generation shortcodes and styling for Calgary Condo Search pages that use the existing myRealPage IDX plugin.
 * Version: 1.0.2
 * Author: Louis Sargeant
 * Text Domain: calgary-condo-leads
 * Requires at least: 6.0
 * Requires PHP: 7.4
 */

if (!defined('ABSPATH')) {
    exit;
}

define('CCL_VERSION', '1.0.2');
define('CCL_PLUGIN_FILE', __FILE__);
define('CCL_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CCL_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-leads.php';

Calgary_Condo_Leads::instance();