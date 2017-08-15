<?php
/**
 * Main Class for building social icons widgets
 * extending WP_Widget class.
 *
 * @author jason.xie@victheme.com
 *
 * @see VTCore_Wordpress_Init();
 */
class VTCore_Wordpress_Widgets_Social
extends WP_Widget {


  private $defaults = array(
    'title' => '',
    'description' => '',
    'align' => 'text-center',
    'links' => array(
      array(
       'icon' => '',
        'href' => '',
      ),
    ),
  );


  private $instance;
  private $args;


  // Define the valid icon that icon-picker
  // can display.
  private $iconset = array(
    'tumblr',
    'facebook',
    'google-plus',
    'pinterest',
    'linkedin',
    'github',
    'twitter',
    'flickr' ,
    'youtube',
    'dribbble',
    'instagram',
    'weibo',
    'bitbucket',
    'dropbox',
    'foursquare',
    'gittip',
    'renren',
    'skype',
    'stack-exchange',
    'trello',
    'vk',
    'vimeo-square',
    'xing',
  );



  /**
   * Registering widget as WP_Widget requirement
   */
  public function __construct() {
    parent::__construct(
      'vtcore_wordpress_widgets_social',
      'Social Icon',
      array('description' => 'Displaying Social Icons')
    );
  }




  /**
   * Registering widget
   */
  public function registerWidget() {
    return register_widget('VTCore_Wordpress_Widgets_Social');
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
        ->addChildren(new VTCore_Bootstrap_Element_BsElement(array(
          'type' => 'div',
          'text' => $this->instance['description'],
          'attributes' => array(
            'class' => array('post-social-desciption'),
          ),
          'raw' => true,
        )));
    }

    $element
      ->addChildren(new VTCore_Bootstrap_Element_BsElement(array(
        'type' => 'div',
        'attributes' => array(
          'class' => array('post-social'),
        ),
      )))
      ->lastChild()
      ->addChildren(new VTCore_Wordpress_Element_WpSocialIcon(array(
        'social' => $this->instance['links'],
        'attributes' => array(
          'class' => array('unstyled', 'inline', $this->instance['align'])
        ),
      )));


    // Allow other plugin to alter the output
    do_action('wp_widget_social_output', $element, $this);

    $element->render();

    $element = false;
    unset($element);

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
      ->addChildren(new VTCore_Bootstrap_Form_BsText(array(
        'text' => __('Title', 'victheme_core'),
        'name' => $this->get_field_name('title'),
        'id' => $this->get_field_id('title'),
        'value' => $this->instance['title'],
      )))
      ->addChildren(new VTCore_Bootstrap_Form_BsTextarea(array(
        'text' => __('Description', 'victheme_core'),
        'name' => $this->get_field_name('description'),
        'id' => $this->get_field_id('description'),
        'value' => $this->instance['description'],
      )))
      ->addChildren(new VTCore_Bootstrap_Form_BsSelect(array(
        'text' => __('Alignment', 'victheme_core'),
        'name' => $this->get_field_name('align'),
        'id' => $this->get_field_id('align'),
        'value' => $this->instance['align'],
        'options' => array(
          'text-left' => __('Left', 'victheme_core'),
          'text-right' => __('Right', 'victheme_core'),
          'text-center' => __('Center', 'victheme_core'),
        ),
      )))
      ->addChildren(new VTCore_Bootstrap_Element_BsElement(array(
        'type' => 'div',
        'attributes' => array(
          'class' => array('table-manager'),
        ),
      )))
      ->lastChild()
      ->addChildren(new VTCore_Html_Table(array(
        'headers' => array(
          ' ',
          __('Content', 'victheme_core'),
          ' ',
        ),
        'rows' => $this->buildRows(),
        'attributes' => array(
          'data-filter' => 2,
        ),
      )))
      ->addChildren(new VTCore_Form_Button(array(
        'text' => __('Add New Entry', 'victheme_core'),
        'attributes' => array(
          'data-tablemanager-type' => 'addrow',
          'class' => array('button', 'button-large', 'button-primary'),
        ),
      )));

    return $widget;
  }





  /**
   * Building the table manager rows
   */
  private function buildRows() {
    $rows = array();

    if (empty($this->instance['links'])) {
      $this->instance['links'] = array(
        array(
          'icon' => '',
          'href' => '',
        ),
      );
    }

    foreach ($this->instance['links'] as $key => $link) {

      $link = new VTCore_Wordpress_Objects_Array($link);

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
          'iconset' => $this->iconset,
          'text' => __('Icon', 'victheme_core'),
          'name' => $this->get_field_name('links][' . $key . '][icon'),
          'value' => $link->get('icon'),
        ))
        ->BsUrl(array(
          'text' => __('Link URL', 'victheme_core'),
          'name' => $this->get_field_name('links][' . $key . '][href'),
          'value' => $link->get('href'),
          'required' => true,
        ))
        ->BsText(array(
          'text' => __('Link Target', 'victheme_core'),
          'name' => $this->get_field_name('links][' . $key . '][target'),
          'value' => $link->get('target'),
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