# WordPress Live Page Cleanup — Calgary Condo Search

Status: Calgary Condo Leads direct ZIP is installed and active at version 1.0.9.

## Main Calgary Condo Search page

Current page being edited:

```text
/calgary-condo-search/
```

## Clean shortcode stack

Use this exact structure on the page.

### Top shortcode block

```text
[ccl_hero primary_url="#idx-search" secondary_url="#condo-alerts"]
[ccl_quick_search]
[ccl_trust_strip]
```

### IDX block

Keep the existing myRealPage IDX shortcode exactly in place.

Do not remove, replace, seed, scrape, or edit IDX listing data.

### Bottom shortcode block

```text
[ccl_value_cards]
[ccl_area_grid]
[ccl_price_grid]
[ccl_buyer_path]
[ccl_building_cta]
[ccl_alert_form]
[ccl_seller_cta]
[ccl_site_footer]
```

## Unsupported legacy shortcodes to remove

Remove these if they appear on the page because the direct ZIP does not include them:

```text
[ccl_market_snapshot]
[ccl_building_checklist]
[ccl_building_scorecard]
[ccl_lead_magnet]
[ccl_action_router]
```

## Current blocker

The myRealPage IDX registration/account popup appears immediately on page preview and blocks the visible page.

This is not caused by Calgary Condo Leads. It is the IDX registration gate from myRealPage.

## Next testing tasks

- Clean the page shortcode stack.
- Save/update the page.
- Purge SG cache.
- Test the page again.
- Adjust myRealPage registration popup behavior before launch.
