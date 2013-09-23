<?php

namespace Adchieve\SecurityCheckerBundle\Tests\DataCollector;

use Adchieve\SecurityCheckerBundle\DataCollector;

use SensioLabs\Security;

/**
 * Collects data from the sensiolabs security checker
 *
 * @author Bas Hilbers <bas.hilbers@tribal-im.com>
 */
class SecurityCheckerDataCollectorTest extends \PHPUnit_Framework_TestCase
{
	protected $collector;

	public function setUp()
	{
		$this->collector = new SecurityCheckerDataCollector(
			new SecurityChecker(),
			$this->getComposerMockPath()
		);
	}
	
	public function getComposerMockPath()
	{
		$dir = __FILE__ . '../Fixtures/composer.lock';
	}
	
	
}