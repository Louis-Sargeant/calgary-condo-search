# Beltline Condos Page Copy and Structure

## Purpose

Create the first dedicated Calgary condo area page without touching the working Calgary Condos hub.

Target URL:

```text
/beltline-condos/
```

Use this as the test pattern before duplicating to other area pages.

## Page title

```text
Beltline Condos for Sale
```

## Slug

```text
beltline-condos
```

## Template

Use a full-width template if available. Do not edit this page with Elementor unless normal WordPress blocks fail.

## Safe starter content

Use a Custom HTML block for the hero, then a Shortcode block for the myRealPage IDX.

### Hero block

```html
<section style="background:#0A1A2F;color:white;padding:70px 32px;border-radius:22px;margin-bottom:28px;">
  <p style="text-transform:uppercase;letter-spacing:.12em;color:#F0C75E;font-weight:700;margin:0 0 12px;">Beltline Condo Search</p>
  <h1 style="font-size:clamp(40px,6vw,72px);line-height:.96;margin:0 0 22px;">Beltline Condos for Sale</h1>
  <p style="font-size:20px;line-height:1.5;max-width:820px;margin:0 0 28px;">
    Search Beltline condos, compare buildings, narrow down walkable options, and get guidance before you book a showing.
  </p>
  <div style="display:flex;gap:14px;flex-wrap:wrap;">
    <a href="#idx-search" style="background:#F0C75E;color:#0A1A2F;padding:14px 20px;border-radius:10px;font-weight:800;text-decoration:none;">Search Beltline Condos</a>
    <a href="#beltline-alerts" style="border:1px solid #F0C75E;color:white;padding:14px 20px;border-radius:10px;font-weight:800;text-decoration:none;">Get Beltline Condo Alerts</a>
  </div>
</section>

<div id="idx-search"></div>
```

### IDX shortcode block

Start with the proven working base shortcode:

```text
[mrp account_id=67196 searchform_def=idx.browse embed=true context=recip]
```

Do not add the Beltline filter until a separate filter test confirms the exact myRealPage parameter.

## Lead section below IDX

Add below the IDX only after the IDX works.

```html
<section id="beltline-alerts" style="background:#F7F3E8;color:#0A1A2F;padding:44px 28px;border-radius:18px;margin-top:36px;">
  <p style="text-transform:uppercase;letter-spacing:.1em;color:#9B6B00;font-weight:800;margin:0 0 10px;">Beltline Condo Alerts</p>
  <h2 style="font-size:clamp(30px,4vw,48px);line-height:1.05;margin:0 0 16px;">Want Beltline condo matches sent to you?</h2>
  <p style="font-size:18px;line-height:1.55;max-width:760px;margin:0 0 22px;">
    Tell us your budget, parking needs, pet needs, timeline, and building preferences. We will help you narrow the search before you waste time on the wrong condos.
  </p>
  <a href="/building-alerts/" style="display:inline-block;background:#0A1A2F;color:white;padding:14px 20px;border-radius:10px;font-weight:800;text-decoration:none;">Set Up Beltline Alerts</a>
</section>
```

## SEO intro copy

Beltline is one of Calgary's most active inner-city condo areas, with walkable access to restaurants, coffee shops, downtown offices, transit, parks, and nightlife. Buyers often compare Beltline condos by building age, parking, condo fees, pet rules, exposure, walkability, and proximity to 17 Avenue or the downtown core.

This page should help buyers search current Beltline condo listings and quickly request guidance on which buildings fit their goals.

## Internal links

Link back to:

```text
/calgary-condos/
```

Link sideways to:

```text
/downtown-calgary-condos/
/mission-condos/
/east-village-condos/
/lower-mount-royal-condos/
```

## Do-not-break rule

Do not add multiple IDX shortcodes to this page.

Do not add filtered IDX parameters until the filter is tested on a draft/test page first.
