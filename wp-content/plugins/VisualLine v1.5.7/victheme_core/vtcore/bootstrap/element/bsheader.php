<?php
/**
 * Helper class for building bootstrap header element
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Bootstrap_Element_BsHeader
extends VTCore_Bootstrap_Element_Base {

  protected $context = array(
    'type' => 'div',
    'text' => '',
    'tag' => 'h1',
    'small' => false,
    'attributes' => array(
      'class' => array(
        'page-header'
      ),
    ),
  );


  public function buildElement() {

    $this->addAttributes($this->getContext('attributes'));

    $this
      ->addChildren(new VTCore_Html_Element(array(
        'type' => $this->getContext('tag'),
      )))
      ->lastChild()
      ->addChildren($this->getContext('text'));

    if ($this->getContext('small')) {
      $this->lastChild()->addChildren(new VTCore_Html_Element(array(
        'type' => 'small',
        'text' => $this->getContext('small'),
      )));
    }
  }
}