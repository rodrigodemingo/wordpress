<?php
/**
 * Text validation class for testing value is less than maximum limit
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Validator_Max
extends VTCore_Validator_Base {

  private $limit;

  public function validateText() {
    if ($this->getLimit() !== NULL && $this->getText() !== '') {
      return ((float) $this->getText() <= (float) $this->getLimit());
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