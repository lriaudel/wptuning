<?php

add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'wptunning_settings_action_links', 10, 2 );

function wptunning_settings_action_links( $links, $file ) {
	array_unshift( $links, '<a href="' . admin_url( 'options-general.php?page=wptunning-options' ) . '">' . __( 'Settings' ) . '</a>' );
	return $links;
}
