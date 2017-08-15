<?php
/**
 * Helper class for building HTML5 Audio element
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Html_Audio
extends VTCore_Html_Base {

  protected $context = array(
    'type' => 'audio',
    'text' => '',
    'attributes' => array(
      'controls' => true,
      'width' => '',
      'height' => '',
      'preload' => 'none',
      'poster' => '',
      'loop' => false,
      'muted'=> false,

    ),
    'sources' => array(),
  );


  public function buildElement() {
    $this->addAttributes($this->getContext('attributes'));

    foreach ($this->getContext('sources') as $source) {
      $this->addChildren($source);
    }

    if ($this->getContext('text')) {
      $this->setText($this->getContext('text'));
    }
  }
}