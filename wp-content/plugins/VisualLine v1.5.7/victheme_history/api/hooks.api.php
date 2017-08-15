<?php
/**
 * Example file for showing advanced developer
 * how to alter the VicTheme History via code
 *
 * @prequisite
 *   User must know how to use VicTheme VTCore Object
 *   as the plugin doesn't use normal templating but
 *   instead rely on VTCore Object when building the
 *   markup.
 *
 *   See VTCore API's for more information.
 */

// Don't allow direct access for this file
die('No Direct Access Allowed');


/**
 * Altering the History Wrapper element before it get
 * rendered.
 *
 * At this stage the Core Object Context has already
 * been parsed and processed to build the sub objects
 * as specified in the object logic. Thus it is useless
 * to alter the context, instead alter the built object
 * directly.
 *
 * Method such as findChildren(), removeChildren(), addChildren()
 * can be used to alter the child content.
 *
 * The following example is provided as simple as possible, not
 * to be followed blindly without understanding the actual process.
 *
 * available hooks action :
 *
 * vtcore_history_alter_history_element_object
 *  - action for altering the history element wrapper, you can also
 *    access all the child content via this hook
 *
 * vtcore_history_alter_history_content_object
 *  - action for altering a single history element, you can use
 *    additional shortcut method such as :
 *      - getLeft()
 *          returning the object for left wrapper
 *      - getRight()
 *          returning the object for the right wrapper
 *      - getIcon()
 *          returning the object for icon
 *      - getLabel()
 *          returning the object for label
 *      - getImage()
 *          returning the object for image wrapper
 *
 * @see VTCore_Wordpress_Models_Hooks
 * @see VTCore_Wordpress_Models_Hook
 * @see VTCore_Wordpress_Factory_Actions
 * @see VTCore_Wordpress_Init::getFactory('actions');
 * @see VTCore_History_Element_HsElement
 */




/**
 * Simple normal wordpress way
 */
// Invoke the hooks, you can also use VTCore Object hooks to register
// this hook inside a class.
add_action('vtcore_history_alter_history_element_object', 'myaltering_function');



// The altering function, if you are using VTCore Object Hooks then
// the $object will be available inside the class.
function myaltering_function($object) {
  // do something with $object.
}



/**
 * VTCore integration way
 */
// Booting autoloader, this is a very simple example, the autoloader
// will not return valid path.
// Call this in the myplugin/myplugin.php
$autoloader = new VTCore_Autoloader('VTCore_MyPlugin', dirname(__FILE__));
$autoloader->setRemovePath('vtcore' . DIRECTORY_SEPARATOR . 'myplugin' . DIRECTORY_SEPARATOR);
$autoloader->register();



// When using VTCore instead
// Registering filters
// call this after the autoloader in the myplugin/myplugin.php
VTCore_Wordpress_Init::getFactory('actions')
  ->addPrefix('VTCore_MyPlugin_')
  ->addHooks(array(
    'vtcore_history_alter_history_element_object'
  ))
  ->register();



/**
 * This class must be placed in the correct folder and path as specified in the autoloader
 *
 * example :
 *
 * myplugin/myplugin.php - this is where the autoloader called
 * myplugin/actions/vtcore_history_alter_history_element_object.php - this is where the class should reside
 *
 * Class VTCore_MyPlugin_Actions_VTCore__History__Alter__History__Element__Object
 */
class VTCore_MyPlugin_Actions_VTCore__History__Alter__History__Element__Object {

  public function hook($object) {

    // the $object contains the object markup
    // use the vtcore object method's to alter the object
    // @see VTCore_Html_Base class for methods
    // @see VTCore_History_Element_HsElement for additional methods.

    var_dump($object);

    // Get available childrens
    $children = $object->getChildrens();

    // Find Children with specific id
    $children = $object->findChildren('context', 'attributes.id', 'someid');

    // Processing children
    foreach ($children as $delta => $child) {
      // $child is also VTCORE objects
    }

    // adding children
    $object->addChildren(new VTCore_History_Element_HsInner(array(
      // Inject the context here
      // @see VTCore_History_Element_HsInner for contexes
    )));
  }
}


