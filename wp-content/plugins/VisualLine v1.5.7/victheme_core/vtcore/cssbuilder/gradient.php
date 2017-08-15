<?php
/**
 * CSSBuilder extension for building valid CSSBuilder rules for color gradients
 * This is a final class, no extension is possible.
 *
 * Currently supports :
 * 1. Linear gradient with multiple color stops
 * 2. Linear gradient repeating with multiple color stops (experimental)
 * 3. Radial gradient with multiple color stops (experimental)
 * 4. Radial gradient repeating with multiple color stops (experimental)
 *
 * How to use :
 *
 * // Build the object
 * $gradient = new VTCore_CSSBuilder_Gradient(array(
 *   'type' => 'linear',
 *   'settings' => array(
 *     'direction' => 'top',
 *    ),
 *    'colors' => array(
 *      array('stop' => '0%', 'color' => 'black'),
 *      array('stop' => '100%', 'color' => 'green'),
 *    ),
 *    'repeat' => false,
 *  );
 *
 *  // Get the array of css rules, inject the array
 *  // to CSSBuilder rules object
 *  $gradient->getRules();
 *
 *  // Get the pure css rule
 *  $gradient->render();
 *
 *
 * Context array valid rule :
 *
 *   type          : (string) linear|gradient
 *   settings      : (array)  the gradient settings
 *    |- direction : (string) the gradient direction can be left|right|up|down|diagonal
 *    |                      or degree of angles, only used in linear type
 *    |
 *    |- size      : (string) the radial gradient size can be farthest-corner|farthest-side
 *    |                      |closest-side|closest-corner only used in radial type
 *    |
 *    |- shape     : (string) circle|eclipse, only used in radial type
 *    |- position  : (string) center|eclipse|circle|size in pixel like 100px 100px, only
 *                          used in radial type
 *
 *   repeat        : (boolean) true|false, set the repeat mode on or off
 *
 *   colors        : (array) define multiple color stops
 *     |- array
 *         |- stop : (string) the color stop point can be percentage or pixel value
 *         |                   example : 100% or 100px
 *         |- color: (string) the color value in hex|rgba|rgb
 *
 *
 *
 * @author jason.xie@victheme.com
 *
 */
final class VTCore_CSSBuilder_Gradient {


  /**
   * Default context value
   * set to build linear mode with top to bottom
   * linear gradient
   */
  private $context = array(
    'type' => 'linear',
    'repeat' => false,
    'settings' => array(
      'direction' => 'top',
      'size' => '',
      'shape' => '',
      'position' => '',
    ),
    'colors' => array(),
  );



  private $selector = 'background';
  private $colors = '';
  private $repeat = '';
  private $settings = array();
  private $rules = array();
  private $fallback = false;


  private $prefix = array(
    '-o-',
    '-moz-',
    '-webkit-',
    '-ms-',
    ' ',
  );




  /**
   * Construct the object and process the
   * context arrays.
   *
   * @param array $context
   */
  public function __construct($context) {

    $this->context = VTCore_Utility::arrayMergeRecursiveDistinct($context, $this->context);

    $this->type = $this->context['type'];

    $colors = array();
    foreach ($this->context['colors'] as $color) {
      if (empty($color['color']) || empty($color['stop'])) {
        continue;
      }
      $colors[] = $color['color'] . ' ' . $color['stop'];
    }

    if (isset($context['colors'][0]) && isset($context['colors'][0]['color'])) {
      $this->fallback = $context['colors'][0]['color'];
    }

    $this->colors = implode(', ', $colors);

    $this->settings = $this->context['settings'];

    if ($this->context['repeat']) {
      $this->repeat = 'repeating-';
    }


    // Free up memory
    unset($this->context);

  }





  /**
   * Build the linear settings
   */
  private function getLinearDirection() {
    if (is_numeric($this->settings['direction'])) {
      $this->settings['direction'] .= 'deg';
    }

    return $this->settings['direction'];
  }



  /**
   * Build the radial settings
   */
  private function getRadialSetting() {

    if (isset($this->settings['position'])) {
      $this->settings['position'] .= ',';
    }

    return $this->settings['position'] . ' ' . $this->settings['shape'] . ' ' . $this->settings['size'];

  }





  /**
   * Build the linear gradient css rules and
   * store them in rules array
   */
  private function buildLinearGradient() {
    $setting = $this->getLinearDirection();
    foreach ($this->prefix as $prefix) {
      $this->rules[] = $this->selector . ': ' . $prefix . $this->repeat . 'linear-gradient(' . $setting . ', ' . $this->colors . ')';
    }
  }




  /**
   * Build the radial gradient css rules and store
   * them in the rules array
   */
  private function buildRadialGradient() {
    $setting = $this->getRadialSetting();
    foreach ($this->prefix as $prefix) {
      $this->rules[] = $this->selector . ': ' . $prefix . $this->repeat . 'radial-gradient(' . $setting . ', ' . $this->colors . ')';
    }
  }




  /**
   * build the rules and return them as rules
   * array compatible with CSSBuilder rules
   * @return array
   */
  public function getRules() {

    if ($this->fallback) {
      $this->rules[] = 'background: ' . $this->fallback;
    }

    switch ($this->type) {
      case 'linear' :
        $this->buildLinearGradient();
      break;

      case 'radial' :
        $this->buildRadialGradient();
      break;
    }


    return $this->rules;
  }




  /**
   * Build the rules and return them as CSS
   * valid string
   * @return string
   */
  public function render() {

    $this->getRules();

    return (implode("; \n  ", $this->rules));
  }
}