<?php
/**
 * Class for building the bootstrap form wrapper.
 *
 * This class must be called instead of VTCore_Form_Instance()
 * when building a form that supports bootstrap form elements
 *
 * @author jason.xie@victheme.com
 * @see VTCore_Html_Form
 *
 * @method BsText() Method for building input text object
 * @method BsTextarea() Method for building textarea object
 * @method BsCheckbox() Method for building checkbox element
 * @method BsSelect() Method for building select element
 * @method BsRadio() Method for building radio element
 * @method BsColor() Method for building color element with color picker
 * @method BsDescription() Method for building form element description box
 * @method BsGlyphicon() Method for building glyphicon element
 * @method BsNumber() Method for building number HTML5 element
 * @method BsPrefix() Method for building form item prefix element
 * @method BsSubmit() Method for building submit button element
 * @method BsUrl() Method for building url HTML5 element
 */
class VTCore_Bootstrap_Form_BsInstance
extends VTCore_Form_Instance {

  protected $overloaderPrefix = array(
    'VTCore_Bootstrap_Form_',
    'VTCore_Bootstrap_Element_',
    'VTCore_Bootstrap_Grid_',
    'VTCore_Form_',
    'VTCore_Html_',
  );




  /**
   * Processing form and build the error message
   * if the form has errors.
   *
   *
   * @param string $inline
   *     Prepend the error element in the form element if set to true
   *     or pool up the error element and don't print them at all
   *     allowing user to get the error objects and place them in
   *     custom entry point.
   *
   * @param string $feedback
   *     Enable or disable bootstrap feedback element, which adds
   *     an icon that can dismiss the error element.
   *
   * @return VTCore_Bootstrap_Form_BsInstance
   */
  public function processError($inline = FALSE, $feedback = FALSE) {

    if ($this->getErrors() == NULL) {
      return $this;
    }

    $groups = array_merge($this->findChildren('attributes', 'class', 'form-group'), $this->findChildren('attributes', 'class', 'input-group'));

    foreach ($this->getErrors() as $name => $message) {

      foreach ($groups as $delta => $object) {

        $element = $object->findChildren('attributes', 'name', $name);

        if (empty($element)) {
          continue;
        }

        $object->addClass($object->getErrorContext('errorClass'));

        // Build the feedback icons
        if ($feedback) {

          foreach ($element as $element_id => $elementObject) {

            $object->addClass('has-feedback');

            // Bootstrap input group can't handle feedback
            if ($object->hasClass('input-group')) {
              continue;
            }

            $feedObject = new VTCore_Bootstrap_Element_BsGlyphicon(array(
              'icon' => $object->getErrorContext('feedbackIcon'),
              'attributes' => array(
                'class' => array(
                  'glyphicon',
                  'form-control-feedback'
                ),
              ),
              'data' => array(
                'target' => $elementObject->getAttribute('id'),
              ),
            ));

            $object->insertChildrenAfter($elementObject->getMachineID(), $feedObject->getMachineID(), $feedObject);
          }
        }

        // Build the inline message here
        if ($inline) {
          $object
            ->prependChild(new VTCore_Bootstrap_Element_BsAlert(array(
              'text' => $message,
              'class' => array($object->getErrorContext('messageClass')),
            )));
        }

        $object = NULL;
        unset($object);
      }
    }

    return $this;

  }



  /**
   * Retrieve the error object per context.
   */
  protected function getErrorContext($type) {
    return $this->errorsContext[$type];
  }


}