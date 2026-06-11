# Calgary Phone and IDX Verification

Use this before launch to confirm Calgary Condo Search is Calgary-only while keeping the approved myRealPage IDX setup untouched.

## Correct Calgary contact values

- Display phone: `+1 (403) 800-6996`
- Click-to-call value: `+14038006996`
- Site focus: Calgary Condo Search only

## Hard rules

- Do not edit, replace, scrape, seed, or override myRealPage IDX listing data.
- Do not add fake MLS listings, fake listing cards, or unverified market statistics.
- Do not hide required brokerage, board, MLS, or IDX compliance information unless the site owner confirms it is allowed.
- Keep Coming Soon mode enabled until the phone number, IDX, forms, mobile layout, and links are approved.

## Plugin-level checks

The Calgary Condo Leads plugin already defines the Calgary number as constants in `calgary-condo-leads.php`:

```php
CCL_CONTACT_PHONE_DISPLAY = '+1 (403) 800-6996'
CCL_CONTACT_PHONE_TEL = '+14038006996'
```

Check these plugin-controlled areas after upload:

1. `[ccl_seller_cta]` button displays `+1 (403) 800-6996` and links to `tel:+14038006996`.
2. `[ccl_site_footer]` displays `+1 (403) 800-6996` and links to `tel:+14038006996`.
3. `[ccl_alert_form]` lead form copy stays Calgary-only.
4. No Vancouver phone number appears inside plugin-generated copy.

## WordPress/site checks

Check every public-facing Calgary page, even while Coming Soon is enabled from a logged-in/admin preview:

1. Header contact area.
2. Footer contact area.
3. Calgary Condo Search page.
4. Condo Value Report page.
5. Building Alerts page.
6. Condo Buildings page.
7. Market Report page.
8. Area and price landing pages.
9. Any schema, SEO title/description fields, or contact widgets added in WordPress.

If a Vancouver phone number appears outside the plugin, update it from the theme, page builder, site settings, footer/header widget, SEO plugin, or WordPress customizer area that controls it.

## myRealPage IDX checks

The live IDX phone number may be controlled outside this repository. Check these places without editing the IDX plugin files:

1. myRealPage account/profile contact settings.
2. Agent/profile settings connected to the IDX account.
3. Brokerage/board profile data if myRealPage pulls phone data from an approved feed.
4. WordPress myRealPage plugin settings screen, if it exposes agent/contact display settings.
5. Any IDX widget/embed configuration used on the Calgary Condo Search page.

Verify these live IDX areas:

1. IDX search panel loads.
2. IDX listing cards load.
3. IDX listing detail pages open.
4. Agent/contact block on listing cards shows Calgary number or approved compliant contact info.
5. Agent/contact block on listing detail pages shows Calgary number or approved compliant contact info.
6. Mobile IDX view still works after any account/profile change.

## What to do if the Vancouver number still shows

1. Take a screenshot of the exact location.
2. Note whether it appears in WordPress theme/page content or inside the myRealPage IDX listing area.
3. If it appears in normal WordPress content, update the relevant WordPress setting/page/widget.
4. If it appears inside IDX listing cards/details, treat it as a myRealPage/account/profile issue, not a plugin-code issue.
5. Contact myRealPage or update the approved myRealPage profile settings so the Calgary phone is used.
6. Re-test IDX cards, detail pages, mobile, and lead forms after the update.

## Acceptance checklist for issue #5

- No Vancouver number appears on Calgary Condo Search pages.
- Plugin-controlled phone links use `+1 (403) 800-6996` and `tel:+14038006996`.
- IDX search, listing cards, and listing detail pages still work.
- No fake MLS/listing content was added.
- Any required myRealPage/manual account step is documented for owner approval.
- Coming Soon stays on until final owner approval.
