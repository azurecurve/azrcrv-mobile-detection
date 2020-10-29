<?php
/**
 * ------------------------------------------------------------------------------
 * Plugin Name: Mobile Detection
 * Description: Plugin providing shortcodes and functions to allow different content to be served to different types of device (Desktop, Tablet, Phone); also includes checks on types of device (iOS, iPhone, iPad, Android, Windows Phone) and mobile browsers (Chrome, Firefox, IE, Opera, WebKit). Uses the PHP Mobile Detect class.
 * Version: 1.2.0
 * Author: azurecurve
 * Author URI: https://development.azurecurve.co.uk/classicpress-plugins/
 * Plugin URI: https://development.azurecurve.co.uk/classicpress-plugins/mobile-detection/
 * Text Domain: mobile-detection
 * Domain Path: /languages
 * ------------------------------------------------------------------------------
 * This is free software released under the terms of the General Public License,
 * version 2, or later. It is distributed WITHOUT ANY WARRANTY; without even the
 * implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. Full
 * text of the license is available at https://www.gnu.org/licenses/gpl-2.0.html.
 * ------------------------------------------------------------------------------
 */

// Prevent direct access.
if (!defined('ABSPATH')){
	die();
}

// include plugin menu
require_once(dirname( __FILE__).'/pluginmenu/menu.php');
add_action('admin_init', 'azrcrv_create_plugin_menu_md');

// include update client
require_once(dirname(__FILE__).'/libraries/updateclient/UpdateClient.class.php');

/**
 * Setup registration activation hook, actions, filters and shortcodes.
 *
 * @since 1.0.0
 *
 */

// add actions
add_action('admin_menu', 'azrcrv_md_create_admin_menu');
add_action('network_admin_menu', 'azrcrv_md_create_network_admin_menu');
add_action('plugins_loaded', 'azrcrv_md_load_languages');

// add filters
add_filter('plugin_action_links', 'azrcrv_md_add_plugin_action_link', 10, 2);
add_filter('codepotent_update_manager_image_path', 'azrcrv_md_custom_image_path');
add_filter('codepotent_update_manager_image_url', 'azrcrv_md_custom_image_url');

// add shortcodes
add_shortcode('ismobile', 'azrcrv_md_is_mobile_shortcode');
add_shortcode('isnotmobile', 'azrcrv_md_is_not_mobile_shortcode');
add_shortcode('isphone', 'azrcrv_md_is_phone_shortcode');
add_shortcode('isnotphone', 'azrcrv_md_is_not_phone_shortcode');
add_shortcode('istablet', 'azrcrv_md_is_tablet_shortcode');
add_shortcode('isnottablet', 'azrcrv_md_is_not_tablet_shortcode');
add_shortcode('isios', 'azrcrv_md_is_iOS_shortcode');
add_shortcode('isiphone', 'azrcrv_md_is_iPhone_shortcode');
add_shortcode('isipad', 'azrcrv_md_is_iPad_shortcode');
add_shortcode('isandroidos', 'azrcrv_md_is_AndroidOS_shortcode');
add_shortcode('isandroid', 'azrcrv_md_is_AndroidOS_shortcode');
add_shortcode('iswindowsmobileos', 'azrcrv_md_is_WindowsMobileOS_shortcode');
add_shortcode('iswindowsmobile', 'azrcrv_md_is_WindowsMobileOS_shortcode');
add_shortcode('iswinmo', 'azrcrv_md_is_WindowsMobileOS_shortcode');
add_shortcode('iswindowsphone', 'azrcrv_md_is_WindowsPhoneOS_shortcode');
add_shortcode('iswindowsphone', 'azrcrv_md_is_WindowsPhoneOS_shortcode');
add_shortcode('iswp', 'azrcrv_md_is_WindowsPhoneOS_shortcode');
add_shortcode('ischrome', 'azrcrv_md_is_Chrome_shortcode');
add_shortcode('isfirefox', 'azrcrv_md_is_Firefox_shortcode');
add_shortcode('isinternetexplorer', 'azrcrv_md_is_IE_shortcode');
add_shortcode('isie', 'azrcrv_md_is_IE_shortcode');
add_shortcode('isopera', 'azrcrv_md_is_Opera_shortcode');
add_shortcode('istv', 'azrcrv_md_is_TV_shortcode');
add_shortcode('iswebkit', 'azrcrv_md_is_WebKit_shortcode');
add_shortcode('isconsole', 'azrcrv_md_is_Console_shortcode');

