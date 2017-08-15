<?php
/**
 * Hooking into Visual Composer Frontend iFrame
 * before it got initialized
 *
 * @author jason.xie@victheme.com
 */
class VTCore_History_Actions_Vc__Load__IFrame__JsCss
extends VTCore_Wordpress_Models_Hook {

  public function hook() {

    VTCore_Wordpress_Utility::loadAsset('history-admin');
    VTCore_Wordpress_Utility::loadAsset('history-front');
    VTCore_Wordpress_Utility::loadAsset('jquery-pointconnector');

    VTCore_Wordpress_init::getFactory('assets')
      ->get('queues')
      ->remove('history-admin.js.history-admin-js');

  }
}