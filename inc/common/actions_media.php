<?php

function wptunning_add_medium_large() {
	add_filter( 'image_size_names_choose', 'add_medium_large');
}

/**
* Add medium format `medium_large` to media in admin
* This format is by default since version 4.4 but not appear in media
*
* @param array $format Format list
* @return array $format
*/
function add_medium_large( $format ){
	$format['medium_large'] = __('Medium Large');
	return $format;
}



function wptunning_protect_media_filename() {

	add_filter( 'sanitize_file_name', 'remove_accents', 10, 1 );
	add_filter( 'sanitize_file_name_chars', 'sanitize_file_name_chars', 10, 1 );

}

/**
 * No french punctuation and accents for filename
 * Description:  Remove all french punctuation and accents from the filename of upload for client limitation (Safari Mac/IOS)
 * Plugin URI:   https://gist.github.com/herewithme/7704370
 * @version      1.0
 * @author		BeAPI (http://www.beapi.fr)
 */
function sanitize_file_name_chars( $special_chars = array() ) {
	$special_chars = array_merge( array( '’', '‘', '“', '”', '«', '»', '‹', '›', '—', 'æ', 'œ', '€' ), $special_chars );
	return $special_chars;
}
