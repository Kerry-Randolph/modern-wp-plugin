<?php
declare( strict_types=1 );

namespace UniqueRootNamespace\Wordpress;

use WpHookAnnotations\Hooks\HookAware;

class Wordpress {
	use HookAware;

	private $logger;

	/**
	 * This class is the entry point to our plugin
	 *
	 * So we would normally probably have DI load other dependencies here
	 * And it would keep branching from there
	 *
	 * @param ModernWpShortcode $modern_wp_shortcode
	 * @param EnqueueResources  $enqueue_resources
	 */
	public function __construct(
		ModernWpShortcode $modern_wp_shortcode,
		EnqueueResources $enqueue_resources
	) {
	}
}