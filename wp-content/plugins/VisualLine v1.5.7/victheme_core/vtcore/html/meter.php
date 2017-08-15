<?php
/**
 * Helper class for building meter element
 *
 * Required attributes :
 * min     : Lower bound of range
 * max     : Upper bound of range
 * value   : Current value of the element
 * low     : High limit of low range
 * high    : Low limit of high range
 * optimum : Optimum value in gauge
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Html_Meter
  extends VTCore_Html_Base {

  protected $context = array(
    'type' => 'meter',
    'attributes' => array(
      'min' => 0,
      'max' => 1,
      'value' => 0,
      'low' => false,
      'high' => false,
      'optimum' => false,
    ),
  );

  public function buildElement() {
    $this->addAttributes($this->getContext('attributes'));
    if ($this->getContext('text')) {
      $this->setText($this->getContext('text'));
    }
  }
}