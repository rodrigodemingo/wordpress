<?php
/**
 * Helper class for building HTML Style element
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Html_Style
extends VTCore_Html_Base {

  protected $context = array(
    'type' => 'style',
    'attributes' => array(
      'type' => 'text/css',
      'scope' => '',
      'media' => '',
     ),
  );
}