<?php
/**
 * Load the public JS build file.
 *
 * @package XWP\Pub
 */

namespace XWP\Pub;

/**
 * This file loads the public facing bundled JS file for the widget
 *
 * Load the public facing script for the widget
 *
 * @package XWP\Pub
 */
class Public_Js {
	/**
	 * Initializes the custom actions or filters
	 */
	public function init() {
		add_action( 'wp_enqueue_scripts', array( $this, 'load_public_js' ) );
		// Only load if multisite
		$widgets_options = get_option( 'widget_stats-widget' );
		if ( $widgets_options && is_multisite() ) {
			foreach ( $widgets_options as $option ) {
				if ( true === $option['multisite_stats'] ) {
					add_action( 'wp_ajax_subdomains_action', array( $this, 'subdomains_action' ) );
					add_action( 'wp_ajax_nopriv_subdomains_action', array( $this, 'subdomains_action' ) );
				}
			}
		}
	}

	/**
	 * Load the public script and localize the file
	 */
	public function load_public_js() {
		// Only load if multisite
		$widgets_options = get_option( 'widget_stats-widget' );
		if ( $widgets_options && is_multisite() ) {
			foreach ( $widgets_options as $option ) {
				if ( true === $option['multisite_stats'] ) {
					$public_array =
					array(
						'api_nonce'           => wp_create_nonce( 'wp_rest' ),
						'api_url'             => site_url( '/wp-json/xwp-test/v2/' ),
						'ajax_url'            => admin_url( 'admin-ajax.php' ),s
					);
				} else if ( false === $option['multisite_stats'] ) {
					$public_array =
					array(
						'api_nonce' => wp_create_nonce( 'wp_rest' ),
						'api_url'   => site_url( '/wp-json/xwp-test/v2/' ),
					);
				}
			}
		} else {
			$public_array =
			array(
				'api_nonce' => wp_create_nonce( 'wp_rest' ),
				'api_url'   => site_url( '/wp-json/xwp-test/v2/' ),
			);
		}
		// Only load if the widget is active
		if ( is_active_widget( false, false, 'stats-widget' ) ) {
			wp_enqueue_script( 'xwp-public', plugins_url( '/dist/public.js', XWP_TEST_PLUGIN_FILE ), array( 'jquery' ), null, true );
			wp_localize_script( 'xwp-public', 'rest_object',
				$public_array
			);
		}
	}

	/**
	 * Get stats for the subdomains if it is multisite and multisite__stats is enabled
	 */
	public function subdomains_action() {
		$sites = get_sites();
		foreach ( $sites as $site ) {
			$path  = $site->path;
			if ( '/' !== $path ) {
				switch_to_blog( $site->blog_id );
				$sites_array[] = array( 
					'total_posts'    => (int) wp_count_posts( 'post' )->publish,
					'total_users'    => (int) count_users()['total_users'],
					'total_comments' => (int) wp_count_comments()->total_comments,
				);
				restore_current_blog();
			}	
		}
		//Make sure to json encode the output because that's what it is expecting
		echo json_encode( $sites_array );
		wp_die();
	}
}