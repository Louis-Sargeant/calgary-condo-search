<?php
/**
 * Fourth production-safe building import batch.
 *
 * Re-applies enriched public/basic data for Keynote Two Urban Village.
 * This batch exists to trigger the auto-seed runner update for a record
 * that was originally seeded with placeholder values in batch 3.
 *
 * seed_note is an internal annotation field only. It is never written to
 * WordPress post meta and is ignored by all importers and the seed runner.
 *
 * @package CalgaryCondoLeads
 */

if (!defined('ABSPATH')) {
    exit;
}

return [
    [
        // Enriched update for Keynote Two Urban Village.
        // Keynote Two / Keynote 2 is at 225 11 Avenue SE — a separate tower with its own condo corporation.
        // Keynote One Urban Village (220 12 Avenue SE) is in building-first-batch.php and is not modified here.
        'name'             => 'Keynote Two Urban Village',
        'slug'             => 'keynote-two-urban-village',
        'community'        => 'Beltline / Victoria Park',
        'address'          => '225 11 Avenue SE, Calgary, AB',
        'year_built'       => '2013',
        'building_type'    => 'Concrete high-rise',
        'amenities'        => 'Fitness centre, owners lounge / party room, guest suites, bike storage, underground parking, nearby retail/services.',
        'story'            => 'Keynote Two Urban Village is the second residential tower in the Keynote Urban Village development in Beltline / Victoria Park. Located at 225 11 Avenue SE, it gives buyers access to downtown, Stampede Park, transit, restaurants, Sunterra Market, and inner-city services. Use this profile as a starting point, then confirm the current listings, condo documents, bylaws, parking/storage details, pet/rental rules, and building-specific risks before writing an offer.',
        'listings_page_url' => '',
        'seed_note'        => 'MULTI-TOWER: Tower-specific record for Keynote Two (225 11 Avenue SE). Separate condo corporation from Keynote One Urban Village (220 12 Avenue SE). Wire a separate IDX listings page before setting listings_page_url.',
    ],
];
