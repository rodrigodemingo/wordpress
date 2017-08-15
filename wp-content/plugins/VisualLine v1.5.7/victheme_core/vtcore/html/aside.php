<?php
/**
 * Helper class for building HTML5 Aside element
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Html_Aside
extends VTCore_Html_Base {

  protected $context = array(
    'type' => '',
    'attributes' => array(),
  );

  public function buildElement() {
    $this->addAttributes($this->getContext('attributes'));
    if ($this->getContext('text')) {
      $this->setText($this->getContext('text'));
    }
  }
}