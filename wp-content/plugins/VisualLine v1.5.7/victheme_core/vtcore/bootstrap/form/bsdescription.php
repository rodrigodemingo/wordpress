<?php
/**
 * Helper Class for building the Description Elements
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Bootstrap_Form_BsDescription
extends VTCore_Bootstrap_Form_Base
implements VTCore_Form_Interface {

  protected $context = array(
    'text' => '',
    'type' => 'p',
    'attributes' => array(
      'class' => array('help-block'),
    ),
    'raw' => true,
  );

  public function buildElement() {
    $this->addAttributes($this->getContext('attributes'));
    $this->setText($this->getContext('text'));
  }
}