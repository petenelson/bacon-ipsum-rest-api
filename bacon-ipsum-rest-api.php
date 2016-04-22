<?php
/**
 * Plugin Name: Bacon Ipsum REST API
 * Version: 1.0.0
 * Description: Endooint for baconipsum.com
 * Author: Pete Nelson
 * Author URI: https://baconipsum.com
 * Plugin URI: https://baconipsum.com
 * Text Domain: bacon-ipsum-rest-api
 * Domain Path: /languages
 * @package bacon-ipsum-rest-api
 */

if ( ! defined( 'BACON_IPSUM_REST_API_ROOT' ) ) {
	define( 'BACON_IPSUM_REST_API_ROOT', trailingslashit( dirname( __FILE__ ) ) );
}

require_once BACON_IPSUM_REST_API_ROOT . 'includes/class-bacon-ipsum-rest-api.php';

add_action( 'plugins_loaded', function() {
	Bacon_Ipsum_REST_API::plugins_loaded();
} );
