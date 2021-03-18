=== WP Menu Custom Fields ===
Contributors: rtcamp, sid177, kiranpotphode, devikvekariya
Tags: Navigation Menu, Navigation Menu Custom Fields
Requires at least: 5.4
Tested up to: 5.7
Requires PHP: 7.0
Stable tag: 1.0.2
License: GPLv2 or later (of course!)
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin adds custom fields on menu item's edit interface of wp-admin.

== Description ==

This plugin adds custom fields on menu item's edit interface of wp-admin.
Below is the list of custom fields this plugin adds.

- Custom text
- Image selection with link and caption
- Shortcode with caption
- Custom HTML with TinyMCE editor

**Note:** This plugin works with default themes. In order to use it with custom themes, please add the necessary styling.

== Installation ==

1.  Extract the zip file.
2.  Upload it to the `/wp-content/plugins/` directory in your WordPress installation.
3.  Activate the WP Menu Custom Fields from your Plugins page.

== Usage ==

1. After installing and activating this plugin, goto Appearance -> Menus of your WordPress admin. Create a menu if you haven't already and add menu items according to your need.
2. When you expand any menu item, you'll see the custom fields added here (see screenshots below). You can see **Custom Field** and **Select Feature** options.
3. Along with Custom Text field, you can choose to use either Image, Shortcode or Custom HTML feature for a particular menu item.
4. You can click on the option you want to use and the input fields of that option will be visible.

= Using Custom Text field =

- You can enter any text here and it'll be displayed with this menu item.
- This field can be used by all menu items along with any other feature.

= Using Image =

- By clicking on **Select Image** button, WordPress' media gallery window will be opened up. You can choose 1 image from already uploaded images or you can upload a new one and select that.
- The selected image will be shown below **Select Image** button after you select and close the media gallery window.
- To remove already selected image, click on **Select Image** button and deselect the already selected image. You can change the selected image by selecting any other image.
- You can enter a URL in **Image Link** text field. On front-end, clicking on the image will lead to this URL.
- You can enter a caption text in **Image Caption** field and it'll be displayed below the image on the front-end.

= Using Shortcode =

- You can add a shortcode in **Shortcode** field. We've added some stylings to handle WordPress' defaut `[video]` shortcode.
- You can enter a caption text in **Shortcode Caption** field and it'll be displayed below the shortcode on the front-end.

= Using Custom HTML =

- TinyMCE editor is used to add custom HTML here.
- From the **Visual** tab, you can enter text and format it using tools given in toolbar.
- You can switch to **Text** tab to see/change HTML code of the text you entered.

== Screenshots ==

1. Custom fields added under Appearance -> Menus
2. Custom HTML
3. Image with custom text
4. Video via shortcode

== Hooks ==

= wp_menu_custom_fields_image_html Filter =

- Allows to change HTML generated for image feature.
- There are 3 parameters. `$html` (Generated HTML), `$data` (Custom fields data), `$item_id` (Menu item ID).
- Example:
    <code>
    [selected-feature] => image
    [image] => Array
        (
            [media-id] => 11
            [media-type] => image
            [media-link] => https://google.com/
            [media-caption] => This is image caption
            [media-url] => http://example.com/wp-content/uploads/2020/03/92d43b978cbcdc7b33e3596d131d5256.jpg
        )
    </code>

= wp_menu_custom_fields_shortcode_html Filter =

- Allows to change HTML generated for shortcode feature.
- Parameters are same as `wp_menu_custom_fields_image_html`.
- Example:
    <pre><code>
    [selected-feature] => shortcode
    [shortcode] => Array
        (
            [shortcode] => [video src="https://file-examples.com/wp-content/uploads/2017/04/file_example_MP4_480_1_5MG.mp4"]
            [shortcode-caption] => This is a shortcode caption
        )
    </code></pre>

= wp_menu_custom_fields_custom_markup_html Filter =

