<?php
/**
 * Building form color with bootstrap rules
 *
 * Shortcut Method : BsColor($context)
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
 * prefix        : (string) Prefix element in front of the text input element
 * suffix        : (string) Suffix element in the end of the text input element
 * description   : (string) Text of decription printed after the input element
 * required      : (boolean) Flag for marking element as required
 * placeholder   : (string) The placeholder text for the input element
 * name          : (string) The name attributes for the input element
 * value         : (string) The value attributes for the input element
 * id            : (string) The id used for the input element and object machine id
 * class         : (array) Classes used for the input element
 * label         : (boolean) Flag for hiding the label element via CSS
 *
 * @author jason.xie@victheme.com
 * @method BsColor($context)
 * @see VTCore_Html_Form interface
 */
class VTCore_Bootstrap_Form_BsColor
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
    'placeholder' => false,
    'name' => false,
    'value' => false,
    'id' => false,
    'class' => array('form-control'),

    // Bootstrap Rules
    'label' => true,

    // Wrapper element
    'type' => 'div',
    'attributes' => array(
      'class' => array('form-group'),
    ),

    'enablejs' => true,

    // Toggle label
    'togglelabel' => false,

    // Internal use, Only override if needed
    'input_elements' => array(),
    'label_elements' => array(),
    'description_elements' => array(),
    'prefix_elements' => array(),
    'suffix_elements' => array(),
    'required_elements' => array(),
  );

  public function buildElement() {


    $this->addAttributes($this->getContext('attributes'));


    if ($this->getContext('label_elements')) {
      $this->addChildren(new VTCore_Form_Label($this->getContext('label_elements')));
    }

    if ($this->getContext('prefix_elements')) {
      $this->addChildren(new VTCore_Bootstrap_Form_BsPrefix(($this->getContext('prefix_elements'))));
    }

    $this->addChildren(new VTCore_Form_Color($this->getContext('input_elements')));

    // Load and reformat the element as bootstrap colorpicker
    // javascript requires.
    if ($this->getContext('enablejs')) {

      if (class_exists('VTCore_Wordpress_Utility')) {
        VTCore_Wordpress_Utility::loadAsset('bootstrap-colorpicker');
      }

      $this->lastChild()->addAttribute('type', 'text');

      $this->addClass('bootstrap-colorpicker');
      $this->addClass('input-group');
      $this
        ->addChildren(new VTCore_Html_Element(array(
          'type' => 'span',
          'attributes' => array(
            'class' => array('input-group-addon'),
          ),
        )))
        ->lastChild()
        ->addChildren(new VTCore_Html_Element(array(
          'type' => 'i'
        )));

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
  }
}