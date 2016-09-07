<?php

namespace Voonne\TestForms;

use Codeception\Test\Unit;
use Mockery;
use UnitTester;
use Voonne\Forms\Container;


class ContainerTest extends Unit
{

	/**
	 * @var UnitTester
	 */
	protected $tester;

	/**
	 * @var Container
	 */
	private $container;


	protected function _before()
	{
		$this->container = new Container('label');
	}


	protected function _after()
	{
		Mockery::close();
	}


	public function testInitialize()
	{
		$this->assertEquals('label', $this->container->getLabel());
	}

}
