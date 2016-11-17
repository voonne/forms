<?php

/**
 * This file is part of the Voonne platform (http://www.voonne.org)
 *
 * Copyright (c) 2016 Jan Lavička (mail@janlavicka.name)
 *
 * For the full copyright and license information, please view the file LICENCE.md that was distributed with this source code.
 */

namespace Voonne\Forms\Controls;


trait PrefixProperty
{

	/**
	 * @var string|null
	 */
	private $prefix;


	/**
	 * @param string $prefix
	 *
	 * @return $this
	 */
	public function setPrefix($prefix)
	{
		$this->prefix = $prefix;

		return $this;
	}


	/**
	 * @return string|null
	 */
	public function getPrefix()
	{
		return $this->prefix;
	}

}
