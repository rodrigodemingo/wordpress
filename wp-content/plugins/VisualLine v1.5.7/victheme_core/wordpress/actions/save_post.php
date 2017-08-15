<?php
/**
 * Class to be invoked on save_post action
 *
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Wordpress_Actions_Save__Post
extends VTCore_Wordpress_Models_Hook {

  protected $argument = 2;

  public function hook($post_id = NULL, $post = NULL) {
    // Add saving function for custom templating system
    $customTemplate = new VTCore_Wordpress_Metabox_CustomTemplate();
    $customTemplate->save($post_id, $post);

    // Add saving function for custom heading system
    $customHeading = new VTCore_Wordpress_Metabox_CustomHeader();
    $customHeading->save($post_id, $post);
  }
}