/**
 * Load language files.
 *
 * @since 1.0.0
 *
 */
function azrcrv_md_load_languages() {
    $plugin_rel_path = basename(dirname(__FILE__)).'/languages';
    load_plugin_textdomain('mobile-detection', false, $plugin_rel_path);
}

/**
 * Custom plugin image path.
 *
 * @since 1.2.0
 *
 */
function azrcrv_md_custom_image_path($path){
    if (strpos($path, 'azrcrv-mobile-detection') !== false){
        $path = plugin_dir_path(__FILE__).'assets/pluginimages';
    }
    return $path;
}

/**
 * Custom plugin image url.
 *
 * @since 1.2.0
 *
 */
function azrcrv_md_custom_image_url($url){
    if (strpos($url, 'azrcrv-mobile-detection') !== false){
        $url = plugin_dir_url(__FILE__).'assets/pluginimages';
    }
    return $url;
}

/**
 * Add Mobile Detection action link on plugins page.
 *
 * @since 1.0.0
 *
 */
function azrcrv_md_add_plugin_action_link($links, $file){
	static $this_plugin;

	if (!$this_plugin){
		$this_plugin = plugin_basename(__FILE__);
	}

	if ($file == $this_plugin){
		$settings_link = '<a href="'.admin_url('admin.php?page=azrcrv-md').'"><img src="'.plugins_url('/pluginmenu/images/Favicon-16x16.png', __FILE__).'" style="padding-top: 2px; margin-right: -5px; height: 16px; width: 16px;" alt="azurecurve" />'.esc_html__('Settings' ,'mobile-detection').'</a>';
		array_unshift($links, $settings_link);
	}

	return $links;
}

/**
 * Add to menu.
 *
 * @since 1.0.0
 *
 */
function azrcrv_md_create_admin_menu(){
	//global $admin_page_hooks;
	
	add_submenu_page("azrcrv-plugin-menu"
						,esc_html__("Mobile Detection Settings", "mobile-detection")
						,esc_html__("Mobile Detection", "mobile-detection")
						,'manage_options'
						,'azrcrv-md'
						,'azrcrv_md_display_options');
}

/**
 * Display Settings page.
 *
 * @since 1.0.0
 *
 */
