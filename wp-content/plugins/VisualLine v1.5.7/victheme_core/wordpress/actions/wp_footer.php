<?php
/**
 * Action wp_footer for VTCore_Wordpress
 *
 * @note
 *   Somehow wordpress will not process the queue
 *   properly on weight larger than 11.
 *
 *   Sub classes that is registering / enqueuing asset
 *   must use weight lower than 11 or it wont get
 *   picked up by the final asset processing invoked
 *   by this class
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Actions_Wp__Footer
extends VTCore_Wordpress_Models_Hook {

  protected $weight = 11;

  public function hook() {

    // Last chance to grab all the rest of the late
    // binded assets
    VTCore_Wordpress_Init::getFactory('assets')->process();

  }

}