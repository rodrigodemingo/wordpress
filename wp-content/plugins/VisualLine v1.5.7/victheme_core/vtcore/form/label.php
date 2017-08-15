<?php
/**
 * Helper Class for building the Label Form Elements
 *
 * @author jason.xie@victheme.com
 * @see VTCore_Form_Interface interface
 */
class VTCore_Form_Label
extends VTCore_Form_Base
implements VTCore_Form_Interface {

  protected $context = array(
    'type' => 'label',
    'text' => '',
    'attributes' => array(
      'for' => '',
      'id' => false,
      'class' => array(),
    ),
    'required' => false,
    'required_elements' => array(),
  );

	public function buildElement() {

	  $this->addAttributes($this->getContext('attributes'));
		$this->addChildren($this->getContext('text'));

		if ($this->getContext('required') == true) {
      $this->addChildren(new VTCore_Form_Required($this->getContext('required_elements')));
		}
	}
}