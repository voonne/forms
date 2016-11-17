<?php
namespace Voonne\TestForms\Controls;

use Codeception\Test\Unit;
use Mockery;
use UnitTester;
use Voonne\Forms\Controls\SuffixProperty;


class SuffixPropertyTest extends Unit
{

	/**
	 * @var UnitTester
	 */
	protected $tester;

	/**
	 * @var TestSuffixProperty
	 */
	private $suffixProperty;


	protected function _before()
	{
		$this->suffixProperty = new TestSuffixProperty();
	}


	protected function _after()
	{
		Mockery::close();
	}


	public function testSuffix()
	{
		$this->assertNull($this->suffixProperty->getSuffix());

		$this->suffixProperty->setSuffix('suffix');

		$this->assertEquals('suffix', $this->suffixProperty->getSuffix());
	}

}


class TestSuffixProperty
{

	use SuffixProperty;

}
