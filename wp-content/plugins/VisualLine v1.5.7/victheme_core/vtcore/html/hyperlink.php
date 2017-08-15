<?php
/**
 * Helper class for building link element
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Html_HyperLink
extends VTCore_Html_Base {

  protected $context = array(
    'type' => 'a',
    'text' => '',
    'attributes' => array(
      'href' => '',
      'title' => '',
    ),
  );

  public function buildElement() {
    $this->addAttributes($this->getContext('attributes'));
    if ($this->getContext('text')) {
      $this->setText($this->getContext('text'));
    }
  }
}