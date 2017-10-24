<?php
/**
 * Load the admin JS build file.
 *
 * @package XWP\Admin
 */

namespace XWP\Admin;

/**
 * This file loads the bundled JS file on the admin widgets screen
 *
 * Load the script on the admin widgets screen
 *
 * @package XWP\Admin
 */
class Admin_Js {
	/**
	 * Initializes the custom actions or filters
	 */
	public function init() {
		if ( is_admin() ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_js' ) );
		}
	}

	/**
	 * Load the admin script only on the widgets admin screen
	 * 
	 * @param array $hook
	 */
	public function load_admin_js( $hook ) {
		// Get screen object.
		$screen = get_current_screen();
		if ( 'widgets' === $screen->id ) {
			wp_enqueue_script( 'xwp-admin', plugins_url( '/dist/admin.js', XWP_TEST_PLUGIN_FILE ), array( 'jquery' ), null, true );
		}
	}
}