<?php
/**
 * CSSBuilder Rules object for defining css animation rules.
 * 
 * Just extending the Rules Abstract as each keys
 * can be built using the abstract class

 * Available keys :
 * name
 * delay
 * direction
 * duration
 * fill-mode
 * iteration-count
 * play-state
 * timing-function
 * 
 * @author jason.xie@victheme.com
 *
 */
class VTCore_CSSBuilder_Rules_Animation
extends VTCore_CSSBuilder_Rules_Base {
  
  protected $type = 'animation';
  protected $prefix = array('-webkit-', '');
  
  public function buildRule() {
    foreach ($this->prefix as $prefix) {
      foreach ($this->context as $key => $value) {
        $this->rules[] = $prefix . 'animation-' . $key . ': ' . $value;
      }
    }
  }
  
}