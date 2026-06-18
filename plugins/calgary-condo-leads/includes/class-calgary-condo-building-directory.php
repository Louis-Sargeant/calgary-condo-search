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
        ['name' => 'Ink', 'area' => 'East Village', 'type' => 'High-rise', 'focus' => 'Entry-level downtown ownership'],
        ['name' => 'Bridgeland Crossing', 'area' => 'Bridgeland', 'type' => 'Mid-rise', 'focus' => 'C-Train, river, inner-city neighbourhood feel'],
        ['name' => 'Radius', 'area' => 'Bridgeland', 'type' => 'Concrete mid-rise', 'focus' => 'Modern building, inner-city lifestyle'],
    ];

    public function __construct() {
        add_action('template_redirect', [$this, 'render_buildings_page'], 0);
        add_shortcode('ccl_building_directory', [$this, 'shortcode']);
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
.ccl-building-page{background:#f6f7f8;color:#0A1A2F}.ccl-building-wrap{width:min(1180px,calc(100% - 40px));margin:0 auto}.ccl-building-hero{position:relative;overflow:hidden;background:#07162a;color:#fff;padding:78px 0}.ccl-building-hero:before{content:"";position:absolute;inset:0;background:linear-gradient(90deg,rgba(7,22,42,.98),rgba(7,22,42,.84),rgba(7,22,42,.58)),radial-gradient(circle at 78% 22%,rgba(240,199,94,.2),transparent 28%),linear-gradient(135deg,rgba(15,92,128,.5),rgba(7,22,42,.1));opacity:1}.ccl-building-hero:after{content:"";position:absolute;right:0;bottom:0;left:0;height:60%;background:linear-gradient(to top,rgba(0,0,0,.48),transparent),linear-gradient(90deg,transparent 0 6%,rgba(255,255,255,.12) 6% 7%,transparent 7% 11%,rgba(255,255,255,.08) 11% 12%,transparent 12% 18%,rgba(255,255,255,.1) 18% 19%,transparent 19% 100%);clip-path:polygon(0 100%,0 60%,8% 60%,8% 38%,16% 38%,16% 55%,23% 55%,23% 30%,31% 30%,31% 66%,38% 66%,38% 20%,45% 20%,45% 100%,49% 100%,49% 48%,53% 48%,53% 17%,56% 48%,60% 48%,60% 100%,67% 100%,67% 38%,75% 38%,75% 55%,83% 55%,83% 28%,91% 28%,91% 64%,100% 64%,100% 100%);background-color:rgba(12,43,74,.72);opacity:.2}.ccl-building-hero__inner{position:relative;z-index:2;display:grid;grid-template-columns:minmax(0,1fr) minmax(360px,.48fr);gap:34px;align-items:center}.ccl-building-eyebrow{margin:0 0 14px;color:#F0C75E;font-weight:900;letter-spacing:.12em;text-transform:uppercase;font-size:13px}.ccl-building-hero h1{margin:0 0 18px;color:#fff;font-size:clamp(42px,5vw,72px);line-height:.96;letter-spacing:-.05em}.ccl-building-hero p{margin:0;color:rgba(255,255,255,.88);font-size:18px;line-height:1.6;max-width:760px}.ccl-building-visual{position:relative;min-height:390px;border-radius:34px;overflow:hidden;background:linear-gradient(145deg,rgba(255,255,255,.14),rgba(255,255,255,.04));border:1px solid rgba(255,255,255,.22);box-shadow:0 30px 80px rgba(0,0,0,.35);backdrop-filter:blur(10px)}.ccl-building-visual__image{position:absolute;inset:0;background-image:linear-gradient(180deg,rgba(7,22,42,.08),rgba(7,22,42,.62)),var(--ccl-building-hero-image);background-size:cover;background-position:center;transform:scale(1.015)}.ccl-luxury-label{position:absolute;right:18px;bottom:18px;max-width:280px;background:rgba(10,26,47,.72);border:1px solid rgba(255,255,255,.24);border-radius:22px;padding:18px;color:#fff;backdrop-filter:blur(10px)}.ccl-luxury-label strong{display:block;color:#fff;font-size:21px;margin-bottom:7px}.ccl-luxury-label span{display:block;color:rgba(255,255,255,.82);line-height:1.45;font-size:14px}.ccl-building-searchbox{display:none}.ccl-building-section{padding:58px 0;background:#fff}.ccl-building-section--soft{background:#f6f7f8}.ccl-building-section h2{margin:0 0 12px;font-size:clamp(30px,4vw,48px);letter-spacing:-.04em;line-height:1}.ccl-building-section p{max-width:820px;color:#4b5563;line-height:1.7;font-size:17px}.ccl-building-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:16px;margin-top:28px}.ccl-building-card{background:#fff;border:1px solid rgba(10,26,47,.1);border-radius:22px;padding:20px;box-shadow:0 18px 45px rgba(10,26,47,.07);min-height:190px}.ccl-building-card span{display:inline-block;background:#F0C75E;color:#0A1A2F;border-radius:999px;padding:6px 10px;font-weight:900;font-size:12px;margin-bottom:12px}.ccl-building-card h3{margin:0 0 8px;font-size:22px;line-height:1.1}.ccl-building-card p{font-size:14px;line-height:1.55;margin:0;color:#4b5563}.ccl-building-card small{display:block;margin-top:12px;color:#64748b;font-weight:800}.ccl-building-cta{background:#0A1A2F;color:#fff;border-radius:28px;padding:34px;display:grid;grid-template-columns:1fr auto;gap:20px;align-items:center}.ccl-building-cta h2{color:#fff;margin:0 0 8px}.ccl-building-cta p{color:rgba(255,255,255,.78);margin:0}.ccl-building-btn{display:inline-flex;align-items:center;justify-content:center;min-height:48px;padding:0 22px;border-radius:14px;background:#F0C75E;color:#0A1A2F;text-decoration:none;font-weight:900;white-space:nowrap}@media(max-width:980px){.ccl-building-hero__inner,.ccl-building-cta{grid-template-columns:1fr}.ccl-building-grid{grid-template-columns:repeat(2,minmax(0,1fr))}.ccl-building-visual{min-height:330px}}@media(max-width:620px){.ccl-building-grid{grid-template-columns:1fr}.ccl-building-btn{width:100%}.ccl-building-visual{min-height:280px}.ccl-luxury-label{left:14px;right:14px;top:auto;bottom:14px}.ccl-building-hero{padding:54px 0}}
</style>
CSS;
    }

    private function page(): string {
        return '<main class="ccl-building-page">' . $this->hero() . $this->directory_section(true) . $this->cta() . '</main>';
    }

    private function hero(): string {
        $hero_image = esc_url(self::BUILDING_HERO_IMAGE);

        return <<<HTML
<section class="ccl-building-hero" style="--ccl-building-hero-image:url('{$hero_image}')">
    <div class="ccl-building-wrap ccl-building-hero__inner">
        <div>
            <p class="ccl-building-eyebrow">Calgary Condo Buildings</p>
            <h1>Search Calgary condos by building, not just price.</h1>
            <p>Browse Calgary condo buildings across Beltline, Downtown, East Village, Eau Claire, Bridgeland, Victoria Park, and more. Compare the building first, then chase the right listing.</p>
        </div>
        <div class="ccl-building-visual" aria-label="Luxury Calgary condo tower visual">
            <div class="ccl-building-visual__image"></div>
            <div class="ccl-luxury-label">
                <strong>Luxury condo tower search</strong>
                <span>Building profile, amenities, fees, documents, parking, storage, and resale path before showings.</span>
            </div>
        </div>
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

        $intro = $include_intro ? '<p>This is the starter Calgary building directory. The next phase is individual building profile pages with building-specific listing feeds where the IDX data supports it.</p>' : '';

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
            <a class="ccl-building-btn" href="/building-alerts/">Set Building Alerts</a>
        </div>
    </div>
</section>
HTML;
    }
}

new Calgary_Condo_Building_Directory();
