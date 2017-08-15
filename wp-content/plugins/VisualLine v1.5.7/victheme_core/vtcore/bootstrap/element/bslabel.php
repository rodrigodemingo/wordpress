<?php
/**
 * Helper class for building bootstrap label
 *
 * This class should be inserted to other class as children
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Bootstrap_Element_BsLabel
extends VTCore_Bootstrap_Element_Base {

  protected $context = array(
    'type' => 'span',
    'label' => 'default',
    'text' => '',
    'attributes' => array(
      'class' => array('label')
    ),
  );

  public function buildElement() {
    $this->addAttributes($this->getContext('attributes'));
    $this->addClass('label-' . $this->getContext('label'));

    if ($this->getContext('text')) {
      $this->setText($this->getContext('text'));
    }
  }
}