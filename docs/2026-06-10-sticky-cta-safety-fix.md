# 2026-06-10 Sticky CTA Safety Fix

## Issue observed during live QA

During manual WordPress QA, the sticky bottom CTA sat close to the myRealPage IDX controls and visitor flow. While the IDX itself continued to load correctly, the sticky CTA created confusion near the IDX search and account popup flow.

## Fix committed

The sticky CTA visual output is disabled in CSS:

```css
.ccl-sticky-cta {
  display: none !important;
}
```

This preserves the `[ccl_sticky_cta]` shortcode for future use, but prevents it from visually covering or competing with IDX search controls, IDX popups, or lead-form fields.

## Why this approach

- Protects myRealPage IDX interactions.
- Avoids changing IDX plugin data, listing data, listing cards, or detail pages.
- Keeps the shortcode available for a future non-sticky or desktop-only version.
- Removes the immediate confusion before launch.

## Deployment checkpoint

A new GitHub Actions package should be generated after commit `266733b` or later.

Upload the newest `calgary-condo-leads.zip` package in WordPress, replace the current plugin, keep the plugin active, and purge SiteGround cache.

## QA after upload

- Confirm Calgary Condo Leads plugin remains active.
- Confirm version remains at least `1.0.7` or later.
- Confirm `/calgary-condo-search/` loads.
- Confirm myRealPage IDX filters still load.
- Confirm the bottom sticky CTA no longer appears over IDX or forms.
- Confirm Coming Soon mode remains enabled until launch approval.
