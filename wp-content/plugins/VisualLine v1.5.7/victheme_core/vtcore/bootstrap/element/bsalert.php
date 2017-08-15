<?php
/**
 * Building alert box with bootstrap rules
 *
 * Shortcut Method : BsAlert($context)
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
 * text          : (string) The text for the alert element
 * button        : (string) button content give false to disable button
 * alert-type          : (string) The class type for the button eg. danger
 *
 *
 * @author jason.xie@victheme.com
 * @method BsAlert($context)
 * @see VTCore_Html_Form interface
 */
class VTCore_Bootstrap_Element_BsAlert
extends VTCore_Bootstrap_Element_Base {

  protected $context = array(

    // Shortcut method
    // @see VTCore_Bootstrap_Form_Base::assignContext()
    'text' => false,
    'button' => '&times;',
    'alert-type' => 'danger',

    // Wrapper element
    'type' => 'div',
    'attributes' => array(
      'class' => array('alert'),
    ),

    // Internal use, Only override if needed
    'button_elements' => array(
      'text' => '&times;',
      'attributes' => array(
        'class' => array('close'),
        'data-dismiss' => 'alert',
        'aria-hidden' => 'true',
      ),
    ),
  );

  public function buildElement() {

    $this->addAttributes($this->getContext('attributes'));

    $this->addClass('alert-' . $this->getContext('alert-type'));

    if ($this->getContext('button')) {
      $this->addClass('alert-dismissable');
      $this
        ->addChildren(new VTCore_Form_Button($this->getContext('button_elements')))
        ->addChildren($this->getContext('text'));
    }
    else {
      $this->addChildren($this->getContext('text'));
    }
  }
}