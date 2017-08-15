<?php
/**
 * Class extending the Shortcodes base class
 * for building the bubbleline element
 *
 * how to use :
 *
 * [bubbleline
 *   class="some class"
 *   id="someid"
 * ]
 *
 * [bubblelineitem
 *   id="x"
 *   class="class_one class_two"
 *   bubble___date="2016"
 *   bubble___text="the context text"
 *   bubble___color=""
 *   bubble___size="small"
 *   bubble___style="point"
 *   dot___radius=''
 *   dot___color=''
 *   dot___border_color=''
 *   dot___border_size=''
 *   line___color=''
 *   line___width=''
 *   line___type=''
 * ]
 *
 *   some content for the inner shortcodes allowed
 *
 * [/bubblelineitem]
 *
 * [/bubbleline]
 *
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_BubbleLine_Shortcodes_BubbleLine
extends VTCore_Wordpress_Models_Shortcodes
implements VTCore_Wordpress_Interfaces_Shortcodes {

  protected $processDottedNotation = true;

  public function buildObject() {
    $this->object = new VTCore_BubbleLine_Element_BubbleLine($this->atts);
    $this->object->addChildren(do_shortcode($this->content));
  }
}