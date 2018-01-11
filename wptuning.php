<?php
/**
 * Plugin Name: WP Tuning
 * Plugin URI: https://codetheworld.info
 * Description: Differents hooks and functions to improve WordPress and basic customization in a plugin.
 * Version: 1.01
 * Author: lriaudel
 * Text Domain: wptuning
 * Domain Path: /languages/
 * Contributors:
 * GitHub Plugin URI: https://github.com/lriaudel/wp-tuning
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
define( 'WPT_VERSION', '1.01' );
define( 'WPT_DIR', dirname( __FILE__ ) );
define( 'WPT_URL', plugin_dir_url( __FILE__ ) );
define( 'WPT_SLUG', 'wptuning_settings' );
define( 'WPT_LG', 'wptuning' );
define( 'WPT_PAGE_SLUG', 'wptuning' );


/**
 * Global variables
 */
/**
 * [global description]
 * @var string
 */
global $wptuning_settings_name;
$wptuning_settings_name = 'wptuning_settings';

/**
 * All actions list
 * @var array
 */
global $wpt_actions;

/**
 * All sections list
 * @var array
 */
global $wpt_sections;


/**
 * Tell WP what to do when plugin is loaded.
 */
add_action( 'plugins_loaded', 'wptuning_init' );

function wptuning_init() {

	include WPT_DIR . '/inc/common/wpt_actions.php';
	include WPT_DIR . '/inc/common/wpt_sections.php';

	global $wpt_sections;

	foreach ( $wpt_sections as $section ) {
		include $section['file'];
	}

	if ( is_admin() ) {
		include WPT_DIR . '/inc/admin/options-page.php';
		include WPT_DIR . '/inc/admin/plugins.php';
	}

	include WPT_DIR . '/inc/common/exe_actions.php';

	/**
	* Fires when WP-Tuning is correctly loaded.
	*/
	do_action( 'wptuning_loaded' );
}
