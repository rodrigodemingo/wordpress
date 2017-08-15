<?php
/**
 * Action add_meta_boxes for VTCore_Wordpress
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Actions_Add__Meta__Boxes
extends VTCore_Wordpress_Models_Hook {

  public function hook() {

    $types = get_post_types();

    // Booting Metabox for choosing template file
    // Theme must invoke add_theme_support('vtcore_custom_template')
    if (get_theme_support('vtcore_custom_template')) {

      foreach ($types as $post_type) {
        if (in_array($post_type, VTCore_Wordpress_Init::getFactory('customTemplate')->getRegistered())) {
          add_meta_box(
            'vtcore_custom_templates',
            __('Custom Templates', 'victheme_core'),
            array(new VTCore_Wordpress_Metabox_CustomTemplate, 'register'),
            $post_type,
            'side',
            'default'
          );
        }
      }
    }

    // Booting Metabox for adding custom heading
    // Theme must invoke add_theme_support('vtcore_custom_heading')
    if (get_theme_support('vtcore_custom_heading')) {

      $post_types = get_theme_support('vtcore_custom_heading');

      if (is_array($post_types)) {
        $post_types = array_shift($post_types);
      }
      else {
        $post_types = array();
      }

      foreach ($types as $post_type) {
        if (in_array($post_type, $post_types)) {
          add_meta_box(
            'vtcore_custom_header',
            __('Custom Header', 'victheme_core'),
            array(new VTCore_Wordpress_Metabox_CustomHeader, 'register'),
            $post_type,
            'side',
            'default'
          );
        }
      }
    }


  }

}