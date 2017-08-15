<?php
/*
Plugin Name: VicTheme CenterLine
Plugin URI: http://victheme.com/victheme-centerline
Description: Plugin for extending visual composer with centerline elements.
Author: jason.xie@victheme.com
Version: 1.6.14
Author URI: http://victheme.com
*/

define('VTCORE_CENTERLINE_CORE_VERSION', '1.7.0');

add_action('plugins_loaded', 'VTCore_CenterLine_bootPlugin', 11);

// Autoload translation for vtcore
load_plugin_textdomain('victheme_centerline', false, 'victheme_centerline/languages');

function VTCore_CenterLine_bootPlugin() {


  if (!defined('VTCORE_VERSION') || version_compare(VTCORE_VERSION, VTCORE_CENTERLINE_CORE_VERSION, '!=')) {

    add_action('admin_notices', 'VTCore_CenterLine_MissingCoreNotice');

    function VTCore_CenterLine_MissingCoreNotice() {

      if (!defined('VTCORE_VERSION')) {
        $notice = __('VicTheme Center Line depends on VicTheme Core Plugin which is not activated or missing,
        Please enable it first before VicTheme Center Line can work properly.', 'victheme_centerline');
      }
      elseif (version_compare(VTCORE_VERSION, VTCORE_CENTERLINE_CORE_VERSION, '!=')) {
        $notice = sprintf(__('VicTheme Center Line depends on VicTheme Core Plugin API version %s to operate properly.', 'victheme_centerline'), VTCORE_CENTERLINE_CORE_VERSION);
      }

      if (isset($notice)) {
        echo '<div class="error""><p>' . $notice . '</p></div>';
      }

    }

    return;
  }


  if (!defined('WPB_VC_VERSION')) {

    add_action('admin_notices', 'VTCore_CenterLine_MissingVisualComposerNotice');

    function VTCore_CenterLine_MissingVisualComposerNotice() {
      echo

      '<div class="error""><p>' .

      __( 'CenterLine requires Visual Composer Plugin enabled before it can function properly.', 'victheme_centerline') .

      '</p></div>';
    }

    return;
  }

  if (defined('WPB_VC_VERSION') && !version_compare(WPB_VC_VERSION, '4.7.0', '>=')) {
    add_action('admin_notices', 'VTCore_CenterlineVCTooLow');

    function VTCore_CenterlineVCTooLow() {
      echo
        '<div class="error""><p>' .

        __( 'CenterLine requires Visual Composer Plugin version 4.7.0 and above before it can function properly.
             For older visual composer please use CenterLine version 1.5.x.', 'victheme_centerline') .

        '</p></div>';
    }

    return;
  }


  // Continue booting the plugin
  define('VTCORE_CENTERLINE_LOADED', true);
  define('VTCORE_CENTERLINE_BOOTSTRAP', true);
  define('VTCORE_CENTERLINE_URL', plugin_dir_url(__FILE__));
  define('VTCORE_CENTERLINE_ADVANCED_MODE', get_option('vtcore_centerline_advanced_mode', false));

  // Booting Core Class
  require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php');
  $init = new VTCore_CenterLine_Init();


}