<?php
declare( strict_types=1 );

namespace UniqueRootNamespace\Tests;

use DI\Container;
use Exception;
use UniqueRootNamespace\Bootstrap\Environment;
use WP_UnitTestCase;

class ContainerizedTestCase extends WP_UnitTestCase {
//class ContainerizedTestCase extends TestCase {

	/** @var Container $container */
	protected $di_container;

	/**
	 * Gets DI container and injects on $this
	 *
	 * "Before a test method is run, a template method called setUp() is invoked.
	 * setUp() is where you create the objects against which you will test"
	 * https://phpunit.readthedocs.io/en/8.2/fixtures.html#more-setup-than-teardown
	 *
	 * @throws Exception
	 */
	public function setUp(): void {

		if ( null === $this->di_container ) {
			$this->di_container = Environment::getContainer();
		}

		$this->di_container->injectOn( $this );
	}
}