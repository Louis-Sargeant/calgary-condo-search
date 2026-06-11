# Sticky CTA Shortcode

The `[ccl_sticky_cta]` shortcode adds an optional sticky conversion bar for Calgary Condo Search pages.

## Purpose

The sticky CTA keeps the main buyer actions visible while visitors scroll through IDX listings, buyer education sections, FAQs, and lead forms.

It is designed to help visitors quickly return to:

- Live condo search
- Condo alerts
- Building guidance

## Recommended placement

Place it near the bottom of the page content after the main conversion sections. It uses sticky positioning, so it can remain visible while the visitor scrolls.

```text
[ccl_idx_shell]
    Place the existing approved IDX shortcode here.
[/ccl_idx_shell]

[ccl_value_cards]
[ccl_area_grid]
[ccl_price_grid]
[ccl_market_snapshot]
[ccl_building_checklist]
[ccl_buyer_path]
[ccl_faq]
[ccl_alert_form]
[ccl_sticky_cta]
[ccl_site_footer]
```

## Default shortcode

```text
[ccl_sticky_cta]
```

## Optional attributes

```text
[ccl_sticky_cta text="Ready to compare Calgary condos with a plan?" primary_text="Search Listings" primary_url="#idx-search" secondary_text="Get Alerts" secondary_url="#condo-alerts"]
```

## Launch QA

Before launch, confirm:

1. The bar does not cover important IDX controls on mobile.
2. The primary button jumps to the IDX search section.
3. The secondary button jumps to the condo alert form.
4. It displays cleanly on desktop and mobile.
5. It does not interfere with the site cookie banner, chat widget, or Coming Soon overlay.

## Notes

This shortcode does not touch IDX data, listing data, or account-level settings. It only adds a conversion path for visitors already on the page.
