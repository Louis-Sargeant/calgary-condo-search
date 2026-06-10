<?php
/**
 * Plugin Name: Calgary Condo Leads
 * Description: Lead-generation shortcodes and styling for the Calgary Condo Search website.
 * Version: 0.1.0
 * Author: Louis Sargeant
 */

if (!defined('ABSPATH')) {
    exit;
}

define('CCL_VERSION', '0.1.0');
define('CCL_PLUGIN_URL', plugin_dir_url(__FILE__));
define('CCL_PLUGIN_DIR', plugin_dir_path(__FILE__));

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('calgary-condo-leads', CCL_PLUGIN_URL . 'assets/css/calgary-condo-leads.css', [], CCL_VERSION);
});

function ccl_attr($atts, $defaults = []) {
    return shortcode_atts($defaults, $atts, 'calgary_condo_leads');
}

add_shortcode('ccl_hero', function ($atts) {
    $atts = ccl_attr($atts, [
        'eyebrow' => 'Calgary Condo Search',
        'title' => 'Search Calgary Condos For Sale',
        'subtitle' => 'Browse active Calgary apartment condo listings, compare buildings, and get expert guidance before you book a showing.',
        'primary_text' => 'Search Condos',
        'primary_url' => '#idx-search',
        'secondary_text' => 'Get Condo Alerts',
        'secondary_url' => '#condo-alerts',
    ]);

    ob_start(); ?>
    <section class="ccl-hero">
        <div class="ccl-wrap ccl-hero__grid">
            <div>
                <p class="ccl-eyebrow"><?php echo esc_html($atts['eyebrow']); ?></p>
                <h1><?php echo esc_html($atts['title']); ?></h1>
                <p class="ccl-hero__subtitle"><?php echo esc_html($atts['subtitle']); ?></p>
                <div class="ccl-actions">
                    <a class="ccl-btn ccl-btn--primary" href="<?php echo esc_url($atts['primary_url']); ?>"><?php echo esc_html($atts['primary_text']); ?></a>
                    <a class="ccl-btn ccl-btn--secondary" href="<?php echo esc_url($atts['secondary_url']); ?>"><?php echo esc_html($atts['secondary_text']); ?></a>
                </div>
            </div>
            <div class="ccl-hero__panel">
                <strong>Built for Calgary condo buyers.</strong>
                <span>Search smarter. Compare faster. Ask better questions before booking a showing.</span>
            </div>
        </div>
    </section>
    <?php return ob_get_clean();
});

add_shortcode('ccl_alert_form', function ($atts) {
    $atts = ccl_attr($atts, [
        'title' => 'Get Calgary Condo Alerts Before Everyone Else',
        'subtitle' => 'Tell us what you are looking for and get matched with Calgary condo opportunities that fit your budget and preferred area.',
    ]);

    ob_start(); ?>
    <section id="condo-alerts" class="ccl-section ccl-alerts">
        <div class="ccl-wrap ccl-two-col">
            <div>
                <p class="ccl-eyebrow">Condo Alerts</p>
                <h2><?php echo esc_html($atts['title']); ?></h2>
                <p><?php echo esc_html($atts['subtitle']); ?></p>
            </div>
            <form class="ccl-form" method="post">
                <label>Name <input type="text" name="ccl_name" placeholder="Your name"></label>
                <label>Email <input type="email" name="ccl_email" placeholder="Your email"></label>
                <label>Phone <input type="tel" name="ccl_phone" placeholder="Your phone"></label>
                <label>Preferred area <input type="text" name="ccl_area" placeholder="Beltline, Downtown, Mission..."></label>
                <label>Budget <input type="text" name="ccl_budget" placeholder="$300K - $500K"></label>
                <button type="submit" class="ccl-btn ccl-btn--primary">Send Me Condo Alerts</button>
                <p class="ccl-form__note">Form routing will be connected after approval.</p>
            </form>
        </div>
    </section>
    <?php return ob_get_clean();
});

add_shortcode('ccl_value_cards', function () {
    $cards = [
        ['title' => 'Search Active Listings', 'text' => 'Browse Calgary apartment condo listings connected through the existing IDX system.'],
        ['title' => 'Compare Buildings', 'text' => 'Understand location, building type, fees, amenities, and resale value before you book.'],
        ['title' => 'Get Local Guidance', 'text' => 'Work with a Calgary-focused advisor before making a condo decision.'],
    ];

    ob_start(); ?>
    <section class="ccl-section">
        <div class="ccl-wrap ccl-cards">
            <?php foreach ($cards as $card): ?>
                <article class="ccl-card">
                    <h3><?php echo esc_html($card['title']); ?></h3>
                    <p><?php echo esc_html($card['text']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
    <?php return ob_get_clean();
});
