<?php
/**
 * Defining the API Version number
 */
define('HTML_API', '2.0');

/**
 * HTML Builder Class
 *
 * The main class for trully building HTML elements
 * as a true OOP object.
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Html_Base {

  static protected $delta = 0;
  static protected $vtcore_classes = array();

  protected $context = array();
  protected $overloaderPrefix = array('VTCore_Html_');
  protected $childrenPointer = '';
  protected $booleans = array();
  protected $int = array();

  // Obsolete, use $booleans instead with dotted array key.
  protected $convertBool = array();

  private $closers = array('input', 'img', 'hr', 'br', 'meta', 'link');
  private $objectID = '';
  private $innerHTML = '';
  private $type;
  private $attributes = array();
  private $parent;
  private $children = array();
  private $styles = array();
  private $allowEmpty = array('value');
  private $raw = FALSE;
  private $clean = TRUE;
  private $data = array();
  private $html5Attributes = array(
    'controls',
    'autoplay',
  );


  /**
   * Constructing the object and processing
   * the context array
   */
  public function __construct($context = array()) {
    $this->buildObject($context);
    $this->buildElement();
  }


  /**
   * Helper function to build the object
   * This class must be called in any child base class that
   * override the parent __construct()
   */
  public function buildObject($context) {

    $this->objectID = self::$delta++;
    $this->setContext($context);

    if (isset($this->context['type'])) {
      $this->setType($this->context['type']);
    }

    if (isset($this->context['raw'])) {
      $this->setRaw($this->context['raw']);
    }

    if (isset($this->context['styles'])) {
      $this->setStyle($this->context['styles']);
    }

    if (isset($this->context['clean'])) {
      $this->setClean($this->context['clean']);
    }

    if (isset($this->context['data'])) {
      $this->setData($this->context['data']);
    }

    $children = $this->getContext('children');
    if (!empty($children)) {
      if (is_array($children)) {
        foreach ($this->getContext('children') as $child) {
          $this->addChildren($child);
          unset($child);
        }
      }
      else {
        $this->addChildren($children);
      }
    }

    if (!empty($this->booleans)) {
      $this->processBooleans();
    }

    if (!empty($this->int)) {
      $this->processInt();
    }

    // Garbage cleanup
    $children = NULL;
    unset($children);

    $context = NULL;
    unset($context);

    return $this;
  }


  /**
   * This function is meant to be extended
   */
  public function buildElement() {
    $this->addAttributes($this->getContext('attributes'));
    return $this;
  }


  /**
   * Overloading method that is declared on child subclass
   * but not in this main class.
   *
   * Note: this is very expensive, avoid at all cost when
   * building your chainable model.
   */
  public function __call($method, $context) {

    foreach ($this->overloaderPrefix as $prefix) {
      $class = $prefix . $method;
      $name = '';
      if (isset(self::$vtcore_classes[$class])) {
        if (self::$vtcore_classes[$class]) {
          $name = $class;
          break;
        }
      }
      else {
        if (class_exists($class, TRUE)) {
          $name = $class;
          self::$vtcore_classes[$class] = TRUE;
          break;
        }
        else {
          self::$vtcore_classes[$class] = FALSE;
        }
      }
    }

    if (!empty($name)) {
      $object = new $name(array_shift($context));
      unset($context);
    }

    if (isset($object) && is_object($object)) {
      $object->setParent($this);
      $this->addChildren($object);

      unset($object);

    }
    else {
      throw new Exception('Error Class VTCore_Html_' . $method . ' does\'t exists');
    }

    return $this;
  }


  /**
   * Injecting new self closing element if needed
   */
  public function addSelfClosers($element) {
    $this->closers[] = $element;
    return $this;
  }


  /**
   * Merging element default context array with
   * the user configured context array.
   */
  public function setContext($context) {
    $this->context = VTCore_Utility::arrayMergeRecursiveDistinct($context, $this->context);
    $context = NULL;
    unset($context);
    return $this;
  }


  /**
   * Retrieving stored context
   */
  public function getContext($type) {
    return VTCore_Utility::getArrayValueKeys($this->context, $type);
  }


  /**
   * Find context by its array key
   */
  public function findContext($key) {
    return VTCore_Utility::searchArrayValueByKey($this->context, $key);
  }


  /**
   * Retrieving all context
   */
  public function getContexts() {
    return $this->context;
  }


  /**
   * Add or replace context with new value
   *
   * $keys can be string or arrays, string will be converted
   * to arrays.
   *
   * it supports dotted and hashed drilling.
   * example :
   *   arraykey.arraykey2.arraykey3
   *   or
   *   arraykey#arraykey2#arraykey3
   *
   *   is equal to
   *   array(arraykey, arraykey2, arraykey3)
   */
  public function addContext($key, $value) {
    $this->context = VTCore_Utility::setArrayValueKeys($this->context, $key, $value);
    return $this;
  }


  /**
   * Remove context per keys
   *
   * $keys can be string or arrays, string will be converted
   * to arrays. the last key will be removed from context
   *
   * If the last key doesn't exist the method will not
   * remove anything.
   *
   * it supports dotted and hashed drilling.
   * example :
   *   arraykey.arraykey2.arraykey3
   *   or
   *   arraykey#arraykey2#arraykey3
   *
   *   is equal to
   *   array(arraykey, arraykey2, arraykey3)
   */
  public function removeContext($key) {
    $this->context = VTCore_Utility::removeArrayValueKeys($this->context, $key);
    return $this;
  }


  /**
   * Merge context
   */
  public function mergeContext(array $context) {
    $this->context = VTCore_Utility::arrayMergeRecursiveDistinct($context, $this->context);
    return $this;
  }


  /**
   * Remove all context value
   */
  public function resetContext() {
    $this->context = array();
    return $this;
  }


  /**
   * Method for replacing the whole context
   * array with new context
   */
  public function replaceContext($context) {
    $this->context = $context;
    return $this;
  }


  /**
   * Experimental method for cleaning context array
   */
  public function cleanEmptyContext($key = FALSE) {

    $array = $key ? $this->getContext($key) : $this->getContexts();
    if (is_array($array)) {
      $array = VTCore_Utility::arrayFilterEmpty($array);
    }

    if ($key) {
      empty($array) ? $this->removeContext($key) : $this->addContext($key, $array);
    }
    else {
      empty($array) ? $this->resetContext() : $this->replaceContext($array);
    }

    unset($array);

    return $this;
  }


  /**
   * Declaring the object html tag type.
   * Empty tags will not be printed although the stored children
   * will be processed.
   */
  public function setType($type) {
    $this->type = $type;
    return $this;
  }


  /**
   * Retrieving the current object element type
   */
  public function getType() {
    return $this->type;
  }


  /**
   * Adding a single attribute
   * $keys can be string or arrays, string will be converted
   * to arrays.
   *
   * it supports dotted and hashed drilling.
   * example :
   *   arraykey.arraykey2.arraykey3
   *   or
   *   arraykey#arraykey2#arraykey3
   *
   *   is equal to
   *   array(arraykey, arraykey2, arraykey3)
   */
  public function addAttribute($key, $value) {
    $this->attributes = VTCore_Utility::setArrayValueKeys($this->attributes, $key, $value);

    return $this;
  }


  /**
   * Removing Attributes from object by its key, if recursive
   * is set to true, it will remove the attributes recursively.
   */
  public function removeAttribute($key, $recursive = FALSE) {

    if ($recursive) {
      VTCore_Utility::removeArrayValueByKey($this->attributes, $key);
    }
    elseif (isset($this->attributes[$key])) {
      unset($this->attributes[$key]);
    }

    return $this;
  }


  /**
   * Returning attributed based on $key
   */
  public function getAttribute($key) {
    return VTCore_Utility::getArrayValueKeys($this->attributes, $key);
  }


  /**
   * Add attributes to object
   * @param array $attributes
   */
  public function addAttributes($attributes) {
    $this->attributes = VTCore_Utility::arrayMergeRecursiveDistinct($attributes, $this->attributes);

    return $this;
  }


  /**
   * Returning all attributes
   */
  public function getAttributes() {
    return $this->attributes;
  }


  /**
   * Convert the context data to html5
   * data-* attributes
   */
  protected function buildData() {

    foreach ($this->getDatas() as $key => $value) {

      // HTML5 specs need all lowercase key
      // and no underscore
      $key = strtolower(str_replace('_', '-', $key));

      // HTML5 specs needs string "true" or "false" for
      // true booleans
      if ($value === TRUE) {
        $value = 'true';
      }

      if ($value === FALSE) {
        $value = 'false';
      }

      // Can't determine automatically for value such as
      // 0 or 1, child object need to define these data
      // entry in the $convertBool array
      // Obsolete, use $booleans and $int instead to convert
      // the value while still in context mode.
      if (in_array($key, $this->convertBool)) {
        $value = filter_var($value, FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false';
      }

      // Dont build really "empty" value
      if (empty($value)) {
        continue;
      }

      // HTML5 can only store string
      // Convert to json so jQuery can pick it up easily.
      if (is_array($value) || is_object($value)) {
        $value = json_encode($value);
      }

      $this->addAttribute('data-' . $key, $value);

    }

    return $this;
  }


  /**
   * Set the HTML 5 data
   */
  public function setData($data) {
    $this->data = $data;
  }


  /**
   * Retrieving HTML5 data array
   */
  public function getDatas() {
    return $this->data;
  }


  /**
   * Removing all HTML5 data
   */
  public function cleanDatas() {
    $this->data = array();
    return $this;
  }


  /**
   * Retrieving single HTML5 data
   */
  public function getData($type) {
    return VTCore_Utility::getArrayValueKeys($this->data, $type);
  }


  /**
   * Adding single HTML5 Data
   */
  public function addData($key, $type) {
    $this->data = VTCore_Utility::setArrayValueKeys($this->data, $key, $type);
    return $this;
  }


  /**
   * Removing single HTML5 data
   */
  public function removeData($key) {
    unset($this->data[$key]);
    return $this;
  }


  /**
   * Retrieve object machine id
   * @return string
   */
  public function getMachineID() {
    return $this->objectID;
  }


  /**
   * Set the machine ID
   */
  protected function setMachineID($id) {
    $this->objectID = $id;

    return $this;
  }


  /**
   * Inject string to object as child
   * This can serve to override innerHTML string
   * as well.
   */
  public function setText($text) {
    $this->innerHTML = (string) $text;

    return $this;
  }


  /**
   * Adding string text directly to innerHTML
   */
  public function addText($text) {
    $this->innerHTML .= (string) $text;

    return $this;
  }


  /**
   * Replace text in innerHTML using preg_replace()
   */
  public function replaceText($pattern, $replacement) {
    $this->innerHTML = preg_replace($pattern, $replacement, $this->innerHTML);

    return $this;
  }


  /**
   * Get the innerHTML
   */
  public function getText() {
    return $this->innerHTML;
  }


  /**
   * Set raw HTML mode, if set to true no escaping to html output is performed.
   */
  public function setRaw($mode) {
    $this->raw = $mode;
    return $this;
  }


  /**
   * Set if object should clean the context after rendered
   * for minimizing memory usage.
   */
  public function setClean($clean) {
    if (is_bool($clean)) {
      $this->clean = $clean;
    }

    return $this;
  }


  /**
   * Setting the children pointer variables.
   * This is useful for using other variables than $children for
   * storing the children.
   *
   * This must be invoked or set in object that have
   * nested wrapper object and would like the other object
   * to have an uniform way to add children by using the
   * addChildren() method.
   */
  public function setChildrenPointer($pointer) {
    $this->childrenPointer = $pointer;

    return $this;
  }


  /**
   * Retrieving the pointer variable name
   */
  protected function getChildrenPointer() {

    if (!empty($this->childrenPointer)) {
      return $this->{$this->childrenPointer};
    }

    return $this;
  }


  /**
   * Inserting children object to the parent object
   */
  public function addChildren($object) {
    if (!is_object($object)) {
      $text = (string) $object;
      $object = new VTCore_Html_Base();
      $object->addText($text);
    }

    $object->setParent($this);
    $this->getChildrenPointer()->children[$object->getMachineID()] = $object;

    $object = NULL;
    unset($object);

    return $this;
  }


  /**
   * Insert new children at the beginning of children array
   */
  public function prependChild($object) {
    if (!is_object($object)) {
      $text = (string) $object;
      $object = new VTCore_Html_Base();
      $object->addText($text);
    }

    $array1 = $this->getChildrenPointer()->children;
    $array2[$object->getMachineID()] = $object;
    $this->setChildren($array2 + $array1);

    unset($object);
    unset($array1);
    unset($array2);

    return $this;
  }


  /**
   * Retrieving children object by its id
   */
  public function getChildren($id = FALSE) {
    if (isset($this->getChildrenPointer()->children[$id])) {
      return $this->getChildrenPointer()->children[$id];
    }

    return FALSE;
  }


  /**
   * Force Overwrite all childrens
   */
  public function setChildren($children) {
    $this->getChildrenPointer()->children = $children;

    return $this;
  }


  /**
   * Get all childrens
   */
  public function getChildrens() {
    return $this->getChildrenPointer()->children;
  }


  /**
   * Method for checking if object has children
   * @return boolean
   */
  public function hasChildren() {
    return ($this->getChildrens() != array());
  }


  /**
   * Retrieving the last children in array
   */
  public function lastChild() {
    return end($this->getChildrenPointer()->children);
  }


  /**
   * Retrieving the first children in array
   */
  public function firstChild() {
    return reset($this->getChildrenPointer()->children);
  }


  /**
   * Retrieving the parent object
   */
  public function getParent() {
    return $this->parent;
  }


  /**
   * Set the parent object
   */
  public function setParent($object) {
    $this->parent = $object;
  }


  /**
   * Reset the chained object to the main parent object
   */
  public function resetObject($object) {
    return $object;
  }


  /**
   * Allowing user to inject overloader prefix when
   * chaining the object build process.
   */
  public function addOverloaderPrefix($prefix) {
    array_unshift($this->overloaderPrefix, $prefix);
    return $this;
  }

  /**
   * Find the children object by specifying children property
   * key and value.
   *
   * Valid search options :
   *
   * Machine ID
   * $type = ID
   * $key = the machine id value
   * $value = FALSE
   *
   * Type
   * $type = type
   * $key = the object type
   * $value = FALSE
   *
   * CSS Class
   * $type = class
   * $key = the class name
   * $value = FALSE
   *
   * Text
   * $type = text
   * $key = text searched in innerHTML
   * $value = use preg_match by inserting patterns
   *
   * Attributes
   * $type = attributes
   * $key = the attribute keys
   * $value = the value of the key, if the source is an array it will use in_array()
   *
   * @param string $type - children property type
   * @param string $key - children property key
   * @param string $value - children property value
   * @return array - array of children object found
   */
  public function findChildren($type, $key, $value = FALSE) {
    $childrens = array();
    $iterators = new RecursiveIteratorIterator(new VTCore_Html_Iterators($this), RecursiveIteratorIterator::SELF_FIRST);
    foreach ($iterators as $object) {

      switch ($type) {
        case 'id' :
          if (!is_array($key)) {
            $key = (array) $key;
          }
          foreach ($key as $id) {
            if ($id == $object->getMachineID()) {
              $childrens[] = $object;
            }
          }
          break;

        case 'type' :
          if (strtolower($key) == strtolower($object->getType())) {
            $childrens[] = $object;
          }
          break;

        case 'class' :
          if (!is_array($key)) {
            $key = (array) $key;
          }

          foreach ($key as $class) {
            if (is_array($object->getAttribute('class')) && in_array($class, $object->getAttribute('class'))) {
              $childrens[] = $object;
            }
          }
          break;

        case 'text' :

          if (!is_array($key)) {
            $key = (array) $key;
          }

          foreach ($key as $text) {
            if (strpos($object->getText(), $text) !== FALSE) {
              $childrens[] = $object;
            }
          }

          if (!is_array($value)) {
            $value = (array) $value;
          }

          foreach ($value as $text) {
            if ($text !== false  && preg_match($text, $object->getText()) !== NULL) {
              $childrens[] = $object;
            }
          }
          break;

        case 'attributes' :
          if (!is_array($value)) {
            $value = (array) $value;
          }

          $attribute = $object->getAttribute($key);
          foreach ($value as $val) {

            if (is_array($attribute) && in_array($val, $attribute)) {
              $childrens[] = $object;
            }

            if (!is_array($attribute) && $attribute == $val) {
              $childrens[] = $object;
            }
          }
          break;

        case 'context' :

          if (!is_array($value)) {
            $value = (array) $value;
          }

          foreach ($value as $val) {
            if ($val != FALSE && $val == $object->getContext($key)) {
              $childrens[] = $object;
            }

            if ($val == FALSE && $object->getContext($key)) {
              $childrens[] = $object;
            }
          }
          break;

        case 'objectType' :
          if (!is_array($key)) {
            $key = (array) $key;
          }
          foreach ($key as $objectType) {
            if (is_a($object, $objectType)) {
              $childrens[] = $object;
            }
          }

          break;
      }
    }

    return $childrens;
  }


  /**
   * Injecting children after $key array value
   */
  public function insertChildrenAfter($key, $new_key, $new_value) {
    if (array_key_exists($key, $this->getChildrens())) {
      $new = array();
      foreach ($this->getChildrens() as $k => $value) {
        $new[$k] = $value;
        if ($k === $key) {
          $new[$new_key] = $new_value;
        }
      }

      if (!empty($new)) {
        $this->resetChildren();
        $this->setChildren($new);
      }

      unset($new);
    }

    return $this;
  }


  /**
   * Remove children by its id
   */
  public function removeChildren($delta) {
    if (isset($this->children[$delta])) {
      unset($this->children[$delta]);
    }

    return $this;
  }


  /**
   * Remove all childrens
   */
  public function resetChildren() {
    $this->children = array();

    return $this;
  }


  /**
   * Adding inline style
   */
  public function addStyle($key, $value) {
    $this->styles = VTCore_Utility::setArrayValueKeys($this->styles, $key, $value);
    return $this;
  }


  /**
   * Removing inline style by key
   */
  public function removeStyle($key) {
    if (isset($this->styles[$key])) {
      unset($this->styles[$key]);
    }

    return $this;
  }


  /**
   * Overriding the styles array
   */
  public function setStyle($styles) {
    $this->styles = $styles;

    return $this;
  }


  /**
   * Retrieving style value by key
   */
  public function getStyle($key) {
    return VTCore_Utility::getArrayValueKeys($this->styles, $key);
  }


  /**
   * Retrieving all styles array
   */
  public function getStyles() {
    return $this->styles;
  }


  /**
   * Reset styles into empty styles variables
   */
  public function resetStyles() {
    $this->styles = array();

    return $this;
  }


  /**
   * Clean object stored variables to free up
   * memory usage.
   */
  public function cleanObject() {

    if ($this->clean) {
      foreach ($this as $key => $value) {
        $this->$key = NULL;
        unset($this->$key);
      }
    }

    return $this;
  }


  /**
   * Build and convert the object into HTML value
   */
  protected function buildContent() {

    $type = $this->getType();

    if (empty($type) && empty($this->children)) {
      $build = $this->getText();
      $this->cleanObject();
      return $build;
    }

    if (empty($type) && !empty($this->children)) {
      return $this->buildInnerHtml();
    }

    // Start building the HTML output
    $build = '<' . $this->getType();

    // Build inline style and add them to attributes
    if (isset($this->styles) && !empty($this->styles)) {
      $styles = array_filter($this->getStyles());

      $style = array();
      foreach ($styles as $key => $value) {
        $style[] = $key . ':' . $value;
      }

      $this->addAttribute('style', implode('; ', $style));

    }

    if (!empty($this->data)) {
      $this->buildData();
    }

    // Add attributes
    if (count($this->getAttributes())) {
      foreach ($this->getAttributes() as $key => $value) {

        if ($value === FALSE) {
          continue;
        }

        if (is_array($value)) {
          $value = implode(' ', $value);
        }

        $value = (string) $value;

        if (!$this->raw) {
          $value = $this->specialchars($this->checkInvalidUTF8($value), ENT_QUOTES);
        }

        if (in_array($key, $this->html5Attributes)) {
          if (filter_var($value, FILTER_VALIDATE_BOOLEAN)) {
            $build .= ' ' . $key;
          }
        }
        else {
          if (strlen($value) || in_array($key, $this->allowEmpty)) {
            $build .= ' ' . $key . '="' . $value . '"';
          }
        }
      }

    }

    if (!in_array($this->getType(), $this->closers)) {
      $build .= '>' . $this->buildInnerHtml() . '</' . $this->getType() . '>';
    }
    else {
      $build .= ' />';
    }

    $this->cleanObject();

    return $build;
  }


  /**
   * Build the inner html value
   */
  private function buildInnerHtml() {
    $build = '';
    if (strlen($this->getText())) {
      $build = ($this->raw) ? $this->getText() : htmlspecialchars($this->getText());
    }

    if (!empty($this->children) && is_array($this->children)) {
      // Don't use getChildrens() method, it may not reflect the correct
      // Children hiearchy if object use different pointers!.
      foreach ($this->children as $k => $child) {
        $build .= $child->buildContent();
        unset($child);
      }
    }

    return $build;
  }


  /**
   * Extra Methods for manipulating class element
   */
  public function addClass($class, $key = FALSE) {
    if (!isset($this->attributes['class']) || !in_array($class, $this->attributes['class'])) {

      if (!$key) {
        $this->attributes['class'][] = $class;
      }
      else {
        $this->attributes['class'][$key] = $class;
      }
    }

    return $this;
  }


  /**
   * Removing class from attributes
   */
  public function removeClass($class) {
    if (isset($this->attributes['class'])) {
      $this->attributes['class'] = array_diff($this->attributes['class'], (array) $class);
    }

    return $this;
  }


  /**
   * Check if element has certain css class
   */
  public function hasClass($class) {
    return isset($this->attributes['class']) ? in_array($class, $this->attributes['class']) : FALSE;
  }


  /**
   * Build and echo the HTML value
   *
   * If context clean is set to true, After invoking
   * this method the object will be destroyed and
   * all property is removed. Make sure to call this
   * as the final invocation and no more object
   * operational will be performed afterwards.
   */
  public function render() {
    $clean = $this->clean;
    echo $this->buildContent();
    if ($clean) {
      unset($this);
    }
    unset($clean);
  }


  /**
   * Build and return the HTML value
   *
   * If context clean is set to true, After invoking
   * this method the object will be destroyed and
   * all property is removed. Make sure to call this
   * as the final invocation and no more object
   * operational will be performed afterwards.
   */
  public function __toString() {
    return $this->buildContent();
  }


  /**
   * Preprocess booleans
   * This method will search for attributes as specified
   * in the $booleans class variables and attempt to
   * convert value such as "true", "false", 0, 1 into
   * the corresponding booleans
   *
   * This method will inject the key to the context and
   * set the value as false if there is no original
   * context by the search key defined originally
   */
  public function processBooleans() {
    foreach ($this->booleans as $key) {
      $this->addContext($key, filter_var($this->getContext($key), FILTER_VALIDATE_BOOLEAN));
    }
  }


  /**
   * Preprocess Int
   * This method will search for attributes as specified
   * in the $int class variables and attempt to
   * convert value to true integers
   *
   * This method will inject the key to the context and
   * set the value as false if there is no original
   * context by the search key defined originally
   */
  public function processInt() {
    foreach ($this->int as $key) {
      if ($this->getContext($key) !== NULL) {
        $this->addContext($key, (int) $this->getContext($key));
      }
    }
  }

  /**
   * Checks for invalid UTF8 in a string.
   *
   * @since 2.8.0
   *
   * @staticvar bool $is_utf8
   * @staticvar bool $utf8_pcre
   *
   * @param string  $string The text which is to be checked.
   * @param bool    $strip Optional. Whether to attempt to strip out invalid UTF8. Default is false.
   * @return string The checked text.
   */
  function checkInvalidUTF8( $string, $strip = false ) {
    $string = (string) $string;

    if ( 0 === strlen( $string ) ) {
      return '';
    }

    // Store the site charset as a static to avoid multiple calls to get_option()
    static $is_utf8 = null;
    if ( ! isset( $is_utf8 ) ) {
      $is_utf8 = in_array( get_option( 'blog_charset' ), array( 'utf8', 'utf-8', 'UTF8', 'UTF-8' ) );
    }
    if ( ! $is_utf8 ) {
      return $string;
    }

    // Check for support for utf8 in the installed PCRE library once and store the result in a static
    static $utf8_pcre = null;
    if ( ! isset( $utf8_pcre ) ) {
      $utf8_pcre = @preg_match( '/^./u', 'a' );
    }
    // We can't demand utf8 in the PCRE installation, so just return the string in those cases
    if ( !$utf8_pcre ) {
      return $string;
    }

    // preg_match fails when it encounters invalid UTF8 in $string
    if ( 1 === @preg_match( '/^./us', $string ) ) {
      return $string;
    }

    // Attempt to strip the bad chars if requested (not recommended)
    if ( $strip && function_exists( 'iconv' ) ) {
      return iconv( 'utf-8', 'utf-8', $string );
    }

    return '';
  }

  /**
   * Converts a number of special characters into their HTML entities.
   *
   * Specifically deals with: &, <, >, ", and '.
   *
   * $quote_style can be set to ENT_COMPAT to encode " to
   * &quot;, or ENT_QUOTES to do both. Default is ENT_NOQUOTES where no quotes are encoded.
   *
   * @since 1.2.2
   * @access private
   *
   * @staticvar string $_charset
   *
   * @param string $string         The text which is to be encoded.
   * @param int    $quote_style    Optional. Converts double quotes if set to ENT_COMPAT, both single and double if set to ENT_QUOTES or none if set to ENT_NOQUOTES. Also compatible with old values; converting single quotes if set to 'single', double if set to 'double' or both if otherwise set. Default is ENT_NOQUOTES.
   * @param string $charset        Optional. The character encoding of the string. Default is false.
   * @param bool   $double_encode  Optional. Whether to encode existing html entities. Default is false.
   * @return string The encoded text with HTML entities.
   */
  function specialchars( $string, $quote_style = ENT_NOQUOTES, $charset = false, $double_encode = false ) {
    $string = (string) $string;

    if ( 0 === strlen( $string ) )
      return '';

    // Don't bother if there are no specialchars - saves some processing
    if ( ! preg_match( '/[&<>"\']/', $string ) )
      return $string;

    // Account for the previous behaviour of the function when the $quote_style is not an accepted value
    if ( empty( $quote_style ) )
      $quote_style = ENT_NOQUOTES;
    elseif ( ! in_array( $quote_style, array( 0, 2, 3, 'single', 'double' ), true ) )
      $quote_style = ENT_QUOTES;

    // Store the site charset as a static to avoid multiple calls to wp_load_alloptions()
    if ( ! $charset ) {
      static $_charset = null;
      if ( ! isset( $_charset ) ) {
        $alloptions = wp_load_alloptions();
        $_charset = isset( $alloptions['blog_charset'] ) ? $alloptions['blog_charset'] : '';
      }
      $charset = $_charset;
    }

    if ( in_array( $charset, array( 'utf8', 'utf-8', 'UTF8' ) ) )
      $charset = 'UTF-8';

    $_quote_style = $quote_style;

    if ( $quote_style === 'double' ) {
      $quote_style = ENT_COMPAT;
      $_quote_style = ENT_COMPAT;
    } elseif ( $quote_style === 'single' ) {
      $quote_style = ENT_NOQUOTES;
    }

    if ( ! $double_encode ) {
      // Guarantee every &entity; is valid, convert &garbage; into &amp;garbage;
      // This is required for PHP < 5.4.0 because ENT_HTML401 flag is unavailable.
      $string = wp_kses_normalize_entities( $string );
    }

    $string = @htmlspecialchars( $string, $quote_style, $charset, $double_encode );

    // Backwards compatibility
    if ( 'single' === $_quote_style )
      $string = str_replace( "'", '&#039;', $string );

    return $string;
  }
}