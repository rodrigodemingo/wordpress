<?php
/**
 * Action Init for VTCore_Wordpress
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Actions_Init
extends VTCore_Wordpress_Models_Hook {

  protected $weight = 999;


  /**
   * Encapsulating hook init and delayed
   * to late binding (999) allowing other
   * sub VTCore Plugin to allow to register
   * all hooks action and filter first before
   * this class methods initializes.
   *
   */
  public function hook() {

    // Booting the shortcodes factory
    VTCore_Wordpress_Init::getFactory('shortcodes')->filter()->initialize();

    // Booting the template factory
    VTCore_Wordpress_Init::getFactory('template')->detect();
  }

}