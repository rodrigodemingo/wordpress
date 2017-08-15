<?php
/**
 * Extending VTCore default shortcodes models
 * to add processor relevant to visual composer.
 *
 * @todo when all related plugin use this method, move the convert vc grid logic
 *       into this base class!
 * @author jason.xie@victheme.com
 */
abstract class VTCore_Wordpress_Models_VCShortcodes
extends VTCore_Wordpress_Models_Shortcodes {


  /**
   * Processor specially for converting vc shortcodes atts
   *
   */
  protected function processVC() {

    // Preprocessing VC custom css from the design tabs
    if ($this->get('css') && function_exists('vc_shortcode_custom_css_class')) {
      $this->add('attributes.class.visualcomposer_style',  vc_shortcode_custom_css_class($this->get('css'), ' '));
    }

    // Support for css animation
    if ($this->get('css_animation')) {

      if (wp_script_is('waypoints', 'registered') == false) {
        wp_register_script('waypoints', vc_asset_url( 'lib/jquery-waypoints/waypoints.min.js'), array('jquery'), WPB_VC_VERSION, true);
      }

      wp_enqueue_script('waypoints');

      $this
        ->add('attributes.class.css_animation',  'wpb_animate_when_almost_visible wpb_' . $this->get('css_animation'))
        ->remove('css_animation');
    }
  }

  /**
   * Preprocess shortcode attributes first
   * as many jQuery plugin is very picky about the data structure.
   */
  protected function preprocessAtts($atts) {

    parent::preprocessAtts($atts);

    if (defined('WPB_VC_VERSION')) {
      $this->processVC();
    }

    return $this->atts;
  }

}