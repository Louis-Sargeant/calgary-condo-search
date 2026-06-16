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
        <div class="ccl-home-tight ccl-home-search-first">
            <section class="ccl-tight-hero" aria-labelledby="ccl-home-title">
                <div class="ccl-tight-hero__overlay">
                    <div class="ccl-wrap ccl-tight-hero__inner">
                        <p class="ccl-eyebrow">Calgary Condo Search</p>
                        <h1 id="ccl-home-title">The Place to Find a Calgary Condo</h1>

                        <form class="ccl-home-search" action="#idx-search" method="get" role="search" aria-label="Search Calgary condos">
                            <button class="ccl-home-search__type" type="button" aria-label="Search type">For Sale</button>
                            <label class="ccl-home-search__field">
                                <span class="screen-reader-text">Search Calgary condos, buildings, or areas</span>
                                <input name="condo_search" type="search" placeholder="Calgary condos, buildings, or areas" />
                            </label>
                            <button class="ccl-home-search__submit" type="submit" aria-label="Search Calgary condos">Search</button>
                        </form>

                        <a class="ccl-tight-hero__phone" href="tel:<?php echo esc_attr($phone_tel); ?>">Call Calgary direct: <?php echo esc_html($phone_display); ?></a>
                    </div>
                </div>
            </section>

            <section class="ccl-home-explore" aria-labelledby="ccl-explore-title">
                <div class="ccl-wrap">
                    <h2 id="ccl-explore-title">Explore Calgary Condos</h2>
                    <nav class="ccl-home-tabs" aria-label="Calgary condo quick searches">
                        <a class="is-active" href="#idx-search">New to Market</a>
                        <a href="/condos-under-300k/">Under $300K</a>
                        <a href="/downtown-calgary-condos/">Downtown</a>
                        <a href="/beltline-condos/">Beltline</a>
                        <a href="/luxury-condos/">Luxury Condos</a>
                        <a href="/price-drops/">Price Drops</a>
                        <a href="/open-houses/">Open Houses</a>
                    </nav>
                </div>
            </section>

            <section id="idx-search" class="ccl-section ccl-section--white ccl-idx-shell ccl-tight-idx">
                <div class="ccl-wrap">
                    <div class="ccl-idx-shell__header ccl-idx-shell__header--compact">
                        <div>
                            <p class="ccl-eyebrow">Live Calgary Condo Search</p>
                            <h2>Start with the search. Then compare the building.</h2>
                            <p>Search Calgary condos, save the right matches, and get building-first guidance before booking showings.</p>
                        </div>
                        <a class="ccl-small-link" href="#condo-alerts">Get condo alerts</a>
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
