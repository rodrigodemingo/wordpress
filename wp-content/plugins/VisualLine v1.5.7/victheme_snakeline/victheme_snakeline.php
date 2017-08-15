<?php
/*
Plugin Name: VicTheme SnakeLine
Plugin URI: http://victheme.com/victheme-snakeline
Description: Plugin for extending visual composer with snakeline elements.
Author: jason.xie@victheme.com
Version: 1.0.3
Author URI: http://victheme.com
*/

define('VTCORE_SNAKELINE_CORE_VERSION', '1.7.0');

add_action('plugins_loaded', 'VTCore_SnakeLine_bootPlugin', 11);

// Autoload translation for vtcore
load_plugin_textdomain('victheme_snakeline', false, 'victheme_snakeline/languages');

function VTCore_SnakeLine_bootPlugin() {

  if (!(defined('VTCORE_VERSION') && version_compare(VTCORE_VERSION, VTCORE_SNAKELINE_CORE_VERSION, '='))) {

    add_action('admin_notices', 'VTCore_SnakeLine_MissingCoreNotice');

    function VTCore_SnakeLine_MissingCoreNotice() {

      if (!defined('VTCORE_VERSION')) {
        $notice = __('VicTheme Snake Line depends on VicTheme Core Plugin which is not activated or missing,
        Please enable it first before VicTheme Snake Line can work properly.', 'victheme_snakeline');
      }
      elseif (version_compare(VTCORE_VERSION, VTCORE_SNAKELINE_CORE_VERSION, '!=')) {
        $notice = sprintf(__('VicTheme Snake Line depends on VicTheme Core Plugin API version %s to operate properly.', 'victheme_snakeline'), 'victheme_snakeline');
      }

      if (isset($notice)) {
        echo '<div class="error""><p>' . $notice . '</p></div>';
      }

    }

    return;
  }


  if (!defined('WPB_VC_VERSION')) {

    add_action('admin_notices', 'VTCore_SnakeLine_MissingVisualComposerNotice');

    function VTCore_SnakeLine_MissingVisualComposerNotice() {
      echo

      '<div class="error""><p>' .

      __( 'SnakeLine requires Visual Composer Plugin enabled before it can function properly.', 'victheme_snakeline') .

      '</p></div>';
    }

    return;
  }


  if (defined('WPB_VC_VERSION') && !version_compare(WPB_VC_VERSION, '4.7.0', '>=')) {
    add_action('admin_notices', 'VTCore_SnakelineVCTooLow');

    function VTCore_SnakelineVCTooLow() {
      echo
        '<div class="error""><p>' .

        __( 'SnakeLine requires Visual Composer Plugin version 4.7.0 and above before it can function properly.', 'victheme_timeline') .

        '</p></div>';
    }

    return;
  }

  // Continue booting the plugin

  define('VTCORE_SNAKELINE_BOOTSTRAP', true);
  define('VTCORE_SNAKELINE_URL', plugin_dir_url(__FILE__));
  define('VTCORE_SNAKELINE_ADVANCED_MODE', get_option('vtcore_snakeline_advanced_mode', false));

  // Booting Core Class
  require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php');
  $init = new VTCore_SnakeLine_Init();


}