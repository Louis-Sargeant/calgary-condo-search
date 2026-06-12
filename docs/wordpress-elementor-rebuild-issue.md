# WordPress Elementor Rebuild Issue

## Current status

The `/calgary-condos/` page is still rendering old Elementor/placeholder content even after shortcode and plugin updates.

This means the live page is being controlled by saved WordPress/Elementor page data, not by GitHub plugin code alone.

## Confirmed findings

- The correct page slug is now `/calgary-condos/`.
- The myRealPage IDX shortcode does work and can show live listings.
- The correct Calgary phone number is showing on listing cards: `403-800-6996`.
- The old placeholder sections still appear when the Search Calgary Condos button jumps to `#calgary-idx`.
- Elementor content and WordPress block content became mixed during manual editing.
- Future fixes should avoid small partial edits and should rebuild the page cleanly.

## Recommended repair path

When returning to this fix, use the cleanest path:

1. Rename or trash the current broken Elementor-backed page.
2. Create a fresh page titled `Calgary Condos`.
3. Use slug: `calgary-condos`.
4. Use a normal WordPress Shortcode block only.
5. Paste one clean shortcode layout.
6. Do not edit this page with Elementor after the rebuild unless absolutely required.
7. Purge SG Cache.
8. Test `/calgary-condos/` fresh with no hash at the end of the URL.

## Clean shortcode layout

```text
[ccl_hero title="Search Calgary Condos With a Fighter In Your Corner" subtitle="Find Calgary condos, compare buildings, get alerts, and request guidance before you book a showing." primary_text="Search Calgary Condos" primary_url="#mrp-listings" secondary_text="Get My Condo Value Report" secondary_url="#condo-alerts" panel_title="Get Calgary condo matches sent to you" panel_text="Tell us what you want and we will help you narrow the search."]

[ccl_quick_search]
[ccl_trust_strip]

<div id="mrp-listings"></div>

[mrp account_id=67196 searchform_def=idx.browse embed=true context=recip init_attr=omni-city%3ACalgary%5BCalgary%20%2Ccity%29%5D,property_type-DWELLING_TYPE%40APAR]

[ccl_value_cards]
[ccl_area_grid]
[ccl_price_grid]
[ccl_buyer_path]
[ccl_building_cta]

[ccl_alert_form title="Get Calgary Condo Alerts" subtitle="Tell us your preferred area, budget, parking needs, timeline, and must-haves." button_text="Send My Condo Match Request"]

[ccl_seller_cta]
[ccl_site_footer]
```

## Build rule going forward

The site must stay visual-first. Do not allow the Calgary condo search page to become a text-heavy or broken placeholder page. The first visible experience must be a sharp hero, clear search action, and live listing access.
