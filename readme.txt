=== Mobile Detection ===

Description:	Plugin providing shortcodes and functions to allow different content to be served to different types of device.
Version:		1.1.1
Tags:			mobile, tablet, desktop, chrome, android, IE, WebKit, iOS, iPad, iPhone, Mobile Detect, post, page, widget, shortcode
Author:			azurecurve
Author URI:		https://development.azurecurve.co.uk/
Plugin URI:		https://development.azurecurve.co.uk/classicpress-plugins/mobile-detection/
Download link:	https://github.com/azurecurve/azrcrv-mobile-detection/releases/download/v1.1.0/azrcrv-mobile-detection.zip
Donate link:	https://development.azurecurve.co.uk/support-development/
Requires PHP:	5.6
Requires:		1.0.0
Tested:			4.9.99
Text Domain:	mobile-detection
Domain Path:	/languages
License: 		GPLv2 or later
License URI: 	http://www.gnu.org/licenses/gpl-2.0.html

Plugin providing shortcodes and functions to allow different content to be served to different types of device.

== Description ==

# Description

Plugin providing shortcodes and functions to allow different content to be served to different types of device (Desktop, Tablet, Phone); also includes checks on types of device (iOS, iPhone, iPad, Android, Windows Phone) and mobile browsers (Chrome, Firefox, IE, Opera, WebKit).

The following shortcodes are available:
* ismobile
* isnotmobile
* isphone
* isnotphone
* istablet
* isnottablet
* isios
* isiphone
* isipad
* isandroid
* iswindowsphone (alternative shortcode iswp)
* iswindowsmobile (alternative shortcode iswinmo)
* ischrome
* isfirefox
* isie
* isopera
* iswebkit
* istv
* isconsole

All shortcodes available as functions with an **azrcrv_md** prefix for calling from themes, other plugins, etc. For example, **is_mobile** available as function **azrcrv_md_is_mobile**.

Uses PHP Mobile Detect class, the lightweight PHP class for detecting mobile devices (including tablets), from http://mobiledetect.net/.

This plugin is multisite compatible..

== Installation ==

# Installation Instructions

 * Download the plugin from [GitHub](https://github.com/azurecurve/azrcrv-mobile-detection/releases/latest/).
 * Upload the entire zip file using the Plugins upload function in your ClassicPress admin panel.
 * Activate the plugin.
 * Configure relevant settings via the configuration page in the admin control panel (azurecurve menu).

== Frequently Asked Questions ==

# Frequently Asked Questions

### Can I translate this plugin?
Yes, the .pot fie is in the plugins languages folder and can also be downloaded from the plugin page on https://development.azurecurve.co.uk; if you do translate this plugin, please sent the .po and .mo files to translations@azurecurve.co.uk for inclusion in the next version (full credit will be given).

### Is this plugin compatible with both WordPress and ClassicPress?
This plugin is developed for ClassicPress, but will likely work on WordPress.

== Changelog ==

# Changelog

### [Version 1.1.1](https://github.com/azurecurve/azrcrv-mobile-detection/releases/tag/v1.1.1)
 * Fix bug with incorrect language load text domain.

### [Version 1.1.0](https://github.com/azurecurve/azrcrv-mobile-detection/releases/tag/v1.1.0)
 * Add integration with Update Manager for automatic updates.
 * Fix issue with display of azurecurve menu.
 * Change settings page heading.
 * Add load_plugin_textdomain to handle translations.

### [Version 1.0.1](https://github.com/azurecurve/azrcrv-mobile-detection/releases/tag/v1.0.1)
 * Update azurecurve menu for easier maintenance.
 * Move require of azurecurve menu below security check.

### [Version 1.0.0](https://github.com/azurecurve/azrcrv-mobile-detection/releases/tag/v1.0.0)
 * Initial release for ClassicPress forked from azurecurve Mobile Detection WordPress Plugin.

== Other Notes ==

# About azurecurve

**azurecurve** was one of the first plugin developers to start developing for Classicpress; all plugins are available from [azurecurve Development](https://development.azurecurve.co.uk/) and are integrated with the [Update Manager plugin](https://codepotent.com/classicpress/plugins/update-manager/) by [CodePotent](https://codepotent.com/) for fully integrated, no hassle, updates.

Some of the top plugins available from **azurecurve** are:
* [Add Twitter Cards](https://development.azurecurve.co.uk/classicpress-plugins/add-twitter-cards/)
* [Breadcrumbs](https://development.azurecurve.co.uk/classicpress-plugins/breadcrumbs/)
* [Series Index](https://development.azurecurve.co.uk/classicpress-plugins/series-index/)
* [To Twitter](https://development.azurecurve.co.uk/classicpress-plugins/to-twitter/)
* [Theme Switches](https://development.azurecurve.co.uk/classicpress-plugins/theme-switcher/)
* [Toggle Show/Hide](https://development.azurecurve.co.uk/classicpress-plugins/toggle-showhide/)