# Homes-style homepage hero source block

Purpose: replace the current generic top of homepage with a stronger Homes.com-style visual hero while preserving all tested links and lead capture paths.

Use this as a single Elementor HTML widget near the top of the homepage.

```html
<section class="ccs-hero" style="position:relative;overflow:hidden;border-radius:0 0 28px 28px;min-height:520px;background:linear-gradient(90deg,rgba(10,26,47,.86),rgba(10,26,47,.42)),url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1800&q=80') center/cover no-repeat;color:#fff;display:flex;align-items:center;">
  <div style="width:100%;max-width:1180px;margin:0 auto;padding:72px 24px;">
    <p style="margin:0 0 14px 0;color:#F0C75E;font-size:13px;font-weight:800;letter-spacing:.14em;text-transform:uppercase;">AI-Powered Calgary Condo Search</p>

    <h1 style="margin:0 0 18px 0;font-size:clamp(42px,6vw,78px);line-height:.98;font-weight:900;letter-spacing:-.05em;max-width:820px;">Find Your Calgary Condo</h1>

    <p style="margin:0 0 28px 0;font-size:clamp(17px,2vw,22px);line-height:1.45;max-width:780px;color:#e5edf7;">Search live Calgary condos, price drops, buildings, and value reports in one place.</p>

    <div style="background:rgba(255,255,255,.95);border-radius:999px;box-shadow:0 24px 70px rgba(0,0,0,.28);display:flex;align-items:center;gap:10px;max-width:920px;padding:10px;">
      <div style="flex:1;color:#64748b;font-size:16px;padding:0 18px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">Tell us what you want: Beltline, under $400K, pet-friendly, concrete building...</div>
      <a href="/calgary-condos-2/" style="display:inline-flex;align-items:center;justify-content:center;min-height:48px;padding:0 24px;border-radius:999px;background:#F0C75E;color:#0A1A2F;font-weight:800;text-decoration:none;white-space:nowrap;">Search Condos</a>
      <a href="#condo-assistant" style="display:inline-flex;align-items:center;justify-content:center;min-height:48px;padding:0 24px;border-radius:999px;background:#0A1A2F;color:#fff;font-weight:800;text-decoration:none;white-space:nowrap;">Ask AI</a>
    </div>

    <div style="display:flex;flex-wrap:wrap;gap:12px;margin-top:24px;">
      <a href="/calgary-condos-2/" style="padding:12px 16px;border-radius:999px;background:rgba(255,255,255,.16);color:#fff;text-decoration:none;font-weight:700;border:1px solid rgba(255,255,255,.2);">New Calgary Condos</a>
      <a href="/price-reduced-condos/" style="padding:12px 16px;border-radius:999px;background:rgba(255,255,255,.16);color:#fff;text-decoration:none;font-weight:700;border:1px solid rgba(255,255,255,.2);">Price Reduced</a>
      <a href="/condos-under-400k/" style="padding:12px 16px;border-radius:999px;background:rgba(255,255,255,.16);color:#fff;text-decoration:none;font-weight:700;border:1px solid rgba(255,255,255,.2);">Under $400K</a>
      <a href="/building-alert-request/" style="padding:12px 16px;border-radius:999px;background:rgba(255,255,255,.16);color:#fff;text-decoration:none;font-weight:700;border:1px solid rgba(255,255,255,.2);">Building Alerts</a>
      <a href="/condo-value-report/" style="padding:12px 16px;border-radius:999px;background:rgba(255,255,255,.16);color:#fff;text-decoration:none;font-weight:700;border:1px solid rgba(255,255,255,.2);">Condo Value Report</a>
    </div>
  </div>
</section>
```

Notes:
- Replace the image URL with a Calgary-specific skyline/condo image when available.
- Keep these URLs unchanged because they are tested and working:
  - `/calgary-condos-2/`
  - `/price-reduced-condos/`
  - `/condos-under-400k/`
  - `/building-alert-request/`
  - `/condo-value-report/`
  - `#condo-assistant`
- After installing this hero, do not remove the working card section until the hero is verified.
