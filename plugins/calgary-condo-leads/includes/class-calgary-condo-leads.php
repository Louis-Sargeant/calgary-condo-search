<?php
/**
 * Main Calgary Condo Leads plugin class.
 *
 * @package CalgaryCondoLeads
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Registers lead-generation assets, shortcodes, and form handling.
 */
final class Calgary_Condo_Leads {
    /**
     * Singleton instance.
     *
     * @var Calgary_Condo_Leads|null
     */
    private static $instance = null;

    /**
     * Lead post type slug.
     */
    private const LEAD_POST_TYPE = 'ccl_lead';

    /**
     * Return the singleton instance.
     */
    public static function instance(): Calgary_Condo_Leads {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Wire WordPress hooks.
     */
    private function __construct() {
        add_action('init', [$this, 'register_lead_post_type'], 0);
        add_action('init', [$this, 'handle_alert_form_submission'], 20);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('admin_menu', [$this, 'add_help_page']);
        add_filter('manage_' . self::LEAD_POST_TYPE . '_posts_columns', [$this, 'lead_columns']);
        add_action('manage_' . self::LEAD_POST_TYPE . '_posts_custom_column', [$this, 'render_lead_column'], 10, 2);

        add_shortcode('ccl_hero', [$this, 'render_hero_shortcode']);
        add_shortcode('ccl_alert_form', [$this, 'render_alert_form_shortcode']);
        add_shortcode('ccl_value_cards', [$this, 'render_value_cards_shortcode']);
    }

    /**
     * Register a private admin-visible post type for captured leads.
     */
    public function register_lead_post_type(): void {
        register_post_type(
            self::LEAD_POST_TYPE,
            [
                'labels' => [
                    'name' => __('Condo Leads', 'calgary-condo-leads'),
                    'singular_name' => __('Condo Lead', 'calgary-condo-leads'),
                    'menu_name' => __('Condo Leads', 'calgary-condo-leads'),
                    'add_new_item' => __('Add New Condo Lead', 'calgary-condo-leads'),
                    'edit_item' => __('View Condo Lead', 'calgary-condo-leads'),
                    'search_items' => __('Search Condo Leads', 'calgary-condo-leads'),
                    'not_found' => __('No condo leads found.', 'calgary-condo-leads'),
                ],
                'public' => false,
                'show_ui' => true,
                'show_in_menu' => true,
                'menu_icon' => 'dashicons-email-alt2',
                'supports' => ['title'],
                'capability_type' => 'post',
                'map_meta_cap' => true,
            ]
        );
    }

    /**
     * Enqueue front-end styles only when WordPress renders the page.
     */
    public function enqueue_assets(): void {
        wp_enqueue_style(
            'calgary-condo-leads',
            CCL_PLUGIN_URL . 'assets/css/calgary-condo-leads.css',
            [],
            CCL_VERSION
        );
    }

    /**
     * Add a lightweight admin help page with shortcode examples.
     */
    public function add_help_page(): void {
        add_submenu_page(
            'edit.php?post_type=' . self::LEAD_POST_TYPE,
            __('Calgary Condo Leads Help', 'calgary-condo-leads'),
            __('Shortcodes', 'calgary-condo-leads'),
            'edit_posts',
            'ccl-shortcodes',
            [$this, 'render_help_page']
        );
    }

    /**
     * Render the plugin help page.
     */
    public function render_help_page(): void {
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('Calgary Condo Leads Shortcodes', 'calgary-condo-leads'); ?></h1>
            <p><?php esc_html_e('Use these shortcodes around the existing myRealPage IDX shortcode or search page. This plugin does not replace, modify, or seed IDX listing data.', 'calgary-condo-leads'); ?></p>
            <h2><?php esc_html_e('Recommended Calgary condo page layout', 'calgary-condo-leads'); ?></h2>
            <pre>[ccl_hero primary_url="#idx-search" secondary_url="#condo-alerts"]
[ccl_quick_search]

&lt;div id="idx-search"&gt;
    Keep your existing myRealPage IDX shortcode here.
&lt;/div&gt;

[ccl_value_cards]
[ccl_area_grid]
[ccl_price_grid]
[ccl_market_snapshot]
[ccl_building_checklist]
[ccl_buyer_path]
[ccl_building_cta]
[ccl_alert_form]
[ccl_seller_cta]
[ccl_site_footer]</pre>
            <h2><?php esc_html_e('Available shortcodes', 'calgary-condo-leads'); ?></h2>
            <ul>
                <li><code>[ccl_hero]</code> &mdash; <?php esc_html_e('Hero section with two calls to action.', 'calgary-condo-leads'); ?></li>
                <li><code>[ccl_quick_search]</code> &mdash; <?php esc_html_e('High-intent quick search cards for Calgary condo buyers.', 'calgary-condo-leads'); ?></li>
                <li><code>[ccl_value_cards]</code> &mdash; <?php esc_html_e('Three trust/value proposition cards.', 'calgary-condo-leads'); ?></li>
                <li><code>[ccl_area_grid]</code> &mdash; <?php esc_html_e('Calgary condo area cards.', 'calgary-condo-leads'); ?></li>
                <li><code>[ccl_price_grid]</code> &mdash; <?php esc_html_e('Calgary condo budget cards.', 'calgary-condo-leads'); ?></li>
                <li><code>[ccl_market_snapshot]</code> &mdash; <?php esc_html_e('Market education section that helps buyers compare building strength, monthly cost, lifestyle fit, and resale path without adding fake market statistics.', 'calgary-condo-leads'); ?></li>
                <li><code>[ccl_building_checklist]</code> &mdash; <?php esc_html_e('Condo building due-diligence checklist for documents, fees, rules, unit details, building demand, and offer strategy.', 'calgary-condo-leads'); ?></li>
                <li><code>[ccl_buyer_path]</code> &mdash; <?php esc_html_e('Buyer guidance section for building, fee, bylaw, and resale checks.', 'calgary-condo-leads'); ?></li>
                <li><code>[ccl_building_cta]</code> &mdash; <?php esc_html_e('Building-alert call to action.', 'calgary-condo-leads'); ?></li>
                <li><code>[ccl_alert_form]</code> &mdash; <?php esc_html_e('Condo alert lead form. Leads are saved under Condo Leads and emailed to the site admin address.', 'calgary-condo-leads'); ?></li>
                <li><code>[ccl_seller_cta]</code> &mdash; <?php esc_html_e('Calgary condo owner valuation call to action with Calgary phone number.', 'calgary-condo-leads'); ?></li>
                <li><code>[ccl_site_footer]</code> &mdash; <?php esc_html_e('Calgary-only footer/contact block.', 'calgary-condo-leads'); ?></li>
            </ul>
            <h2><?php esc_html_e('Launch rules', 'calgary-condo-leads'); ?></h2>
            <ul>
                <li><?php esc_html_e('Keep Coming Soon mode on until IDX, forms, links, mobile, and Calgary contact information are checked.', 'calgary-condo-leads'); ?></li>
                <li><?php esc_html_e('Use Calgary phone number only on this site.', 'calgary-condo-leads'); ?></li>
                <li><?php esc_html_e('Do not replace or edit the approved myRealPage IDX plugin from this lead-generation plugin.', 'calgary-condo-leads'); ?></li>
                <li><?php esc_html_e('Do not add fake listings, fake MLS content, scraped market data, or unverified market statistics.', 'calgary-condo-leads'); ?></li>
            </ul>
        </div>
        <?php
    }

    /**
     * Customize lead list columns.
     *
     * @param array<string,string> $columns Default columns.
     * @return array<string,string>
     */
    public function lead_columns(array $columns): array {
        return [
            'cb' => $columns['cb'] ?? '',
            'title' => __('Lead', 'calgary-condo-leads'),
            'ccl_email' => __('Email', 'calgary-condo-leads'),
            'ccl_phone' => __('Phone', 'calgary-condo-leads'),
            'ccl_area' => __('Preferred Area', 'calgary-condo-leads'),
            'ccl_budget' => __('Budget', 'calgary-condo-leads'),
            'date' => __('Date', 'calgary-condo-leads'),
        ];
    }

    /**
     * Render custom lead list column values.
     *
     * @param string $column Column name.
     * @param int    $post_id Post ID.
     */
    public function render_lead_column(string $column, int $post_id): void {
        if (!in_array($column, ['ccl_email', 'ccl_phone', 'ccl_area', 'ccl_budget'], true)) {
            return;
        }

        echo esc_html((string) get_post_meta($post_id, '_' . $column, true));
    }

    /**
     * Normalize shortcode attributes.
     *
     * @param array<string,mixed> $atts Shortcode attributes.
     * @param array<string,mixed> $defaults Default attributes.
     * @param string              $shortcode Shortcode name.
     * @return array<string,string>
     */
    private function shortcode_atts(array $atts, array $defaults, string $shortcode): array {
        $normalized = shortcode_atts($defaults, $atts, $shortcode);

        return array_map('strval', $normalized);
    }

    /**
     * Render the hero shortcode.
     *
     * @param array<string,mixed> $atts Shortcode attributes.
     */
    public function render_hero_shortcode(array $atts = []): string {
        $atts = $this->shortcode_atts(
            $atts,
            [
                'eyebrow' => 'Calgary Condo Search',
                'title' => 'Search Calgary Condos For Sale',
                'subtitle' => 'Browse Calgary apartment condo listings with the existing IDX search, compare buildings, and get expert guidance before you book a showing.',
                'primary_text' => 'Search Condos',
                'primary_url' => '#idx-search',
                'secondary_text' => 'Get Condo Alerts',
                'secondary_url' => '#condo-alerts',
                'panel_title' => 'Built for Calgary condo buyers.',
                'panel_text' => 'Search smarter, compare faster, and ask better questions before booking a showing.',
            ],
            'ccl_hero'
        );

        ob_start();
        ?>
        <section class="ccl-hero" aria-label="<?php echo esc_attr($atts['eyebrow']); ?>">
            <div class="ccl-wrap ccl-hero__grid">
                <div class="ccl-hero__content">
                    <p class="ccl-eyebrow"><?php echo esc_html($atts['eyebrow']); ?></p>
                    <h1><?php echo esc_html($atts['title']); ?></h1>
                    <p class="ccl-hero__subtitle"><?php echo esc_html($atts['subtitle']); ?></p>
                    <div class="ccl-actions">
                        <a class="ccl-btn ccl-btn--primary" href="<?php echo esc_url($atts['primary_url']); ?>"><?php echo esc_html($atts['primary_text']); ?></a>
                        <a class="ccl-btn ccl-btn--secondary" href="<?php echo esc_url($atts['secondary_url']); ?>"><?php echo esc_html($atts['secondary_text']); ?></a>
                    </div>
                </div>
                <div class="ccl-hero__panel">
                    <strong><?php echo esc_html($atts['panel_title']); ?></strong>
                    <span><?php echo esc_html($atts['panel_text']); ?></span>
                </div>
            </div>
        </section>
        <?php

        return (string) ob_get_clean();
    }

    /**
     * Render the condo alert lead form shortcode.
     *
     * @param array<string,mixed> $atts Shortcode attributes.
     */
    public function render_alert_form_shortcode(array $atts = []): string {
        $atts = $this->shortcode_atts(
            $atts,
            [
                'title' => 'Get Calgary Condo Alerts',
                'subtitle' => 'Tell us what you are looking for. We will follow up with guidance based on your preferred Calgary area, budget, and timing.',
                'button_text' => 'Send Me Condo Alerts',
                'privacy_text' => 'Your details stay with Calgary Condo Search and are used only to follow up about your condo search.',
                'success_message' => 'Thanks. Your condo alert request has been received.',
            ],
            'ccl_alert_form'
        );

        $status = isset($_GET['ccl_status']) ? sanitize_key(wp_unslash($_GET['ccl_status'])) : '';

        ob_start();
        ?>
        <section id="condo-alerts" class="ccl-section ccl-alerts">
            <div class="ccl-wrap ccl-two-col">
                <div class="ccl-section__intro">
                    <p class="ccl-eyebrow"><?php esc_html_e('Condo Alerts', 'calgary-condo-leads'); ?></p>
                    <h2><?php echo esc_html($atts['title']); ?></h2>
                    <p><?php echo esc_html($atts['subtitle']); ?></p>
                </div>
                <form class="ccl-form" method="post" action="<?php echo esc_url($this->current_url()); ?>#condo-alerts">
                    <?php wp_nonce_field('ccl_alert_form', 'ccl_nonce'); ?>
                    <input type="hidden" name="ccl_action" value="alert_form">
                    <label for="ccl-name"><?php esc_html_e('Name', 'calgary-condo-leads'); ?> <span aria-hidden="true">*</span>
                        <input id="ccl-name" type="text" name="ccl_name" autocomplete="name" required placeholder="<?php esc_attr_e('Your name', 'calgary-condo-leads'); ?>">
                    </label>
                    <label for="ccl-email"><?php esc_html_e('Email', 'calgary-condo-leads'); ?> <span aria-hidden="true">*</span>
                        <input id="ccl-email" type="email" name="ccl_email" autocomplete="email" required placeholder="<?php esc_attr_e('you@example.com', 'calgary-condo-leads'); ?>">
                    </label>
                    <label for="ccl-phone"><?php esc_html_e('Phone', 'calgary-condo-leads'); ?>
                        <input id="ccl-phone" type="tel" name="ccl_phone" autocomplete="tel" placeholder="<?php esc_attr_e('Your phone number', 'calgary-condo-leads'); ?>">
                    </label>
                    <label for="ccl-area"><?php esc_html_e('Preferred Calgary area', 'calgary-condo-leads'); ?>
                        <input id="ccl-area" type="text" name="ccl_area" placeholder="<?php esc_attr_e('Beltline, Downtown, Mission...', 'calgary-condo-leads'); ?>">
                    </label>
                    <label for="ccl-budget"><?php esc_html_e('Budget', 'calgary-condo-leads'); ?>
                        <input id="ccl-budget" type="text" name="ccl_budget" placeholder="<?php esc_attr_e('$300K - $500K', 'calgary-condo-leads'); ?>">
                    </label>
                    <label for="ccl-timeline"><?php esc_html_e('Timeline', 'calgary-condo-leads'); ?>
                        <select id="ccl-timeline" name="ccl_timeline">
                            <option value=""><?php esc_html_e('Select a timeline', 'calgary-condo-leads'); ?></option>
                            <option value="Immediately"><?php esc_html_e('Immediately', 'calgary-condo-leads'); ?></option>
                            <option value="1-3 months"><?php esc_html_e('1-3 months', 'calgary-condo-leads'); ?></option>
                            <option value="3-6 months"><?php esc_html_e('3-6 months', 'calgary-condo-leads'); ?></option>
                            <option value="6+ months"><?php esc_html_e('6+ months', 'calgary-condo-leads'); ?></option>
                        </select>
                    </label>
                    <label for="ccl-message"><?php esc_html_e('What should we help you find?', 'calgary-condo-leads'); ?>
                        <textarea id="ccl-message" name="ccl_message" rows="4" placeholder="<?php esc_attr_e('Building preferences, must-haves, parking, pet rules, or questions...', 'calgary-condo-leads'); ?>"></textarea>
                    </label>
                    <label class="ccl-hp" for="ccl-website"><?php esc_html_e('Website', 'calgary-condo-leads'); ?>
                        <input id="ccl-website" type="text" name="ccl_website" tabindex="-1" autocomplete="off">
                    </label>
                    <button type="submit" class="ccl-btn ccl-btn--primary"><?php echo esc_html($atts['button_text']); ?></button>
                    <p class="ccl-form__note"><?php echo esc_html($atts['privacy_text']); ?></p>
                    <?php if ('success' === $status) : ?>
                        <p class="ccl-form__message ccl-form__message--success" role="status"><?php echo esc_html($atts['success_message']); ?></p>
                    <?php elseif ('error' === $status) : ?>
                        <p class="ccl-form__message ccl-form__message--error" role="alert"><?php esc_html_e('Please check the required fields and try again.', 'calgary-condo-leads'); ?></p>
                    <?php endif; ?>
                </form>
            </div>
        </section>
        <?php

        return (string) ob_get_clean();
    }

    /**
     * Render value proposition cards.
     *
     * @param array<string,mixed> $atts Shortcode attributes.
     */
    public function render_value_cards_shortcode(array $atts = []): string {
        $atts = $this->shortcode_atts(
            $atts,
            [
                'title_1' => 'Use the Existing IDX Search',
                'text_1' => 'Keep visitors focused on live listings from the site’s approved myRealPage IDX setup.',
                'title_2' => 'Compare Condo Details',
                'text_2' => 'Prompt buyers to think about location, fees, amenities, parking, pet rules, and resale value.',
                'title_3' => 'Capture Better Leads',
                'text_3' => 'Give serious buyers a simple next step when they want tailored Calgary condo guidance.',
            ],
            'ccl_value_cards'
        );

        $cards = [
            ['title' => $atts['title_1'], 'text' => $atts['text_1']],
            ['title' => $atts['title_2'], 'text' => $atts['text_2']],
            ['title' => $atts['title_3'], 'text' => $atts['text_3']],
        ];

        ob_start();
        ?>
        <section class="ccl-section ccl-section--white" aria-label="<?php esc_attr_e('Calgary condo search benefits', 'calgary-condo-leads'); ?>">
            <div class="ccl-wrap ccl-cards">
                <?php foreach ($cards as $card) : ?>
                    <article class="ccl-card">
                        <h3><?php echo esc_html($card['title']); ?></h3>
                        <p><?php echo esc_html($card['text']); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
        <?php

        return (string) ob_get_clean();
    }

    /**
     * Handle lead submissions.
     */
    public function handle_alert_form_submission(): void {
        if (!isset($_POST['ccl_action']) || 'alert_form' !== sanitize_key(wp_unslash($_POST['ccl_action']))) {
            return;
        }

        $redirect_error = add_query_arg('ccl_status', 'error', $this->current_url(false));

        if (!isset($_POST['ccl_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['ccl_nonce'])), 'ccl_alert_form')) {
            wp_safe_redirect($redirect_error . '#condo-alerts');
            exit;
        }

        $honeypot = isset($_POST['ccl_website']) ? sanitize_text_field(wp_unslash($_POST['ccl_website'])) : '';
        if ('' !== $honeypot) {
            wp_safe_redirect(add_query_arg('ccl_status', 'success', $this->current_url(false)) . '#condo-alerts');
            exit;
        }

        $lead = [
            'name' => isset($_POST['ccl_name']) ? sanitize_text_field(wp_unslash($_POST['ccl_name'])) : '',
            'email' => isset($_POST['ccl_email']) ? sanitize_email(wp_unslash($_POST['ccl_email'])) : '',
            'phone' => isset($_POST['ccl_phone']) ? sanitize_text_field(wp_unslash($_POST['ccl_phone'])) : '',
            'area' => isset($_POST['ccl_area']) ? sanitize_text_field(wp_unslash($_POST['ccl_area'])) : '',
            'budget' => isset($_POST['ccl_budget']) ? sanitize_text_field(wp_unslash($_POST['ccl_budget'])) : '',
            'timeline' => isset($_POST['ccl_timeline']) ? sanitize_text_field(wp_unslash($_POST['ccl_timeline'])) : '',
            'message' => isset($_POST['ccl_message']) ? sanitize_textarea_field(wp_unslash($_POST['ccl_message'])) : '',
        ];

        if ('' === $lead['name'] || !is_email($lead['email'])) {
            wp_safe_redirect($redirect_error . '#condo-alerts');
            exit;
        }

        $post_id = wp_insert_post(
            [
                'post_type' => self::LEAD_POST_TYPE,
                'post_status' => 'private',
                'post_title' => sprintf(
                    /* translators: 1: lead name, 2: lead email */
                    __('Condo alert request from %1$s <%2$s>', 'calgary-condo-leads'),
                    $lead['name'],
                    $lead['email']
                ),
            ],
            true
        );

        if (is_wp_error($post_id)) {
            wp_safe_redirect($redirect_error . '#condo-alerts');
            exit;
        }

        foreach ($lead as $key => $value) {
            update_post_meta((int) $post_id, '_ccl_' . $key, $value);
        }

        $this->email_lead_notification($lead, (int) $post_id);

        wp_safe_redirect(add_query_arg('ccl_status', 'success', $this->current_url(false)) . '#condo-alerts');
        exit;
    }

    /**
     * Email the site admin when a lead is received.
     *
     * @param array<string,string> $lead Lead values.
     * @param int                  $post_id Lead post ID.
     */
    private function email_lead_notification(array $lead, int $post_id): void {
        $to = get_option('admin_email');
        if (!is_email($to)) {
            return;
        }

        $subject = sprintf(
            /* translators: %s: lead name */
            __('New Calgary condo alert request from %s', 'calgary-condo-leads'),
            $lead['name']
        );

        $body = implode(
            "\n",
            [
                __('A new Calgary Condo Search lead was submitted.', 'calgary-condo-leads'),
                '',
                sprintf(__('Name: %s', 'calgary-condo-leads'), $lead['name']),
                sprintf(__('Email: %s', 'calgary-condo-leads'), $lead['email']),
                sprintf(__('Phone: %s', 'calgary-condo-leads'), $lead['phone']),
                sprintf(__('Preferred area: %s', 'calgary-condo-leads'), $lead['area']),
                sprintf(__('Budget: %s', 'calgary-condo-leads'), $lead['budget']),
                sprintf(__('Timeline: %s', 'calgary-condo-leads'), $lead['timeline']),
                sprintf(__('Message: %s', 'calgary-condo-leads'), $lead['message']),
                '',
                sprintf(__('Lead ID: %d', 'calgary-condo-leads'), $post_id),
            ]
        );

        wp_mail($to, $subject, $body);
    }

    /**
     * Build the current front-end URL.
     *
     * @param bool $include_query Whether to include current query parameters.
     */
    private function current_url(bool $include_query = true): string {
        $scheme = is_ssl() ? 'https' : 'http';
        $host = isset($_SERVER['HTTP_HOST']) ? sanitize_text_field(wp_unslash($_SERVER['HTTP_HOST'])) : '';
        $request_uri = isset($_SERVER['REQUEST_URI']) ? sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI'])) : '/';

        if (!$include_query) {
            $request_uri = strtok($request_uri, '?') ?: '/';
        }

        return esc_url_raw($scheme . '://' . $host . $request_uri);
    }
}
