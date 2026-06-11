# WordPress Deployment Runbook

This runbook is for moving the Calgary Condo Leads plugin from GitHub to the WordPress staging/live site without breaking the approved myRealPage IDX setup.

## Before deployment

- Confirm the latest approved changes are on `main`.
- Confirm the plugin version in `plugins/calgary-condo-leads/calgary-condo-leads.php` is `1.0.6`.
- Confirm the Calgary phone number remains `+1 (403) 800-6996`.
- Confirm the click-to-call value remains `+14038006996`.
- Confirm Coming Soon mode is still enabled.
- Confirm the existing myRealPage IDX widget, shortcode, and page setup are not changed by this plugin.

## Build the upload ZIP

Preferred method:

1. Open GitHub Actions.
2. Run **Package Calgary Condo Leads Plugin**.
3. Download the artifact named `calgary-condo-leads-wordpress-plugin`.
4. Extract the artifact if needed.
5. Use the contained file `calgary-condo-leads.zip` for WordPress upload.

Manual fallback:

```bash
cd plugins
zip -r calgary-condo-leads.zip calgary-condo-leads
```

The ZIP must contain `calgary-condo-leads/` at the root, not loose plugin files.

## Upload in WordPress

1. Log in to WordPress admin.
2. Go to **Plugins → Add New Plugin → Upload Plugin**.
3. Upload `calgary-condo-leads.zip`.
4. If WordPress says the plugin already exists, choose **Replace current with uploaded**.
5. Confirm **Calgary Condo Leads** is active.
6. Do not deactivate or replace the existing myRealPage IDX plugin.

## Page content order

Use this page layout around the existing IDX block:

```text
[ccl_hero primary_url="#idx-search" secondary_url="#condo-alerts"]
[ccl_quick_search]

<div id="idx-search">
    Keep the existing myRealPage IDX shortcode or approved IDX embed here.
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

## Immediate checks after upload

- Confirm the page loads without a WordPress fatal error.
- Confirm the hero section renders.
- Confirm quick search cards render.
- Confirm market snapshot cards render.
- Confirm building checklist cards render.
- Confirm seller CTA and footer show the Calgary phone number.
- Confirm the IDX block still loads.
- Confirm listing cards and listing detail links still work.

## Lead form test

Submit one test lead through `[ccl_alert_form]`.

Confirm:

- Success message appears.
- Lead is stored under **Condo Leads**.
- Email notification is sent to the configured WordPress admin email.
- Honeypot field is not visible to normal users.
- Empty required fields do not submit.

## Cache and final QA

1. Purge SiteGround cache.
2. Open the page in an incognito/private window.
3. Test desktop.
4. Test mobile.
5. Confirm click-to-call works.
6. Confirm no fake listings, fake MLS data, or scraped data appear anywhere.
7. Keep Coming Soon enabled until final owner approval.

## Launch gate

Do not remove Coming Soon mode until these are confirmed:

- IDX search works.
- Listing cards work.
- Listing details work.
- Lead form saves and emails correctly.
- Calgary phone is correct everywhere.
- Mobile layout is clean.
- Site owner approves launch.
