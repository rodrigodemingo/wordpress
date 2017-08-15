<?php

/**
 * Main Interface for all Form SubClass
 *
 * Any SubClass of VTCore_Form_Base() must
 * implement this interface in order to be able to
 * act as a form element constructor and overrider
 * for the main VTCore_Form_Base() or VTCore_Form_Form().
 *
 * @author jason.xie@victheme.com
 * @see form_element_example.api.php
 */
interface VTCore_Form_Interface {
  public function buildElement();

  public function setValue($value);
}

/**
 * Extending the Core_Html_Base() for the form element
 * subclasses. We need to extend the base because
 * the method for overloading the form elements method
 * is different from the basic HTML methods.
 *
 * @author jason.xie@victheme.com
 *
 * Define the magic method for IDE autocomplete use
 * @method string Button() Method for building HTML5 Button input element
 * @method string Checkbox() Method for building checkbox element
 * @method string Color() Method for building HTML5 Color input element
 * @method string DataList() Method for building HTML data list element
 * @method string Date() Method for building HTML5 Date input element
 * @method string Email() Method for building Email input element
 * @method string Fieldset() Method for building fieldset element
 * @method string Hidden() Method for building hidden input element
 * @method string Label() Method for building label element
 * @method string Legend() Method for building legend element
 * @method string Month() Method for building HTML5 Month input element
 * @method string Nonce() Method for building WP nonce hidden input field
 * @method string Number() Method for building HTML5 Number input element
 * @method string Option() Method for building option element
 * @method string Radio() Method for building radio element
 * @method string Range() Method for building HTML5 Range input element
 * @method string Required() Method for building form item required element
 * @method string Reset() Method for building input reset element
 * @method string Search() Method for building HTML5 Search input element
 * @method string Select() Method for building select element
 * @method string Submit() Method for building input submit element
 * @method string Tel() Method for building HTML5 Telephone input element
 * @method string Text() Method for building input text object
 * @method string Textarea() Method for building textarea object
 * @method string Time() Method for building HTML5 Time input element
 * @method string URL() Method for building HTML5 URL input element
 * @method string Week() Method for building HTML5 Week input element
 */
class VTCore_Form_Base
  extends VTCore_Html_Base {

  private $validators = array();
  protected $overloaderPrefix = array('VTCore_Form_', 'VTCore_Html_');

  /**
   * Constructing the object and processing
   * the context array
   */
  public function __construct($context = array()) {
    $this->buildObject($context);
    $this->buildElement();
    $this->buildValidator();
  }

  public function buildValidator() {

    $validator = $this->getContext('validators');

    if ($this->getAttribute('required') == TRUE
      && !isset($validator['empty'])
    ) {

      $context = array(
        'validators' => array(
          'empty' => __('Form is required', 'victheme_core'),
        ),
      );
      $this->setContext($context);
    }

    if ($this->getContext('validators') !== NULL) {
      $this->setValidators();
    }
  }

  public function setValue($value) {
    $this->addAttribute('value', $value);
  }

  public function getValue() {
    return $this->getAttribute('value');
  }

  public function setDefaultValidator($rule, $message) {
    $context = $this->getContext('validators');
    if (!isset($context[$rule])) {
      $context[$rule] = $message;
      $this->setContext(array('validators' => $context));
    }
  }

  public function addValidator($rule, $validator) {
    $this->validators[$rule] = $validator;
  }

  public function removeValidator($rule) {
    unset($this->validators[$rule]);
  }

  public function getValidator($rule) {
    return (!isset($this->validators[$rule])) ? NULL : $this->validators[$rule];
  }

  public function getValidators() {
    return (empty($this->validators)) ? NULL : $this->validators;
  }

  public function setValidators() {
    foreach ($this->getContext('validators') as $rule => $message) {
      $class = 'VTCore_Validator_' . $rule;
      if (is_callable($class, TRUE)) {
        $this->addValidator($rule, new $class(FALSE, $message));
      }
    }
  }
}