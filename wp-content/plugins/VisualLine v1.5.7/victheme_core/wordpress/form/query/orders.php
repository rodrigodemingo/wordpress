<?php
/**
 * Class for building the wp_query ordering options
 * compliant form.
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Wordpress_Form_Query_Orders
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
        'wp-query-orders',
      ),
    ),

    'value' => array(
      'orderby' => false,
      'order' => 'DESC',
    ),

    // Internal use, Only override if needed
    'label_elements' => array(),
    'description_elements' => array(),
  );


  /**
   * Overriding parent method
   *
   * @return $this|void
   */
  public function buildElement() {

    parent::buildElement();

    if ($this->getContext('label_elements')) {
      $this->addChildren(new VTCore_Form_Label($this->getContext('label_elements')));
    }

    if ($this->getContext('description_elements')) {
      $this->addChildren(new VTCore_Bootstrap_Form_BsDescription(($this->getContext('description_elements'))));
    }

    $options = array(
      '' => __('No Order', 'victheme_core'),
      'ID' => __('Order by post id', 'victheme_core'),
      'author' => __('Order by author', 'victheme_core'),
      'title' => __('Order by title', 'victheme_core'),
      'name' => __('Order by post name (post slug)', 'victheme_core'),
      'date' => __('Order by date', 'victheme_core'),
      'modified' => __('Order by last modified date', 'victheme_core'),
      'parent' => __('Order by post/page parent id', 'victheme_core'),
      'rand' => __('Random order', 'victheme_core'),
      'comment_count' => __('Order by number of comments', 'victheme_core'),
      'menu_order' => __('Order by Page Order', 'victheme_core'),
    );

    if ($this->getContext('options')) {
      foreach ($this->getContext('options') as $key => $text) {
        $options[$key] = $text;
      }
    }

    $this
      ->addChildren(new VTCore_Bootstrap_Form_BsSelect(array(
        'text' => __('Order Direction', 'victheme_core'),
        'description' => __('Set the queried data ordering direction.', 'victheme_core'),
        'name' => $this->getContext('name') . '[orders][order]',
        'value' => $this->getContext('value.order'),
        'options' => array(
          'DESC' => __('Descending', 'victheme_core'),
          'ASC' => __('Ascending', 'victheme_core'),
        ),
      )))
      ->addChildren(new VTCore_Bootstrap_Form_BsSelect(array(
        'text' => __('Order By', 'victheme_core'),
        'description' => __('Define how to order the queried data value.', 'victheme_core'),
        'name' => $this->getContext('name') . '[orders][orderby]',
        'value' => $this->getContext('value.orderby'),
        'options' => $options,
      )));

  }


}