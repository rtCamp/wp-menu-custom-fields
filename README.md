<p align="center">
<a href="https://rtcamp.com/?ref=wp-menu-custom-fields-repo" target="_blank"><img width="200"src="https://rtcamp.com/wp-content/themes/rtcamp-v9/assets/img/site-logo-black.svg"></a>
</p>

# WP Menu Custom Fields - v1.0.2
[![Project Status: Active – The project has reached a stable, usable state and is being actively developed.](https://www.repostatus.org/badges/latest/active.svg)](https://www.repostatus.org/#active)

This plugin adds custom fields on menu item's edit screen of wp-admin.

**Author:** rtCamp

**Contributors:** rtcamp, sid177, kiranpotphode, devikvekariya, vaishaliagola27, deepaklalwani97

**Tags:** Navigation Menu, Navigation Menu Custom Fields

**Requires at least:** 5.4

**Tested up to:** 5.7

**Requires PHP version:** 7.0

**Stable tag:** 1.0.2

**License:** GPLv2 or later (of course!)

**License URI:** http://www.gnu.org/licenses/gpl-2.0.html

## Description ##
This plugin adds custom fields on Appearance -> Menus page of wp-admin (see [screenshots](#screenshots)).
It uses `wp_nav_menu_item_custom_fields` hook added in WordPress 5.4 release to add custom fields.  
Below is the list of custom fields added by this plugin.
- Custom text
- Image selection with link and caption
- Shortcode with caption
- Custom HTML with tinyMCE editor

**Note:** This plugin works with default themes. In order to use it with custom themes, please add the necessary styling.

## Installation ##

1. Extract the zip file.
2. Upload it to the `/wp-content/plugins/` directory in your WordPress installation.
3. Activate the WP Menu Custom Fields from your Plugins page.

## Usage ##
1. After installing and activating this plugin, goto Appearance -> Menus of your WordPress admin. Create a menu if you haven't already and add menu items according to your need.
2. When you expand any menu item, you'll see the custom fields added here (see [screenshots](#screenshots)). You can see **Custom Field** and **Select Feature** options.
3. Along with Custom Text field, you can choose to use either Image, Shortcode or Custom HTML feature for a particular menu item.
4. You can click on the option you want to use and the input fields of that option will be visible.
#### Using Custom Text field ####
- You can enter any text here and it'll be displayed with this menu item.
- This field can be used by all menu items along with any other feature.
#### Using Image ####
- By clicking on **Select Image** button, WordPress' media gallery window will be opened up. You can choose 1 image from already uploaded images or you can upload a new one and select that.
- The selected image will be shown below **Select Image** button after you select and close the media gallery window.
- To remove already selected image, click on **Select Image** button and deselect the already selected image. You can change the selected image by selecting any other image.
- You can enter a URL in **Image Link** text field. On front-end, clicking on the image will lead to this URL.
- You can enter a caption text in **Image Caption** field and it'll be displayed below the image on the front-end.
#### Using Shortcode ####
- You can add a shortcode in **Shortcode** field. We've added some stylings to handle WordPress' defaut `[video]` shortcode.
- You can enter a caption text in **Shortcode Caption** field and it'll be displayed below the shortcode on the front-end.
#### Using Custom HTML ####
- TinyMCE editor is used to add custom HTML here.
- From the **Visual** tab, you can enter text and format it using tools given in toolbar.
- You can switch to **Text** tab to see/change HTML code of the text you entered.

### Screenshots ###

Custom fields added under Appearance -> Menus:

![Custom fields added under Appearance -> Menus](/screenshots/backend-gif.gif?raw=true)

Menu on frontend of your website:

![Menu on frontend of your website](/screenshots/frontend-gif.gif?raw=true)

## Hooks ##
#### `wp_menu_custom_fields_image_html` [Filter](https://developer.wordpress.org/plugins/hooks/filters/) ####
- Allows to change HTML generated for image feature.
- There are 3 parameters. $html (Generated HTML), $data (Custom fields data), $item_id (Menu item ID).
- Sample $data
```
[selected-feature] => image
[image] => Array
    (
        [media-id] => 11
        [media-type] => image
        [media-link] => https://google.com/
        [media-caption] => This is image caption
        [media-url] => http://example.com/wp-content/uploads/2020/03/92d43b978cbcdc7b33e3596d131d5256.jpg
    )
```

#### `wp_menu_custom_fields_shortcode_html` Filter ####
- Allows to change HTML generated for shortcode feature.
- Parameters are same as `wp_menu_custom_fields_image_html`.
- Sample $data
```
[selected-feature] => shortcode
[shortcode] => Array
    (
        [shortcode] => [video src="https://file-examples.com/wp-content/uploads/2017/04/file_example_MP4_480_1_5MG.mp4"]
        [shortcode-caption] => This is a shortcode caption
    )
```

#### `wp_menu_custom_fields_custom_markup_html` Filter ####
- Allows to change HTML generated for custom HTML feature.
- Parameters are same as `wp_menu_custom_fields_image_html`.
- Sample $data
```
[selected-feature] => html
[html] => Array
    (
        [custom-html] => <em><strong>This is custom HTML</strong></em>
    )
```

#### `wp_menu_custom_fields_custom_text_html` Filter ####
- Allows to change HTML generated for custom text field.
- Parameters are same as `wp_menu_custom_fields_image_html`.
- Sample $data
```
[custom-text] => This is a custom text
```

#### `wp_menu_custom_fields_fields_html` Filter ####
- Allows to change the final custom field's HTML generated for a particular menu item.
- Parameters are same as `wp_menu_custom_fields_image_html`.
- Sample $data
```
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
```

## Styling mega menu ##
A theme developer can add stylings for the custom fields added by this plugin by referring to the below sample HTML code.
- Image & Custom text
    - Sample HTML code
    ```
    <div class="rt-wp-menu-custom-fields-wrapper" style="padding-top: 10px; padding-right: 20px; /* Dynamic stylings added via JavaScript. */">
        <div class="rt-wp-menu-custom-fields-image-wrapper">
            <a href="{ Image Link }">
                <img class="rt-wp-menu-custom-fields-image" src="{ Selected Image }">
            </a>
            <span class="rt-wp-menu-custom-fields-image-caption">{ Image Caption }</span>
        </div>
        <span class="rt-wp-menu-custom-fields-custom-text">{ Custom Text }</span>
    </div>
    ```
    - If **Image Link** is entered, then `img` tag will be wrapped inside `a`.
    - Custom text will be displayed below the feature's HTML.
- Shortcode
    ```
    <div class="rt-wp-menu-custom-fields-shortcode-wrapper">
        <div class="rt-wp-menu-custom-fields-shortcode">
            { Shortcode }
        </div>
        <span class="rt-wp-menu-custom-fields-shortcode-caption">{ Shortcode Caption }</span>
    </div>
    ```
- Custom HTML
    ```
    <div class="rt-wp-menu-custom-fields-custom-html">{ Custom HTML }</div>
    ```

## Contribute

### Reporting a bug 🐞

Before creating a new issue, do browse through the [existing issues](https://github.com/rtCamp/wp-menu-custom-fields/issues) for resolution or upcoming fixes. 

If you still need to [log an issue](https://github.com/rtCamp/wp-menu-custom-fields/issues/new), making sure to include as much detail as you can, including clear steps to reproduce your issue if possible.

### Creating a pull request

Want to contribute a new feature? Start a conversation by logging an [issue](https://github.com/rtCamp/wp-menu-custom-fields/issues).

Once you're ready to send a pull request, please run through the following checklist: 

1. Browse through the [existing issues](https://github.com/rtCamp/wp-menu-custom-fields/issues) for anything related to what you want to work on. If you don't find any related issues, open a new one.

1. Fork this repository.

1. Create a branch from `develop` for each issue you'd like to address and commit your changes.

1. Push the code changes from your local clone to your fork.

1. Open a pull request and that's it! We'll with feedback as soon as possible (Isn't collaboration a great thing? 😌)

1. Once your pull request has passed final code review and tests, it will be merged into `develop` and be in the pipeline for the next release. Props to you! 🎉


# BTW, We're Hiring!

<a href="https://rtcamp.com/"><img src="https://rtcamp.com/wp-content/uploads/2019/04/github-banner@2x.png" alt="Join us at rtCamp, we specialize in providing high performance enterprise WordPress solutions"></a>
