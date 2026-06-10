# 2026-06-10 Calgary lead-generation section update

## Added in plugin version 1.0.6

- `[ccl_market_snapshot]` — Calgary condo buyer education section focused on building strength, true monthly cost, lifestyle fit, and resale/exit plan.
- `[ccl_building_checklist]` — Calgary condo due-diligence section focused on documents, fees, rules, unit details, building demand, and offer strategy.

## Recommended page order

```text
[ccl_hero primary_url="#idx-search" secondary_url="#condo-alerts"]
[ccl_quick_search]

<div id="idx-search">
    Keep the existing myRealPage IDX shortcode here.
</div>

[ccl_value_cards]
[ccl_area_grid]
[ccl_price_grid]
[ccl_market_snapshot]
[ccl_building_checklist]
[ccl_buyer_path]
[ccl_building_cta]
[ccl_alert_form]
[ccl_seller_cta]
[ccl_site_footer]
```

## QA notes

- These sections are educational only and do not add fake market statistics, fake listings, or MLS data.
- The existing myRealPage IDX search must remain in place and unchanged.
- Calgary-only phone number remains `+1 (403) 800-6996`.
- Coming Soon mode should remain enabled until IDX, links, forms, mobile layout, and Calgary contact information are checked.
