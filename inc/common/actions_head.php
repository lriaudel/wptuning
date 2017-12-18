<?php
/**
 * Head cleaning
 */
function wptuning_wp_generator() {
	remove_action( 'wp_head', 'wp_generator' );					// Deactivate WordPress version
}
function wptuning_wlwmanifest_link() {
	remove_action( 'wp_head', 'wlwmanifest_link' );				// Deactivate Windows Live Writer Manifest Link
}
/** A voir */
function wptuning_rsd_link() {
	remove_action( 'wp_head', 'rsd_link' );						// Deactivate RSD
}
function wptuning_xmlrpc_enabled() {
	add_filter( 'xmlrpc_enabled', '__return_false' );			// Deactivate XML-RPC
}
/**/
function wptuning_xmlrpc_enabled_rsd() {
	remove_action( 'wp_head', 'rsd_link' );
	add_filter( 'xmlrpc_enabled', '__return_false' );			// Deactivate XML-RPC
}

function wptuning_feed_link() {
	add_filter( 'feed_links_show_posts_feed', '__return_false' );// Supprime le flux RSS général
}
function wptuning_comments_feed() {
	add_filter( 'feed_links_show_comments_feed', '__return_false' );// Supprime le flux RSS des catégories
}
function wptuning_start_post_rel_link() {
	remove_action( 'wp_head', 'start_post_rel_link' );			// Supprime le lien vers le premier post
}
function wptuning_wp_shortlink_wp_head() {
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );			// Supprime la balise lien court <link rel=shortlink
}
function wptuning_index_rel_link() {
	remove_action( 'wp_head', 'index_rel_link' );					// Supprime la balise <link rel=index
}
function wptuning_parent_post_rel_link() {
	remove_action( 'wp_head', 'parent_post_rel_link' );			// Supprime le lien vers la catégorie parente
}
