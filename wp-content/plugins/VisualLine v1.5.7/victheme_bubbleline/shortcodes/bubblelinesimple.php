<?php
/**
 * Class extending the Shortcodes base class
 * for building simple bubble line. This is created
 * for a very simple bubble line object for advanced
 * usage please us the normal bubbleline shortcode instead.
 *
 * how to use :
 *
 * [bubblelinesimple
 *   class="some class"
 *   id="someid"
 *   contentargs="url decoded arrays of content"
 * ]
 *
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_BubbleLine_Shortcodes_BubbleLineSimple
extends VTCore_Wordpress_Models_Shortcodes
implements VTCore_Wordpress_Interfaces_Shortcodes {

  protected $processDottedNotation = true;

  /**
   * Extending parent method.
   * @see VTCore_Wordpress_Models_Shortcodes::processCustomRules()
   */
  protected function processCustomRules() {
    if ($this->get('contentargs')) {
      $this->add('contents', json_decode(urldecode($this->get('contentargs')), true));
    }
  }


  public function buildObject() {
    $this->object = new VTCore_BubbleLine_Element_BubbleLine($this->atts);

    if ($this->get('contents')) {
      $markup = '';
      foreach ($this->get('contents') as $delta => $content) {
        $data = new VTCore_Wordpress_Objects_Array($content);
        $shortcode = new VTCore_BubbleLine_Shortcodes_BubbleLineItem($data->extract(), $data->get('content'), 'bubblelineitem');
        $shortcode->buildObject();
        $markup .= $shortcode->getMarkup();

        unset($data);
        $data = NULL;

        unset($shortcode);
        $shortcode = NULL;
      }

      if (!empty($markup)) {
        $this->object->addChildren($markup);
      }
    }
  }
}


