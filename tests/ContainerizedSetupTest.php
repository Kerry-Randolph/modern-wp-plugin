<?php
declare( strict_types=1 );

namespace UniqueRootNamespace\Tests;

use DI\Container;

class ContainerizedSetupTest extends ContainerizedTestCase {

	public function testContainerSetup(): void {
		$this->assertInstanceOf( Container::class, $this->di_container );
	}
}
