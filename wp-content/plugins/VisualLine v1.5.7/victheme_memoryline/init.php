<?php
/**
 * Main Class for handling the Plugin operation
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_MemoryLine_Init {

  private $autoloader;

  private $filters = array(
    'vtcore_wordpress_shortcode_attributes_alter',
    'vc_load_default_templates'
  );

  private $actions = array(
    'vc_backend_editor_enqueue_js_css',
    'vc_frontend_editor_enqueue_js_css',
    'vc_load_iframe_jscss',
  );

  private $shortcodes = array(
    'memoryline' => 'VTCore_MemoryLine_Shortcodes_MemoryLine',
    'memorylineinner' => 'VTCore_MemoryLine_Shortcodes_MemoryLineInner',
    'memorylinesimple' => 'VTCore_MemoryLine_Shortcodes_MemoryLineSimple',
  );

  private $vcshortcodes = array(
    'VTCore_MemoryLine_Visualcomposer_MemoryLine',
    'VTCore_MemoryLine_Visualcomposer_MemoryLineInner',
    'VTCore_MemoryLine_Visualcomposer_MemoryLineSimple',
  );


  /**
   * Constructing the main class and adding action to init.
   */
  public function __construct() {

    // Load autoloader
    $this->autoloader = new VTCore_Autoloader('VTCore_MemoryLine', dirname(__FILE__));
    $this->autoloader->setRemovePath('vtcore' . DIRECTORY_SEPARATOR . 'memoryline' . DIRECTORY_SEPARATOR);
    $this->autoloader->register();

    // Registering assets
    VTCore_Wordpress_Init::getFactory('assets')
      ->get('library')
      ->detect(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets', plugins_url('', __FILE__) . '/assets', false, 'VTCore_MemoryLine_Assets');

    // Registering actions
    VTCore_Wordpress_Init::getFactory('filters')
      ->addPrefix('VTCore_MemoryLine_Filters_')
      ->addHooks($this->filters)
      ->register();


    // Registering filters
    VTCore_Wordpress_Init::getFactory('actions')
      ->addPrefix('VTCore_MemoryLine_Actions_')
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