<?php
/**
 * Third production-safe building import batch.
 *
 * Adds tower-specific records that were identified during the batch-1/batch-2
 * audit as requiring separate building profiles (separate condo corporations,
 * separate addresses, or separate IDX targets).
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
        // Tower-specific record. Part of the Keynote Urban Village development.
        // Keynote Two is on 12th Avenue SE — a separate tower with its own condo corporation.
        // Keynote One Urban Village (11th Avenue SE) is already in building-first-batch.php.
        // Do not blend Keynote One and Keynote Two into a single IDX target.
        'name'             => 'Keynote Two Urban Village',
        'slug'             => 'keynote-two-urban-village',
        'community'        => 'Beltline',
        'address'          => '',
        'year_built'       => '',
        'building_type'    => 'High-rise condo',
        'amenities'        => '',
        'story'            => 'Keynote Two Urban Village is a high-rise condo tower in the Beltline, situated on 12th Avenue SE. Its location gives buyers access to nearby inner-city amenities, transit, restaurants, pathways, and local services, including on-site retail and strong walkability to Downtown Calgary. Use this profile as a starting point, then confirm the current listings, condo documents, bylaws, parking/storage details, and building-specific risks before writing an offer.',
        'listings_page_url' => '',
        'seed_note'        => 'MULTI-TOWER: Tower-specific record for Keynote Two (12th Avenue SE). Separate condo corporation from Keynote One Urban Village (11th Avenue SE). Verify exact address and year built before publishing. Wire a separate IDX listings page before setting listings_page_url.',
    ],
];
