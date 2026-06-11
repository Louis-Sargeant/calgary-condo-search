# 2026-06-10 Calgary lead-generation section update

## Added through plugin version 1.0.7

### Version 1.0.6 sections

- `[ccl_market_snapshot]` — Calgary condo buyer education section focused on building strength, true monthly cost, lifestyle fit, and resale/exit plan.
- `[ccl_building_checklist]` — Calgary condo due-diligence section focused on documents, fees, rules, unit details, building demand, and offer strategy.

### Version 1.0.7 sections

- `[ccl_intent_capture]` — visitor-intent cards that route buyers, alert requests, condo owners, and building-risk questions to the right next step.
- `[ccl_next_step_band]` — compact bottom-of-page CTA for visitors who need guidance before booking showings.
- `[ccl_idx_shell]` — conversion wrapper for the existing IDX shortcode or embed. This wrapper must not replace or alter IDX data.
- `[ccl_trust_strip]` — trust/proof strip focused on live IDX search, building-first guidance, buyer alerts, and cleaner decisions.
- `[ccl_lead_magnet]` — checklist CTA that routes visitors into the condo alert form.
- `[ccl_building_scorecard]` — building-risk scorecard for documents, fees, rules, and resale.
- `[ccl_action_router]` — routing cards for active listings, building alerts, and risk/guidance.
- `[ccl_faq]` — Calgary condo buyer FAQ for SEO and objection handling.
- `[ccl_sticky_cta]` — optional sticky CTA for search and alerts.

## Recommended page order

```text
[ccl_hero primary_url="#idx-search" secondary_url="#condo-alerts"]
[ccl_quick_search]
[ccl_intent_capture]
[ccl_trust_strip]

[ccl_idx_shell]
    Keep the existing myRealPage IDX shortcode here.
[/ccl_idx_shell]

[ccl_value_cards]
[ccl_area_grid]
[ccl_price_grid]
[ccl_market_snapshot]
[ccl_building_checklist]
[ccl_building_scorecard]
[ccl_buyer_path]
[ccl_lead_magnet]
[ccl_action_router]
[ccl_building_cta]
[ccl_alert_form]
[ccl_seller_cta]
[ccl_faq]
[ccl_next_step_band]
[ccl_site_footer]
[ccl_sticky_cta]
```

## QA notes

- These sections are educational and conversion-focused only. They do not add fake market statistics, fake listings, scraped MLS content, or placeholder property data.
- The existing myRealPage IDX search must remain in place and unchanged.
- Calgary-only phone number remains `+1 (403) 800-6996`.
- Coming Soon mode should remain enabled until IDX, links, forms, mobile layout, and Calgary contact information are checked.
- Sticky CTA must be checked on mobile to confirm it does not block IDX controls or form fields.