# East Village Condos Page Copy and Structure

## Purpose

Create the East Village Condos area page after the Beltline test page proves the pattern.

Target URL:

```text
/east-village-condos/
```

## Page title

```text
East Village Condos for Sale
```

## Slug

```text
east-village-condos
```

## Safe starter structure

Use a Custom HTML block for the hero and a Shortcode block for the myRealPage IDX.

Do not edit with Elementor.

### Hero block

```html
<section style="background:#0A1A2F;color:white;padding:70px 32px;border-radius:22px;margin-bottom:28px;">
  <p style="text-transform:uppercase;letter-spacing:.12em;color:#F0C75E;font-weight:700;margin:0 0 12px;">East Village Condo Search</p>
  <h1 style="font-size:clamp(40px,6vw,72px);line-height:.96;margin:0 0 22px;">East Village Condos for Sale</h1>
  <p style="font-size:20px;line-height:1.5;max-width:840px;margin:0 0 28px;">
    Search East Village condos, compare newer buildings, review river-area options, and get guidance before you book a showing.
  </p>
  <div style="display:flex;gap:14px;flex-wrap:wrap;">
    <a href="#idx-search" style="background:#F0C75E;color:#0A1A2F;padding:14px 20px;border-radius:10px;font-weight:800;text-decoration:none;">Search East Village Condos</a>
    <a href="#east-village-alerts" style="border:1px solid #F0C75E;color:white;padding:14px 20px;border-radius:10px;font-weight:800;text-decoration:none;">Get East Village Alerts</a>
  </div>
</section>

<div id="idx-search"></div>
```

### IDX shortcode block

Start with the proven working base shortcode:

```text
[mrp account_id=67196 searchform_def=idx.browse embed=true context=recip]
```

Do not apply an East Village filter until it is tested separately.

## Lead section below IDX

```html
<section id="east-village-alerts" style="background:#F7F3E8;color:#0A1A2F;padding:44px 28px;border-radius:18px;margin-top:36px;">
  <p style="text-transform:uppercase;letter-spacing:.1em;color:#9B6B00;font-weight:800;margin:0 0 10px;">East Village Condo Alerts</p>
  <h2 style="font-size:clamp(30px,4vw,48px);line-height:1.05;margin:0 0 16px;">Want East Village condo matches sent to you?</h2>
  <p style="font-size:18px;line-height:1.55;max-width:780px;margin:0 0 22px;">
    Tell us your budget, preferred building, view preference, parking needs, pet needs, and timeline. We will help you compare East Village condo options before you book showings.
  </p>
  <a href="/building-alerts/" style="display:inline-block;background:#0A1A2F;color:white;padding:14px 20px;border-radius:10px;font-weight:800;text-decoration:none;">Set Up East Village Alerts</a>
</section>
```

## SEO intro copy

East Village is one of Calgary's best-known inner-city condo areas for buyers who want river access, newer high-rise options, downtown proximity, restaurants, pathways, transit, and an urban lifestyle. Buyers often compare East Village condos by building age, view, floor height, parking, condo fees, amenities, and resale strength.

This page should help buyers search current East Village condo listings and request guidance on which buildings match their goals.

## Internal links

Link back to:

```text
/calgary-condos/
```

Link sideways to:

```text
/downtown-calgary-condos/
/beltline-condos/
/bridgeland-condos/
/eau-claire-condos/
```

## CTA rule

Every East Village Condos page version should include:

- Search East Village Condos
- Get East Village Condo Alerts
- Get My Condo Value Report
- Talk to Louis

## Do-not-break rule

Do not add multiple IDX blocks. Do not edit with Elementor. Do not filter until the myRealPage filter is tested separately.
