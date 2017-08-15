<?php
/**
 * Helper class for building bootstrap badge
 *
 * This class should be inserted to other class as children
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Bootstrap_Element_BsBadge
extends VTCore_Bootstrap_Element_Base {

  protected $context = array(
    'type' => 'span',
    'text' => '',
    'attributes' => array(
      'class' => array('badge')
    ),
  );

  public function buildElement() {
    $this->addAttributes($this->getContext('attributes'));

    if ($this->getContext('text')) {
      $this->setText($this->getContext('text'));
    }
  }
}