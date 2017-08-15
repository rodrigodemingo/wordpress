<?php
/**
 * Class for managing VTCore Assets libraries
 * Centralizing the assets record so other plugin
 * can just load the asset by folder name.
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Wordpress_Factory_Assets
  extends VTCore_Wordpress_Models_Config
  implements VTCore_Wordpress_Interfaces_Factory {

  protected $options = array();
  protected $database = 'vtcore_asset_cache';
  protected $filter = FALSE;

  private static $reset = false;

  private $base;
  private $hash;
  private $context;
  private $admin;


  protected function register(array $options) {

    $this->admin = defined('WP_ADMIN');

    // @bugfix post edit screw up when auto clear + wp_debug enabled
    if (!$this->admin) {
      $this->maybeByPassCache();
    }

    $this->options = array(
      'library' => new VTCore_Wordpress_Objects_Library(),
      'queues' => new VTCore_Wordpress_Objects_Queue(),
      'aggregate' => (boolean) VTCore_Wordpress_Init::getFactory('coreConfig')->get('aggregate.frontend'),
      'minify' => false,
      'default' => array(
        'deps' => array('jquery'),
        'version' => '',
        'footer' => true,
      ),
      'prefix' => 'comp-front-',
      'compressed' => array(),
    );

    // Setting up the library object;
    $this
      ->get('library')
      ->allowed(array('js', 'css'))
      ->database('vtcore_asset_library')
      ->load();

    if ($this->admin) {
      $this->mutate('prefix', 'comp-admin-');
      $this->change('aggregate', (boolean) VTCore_Wordpress_Init::getFactory('coreConfig')->get('aggregate.backend'));
    }

    $this->merge($options)->load();

    $this->maybeByPassAggregate();

    return $this;
  }


  /**
   * Method for checking against plugin that is known
   * to be incompatible with the asset aggregation.
   *
   * @return mixed
   */
  public function maybeByPassAggregate() {

    $incompatible = array(
      'zencache/zencache.php' => 'Zen Cache',
      'wp-super-cache/wp-cache.php' => 'WP Super Cache',
      'wp-fastest-cache/wpFastestCache.php' => 'WP Fastest Cache',
      'w3-total-cache/w3-total-cache.php' => 'W3 Total Cache',
      'comet-cache/comet-cache.php' => 'Comet Cache',
      'autoptimize/autoptimize.php' => 'Auto Optimize',
      'wp-minify-fix/wp-minify.php' => 'WP Minify',
      'bwp-minify/bwp-minify.php' => 'Better Wordpress Minify',
      'wp-super-minify/wp-super-minify.php' => 'WP Super Minify'
    );

    $active_plugins = get_option('active_plugins', array());
    $disable = false;

    foreach ($active_plugins as $slug) {
      if (isset($incompatible[$slug])) {
        $disable = $incompatible[$slug];
        break;
      }
    }

    if ($disable) {
      $this
        ->add('incompatible', true)
        ->add('aggregate', false)
        ->add('minify', false);
    }

    return $disable;
  }

  /**
   * Method for generating hashed key
   * @return mixed
   */
  protected function generateHash() {
    $this->hash = $this->get('prefix') . md5(implode('#', array_keys($this->get('queues')->extract())));
    return $this;
  }


  /**
   * Main logic for loading assets
   * @return VTCore_Wordpress_Objects_Assets_Loader
   */
  public function process() {

    // Generate unique hash
    $this->generateHash();

    // Do asset aggregation service
    if ($this->get('aggregate')) {

      // Try to last minute rebuild cache file
      if (!$this->checkCache()) {
        $this->compress();
        $this->save();
      }

      // Only load if we got valid cache
      if ($this->checkCache()) {
        $this->loadCache();
      }
    }

    // Enqueue the assets to wordpress
    $this->enqueue();

    return $this;
  }


  /**
   * Method for enqueue queued asset to wordpress
   * @return VTCore_Wordpress_Objects_Assets_Loader
   */
  public function enqueue() {

    $queues = $this->get('queues')->extract();
    $queueKey = array_keys($queues);
    $queueCount = count($queues);

    for ($q = 0; $q < $queueCount; $q++) {

      $name = $queueKey[$q];
      $data = $queues[$name];

      if (!$this->get('library')->get($name)) {
        continue;
      }

      $inline = array();
      $dynamic = array();
      $localize = array();

      $data = wp_parse_args($data, $this->get('default'));

      $library = $this->get('library')->get($name);
      $libraryKey = array_keys($library);
      $libraryCount = count($library);

      for ($l=0; $l < $libraryCount; $l++) {

        $type = $libraryKey[$l];
        $files = $library[$type];
        $fileCount = count($files);
        $fileKey = array_keys($files);

        for ($f=0; $f<$fileCount; $f++) {

          $filename = $fileKey[$f];
          $file = $files[$filename];

          if (!is_file($file['path'])) {
            continue;
          }

          if ($type == 'css') {
            wp_enqueue_style($filename, $file['url']);
          }

          if ($type == 'js') {
            wp_enqueue_script($filename, $file['url'], $data['deps'], $data['version'], $data['footer']);
          }

          if (isset($file['inline'])) {
            $inline[$filename] = implode("\n", $file['inline']);
          }

          if (isset($file['dynamic'])) {
            $dynamic[$filename] = implode("\n", $file['dynamic']);
          }

          if (isset($file['localize'])) {
            $localize[$filename] = $file['localize'];
          }
        }
      }

      // Enqueue inline styles
      foreach ($inline as $filename => $css) {
        wp_add_inline_style($filename, $css);
      }

      // Enqueue dynamic styles
      foreach ($dynamic as $filename => $css) {
        wp_add_inline_style($filename, $css);
      }

      // Enqueue localized script
      foreach ($localize as $filename => $local) {
        foreach ($local as $var => $value) {
          wp_localize_script($filename, $var, $value);
        }
      }

      $this->get('queues')->processed($name);
    }

    return $this;
  }


  /**
   * Method for checking if we should bypass cache
   * @return VTCore_Wordpress_Factory_Assets
   */
  public function maybeByPassCache() {

    // Force remove if defined global clear cache constant
    if ((defined('WP_DEBUG') && WP_DEBUG)
      || (defined('VTCORE_CLEAR_CACHE') && VTCORE_CLEAR_CACHE)
      || get_option('vtcore_clear_cache', false) == true) {

      $this->clearCache();

    }

    return $this;
  }


  /**
   * Load compressed asset from cache
   * @return VTCore_Wordpress_Objects_Assets_Loader
   */
  public function loadCache() {

    $hash = 'compressed.' . $this->hash;
    $id = $this->get($hash . '.id');

    $queues = $this->get('queues')->extract();
    $queueCount = count($queues);
    $queueKeys = array_keys($queues);

    // Pre process queue first
    for ($q=0; $q < $queueCount; $q++) {
      $name = $queueKeys[$q];
      $library = $this->get('library')->get($name);

      // Inject dynamic assets that cannot be compressed
      // @since 4.7.36
      if ($library) {
        $libraryCount = count($library);
        $libraryKey = array_keys($library);
        for ($l=0; $l < $libraryCount; $l++) {

          $key = $libraryKey[$l];
          $files = $library[$key];
          $fileCount = count($files);
          $fileKey = array_keys($files);

          for ($f=0; $f<$fileCount; $f++) {

            $filename = $fileKey[$f];
            $asset = $files[$filename];

            if (isset($asset['dynamic']) && !empty($asset['dynamic'])) {
              $this->add($hash . '.assets.' . $key . '.' . $id . '.inline', $asset['dynamic']);
            }
          }
        }
      }

      // Remove previously cached assets from queues
      if ($name != $id) {
        $this->get('queues')->processed($name);
      }
    }

    // Add cached custom asset to library
    $this
      ->get('library')
      ->add($id, $this->get($hash . '.assets'));


    // Add the cached assets to queue
    $this
      ->get('queues')
      ->add($id, TRUE);

    return $this;
  }


  /**
   * Check if the cached file actually exists
   * to prevent missing file break site bug.
   * @return boolean
   */
  public function checkCache() {

    $check = false;
    $assets = $this->get('compressed.' . $this->hash . '.assets');
    $assetCount = count($assets);

    if ($assets && $assetCount && self::$reset == false) {
      $assetKey = array_keys($assets);
      for ($a=0; $a<$assetCount; $a++) {

        $type = $assetKey[$a];
        $data = $assets[$type];
        $file = array_shift($data);

        if (isset($file['path']) && is_file($file['path'])) {
          $check = true;
        }

        // Bail out if one of the cached file is missing
        else {
          $check = false;
          break;
        }
      }

      if (!$check) {
        // Smarter removing files, only nuke a single hashed block
        // instead of all file when using clearCache() method.
        for ($a=0; $a<$assetCount; $a++) {
          $type = $assetKey[$a];
          $data = $assets[$type];
          $file = array_shift($data);

          if (isset($file['path']) && is_file($file['path'])) {
            unlink($file['path']);
          }
        }

        $this->remove('compressed.' . $this->hash);
        $this->save();
      }

    }

    return $check;
  }


  /**
   * Overriden method for saving to database
   * This object doesn't need to save referenced
   * assets objects to database.
   *
   * @return VTCore_Wordpress_Objects_Assets_Loader
   */
  public function save() {

    $data = $this->extract();
    $this->options = array('compressed' => $this->get('compressed'));

    parent::save();

    $this->options = $data;

    unset($data);

    return $this;
  }


  /**
   * Method for compressing queued assets
   * @return VTCore_Wordpress_Objects_Assets_Loader
   */
  public function compress() {

    $this->context = array(
      'css' => '',
      'js' => '',
      'inline' => '',
      'dynamic' => '',
      'id' => uniqid('custom-'),
    );

    $queues = $this->get('queues')->extract();
    $maxQueue = count($queues);
    $queueKey = array_keys($queues);


    for ($q=0; $q < $maxQueue; $q++) {
      $name = $queueKey[$q];

      if (!$this->get('library')->get($name)) {
        continue;
      }

      $library = $this->get('library')->get($name);
      $libCount = count($library);
      $libKey = array_keys($library);
      for ($l=0; $l< $libCount; $l++) {

        $type = $libKey[$l];
        $files = $library[$type];
        $content = '';
        $filesKey = array_keys($files);
        $fileCount = count($files);

        for ($f=0; $f<$fileCount; $f++) {

          $filename = $filesKey[$f];
          $file = $files[$filename];

          if (is_file($file['path'])) {
            $content .= file_get_contents($file['path']);
          }

          if (isset($file['inline'])) {
            $this->context['inline'] .= implode("\n", $file['inline']);
          }

          if (isset($file['dynamic'])) {
            $this->context['dynamic'] .= implode("\n", $file['dynamic']);
          }

          if (isset($file['localize'])) {
            $this->get('library')
              ->add($this->context['id'] . '.js.' . $this->context['id'] . '.localize', $file['localize']);
          }
        }


        if ($type == 'css') {
          $this->base = trailingslashit(dirname($file['url']));
          $content = preg_replace_callback('/url\(\s*[\'"]?(?![a-z]+:|\/+)([^\'")]+)[\'"]?\s*\)/i', array(
            $this,
            'fixCssPath'
          ), $content);
        }

        if ($type == 'js' && substr($content, -1) != ';') {
          $content .= ";\n";
        }

        $this->context[$type] .= $content;
      }

    }

    // Merge inline css last
    $this->context['css'] .= $this->context['inline'];

    if ($this->get('minify')) {
      $this->minify();
    }

    $addAsset = false;

    if (!empty($this->context['css'])) {

      // Remove multiple @charset
      $this->context['css'] = preg_replace('/^@charset\s+[\'"](\S*?)\b[\'"];/i', '', $this->context['css']);

      $upload = VTCore_Wordpress_Utility::uploadBits($this->context['id'] . '.css', $this->context['css'], array('vtcore-assets'));

      if (!$upload['error'] && is_file($upload['file'])) {
        $this->get('queues')->add($this->context['id'], TRUE);
        $this->get('library')
          ->add($this->context['id'] . '.css.' . $this->context['id'] . '.url', $upload['url']);
        $this->get('library')
          ->add($this->context['id'] . '.css.' . $this->context['id'] . '.path', $upload['file']);

        if (!empty($this->context['dynamic'])) {
          $this->get('library')
            ->add($this->context['id'] . '.css.' . $this->context['id'] . '.inline.compressed', $this->context['dynamic']);
        }

        $addAsset = true;
      }
    }

    if (!empty($this->context['js'])) {
      $upload = VTCore_Wordpress_Utility::uploadBits($this->context['id'] . '.js', $this->context['js'], array('vtcore-assets'));

      if (!$upload['error'] && is_file($upload['file'])) {
        $this->get('queues')->add($this->context['id'], TRUE);
        $this->get('library')
          ->add($this->context['id'] . '.js.' . $this->context['id'] . '.url', $upload['url']);
        $this->get('library')
          ->add($this->context['id'] . '.js.' . $this->context['id'] . '.path', $upload['file']);

        $addAsset = true;

      }
    }
    // Add the compressed file map to compressed library
    // @bugfix compressed file never got removed
    if ($addAsset === true) {

      // Wipe merged asset from queue
      $queues = $this->get('queues')->extract();
      $maxQueue = count($queues);
      $queueKey = array_keys($queues);

      for ($q=0; $q < $maxQueue; $q++) {
        $name = $queueKey[$q];
        if (strpos($name, 'custom-') !== false) {
          continue;
        }

        $this->get('queues')->processed($name);
      }

      $this->add('compressed.' . $this->hash, array(
        'id' => $this->context['id'],
        'assets' => $this->get('library')->get($this->context['id']),
      ));
    }

    // free memory
    $this->context = array();
    unset($this->context);

    return $this;
  }


  /**
   * Method for dequeuing assets from wordpress queue
   * @return VTCore_Wordpress_Objects_Assets_Loader
   */
  public function dequeue($name, $js = TRUE, $css = TRUE) {

    if ($this->get('library')->get($name)) {
      foreach ($this->get('library')->get($name) as $type => $files) {
        foreach ($files as $filename => $file) {
          if ($type == 'css') {
            wp_dequeue_style($filename);
          }

          if ($type == 'js') {
            wp_dequeue_script($filename);
          }
        }
      }
    }

    return $this;
  }


  /**
   * Method ripped from drupal for fixing css relative path
   */
  public function fixCssPath($matches, $base = NULL) {

    // Store base path for preg_replace_callback.
    if (isset($base)) {
      $this->base = $base;
    }

    // Prefix with base and remove '../' segments where possible.
    $path = $this->base . $matches[1];
    $last = '';
    while ($path != $last) {
      $last = $path;
      $path = preg_replace('`(^|/)(?!\.\./)([^/]+)/\.\./`', '$1', $path);
    }
    return 'url(' . $path . ')';
  }


  /**
   * Minify the assets, ripped off from drupal 7
   *
   * @return VTCore_Wordpress_Factory_Assets
   */
  public function minify() {

    if (!empty($this->context['css'])) {
      $this->context['css'] = VTCore_CSSBuilder_Minify_CSS::minify($this->context['css']);
    }

    if (!empty($this->context['js'])) {
      $this->context['js'] = VTCore_CSSBuilder_Minify_JS::minify($this->context['js']);
    }

    return $this;
  }


  /**
   * Removing all compressed assets
   * This can only be invoked once per
   * page load as it is enough to clear
   * all cached file once.
   */
  public function clearCache() {

    if (self::$reset == false) {

      $upload = VTCore_Wordpress_Utility::getUploadDir(false);
      $files = glob($upload['basedir'] . DIRECTORY_SEPARATOR . 'vtcore-assets' . DIRECTORY_SEPARATOR . '*');

      if (!empty($files)) {
        foreach ($files as $file) {
          if (is_file($file)) {
            unlink($file);
          }
        }
      }

      $this->add('compressed', array());

      // Remove library asset cache
      if (is_object($this->get('library')) && method_exists($this->get('library'), 'delete')) {
        $this->get('library')->delete();
      }

      $this->save();

      // Lock this method up
      self::$reset = true;
    }

    return $this;
  }

}