<?php
/**
 * Main Class for handling the Plugin operation
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_SnakeLine_Init {

  private $autoloader;

  private $filters = array(
    'vtcore_wordpress_shortcode_attributes_alter',
  );

  private $actions = array(
    'vc_backend_editor_enqueue_js_css',
    'vc_frontend_editor_enqueue_js_css',
    'vc_load_iframe_jscss',
  );

  private $shortcodes = array(
    'snakeline' => 'VTCore_SnakeLine_Shortcodes_SnakeLine',
    'snakelineitem' => 'VTCore_SnakeLine_Shortcodes_SnakeLineItem',
    'snakelinesimple' => 'VTCore_SnakeLine_Shortcodes_SnakeLineSimple',
  );

  private $vcshortcodes = array(
    'VTCore_SnakeLine_Visualcomposer_SnakeLine',
    'VTCore_SnakeLine_Visualcomposer_SnakeLineInner',
    'VTCore_SnakeLine_Visualcomposer_SnakeLineSimple',
  );


  /**
   * Constructing the main class and adding action to init.
   */
  public function __construct() {

    // Load autoloader
    $this->autoloader = new VTCore_Autoloader('VTCore_SnakeLine', dirname(__FILE__));
    $this->autoloader->setRemovePath('vtcore' . DIRECTORY_SEPARATOR . 'snakeline' . DIRECTORY_SEPARATOR);
    $this->autoloader->register();

    // Registering assets
    VTCore_Wordpress_Init::getFactory('assets')
      ->get('library')
      ->detect(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets', plugins_url('', __FILE__) . '/assets', false, 'VTCore_SnakeLine_Assets');

    // Registering actions
    VTCore_Wordpress_Init::getFactory('filters')
      ->addPrefix('VTCore_SnakeLine_Filters_')
      ->addHooks($this->filters)
      ->register();


    // Registering filters
    VTCore_Wordpress_Init::getFactory('actions')
      ->addPrefix('VTCore_SnakeLine_Actions_')
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