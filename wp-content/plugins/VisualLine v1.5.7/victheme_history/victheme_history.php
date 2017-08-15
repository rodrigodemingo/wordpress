<?php
/*
Plugin Name: VicTheme History
Plugin URI: http://victheme.com/victheme-history
Description: Plugin for extending visual composer with history elements.
Author: jason.xie@victheme.com
Version: 1.5.13
Author URI: http://victheme.com
*/

define('VTCORE_HISTORY_CORE_VERSION', '1.7.0');

add_action('plugins_loaded', 'VTCore_History_bootPlugin');

// Autoload translation for vtcore
load_plugin_textdomain('victheme_history', false, 'victheme_history/languages');

function VTCore_History_bootPlugin() {

  if (!defined('VTCORE_VERSION') || version_compare(VTCORE_VERSION, VTCORE_HISTORY_CORE_VERSION, '!=')) {

    add_action('admin_notices', 'VTCore_History_MissingCoreNotice');

    function VTCore_History_MissingCoreNotice() {
      if (!defined('VTCORE_VERSION')) {
        $notice = __('VicTheme History depends on VicTheme Core Plugin which is not activated or missing,
        Please enable it first before VicTheme History can work properly.', 'victheme_history');
      }
      elseif (version_compare(VTCORE_VERSION, VTCORE_HISTORY_CORE_VERSION, '!=')) {
        $notice = sprintf(__('VicTheme History depends on VicTheme Core Plugin API version %s to operate properly.', 'victheme_history'), VTCORE_HISTORY_CORE_VERSION);
      }

      if (isset($notice)) {
        echo '<div class="error""><p>' . $notice . '</p></div>';
      }
    }

    return;
  }


  if (!defined('WPB_VC_VERSION')) {

    add_action('admin_notices', 'VTCore_History_MissingVisualComposerNotice');

    function VTCore_History_MissingVisualComposerNotice() {
      echo

      '<div class="error""><p>' .

      __( 'History requires Visual Composer Plugin enabled before it can function properly.', 'victheme_history') .

      '</p></div>';
    }

    return;
  }


  if (defined('WPB_VC_VERSION') && !version_compare(WPB_VC_VERSION, '4.7.0', '>=')) {
    add_action('admin_notices', 'VTCore_HistorylineVCTooLow');

    function VTCore_HistorylineVCTooLow() {
      echo
        '<div class="error""><p>' .

        __( 'HistoryLine requires Visual Composer Plugin version 4.7.0 and above before it can function properly.
             For older visual composer please use HistoryLine version 1.4.x.', 'victheme_history') .

        '</p></div>';
    }

    return;
  }

  // Continue booting the plugin
  define('VTCORE_HISTORY_LOADED', true);
  define('VTCORE_HISTORY_URL', plugin_dir_url(__FILE__));
  define('VTCORE_HISTORY_ADVANCED_MODE', get_option('vtcore_history_advanced_mode', false));

  // Booting Core Class
  require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php');
  $init = new VTCore_History_Init();


}