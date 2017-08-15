<?php
/**
 * Class extending the VTCore_Utility for
 * adding singleton specific for Wordpress
 * Usage only.
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Utility
extends VTCore_Utility {




  /**
   * Helper function for locating the right template from a path,
   * this will support checking if active theme has overriden the template
   */
  public static function locateTemplate($path) {
    return VTCore_Wordpress_Init::getFactory('template')->locate($path);
  }




  /**
   * Quick function for building the bootstrap
   * grid class. this is useful for usage inside a template
   */
  public static function getBootstrapGrid($context) {
    $object = new VTCore_Bootstrap_Grid_Column($context);
    return $object->getClass();
  }




  /**
   * Deregister assets
   */
  public static function deregisterAsset($name, $css = true, $js = true) {
    VTCore_Wordpress_Init::getFactory('assets')->dequeue($name, $js = true, $css = true);
  }



  /**
   * Shortcut for retrieving assets library data quickly and easily.
   */
  public static function getAssetData($name, $type) {
    return VTCore_Wordpress_Init::getFactory('assets')->get('library')->get($name . '.' . $type);
  }





  /**
   * Load single asset
   * @see VTCore_Assets()
   */
  public static function loadFrontAsset($name, $deps = array('jquery'), $footer = true, $queue = true) {
    VTCore_Wordpress_Init::getFactory('assets')->get('queues')->add($name, array(
      'deps' => $deps,
      'footer' => $footer,
    ));
  }




  /**
   * Load single asset for admin
   * @see VTCore_Assets()
   */
  public static function loadAdminAsset($name, $deps = array('jquery'), $footer = true, $queue = true) {
    VTCore_Wordpress_Init::getFactory('assets')->get('queues')->add($name, array(
      'deps' => $deps,
      'footer' => $footer,
    ));
  }



  /**
   * Direct enqueues asset files, this must be done
   * after hook init
   */
  public static function loadAsset($name, $deps = array('jquery'), $footer = true, $queue = true) {
    VTCore_Wordpress_Init::getFactory('assets')->get('queues')->add($name, array(
      'deps' => $deps,
      'footer' => $footer,
    ));
  }


  /**
   * Get all metas by its meta key
   */
  public static function getMetadataByKey($type, $key, $default = array()) {
    global $wpdb;

    if (!$type
      || !$key
      || !$table = _get_meta_table($type)) {
      return $default;
    }

    $meta = $wpdb->get_results($wpdb->prepare( "SELECT * FROM $table WHERE meta_key = %s", $key));

    return $meta;
  }



  /**
   *
   * Clone of wp_upload_dir() with exception this method
   * will not use date time but instead array of subfolders
   */
  static function createUploadDir($subfolders = array()) {

    $siteurl = get_option('siteurl');
    $upload_path = trim(get_option('upload_path'));

    if (empty($upload_path) || 'wp-content/uploads' == $upload_path) {
      $dir = WP_CONTENT_DIR . '/uploads';
    }

    elseif (strpos($upload_path, ABSPATH) !== 0) {

      // $dir is absolute, $upload_path is (maybe) relative to ABSPATH
      $dir = path_join(ABSPATH, $upload_path);

    }

    else {
      $dir = $upload_path;
    }

    if (!$url = get_option( 'upload_url_path')) {

      if (empty($upload_path)
        || ('wp-content/uploads' == $upload_path)
        || ($upload_path == $dir)) {

        $url = WP_CONTENT_URL . '/uploads';

      }

      else {
        $url = trailingslashit($siteurl) . $upload_path;
      }
    }

    // Obey the value of UPLOADS. This happens as long as ms-files rewriting is disabled.
    // We also sometimes obey UPLOADS when rewriting is enabled -- see the next block.
    if (defined('UPLOADS')
      && !(is_multisite()
        && get_site_option('ms_files_rewriting'))) {

      $dir = ABSPATH . UPLOADS;
      $url = trailingslashit($siteurl) . UPLOADS;

    }

    // If multisite (and if not the main site in a post-MU network)
    if (is_multisite()
      && !(is_main_network()
        && is_main_site()
        && defined('MULTISITE'))) {

      if (!get_site_option('ms_files_rewriting')) {
        // If ms-files rewriting is disabled (networks created post-3.5), it is fairly straightforward:
        // Append sites/%d if we're not on the main site (for post-MU networks). (The extra directory
        // prevents a four-digit ID from conflicting with a year-based directory for the main site.
        // But if a MU-era network has disabled ms-files rewriting manually, they don't need the extra
        // directory, as they never had wp-content/uploads for the main site.)

        if (defined('MULTISITE')) {

          $ms_dir = '/sites/' . get_current_blog_id();

        }


        else {
          $ms_dir = '/' . get_current_blog_id();

          $dir .= $ms_dir;
          $url .= $ms_dir;
        }

      }

    }

    elseif (defined('UPLOADS') && !ms_is_switched()) {

      // Handle the old-form ms-files.php rewriting if the network still has that enabled.
      // When ms-files rewriting is enabled, then we only listen to UPLOADS when:
      //   1) we are not on the main site in a post-MU network,
      //      as wp-content/uploads is used there, and
      //   2) we are not switched, as ms_upload_constants() hardcodes
      //      these constants to reflect the original blog ID.
      //
      // Rather than UPLOADS, we actually use BLOGUPLOADDIR if it is set, as it is absolute.
      // (And it will be set, see ms_upload_constants().) Otherwise, UPLOADS can be used, as
      // as it is relative to ABSPATH. For the final piece: when UPLOADS is used with ms-files
      // rewriting in multisite, the resulting URL is /files. (#WP22702 for background.)

      if (defined('BLOGUPLOADDIR')) {
        $dir = untrailingslashit(BLOGUPLOADDIR);
      }

      else {
        $dir = ABSPATH . UPLOADS;
        $url = trailingslashit( $siteurl ) . 'files';
      }
    }

    $basedir = $dir;
    $baseurl = $url;

    $subdir = '';
    if (!empty($subfolders)) {
      $subdir = '/' . implode('/', $subfolders);

      $dir .= $subdir;
      $url .= $subdir;
    }

    /**
     * Filter the uploads directory data.
     *
     * @since 2.0.0
     *
     * @param array $uploads Array of upload directory data with keys of 'path',
     *                       'url', 'subdir, 'basedir', and 'error'.
     */
    $uploads = apply_filters('upload_dir',
      array(
        'path'    => $dir,
        'url'     => $url,
        'subdir'  => $subdir,
        'basedir' => $basedir,
        'baseurl' => $baseurl,
        'error'   => false,
      ));

    // Make sure we have an uploads dir
    if (!wp_mkdir_p($uploads['path'])) {

      if (strpos($uploads['basedir'], ABSPATH) === 0) {

        $error_path = str_replace(ABSPATH, '', $uploads['basedir']) . $uploads['subdir'];

      }
      else {

        $error_path = basename($uploads['basedir']) . $uploads['subdir'];

      }

      $message = sprintf( __('Unable to create directory %s. Is its parent directory writable by the server?', 'victheme_core'), $error_path );
      $uploads['error'] = $message;

    }

    return $uploads;

  }





  /**
   * Clone of wp_upload_bits()
   *
   * This method is direct clone of wp_upload_bits but instead of
   * using the wp_upload_dir this method will use the VTCore_Wordpress_Utility::createUploadDir()
   * methods.
   *
   */
  static function uploadBits($name, $bits, $subfolder = array()) {

    if (empty($name)) {
      return array('error' => __('Empty filename', 'victheme_core'));
    }


    $wp_filetype = wp_check_filetype($name);

    if (!$wp_filetype['ext'] && !current_user_can('unfiltered_upload')) {
      return array('error' => __('Invalid file type', 'victheme_core'));
    }

    $upload = VTCore_Wordpress_Utility::createUploadDir($subfolder);

    if ($upload['error'] !== false) {
      return $upload;
    }


    $upload_bits_error = apply_filters('wp_upload_bits', array('name' => $name, 'bits' => $bits, 'time' => $upload['subdir']));

    if (!is_array($upload_bits_error)) {
      $upload[ 'error' ] = $upload_bits_error;
      return $upload;
    }

    $filename = wp_unique_filename($upload['path'], $name);

    $new_file = $upload['path'] . "/$filename";

    if (!wp_mkdir_p(dirname($new_file))) {

      if (strpos( $upload['basedir'], ABSPATH) === 0) {
        $error_path = str_replace(ABSPATH, '', $upload['basedir']) . $upload['subdir'];
      }

      else {
        $error_path = basename($upload['basedir']) . $upload['subdir'];
      }

      $message = sprintf(__( 'Unable to create directory %s. Is its parent directory writable by the server?' , 'victheme_core'), $error_path);

      return array('error' => $message);
    }


    $ifp = @fopen($new_file, 'wb');

    if (!$ifp) {
      return array('error' => sprintf(__('Could not write file %s' , 'victheme_core'), $new_file));
    }

    @fwrite($ifp, $bits);
    fclose($ifp);
    clearstatcache();

    // Set correct file permissions
    $stat = @stat(dirname($new_file));
    $perms = $stat['mode'] & 0007777;
    $perms = $perms & 0000666;
    @chmod($new_file, $perms);
    clearstatcache();

    // Compute the URL
    $url = set_url_scheme($upload['url'] . "/$filename");

    return array('file' => $new_file, 'url' => $url, 'error' => false);
  }



  /**
   * Helper function for checking if we are
   * on certain page
   *
   * @return boolean
   */
  static function checkCurrentPage($pages) {
    return in_array($GLOBALS['pagenow'], $pages);
  }



  /**
   * Clone of wp_parse_args but without the merging
   * of the default values.
   *
   * The main purpose for this method is to parse
   * large query array that will hit the php max_input_vars
   * if using normal wp_parse_args.
   *
   * @param array $args
   * @return array:
   */
  public static function wpParseLargeArgs($args) {

    $raws = explode('&', $args);
    $data = array();

    foreach ($raws as $raw) {

      if (empty($raw)) {
        continue;
      }

      $line = wp_parse_args($raw);
      list($key, $value) = explode('=', $raw);
      $key = urldecode($key);


      // Determine if we should merge disctinctly or not
      // This is for fixing :
      // - post value with same HTML attribute name must not produce array
      // - post value with [] in the attribute name must produce array
      if (strpos($key, '[]') === false) {
        $data = self::arrayMergeRecursiveDistinct($line, $data);
      }
      else {
        $data = array_merge_recursive($line, $data);
      }
    }

    return $data;

  }



  /**
   * Helper function for retrieving the original media attachment
   * src url for Wordpress media attachment.
   *
   * @param unknown $attachment_id
   * @return Ambigous <boolean, string>
   */
  public static function wpGetAttachmentOriginalImageSrc($attachment_id) {

    $output = false;

    if (is_numeric($attachment_id)) {
      // Specifying empty wp_upload_dir will create a new
      // empty folder!
      $uploadDir = VTCore_Wordpress_Utility::getUploadDir(false);
      $metas = wp_get_attachment_metadata($attachment_id);

      if (isset($metas['file']) && !empty($metas['file'])) {
        $output = $uploadDir['baseurl'] . '/' . $metas['file'];
      }
    }

    return $output;
  }


  /**
   * Helper function for retrieving the original media attachment
   * src path for Wordpress media attachment.
   *
   * @param unknown $attachment_id
   * @return Ambigous <boolean, string>
   */
  public static function wpGetAttachmentOriginalImagePath($attachment_id) {

    $output = false;

    if (is_numeric($attachment_id)) {
      $uploadDir = self::createUploadDir();
      $metas = wp_get_attachment_metadata($attachment_id);
      if (isset($metas['file']) && !empty($metas['file'])) {
        $output = $uploadDir['path'] . '/' . $metas['file'];
      }
    }

    return $output;
  }


  /**
   * Create retina-ready images
   */
  public static function wpCreateRetinaImage($file, $width, $height, $crop = false) {

    $namesizing = '@2x';
    if ($width && $height) {
      $namesizing = $width . 'x' . $height . '@2x';
    }

    if (!$width || !$height) {
      $size = @getimagesize($file);
    }

    if (isset($size) && !empty($size)) {
      if (!$width) {
        $width = $size[0];
      }

      if (!$height) {
        $height = $size[1];
      }
    }

    if (isset($width) && !empty($width) && isset($height) && !empty($height)) {
      $resized_file = wp_get_image_editor($file);

      if (!is_wp_error($resized_file)) {

        $filename = str_replace('-@2x', '@2x', $resized_file->generate_filename($namesizing));

        //if (!@file_exists($filename)) {
          $resized_file->resize($width * 2, $height * 2, $crop);
          $resized_file->save($filename);

          $info = $resized_file->get_size();

          return array(
            'file' => wp_basename($filename),
            'width' => $info['width'],
            'height' => $info['height'],
          );
        //}
      }
    }

    return false;
  }


  /**
   * Static function for resizing image
   * @param $file
   * @param $width
   * @param $height
   * @param $crop
   * @param $name
   * @return array
   */
  public static function wpResizeImage($file, $width, $height, $crop, $name) {

    $object = wp_get_image_editor( $file );
    $result = false;

    if (!is_wp_error($object)) {
      $filename = $object->generate_filename($name);
      $uploadDir = self::createUploadDir();

      $result =  array(
        'path' => $filename,
        'url' => $uploadDir['url'] . '/' . implode('/', array_slice(explode('/', $filename), -3,3)),
        'file' => wp_basename( $filename ),
        'width' => $width,
        'height' => $height,
        'created' => false,
      );

      // Only recreate if file doesn't exists
      if (!@is_file($filename)) {
        $object->resize($width, $height, $crop);
        $object->save( $filename );
        $result['created'] = true;
      }
    }

    return $result;
  }


  /**
   * Clone of wp_upload_dir function but without
   * the nasty create folder everytime its called
   * behavior
   *
   * @return mixed|void
   */
  public static function getUploadDir($time = false) {
    $siteurl = get_option( 'siteurl' );
    $upload_path = trim( get_option( 'upload_path' ) );

    if ( empty( $upload_path ) || 'wp-content/uploads' == $upload_path ) {
      $dir = WP_CONTENT_DIR . '/uploads';
    } elseif ( 0 !== strpos( $upload_path, ABSPATH ) ) {
      // $dir is absolute, $upload_path is (maybe) relative to ABSPATH
      $dir = path_join( ABSPATH, $upload_path );
    } else {
      $dir = $upload_path;
    }

    if ( !$url = get_option( 'upload_url_path' ) ) {
      if ( empty($upload_path) || ( 'wp-content/uploads' == $upload_path ) || ( $upload_path == $dir ) )
        $url = WP_CONTENT_URL . '/uploads';
      else
        $url = trailingslashit( $siteurl ) . $upload_path;
    }

    /*
     * Honor the value of UPLOADS. This happens as long as ms-files rewriting is disabled.
     * We also sometimes obey UPLOADS when rewriting is enabled -- see the next block.
     */
    if ( defined( 'UPLOADS' ) && ! ( is_multisite() && get_site_option( 'ms_files_rewriting' ) ) ) {
      $dir = ABSPATH . UPLOADS;
      $url = trailingslashit( $siteurl ) . UPLOADS;
    }

    // If multisite (and if not the main site in a post-MU network)
    if ( is_multisite() && ! ( is_main_network() && is_main_site() && defined( 'MULTISITE' ) ) ) {

      if ( ! get_site_option( 'ms_files_rewriting' ) ) {
        /*
         * If ms-files rewriting is disabled (networks created post-3.5), it is fairly
         * straightforward: Append sites/%d if we're not on the main site (for post-MU
         * networks). (The extra directory prevents a four-digit ID from conflicting with
         * a year-based directory for the main site. But if a MU-era network has disabled
         * ms-files rewriting manually, they don't need the extra directory, as they never
         * had wp-content/uploads for the main site.)
         */

        if ( defined( 'MULTISITE' ) )
          $ms_dir = '/sites/' . get_current_blog_id();
        else
          $ms_dir = '/' . get_current_blog_id();

        $dir .= $ms_dir;
        $url .= $ms_dir;

      } elseif ( defined( 'UPLOADS' ) && ! ms_is_switched() ) {
        /*
         * Handle the old-form ms-files.php rewriting if the network still has that enabled.
         * When ms-files rewriting is enabled, then we only listen to UPLOADS when:
         * 1) We are not on the main site in a post-MU network, as wp-content/uploads is used
         *    there, and
         * 2) We are not switched, as ms_upload_constants() hardcodes these constants to reflect
         *    the original blog ID.
         *
         * Rather than UPLOADS, we actually use BLOGUPLOADDIR if it is set, as it is absolute.
         * (And it will be set, see ms_upload_constants().) Otherwise, UPLOADS can be used, as
         * as it is relative to ABSPATH. For the final piece: when UPLOADS is used with ms-files
         * rewriting in multisite, the resulting URL is /files. (#WP22702 for background.)
         */

        if ( defined( 'BLOGUPLOADDIR' ) )
          $dir = untrailingslashit( BLOGUPLOADDIR );
        else
          $dir = ABSPATH . UPLOADS;
        $url = trailingslashit( $siteurl ) . 'files';
      }
    }

    $basedir = $dir;
    $baseurl = $url;

    $subdir = '';
    if ( get_option( 'uploads_use_yearmonth_folders' ) ) {
      // Generate the yearly and monthly dirs
      if ( !$time )
        $time = current_time( 'mysql' );
      $y = substr( $time, 0, 4 );
      $m = substr( $time, 5, 2 );
      $subdir = "/$y/$m";
    }

    $dir .= $subdir;
    $url .= $subdir;

    /**
     * Filter the uploads directory data.
     *
     * @since 2.0.0
     *
     * @param array $uploads Array of upload directory data with keys of 'path',
     *                       'url', 'subdir, 'basedir', and 'error'.
     */
    $uploads = apply_filters( 'upload_dir',
      array(
        'path'    => $dir,
        'url'     => $url,
        'subdir'  => $subdir,
        'basedir' => $basedir,
        'baseurl' => $baseurl,
        'error'   => false,
      ) );

    return $uploads;
  }



  /**
   * Debugging tools, start debug
   * Call this at each point of interest, passing a descriptive string
   *
   * @param $str
   */
  static public function prof_flag($str) {
    global $prof_timing, $prof_names;
    $prof_timing[] = microtime(true);
    $prof_names[] = $str;
  }

  /**
   * Debugging tools, end debug
   * Call this when you're done and want to see the results
   *
   */
  static public function prof_print() {
    global $prof_timing, $prof_names;
    $size = count($prof_timing);
    for($i=0;$i<$size - 1; $i++)
    {
      echo "<b>{$prof_names[$i]}</b><br>";
      echo sprintf("&nbsp;&nbsp;&nbsp;%f<br>", $prof_timing[$i+1]-$prof_timing[$i]);
    }
    echo "<b>{$prof_names[$size-1]}</b><br>";
  }


  /**
   * Get the lowest value of a certain metakey
   * @param $metakey
   * @param $tablekey
   * @return null|string
   */
  static public function getMetaLowestValue($metakey, $tablekey) {

    global $wpdb;
    $table = $wpdb->$tablekey;
    $result = NULL;

    if (!empty($table) && !empty($metakey)) {
      $result = $wpdb->get_var($wpdb->prepare("SELECT MIN( meta_value+0 ) as minprice FROM $table WHERE meta_key = %s", $metakey));
    }

    return $result;
  }


  /**
   * Get the highest value of a certain metakey
   * @param $metakey
   * @param $tablekey
   * @return null|string
   */
  static public function getMetaHighestValue($metakey, $tablekey) {

    global $wpdb;
    $table = $wpdb->$tablekey;
    $result = NULL;

    if (!empty($table) && !empty($metakey)) {
      $result = $wpdb->get_var($wpdb->prepare("SELECT MAX( meta_value+0 ) as minprice FROM $table WHERE meta_key = %s", $metakey));
    }

    return $result;
  }

  /**
   * Convert media to base64
   * @param $image
   * @param string $mime
   * @return string
   */
  static function getDataURI($image, $mime = '') {
    if (is_numeric($image)) {
      $mime = get_post_mime_type($image);
      $image = wp_get_attachment_url($image);
    }

    if (empty($mime) && function_exists('image_type_to_mime_type') && function_exists('exif_imagetype')) {
      $mime = image_type_to_mime_type(exif_imagetype($image));
    }

    if (empty($mime) && function_exists('mime_content_type')) {
      $mime = mime_content_type($image);
    }

    return 'data:'. $mime .';base64,'.base64_encode(file_get_contents($image));
  }
}