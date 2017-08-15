<?php
/**
 * Helper Class for building the Fontawesome Border selector
 *
 * @author jason.xie@victheme.com
 * @see VTCore_Form_Interface interface
 */
class VTCore_Fontawesome_Form_faBorder
extends VTCore_Fontawesome_Form_Base
implements VTCore_Form_Interface {

  protected $context = array(

    'text' => false,
    'prefix' => false,
    'suffix' => false,
    'description' => false,
    'required' => false,
    'value' => false,
    'id' => false,
    'class' => array('form-control', 'form-icons-border'),
    'name' => false,

    // BootStrap Rules
    'label' => true,

    // Wrapper element
    'type' => 'div',
    'attributes' => array(
      'class' => array('form-group'),
    ),

    // Internal use, Only override if needed
    'input_elements' => array(),

    'label_elements' => array(),
    'description_elements' => array(),
    'prefix_elements' => array(),
    'suffix_elements' => array(),
    'required_elements' => array(),
  );


  /**
   * Build a options valid for select element
   */
  protected function buildOptions() {

    $this->options = array(
      false => __('No', 'victheme_core'),
      true => __('Yes', 'victheme_core'),
    );

    return $this;
  }


}