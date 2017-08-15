<?php
/**
 * Text validation class for testing valid number
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Validator_Number
extends VTCore_Validator_Base {

  public function validateText() {

    if ($this->getText() != '') {
      return ctype_digit((string) $this->getText());
    }

    return true;
  }

}