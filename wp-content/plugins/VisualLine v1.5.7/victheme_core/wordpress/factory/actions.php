<?php
/**
 * Class for encapsulating all Wordpress
 * actions hook in one place.
 *
 * The action class should follow the
 * Autoloader naming convention and
 * extend the VTCore_Wordpress_Base class
 *
 * @see VTCore_Wordpress_Models_Hooks
 * @author jason.xie@victheme.com
 */
class VTCore_Wordpress_Factory_Actions
extends VTCore_Wordpress_Models_Hooks {

  protected $registry = array(
    'init',
    'admin_init',
    'admin_menu',
    'widgets_init',
    'wp_footer',
    'wp_enqueue_scripts',
    'admin_enqueue_scripts',
    'wp_ajax_nopriv_vtcore_ajax_framework',
    'wp_ajax_vtcore_ajax_framework',
    'added_option',
    'deleted_option',
    'updated_option',
    'save_post',
    'wp',
    'add_meta_boxes',
    'admin_footer',
    'shutdown',
    'vc_backend_editor_enqueue_js_css',
    'vc_frontend_editor_enqueue_js_css',
    'vc_load_iframe_jscss',
    'vc_before_init',
    'upgrader_process_complete',
    'vtcore_updater',
    'themecheck_checks_loaded',
  );


  protected $overloaderPrefix = array(
    'VTCore_Wordpress_Actions_'
  );

  protected $loaded = array();
  protected $hookFunction = 'add_action';

}