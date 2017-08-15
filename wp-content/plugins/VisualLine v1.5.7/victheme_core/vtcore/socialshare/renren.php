<?php
/**
 * Class for building RenRen Share icon
 * button.
 * 
 * User must provide the queries context
 * especially one with url as its key that
 * defines the actual share url to be given
 * to renren.
 *       
 * @author jason.xie@victheme.com
 *
 */
class VTCore_SocialShare_RenRen
extends VTCore_SocialShare_Base {

  protected $context = array(
    'type' => 'a',
    'text' => '',
    'queries' => array(),
    'querykey' => 'link',
    'attributes' => array(
      'href' => 'http://share.renren.com/share/buttonshare.do',
    ),
    'icon_attributes' => array(
      'type' => 'div',
      'icon' => 'renren',
      'shape' => 'round',
      'background' => '',
      'color' => '',
      'position' => 'left',
      'margin' => '0 10px 0 0',
    ),
  );
}