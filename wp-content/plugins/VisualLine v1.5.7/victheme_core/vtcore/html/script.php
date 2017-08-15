<?php
/**
 * Helper class for building HTML5 script element
 *
 * Note: Script requires the innerHTML to be wrapped
 *       in CDATA.
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Html_Script
extends VTCore_Html_Base {

  protected $context = array(
    'type' => 'script',
    'attributes' => array(
      'type' => 'text/javascript',
      'src' => '',
      'async' => '',
      'defer' => '',
      'charset' => '',
     ),
  );
}