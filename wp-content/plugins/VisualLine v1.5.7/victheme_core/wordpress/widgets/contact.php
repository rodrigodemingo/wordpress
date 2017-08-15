<?php
/**
 * Main Class for building Contact box widgets
 * extending WP_Widget class.
 *
 * @author jason.xie@victheme.com
 *
 * @see VTCore_Wordpress_Init();
 */
class VTCore_Wordpress_Widgets_Contact
extends WP_Widget {


  private $defaults = array(
    'title' => '',
    'description' => '',
    'entries' => array(
      array(
        'icon' => '',
        'label' => '',
        'text' => '',
        'separator' => ':',
      ),
    ),
  );


  private $instance;
  private $args;



  /**
   * Registering widget as WP_Widget requirement
   */
  public function __construct() {
    parent::__construct(
      'vtcore_wordpress_widgets_contact',
      'Contact Information',
      array('description' => 'Displaying a configured contact information')
    );
  }




  /**
   * Registering widget
   */
  public function registerWidget() {
    return register_widget('VTCore_Wordpress_Widgets_Contact');
  }



  /**
   * Constructs name attributes for use in form() fields
   *
   * This function should be used in form() methods to create name attributes for fields to be saved by update()
   * Override the default parent method since 4.4.0, the parent method
   * will break the form name!
   *
   * @since 2.8.0
   * @since 4.4.0 Array format field names are now accepted.
   *
   * @param string $field_name Field name
   * @return string Name attribute for $field_name
   */
  public function get_field_name($field_name) {
    return 'widget-' . $this->id_base . '[' . $this->number . '][' . $field_name . ']';
  }

  /**
   * Extending widget
   *
   * @see WP_Widget::widget()
   */
  public function widget($args, $instance) {

    VTCore_Wordpress_Utility::loadAsset('wp-contact-info');

    $this->args = $args;
    $this->instance = VTCore_Utility::arrayMergeRecursiveDistinct($instance, $this->defaults);

    $title = apply_filters( 'widget_title', $this->instance['title'] );
    echo $this->args['before_widget'];

    if (!empty($title)) {
      echo $this->args['before_title'] . $title . $this->args['after_title'];
    }

    $element = new VTCore_Bootstrap_Element_Base();

    if (!empty($this->instance['description'])) {
      $element
        ->BsElement(array(
          'type' => 'div',
          'text' => $this->instance['description'],
          'attributes' => array(
            'class' => array('post-social-desciption'),
          ),
          'raw' => true,
        ));
    }

    foreach ($this->instance['entries'] as $entry) {

      $element
        ->BsElement(array(
          'type' => 'div',
          'attributes' => array(
            'class' => array('contact-rows'),
          ),
        ));

      if (!empty($entry['icon'])) {
        $element->lastChild()->addChildren(new VTCore_Fontawesome_faIcon($entry));
      }

      if (!empty($entry['label'])) {
        $element->lastChild()->addChildren(new VTCore_Bootstrap_Element_BsElement(array(
          'type' => 'span',
          'text' => $entry['label'],
          'raw' => true,
          'attributes' => array(
            'class' => array('contact-heading'),
          ),
        )));
      }

      if (!empty($entry['separator'])) {
        $element->lastChild()->addChildren(new VTCore_Bootstrap_Element_BsElement(array(
          'type' => 'span',
          'text' => $entry['separator'],
          'raw' => true,
          'attributes' => array(
            'class' => array('contact-separator'),
          ),
        )));
      }

      if (!empty($entry['text'])) {
        $element->lastChild()->addChildren(new VTCore_Bootstrap_Element_BsElement(array(
          'type' => 'span',
          'text' => $entry['text'],
          'raw' => true,
          'attributes' => array(
            'class' => array('contact-text'),
          ),
        )));
      }

    }

    // Allow other plugin to alter the output
    do_action('wp_widget_contact_output', $element, $this);

    $element->render();

    echo $args['after_widget'];
  }





  /**
   * Widget configuration form
   * @see WP_Widget::form()
   */
  public function form($instance) {

    VTCore_Wordpress_Utility::loadAsset('jquery-table-manager');
    VTCore_Wordpress_Utility::loadAsset('wp-bootstrap');
    VTCore_Wordpress_Utility::loadAsset('wp-widget');


    $this->instance = VTCore_Utility::arrayMergeRecursiveDistinct($instance, $this->defaults);

    $this
      ->buildForm()
      ->processForm()
      ->processError(true)
      ->render();

  }




  /**
   * Function for building the form object
   */
  private function buildForm() {

    $widget = new VTCore_Bootstrap_Form_BsInstance(array(
      'type' => false,
    ));

    $widget
      ->BsText(array(
        'text' => __('Title', 'victheme_core'),
        'name' => $this->get_field_name('title'),
        'id' => $this->get_field_id('title'),
        'value' => $this->instance['title'],
      ))
      ->BsTextarea(array(
        'text' => __('Description', 'victheme_core'),
        'name' => $this->get_field_name('description'),
        'id' => $this->get_field_id('description'),
        'value' => $this->instance['description'],
      ))
      ->BsElement(array(
        'type' => 'div',
        'attributes' => array(
          'class' => array('table-manager'),
        ),
      ))
      ->lastChild()
      ->Table(array(
        'headers' => array(
          ' ',
          __('Content', 'victheme_core'),
          ' ',
        ),
        'rows' => $this->buildRows(),
        'attributes' => array(
          'data-filter' => 2,
        ),
      ))
      ->Button(array(
        'text' => __('Add New Entry', 'victheme_core'),
        'attributes' => array(
          'data-tablemanager-type' => 'addrow',
          'class' => array('button', 'button-large', 'button-primary'),
        ),
      ));

    return $widget;
  }





  /**
   * Building the table manager rows
   */
  private function buildRows() {
    $rows = array();
    foreach ($this->instance['entries'] as $key => $link) {

      // Draggable Icon
      $rows[$key][] = array(
        'content' => new VTCore_Bootstrap_Element_BsElement(array(
          'type' => 'span',
          'attributes' => array(
            'class' => array('drag-icon'),
          ),
        )),
        'attributes' => array(
          'class' => array('drag-element'),
        ),
      );


      // Icon selector
      $rows[$key]['content'] = new VTCore_Bootstrap_Element_Base();
      $rows[$key]['content']
        ->addOverloaderPrefix('VTCore_Fontawesome_Form_')
        ->faIcon(array(
          'text' => __('Icon', 'victheme_core'),
          'name' => $this->get_field_name('entries][' . $key . '][icon'),
          'value' => $link['icon'],
        ))
        ->BsRow()
        ->lastChild()
        ->BsText(array(
          'text' => __('Label', 'victheme_core'),
          'name' => $this->get_field_name('entries][' . $key . '][label'),
          'value' => $link['label'],
          'grids' => array(
            'columns' => array(
              'mobile' => 8,
              'tablet' => 8,
              'small' => 8,
              'large' => 8,
            ),
          ),
        ))
        ->BsText(array(
          'text' => __('Separator', 'victheme_core'),
          'name' => $this->get_field_name('entries][' . $key . '][separator'),
          'value' => $link['separator'],
          'grids' => array(
            'columns' => array(
              'mobile' => 4,
              'tablet' => 4,
              'small' => 4,
              'large' => 4,
            ),
          ),
        ))
        ->getParent()
        ->BsTextarea(array(
          'text' => __('Text', 'victheme_core'),
          'name' => $this->get_field_name('entries][' . $key . '][text'),
          'value' => $link['text'],
          'input_attributes' => array(
            'raw' => true,
          ),
        ));


      // Remove button
      $rows[$key][] = array(
        'content' => new VTCore_Form_Button(array(
            'text' => 'X',
            'attributes' => array(
              'data-tablemanager-type' => 'removerow',
              'class' => array('button', 'button-mini', 'form-button'),
            ),
          )),
          'attributes' => array(
            'class' => array('remove-button')
          ),
        );
    }

    return $rows;
  }





  /**
   * Widget update function.
   * @see WP_Widget::update()
   */
  public function update($new_instance, $old_instance) {

    $form = $this->buildForm()->processForm()->processError();
    $errors = $form->getErrors();

    if (empty($errors)) {
      return wp_unslash($new_instance);
    }

    return false;
  }
}