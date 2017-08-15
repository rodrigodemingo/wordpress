<?php

die('No Direct Access Allowed');

/**
 * Example for registering custom asset folder to VTCore
 * asset management system
 *
 * This must be done after VTCore finish initialization.
 * $assetMainDirectoryRoot is the parent root of the assets
 * the subfolder will be registered as assets.
 *
 * Example valid asset folder structures :
 *
 * myplugin
 *   | - assets (this folder must be registered as $assetsMainDirectoryRoot
 *         | - myplugin-form (it is recommended to prefix the asset folder with unique name in
 *                            in this case is "myplugin")
 *                  | - css (all the css stored here, the name of css file can be anything)
 *                  | - js (all the js file stored here, the name of the js file can be anything)
 *         | - myplugin-anotherasset
 *                  | - css
 *                  | - js
 */

// Registering to VTCore Assets management
VTCore_Wordpress_Init::getFactory('assets')->get('library')->detect($assetsMainDirectoryRoot, $assetsMainDirectoryURL);


// Load specific assets after it is registered
// This might be deprecated in the future
VTCore_Wordpress_Utility::loadAsset('myplugin-form');


// The direct method for loading specific asset
VTCore_Wordpress_Init::getFactory('assets')
  ->get('queue')
  ->add('asset-name', array(
    'deps' => array('js deps'),
    'footer' => true,
  ));

// Removing from queue
VTCore_Wordpress_Init::getFactory('assets')
  ->get('queue')
  ->remove('asset-name');


// Adding to library
VTCore_Wordpress_Init::getFactory('assets')
  ->get('library')
  ->add('asset-name', $assetpath);


// Adding inline script
VTCore_Wordpress_Init::getFactory('assets')
  ->get('library')

  // Note: the style name must be any previously registered css!
  ->add('asset-name.css.style-css.inline.uniquekey', $someCssText);


// Cherry pick to remove single asset file
  VTCore_Wordpress_Init::getFactory('assets')
  ->get('library')
  ->remove('asset-name.css.asset-filename-css');


// To clear all factory cached, including class maps,
// asset cache. Sometimes the and js will break if we call
// this after the wp_enqueue_scripts.
define('VTCORE_CLEAR_CACHE', true);

// Schedule future clear cache which will be performed after
// another page load
update_option('vtcore_clear_cache', true);

// Cherry pick sets of compressed files via prefix
VTCore_Wordpress_Init::getFactory('assets')

  // Target the default frontend cache prefix
  // This is valid for the default factory object
  // other instance or plugin may use different prefix
  ->mutate('prefix', 'comp-front-')

  // Clear cache by deleting all the cached data entry
  // and its compressed files
  ->clearCache()

  // Revert the prefix back to admin side cache prefix
  // to continue loading the admin side cached asset
  ->mutate('prefix', 'comp-admin-');

