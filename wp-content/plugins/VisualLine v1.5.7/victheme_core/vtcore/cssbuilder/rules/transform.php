<?php
/**
 * CSSBuilder Rules object for defining css 2d transform.
 *
 * Valid keys that will be processed :
 * scale
 * scaleX
 * scaleY
 * skewX
 * skewY
 * translate
 * translateX
 * translateY
 * rotate
 * matrix
 * perspective
 * 
 * @author jason.xie@victheme.com
 *
 */
class VTCore_CSSBuilder_Rules_Transform
extends VTCore_CSSBuilder_Rules_Base {
  
  protected $type = 'transform';
  protected $prefix = array('-webkit-', '');
  protected $allowed = array(
    'scale',
    'scaleX',
    'scaleY',
    'skewX',
    'skewY',
    'translate',
    'translateX',
    'translateY',
    'rotate',
    'matrix',
    'persepective',
  );
  
  public function buildRule() {
    foreach ($this->prefix as $prefix) {
      foreach ($this->context as $key => $value) {
        if (!in_array($key, $this->allowed) || empty($value)) {
          continue;
        }

        $this->rules[] = $prefix . 'transform: ' . $key . '(' . $value . ')';

      }
    }
  }
  
}