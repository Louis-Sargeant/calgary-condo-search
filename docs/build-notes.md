# Build Notes

Calgary Condo Search build notes.

## Current status

- WordPress lead-generation plugin exists at `plugins/calgary-condo-leads/`.
- Plugin version is currently `1.0.5`.
- Calgary contact defaults are set in the plugin.
- Expanded lead-generation shortcodes have been added.
- Admin shortcode help has been updated.
- Coming Soon stays on until final approval.

## Main page stack

```text
[ccl_hero primary_url="#idx-search" secondary_url="#condo-alerts"]
[ccl_quick_search]

<div id="idx-search">
    Keep the existing myRealPage IDX shortcode or IDX embed here.
</div>

[ccl_value_cards]
[ccl_area_grid]
[ccl_price_grid]
[ccl_buyer_path]
[ccl_building_cta]
[ccl_alert_form]
[ccl_seller_cta]
[ccl_site_footer]
```

## Deployment steps

1. Package the plugin from GitHub Actions.
2. Download the `calgary-condo-leads-wordpress-plugin` artifact.
3. Upload `calgary-condo-leads.zip` in WordPress.
4. Replace the existing plugin if WordPress asks.
5. Confirm **Calgary Condo Leads** remains active.
6. Open **Condo Leads → Shortcodes** and confirm the expanded shortcode layout appears.
7. Purge SiteGround cache.
8. Check the main Calgary Condos page in a private browser window.

## Do not launch until

- IDX listings load.
- IDX listing detail pages work.
- Lead form submits successfully.
- Test lead appears in WordPress admin.
- Lead email notification sends correctly.
- Calgary phone number appears everywhere it should.
- No Vancouver phone number appears on Calgary Condo Search pages.
- Desktop and mobile layouts are checked.
- Owner approves launch.
