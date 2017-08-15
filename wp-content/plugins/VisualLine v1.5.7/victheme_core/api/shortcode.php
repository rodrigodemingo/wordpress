<?php

die('No Direct access allowed.');

/**
 *
 * Example class for showing how to add new
 * shortcode via VTCore shortcode main class.
 *
 * Adding a new shortcode class process :
 *
 * 1. Add the new shortcode base into $shortcode either directly via this class
 *    or do it via WordPress filter VTCore_register_shortcode.
 * 2. If the subclasses have different naming convention other than VTCore_Wordpress_Shortcodes_
 *    then it must register the overloader naming via $overloaderPrefix or via
 *    WordPress filter VTCore_register_shortcode_prefix.
 * 3. The shortcode subclass must handle its own autoloading mechanism if it is not
 *    using the VTCore autoloading class.
 *
 *
 * the "Example" is the actual shortcode tags.
 * in this example the valid tags will be :
 *
 * [example]some content[/example]
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Shortcodes_Example
extends VTCore_Wordpress_Models_Shortcodes 
implements VTCore_Wordpress_Interfaces_Shortcodes {
  
  /**
   * Define the data array that will be automatically converted
   * into html data-* property.
   * 
   * @note html data-* property doesn't allow camel case so
   *       only use this array if the jQuery plugin options
   *       setting can understand data-* and use non camel case
   *       option key.
   *       
   */
  protected $data = array(
    'keyone' => 'value',
  ); 
  
  
  
  /**
   * Define the data key that should preserve the camel case.
   * This is useful if combined with the $settings array and
   * for easily moving the settings from PHP into jQuery with $.data('settings');
   */
  protected $camelcase = array(
    'keyOne', 'preserveCamelCase',
  );
  
  
  
  /**
   * Define the key from atts that will be merged into a single
   * data-settings property in form of json format. this is 
   * useful if jQuery plugin has camelCase as the key for the
   * options or if it doesn't understand how to use data-* natively.
   */
  protected $settings = array(
    'keyOne',
  );
  
  
  
  
  /**
   * Extending parent method.
   * 
   * You can preprocess the $atts & $content property
   * in this method.
   * 
   * This method will be called by the parent class
   * last after all of the process method is called.
   * 
   * 
   * @see VTCore_Wordpress_Models_Shortcodes::processCustomRules()
   */
  protected function processCustomRules() {
    
    // Example of moving defined atts into other atts key.
    if (isset($this->atts['alert_type'])) {
      $this->atts['alert-type'] = $this->atts['alert_type'];
      unset($this->atts['alert_type']);
    }
  
    // Example of injecting the content into text atts
    // as some of the Html subclass needed.
    if ($this->content) {
      $this->atts['text'] = do_shortcode($this->content);
    }
  }

  
  
  
  
  
  /**
   * This method must be available on the subclass
   * for creating the actual object for building the
   * shortcode html markup.
   * 
   * $this->atts is the WordPress shortcode API $atts and
   * has been processed by the parent class for automatic
   * attributes buidling for :
   * 
   * class - any shortcode with class="" will be processed as
   *         $this->atts['attributes']['class'] = array or classes
   *         
   * data - any subclass that define $data property will have its
   *        array content processed into $this->atts['data']['datakey'] 
   *        and $this->atts['attributes']['data-datakey']
   *        
   * camelcase - any subclasses that define $camelcase property will
   *             have its array key transformed into camel case as
   *             some jQuery plugin need camelcase like : camelcase="sometext"
   *             will be transformed into $this->atts['camelCase'] if user
   *             define $camelcase = array('camelCase');
   *             
   * settings - any subclasses that define settings array will have the
   *            $settings key to be merged into one data array with json
   *            content such as $settings = array('keyone', 'keytwo') with
   *            user shortcode of keyone="valueone" keytwo="valuetwo" then
   *            it will have $this->atts['data']['settings'] = { "keyone" : "valueone"; "keytwo" => 'valuetwo"; };
   *            user then can use jQuery to get the data like :
   *            $('.selector').data('settings'); and jQuery will automatically
   *            parse the string and convert it into json object.
   *            
   *            
   * Although you can still process the $atts and $content in this method
   * it is highly discouraged and better to use the processCustomRules method
   * instead.
   *             
   * @see VTCore_Wordpress_Models_Shortcodes()
   */
  public function buildObject() {

    // Build the VTCore HTML object (or its subclasses object)
    // and store it to the VTCore shortcode base class $object property
    // for processing later.
    $this->object = new VTCore_Html_Element($this->atts);


    // You can still modify the object since it will not be processed
    // until it exited this construct method.
    // All the HTML object method can be applied to this object
    // @see html_base() class for more object method.
    $this->object->addChildren(do_shortcode($this->content));
  }
  
  
}