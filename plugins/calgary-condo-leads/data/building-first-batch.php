<?php
/**
 * First production-safe building import batch.
 *
 * seed_note is an internal annotation field only. It is never written to
 * WordPress post meta and is ignored by all importers and the seed runner.
 * Use it to document multi-tower/phase buildings, naming ambiguity, or
 * any field that requires manual verification before publishing.
 *
 * @package CalgaryCondoLeads
 */

if (!defined('ABSPATH')) {
    exit;
}

return [
    [
        'name'             => 'The Guardian',
        'community'        => 'Beltline',
        'address'          => '1188 3 Street SE, Calgary, AB',
        'year_built'       => '2016',
        'building_type'    => 'High-rise condo',
        'amenities'        => 'Fitness room, social lounge, concierge service, workshop, garden terrace.',
        'story'            => 'The Guardian is a high-rise condo building in the Beltline. Its location gives buyers access to nearby inner-city amenities, transit, restaurants, pathways, and local services, including quick connections to Downtown, the Saddledome district, and the Elbow and Bow river pathway systems. Use this profile as a starting point, then confirm the current listings, condo documents, bylaws, parking/storage details, and building-specific risks before writing an offer.',
        'listings_page_url' => '/the-guardian-active-listings/',
        'seed_note'        => 'Verify whether The Guardian is registered as one condo corporation or two (North and South towers). If separate corporations exist, tower-specific records may be needed.',
    ],
    [
        'name'             => 'Sasso',
        'community'        => 'Beltline',
        'address'          => '1410 1 Street SE, Calgary, AB',
        'year_built'       => '2006',
        'building_type'    => 'High-rise condo',
        'amenities'        => 'Fitness room, hot tub, recreation lounge, concierge support.',
        'story'            => 'Sasso is a high-rise condo building in the Beltline, close to Stampede Park and the Victoria Park/Stampede C-Train station. Its location gives buyers access to nearby inner-city amenities, transit, restaurants, pathways, and local services. Use this profile as a starting point, then confirm the current listings, condo documents, bylaws, parking/storage details, and building-specific risks before writing an offer.',
        'listings_page_url' => '/sasso-active-listings/',
        'seed_note'        => '',
    ],
    [
        'name'             => 'Arriva',
        'community'        => 'Beltline',
        'address'          => '433 11 Avenue SE, Calgary, AB',
        'year_built'       => '2008',
        'building_type'    => 'Luxury high-rise condo',
        'amenities'        => 'Concierge, secured entry, fitness facilities, premium common areas.',
        'story'            => 'Arriva is a luxury high-rise condo building in the Beltline. Its location gives buyers access to nearby inner-city amenities, transit, restaurants, pathways, and local services, with proximity to the Victoria Park event district and downtown Calgary. Use this profile as a starting point, then confirm the current listings, condo documents, bylaws, parking/storage details, and building-specific risks before writing an offer.',
        'listings_page_url' => '/arriva-active-listings/',
        'seed_note'        => '',
    ],
    [
        // Tower-specific record. Keynote Urban Village is a multi-tower development.
        // Keynote One (this record) is on 11th Avenue SE.
        // Keynote Two is a separate tower on 12th Avenue SE with its own condo corporation.
        // See building-third-batch.php for the Keynote Two record.
        'name'             => 'Keynote One Urban Village',
        'slug'             => 'keynote-one-urban-village',
        'community'        => 'Beltline',
        'address'          => '225 11 Avenue SE, Calgary, AB',
        'year_built'       => '2010',
        'building_type'    => 'High-rise condo',
        'amenities'        => 'Fitness room, hot tubs, owner lounge, concierge, retail access.',
        'story'            => 'Keynote One Urban Village is a high-rise condo tower in the Beltline, situated on 11th Avenue SE. Its location gives buyers access to nearby inner-city amenities, transit, restaurants, pathways, and local services, including on-site retail and strong walkability to Downtown Calgary. Use this profile as a starting point, then confirm the current listings, condo documents, bylaws, parking/storage details, and building-specific risks before writing an offer.',
        'listings_page_url' => '/keynote-one-urban-village-active-listings/',
        'seed_note'        => 'MULTI-TOWER: Part of the Keynote Urban Village development. Keynote One is on 11th Avenue SE. Keynote Two is a separate tower on 12th Avenue SE with a separate condo corporation. Do not blend the two towers into one IDX target.',
    ],
    [
        'name'             => 'Vogue',
        'community'        => 'Downtown West End',
        'address'          => '930 6 Avenue SW, Calgary, AB',
        'year_built'       => '2017',
        'building_type'    => 'High-rise condo',
        'amenities'        => 'Fitness room, concierge, owners lounge, rooftop social spaces.',
        'story'            => 'Vogue is a high-rise condo building in the Downtown West End. Its location gives buyers access to nearby inner-city amenities, transit, restaurants, pathways, and local services, including LRT connections, the Bow River pathway system, Kensington Village, and the downtown business core. Use this profile as a starting point, then confirm the current listings, condo documents, bylaws, parking/storage details, pet/rental rules, and building-specific risks before writing an offer.',
        'listings_page_url' => '',
        'seed_note'        => '',
    ],
    [
        'name'             => 'Union Square',
        'community'        => 'Beltline',
        'address'          => '215 13 Avenue SW, Calgary, AB',
        'year_built'       => '2009',
        'building_type'    => 'High-rise condo',
        'amenities'        => 'Fitness room, social spaces, concierge support, secure parking.',
        'story'            => 'Union Square is a high-rise condo building in the Beltline. Its location gives buyers access to nearby inner-city amenities, transit, restaurants, pathways, and local services, with quick connections to Downtown Calgary offices and the broader Beltline corridor. Use this profile as a starting point, then confirm the current listings, condo documents, bylaws, parking/storage details, and building-specific risks before writing an offer.',
        'listings_page_url' => '',
        'seed_note'        => '',
    ],
    [
        'name'             => 'Bridgeland Crossing',
        'community'        => 'Bridgeland',
        'address'          => '38 9 Street NE, Calgary, AB',
        'year_built'       => '2016',
        'building_type'    => 'Mid-rise condo',
        'amenities'        => 'Fitness room, resident lounge, courtyard spaces, bike-friendly access.',
        'story'            => 'Bridgeland Crossing is a mid-rise condo building in Bridgeland. Its location gives buyers access to nearby inner-city amenities, transit, restaurants, pathways, and local services, with the Bridgeland-Memorial C-Train station and Bow River pathways close by. Use this profile as a starting point, then confirm the current listings, condo documents, bylaws, parking/storage details, and building-specific risks before writing an offer.',
        'listings_page_url' => '',
        'seed_note'        => '',
    ],
    [
        'name'             => 'Evolution',
        'community'        => 'East Village',
        'address'          => '510 6 Avenue SE, Calgary, AB',
        'year_built'       => '2016',
        'building_type'    => 'High-rise condo',
        'amenities'        => 'Fitness room, steam/sauna areas, concierge, lounge and terrace spaces.',
        'story'            => 'Evolution is a high-rise condo building in East Village. Its location gives buyers access to nearby inner-city amenities, transit, restaurants, pathways, and local services, including the Bow River pathway system, the Central Library, and the growing East Village dining and retail scene. Use this profile as a starting point, then confirm the current listings, condo documents, bylaws, parking/storage details, and building-specific risks before writing an offer.',
        'listings_page_url' => '',
        'seed_note'        => '',
    ],
    [
        'name'             => 'Princeton Grand',
        'community'        => 'Eau Claire',
        'address'          => '1108 6 Avenue SW, Calgary, AB',
        'year_built'       => '2002',
        'building_type'    => 'Luxury condo',
        'amenities'        => 'Concierge, secure parking, premium common areas, river-adjacent location.',
        'story'            => 'Princeton Grand is a luxury condo building in Eau Claire. Its location gives buyers access to nearby inner-city amenities, transit, restaurants, pathways, and local services, including the Bow River pathway system, Princes Island Park, and the upscale Eau Claire dining and retail district. Use this profile as a starting point, then confirm the current listings, condo documents, bylaws, parking/storage details, and building-specific risks before writing an offer.',
        'listings_page_url' => '',
        'seed_note'        => '',
    ],
];
