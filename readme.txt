=== Plugin Name ===
Contributors: unknowndomain, chrisguitarguy
Donate link: http://supportus.cancerresearchuk.org/donate/
Tags: custom, post, type, main, loop, query, the loop, post type, custom post type, cpt, custom post type, main loop, main query
Requires at least: 3.3
Tested up to: 3.3
Stable tag: 1.0

Custom Post Type Selector allows you to select which post types should be included in the main loop of your blog, including custom post types.

== Description ==

Custom Post Type Selector allows you to select which post types should be included in the main loop of your blog, including custom post types.

**If you find this plugin useful please [donate to Cancer Research UK], and let me know what think you via [my website].**

Special thanks to [Christopher Davis] for his help getting the [core functionality] working on [#wordpress].

[my website]: http://tomlynch.co.uk
[Christopher Davis]: http://christopherdavis.me
[core functionality]: https://gist.github.com/1864416
[#wordpress]: http://codex.wordpress.org/IRC

[donate to Cancer Research UK]: http://supportus.cancerresearchuk.org/donate/

== Installation ==

Depending on whether you are using a standard installation of WordPress or a Multi-site installation you will need to look in the Site Admin or Network Admin areas respectively.

1. Download and activate Custom Post Type Selector from within your WordPress Admin, under the Plugins menu. 
1. You will find the `Post Types` panel under the `Settings` menu in the WordPress Admin.

== Screenshots ==

1. From this panel you can select which post types should be enabled.
2. You will find the `Post Types` panel under the `Settings` menu in the Admin area of your site or network.

== Frequently Asked Questions ==

= How do I get to the Custom Post Type Selector settings after I activate? =

1. There are two easy ways, first is to click `Post Types` under the now activated plugin in the Plugins list.
1. Go to the `Settings` menu and click `Post Types`. 

= How do I use Custom Post Type Selector? =

Simply activate Custom Post Type Selector, go to the settings page and check or uncheck the post types you wish to show or hide from the main loop (front page).

= How can I get more help? =

I am a pretty busy person but I will do my best to answer questions, so long as they aren't plain obvious, just email me via [my website].

[my website]: http://tomlynch.co.uk

= Why does this plugin require WordPress 3.3? =

This plugin uses a function called [is_main_query()] which was not introduced until WordPress 3.3 so there is no way to implement this functionality like this in earlier versions.

[is_main_query()]: http://codex.wordpress.org/Function_Reference/is_main_query

== Changelog ==

= 1.0 =
* Initial release