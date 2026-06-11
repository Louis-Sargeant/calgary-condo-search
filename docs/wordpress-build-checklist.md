# WordPress Build Checklist — Calgary Condo Search

Use this checklist after the `calgary-condo-leads.zip` package is uploaded and active in WordPress.

## Pre-build rules

- Keep Coming Soon mode on.
- Do not remove or replace the myRealPage IDX plugin.
- Do not edit MLS/listing data, listing cards, listing detail pages, or IDX output.
- Use Calgary-only contact information.
- Purge SiteGround cache only after plugin upload/page edits are complete.

## Plugin upload checkpoint

1. Download the GitHub Actions artifact named `calgary-condo-leads-wordpress-plugin`.
2. Extract the artifact if needed.
3. Upload `calgary-condo-leads.zip` in WordPress under **Plugins → Add New Plugin → Upload Plugin**.
4. Choose **Replace current with uploaded** if WordPress says the plugin already exists.
5. Confirm **Calgary Condo Leads** remains active.
6. Confirm WordPress shows version `1.0.7`.

## Main Calgary condo search page

Use this page as the main conversion page.

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

## Supporting pages to create or verify

Create these pages as real pages or approved placeholders so CTA links do not dead-end:

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
- `/condo-buildings/`
- `/building-alerts/`
- `/condo-value-report/`
- `/market-report/`

Use `docs/supporting-page-content.md` for ready-to-paste titles, meta descriptions, intro copy, and shortcode stacks.

## Form QA

Submit one test lead with:

- Name: Test Lead
- Email: a real test email controlled by the site owner
- Preferred area: Beltline
- Budget: $300K - $500K
- Timeline: 1-3 months
- Message: Test submission for Calgary Condo Search launch QA.

Confirm:

- Success message appears.
- Lead appears under **Condo Leads** in WordPress admin.
- Admin notification email arrives.
- Empty name/email validation blocks submission.
- Honeypot remains hidden.

## Desktop QA

Check:

- Hero layout and H1 are readable.
- IDX shell wraps the existing IDX search without breaking it.
- IDX controls, listing cards, and listing detail pages work.
- Intent-capture cards route correctly.
- CTA buttons go to `#idx-search`, `#condo-alerts`, `/condo-value-report/`, or approved support pages.
- Footer phone link is clickable.

## Mobile QA

Check on a real phone when possible:

- Hero text and buttons fit cleanly.
- Cards stack correctly.
- IDX controls remain usable.
- Sticky CTA does not cover IDX controls or form fields.
- Form fields are easy to tap.
- Footer phone link is easy to tap.

## Cache and final review

1. Purge SiteGround cache.
2. Open the site in an incognito/private browser.
3. Recheck main page desktop.
4. Recheck main page mobile.
5. Recheck form submission.
6. Keep Coming Soon mode enabled until final owner launch approval.
