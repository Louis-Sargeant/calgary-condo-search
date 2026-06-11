# Trust Strip Shortcode

The `[ccl_trust_strip]` shortcode adds a credibility section for Calgary Condo Search pages.

## Purpose

Use this near conversion points to remind visitors why the page is built around a safer search process: live IDX search, building-first guidance, buyer alerts, and cleaner decision-making.

## Default shortcode

```text
[ccl_trust_strip]
```

## Optional attributes

```text
[ccl_trust_strip eyebrow="Why Buyers Use This Calgary Condo Search" title="A cleaner way to search, compare, and choose the right condo path"]
```

## Recommended placement

Use it before the main alert form or after the action-router section.

```text
[ccl_idx_shell]
    Place the existing approved IDX shortcode here.
[/ccl_idx_shell]

[ccl_action_router]
[ccl_building_scorecard]
[ccl_trust_strip]
[ccl_lead_magnet]
[ccl_alert_form]
```

## Launch QA

1. Confirm the shortcode renders without affecting IDX.
2. Confirm the section supports trust without making unsupported claims.
3. Confirm it does not mention fake market statistics.
4. Confirm it appears before or near a lead form where it can support conversion.
