<?php
/**
 * Helper class for building footer element
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Html_Footer
extends VTCore_Html_Base {

  protected $context = array(
    'type' => 'footer',
    'attributes' => array(),
  );

  public function buildElement() {
    $this->addAttributes($this->getContext('attributes'));
    if ($this->getContext('text')) {
      $this->setText($this->getContext('text'));
    }
  }
}