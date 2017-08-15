<?php
/**
 * Generic model allowing user to use dotted notation for
 * array operation.
 *
 * @author jason.xie@victheme.com
 *
 */
abstract class VTCore_Wordpress_Models_Dot {

  protected $options;
  protected $filter;
  protected $sanitizer;
  protected $sanitizerClass = 'VTCore_Wordpress_Objects_Sanitizer';


  /**
   * Construct the object.
   * Pass in the array to be stored in the object and
   * act as the target for object operations
   *
   * @param array $options
   */
  public function __construct($options = array()) {
    $this->set($options);
    $this->sanitizer = new $this->sanitizerClass();
  }


  /**
   * Retrieve all the stored object array.
   *
   * @return mixed
   */
  public function extract() {
    return $this->options;
  }


  /**
   * Replace the stored array with a new array as passed
   * by argument one.
   *
   * @param array $value
   * @return $this
   */
  public function set(array $options) {
    $this->options = $options;
    return $this;
  }


  /**
   * Remove the stored array and replace it with
   * an empty array
   *
   * @return $this
   */
  public function reset() {
    $this->set(array());
    return $this;
  }


  /**
   * Add a new entry to the stored array by dotted
   * notation keys and its value.
   *
   * @param $keys
   * @param $value
   * @return $this
   */
  public function add($keys, $value) {
    if ((array) $this->options === $this->options) {
      VTCore_Utility::setArrayValueKeys($this->options, $keys, $value);
    }
    return $this;
  }


  /**
   * This is an alias for the add() method
   *
   * @param $keys
   * @param $value
   * @return VTCore_Wordpress_Models_Dot
   */
  public function mutate($keys, $value) {
    return $this->add($keys, $value);
  }


  /**
   * This is an alias for the add() method
   *
   * @param $keys
   * @param $value
   * @return VTCore_Wordpress_Models_Dot
   */
  public function change($keys, $value) {
    return $this->add($keys, $value);
  }


  /**
   * Retrieve a single value with dotted notation
   * as the keys from the stored array
   *
   * You can also sanitize the values by passing
   * the sanitation format in the second argument
   *
   * Valid sanitation arguments :
   * - attr   - will pass all the retrieved value to esc_attr
   * - url    - will pass all the retrieved value to esc_url
   * - js     - will pass all the retrieved value to esc_js
   * - html   - will pass all the retrieved value to esc_html
   * - post   - will pass all the retrieved value to wp_kses_post
   * - data   - will pass all the retrieved value to wp_kses_data
   *
   *
   * @param $keys
   * @param bool $sanitize
   * @return array|null|string|void
   */
  public function get($keys, $sanitize = false) {

    if ((array) $this->options === $this->options) {
      $this->result = VTCore_Utility::getArrayValueKeys($this->options, $keys);
    }

    if ($sanitize && $this->result) {
      $this->result = $this->sanitizer->sanitize($this->result, $sanitize);
    }

    return $this->result;
  }


  /**
   * Remove entry from the stored array by dotted notation
   * keys. this can remove the array entry recursively.
   *
   * @param $keys
   * @return $this
   */
  public function remove($keys) {
    if ((array) $this->options === $this->options) {
      VTCore_Utility::removeArrayValueKeys($this->options, $keys);
    }
    return $this;
  }


  /**
   * Merge the stored arrays with a new one as supplied via
   * the argument one, the merging is distinct meaning only one
   * array keys at the same level can exists.
   *
   * @param $options
   * @return $this
   */
  public function merge($options) {
    if ((array) $options === $options && $this->options !== $options) {
      $this->options = VTCore_Utility::arrayMergeRecursiveDistinct($options, $this->options);
    }
    elseif (!empty($options) && empty($this->options)) {
      $this->options = (array) $options;
    }
    return $this;
  }



  /**
   * Insert an array to the first level of the stored array.
   * This method will override any existing first level array
   * with the same key as the one supplied in the argument one.
   *
   * @param $key
   * @param $options
   * @return $this
   */
  public function insert($key, $options) {
    $this->options[$key] = $options;
    return $this;
  }



  /**
   * Push new options to options array using array_push
   * Note that passing an array to the new options will just
   * add the whole array to the next level.
   *
   * The array key will be a numeric value, use add() method
   * to define a non numerical array key when trying to add
   * a new array.
   *
   * To preserve keys define $preserve = true and this
   * method will not use array_push function
   *
   * @param $key
   * @param $options
   * @param $preserve
   * @return $this
   */
  public function append($key, $options, $preserve = false) {
    if ((array) $this->options === $this->options) {
      if (!$preserve) {
        array_push($this->options[$key], $options);
      }
      else {
        $this->options[$key][] = $options;
      }
    }
    return $this;
  }


  /**
   * Prepend a new options to the options array using array_unshift
   * Note that the new key will be reordered if the whole array appended
   * has numerical value.
   *
   * Use $preserveKey = true to preserve the key and not use array_unshift
   *
   * @param $key
   * @param $options
   * @param $preserve
   * @return $this
   */
  public function prepend($key, $options, $preserve = false) {
    if ((array) $this->options === $this->options) {

      if (!$preserve) {
        array_unshift($this->options[$key], $options);
      }
      else {
        $arr = array_reverse($this->options[$key]);
        $arr[$key] = $options;
        $this->options[$key] = array_reverse($arr);
        unset($arr);
        $arr = NULL;
      }
    }

    return $this;
  }


}