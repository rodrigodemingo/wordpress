<?php
/**
 * Helper class for building HTML5 nav element
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Html_Nav
extends VTCore_Html_Base {

  protected $context = array(
    'type' => 'nav',
    'attributes' => array(),
  );

  public function buildElement() {
    $this->addAttributes($this->getContext('attributes'));
    if ($this->getContext('text')) {
      $this->setText($this->getContext('text'));
    }
  }
}