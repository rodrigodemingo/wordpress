<?php
/**
 * Hooking into Visual Composer Frontend iFrame
 * before it got initialized
 *
 * @author jason.xie@victheme.com
 */
class VTCore_BubbleLine_Actions_Vc__Load__IFrame__JsCss
extends VTCore_Wordpress_Models_Hook {

  public function hook() {
    VTCore_Wordpress_Utility::loadAsset('bubbleline-admin');
    VTCore_Wordpress_Utility::loadAsset('bubbleline-front');
    VTCore_Wordpress_init::getFactory('assets')
      ->get('queues')
      ->remove('bubbleline-admin.js.bubbleline-admin-js');

  }
}