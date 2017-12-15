<?php
/**
 * Plugin Name: WP Tunning
 * Plugin URI: https://codetheworld.info
 * Description: Differents hooks and functions to improve WordPress and basic customization in a plugin.
 * Version: 1.0
 * Author: lriaudel
 * Contributors:
 * Tested up to: 4.9
 * Requires PHP: 5.4+
 * Author URI: http://ludovic.riaudel.net
 * Licence: GPLv2
 *
 * Copyright 2013-2017 Ludovic Riaudel
 * */

defined( 'ABSPATH' ) || die( 'O.o' );

/**
 * Constants
 */
define( 'WPT_VERSION', '1.0' );
define( 'WPT_DIR', dirname(__FILE__) );
define( 'WPT_SLUG', 'wptunning-options' );
define( 'WPT_LG', 'wptunning' );

global $wptunning_settings_name;
$wptunning_settings_name = 'wptunning_settings';

/**
 * Tell WP what to do when plugin is loaded.
 */
add_action( 'plugins_loaded', 'wptunning_init' );

function wptunning_init() {

	include WPT_DIR . '/inc/common/wpt_actions.php';
	include WPT_DIR . '/inc/common/wpt_sections.php';

	global $wpt_sections;

	foreach( $wpt_sections as $section ) {
		include $section['file'];
	}

	if ( is_admin() ) {
		include WPT_DIR . '/inc/admin/options-page.php';
		include WPT_DIR . '/inc/admin/plugins.php';
	}

	include WPT_DIR . '/inc/common/exe_actions.php';

	/**
	* Fires when WP-Tunning is correctly loaded.
	*/
	do_action( 'wptunning_loaded' );
}
