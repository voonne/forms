<?php

/**
 * This file is part of the Voonne platform (http://www.voonne.org)
 *
 * Copyright (c) 2016 Jan Lavička (mail@janlavicka.name)
 *
 * For the full copyright and license information, please view the file LICENCE.md that was distributed with this source code.
 */

namespace Voonne\Forms\Controls;

use DateTime;
use Nette\Forms\Controls\TextBase;


class DatePicker extends TextBase
{

	use DescriptionProperty;


	public function __construct($label = null)
	{
		parent::__construct($label);
	}


	/**
	 * Returns control's value.
	 *
	 * @return DateTime|string
	 */
	public function getValue()
	{
		$value = parent::getValue();

		if (!empty($value)) {
			$value = DateTime::createFromFormat('d.m.Y', $value);

			if ($value) {
				$value->setTime(0, 0, 0);
			}
		}

		return $value;
	}


	/**
	 * Sets control's value.
	 *
	 * @param DateTime|string $value
	 *
	 * @return $this
	 */
	public function setValue($value)
	{
		return parent::setValue($value instanceof DateTime ? $value->format('d.m.Y') : $value);
	}


	/**
	 * Sets control's default value.
	 *
	 * @param DateTime|string $value
	 *
	 * @return $this
	 */
	public function setDefaultValue($value)
	{
		return parent::setDefaultValue($value instanceof DateTime ? $value->format('d.m.Y') : $value);
	}


	public function getControl()
	{
		$control = parent::getControl();

		if ($this->getValue() instanceof DateTime) {
			$control->{'value'} = $this->getValue()->format('d.m.Y');
		}

		return $control;
	}

}
