<?php
/**
 * Page-level fallback overrides for the Calgary condo lead-generation site.
 *
 * @package CalgaryCondoLeads
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Forces key pages to use clean, non-repetitive lead-generation layouts.
 */
final class Calgary_Condo_Page_Overrides {
    /**
     * Synthetic ID used for the generated Browse by Price parent menu item.
     */
    private const BROWSE_BY_PRICE_MENU_ID = 999991;

    /**
     * Official CREB housing statistics page.
     */
    private const CREB_MARKET_UPDATE_URL = 'https://www.creb.com/Housing_Statistics/';

    /**
     * Wire filters.
     */
    public function __construct() {
        add_filter('the_content', [$this, 'replace_page_content'], 999);
        add_filter('wp_nav_menu_objects', [$this, 'reorganize_primary_navigation'], 30, 2);
        add_filter('nav_menu_link_attributes', [$this, 'rewrite_market_menu_attributes'], 20, 4);
        add_filter('nav_menu_link_attributes', [$this, 'rewrite_home_menu_attributes'], 21, 4);
        add_action('template_redirect', [$this, 'redirect_shortcode_contaminated_home_links'], 0);
        add_action('template_redirect', [$this, 'render_virtual_market_update_page'], 1);
        add_action('wp_footer', [$this, 'rewrite_market_links'], 99);
        add_action('wp_footer', [$this, 'rewrite_home_links'], 100);
        add_action('wp_footer', [$this, 'add_price_drop_badges'], 100);
    }

    public function replace_page_content(string $content): string {
        if (is_admin() || !is_singular('page') || !is_main_query() || !in_the_loop()) {
            return $content;
        }

        if (is_page('calgary-condos')) {
            return do_shortcode('[ccl_homepage_tight]');
        }

        if (is_page('price-reduced-condos')) {
            return do_shortcode($this->price_reduced_layout());
        }

        if (is_page('condo-buildings')) {
            return do_shortcode($this->compare_buildings_layout());
        }

        if (is_page(['market-report', 'market-update'])) {
            return do_shortcode($this->market_update_layout());
        }

        if (is_page('calgary-communities')) {
            return do_shortcode($this->calgary_communities_layout());
        }

        return $content;
    }

    public function redirect_shortcode_contaminated_home_links(): void {
        if (is_admin()) {
            return;
        }

        $path = rawurldecode((string) parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH));
        if (false === strpos($path, '[ccl_homepage_tight]')) {
            return;
        }

