<?php
/**
 * Action wp_enqueue_scripts for VTCore_Wordpress
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Actions_Wp__Enqueue__Scripts
extends VTCore_Wordpress_Models_Hook {

  protected $weight = 999;

  public function hook() {

    // Load the retina js as it is supported as core feature
    if (VTCore_Wordpress_Init::getFactory('coreConfig')->get('images.retinajs')) {
      VTCore_Wordpress_Init::getFactory('assets')
        ->get('queues')
        ->add('jquery-retina', array(
          'deps' => array(
            'jquery',
          ),
          'footer' => TRUE,
        ));
    }

    // Process collected assets at this point
    VTCore_Wordpress_Init::getFactory('assets')->process();

    // Centralized Google Fonts Loading
    VTCore_Wordpress_Init::getFactory('fonts')->loadFont();
  }

}