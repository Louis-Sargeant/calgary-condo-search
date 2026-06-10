# WordPress Page Layout — Calgary Condo Search

Use this as the working layout for the main Calgary condo search page after the upgraded plugin ZIP is installed.

## Main Calgary condo search page

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

## Page purpose

This page should do three jobs:

1. Let buyers search live Calgary condo listings through the approved myRealPage IDX.
2. Capture buyer leads through condo alerts and building alerts.
3. Capture seller leads from Calgary condo owners through the condo value report CTA.

## Rules

- Do not remove, replace, seed, scrape, or edit the myRealPage IDX listing data.
- Keep Coming Soon mode on until everything is tested.
- Calgary-only contact information on every Calgary Condo Search page.
- No Vancouver phone number on this site.
- Every search card should either point to a real page or an approved placeholder page before launch.

## Suggested page title and SEO

Title/H1 handled by shortcode:

```text
Search Calgary Condos For Sale
```

Suggested SEO title:

```text
Calgary Condos For Sale | Calgary Condo Search
```

Suggested meta description:

```text
Search Calgary condos for sale, compare buildings, set up condo alerts, and get Calgary condo guidance with a fighter in your corner.
```

## After upload checks

- Hero loads at the top.
- IDX search appears directly below the quick-search section.
- No duplicate page title appears above the hero.
- Lead form submits successfully.
- Lead appears in WordPress admin under Condo Leads.
- Lead notification email sends to the correct admin email.
- Calgary phone number shows in seller CTA/footer.
- All sections stack cleanly on mobile.
