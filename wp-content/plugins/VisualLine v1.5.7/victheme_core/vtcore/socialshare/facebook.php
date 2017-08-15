<?php
/**
 * Class for building Facebook Share icon 
 * button.
 * 
 * User must provide the queries context
 * especially one with url as its key that
 * defines the actual share url to be given
 * to facebook.
 *       
 * @author jason.xie@victheme.com
 *
 */
class VTCore_SocialShare_Facebook
extends VTCore_SocialShare_Base {

  protected $context = array(
    'type' => 'a',
    'text' => '',
    'queries' => array(),
    'querykey' => 'u',
    'attributes' => array(
      'href' => 'http://www.facebook.com/sharer/sharer.php',
    ),
    'icon_attributes' => array(
      'type' => 'div',
      'icon' => 'facebook',
      'shape' => 'round',
      'background' => '',
      'color' => '',
      'position' => 'left',
      'margin' => '0 10px 0 0',
    ),
  );
}