<?php
/**
 * Hooking into Visual Composer Backend Editor
 * before it got initialized
 *
 * @author jason.xie@victheme.com
 */
class VTCore_History_Actions_Vc__Backend__Editor__Enqueue__Js__Css
extends VTCore_Wordpress_Models_Hook {

  public function hook() {
    VTCore_Wordpress_Utility::loadAsset('wp-bootstrap');
    VTCore_Wordpress_Utility::loadAsset('history-admin');
    VTCore_Wordpress_init::getFactory('assets')
      ->get('queues')
      ->remove('history-admin.js.history-admin-js');
  }
}