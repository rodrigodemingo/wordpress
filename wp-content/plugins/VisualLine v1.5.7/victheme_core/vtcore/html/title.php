<?php
/**
 * Helper class for building HTML title element
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Html_Title
extends VTCore_Html_Base {

  protected $context = array(
    'type' => 'title',
    'attributes' => array(),
  );

  public function buildElement() {
    $this->addAttributes($this->getContext('attributes'));
    $this->setText($this->getContext('text'));
  }
}