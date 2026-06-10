# Build Notes

Calgary Condo Search build notes.

## Current status

- WordPress lead-generation plugin exists at `plugins/calgary-condo-leads/`.
- Plugin version is currently `1.0.5`.
- Calgary contact defaults are set in the plugin.
- Expanded lead-generation shortcodes have been added.
- Admin shortcode help has been updated.
- Coming Soon stays on until final approval.

## Main page stack

```text
[ccl_hero primary_url="#idx-search" secondary_url="#condo-alerts"]
[ccl_quick_search]

<div id="idx-search">
    Keep the existing myRealPage IDX shortcode or IDX embed here.
</div>

[ccl_value_cards]
[ccl_area_grid]
[ccl_price_grid]
[ccl_buyer_path]
[ccl_building_cta]
[ccl_alert_form]
[ccl_seller_cta]
[ccl_site_footer]
```
