=== Mobile Detection ===
Contributors: azurecurve
Tags: mobile, tablet, desktop, chrome, android, IE, WebKit, iOS, iPad, iPhone, Mobile Detect, post, page, widget, shortcode
Plugin URI: https://development.azurecurve.co.uk/classicpress-plugins/mobile-detection/
Donate link: https://development.azurecurve.co.uk/support-development/
Requires at least: 1.0.0
Tested up to: 1.0.0
Requires PHP: 5.6
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Plugin providing shortcodes and functions to allow different content to be served to different types of device (Desktop, Tablet, Phone); also includes checks on types of device (iOS, iPhone, iPad, Android, Windows Phone) and mobile browsers (Chrome, Firefox, IE, Opera, WebKit). Uses the PHP Mobile Detect class.

== Description ==
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

All shortcodes available as functions with an <strong>azrcrv_md</strong> prefix for calling from themes, other plugins, etc. For example, <strong>is_mobile</strong> available as function <strong>azrcrv_md_is_mobile</strong>.

Uses PHP Mobile Detect class, the lightweight PHP class for detecting mobile devices (including tablets), from http://mobiledetect.net/.

== Installation ==
To install the Mobile Detection plugin:
* Download the plugin from <a href='https://github.com/azurecurve/azrcrv-mobile-detection/'>GitHub</a>.
* Upload the entire zip file using the Plugins upload function in your ClassicPress admin panel.
* Activate the plugin.

== Changelog ==
Changes and feature additions for the Mobile Detection plugin:
= 1.0.0 =
* First version for ClassicPress forked from azurecurve Mobile Detection WordPress Plugin.

== Frequently Asked Questions ==
= Can I translate this plugin? =
* Yes, the .pot fie is in the plugin's languages folder and can also be downloaded from the plugin page on https://development.azurecurve.co.uk; if you do translate this plugin please sent the .po and .mo files to translations@azurecurve.co.uk for inclusion in the next version (full credit will be given).
= Is this plugin compatible with both WordPress and ClassicPress? =
* This plugin is developed for ClassicPress, but will likely work on WordPress.