<?php
/**
 * Building a single select element for a flatten
 * single taxonomy terms.
 *
 *
 * @author jason.xie@victheme.com
 * @method WpTerms($context)
 * @see VTCore_Html_Form interface
 */
class VTCore_Wordpress_Form_WpTerms
extends VTCore_Bootstrap_Form_BsSelect
implements VTCore_Form_Interface {

  protected $context = array(

    // Shortcut method
    // @see VTCore_Bootstrap_Form_Base::assignContext()
    'text' => false,
    'description' => false,
    'required' => false,

    'name' => false,
    'id' => false,
    'class' => array('form-control'),

    // Bootstrap Rules
    'label' => true,

    // Wrapper element
    'type' => 'div',
    'attributes' => array(
      'class' => array(
        'form-group',
        'wp-terms'
       ),
    ),

    'value' => false,
    'placeholder_element' => true,
    'taxonomies' => array(),
    'arguments' => array(
      'orderby' => 'name',
      'order' => 'ASC',
      'hide_empty' => false,
      'parent' => false,
      'fields' => 'all',
      'hierarchical' => true,
    ),

    // Internal use, Only override if needed
    'input_elements' => array(),

    'label_elements' => array(),
    'description_elements' => array(),
    'prefix_elements' => array(),
    'suffix_elements' => array(),
    'required_elements' => array(),
  );


  private $terms;
  private $taxonomies = array();

  /**
   * Build a options valid for select element
   */
  protected function buildOptions() {

    // Record all children hierarchy first
    foreach ($this->getContext('taxonomies') as $taxonomy) {
      $this->taxonomies[$taxonomy] = _get_term_hierarchy($taxonomy);
    }

    // Fix wp notice bug
    $this->options = array();

    if ($this->getContext('placeholder_element')) {
      if (!$this->getContext('placeholder')) {
        $this->addContext('placeholder', __('-- Select --', 'victheme_core'));
      }
      $this->options = array(
        array(
          'text' => $this->getContext('placeholder'),
          'data' => array(
            'placeholder' => TRUE,
          ),
          'attributes' => array(
            'value' => '',
          ),
        ),
      );
    }

    $this->terms = get_terms($this->getContext('taxonomies'), $this->getContext('arguments'));

    // Wp Got error
    if ($this->terms instanceof WP_Error) {
      $this->terms = array();
    }

    foreach ($this->terms as $term) {
      $this->options[$term->term_id] = array(
        'text' => $term->name,
        'attributes' => array(
          'value' => $term->term_id,
        ),
        'data' => array(
          'parent' => $term->parent,
          'has-children' => $this->checkChildren($term->term_id, $term->taxonomy),
        ),
      );
    }

    $this->addContext('options', $this->options);

    return $this;
  }


  /**
   * Overridding parent buildElement()
   * @see VTCore_Bootstrap_Form_BsSelect::buildElement()
   */
  public function buildElement() {
    $this->buildOptions();
    parent::buildElement();
  }


  public function checkChildren($term_id, $taxonomy) {
    return isset($this->taxonomies[$taxonomy][$term_id]) ? true : false;
  }

}