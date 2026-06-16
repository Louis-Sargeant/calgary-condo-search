<?php
if (!defined('ABSPATH')) {
    exit;
}

final class Calgary_Condo_Community_Schools {
    public function __construct() {
        add_shortcode('ccl_school_community', [$this, 'render']);
    }

    public function render(array $atts = []): string {
        $atts = shortcode_atts([
            'eyebrow' => 'Schools & Community',
            'title' => 'Search the area, schools, and lifestyle before you book a showing.',
            'subtitle' => 'A Calgary condo search should include the area around the building: schools, commute, parks, amenities, walkability, and community feel.',
        ], $atts, 'ccl_school_community');

        $cards = [
            ['label' => 'Public Schools', 'title' => 'Search CBE schools', 'text' => 'Check public school information for the area you are considering.', 'url' => 'https://www.cbe.ab.ca/schools/find-a-school/Pages/default.aspx', 'external' => true],
            ['label' => 'Catholic Schools', 'title' => 'Search CCSD schools', 'text' => 'Check Catholic school information before comparing communities.', 'url' => 'https://www.cssd.ab.ca/schools/Pages/default.aspx', 'external' => true],
            ['label' => 'Communities', 'title' => 'Explore Calgary communities', 'text' => 'Compare lifestyle, commute, condo options, amenities, and neighbourhood fit.', 'url' => '/calgary-communities/', 'external' => false],
            ['label' => 'Building Fit', 'title' => 'Compare condo buildings', 'text' => 'Check fees, rules, parking, storage, documents, and resale path before you book.', 'url' => '/condo-buildings/', 'external' => false],
        ];

        ob_start();
        ?>
        <section class="ccl-section ccl-section--white ccl-school-community">
            <div class="ccl-wrap">
                <div class="ccl-section__header ccl-section__header--centered">
                    <p class="ccl-eyebrow"><?php echo esc_html((string) $atts['eyebrow']); ?></p>
                    <h2><?php echo esc_html((string) $atts['title']); ?></h2>
                    <p><?php echo esc_html((string) $atts['subtitle']); ?></p>
                </div>
                <div class="ccl-school-community__grid">
                    <?php foreach ($cards as $card) : ?>
                        <a class="ccl-school-community__card" href="<?php echo esc_url($card['url']); ?>" <?php echo $card['external'] ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
                            <span><?php echo esc_html($card['label']); ?></span>
                            <strong><?php echo esc_html($card['title']); ?></strong>
                            <em><?php echo esc_html($card['text']); ?></em>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
        return (string) ob_get_clean();
    }
}

new Calgary_Condo_Community_Schools();
