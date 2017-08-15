<?php
/**
 * Helper Class for building the Legend Form Elements
 *
 * @author jason.xie@victheme.com
 * @see VTCore_Form_Interface interface
 */
class VTCore_Form_Legend
extends VTCore_Form_Base
implements VTCore_Form_Interface {

	protected $context = array(
    'type' => 'legend',
    'text' => '',
    'attributes' => array(
      'class' => array(),
    ),

    'wrapper_elements' => array(
      'type' => 'span',
      'attributes' => array(
        'class' => array(),
      ),
    ),
  );

	public function buildElement() {
	  $this->addAttributes($this->getContext('attributes'));

	  $object = new VTCore_Form_Base($this->getContext('wrapper_elements'));
	  $object->addChildren($this->getContext('text'));

	  $this->addChildren($object);
	}
}