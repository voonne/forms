<?php

/**
 * This file is part of the Voonne platform (http://www.voonne.org)
 *
 * Copyright (c) 2016 Jan Lavička (mail@janlavicka.name)
 *
 * For the full copyright and license information, please view the file LICENCE.md that was distributed with this source code.
 */

namespace Voonne\Forms\Controls;


trait SuffixProperty
{

	/**
	 * @var string|null
	 */
	private $suffix;


	/**
	 * @param string $suffix
	 *
	 * @return $this
	 */
	public function setSuffix($suffix)
	{
		$this->suffix = $suffix;

		return $this;
	}


	/**
	 * @return string|null
	 */
	public function getSuffix()
	{
		return $this->suffix;
	}

}
