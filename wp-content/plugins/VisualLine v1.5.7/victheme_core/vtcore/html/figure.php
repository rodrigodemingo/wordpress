<?php
/**
 * Helper class for building figure element
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Html_Figure
extends VTCore_Html_Base {

  protected $context = array(
    'type' => 'figure',
    'text' => '',
    'attributes' => array(),
  );

  public function buildElement() {
    $this->addAttributes($this->getContext('attributes'));

    foreach ($this->getContext('contents') as $content) {
      $this->addChildren($content);
    }

    if ($this->getContext('text')) {
      $this->addChildren(new VTCore_Html_Element(array(
        'type' => 'figcaption',
        'text' => $this->getContext('text'),
      )));
    }
  }
}