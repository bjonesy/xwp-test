<?php
/**
 * Display the JSON data to a specified URL using the WordPress API.
 *
 * @package XWP\Lib
 */

namespace XWP\Lib;

/**
 * This file adds a custom API endpoint to the WordPress API
 *
 * Registers custom API endpoints
 *
 * @package XWP\Lib
 */
class Endpoints {

	/**
	 * Register the custom routes
	 */
	public function init() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	/**
	 * Add a custom API endpoint based on the {post-type} taxonomy term
	 */
	public function register_routes() {
		// Total posts.
		register_rest_route(
			'xwp-test/v2', '/total-posts', array(
				'methods'  => 'GET',
				'callback' => array( $this, 'total_posts' ),
			)
		);
		// Total users.
		register_rest_route(
			'xwp-test/v2', '/total-users', array(
				'methods'  => 'GET',
				'callback' => array( $this, 'total_users' ),
			)
		);
		// Total comments.
		register_rest_route(
			'xwp-test/v2', '/total-comments', array(
				'methods'  => 'GET',
				'callback' => array( $this, 'total_comments' ),
			)
		);
	}

	/**
	 * Return total number of posts
	 *
	 * @return int
	 */
	public function total_posts() {
		return wp_count_posts( 'post' )->publish;
	}

	/**
	 * Return total number of users
	 *
	 * @return int
	 */
	public function total_users() {
		return count_users();
	}

	/**
	 * Return total number of comments
	 *
	 * @return int
	 */
	public function total_comments() {
		return wp_count_comments();
	}

}