# Calgary Condo Search

Private website build repository for the Calgary Condo Search WordPress site.

## Current build status

This repository contains a self-contained WordPress lead-generation plugin at:

`plugins/calgary-condo-leads/`

The plugin adds conversion-focused sections around the site’s existing myRealPage IDX search experience. It does **not** modify, replace, seed, scrape, or update the myRealPage IDX plugin, MLS data, or listing data.

Current plugin version: `1.0.6`.

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

2. In WordPress admin, go to **Plugins → Add New Plugin → Upload Plugin**.
3. Upload `calgary-condo-leads.zip`.
4. Activate **Calgary Condo Leads**.
5. Keep the existing myRealPage IDX plugin and shortcode in place. Do not delete or replace the IDX shortcode.
6. Keep Coming Soon mode enabled until the site owner approves launch.

## Shortcode usage instructions

### Recommended Calgary condo search page layout

Add the lead-generation shortcodes around the existing myRealPage IDX shortcode or IDX page embed:

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

### Hero shortcode

```text
[ccl_hero]
```

Optional attributes:

```text
[ccl_hero eyebrow="Calgary Condo Search" title="Search Calgary Condos For Sale" subtitle="Browse Calgary apartment condo listings with the existing IDX search." primary_text="Search Condos" primary_url="#idx-search" secondary_text="Get Condo Alerts" secondary_url="#condo-alerts" panel_title="Built for Calgary condo buyers." panel_text="Search smarter before booking a showing."]
```

### Quick search shortcode

```text
[ccl_quick_search]
```

### Value cards shortcode

```text
[ccl_value_cards]
```

Optional attributes:

```text
[ccl_value_cards title_1="Use the Existing IDX Search" text_1="Keep visitors focused on live listings from the approved IDX setup." title_2="Compare Condo Details" text_2="Help buyers think about fees, amenities, parking, and resale value." title_3="Capture Better Leads" text_3="Give serious buyers a simple next step."]
```

### Area, price, market, checklist, buyer path, building, seller, and footer shortcodes

```text
[ccl_area_grid]
[ccl_price_grid]
[ccl_market_snapshot]
[ccl_building_checklist]
[ccl_buyer_path]
[ccl_building_cta]
[ccl_seller_cta]
[ccl_site_footer]
```

### Condo alert form shortcode

```text
[ccl_alert_form]
```

Optional attributes:

```text
[ccl_alert_form title="Get Calgary Condo Alerts" subtitle="Tell us what you are looking for." button_text="Send Me Condo Alerts" privacy_text="Your details stay with Calgary Condo Search." success_message="Thanks. Your condo alert request has been received."]
```

Submissions are stored privately in WordPress admin under **Condo Leads** and emailed to the site admin email address configured in WordPress.

## QA checklist before launch

1. Confirm the ZIP contains the folder `calgary-condo-leads/` at its root.
2. Confirm `calgary-condo-leads.php` is directly inside that folder.
3. Confirm the existing myRealPage IDX plugin is still installed and unchanged.
4. Confirm no fake listings or fake MLS content has been added.
5. Confirm Calgary Condo Search page loads on desktop and mobile.
6. Confirm IDX search, listing cards, and listing detail pages still work.
7. Confirm all Calgary Condo Search pages use the Calgary phone number only.
8. Confirm condo lead form submission creates a private admin lead and emails the configured admin address.
9. Confirm quick-search, area, price, market snapshot, checklist, building-alert, seller-CTA, and footer links go to real pages or approved placeholder pages.
10. Confirm Coming Soon mode remains on until launch approval.

## Supporting docs

- `docs/2026-06-10-lead-gen-sections.md` — notes for the newest lead-generation sections.
- `docs/live-launch-qa-checklist.md` — full live launch QA checklist for WordPress, IDX, mobile, forms, links, cache, and final approval.
