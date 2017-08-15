<?php
/**
 * This class is for initializing all related
 * WordPress specific sub classes
 *
 * This is needed to keep clean VTCore that can
 * be ported or used by other CMS.
 *
 * Currently this class is managing centralized
 * registration system for :
 *
 * 1. Template system
 * 2. Actions system
 * 3. Filters system
 * 4. Fonts system
 * 5. Extension for VTCore class autoloader system
 * 6. Registering assets
 * 7. Bridging VTCore elements to VisualComposer
 * 8. WPML Bridge system
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Init
extends VTCore_Wordpress_Models_Factories {

  static protected $factories;

  public function register() {

    // Boot core configuration
    self::setFactory('coreConfig', new VTCore_Wordpress_Objects_Array(get_option('vtcore_core_options', array(
      'aggregate' => array(
        'frontend' => false,
        'backend' => true,
      ),
      'images' => array(
        'responsive' => true,
        'retinajs' => false,
      ),
      'cachetime' => 24,
    ))));

    // Booting asset management system
    self::setFactory('assets', new VTCore_Wordpress_Factory_Assets());
    self::getFactory('assets')
      ->get('library')
      ->detect(
        VTCore_Init::getCorePath() . DIRECTORY_SEPARATOR . 'assets',
        VTCore_Init::getCoreURL() . '/assets',
        false,
        'VTCore_Wordpress_Data_Maps_Core'
      )
      ->detect(
        dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets',
        str_replace('vtcore', 'wordpress', VTCore_Init::getCoreURL()) . '/assets',
        false,
        'VTCore_Wordpress_Data_Maps_Wordpress'
      )
      ->add('wp-ajax.js.wp-ajax-js.localize.wpajax', array('ajaxurl' => admin_url('admin-ajax.php')));

    // Booting plugin templating system
    self::setFactory('template', new VTCore_Wordpress_Factory_Templates());

    // Booting google fonts system
    self::setFactory('fonts', new VTCore_Wordpress_Factory_Fonts());

    // Booting shortcodes system
    self::setFactory('shortcodes', new VTCore_Wordpress_Factory_Shortcodes());

    // Booting custom templates
    self::setFactory('customTemplate', new VTCore_Wordpress_Factory_CustomTemplate());

    // Booting Customizer
    self::setFactory('customizer', new VTCore_Wordpress_Factory_Customizer());

    // Booting VisualComposer integration
    if (defined('WPB_VC_VERSION')) {
      self::setFactory('visualcomposer', new VTCore_Wordpress_Factory_VC());
    }

    // Booting WPML integration for wpml-config.xml
    if (defined('ICL_SITEPRESS_VERSION')) {
      self::setFactory('wpml', new VTCore_Wordpress_Factory_WPML());
    }

    // Load core classes registry cache for performance
    if (!(defined('VTCORE_CLEAR_CACHE') && VTCORE_CLEAR_CACHE)
        || !(defined('WP_DEBUG') && WP_DEBUG)) {

      $object = new VTCore_Wordpress_Objects_Cache();
      $object->loadCoreClasses();
      unset($object);
    }

    // Booting updater plugin, other plugin can utilize the
    // centralized version mapping system to add their own
    // updating logic
    self::setFactory('updater', new VTCore_Wordpress_Factory_Updater());
    self::getFactory('updater')
      ->add('registry.victheme_core', array(
        'object' => 'VTCore_Wordpress_Updater',
        'updates' => array(
          'update_1_7_5' => __('Updating custom template', 'victheme_core'),
        )
      ));

    // Booting action system
    // Need to fire last
    self::setFactory('actions', new VTCore_Wordpress_Factory_Actions());
    self::getFactory('actions')->register();


    // Booting filter system
    // Need to fire last
    self::setFactory('filters', new VTCore_Wordpress_Factory_Filters());
    self::getFactory('filters')->register();

    // Process late clear cache
    if (get_option('vtcore_clear_cache')) {
      update_option('vtcore_clear_cache', false);

      // Force Clear Cache
      if (!defined('VTCORE_CLEAR_CACHE')) {
        define('VTCORE_CLEAR_CACHE', true);
      }

      VTCore_Autoloader::resetMapCache();
    }

    if (get_theme_support('load_vtcore_bootstrap')) {
      add_theme_support('bootstrap');
      VTCore_Wordpress_Utility::loadAsset('bootstrap');
    }

    if (self::getFactory('coreConfig')->get('images.responsive')) {
      self::getFactory('filters')
        ->addHooks(array(
          'wp_calculate_image_sizes',
          'wp_calculate_image_srcset',
        ))
        ->register();

      // Responsive Images
      add_image_size('mobile-potrait', '380', '380', false);
      add_image_size('large-mobile-potrait', '500', '500', false);
      add_image_size('mobile-landscape', '660', '660', false);
      add_image_size('large-mobile-landscape', '800', '800', false);
    }

  }

}