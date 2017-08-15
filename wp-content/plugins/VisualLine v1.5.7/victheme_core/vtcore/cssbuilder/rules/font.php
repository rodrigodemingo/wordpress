<?php
/**
 * CSSBuilder Rules object for defining css font rules.
 *
 * Valid Context array that will be processed:
 * color
 * family
 * size
 * size-adjust
 * stretch
 * style
 * variant
 * weight
 *
 * shadow
 * height
 * spacing
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_CSSBuilder_Rules_Font
extends VTCore_CSSBuilder_Rules_Base
implements VTCore_CSSBuilder_Rules_Interface {

  protected $type = 'font';

  public function buildRule() {

    foreach ($this->context as $key => $value) {

      if ($value == '__i__') {
        continue;
      }

      $rule = 'font-' . $key;

      if ($key == 'color') {
        $rule = $key;
      }

      if ($key == 'height') {
        $rule = 'line-height';
      }

      if ($key == 'shadow') {
        $rule = 'text-shadow';
      }

      if ($key == 'spacing') {
        $rule = 'letter-spacing';
      }

      $value = str_replace(array('"', "'"), array('', ''), $value);

      if ($key == 'family') {
        $exploded = explode(',' , $value);
        foreach ($exploded as $delta => $val) {

          $val = trim($val);

          if (strpos($val, ' ') !== false || strpos($val, '+') !== false) {
            $val = '"' . str_replace(array('+'), array(' '), $val) . '"';
          }

          $exploded[$delta] = $val;
        }
        $value = implode(', ', $exploded);
      }

      $this->rules[] = $rule  . ': ' . $value;
    }
  }

}