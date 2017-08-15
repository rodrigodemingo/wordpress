<?php
/**
 * Building form checkbox with bootstrap rules
 *
 * Shortcut Method : BsCheckbox($context)
 *
 * This class must be called from VTCore_Bootstrap_Form_BsInstance() as
 * the main form wrapper class if shortcut method is used.
 *
 * Otherwise a full invocation of the class name must be used
 * when building the object, and addChildren() method must be
 * used for registering the object into the parent form wrapper.
 *
 * Shortcut context available :
 *
 * text          : (string) The text for the Legend element
 * description   : (string) Text of decription printed after the input element
 * required      : (boolean) Flag for marking element as required
 * placeholder   : (string) The placeholder text for the input element
 * name          : (string) The name attributes for the input element
 * value         : (string) The value attributes for the input element
 * offvalue      : (string) The value should be returned when unchecked,
 *                          set to NULL to disable
 * id            : (string) The id used for the input element and object machine id
 * class         : (array) Classes used for the input element
 *
 *
 * Bootstrap Switch shortcodes :
 * switch        : (boolean) true or false to turn on/off javascript toggle switch
 * data          : (array) arrays of data that will be passed to javascript with below valid keys
 *   size        : (string)  null, mini, small, normal, large
 *   animate     : (boolean) true or false
 *   disabled    : (boolean) true or false
 *   readonly    : (boolean) true or false
 *   onColor     : (string) primary, info, success, warning, danger, default
 *   offColor    : (string) primary, info, success, warning, danger, default
 *   onText      : (string) Text of the left side of the switch
 *   offText     : (string) Text of the right side of the switch
 *   labelText   : (string) Text of the center handle of the switch
 *   baseClass   : (string) Global class prefix
 *   wrapperClass: (string) container element classes
 *
 * @author jason.xie@victheme.com
 * @method BsCheckbox($context)
 * @see VTCore_Html_Form interface
 *
 * @todo support the bootstrap switch natively without javascript !.
 */
class VTCore_Bootstrap_Form_BsCheckbox
extends VTCore_Bootstrap_Form_Base
implements VTCore_Form_Interface {

  protected $context = array(

    // Shortcut method
    // @see VTCore_Bootstrap_Form_Base::assignContext()
    'text' => '',
    'description' => '',
    'required' => false,
    'id' => '',
    'class' => array(),
    'value' => '1',
    'offvalue' => '0', // Boolean false will not printed.

    'label' => true,

    // Switch box
    'switch' => false,
    'switch_attributes' => array(
      'size' => 'mini',
      'off' => array(
        'color' => 'danger',
        'text' => false,
      ),
      'on' => array(
        'color' => 'primary',
        'text' => false,
      ),
    ),

    // Wrapper element
    'type' => 'div',
    'attributes' => array(
      'class' => array('checkbox', 'form-group'),
    ),

    // Internal use, Only override if needed
    'input_elements' => array(),
    'label_elements' => array(),
    'description_elements' => array(),
    'required_elements' => array(),
  );

  /**
   * Build the elements
   * @see VTCore_Html_Form::buildElement()
   */
  public function buildElement() {

    $this->addAttributes($this->getContext('attributes'));

    if ($this->getContext('offvalue') !== NULL) {
      $this
        ->addChildren(new VTCore_Form_Hidden(array(
          'attributes' => array(
            'name' => $this->getContext('name'),
            'value' => $this->getContext('offvalue'),
          ),
        )));
    }

    // Process switchbox
    if ($this->getContext('switch')) {
      VTCore_Wordpress_Utility::loadAsset('bootstrap-switch');

      if (!$this->getContext('switch_attributes.off.text')) {
        $this->addContext('switch_attributes.off.text', __('OFF', 'victheme_core'));
      }

      if (!$this->getContext('switch_attributes.on.text')) {
        $this->addContext('switch_attributes.on.text', __('ON', 'victheme_core'));
      }

      $object = new VTCore_Html_Element();
      $object
        ->addChildren(new VTCore_Html_Element(array(
          'type' => 'div',
          'attributes' => array(
            'class' => array(
              'bootstrap-switch',
              'bootstrap-switch-' . $this->getContext('switch_attributes.size'),
            ),
          ),
        )))
        ->lastChild()
        ->addChildren(new VTCore_Html_Element(array(
          'type' => 'div',
          'attributes' => array(
            'class' => array(
              'bootstrap-switch-container',
            ),
          ),
        )))
        ->lastChild()
        ->addChildren(new VTCore_Form_Checkbox($this->getContext('input_elements')))
        ->addChildren(new VTCore_Html_Element(array(
          'type' => 'span',
          'text' => $this->getContext('switch_attributes.off.text'),
          'attributes' => array(
            'class' => array(
              'bootstrap-switch-handle-off',
              'bootstrap-switch-' . $this->getContext('switch_attributes.off.color'),
            ),
          ),
        )))
        ->addChildren(new VTCore_Html_Element(array(
          'type' => 'span',
          'text' => $this->getContext('switch_attributes.on.text'),
          'attributes' => array(
            'class' => array(
              'bootstrap-switch-handle-on',
              'bootstrap-switch-' . $this->getContext('switch_attributes.on.color'),
            ),
          ),
        )));

      $this->addContext('label_elements.attributes.class.bs-switch', 'bootstrap-switch-label');
      $this->addContext('label_elements.children', $object->getChildrens());
      $this->addClass('bootstrap-switch-mode');

      if (!$this->getContext('grids')) {
        $this->addClass('bootstrap-switch-no-grid');
      }

      $object = NULL;
      unset($object);
    }

    else {
      $this->addContext('label_elements.children', array(
        new VTCore_Form_Checkbox($this->getContext('input_elements')),
      ));
    }

    $this->addChildren(new VTCore_Form_Label($this->getContext('label_elements')));

    if ($this->getContext('description_elements')) {
      $this->addChildren(new VTCore_Bootstrap_Form_BsDescription(($this->getContext('description_elements'))));
    }
  }
}