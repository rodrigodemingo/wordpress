<?php
/**
 * CSSBuilder Rules object for defining css padding rules.
 * 
 * Available keys :
 * top
 * right
 * bottom
 * left
 * 
 * @author jason.xie@victheme.com
 *
 */
class VTCore_CSSBuilder_Rules_Padding
extends VTCore_CSSBuilder_Rules_Base
implements VTCore_CSSBuilder_Rules_Interface {
  
  protected $type = 'padding'; 
  
  public function buildRule() {
    
    foreach ($this->context as $key => $value) {
      $this->rules[] = 'padding-' . $key . ': ' . $value;
    }

  }
  
}