<?php
/**
 * Monthly Calgary market stats data.
 *
 * Update this file once per month from the newest CREB City of Calgary Monthly Statistics report,
 * then bump the plugin version and package the ZIP. Keep numbers source-backed.
 *
 * @package CalgaryCondoLeads
 */

if (!defined('ABSPATH')) {
    exit;
}

return [
    'month_label' => 'June 2026',
    'eyebrow' => 'CALGARY MARKET STATS • JUNE 2026',
    'headline' => 'High-density supply is pressuring Calgary apartment condo prices.',
    'intro' => 'June sales improved from May, but elevated apartment inventory continues to give condo buyers more choice. Use this page to understand the numbers before comparing buildings, fees, rules, parking, storage, and resale risk.',
    'source_label' => 'CREB City of Calgary Monthly Statistics, June 2026',
    'source_url' => 'https://www.creb.com/Housing_Statistics/',
    'summary' => 'Calgary sales improved over May, but apartment-style condominiums remain under buyer-market pressure because high-density supply is elevated. Buyers have more choice, but they still need to compare the building, condo fees, reserve fund, bylaws, parking, storage, insurance, and resale path before booking showings.',
    'snapshot' => [
        ['label' => 'Sales', 'value' => '2,197'],
        ['label' => 'New Listings', 'value' => '3,900'],
        ['label' => 'Inventory', 'value' => '6,805'],
        ['label' => 'Citywide Benchmark', 'value' => '$572,500'],
        ['label' => 'Apartment Benchmark', 'value' => '$299,000'],
        ['label' => 'Apartment Supply', 'value' => 'Nearly 5 months'],
    ],
    'property_prices' => [],
    'district_prices' => [],
];
