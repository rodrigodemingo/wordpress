<?php
/**
 * Base class for bridging VTCore HTML class and it's subclasses
 * into WordPress Shortcode API.
 *
 * Adding a new shortcode class process :
 *
 * 1. Add the new shortcode base into $shortcode either via the VTCore init shortcodes factory
 *    or do it via WordPress filter vtcore_register_shortcode.
 * 2. If the subclasses have different naming convention other than VTCore_Wordpress_Shortcodes_
 *    then it must register the overloader naming via $overloaderPrefix or via
 *    WordPress filter vtcore_register_shortcode_prefix or via VTCore init shortcode factory
 * 3. The shortcode subclass must handle its own autoloading mechanism if it is not
 *    using the VTCore autoloading class.
 * 4. Create the subclasses that defines the shortcode (look at the api folder for example)
 *
 * @author jason.xie@victheme.com
 */
abstract class VTCore_Wordpress_Models_Shortcodes {

  /**
   * All subclasses must store their object in this variable
   */
  protected $object;


  /**
   * Subclasses can define attributes with camel case that
   * should be preserved at all cost.
   *
   * The convertion will be invoked in the __call() method.
   */
  protected $camelcase = array();


  /**
   * Variable for storing shortcode attributes
   */
  protected $atts = array();


  /**
   * Subclass should store their default data here
   */
  protected $data = array();



  /**
   * Subclass can define settings arrays
   * this is usefull for jQuery plugin that has
   * camel case for the settings which cannot
   * use data- method
   */
  protected $settings = array();



  /**
   * Subclass can defined the attributes key
   * that must be converted to booleans by
   * supplying the key of the attributes array
   * in this array.
   */
  protected $booleans = array();


  /**
   * Subclass can defined the attributes key
   * that must be converted to integer by
   * supplying the key of the attributes array
   * in this array.
   */
  protected $int = array();



  /**
   * Marker for auto processing tags, set this to
   * false in the child element if it doesn't want
   * auto tag processing.
   */
  protected $processTag = true;



  /**
   * Marker for auto converting data into attributes
   * data with key prefix.
   */
  protected $convertDataToAttributes = true;


  /**
   * Marker for converting attributes from invalid
   * shortcode due to use of dotted notation into
   * a valid shortcode attributes array.
   *
   * Dotted notation support . and # as the array
   * breaker.
   */
  protected $processDottedNotation = false;


  /**
   * Marker for allowing plugin to convert bootstrap
   * grid classes into Visual composer grids
   * @var bool
   */
  protected $convertVCGrid = false;


  /**
   * Storing the shortcode calling name
   */
  protected $shortcode = false;

  /**
   * Constructor method, this is important because
   * we need to preprocess the atts to match HtmL object
   * and its subclasses context rules
   *
   * @param array $atts  raw attributes provided by WordPress Shortcode API
   * @param string $content  raw content provided by WordPress Shortcode API
   * @param string $shortcode the shortcode name
   */
  public function __construct($atts = array(), $content = NULL, $shortcode = NULL) {
    $this->content = $content;
    $this->shortcode = $shortcode;
    $this->preprocessAtts($atts);
  }




  /**
   * Returning the markup for the stored object
   */
  public function getMarkup() {

    // @hook allow other class or plugin to do final alteration
    //       before the object is rendered.
    do_action('vtcore_wordpress_shortcode_object_alter', $this->object);

    $markup = (is_object($this->object)) ?  $this->object->__toString() : $this->object;

    if ($this->convertVCGrid) {

      VTCore_Wordpress_Utility::loadAsset('wp-visualcomposer-extra');

      // Extract the class="*" string from markup
      $regex = '/class="([^"]*+)"/m';
      preg_match_all($regex, $markup, $classes, PREG_PATTERN_ORDER);

      if (isset($classes[0]) && !empty($classes[0])) {
        foreach ($classes[0] as $class) {

          $class = ' ' . str_replace('class="', 'class=" ', $class);
          $newstring = str_replace(
            array(
              ' row',
              ' col-',
              ' push-left',
              ' push-right',
              ' pull-left',
              ' pull-right',
              ' pull-center',
              ' text-center',
              ' text-left',
              ' text-right',
              ' hidden-',
              ' visibile-',
            ),
            array(
              ' vc_row',
              ' vc_col-',
              ' vc_push-left',
              ' vc_push-right',
              ' vc_pull-left',
              ' vc_pull-right',
              ' vc_pull-center',
              ' vc_txt_align_center',
              ' vc_txt_align_left',
              ' vc_txt_align_right',
              ' vc_hidden-',
              ' vc_visible-'
            ),
            $class);

          $markup = str_replace(
            trim(str_replace('class=" ', 'class="', $class)),
            trim(str_replace('class=" ', 'class="', $newstring)),
            $markup);
        }
      }
    }

    return $markup;
  }



