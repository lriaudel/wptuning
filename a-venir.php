<?php
/**
* Revision setting limited to 5
* @source https://codex.wordpress.org/Revisions
*/
if(!defined('WP_POST_REVISIONS')){
	define('WP_POST_REVISIONS', 5);
}


/**
 * Remove Yoast Bar
 * Plugin URI: https://www.nosegraze.com
 * Description: Removes the Yoast node from the WP Admin Bar.
 * Author: Nose Graze
 * Remove Yoast Node
 * @param WP_Admin_Bar $wp_admin_bar
 * @return void
 */
function remove_yoast_bar( $wp_admin_bar ) {
	$wp_admin_bar->remove_node( 'wpseo-menu' );
}
add_action( 'admin_bar_menu', 'remove_yoast_bar', 99 );




/****
A mettre en place :
https://blog.futtta.be/2017/08/28/no-author-pages/
*/
