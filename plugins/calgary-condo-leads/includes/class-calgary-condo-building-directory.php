<?php
/**
 * Calgary condo building directory scaffold.
 *
 * @package CalgaryCondoLeads
 */

if (!defined('ABSPATH')) {
    exit;
}

final class Calgary_Condo_Building_Directory {
    private const BUILDING_HERO_IMAGE = 'https://media-production.lp-cdn.com/cdn-cgi/image/format=auto,quality=85/https://media-production.lp-cdn.com/media/a4d49880-59d1-42e4-a404-c5e1cf16111b';

    private const BUILDINGS = [
        ['name' => 'The Guardian', 'area' => 'Victoria Park / Beltline', 'type' => 'High-rise', 'focus' => 'Downtown access, views, newer tower product'],
        ['name' => 'Keynote Urban Village', 'area' => 'Beltline / Victoria Park', 'type' => 'High-rise', 'focus' => 'Walkability, amenities, downtown lifestyle'],
        ['name' => 'Arriva', 'area' => 'Victoria Park', 'type' => 'Luxury high-rise', 'focus' => 'Larger plans, premium building profile'],
        ['name' => 'Sasso', 'area' => 'Victoria Park', 'type' => 'High-rise', 'focus' => 'Stampede Park access, Beltline value'],
        ['name' => 'Vetro', 'area' => 'Victoria Park', 'type' => 'High-rise', 'focus' => 'Beltline location and amenity access'],
        ['name' => 'Colours', 'area' => 'Beltline', 'type' => 'Concrete high-rise', 'focus' => 'Urban loft-style layouts'],
        ['name' => 'Union Square', 'area' => 'Beltline', 'type' => 'Concrete high-rise', 'focus' => 'Central Beltline ownership'],
        ['name' => 'Avenue West End', 'area' => 'Downtown West End', 'type' => 'Luxury high-rise', 'focus' => 'River pathway and downtown access'],
        ['name' => 'Vogue', 'area' => 'Downtown West End', 'type' => 'High-rise', 'focus' => 'Downtown living, concierge-style positioning'],
        ['name' => 'Princeton Grand', 'area' => 'Eau Claire', 'type' => 'Luxury low-rise', 'focus' => 'Premium riverfront positioning'],
        ['name' => 'Churchill Estates', 'area' => 'Downtown Commercial Core', 'type' => 'Luxury tower', 'focus' => 'Large suites and central business district access'],
        ['name' => 'Evolution', 'area' => 'East Village', 'type' => 'High-rise', 'focus' => 'River pathways, library, downtown east growth'],
        ['name' => 'Verve', 'area' => 'East Village', 'type' => 'High-rise', 'focus' => 'Modern East Village lifestyle'],
        ['name' => 'Ink', 'area' => 'East Village', 'type' => 'Entry-level high-rise', 'focus' => 'Entry-level downtown ownership'],
        ['name' => 'Bridgeland Crossing', 'area' => 'Bridgeland', 'type' => 'Mid-rise', 'focus' => 'C-Train, river, inner-city neighbourhood feel'],
        ['name' => 'Radius', 'area' => 'Bridgeland', 'type' => 'Concrete mid-rise', 'focus' => 'Modern building, inner-city lifestyle'],
    ];

    public function __construct() {
        add_action('template_redirect', [$this, 'render_buildings_page'], 0);
        add_shortcode('ccl_building_directory', [$this, 'shortcode']);
        add_shortcode('ccl_building_database_directory', [$this, 'database_shortcode']);
    }


