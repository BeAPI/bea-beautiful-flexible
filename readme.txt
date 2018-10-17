=== BEA - Beautiful Flexible ===
Contributors: beapi, maximeculea
Donate link: http://paypal.me/BeAPI
Tags: Advanced Custom Fields, ACF, ACF Addon, Flexible
Requires at least: 4.7
Requires php: 5.6
Tested up to: 4.9.6
Stable tag: 1.0.5
License: GPLv3 or later
License URI: https://github.com/BeAPI/bea-beautiful-flexible/blob/master/LICENSE.md

Transform ACF's flexible layouts list into a nice and UX popup.

== Description ==

Transform ACF's flexible layouts list into a nice and UX popup.

## How ?

By default there is a "default" image for layouts. But the idea is to customize them by adding your own.

### Image convention

* The size of image should be 366 x 150 or bigger 732 x 300.
* They should be named based on the flexible key (`push_2_light`) with no underscores but dashes (`push-2-light.[extension]`).
* The following extensions will be resolved in that order: `.jpg`, `.jpeg`, `.png` and `.gif`.

### Where images should be situated

They should more likely be situated into your theme `wp-content\themes\my-theme\assets\bea-beautiful-flexible\`. But if you have a child-theme and added images into it, these will overwrite those from parent-theme.
The following directories will be solved according to order: plugin's folder, child theme's folder, theme's folder.

Also note that you can filter this path to gather all your images into a same folder :

`add_filter( 'bea.beautiful_flexible.images_path', $path );`

Finally, you could filter all images like this :

`add_filter( 'bea.beautiful_flexible.images', $images );`

## Who ?

### Credits

Special thanks to HWK, from his blogpost, we created a WordPress plugin with custom tuning (js+css).

### Creator

Created by [Be API](https://beapi.fr), the French WordPress leader agency since 2009. Based in Paris, we are more than 30 people and always [hiring](https://beapi.workable.com) some fun and talented guys. So we will be pleased to work with you.

This plugin is only maintained, which means we do not guarantee some free support. Consider reporting an [issue](https://github.com/BeAPI/bea-media-analytics/issues) and be patient.

To facilitate the process of submitting an issue and quicker answer, we only use Github, so don't use WP.Org support, it will not be considered.

== Installation ==

This plugin works only if the [ACF Pro](https://www.advancedcustomfields.com/) plugin is installed and activated.

# Requirements

- [ACF Pro](https://www.advancedcustomfields.com/) plugin
- WordPress 4.7+ because of `[get_theme_file_uri()](https://developer.wordpress.org/reference/functions/get_theme_file_uri)`
- Tested up to 4.9.3.
- PHP 5.6+

# WordPress

- Download and install using the built-in WordPress plugin installer.
- Site activate in the "Plugins" area of the admin.
- Then [add](#details) your awesome layouts images.

== Screenshots ==

1. Show how BEA Beautiful Flexible improve the ACF's layouts dropdown.

== Changelog ==

= 1.0.5 - 17 Oct 2018 =
- FIX [#10](https://github.com/BeAPI/bea-beautiful-flexible/issues/10) : fix warning

= 1.0.4 - 15 Oct 2018 =
- Update readme with new requirements
- Feature [#11](https://github.com/BeAPI/bea-beautiful-flexible/issues/11) : add more filetype
- FIX [#10](https://github.com/BeAPI/bea-beautiful-flexible/issues/10) : fix warning

= 1.0.3 - 13 Aug 2018 =
- FIX [#8](https://github.com/BeAPI/bea-beautiful-flexible/issues/8) : breaking changes with ACF 5.7.0 by adding new JS.
- Refactor way requirements are loaded by adding dedicated class.

= 1.0.2 - 5 Jun 2018 =
- Push to wp.org.

= 1.0.1 - 22 May 2018 =
- [#6](https://github.com/BeAPI/bea-beautiful-flexible/issues/6) : fix title display

= 1.0.0 - 4 May 2018 =
- First version of the plugin.
- Dynamically get flexible layouts.
- Finish readme.
- Add screenshot.
- Add composer.json.
- Init plugin.
