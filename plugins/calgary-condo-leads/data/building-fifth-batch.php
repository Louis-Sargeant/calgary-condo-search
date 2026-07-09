<?php
/**
 * Fifth production-safe building import batch.
 *
 * Re-applies Chocolate's corrected building metadata against the existing
 * ccl_building post so plugin replacement updates the saved post directly.
 *
 * @package CalgaryCondoLeads
 */

if (!defined('ABSPATH')) {
    exit;
}

return [
    [
        'name'              => 'Chocolate',
        'slug'              => 'chocolate',
        'community'         => 'Victoria Park / Beltline',
        'address'           => '188 15 Avenue SW, Calgary, AB',
        'year_built'        => '2006',
        'building_type'     => 'Concrete high-rise condo tower',
        'amenities'         => 'Rooftop terrace/common rooftop space, heated underground parking, polished concrete/industrial-style finishes.',
        'story'             => 'Chocolate is a Battistella Developments condo tower in Victoria Park / Beltline at 188 15 Avenue SW. Known for its modern industrial design, concrete construction, polished concrete finishes, and inner-city location near 17th Avenue, downtown Calgary, restaurants, transit, and services, Chocolate appeals to buyers looking for a distinctive urban condo building. Use this profile as a starting point, then confirm the current listings, condo documents, bylaws, parking/storage details, pet/rental rules, and building-specific risks before writing an offer.',
        'listings_page_url' => '',
        'seed_note'         => 'Surgical correction for the existing Chocolate ccl_building post. Match by slug chocolate or exact title Chocolate, overwrite the wrong Kensington community data, and do not add a listings page URL.',
    ],
];