    private const VISUAL_DIRECTORY_CARDS = [
        'Inner-City Condo Hubs' => [
            ['title' => 'Beltline', 'slug' => 'beltline', 'category' => 'Inner-City Condo Hubs', 'url' => '/beltline-condos/', 'description' => 'Central Beltline condo buildings and active on-site listing access.'],
            ['title' => 'Downtown Core', 'slug' => 'downtown-core', 'category' => 'Inner-City Condo Hubs', 'url' => '/downtown-core-condos/', 'description' => 'Downtown Core condo buildings close to offices, restaurants, and transit.'],
            ['title' => 'Eau Claire', 'slug' => 'eau-claire', 'category' => 'Inner-City Condo Hubs', 'url' => '/eau-claire-condos/', 'description' => 'Eau Claire condo buildings near the river pathway and downtown core.'],
            ['title' => 'East Village', 'slug' => 'east-village', 'category' => 'Inner-City Condo Hubs', 'url' => '/east-village-condos/', 'description' => 'East Village condo buildings near the library, river pathways, and downtown east amenities.'],
            ['title' => 'Mission', 'slug' => 'mission', 'category' => 'Inner-City Condo Hubs', 'url' => '/mission-condos/', 'description' => 'Mission condo buildings with inner-city walkability and river access.'],
            ['title' => 'Victoria Park', 'slug' => 'victoria-park', 'category' => 'Inner-City Condo Hubs', 'url' => '/victoria-park-condos/', 'description' => 'Victoria Park condo buildings near Stampede Park and the Beltline.'],
        ],
        'Lifestyle & Walkability Areas' => [
            ['title' => 'Kensington', 'slug' => 'kensington', 'category' => 'Lifestyle & Walkability Areas', 'url' => '/kensington-condos/', 'description' => 'Kensington condo buildings near shops, restaurants, pathways, and LRT access.'],
            ['title' => 'Bridgeland', 'slug' => 'bridgeland', 'category' => 'Lifestyle & Walkability Areas', 'url' => '/bridgeland-condos/', 'description' => 'Bridgeland condo buildings with neighbourhood amenities and downtown access.'],
            ['title' => 'Sunnyside', 'slug' => 'sunnyside', 'category' => 'Lifestyle & Walkability Areas', 'url' => '/sunnyside-condos/', 'description' => 'Sunnyside condo buildings near Kensington, LRT, and the Bow River pathway.'],
            ['title' => 'Lower Mount Royal', 'slug' => 'lower-mount-royal', 'category' => 'Lifestyle & Walkability Areas', 'url' => '/lower-mount-royal-condos/', 'description' => 'Lower Mount Royal condo buildings near 17 Avenue and inner-city amenities.'],
            ['title' => 'Marda Loop', 'slug' => 'marda-loop', 'category' => 'Lifestyle & Walkability Areas', 'url' => '/marda-loop-condos/', 'description' => 'Marda Loop condo buildings close to local shopping, dining, and southwest routes.'],
            ['title' => 'Inglewood', 'slug' => 'inglewood', 'category' => 'Lifestyle & Walkability Areas', 'url' => '/inglewood-condos/', 'description' => 'Inglewood condo buildings near historic main-street amenities and river pathways.'],
        ],
        'Suburban Condo Markets' => [
            ['title' => 'Seton', 'slug' => 'seton', 'category' => 'Suburban Condo Markets', 'url' => '/seton-condos/', 'description' => 'Seton condo buildings near south Calgary retail, health, and recreation amenities.'],
            ['title' => 'Mahogany', 'slug' => 'mahogany', 'category' => 'Suburban Condo Markets', 'url' => '/mahogany-condos/', 'description' => 'Mahogany condo buildings with lake-community access and southeast amenities.'],
            ['title' => 'Auburn Bay', 'slug' => 'auburn-bay', 'category' => 'Suburban Condo Markets', 'url' => '/auburn-bay-condos/', 'description' => 'Auburn Bay condo buildings near the lake, hospital district, and southeast routes.'],
            ['title' => 'Legacy', 'slug' => 'legacy', 'category' => 'Suburban Condo Markets', 'url' => '/legacy-condos/', 'description' => 'Legacy condo buildings in a growing south Calgary suburban market.'],
            ['title' => 'Sage Hill', 'slug' => 'sage-hill', 'category' => 'Suburban Condo Markets', 'url' => '/sage-hill-condos/', 'description' => 'Sage Hill condo buildings near northwest shopping and ring-road access.'],
            ['title' => 'University District', 'slug' => 'university-district', 'category' => 'Suburban Condo Markets', 'url' => '/university-district-condos/', 'description' => 'University District condo buildings near campus, hospitals, retail, and parks.'],
        ],
        'Building Profile Searches' => [
            ['title' => 'Luxury High-Rise Condos', 'slug' => 'luxury-high-rise-condos', 'category' => 'Building Profile Searches', 'url' => '/luxury-high-rise-condos/', 'description' => 'Browse active building-profile condo routes matched to this search.'],
            ['title' => 'Concrete Buildings', 'slug' => 'concrete-buildings', 'category' => 'Building Profile Searches', 'url' => '/concrete-buildings/', 'description' => 'Browse active building-profile condo routes matched to this search.'],
            ['title' => 'Pet-Friendly Condo Buildings', 'slug' => 'pet-friendly-condo-buildings', 'category' => 'Building Profile Searches', 'url' => '/pet-friendly-condo-buildings/', 'description' => 'Browse active building-profile condo routes matched to this search.'],
            ['title' => 'Buildings With Underground Parking', 'slug' => 'buildings-with-underground-parking', 'category' => 'Building Profile Searches', 'url' => '/buildings-with-underground-parking/', 'description' => 'Browse active building-profile condo routes matched to this search.'],
            ['title' => 'Newer Condo Buildings', 'slug' => 'newer-condo-buildings', 'category' => 'Building Profile Searches', 'url' => '/newer-condo-buildings/', 'description' => 'Browse active building-profile condo routes matched to this search.'],
            ['title' => 'Low-Rise Condo Buildings', 'slug' => 'low-rise-condo-buildings', 'category' => 'Building Profile Searches', 'url' => '/low-rise-condo-buildings/', 'description' => 'Browse active building-profile condo routes matched to this search.'],
        ],
    ];

