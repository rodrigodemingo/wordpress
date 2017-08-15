<?php
/**
 * Text validation class for testing 
 * true css width entry.
 * 
 * Valid entry :
 * XXXpx
 * XXX%
 * auto
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Validator_CSSSize
extends VTCore_Validator_Base {

  public function validateText() {
    
    if ($this->getText() !== 'auto' && $this->getText() !== '') {
      return (bool) preg_match('/^(\d+)(px|%)$/i', $this->getText());
    }
    
    return true;
  }

}