# Calgary Condo-Only IDX Detail Page Confirmed

## Confirmed on Visual/Working Calgary Condos page

The new condo-only myRealPage shortcode was pasted into the working Calgary Condos page and previewed.

## Confirmed behavior

- Listings load.
- Visible results are Calgary apartment/condo style listings.
- Detached house results are no longer visible in the tested output.
- A listing detail page opened successfully.
- Detail page showed:
  - Address: 1607 3830 Brentwood Road NW
  - Calgary area: Brentwood
  - Price: $320,000
  - Residential apartment condo detail layout
  - Photo gallery
  - Map
  - Schedule a viewing form

## Remaining issue

The working page URL currently shows:

```text
/calgary-condos-2/
```

This means the condo-only IDX works, but the URL/duplicate-page cleanup still needs to be handled carefully.

## Next recommended action

Before changing slugs, verify which page currently owns `/calgary-condos/` and which owns `/calgary-condos-2/`.

Do not delete pages until the live page URL is confirmed.

Preferred final state:

```text
/calgary-condos/
```

with the visual hero and condo-only IDX shortcode.
