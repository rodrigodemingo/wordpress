<?php
/**
 * Helper class for building HTML5 article element
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Html_Article
extends VTCore_Html_Base {

  protected $context = array(
    'type' => 'article',
    'attributes' => array(),
  );

  public function buildElement() {
    $this->addAttributes($this->getContext('attributes'));
    if ($this->getContext('text')) {
      $this->setText($this->getContext('text'));
    }
  }
}