# Calgary Condo Search Live Launch QA Checklist

Use this checklist after the Calgary Condo Leads plugin package is uploaded to WordPress and before Coming Soon mode is removed.

## Hard rules

- Keep Coming Soon mode enabled until every launch item is checked.
- Do not replace, edit, seed, scrape, or modify the myRealPage IDX plugin, IDX shortcode, MLS data, listing cards, or listing detail pages.
- Keep Calgary-only contact information across Calgary Condo Search pages.
- Confirm the Calgary phone number appears correctly as `+1 (403) 800-6996` and the click-to-call link uses `+14038006996`.
- Do not add fake listings, fake MLS content, unverified market statistics, or scraped market data.

## Plugin package check

- Confirm the uploaded ZIP contains `calgary-condo-leads/` at the root.
- Confirm `calgary-condo-leads.php` is directly inside that folder.
- Confirm the plugin version shown in WordPress is `1.0.7`.
- Confirm these files are present in the plugin folder:
  - `includes/class-calgary-condo-leads.php`
  - `includes/class-calgary-condo-site-sections.php`
  - `includes/class-calgary-condo-assets.php`
  - `includes/class-calgary-condo-trust-strip.php`
  - `includes/class-calgary-condo-intent-capture.php`
  - `assets/css/calgary-condo-leads.css`
  - `assets/css/calgary-condo-leads-extended.css`
- Confirm **Calgary Condo Leads** remains active after upload/replacement.

## Recommended page layout

Use this layout on the Calgary condo search page while keeping the existing IDX embed in place:

```text
[ccl_hero primary_url="#idx-search" secondary_url="#condo-alerts"]
[ccl_quick_search]
[ccl_intent_capture]
[ccl_trust_strip]

[ccl_idx_shell]
    Keep the existing myRealPage IDX shortcode or approved IDX embed here.
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

## IDX checks

- Confirm the existing myRealPage IDX search appears on the Calgary condo page.
- Confirm IDX search controls load.
- Confirm listing cards load.
- Confirm listing detail pages open correctly.
- Confirm no fake listings or placeholder property data were introduced by the plugin.
- Confirm IDX still functions on mobile.

## Lead capture checks

- Submit one test condo alert lead with a real test email address.
- Confirm the success message appears on the page.
- Confirm the lead is stored privately under **Condo Leads** in WordPress admin.
- Confirm the email notification reaches the configured WordPress admin email.
- Confirm the spam honeypot field remains hidden on the front end.
- Confirm required validation blocks empty name/email submissions.

## Conversion section checks

- Confirm the intent-capture cards route visitors to search, alerts, seller valuation, and building-risk guidance.
- Confirm the trust strip appears near the IDX experience and does not alter IDX output.
- Confirm the lead-magnet, building scorecard, action router, FAQ, next-step band, and sticky CTA display correctly.
- Confirm all CTA buttons either jump to `#idx-search`, jump to `#condo-alerts`, call the Calgary number, or open an approved page.
- Confirm no section contains fake market statistics, fake listings, or scraped MLS content.

## Mobile checks

Check the page on mobile width and real phone if possible:

- Hero heading is readable.
- Buttons are full-width or easy to tap.
- IDX search is usable.
- Quick-search cards stack properly.
- Intent-capture cards stack properly.
- Market snapshot cards stack properly.
- Building checklist cards stack properly.
- Building scorecard cards stack properly.
- FAQ accordions open and close cleanly.
- Sticky CTA does not block form fields or IDX controls.
- Lead form fields are easy to use.
- Footer phone number is easy to tap.

## Link checks

Confirm the following links either go to real pages or approved placeholders:

- `/calgary-condos/`
- `/inner-city-calgary-condos/`
- `/calgary-concrete-condos/`
- `/calgary-pet-friendly-condos/`
- `/downtown-calgary-condos/`
- `/beltline-condos/`
- `/east-village-condos/`
- `/mission-condos/`
- `/eau-claire-condos/`
- `/calgary-luxury-condos/`
- `/calgary-condos-under-300k/`
- `/calgary-condos-300k-500k/`
- `/calgary-condos-500k-750k/`
- `/condo-value-report/`
- `/condo-buildings/`
- `/market-report/`
- `/building-alerts/`

## Cache and launch checks

- Purge SiteGround cache after upload and page edits.
- Check the page in an incognito/private browser window.
- Check desktop and mobile after cache purge.
- Confirm Coming Soon mode is still on until final launch approval.
- Launch only after the site owner approves IDX, phone, lead form, mobile layout, and links.