<?php
/**
 * Helper Class for building the Suffix Elements
 */
class VTCore_Bootstrap_Form_BsSuffix
extends VTCore_Bootstrap_Form_Base
implements VTCore_Form_Interface {

  protected $context = array(
    'text' => '',
    'type' => 'span',
    'attributes' => array(
      'class' => array('input-group-addon'),
    ),
  );

	public function buildElement() {
		$this->addAttributes($this->getContext('attributes'));
		$this->setText($this->getContext('text'));
	}
}