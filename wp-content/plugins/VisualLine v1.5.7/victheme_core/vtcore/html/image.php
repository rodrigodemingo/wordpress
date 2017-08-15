<?php
/**
 * Helper class for building img element
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Html_Image
extends VTCore_Html_Base {

  protected $context = array(
    'type' => 'img',
    'attributes' => array(
      'src' => '',
      'alt' => '',
      'width' => '',
      'height' => '',
      'ismap' => false,
      'usemap' => false,
    ),
  );

  public function buildElement() {
    $this->addAttributes($this->getContext('attributes'));
  }
}