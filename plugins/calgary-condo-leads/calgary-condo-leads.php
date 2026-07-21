<?php
/**
 * Plugin Name: Calgary Condo Leads
 * Description: Lead-generation shortcodes and styling for Calgary Condo Search pages using the myRealPage IDX plugin.
 * Version: 1.0.142
 * Author: Louis Sargeant
 * Text Domain: calgary-condo-leads
 * Requires at least: 6.0
 * Requires PHP: 7.4
 */

if (!defined('ABSPATH')) {
    exit;
}

define('CCL_VERSION', '1.0.142');
define('CCL_PLUGIN_FILE', __FILE__);
define('CCL_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CCL_PLUGIN_URL', plugin_dir_url(__FILE__));

if (!defined('CCL_CONTACT_PHONE_DISPLAY')) {
    define('CCL_CONTACT_PHONE_DISPLAY', '+1 (403) 800' . '-6996');
}

if (!defined('CCL_CONTACT_PHONE_TEL')) {
    define('CCL_CONTACT_PHONE_TEL', '+1403' . '8006996');
}

if (!defined('CCL_IDX_BROKER_CALGARY_CONDOS_RESULTS_URL')) {
    define('CCL_IDX_BROKER_CALGARY_CONDOS_RESULTS_URL', 'https://sargeantrealestate.idxbroker.com/idx/results/listings?idxID=a636&pt=1&ccz=city&city%5B%5D=6539');
}

require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-leads.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-site-sections.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-assets.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-trust-strip.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-intent-capture.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-building-risk-modal.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-lead-modal.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-homepage.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-area-pages.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-building-data-mode.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-building-directory.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-search-router.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-building-cpt.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-building-seeder.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-building-csv-importer.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-building-batch-importer.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-building-second-batch-importer.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-building-seed-runner.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-building-index.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-community-schools.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-chat-widget.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-visual-assets.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-page-overrides.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-market-update-page.php';
require_once CCL_PLUGIN_DIR . 'includes/class-calgary-condo-cleanup.php';

// Flush rewrite rules on activation so /calgary-condo-buildings/{slug}/ resolves immediately.
// Safe: runs only once on activation, never on every page load.
register_activation_hook(CCL_PLUGIN_FILE, static function (): void {
    Calgary_Condo_Building_CPT::activate();
});

// Versioned building seed runner.  Runs any outstanding batch data files on
// init (priority 30, after CPT and default terms are registered).  Idempotent.
Calgary_Condo_Building_Seed_Runner::register();


add_action('wp_footer', static function (): void {
    if (is_admin()) {
        return;
    }
    ?>
    <div id="portal-lightbox-shell" aria-hidden="true">
        <div class="portal-lightbox-panel" role="dialog" aria-modal="true" aria-label="Calgary Condo Search Portal">
            <div class="portal-lightbox-bar">
                <strong>Calgary Condo Search Portal — Direct Assistance: +1 (403) 800-6996</strong>
                <button type="button" onclick="closePortalModal()">✕ Close &amp; Return to Condo Search</button>
            </div>
            <iframe id="portal-lightbox-frame" src="about:blank" loading="lazy"></iframe>
        </div>
    </div>
    <script>
    window.openPortalModal = function(url) {
      var shell = document.getElementById('portal-lightbox-shell');
      var frame = document.getElementById('portal-lightbox-frame');
      if (!shell || !frame || !url) {
        return;
      }
      frame.src = url;
      shell.style.display = 'block';
      requestAnimationFrame(function() {
        shell.classList.add('is-active');
        shell.setAttribute('aria-hidden', 'false');
      });
    };

    window.closePortalModal = function() {
      var shell = document.getElementById('portal-lightbox-shell');
      var frame = document.getElementById('portal-lightbox-frame');
      if (!shell || !frame) {
        return;
      }
      shell.classList.remove('is-active');
      shell.setAttribute('aria-hidden', 'true');
      window.setTimeout(function() {
        shell.style.display = 'none';
        frame.src = 'about:blank';
      }, 360);
    };
    </script>
    <?php
}, 20);

add_action('wp_enqueue_scripts', static function (): void {
    wp_enqueue_style(
        'calgary-condo-school-grid-fix',
        CCL_PLUGIN_URL . 'assets/css/calgary-condo-school-grid-fix.css',
        ['calgary-condo-leads-extended'],
        CCL_VERSION
    );
}, 30);

Calgary_Condo_Leads::instance();