<?php
/**
 * Building form number with bootstrap rules
 *
 * Shortcut Method : BsNumber($context)
 *
 * Shortcut context available :
 *
 * text          : (string) The text for the Legend element
 * prefix        : (string) Prefix element in front of the text input element
 * suffix        : (string) Suffix element in the end of the text input element
 * description   : (string) Text of decription printed after the input element
 * required      : (boolean) Flag for marking element as required
 * placeholder   : (string) The placeholder text for the input element
 * max           : (numeric) The maximum acceptable value
 * min           : (numeric) the minimum acceptable value
 * step          : (numeric) incremental value
 * name          : (string) The name attributes for the input element
 * value         : (string) The value attributes for the input element
 * id            : (string) The id used for the input element and object machine id
 * class         : (array) Classes used for the input element
 * label         : (boolean) Flag for hiding the label element via CSS
 * spinner       : (boolean) Flag for building the spinner element instead of
 *                           using native HTML5 input number field (experimental)
 *
 *
 * @author jason.xie@victheme.com
 * @method BsNumber($context)
 * @see VTCore_Html_Form interface
 */
class VTCore_Bootstrap_Form_BsNumber
extends VTCore_Bootstrap_Form_Base
implements VTCore_Form_Interface {

  protected $context = array(

    // Shortcut method
    // @see VTCore_Bootstrap_Form_Base::assignContext()
    'text' => false,
    'prefix' => false,
    'suffix' => false,
    'description' => false,
    'required' => false,
    'max' => false,
    'min' => false,
    'step' => false,
    'placeholder' => false,
    'name' => false,
    'value' => false,
    'id' => false,
    'class' => array('form-control'),

    // Bootstrap Rules
    'label' => true,

    'togglelabel' => false,

    // Wrapper element
    'type' => 'div',
    'attributes' => array(
      'class' => array('form-group'),
    ),

    'spinner' => false,

    // Internal use, Only override if needed
    'input_elements' => array(),
    'label_elements' => array(),
    'description_elements' => array(),
    'prefix_elements' => array(),
    'suffix_elements' => array(),
    'required_elements' => array(),
  );



  public function buildElement() {


    if ($this->getContext('label_elements')) {
      $this->addChildren(new VTCore_Form_Label($this->getContext('label_elements')));
    }

    if ($this->getContext('prefix_elements')) {
      $this->addChildren(new VTCore_Bootstrap_Form_BsPrefix(($this->getContext('prefix_elements'))));
    }

    if ($this->getContext('spinner')) {
      // Experimental, not working properly yet!
      $this->buildSpinner();
    }
    else {
      $this->addChildren(new VTCore_Form_Number($this->getContext('input_elements')));
    }

    if ($this->getContext('suffix_elements')) {
      $this->addChildren(new VTCore_Bootstrap_Form_BsSuffix(($this->getContext('suffix_elements'))));
    }

    if ($this->getContext('description_elements')) {
      $this->addChildren(new VTCore_Bootstrap_Form_BsDescription(($this->getContext('description_elements'))));
    }

    if ($this->getContext('togglelabel')) {

      if (class_exists('VTCore_Wordpress_Utility')) {
        VTCore_Wordpress_Utility::loadAsset('bootstrap-toggle-label');
      }

      $this->addData('toggle-label', array(
        'parent' => false,
      ));
    }

    $this->addAttributes($this->getContext('attributes'));
  }


  /**
   * Build the custom spinner markup according to jQuery Spinner js.
   * Note that this is not recommended, it is better to use native
   * HTML5 input number element instead.
   *
   * @return $this
   */
  protected function buildSpinner() {

    if (class_exists('VTCore_Wordpress_Utility')) {
      VTCore_Wordpress_Utility::loadAsset('bootstrap-spinner');
      VTCore_Wordpress_Utility::loadAsset('jquery-spinner');
      VTCore_Wordpress_Utility::loadAsset('font-awesome');
    }

    if ($this->getContext('max') !== false) {
      $this->addContext('input_elements.attributes.data-max', $this->getContext('max'));

      // Not sure why this wont perform?
      $this->addContext('input_elements.validators.max', 'The highest value allowed is ' . $this->getContext('max'));
    }

    if ($this->getContext('min') !== false) {
      $this->addContext('input_elements.attributes.data-min', $this->getContext('min'));

      // Not sure why this wont perform?
      $this->addContext('input_elements.validators.min', 'The lowest value allowed is ' . $this->getContext('min'));
    }

    if ($this->getContext('step') !== false) {

      // Format the steps so javascript dont get screwed up
      $step = $this->getContext('step');
      $str = rtrim(number_format($step, 14 - log10($step)), '0');
      $decimal = strlen(substr(strrchr($str, "."), 1));

      $this->addContext('input_elements.attributes.data-step', $this->getContext('step'));
      $this->addContext('input_elements.attributes.data-precision', $decimal);
      $this->removeContext('input_elements.attributes.step');
    }

    if ($this->getContext('rule') !== false) {
      $this->addContext('input_elements.attributes.data-rule', $this->getContext('rule'));
    }

    $this->addContext('input_elements.validators.numeric', 'Only numerical value allowed');


    $this
      ->addChildren(new VTCore_Html_Element(array(
        'type' => 'div',
        'data' => array(
          'trigger' => 'spinner',
        ),
        'attributes' => array(
          'class' => array(
            'bootstrap-spinner',
          ),
        ),
      )))
      ->lastChild()
      ->addChildren(new VTCore_Form_Text($this->getContext('input_elements')))
      ->addChildren(new VTCore_Html_Element(array(
        'type' => 'div',
        'attributes' => array(
          'class' => array(
            'bootstrap-spinner-buttons',
          ),
        ),
      )))
      ->lastChild()
      ->addChildren(new VTCore_Form_Button(array(
        'data' => array(
          'spin' => 'up',
        ),
        'attributes' => array(
          'type' => 'button',
          'class' => array(
            'bootstrap-spinner-spin-up',
          )
        )
      )))
      ->addChildren(new VTCore_Form_Button(array(
        'data' => array(
          'spin' => 'down',
        ),
        'attributes' => array(
          'type' => 'button',
          'class' => array(
            'bootstrap-spinner-spin-down',
          )
        )
      )));

    return $this;
  }
}