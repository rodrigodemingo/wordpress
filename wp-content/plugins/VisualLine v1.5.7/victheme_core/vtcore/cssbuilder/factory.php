<?php
/**
 * Main Factory class for building a single
 * target CSS rules.
 *
 * @author jason.xie@victheme.com
 * @experimental
 * @cleanup
 */
class VTCore_CSSBuilder_Factory {

  private $target = array();
  private $rules = array();
  private $minify = false;
  private $keyframe = false;
  private $overloaderPrefix = array('VTCore_CSSBuilder_Rules_');

  public function __construct($target = array()) {
    if (!empty($target)) {
      $this->setTarget($target);
    }
  }

  public function __call($method, $context) {

    foreach ($this->overloaderPrefix as $prefix) {
      $class = $prefix . $method;
      if (class_exists($class, true)) {
        $name = $class;
        break;
      }
    }

    if (!empty($name)) {
      $object = new $name(array_shift($context));
    }

    if (isset($object) && is_object($object)) {
      $this->addRule($object);
      unset($object);
      $object = null;
    }
    else {
      throw new Exception('Error Class VTCore_CSSBuilder_Rules_' . $method . ' does\'t exists');
    }

    return $this;
  }

  public function addRule($object) {
    $this->rules[$object->getType()] = $object;
    return $this;
  }

  public function removeRule($type) {
    unset($this->rules[$type]);
    return $this;
  }

  public function getRules() {
    return $this->rules;
  }

  public function getRule($type) {
    return $this->rules[$type];
  }

  public function addTarget($target) {
    $this->target[] = $target;
  }

  public function getTarget() {
    return $this->target;
  }

  public function setTarget($target) {
    $this->target = $target;
  }

  public function removeTarget($target) {
    VTCore_Utility::removeArrayValueByKey($this->target, $target);
  }



  public function setMinify($minify) {
    $this->minify = $minify;
    return $this;
  }



  private function buildCSS() {

    $css = false;
    $rules = '';
    foreach ($this->rules as $object) {
      $rules .= (string) $object;
    }

    if (!empty($rules)) {
      $css = implode(", \n", (array) $this->target) . " {\n$rules}\n";
    }

    if ($this->keyframe) {
      $css .= $this->keyframe->__toString();
    }

    // @todo smartly remove white space
    if ($this->minify) {
      $css = str_replace("\n", '', $this->minimizeCSS($css));
    }

    return $css;
  }


  public function buildInlineStyle() {
    $rules = '';
    foreach ($this->rules as $object) {
      $rules .= (string) $object;
    }

    return $rules;
  }


  /**
   * Minify CSS
   * @experimental - maybe can be problematic with threadstack size?
   */
  public function minimizeCSS($input) {

    // Remove comments
    $output = preg_replace('#/\*.*?\*/#s', '', $input);

    // Remove whitespace
    $output = preg_replace('/\s*([{}|:;,])\s+/', '$1', $output);

    // Remove trailing whitespace at the start
    $output = preg_replace('/\s\s+(.*)/', '$1', $output);

    // Remove unnecesairy ;'s
    $output = str_replace(';}', '}', $output);

    return $output;
  }




	public function render() {
		echo $this->buildCSS();
	}



	public function __toString() {
		return $this->buildCSS();
	}


	/**
	 * Shortcut function for building a complete css
	 * from a single styles array.
	 *
	 * $styles array must contain selectors key & rules key
	 * and inside the rules key must contain arrays of
	 * valid CSSBuilder sub class name as the key with
	 * valid context for the sub class.
	 */
	public function buildStyles($styles) {
      if (isset($styles['selectors'])) {
        $this->setTarget($styles['selectors']);
        foreach ($styles['rules'] as $key => $context) {

          if ($key == 'keyframe') {
            $this->keyframe = new VTCore_CSSBuilder_Keyframe($context['name']);
            foreach ($context['frame'] as $frame => $rules) {
              $this->keyframe->addFrame($frame);

              foreach ($rules as $name => $rule) {
                $this->keyframe->$name($rule);
              }
            }
          }

          $name = ucfirst($key);
          $this->$name($context);
        }
      }

	  return $this;
	}
}