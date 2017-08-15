<?php
/**
 * Class for handling custom templating system
 *
 * This class will act as the main central library
 * for all plugins and theme to use for registering
 * custom template
 *
 * It will allow user / themer to provide template
 * files targeted for specific custom post type single
 * template only.
 *
 * The folder for the template files structure :
 *
 * themefolder/templates/custom/xxxx.php
 *
 *
 * The file must have header doc :
 *
 *
 *  Post Types: xxx,xxx,xxx
 *  Template Custom Name: Some useful name for indentifying the template
 *
 *
 * Theme or plugin must use the VTCore template factory for registering
 * the custom template files.
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Factory_CustomTemplate
implements VTCore_Wordpress_Interfaces_Factory {

  /**
   * Default we register the page and post
   * post type, more post type can be
   * registered on the fly with hook
   * filter vtcore_wordpress_register_custom_templates
   * or method addRegistered()
   */
  private $registered = array(
    'page',
    'post',
  );

  public function maybeByPassCache() {}
  public function loadCache() {}
  public function clearCache() {}


  /**
   * Get registered post types that can have custom
   * templating system
   *
   * @see filters vtcore_wordpress_register_custom_templates
   *       use this filter to add or remove registered templates
   */
  public function getRegistered() {
    return apply_filters('vtcore_wordpress_register_custom_templates', $this->registered);
  }



  /**
   * Allow other plugin to add custom post type on the fly.
   */
  public function addRegistered($type) {
    $type = (array) $type;
    $this->registered = array_merge($this->registered, $type);
    return $this;
  }

}