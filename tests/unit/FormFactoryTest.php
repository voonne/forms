<?php

namespace Voonne\TestForms;

use Codeception\Test\Unit;
use Mockery;
use Mockery\MockInterface;
use Nette\Localization\ITranslator;
use UnitTester;
use Voonne\Forms\FormFactory;


class FormFactoryTest extends Unit
{

	/**
	 * @var UnitTester
	 */
	protected $tester;

	/**
	 * @var MockInterface
	 */
	private $translator;

	/**
	 * @var FormFactory
	 */
	private $formFactory;


	protected function _before()
	{
		$this->translator = Mockery::mock(ITranslator::class);

		$this->formFactory = new FormFactory($this->translator);
	}


	protected function _after()
	{
		Mockery::close();
	}


	public function testCreate()
	{
		$form = $this->formFactory->create();

		$this->assertEquals('novalidate', $form->getElementPrototype()->getAttribute('novalidate'));
		$this->assertEquals($this->translator, $form->getTranslator());
	}

}
