<?php

/**
 * This file is part of the Voonne platform (http://www.voonne.org)
 *
 * Copyright (c) 2016 Jan Lavička (mail@janlavicka.name)
 *
 * For the full copyright and license information, please view the file licence.md that was distributed with this source code.
 */

namespace Voonne\Forms;

use Nette\Forms\IControl;
use Nette\UnexpectedValueException;
use Nette\Utils\Callback;
use Voonne\Forms\Controls\Button;
use Voonne\Forms\Controls\Checkbox;
use Voonne\Forms\Controls\CheckboxList;
use Voonne\Forms\Controls\DatePicker;
use Voonne\Forms\Controls\DateTimePicker;
use Voonne\Forms\Controls\HiddenField;
use Voonne\Forms\Controls\ImageButton;
use Voonne\Forms\Controls\MultiSelectBox;
use Voonne\Forms\Controls\RadioList;
use Voonne\Forms\Controls\SelectBox;
use Voonne\Forms\Controls\SubmitButton;
use Voonne\Forms\Controls\TextArea;
use Voonne\Forms\Controls\TextInput;
use Voonne\Forms\Controls\TimePicker;
use Voonne\Forms\Controls\UploadControl;


class Container extends \Nette\Forms\Container
{

	/**
	 * @var array
	 */
	public $onSuccess = [];

	/**
	 * @var array
	 */
	public $onError = [];

	/**
	 * @var array
	 */
	public $onSubmit = [];

	/**
	 * @var array
	 */
	public $onRender = [];

	/**
	 * @var bool
	 */
	private $validated;

	/**
	 * @var string|null
	 */
	private $label;


	public function __construct($label = null)
	{
		parent::__construct();

		$this->label = $label;
	}


	/**
	 * @return string|null
	 */
	public function getLabel()
	{
		return $this->label;
	}


	/**
	 * Is form valid?
	 *
	 * @return bool
	 */
	public function isValid()
	{
		if ($this->isSubmitted()) {
			if(!$this->validated) {
				if($this->getErrors()) {
					return false;
				}

				$this->validate();
			}

			return !$this->getErrors();
		} else {
			return true;
		}
	}


	/**
	 * Performs the server side validation.
	 *
	 * @param array
	 *
	 * @return void
	 */
	public function validate(array $controls = NULL)
	{
		if ($this->isSubmitted()) {
			foreach ($controls === null ? $this->getComponents() : $controls as $control) {
				if($control instanceof IControl || $control instanceof self) {
					$control->validate();
				}
			}
			if($this->onValidate !== null) {
				if(!is_array($this->onValidate) && !$this->onValidate instanceof \Traversable) {
					throw new UnexpectedValueException('Property Form::$onValidate must be array or Traversable, ' . gettype($this->onValidate) . ' given.');
				}
				foreach ($this->onValidate as $handler) {
					$params = Callback::toReflection($handler)->getParameters();
					$values = isset($params[1]) ? $this->getValues($params[1]->isArray()) : null;
					Callback::invoke($handler, $this, $values);
				}
			}
			$this->validated = true;
		} else {
			$this->validated = true;
		}
	}


	/**
	 * Is this part of form submitted?
	 *
	 * @return bool
	 */
	public function isSubmitted()
	{
		foreach ($this->getComponents(true, \Nette\Forms\Controls\Button::class) as $component) {
			if ($component->isSubmittedBy()) {
				return true;
			}
		}

		return false;
	}


	/**
	 * Adds single-line text input control to the form.
	 *
	 * @param string $name
	 * @param string $label
	 * @param int $cols
	 * @param int $maxLength
	 *
	 * @return TextInput
	 */
	public function addText($name, $label = null, $cols = null, $maxLength = null)
	{
		$control = new TextInput($label, $maxLength);
		$control->setAttribute('size', $cols);
		return $this[$name] = $control;
	}


	/**
	 * Adds single-line text input control used for sensitive input such as passwords.
	 *
	 * @param string $name
	 * @param string $label
	 * @param int $cols
	 * @param int $maxLength
	 *
	 * @return TextInput
	 */
	public function addPassword($name, $label = null, $cols = null, $maxLength = null)
	{
		$control = new TextInput($label, $maxLength);
		$control->setAttribute('size', $cols);
		return $this[$name] = $control->setType('password');
	}


	/**
	 * Adds multi-line text input control to the form.
	 *
	 * @param string $name
	 * @param string $label
	 * @param int $cols
	 * @param int $rows
	 *
	 * @return TextArea
	 */
	public function addTextArea($name, $label = null, $cols = null, $rows = null)
	{
		$control = new TextArea($label);
		$control->setAttribute('cols', $cols)->setAttribute('rows', $rows);
		return $this[$name] = $control;
	}


	/**
	 * Adds control that allows the user to upload files.
	 *
	 * @param string $name
	 * @param string $label
	 * @param bool $multiple
	 *
	 * @return UploadControl
	 */
	public function addUpload($name, $label = null, $multiple = false)
	{
		return $this[$name] = new UploadControl($label, $multiple);
	}


