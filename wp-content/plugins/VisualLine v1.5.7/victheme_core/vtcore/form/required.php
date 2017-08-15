<?php
/**
 * Helper Class for building the Required Elements
 *
 * @author jason.xie@victheme.com
 * @see VTCore_Form_Interface interface
 */
class VTCore_Form_Required
extends VTCore_Form_Base
implements VTCore_Form_Interface {

  protected $context = array(
    'text' => '*',
    'type' => 'span',
    'attributes' => array(
      'class' => array('required'),
    ),
  );

	public function buildElement() {
		$this->addAttributes($this->getContext('attributes'));
		$this->addChildren($this->getContext('text'));
	}
}