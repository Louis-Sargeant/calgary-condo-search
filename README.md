# Calgary Condo Search

Private website build repository for the Calgary Condo Search WordPress site.

## Current build status

This repository contains a self-contained WordPress lead-generation plugin at:

`plugins/calgary-condo-leads/`

The plugin adds conversion-focused sections around the site’s existing myRealPage IDX search experience. It does **not** modify, replace, seed, scrape, or update the myRealPage IDX plugin, MLS data, or listing data.

Current plugin version: `1.0.13`.

## Working rules

- The site owner approves, checks, and grants access.
- GitHub/Codex handles the build work whenever possible.
- WordPress login work is limited to required admin actions such as plugin upload, activation, cache purge, and final visual checks.
- Coming Soon mode stays on until launch approval.
- Calgary Condo Search pages must use Calgary-only contact information.
- Calgary phone number: `+1 (403) 800-6996`.
- Click-to-call value: `+14038006996`.

## What the plugin includes

- `[ccl_hero]` — mobile-first hero section with configurable calls to action.
- `[ccl_quick_search]` — high-intent quick search cards for Calgary condo buyers.
- `[ccl_value_cards]` — trust/value proposition cards for the Calgary condo search page.
- `[ccl_area_grid]` — Calgary condo area cards.
- `[ccl_price_grid]` — Calgary condo price-range cards.
- `[ccl_market_snapshot]` — buyer education section for comparing building strength, true monthly cost, lifestyle fit, and resale path without fake market statistics.
- `[ccl_building_checklist]` — due-diligence checklist for condo documents, fees, rules, unit details, building demand, and offer strategy.
- `[ccl_buyer_path]` — buyer education section that explains what to check before booking showings.
- `[ccl_idx_shell]` — conversion-focused wrapper for the existing IDX shortcode or embed.
- `[ccl_trust_strip]` — trust/proof strip for IDX and building-first guidance.
- `[ccl_lead_magnet]` — checklist CTA that routes buyers into the alert form.
- `[ccl_building_scorecard]` — building-risk scorecard section.
- `[ccl_action_router]` — next-step router for search, building alerts, and guidance.
- `[ccl_intent_capture]` — visitor-intent cards for browsing, alerts, sellers, and building-risk questions.
- `[ccl_next_step_band]` — compact CTA band for bottom-of-page conversion.
- `[ccl_faq]` — Calgary condo buyer FAQ content.
- `[ccl_sticky_cta]` — optional sticky search/alert CTA.
- `[ccl_building_cta]` — building-alert CTA.
- `[ccl_seller_cta]` — Calgary condo owner valuation CTA using the Calgary phone number.
- `[ccl_alert_form]` — condo alert lead form with nonce validation, spam honeypot, admin email notification, and private lead storage in WordPress admin under **Condo Leads**.
- `[ccl_site_footer]` — Calgary-only footer/contact block.
- Front-end CSS in `assets/css/calgary-condo-leads.css`.
- Extended lead-generation section CSS in `assets/css/calgary-condo-leads-extended.css`.
- Page-specific layout cleanup for the Calgary Condo Search page.
- Admin shortcode help page under **Condo Leads → Shortcodes**.

## Preferred deployment workflow

Use GitHub Actions whenever possible so the site owner does not have to manually create ZIP files.

1. Push approved changes to `main`.
2. Open **Actions → Package Calgary Condo Leads Plugin**.
3. Download the artifact named `calgary-condo-leads-wordpress-plugin`.
4. Extract the artifact ZIP if needed. It contains the WordPress upload file:

   ```text
   calgary-condo-leads.zip
   ```

5. In WordPress admin, go to **Plugins → Add New Plugin → Upload Plugin**.
6. Upload `calgary-condo-leads.zip`.
7. If WordPress says the plugin already exists, choose **Replace current with uploaded**.
8. Confirm **Calgary Condo Leads** remains active.
9. Purge SiteGround cache.
10. Check the live Calgary Condo Search page.

## Manual fallback install instructions

Only use this if the GitHub Actions artifact is not available.

1. From this repository, zip the plugin folder only:

   ```bash
   cd plugins
   zip -r calgary-condo-leads.zip calgary-condo-leads
   ```
