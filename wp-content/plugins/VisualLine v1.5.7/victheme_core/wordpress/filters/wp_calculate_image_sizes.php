<?php
/**
 * Class for filtering the woocommerce product variation output
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Filters_WP__Calculate__Image__Sizes
  extends VTCore_Wordpress_Models_Hook {

  protected $argument = 5;

  public function hook($sizes = NULL, $size = NULL, $image_src = NULL, $image_meta = NULL, $attachment_id = NULL ) {

    if (is_array($size)) {
      $width = $size[0];
      $responsiveSizes = array(
        '380' => 'max-width',
        '500' => 'max-width',
        '660' => 'max-width',
        '800' => 'max-width',
      );

      $newsize = '';
      foreach ($responsiveSizes as $maybesize => $rule) {
        $newsize .= '(' . $rule . ': ' . $maybesize . 'px) ' . ($maybesize / $width) * 100 . 'vw,';
      }

      $newsize .= $width . 'px';
      $sizes = rtrim($newsize, ',');
    }

    return $sizes;
  }
}