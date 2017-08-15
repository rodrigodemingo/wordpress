<?php
/**
 * Hooking into Visual Composer Backend Editor
 * before it got initialized
 *
 * @author jason.xie@victheme.com
 */
class VTCore_TimeLine_Actions_Vc__Backend__Editor__Enqueue__Js__Css
extends VTCore_Wordpress_Models_Hook {

  public function hook() {
    VTCore_Wordpress_Utility::loadAsset('jquery-iconpicker');
    VTCore_Wordpress_Utility::loadAsset('font-awesome');
    VTCore_Wordpress_Utility::loadAsset('wp-bootstrap');
    VTCore_Wordpress_Utility::loadAsset('bootstrap-switch');
    VTCore_Wordpress_Utility::loadAsset('jquery-table-manager');
    VTCore_Wordpress_Utility::loadAsset('timeline-admin');
    VTCore_Wordpress_init::getFactory('assets')
      ->get('queues')
      ->remove('timeline-admin.js.timeline-admin-js');
  }
}