	/**
	 * Adds control that allows the user to upload multiple files.
	 *
	 * @param string $name
	 * @param string $label
	 *
	 * @return UploadControl
	 */
	public function addMultiUpload($name, $label = null)
	{
		return $this[$name] = new UploadControl($label, true);
	}


	/**
	 * Adds hidden form control used to store a non-displayed value.
	 *
	 * @param string $name
	 * @param mixed $default
	 *
	 * @return HiddenField
	 */
	public function addHidden($name, $default = null)
	{
		$control = new HiddenField();
		$control->setDefaultValue($default);
		return $this[$name] = $control;
	}


	/**
	 * Adds check box control to the form.
	 *
	 * @param string $name
	 * @param string $caption
	 *
	 * @return Checkbox
	 */
	public function addCheckbox($name, $caption = null)
	{
		return $this[$name] = new Checkbox($caption);
	}


	/**
	 * Adds set of radio button controls to the form.
	 *
	 * @param string $name
	 * @param string $label
	 * @param array $items
	 *
	 * @return RadioList
	 */
	public function addRadioList($name, $label = null, array $items = null)
	{
		return $this[$name] = new RadioList($label, $items);
	}


	/**
	 * Adds set of checkbox controls to the form.
	 *
	 * @param string $name
	 * @param string $label
	 * @param array $items
	 *
	 * @return CheckboxList
	 */
	public function addCheckboxList($name, $label = null, array $items = null)
	{
		return $this[$name] = new CheckboxList($label, $items);
	}


	/**
	 * Adds select box control that allows single item selection.
	 *
	 * @param string $name
	 * @param string $label
	 * @param array $items
	 * @param int $size
	 *
	 * @return SelectBox
	 */
	public function addSelect($name, $label = null, array $items = null, $size = null)
	{
		$control = new SelectBox($label, $items);
		if ($size > 1) {
			$control->setAttribute('size', (int)$size);
		}
		return $this[$name] = $control;
	}


	/**
	 * Adds select box control that allows multiple item selection.
	 *
	 * @param string $name
	 * @param string $label
	 * @param array $items
	 * @param int $size
	 *
	 * @return MultiSelectBox
	 */
	public function addMultiSelect($name, $label = null, array $items = null, $size = null)
	{
		$control = new MultiSelectBox($label, $items);
		if ($size > 1) {
			$control->setAttribute('size', (int)$size);
		}
		return $this[$name] = $control;
	}


	/**
	 * Adds date picker to the form.
	 *
	 * @param string $name
	 * @param string|null $label
	 *
	 * @return DatePicker
	 */
	public function addDatePicker($name, $label = null)
	{
		return $this[$name] = new DatePicker($label);
	}


	/**
	 * Adds time picker to the form.
	 *
	 * @param string $name
	 * @param string|null $label
	 *
	 * @return TimePicker
	 */
	public function addTimePicker($name, $label = null)
	{
		return $this[$name] = new TimePicker($label);
	}


	/**
	 * Adds date time picker to the form.
	 *
	 * @param string $name
	 * @param string|null $label
	 *
	 * @return DateTimePicker
	 */
	public function addDateTimePicker($name, $label = null)
	{
		return $this[$name] = new DateTimePicker($label);
	}


	/**
	 * Adds button used to submit form.
	 *
	 * @param string $name
	 * @param string $caption
	 *
	 * @return SubmitButton
	 */
	public function addSubmit($name, $caption = null)
	{
		return $this[$name] = new SubmitButton($caption);
	}


	/**
	 * Adds push buttons with no default behavior.
	 *
	 * @param string $name
	 * @param string $caption
	 *
	 * @return Button
	 */
	public function addButton($name, $caption = null)
	{
		return $this[$name] = new Button($caption);
	}


	/**
	 * Adds graphical button used to submit form.
	 *
	 * @param string $name
	 * @param string $src
	 * @param string $alt
	 *
	 * @return ImageButton
	 */
	public function addImage($name, $src = null, $alt = null)
	{
		return $this[$name] = new ImageButton($src, $alt);
	}


	/**
	 * Adds naming container to the form.
	 *
	 * @param string $name
	 * @param string|null $label
	 *
	 * @return Container
	 */
	public function addContainer($name, $label = null)
	{
		$control = new Container($label);
		$control->currentGroup = $this->currentGroup;
		if ($this->currentGroup !== NULL) {
			$this->currentGroup->add($control);
		}

		$this->onSuccess[] = function (Container $container, $values) use ($control, $name) {
			$control->onSuccess($container->getComponent($name), $values->{$name});
		};

		$this->onError[] = function (Container $container) use ($control, $name) {
			$control->onError($container);
		};

		$this->onSubmit[] = function (Container $container) use ($control, $name) {
			$control->onSubmit($container);
		};

		$this->onRender[] = function (Container $container) use ($control, $name) {
			$control->onRender($container);
		};

		return $this[$name] = $control;
	}

}
