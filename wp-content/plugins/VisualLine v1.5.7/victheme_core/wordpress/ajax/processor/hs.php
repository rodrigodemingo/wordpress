<?php
/**
 * Ajax callback class for handling
 * the hierarchical selects ajax.
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Ajax_Processor_Hs
extends VTCore_Wordpress_Models_Ajax {

  protected $render = array();
  protected $post;

  private $term_id;
  private $taxonomies;
  private $target;
  private $object;
  private $context;
  private $term;
  private $parent_id;

  /**
   * Ajax callback function
   *
   * $this->post will hold all the data passed by ajax.
   * - taxonomies = array or string of taxonomies,
   * - elval = the taxonomy term id
   */
  protected function processAjax() {

    $this->taxonomies = esc_html($this->post['data']['taxonomies']);
    $this->term_id = esc_html($this->post['elval']);
    $this->target = esc_html($this->post['data']['target']);
    $this->context = json_decode(base64_decode($this->post['value']), true);
    $this->parent_id = esc_html($this->post['data']['parent']);

    if (empty($this->term_id) && !empty($this->parent_id)) {
      $this->term_id = (int) $this->parent_id;
    }

    if (!$this->validateData()) {
      return array(
        'action' => array(
          'mode' => 'error',
          'target' => '',
          'content' => __('Error Processing Ajax request', 'victheme_core'),
        ),
      );
    }

    $this->context['value'] = array_reverse(get_ancestors($this->term_id, $this->taxonomies));
    $this->context['value'][] = $this->term_id;

    array_filter($this->context['value']);

    $this->object = new VTCore_Wordpress_Form_WpTermsHS($this->context);


    // Build ajax framework commands
    // Command if new ajax content is allowed
    $this->render['action'][] = array(
      'mode' => 'replace',
      'target' => $this->target,
      'content' => $this->object->__toString(),
    );

    return $this->render;
  }



  /**
   * Validate the ajax post data
   *
   * @return boolean
   * @todo : Expand this to its own validation class set.
   */
  private function validateData() {
    if (empty($this->taxonomies)
        || !is_numeric($this->term_id)) {

      return false;
    }

    return true;
  }
}