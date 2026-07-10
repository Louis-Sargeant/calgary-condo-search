<?php
/**
 * Seventh production-safe building import batch.
 *
 * Re-applies Mark on 10th corrected metadata against the existing ccl_building
 * post so plugin replacement updates the saved post directly.
 *
 * @package CalgaryCondoLeads
 */

if (!defined('ABSPATH')) {
    exit;
}

return [
    [
        'name'              => 'Mark on 10th',
        'slug'              => 'mark-on-10th',
        'community'         => 'Beltline',
        'address'           => '901 10 Avenue SW, Calgary, AB',
        'year_built'        => '2016',
        'developer'         => 'Qualex-Landmark',
        'building_type'     => 'Concrete high-rise condo',
        'storeys'           => '34',
        'amenities'         => 'Top-floor amenity area, rooftop patio/lounge, fitness room, yoga studio, hot tub, steam room, guest suite, rooftop garden/fire pit/barbecue area.',
        'story'             => 'Mark on 10th is a Qualex-Landmark concrete high-rise condo building in Calgary’s Beltline at 901 10 Avenue SW. Completed in 2016, it is known for its central Beltline location and top-floor amenity areas, including rooftop lounge/patio space, fitness facilities, hot tub and steam room amenities, yoga studio, guest suite access, and rooftop garden space. Its location gives buyers access to downtown Calgary, restaurants, shops, transit, nightlife, and inner-city services. Use this profile as a starting point, then confirm the current listings, condo documents, bylaws, parking/storage details, pet/rental rules, and building-specific risks before writing an offer.',
        'seed_note'         => 'Surgical Mark on 10th correction: update the existing ccl_building post by slug/title, add verified public metadata only, skip unit count, and do not add a listings page URL.',
    ],
];
