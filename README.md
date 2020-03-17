# WP Menu Custom Fields #

[![Project Status: WIP – Initial development is in progress, but there has not yet been a stable, usable release suitable for the public.](https://www.repostatus.org/badges/latest/wip.svg)](https://www.repostatus.org/#wip)


**Tags:** Navigation Menu, Navigation Menu Custom Fields

**Tested with:** 5.4-RC2-47447

**Required WordPress version:** 5.4-RC2-47447


# What plugin does #

- It uses the newly added action hook of WordPress 5.4 `wp_nav_menu_item_custom_fields` to add custom fields on Menu Item edit interface.
- It then shows data stored in these custom fields on menu items on frontend.
- Plugin provides below custom fields:
  - Custom text
  - Media (image/video) with link and caption
  - Shortcode with caption
  - Custom HTML with [tinyMCE](https://www.tiny.cloud/) editor


# Branches #

    master

# Issue reporting #

 https://github.com/rtCamp/labs/issues/32

 
# Links #

[New hooks let you add custom fields to menu items](https://make.wordpress.org/core/2020/02/25/wordpress-5-4-introduces-new-hooks-to-add-custom-fields-to-menu-items/)

[WordPress Core ticket for `wp_nav_menu_item_custom_fields`](https://core.trac.wordpress.org/ticket/47056)

[Reference Menu](https://www.videojet.com/us/homepage.html)
