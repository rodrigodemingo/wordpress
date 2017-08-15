<?php
/**
 * Building Bootstrap form for selecting jQuery Easing.
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_jQuery_Form_Easing
extends VTCore_Bootstrap_Form_BsSelect
implements VTCore_Form_Interface {

  protected $easing = array(
    'swing' => 'swing',
    'easeInQuad' =>  'easeInQuad',
    'easeOutQuad' => 'easeOutQuad',
    'easeInOutQuad' => 'easeInOutQuad',
    'easeInCubic' => 'easeInCubic',
    'easeOutCubic' => 'easeOutCubic',
    'easeInOutCubic' => 'easeInOutCubic',
    'easeInQuart' => 'easeInQuart',
    'easeOutQuart' => 'easeOutQuart',
    'easeInOutQuart' => 'easeInOutQuart',
    'easeInQuint' => 'easeInQuint',
    'easeOutQuint' => 'easeOutQuint',
    'easeInOutQuint' => 'easeInOutQuint',
    'easeInSine' => 'easeInSine',
    'easeOutSine' => 'easeOutSine',
    'easeInOutSine' => 'easeInOutSine',
    'easeInExpo' => 'easeInExpo',
    'easeOutExpo' => 'easeOutExpo',
    'easeInOutExpo' => 'easeInOutExpo',
    'easeInCirc' => 'easeInCirc',
    'easeOutCirc' => 'easeOutCirc',
    'easeInOutCirc' => 'easeInOutCirc',
    'easeInElastic' => 'easeInElastic',
    'easeOutElastic' => 'easeOutElastic',
    'easeInOutElastic' => 'easeInOutElastic',
    'easeInBack' => 'easeInBack',
    'easeOutBack' => 'easeOutBack',
    'easeInOutBack' => 'easeInOutBack',
    'easeInBounce' => 'easeInBounce',
    'easeOutBounce' => 'easeOutBounce',
    'easeInOutBounce' => 'easeInOutBounce',
  );


  public function buildElement() {
    $this->addContext('options', $this->easing);

    parent::buildElement();
  }

}