<?php
global $wpt_sections;

/**
 * All sections list
 * @var array
 */
$wpt_sections = array(
	'security'	=> array(
		'name'			=> __( 'Security', WPT_LG ),
		'description'	=> __( '', WPT_LG ),
		'file'			=> WPT_DIR . '/inc/common/actions_security.php',
	),
	'media'	=> array(
		'name'			=> __( 'Media', WPT_LG ),
		'description'	=> __( '', WPT_LG ),
		'file'			=> WPT_DIR . '/inc/common/actions_media.php',
	),
	'misc'	=> array(
		'name'			=> __( 'Misc', WPT_LG ),
		'description'	=> __( '', WPT_LG ),
		'file'			=> WPT_DIR . '/inc/common/actions_misc.php',
	),
	'head'	=> array(
		'name'			=> __( 'Head', WPT_LG ),
		'description'	=> __( '', WPT_LG ),
		'file'			=> WPT_DIR . '/inc/common/actions_head.php',
	),
);
