<?php
/**
 * Helper Class for building the TextArea Form Elements
 *
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Bootstrap_Form_BsTextarea
extends VTCore_Bootstrap_Form_Base
implements VTCore_Form_Interface {

  protected $context = array(

    // Shortcut method
    // @see VTCore_Bootstrap_Form_Base::assignContext()
    'text' => false,
    'description' => false,
    'required' => false,
    'resizeable' => false,
    'editor' => false,
    'id' => false,
    'class' => array('form-control'),
    'name' => false,
    'cols' => false,
    'rows' => 6,
    'value' => false,

    'label' => true,

    'togglelabel' => false,

    // Wrapper element
    'type' => 'div',
    'attributes' => array(
      'class' => array('form-group'),
    ),

    // Internal use, Only override if needed
    'input_elements' => array(),
    'label_elements' => array(),
    'description_elements' => array(),
    'required_elements' => array(),
  );

  private $input;

  public function buildElement() {

    $this->addAttributes($this->getContext('attributes'));

    if ($this->getContext('editor')) {
      $this->addClass('form-with-editor');
    }

    if ($this->getContext('resizeable')) {
      $this->addClass('form-resizeable');
    }

    if ($this->getContext('label_elements')) {
      $this->addChildren(new VTCore_Form_Label($this->getContext('label_elements')));
    }

    $this->input = $this->addChildren(new VTCore_Form_Textarea($this->getContext('input_elements')))->lastChild();

    if ($this->getContext('description_elements')) {
      $this->addChildren(new VTCore_Bootstrap_Form_BsDescription($this->getContext('description_elements')));
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