function azrcrv_md_display_options(){
	if (!current_user_can('manage_options')){
        wp_die(esc_html__('You do not have sufficient permissions to access this page.', 'mobile-detection'));
    }
	
	?>
	<div id="azrcrv-md-general" class="wrap">
		<h1><?php echo esc_html(get_admin_page_title()); ?></h1>

		<table class="form-table">
			<tr>
				<th scope="row" colspan="2">
					<label for="explanation">
						<?php esc_html_e('Mobile Detection provides shortcodes and functions to allow different content to be served to different types of device:', 'mobile-detection'); ?>
					</label>
				</th>
			</tr>
			<tr><th scope="row">ismobile</th><td><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_mobile</strong></td></tr>
			<tr><th scope="row">isnotmobile</th><td><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_not_mobile</strong></td></tr>
			<tr><th scope="row">isphone</th><td><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_phone</strong></td></tr>
			<tr><th scope="row">isnotphone</th><td><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_not_phone</strong></td></tr>
			<tr><th scope="row">istablet</th><td><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_tablet</strong></td></tr>
			<tr><th scope="row">isnottablet</th><td><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_not_tablet</strong></td></tr>
			<tr><th scope="row">isios</th><td><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_iOS</strong></td></tr>
			<tr><th scope="row">isiphone</th><td><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_iPhone</strong></td></tr>
			<tr><th scope="row">isipad</th><td><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_iPad</strong></td></tr>
			<tr><th scope="row">isandroid</th><td><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_Android</strong></td></tr>
			<tr><th scope="row">iswindowsphone</th><td><?php printf(esc_html__('Alternative shortcode %s available', 'mobile-detection'), 'iswp'); ?><br /><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_WindowsPhoneOS</strong></td></tr>
			<tr><th scope="row">iswindowsmobile</th><td><?php printf(esc_html__('Alternative shortcode %s available', 'mobile-detection'), 'iswinmo'); ?><br /><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_WindowsMobileOS</strong></td></tr>
			<tr><th scope="row">ischrome</th><td><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_Chrome</strong></td></tr>
			<tr><th scope="row">isfirefox</th><td><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_Firefox</strong></td></tr>
			<tr><th scope="row">isie</th><td><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_IE</strong></td></tr>
			<tr><th scope="row">isopera</th><td><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_Opera</strong></td></tr>
			<tr><th scope="row">iswebkit</th><td><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_WebKit</strong></td></tr>
			<tr><th scope="row">istv</th><td><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_TV</strong></td></tr>
			<tr><th scope="row">isconsole</th><td><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_Console</strong></td></tr>
			<tr>
				<th scope="row" colspan="2">
					<?php esc_html_e('All function calls available with <em>azc</em> prefix for backward compatibility', 'mobile-detection'); ?>
				</th>
			</tr>
			<tr>
				<th scope="row" colspan="2">
					<label for="additional-plugins">
						azurecurve <?php esc_html_e('has the following plugins which allow shortcodes to be used in comments and widgets:', 'mobile-detection'); ?>
					</label>
					<ul class='azc_plugin_index'>
						<li>
							<?php
							if (azrcrv_md_is_plugin_active('azrcrv-shortcodes-in-comments/azrcrv-shortcodes-in-comments.php')){
								echo "<a href='admin.php?page=azc-sic' class='azc_plugin_index'>Shortcodes in Comments</a>";
							}else{
								echo "<a href='https://development.azurecurve.co.uk/classicpress-plugins/shortcodes-in-comments/' class='azc_plugin_index'>Shortcodes in Comments</a>";
							}
							?>
						</li>
						<li>
							<?php
							if (azrcrv_md_is_plugin_active('azrcrv-shortcodes-in-widgets/azrcrv-shortcodes-in-widgets.php')){
								echo "<a href='admin.php?page=azc-siw' class='azc_plugin_index'>Shortcodes in Widgets</a>";
							}else{
								echo "<a href='https://development.azurecurve.co.uk/classicpress-plugins/shortcodes-in-widgets/' class='azc_plugin_index'>Shortcodes in Widgets</a>";
							}
							?>
						</li>
					</ul>
				</th>
			</tr>
		</table>
	</div>
	<?php
}

/**
 * Add to Network menu.
 *
 * @since 1.0.0
 *
 */
function azrcrv_md_create_network_admin_menu(){
	if (function_exists('is_multisite') && is_multisite()){
		add_submenu_page(
						'settings.php'
						,esc_html__("Mobile Detection Settings", "mobile-detection")
						,esc_html__("Mobile Detection", "mobile-detection")
						,'manage_network_options'
						,'azrcrv-md'
						,'azrcrv_md_network_settings'
						);
	}
}

/**
 * Display network settings.
 *
 * @since 1.0.0
 *
 */
