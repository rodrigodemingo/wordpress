<?php
/**
 * Helper class for building HTML5 output element
 *
 * attributes :
 * for
 * name
 * form
 *
 * IE 9-10 must load the polyfill.
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Html_Progress
  extends VTCore_Html_Base {

  protected $context = array(
    'type' => 'progress',
    'attributes' => array(
      'name' => '',
      'form' => false,
      'for' => false,
    ),
  );

  public function buildElement() {
    $this->addAttributes($this->getContext('attributes'));
    if ($this->getContext('text')) {
      $this->setText($this->getContext('text'));
    }
  }
}
