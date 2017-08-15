<?php
/**
 * Class for building the custom template
 * selector metabox in the post edit form.
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Metabox_CustomTemplate
extends VTCore_Wordpress_Models_Metabox {

  protected $nonce_id = '_vtcore_wordpress_custom_template_nonce';
  protected $nonce_key = '_vtwocusate_nonce';
  protected $meta_id = 'vtcore_wordpress_custom_template';
  protected $meta_key = 'vtcore_wordpress_custom_template';


  private $options = array();

  /**
   * Building the metabox form
   */
  public function buildForm() {

    $this->buildTemplateOptions();

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
      ->addChildren(new VTCore_Bootstrap_Form_BsSelect(array(
        'label' => false,
        'name' => 'vtcore_wordpress_custom_template',
        'description' => __('Use custom template for this post entry.', 'victheme_core'),
        'value' => $this->meta,
        'options' => $this->options,
      )));

  }


  /**
   * Constructing all available template for
   * current post type.
   *
   * @return array suitable for use with Html object select element.
   */
  private function buildTemplateOptions() {

    foreach (VTCore_Wordpress_Init::getFactory('template')->getTemplates() as $filename => $template) {

      // Extracting template data
      $headers = get_file_data(
        VTCore_Wordpress_Init::getFactory('template')->locate($filename),
        array(
          'post_type' => 'Post Types',
          'template_name' => 'Template Name',
          'custom_name' => 'Template Custom Name',
       )
      );

      if (empty($headers['post_type']) || strpos($headers['post_type'], $this->post->post_type) === false) {
        continue;
      }

      $name = $filename;
      if (isset($headers['template_name']) && !empty($headers['template_name'])) {
        $name = $headers['template_name'];
      }

      if (isset($headers['custom_name']) && !empty($headers['custom_name'])) {
        $name = $headers['custom_name'];
      }

      $this->options[$filename] = $name;
    }

    asort($this->options);
    array_unshift($this->options, __('None', 'victheme_core'));

  }

}