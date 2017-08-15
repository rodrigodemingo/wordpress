<?php
/**
 * Main Class for handling the Plugin operation
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_BubbleLine_Init {

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
    'bubbleline' => 'VTCore_BubbleLine_Shortcodes_BubbleLine',
    'bubblelineitem' => 'VTCore_BubbleLine_Shortcodes_BubbleLineItem',
    'bubblelinesimple' => 'VTCore_BubbleLine_Shortcodes_BubbleLineSimple',
  );

  private $vcshortcodes = array(
    'VTCore_BubbleLine_Visualcomposer_BubbleLine',
    'VTCore_BubbleLine_Visualcomposer_BubbleLineInner',
    'VTCore_BubbleLine_Visualcomposer_BubbleLineSimple',
  );


  /**
   * Constructing the main class and adding action to init.
   */
  public function __construct() {

    // Load autoloader
    $this->autoloader = new VTCore_Autoloader('VTCore_BubbleLine', dirname(__FILE__));
    $this->autoloader->setRemovePath('vtcore' . DIRECTORY_SEPARATOR . 'bubbleline' . DIRECTORY_SEPARATOR);
    $this->autoloader->register();

    // Registering assets
    VTCore_Wordpress_Init::getFactory('assets')
      ->get('library')
      ->detect(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets', plugins_url('', __FILE__) . '/assets', false, 'VTCore_BubbleLine_Assets');

    // Registering actions
    VTCore_Wordpress_Init::getFactory('filters')
      ->addPrefix('VTCore_BubbleLine_Filters_')
      ->addHooks($this->filters)
      ->register();


    // Registering filters
    VTCore_Wordpress_Init::getFactory('actions')
      ->addPrefix('VTCore_BubbleLine_Actions_')
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