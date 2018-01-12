<?php
/**
 * @see http://wpsettingsapi.jeroensormani.com/
 */
add_action( 'admin_menu', 'wptuning_add_admin_menu' );
add_action( 'admin_init', 'wptuning_settings_init' );
add_action( 'admin_enqueue_scripts', 'wptuning_enqueue_script' );

function wptuning_enqueue_script() {
	global $pagenow;

	if ( 'options-general.php' == $pagenow && WPT_PAGE_SLUG == $_GET['page'] ) {
		wp_register_script( 'wptuning-admin', WPT_URL . 'assets/js/admin.js', 'jquery' );
		wp_enqueue_script( 'wptuning-admin' );
	}
}

function wptuning_add_admin_menu() {

	add_options_page( 'WP Tuning', 'WP Tuning', 'manage_options', WPT_PAGE_SLUG, 'wptuning_options_page' );

}


function wptuning_settings_init() {

	global $wptuning_settings_name, $wpt_actions, $wpt_sections;

	register_setting( WPT_SLUG, $wptuning_settings_name );

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
				'wptuning_field_' . esc_attr( $id ),
				$action['label'],
				function() use ($id, $action) { wptuning_field_view( $id, $action ); },
				WPT_SLUG,
				WPT_SLUG . '_section_' . $section_id,
				$action['args']
			);

		}

	} // end foreach

}


function wptuning_field_view( $id, $action ) {

	global $wptuning_settings_name;
	$action_option_value = '';

	$options = get_option( $wptuning_settings_name );

	$default = '';
	if ( isset( $action['default'] ) ) {
		$default = $action['default'];
	}

	if ( isset( $options[ $id ] ) ) {
		$action_option_value = $options[ $id ];
	}

	switch ( $action['type'] ) {

		case 'text':
			?>
			<input type="text"
				id="<?php echo esc_attr( $id ); ?>"
				data-default="<?php echo esc_attr( $default ); ?>"
				name="<?php echo esc_attr( $wptuning_settings_name . '[' . $id . ']' ); ?>"
				value="<?php echo wp_kses( $action_option_value , array() ); ?>"
			>
			<?php
			break;
		default:
			?>
			<input type="checkbox"
				id="<?php echo esc_attr( $id ); ?>"
				data-default="<?php echo esc_attr( $default ); ?>"
				name="<?php echo esc_attr( $wptuning_settings_name . '[' . $id . ']' ); ?>"
				<?php checked( $action_option_value, 1 ); ?>
				value="1"
			>
			<?php
			break;
	}

	if ( isset( $action['description'] ) ) {
		echo $action['description'];
	}

} // end wptuning_field_view


function wptuning_options_page() {
	?>
	<form action='options.php' method='post'>

		<h1>WP Tuning</h1>
		<p>
			<?php echo __( 'Options to improve WordPress', WPT_LG ); ?>
		</p>
		<p>
			<button type="button" id="wptunning-default-button" class="button-secondary">
				<?php _e('Set to default setting', WPT_LG) ?>
			</button>
			&nbsp;
			<?php submit_button( '', 'primary', 'submit', false ); ?>
		</p>
		<?php
		settings_fields( WPT_SLUG );
		do_settings_sections( WPT_SLUG );
		submit_button();
		?>
	</form>
	<?php
} // end wptuning_options_page

?>
