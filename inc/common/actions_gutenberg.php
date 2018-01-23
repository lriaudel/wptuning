<?php

/**
 * Test if the plugin Gutenberg is actibe
 * @return boolean True if active
 */
function is_active_gutenberg() {

	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

	if ( is_plugin_active( 'gutenberg/gutenberg.php' ) ) {
		return true;
	}

	return false;
}


/**
 * If Gutenberg is deactive, return a css class
 * @return array A css class wptuning_disabled
 */
function wptuning_deactive_post_type_gutenberg_get_class() {
	if ( is_active_gutenberg() ) {
		return array();
	}
	return array( 'class' => 'wptuning_disabled' );
}


/**
 * Specific form for select post type
 * @param  string $id default form id
 * @return void
 */
function wptuning_deactive_post_type_gutenberg_options( $id ) {

	global $wptuning_settings_name;

	$options = get_option( $wptuning_settings_name );

	// Get Post Types
	$post_types = get_post_types( array( 'show_ui' => true ), 'object' );
	unset( $post_types['attachment'] );

	$is_gutenberg = is_active_gutenberg();

	// Hidden field for execution
	?>
	<input type="hidden"
		id="<?php echo $id; ?>"
		name="<?php echo esc_attr( $wptuning_settings_name . '[' . $id . ']' ); ?>"
		checked="checked"
		value="1"
	>
	<?php

	foreach( $post_types as $key => $post_type ) {

		$newid = $id . '-' . esc_attr( $key );
		$action_option_value = isset( $options[ $newid ] ) ? $options[ $newid ] : "";
		?>
		<p>
			<input type="checkbox"
				id="<?php echo $newid; ?>"
				name="<?php echo esc_attr( $wptuning_settings_name . '[' . $newid . ']' ); ?>"
				<?php checked( $action_option_value, 1 ); ?>
				value="1"
				<?php disabled( $is_gutenberg, false ); ?>
			>
			<label for="<?php echo $newid; ?>"
			<?php echo ( !$is_gutenberg ? 'style="color: #bbb;"' : "" ); ?>
			><?php echo $post_type->label ?></label>
		</p>
		<?php
	}
} // end wptuning_deactive_post_type_gutenberg_options


/**
 * Deactivate gutenberg by post type
 * @return void
 */
function wptuning_deactive_post_type_gutenberg() {
	add_filter('gutenberg_can_edit_post_type', 'wptuning_deactive_post_type_gutenberg_action', 10, 2);
}

/**
 * Filter to deactivate gutenberg by post type
 * @param  boolean $can_edit  Value for activate or not
 * @param  string $post_type Post type
 * @return boolean True if active, False if deactive
 */
function wptuning_deactive_post_type_gutenberg_action( $can_edit, $post_type ) {

	global $wptuning_settings_name;

	$options = get_option( $wptuning_settings_name );

	$value = 'deactive_post_type_gutenberg-' . $post_type;

	if( isset( $options[ $value ] ) &&  1 == $options[ $value ] ) {
		$can_edit = false;
	}

	return $can_edit;
}
