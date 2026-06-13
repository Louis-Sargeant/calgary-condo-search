# Visual Test Review Before Live

## Status

The Visual Test - Calgary Condo Hub page now has the correct overall direction.

The visual flow is working:

1. Premium dark Calgary condo hero
2. Search intent tabs
3. Three primary CTAs
4. Shortcut cards
5. Calgary Condo Assistant section
6. Live Calgary Condo Listings intro
7. myRealPage IDX loads underneath
8. Footer loads

## User visual feedback

User likes the feel and wants to continue on this route.

## What is approved conceptually

- Search-first design
- Calgary-only positioning
- Dark blue and gold premium brand feel
- Calgary Condo Assistant CTA
- Realtor.com-inspired utility layout
- IDX underneath the visual search experience

## Critical issue before going live

The IDX is loading, but it appears too broad and may be showing listings beyond condo-only results.

Before moving this design to the live Calgary Condos page, the IDX/search needs to be confirmed as Calgary condo-only.

Do not publish this test page live until IDX filtering is confirmed.

## Next WordPress / myRealPage task

Find the correct myRealPage method to make the IDX results condo-only. Possible paths:

1. myRealPage saved search for Calgary condos
2. myRealPage search form definition configured for condos
3. myRealPage shortcode parameter for property type, if supported
4. myRealPage account/backend search setup

Do not guess or hard-code unsupported parameters on the live page.

## Current safe shortcode

This shortcode loads IDX but may be broad:

```text
[mrp account_id=67196 searchform_def=idx.browse embed=true context=recip]
```

## Do-not-break rule

The live Calgary Condos page is still protected. Do not overwrite it until:

- Visual test is approved
- IDX is condo-only
- Mobile preview is checked
- Draft page is backed up

## Immediate next step

Use the test page to identify or confirm the correct condo-only myRealPage IDX setup.
