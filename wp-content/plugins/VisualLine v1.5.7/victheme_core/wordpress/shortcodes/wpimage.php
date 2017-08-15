<?php
/**
 * Class extending the Shortcodes base class
 * for building the WordPress Image element
 *
 * how to use :
 *
 * [wpimage
 *   class="someclass"
 *   image="image attachment id or image url"
 *   size="WP thumbnail size name"]
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Shortcodes_WpImage
extends VTCore_Wordpress_Models_Shortcodes
implements VTCore_Wordpress_Interfaces_Shortcodes {


  /**
   * Extending parent method.
   * @see VTCore_Wordpress_Models_Shortcodes::processCustomRules()
   */
  protected function processCustomRules() {

    if (isset($this->atts['image'])) {

      if (is_numeric($this->atts['image'])) {
        $size = 'thumbnail';
        if (isset($this->atts['size'])) {
          $size = $this->atts['size'];
        }
        $image = wp_get_attachment_image_src($this->atts['image'], $size);

        $this->atts['attributes'] += $image;
      }

      else {

        list($width, $height, $type, $attr) = @getimagesize($this->atts['image']);

        $this->atts['attributes'] = array(
          'src' => $this->atts['image'],
          'width' => $width,
          'height' => $height,
        );
      }

    }

  }



  public function buildObject() {

    $this->object = new VTCore_Html_Image($this->atts);

  }
}