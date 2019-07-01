<?php
declare( strict_types=1 );

namespace UniqueRootNamespace\Services;

use DI\Annotation\Inject;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;

class Http {

	/**
	 * @Inject("config")
	 * @var array $config
	 */
	private $config;

	/**
	 * @var Client
	 */
	private $http;

	/**
	 * Http constructor.
	 *
	 * @param Client $http
	 */
	public function __construct(
		Client $http
	) {
		$this->http = $http;
	}

	/**
	 * @param bool $as_array
	 *
	 * @return array|mixed|object
	 * @throws GuzzleException
	 */
	public function getStuff( bool $as_array = true ) {
		$request = new Request(
			'GET',
			$this->config['endpoints']['widgets']
		);

		$http_response = $this->http->send( $request );

		// TODO: Handle errors
		//$status_code = $response->getStatusCode();
		//$reason = $response->getReasonPhrase();

		$body     = $http_response->getBody(); // StreamInterface
		$contents = $body->getContents(); // json string array

		// array or stdClass object depending on as_array
		$response = json_decode( $contents, $as_array );

		return $response;
	}
}