    public function database_shortcode(): string {
        $columns = '';
        foreach (self::VISUAL_DIRECTORY_CARDS as $heading => $items) {
            $cards = '';
            foreach ($items as $item) {
                $cards .= $this->render_visual_directory_card($item);
            }

            $columns .= '<div class="ccl-visual-directory__column"><h3>' . esc_html($heading) . '</h3><div class="ccl-visual-directory__cards">' . $cards . '</div></div>';
        }

        return '<section id="calgary-building-directory-database" class="ccl-visual-directory ccl-visual-directory--premium" aria-labelledby="calgary-building-directory-database-title"><div class="ccl-visual-directory__header"><span class="ccl-visual-directory__eyebrow">Calgary Building Database</span><h2 id="calgary-building-directory-database-title">Browse Calgary Condo Buildings by Community &amp; Profile</h2><p>Start with the building, then compare the listing. Browse Calgary condo towers, low-rise buildings, concrete projects, luxury residences, and high-demand communities before booking showings.</p></div><div class="ccl-visual-directory__matrix">' . $columns . '</div></section>';
    }

    private function render_visual_directory_card(array $item): string {
        $has_saved_search = !empty($item['url']);
        $classes = 'ccl-visual-card ccl-visual-card--' . sanitize_html_class($item['slug']);
        if ('Building Profile Searches' === $item['category']) {
            $classes .= ' ccl-visual-card--profile';
        }

        $description = $item['description'] ?? 'Browse active Calgary condo listing routes for this search.';
        $badge = $has_saved_search ? '<span class="ccl-visual-card__badge">Live IDX Route</span>' : '';
        $cta_text = 'Building Profile Searches' === $item['category'] ? 'View Matching Buildings' : 'View Active Condos';
        $cta = '<span class="ccl-visual-card__cta">' . esc_html($cta_text) . '</span>';

        return '<a href="' . esc_url($item['url']) . '" target="_self" class="' . esc_attr($classes) . '"><span class="ccl-visual-card__overlay"></span><span class="ccl-visual-card__category">' . esc_html($item['category']) . '</span><span class="ccl-visual-card__title">' . esc_html($item['title']) . '</span>' . $badge . '<span class="ccl-visual-card__description">' . esc_html($description) . '</span>' . $cta . '</a>';
    }

