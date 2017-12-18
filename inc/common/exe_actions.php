<?php

/**
 * Execute all configured actions
 */
add_action( 'wptuning_loaded', 'wptuning_exe' );

function wptuning_exe() {

	global $wptuning_settings_name, $wpt_actions;

	$wptuning_settings = get_option( $wptuning_settings_name );

	if ( !empty( $wptuning_settings ) ) {

		foreach( $wptuning_settings as $action => $value ) {

			if ( isset( $wpt_actions[$action] )
				&& isset( $wpt_actions[$action]['cb'] )
			) {
				switch ( $wpt_actions[$action]['type'] ) {

					case 'text':

							wpt_action_callback( $wpt_actions[$action]['cb'] );

						break;

					case 'radio':
					case 'checkbox':

						if ( '1' == $value || 'on' == $value ) {
							wpt_action_callback( $wpt_actions[$action]['cb'] );
						}

						break;

					default:
						var_dump( __( 'WP Tuning: Define a type in your action.' ) );
						break;

				}

			}

		}

	}

} // end wptuning_exe


function wpt_action_callback( $callback ){
	call_user_func( $callback );
}
