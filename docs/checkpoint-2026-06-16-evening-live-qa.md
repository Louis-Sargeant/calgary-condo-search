# Checkpoint — Evening Live QA

## Confirmed complete

- Top navigation menu created and assigned to Primary Navigation.
- Top nav now shows clean links:
  - Home
  - Calgary Condos
  - Building Alerts
  - Under $400K
  - Price Reduced
  - Market Update
- Market Update opens CREB Housing Statistics correctly:
  - https://www.creb.com/Housing_Statistics/
- Plugin update installed successfully.
- SG cache was purged.
- Ask AI / Calgary Condo Assistant form was upgraded and tested from the live homepage.
- Redundant field `What do you want help with?` was removed.
- Live-page form submission came through by email.

## Current Ask AI form fields

- First Name
- Last Name
- Email
- Phone Number
- What are you trying to do?
  - Buy a Calgary condo
  - Sell a Calgary condo
  - Get building alerts
  - Ask a market question
  - Not sure yet
- What is your budget range?
- Preferred Calgary area or building
- Bedrooms needed
- Must-haves
- Timeline

## Important issue discovered

The homepage hero search bar is not a real search experience yet.

User reported:

- Typing `southeast` routes to northwest.
- The `For Sale` control is static/decorative and does not open or do anything.

This is a credibility problem. Do not leave the fake search bar live as-is.

## Next recommended fix

Replace the fake search UI with reliable click paths until a real IDX-powered search/autocomplete is wired.

Preferred safe homepage search buttons:

- Search All Calgary Condos
- SE Calgary Condos
- NW Calgary Condos
- NE Calgary Condos
- SW Calgary Condos
- Under $400K
- Price Reduced
- Ask AI

Or wire the search bar properly to myRealPage IDX if exact query URLs are confirmed.

## Standing build rule

Louis explicitly said:

- Do not guess.
- Do not provide partial HTML snippets for major section replacements.
- If replacing a section, provide the entire replacement HTML block.
- Avoid broken code.
- Use exact commands and visible labels.
- Give grouped commands only when each command is precise.

## Current next session starting point

Start with fixing the homepage hero search bar.

Do not work on new AI plugin/chat until the homepage search issue is corrected.
