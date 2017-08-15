<?php
die('No Direct access allowed.');

/**
 * Example on how to use the cssbuilder objects
 *
 * The CSSBuilder Classes is not meant to replace the use
 * of CSS or LESS. The classes purposes is to generate
 * dynamic CSS easily and can store css rules in PHP arrays or
 * object.
 */

// Create new CSS Block and define the selectors as an array
$css = new VTCore_CSSBuilder_Factory(array(
  '#header', '#body', '.content'
));

$css

  // Add border with border short method
  // @see VTCore_CSSBuilder_Rules_Border()
  ->Border(array(
    'width' => '1px',
    'style' => 'solid',
    'color' => 'gold',
    'radius' => '3px',
  ))

  // Add background rule with background short method
  // @see VTCore_CSSBuilder_Rules_Background()
  ->Background(array(
    'color' => '#123456',
    'image' => 'http://someimace.com/image.png',
    'position' => 'top left',
    'repeat' => 'no-repeat',
    'size' => '100% auto',
    'attachment' => 'fixed',
  ))

  // Now it supports multiple image as CSS3 rules
  ->Background(array(
    'color' => '#123456',
    'image' => array(
      'http://someimace.com/image.png',
      'http://someimace.com/image2.png',
      'http://someimace.com/image3.png',
    ),
    'position' => array(
      'top left',
      '200px 0px',
      'bottom right',
    ),
    'repeat' => array(
      'no-repeat',
      'repeat-x',
      'repeat',
    ),
    'size' => array(
      '100% auto',
      '100% auto',
      'contain'
    ),
    'attachment' => array(
      'fixed',
      'scroll',
      'inherit',
    ),
  ))

  // Add font with font short method
  // @see VTCore_CSSBuilder_Rules_Font()
  ->Font(array(
    'color' => 'green',
    'size' => '13px',
    'weight' => 'bold',
  ))

  // Freely adding the css rules as normal css code using the
  // Abstract short method
  // @see VTCore_CSSBuilder_Rules_Abstract()
  ->Abstract(array(
    'position' => 'absolute',
    'top' => '10px',
    'left' => '20px',
    'margin-top' => '30px',
  ))

  // Add New margin using margin short method
  // @see VTCore_CSSBuilder_Rules_Margin()
  ->Margin(array(
    'top' => '10px',
  ))

  // Add new padding using padding short method
  // @see VTCore_CSSBuilder_Rules_Padding()
  ->Padding(array(
    'top' => '10px',
  ))

  // Add positioning rules using position short method
  // @see VTCore_CSSBuilder_Rules_Position()
  ->Position(array(
    'position' => 'absolute',
    'top' => '30px',
  ))

  // Add animation rules using animation short method
  // @see VTCore_CSSBuilder_Rules_Animation()
  ->Animation(array(
    'name' => 'tester',
    'duration' => '10s',
  ))

  // Echo the result or use __toString() to return the value.
  ->render();


/**
 * Example on creating new CSSBuilder Rules
 *
 * Create a new File in the cssbuilder/rules folder
 * (or other folder if you able to make it autoload
 * when the class is called)
 *
 * in this example we use Example as the short overloading
 * method. thus the file name must be example.php and the
 * class name must be VTCore_CSSBuilder_Rules_Example.
 *
 */
class VTCore_CSSBuilder_Rules_Example
extends VTCore_CSSBuilder_Rules_Base
implements VTCore_CSSBuilder_Rules_Interface {

  // This must be defined and unique related to
  // other rule class. Since the value will be used
  // as the array keys. non unique value will get
  // overridden.
  protected $type = 'example';


  // This method must exists and used to convert
  // user $context configuration into valid
  // css style rules.
  public function buildRule() {

    // This is the easiest method, the $context
    // property will hold user configuration
    // and this simple function will convert the
    // configuration array into valid css rule.
    // You must store the converted valid css rule
    // as an array entry in the $rules property.
    // The factory class will process the $rules
    // property when rendering as string.
    foreach ($this->context as $key => $value) {
      $this->rules[] = $key . ': ' . $value;
    }

  }
}




/**
 * Example of creating css keyframes rules.
 *
 */

// Create the object and insert the animation name
$keyframe = new VTCore_CSSBuilder_Keyframe('animation_name');

// Process the object
$keyframe

  // AddFrame method must be invoked first to mark the frame
  // percentage stage.
  ->addFrame('0')

  // All CSSBuilder Rules can be applied afterwards, and will be injected
  // to frame 0%
  ->Margin(array(
    'top' => '0'
  ))

  // Add another frame and move the object pointer to new frame
  ->addFrame('10')

  // This Rules will be applied to frame 10%
  ->Margin(array(
    'top' => '0'
  ))

  // Use render() to echo the output or __toString() to return the output.
  ->render();


/**
 * Example on using the VTCore_CSSBuilder_Factory::buildStyle();
 *
 * The method only care for the selectors key and rules key
 * the other keys (eg. title in this case) can be used
 * for other purposes (eg. when building a configuration form for it).
 */
$styles = array(
  'topheader' => array(
    'title' => 'some title',
    'description' => 'some description',
    'selectors' => array(
      '#topheader',
      '#topheader a',
      '#header'
    ),
    'rules' => array(
      'abstract' => array(
        'position' => 'absolute',
        'top' => '10px',
        'left' => '20px',
        'margin-top' => '30px',
      ),
      'background' => array(
        'color' => '#123456',
        'image' => 'http://someimace.com/image.png',
        'position' => 'top left',
        'repeat' => 'no-repeat',
        'size' => '100% auto',
      ),
      'keyframe' => array(
        'name' => 'myanimation',
        'frames' => array(
          '100%' => array(
            'margin' => array(
              'top' => '10px',
              'left' => '10px',
            ),
            'background' => array(
              'position' => '100% 100%, 100% 100%'
            ),
          ),
        ),
      ),
      'animation' => array(
        'name' => 'tester',
        'duration' => '10s',
      ),
    ),
   ),
);

$style = new VTCore_CSSBuilder_Factory();
$style->buildStyles($styles);
$style->render();