  /**
   * Some jQuery plugin is very picky about camelcase data
   * attributes. this function will preserve the original
   * camelcase taken from shortcode atts.
   *
   * Sub class must define the protected $camelcase variable
   * to let the base class undertand on what to preserve.
   *
   * @param array $atts
   * @return array
   */
  protected function preserveCamelCase() {
    $object = new VTCore_Wordpress_Objects_Array((array)$this->atts);
    foreach ($this->camelcase as $case) {
      $name = strtolower($case);
      if ($object->get($name)) {
        $object->add($case, $object->get($name));
        $object->remove($name);
      }
    }

    $this->atts = $object->extract();
    unset($object);
    $object = null;
  }





  /**
   * VTCore don't allow string as class
   * convert them into arrays.
   */
  protected function processClass() {
    if (isset($this->atts['class'])) {
      $classes = explode(' ', $this->atts['class']);

      if (is_array($classes)) {
        foreach ($classes as $class) {
          $this->atts['attributes']['class']['custom-' . $class] = $class;

          if ($class == 'equalheightRow') {
            VTCore_Wordpress_Utility::loadAsset('jquery-equalheight');
          }
        }
      }

      unset($this->atts['class']);
    }
  }



  /**
   * Process attributes ID
   */
  protected function processID() {
    if (isset($this->atts['id'])) {
      $this->atts['attributes']['id'] = str_replace(' ', '-', $this->atts['id']);
      unset($this->atts['id']);
    }
  }




  /**
   * Preprocess bootstrap grids
   */
  protected function processGrid() {
    $gridKeys = array(
      'columns',
      'push',
      'pull',
      'offset',
      'hidden',
      'visible',
    );

    if (!empty($this->atts) && is_array($this->atts)) {

      foreach ($this->atts as $key => $value) {

        if (strpos($key, '_') === false) {
          continue;
        }

        list($type, $name) = explode('_', $key);

        // @bugfix hidden and visible always printed
        if (($type == 'hidden' || $type == 'visible') && empty($value)) {
          continue;
        }

        if (in_array($type, $gridKeys)) {
          $this->atts['grids'][$type][$name] = $value;
        }
      }

    }
  }



  /**
   * Preprocess data attributes, this
   * method is useful for creating data-x attributes
   * as defined in the $data and $atts.
   */
  protected function processData() {

    foreach ($this->data as $key => $value) {
      if (isset($this->atts[$key])) {
        $this->atts['data'][$key] = $this->atts[$key];

        if ($this->convertDataToAttributes) {
          $this->atts['attributes']['data-' . $key] = $this->atts[$key];
        }

        unset($this->atts[$key]);
      }
    }
  }




  /**
   * Preprocess Settings
   * The markup will be data-settings and in json format
   */
  protected function processSetting() {
    $settings = array();
    foreach ($this->settings as $key) {
      if (isset($this->atts[$key])) {
        $settings[$key] = $this->atts[$key];
      }
    }

    if (!empty($settings)) {
      $this->atts['data']['settings'] = json_encode($settings);
    }
  }



  /**
   * Preprocess shortcode tag attributes and assign
   * the value as the object tags.
   */
  protected function processTag() {
    if (isset($this->atts['tag']) && !empty($this->atts['tag']) && $this->processTag == true) {
      $this->atts['type'] = $this->atts['tag'];
    }
  }

  /**
   * Preprocess inline styles
   * shortcode must utilize style params with normal inline
   * style in the format of style:value; to utilize this
   * methor properly.
   */
  protected function processInlineStyle() {
    if (isset($this->atts['style']) && !empty($this->atts['style'])) {
      $styles = explode(';', $this->atts['style']);
      foreach ($styles as $style) {
        if (strpos($style, ':') !== false) {
          list($key, $value) = explode(':', $style);
          $this->atts['styles'][trim($key)] = trim($value);
        }
      }
    }
  }


