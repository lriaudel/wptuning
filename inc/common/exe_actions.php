<?php

add_action( 'wptunning_loaded', 'wptunning_exe' );

function wptunning_exe() {

	global $wptunning_settings_name, $wpt_actions;

	$wptunning_settings = get_option( $wptunning_settings_name );

	if( !empty($wptunning_settings) ) {

		foreach( $wptunning_settings as $action => $value ) {

			if( isset($wpt_actions[$action])
				&& isset($wpt_actions[$action]['cb'])
			) {
				switch( $wpt_actions[$action]['type'] ) {
					case 'radio':
					case 'checkbox':
						if( '1' == $value || 'on' == $value ) {
							wpt_action_callback( $wpt_actions[$action]['cb'] );
						}
					break;
					default:
						var_dump( __('WP Tunning: Define a type in your action.') );
					break;
				}

			}

		}

	}

}


function wpt_action_callback( $callback ){
	call_user_func( $callback );
}
