<?php
/**
 * VTCore API Ajax Router For Admin Page
 *
 * @author jason.xie@victheme.com
 * @see VTCore_Wordpress_Models_Router
 * @see VTCore_Wordpress_Actions_Wp__Ajax__Nopriv__VTCore__Ajax__Framework
 *
 * @todo Better user checking
 * @todo allow other class to change the nonce key on the fly
 */
class VTCore_Wordpress_Ajax_Router_Admin
extends VTCore_Wordpress_Models_Router {

  protected $noncekey = 'vtcore-ajax-nonce-admin';


  /**
   * Check if on admin page and user has
   * valid nonce key.
   *
   * @see VTCore_Wordpress_Ajax_Router_Base::checkPermission()
   */
  public function checkPermission() {

    // Only admin allow to use this ajax callback
    if (!is_admin() || !isset($this->post['nonce']) || !wp_verify_nonce($this->post['nonce'], $this->noncekey)) {
      die(__('Permission Denied.', 'victheme_core'));
    }

    return $this;
  }

}