function azrcrv_md_network_settings(){
	if(!current_user_can('manage_network_options')){
		wp_die(esc_html__('You do not have permissions to perform this action', 'mobile-detection'));
	}

	?>
	<div id="azrcrv-md-general" class="wrap">
		<h2><?php esc_html_e('Mobile Detection' , 'mobile-detection'); ?></h2>

		<table class="form-table">
			<tr>
				<th scope="row" colspan="2">
					<label for="explanation">
						<?php esc_html_e('Mobile Detection provides shortcodes and functions to allow different content to be served to different types of device:', 'mobile-detection'); ?>
					</label>
				</th>
			</tr>
			<tr><th scope="row">ismobile</th><td><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_mobile</strong></td></tr>
			<tr><th scope="row">isnotmobile</th><td><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_not_mobile</strong></td></tr>
			<tr><th scope="row">isphone</th><td><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_phone</strong></td></tr>
			<tr><th scope="row">isnotphone</th><td><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_not_phone</strong></td></tr>
			<tr><th scope="row">istablet</th><td><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_tablet</strong></td></tr>
			<tr><th scope="row">isnottablet</th><td><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_not_tablet</strong></td></tr>
			<tr><th scope="row">isios</th><td><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_iOS</strong></td></tr>
			<tr><th scope="row">isiphone</th><td><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_iPhone</strong></td></tr>
			<tr><th scope="row">isipad</th><td><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_iPad</strong></td></tr>
			<tr><th scope="row">isandroid</th><td><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_Android</strong></td></tr>
			<tr><th scope="row">iswindowsphone</th><td><?php printf(esc_html__('Alternative shortcode %s available', 'mobile-detection'), 'iswp'); ?><br /><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_WindowsPhoneOS</strong></td></tr>
			<tr><th scope="row">iswindowsmobile</th><td><?php printf(esc_html__('Alternative shortcode %s available', 'mobile-detection'), 'iswinmo'); ?><br /><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_WindowsMobileOS</strong></td></tr>
			<tr><th scope="row">ischrome</th><td><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_Chrome</strong></td></tr>
			<tr><th scope="row">isfirefox</th><td><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_Firefox</strong></td></tr>
			<tr><th scope="row">isie</th><td><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_IE</strong></td></tr>
			<tr><th scope="row">isopera</th><td><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_Opera</strong></td></tr>
			<tr><th scope="row">iswebkit</th><td><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_WebKit</strong></td></tr>
			<tr><th scope="row">istv</th><td><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_TV</strong></td></tr>
			<tr><th scope="row">isconsole</th><td><?php esc_html_e('Available as function call', 'mobile-detection'); ?> <strong>azrcrv_md_is_Console</strong></td></tr>
			<tr>
				<th scope="row" colspan="2">
					<?php esc_html_e('All function calls available with <em>azc</em> prefix for backward compatibility', 'mobile-detection'); ?>
				</th>
			</tr>
			<tr>
				<th scope="row" colspan="2">
					<label for="additional-plugins">
						azurecurve <?php esc_html_e('has the following plugins which allow shortcodes to be used in comments and widgets:', 'mobile-detection'); ?>
					</label>
					<ul class='azc_plugin_index'>
						<li>
							<?php
							if (azrcrv_md_is_plugin_active('azrcrv-shortcodes-in-comments/azrcrv-shortcodes-in-comments.php')){
								echo "<a href='admin.php?page=azc-sic' class='azc_plugin_index'>Shortcodes in Comments</a>";
							}else{
								echo "<a href='https://development.azurecurve.co.uk/classicpress-plugins/shortcodes-in-comments/' class='azc_plugin_index'>Shortcodes in Comments</a>";
							}
							?>
						</li>
						<li>
							<?php
							if (azrcrv_md_is_plugin_active('azrcrv-shortcodes-in-widgets/azrcrv-shortcodes-in-widgets.php')){
								echo "<a href='admin.php?page=azc-siw' class='azc_plugin_index'>Shortcodes in Widgets</a>";
							}else{
								echo "<a href='https://development.azurecurve.co.uk/classicpress-plugins/shortcodes-in-widgets/' class='azc_plugin_index'>Shortcodes in Widgets</a>";
							}
							?>
						</li>
					</ul>
				</th>
			</tr>
		</table>
	</div>
	<?php
}

/**
 * Check if function active (included due to standard function failing due to order of load).
 *
 * @since 1.0.0
 *
 */
function azrcrv_md_is_plugin_active($plugin){
    return in_array($plugin, (array) get_option('active_plugins', array()));
}

// include mobile detect library if not already present
if(!class_exists('Mobile_Detect')){
    require_once(plugin_dir_path(__FILE__).'/libraries/Mobile_Detect.php');
}

$detect = new Mobile_Detect();

