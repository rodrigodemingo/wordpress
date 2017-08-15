<?php
/**
 * Class for build the wp_query pagination
 * compliant form
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Wordpress_Form_Query_Pagination
extends VTCore_Bootstrap_Form_Base
implements VTCore_Form_Interface  {

  protected $context = array(
    'text' => false,
    'description' => false,

    'name' => false,
    'id' =>  false,
    'class' => array(
      'form-control'
    ),
    'label' => true,

    'type' => 'div',

    // Wrapper Element
    'type' => 'div',
    'attributes' => array(
      'class' => array(
        'form-group',
        'wp-query-pagination',
      ),
    ),

    'value' => array(
      'posts_per_page' => 10,
      'nopaging' => false,
      'offset' => false,
      'paged' => false,
    ),

    // Internal use, Only override if needed
    'label_elements' => array(),
    'description_elements' => array(),
  );


  public function buildElement() {

    parent::buildElement();

    if ($this->getContext('label_elements')) {
      $this->addChildren(new VTCore_Form_Label($this->getContext('label_elements')));
    }

    if ($this->getContext('description_elements')) {
      $this->addChildren(new VTCore_Bootstrap_Form_BsDescription(($this->getContext('description_elements'))));
    }

    $this
      ->addChildren(new VTCore_Bootstrap_Form_BsText(array(
        'text' => __('Post Per Page', 'victheme_core'),
        'description' => __('Number of post to retrieve in a single query', 'victheme_core'),
        'name' => $this->getContext('name') . '[pagination][posts_per_page]',
        'value' => $this->getContext('value.posts_per_page'),
      )))
      ->addChildren(new VTCore_Bootstrap_Form_BsCheckbox(array(
        'text' => __('No Paging', 'victheme_core'),
        'description' => __('When enabled, post per page options will be ignored.', 'victheme_core'),
        'switch' => true,
        'name' => $this->getContext('name') . '[pagination][nopaging]',
        'checked' => (boolean) $this->getContext('value.nopaging'),
      )))
      ->addChildren(new VTCore_Bootstrap_Form_BsNumber(array(
        'text' => __('Offset', 'victheme_core'),
        'description' => __('Set how many post should the query skips before starting the query.', 'victheme_core'),
        'name' => $this->getContext('name') . '[pagination][offset]',
        'value' => $this->getContext('value.offset'),
      )))
      ->addChildren(new VTCore_Bootstrap_Form_BsNumber(array(
        'text' => __('Page', 'victheme_core'),
        'description' => __('Input numerical entry for jumping the query to x page, the number of post skipped will be related to the post per page options', 'victheme_core'),
        'name' => $this->getContext('name') . '[pagination][paged]',
        'value' => $this->getContext('value.paged'),
      )));

  }


}