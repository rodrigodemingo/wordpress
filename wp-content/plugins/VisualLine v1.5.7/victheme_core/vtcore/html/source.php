<?php
/**
 * Helper class for building HTML5 Source Element
 * for audio and video element
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Html_Source
extends VTCore_Html_Base {

  protected $context = array(
    'type' => 'source',
    'attributes' => array(
      'src' => '',
      'type' => '',
     ),
  );
}