- Allows to change HTML generated for custom HTML feature.
- Parameters are same as `wp_menu_custom_fields_image_html`.
- Example:
    <pre><code>
    [selected-feature] => html
    [html] => Array
        (
            [custom-html] => <em><strong>This is custom HTML</strong></em>
        )
    </code></pre>

= wp_menu_custom_fields_custom_text_html Filter =

- Allows to change HTML generated for custom text field.
- Parameters are same as `wp_menu_custom_fields_image_html`.
- Example:
    <pre><code>
    [custom-text] => This is a custom text
    </code></pre>

= wp_menu_custom_fields_fields_html Filter =

- Allows to change the final custom field's HTML generated for a particular menu item.
- Parameters are same as `wp_menu_custom_fields_image_html`.
- Example:
    <pre><code>
    Array
    (
        [custom-text] => This is a custom text
        [selected-feature] => image
        [image] => Array
            (
                [media-id] => 11
                [media-type] => image
                [media-link] => https://google.com
                [media-caption] => This is image caption
                [media-url] => http://example.com/wp-content/uploads/2020/03/92d43b978cbcdc7b33e3596d131d5256.jpg
            )

    )
    </code></pre>

== Styling mega menu ==

A theme developer can add stylings for the custom fields added by this plugin by referring to the below sample HTML code.

- Image & Custom text
    - Sample HTML code

    <pre><code>
        <div class="rt-wp-menu-custom-fields-wrapper" style="padding-top: 10px; padding-right: 20px;">
            <div class="rt-wp-menu-custom-fields-image-wrapper">
                <a href="https://google.com">
                    <img class="rt-wp-menu-custom-fields-image" src="http://example.com/wp-content/uploads/2020/03/92d43b978cbcdc7b33e3596d131d5256.jpg">
                </a>
                <span class="rt-wp-menu-custom-fields-image-caption">This is an image caption</span>
            </div>
            <span class="rt-wp-menu-custom-fields-custom-text">This is a custom text</span>
        </div>
    </code></pre>

    - If **Image Link** is entered, then `img` tag will be wrapped inside `a`.
    - Custom text will be displayed below the feature's HTML.

- Shortcode

    <pre><code>
        <div class="rt-wp-menu-custom-fields-shortcode-wrapper">
            <div class="rt-wp-menu-custom-fields-shortcode">
                <!-- shortcode HTML will be here -->
            </div>
            <span class="rt-wp-menu-custom-fields-shortcode-caption">This is shortcode caption!</span>
        </div>
    </code></pre>

- Custom HTML

    <pre><code>
        <div class="rt-wp-menu-custom-fields-custom-html">Welcome to <strong>WordPress</strong>. This is your first post. Edit or delete it, then start <em>writing</em>!</div>
    </code></pre>

== Important Links ==

* [GitHub](https://github.com/rtCamp/wp-menu-custom-fields) - Please mention your wordpress.org username when sending pull requests.

== License ==

Same [GPL](http://www.gnu.org/licenses/gpl-2.0.txt) that WordPress uses!

== Changelog ==

= 1.0.2 =
FIXED
 * Fix audio Shortcode not rendering on frontend
 * Fix few notices

= 1.0.1 =
FIXED
 * Class `WP_Menu_Custom_Fields\Inc\Plugin` not found error on Windows platform

= 1.0 =
* Initial release

== Upgrade Notice ==
WP Menu Custom Fields v1.0.2, with added fix for Audio Shortcode.

== See room for improvement? ==

Great! There are several ways you can get involved to help make this plugin better:

1. **Report Bugs:** If you find a bug, error or other problem, please report it! You can do this by [creating a new topic](https://github.com/rtCamp/wp-menu-custom-fields/issues) in the issue tracker.
2. **Suggest New Features:** Have an awesome idea? Please share it! Simply [create a new topic](https://github.com/rtCamp/wp-menu-custom-fields/issues) in the issure tracker to express your thoughts on why the feature should be included and get a discussion going around your idea.
