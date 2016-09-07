<?php

namespace Voonne\TestForms\Controls;

use Codeception\Test\Unit;
use Mockery;
use UnitTester;
use Voonne\Forms\Controls\DescriptionProperty;


class DescriptionPropertyTest extends Unit
{

	/**
	 * @var UnitTester
	 */
	protected $tester;

	/**
	 * @var TestDescriptionProperty
	 */
	private $descriptionProperty;


	protected function _before()
	{
		$this->descriptionProperty = new TestDescriptionProperty();
	}


	protected function _after()
	{
		Mockery::close();
	}


	public function testSetDescription()
	{
		$this->assertNull($this->descriptionProperty->getDescription());

		$this->descriptionProperty->setDescription('description');

		$this->assertEquals('description', $this->descriptionProperty->getDescription());
	}

}


class TestDescriptionProperty
{

	use DescriptionProperty;

}
