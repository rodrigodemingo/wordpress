<?php
/**
 * Helper class for bootstrap well
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Bootstrap_Element_BsWell
extends VTCore_Bootstrap_Element_Base {

  protected $context = array(
    'type' => 'div',
    'text' => '',
    'size' => '',
    'attributes' => array(
      'class' => array('well'),
     ),
  );

  public function buildElement() {
    $this->addAttributes($this->getContext('attributes'));
    
    if ($this->getContext('text')) {
      $this->setText($this->getContext('text'));
    }
    
    if ($this->getContext('size')) {
      $this->addClass($this->getContext('size'));
    }
  }
}