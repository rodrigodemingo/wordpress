<?php
/**
 * Class extending the Shortcodes base class
 * for building the timeend element
 *
 * how to use :

 * [timeend
 *   direction="left|right|top|bottom|center"
 * ]Some text to represent end text[/timeend]
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Timeline_Shortcodes_TimeEnd
extends VTCore_Wordpress_Models_Shortcodes
implements VTCore_Wordpress_Interfaces_Shortcodes {
  
  public function buildObject() {

    // Convert the bootstrap classes into vc compatible one
    $this->convertVCGrid = !get_theme_support('bootstrap');

    // Manually build the wrapper
    $this->object = new VTCore_Html_Element(array(
      'type' => 'li',
      'attributes' => array(
        'class' => array(
          'timeline-items',
        ),
      ),
      'data' => array(
        'timeline' => 'items',
      ),
    ));

    $object = new VTCore_Timeline_Element_End($this->atts);
    $this->object
      ->addChildren($object)
      ->lastChild()
      ->addChildren(do_shortcode($this->content));


    if ($object->getContext('direction')) {
      $this->object->addData('direction', $object->getContext('direction'));
    }

    if ($object->getContext('classtype')) {
      $this->object->addData('type', $object->getContext('classtype'));
    }

    // Free Memory
    unset($object);
    $object = NULL;
  }
}