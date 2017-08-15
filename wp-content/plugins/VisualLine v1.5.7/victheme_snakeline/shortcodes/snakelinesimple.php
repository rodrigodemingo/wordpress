<?php
/**
 * Class extending the Shortcodes base class
 * for building simple snake line. This is created
 * for a very simple snake line object for advanced
 * usage please us the normal snakeline shortcode instead.
 *
 * how to use :
 *
 * [snakelinesimple
 *   class="some class"
 *   id="someid"
 *   contentargs="url decoded arrays of content"
 * ]
 *
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_SnakeLine_Shortcodes_SnakeLineSimple
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
    
    $this->object = new VTCore_SnakeLine_Element_SnakeLine($this->atts);

    if ($this->get('contents')) {

      foreach ($this->get('contents') as $delta => $content) {
        $markup = '';
        $data = new VTCore_Wordpress_Objects_Array($content);
        $shortcode = new VTCore_SnakeLine_Shortcodes_SnakeLineItem($data->extract(), $data->get('content'), 'snakelineitem');
        $shortcode->buildObject();
        $markup .= $shortcode->getMarkup();

        unset($data);
        $data = NULL;

        unset($shortcode);
        $shortcode = NULL;

        if (!empty($markup)) {
          $this->object->addChildren($markup);
        }
      }
    }
  }
}


