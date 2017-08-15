<?php
/**
 * Helper class for building HTML5 time element
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Html_Time
extends VTCore_Html_Base {

  protected $context = array(
    'type' => 'time',
    'attributes' => array(
      'datetime' => '',
    ),
  );
}