    private function render_mrp_saved_search(string $search_id): string {
        $verified_search_ids = [];
        if (!in_array($search_id, $verified_search_ids, true)) {
            return '';
        }

        return do_shortcode('[mrp account_id=67196 listing_def=search-' . esc_attr($search_id) . ' context=recip perm_attr=tmpl~v2 ][/mrp]');
    }

    public function render_buildings_page(): void {
        if (is_admin()) {
            return;
        }

        $slug = trim((string) parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH), '/');
        if (!in_array($slug, ['buildings', 'calgary-condo-buildings', 'building-directory'], true)) {
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
        echo $this->styles(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo $this->page(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        get_footer();
        exit;
    }

    public function shortcode(): string {
        return $this->styles() . $this->directory_section(false);
    }

    private function styles(): string {
        return <<<'CSS'
<style>
.ccl-building-page{background:#f6f7f8;color:#0A1A2F}.ccl-building-wrap{width:min(1180px,calc(100% - 40px));margin:0 auto}.ccl-building-hero{position:relative;overflow:hidden;background:#07162a;color:#fff;padding:92px 0;min-height:560px;display:flex;align-items:center}.ccl-building-hero:before{content:"";position:absolute;inset:0;background-image:linear-gradient(90deg,rgba(7,22,42,.96) 0%,rgba(7,22,42,.83) 36%,rgba(7,22,42,.48) 68%,rgba(7,22,42,.2) 100%),linear-gradient(180deg,rgba(7,22,42,.14),rgba(7,22,42,.38)),var(--ccl-building-hero-image);background-size:cover;background-position:center;transform:scale(1.02);opacity:1}.ccl-building-hero:after{content:"";position:absolute;inset:auto 0 0 0;height:38%;background:linear-gradient(to top,rgba(7,22,42,.88),transparent)}.ccl-building-hero__inner{position:relative;z-index:2;display:grid;grid-template-columns:minmax(0,.92fr) minmax(320px,.42fr);gap:34px;align-items:center}.ccl-building-eyebrow{margin:0 0 14px;color:#F0C75E;font-weight:900;letter-spacing:.12em;text-transform:uppercase;font-size:13px}.ccl-building-hero h1{margin:0 0 18px;color:#fff;font-size:clamp(42px,5vw,72px);line-height:.96;letter-spacing:-.05em;text-shadow:0 12px 34px rgba(0,0,0,.35)}.ccl-building-hero p{margin:0;color:rgba(255,255,255,.9);font-size:18px;line-height:1.6;max-width:760px}.ccl-building-visual{display:none}.ccl-building-searchbox{background:rgba(10,26,47,.58);border:1px solid rgba(255,255,255,.26);border-radius:26px;padding:24px;backdrop-filter:blur(13px);box-shadow:0 24px 70px rgba(0,0,0,.28)}.ccl-building-searchbox strong{display:block;color:#fff;font-size:24px;margin-bottom:10px}.ccl-building-searchbox span{display:block;color:rgba(255,255,255,.82);line-height:1.5}.ccl-building-section{padding:58px 0;background:#fff}.ccl-building-section--soft{background:#f6f7f8}.ccl-building-section h2{margin:0 0 12px;font-size:clamp(30px,4vw,48px);letter-spacing:-.04em;line-height:1}.ccl-building-section p{max-width:820px;color:#4b5563;line-height:1.7;font-size:17px}.ccl-building-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:16px;margin-top:28px}.ccl-building-card{background:#fff;border:1px solid rgba(10,26,47,.1);border-radius:22px;padding:20px;box-shadow:0 18px 45px rgba(10,26,47,.07);min-height:190px}.ccl-building-card span{display:inline-block;background:#F0C75E;color:#0A1A2F;border-radius:999px;padding:6px 10px;font-weight:900;font-size:12px;margin-bottom:12px}.ccl-building-card h3{margin:0 0 8px;font-size:22px;line-height:1.1}.ccl-building-card p{font-size:14px;line-height:1.55;margin:0;color:#4b5563}.ccl-building-card small{display:block;margin-top:12px;color:#64748b;font-weight:800}.ccl-building-cta{background:#0A1A2F;color:#fff;border-radius:28px;padding:34px;display:grid;grid-template-columns:1fr auto;gap:20px;align-items:center}.ccl-building-cta h2{color:#fff;margin:0 0 8px}.ccl-building-cta p{color:rgba(255,255,255,.78);margin:0}.ccl-building-btn{display:inline-flex;align-items:center;justify-content:center;min-height:48px;padding:0 22px;border-radius:14px;background:#F0C75E;color:#0A1A2F;text-decoration:none;font-weight:900;white-space:nowrap}@media(max-width:980px){.ccl-building-hero{min-height:520px}.ccl-building-hero__inner,.ccl-building-cta{grid-template-columns:1fr}.ccl-building-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}@media(max-width:620px){.ccl-building-hero{padding:62px 0;min-height:520px}.ccl-building-grid{grid-template-columns:1fr}.ccl-building-btn{width:100%}}
</style>
CSS;
    }

    private function page(): string {
        return '<main class="ccl-inner-page-shell ccl-building-page">' . $this->hero() . $this->directory_section(true) . $this->cta() . '</main>';
    }

    private function hero(): string {
        $hero_image = esc_url(self::BUILDING_HERO_IMAGE);

        return <<<HTML
<section class="ccl-building-hero" style="--ccl-building-hero-image:url('{$hero_image}')">
    <div class="ccl-building-wrap ccl-building-hero__inner">
        <div>
            <p class="ccl-building-eyebrow">Calgary Condo Buildings</p>
            <h1>Search Calgary condos by building, not just price.</h1>
            <p>Browse Calgary condo buildings across every price point — entry-level, mid-rise, high-rise, concrete, luxury, downtown, Beltline, East Village, Bridgeland, and more. Compare the building first, then chase the right listing.</p>
        </div>
        <aside class="ccl-building-searchbox">
            <strong>All Calgary condo buildings</strong>
            <span>Fees, bylaws, parking, storage, insurance, reserve fund strength, documents, amenities, and resale path matter before showings.</span>
        </aside>
    </div>
</section>
HTML;
    }

    private function directory_section(bool $include_intro): string {
        $cards = '';
        foreach (self::BUILDINGS as $building) {
            $name = esc_html($building['name']);
            $area = esc_html($building['area']);
            $type = esc_html($building['type']);
            $focus = esc_html($building['focus']);
            $cards .= <<<HTML
<article class="ccl-building-card">
    <span>{$type}</span>
    <h3>{$name}</h3>
    <p>{$focus}</p>
    <small>{$area}</small>
</article>
HTML;
        }

        $intro = $include_intro ? '<p>This is the starter Calgary building directory for all condo buyers — first-time buyers, downsizers, investors, downtown buyers, luxury buyers, and price-sensitive buyers. The next phase is individual building profile pages with building-specific listing feeds where the IDX data supports it.</p>' : '';

        return <<<HTML
<section class="ccl-building-section">
    <div class="ccl-building-wrap">
        <p class="ccl-building-eyebrow">Building Directory</p>
        <h2>Popular Calgary condo buildings</h2>
        {$intro}
        <div class="ccl-building-grid">{$cards}</div>
    </div>
</section>
HTML;
    }

    private function cta(): string {
        return <<<HTML
<section class="ccl-building-section ccl-building-section--soft">
    <div class="ccl-building-wrap">
        <div class="ccl-building-cta">
            <div>
                <h2>Want alerts for a specific building?</h2>
                <p>Tell us the building, budget, unit type, parking needs, and timing. We will watch the right listings and help compare the building before you book showings.</p>
            </div>
            <a class="ccl-building-btn" href="/building-alerts/" target="_self">Set Building Alerts</a>
        </div>
    </div>
</section>
HTML;
    }
}

new Calgary_Condo_Building_Directory();
