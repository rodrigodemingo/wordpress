<?php
/*
Plugin Name: VicTheme BubbleLine
Plugin URI: http://victheme.com/victheme-bubbleline
Description: Plugin for extending visual composer with bubbleline elements.
Author: jason.xie@victheme.com
Version: 1.0.3
Author URI: http://victheme.com
*/

define('VTCORE_BUBBLELINE_CORE_VERSION', '1.7.0');

add_action('plugins_loaded', 'VTCore_BubbleLine_bootPlugin', 11);

// Autoload translation for vtcore
load_plugin_textdomain('victheme_bubbleline', false, 'victheme_bubbleline/languages');

function VTCore_BubbleLine_bootPlugin() {

  if (!(defined('VTCORE_VERSION') && version_compare(VTCORE_VERSION, VTCORE_BUBBLELINE_CORE_VERSION, '='))) {

    add_action('admin_notices', 'VTCore_BubbleLine_MissingCoreNotice');

    function VTCore_BubbleLine_MissingCoreNotice() {

      if (!defined('VTCORE_VERSION')) {
        $notice = __('VicTheme Bubble Line depends on VicTheme Core Plugin which is not activated or missing,
        Please enable it first before VicTheme Bubble Line can work properly.', 'victheme_bubbleline');
      }
      elseif (version_compare(VTCORE_VERSION, VTCORE_BUBBLELINE_CORE_VERSION, '!=')) {
        $notice = sprintf(__('VicTheme Bubble Line depends on VicTheme Core Plugin API version %s to operate properly.', 'victheme_bubbleline'), VTCORE_BUBBLELINE_CORE_VERSION);
      }

      if (isset($notice)) {
        echo '<div class="error""><p>' . $notice . '</p></div>';
      }

    }

    return;
  }


  if (!defined('WPB_VC_VERSION')) {

    add_action('admin_notices', 'VTCore_BubbleLine_MissingVisualComposerNotice');

    function VTCore_BubbleLine_MissingVisualComposerNotice() {
      echo

      '<div class="error""><p>' .

      __( 'BubbleLine requires Visual Composer Plugin enabled before it can function properly.', 'victheme_bubbleline') .

      '</p></div>';
    }

    return;
  }


  if (defined('WPB_VC_VERSION') && !version_compare(WPB_VC_VERSION, '4.7.0', '>=')) {
    add_action('admin_notices', 'VTCore_BubblelineVCTooLow');

    function VTCore_BubblelineVCTooLow() {
      echo
        '<div class="error""><p>' .

        __( 'BubbleLine requires Visual Composer Plugin version 4.7.0 and above before it can function properly.', 'victheme_timeline') .

        '</p></div>';
    }

    return;
  }

  // Continue booting the plugin

  define('VTCORE_BUBBLELINE_BOOTSTRAP', true);
  define('VTCORE_BUBBLELINE_URL', plugin_dir_url(__FILE__));
  define('VTCORE_BUBBLELINE_ADVANCED_MODE', get_option('vtcore_bubbleline_advanced_mode', false));

  // Booting Core Class
  require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php');
  $init = new VTCore_BubbleLine_Init();


}