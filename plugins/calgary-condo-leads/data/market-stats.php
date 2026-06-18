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
    'month_label' => 'May 2026',
    'eyebrow' => 'Calgary Market Stats • May 2026',
    'headline' => 'Apartment prices ease as inventory remains elevated.',
    'intro' => 'Here is the monthly Calgary market stats page buyers actually need: sales, listings, inventory, months of supply, benchmark prices, and area price movement — with CREB kept as the official source.',
    'source_label' => 'CREB City of Calgary Monthly Statistics, May 2026',
    'source_url' => 'https://www.creb.com/Housing_Statistics/',
    'summary' => 'Sales slowed while inventory stayed elevated. Total residential benchmark price was $570,500, down 3.0% year over year. Apartment benchmark price was $300,400, down 9.1% year over year.',
    'snapshot' => [
        ['label' => 'Sales', 'value' => '2,162', 'change' => '↓ 15.5% Y/Y', 'direction' => 'down'],
        ['label' => 'New Listings', 'value' => '4,226', 'change' => '↓ 12.7% Y/Y', 'direction' => 'down'],
        ['label' => 'Inventory', 'value' => '6,752', 'change' => '↑ 0.1% Y/Y', 'direction' => 'up'],
        ['label' => 'Months Supply', 'value' => '3.12', 'change' => '↑ 18.5% Y/Y', 'direction' => 'up'],
    ],
    'property_prices' => [
        ['label' => 'Total Residential', 'value' => '$570,500', 'change' => '↓ 3.0% Y/Y', 'direction' => 'down'],
        ['label' => 'Detached', 'value' => '$747,800', 'change' => '↓ 2.4% Y/Y', 'direction' => 'down'],
        ['label' => 'Semi-Detached', 'value' => '$691,100', 'change' => '↓ 1.0% Y/Y', 'direction' => 'down'],
        ['label' => 'Row', 'value' => '$422,300', 'change' => '↓ 6.4% Y/Y', 'direction' => 'down'],
        ['label' => 'Apartment', 'value' => '$300,400', 'change' => '↓ 9.1% Y/Y', 'direction' => 'down'],
    ],
    'district_prices' => [
        ['label' => 'North West', 'value' => '$636,900', 'change' => '↓ 1.7% Y/Y', 'direction' => 'down'],
        ['label' => 'North', 'value' => '$526,500', 'change' => '↓ 5.4% Y/Y', 'direction' => 'down'],
        ['label' => 'North East', 'value' => '$467,800', 'change' => '↓ 7.5% Y/Y', 'direction' => 'down'],
        ['label' => 'West', 'value' => '$726,600', 'change' => '↓ 0.5% Y/Y', 'direction' => 'down'],
        ['label' => 'City Centre', 'value' => '$568,800', 'change' => '↓ 3.4% Y/Y', 'direction' => 'down'],
        ['label' => 'East', 'value' => '$400,800', 'change' => '↓ 6.8% Y/Y', 'direction' => 'down'],
        ['label' => 'South', 'value' => '$582,300', 'change' => '↓ 1.3% Y/Y', 'direction' => 'down'],
        ['label' => 'South East', 'value' => '$556,200', 'change' => '↓ 3.9% Y/Y', 'direction' => 'down'],
    ],
];
