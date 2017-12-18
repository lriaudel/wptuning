<?php

function wptuning_add_medium_large() {
	add_filter( 'image_size_names_choose', 'add_medium_large' );
}

/**
* Add medium format `medium_large` to media in admin
* This format is by default since version 4.4 but not appear in media
*
* @param array $format Format list
* @return array $format
*/
function add_medium_large( $format ){
	$format['medium_large'] = __( 'Medium Large' );
	return $format;
}


/**
 * BEA Sanitize filename
 * No french punctuation and accents for filename
 * Description:  Remove all french punctuation and accents from the filename of upload for client limitation (Safari Mac/IOS)
 * Plugin URI:   https://github.com/BeAPI/bea-sanitize-filename
 * @version      1.0.2
 * @author		BeAPI (http://www.beapi.fr)
 */
function wptuning_protect_media_filename() {

	add_filter( 'sanitize_file_name', 'bea_sanitize_file_name', 10, 1 );
	add_filter( 'sanitize_file_name_chars', 'bea_sanitize_file_name_chars', 10, 1 );

}

function bea_sanitize_file_name_chars( $special_chars = array() ) {
	$special_chars = array_merge( array( '’', '‘', '“', '”', '«', '»', '‹', '›', '—', '€' ), $special_chars );
	return $special_chars;
}

 /**
 * Filters the filename by adding more rules :
 * - only lowercase
 * - replace _ by -
 * @since 1.0.1
 * @param string $file_name
 * @return string
 */
function bea_sanitize_file_name( $file_name ) {
	preg_match( '/\.[^\.]+$/i', $file_name, $ext );
	$ext = $ext[0];
	$file_name = str_replace( $ext, '', $file_name );
	$file_name = sanitize_title( $file_name );
	$file_name = str_replace( '_', '-', $file_name );
	return $file_name . $ext;
}
