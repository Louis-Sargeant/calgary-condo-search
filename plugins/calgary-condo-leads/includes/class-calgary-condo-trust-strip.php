<?php
/**
 * Trust strip shortcode for Calgary Condo Leads.
 *
 * @package CalgaryCondoLeads
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Adds credibility and trust signals near conversion points.
 */
final class Calgary_Condo_Trust_Strip {
    /**
     * Wire hooks.
     */
    public function __construct() {
        add_shortcode('ccl_trust_strip', [$this, 'render_shortcode']);
    }

    /**
     * Render the trust strip.
     *
     * @param array<string,mixed> $atts Shortcode attributes.
     */
    public function render_shortcode(array $atts = []): string {
        $atts = shortcode_atts(
            [
                'eyebrow' => 'Why Buyers Use This Calgary Condo Search',
                'title' => 'A cleaner way to search, compare, and choose the right condo path',
            ],
            $atts,
            'ccl_trust_strip'
        );

        if ($this->is_price_range_page()) {
            return $this->render_price_range_stats_strip();
        }

        $proof_points = [
            [
                'label' => 'Live IDX Search',
                'text' => 'Search current condo inventory through the approved IDX path.',
            ],
            [
                'label' => 'Building-First Guidance',
                'text' => 'Compare documents, fees, rules, parking, storage, and resale fit before chasing a unit.',
            ],
            [
                'label' => 'Buyer Alert Funnel',
                'text' => 'Turn browsing into saved searches, building alerts, and better-timed showings.',
            ],
            [
                'label' => 'Cleaner Decisions',
                'text' => 'Education sections support the search experience without changing IDX data.',
            ],
        ];

        ob_start();
        ?>
        <section class="ccl-section ccl-trust-strip" aria-label="<?php echo esc_attr($atts['eyebrow']); ?>">
            <div class="ccl-wrap">
                <div class="ccl-trust-strip__header">
                    <p class="ccl-eyebrow"><?php echo esc_html($atts['eyebrow']); ?></p>
                    <h2><?php echo esc_html($atts['title']); ?></h2>
                </div>
                <div class="ccl-trust-strip__grid">
                    <?php foreach ($proof_points as $point) : ?>
                        <article class="ccl-trust-strip__item">
                            <strong><?php echo esc_html($point['label']); ?></strong>
                            <p><?php echo esc_html($point['text']); ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php

        return (string) ob_get_clean();
    }

    /**
     * Render premium credibility stats for price-range landing pages.
     */
    private function render_price_range_stats_strip(): string {
        $stats = [
            [
                'icon' => '🏢',
                'heading' => '1,000+ Active Calgary Condo Listings',
                'text' => 'Live listings powered by the myRealPage IDX feed.',
            ],
            [
                'icon' => '🏷️',
                'heading' => 'Price Drops Updated Daily',
                'text' => 'Track recent reductions as soon as they become available.',
            ],
            [
                'icon' => '🔔',
                'heading' => 'Instant Condo Alerts',
                'text' => 'Receive new listings matching your preferred price range.',
            ],
            [
                'icon' => '🏙️',
                'heading' => 'Explore Calgary Communities',
                'text' => 'Browse condos by neighbourhood, building, and lifestyle.',
            ],
        ];

        ob_start();
        ?>
        <section class="ccl-section ccl-trust-strip ccl-trust-strip--price-range" aria-label="<?php esc_attr_e('Calgary condo credibility stats', 'calgary-condo-leads'); ?>">
            <div class="ccl-wrap">
                <div class="ccl-trust-strip__grid ccl-trust-strip__grid--price-range">
                    <?php foreach ($stats as $stat) : ?>
                        <article class="ccl-trust-strip__stat-card">
                            <span class="ccl-trust-strip__icon" aria-hidden="true"><?php echo esc_html($stat['icon']); ?></span>
                            <h3><?php echo esc_html($stat['heading']); ?></h3>
                            <p><?php echo esc_html($stat['text']); ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php

        return (string) ob_get_clean();
    }

    /**
     * Determine if current page is a price-range landing page.
     */
    private function is_price_range_page(): bool {
        $price_slugs = [
            'calgary-condos-under-300k',
            'calgary-condos-300k-500k',
            'under-300k',
            'under-400k',
            '300k-400k',
            '300k-500k',
            '400k-500k',
            '500k-600k',
            '600k-700k',
            '700k-800k',
            '800k-900k',
            '900k-1m',
            '1m-plus',
            'calgary-luxury-condos',
            'luxury-condos',
        ];

        if (is_page($price_slugs)) {
            return true;
        }

        $path = trim((string) parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH), '/');
        if ('' === $path) {
            return false;
        }

        return (bool) preg_match('/(^|\/)(?:calgary-condos-)?(?:under-\d+k|\d+k-\d+k|\d+k-\d+m|1m-plus|luxury-condos|calgary-luxury-condos)$/', $path);
    }
}

new Calgary_Condo_Trust_Strip();
