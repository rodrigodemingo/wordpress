<?php
/**
 * Building Form for creating valid arrays
 * for WP_Query Objects.
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Form_WpQuery
extends VTCore_Bootstrap_Element_BsAccordion {

  protected $context = array(
    'type' => 'div',
    'prefix' => 'accordion',
    'attributes' => array(
      'id' => '',
      'class' => array(
        'panel-group',
        'panel-accordion',
      ),
    ),
    'contents' => array(),
    'active' => false,

    // Default elements context only override when needed

    // Heading wrapper element
    'heading_elements' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array('panel-heading'),
      ),
    ),

    // Heading title element
    'title_elements' => array(
      'type' => 'h4',
      'attributes' => array(
        'class' => array('panel-title'),
      ),
    ),

    // Heading link element
    'link_elements' => array(
      'type' => 'a',
      'attributes' => array(
        'data-toggle' => 'collapse',
        'data-parent' => '',
        'href' => '',
      ),
    ),

    // Content Wrapper element
    'content_elements' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array(
          'panel-collapse',
          'collapse',
        ),
      ),
    ),

    // Content body element
    'body_elements' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array('panel-body'),
      ),
    ),

    // Main Panel wrapper element
    'panel_elements' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array(
          'panel',
          'panel-default',
        ),
      ),
    ),
    'context' => array(
      'posts' => array(),
      'authors' => array(),
      'orders' => array(),
      'pagination' => array(),
      'taxonomy' => array(),
      'meta' => array(),
    ),
    'visibility' => array(
      'posts' => true,
      'authors' => true,
      'orders' => true,
      'pagination' => true,
      'taxonomy' => true,
      'meta' => true,
    ),
  );

  public function buildElement() {

    VTCore_Wordpress_Utility::loadAsset('wp-bootstrap');
    VTCore_Wordpress_Utility::loadAsset('wp-query');

    if ($this->getContext('visibility.posts')) {
      $object = new VTCore_Wordpress_Objects_Array($this->getContext('context.posts'));
      $object->merge(array(
        'name' => $this->getContext('name'),
        'value' => $this->getContext('value.posts'),
      ));

      $this->addContext('contents.posts', array(
        'title' => __('Posts', 'victheme_core'),
        'content' => new VTCore_Wordpress_Form_Query_Posts($object->extract()),
      ));
    }

    if ($this->getContext('visibility.authors')) {
      $object = new VTCore_Wordpress_Objects_Array($this->getContext('context.authors'));
      $object->merge(array(
        'name' => $this->getContext('name'),
        'value' => $this->getContext('value.authors'),
      ));

      $this->addContext('contents.authors', array(
        'title' => __('Authors', 'victheme_core'),
        'content' => new VTCore_Wordpress_Form_Query_Authors($object->extract()),
      ));
    }

    if ($this->getContext('visibility.orders')) {
      $object = new VTCore_Wordpress_Objects_Array($this->getContext('context.orders'));
      $object->merge(array(
        'name' => $this->getContext('name'),
        'value' => $this->getContext('value.orders'),
      ));

      $this->addContext('contents.orders', array(
        'title' => __('Ordering', 'victheme_core'),
        'content' => new VTCore_Wordpress_Form_Query_Orders($object->extract()),
      ));
    }

    if ($this->getContext('visibility.pagination')) {
      $object = new VTCore_Wordpress_Objects_Array($this->getContext('context.pagination'));
      $object->merge(array(
        'name' => $this->getContext('name'),
        'value' => $this->getContext('value.pagination'),
      ));

      $this->addContext('contents.pagination', array(
        'title' => __('Pagination', 'victheme_core'),
        'content' => new VTCore_Wordpress_Form_Query_Pagination($object->extract()),
      ));
    }

    if ($this->getContext('visibility.taxonomy')) {
      $object = new VTCore_Wordpress_Objects_Array($this->getContext('context.taxonomy'));
      $object->merge(array(
        'name' => $this->getContext('name'),
        'value' => $this->getContext('value.taxonomy'),
      ));

      $this->addContext('contents.taxonomy', array(
        'title' => __('Taxonomy', 'victheme_core'),
        'content' => new VTCore_Wordpress_Form_Query_Taxonomy($object->extract()),
      ));
    }

    if ($this->getContext('visibility.meta')) {
      $object = new VTCore_Wordpress_Objects_Array($this->getContext('context.meta'));
      $object->merge(array(
        'name' => $this->getContext('name'),
        'value' => $this->getContext('value.meta'),
      ));

      $this->addContext('contents.meta', array(
        'title' => __('Meta', 'victheme_core'),
        'content' => new VTCore_Wordpress_Form_Query_Meta($object->extract()),
      ));
    }

    if (!$this->getContext('value.id')) {
      $this->addContext('value.id', uniqid('vtcore-' . str_replace(array('[', ']'), array('-', '-'), $this->getContext('name')) . '-'));
    }

    $this->addContext('contents.query', array(
      'title' => __('Parameters', 'victheme_core'),
      'content' => new VTCore_Bootstrap_Form_BsText(array(
        'text' => __('Unique loop ID', 'victheme_core'),
        'description' => __('This ID can be used for other element to interacts with this query', 'victheme_core'),
        'name' => $this->getContext('name') . '[id]',
        'value' => $this->getContext('value.id'),
      ))
    ));


    parent::buildElement();
  }
}