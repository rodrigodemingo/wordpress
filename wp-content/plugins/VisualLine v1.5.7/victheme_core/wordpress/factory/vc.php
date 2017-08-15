<?php
/**
 * Class for encapsulating visual composer
 * related methods into a single factory class
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Wordpress_Factory_VC
implements VTCore_Wordpress_Interfaces_Factory {

  protected static $maps = array();
  protected $classMaps = array();
  protected $base = '';
  protected $assets = array();
  protected $vc = false;

  /**
   * Registering visual composer
   */
  public function register() {
    $this->vc = true;
    return $this;
  }

  /**
   * Processing shortcodes and registering
   * them to visual composer
   */
  public function processShortcodes() {


    // Check if we should bypass cache
    $this->maybeByPassCache();

    // Load cache
    $this->loadCache();

    foreach (self::$maps as $class) {

      $name = false;
      $check = strtolower($class);

      if (isset($this->classMaps[$check])) {

        if ($this->classMaps[$check] == true) {
          $name = $class;
        }
        else {
          continue;
        }
      }
      else if (class_exists($class, true)) {
        $name = $class;
        $this->classMaps[$check] = true;
      }
      else {
        $this->classMaps[$check] = false;
      }

      if ($name) {
        $object = new $name(array());
        vc_map($object->connectVC());
        unset($object);
      }
    }

    set_transient('vtcore_vc_maps', $this->classMaps, VTCore_Wordpress_Init::getFactory('coreConfig')->get('cachetime') * HOUR_IN_SECONDS);


    return $this;
  }


  /**
   * Method for checking if class should bypass cache
   * @return VTCore_Wordpress_Factory_Layout
   */
  public function maybeByPassCache() {
    // Wordpress on debug mode
    if ((defined('WP_DEBUG') && WP_DEBUG)
        || (defined('VTCORE_CLEAR_CACHE') && VTCORE_CLEAR_CACHE)) {

      $this->clearCache();
    }

    return $this;
  }


  /**
   * Method for loading from cache
   * @return VTCore_Wordpress_Factory_Layout
   */
  public function loadCache() {
    $this->classMaps = get_transient('vtcore_vc_maps');
    return $this;
  }


  /**
   * Clear transient cache
   */
  public function clearCache() {
    delete_transient('vtcore_vc_maps');
    return $this;
  }


  /**
   * Add shortcode form class definition
   * to the centralized mapping system
   *
   * @return VTCore_Wordpress_Factory_VC
   */
  public function mapShortcode($class) {

    if (!is_array($class)) {
      $class = array($class);
    }
    self::$maps = array_merge(self::$maps, $class);

    return $this;
  }


  /**
   * Remove shortcode class from maps
   * @param $class
   * @return $this
   */
  public function removeShortcode($class) {
    if (isset(self::$maps[$class])) {
      unset(self::$maps[$class]);
    }
    return $this;
  }

  /**
   * Wrapper for connecting VC into VTCore
   *
   * @see registerVC()
   */
  public function VTCoreElementBridge($settings, $value) {

    // Element that needs default value
    $defaults = array(
      'VTCore_Bootstrap_Form_BsSelect',
    );

    if (!in_array($settings['core_class'], $defaults)
        || (in_array($settings['core_class'], $defaults) && $value != ''))  {

      $settings['core_context']['value'] = $value;
    }

    $element = new $settings['core_class']($settings['core_context']);

    do_action('vtcore_wordpress_alter_visualcomposer_form', $element);

    return $element->__toString();
  }




  /**
   * Method for invoking custom VTCore special forms
   * so it can be used by vc_map() API
   */
  public function registerExtraForm() {
    if (function_exists('vc_add_shortcode_param')) {
      VTCore_Wordpress_Utility::loadAsset('wp-visualcomposer-extra');
      vc_add_shortcode_param('vtcore', array($this, 'VTCoreElementBridge'));
      vc_add_shortcode_param('vt_query_form', array($this, 'buildWpQueryForm'));
      vc_add_shortcode_param('vt_iconset_form', array($this, 'buildWpIconSetForm'));
      vc_add_shortcode_param('vt_icon_form', array($this, 'buildWpIconForm'));
    }
  }




  /**
   * Method for building the WPQuery form inside visualcomposer
   * Only invoke this via registerExtraForm() method!
   * @return string
   */
  public function buildWpQueryForm($settings, $value) {

    // Define the assets to load via loadFormAssets() method
    $this->assets = array(
      'wp-query',
      'wp-bootstrap',
      'bootstrap-switch',
      'wp-visualcomposer-form',
    );

    $this->loadFormAssets('vt-query-form');
    $object = new VTCore_Wordpress_Objects_Array($settings);

    // This is where we put the default value back to the form
    // when VC build the popup panel! not via javascript!
    if (!empty($value)) {
      $object->add('value', $value);
    }

    // Inject the value
    if ($object->get('value')) {
      $object->merge(wp_parse_args(html_entity_decode($object->get('value'))));
    }

    $form = new VTCore_Bootstrap_Form_BsInstance(array(
      'data' => array(
        'query-editor' => true,
      )
    ));

    $context = new VTCore_Wordpress_Objects_Array(array(
      'name' => 'query',
      'value' => $object->get('query'),
    ));

    if ($object->get('context')) {
      $context->add('context', $object->get('context'));
    }

    if ($object->get('visibility')) {
      $context->add('visibility', $object->get('visibility'));
    }

    $form
      ->addChildren(new VTCore_Wordpress_Form_WpQuery($context->extract()));


    $target = new VTCore_Form_Hidden(array(
      'attributes' => array(
        'value' => $object->get('value'),
        'name' => $object->get('param_name'),
        'data-query-value' => 'true',
        'class' => array(
          'wpb_vc_param_value',
          'wpb-input',
          $object->get('param_name')
        )
      ),
    ));

    unset($object);
    $object = NULL;

    unset($context);
    $context = NULL;

    return $target->__toString() . $form->__toString();
  }


  /**
   * Method for building the WPIconSet form inside visualcomposer
   * Only invoke this via registerExtraForm() method!
   * @return string
   */
  public function buildWpIconSetForm($settings, $value) {

    // Define the assets to load via loadFormAssets() method
    $this->assets = array(
      'wp-ajax',
      'wp-icons',
      'wp-icons-front',
      'bootstrap-colorpicker',
      'wp-bootstrap',
      'jquery-iconpicker',
      'wp-visualcomposer-form',
    );

    $object = new VTCore_Wordpress_Objects_Array($settings);

    // This is where we put the default value back to the form
    // when VC build the popup panel! not via javascript!
    if (!empty($value)) {
      $object->add('value', $value);
    }

    // Inject the value
    if ($object->get('value')) {
      $object->merge(wp_parse_args(html_entity_decode($object->get('value'))));
      $library = new VTCore_Wordpress_Data_Icons_Library();
      $this->assets[] = $library->get($object->get('iconset.family') . '.asset');
    }

    $this->loadFormAssets('vt-iconset-form');

    $form = new VTCore_Bootstrap_Form_BsInstance(array(
      'data' => array(
        'iconset-editor' => true,
      )
    ));
    $form
      ->addChildren(new VTCore_Wordpress_Form_WpIconSet(array(
        'name' => 'iconset',
        'value' => $object->get('iconset'),
      )));


    $target = new VTCore_Form_Hidden(array(
      'attributes' => array(
        'value' => $object->get('value'),
        'name' => $object->get('param_name'),
        'data-iconset-value' => 'true',
        'class' => array(
          'wpb_vc_param_value',
          'wpb-input',
          $object->get('param_name')
        )
      ),
    ));

    unset($object);
    $object = NULL;

    return $target->__toString() . $form->__toString();
  }




  /**
   * Method for building the WPIcon form inside visualcomposer
   * Only invoke this via registerExtraForm() method!
   * @return string
   */
  public function buildWpIconForm($settings, $value) {

    // Define the assets to load via loadFormAssets() method
    $this->assets = array(
      'wp-icons',
      'wp-bootstrap',
      'jquery-iconpicker',
      'wp-visualcomposer-form',
    );

    $this->loadFormAssets('vt-icon-form');
    $object = new VTCore_Wordpress_Objects_Array($settings);

    // This is where we put the default value back to the form
    // when VC build the popup panel! not via javascript!
    if (!empty($value)) {
      $object->add('value', $value);
    }

    // Inject the value
    if ($object->get('value')) {
      $object->merge(wp_parse_args(html_entity_decode($object->get('value'))));
    }

    $form = new VTCore_Bootstrap_Form_BsInstance(array(
      'data' => array(
        'iconset-editor' => true,
      )
    ));
    $form
      ->addChildren(new VTCore_Wordpress_Form_WpIcon(array(
        'name' => 'icon',
        'value' => $object->get('icon'),
      )));


    $target = new VTCore_Form_Hidden(array(
      'attributes' => array(
        'value' => $object->get('value'),
        'name' => $object->get('param_name'),
        'data-query-value' => 'true',
        'class' => array(
          'wpb_vc_param_value',
          'wpb-input',
          $object->get('param_name')
        )
      ),
    ));

    unset($object);
    $object = NULL;

    return $target->__toString() . $form->__toString();
  }



  /**
   * Method for loading and compressing assets
   * This is required for injecting custom assets
   * into the visualcomposer popup form easily.
   */
  public function loadFormAssets($id = 'vtcore-managed-asset', $assets = array()) {

    $css = '';
    $js = '';
    $library = VTCore_Wordpress_Init::getFactory('assets')->get('library');

    // Allow dynamic injection
    if (!empty($assets)) {
      $this->assets = array_merge($this->assets, $assets);
    }

    // Make a reference to the global asset object
    foreach ($this->assets as $asset) {

      if ($library->get($asset . '.css')) {
        $content = '';
        foreach ($library->get($asset . '.css') as $file) {
          $this->base = trailingslashit(dirname($file['url']));
          $content .= @file_get_contents($file['path']);
        }

        $css .= preg_replace_callback(
                  '/url\(\s*[\'"]?(?![a-z]+:|\/+)([^\'")]+)[\'"]?\s*\)/i',
                  array($this, 'fixCssPath'),
                  $content
                );
      }


      if ($library->get($asset . '.js')) {
        foreach ($library->get($asset . '.js') as $file) {
          $js .= @file_get_contents($file['path']);
          if (substr($js, -1) != ';') {
            $js .= ";\n";
          }
        }
      }
    }
    if (!empty($css)) {
      echo '<style id="' . $id . '-css" type="text/css">'
            . preg_replace('/^@charset\s+[\'"](\S*?)\b[\'"];/i', '', $css)
            . '</style>';
    }

    if (!empty($js)) {

      // Some script will need the ajaxurl
      echo '<script id="ajax-helper" type="text/javascript">'
            . 'var ajaxurl = "' . admin_url('admin-ajax.php') . '";'
            . '</script>';

      echo '<script id="' . $id . '-js" type="text/javascript">'
            . $js
            . '</script>';
    }

    // Clean the base and assets
    $this->assets = array();
    $this->base = '';

    unset($library);
    $library = NULL;

    return $this;

  }

  /**
   * Method ripped from drupal for fixing css relative path
   */
  public function fixCssPath($matches, $base = NULL) {

    // Store base path for preg_replace_callback.
    if (isset($base)) {
      $this->base = $base;
    }

    // Prefix with base and remove '../' segments where possible.
    $path = $this->base . $matches[1];
    $last = '';
    while ($path != $last) {
      $last = $path;
      $path = preg_replace('`(^|/)(?!\.\./)([^/]+)/\.\./`', '$1', $path);
    }
    return 'url(' . $path . ')';
  }

  public function checkVCLoaded() {
    return $this->vc;
  }

  /**
   * Detect if we are trully on VC edit mode
   * This is has to be done this way since
   * all VC detector sucks and doesn't work!
   *
   * @return bool
   */
  public function isVCEditor() {

    $editable = false;
    if (isset($_GET['vc_editable'])) {
      $editable = true;
    }

    if (vc_action() == 'vc_inline') {
      $editable = true;
    }

    if (isset($_POST['action']) && $_POST['action'] == 'vc_edit_form') {
      $editable = true;
    }

    if (isset($_GET['wpb_vc_js_status'])) {
      $editable = true;
    }

    if (VTCore_Wordpress_Utility::checkCurrentPage(array('post.php', 'post-new.php'))) {
      $editable = true;
    }

    // VC on ajax when cloning params
    if (isset($_POST['action']) && $_POST['action'] == 'vc_param_group_clone') {
      $editable = true;
    }

    return $editable;
  }

}