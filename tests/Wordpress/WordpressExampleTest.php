<?php
declare( strict_types=1 );

namespace UniqueRootNamespace\Tests\Wordpress;

use DI\Annotation\Inject;
use UniqueRootNamespace\Tests\ContainerizedTestCase;
use UniqueRootNamespace\Wordpress\Wordpress;

class WordpressExampleTest extends ContainerizedTestCase {

	/**
	 * @Inject()
	 * @var Wordpress $wordpress_example
	 */
	private $wordpress_example;

	public function testHooksAndFilters(): void {
		$has_action = has_action('wp_loaded', [$this->wordpress_example, 'doSomethingToWordpress']);
		self::assertNotFalse($has_action);

		$has_filter = has_action('admin_init', [$this->wordpress_example, 'removeTitle']);
		self::assertNotFalse($has_filter);
	}

}
