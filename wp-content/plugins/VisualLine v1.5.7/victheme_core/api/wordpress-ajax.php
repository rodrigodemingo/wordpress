<?php

die('No direct access allowed');


/**
 * Example file for utilizing VTCore_Wordpress Ajax API.
 *
 * The Ajax API will hook into Wordpress AJAX action :
 *
 * wp_ajax_vtcore_ajax_framework
 * - This hook is for all the admin page ajax callback request
 * - Utilizes VTCore_Wordpress actions system
 * - The hook file is wp_ajax_vtcore_ajax_framework.php
 * - The hook class is VTCore_Wordpress_Actions_Wp__Ajax__Vtcore__Ajax__Framework
 * - The hook class will initializes the ajax router by calling the VTCore_Wordpress_Ajax_Router_Admin
 *   class and processing the request validation and invoke the callback class
 *
 * wp_ajax_nopriv_vtcore_ajax_framework
 * - This hook is for all the front end (including the login page) ajax callback request
 * - Utilizes VTCore_Wordpress actions system
 * - The hook file is wp_ajax_nopriv_vtcore_ajax_framework.php
 * - The hook class is VTCore_Wordpress_Actions_Wp__Ajax__Nopriv__Vtcore__Ajax__Framework
 * - The hook class will initializes the ajax router by calling the VTCore_Wordpress_Ajax_Router_Anon
 *   class and processing the request validation and invoking the callback class
 *
 * The Ajax triggering will be invoked from the wp-ajax assets.
 */


/**
 * Triggering Elements
 *
 * In order to invoke the ajax framework function, it is required to build the correct triggering
 * element that has the correct HTML5 data-* attributes.
 *
 * It can be a button, input submit or any elements.
 *
 * Required data-* attributes
 *    ajax-mode : post | data | both | trigger | value
 *                post    - this mode will retrieve the parent element (must be a form) post data, serialized
 *                          serialized it and convert into an url parameters
 *                data    - this mode will just retrieve the element html5 data-* attributes, serialized it and
 *                          convert it into url parameters
 *                both    - this mode will retrieve both parent element post and element data attributes,
 *                          merged them, serialized it and convert to url parameters.
 *                trigger - this mode will retrieve the data-ajax-trigger on selected target
 *                value   - this mode will retrieve the value of the selected target using jQuery .val() method.
 *
 *    ajax-target : CSS selector - recommended to use id such as '#someid', this is the target parent
 *                  used to determine the target point for fetching post or modifying the content
 *
 *    ajax-loading-text : string - this string will be shown in the button or input submit element when
 *                                 an ajax event is processing
 *
 *    ajax-object : valid PHP object name - this object will be invoked when an ajax request is made, it must
 *                                          be a valid php object that also been registered via autoloader
 *                                          the script will not attempt to look for the class file, it will
 *                                          just initializes the class.
 *
 *    ajax-action : the nonce key - by default it will use 'vtcore-ajax-framework' unless you have change
 *                                  the default nonce key, no need to change this.
 *
 *    ajax-queue : array - you can use queueing system to queue the ajax process and pass the value
 *                 name to act as triggering marker one by one in the array. The array will be converted into
 *                 a json object via VTCore_Html base data-* processor.
 *
 *    ajax-value : array - you can pass custom data by adding the value into the ajax-value as an array.
 *    ajax-marker : array - you can pass custom data so other javascript can pick it up using the jQuery ajaxComplete events under
 *                  the settings variables.
 *
 *    ajax-group : you can make several buttons to act as a group of button that will be disabled together
 *                 when a single button in the group is performing ajax request. all the group items
 *                 must share the same value for the data-ajax-group property.
 *
 *    nonce : You can pass the nonce key in the data-nonce if the ajax caller element is not a form elements
 *
 */

// Example Valid Form with triggering button for ajax
class Ajax_Driven_Page {

  private $form;
  private $post;

