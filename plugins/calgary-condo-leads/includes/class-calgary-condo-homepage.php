<?php
if (!defined('ABSPATH')) {
    exit;
}

final class Calgary_Condo_Homepage {
    public function __construct() {
        add_shortcode('ccl_homepage_tight', [$this, 'render']);
    }

    public function render(array $atts = [], ?string $content = null): string {
        $phone_display = defined('CCL_CONTACT_PHONE_DISPLAY') ? CCL_CONTACT_PHONE_DISPLAY : '+1 (403) 800-6996';
        $phone_tel = defined('CCL_CONTACT_PHONE_TEL') ? CCL_CONTACT_PHONE_TEL : '+14038006996';
        $idx_content = trim((string) $content);

        ob_start();
        ?>
        <div class="ccl-home-tight">
            <section class="ccl-tight-hero">
                <div class="ccl-wrap ccl-tight-hero__grid">
                    <div class="ccl-tight-hero__content">
                        <p class="ccl-eyebrow">Calgary Condo Search</p>
                        <h1>Search Calgary Condos With a Fighter In Your Corner</h1>
                        <p class="ccl-tight-hero__subtitle">Find condos, compare buildings, set alerts, and get direct Calgary condo guidance before you book showings or make a move.</p>
                        <div class="ccl-tight-hero__actions">
                            <a class="ccl-btn ccl-btn--primary" href="#idx-search">Search Calgary Condos</a>
                            <a class="ccl-btn ccl-btn--secondary" href="#condo-alerts">Get Condo Alerts</a>
                            <a class="ccl-btn ccl-btn--dark" href="/condo-value-report/">Get My Condo Value Report</a>
                        </div>
                        <a class="ccl-tight-hero__phone" href="tel:<?php echo esc_attr($phone_tel); ?>">Call Calgary direct: <?php echo esc_html($phone_display); ?></a>
                    </div>
                    <aside class="ccl-tight-hero__panel">
                        <strong>Get Calgary condo matches sent to you.</strong>
                        <span>Send your area, budget, timing, building questions, and must-haves. Get a cleaner shortlist before wasting time.</span>
                        <a class="ccl-btn ccl-btn--primary" href="#condo-alerts">Send My Condo Match Request</a>
                    </aside>
                </div>
            </section>

            <section id="idx-search" class="ccl-section ccl-section--white ccl-idx-shell ccl-tight-idx">
                <div class="ccl-wrap">
                    <div class="ccl-idx-shell__header">
                        <div>
                            <p class="ccl-eyebrow">Calgary Condo Search</p>
                            <h2>Start with the search. Then compare the building.</h2>
                            <p>The permanent myRealPage IDX search is being prepared. Until it is connected, use the custom condo match request below or call the Calgary number for direct help.</p>
                        </div>
                        <a class="ccl-btn ccl-btn--dark" href="#condo-alerts">Get Help Narrowing The Search</a>
                    </div>
                    <div class="ccl-idx-shell__frame">
                        <?php if ('' !== $idx_content) : ?>
                            <?php echo wp_kses_post(do_shortcode($idx_content)); ?>
                        <?php else : ?>
                            <div class="ccl-tight-idx__placeholder">
                                <strong>Live condo search connection pending.</strong>
                                <p>The live IDX gets connected when the approved myRealPage search is ready.</p>
                                <div class="ccl-tight-idx__actions">
                                    <a href="#condo-alerts">Request a custom condo search</a>
                                    <a href="/condo-buildings/">Compare Calgary condo buildings</a>
                                    <a href="/building-alerts/">Set building alerts</a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        </div>
        <?php
        return (string) ob_get_clean();
    }
}

new Calgary_Condo_Homepage();
