# Building Scorecard Shortcode

The `[ccl_building_scorecard]` shortcode adds a buyer-friendly scorecard section for evaluating Calgary condo buildings before chasing a listing.

## Purpose

This section helps visitors think beyond photos and price. It supports lead capture by pushing buyers toward building research, condo alerts, and document-review guidance.

## Default shortcode

```text
[ccl_building_scorecard]
```

## Optional attributes

```text
[ccl_building_scorecard eyebrow="Calgary Condo Building Scorecard" title="Score the building before you chase the unit" subtitle="A condo can look good online and still be the wrong move. Use this scorecard to think through the building before booking showings or writing an offer." button_text="Ask About A Building" button_url="#condo-alerts"]
```

## Built-in scorecard categories

- Documents
- Fees
- Rules
- Resale

## Recommended placement

Use this after the IDX search and before the alert form. It works especially well after the market snapshot or building checklist sections.

```text
[ccl_idx_shell]
    Place the existing approved IDX shortcode here.
[/ccl_idx_shell]

[ccl_market_snapshot]
[ccl_building_scorecard]
[ccl_building_checklist]
[ccl_lead_magnet]
[ccl_alert_form]
```

## Conversion role

The scorecard creates a natural reason for buyers to ask about a specific building. It is meant to turn passive listing browsing into a higher-quality lead conversation.

## Launch QA

1. Confirm the CTA jumps to the condo alert or building inquiry form.
2. Confirm the section displays cleanly on mobile.
3. Confirm it does not use fake market statistics or listing data.
4. Confirm it supports the page flow and does not duplicate nearby checklist copy too heavily.
