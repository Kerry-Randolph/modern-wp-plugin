<?php
declare( strict_types=1 );

namespace UniqueRootNamespace\Wordpress;

use DI\Annotation\Inject;
use WpHookAnnotations\Hooks\HookAware;
use WpHookAnnotations\Hooks\Model\Action;

class EnqueueResources {
	use HookAware; // enables hook annotations

	/**
	 * @Inject("config")
	 * @var array $config
	 */
	private $config;

	/**
	 * Load scripts and styles
	 *
	 * @Action(tag="wp_enqueue_scripts")
	 */
	public function enqueueScripts(): void {

		wp_register_script(
			'modern-wp-plugin',
			$this->config['scripts_url'] . '/modern-wp-plugin.js',
			[ 'jquery-ui-js', 'jquery' ]
		);

		wp_localize_script(
			'modern-wp-plugin',
			'modern_wp_plugin_server_data',
			[
				'disable_wp_title' => $this->config['disable_wp_title']
			]
		);

		wp_enqueue_script( 'modern-wp-plugin' );

		/* jQuery UI */

		wp_enqueue_script(
			'jquery-ui-js',
			'https://code.jquery.com/ui/1.12.0/jquery-ui.min.js',
			//'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.9.2/jquery.ui.datepicker.min.js',
			[ 'jquery' ]
		);

		wp_enqueue_style(
			'jquery-ui-css',
			'https://code.jquery.com/ui/1.12.1/themes/south-street/jquery-ui.css'
		//'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.9.2/themes/base/minified/jquery.ui.datepicker.min.css'
		);

		/* Bootstrap */

		wp_enqueue_style(
			'bootstrap-css',
			'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css'
		);
		wp_enqueue_script(
			'popper',
			'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js',
			[ 'jquery' ]
		);
		wp_enqueue_script(
			'bootstrap-js',
			'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js',
			[ 'jquery', 'popper' ]
		);
	}
}