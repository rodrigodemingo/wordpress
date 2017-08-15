<?php
/**
 * Models for generating WordPress metabox
 * complete with its registration process
 * and saving process.
 *
 * @author jason.xie@victheme.com
 *
 */
abstract class VTCore_Wordpress_Models_Metabox {

  /**
   * Define the permission name for class
   * to check when saving the metabox
   *
   * @var string
   */
  protected $permission;

  /**
   * Define the field nonce key for class
   * to verify when saving
   *
   * @var string
   */
  protected $nonce_id;
  protected $nonce_key;

  /**
   * Define the meta key for class to retrieve
   * meta data from database and when saving
   * to database.
   *
   * @var string
   */
  protected $meta_id;
  protected $meta_key;


  /**
   * Private variables used only by class
   * to store data.
   */
  protected $post;
  protected $form;
  protected $meta;
  protected $sanitized;
  protected $clearCache = false;



  /**
   * Default construct method.
   */
  public function __construct() {
    global $post;
    $this->post = $post;

    if (!empty($this->meta_id) && isset($this->post->ID)) {
      $meta = get_post_meta($this->post->ID, $this->meta_id, true);

      // Auto merge array of metas
      if (is_array($this->meta) && !empty($meta) && is_array($meta)) {
        $this->merge($meta);
      }
      elseif (!is_array($meta) && !is_array($this->meta)) {
        $this->meta = $meta;
      }
      elseif (empty($this->meta)) {
        $this->meta = $meta;
      }
    }
  }


  public function extract() {
    return $this->meta;
  }


  public function set(array $value) {
    $this->meta = $value;
    return $this;
  }


  public function reset() {
    $this->meta = array();
    return $this;
  }


  public function add($keys, $value) {
    VTCore_Utility::setArrayValueKeys((array) $this->meta, $keys, $value);
    return $this;
  }


  public function get($keys) {
    return VTCore_Utility::getArrayValueKeys((array) $this->meta, $keys);
  }


  public function remove($keys) {
    VTCore_Utility::removeArrayValueKeys((array) $this->meta, $keys);
    return $this;
  }


  public function merge(array $options) {
    $original = (array) $this->meta;
    $this->meta = VTCore_Utility::arrayMergeRecursiveDistinct($options, $original);
    unset($original);
    unset($options);
    return $this;
  }


  public function getFieldKey($key) {
    return $this->meta_key . '[' . $key . ']';
  }



  /**
   * Hook to register metabox
   * This should be called from add_meta_box()
   * withing add_meta_boxes() action hook
   */
  public function register() {
    $this->buildForm();
    $this->form->processForm()->render();
  }



  /**
   * Sub class must extend this method and
   * provide the actual VTCore HTML objects
   * inside the $form property
   */
  abstract protected function buildForm();



  /**
   * Hook to save the metabox
   * This should be called from save_post
   * action hook.
   */
  public function save($post_id, $post) {

    // Verify nonce if sub class defined the nonce key
    if (!empty($this->nonce)) {
      $nonce = $_POST[$this->nonce_id];
      if (!wp_verify_nonce($nonce, $this->nonce_key)) {
        return $post_id;
      }
    }

    // If this is an autosave, our form has not been submitted,
    // so we don't want to do anything.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return $post_id;
    }

    // Check the user's permissions.
    if (!empty($this->permission)) {
      if (!current_user_can($this->permission)) {
        return $post_id;
      }
    }

    if (!empty($this->meta_id) && isset($_POST[$this->meta_key])) {
      update_post_meta($post_id, $this->meta_id, $_POST[$this->meta_key]);

      if ($this->clearCache) {
        VTCore_Wordpress_Init::getFactory('assets')
          ->mutate('prefix', 'comp-front-')
          ->clearCache()
          ->mutate('prefix', 'comp-admin-');
      }
    }

  }

}