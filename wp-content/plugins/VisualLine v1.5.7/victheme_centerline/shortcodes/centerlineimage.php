<?php
/**
 * Class extending the Shortcodes base class
 * for building the centerline image element
 *
 * how to use :
 *
 * [centerlineimage
 *   class="some class"
 *   id="someid"
 *   image_attachmentid="the wp attachment id to serve as the center image"
 *   image_size="the size for center image"
 *   image_position="the position of the image"
 *   image_style="the style for the image"
 *   border_color="the border color for the image"
 *   grids___columns___mobile="X"
 *   grids___columns___tablet="X"
 *   grids___columns___small="X"
 *   grids___columns___large="X"
 *   grids___offset___mobile="X"
 *   grids___offset___tablet="X"
 *   grids___offset___small="X"
 *   grids___offset___large="X"
 *   grids___push___mobile="X"
 *   grids___push___tablet="X"
 *   grids___push___small="X"
 *   grids___push___large="X"
 *   grids___pull___mobile="X"
 *   grids___pull___tablet="X"
 *   grids___pull___small="X"
 *   grids___pull___large="X"
 * ]
 *
 * [/centerlineimage]
 *
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_CenterLine_Shortcodes_CenterLineImage
extends VTCore_Wordpress_Models_Shortcodes
implements VTCore_Wordpress_Interfaces_Shortcodes {

  protected $processDottedNotation = true;

  /**
   * Extending parent method.
   * @see VTCore_Wordpress_Models_Shortcodes::processCustomRules()
   */
  protected function processCustomRules() {

    // Convert the bootstrap classes into vc compatible one
    $this->convertVCGrid = !get_theme_support('bootstrap');

    foreach ($this->atts as $key => $value) {

      // Processing image
      if ($key == 'image_attachmentid') {
        $this->atts['image_element']['attachment_id'] = $value;
        unset($this->atts[$key]);
        continue;
      }

      if ($key == 'image_size') {
        if (empty($value)) {
          $value = 'thumbnail';
        }
        $this->atts['image_element']['size'] = $value;
        unset($this->atts[$key]);
        continue;
      }

      if ($key == 'image_position') {
        $value = 'text-' . $value;
        $this->atts['attributes']['class'][] = $value;
        unset($this->atts[$key]);
        continue;
      }
    }
  }

  public function buildObject() {
    $this->object = new VTCore_CenterLine_Element_ClImage($this->atts);
    $this->object->addChildren(do_shortcode($this->content));
  }
}