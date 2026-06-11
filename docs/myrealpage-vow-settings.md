# myRealPage VOW Settings Notes

## Current discovery

The myRealPage backend has a VOW Options screen that controls when visitors are prompted to create or log in to a VOW account.

The user also updated the myRealPage contact phone number so it should populate across listing/contact areas with the Calgary number.

## Calgary phone rule

Use Calgary only:

```text
+1 (403) 800-6996
```

Do not use the Vancouver phone number anywhere on this Calgary lead-generation site.

## Recommended launch setting

Use a soft but still serious lead-capture flow:

```text
Initially prompt visitors to signup: After 5 minutes
Repeat prompt: Three (3) times
Repeat prompt every: 5 minutes
After last prompt: Force to signup / login
Limit listing views before prompt to: 5 listings
```

## Why this setting

This avoids blocking the visitor immediately before they understand the site value, while still preserving lead capture once they show serious search intent.

The visitor gets enough time to search and build trust first, then the VOW system captures serious users who keep browsing.

## QA items

- Confirm the prompt does not block the first page load immediately.
- Confirm visitors can see enough value before being asked to sign up.
- Confirm the form captures name, email, and phone.
- Confirm the contact phone shown in myRealPage listings is the Calgary number.
- Confirm the Calgary Condo Leads plugin CTA forms still work separately from the VOW prompt.
- Confirm mobile behavior is not too aggressive.

## Launch note

If the prompt feels too aggressive during live testing, loosen the timing first rather than removing the VOW capture entirely. The goal is not to eliminate registration. The goal is to capture leads after value has been shown.
