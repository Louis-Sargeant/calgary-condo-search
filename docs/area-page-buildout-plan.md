# Calgary Condo Area Page Buildout Plan

## Purpose

The Calgary Condos page should stay fast and stable. Area cards should not load separate live IDX sections on the main page. Each area card should link to a dedicated search page.

## First test page

Start with one page:

```text
/beltline-condos/
```

Use the working myRealPage shortcode first without heavy filters:

```text
[mrp account_id=67196 searchform_def=idx.browse embed=true context=recip]
```

Once the page loads correctly, test the correct myRealPage filter for Beltline on that page only.

## Area page structure

Each area page should include:

1. Visual hero
2. Short neighbourhood-specific value proposition
3. Live myRealPage IDX search section
4. Buyer CTA: get alerts for this area
5. Seller CTA: request a condo value report
6. Links to nearby condo areas
7. Short SEO content lower on the page

## Priority area pages

Build in this order:

1. Beltline Condos
2. Downtown Calgary Condos
3. East Village Condos
4. Mission Condos
5. Eau Claire Condos
6. Kensington / Hillhurst Condos
7. Bridgeland Condos
8. Inglewood Condos
9. Lower Mount Royal Condos

## Safe editing rule

Do not bulk-create all area pages until one test area page works end-to-end.

Do not use Elementor on these pages unless the normal WordPress block editor fails.

Do not add custom plugin shortcodes until the myRealPage IDX works on the page.

## Lead capture rule

Every area page must have one clear buyer lead action:

```text
Get area condo alerts
```

And one clear seller lead action:

```text
Get my condo value report
```

## Internal linking rule

Every area page should link back to:

```text
/calgary-condos/
```

And link sideways to at least three nearby area pages.
