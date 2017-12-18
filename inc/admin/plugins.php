<?php

/**
 * Add a 'Setting' link on plugin page
 */
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'wptuning_settings_action_links', 10, 2 );

function wptuning_settings_action_links( $links, $file ) {
	array_unshift( $links, '<a href="' . admin_url( 'options-general.php?page=wptuning-options' ) . '">' . __( 'Settings' ) . '</a>' );
	return $links;
}
