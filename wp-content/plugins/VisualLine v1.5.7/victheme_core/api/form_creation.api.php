<?php

die ('No direct access allowed');

/**
 * Example on using Form API
 * 
 * In this example will be shown on how to build
 * the form, validate it, get errors and saving it.
 * 
 * @author jason.xie@victheme.com
 */

// Example 1
// Using standard form instance

$form = new VTCore_Form_Instance(array(
  'attributes' => array(
    'action' => $_SERVER['REQUEST_URI'], // or __FILE__ or any valid form action path.
    'id' => 'some-id', // Valid form id
  ),
));

// Example on why the parent instance is important
// when using shortcut method.
//
// This will throw errors because
// VTCore_Form_Instance doesn't understand VTCore_Bootstrap_Form_Instance()
// overloader prefix
// Bootstrap elements, forms and grid class must be invoked
// within Bootstrap parent instance or base
$form
  ->BsText(array(
    'name' => 'someform[nameone]',
    'value' => 'some value for the form',
  ));

// This will not throw error although we are injecting
// the same BsText element because we are not using
// the shortcut method instead injecting the object
// directly by creating the object manually.
$form
  ->addChildren(new VTCore_Bootstrap_Form_BsText(array(
    'name' => 'someform[nameone]',
    'value' => 'some value for the form',
  )));

// This will work properly
$form
  ->Label(array(
    'attributes' => array(
      'for' => 'some-id',
      'text' => 'Some Label',
    ),
   ))
  ->Text(array(
    'attributes' => array(
      'id' => 'some-id',
      'value' => 'some value',
      'name' => 'someform[nameone]',
    ),
  ));


// Defining validation for our form element
$form
  ->Label(array(
    'attributes' => array(
      'for' => 'some-id',
      'text' => 'Some Label for required element',
    ),
  ))
  ->Text(array(
    'attributes' => array(
      'id' => 'some-id',
      'value' => 'some value',
      'name' => 'someform[nameone]',
      'required' => true, // Mark as required
    ),
    
    // All validator setting must be defined inside
    // the $validators array
    'validators' => array(
      
      // The array key is the type of validation
      // check vtcore/validator folder for more 
      // validation type
      // The value is the message to be displayed
      // when validation failed
      'number' => 'only numerical value allowed',
     ),
  ));



// Processing the form
// The suggested build order :
// 1. Build the form objects
// 2. Process the form for validation
// 3. Process the Error message (bootstrap instance only VTCore_Form_Instance don't have this)
// 4. Get the error messages
// 5. Add the error messages to form object (if not using inline error reporting)
// 6. Save the form if no error found
// 7. Render the output.

// Process Form
$form->processForm();

// Get error
$error = $form->getErrors();

// Got error, add the error message to the beginning of the form.
// this is a very simple display, in real life you may need to 
// wrap the error text inside a html object (like bootstrap BsAlert object)
// for better styling.
if (!empty($error)) {
  $form->prependChild($error);
}

// No errors
else {
  // do your saving function here.
}

// Render the form
$form->render();