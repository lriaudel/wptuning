# WP-Tunning
Differents hooks and functions for improve WordPress and basic customize in a plugin.

## Security

- Head cleaning (Remove wp_generator, wlwmanifest_link, rsd_link, xmlrpc_enabled)
- Hide connections errors
- Filter body_class in order to hide User ID and User nicename
- No french punctuation and accents for filename
- Disallow "admin" as username

## Tunning

- Revision limited to 5 if is not defined
- Head cleanning (Remove `start_post_rel_link`, `feed_links_extra`, `feed_links`, `wp_shortlink_wp_head`, `index_rel_link`, `parent_post_rel_link`)
- Remove H1 from the WordPress editor
- Add medium format `medium_large` to media in admin
- Deactive Emoji
- Dashboard cleaning


