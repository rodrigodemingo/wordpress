<?php
/**
 * Helper Class for building the Option Elements
 *
 * @author jason.xie@victheme.com
 * @see VTCore_Form_Interface interface
 */
class VTCore_Form_Option
extends VTCore_Form_Base
implements VTCore_Form_Interface {

  protected $context = array(
    'text' => '',
    'type' => 'option',
    'attributes' => array(
      'class' => array(),
      'value' => '',
      'selected' => false,
    ),
  );

  public function buildElement() {
    $this->addAttributes($this->getContext('attributes'));
    $this->addChildren($this->getContext('text'));
  }
}