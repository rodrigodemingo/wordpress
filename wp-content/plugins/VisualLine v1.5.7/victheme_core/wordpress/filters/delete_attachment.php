<?php
/**
 * Class for hooking into delete_attachment
 * for removing the retina ready image
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Filters_Delete__Attachment
extends VTCore_Wordpress_Models_Hook {

  protected $weight = 10;

  public function hook($attachment_id = NULL) {

    $meta = wp_get_attachment_metadata($attachment_id);

    if (is_array($meta) && isset($meta['file'])) {

      $upload_dir = VTCore_Wordpress_Utility::getUploadDir(false);
      $path = pathinfo($meta['file']);

      foreach ($meta as $key => $value) {

        if ('sizes' !== $key) {
          continue;
        }

        foreach ($value as $sizes => $size) {

          $original_filename = $upload_dir['basedir'] . '/' . $path['dirname'] . '/' . $size['file'];
          $retina_filename = substr_replace($original_filename, '@2x.', strrpos( $original_filename, '.' ), strlen( '.' ));

          if (file_exists($retina_filename)) {
            @unlink($retina_filename);
          }
        }
      }

    }

    return $attachment_id;

  }
}