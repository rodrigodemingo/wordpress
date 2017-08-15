<?php
/**
 * Helper Class for building the Input Date Form Elements
 *
 * @author jason.xie@victheme.com
 * @see VTCore_Html_Form interface
 */
class VTCore_Form_Date
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
      'type' => 'date',
      'min' => false,
      'max' => false,
    ),
  );

}