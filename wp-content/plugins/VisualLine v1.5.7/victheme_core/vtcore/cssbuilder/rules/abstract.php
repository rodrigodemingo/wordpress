<?php
/**
 * CSSBuilder Rules object for defining abstract rules.
 * 
 * This is a special class that allows user
 * to define any css rules. the rules for this
 * class is to define valid css rule as the key
 * and define the value for its css rule value.
 * 
 * example :
 * $context = array(
 *   'margin-left' => '0px',
 * );
 * 
 * result :
 * margin-left: 0px;
 * 
 * @author jason.xie@victheme.com
 *
 */
class VTCore_CSSBuilder_Rules_Abstract
extends VTCore_CSSBuilder_Rules_Base
implements VTCore_CSSBuilder_Rules_Interface {
  
  protected $type = 'abstract'; 
  
  public function buildRule() {
    
    foreach ($this->context as $key => $value) {
      $this->rules[] = $key . ': ' . $value;
    }

  }
  
}