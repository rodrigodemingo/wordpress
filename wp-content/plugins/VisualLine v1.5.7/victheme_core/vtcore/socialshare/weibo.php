<?php
/**
 * Class for building Weibo Share icon
 * button.
 * 
 * User must provide the queries context
 * especially one with url as its key that
 * defines the actual share url to be given
 * to weibo.
 *       
 * @author jason.xie@victheme.com
 *
 */
class VTCore_SocialShare_Weibo
extends VTCore_SocialShare_Base {

  protected $context = array(
    'type' => 'a',
    'text' => '',
    'queries' => array(),
    'querykey' => 'url',
    'attributes' => array(
      'href' => 'http://service.weibo.com/share/share.php',
    ),
    'icon_attributes' => array(
      'type' => 'div',
      'icon' => 'weibo',
      'shape' => 'round',
      'background' => '',
      'color' => '',
      'position' => 'left',
      'margin' => '0 10px 0 0',
    ),
  );
}