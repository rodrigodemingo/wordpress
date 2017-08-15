<?php
/**
 * Interface for Rules subclasses
 */
interface VTCore_CSSBuilder_Rules_Interface {
  function buildRule();
}

/**
 * Abstract class meant to be extended
 * by rules sub classes
 *
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_CSSBuilder_Rules_Base {

  protected $type;
  protected $rules = array();
  protected $context = array();
  protected $prefix = array(
    '-webkit-',
    '-moz-',
    '-ms-',
    '-o-',
    '',
  );


  public function __construct($context) {
    $this->context= $context;
    $this->cleanContext();
    $this->buildRule();
  }

  public function cleanContext() {
    foreach ($this->context as $key => $value) {
      if ($value == '__i__') {
        unset($this->context[$key]);
      }
    }
    return $this;
  }

  public function __toString() {
    $rule = implode(";\n  ", $this->rules);
    if (!empty($rule)) {
      return '  ' . $rule . ";\n";
    }
    return $rule;
  }

  public function getType() {
    return $this->type;
  }

  public function getRules() {
    return $this->rules;
  }

  public function buildRule() {}

  public function getContext($type) {
    return isset($this->context[$type]) ? $this->context[$type] : NULL;
  }

}