<?php
/**
 * @see http://wpsettingsapi.jeroensormani.com/
 */
add_action( 'admin_menu', 'wptunning_add_admin_menu' );
add_action( 'admin_init', 'wptunning_settings_init' );


function wptunning_add_admin_menu() {

	add_options_page( 'WP Tunning', 'WP Tunning', 'manage_options', 'wp_tunning', 'wptunning_options_page' );

}


function wptunning_settings_init() {

	global $wptunning_settings_name, $wpt_actions, $wpt_sections;

	register_setting( WPT_SLUG, $wptunning_settings_name );

	$section_id = null;

	foreach ( $wpt_actions as $id => $action ) {
		// Setting section
		if ( isset( $action['section'] ) && $action['section'] !== $section_id ) {

			$section_id = $action['section'];
			$section_name = esc_html( $wpt_sections[ $section_id ]['name'] );
			$section_des = esc_html( $wpt_sections[ $section_id ]['description'] );

			add_settings_section(
				WPT_SLUG . '_section_' . $section_id,
				$section_name,
				function() use ($section_des) { echo $section_des; },
				WPT_SLUG
			);

		}

		// Actions / Fiedls
		if ( isset( $action['label'] ) && isset( $action['type'] ) && isset( $action['cb'] ) ) {

			add_settings_field(
				'wptunning_field_' . esc_attr( $id ),
				$action['label'],
				function() use ($id, $action) { wptunning_field_view( $id, $action ); },
				WPT_SLUG,
				WPT_SLUG . '_section_' . $section_id,
				$action['args']
			);

		}

	} // end foreach

}


function wptunning_field_view( $id, $action ) {

	global $wptunning_settings_name;
	$action_option_value = '';

	$options = get_option( $wptunning_settings_name );

	if ( isset( $options[ $id ] ) ) {
		$action_option_value = $options[ $id ];
	}

	switch ( $action['type'] ) {

		case 'text':
			?>
			<input type="text"
				id="<?php echo esc_attr( $id ); ?>"
				name="<?php echo esc_attr( $wptunning_settings_name . '[' . $id . ']' ); ?>"
				value="<?php echo wp_kses( $action_option_value ); ?>"
			>
			<?php
			break;
		default:
			?>
			<input type="checkbox"
				id="<?php echo esc_attr( $id ); ?>"
				name="<?php echo esc_attr( $wptunning_settings_name . '[' . $id . ']' ); ?>"
				<?php checked( $action_option_value, 1 ); ?>
				value="1"
			>
			<?php
			break;
	}

	if ( isset( $action['description'] ) ) {
		echo $action['description'];
	}

}

function wptunning_options_page() {
	?>
	<form action='options.php' method='post'>

		<h1>WP Tunning</h1>

		<p>
			<?php echo __( 'Options to improve WordPress', WPT_LG ); ?>
		</p>
		<?php
		settings_fields( WPT_SLUG );
		do_settings_sections( WPT_SLUG );
		submit_button();
		?>
	</form>
	<?php
}

?>
