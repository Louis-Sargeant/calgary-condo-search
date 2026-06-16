# Checkpoint — 2026-06-16 — Calgary Condo Search homepage

## Current confirmed state

The homepage is now functional and visually improved with a Homes.com-style hero.

Confirmed working by user:

- Homepage loads correctly.
- Large visual AI-powered Calgary condo hero is live.
- Hero buttons/links tested:
  - Search Condos → `/calgary-condos-2/`
  - Ask AI → jumps to `#condo-assistant`
  - New Calgary Condos → working
  - Price Reduced → working
  - Condos Under $400K → saved search fixed and working
  - Building Alerts → working
  - Condo Value Report → working
- Ask AI target section was added:
  - Heading: `Ask the Calgary Condo Assistant.`
  - Form: Fluent Form `[fluentform id="8"]`
  - User confirmed Ask AI jumps to the form.
- Condo Value Report form was tested by user and email came through.
- Building Alerts form was previously built and tested successfully.
- Condos Under $400K saved search was corrected:
  - City/Town = Calgary
  - Property Type = Residential
  - Condo Type = Conventional Condo
  - Asking Price <= $400,000
  - Preview showed valid under-$400K listings.
- Hero quick-link pill was restored to:
  - Text: `Condo Value Report`
  - URL: `/condo-value-report/`
- Coming Soon remains ON. Do not turn it off until final QA.

## User feedback / required design improvement

User likes the new Homes.com-style feel and said it looks and feels different in the right direction.

User does not like the current hero photo because it is too dark. Calgary should feel bright, sunny, warm, and happy.

Next visual task:

- Replace hero background image with a brighter Calgary-appropriate image.
- Prefer bright Calgary skyline, modern condo/lifestyle, Bow River/urban sunshine, or warm bright building exterior.
- Avoid dark moody luxury-home image.
- Keep the hero layout and links intact.

## Market Report / Market Update correction

User clarified:

- Do not replace the hero `Condo Value Report` pill with Market Update.
- The hero should keep `Condo Value Report` as a seller lead path.
- The top navigation item currently called `Market Report` should be changed to `Market Update`.
- That top navigation item should link to the official CREB monthly board update source:
  - `https://www.creb.com/Housing_Statistics/`

Important:

- WordPress Appearance → Menus showed no existing menu; the top header is not controlled by standard WP Menus.
- Do not create a new menu there without verifying theme/header control.
- A script was attempted in the hero HTML but did not change the header; user was instructed to remove it and restore clean hero HTML.
- Next step should locate the actual header/menu source, likely Elementor header/template, theme header settings, or a page/header component.

## Current safe next steps

1. Verify the hero HTML no longer contains the temporary script.
2. Confirm hero pill remains `Condo Value Report` → `/condo-value-report/`.
3. Locate where the top navigation is controlled.
4. Change top nav:
   - `Market Report` → `Market Update`
   - URL → `https://www.creb.com/Housing_Statistics/`
5. Replace hero photo with bright Calgary-appropriate visual.
6. QA desktop and mobile.
7. Keep Coming Soon ON until final launch approval.

## User workflow rules reinforced today

- Use source-first fixes where possible.
- Do not guess through Elementor widgets.
- Give exact visible labels and exact code.
- One step at a time.
- Never say vague instructions like “click the big/purple button” without naming exactly which icon/label.
- If a change affects a working section, explain exactly what is being changed and what is being preserved.
