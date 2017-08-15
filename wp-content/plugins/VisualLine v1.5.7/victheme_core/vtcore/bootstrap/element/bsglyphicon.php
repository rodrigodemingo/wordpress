<?php
/**
 * Helper class for building bootstrap glyphicon
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Bootstrap_Element_BsGlyphicon
extends VTCore_Bootstrap_Element_Base {

  protected $context = array(
    'type' => 'span',
    'icon' => '',
    'size' => false,
    'color' => false,
    'attributes' => array(
      'class' => array(
        'glyphicon',
      ),
    ),
  );

  protected $sizes = array(
    'glyphicon-lg',
    'glyphicon-2x',
    'glyphicon-3x',
    'glyphicon-4x',
    'glyphicon-5x',
  );

  public function buildElement() {
    $this->addAttributes($this->getContext('attributes'));

    if (in_array($this->getContext('size'), $this->sizes)) {
      $this->addClass($this->getContext('size'));
    }

    if ($this->getContext('color')) {
      $this->addStyle('color', $this->getContext('color'));
    }

    $this->addClass('glyphicon-' . $this->getContext('icon'));
  }
}