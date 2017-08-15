<?php
/**
 * Helper Class for building the Input Password Form Elements
 *
 * @author jason.xie@victheme.com
 * @see VTCore_Form_Interface interface
 */
class VTCore_Form_Password
extends VTCore_Form_Base
implements VTCore_Form_Interface {

  protected $context = array(
    'type' => 'input',
    'attributes' => array(
      'id' => false,
      'class' => array(),
      'name' => '',
      'size' => false,
      'value' => '',
      'required' => false,
      'type' => 'password',
    ),
  );

}