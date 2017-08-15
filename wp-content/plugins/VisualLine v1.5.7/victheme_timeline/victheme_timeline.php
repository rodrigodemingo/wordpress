<?php
/*
Plugin Name: VicTheme Timeline
Plugin URI: http://victheme.com/victheme-timeline
Description: Plugin for creating time line element.
Author: jason.xie@victheme.com
Version: 1.6.9
Author URI: http://victheme.com
*/

define('VTCORE_TIMELINE_CORE_VERSION', '1.7.0');
add_action('plugins_loaded', 'VTCore_Timeline_bootPlugin', 11);

// Autoload translation for vtcore
load_plugin_textdomain('victheme_timeline', false, 'victheme_timeline/languages');

function VTCore_Timeline_bootPlugin() {

  if (!defined('VTCORE_VERSION') || version_compare(VTCORE_VERSION, VTCORE_TIMELINE_CORE_VERSION, '!=')) {


    add_action('admin_notices', 'VTCore_Timeline_MissingCoreNotice');

    function VTCore_Timeline_MissingCoreNotice() {

      if (!defined('VTCORE_VERSION')) {
        $notice = __('VicTheme Timeline depends on VicTheme Core Plugin which is not activated or missing,
        Please enable it first before VicTheme Timeline can work properly.', 'victheme_timeline');
      }
      elseif (version_compare(VTCORE_VERSION, VTCORE_TIMELINE_CORE_VERSION, '!=')) {
        $notice = sprintf(__('VicTheme Timeline depends on VicTheme Core Plugin API version %s to operate properly.', 'victheme_timeline'), VTCORE_TIMELINE_CORE_VERSION);
      }

      if (isset($notice)) {
        echo '<div class="error""><p>' . $notice . '</p></div>';
      }
    }
    return;
  }


  if (!defined('WPB_VC_VERSION')) {

    add_action('admin_notices', 'VTCore_Timeline_MissingVisualComposerNotice');

    function VTCore_Timeline_MissingVisualComposerNotice() {
      echo

      '<div class="error""><p>' .

      __( 'Timeline requires Visual Composer Plugin enabled before it can function properly.', 'victheme_timeline') .

      '</p></div>';
    }

    return;
  }

  if (defined('WPB_VC_VERSION') && !version_compare(WPB_VC_VERSION, '4.7.0', '>=')) {
    add_action('admin_notices', 'VTCore_TimelineVCTooLow');

    function VTCore_TimelineVCTooLow() {
      echo
        '<div class="error""><p>' .

        __( 'TimeLine requires Visual Composer Plugin version 4.7.0 and above before it can function properly.
             For older visual composer please use TimeLine version 1.4.x.', 'victheme_timeline') .

        '</p></div>';
    }

    return;
  }


  // Continue booting the plugin

  define('VTCORE_TIMELINE_BOOTSTRAP', true);
  define('VTCORE_TIMELINE_URL', plugin_dir_url(__FILE__));
  define('VTCORE_TIMELINE_ADVANCED_MODE', get_option('vtcore_timeline_advanced_mode', false));
  define('VTCORE_TIMELINE_VERSION', '1.4.0');

  // Booting Core Class
  require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php');
  $init = new VTCore_Timeline_Init();


}