<?php

/**
 * Allow SVG files 
 * @since	1.3.0
 */ 
function wptuning_add_svg_mime_types() {
	add_filter('upload_mimes', 'add_svg_mime_types');

	add_filter('wp_check_filetype_and_ext', 'wptuning_upload_check', 10, 4);
	add_action('wp_AJAX_svg_get_attachment_url', 'wptuning_display_svg_files_backend');
	add_filter('wp_prepare_attachment_for_js', 'wptuning_display_svg_media', 10, 3);
	add_action('admin_head', 'wptuning_svg_styles');
}

/**
 * Add SVG mime types
 */
function add_svg_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	$mimes['svgz'] = 'image/svg+xml';
	return $mimes;
}

/**
 * Different hook for have a correct display in media library
 * 
 * @source https://wordpress.org/plugins/easy-svg/
 */

 /**
  * Uploading SVG Files into the Media Libary
  */
function wptuning_upload_check($checked, $file, $filename, $mimes){

	if(!$checked['type']){

		$esw_upload_check = wp_check_filetype( $filename, $mimes );
		$ext              = $esw_upload_check['ext'];
		$type             = $esw_upload_check['type'];
		$proper_filename  = $filename;

		if($type && 0 === strpos($type, 'image/') && $ext !== 'svg'){
			$ext = $type = false;
		}

		// Check the filename
		$checked = compact('ext','type','proper_filename');
	}

	return $checked;

}
   
/**
 * Display SVG Files in Backend
 */
function wptuning_display_svg_files_backend() {

	$url = '';
	$attachmentID = isset($_REQUEST['attachmentID']) ? $_REQUEST['attachmentID'] : '';

	if($attachmentID){
		$url = wp_get_attachment_url($attachmentID);
	}
	echo $url;

	die();
}
   
/**
 * Media Libary  Display SVG
 */
function wptuning_display_svg_media($response, $attachment, $meta) {

	if( $response['type'] === 'image' && $response['subtype'] === 'svg+xml' && class_exists('SimpleXMLElement') ) {
		try {
			
			$path = get_attached_file($attachment->ID);

			if(@file_exists($path)){
				$svg                = new SimpleXMLElement(@file_get_contents($path));
				$src                = $response['url'];
				$width              = (int) $svg['width'];
				$height             = (int) $svg['height'];
				$response['image']  = compact( 'src', 'width', 'height' );
				$response['thumb']  = compact( 'src', 'width', 'height' );

				$response['sizes']['full'] = array(
					'height'        => $height,
					'width'         => $width,
					'url'           => $src,
					'orientation'   => $height > $width ? 'portrait' : 'landscape',
				);
			}
		}
		catch(Exception $e){}
	}

	return $response;
}

/**
 * Load CSS in Admin Header Styles
 */
function wptuning_svg_styles() {
	echo "<style>
			/* Media LIB */
			table.media .column-title .media-icon img[src*='.svg'] {
				width: 100%;
				height: auto;
			}

			/* Gutenberg Support */
			.components-responsive-wrapper__content[src*='.svg'] {
				position: relative;
			}

		</style>";
}

?>