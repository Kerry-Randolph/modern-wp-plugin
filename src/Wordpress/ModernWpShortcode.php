<?php
declare( strict_types=1 );

namespace UniqueRootNamespace\Wordpress;

use DI\Annotation\Inject;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use UniqueRootNamespace\Services\Http;
use WpHookAnnotations\Hooks\HookAware;
use WpHookAnnotations\Hooks\Model\Shortcode;

class ModernWpShortcode {
	use HookAware;

	/**
	 * @var Environment
	 */
	private $twig;
	/**
	 * @Inject("config")
	 * @var array $config
	 */
	private $config;
	/**
	 * @var Http
	 */
	private $http;

	/**
	 * Shortcode constructor.
	 *
	 * @param Environment $twig
	 * @param Http        $http
	 */
	public function __construct(
		Environment $twig,
		Http $http
	) {
		$this->twig = $twig;
		$this->http = $http;
	}

	/**
	 * Enables [modern-wp-plugin] shortcode for use in Wordpress
	 *
	 * @Shortcode(tag="modern-wp-plugin")
	 *
	 * @return string
	 * @throws LoaderError
	 * @throws RuntimeError
	 * @throws SyntaxError
	 */
	public function generateShortcode(): string {
		// load twig loader
		$twig = $this->twig->load( 'twig-template.twig' );

		// get dynamic stuff
		//$dynamic_stuff       = $this->http->getStuff(); // as array

		// render
		return $twig->render( [
				'title' => $this->config['title'],
				//'stuff'       => $dynamic_stuff
			]
		);
	}
}