  /**
   * Process dotted notation and explode them
   * into real arrays
   *
   * Wordpress by default will failed to parse
   * the attributes due to the character used
   * as dotted notation breaker (. or #) is treated
   * as invalid character.
   *
   * The original array will be a numeric keyed
   * array with the verbatim attributes string, example
   *
   * array(
   *  0 => 'somekey#somechildkey#somegranchildkey="somevalue"',
   * );
   *
   * Visual Composer as of 4.4.3 doesn't support . or # as
   * the breaker, use ___ instead (triple underscore).
   *
   * This method supports both . and # as the breaker.
   */
  protected function processDottedNotation() {

    if ($this->processDottedNotation && is_array($this->atts)) {
      foreach ($this->atts as $key => $value) {

        // Wordpress convert dotted to numerical array, convert
        // it to dotted key and value
        if (is_numeric($key)) {
          list($dottedKey, $dottedValue) = explode('=', $value);

          // Visual composer can't handle anything except underscore.
          if (strpos($dottedKey, '___') !== false) {
            $dottedKey = str_replace('___', '.', $dottedKey);
          }

          $this->remove($key);
          $this->add($dottedKey, substr($dottedValue, 1, -1));
        }

        // Normal dotted, direct injecting
        elseif (strpos($key, '#') !== false || strpos($key, '.') !== false) {
          $this->remove($key);
          $this->add($key, $value);
        }

        // Handling VisualComposer, only underscore allowed
        elseif (strpos($key, '___') !== false) {
          $dottedKey = str_replace('___', '.', $key);
          $this->remove($key);
          $this->add($dottedKey, $value);
        }

      }
    }
  }


  /**
   * Preprocess booleans
   * This method will search for attributes as specified
   * in the $booleans class variables and attempt to
   * convert value such as "true", "false", 0, 1 into
   * the corresponding booleans
   */
  protected function processBooleans() {
    foreach ($this->booleans as $key) {
      if ($this->get($key)) {
        $this->add($key, filter_var($this->get($key), FILTER_VALIDATE_BOOLEAN));
      }
    }
  }


  /**
   * Preprocess Int
   * This method will search for attributes as specified
   * in the $int class variables and attempt to
   * convert value to true integers
   */
  protected function processInt() {
    foreach ($this->int as $key) {
      if ($this->get($key)) {
        $this->add($key, (int) $this->get($key));
      }
    }
  }


 /**
  * Custom preprocess function, this is meant to be
  * extended by subclass if needed.
  */
  protected function processCustomRules() {}



  /**
   * Preprocess shortcode attributes first
   * as many jQuery plugin is very picky about the data structure.
   */
  protected function preprocessAtts($atts) {

    $this->atts = $atts;

    $this->atts['shortcode'] = strtolower($this->shortcode);

    $this->processDottedNotation();
    $this->preserveCamelCase();
    $this->processBooleans();
    $this->processInt();
    $this->processID();
    $this->processClass();
    $this->processData();
    $this->processGrid();
    $this->processSetting();
    $this->processTag();
    $this->processInlineStyle();


    // Sub class can override this to provide
    // their own attributes preprocess function.
    $this->processCustomRules();

    $this->atts = apply_filters('vtcore_wordpress_shortcode_attributes_alter', $this->atts);

    return $this->atts;
  }


  public function extract() {
    return $this->atts;
  }


  public function set(array $value) {
    $this->atts = $value;
    return $this;
  }


  public function reset() {
    $this->atts = array();
    return $this;
  }


  public function add($keys, $value) {
    if (!is_array($this->atts)) {
      $this->atts = (array) $this->atts;
    }
    VTCore_Utility::setArrayValueKeys($this->atts, $keys, $value);
    return $this;
  }


  public function get($keys) {
    if (!is_array($this->atts)) {
      $this->atts = (array) $this->atts;
    }
    return VTCore_Utility::getArrayValueKeys($this->atts, $keys);
  }


  public function remove($keys) {
    if (!is_array($this->atts)) {
      $this->atts = (array) $this->atts;
    }
    VTCore_Utility::removeArrayValueKeys($this->atts, $keys);
    return $this;
  }


  public function merge(array $options) {
    if (!is_array($this->atts)) {
      $this->atts = (array) $this->atts;
    }
    if (!is_array($options)) {
      $options = (array) $options;
    }
    $this->atts = VTCore_Utility::arrayMergeRecursiveDistinct($options, $this->atts);
    return $this;
  }


}