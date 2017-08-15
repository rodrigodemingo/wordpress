<?php
/**
 * Text validation class for testing if text is empty
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Validator_Empty
extends VTCore_Validator_Base {

  public function validateText() {
    return ($this->getText() !== '');
  }

}