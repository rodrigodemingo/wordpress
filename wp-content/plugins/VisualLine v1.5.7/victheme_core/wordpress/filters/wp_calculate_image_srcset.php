<?php
/**
 * Class for filtering the woocommerce product variation output
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Filters_WP__Calculate__Image__Srcset
  extends VTCore_Wordpress_Models_Hook {

  protected $argument = 5;

  public function hook($sources = NULL, $size_array = NULL, $image_src = NULL, $image_meta = NULL, $attachment_id = NULL) {

    ksort($sources);

    /**
    if (is_array($size_array)) {
      $width = $size_array[0];
    }

    foreach ($sources as $size => $data) {

      $is_retina = strpos($data['url'], '@2x') !== false;
      if ($size > $width && !$is_retina) {
        //unset($sources[$size]);
      }
    }
    **/

    return $sources;
  }
}