# Calgary Condo-Only IDX Confirmed

## Status

The Visual Test page IDX was tested with the myRealPage WordPress shortcode generator.

The broad IDX shortcode was replaced on the test page with a generated myRealPage shortcode that includes the Apartment dwelling type filter.

## Confirmed result

Preview showed:

- Property / Dwelling Type: Apartment
- Status: Active
- Calgary apartment-style condo listings only
- No detached houses in the visible preview
- Result count: 81 visible for this generated shortcode preview

This confirms the visual test page can show condo-only IDX results.

## Important shortcode details

The generated shortcode begins with:

```text
[mrp account_id=67196 embed=true searchform_def=idx.browse context=recip ...
```

It includes:

```text
ibf_property_type=DWELLING_TYPE%40APAR
```

This appears to be the key filter for apartment-style Calgary condo listings.

## Remaining caution

Do not move this to the live Calgary Condos page until:

1. The full shortcode is copied cleanly.
2. The Visual Test preview is checked again after saving.
3. The results are confirmed as apartment/condo-only.
4. Mobile preview is checked.

## Next build step

Once confirmed, replace the live Calgary Condos IDX shortcode with the condo-only generated shortcode and preserve the current visual layout.
