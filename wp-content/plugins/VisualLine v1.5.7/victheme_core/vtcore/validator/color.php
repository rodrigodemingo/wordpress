<?php
/**
 * Text validation class for testing hex color value
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Validator_Color
extends VTCore_Validator_Base {

  public function validateText() {

    // No need to check for transparent or empty element
    if ($this->getText() == 'transparent' || $this->getText() === '') {
      return true;
    }

    // Test for hex
    $result = (bool) preg_match('/^#[a-f0-9]{6}$/i', $this->getText());

    // Test for RGBa, RGB, HSL, HSA Value
    if ($result == false) {
      $result = (bool) preg_match('/(rgba|rgb|hsl|hsla)\([0-9\,\.]+?\)/', $this->getText());
    }

    return $result;
  }

}