<?php
/**
 * Main Class for handling the Plugin operation
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_CenterLine_Init {

  private $autoloader;

  private $filters = array(
    'vtcore_wordpress_shortcode_attributes_alter',
    'vc_load_default_templates',
  );

  private $actions = array(
    'vc_backend_editor_enqueue_js_css',
    'vc_frontend_editor_enqueue_js_css',
    'vc_load_iframe_jscss',
  );

  private $shortcodes = array(
    'centerline' => 'VTCore_CenterLine_Shortcodes_CenterLine',
    'centerlineimage' => 'VTCore_CenterLine_Shortcodes_CenterLineImage',
    'centerlineinner' => 'VTCore_CenterLine_Shortcodes_CenterLineInner',
    'centerlinesimple' => 'VTCore_CenterLine_Shortcodes_CenterLineSimple',
  );

  private $vcshortcodes = array(
    'VTCore_CenterLine_Visualcomposer_CenterLine',
    'VTCore_CenterLine_Visualcomposer_CenterLineInner',
    'VTCore_CenterLine_Visualcomposer_CenterLineImage',
    'VTCore_CenterLine_Visualcomposer_CenterLineSimple',
  );

  /**
   * Constructing the main class and adding action to init.
   */
  public function __construct() {

    // Load autoloader
    $this->autoloader = new VTCore_Autoloader('VTCore_CenterLine', dirname(__FILE__));
    $this->autoloader->setRemovePath('vtcore' . DIRECTORY_SEPARATOR . 'centerline' . DIRECTORY_SEPARATOR);
    $this->autoloader->register();

    // Registering assets
    VTCore_Wordpress_Init::getFactory('assets')
      ->get('library')
      ->detect(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets', plugins_url('', __FILE__) . '/assets', false, 'VTCore_CenterLine_Assets');

    // Registering actions
    VTCore_Wordpress_Init::getFactory('filters')
      ->addPrefix('VTCore_CenterLine_Filters_')
      ->addHooks($this->filters)
      ->register();


    // Registering filters
    VTCore_Wordpress_Init::getFactory('actions')
      ->addPrefix('VTCore_CenterLine_Actions_')
      ->addHooks($this->actions)
      ->register();

    // Registering shortcodes
    VTCore_Wordpress_Init::getFactory('shortcodes')
      ->merge($this->shortcodes)
      ->initialize();

    // Register to visual composer via VTCore Visual Composer Factory
    if (VTCore_Wordpress_Init::getFactory('visualcomposer')) {
      VTCore_Wordpress_Init::getFactory('visualcomposer')
        ->mapShortcode($this->vcshortcodes);
    }
  }

}