<?php
/**
 * Class for hooking into wp_generate_attachment_metadata
 * for creating additional image for retina ready.
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Filters_Wp__Generate__Attachment__Metadata
extends VTCore_Wordpress_Models_Hook {

  protected $argument = 2;
  protected $weight = 10;
  private $metadata;

  public function hook($metadata = NULL, $attachment_id = NULL) {

    $this->metadata = $metadata;

    // Create retina for the original image
    // VTCore_Wordpress_Utility::wpCreateRetinaImage(get_attached_file($attachment_id), false, false, false);

    // Direct scan the directory and create retina image
    // This is the only way to make sure all of the image
    // eventhough it is not registered to meta get
    // the proper @2x clone.
    $path = pathinfo(get_attached_file($attachment_id));

    if (is_dir($path['dirname'])) {
      $this->createRetinas($path, $attachment_id, $metadata['width'], $metadata['height']);
    }

    return $this->metadata;
  }




  /**
   * find files matching a pattern
   * using PHP "glob" function and recursion
   *
   * @return array containing all pattern-matched files
   *
   * @param string $dir     - directory to start with
   * @param string $pattern - pattern to glob for
   */
  public function createRetinas($path, $attachment_id){

    $handle = opendir($path['dirname']);

    while (false !== ($entry = readdir($handle))) {
      if (preg_match('|' . $path['filename'] . '-[0-9]{1,4}x[0-9]{1,4}\.' . $path['extension'] . '|', $entry)) {

        list($width, $height) = explode('x', str_replace(array($path['filename'], $path['extension'], '-', '.'), '', $entry));

        // Never build image larger than original
        if ($width * 2 > $this->metadata['width'] || $height * 2  > $this->metadata['height']) {
          continue;
        }

        $result = VTCore_Wordpress_Utility::wpCreateRetinaImage($path['dirname'] . DIRECTORY_SEPARATOR . $path['basename'], $width, $height, false);
        if ($result) {
          $result['retina'] = true;
          $this->metadata['sizes']['retina-' . $width . 'x' . $height] = $result;
        }
      }
    }

    closedir($handle);

    return $this;
  }
}