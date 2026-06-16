# AI Concierge Build Plan — Calgary Condo Search

## Current confirmed foundation

The site now has working lead paths and a stronger Homes-style homepage direction.

Confirmed working:

- Search Condos hero button
- Ask AI card/button jumps to the assistant form
- Fluent Form #8 appears under `Ask the Calgary Condo Assistant`
- Condo Value Report form sends email correctly
- Building Alerts form sends email correctly
- Price Reduced Calgary Condos saved search works
- Condos Under $400K saved search works
- New Calgary Condos path works
- Beltline Condos page works
- Downtown Condos page works

Coming Soon remains ON.

## Main AI goal

Turn the current `Ask AI` form area into a true Calgary condo concierge intake flow.

The user-facing promise should be:

> Tell us what kind of Calgary condo you want. We will help narrow down the best listings, buildings, alerts, and next steps.

## Phase 1 — Improve Ask AI intake form

Current form is functional, but should become a better lead intake tool.

Recommended fields:

1. First Name
2. Last Name
3. Email
4. Phone
5. What are you trying to do?
   - Buy a Calgary condo
   - Sell a Calgary condo
   - Get building alerts
   - Ask a market question
   - Not sure yet
6. Budget range
   - Under $300K
   - $300K–$400K
   - $400K–$500K
   - $500K–$700K
   - $700K–$1M
   - $1M+
   - Not sure yet
7. Preferred area/building
   - Free text
8. Bedrooms needed
   - Studio
   - 1 bedroom
   - 1 + den
   - 2 bedroom
   - 2 + den
   - 3+
   - Not sure yet
9. Must-haves
   - Parking
   - Pet-friendly
   - Concrete building
   - Balcony
   - Low condo fees
   - Gym/amenities
   - Close to CTrain
   - Walkable area
   - Investment/rental friendly
10. Timeline
   - ASAP
   - 1–3 months
   - 3–6 months
   - 6–12 months
   - Just researching
11. Ask your Calgary condo question
   - Long text field

## Phase 2 — Route leads by intent

Depending on the selected visitor intent, the assistant workflow should route to:

- Buyer condo search follow-up
- Condo Value Report seller follow-up
- Building Alerts follow-up
- Market Update source
- Book-a-call / direct contact follow-up

## Phase 3 — AI-powered response layer

The live website should not pretend to be fully AI until the underlying response flow is stable.

Recommended rollout:

1. Start with form intake and manual response.
2. Add internal AI-generated response drafts for Louis.
3. Later add a public-facing chat widget connected to a controlled Calgary condo knowledge base.

## Phase 4 — Calgary condo knowledge base

Knowledge base should include:

- Calgary condo buying process
- Calgary condo selling process
- Condo fees explanation
- Pet restrictions explanation
- Concrete vs wood-frame building guidance
- Area pages: Beltline, Downtown, University District, Mission, East Village/Rivers District, Bridgeland, Kensington, Eau Claire
- Market Update information linked to CREB
- Building Alerts process
- Condo Value Report process
- Contact info: 403-800-6996

## Do not do yet

- Do not install a random AI chatbot plugin without comparing control, cost, security, and workflow.
- Do not expose unreviewed AI answers as professional advice.
- Do not let AI answer legal, financing, or condo-document questions without clear disclaimers and routing to Louis.
- Do not remove the working Fluent Forms until an AI layer is fully tested.

## Next practical build steps

1. Improve Fluent Form #8 fields into the AI concierge intake flow.
2. Update the Ask AI section copy to make the assistant feel intentional.
3. Keep all form notifications going to Louis.
4. Prepare a future OpenAI/API integration plan, but do not launch public AI chat until the intake flow is stable.

## User workflow note

Louis wants source-first fixes, no guessing through Elementor, and exact step-by-step instructions only when manual clicks are required.
