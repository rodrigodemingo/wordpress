<?php
/**
 * Class extending the Shortcodes base class
 * for building the bubblelineinner element
 *
 * how to use :

 * [bubblelineitem
 *   id="x"
 *   class="class_one class_two"
 *   bubble___date="2016"
 *   bubble___text="the context text"
 *   bubble___color=""
 *   bubble___size="small"
 *   bubble___style="point"
 *   bubble___text_color=""
 *   dot___radius=""
 *   dot___color=""
 *   dot___border_color=""
 *   dot___border_size=""
 *   line___color=""
 *   line___width=""
 *   line___type=""
 *   text___color=""
 * ]
 *
 *   some content for the inner shortcodes allowed
 *
 * [/bubblelineitem]
 *
 * This shortcode must be inside the bubbleline shortcode
 * otherwise it will produce invalid HTML markup
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_BubbleLine_Shortcodes_BubbleLineItem
extends VTCore_Wordpress_Models_Shortcodes
implements VTCore_Wordpress_Interfaces_Shortcodes {

  protected $defaults = array(
    'bubble' => array(
      'date' => '',
      'text' => '',
      'color' => '#019ADD',
      'size' => 'normal',
      'style' => 'point',
      'text_color' => '#ffffff',
    ),
    'text' => array(
      'color' => '019ADD',
    ),
    'dot' => array(
      'color' => '',
      'border_color' => '#3EA7C7',
    ),
    'line' => array(
      'color' => '#7B7B7B',
      'width' => '4',
      'type' => 'solid',
    ),
    'link' => '',
  );

  protected $processDottedNotation = true;

  public function processCustomRules() {

    $this->atts = wp_parse_args($this->atts, $this->defaults);

    if (!empty($this->content)) {
      $this->add('bubble.text', $this->content);
    }
    $this->add('bubble.text', do_shortcode($this->get('bubble.text')));
  }

  public function buildObject() {
    $this->object = new VTCore_BubbleLine_Element_BubbleLineItem($this->atts);
  }
}