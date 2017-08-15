<?php
/**
 * Hooking into vtcore_wordpress_shortcode_attributes_alter filter
 * to process custom shortcode attributes rules that is not
 * implemented in VTCore but implemented in VisualComposer
 *
 * This is done this way to keep the core clean from VisualComposer
 * specific codes.
 *
 * @author jason.xie@victheme.com
 */
class VTCore_SnakeLine_Filters_VTCore__Wordpress__Shortcode__Attributes__Alter
extends VTCore_Wordpress_Models_Hook {

  public function hook($atts = NULL) {

    // Preprocessing VC custom css from the design tabs
    if (isset($atts['css']) && !empty($atts['css'])) {
      $atts['attributes']['class']['visualcomposer_style'] = vc_shortcode_custom_css_class($atts['css'], ' ');
    }

    // Animation class
    if (isset($atts['css_animation']) && !empty($atts['css_animation'])) {

      // Load waypoints
      if (wp_script_is('waypoints', 'registered') == false) {
        wp_register_script('waypoints', vc_asset_url( 'lib/jquery-waypoints/waypoints.min.js'), array('jquery'), WPB_VC_VERSION, true);
      }

      wp_enqueue_script('waypoints');

      $atts['attributes']['class']['css_animation'] = 'wpb_animate_when_almost_visible wpb_' . $atts['css_animation'];
      unset($atts['css_animation']);
    }

    return $atts;
  }
}