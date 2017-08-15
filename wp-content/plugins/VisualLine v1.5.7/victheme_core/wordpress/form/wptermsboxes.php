<?php
/**
 * Building series of checkboxes or radios
 * from taxonomy terms with its children hierarchy
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Wordpress_Form_WpTermsBoxes
extends VTCore_Bootstrap_Form_Base {

  protected $context = array(

    'text' => false,
    'description' => false,
    'required' => false,

    'name' => false,
    'id' => false,
    'class' => array('form-control'),

    // Bootstrap Rules
    'label' => true,
    'element' => 'checkbox', // Checkbox || radio

    // Wrapper element
    'type' => 'div',
    'attributes' => array(
      'class' => array(
        'form-group',
        'wp-terms-group',
        'wp-terms-boxes',
       ),
    ),

    'value' => array(),
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


  /**
   * Build a options valid for select element
   */
  public function buildElement() {

    VTCore_Wordpress_Utility::loadAsset('font-awesome');
    VTCore_Wordpress_Utility::loadAsset('wp-termsboxes');

    $this->addAttributes($this->getContext('attributes'));

    if ($this->getContext('label_elements')) {
      $this->addChildren(new VTCore_Form_Label($this->getContext('label_elements')));
    }

    if ($this->getContext('prefix_elements')) {
      $this->addChildren(new VTCore_Bootstrap_Form_BsPrefix(($this->getContext('prefix_elements'))));
    }

    foreach ($this->getContext('taxonomies') as $taxonomy) {

      $object = new VTCore_Bootstrap_Element_BsElement();
      $this->buildTerms($object, $taxonomy, '');
      if ($object->getChildrens() == array()) {
        $object
          ->setType('div')
          ->addClass('wpterms-empty')
          ->setText(__('No Terms found', 'victheme_core'));
      }
      $this->addChildren($object);
    }

    if ($this->getContext('suffix_elements')) {
      $this->addChildren(new VTCore_Bootstrap_Form_BsSuffix(($this->getContext('suffix_elements'))));
    }

    if ($this->getContext('description_elements')) {
      $this->addChildren(new VTCore_Bootstrap_Form_BsDescription(($this->getContext('description_elements'))));
    }

    if ($this->getContext('togglelabel')) {

      if (class_exists('VTCore_Wordpress_Utility')) {
        VTCore_Wordpress_Utility::loadAsset('bootstrap-toggle-label');
      }

      $this->addData('toggle-label', array(
        'parent' => false,
      ));
    }

    return $this;
  }


  /**
   * Method for building the taxonomy terms elements
   * @param $object
   * @param $taxonomy
   * @param string $parent
   * @return mixed
   */
  protected function buildTerms($object, $taxonomy, $parent = '') {
    $args = $this->getContext('arguments');
    $values = (array) $this->getContext('value');
    $className = 'VTCore_Bootstrap_Form_BsCheckbox';

    if ($this->getContext('element') == 'radio') {
      $className = 'VTCore_Bootstrap_Form_BsRadio';
    }

    if (!empty($parent)) {
      $args['parent'] = $parent;
    }
    $terms = get_terms($taxonomy, $args);

    if (!empty($terms)) {

      foreach ($terms as $term) {
        $object
          ->addChildren(new VTCore_Bootstrap_Element_BsElement(array(
            'type' => 'div',
            'attributes' => array(
              'class' => array(
                'wp-terms-wrapper',
                'clearfix',
                empty($parent) ? $taxonomy : '',
              ),
            ),
            'data' => array(
              'term-parent' => empty($parent) ? 'root' : $parent,
            ),
          )))
          ->lastChild()
          ->addChildren(new $className(array(
            'text' => $term->name,
            'name' => $this->getContext('name'),
            'value' => $term->term_id,
            'offvalue' => NULL,
            'checked' => (boolean) in_array($term->term_id, $values),
            'input_elements' => array(
              'attributes' => array(
                'class' => array(
                  'wptermboxes-input'
                ),
              ),
            ),
          )))
          ->prependChild(new VTCore_Bootstrap_Element_BsElement(array(
            'type' => 'span',
            'data' => array(
              'term-trigger' => $term->term_id,
            ),
          )));


        $this->buildTerms($object->lastChild(), $taxonomy, $term->term_id);
        unset($current);
      }
    }

    return $object;
  }

}