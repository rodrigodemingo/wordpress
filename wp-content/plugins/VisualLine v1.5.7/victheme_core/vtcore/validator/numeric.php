<?php
/**
 * Text validation class for testing valid number
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Validator_Numeric
extends VTCore_Validator_Base {

  public function validateText() {

    if ($this->getText() != '') {
      return is_numeric($this->getText());
    }

    return true;
  }

}