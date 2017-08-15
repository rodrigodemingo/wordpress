<?php
/**
 * Helper class for building HTML Meta element
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Html_Meta
extends VTCore_Html_Base {

  protected $context = array(
    'type' => 'meta',
    'attributes' => array(),
  );

  public function buildElement() {
    $this->addAttributes($this->getContext('attributes'));
  }
}