<?php

/*========================= emoji ============================= */

/**
 * Disable the emoji's
 * @see https://www.keycdn.com/blog/website-performance-optimization/#http
 * @see https://fr.wordpress.org/plugins/disable-emojis/
 * @return void
 */
function wptuning_disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
	add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}

/**
 * Filter function used to remove the tinymce emoji plugin.
 *
 * @param    array  $plugins
 * @return   array  Difference betwen the two arrays
 */
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 *
 * @param  array  $urls          URLs to print for resource hints.
 * @param  string $relation_type The relation type the URLs are printed for.
 * @return array                 Difference betwen the two arrays.
 */
function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
	if ( 'dns-prefetch' == $relation_type ) {
		// Strip out any URLs referencing the WordPress.org emoji location
		$emoji_svg_url_bit = 'https://s.w.org/images/core/emoji/';
		foreach ( $urls as $key => $url ) {
			if ( strpos( $url, $emoji_svg_url_bit ) !== false ) {
				unset( $urls[$key] );
			}
		}

	}
	return $urls;
}
/*========================= end emoji ============================= */


function wptuning_remove_default_dashboard_widgets() {
	add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );
}

/**
* Dashboard cleaning
* Deactivate useless metaboxes on dashboard
*/
function remove_dashboard_widgets() {

	remove_action('welcome_panel', 'wp_welcome_panel',99);				// Remove Welcome panel
	//remove_meta_box('dashboard_right_now', 'dashboard', 'normal');	// Remove "At a Glance"
	remove_meta_box('dashboard_activity', 'dashboard', 'normal');		// Remove "Activity" which includes "Recent Comments"
	remove_meta_box('dashboard_quick_press', 'dashboard', 'side');		// Remove Quick Draft
	remove_meta_box('dashboard_primary', 'dashboard', 'side');			// Remove WordPress Events and News

}


/**
 * Deactivate file editor for plugins and themes in wp-admin
 */
function wptuning_disallow_file_edit() {
	if ( !defined('DISALLOW_FILE_EDIT') ) {
		define('DISALLOW_FILE_EDIT', true);
	}
}


function wptuning_deactivate_H1() {
	add_filter( 'tiny_mce_before_init', 'modify_editor_buttons' );
}

/**
 * Remove H1 from the WordPress editor.
 * H1 is only for page titles
 *
 * @param   array  $init   The array of editor settings
 * @return  array		 	The modified edit settings
 */
function modify_editor_buttons( $init ) {
	$init['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;Preformatted=pre;';
	return $init;
}


function wptuning_define_post_revision() {

	global $wptuning_settings_name, $wpt_actions;

	$wptuning_settings = get_option( $wptuning_settings_name );

	$post_revision_nb = $wptuning_settings['define_post_revision'];

	if( '' === $post_revision_nb ){
		return;
	}
	else{
		$post_revision_nb = (int) $post_revision_nb;
	}

	add_filter( 'wp_revisions_to_keep', function() use ($post_revision_nb) {
		return $post_revision_nb;
	}, 10, 2 );

}
