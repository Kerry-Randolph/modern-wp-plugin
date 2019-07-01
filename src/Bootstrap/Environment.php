<?php
declare( strict_types=1 );

namespace UniqueRootNamespace\Bootstrap;

use DI\Container;
use DI\ContainerBuilder;
use Exception;

/**
 * Class Environment (Singleton pattern)
 *
 * Builds DI container from definitions in config.php
 * Singletons can be abused, but I think for DI bootstrap it's legitimate
 * https://blog.cotten.io/how-to-screw-up-singletons-in-php-3e8c83b63189
 *
 */
class Environment {

	private static $container;

	/**
	 * Get the DI Container
	 *
	 * Singleton pattern
	 *
	 * @return Container
	 * @throws Exception
	 */
	public static function getContainer(): Container {
		if ( null === static::$container ) {
			static::$container = static::initializeContainer();
		}

		return static::$container;
	}

	/**
	 * Bootstrap DI container
	 *
	 * Builds DI container
	 *
	 * @return Container
	 * @throws Exception
	 */
	private static function initializeContainer(): Container {
		$builder = new ContainerBuilder;
		$builder->useAnnotations( true );
		$builder->addDefinitions( __DIR__ . '/config.php' );
		$container = $builder->build();

		return $container;
	}
}