=== Bestseller Lists from the New York Times ===
Contributors: jakeparis
Donate link: https://jakeparis.com/
Tags: books, library, bestsellers, libraries, reading lists
Requires at least: 5.4
Tested up to: 6.5.2
Stable tag: 2.4.0
Requires PHP: 5.4

Integrate bestseller lists from the New York Times into your own site with a user-friendly interface. 

== Description ==

Use this plugin to display all the bestseller lists from New York Times on your own site. Optionally include links from your own local library catalog for each book. 

The plugin uses an easy-to-use user-interface which updates quickly and "in-place" when changing lists without reloading the rest of the page. 

== Use == 

Use the *Bestseller Lists from NYT* block. You can optionally specify which list is initially displayed.

There's also a shortcode available to embed the list viewer: `[nyt-bestseller-listings]`. You can optionally specify which list is initially displayed by using the `initial-list` attribute with the list slug as the attribute value. Get the list slug by first placing the shortcode in your page, then visiting the page and changing lists. The page url will change as the list changes, and the list slug can be seen by looking for **nyt-list=SLUG-HERE** in your browser's url bar. So for example, to place the lists on a page and set the initial list to be children's picture books, you would use: `[nyt-bestseller-listings initial-list="picture-books"]`

To hide the images, add the following bit of css to your theme stylesheet or to the *Additional CSS* section in the Customizer: `.nyt-bestseller-listings-img { display: none; }`. 

== Installation ==

1. Upload this directory to the \`/wp-content/plugins/\` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Configure the plugin by looking under Settings > NYT Bestseller Lists. You'll need to get an free API key from the NY Times, which you can do here: https://developer.nytimes.com/signup.
1. Embed the shortcode in your page. 

== Frequently Asked Questions ==

= How do I change which list shows up first? =

You can  set it on a per-instance level, by choosing the list in the block, or using the correct shortcode attribute. See the *Use* section. 

= The initial list displaying is not the one I'm choosing =

This can happen when old settings are "stuck". Visit the settings page (*Admin* > *Settings* > *NYT Bestseller Lists*) and just click Save. That should clear out any old settings. 

== Screenshots ==

1. The quick-switcher and the top of the list in TwentySeventeen theme.

== Changelog ==

= 2.4.0 =

Tested with WordPress 6.5.2. Works great! :)

= 2.3.1 =

Verion bump.

= 2.3.0 =

Reorganization of plugin; housekeeping.

= 2.2.0 = 

Tested with WordPress 6.3 and updated the readme a bit.

= 2.1.0 =

* Removed "default list" php setting. Now just set the default list in the block.
* Tested with WordPress 6.1

= 2.0.2 = 

Updated "tested up to" value

= 2.0.1 = 

* Fixed bug where no images show on lists beyond the initially loaded one.

= 2.0.0 =

* Added "hide images" setting to Lists block.
* Cleaned up the Lists block.
* Improved output using a css-grid layout
* Internal facing code cleanups
* Fixed config options names in DB.
* Updated tested-to version number to 5.9.2

= 1.2.6 = 

Fix a bad update.

= 1.2.4 =

Tested against WordPress 5.8 - works!

= 1.2.3 =

Tested against WordPress 5.5

= 1.2.2 = 

Added backwards compatibility for pre WordPress 5.0

= 1.2.0 =

Added a "block" for the new WordPress 5.0 editor. The shortcode is left for backwards-compatibility.

= 1.0.1 = 

File cleanups.

= 1.0.0 =

Initial release. Includes basic listings shortcode with ability control initial list. 

== Upgrade Notice == 

= 1.0.0 = 
Use this plugin.
