<?php
/**
 * Helper class for building HTML code element
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Html_Code
extends VTCore_Html_Base {

  protected $context = array(
    'type' => 'code',
    'attributes' => array(),
    'raw' => true,
  );

  public function buildElement() {
    $this->addAttributes($this->getContext('attributes'));
    if ($this->getContext('text')) {
      $this->setText($this->getContext('text'));
    }
  }
}