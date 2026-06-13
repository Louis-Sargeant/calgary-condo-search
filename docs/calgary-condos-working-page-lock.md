# Calgary Condos Working Page Lock

## Current working state

The Calgary Condos page is now working at:

```text
/calgary-condos/
```

The working page is the former IDX Test page, renamed to Calgary Condos and assigned the `calgary-condos` slug.

The working page uses the myRealPage shortcode directly:

```text
[mrp account_id=67196 searchform_def=idx.browse embed=true context=recip]
```

A visual Custom HTML hero is placed above the IDX shortcode.

## What was fixed

- The broken Elementor page was moved out of the way as `calgary-condos-broken`.
- The old duplicate page was moved out of the way as `calgary-condos-old`.
- The custom Calgary Condo Leads plugin was deactivated for this page.
- The myRealPage IDX search was confirmed working.
- Listing cards open successfully.
- Listing detail pages load successfully.

## Do not break rules

Do not reactivate the Calgary Condo Leads plugin for the Calgary Condos page.

Do not edit the Calgary Condos page with Elementor.

Do not replace the working myRealPage shortcode with a filtered shortcode until filters are tested on a separate test page first.

Do not add multiple live IDX blocks to the same page.

Do not add new lead-generation sections above or inside the myRealPage shortcode block unless tested first.

## Safe build path

Future sections should be added below the working IDX block only, one at a time:

1. Calgary condo building guidance CTA
2. Condo alert lead form
3. Condo value report CTA
4. Area navigation cards
5. Buyer checklist section
6. Internal links to dedicated area pages

## Area page strategy

Area cards on the Calgary Condos page should link to separate area search pages, not load multiple IDX searches on the main page.

Start with one test area page first:

```text
/beltline-condos/
```

Once Beltline works, replicate the structure for Downtown Calgary, East Village, Mission, Eau Claire, Kensington/Hillhurst, Bridgeland, Inglewood, and Lower Mount Royal.
