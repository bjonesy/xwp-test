<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the
 * plugin admin area. This file also includes all of the dependencies used by
 * the plugin, and defines a function that starts the plugin.
 *
 * @since              1.0.0
 * @package            XWP
 *
 * @wordpress-plugin
 * Plugin Name:        XWP Test
 * Description:        A frontend widget that shows stats about a site and its subdomains.
 * Version:            1.0.0
 * Author:             Brandon Jones
 * Author URI:         https://brandonsj.me/
 * License:            GPL-2.0+
 * License URI:        http://www.gnu.org/licenses/gpl-2.0.txt
 */

namespace XWP;

use XWP\Admin;
use XWP\Pub;
use XWP\Lib;

// Plugin file path.
define( 'XWP_TEST_PLUGIN_FILE', __FILE__ );

// This file can't be accessed directly.
defined( 'WPINC' ) || die;

// Load the autoloader.
include_once( __DIR__ . '/lib/autoloader.php' );

// Load the custom widget
include_once( __DIR__ . '/admin/class-stats-widget.php' );

add_action( 'init', __NAMESPACE__ . '\\xwp_test_start' );
/**
 * Starts the plugin by instantiating each of the classes (which is
 * included via the autoloader).
 */
function xwp_test_start() {
	/**
	 * Add custom endpoint to WP API
	 */
	$custom_endpoint = new Lib\Endpoints();
	$custom_endpoint->init();

	/**
	 * Load the bundled admin facing js file
	 */
	$admin_js = new Admin\Admin_Js();
	$admin_js->init();

	/**
	 * Load the bundled public facing js file
	 */
	$public_js = new Pub\Public_Js();
	$public_js->init();
}