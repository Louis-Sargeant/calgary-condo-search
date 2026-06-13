# Mission Condos Page Copy and Structure

## Purpose

Create the Mission Condos area page after the Beltline test page proves the pattern.

Target URL:

```text
/mission-condos/
```

## Page title

```text
Mission Condos for Sale
```

## Slug

```text
mission-condos
```

## Safe starter structure

Use a Custom HTML block for the hero and a Shortcode block for the myRealPage IDX.

Do not edit with Elementor.

### Hero block

```html
<section style="background:#0A1A2F;color:white;padding:70px 32px;border-radius:22px;margin-bottom:28px;">
  <p style="text-transform:uppercase;letter-spacing:.12em;color:#F0C75E;font-weight:700;margin:0 0 12px;">Mission Condo Search</p>
  <h1 style="font-size:clamp(40px,6vw,72px);line-height:.96;margin:0 0 22px;">Mission Condos for Sale</h1>
  <p style="font-size:20px;line-height:1.5;max-width:840px;margin:0 0 28px;">
    Search Mission condos, compare walkable buildings near 4th Street and the river pathway, and get guidance before you book a showing.
  </p>
  <div style="display:flex;gap:14px;flex-wrap:wrap;">
    <a href="#idx-search" style="background:#F0C75E;color:#0A1A2F;padding:14px 20px;border-radius:10px;font-weight:800;text-decoration:none;">Search Mission Condos</a>
    <a href="#mission-alerts" style="border:1px solid #F0C75E;color:white;padding:14px 20px;border-radius:10px;font-weight:800;text-decoration:none;">Get Mission Condo Alerts</a>
  </div>
</section>

<div id="idx-search"></div>
```

### IDX shortcode block

Start with the proven working base shortcode:

```text
[mrp account_id=67196 searchform_def=idx.browse embed=true context=recip]
```

Do not apply a Mission filter until it is tested separately.

## Lead section below IDX

```html
<section id="mission-alerts" style="background:#F7F3E8;color:#0A1A2F;padding:44px 28px;border-radius:18px;margin-top:36px;">
  <p style="text-transform:uppercase;letter-spacing:.1em;color:#9B6B00;font-weight:800;margin:0 0 10px;">Mission Condo Alerts</p>
  <h2 style="font-size:clamp(30px,4vw,48px);line-height:1.05;margin:0 0 16px;">Want Mission condo matches sent to you?</h2>
  <p style="font-size:18px;line-height:1.55;max-width:780px;margin:0 0 22px;">
    Tell us your budget, parking needs, pet needs, preferred building style, and timeline. We will help you compare Mission condo options before you book showings.
  </p>
  <a href="/building-alerts/" style="display:inline-block;background:#0A1A2F;color:white;padding:14px 20px;border-radius:10px;font-weight:800;text-decoration:none;">Set Up Mission Alerts</a>
</section>
```

## SEO intro copy

Mission is one of Calgary's strongest lifestyle condo areas for buyers who want walkability, restaurants, river pathway access, nearby shops, and quick access to the downtown core. Buyers often compare Mission condos by building age, parking, condo fees, pet rules, balcony exposure, noise, and proximity to 4th Street or the Elbow River.

This page should help buyers search current Mission condo listings and request guidance on which buildings fit their lifestyle and resale goals.

## Internal links

Link back to:

```text
/calgary-condos/
```

Link sideways to:

```text
/beltline-condos/
/lower-mount-royal-condos/
/downtown-calgary-condos/
/eau-claire-condos/
```

## Do-not-break rule

Do not add multiple IDX blocks. Do not edit with Elementor. Do not filter until the myRealPage filter is tested separately.
