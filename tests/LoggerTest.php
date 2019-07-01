<?php
declare( strict_types=1 );

namespace UniqueRootNamespace\Tests;

use DI\Annotation\Inject;
use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use Psr\Log\LoggerInterface;

class LoggerTest extends ContainerizedTestCase {

	/**
	 * @var LoggerInterface $logger
	 * @Inject()
	 */
	private $logger;

	public function testLoggerInjection(): void {
		self::assertInstanceOf( LoggerInterface::class, $this->logger );
	}

	/**
	 * @throws DependencyException
	 * @throws NotFoundException
	 * @throws Exception
	 */
	public function testLogger(): void {
		$message = 'test logger functionality';
		$this->logger->debug( $message );

		$log_path = $this->di_container->get( 'log.path' );
		$this->assertFileExists( $log_path );

		$this->assertTrue( is_readable( $log_path ) );

		$contents = file_get_contents( $log_path );

		$pattern = preg_quote( '/' . $message . '/' );
		$this->assertRegExp( $pattern, $contents );
	}
}