<?php
if (!defined('ABSPATH')) {
    exit;
}

final class Calgary_Condo_Compare {
    public function __construct() {
        add_shortcode('ccl_compare_buildings', [$this, 'render_shortcode']);
    }

    public function render_shortcode(array $atts = []): string {
        return '<section class="ccl-section ccl-section--white"><div class="ccl-wrap"><h2>Compare Calgary Condo Buildings</h2><p>Compare buildings, fees, rules, documents, parking, storage, and resale path before booking showings.</p></div></section>';
    }
}

new Calgary_Condo_Compare();
