<?php
/**
 * CSSBuilder Rules object for defining css background rules.
 *
 * Valid Context array that will be processed:
 * color
 * image   : array or string for width as in normal CSS rules
 * position
 *    : array or string for width as in normal CSS rules
 * repeat  : array or string for width as in normal CSS rules
 * size  : array or string for width as in normal CSS rules
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_CSSBuilder_Rules_Background
extends VTCore_CSSBuilder_Rules_Base
implements VTCore_CSSBuilder_Rules_Interface {

  protected $type = 'background';
  protected $validKeys = array(
    'image',
    'position',
    'color',
    'repeat',
    'size',
    'attachment',
    'gradient',
  );

  public function buildRule() {

    foreach ($this->context as $key => $value) {

      if (!in_array($key, $this->validKeys) || $value == '') {
        continue;
      }

      // Normal background
      if ($key != 'gradient') {
        $value = (array) $value;
        if ($key == 'image') {
          foreach ($value as $i => $image) {
            $value[$i] = 'url(' . $image . ')';
          }
        }

        $this->rules[] = 'background-' . $key . ': ' . implode(', ', $value);
      }

      // Build gradient
      if ($key === 'gradient'
          && is_array($value)
          && !empty($value)) {

        $object = new VTCore_CSSBuilder_Gradient($value);
        foreach($object->getRules() as $rule) {
          $this->rules[] = $rule;
        }

        unset($object);
      }
    }

  }

}