// shortcode for is mobile (phones and tablets)
function azc_md_is_mobile_shortcode($atts, $content=null){
	global $detect;
	if ($detect->isMobile()) return do_shortcode($content);
}

// function returns true for mobile (phones and tablets)
function azc_md_is_mobile(){
	return azrcrv_md_is_mobile();
}
function azrcrv_md_is_mobile(){
	global $detect;
	if($detect->isMobile()) return true;
}


// shortcode for is not mobile (Laptops and Desktops)
function azc_md_is_not_mobile_shortcode($atts, $content=null){
	global $detect;
	if (!$detect->isMobile()) return do_shortcode($content);
}

// function returns true for is not mobile (Laptops and Desktops)
function azc_md_is_not_mobile(){
	return azrcrv_md_is_not_mobile();
}
function azrcrv_md_is_not_mobile(){
	global $detect;
	if(!$detect->isMobile()) return true;
}


// shortcode for is phone
function azc_md_is_phone_shortcode($atts, $content=null){
	global $detect;
	if ($detect->isMobile() && !$detect->istablet()) return do_shortcode($content);
}
// function returns true for is phone
function azc_md_is_phone(){
	return azrcrv_md_is_phone();
}
function azrcrv_md_is_phone(){
	global $detect;
	if($detect->isMobile() && !$detect->istablet()) return true;
}


// shortcode for is not phone (Tablets, Laptops and Desktops)
function azc_md_is_not_phone_shortcode($atts, $content=null){
	global $detect;
	if (!$detect->isMobile() || $detect->isTablet()) return do_shortcode($content);
}

// function returns true for not phone (Tablets, Laptops and Desktops)
function azc_md_is_not_phone(){
	return azrcrv_md_is_not_phone();
}
function azrcrv_md_is_not_phone(){
	global $detect;
	if($detect->isMobile() || $detect->isTablet()) return true;
}


// shortcode for is tablet
function azc_md_is_tablet_shortcode($atts, $content=null){
	global $detect;
	if ($detect->istablet()) return do_shortcode($content);
}

// function returns true for is tablet
function azc_md_is_tablet(){
	return azrcrv_md_is_tablet();
}
function azrcrv_md_is_tablet(){
	global $detect;
	if($detect->istablet()) return true;
}


// shortcode for is not tablet
function azc_md_is_not_tablet_shortcode($atts, $content=null){
	global $detect;
	if (!$detect->isTablet()) return do_shortcode($content);
}

// function returns true for not tablet
function azc_md_is_not_tablet(){
	return azrcrv_md_is_not_tablet();
}
function azrcrv_md_is_not_tablet(){
	global $detect;
	if(! $detect->isTablet()) return true;
}


// shortcode for is iOS
function azc_md_is_iOS_shortcode($atts, $content=null){
	global $detect;
	if ($detect->isiOS()) return do_shortcode($content);
}

// function returns true for is iOS
function azc_md_is_iOS(){
	return azrcrv_md_is_iOS();
}
function azrcrv_md_is_iOS(){
	global $detect;
	if($detect->isiOS()) return true;
}


// shortcode for is iPhone
function azc_md_is_iPhone_shortcode($atts, $content=null){
	global $detect;
	if ($detect->isiPhone()) return do_shortcode($content);
}

// function returns true for is iPhone
function azc_md_is_iPhone(){
	return azrcrv_md_is_iPhone();
}
function azrcrv_md_is_iPhone(){
	global $detect;
	if($detect->isiPhone()) return true;
}


// shortcode for is iPad
function azc_md_is_iPad_shortcode($atts, $content=null){
	global $detect;
	if ($detect->isiPad()) return do_shortcode($content);
}

// function returns true for is iPad
function azc_md_is_iPad(){
	return azrcrv_md_is_iPad();
}
function azrcrv_md_is_iPad(){
	global $detect;
	if($detect->isiPad()) return true;
}


// shortcode for is AndroidOS
function azc_md_is_AndroidOS_shortcode($atts, $content=null){
	global $detect;
	if ($detect->isAndroidOS()) return do_shortcode($content);
}

