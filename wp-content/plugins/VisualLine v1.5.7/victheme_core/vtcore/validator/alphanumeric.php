<?php
/**
 * Text validation class for testing alpha numeric
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Validator_Alphanumeric
extends VTCore_Validator_Base {

  public function validateText() {
    if ($this->getText() !== '') {
      return ctype_alnum($this->getText());
    }
    return true;
  }

}