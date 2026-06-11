# Calgary Condo Search Lead-Gen Content Roadmap

## Goal

Build Calgary Condo Search into a focused Calgary condo lead-generation website that captures buyer, seller, building-alert, and market-report leads while keeping the approved myRealPage IDX intact.

## Core conversion paths

1. Search Calgary condos
2. Get condo alerts
3. Watch a building
4. Request a condo value report
5. Ask about condo fees, bylaws, parking, pet rules, and resale fit
6. Book a showing after the buyer has enough building context

## Main page priority

### 1. Calgary Condo Search

Primary hub page.

Required structure:

```text
[ccl_hero primary_url="#idx-search" secondary_url="#condo-alerts"]
[ccl_quick_search]
[ccl_trust_strip]

<div id="idx-search">
    Existing approved myRealPage IDX shortcode stays here.
</div>

[ccl_value_cards]
[ccl_area_grid]
[ccl_price_grid]
[ccl_buyer_path]
[ccl_building_cta]
[ccl_alert_form]
[ccl_seller_cta]
[ccl_site_footer]
```

### 2. Calgary Condo Buildings

Purpose: capture building-specific search intent.

Primary CTA: Set Up Building Alerts

Secondary CTA: Ask About a Building

### 3. Building Alerts

Purpose: turn high-intent building watchers into leads.

Primary CTA: Get Building Alerts

Secondary CTA: Ask For Building Advice

### 4. Condo Value Report

Purpose: seller lead capture.

Primary CTA: Request Condo Value Report

Secondary CTA: Call Calgary Number

### 5. Calgary Condo Market Report

Purpose: buyer and seller education lead magnet.

Primary CTA: Get Monthly Condo Market Report

Secondary CTA: Ask About Your Building

## Area page priority

1. Beltline
2. Downtown Calgary
3. East Village
4. Mission
5. Eau Claire
6. Victoria Park
7. Bridgeland
8. Kensington / Hillhurst
9. Lower Mount Royal
10. Sunalta
11. Marda Loop
12. Inglewood

## Price page priority

1. Calgary condos under $300K
2. Calgary condos $300K to $500K
3. Calgary condos $500K to $750K
4. Calgary luxury condos
5. Calgary penthouse condos

## Building-intent page priority

1. Concrete condos in Calgary
2. Pet-friendly condos in Calgary
3. Calgary condos with titled parking
4. Calgary condos with views
5. Calgary condos with low condo fees
6. Newer Calgary condos
7. Downtown high-rise condos
8. Walkable Calgary condos

## Content rules

- Calgary only.
- Use the Calgary phone number only: +1 (403) 800-6996.
- Do not mention Vancouver phone numbers.
- Do not replace or scrape IDX data.
- Do not seed fake listings.
- Keep IDX content inside approved myRealPage shortcode/embed areas.
- Use clear CTAs on every page.
- Every area page should push condo alerts and building guidance.
- Every seller page should push condo value report.

## QA before launch

- Confirm plugin active.
- Confirm Calgary phone only.
- Confirm no unsupported shortcode text visible on live pages.
- Confirm IDX search loads.
- Confirm forced registration popup setting is acceptable.
- Confirm lead form submits.
- Confirm lead appears under Condo Leads.
- Confirm email notification sends to site admin.
- Confirm mobile layout.
- Purge SiteGround cache after every major page change.
