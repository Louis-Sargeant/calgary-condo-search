=== Calgary Condo Leads ===
Contributors: louis-sargeant
Tags: real estate, lead generation, shortcode, calgary condos
Requires at least: 6.0
Requires PHP: 7.4
Stable tag: 1.0.0
License: Proprietary

Self-contained lead-generation shortcodes and styling for Calgary Condo Search pages that use the existing myRealPage IDX plugin.

== Description ==

Calgary Condo Leads adds conversion-focused page sections around an existing approved IDX search experience. It does not replace, modify, seed, scrape, or update the myRealPage IDX plugin, MLS data, or listing data.

Included shortcodes:

* `[ccl_hero]` - Hero section with configurable calls to action.
* `[ccl_value_cards]` - Trust/value proposition cards.
* `[ccl_alert_form]` - Condo alert form that stores leads privately under Condo Leads and emails the site admin address.

== Installation ==

1. Zip the `calgary-condo-leads` folder.
2. In WordPress admin, go to Plugins > Add New Plugin > Upload Plugin.
3. Upload the ZIP file and activate Calgary Condo Leads.
4. Keep the existing myRealPage IDX plugin and IDX shortcode in place.
5. Keep Coming Soon mode enabled until approval.

== Shortcode Usage ==

Recommended layout:

`[ccl_hero primary_url="#idx-search" secondary_url="#condo-alerts"]`

Keep the existing myRealPage IDX shortcode inside a section or block with `id="idx-search"`.

`[ccl_value_cards]`

`[ccl_alert_form]`

Admin help is available under Condo Leads > Shortcodes after activation.

== Changelog ==

= 1.0.0 =
* Initial self-contained lead-generation plugin.
