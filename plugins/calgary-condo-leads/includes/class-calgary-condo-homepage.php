<?php
if (!defined('ABSPATH')) {
    exit;
}

final class Calgary_Condo_Homepage {
    private const SEARCH_SHORTCODES = [
        'all' => '[mrp account_id=67196 listing_def=search-1439299 context=recip perm_attr=tmpl~v2 ][/mrp]',
        'southeast' => '[mrp account_id=67196 listing_def=search-1439583 context=recip perm_attr=tmpl~v2 ][/mrp]',
        'under-400k' => '[mrp account_id=67196 listing_def=search-1439371 context=recip perm_attr=tmpl~v2 ][/mrp]',
        'price-drops' => '[mrp account_id=67196 listing_def=search-1439357 context=recip perm_attr=tmpl~v2 ][/mrp]',
    ];

    public function __construct() {
        add_shortcode('ccl_homepage_tight', [$this, 'render']);
        add_action('template_redirect', [$this, 'redirect_legacy_query_routes'], 1);
    }

    public function redirect_legacy_query_routes(): void {
        if (is_admin() || !is_page('calgary-condos')) {
            return;
        }

        $area = isset($_GET['ccl_area']) ? sanitize_key((string) wp_unslash($_GET['ccl_area'])) : '';
        $filter = isset($_GET['ccl_filter']) ? sanitize_key((string) wp_unslash($_GET['ccl_filter'])) : '';
        $target = '';

        if ('southeast' === $area) {
            $target = 'ccl-southeast';
        } elseif ('under-400k' === $filter) {
            $target = 'ccl-under-400k';
        } elseif ('price-drops' === $filter || 'price-reduced' === $filter) {
            $target = 'ccl-price-drops';
        }

        if ('' !== $target) {
            wp_safe_redirect(home_url('/calgary-condos/#' . $target), 302);
            exit;
        }
    }

