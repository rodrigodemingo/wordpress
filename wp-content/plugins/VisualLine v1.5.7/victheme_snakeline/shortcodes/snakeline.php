<?php
/**
 * Class extending the Shortcodes base class
 * for building the snakeline element
 *
 * how to use :
 *
    [snakeline
    class="some class"
    id="someid"
    line___color=""
    line___width=""
    line___type=""
    ]

      [snakelineitem
      id="x"
      class="class_one class_two"
      date___text="2016"
      date___color=""
      content___text="the context text"
      content___color=""
      dot___link=""
      dot___color=""
      dot___background=""
      dot___text=""
      ]

      some content for the inner shortcodes allowed

      [/snakelineitem]

    [/snakeline]

 *
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_SnakeLine_Shortcodes_SnakeLine
extends VTCore_Wordpress_Models_Shortcodes
implements VTCore_Wordpress_Interfaces_Shortcodes {

  protected $processDottedNotation = true;

  public function buildObject() {
    $this->object = new VTCore_SnakeLine_Element_SnakeLine($this->atts);
    $this->object->addChildren(do_shortcode($this->content));
  }
}