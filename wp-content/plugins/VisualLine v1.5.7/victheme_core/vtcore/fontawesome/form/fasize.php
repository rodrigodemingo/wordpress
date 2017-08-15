<?php
/**
 * Helper Class for building the Fontawesome Size selector
 *
 * @author jason.xie@victheme.com
 * @see VTCore_Form_Interface interface
 */
class VTCore_Fontawesome_Form_faSize
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
    'class' => array('form-control', 'form-icons-size'),
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
      false => __('Normal', 'victheme_core'),
      'lg' => __('Large', 'victheme_core'),
      '2x' => __('2x', 'victheme_core'),
      '3x' => __('3x', 'victheme_core'),
      '4x' => __('4x', 'victheme_core'),
      '5x' => __('5x', 'victheme_core'),
    );

    return $this;
  }

}