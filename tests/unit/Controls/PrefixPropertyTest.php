<?php
namespace Voonne\TestForms\Controls;

use Codeception\Test\Unit;
use Mockery;
use UnitTester;
use Voonne\Forms\Controls\PrefixProperty;


class PrefixPropertyTest extends Unit
{

	/**
	 * @var UnitTester
	 */
	protected $tester;

	/**
	 * @var TestPrefixProperty
	 */
	private $prefixProperty;


	protected function _before()
	{
		$this->prefixProperty = new TestPrefixProperty();
	}


	protected function _after()
	{
		Mockery::close();
	}


	public function testPrefix()
	{
		$this->assertNull($this->prefixProperty->getPrefix());

		$this->prefixProperty->setPrefix('prefix');

		$this->assertEquals('prefix', $this->prefixProperty->getPrefix());
	}

}


class TestPrefixProperty
{

	use PrefixProperty;

}
