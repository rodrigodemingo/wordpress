<?php
/**
 * Helper class for building HTML5 Video element
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Html_Video
extends VTCore_Html_Base {

  protected $context = array(
    'type' => 'video',
    'text' => '',
    'attributes' => array(
      'controls' => true,
      'width' => '',
      'height' => '',
      'preload' => 'none',
      'poster' => '',
      'loop' => false,
      'muted'=> false,
      'cover' => '',
    ),
    'sources' => array(),
    'tracks' => array(),
  );


  public function buildElement() {
    $this->addAttributes($this->getContext('attributes'));

    if ($this->getContext('sources')) {
      foreach ($this->getContext('sources') as $source) {
        $this->addChildren(new VTCore_Html_Source($source));
      }
    }

    if ($this->getContext('tracks')) {
      foreach ($this->getContext('tracks') as $track) {
        $this->addChildren(new VTCore_Html_Track($track));
      }
    }

    if ($this->getContext('text')) {
      $this->setText($this->getContext('text'));
    }
  }

}