<?php
/**
 * Class for building Google Plus Share icon 
 * button.
 * 
 * User must provide the queries context
 * especially one with url as its key that
 * defines the actual share url to be given
 * to google plus.
 *       
 * @author jason.xie@victheme.com
 *
 */
class VTCore_SocialShare_Google
extends VTCore_SocialShare_Base {

  protected $context = array(
    'type' => 'a',
    'text' => '',
    'attributes' => array(
      'href' => 'https://plus.google.com/share',
    ),
    'queries' => array(),
    'querykey' => 'url',
    'icon_attributes' => array(
      'type' => 'div',
      'icon' => 'google-plus',
      'shape' => 'round',
      'background' => '',
      'color' => '',
      'position' => 'left',
      'margin' => '0 10px 0 0',    
    ),
  );
  
}