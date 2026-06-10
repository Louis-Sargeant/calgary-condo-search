# WordPress Page Layout Shortcode Map

Use this as the working map for building pages in WordPress with the Calgary Condo Leads plugin.

## Main search page

Page: Calgary Condo Search

Recommended layout:

```text
[ccl_hero title="Search Calgary Condos With a Fighter In Your Corner" subtitle="Search live Calgary condo listings, compare buildings, and get direct guidance before booking a showing." primary_text="Search Calgary Condos" primary_url="#idx-search" secondary_text="Get My Condo Value Report" secondary_url="/condo-value-report/" panel_title="Get Calgary condo matches sent to you" panel_text="Tell us your preferred area, budget, and building style so your search stays focused."]

[ccl_price_grid]

<div id="idx-search">
Keep the existing myRealPage IDX shortcode here.
</div>

[ccl_area_grid]

[ccl_building_cta]

[ccl_alert_form title="Get Calgary Condo Alerts" subtitle="Tell us what you are looking for and we will follow up with Calgary condo options, building insight, and next steps." button_text="Send My Condo Match Request"]

[ccl_site_footer]
```

## Calgary Condos page

Suggested slug: `/calgary-condos/`

```text
[ccl_hero title="Calgary Condos For Sale" subtitle="Search Calgary apartment condos, compare areas, and get guidance before booking a showing." primary_text="Search Live Listings" primary_url="#idx-search" secondary_text="Get Condo Alerts" secondary_url="#condo-alerts" panel_title="Calgary-only condo guidance" panel_text="Focused on Calgary condo buyers, sellers, buildings, and market movement."]

[ccl_price_grid]

<div id="idx-search">
Add the relevant myRealPage IDX shortcode or saved search embed here.
</div>

[ccl_area_grid]
[ccl_alert_form]
[ccl_site_footer]
```

## Price pages

Create these pages and connect them to the correct IDX search/embed where available:

- `/calgary-condos-under-300k/`
- `/calgary-condos-300k-500k/`
- `/calgary-condos-500k-750k/`
- `/calgary-luxury-condos/`

Base layout:

```text
[ccl_hero title="Calgary Condos Under $300K" subtitle="Search Calgary condo options in this price range and get help comparing building fit, location, fees, and resale value." primary_text="Search Listings" primary_url="#idx-search" secondary_text="Get Condo Alerts" secondary_url="#condo-alerts"]

<div id="idx-search">
Add the matching myRealPage IDX shortcode or saved search embed here.
</div>

[ccl_building_cta]
[ccl_alert_form]
[ccl_site_footer]
```

Change the title for each price page.

## Area pages

Create these pages and connect them to the correct IDX search/embed where available:

- `/downtown-calgary-condos/`
- `/beltline-condos/`
- `/east-village-condos/`
- `/mission-condos/`
- `/eau-claire-condos/`

Base layout:

```text
[ccl_hero title="Beltline Condos For Sale" subtitle="Search Beltline condos and compare building fit, walkability, amenities, fees, and resale value before booking showings." primary_text="Search Beltline Condos" primary_url="#idx-search" secondary_text="Get Building Alerts" secondary_url="#condo-alerts"]

<div id="idx-search">
Add the matching myRealPage IDX shortcode or saved search embed here.
</div>

[ccl_building_cta]
[ccl_alert_form]
[ccl_site_footer]
```

Change the title and subtitle for each area page.

## Building pages

Hub page slug: `/condo-buildings/`

```text
[ccl_hero title="Calgary Condo Buildings" subtitle="Research Calgary condo buildings, compare listings, and watch the buildings that fit your search." primary_text="Search Buildings" primary_url="#building-search" secondary_text="Set Building Alerts" secondary_url="#condo-alerts"]

[ccl_building_cta]
[ccl_area_grid]
[ccl_alert_form title="Watch a Calgary Condo Building" subtitle="Tell us the building or area you want to watch and we will help you track listings and opportunities." button_text="Set Up Building Alerts"]
[ccl_site_footer]
```

## Seller page

Suggested slug: `/condo-value-report/`

```text
[ccl_hero title="Calgary Condo Value Report" subtitle="Get a Calgary condo value check based on your building, recent sales, active competition, and current buyer demand." primary_text="Request My Value Report" primary_url="#condo-alerts" secondary_text="Search Calgary Condos" secondary_url="/calgary-condos/"]

[ccl_alert_form title="Request a Calgary Condo Value Report" subtitle="Send your building, unit type, and timing. We will follow up with a focused Calgary condo value plan." button_text="Send My Value Report Request"]
[ccl_site_footer]
```

## Contact standard

Use Calgary number only:

```text
+1 (403) 800-6996
```

If the IDX cards or listing detail pages show another phone number, that likely needs to be changed in myRealPage account/profile settings rather than in this plugin.
