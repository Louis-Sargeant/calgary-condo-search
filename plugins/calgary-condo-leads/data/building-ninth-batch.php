<?php
/**
 * Ninth production-safe building import batch.
 *
 * Re-applies Colours corrected metadata against the existing ccl_building
 * post so plugin replacement updates the saved post directly.
 *
 * @package CalgaryCondoLeads
 */

if (!defined('ABSPATH')) {
    exit;
}

return [
    [
        'name'              => 'Colours',
        'slug'              => 'colours',
        'community'         => 'Beltline',
        'address'           => '135 13 Avenue SW, Calgary, AB',
        'year_built'        => '2009',
        'building_type'     => 'Concrete high-rise condo',
        'amenities'         => 'Fitness centre, underground parking, visitor parking, bike storage, in-suite laundry, balconies/patios, urban Beltline location close to downtown, 17 Avenue, restaurants, shops, transit, and Stampede/Victoria Park amenities.',
        'story'             => 'Colours is a concrete high-rise condo building in Calgary’s Beltline at 135 13 Avenue SW. Completed in 2009, it is known for its colourful exterior design, urban loft-style feel, and central Beltline location near downtown Calgary, 17 Avenue, restaurants, shops, transit, and Stampede/Victoria Park amenities. The building appeals to buyers who want a walkable inner-city lifestyle with modern condo convenience. Use this profile as a starting point, then confirm the current listings, condo documents, bylaws, parking/storage details, pet/rental rules, and building-specific risks before writing an offer.',
        'listings_page_url' => '',
        'seed_note'         => 'Surgical correction for the existing Colours ccl_building post. Match by slug colours or exact title Colours, overwrite incomplete profile metadata, preserve any existing listings page URL, and do not create a duplicate.',
    ],
];
