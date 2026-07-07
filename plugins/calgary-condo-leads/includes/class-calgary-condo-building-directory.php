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

    private const DIRECTORY_COMMUNITY_PRESETS = [
        ['label' => 'Victoria Park / Beltline', 'key' => 'victoria-park-beltline', 'aliases' => ['victoria park', 'beltline']],
        ['label' => 'Downtown West End', 'key' => 'downtown-west-end', 'aliases' => ['downtown west end', 'west end']],
        ['label' => 'Eau Claire', 'key' => 'eau-claire', 'aliases' => ['eau claire']],
        ['label' => 'Mission', 'key' => 'mission', 'aliases' => ['mission']],
        ['label' => 'East Village', 'key' => 'east-village', 'aliases' => ['east village']],
        ['label' => 'Bridgeland/Riverside', 'key' => 'bridgeland-riverside', 'aliases' => ['bridgeland', 'riverside']],
        ['label' => 'Hillhurst', 'key' => 'hillhurst', 'aliases' => ['hillhurst']],
        ['label' => 'Sunnyside', 'key' => 'sunnyside', 'aliases' => ['sunnyside']],
    ];

    private const VISUAL_DIRECTORY_CARDS = [
        'Inner-City Condo Hubs' => [
            ['title' => 'Beltline', 'slug' => 'beltline', 'category' => 'Inner-City Condo Hubs', 'url' => '/beltline-condos/', 'description' => 'Central Beltline condo buildings and active on-site listing access.'],
            ['title' => 'Downtown Core', 'slug' => 'downtown-core', 'category' => 'Inner-City Condo Hubs', 'url' => '/calgary-condo-buildings/downtown-core/', 'description' => 'Downtown Core condo buildings close to offices, restaurants, and transit.'],
            ['title' => 'Eau Claire', 'slug' => 'eau-claire', 'category' => 'Inner-City Condo Hubs', 'url' => '/calgary-condo-buildings/eau-claire/', 'description' => 'Eau Claire condo buildings near the river pathway and downtown core.'],
            ['title' => 'East Village', 'slug' => 'east-village', 'category' => 'Inner-City Condo Hubs', 'url' => '/calgary-condo-buildings/east-village/', 'description' => 'East Village condo buildings near the library, river pathways, and downtown east amenities.'],
            ['title' => 'Mission', 'slug' => 'mission', 'category' => 'Inner-City Condo Hubs', 'url' => '/calgary-condo-buildings/mission/', 'description' => 'Mission condo buildings with inner-city walkability and river access.'],
            ['title' => 'Victoria Park', 'slug' => 'victoria-park', 'category' => 'Inner-City Condo Hubs', 'url' => '/calgary-condo-buildings/victoria-park/', 'description' => 'Victoria Park condo buildings near Stampede Park and the Beltline.'],
        ],
        'Lifestyle & Walkability Areas' => [
            ['title' => 'Bridgeland', 'slug' => 'bridgeland', 'category' => 'Lifestyle & Walkability Areas', 'url' => '/calgary-condo-buildings/bridgeland/', 'description' => 'Bridgeland condo buildings with neighbourhood amenities and downtown access.'],
            ['title' => 'Sunnyside', 'slug' => 'sunnyside', 'category' => 'Lifestyle & Walkability Areas', 'url' => '/calgary-condo-buildings/sunnyside/', 'description' => 'Sunnyside condo buildings near Kensington, LRT, and the Bow River pathway.'],
            ['title' => 'Lower Mount Royal', 'slug' => 'lower-mount-royal', 'category' => 'Lifestyle & Walkability Areas', 'url' => '/calgary-condo-buildings/lower-mount-royal/', 'description' => 'Lower Mount Royal condo buildings near 17 Avenue and inner-city amenities.'],
            ['title' => 'Marda Loop', 'slug' => 'marda-loop', 'category' => 'Lifestyle & Walkability Areas', 'url' => '/calgary-condo-buildings/marda-loop/', 'description' => 'Marda Loop condo buildings close to local shopping, dining, and southwest routes.'],
            ['title' => 'Inglewood', 'slug' => 'inglewood', 'category' => 'Lifestyle & Walkability Areas', 'url' => '/calgary-condo-buildings/inglewood/', 'description' => 'Inglewood condo buildings near historic main-street amenities and river pathways.'],
        ],
        'Suburban Condo Markets' => [
            ['title' => 'Seton', 'slug' => 'seton', 'category' => 'Suburban Condo Markets', 'url' => '/calgary-condo-buildings/seton/', 'description' => 'Seton condo buildings near south Calgary retail, health, and recreation amenities.'],
            ['title' => 'Mahogany', 'slug' => 'mahogany', 'category' => 'Suburban Condo Markets', 'url' => '/calgary-condo-buildings/mahogany/', 'description' => 'Mahogany condo buildings with lake-community access and southeast amenities.'],
            ['title' => 'Auburn Bay', 'slug' => 'auburn-bay', 'category' => 'Suburban Condo Markets', 'url' => '/calgary-condo-buildings/auburn-bay/', 'description' => 'Auburn Bay condo buildings near the lake, hospital district, and southeast routes.'],
            ['title' => 'Legacy', 'slug' => 'legacy', 'category' => 'Suburban Condo Markets', 'url' => '/calgary-condo-buildings/legacy/', 'description' => 'Legacy condo buildings in a growing south Calgary suburban market.'],
            ['title' => 'Sage Hill', 'slug' => 'sage-hill', 'category' => 'Suburban Condo Markets', 'url' => '/calgary-condo-buildings/sage-hill/', 'description' => 'Sage Hill condo buildings near northwest shopping and ring-road access.'],
            ['title' => 'University District', 'slug' => 'university-district', 'category' => 'Suburban Condo Markets', 'url' => '/calgary-condo-buildings/university-district/', 'description' => 'University District condo buildings near campus, hospitals, retail, and parks.'],
        ],
        'Building Profile Searches' => [
            ['title' => 'Luxury High-Rise Condos', 'slug' => 'luxury-high-rise-condos', 'category' => 'Building Profile Searches', 'url' => '/calgary-condo-buildings/luxury-high-rise-condos/', 'description' => 'Browse active building-profile condo routes matched to this search.'],
            ['title' => 'Concrete Buildings', 'slug' => 'concrete-buildings', 'category' => 'Building Profile Searches', 'url' => '/calgary-condo-buildings/concrete-buildings/', 'description' => 'Browse active building-profile condo routes matched to this search.'],
            ['title' => 'Pet-Friendly Buildings', 'slug' => 'pet-friendly-buildings', 'aliases' => ['Pet-Friendly Condo Buildings'], 'category' => 'Building Profile Searches', 'url' => '/calgary-condo-buildings/pet-friendly-buildings/', 'description' => 'Browse active building-profile condo routes matched to this search.'],
            ['title' => 'Underground Parking', 'slug' => 'underground-parking', 'aliases' => ['Buildings With Underground Parking'], 'category' => 'Building Profile Searches', 'url' => '/calgary-condo-buildings/underground-parking/', 'description' => 'Browse active building-profile condo routes matched to this search.'],
            ['title' => 'Newer Condo Buildings', 'slug' => 'newer-condo-buildings', 'category' => 'Building Profile Searches', 'url' => '/calgary-condo-buildings/newer-condo-buildings/', 'description' => 'Browse active building-profile condo routes matched to this search.'],
            ['title' => 'Low-Rise Condo Buildings', 'slug' => 'low-rise-condo-buildings', 'category' => 'Building Profile Searches', 'url' => '/calgary-condo-buildings/low-rise-condo-buildings/', 'description' => 'Browse active building-profile condo routes matched to this search.'],
        ],
    ];

    public function __construct() {
        add_action('template_redirect', [$this, 'redirect_legacy_beltline_building_route'], 0);
        add_action('template_redirect', [$this, 'render_buildings_page'], 0);
        add_shortcode('ccl_building_directory', [$this, 'shortcode']);
        add_shortcode('ccl_building_database_directory', [$this, 'database_shortcode']);
    }

    /**
     * Return normalized visual directory card destinations for search routing.
     *
     * @return array<string,string>
     */
    public static function visual_directory_search_routes(): array {
        $routes = [];

        foreach (self::VISUAL_DIRECTORY_CARDS as $items) {
            foreach ($items as $item) {
                if (empty($item['title']) || empty($item['url'])) {
                    continue;
                }

                $terms = [(string) $item['title']];

                if (!empty($item['aliases']) && is_array($item['aliases'])) {
                    foreach ($item['aliases'] as $alias) {
                        $terms[] = (string) $alias;
                    }
                }

                if (!empty($item['slug'])) {
                    $terms[] = str_replace('-', ' ', (string) $item['slug']);
                }

                foreach ($terms as $term) {
                    $normalized = self::normalize_search_term($term);
                    if ('' !== $normalized) {
                        $routes[$normalized] = (string) $item['url'];
                    }
                }
            }
        }

        return $routes;
    }

    private static function normalize_search_term(string $term): string {
        return trim((string) preg_replace('/\s+/', ' ', (string) preg_replace('/[^a-z0-9]+/', ' ', strtolower($term))));
    }

    /**
     * Return the hard-coded fallback building directory rows.
     *
     * @return array<int,array{name:string,area:string,type:string,focus:string}>
     */
    public static function fallback_buildings(): array {
        return self::BUILDINGS;
    }

    /**
     * @param array<string,mixed> $args
     */
    public static function render_premium_directory(array $entries, array $args = []): string {
        $defaults = [
            'section_id' => 'ccl-building-directory',
            'eyebrow' => __('Calgary Condo Search — Building Directory', 'calgary-condo-leads'),
            'title' => __('Every building, indexed.', 'calgary-condo-leads'),
            'intro' => __('Calgary condo buildings organized like a proper directory — not a photo scroll. Search by name, filter by community, or browse the full building index below.', 'calgary-condo-leads'),
            'context_note' => '',
            'empty_message' => __('No building plaques match the current search and community filter.', 'calgary-condo-leads'),
        ];

        $args = array_merge($defaults, $args);
        $section_id = sanitize_html_class((string) $args['section_id']);

        usort(
            $entries,
            static fn(array $left, array $right): int => strcasecmp((string) ($left['name'] ?? ''), (string) ($right['name'] ?? ''))
        );

        $prepared_entries = [];
        foreach ($entries as $index => $entry) {
            $prepared_entries[] = self::prepare_entry($entry, $index + 1);
        }

        $groups = self::group_entries_by_letter($prepared_entries);
        $chips = self::community_chips($prepared_entries);

        ob_start();
        ?>
        <section id="<?php echo esc_attr($section_id); ?>" class="ccl-building-directory" data-ccl-building-directory>
            <div class="ccl-building-directory__header">
                <p class="ccl-building-directory__eyebrow"><?php echo esc_html((string) $args['eyebrow']); ?></p>
                <h1 class="ccl-building-directory__title"><?php echo esc_html((string) $args['title']); ?></h1>
                <p class="ccl-building-directory__sub"><?php echo esc_html((string) $args['intro']); ?></p>
                <?php if ('' !== trim((string) $args['context_note'])) : ?>
                    <p class="ccl-building-directory__context"><?php echo esc_html((string) $args['context_note']); ?></p>
                <?php endif; ?>
            </div>
            <div class="ccl-building-directory__controls">
                <label class="screen-reader-text" for="<?php echo esc_attr($section_id); ?>-search"><?php esc_html_e('Search by building name', 'calgary-condo-leads'); ?></label>
                <input
                    id="<?php echo esc_attr($section_id); ?>-search"
                    class="ccl-building-directory__search"
                    type="search"
                    placeholder="<?php esc_attr_e('Search by building name…', 'calgary-condo-leads'); ?>"
                    aria-label="<?php esc_attr_e('Search by building name', 'calgary-condo-leads'); ?>"
                    data-ccl-directory-search
                />
                <div class="ccl-building-directory__chips" role="group" aria-label="<?php esc_attr_e('Filter buildings by community', 'calgary-condo-leads'); ?>">
                    <button type="button" class="ccl-building-directory__chip is-active" data-community-filter="all"><?php esc_html_e('All Communities', 'calgary-condo-leads'); ?></button>
                    <?php foreach ($chips as $chip) : ?>
                        <button type="button" class="ccl-building-directory__chip" data-community-filter="<?php echo esc_attr($chip['key']); ?>"><?php echo esc_html($chip['label']); ?></button>
                    <?php endforeach; ?>
                </div>
                <nav class="ccl-building-directory__alpha" aria-label="<?php esc_attr_e('Jump to building letter', 'calgary-condo-leads'); ?>">
                    <?php foreach (range('A', 'Z') as $letter) : ?>
                        <?php if (isset($groups[$letter])) : ?>
                            <a href="#<?php echo esc_attr($section_id . '-letter-' . strtolower($letter)); ?>" data-alpha-link><?php echo esc_html($letter); ?></a>
                        <?php else : ?>
                            <span aria-disabled="true"><?php echo esc_html($letter); ?></span>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </nav>
            </div>
            <div class="ccl-building-directory__groups">
                <?php foreach ($groups as $letter => $letter_entries) : ?>
                    <section id="<?php echo esc_attr($section_id . '-letter-' . strtolower($letter)); ?>" class="ccl-building-directory__group" data-letter-group data-letter="<?php echo esc_attr($letter); ?>">
                        <div class="ccl-building-directory__group-head">
                            <h2 class="ccl-building-directory__group-label"><?php echo esc_html($letter); ?></h2>
                            <p class="ccl-building-directory__group-count"><?php echo esc_html(sprintf(_n('%d building', '%d buildings', count($letter_entries), 'calgary-condo-leads'), count($letter_entries))); ?></p>
                        </div>
                        <div class="ccl-building-directory__grid">
                            <?php foreach ($letter_entries as $entry) : ?>
                                <?php echo self::render_plaque($entry); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endforeach; ?>
            </div>
            <p class="ccl-building-directory__empty" data-directory-empty hidden><?php echo esc_html((string) $args['empty_message']); ?></p>
        </section>
        <?php

        return (string) ob_get_clean() . self::directory_script($section_id);
    }

    /**
     * @return array{name:string,community:string,year:string,type:string,permalink:string,letter:string,community_keys:array<int,string>,index:string}
     */
    public static function build_directory_entry_from_post(WP_Post $post): array {
        // Support both the current meta keys and older mirrored keys so the
        // directory stays stable while legacy imported records are normalized.
        $community = self::first_non_empty([
            (string) get_post_meta($post->ID, 'building_community', true),
            (string) get_post_meta($post->ID, 'ccl_building_community', true),
            self::taxonomy_term_name($post->ID, 'ccl_building_community'),
        ]);

        $year = self::first_non_empty([
            (string) get_post_meta($post->ID, 'building_year_built', true),
            (string) get_post_meta($post->ID, 'ccl_building_year_built', true),
        ]);

        $type = self::first_non_empty([
            (string) get_post_meta($post->ID, 'building_construction_type', true),
            (string) get_post_meta($post->ID, 'ccl_building_type', true),
        ]);

        return [
            'name' => $post->post_title,
            'community' => $community,
            'year' => $year,
            'type' => $type,
            'permalink' => (string) get_permalink($post),
            'letter' => self::letter_for_name($post->post_title),
            'community_keys' => self::community_filter_keys($community),
            'index' => '',
        ];
    }

    public function database_shortcode(): string {
        $columns = '';
        foreach (self::VISUAL_DIRECTORY_CARDS as $heading => $items) {
            $cards = '';
            foreach ($items as $item) {
                $cards .= $this->render_visual_directory_card($item);
            }

            $columns .= '<div class="ccl-visual-directory__column"><h3>' . esc_html($heading) . '</h3><div class="ccl-visual-directory__cards">' . $cards . '</div></div>';
        }

        return '<section id="calgary-building-directory-database" class="ccl-visual-directory ccl-dark-luxury-section ccl-visual-directory--premium" aria-labelledby="calgary-building-directory-database-title"><div class="ccl-visual-directory__header"><span class="ccl-visual-directory__eyebrow">Calgary Building Database</span><h2 id="calgary-building-directory-database-title">Browse Calgary Condo Buildings by Community &amp; Profile</h2><p>Start with the building, then compare the listing. Browse Calgary condo towers, low-rise buildings, concrete projects, luxury residences, and high-demand communities before booking showings.</p></div><div class="ccl-visual-directory__matrix">' . $columns . '</div></section>';
    }

    private function render_visual_directory_card(array $item): string {
        $has_saved_search = !empty($item['url']);
        $classes = 'ccl-visual-card ccl-visual-card--' . sanitize_html_class($item['slug']);
        if ('Building Profile Searches' === $item['category']) {
            $classes .= ' ccl-visual-card--profile';
        }

        $description = $item['description'] ?? 'Browse active Calgary condo listing routes for this search.';
        $badge = $has_saved_search ? '<span class="ccl-visual-card__badge">Active Listings</span>' : '';
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

    public function redirect_legacy_beltline_building_route(): void {
        if (is_admin()) {
            return;
        }

        $path = trim((string) parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH), '/');
        if ('calgary-condo-buildings/beltline' !== $path) {
            return;
        }

        wp_safe_redirect(home_url('/beltline-condos/'), 301);
        exit;
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
        echo $this->page(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        get_footer();
        exit;
    }

    public function shortcode(): string {
        return $this->directory_section(false);
    }

    private function page(): string {
        return '<main class="ccl-inner-page-shell ccl-building-page">' . $this->directory_section(true) . $this->cta() . '</main>';
    }

    /**
     * @return array<int,array{name:string,community:string,year:string,type:string,permalink:string,letter:string,community_keys:array<int,string>,index:string}>
     */
    private function get_directory_entries(): array {
        if (Calgary_Condo_Building_Data_Mode::is_array_first()) {
            return $this->get_array_first_directory_entries();
        }

        $posts = get_posts([
            'post_type' => Calgary_Condo_Building_CPT::POST_TYPE,
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
            'no_found_rows' => true,
            'update_post_meta_cache' => true,
        ]);

        if (empty($posts)) {
            return $this->fallback_directory_entries([]);
        }

        return array_map([self::class, 'build_directory_entry_from_post'], $posts);
    }

    /**
     * @return array<int,array{name:string,community:string,year:string,type:string,permalink:string,letter:string,community_keys:array<int,string>,index:string}>
     */
    private function get_array_first_directory_entries(): array {
        $posts = get_posts([
            'post_type' => Calgary_Condo_Building_CPT::POST_TYPE,
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
            'no_found_rows' => true,
            'update_post_meta_cache' => true,
        ]);

        $mapped_posts = [];
        foreach ($posts as $post) {
            $mapped_posts[strtolower($post->post_title)] = $post;
        }

        return $this->fallback_directory_entries($mapped_posts);
    }

    /**
     * @param array<string,WP_Post> $mapped_posts
     * @return array<int,array{name:string,community:string,year:string,type:string,permalink:string,letter:string,community_keys:array<int,string>,index:string}>
     */
    private function fallback_directory_entries(array $mapped_posts): array {
        $entries = [];

        foreach (self::BUILDINGS as $building) {
            $post = $mapped_posts[strtolower($building['name'])] ?? null;
            if ($post instanceof WP_Post) {
                $entries[] = self::build_directory_entry_from_post($post);
                continue;
            }

            $community = (string) ($building['area'] ?? '');
            $type = (string) ($building['type'] ?? '');
            $entries[] = [
                'name' => (string) $building['name'],
                'community' => $community,
                'year' => '',
                'type' => $type,
                'permalink' => '',
                'letter' => self::letter_for_name((string) $building['name']),
                'community_keys' => self::community_filter_keys($community),
                'index' => '',
            ];
        }

        return $entries;
    }

    private function directory_section(bool $include_intro): string {
        return self::render_premium_directory(
            $this->get_directory_entries(),
            [
                'section_id' => $include_intro ? 'ccl-building-directory-page' : 'ccl-building-directory-shortcode',
                'intro' => $include_intro
                    ? __('Calgary condo buildings organized like a proper directory — not a photo scroll. Search by name, filter by community, or browse the full building index below.', 'calgary-condo-leads')
                    : __('Search by building name, filter by community, or browse the full Calgary condo building index below.', 'calgary-condo-leads'),
            ]
        );
    }

    private function cta(): string {
        return <<<HTML
<section class="ccl-building-directory-cta">
    <div class="ccl-building-directory-cta__inner">
        <div>
            <p class="ccl-building-directory-cta__eyebrow">Calgary Condo Search</p>
            <h2>Want alerts for a specific building?</h2>
            <p>Tell us the building, budget, unit type, parking needs, and timing. We will watch the right listings and help compare the building before you book showings.</p>
        </div>
        <button type="button" class="ccl-building-directory-cta__button" data-ccl-lead-open data-lead-source="Building Profile Searches" data-requested-category="Building Alerts" data-intent="Building profile list request">Set Building Alerts</button>
    </div>
</section>
HTML;
    }

    /**
     * @param array<string,mixed> $entry
     * @return array<string,mixed>
     */
    private static function prepare_entry(array $entry, int $position): array {
        $name = trim((string) ($entry['name'] ?? ''));
        $community = trim((string) ($entry['community'] ?? ''));
        $year = trim((string) ($entry['year'] ?? ''));
        $type = trim((string) ($entry['type'] ?? ''));
        $permalink = trim((string) ($entry['permalink'] ?? ''));
        $community_keys = !empty($entry['community_keys']) && is_array($entry['community_keys'])
            ? array_values(array_unique(array_filter(array_map('strval', $entry['community_keys']))))
            : self::community_filter_keys($community);

        return [
            'name' => $name,
            'community' => '' !== $community ? $community : __('Community pending', 'calgary-condo-leads'),
            'year' => $year,
            'type' => $type,
            'permalink' => $permalink,
            'letter' => self::letter_for_name($name),
            'community_keys' => $community_keys,
            'index' => str_pad((string) $position, 2, '0', STR_PAD_LEFT),
        ];
    }

    /**
     * @param array<int,array<string,mixed>> $entries
     * @return array<string,array<int,array<string,mixed>>>
     */
    private static function group_entries_by_letter(array $entries): array {
        $groups = [];

        foreach ($entries as $entry) {
            $letter = (string) ($entry['letter'] ?? '#');
            if (!isset($groups[$letter])) {
                $groups[$letter] = [];
            }

            $groups[$letter][] = $entry;
        }

        ksort($groups);
        return $groups;
    }

    /**
     * @param array<int,array<string,mixed>> $entries
     * @return array<int,array{label:string,key:string}>
     */
    private static function community_chips(array $entries): array {
        $chips = [];
        $available_keys = [];

        foreach ($entries as $entry) {
            foreach ((array) ($entry['community_keys'] ?? []) as $key) {
                $available_keys[(string) $key] = true;
            }
        }

        foreach (self::DIRECTORY_COMMUNITY_PRESETS as $preset) {
            $key = (string) $preset['key'];
            if (isset($available_keys[$key])) {
                $chips[] = ['label' => (string) $preset['label'], 'key' => $key];
                unset($available_keys[$key]);
            }
        }

        $extra = [];
        foreach ($entries as $entry) {
            $label = trim((string) ($entry['community'] ?? ''));
            if ('' === $label) {
                continue;
            }

            $key = str_replace(' ', '-', self::normalize_search_term($label));
            if ('all' === $key || isset($extra[$key])) {
                continue;
            }

            if (!isset($available_keys[$key])) {
                continue;
            }

            $extra[$key] = ['label' => $label, 'key' => $key];
        }

        uasort(
            $extra,
            static fn(array $left, array $right): int => strcasecmp((string) ($left['label'] ?? ''), (string) ($right['label'] ?? ''))
        );

        return array_merge($chips, array_values($extra));
    }

    /**
     * @param array<string,mixed> $entry
     */
    private static function render_plaque(array $entry): string {
        $name = (string) ($entry['name'] ?? '');
        $community = (string) ($entry['community'] ?? '');
        $year = trim((string) ($entry['year'] ?? ''));
        $type = trim((string) ($entry['type'] ?? ''));
        $permalink = trim((string) ($entry['permalink'] ?? ''));
        $community_keys = implode('|', array_map('sanitize_html_class', (array) ($entry['community_keys'] ?? [])));

        $stats = [];
        if ('' !== $year) {
            $stats[] = sprintf(__('Built %s', 'calgary-condo-leads'), $year);
        }
        if ('' !== $type) {
            $stats[] = $type;
        }
        if (empty($stats)) {
            $stats[] = __('Profile details coming soon', 'calgary-condo-leads');
        }

        $tag = '' !== $permalink ? 'a' : 'article';
        $attributes = '' !== $permalink
            ? 'href="' . esc_url($permalink) . '" aria-label="' . esc_attr(sprintf(__('Open %1$s building profile in %2$s', 'calgary-condo-leads'), $name, $community)) . '"'
            : 'aria-label="' . esc_attr(sprintf(__('Building profile for %s is being prepared', 'calgary-condo-leads'), $name)) . '"';

        $stats_markup = '';
        foreach ($stats as $stat_index => $stat) {
            if ($stat_index > 0) {
                $stats_markup .= '<span aria-hidden="true">|</span>';
            }

            $stats_markup .= '<span>' . esc_html($stat) . '</span>';
        }

        return sprintf(
            '<%1$s class="ccl-building-directory__plaque" %2$s data-building-name="%3$s" data-building-community="%4$s"><span class="ccl-building-directory__index">%5$s</span><h3 class="ccl-building-directory__name">%6$s</h3><p class="ccl-building-directory__community">%7$s</p><p class="ccl-building-directory__stats">%8$s</p></%1$s>',
            $tag,
            $attributes,
            esc_attr(self::normalize_search_term($name)),
            esc_attr($community_keys),
            esc_html(sprintf(__('No. %s', 'calgary-condo-leads'), (string) ($entry['index'] ?? '00'))),
            esc_html($name),
            esc_html($community),
            $stats_markup
        );
    }

    private static function directory_script(string $section_id): string {
        $section_id = esc_js($section_id);

        return <<<HTML
<script>
(function() {
  var root = document.getElementById('{$section_id}');
  if (!root || root.dataset.cclDirectoryReady === 'true') {
    return;
  }

  root.dataset.cclDirectoryReady = 'true';

  var search = root.querySelector('[data-ccl-directory-search]');
  var chips = Array.prototype.slice.call(root.querySelectorAll('[data-community-filter]'));
  var groups = Array.prototype.slice.call(root.querySelectorAll('[data-letter-group]'));
  var empty = root.querySelector('[data-directory-empty]');
  var activeCommunity = 'all';

  function normalizeSearchTerm(value) {
    return String(value || '').toLowerCase().replace(/[^a-z0-9]+/g, ' ').replace(/\s+/g, ' ').trim();
  }

  function applyFilters() {
    var term = normalizeSearchTerm(search ? search.value : '');
    var visibleCount = 0;

    groups.forEach(function(group) {
      var groupVisible = 0;
      var plaques = Array.prototype.slice.call(group.querySelectorAll('.ccl-building-directory__plaque'));

      plaques.forEach(function(plaque) {
        var name = plaque.getAttribute('data-building-name') || '';
        var communities = (plaque.getAttribute('data-building-community') || '').split('|');
        var matchesSearch = !term || name.indexOf(term) !== -1;
        var matchesCommunity = activeCommunity === 'all' || communities.indexOf(activeCommunity) !== -1;
        var visible = matchesSearch && matchesCommunity;
        var indexLabel = plaque.querySelector('.ccl-building-directory__index');

        plaque.hidden = !visible;
        if (visible) {
          groupVisible += 1;
          visibleCount += 1;
          if (indexLabel) {
            indexLabel.textContent = 'No. ' + String(visibleCount).padStart(2, '0');
          }
        }
      });

      group.hidden = groupVisible === 0;
    });

    if (empty) {
      empty.hidden = visibleCount !== 0;
    }
  }

  if (search) {
    search.addEventListener('input', applyFilters);
  }

  chips.forEach(function(chip) {
    chip.addEventListener('click', function() {
      activeCommunity = chip.getAttribute('data-community-filter') || 'all';
      chips.forEach(function(button) {
        button.classList.toggle('is-active', button === chip);
      });
      applyFilters();
    });
  });

  applyFilters();
})();
</script>
HTML;
    }

    /**
     * @param array<int,string> $values
     */
    private static function first_non_empty(array $values): string {
        foreach ($values as $value) {
            $value = trim((string) $value);
            if ('' !== $value) {
                return $value;
            }
        }

        return '';
    }

    private static function taxonomy_term_name(int $post_id, string $taxonomy): string {
        $terms = get_the_terms($post_id, $taxonomy);
        if (is_wp_error($terms) || empty($terms) || !is_array($terms)) {
            return '';
        }

        $first = reset($terms);
        return $first instanceof WP_Term ? (string) $first->name : '';
    }

    private static function letter_for_name(string $name): string {
        $first_character = strtoupper((string) mb_substr(trim($name), 0, 1));
        return preg_match('/[A-Z]/', $first_character) ? $first_character : '#';
    }

    /**
     * @return array<int,string>
     */
    private static function community_filter_keys(string $community): array {
        $normalized = self::normalize_search_term($community);
        $keys = [];

        if ('' !== $normalized) {
            $keys[] = str_replace(' ', '-', $normalized);
        }

        foreach (self::DIRECTORY_COMMUNITY_PRESETS as $preset) {
            foreach ((array) $preset['aliases'] as $alias) {
                if (self::contains_all_terms($normalized, self::normalize_search_term((string) $alias))) {
                    $keys[] = (string) $preset['key'];
                    break;
                }
            }
        }

        return array_values(array_unique(array_filter($keys)));
    }

    private static function contains_all_terms(string $haystack, string $needle): bool {
        if ('' === $haystack || '' === $needle) {
            return false;
        }

        foreach (explode(' ', $needle) as $term) {
            if ('' === $term) {
                continue;
            }

            if (false === strpos($haystack, $term)) {
                return false;
            }
        }

        return true;
    }
}

new Calgary_Condo_Building_Directory();
