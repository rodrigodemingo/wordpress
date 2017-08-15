<?php
/**
 * Class for managing asset queues
 *
 * This class cannot save to database nor
 * load data from database.
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Objects_Queue
extends VTCore_Wordpress_Models_Dot {

  protected $options = array();
  protected $processed = array();

  /**
   * Mark queue as processed
   * @return VTCore_Wordpress_Objects_Queue
   */
  public function processed($queue) {
    if ($this->get($queue)) {
      $this->processed[$queue] = $this->get($queue);
      $this->remove($queue);
    }

    return $this;
  }


  /**
   * Check if queue is processed
   */
  public function check($queue) {
    return isset($this->processed[$queue]);
  }



  /**
   * Get all processed queues
   */
  public function getProcessed() {
    return $this->processed;
  }


  /**
   * Allow user to force remove processed queue
   */
  public function removeProcessed($queue) {
    if (isset($this->processed[$queue])) {
      unset($this->processed[$queue]);
    }
    return $this;
  }


  /**
   * Overridden method
   * Don't allow user to requeue processed asset
   *
   * @return VTCore_Wordpress_Objects_Queue
   */
  public function add($keys, $value) {
    if (!$this->check($keys)) {
      parent::add($keys, $value);
    }

    return $this;
  }
}