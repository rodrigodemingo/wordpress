<?php
/**
 * This is a class for forcing WP to build
 * the retina image when Visual Composer
 * wpb_getimagebysize() function is invoked
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Filters_Vc__Wpb__GetImageSize
extends VTCore_Wordpress_Models_Hook {

  protected $argument = 3;

  public function hook($data = NULL, $attachment_id = NULL, $params = NULL) {

    // Create retina for the original image
    VTCore_Wordpress_Utility::wpCreateRetinaImage(get_attached_file($attachment_id), false, false, false);

    return $data;
  }
}