<?php
/**
 * Singleton Class for processing POST data
 * and flatten the array into an array keyed
 * with form input name.
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Form_Post {

  private $post = array();
  private static $processedPost = array();
  private $iteratorPost = '';

  public function __construct() {
    $this->setPost($_POST);
    $this->setIterator();

    // @optimize Set this to run once no matter what
    if (empty(self::$processedPost)) {
      $this->processPost();
    }
  }

  public function getPost() {
    return $this->post;
  }

  public function setPost($post) {
    $this->post = $post;
  }

  public function setIterator() {
    $this->iteratorPost = new RecursiveIteratorIterator(
                          new RecursiveArrayIterator($this->getPost()),
                          RecursiveIteratorIterator::SELF_FIRST);
  }

  public function processPost() {

    $name = '';
    foreach ($this->iteratorPost as $key => $value) {
      // Get the first parent key
      $name = stripslashes($this->iteratorPost->getSubIterator(0)->key());
      $depth = $this->iteratorPost->getDepth();

      // Only get the keys between depth 1 and last depth before this position
      // @note Somehow the key got reversed? for ($i = $depth - 1' $i > 0; $i--)
      //       Need indepth testing!
      for ($i = 1; $i < $depth; $i++) {
        $name .= '[' . $this->iteratorPost->getSubIterator($i)->key() . ']';
      }

      if (!is_array($value)) {

        $value = stripslashes($value);

        if ($depth != 0) {
          if (!is_numeric($key)) {
            self::$processedPost[$name . '[' . $key . ']'] = $value;
          }
          else {
            self::$processedPost[$name . '[]'][] = $value;
          }
        }
        else {
          self::$processedPost[$name] = $value;
        }
      }
    }

  }

  public function getProcessedPost() {
    return self::$processedPost;
  }

  public function findProcessedPost($name) {
    if (isset(self::$processedPost[$name])) {
      return self::$processedPost[$name];
    }

    return NULL;
  }
}