<?php

die('No Direct access allowed.');

/**
 * Example class for extending / creating a new Form elements
 * that can be called via VTCore_Form_Base() object or its
 * subclasses.
 *
 * INTERFACE
 * The extender class must extends VTCore_Form_Base and
 * implements the VTCore_Form_Interface interface.
 *
 * TRIGGERING METHOD
 * The triggering method name is taken from the last
 * string after the underscore in the subclass name.
 *
 *   VTCore_Form_{TriggeringMethodName}
 *
 * The triggering method name must not have any extra
 * underscore or spaces in it. Prefered to use camel case.
 *
 * @options Check registerDefaultContext method for all
 *          availale element options.
 *
 * @API valid for API version 1.0
 * @author jason.xie@victheme.com
 * @see VTCore_Form_Interface interface
 */
class VTCore_Form_Example extends VTCore_Form_Base implements VTCore_Form_Interface {

  /**
   * Define the default context array
   */
  protected $context = array(
    // Insert the default context in this array.
  );


  /**
   * Build the elements
   *
   * This is the method where we actually registers the
   * new elements.
   *
   * Never register a html element directly. Html element
   * must be built as an object using the VTCore_Form_Base
   * methods or it subclases.
   *
   * All html element actual tag rendering must be done
   * via VTCore_Form_Base render() method or __toString() method.
   *
   * @see VTCore_Form_Interface::buildElement()
   */
  public function buildElement() {

    // Set the element type
    $this->addType('example');

    // Add the element attributes
    $this->addAttributes(array(
      // Some attributes
    ));

    // Example if we need to add child object
    // to this element
    $object = new VTCore_Form_Base();
    $object->addType('example_child');
    $object->addAttributes(array(
      // Some Attributes
    ));

    // Adding a plaing text as child of subchild
    $object->addText('some text');

    // Inject the child and subchild back to parent
    $this->addChildren($object);

    // No need to echo or print anything, all the
    // actual rendering will be performed by
    // VTCore_Form_Base() when user is invoking
    // the render or __toString method.
  }

}