<?php
/**
 * Building form input with bootstrap time javascript
 * to get the select by clock time element.
 *
 * Shortcut Method : BsTime($context)
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
 * prefix        : (string) Prefix element in front of the text input element
 * required      : (boolean) Flag for marking element as required
 * placeholder   : (string) The placeholder text for the input element
 * name          : (string) The name attributes for the input element
 * value         : (string) The value attributes for the input element
 * id            : (string) The id used for the input element and object machine id
 * class         : (array) Classes used for the input element
 * label         : (boolean) Flag for hiding the label element via CSS
 *
 * clockpicker arrays
 * default       : (string) default time, 'now' or '13:14' e.g.
 * placement     : (string) bottom | top popover placement
 * align         : (string) left | right popover arrow align
 * donetext      : (string) done button text
 * autoclose     : (boolean) auto close when minute is selected
 * twelvehour    : (boolean) enables twelve hour mode with AM & PM buttons
 * vibrate       : (boolean) vibrate the device when dragging clock hand
 * fromnow       : (int) set default time to * milliseconds from now (using with default = 'now')
 *
 * @author jason.xie@victheme.com
 * @method BsTime($context)
 * @see VTCore_Html_Form interface
 */
class VTCore_Bootstrap_Form_BsTime
extends VTCore_Bootstrap_Form_Base
implements VTCore_Form_Interface {

  protected $context = array(

    // Shortcut method
    // @see VTCore_Bootstrap_Form_Base::assignContext()
    'text' => false,
    'description' => false,
    'prefix' => false,
    'required' => false,
    'placeholder' => false,
    'name' => false,
    'value' => false,
    'id' => false,
    'class' => array(
      'form-control'
    ),

    // Bootstrap Rules
    'label' => true,

    'togglelabel' => false,

    // Wrapper element
    'type' => 'div',
    'attributes' => array(
      'class' => array(
        'form-group',
        'input-group',
        'clockpicker',
        'js-clockpicker',
        'clockpicker-group',
      ),
    ),

    'icon' => 'time',

    // Clockpicker rules
    'clockpicker' => array(
      'default' => '',
      'placement' => 'bottom',
      'align' => 'left',
      'donetext' => 'Set Time',
      'autoclose' => false,
      'twelvehour' => true,
      'vibrate' => true,
      'fromnow' => 0,
    ),

    // Internal use, Only override if needed
    'input_elements' => array(),
    'label_elements' => array(),
    'description_elements' => array(),
    'prefix_elements' => array(),
    'suffix_elements' => array(),
    'required_elements' => array(),
  );


  public function buildElement() {

    if (class_exists('VTCore_Wordpress_Utility')) {
      VTCore_Wordpress_Utility::loadAsset('bootstrap-clockpicker');
    }

    $this->addAttributes($this->getContext('attributes'));

    foreach ($this->getContext('clockpicker') as $type => $value) {
      $this->addData($type, $value);
    }

    if ($this->getContext('label_elements')) {
      $this->addChildren(new VTCore_Form_Label($this->getContext('label_elements')));
    }

    if ($this->getContext('prefix_elements')) {
      $this->addChildren(new VTCore_Bootstrap_Form_BsPrefix(($this->getContext('prefix_elements'))));
    }

    $this->addChildren(new VTCore_Form_Text($this->getContext('input_elements')));
    $this->addChildren(new VTCore_Bootstrap_Form_BsSuffix(($this->getContext('suffix_elements'))));
    $this->lastChild()->addChildren(new VTCore_Bootstrap_Element_BsGlyphicon(array(
      'icon' => $this->getContext('icon'),
    )));


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
  }

}