<?php
/**
 * Hooking into Visual Composer Backend Editor
 * before it got initialized
 *
 * @author jason.xie@victheme.com
 */
class VTCore_BubbleLine_Actions_Vc__Backend__Editor__Enqueue__Js__Css
extends VTCore_Wordpress_Models_Hook {

  public function hook() {
    VTCore_Wordpress_Utility::loadAsset('wp-bootstrap');
    VTCore_Wordpress_Utility::loadAsset('bubbleline-admin');
    VTCore_Wordpress_init::getFactory('assets')
      ->get('queues')
      ->remove('bubbleline-admin.js.bubbleline-admin-js');
  }
}