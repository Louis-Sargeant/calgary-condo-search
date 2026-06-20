<?php
if (!defined('ABSPATH')) {
    exit;
}

final class Calgary_Condo_Compare {
    public function __construct() {
        add_shortcode('ccl_compare_buildings', [$this, 'render_shortcode']);
        add_filter('the_content', [$this, 'replace_condo_buildings_page'], 999);
    }

    public function replace_condo_buildings_page(string $content): string {
        if (is_admin() || !is_singular('page') || !is_main_query() || !in_the_loop()) {
            return $content;
        }

        if (!is_page('condo-buildings')) {
            return $content;
        }

        return do_shortcode('[ccl_compare_buildings] [ccl_alert_form title="Request a Calgary Building Comparison" subtitle="Tell us the areas, buildings, budget, parking needs, pet rules, and timeline. We will help narrow the right options before you book showings." button_text="Send My Building Comparison Request"]');
    }

    public function render_shortcode(array $atts = []): string {
        $phone_display = defined('CCL_CONTACT_PHONE_DISPLAY') ? CCL_CONTACT_PHONE_DISPLAY : '+1 (403) 800-6996';
        $phone_tel = defined('CCL_CONTACT_PHONE_TEL') ? CCL_CONTACT_PHONE_TEL : '+14038006996';

        $checks = [
            ['title' => 'Area fit', 'text' => 'Compare lifestyle, commute, walkability, transit, restaurants, pathways, and daily convenience.'],
            ['title' => 'Building strength', 'text' => 'Look at age, construction type, management, maintenance history, elevators, amenities, and reserve fund signals.'],
            ['title' => 'True monthly cost', 'text' => 'Compare price with condo fees, utilities, taxes, insurance, parking, storage, and assessment risk.'],
            ['title' => 'Rules and restrictions', 'text' => 'Check pets, rentals, renovations, move-in rules, parking, storage, and amenity access.'],
            ['title' => 'Resale path', 'text' => 'Compare floor plan, exposure, view, parking, building reputation, buyer demand, and exit strategy.'],
            ['title' => 'Showing shortlist', 'text' => 'Build a shortlist of stronger buildings before spending time on weak options or risky documents.'],
        ];

        ob_start();
        ?>
        <section class="ccl-section ccl-section--white ccl-compare-hero">
            <div class="ccl-wrap ccl-compare-hero__inner">
                <div>
                    <p class="ccl-eyebrow">Compare Calgary Condo Buildings</p>
                    <h1>Compare the building before you book the showing.</h1>
                    <p>Price and photos are only the start. Strong Calgary condo buyers compare the building, fees, rules, documents, parking, storage, lifestyle fit, and resale path before making a move.</p>
                </div>
                <div class="ccl-compare-hero__actions">
                    <a class="ccl-btn ccl-btn--primary" href="#building-comparison-request" target="_self">Request Building Comparison</a>
                    <a class="ccl-btn ccl-btn--dark" href="tel:<?php echo esc_attr($phone_tel); ?>">Call <?php echo esc_html($phone_display); ?></a>
                </div>
            </div>
        </section>

        <section class="ccl-section ccl-compare-checks">
            <div class="ccl-wrap">
                <div class="ccl-section__header">
                    <p class="ccl-eyebrow">What To Compare</p>
                    <h2>The condo building matters as much as the unit.</h2>
                    <p>Two units can look similar online and carry very different risk. These are the comparison points that help separate strong options from weak ones.</p>
                </div>
                <div class="ccl-info-grid">
                    <?php foreach ($checks as $check) : ?>
                        <article class="ccl-card ccl-info-card">
                            <h3><?php echo esc_html($check['title']); ?></h3>
                            <p><?php echo esc_html($check['text']); ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section id="building-comparison-request" class="ccl-section ccl-compare-next-step">
            <div class="ccl-wrap ccl-feature-band">
                <div>
                    <p class="ccl-eyebrow">Building Comparison Request</p>
                    <h2>Send the buildings or areas you are considering.</h2>
                    <p>Get help narrowing the list before showings. Compare fees, bylaws, parking, storage, pet rules, documents, and resale path with a Calgary condo-focused plan.</p>
                </div>
                <button type="button" class="ccl-btn ccl-btn--primary" data-ccl-lead-open data-lead-source="Building Profile Searches" data-requested-category="Building Comparison" data-intent="Building profile list request">Send My Comparison Request</button>
            </div>
        </section>
        <?php
        return (string) ob_get_clean();
    }
}

new Calgary_Condo_Compare();