  public function buildForm() {

    // Load ajax assets
    VTCore_Wordpress_Utility::loadAsset('wp-ajax');

    // Building the Form element
    $form = new VTCore_Bootstrap_Form_BsInstance(array(
      'attributes' => array(
        'id' => 'this-is-the-target',
        'method' => 'post',
        'action' => $_SERVER['REQUEST_URI'],
      ),
    ));

    // By default VTCore Form System will retrieve
    // value from $_POST for updating, validating and sanitizing
    // the form value. but in AJAX case, the post value is passed
    // as a URL encoded string (for bypassing PHP max_input_vars limitation)
    // thus we need to tell VTCore Form about the post value manually here.
    //
    // @see VTCore_Form_Instance()
    if (!empty($this->post)) {
      $form->getProcessor('post')->setPost($this->post);
    }


    // Injecting example form input
    $form->BsText(array(
      'name' => 'just-a-test',
      'text' => 'Test Text',
      'description' => 'This is just an example.',
      'value' => 'some-value',
    ));


    // Injecting the Ajax Triggering element
    $form

      // We need the nonce field for Validating purposes
      // Without this field (if build as input submit element)
      // ajax will always return false
      ->WpNonce(array(
        'action' => 'vtcore-ajax-nonce-admin',
      ))

      // We build the triggering element as an input submit
      // thus we need the wp nonce field
      // the btn-ajax class is required for binding the javascript
      ->Submit(array(
        'attributes' => array(
          'name' => 'trigger-as-input',
          'value' => 'trigger this input',
          'class' => array('btn', 'btn-primary', 'btn-ajax'),
        ),
        'data' => array(
          'ajax-mode' => 'post',
          'ajax-target' => '#this-is-the-target',
          'ajax-loading-text' => 'example of processing message',
          'ajax-object' => 'Ajax_Driven_Page',
          'ajax-action' => 'vtcore_ajax_framework',
          'ajax-queue' => array('trigger-as-input'),
        ),
      ))

      // Build the triggering as a button, notice that we need extra
      // data-nonce for this element nonce.
      // the btn-ajax class is required for binding the javascript
      ->Button(array(
        'attributes' => array(
          'name' => 'trigger-as-input',
          'value' => 'trigger this input',
          'class' => array('btn', 'btn-primary', 'btn-ajax'),
        ),
        'data' => array(
          'nonce' => wp_create_nonce('vtcore_ajax_framework'),
          'ajax-mode' => 'post',
          'ajax-target' => '#this-is-the-target',
          'ajax-loading-text' => 'example of processing message',
          'ajax-object' => 'Ajax_Driven_Page',
          'ajax-action' => 'vtcore_ajax_framework',
          'ajax-queue' => array('trigger-as-input'),
        ),
      ));

  }

  /**
   * This method will be invoked when the ajax request
   * is made to the server.
   *
   * Notice in the triggering element that we defined the
   * same class name as for both the processing and triggering
   * element. It is not required to do so, it is just for
   * simplification sake.
   *
   *
   * The $post will contain the data that the ajax caller
   * posted. The array will contain of :
   *
   *   action : the action name as specified in data-ajax-action
   *   data   : the content data fetched by the data-ajax-mode, the data
   *            is already uncompressed back to a normal array by
   *            VTCore_Wordpress_Ajax_Router_Base::convertPost()
   *   nonce  : the nonce value, used by the Router classes to validate
   *   value  : the triggering value as specified data-ajax-queue single entry.
   *
   *
   * You will need to use this following Array structure for
   * returning the value back to ajax.
   *
   * // Sample for error message
   * $retunedData['action'][] = array(
   *   'mode' => 'error',
   *   'target' => '#example-css-id-selector',
   *   'content' => 'example of some markup as error message',
   * );
   *
   * // Sample for replacing a content
   * $retunedData['action'][] = array(
   *   'mode' => 'replace',
   *   'target' => '#example-css-id-selector',
   *   'content' => 'this is a replacement content',
   * );
   *
   *
   * // Sample for appending a content
   * $retunedData['action'][] = array(
   *   'mode' => 'append',
   *   'target' => '#example-css-id-selector',
   *   'content' => 'this markup will be appended to the target',
   * );
   *
   * // Sample for prepending a content
   * $retunedData['action'][] = array(
   *   'mode' => 'prepend',
   *   'target' => '#example-css-id-selector',
   *   'content' => 'this markup will be prepended to the target',
   * );
   *
   *
   * // Sample for emptying a content
   * $retunedData['action'][] = array(
   *   'mode' => 'empty',
   *   'target' => '#example-css-id-selector',
   * );
   *
   *
   * // Sample for calling custom function
   * $retunedData['action'][] = array(
   *   'mode' => 'callback',
   *   'content' => 'alert("hi, i'm a callback");',
   * );
   *
   * // Sample for modifying data-* attributes
   * $retunedData['action'][] = array(
   *   'mode' => 'data',
   *   'content' => 'some new content for the data-tester',
   *   'key' => 'tester,
   *   'target' => '#example-css-id-selector',
   *   'merge' => true | false // merge the old value
   * );
   *
   *
   * // Sample for adding new class
   * $retunedData['action'][] = array(
   *   'mode' => 'addClass',
   *   'content' => 'some valid css class',
   *   'target' => '#example-id'
   * );
   *
   *
   *
   * // Sample for removing class
   * $retunedData['action'][] = array(
   *   'mode' => 'removeClass',
   *   'content' => 'some valid css class',
   *   'target' => '#example-id'
   * );
   *
   *
   */
  public function renderAjax($post) {

    // Let us inject back the value for the post
    $this->post = $post['data'];

    // Rebuilding the form back
    $this->buildForm();

    // Returning the content using the
    // VTCore Ajax Api format
    return array(
      'action' => array(

        // First action we ask the API to perform
        array(

          // We ask the API to replace the content
          'mode' => 'replace',

          // The target content to be replaced ID
          'target' => '#this-is-the-target',

          // The new Markup for replacement
          'content' => $this->form->__toString()  ,
        ),


        // We can ask the API to perform another task
        array(

          // Prepend the content before the target
          'mode' => 'prepend',

          // The target to prepend
          'target' => '#this-is-the-target',

          // The Markup
          'content' => 'Doh! Ajax were performed and this is prepended',
        ),

      ),
    );

  }
}

