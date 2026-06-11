# Plugin Upload Troubleshooting

Use this if WordPress refuses to upload or replace a Calgary Condo Leads ZIP.

## Current package target

The repo plugin version is now `1.0.9`.

The plugin upload file must be:

```text
calgary-condo-leads.zip
```

The ZIP must contain this exact file path:

```text
calgary-condo-leads/calgary-condo-leads.php
```

## Most common causes

1. The wrong ZIP was uploaded.
2. The GitHub artifact ZIP was uploaded instead of the plugin ZIP inside it.
3. WordPress kept the old plugin folder and did not replace it.
4. The browser cached the old plugin version.
5. SiteGround or WordPress cache kept old CSS/PHP output.

## Correct upload flow

1. Download the GitHub Actions artifact named `calgary-condo-leads-wordpress-plugin`.
2. Extract it if it downloads as an outer ZIP.
3. Upload only `calgary-condo-leads.zip` to WordPress.
4. If WordPress asks, choose **Replace current with uploaded**.
5. Confirm the plugin screen shows Calgary Condo Leads version `1.0.9`.
6. Purge SiteGround cache.
7. Check the page in a private browser window.

## If WordPress still refuses the upload

1. Deactivate Calgary Condo Leads.
2. Delete Calgary Condo Leads from WordPress plugins.
3. Upload the fresh `calgary-condo-leads.zip` again.
4. Activate Calgary Condo Leads.
5. Confirm the myRealPage IDX plugin is still active and unchanged.

## Safety rules

- Do not delete or replace the myRealPage IDX plugin.
- Do not edit MLS/listing data.
- Do not launch until IDX and forms are checked.
