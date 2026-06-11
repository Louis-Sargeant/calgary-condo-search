# IDX Shell Shortcode

The `[ccl_idx_shell]` shortcode wraps the existing approved myRealPage IDX shortcode or embed in a conversion-focused Calgary condo search section.

It is designed to make the live listing search feel like a professional lead-generation block instead of a pasted IDX element.

## What it does

- Adds a polished section headline above the IDX search.
- Adds buyer-focused guidance before visitors start browsing.
- Adds a direct `Get Condo Alerts` call to action beside the heading.
- Places the existing IDX output inside a styled frame.
- Adds a short verification note below the IDX frame.

## What it does not do

- It does not modify the myRealPage IDX plugin.
- It does not replace the existing IDX shortcode.
- It does not create fake listings.
- It does not scrape, seed, or alter MLS data.
- It does not fix account-level IDX/profile settings.

## Recommended page placement

Use the IDX shell after the hero and quick-search cards, before the rest of the education and conversion sections.

```text
[ccl_hero primary_url="#idx-search" secondary_url="#condo-alerts"]
[ccl_quick_search]

[ccl_idx_shell]
    Place the existing approved myRealPage IDX shortcode here.
[/ccl_idx_shell]

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

## Optional attributes

```text
[ccl_idx_shell eyebrow="Live Calgary Condo Listings" title="Search the current Calgary condo inventory" subtitle="Use the live IDX search below, then compare the building, fees, rules, parking, storage, and resale path before booking showings." note="Property details should be independently verified before making decisions."]
    Place the existing approved myRealPage IDX shortcode here.
[/ccl_idx_shell]
```

## Launch QA

Before going live, confirm:

1. The original IDX shortcode still renders inside the shell.
2. IDX search, cards, details, filters, and pagination still work.
3. The alert CTA jumps to the condo alert form.
4. The shell looks clean on mobile.
5. No fake listing data is present.
6. Coming Soon mode remains active until final approval.