        wp_safe_redirect($this->home_menu_url(), 301);
        exit;
    }

    public function render_virtual_market_update_page(): void {
        if (is_admin()) {
            return;
        }

        $path = trim((string) parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH), '/');
        if (!in_array($path, ['market-update', 'market-report'], true)) {
            return;
        }

        global $wp_query;
        if ($wp_query instanceof WP_Query) {
            $wp_query->is_404 = false;
            $wp_query->is_page = true;
            $wp_query->is_singular = true;
        }

        status_header(200);
        nocache_headers();
        get_header();
        echo '<main id="primary" class="site-main ccl-virtual-market-update">';
        echo do_shortcode($this->market_update_layout()); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo '</main>';
        get_footer();
        exit;
    }

    public function rewrite_home_menu_attributes(array $atts, $menu_item, $args, int $depth): array {
        $title = isset($menu_item->title) ? strtolower(trim((string) $menu_item->title)) : '';
        $href = isset($atts['href']) ? rawurldecode(strtolower((string) $atts['href'])) : '';

        if ('home' === $title || false !== strpos($href, '[ccl_homepage_tight]')) {
            $atts['href'] = $this->home_menu_url();
            unset($atts['target'], $atts['rel']);
        }

        return $atts;
    }

    /**
     * Reorganize crowded primary navigation links into a compact Browse by Price dropdown.
     *
     * @param array<int,object> $items Menu items.
     * @param stdClass          $args  Menu arguments.
     * @return array<int,object>
     */
    public function reorganize_primary_navigation(array $items, $args): array {
        if (is_admin() || empty($items)) {
            return $items;
        }

        $top_level_items = [];
        $price_items = [];
        $price_item_lookup = [];
        $price_item_ids = [];

        foreach ($items as $index => $item) {
            if (!$item instanceof stdClass) {
                continue;
            }

            if ('0' === (string) ($item->menu_item_parent ?? '0')) {
                $top_level_items[$index] = $item;
                $price_key = $this->price_menu_key((string) ($item->title ?? ''));
                if (null !== $price_key) {
                    $price_items[$index] = $item;
                    $price_item_lookup[$price_key] = $item;
                    $price_item_ids[(int) ($item->ID ?? 0)] = true;
                }
            }
        }

        if (count($price_item_lookup) < 2) {
            return $items;
        }

        $ordered_price_keys = [
            'up_to_300k',
            '300k_400k',
            '400k_500k',
            '500k_600k',
            '600k_700k',
            '700k_800k',
            '800k_900k',
            '900k_1m',
            '1m_plus',
        ];

        $ordered_price_items = [];
        foreach ($ordered_price_keys as $price_key) {
            if (!isset($price_item_lookup[$price_key])) {
                continue;
            }

            $item = clone $price_item_lookup[$price_key];
            $item->menu_item_parent = (string) self::BROWSE_BY_PRICE_MENU_ID;
            if ('up_to_300k' === $price_key) {
                $item->title = 'Up to $300K';
            } elseif ('300k_400k' === $price_key) {
                $item->title = '$300K–$400K';
            }

            $ordered_price_items[] = $item;
        }

        if (empty($ordered_price_items)) {
            return $items;
        }

        foreach (array_keys($price_items) as $price_item_index) {
            unset($top_level_items[$price_item_index]);
        }

        $browse_by_price_item = $this->build_browse_by_price_menu_item();
        $top_level_items[] = $browse_by_price_item;

        $ordered_top_level = [];
        $top_level_order_keys = ['home', 'building_alerts', 'browse_by_price', 'price_reduced', 'market_stats'];
        foreach ($top_level_order_keys as $order_key) {
            foreach ($top_level_items as $index => $item) {
                if ($this->primary_menu_key($item) !== $order_key) {
                    continue;
                }

                $ordered_top_level[] = $item;
                unset($top_level_items[$index]);
                break;
            }
        }

        foreach ($top_level_items as $item) {
            $ordered_top_level[] = $item;
        }

        $ordered_items = [];
        $menu_order = 1;

        foreach ($ordered_top_level as $top_level_item) {
            $cloned_top_level_item = clone $top_level_item;
            $cloned_top_level_item->menu_item_parent = '0';
            $cloned_top_level_item->menu_order = $menu_order++;
            $ordered_items[] = $cloned_top_level_item;

            if ('browse_by_price' !== $this->primary_menu_key($cloned_top_level_item)) {
                continue;
            }

            foreach ($ordered_price_items as $child_item) {
                $cloned_child_item = clone $child_item;
                $cloned_child_item->menu_order = $menu_order++;
                $ordered_items[] = $cloned_child_item;
            }
        }

        foreach ($items as $item) {
            if (!$item instanceof stdClass) {
                continue;
            }
            if ('0' !== (string) ($item->menu_item_parent ?? '0')) {
                if (isset($price_item_ids[(int) ($item->ID ?? 0)])) {
                    continue;
                }
                $ordered_items[] = $item;
            }
        }

        return $ordered_items;
    }

    /**
     * Build synthetic parent menu item for the price dropdown.
     */
    private function build_browse_by_price_menu_item(): stdClass {
        $item = new stdClass();
        $item->ID = self::BROWSE_BY_PRICE_MENU_ID;
        $item->db_id = 0;
        $item->menu_item_parent = '0';
        $item->object_id = 0;
        $item->object = 'custom';
        $item->type = 'custom';
        $item->type_label = 'Custom Link';
        $item->title = 'Browse by Price';
        $item->url = '#';
        $item->target = '';
        $item->attr_title = '';
        $item->description = '';
        $item->classes = ['menu-item', 'menu-item-type-custom', 'menu-item-object-custom', 'menu-item-has-children', 'ccl-menu-browse-by-price'];
        $item->xfn = '';
        $item->status = 'publish';
        $item->current = false;
        $item->current_item_ancestor = false;
        $item->current_item_parent = false;
        $item->menu_order = 0;

        return $item;
    }

    /**
     * Resolve the canonical menu key for top-level order control.
     */
    private function primary_menu_key(stdClass $item): string {
        $title = $this->normalize_menu_label((string) ($item->title ?? ''));

        if ('browsebyprice' === $title) {
            return 'browse_by_price';
        }

        if ('home' === $title) {
            return 'home';
        }

        if (false !== strpos($title, 'buildingalerts')) {
            return 'building_alerts';
        }

        if (false !== strpos($title, 'pricereduced')) {
            return 'price_reduced';
        }

        if (false !== strpos($title, 'marketstats') || false !== strpos($title, 'marketupdate') || false !== strpos($title, 'marketreport') || false !== strpos($title, 'marketstatistics')) {
            return 'market_stats';
        }

        return '';
    }

    /**
     * Resolve a price menu item key by label.
     */
    private function price_menu_key(string $title): ?string {
        $normalized = $this->normalize_menu_label($title);

        if (false !== strpos($normalized, 'under300k')) {
            return 'up_to_300k';
        }

        if (false !== strpos($normalized, 'under400k') || false !== strpos($normalized, '300k400k')) {
            return '300k_400k';
        }

        if (false !== strpos($normalized, '400k500k')) {
            return '400k_500k';
        }

        if (false !== strpos($normalized, '500k600k')) {
            return '500k_600k';
        }

        if (false !== strpos($normalized, '600k700k')) {
            return '600k_700k';
        }

        if (false !== strpos($normalized, '700k800k')) {
            return '700k_800k';
        }

        if (false !== strpos($normalized, '800k900k')) {
            return '800k_900k';
        }

        if (false !== strpos($normalized, '900k1m')) {
            return '900k_1m';
        }

        if (false !== strpos($normalized, '1mplus') || false !== strpos($normalized, '1m+')) {
            return '1m_plus';
        }

        return null;
    }

    /**
     * Normalize menu labels for robust matching.
     */
    private function normalize_menu_label(string $value): string {
        $value = html_entity_decode(strtolower(trim(wp_strip_all_tags($value))), ENT_QUOTES, 'UTF-8');
        $value = str_replace(['–', '—', '-'], '', $value);
        $value = preg_replace('/[^a-z0-9+]/', '', $value);

        return (string) $value;
    }

    public function rewrite_market_menu_attributes(array $atts, $menu_item, $args, int $depth): array {
        $title = isset($menu_item->title) ? strtolower(trim((string) $menu_item->title)) : '';
        $href = isset($atts['href']) ? strtolower((string) $atts['href']) : '';

        if ('market update' === $title || false !== strpos($href, 'creb.com/housing_statistics')) {
            $atts['href'] = home_url('/market-update/');
            unset($atts['target'], $atts['rel']);
        }

        return $atts;
    }

    public function rewrite_home_links(): void {
        if (is_admin()) {
            return;
        }
        ?>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            var homeUrl = <?php echo wp_json_encode($this->home_menu_url()); ?>;
            document.querySelectorAll('a').forEach(function (link) {
                var label = (link.textContent || '').trim().toLowerCase();
                var href = (link.getAttribute('href') || '').toLowerCase();
                if (label === 'home' || href.indexOf('[ccl_homepage_tight]') !== -1 || href.indexOf('%5bccl_homepage_tight%5d') !== -1) {
                    link.setAttribute('href', homeUrl);
                    link.removeAttribute('target');
                    link.removeAttribute('rel');
                }
            });
        });
        </script>
        <?php
    }

    public function rewrite_market_links(): void {
        if (is_admin()) {
            return;
        }
        ?>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('a').forEach(function (link) {
                var label = (link.textContent || '').trim().toLowerCase();
                var href = (link.getAttribute('href') || '').toLowerCase();
                if (label === 'market update' || href.indexOf('creb.com/housing_statistics') !== -1) {
                    link.setAttribute('href', '/market-update/');
                    link.removeAttribute('target');
                    link.removeAttribute('rel');
                }
            });
        });
        </script>
        <?php
    }

    public function add_price_drop_badges(): void {
        if (is_admin() || !is_page('price-reduced-condos')) {
            return;
        }
        ?>
        <style>
            .ccl-price-drop-badge{position:absolute;left:8px;top:8px;z-index:20;display:inline-flex;align-items:center;gap:4px;padding:5px 8px;border-radius:999px;background:#0A1A2F;color:#fff;font-size:11px;font-weight:800;letter-spacing:.04em;text-transform:uppercase;box-shadow:0 8px 18px rgba(10,26,47,.22);pointer-events:none}.ccl-price-drop-badge::before{content:"↓";display:inline-block;width:16px;height:16px;line-height:16px;text-align:center;border-radius:50%;background:#D4AF37;color:#0A1A2F;font-weight:900}.ccl-price-drop-host{position:relative!important}
        </style>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            function hasListingSignals(el){var text=(el.textContent||'').toLowerCase();return text.indexOf('mls')!==-1&&(text.indexOf('$')!==-1||text.indexOf('details')!==-1)}
            function badgeCards(){var candidates=Array.prototype.slice.call(document.querySelectorAll('.ccl-idx-shell__frame *'));var hosts=[];candidates.forEach(function(el){if(hosts.length>=48){return}var rect=el.getBoundingClientRect();if(rect.width<180||rect.width>520||rect.height<180||rect.height>760){return}if(!hasListingSignals(el)){return}var hasChildHost=hosts.some(function(host){return host.contains(el)});if(hasChildHost){return}var image=el.querySelector('img');var details=(el.textContent||'').toLowerCase().indexOf('details')!==-1;if(image&&details){hosts.push(el)}});hosts.forEach(function(host){if(host.querySelector(':scope > .ccl-price-drop-badge')){return}host.classList.add('ccl-price-drop-host');var badge=document.createElement('span');badge.className='ccl-price-drop-badge';badge.textContent='Price Drop';host.insertBefore(badge,host.firstChild)})}
            badgeCards();window.setTimeout(badgeCards,800);window.setTimeout(badgeCards,1800);
        });
        </script>
        <?php
    }

    private function home_menu_url(): string {
        return home_url('/');
    }

    private function price_reduced_layout(): string {
        $idx = '[mrp account_id=67196 listing_def=search-1439357 context=recip perm_attr=tmpl~v2 ][/mrp]';

        return <<<HTML
<section class="ccl-section ccl-section--white ccl-compare-hero">
    <div class="ccl-wrap ccl-compare-hero__inner">
        <div>
            <p class="ccl-eyebrow">Calgary Price Drop Condos</p>
            <h1>Condos with recent price drops.</h1>
            <p>Watch Calgary condos where sellers have already adjusted their price. This page helps buyers spot motivated opportunities, compare the building behind the unit, and move faster when the right condo fits.</p>
        </div>
        <div class="ccl-compare-hero__actions">
            <a class="ccl-btn ccl-btn--primary" href="/price-reduced-condos/#idx-search" target="_self">View Price Drop Condos</a>
            <button type="button" class="ccl-btn ccl-btn--dark" data-ccl-lead-open data-lead-source="Price Drop Condos" data-requested-category="Price Drop Alerts" data-intent="Active listings request">Get Price Drop Alerts</button>
        </div>
    </div>
</section>

[ccl_idx_shell eyebrow="Live Price Drop Condo Search" title="Current Calgary condos with recent price reductions" subtitle="Browse live price-reduced condo opportunities, then compare fees, bylaws, parking, storage, documents, and resale path before booking showings."]{$idx}[/ccl_idx_shell]
[ccl_alert_form title="Get Calgary Condo Price Drop Alerts" subtitle="Tell us your target area, building, budget, and timing. We will help watch price reductions so you do not have to keep checking every day." button_text="Send My Price Drop Alert Request"]
[ccl_site_footer]
HTML;
    }

    private function compare_buildings_layout(): string {
        return <<<'SHORTCODES'
<section class="ccl-section ccl-section--white ccl-compare-hero">
    <div class="ccl-wrap ccl-compare-hero__inner">
        <div>
            <p class="ccl-eyebrow">Compare Calgary Condo Buildings</p>
            <h1>Compare the building before you book the showing.</h1>
            <p>Price and photos are only the start. Strong Calgary condo buyers compare the building, fees, rules, documents, parking, storage, lifestyle fit, and resale path before making a move.</p>
        </div>
        <div class="ccl-compare-hero__actions">
            <button type="button" class="ccl-btn ccl-btn--primary" data-ccl-lead-open data-lead-source="Building Profile Searches" data-requested-category="Building Comparison" data-intent="Building profile list request">Request Building Comparison</button>
            <a class="ccl-btn ccl-btn--dark" href="tel:+14038006996">Call +1 (403) 800-6996</a>
        </div>
    </div>
</section>
[ccl_market_snapshot title="What to compare before you book a showing" subtitle="Two units can look similar online and carry very different risk. Compare the building, fees, rules, documents, parking, storage, and resale path before you spend time on showings."]
[ccl_building_checklist title="Building comparison checklist" subtitle="Use this checklist to separate strong Calgary condo options from weak ones before you write an offer."]
[ccl_alert_form title="Request a Calgary Building Comparison" subtitle="Tell us the areas, buildings, budget, parking needs, pet rules, and timeline. We will help narrow the right options before you book showings." button_text="Send My Building Comparison Request"]
[ccl_site_footer]
SHORTCODES;
    }

    private function market_update_layout(): string {
        $creb_url = esc_url(self::CREB_MARKET_UPDATE_URL);

        return <<<HTML
<section class="ccl-section ccl-section--white ccl-compare-hero">
    <div class="ccl-wrap ccl-compare-hero__inner">
        <div>
            <p class="ccl-eyebrow">Calgary Market Stats</p>
            <h1>Calgary condo market stats.</h1>
            <p>Use monthly market stats to understand supply, price pressure, inventory, and negotiation conditions before chasing listings. Then compare the individual building before booking showings.</p>
        </div>
        <div class="ccl-compare-hero__actions">
            <a class="ccl-btn ccl-btn--primary" href="/all-calgary-condos/" target="_self">Search Calgary Condos</a>
            <a class="ccl-btn ccl-btn--dark" href="{$creb_url}" target="_blank" rel="noopener noreferrer">Open CREB Source</a>
        </div>
    </div>
</section>

[ccl_market_snapshot eyebrow="Calgary Condo Market Stats" title="Use market data, then compare the building" subtitle="Market data gives the big picture. The individual building still needs to be checked for fees, rules, reserve fund strength, parking, storage, documents, and resale path."]
[ccl_building_cta title="Want help reading the Calgary condo market?" subtitle="Send the building, area, or price range you are watching and get guidance before booking showings." button_text="Compare Condo Buildings" button_url="/calgary-condo-buildings/"]
<section class="ccl-section ccl-section--white">
    <div class="ccl-wrap">
        <p class="ccl-eyebrow">Official Source</p>
        <h2>CREB Board housing statistics</h2>
        <p>For the official board data, open the CREB housing statistics source. For buying decisions, keep the search focused on the specific building, documents, fees, and resale fit.</p>
        <a class="ccl-btn ccl-btn--primary" href="{$creb_url}" target="_blank" rel="noopener noreferrer">Open CREB Housing Statistics</a>
    </div>
</section>
[ccl_site_footer]
HTML;
    }

    private function calgary_communities_layout(): string {
        return <<<'SHORTCODES'
<section class="ccl-section ccl-section--white ccl-compare-hero">
    <div class="ccl-wrap ccl-compare-hero__inner">
        <div>
            <p class="ccl-eyebrow">Calgary Communities</p>
            <h1>Compare the community before you compare the condo.</h1>
            <p>Search schools, commute, parks, walkability, nearby amenities, and condo lifestyle fit before you shortlist buildings or book showings.</p>
        </div>
        <div class="ccl-compare-hero__actions">
            <a class="ccl-btn ccl-btn--primary" href="/all-calgary-condos/" target="_self">Search Calgary Condos</a>
            <a class="ccl-btn ccl-btn--dark" href="/calgary-condo-buildings/" target="_self">Compare Buildings</a>
        </div>
    </div>
</section>
[ccl_school_community]
[ccl_area_grid title="Explore Calgary condo communities" subtitle="Start with the Calgary condo areas buyers ask about most, then narrow by building, budget, schools, commute, and lifestyle fit."]
[ccl_price_grid]
[ccl_alert_form title="Get Community-Based Condo Alerts" subtitle="Tell us the areas, school needs, commute, budget, parking needs, and timeline. We will help narrow the right Calgary condo options." button_text="Send My Community Search Request"]
[ccl_site_footer]
SHORTCODES;
    }
}

new Calgary_Condo_Page_Overrides();
