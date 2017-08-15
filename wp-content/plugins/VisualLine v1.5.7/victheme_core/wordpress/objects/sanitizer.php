<?php
/**
 * Simple object class for sanitizing text or array
 * of text, using wordpress sanitation functions
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Objects_Sanitizer {

  protected $result = false;
  protected $type = 'attr';


  /**
   * Method for invoking the sanitation process
   *
   * @param $value
   * @param bool $type
   * @return array|bool
   */
  public function sanitize($value, $type = false) {
    
    if (!empty($value) && !empty($type)) {
      
      $this->result = $value;
      $this->type = $type;

      if (is_array($this->result)) {
        array_walk_recursive($this->result, array($this, 'sanitizeRecursive'));
      }
      else {
        $this->result = $this->process($this->result, $this->type);
      }
    }

    return $this->result;
  }

  /**
   * Method to be called via the array_walk_recursive when
   * processing the sanitation process.
   * @param $value
   * @param $key
   */
  protected function sanitizeRecursive(&$value, $key) {
    $value = $this->process($value, $this->type);
  }


  /**
   * Method for processing sanitating a single value
   *
   * @param $value
   * @param string $type
   * @return string|void
   */
  protected function process($value, $type = 'attr') {

    switch ($type) {
      case 'attr' :
        $value = esc_attr($value);
        break;
      case 'url' :
        $value = esc_url($value);
        break;
      case 'js' :
        $value = esc_js($value);
        break;
      case 'html' :
        $value = esc_html($value);
        break;
      case 'data' :
        $value = wp_kses_data($value);
        break;
      case 'post' :
        $value = wp_kses_post($value);
        break;
    }

    return $value;
  }

}