<?php
/**
 * Helper Class for building the Input Text Form Elements
 *
 * @author jason.xie@victheme.com
 * @see VTCore_Form_Interface interface
 */
class VTCore_Form_Text
extends VTCore_Form_Base
implements VTCore_Form_Interface {

  protected $context = array(
    'type' => 'input',
    'attributes' => array(
      'id' => false,
      'class' => array(),
      'name' => '',
      'size' => false,
      'maxlength' => false,
      'value' => '',
      'placeholder' => false,
      'required' => false,
      'type' => 'text',
    ),
  );

}