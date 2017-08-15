<?php
/**
 * Class extending the Shortcodes base class
 * for building the timeevents element
 *
 * how to use :

 * [timeevents
 *   datetime="YYYY-MM-DDTHH:MM"
 *   day="eg. Monday"
 *   month="eg. January"
 *   year="eg. 2014"
 *   date="eg. 12"
 *   icon="fontawesome icon name"
 *   text="the event title"
 *   direction="left|right"
 * ]
 * Some content representing the event content
 * [/timeevents]
 *
 * This shortcode must be inside the timeline shortcode
 * otherwise it will produce invalid HTML markup
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Timeline_Shortcodes_TimeEvents
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


    $object = new VTCore_Timeline_Element_Event($this->atts);
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

    // Reverse the content
    if ($object->getContext('direction') == 'bottom') {
      $object
        ->setChildren(array_reverse($object->getChildrens(), true));
    }

    // Free Memory
    unset($object);
    $object = NULL;
  }
}