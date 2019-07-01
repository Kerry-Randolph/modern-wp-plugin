<?php

/* If wp test framework loads the plugin, maybe we can delete this */
//require_once dirname(__DIR__) . '/vendor/autoload.php';
//\UniqueRootNamespace\Bootstrap\Environment::prepare();

/**
 * PHPUnit bootstrap file
 *
 * @package My_Plugin
 */

/*$_tests_dir = getenv( 'WP_TESTS_DIR' );

if ( ! $_tests_dir ) {
	$_tests_dir = rtrim( sys_get_temp_dir(), '/\\' ) . '/wordpress-tests-lib';
}*/

$_tests_dir = dirname(__DIR__) . '/wordpress-tests-lib';

if ( ! file_exists( $_tests_dir . '/includes/functions.php' ) ) {
	echo "Could not find $_tests_dir/includes/functions.php, have you run bin/install-wp-tests.sh ?" . PHP_EOL; // WPCS: XSS ok.
	exit( 1 );
}

// Give access to tests_add_filter() function.
require_once $_tests_dir . '/includes/functions.php';

/**
 * Manually load the plugin being tested.
 */
function _manually_load_plugin() {
	require dirname(__DIR__ ) . '/modern-wp-plugin-jumpstart.php';
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

// Start up the WP testing environment.
require $_tests_dir . '/includes/bootstrap.php';
