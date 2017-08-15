<?php
/**
 * Hooking into Visual Composer Front Editor
 * for loading admin script
 *
 * @author jason.xie@victheme.com
 */
class VTCore_TimeLine_Actions_Vc__Frontend__Editor__Enqueue__Js__Css
  extends VTCore_Wordpress_Models_Hook {

  public function hook() {
    VTCore_Wordpress_Utility::loadAsset('jquery-custom-scrollbar');
    VTCore_Wordpress_Utility::loadAsset('jquery-iconpicker');
    VTCore_Wordpress_Utility::loadAsset('bootstrap-switch');
    VTCore_Wordpress_Utility::loadAsset('jquery-table-manager');
    VTCore_Wordpress_Utility::loadAsset('timeline-front');
    VTCore_Wordpress_Utility::loadAsset('timeline-admin');

  }
}