<?php
/**
 * Eighth production-safe building import batch.
 *
 * Re-applies Drake's corrected building metadata against the existing
 * ccl_building post so plugin replacement updates the saved post directly.
 *
 * @package CalgaryCondoLeads
 */

if (!defined('ABSPATH')) {
    exit;
}

return [
    [
        'name'              => 'Drake',
        'slug'              => 'drake',
        'community'         => 'Beltline',
        'address'           => '1500 7 Street SW, Calgary, AB',
        'year_built'        => '2013',
        'developer'         => 'Grosvenor',
        'building_type'     => 'Concrete high-rise condo',
        'storeys'           => '17',
        'amenities'         => 'Fitness centre, social/lounge space, bike storage, titled/heated underground parking, proximity to 17 Avenue SW shops, restaurants, transit, and Mount Royal Village.',
        'story'             => 'Drake is a Grosvenor-developed high-rise condo building in Calgary\'s Beltline at 1500 7 Street SW. Completed in 2013, it is known for its central 17 Avenue location, modern urban design, and access to restaurants, shops, transit, Mount Royal Village, and downtown Calgary. The building includes a mix of compact urban suites and select townhome-style residences, appealing to buyers who want a walkable inner-city lifestyle. Use this profile as a starting point, then confirm the current listings, condo documents, bylaws, parking/storage details, pet/rental rules, and building-specific risks before writing an offer.',
        'listings_page_url' => '',
        'seed_note'         => 'Surgical correction for the existing Drake ccl_building post. Match by slug drake or exact title Drake, add verified public metadata (address, year, developer, type, storeys, amenities, story), and do not add or change a listings page URL.',
    ],
];
