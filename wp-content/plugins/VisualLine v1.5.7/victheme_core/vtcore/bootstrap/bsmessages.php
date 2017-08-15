<?php
/**
 * Class for extending the WP_Error class
 * for global use with VTCore Classes
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Bootstrap_BsMessages
extends VTCore_Wordpress_Factory_Messages {

  public function render() {
    $message = new VTCore_Bootstrap_Element_Base();

    if ($this->getError()) {
      foreach ($this->getError() as $text) {
        $message
          ->BsAlert(array(
            'text' => $text,
            'alert-type' => 'danger',
          ));
      }
    }

    if ($this->getMessage()) {
      foreach ($this->getMessage() as $text) {
        $message
          ->BsAlert(array(
            'text' => $text,
            'alert-type' => 'info',
          ));
      }
    }

    if ($this->getNotice()) {
      foreach ($this->getNotice() as $text) {
        $message
          ->BsAlert(array(
            'text' => $text,
            'alert-type' => 'success',
          ));
      }
    }

    return $message;
  }
}