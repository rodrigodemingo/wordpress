<?php
/**
 * Class Extending the recursive iterator for iterating
 * the HTML Object quickly.
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Html_Iterators 
implements RecursiveIterator {
  
  private $valid = FALSE;
  private $position = 0;
  private $children = array();

  public function __construct($object) {
    $this->children = $object->getChildrens();
    $this->key();
  }

  public function hasChildren() {
    return !empty($this->children);
  }

  public function getChildren() {
    return new VTCore_Html_Iterators($this->children[$this->key()]);
  }

  public function beginChildren() {
    $this->current();
  }

  public function rewind() {
    $this->valid = (FALSE !== reset($this->children));
  }

  public function current() {
    return $this->children[$this->key()];
  }

  public function key() {
    $this->position = key($this->children);
    return $this->position;
  }

  public function next() {
    $this->valid = (FALSE !== next($this->children));
  }

  public function valid() {
    return $this->valid;
  }
}