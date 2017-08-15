<?php
/**
 * Keyframe factory for building keyframe rules
 * 
 * @author jason.xie@victheme.com
 *
 */
class VTCore_CSSBuilder_Keyframe {
  
  private $target = array();
  private $frames = array();
  private $currentFrame;
  
  private $minify = false;
  private $overloaderPrefix = array('VTCore_CSSBuilder_Rules_');
  private $prefix = array('@keyframes', '@-webkit-keyframes');
  
  public function __construct($target) {
    $this->target = $target;
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
      $this->getCurrentFrame()->addRule($object);
    }
    else {
      throw new Exception('Error Class VTCore_CSSBuilder_Rules_' . $method . ' does\'t exists');
    }
  
    return $this;
  }
  
  public function addFrame($timeline) {
    $this->currentFrame = $this->frames[$timeline] = new VTCore_CSSBuilder_Factory(array($timeline . '%'));
    return $this;
  }
  
  public function getCurrentFrame() {
    return $this->currentFrame;
  }
  
  private function buildCSS() {
    
    $css = false;
    
    foreach ($this->prefix as $prefix) {
      
      $rules = array();
      
      foreach ($this->frames as $object) {
        $rules[] = '  ' . str_replace("\n", "\n  ", (string) $object);
      }
      
      if (!empty($rules)) {
        $css .= "\n$prefix $this->target {\n" . implode("  \n", $rules) . "\n}\n";
      }
      
    }
    
    if ($this->minify) {
      $css = str_replace("\n", '', str_replace(' ', '',$css));
    }
    
    return $css;
  }
  

	public function render() {
		echo $this->buildCSS();
	}

	public function __toString() {
		return $this->buildCSS();
	}
  
}