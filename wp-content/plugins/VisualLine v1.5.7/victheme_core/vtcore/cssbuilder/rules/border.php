<?php
/**
 * CSSBuilder Rules object for defining css border rules.
 * 
 * Valid Context array that will be processed:
 * width   : array or string for width as in normal CSS rules
 * style   : array or string for style as in normal CSS rules
 * color   : array or string for color as in normal CSS rules
 * radius  : array or string for radius as in normal CSS rules
 * 
 * @author jason.xie@victheme.com
 *
 */
class VTCore_CSSBuilder_Rules_Border
extends VTCore_CSSBuilder_Rules_Base
implements VTCore_CSSBuilder_Rules_Interface {
  
  protected $type = 'border'; 
  
  public function buildRule() {
    
   $width = $this->getContext('width');
   if ($width) {
     $this->rules[] = 'border-width: ' . implode(' ', (array) $width); 
   }
    
   $style = $this->getContext('style');
   if ($style) {
     $this->rules[] = 'border-style: ' . implode(' ', (array) $style);
   }
    
   $color = $this->getContext('color');
   if ($color) {
     $this->rules[] = 'border-color: ' . implode(' ', (array) $color);
   }
    
   $radius = $this->getContext('radius');
   if ($radius) {
     foreach ($this->prefix as $prefix) {
       $this->rules[] = $prefix . 'border-radius: ' . implode(' ', (array) $radius);
     }
   }
 }
  
}