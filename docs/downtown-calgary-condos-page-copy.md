# Downtown Calgary Condos Page Copy and Structure

## Purpose

Create the Downtown Calgary Condos area page after the Beltline test page proves the pattern.

Target URL:

```text
/downtown-calgary-condos/
```

## Page title

```text
Downtown Calgary Condos for Sale
```

## Slug

```text
downtown-calgary-condos
```

## Safe starter structure

Use a Custom HTML block for the hero and a Shortcode block for the myRealPage IDX.

Do not edit with Elementor.

### Hero block

```html
<section style="background:#0A1A2F;color:white;padding:70px 32px;border-radius:22px;margin-bottom:28px;">
  <p style="text-transform:uppercase;letter-spacing:.12em;color:#F0C75E;font-weight:700;margin:0 0 12px;">Downtown Calgary Condo Search</p>
  <h1 style="font-size:clamp(40px,6vw,72px);line-height:.96;margin:0 0 22px;">Downtown Calgary Condos for Sale</h1>
  <p style="font-size:20px;line-height:1.5;max-width:840px;margin:0 0 28px;">
    Search Downtown Calgary condos, compare buildings, review walkability, and get guidance before you book a showing.
  </p>
  <div style="display:flex;gap:14px;flex-wrap:wrap;">
    <a href="#idx-search" style="background:#F0C75E;color:#0A1A2F;padding:14px 20px;border-radius:10px;font-weight:800;text-decoration:none;">Search Downtown Condos</a>
    <a href="#downtown-alerts" style="border:1px solid #F0C75E;color:white;padding:14px 20px;border-radius:10px;font-weight:800;text-decoration:none;">Get Downtown Condo Alerts</a>
  </div>
</section>

<div id="idx-search"></div>
```

### IDX shortcode block

Start with the proven working base shortcode:

```text
[mrp account_id=67196 searchform_def=idx.browse embed=true context=recip]
```

Do not apply a Downtown filter until it is tested separately.

## Lead section below IDX

```html
<section id="downtown-alerts" style="background:#F7F3E8;color:#0A1A2F;padding:44px 28px;border-radius:18px;margin-top:36px;">
  <p style="text-transform:uppercase;letter-spacing:.1em;color:#9B6B00;font-weight:800;margin:0 0 10px;">Downtown Condo Alerts</p>
  <h2 style="font-size:clamp(30px,4vw,48px);line-height:1.05;margin:0 0 16px;">Want Downtown Calgary condo matches sent to you?</h2>
  <p style="font-size:18px;line-height:1.55;max-width:780px;margin:0 0 22px;">
    Tell us your budget, preferred building style, parking needs, pet needs, and timeline. We will help you compare Downtown condo options before you waste time on the wrong buildings.
  </p>
  <a href="/building-alerts/" style="display:inline-block;background:#0A1A2F;color:white;padding:14px 20px;border-radius:10px;font-weight:800;text-decoration:none;">Set Up Downtown Alerts</a>
</section>
```

## SEO intro copy

Downtown Calgary condos appeal to buyers who want central access, walkability, transit, restaurants, office access, and a low-maintenance lifestyle close to the core. Buyers often compare Downtown condos by building age, concrete construction, parking, condo fees, amenities, pet rules, exposure, and proximity to the CTrain or Plus 15 network.

This page should help buyers search current Downtown Calgary condo listings while giving them a clear way to request building guidance and alerts.

## Internal links

Link back to:

```text
/calgary-condos/
```

Link sideways to:

```text
/beltline-condos/
/east-village-condos/
/eau-claire-condos/
/kensington-hillhurst-condos/
```

## CTA rule

Every Downtown Calgary Condos page version should include:

- Search Downtown Condos
- Get Downtown Condo Alerts
- Get My Condo Value Report
- Talk to Louis

## Do-not-break rule

Do not add multiple IDX blocks. Do not edit with Elementor. Do not filter until the myRealPage filter is tested separately.
