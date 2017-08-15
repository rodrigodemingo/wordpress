<?php
/**
 * Helper class for building bootstrap jumbotron
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Bootstrap_Element_BsJumbotron
extends VTCore_Bootstrap_Element_Base {

  protected $context = array(
    'type' => 'div',
    'fullsize' => false,
    'attributes' => array(
      'class' => array('jumbotron'),
    ),
  );

  protected $content;

  public function buildElement() {
    $this->addAttributes($this->getContext('attributes'));

    if ($this->getContext('fullsize')) {
      $this->content = $this->addChildren(new VTCore_Bootstrap_Element_BsElement(array(
        'type' => 'div',
        'attributes' => array(
          'class' => array('container'),
        ),
      )))
      ->lastChild();

      $this->setChildrenPointer('content');
    }

    if ($this->getContext('text')) {
      $this->addChildren($this->getContext('text'));
    }
  }
}