# Current Build Status — 2026-06-13

## Project
Calgary Condo Search lead-generation site for Louis Sargeant.

Working site URL:

- `https://louiss106.sg-host.com`

Primary working page:

- `https://louiss106.sg-host.com/calgary-condos-2/`

Do not chase the `/calgary-condos/` slug until the lead capture buildout is stable. The `-2` URL is ugly but working.

## Confirmed working

The following items have been tested and confirmed:

1. Main Calgary condo page loads.
2. Visual hero section is live.
3. myRealPage condo-only IDX loads.
4. Condo listings display.
5. Listing detail pages open.
6. Ask the Calgary Condo Assistant form submits.
7. Ask form entries save in Fluent Forms.
8. Ask form email notification sends immediately to Louis.
9. Building Alerts form exists as Fluent Form ID 9.
10. Building Alerts form email notification exists and is enabled.

## Important shortcodes

### myRealPage condo-only IDX shortcode

Keep this shortcode as its own block. Do not paste form shortcodes inside it.

```text
[mrp account_id=67196 embed=true searchform_def=idx.browse context=recip init_attr=tmpl~v2,idx_v2_map_pos~51.07074749513339%7C-114.11790099999996,idx_v2_map_radius~2,ibf_property_type~DWELLING_TYPE%40APAR ][/mrp]
```

### Ask the Calgary Condo Assistant form

Fluent Form ID 8:

```text
[fluentform id="8"]
```

This form is confirmed working and sending email.

### Building Alerts form

Fluent Form ID 9:

```text
[fluentform id="9"]
```

This form has fields:

- First Name
- Last Name
- Email
- Phone Number
- Building or Area You Want Alerts For
- Budget Range
- Bedrooms Needed
- When are you looking to buy?
- Must-Haves

The Must-Haves field has been corrected to a Text Area.

## Email notifications

### Ask the Calgary Condo Assistant

Notification enabled and tested.

Subject:

```text
New Calgary Condo Assistant Lead
```

### Building Alerts

Notification enabled.

Subject:

```text
New Building Alerts Lead
```

Needs live-page test once the form is placed on the Building Alerts page.

## Current user workflow when paused

The user was on the live Building Alerts page:

```text
https://louiss106.sg-host.com/building-alerts/
```

The user needs to click **Edit Page** and place this shortcode under the hero section:

```text
[fluentform id="9"]
```

Then update the page and submit a test lead to confirm the email arrives.

## Next tasks that do not need user decisions

1. Document the final form locations once Building Alerts placement is confirmed.
2. Build a clear lead-capture map:
   - Buyer lead: Building Alerts
   - Buyer/help lead: Ask the Calgary Condo Assistant
   - Seller lead: Condo Value Report
3. Prepare the Condo Value Report form plan before building it.
4. Prepare page-copy improvements for the Building Alerts form section, including a short intro and trust language.

## Do not do

- Do not reactivate the custom plugin.
- Do not edit myRealPage shortcode unless the user asks and a backup is preserved.
- Do not use Elementor for this page unless explicitly required.
- Do not delete pages right now.
- Do not chase the slug redirect until the lead forms are fully tested.
- Do not put any form shortcode inside the IDX shortcode block.
