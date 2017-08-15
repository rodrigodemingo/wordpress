<?php
/**
 * Text validation class for testing value is less than maximum character length
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Validator_Maxlength
extends VTCore_Validator_Base {

  private $limit;

  public function validateText() {
    if ($this->getText() != '') {
      return (strlen(trim($this->getText())) < $this->getLimit());
    }
    return true;
  }

  public function getLimit() {
    return $this->limit;
  }

  public function setLimit($limit) {
    $this->limit = $limit;
  }
}