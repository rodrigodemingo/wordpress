<?php
/**
 * Text validation class for testing
* true css width entry.
*
* Valid entry :
* XXXpx
* XXX%
* top
* left
* right
* bottom
*
* @author jason.xie@victheme.com
*/
class VTCore_Validator_CSSPosition
extends VTCore_Validator_Base {

  private $position = array(
    'top',
    'left',
    'right',
    'bottom',
  );

  public function validateText() {

    if (!in_array($this->getText(), $this->position)
      && $this->getText() !== '') {

      return (bool) preg_match('/^-?(\d+)(px|%)$/i', $this->getText());
    }

    return true;
  }

}