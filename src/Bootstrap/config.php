<?php
declare( strict_types=1 );

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface as C;
use Psr\Log\LoggerInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/* PHP-DI definitions. See http://php-di.org/doc/php-definitions.html */

return [
	'config'                     => static function ( C $c ) {

		/* Start config options */
		$debug            = true; // Set false in prod for improved performance
		$log_path         = '/logs/modern-wp-plugin.log'; // relative to plugin root
		$api_url          = 'http://localhost/api'; // REST API URL
		$title            = 'Modern WP Plugin';
		$disable_wp_title = true; // Disables/hides the native Wordpress page title
		// instead of manually setting site address, we *could* get it from wp_options
		$url_scheme   = 'https';
		$site_address = $url_scheme . '://modern-wp-plugin-jumpstart.lndo.site';
		$scripts      = $site_address . '/wp-content/plugins/modern-wp-plugin/scripts';
		/* End config options */

		$base = $c->get( 'plugin_root' );

		return [
			'log_path'         => $base . $log_path,
			'log_level'        => $debug ? 'Monolog\\Logger::Debug' : 'Monolog\\Logger::Error',
			'api_url'          => $api_url,
			'debug'            => $debug,
			'endpoints'        => [
				'widgets'       => $api_url . '/widgets',
				'widget_prices' => $api_url . '/widget/prices'
			],
			'title'            => $title,
			'disable_wp_title' => $disable_wp_title,
			'scripts_url'      => $scripts
		];
	},
	'plugin_root'                => static function () {
		return dirname( __DIR__, 2 ); // no trailing slash (unless root)
	},
	// Guzzle config
	GuzzleClientInterface::class => static function ( C $c ) {
		$api_url = $c->get( 'config' )['api_url'];

		return new GuzzleClient( [
			'base_uri' => $api_url, // Base URI is used with relative requests
			'timeout'  => 4.0,
		] );
	},
	// Twig config
	Environment::class           => static function ( C $c ) {
		$base   = $c->get( 'plugin_root' );
		$loader = new FilesystemLoader( $base . '/templates' );
		$debug  = $c->get( 'config' )['debug'];

		return new Environment( $loader, [
			'cache' => $base . '/cache/twig_cache',
			'debug' => $debug
		] );
	},
	// PSR-3 LoggerInterface
	LoggerInterface::class       => static function ( C $c ) {
		$logger      = new Logger( 'modern-wp-plugin' );
		$fileHandler = new StreamHandler(
			$c->get( 'config' )['log_path'],
			$c->get( 'config' )['log_level']
		);
		$fileHandler->setFormatter( new LineFormatter() );
		$logger->pushHandler( $fileHandler );

		return $logger;
	}
];