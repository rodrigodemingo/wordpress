<?php
/*
Plugin Name: VicTheme Core
Plugin URI: http://victheme.com
Description: Core Plugin containing VicTheme core classes, This plugin will do nothing by itself.
Author: jason.xie@victheme.com
Version: 1.7.59
Author URI: http://victheme.com
*/

if (!defined('ABSPATH')) {
  die();
}

// Autoload translation for vtcore
load_plugin_textdomain('victheme_core', false, 'victheme_core/wordpress/languages');

// Bind plugin loading
add_action('plugins_loaded', 'VicthemeCoreBootPlugin', 10);

// Main booting function
function VicthemeCoreBootPlugin() {

  // New dependecies system since 1.6.0
  // Theme and plugin made before 1.6.0 will not boot at all!
  // VTCORE_ACTIVE constant is removed and replace by VTCORE_VERSION
  // Only change this if core will break sub plugin!
  define('VTCORE_VERSION', '1.7.0');

  // Define cache constant
  define('VTCORE_DO_CACHE', !(defined('WP_DEBUG') || WP_DEBUG == false));

  // Define the plugin version
  define('VTCORE_PLUGIN_VERSION', '1.7.56');

  // Define plugin path
  define('VTCORE_CORE_PLUGIN_PATH', dirname(__FILE__));


  // Attempt to load compressed PHP Class
  // VTCoreLoadCompressedClass();

  // Clear the class cache early
  // @bug fix cannot clear map cache when moving site.
  if (defined('VTCORE_CLEAR_CACHE') && VTCORE_CLEAR_CACHE) {
    delete_transient('vtcore_autoloader_maps');
  }

  // Booting VTCore Core
  include_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'vtcore' . DIRECTORY_SEPARATOR . 'init.php');

  // Booting VTCore
  new VTCore_Init(array(
    'corePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . 'vtcore',
    'coreURL' => plugins_url('', dirname(__FILE__) . DIRECTORY_SEPARATOR . 'vtcore' . DIRECTORY_SEPARATOR . 'init.php'),
    'classMap' => get_transient('vtcore_autoloader_maps'),
    'loadAsset' => false,
  ));

  // Register the autoloader for wordpress directory
  $autoloader = new VTCore_Autoloader('VTCore_Wordpress', dirname(__FILE__));
  $autoloader->setRemovePath('vtcore' . DIRECTORY_SEPARATOR);
  $autoloader->register();

  // Booting VTCore for WordPress
  $init = new VTCore_Wordpress_Init();

}


// Bind plugin activation
register_activation_hook(__FILE__, 'VTCore_Activation');

// Plugin activation function
function VTCore_Activation() {

  update_option('vtcore_clear_cache', true);
  delete_transient('vtcore_autoloader_maps');

  // Force clear cache
  if (!defined('VTCORE_CLEAR_CACHE')) {
    define('VTCORE_CLEAR_CACHE', true);
  }
}

// Load compressed PHP Class
function VTCoreLoadCompressedClass() {
  $filesOrdering = array(
    'compressed-html.php',
    'compressed-form.php',
    'compressed-bootstrap.php',
    'compressed-socialshare.php',
    'compressed-validator.php',
    'compressed-cssbuilder.php',
    'compressed-wordpress.php',
  );
  $path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'compressed';
  foreach ($filesOrdering as $file) {
    if (file_exists($path . DIRECTORY_SEPARATOR . $file)) {
      include $path . DIRECTORY_SEPARATOR . $file;
    }
  }
}