<?php
/**
 * Hooking into wordpress admin_menu action
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Wordpress_Actions_ThemeCheck__Checks__Loaded
extends VTCore_Wordpress_Models_Hook {

  public function hook() {
    set_time_limit(99999999);
    ini_set('memory_limit', '1G');
  }
}