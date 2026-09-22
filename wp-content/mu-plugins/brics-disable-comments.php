<?php
/**
 * Disable public comments and comment notification emails for BRICS India.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'comments_open', '__return_false', 20 );
add_filter( 'pings_open', '__return_false', 20 );
add_filter( 'notify_moderator', '__return_false', 20 );
add_filter( 'notify_post_author', '__return_false', 20 );
add_filter( 'pre_option_comments_notify', '__return_zero', 20 );
add_filter( 'pre_option_moderation_notify', '__return_zero', 20 );
add_filter( 'xmlrpc_enabled', '__return_false', 20 );

add_filter(
	'comments_array',
	function () {
		return array();
	},
	20
);

add_filter(
	'pre_option_default_comment_status',
	function () {
		return 'closed';
	},
	20
);

add_filter(
	'pre_option_default_ping_status',
	function () {
		return 'closed';
	},
	20
);

add_action(
	'pre_comment_on_post',
	function () {
		wp_die( 'Comments are closed.', 'Comments closed', array( 'response' => 403 ) );
	},
	0
);

add_filter(
	'rest_pre_insert_comment',
	function () {
		return new WP_Error( 'comments_closed', 'Comments are closed.', array( 'status' => 403 ) );
	},
	0
);

add_filter(
	'xmlrpc_methods',
	function ( $methods ) {
		unset(
			$methods['wp.newComment'],
			$methods['wp.editComment'],
			$methods['wp.deleteComment'],
			$methods['wp.getComments'],
			$methods['pingback.ping'],
			$methods['pingback.extensions.getPingbacks']
		);

		return $methods;
	},
	20
);

add_action(
	'init',
	function () {
		remove_action( 'wp_head', 'feed_links_extra', 3 );
		remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );
		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wlwmanifest_link' );
	},
	1
);

add_action(
	'wp',
	function () {
		if ( is_comment_feed() ) {
			wp_die( 'Comments are closed.', 'Comments closed', array( 'response' => 403 ) );
		}
	}
);

add_action(
	'init',
	function () {
		if ( get_option( 'brics_comments_disabled_applied' ) ) {
			return;
		}

		update_option( 'default_comment_status', 'closed' );
		update_option( 'default_ping_status', 'closed' );
		update_option( 'comments_notify', '0' );
		update_option( 'moderation_notify', '0' );

		global $wpdb;

		$wpdb->query(
			"UPDATE {$wpdb->posts}
			SET comment_status = 'closed', ping_status = 'closed'
			WHERE comment_status <> 'closed' OR ping_status <> 'closed'"
		);

		update_option( 'brics_comments_disabled_applied', time() );
	},
	20
);

add_action(
	'admin_init',
	function () {
		$post_types = get_post_types();

		foreach ( $post_types as $post_type ) {
			remove_post_type_support( $post_type, 'comments' );
			remove_post_type_support( $post_type, 'trackbacks' );
		}
	},
	20
);
