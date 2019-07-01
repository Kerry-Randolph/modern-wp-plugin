<?php
declare( strict_types=1 );

/**
 * Modern Wordpress Plugin
 *
 * @package     PluginPackage
 * @author      Kerry Randolph
 *
 * @wordpress-plugin
 * Plugin Name: Modern Wordpress Plugin
 * Description: A boilerplate template plugin to kickstart development using modern techniques
 * Version:     0.0.1
 * Author:      Kerry Randolph
 */

namespace UniqueRootNamespace;

use Exception;
use Psr\Container\ContainerInterface;
use UniqueRootNamespace\Bootstrap\Environment;
use UniqueRootNamespace\Wordpress\Wordpress;

class ModernWpPluginJumpstart {

	/** @var ContainerInterface $container */
	private $container;

	/**
	 * MyModernPlugin constructor.
	 *
	 * @throws Exception
	 */
	public function __construct() {

		require_once 'vendor/autoload.php';

		/*
		 * 'plugins_loaded' callback
		 *
		 * gets the DI container
		 */
		add_action(
			'plugins_loaded',
			[ $this, 'bootstrap' ],
			10, 0
		);

		/*
		 * 'init' callback
		 *
		 * Defer class loading to 'init' action so that
		 * other plugins (probably) load first
		 *
		 * Adjust as needed
		 */
		add_action(
			'init',
			[ $this, 'kickStart' ],
			10, 0
		);
	}

	/**
	 * Get the DI container
	 *
	 * Must be public to function as action callback (i think?)
	 *
	 * @throws Exception
	 */
	public function bootstrap(): void {
		$this->container = Environment::getContainer();
	}

	/**
	 * The entry point into the application proper
	 *
	 * Kick off the plugin
	 */
	public function kickStart(): void {
		$this->container->get( Wordpress::class );
	}
}

new ModernWpPluginJumpstart();