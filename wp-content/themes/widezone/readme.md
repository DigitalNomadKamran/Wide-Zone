# Wide Zone Block Theme

A minimalist, visionary corporate WordPress block theme for Wide Zone Co.

## Installation
1. Copy the `widezone` theme folder into `wp-content/themes/` of your WordPress installation.
2. Ensure the `assets/css/util.css` file is present and accessible.
3. In the WordPress admin dashboard, navigate to **Appearance → Themes** and activate **Wide Zone**.
4. Assign the “Home” page as the static front page if desired.

## Features
- Fluid typography, responsive containers, and custom color palette
- Sticky header with mobile overlay navigation and utility links
- Custom post types: Industries, Projects, Insights, Jobs, Offices
- Taxonomies: Region (hierarchical) and Horizon (non-hierarchical) with seeded terms
- Custom metadata exposed via REST API
- Block patterns for hero, industries, values, projects, careers, and contact sections

## Starter Content via WP-CLI
Run these commands after activating the theme (adjust IDs/URLs as needed):

```bash
# Pages
wp post create --post_type=page --post_title="Home" --post_status=publish
wp post create --post_type=page --post_title="About" --post_status=publish
wp post create --post_type=page --post_title="Investment Horizons" --post_status=publish
wp post create --post_type=page --post_title="Industries" --post_status=publish
wp post create --post_type=page --post_title="Portfolio" --post_status=publish
wp post create --post_type=page --post_title="Insights" --post_status=publish
wp post create --post_type=page --post_title="Careers" --post_status=publish
wp post create --post_type=page --post_title="Contact" --post_status=publish

# Industries
wp post create --post_type=industry --post_title="Food & Beverages" --post_status=publish
wp post create --post_type=industry --post_title="Retail" --post_status=publish
wp post create --post_type=industry --post_title="Information Technology" --post_status=publish
wp post create --post_type=industry --post_title="Construction & Contracting" --post_status=publish
wp post create --post_type=industry --post_title="Fashion" --post_status=publish
wp post create --post_type=industry --post_title="International Trade" --post_status=publish

# Projects (replace IMAGE_URL with actual URLs)
wp post create --post_type=project --post_title="Transnational Food Hub" --post_status=publish --meta_input='{"project_metrics":{"roi":"18%","co2_saved":"2.1k tons"}}' --tax_input='{"region":["GCC"],"horizon":["Mid"]}'
wp post create --post_type=project --post_title="Digital Retail Fabric" --post_status=publish --meta_input='{"project_metrics":{"roi":"24%","market_share":"12%"}}' --tax_input='{"region":["MENA"],"horizon":["Long"]}'

# Insights
wp post create --post_type=insight --post_title="Ecosystem Capital in Emerging Markets" --post_status=publish
wp post create --post_type=insight --post_title="Circular Supply Networks" --post_status=publish

# Jobs
wp post create --post_type=job --post_title="Venture Architect" --post_status=publish --meta_input='{"job_department":"Strategy","job_location":"Riyadh, KSA","job_type":"Full-time","job_apply_url":"https://widezone.co/apply"}'
wp post create --post_type=job --post_title="Sustainability Analyst" --post_status=publish --meta_input='{"job_department":"Impact","job_location":"Dubai, UAE","job_type":"Full-time","job_apply_url":"https://widezone.co/apply"}'

# Offices
wp post create --post_type=office --post_title="HQ Riyadh" --post_status=publish --meta_input='{"office_city":"Riyadh","office_country":"Saudi Arabia","office_address":"Innovation Tower, Level 18","office_map_url":"https://maps.example.com/riyadh"}'
wp post create --post_type=office --post_title="Dubai Office" --post_status=publish --meta_input='{"office_city":"Dubai","office_country":"UAE","office_address":"Downtown Hub","office_map_url":"https://maps.example.com/dubai"}'
```

