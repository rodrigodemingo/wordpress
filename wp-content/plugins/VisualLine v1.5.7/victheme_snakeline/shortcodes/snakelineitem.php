<?php
/**
 * Class extending the Shortcodes base class
 * for building the snakelineitem element
 *
 * how to use :

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
 *
 * This shortcode must be inside the snakeline shortcode
 * otherwise it will produce invalid HTML markup
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_SnakeLine_Shortcodes_SnakeLineItem
extends VTCore_Wordpress_Models_Shortcodes
implements VTCore_Wordpress_Interfaces_Shortcodes {

  protected $defaults = array(
    'date' => array(
      'text' => '',
      'color' => '',
    ),
    'content' => array(
      'text' => '',
      'color' => '',
    ),
    'dot' => array(
      'color' => '#ffffff',
      'background' => '#1E477B',
      'link' => '',
      'text' => '',
    ),
  );

  protected $processDottedNotation = true;

  public function processCustomRules() {

    $this->atts = wp_parse_args($this->atts, $this->defaults);

    if (!empty($this->content)) {
      $this->add('content.text', $this->content);
    }

    $this->add('content.text', do_shortcode($this->get('content.text')));
    $this->add('dot.text', do_shortcode($this->get('dot.text')));
    $this->add('date.text', do_shortcode($this->get('date.text')));

  }

  public function buildObject() {
    $this->object = new VTCore_SnakeLine_Element_SnakeLineItem($this->atts);
  }
}