// function returns true for is AndroidOS
function azc_md_is_AndroidOS(){
	return azrcrv_md_is_AndroidOS();
}
function azrcrv_md_is_AndroidOS(){
	global $detect;
	if($detect->isAndroidOS()) return true;
}


// shortcode for is WindowsMobileOS
function azc_md_is_WindowsMobileOS_shortcode($atts, $content=null){
	global $detect;
	if ($detect->isWindowsMobileOS()) return do_shortcode($content);
}

// function returns true for is WindowsMobileOS
function azc_md_is_WindowsMobileOS(){
	return azrcrv_md_is_WindowsMobileOS();
}
function azrcrv_md_is_WindowsMobileOS(){
	global $detect;
	if($detect->isWindowsMobileOS()) return true;
}


// shortcode for is WindowsPhoneOS
function azc_md_is_WindowsPhoneOS_shortcode($atts, $content=null){
	global $detect;
	if ($detect->isWindowsPhoneOS()) return do_shortcode($content);
}

// function returns true for is WindowsPhoneOS
function azc_md_is_WindowsPhoneOS(){
	return azrcrv_md_is_WindowsPhoneOS();
}
function azrcrv_md_is_WindowsPhoneOS(){
	global $detect;
	if($detect->isWindowsPhoneOS()) return true;
}


// shortcode for is Chrome
function azc_md_is_Chrome_shortcode($atts, $content=null){
	global $detect;
	if ($detect->isChrome()) return do_shortcode($content);
}

// function returns true for is Chrome
function azc_md_is_Chrome(){
	return azrcrv_md_is_Chrome();
}
function azrcrv_md_is_Chrome(){
	global $detect;
	if($detect->isChrome()) return true;
}


// shortcode for is Firefox
function azc_md_is_Firefox_shortcode($atts, $content=null){
	global $detect;
	if ($detect->isFirefox()) return do_shortcode($content);
}

// function returns true for is Firefox
function azc_md_is_Firefox(){
	return azrcrv_md_is_Firefox();
}
function azrcrv_md_is_Firefox(){
	global $detect;
	if($detect->isFirefox()) return true;
}


// shortcode for is IE
function azc_md_is_IE_shortcode($atts, $content=null){
	global $detect;
	if ($detect->isIE()) return do_shortcode($content);
}

// function returns true for is IE
function azc_md_is_IE($atts, $content=null){
	azrcrv_md_is_IE($atts, $content=null);
}
function azrcrv_md_is_IE(){
	global $detect;
	if($detect->isIE()) return true;
}


// shortcode for is Opera
function azc_md_is_Opera_shortcode($atts, $content=null){
	global $detect;
	if ($detect->isOpera()) return do_shortcode($content);
}

// function returns true for is Opera
function azc_md_is_Opera(){
	return azrcrv_md_is_Opera();
}
function azrcrv_md_is_Opera(){
	global $detect;
	if($detect->isOpera()) return true;
}


// shortcode for is TV
function azc_md_is_TV_shortcode($atts, $content=null){
	global $detect;
	if ($detect->isTV()) return do_shortcode($content);
}

// function returns true for is TV
function azc_md_is_TV(){
	return azrcrv_md_is_TV();
}
function azrcrv_md_is_TV(){
	global $detect;
	if($detect->isTV()) return true;
}


// shortcode for is WebKit
function azrcrv_md_is_WebKit_shortcode($atts, $content=null){
	global $detect;
	if ($detect->isWebKit()) return do_shortcode($content);
}

// function returns true for is WebKit
function azc_md_is_WebKit(){
	return azrcrv_md_is_WebKit();
}
function azrcrv_md_is_WebKit(){
	global $detect;
	if($detect->isWebKit()) return true;
}


// shortcode for is Console
function azc_md_is_Console_shortcode($atts, $content=null){
	global $detect;
	if ($detect->isConsole()) return do_shortcode($content);
}

// function returns true for is Console
function azc_md_is_Consoleot_mobile(){
	return azrcrv_md_is_Console();
}
function azrcrv_md_is_Console(){
	global $detect;
	if($detect->isConsole()) return true;
}

?>