<?php
/**
 * Helper Class for building the TextArea Form Elements
 *
 * @author jason.xie@victheme.com
 * @see VTCore_Form_Interface interface
 */
class VTCore_Form_Textarea
extends VTCore_Form_Base
implements VTCore_Form_Interface {

  protected $context = array(
    'type' => 'textarea',
    'attributes' => array(
      'id' => false,
      'class' => array(),
      'name' => '',
      'cols' => false,
      'rows' => false,
      'value' => '',
      'required' => false,
    ),
  );

  public function buildElement() {

    $this->addAttributes($this->getContext('attributes'));

    if ($this->getAttribute('value')) {
      $this->addChildren($this->getAttribute('value'));
      $this->removeAttribute('value');
    }
  }

  public function setValue($value) {
    foreach ($this->getChildrens() as $delta => $object) {
      $this->removeChildren($delta);
    }

    $this->addChildren($value);
  }
}