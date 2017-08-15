<?php
/**
 * Helper Class for building the Button Form Elements
 *
 * @author jason.xie@victheme.com
 * @see VTCore_Form_Interface interface
 */
class VTCore_Form_Button
extends VTCore_Form_Base
implements VTCore_Form_Interface {

  protected $context = array(
    'type' => 'button',
    'text' => '',
    'attributes' => array(
      'id' => false,
      'class' => array(),
      'name' => '',
      'value' => '',
      'type' => 'button',
    ),
  );

	public function buildElement() {
		$this->addAttributes($this->getContext('attributes'));
		$this->addChildren($this->getContext('text'));
	}

}