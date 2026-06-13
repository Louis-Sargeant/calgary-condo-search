# Calgary Condo Lead Gen Site Finish Sprint

## Objective

Finish the Calgary condo lead generation website without breaking the working IDX page.

The main Calgary Condos page is now stable and should not be used for risky testing.

## Working page to protect

```text
/calgary-condos/
```

Rules:

- Do not edit with Elementor.
- Do not reactivate Calgary Condo Leads plugin for this page.
- Do not add multiple IDX blocks.
- Do not replace the working myRealPage shortcode.
- Do not test filters on this page.

## Sprint priorities

### Phase 1: Stabilize and document

Status: complete.

Completed:

- Working IDX confirmed
- Listing detail confirmed
- Broken Elementor page moved aside
- Duplicate page moved aside
- Working page lock documented
- Competitor research documented
- CREB market report workflow documented

### Phase 2: Area page engine

Status: in progress.

Build first:

1. Beltline Condos
2. Downtown Calgary Condos
3. East Village Condos

Then continue:

4. Mission Condos
5. Eau Claire Condos
6. Kensington/Hillhurst Condos
7. Bridgeland Condos
8. Inglewood Condos
9. Lower Mount Royal Condos

Each area page needs:

- Hero
- Working base IDX shortcode
- Alert CTA
- Value report CTA
- Short SEO intro
- Nearby area links

### Phase 3: Market report authority page

Status: copy prepared.

Use CREB monthly data.

Update every month.

Build sections:

- Snapshot cards
- Buyer interpretation
- Seller interpretation
- Building-level guidance
- CTA to search condos
- CTA for value report

### Phase 4: Building pages

Status: not started.

Create priority building list from competitor research and Calgary search demand.

Each building page should include:

- Building name
- Area
- Live listings or search route
- Building facts
- Buyer notes
- Parking/pet/fee/reserve fund notes
- Building alerts CTA
- Value report CTA

### Phase 5: Buyer guide pages

Status: not started.

Priority pages:

- Calgary Condo Buyer Checklist
- Calgary Condo Fees Explained
- Concrete vs Wood-Frame Condos
- Pet-Friendly Condos in Calgary
- Titled Parking Condos in Calgary
- Calgary Condo Exposure Guide
- Best Calgary Condo Buildings Near CTrain

### Phase 6: Conversion polish

Status: not started.

Add/verify:

- Sticky mobile CTAs
- Clear call/text/contact options
- Fast first screen
- Area navigation
- Condo value report path
- Building alert path
- Contact/Talk to Louis path

## Current next action

Build the Beltline Condos page in WordPress when user is available.

Do not ask the user to touch WordPress until the page blocks are ready and the exact step-by-step instructions are prepared.

## Critical lesson from troubleshooting

The fastest path is not always adding more plugin code. The working solution was:

- clean WordPress page
- simple shortcode block
- direct myRealPage shortcode
- clean hero HTML
- full-width template

Use that pattern for the rest of the build.
