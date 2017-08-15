<?php
/**
 * CSSBuilder Rules object for defining css margin rules.
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
class VTCore_CSSBuilder_Rules_Margin
extends VTCore_CSSBuilder_Rules_Base
implements VTCore_CSSBuilder_Rules_Interface {
  
  protected $type = 'margin'; 
  
  public function buildRule() {
    
    foreach ($this->context as $key => $value) {
      $this->rules[] = 'margin-' . $key . ': ' . $value;
    }

  }
  
}