    public function render(array $atts = [], ?string $content = null): string {
        $phone_display = defined('CCL_CONTACT_PHONE_DISPLAY') ? CCL_CONTACT_PHONE_DISPLAY : '+1 (403) 800-6996';
        $phone_tel = defined('CCL_CONTACT_PHONE_TEL') ? CCL_CONTACT_PHONE_TEL : '+14038006996';
        $idx_content = trim((string) $content);

        $tabs = [
            ['key' => 'all', 'label' => 'All Calgary Condos', 'url' => '/calgary-condos/#ccl-all'],
            ['key' => 'southeast', 'label' => 'Southeast Calgary', 'url' => '/calgary-condos/#ccl-southeast'],
            ['key' => 'southwest', 'label' => 'Southwest Calgary', 'url' => '/calgary-condos/#ccl-all'],
            ['key' => 'northwest', 'label' => 'Northwest Calgary', 'url' => '/calgary-condos/#ccl-all'],
            ['key' => 'northeast', 'label' => 'Northeast Calgary', 'url' => '/calgary-condos/#ccl-all'],
            ['key' => 'downtown', 'label' => 'Downtown', 'url' => '/downtown-calgary-condos/'],
            ['key' => 'beltline', 'label' => 'Beltline', 'url' => '/beltline-condos/'],
            ['key' => 'under-400k', 'label' => 'Under $400K', 'url' => '/calgary-condos/#ccl-under-400k'],
            ['key' => 'price-drops', 'label' => 'Price Drops', 'url' => '/calgary-condos/#ccl-price-drops'],
            ['key' => 'open-houses', 'label' => 'Open Houses', 'url' => '/calgary-condos/#ccl-all'],
        ];

        $labels = [
            'all' => 'All Calgary condo listings',
            'southeast' => 'Southeast Calgary condo listings',
            'under-400k' => 'Calgary condos under $400K',
            'price-drops' => 'Price reduced Calgary condos',
        ];

        ob_start();
        ?>
        <style>
            .ccl-idx-feed{display:none}.ccl-idx-feed.is-active{display:block}.ccl-home-tabs a.is-active{font-weight:700}.ccl-feed-note{margin:0 0 1rem;font-weight:700}
        </style>
        <div class="ccl-home-tight ccl-home-search-first" data-ccl-condo-home>
            <section class="ccl-tight-hero" aria-labelledby="ccl-home-title">
                <div class="ccl-tight-hero__overlay">
                    <div class="ccl-wrap ccl-tight-hero__inner">
                        <p class="ccl-eyebrow">Calgary Condo Search</p>
                        <h1 id="ccl-home-title">The Place to Find a Calgary Condo</h1>

                        <nav class="ccl-home-search ccl-home-search--links" aria-label="Calgary condo search shortcuts">
                            <a class="ccl-home-search__main" href="/calgary-condos/#ccl-all">Search All Calgary Condos</a>
                            <a href="/calgary-condos/#ccl-southeast">Southeast</a>
                            <a href="/downtown-calgary-condos/">Downtown</a>
                            <a href="/calgary-condos/#ccl-under-400k">Under $400K</a>
                        </nav>

                        <a class="ccl-tight-hero__phone" href="tel:<?php echo esc_attr($phone_tel); ?>">Call Calgary direct: <?php echo esc_html($phone_display); ?></a>
                    </div>
                </div>
            </section>

            <section class="ccl-home-explore" aria-labelledby="ccl-explore-title">
                <div class="ccl-wrap">
                    <h2 id="ccl-explore-title">Explore Calgary Condos</h2>
                    <nav class="ccl-home-tabs" aria-label="Calgary condo quick searches">
                        <?php foreach ($tabs as $tab) : ?>
                            <a class="<?php echo 'all' === $tab['key'] ? 'is-active' : ''; ?>" data-ccl-tab="<?php echo esc_attr($tab['key']); ?>" href="<?php echo esc_url($tab['url']); ?>"><?php echo esc_html($tab['label']); ?></a>
                        <?php endforeach; ?>
                    </nav>
                </div>
            </section>

            <?php echo do_shortcode('[ccl_school_community]'); ?>

            <section id="mrp-listings" class="ccl-section ccl-section--white ccl-idx-shell ccl-tight-idx">
                <div class="ccl-wrap">
                    <div class="ccl-idx-shell__header ccl-idx-shell__header--compact">
                        <div>
                            <p class="ccl-eyebrow">Live Calgary Condo Search</p>
                            <h2 data-ccl-feed-title><?php echo esc_html($labels['all']); ?></h2>
                            <p>Search Calgary condos, save the right matches, and get building-first guidance before booking showings.</p>
                        </div>
                        <a class="ccl-small-link" href="/building-alerts/">Get condo alerts</a>
                    </div>
                    <div class="ccl-idx-shell__frame">
                        <?php if ('' !== $idx_content) : ?>
                            <div id="ccl-all" class="ccl-idx-feed is-active" data-ccl-feed="all"><?php echo wp_kses_post(do_shortcode($idx_content)); ?></div>
                        <?php else : ?>
                            <?php foreach (self::SEARCH_SHORTCODES as $key => $shortcode) : ?>
                                <div id="ccl-<?php echo esc_attr($key); ?>" class="ccl-idx-feed <?php echo 'all' === $key ? 'is-active' : ''; ?>" data-ccl-feed="<?php echo esc_attr($key); ?>">
                                    <p class="ccl-feed-note"><?php echo esc_html($labels[$key] ?? $labels['all']); ?></p>
                                    <?php echo do_shortcode($shortcode); ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        </div>
        <script>
            (function(){
                function keyFromHash(){
                    var hash=(window.location.hash||'').replace('#','');
                    if(hash==='ccl-southeast'){return 'southeast';}
                    if(hash==='ccl-under-400k'){return 'under-400k';}
                    if(hash==='ccl-price-drops'){return 'price-drops';}
                    return 'all';
                }
                function showFeed(key){
                    var root=document.querySelector('[data-ccl-condo-home]');
                    if(!root){return;}
                    var labels={all:'All Calgary condo listings',southeast:'Southeast Calgary condo listings','under-400k':'Calgary condos under $400K','price-drops':'Price reduced Calgary condos'};
                    root.querySelectorAll('[data-ccl-feed]').forEach(function(feed){feed.classList.toggle('is-active',feed.getAttribute('data-ccl-feed')===key);});
                    root.querySelectorAll('[data-ccl-tab]').forEach(function(tab){tab.classList.toggle('is-active',tab.getAttribute('data-ccl-tab')===key);});
                    var title=root.querySelector('[data-ccl-feed-title]');
                    if(title){title.textContent=labels[key]||labels.all;}
                    var listings=document.getElementById('mrp-listings');
                    if(listings && window.location.hash){setTimeout(function(){listings.scrollIntoView({behavior:'smooth',block:'start'});},150);}
                }
                window.addEventListener('hashchange',function(){showFeed(keyFromHash());});
                document.addEventListener('DOMContentLoaded',function(){showFeed(keyFromHash());});
            })();
        </script>
        <?php
        return (string) ob_get_clean();
    }
}

new Calgary_Condo_Homepage();
