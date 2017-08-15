<?php
/**
 * Text validation class for testing valid URL
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Validator_Url
extends VTCore_Validator_Base {

  public function validateText() {
    if ($this->getText() !== '') {
      return (filter_var($this->getText(), FILTER_VALIDATE_URL) !== FALSE);
    }

    return true;
  }

}