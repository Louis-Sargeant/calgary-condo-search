# AI Real Estate Reference Execution Spec

## Source

User provided Google AI reference screenshots on June 13, 2026 showing AI real estate examples:

- Zillow natural language search
- HouseSigma AI-generated property value estimates and sold data
- Realtor.com AI Property Finder
- Wahi AI-generated property summaries
- FindHomeGo AI-powered smart home buying assistant

## User intent

The user is providing references so there is no guessing. The instruction is execution: build the site toward a Calgary condo search platform with AI-assisted lead capture.

## What this means for our site

We are not building a generic chatbot.

We are building a Calgary Condo Assistant that supports the lead generation website.

## AI features to pursue

### Phase 1: Lead capture assistant

The first AI chat version should:

- ask what type of visitor they are: buyer, seller, investor, or researcher
- collect area preference
- collect budget
- collect bedrooms
- collect parking needs
- collect pet needs
- collect timeline
- collect contact info
- route serious leads to Louis

### Phase 2: Natural language condo search

Users should be able to ask:

- Show me Beltline condos under $350k with parking
- Find pet-friendly condos near downtown
- I want a concrete building with titled parking
- Show me condos near the CTrain
- What buildings should I avoid if condo fees are high?

Important: this requires integration with IDX/search data. Until connected, the assistant should route them to matching search pages or alert forms instead of pretending it has full live listing access.

### Phase 3: Property summary helper

For listings/buildings, the assistant should summarize:

- property type
- area
- price range
- building considerations
- parking/pet/fee questions to ask
- possible buyer red flags

Important: do not invent details. Only summarize details that are on the page or provided by the user.

### Phase 4: Market explanation helper

The assistant should explain CREB report updates in plain English:

- what buyers should know
- what sellers should know
- what inventory means
- what benchmark price means
- what months of supply means

### Phase 5: Seller value assistant

The assistant should help start a condo value report request:

- building name/address
- unit type
- beds/baths
- parking
- approximate condition
- timeline
- contact info

## AI assistant personality

- helpful
- direct
- Calgary condo-specific
- not robotic
- not overpromising
- not pretending to be Louis
- routes serious advice to Louis

## Guardrails

The AI must not:

- guarantee price direction
- provide legal advice
- provide mortgage approval advice
- claim live MLS access unless integrated
- make unsupported claims about a building
- pretend to be Louis
- collect sensitive financial data beyond basic search qualification

The AI should say:

```text
I can help narrow the search, but Louis should review the details before you make a decision.
```

## Homepage AI CTA

Suggested CTA:

```text
Ask the Calgary Condo Assistant
```

Suggested prompt text:

```text
Tell me your budget, preferred area, parking needs, pet needs, and timeline. I can help point you toward the right Calgary condo search path.
```

## Chat opening options

1. I am buying a Calgary condo
2. I want condo alerts
3. I want a condo value report
4. I have a building question
5. I want to understand the market report

## Lead routing

Every AI chat path should end with one of:

- Search Calgary Condos
- Get Condo Alerts
- Get My Condo Value Report
- Talk to Louis

## Build priority

1. Launch controlled AI chat with lead capture.
2. Train it on site pages, CREB market page, area pages, and condo guides.
3. Connect leads to email first.
4. Later connect to CRM and SMS.
5. Only later connect to listing/search data if technically possible and compliant.

## Execution note

Do not delay the visual build waiting for full AI integration. Launch the visual AI CTA first, then connect the chat tool in a controlled phase.
