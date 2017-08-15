<?php
/**
 * Action Init for VTCore_Wordpress
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Actions_Widgets__Init
extends VTCore_Wordpress_Models_Hook {

  private $widgets = array(
    'social',
    'contact',
  );

  /**
   * Booting VTCore Wordpress default widgets
   */
  public function hook() {
    // Booting widgets
    foreach ($this->widgets as $key => $name) {
      $widget = 'VTCore_Wordpress_Widgets_' . ucfirst($name);

      if (class_exists($widget, true)) {
        $object = new $widget();
        $object->registerWidget();
      }
    }
  }

}