# Realtor.com-Inspired UX and AI Chat Plan

## Source

User provided screenshots of realtor.com desktop pages on June 13, 2026.

Screens showed:

- Full-width hero search with large background image
- Search intent tabs such as Buy, Rent, Sell, Pre-approval, Just sold, Home value
- Large search bar immediately above the fold
- Search shortcut cards such as New Listings, Price Reduced, Recently Sold, New Construction, Land, and distance-based searches
- Agent comparison section
- Buyer help tools such as affordability calculator, mortgage calculator, and down payment help
- Local info block
- Listing search grid with filters and saved search
- Listing detail pages with large photos, price, property facts, map, contact form, and email agent CTA
- Content cards and article modules
- Mortgage/pre-approval CTA blocks

## Key lessons for our site

Realtor.com wins because it feels like a tool, not a brochure.

Our Calgary condo site should feel like a focused Calgary condo decision engine.

## What to copy conceptually, not literally

### 1. Search-first layout

The first visit should immediately give the user a search action.

For our site:

- Search Calgary Condos
- Search by area
- Search by building
- Get condo alerts
- Get condo value

### 2. Intent tabs

Realtor.com uses tabs like Buy, Rent, Sell, Pre-approval, Just sold, Home value.

Our version should be Calgary-condo specific:

- Buy
- Sell
- Building Alerts
- Condo Value
- Market Report

### 3. Search shortcut cards

Realtor.com uses shortcut cards below search.

Our version should use:

- New Calgary Condos
- Price Reduced Condos
- Beltline Condos
- Downtown Condos
- East Village Condos
- Newer Condos
- Pet-Friendly Condos
- Titled Parking Condos
- Concrete Buildings
- Condo Value Report

### 4. Saved search / alert CTA

Realtor.com pushes save search.

Our version should push:

- Get Calgary Condo Alerts
- Get Beltline Condo Alerts
- Get Building Alerts

### 5. Listing detail contact behavior

Realtor.com keeps a contact form beside listing details.

Our myRealPage listing details should be supported by site-level CTAs:

- Ask Louis About This Condo
- Request Building Info
- Book a Showing
- Get Similar Condos Sent to Me

### 6. Buyer tools

Realtor.com has calculators and down payment help.

Our version should include Canadian/Calgary-relevant tools:

- Condo affordability quick guide
- Condo fee red flag checklist
- CMHC/minimum down payment explainer
- Monthly payment estimate disclaimer
- Condo document checklist

### 7. Local info

Realtor.com has local information blocks.

Our version should include area guidance:

- Walkability
- CTrain access
- River/pathway access
- Restaurants/coffee
- Parking expectations
- Pet-friendly considerations
- Building age/fee considerations

## AI chat recommendation

Yes, add AI chat, but it must be controlled.

The AI chat should not pretend to be Louis and should not give legal, mortgage, tax, or guaranteed market advice.

It should act as a condo search assistant that captures leads and routes serious questions to Louis.

## AI chat jobs

The chat should help with:

1. Search intent

- What area are you looking in?
- What budget range?
- Do you need parking?
- Do you have pets?
- Are you buying now or researching?

2. Condo alerts

- Set up alerts by area, budget, bedrooms, parking, pet rules, building type.

3. Building questions

- Ask about condo fees, parking, pets, concrete vs wood-frame, exposure, amenities, reserve fund, documents.

4. Seller leads

- Ask if user owns a condo and wants a value report.

5. Market report questions

- Explain the latest CREB market report in plain English and link to the Market Report page.

6. Handoff

- Collect name, email, phone, timeline, and question.
- Push user to book a call or request a response from Louis.

## AI chat sample opening prompts

- Looking for a Calgary condo? Tell me your budget, area, bedrooms, and parking needs.
- Want condo alerts? I can help set up a search by area, building, price, and lifestyle.
- Own a Calgary condo? I can help start a condo value report request.
- Have a building in mind? Ask about fees, pets, parking, exposure, and resale considerations.

## Required AI chat guardrails

- Do not provide legal advice.
- Do not provide mortgage approval advice.
- Do not guarantee price direction.
- Do not claim live MLS facts unless connected to the site IDX/search results.
- Always offer to connect the user with Louis for specific advice.
- Capture consent before sending SMS/email follow-up.

## Best implementation direction

Use a WordPress-compatible AI chat tool that supports:

- Custom knowledge base
- Lead capture
- Email notifications
- CRM or Zapier webhook
- Chat transcript storage
- Custom disclaimers
- Ability to train on site pages and FAQs

Possible implementation route:

1. Launch with a simple controlled chat widget.
2. Train it on site FAQs, CREB report page, area pages, buyer/seller guides.
3. Connect leads to email first.
4. Later connect to CRM/SMS.

## First-visit homepage layout inspired by Realtor.com

### Section 1: Hero search

Headline:

```text
Find the Right Calgary Condo With a Fighter In Your Corner
```

Search/intent tabs:

- Buy
- Sell
- Building Alerts
- Condo Value
- Market Report

CTA buttons:

- Search Calgary Condos
- Get Condo Alerts

### Section 2: Search cards

- New Calgary Condos
- Price Reduced Condos
- Beltline Condos
- Downtown Condos
- East Village Condos
- Pet-Friendly Condos
- Titled Parking Condos
- Concrete Buildings

### Section 3: Buyer tools

- Condo Buyer Checklist
- Condo Fee Red Flags
- Monthly Cost Guide

### Section 4: Market authority

- CREB Calgary Condo Market Report

### Section 5: Seller CTA

- Get My Condo Value Report

### Section 6: AI chat CTA

- Ask the Calgary Condo Assistant

## Do-not-copy rule

Do not copy realtor.com branding, wording, layout exactly, images, icons, or proprietary UI. Use the concept: search-first, utility-first, helpful cards, saved search, and lead capture.

## Next build task

Create a revised homepage / main condo hub section plan using this search-first structure while protecting the working Calgary Condos IDX page.
