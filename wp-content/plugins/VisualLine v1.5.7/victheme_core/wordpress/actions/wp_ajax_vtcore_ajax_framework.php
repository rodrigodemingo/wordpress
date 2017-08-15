<?php
/**
 * Action wp_ajax_vtcore_ajax_framework
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Actions_Wp__Ajax__VTCore__Ajax__Framework
extends VTCore_Wordpress_Models_Hook {

  public function hook() {

    $ajax = new VTCore_Wordpress_Ajax_Router_Admin();
    $ajax
      ->processData()
      ->checkValidity()
      ->checkPermission()
      ->render();

  }

}