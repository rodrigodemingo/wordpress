<?php
/**
 * Action admin_enqueue_scripts for VTCore_Wordpress
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Actions_Admin__Enqueue__Scripts
extends VTCore_Wordpress_Models_Hook {

  protected $weight = 999;

  public function hook() {

    // Load properly registered assets loaded
    // via admin_enqueue_scripts action any
    // late binder will be processed at admin_footer
    // action.
    VTCore_Wordpress_Init::getFactory('assets')->process();

  }

}