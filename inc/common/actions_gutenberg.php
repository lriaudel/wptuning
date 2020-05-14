<?php


/**
 * Disable Block Editor default FullScreen mode in WordPress 5.4
 * @source https://jeanbaptisteaudras.com/en/2020/03/disable-block-editor-default-fullscreen-mode-in-wordpress-5-4/
 * @return void
 */
function jba_disable_editor_fullscreen_by_default() {
	$script = "window.onload = function() { const isFullscreenMode = wp.data.select( 'core/edit-post' ).isFeatureActive( 'fullscreenMode' ); if ( isFullscreenMode ) { wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'fullscreenMode' ); } }";
	wp_add_inline_script( 'wp-blocks', $script );
}

function wptuning_disable_editor_fullscreen() {
	add_action( 'enqueue_block_editor_assets', 'jba_disable_editor_fullscreen_by_default' );
}


