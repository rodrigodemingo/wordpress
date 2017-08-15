<?php
/**
 * Action Admin_Init for VTCore_Wordpress
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Actions_Admin__Init
extends VTCore_Wordpress_Models_Hook {

  protected $weight = 999;

  /**
   * Encapsulating hook admin_init and delayed
   * to late binding (999) allowing other
   * sub VTCore Plugin to allow to register
   * all hooks action and filter first before
   * this class methods initializes.
   *
   */
  public function hook() {

    // Saving video poster
    // @todo Mimick this to global media upload.
    if (isset($_POST['vtcore-wp-media-video-poster'])
        && is_array($_POST['vtcore-wp-media-video-poster'])) {

      foreach ($_POST['vtcore-wp-media-video-poster'] as $attachment_id => $image) {

        // Check if this is trully an image data for security sake
        $filteredData = base64_decode(str_replace('data:image/png;base64,', '', $image));
        $img = @imagecreatefromstring($filteredData);

        if ($img !== false) {
          $data = wp_get_attachment_metadata($attachment_id);

          if (is_serialized($data)) {
            $data = unserialize($data);
          }

          if (is_array($data)) {
            $data['poster'] = $image;
            wp_update_attachment_metadata($attachment_id, $data);
          }
        }

        imagedestroy($img);
      }
    }

    // Process late upgrade
    // @deprecated remove this in the next release
    if (get_option('vtcore_do_upgrade')) {
      do_action('vtcore_updater', new VTCore_Wordpress_Factory_Updater());
      update_option('vtcore_do_upgrade', false);
    }
  }

}