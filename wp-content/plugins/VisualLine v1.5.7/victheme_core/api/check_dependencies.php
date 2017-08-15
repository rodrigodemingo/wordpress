<?php

die('No Direct access allowed.');

/**
 * This file is just a sample for sub plugin to copy
 * paste and implement their own logic.
 * 
 * The main purpose is to check if VicTheme Core plugin 
 * is activated before proceed further.
 * 
 * We need to rely on the VTCORE_ACTIVE constant which
 * will be loaded if vtcore class is included and 
 * WordPress plugins_loaded action and admin_notices
 * action.
 * 
 * 
 * @author jason.xie@victheme.com
 */

add_action('plugins_loaded', 'bootPlugin');

function bootPlugin() {
  
  if (!defined('VTCORE_ACTIVE')) {
    
    add_action('admin_notices', 'MissingCoreNotice');
    
    function MissingCoreNotice() {
      echo 
        
      '<div class="error""><p>' . 
      
      __( 'Some message') . 
      
      '</p></div>';
    }
    
    return;
  }
  
  // Continue booting the plugin
}