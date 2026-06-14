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
11. Building Alert Request page exists and displays Form ID 9.
12. Building Alert Request form test was submitted and email alert arrived.
13. Budget Range was changed from a text field to a dropdown.
14. Bedrooms Needed was changed from a text field to a dropdown.
15. When are you looking to buy? was changed from a text field to a dropdown.
16. Must-Haves was in progress: user was changing it from Text Area to Checkbox options.

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

This form currently has fields:

- First Name
- Last Name
- Email
- Phone Number
- Building or Area You Want Alerts For
- Budget Range — dropdown
- Bedrooms Needed — dropdown
- When are you looking to buy? — dropdown
- Must-Haves — being changed to checkboxes

The user wants fewer typing fields and more dropdown/checkbox fields because it is faster and cleaner. Long-term direction is AI/voice-style intake where visitors can say/type what they want naturally.

## Dropdown/checkbox choices

### Budget Range dropdown

```text
Under $300,000
$300,000–$400,000
$400,000–$500,000
$500,000–$700,000
$700,000–$1,000,000
$1,000,000+
Not sure yet
```

### Bedrooms Needed dropdown

```text
Studio
1 Bedroom
1 Bedroom + Den
2 Bedrooms
2 Bedrooms + Den
3+ Bedrooms
Not sure yet
```

### Timeline dropdown

```text
ASAP
1–3 months
3–6 months
6–12 months
Just researching
```

### Must-Haves checkbox options

```text
Parking
Pet-friendly
Concrete building
Balcony
Mountain/city views
Low condo fees
Gym/amenities
Close to CTrain
Walkable area
Investment/rental friendly
```

## Email notifications

### Ask the Calgary Condo Assistant

Notification enabled and tested.

Subject:

```text
New Calgary Condo Assistant Lead
```

### Building Alerts

Notification enabled and tested.

Subject:

```text
New Building Alerts Lead
```

## Current user workflow when paused

The user is inside **Fluent Forms → Forms → Building Alerts → Edit**.

The next task is to finish **Must-Haves** as checkboxes:

1. Delete the current Must-Haves field if it is still a Text Area.
2. Add **Checkbox**.
3. Rename to **Must-Haves**.
4. Use Bulk Edit / Predefined Data Sets.
5. Paste the Must-Haves checkbox options listed above.
6. Apply options.
7. Click **Save Form**.
8. Retest `https://louiss106.sg-host.com/building-alert-request/`.
9. Verify email still arrives.

## Current live form page

Building Alert Request page:

```text
https://louiss106.sg-host.com/building-alert-request/
```

This was created because the `/building-alerts/` page is controlled by a template/design that did not show normal block content reliably. Elementor also failed on that page with a content-area/template error. Keep using `/building-alert-request/` for the actual form unless/until the button links are updated.

## Next tasks that do not need user decisions

1. Document final form field setup after Must-Haves checkbox is finished.
2. Prepare link-change instructions so the `Set Up Building Alerts` button points to:
   - `https://louiss106.sg-host.com/building-alert-request/`
3. Prepare the Condo Value Report form plan.
4. Prepare a clean seller lead form with dropdowns/checklists.
5. Prepare page-copy improvements for the Building Alert Request page.

## Do not do

- Do not reactivate the custom plugin.
- Do not edit myRealPage shortcode unless the user asks and a backup is preserved.
- Do not use Elementor for `/building-alerts/`; it hit a content-area/template issue.
- Do not delete pages right now.
- Do not chase the slug redirect until the lead forms are fully tested.
- Do not put any form shortcode inside the IDX shortcode block.
- Do not create another Building Alerts form. Use Form ID 9 only.
- Do not give vague directions. Give one small exact step at a time.
