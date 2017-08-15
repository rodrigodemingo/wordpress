<?php
/**
 * Action wp_footer for VTCore_Wordpress
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Actions_Admin__Footer
extends VTCore_Wordpress_Models_Hook {

  /**
   * Must run in low weight before
   * the actual wp printing script
   * functions
   */
  protected $weight = 11;

  public function hook() {

    // Last chance to grab all the rest of the late
    // binded assets
    VTCore_Wordpress_Init::getFactory('assets')->process();
  }

}