# Action Router Shortcode

The `[ccl_action_router]` shortcode adds a conversion section that routes visitors into the right Calgary condo search path.

## Purpose

Visitors often browse listings without knowing what to do next. This section gives them three clear paths:

- Browse active listings
- Watch a specific building
- Ask for guidance before chasing a weak building or listing

## Default shortcode

```text
[ccl_action_router]
```

## Optional attributes

```text
[ccl_action_router eyebrow="Choose Your Calgary Condo Search Path" title="What do you want to do next?" subtitle="Pick the path that matches where you are in the condo search. The right next step keeps you from wasting time on the wrong building or weak listing."]
```

## Recommended placement

Use this after the IDX shell or after an education block when the visitor needs a clear next action.

```text
[ccl_hero primary_url="#idx-search" secondary_url="#condo-alerts"]
[ccl_quick_search]

[ccl_idx_shell]
    Place the existing approved IDX shortcode here.
[/ccl_idx_shell]

[ccl_action_router]
[ccl_building_scorecard]
[ccl_lead_magnet]
[ccl_alert_form]
[ccl_sticky_cta]
```

## Conversion role

The action router prevents dead-end browsing. It gives visitors a simple decision point and sends them toward IDX search, building alerts, or guidance.

## Launch QA

1. Confirm each button jumps to the correct page section.
2. Confirm the section does not duplicate nearby CTA copy too heavily.
3. Confirm it stacks cleanly on mobile.
4. Confirm the IDX and alert form anchors are present on the page.
