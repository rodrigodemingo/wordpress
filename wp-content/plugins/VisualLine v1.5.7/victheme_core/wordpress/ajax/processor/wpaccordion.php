<?php
/**
 * Ajax callback class for WpAccordion Object
 *
 * Additional context outside the wp-ajax api context needed
 * for building the proper ajax results :
 *
 * WpAccordion
 * ===========
 * context : serialized base64_encoded strings containing
 *           array of arguments for WpAccodion Object content
 * id      : the id for the destination target
 *
 *
 * @see VTCore_Wordpress_Element_WpAccordion
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Ajax_Processor_WpAccordion
extends VTCore_Wordpress_Models_Ajax {

  protected $render = array();
  protected $post;


  private $context;
  private $accordion;


  /**
   * Ajax callback function
   *
   * $post will hold all the data passed by ajax.
   */
  protected function processAjax() {

    $this->context = unserialize(base64_decode($this->post['value']));
    $this->context = apply_filters('vtcore_wordpress_wpaccordion_ajax_context_alter', $this->context);

    $this->target = esc_html($this->post['target']);
    $this->object = esc_html(base64_decode($this->post['data']['panelobject']));

    if (class_exists($this->object, true)) {
      $this->content = new $this->object($this->context);
      $this->content->setType(FALSE);

      $this->render['action'][] = array(
        'mode' => 'append',
        'target' => $this->target,
        'content' => $this->content->__toString(),
      );
    }

    else {
      $this->render['action'][] = array(
        'mode' => 'append',
        'target' => $this->target,
        'content' => __('Error Processing Ajax request', 'victheme_core'),
      );
    }

    // Stop ajax button
    $this->render['action'][] = array(
      'mode' => 'data',
      'target' => '[data-ajax-target="' . $this->target . '"]',
      'key' => 'ajax-stop',
      'content' => true,
    );

    // Allow plugin to inject their own process
    do_action('vtcore_wordpress_wpaccordion_ajax_result_alter', $this->render, $this);

    return $this->render;
  }

}