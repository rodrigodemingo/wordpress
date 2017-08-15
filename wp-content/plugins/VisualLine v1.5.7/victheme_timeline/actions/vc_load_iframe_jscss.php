<?php
/**
 * Hooking into Visual Composer Frontend iFrame
 * before it got initialized
 *
 * @author jason.xie@victheme.com
 */
class VTCore_TimeLine_Actions_Vc__Load__IFrame__JsCss
extends VTCore_Wordpress_Models_Hook {

  public function hook() {
    VTCore_Wordpress_Utility::loadAsset('font-awesome');
    VTCore_Wordpress_Utility::loadAsset('jquery-custom-scrollbar');
    VTCore_Wordpress_Utility::loadAsset('bootstrap-switch');
    VTCore_Wordpress_Utility::loadAsset('jquery-table-manager');
    VTCore_Wordpress_Utility::loadAsset('timeline-front');
    VTCore_Wordpress_Utility::loadAsset('timeline-admin');
    VTCore_Wordpress_Utility::loadAsset('timeline-skins');
    VTCore_Wordpress_init::getFactory('assets')
      ->get('queues')
      ->remove('timeline-admin.js.timeline-admin-js');

  }
}