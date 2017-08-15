<?php
/**
 * Class for building the custom heading
 * custom fields in the post edit page
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Metabox_CustomHeader
extends VTCore_Wordpress_Models_Metabox {

  protected $nonce_id = '_vtcore_wordpress_custom_heading_nonce';
  protected $nonce_key = '_vtwocusthe_nonce';
  protected $meta_id = 'vtcore_wordpress_custom_heading';
  protected $meta_key = 'vtcore_wordpress_custom_heading';

  /**
   * Building the metabox form
   */
  public function buildForm() {

    VTCore_Wordpress_Utility::loadAsset('wp-bootstrap');

    $this->form = new VTCore_Bootstrap_Form_BsInstance(array(
      'type' => '',
      'attributes' => false,
    ));

    $this->form
      ->addChildren(new VTCore_Wordpress_Form_WpNonce(array(
        'action' => $this->nonce_key,
        'attributes' => array(
          'type' => 'hidden',
          'name' => $this->nonce_id,
          'value' => '',
        ),
      )))
      ->addChildren(new VTCore_Wordpress_Form_WpMedia(array(
        'name' => $this->meta_key . '[image]',
        'text' => __('Heading Image', 'victheme_core'),
        'value' => $this->get('image'),
        'data' => array(
          'type' => 'image',
          'title' => __('Select File', 'victheme_core'),
          'button' =>__('Select Image', 'victheme_core'),
        ),
      )))
      ->addChildren(new VTCore_Bootstrap_Form_BsText(array(
        'text' => __('Heading', 'victheme_core'),
        'name' => $this->meta_key . '[header]',
        'value' => $this->get('header'),
      )))
      ->addChildren(new VTCore_Bootstrap_Form_BsTextarea(array(
        'text' => __('Description', 'victheme_core'),
        'name' => $this->meta_key . '[description]',
        'value' => $this->get('description'),
      )));
  }


}