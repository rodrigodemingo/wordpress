<?php
/**
 * Class extending the Shortcodes base class
 * for building the Bootstrap Media Object
 *
 * how to use :
 *
 * [bsmediaobject
 *     type="li or div" use li if this shortcode is wrapped within the bsmedialist
 *     id="some-id"
 *     text="content text heading"
 *     pull="left|right"
 *     img="WP attachment image id or image src url"
 *     class="someclass"]
 *
 * Some contents, other shortcode will be processed automatically
 *
 *
 * [/bsmediaobject]
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Shortcodes_BsMediaObject
extends VTCore_Wordpress_Models_Shortcodes
implements VTCore_Wordpress_Interfaces_Shortcodes {


  /**
   * Extending parent method.
   * @see VTCore_Wordpress_Models_Shortcodes::processCustomRules()
   */
  protected function processCustomRules() {
    $this->atts['contents'] = array(do_shortcode($this->content));

    if (isset($this->atts['img'])) {
      if (is_numeric($this->atts['img'])) {
        $image = array(
          'attachment_id' => $this->atts['img'],
        );
      }
      else {
        $image = array(
          'attributes' => array(
            'src' => $this->atts['img'],
          ),
        );
      }

      $this->atts['img'] = new VTCore_Wordpress_Element_WpImage($image);
    }

  }


  public function buildObject() {

    $this->object = new VTCore_Bootstrap_Element_BsMediaObject($this->atts);

  }
}