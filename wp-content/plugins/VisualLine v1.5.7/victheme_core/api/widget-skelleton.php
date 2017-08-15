<?php

die('No direct access allowed');

/**
 * Example skelleton file for building wordpress
 * widget and utilizing th Html Element builder class
 * including the bootstrap derivative and Form derivative
 *
 * In this example it is also shown how to validate
 * the widget form before saving the data to the database.
 *
 * The class naming system can follow the VTCore autoloader
 * class naming system.
 *
 * @author jason.xie@victheme.com
 */
class VTCore_MainName_SubName
extends WP_Widget {


  // Always define the widget form default value
  // in one place for easy reading and maintenance
  private $defaults = array();


  // Define the instance variables so we can
  // easily get the instance value in every methods
  // without the need to pass variables around
  private $instance;

  // Define the arguments variables, this is optional
  // since it is very rare that we need to get the arguments
  // beside in the widget final output
  private $args;


  /**
   * Registering widget as WP_Widget requirement
   * This is required by the wordpress WP_widget class.
   */
  public function __construct() {
    parent::__construct(
        'vtcore_mainname_subname', // The actual class name
        'Example Widgets', // The widget human friendly name
        array('description' => 'Howdy this is an example widget') // some description for the widget
    );
  }



  /**
   * Registering widget
   * This is the callback that we going to call in the
   * initialization class
   */
  public function registerWidget() {
    // Use the actual widget class name
    return register_widget('vtcore_mainname_subname');
  }



  /**
   * Extending widget.
   *
   * This method will be invoked when Wordpress is printing
   * the widget output.
   *
   * @see WP_Widget::widget()
   */
  public function widget($args, $instance) {

    // You can load VTCore Assets by invoking the VTCore_Wordpress_Utility::loadAsset(assetname)
    // directly here. Don't use the loadFrontAsset() method, it will not work properly
    // due to the late binding.
    VTCore_Wordpress_Utility::loadAsset('some-asset-name');


    // Inject the argument into the class global variables
    $this->args = $args;

    // Merge the defaults and the configured instance and then inject
    // the variable back to the class global variable.
    $this->instance = VTCore_Utility::arrayMergeRecursiveDistinct($instance, $this->defaults);


    // Applying filters for title
    $title = apply_filters( 'widget_title', $instance['title'] );


    // Always print the before widget argument since theme may use
    // this to alter the HTML output.
    echo $this->args['before_widget'];


    // Print the title with the before and after title arguments
    if (!empty($title)) {
      echo $this->args['before_title'] . $title . $this->args['after_title'];
    }


    // Perform the logic for printing the widget output here!
    $output = new VTCore_Html_Element(array(
      'type' => 'div',
      'text' => __('Hey I am a widget!'),
    ));
    $output->render();

    // render the closing after widget arguments
    echo $args['after_widget'];
  }



  /**
   * Widget configuration form.
   *
   * Building the widget configuration form.
   * This method will be called by WordPress to render
   * the actual widget configuration form.
   *
   * We are going to use this as the gateway to process
   * the widget and validating them.
   *
   * @see WP_Widget::form()
   */
  public function form($instance) {

    // Load any neccessary assets from VTCore assets folder
    // Note, use the loadAsset method instead of the loadAdminAsset method
    // due to the late binding.
    VTCore_Wordpress_Utility::loadAsset('some-asset-name');

    // Merge in the default and inject the merged value back to
    // class global variable.
    $this->instance = VTCore_Utility::arrayMergeRecursiveDistinct($instance, $this->defaults);

    // Building the form
    $this
      ->buildForm() // build the form object by calling extra method, the method must return the form object
      ->processForm() // call VTCore method for processing form against $_POST
      ->processError(true) // Process the errors and generate the error notice markup if available
      ->render(); // Render the form

  }



  /**
   * Function for building the form object
   *
   * Make this function private so it cannot be called
   * directly from outside.
   */
  private function buildForm() {

    // Creating form using Bootstrap Form object
    // Notice that we are calling BsInstance with type as false
    // for creating dummy form element. this is required to allow
    // us process the form using processForm method while
    // not printing the <form> tag
    $widget = new VTCore_Bootstrap_Form_BsInstance(array(
      'type' => false,
    ));

    $widget

      // For testing, set the validation for required (non empty value)
      ->BsText(array(
        'text' => __('Title'),
        'description' => __('some title anyone?'),
        'name' => $this->get_field_name('title'),
        'id' => $this->get_field_id('title'),
        'value' => $this->instance['title'],
        'required' => true, // Bootstrap form instance will set the non empty validation automatically
      ))

      // This method will automatically set the validation for numerical input only
      ->BsNumber(array(
        'text' => __('Number only please'),
        'description' => __('dude, only number is allowed'),
        'name' => $this->get_field_name('number'),
        'id' => $this->get_field_id('number'),
        'value' => $this->instance['number'],
      ))

      // Example for setting custom validation
      // The key name for the validation must be an actual valid validator type class name
      // the message can be anything.
      ->BsText(array(
        'text' => __('Custom Validation', 'victheme_core'),
        'description' => __('oh my god, custom validation?'),
        'name' => $this->get_field_name('custom'),
        'id' => $this->get_field_id('custom'),
        'value' => $this->instance['custom'],
        'validation' => array(
          'alphanumeric' => __('Only Alpha numeric allowed'), // Example of setting custom validation
        ),
      ));


    // We must return the widget object so it can be chained with other process
    return $widget;
  }




  /**
   * Widget update function.
   *
   * This function is the method called when Wordpress trying to
   * save the widget configuration to database.
   *
   * Return false if validation failed and you can do some
   * sanitation before passing the data back to database.
   *
   * @see WP_Widget::update()
   */
  public function update($new_instance, $old_instance) {

    // Rebuild the form back for retrieving validation errors
    // Glad that we build the form in separate method so
    // it is now able to be detached easily.
    $form = $this->buildForm()->processForm()->processError();

    // Retriving error messages
    $errors = $form->getErrors();

    // Check if we got no errors so it is safe to
    // save the data back to database
    if (empty($errors)) {

      // Optionally you can process the data first like
      // sanitizing user input before passing the
      // value back to wordpress for database saving.

      return $new_instance;
    }


    // Always return false to stop wordpress from saving
    // value that doesn't pass validation.
    return false;
  }

}






/**
 * Example for booting up Widgets
 * You may wish to encapsulate this inside an init class
 *
 * @author jason.xie@victheme.com
 */
class Example_Init {

  // Simplest way to register available widget
  // is just by defining variables with class name or
  // partial class name.
  // More advanced way can be searching a folder directory
  // for directory name and match it against available classes
  private $widgets = array(
    'subname'
  );

  public function __construct() {

    // Booting widgets
    foreach ($this->widgets as $key => $name) {
      $widget = 'VTCore_MainName_' . ucfirst($name);

      // Invoking the action needed to register the widget and
      // point wordpress to registerWidget method as we created before.
      add_action('widgets_init', array(new $widget(), 'registerWidget'));
    }


  }
}



