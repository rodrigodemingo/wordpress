<?php
/**
 * Class for building the main form wrapper.
 *
 * This class must be called instead of VTCore_Form_Base()
 * when building a form, and vice versa when building a Form
 * Elements.
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Form_Instance
extends VTCore_Form_Base {

  protected $context = array(
    'type' => 'form',
    'attributes' => array(
      'action' => '',
      'method' => 'post',
      'autocomplete' => 'off',
    ),
    'processors' => array(
      'post' => 'VTCore_Form_Post',
    ),
    'post' => false,
  );

  private $processors = array();
  private $errors = array();
  private $validatorLimit = array(
    'max',
    'min',
    'maxlength',
    'minlength',
  );



  /**
   * Overriding parent method.
   */
  public function __construct($context = array()) {

    // Build the object, some class
    // will override this method for
    // their own special object init
    $this->buildObject($context);

    // Inject attributes
    if (isset($context['attributes'])) {
		  $this->addAttributes($context['attributes']);
    }


    // Allow user to inject different multiple
    // processor from context
    if ($this->getContext('processors')) {
      foreach ($this->getContext('processors') as $type => $class) {
        if (class_exists($class, TRUE)) {
          $this->addProcessor($type, new $class());
        }
      }
    }
      // Allow user to inject post value outside of
      // $_POST array
      if ($this->getContext('post')) {
        $this->getProcessor('post')->setPost($this->getContext('post'));
      }

  }


  /**
   * Retrieving post value processor
   */
  public function getProcessor($type) {
    return $this->processors[$type];
  }

  public function addProcessor($type, $object) {
    $this->processors[$type] = $object;
    return $this;
  }

  public function getErrors() {
    return (empty($this->errors)) ? NULL : $this->errors;
  }

  public function getError($name) {
    return (isset($this->errors[$name])) ? $this->errors[$name] : NULL;
  }

  public function setError($name, $message) {
    $this->errors[$name] = $message;
  }




  /**
   * Processing Form Elements and it children recursively for
   * validation against the $_POST value using rules set in
   * each children elements.
   *
   * This function will also update the children value based
   * on the value found in $_POST.
   *
   * Sanitazion should be performed in the build HTMl function
   * or in the post class processor.
   *
   * All validation rules should be registered in the children
   * object via $context when registering the object into
   * the Form main object.
   *
   *
   * @todo examine this further! suspect has bug in multiple select value or
   *       weird html's entry from text area and validation need real test!.
   */
  public function processForm() {
    $post = $this->getProcessor('post');

    $elements = $this->getFormElementForValidation();

    foreach ($post->getProcessedPost() as $name => $value) {

      if (!isset($elements[$name])) {
        continue;
      }

      $object = $elements[$name];

      $validators = $object->getValidators();
      $values = (array) $post->findProcessedPost($name);

      if ($validators !== NULL) {
        foreach ($validators as $validator) {

          // Add extra limits to the validator object
          foreach ($this->validatorLimit as $limit) {
            if ($object->getAttribute($limit) !== NULL
              && get_class($validator) == 'VTCore_Validator_' . $limit) {
              $validator->setLimit($object->getAttribute($limit));
            }
          }

          // Looping value needed due to compensate with array values
          foreach ($values as $value) {
            $validator->setText($value);

            if ($validator->validateText() === FALSE) {
              $this->setError($name, $validator->getError());
            }
          }
        }
      }

      // Checkbox, radio and hidden shouldn't change its value
      if ($object instanceof VTCore_Form_Hidden) {
        continue;
      }

      if ($object instanceof VTCore_Form_Checkbox
          || $object instanceof VTCore_Form_Radio) {

        $object->addAttribute('checked', ($value == $object->getAttribute('value')));
        continue;
      }

      $object->setValue($value);
    }

    return $this;
  }





  /**
   * Filtering out all elements that is not considered
   * to be eligible for form validation.
   *
   * Custom grouped element can utilize this by specifying
   * processor => manual and name => name as form field name
   * and override the setValue() method to assign the values
   * to the right actual child field element.
   *
   * @note this is important for performance reason against
   *       direct using of findChildren() method on a very
   *       large form.
   *
   * @return array of objects
   */
  public function getFormElementForValidation() {
    $elements = array();
    $iterators = new RecursiveIteratorIterator(new VTCore_Html_Iterators($this), RecursiveIteratorIterator::SELF_FIRST);
    foreach ($iterators as $object) {

      // Only grab the input, select, textarea and processor => manual entry
      // skipping hidden, submit and all other elements.
      if (in_array($object->getType(), array('input', 'select', 'textarea'))
          && !in_array($object->getAttribute('type'), array('hidden', 'submit'))
          || $object->getContext('processor') == 'manual') {

        // Manual grouped element cannot have
        // name attribute, switching to context
        $key = $object->getAttribute('name');
        if ($object->getContext('processor') == 'manual') {
          $key = $object->getContext('name');
        }

        // Avoid double element, this can occurs
        // in the grouped element
        if (!isset($elements[$key])) {
          $elements[$key] = $object;
        }
      }
    }

    return $elements;
  }
}