<?php
/**
 * Helper Class for building the Input Tel Form Elements
 *
 * @author jason.xie@victheme.com
 * @see VTCore_Form_Interface interface
 */
class VTCore_Form_Tel
extends VTCore_Form_Base
implements VTCore_Form_Interface {

  protected $context = array(
    'type' => 'input',
    'attributes' => array(
      'id' => false,
      'class' => array(),
      'name' => '',
      'value' => '',
      'placeholder' => false,
      'required' => false,
      'type' => 'url',
    ),
  );

}