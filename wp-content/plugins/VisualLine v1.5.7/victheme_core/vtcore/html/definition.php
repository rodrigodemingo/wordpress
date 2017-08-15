<?php
/**
 * Build a standard definition HTML element
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Html_Definition
extends VTCore_Html_Base {

  protected $context = array(
    'type' => 'dl',
    'contents' => array(),
    'attributes' => array(),

    'title_elements' => array(
      'type' => 'dt',
      'attributes' => array(),
    ),

    'definition_elements' => array(
      'type' => 'dd',
      'attributes' => array(),
    ),
  );


  public function addTitle($title) {
    $dt = new VTCore_Html_Base($this->getContext('title_elements'));
    $dt->addChildren($title);
    $this->addChildren($dt);

    return $this;
  }


  public function addContent($content) {
    $dd = new VTCore_Html_Base($this->getContext('definition_elements'));
    $dd->addChildren($content);
    $this->addChildren($dd);

    return $this;
  }


  public function prependContent($content) {
    $dd = new VTCore_Html_Base($this->getContext('definition_elements'));
    $dd->addChildren($content);
    $this->prependChildren($dd);

    return $this;
  }

  public function buildElement() {
    $this->addAttributes($this->getContext('attributes'));
    foreach ($this->getContext('contents') as $data) {
      $this->addHeader($data['title']);

      foreach ($data['content'] as $content) {
        $this->addContent($content);
      }
    }
  }
}