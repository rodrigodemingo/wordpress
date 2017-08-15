<?php
/**
 * Helper class for building HTML5 Link element
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Html_Link
extends VTCore_Html_Base {

  protected $context = array(
    'type' => 'link',
    'attributes' => array(
      'type' => 'text/css',
      'href' => '',
      'hreflang' => '',
      'media' => 'all',
      'rel' => 'stylesheet',
      'size' => '',
     ),
  );
}