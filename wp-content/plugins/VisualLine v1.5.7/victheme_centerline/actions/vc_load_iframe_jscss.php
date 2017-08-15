<?php
/**
 * Hooking into Visual Composer Frontend iFrame
 * before it got initialized
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Centerline_Actions_Vc__Load__IFrame__JsCss
extends VTCore_Wordpress_Models_Hook {

  public function hook() {
    VTCore_Wordpress_Utility::loadAsset('centerline-admin');
    VTCore_Wordpress_Utility::loadAsset('centerline-front');
    VTCore_Wordpress_init::getFactory('assets')
      ->get('queues')
      ->remove('centerline-admin.js.centerline-admin-js');

  }
}