<?php
/*
Plugin Name: VicTheme MemoryLine
Plugin URI: http://victheme.com/victheme-memoryline
Description: Plugin for extending visual composer with memoryline elements.
Author: jason.xie@victheme.com
Version: 2.0.2
Author URI: http://victheme.com
*/

define('VTCORE_MEMORYLINE_CORE_VERSION', '1.7.0');

add_action('plugins_loaded', 'VTCore_MemoryLine_bootPlugin', 11);

// Autoload translation for vtcore
load_plugin_textdomain('victheme_memoryline', false, 'victheme_memoryline/languages');

function VTCore_MemoryLine_bootPlugin() {

  if (!(defined('VTCORE_VERSION') && version_compare(VTCORE_VERSION, VTCORE_MEMORYLINE_CORE_VERSION, '='))) {

    add_action('admin_notices', 'VTCore_MemoryLine_MissingCoreNotice');

    function VTCore_MemoryLine_MissingCoreNotice() {

      if (!defined('VTCORE_VERSION')) {
        $notice = __('VicTheme Memory Line depends on VicTheme Core Plugin which is not activated or missing,
        Please enable it first before VicTheme Memory Line can work properly.', 'victheme_memoryline');
      }
      elseif (version_compare(VTCORE_VERSION, VTCORE_MEMORYLINE_CORE_VERSION, '!=')) {
        $notice = sprintf(__('VicTheme Memory Line depends on VicTheme Core Plugin API version %s to operate properly.', 'victheme_memoryline'), VTCORE_MEMORYLINE_CORE_VERSION);
      }

      if (isset($notice)) {
        echo '<div class="error""><p>' . $notice . '</p></div>';
      }

    }

    return;
  }


  if (!defined('WPB_VC_VERSION')) {

    add_action('admin_notices', 'VTCore_MemoryLine_MissingVisualComposerNotice');

    function VTCore_MemoryLine_MissingVisualComposerNotice() {
      echo

      '<div class="error""><p>' .

      __( 'MemoryLine requires Visual Composer Plugin enabled before it can function properly.', 'victheme_memoryline') .

      '</p></div>';
    }

    return;
  }


  if (defined('WPB_VC_VERSION') && !version_compare(WPB_VC_VERSION, '4.11.2', '>=')) {
    add_action('admin_notices', 'VTCore_MemorylineVCTooLow');

    function VTCore_MemorylineVCTooLow() {
      echo
        '<div class="error""><p>' .

        __( 'MemoryLine requires Visual Composer Plugin version 4.11.2 and above before it can function properly.', 'victheme_memoryline') .

        '</p></div>';
    }

    return;
  }

  // Continue booting the plugin

  define('VTCORE_MEMORYLINE_BOOTSTRAP', true);
  define('VTCORE_MEMORYLINE_URL', plugin_dir_url(__FILE__));
  define('VTCORE_MEMORYLINE_ADVANCED_MODE', get_option('vtcore_memoryline_advanced_mode', false));

  // Booting Core Class
  require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php');
  $init = new VTCore_MemoryLine_Init();


}