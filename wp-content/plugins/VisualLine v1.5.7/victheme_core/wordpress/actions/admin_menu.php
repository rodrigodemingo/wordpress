<?php
/**
 * Link to Wordpress Action admin_menu for
 * registering Core Administration menus.
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Actions_Admin__Menu
extends VTCore_Wordpress_Models_Hook {

  public function hook() {

    // Victheme Core general configuration
    add_menu_page(
      'Core Options',
      'VicTheme Core',
      'manage_options',
      'vtcore-configuration',
      array(new VTCore_Wordpress_Pages_Config(), 'buildPage'),
      'dashicons-admin-settings');
  }
}