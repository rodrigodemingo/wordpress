<?php

/**
 * Bootstrap Form Base, the superclass for building the
 * Bootstrap compatible form with its element.
 *
 * The difference between this and the form base is
 * this form added several automatic processor for
 * assigning context from the wrapper context into the
 * actual input element context and additional processor
 * for handling the form value as well.
 *
 * @method string BsCheckbox() Method for building checkbox element
 * @method string BsColor() Method for building color element
 * @method string BsDescription() Method for building description element
 * @method string BsGlyphicon() Method for building glyphicon element
 * @method string BsInstance() Method for building Form instance element
 * @method string BsNumber() Method for building input number element
 * @method string BsPrefix() Method for building prefix element
 * @method string BsRadios() Method for building radio element
 * @method string BsSelect() Method for building select element
 * @method string BsSuffix() Method for building suffix elementt
 * @method string BsText() Method for building input text object
 * @method string BsTextarea() Method for building textarea object
 * @method string BsUrl() Method for building Url input element
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Bootstrap_Form_Base
  extends VTCore_Form_Base {

  protected $overloaderPrefix = array(
    'VTCore_Bootstrap_Form_',
    'VTCore_Bootstrap_Element_',
    'VTCore_Bootstrap_Grid_',
    'VTCore_Form_',
    'VTCore_Html_',
  );

  private $shortcutAttributes = array(
    'required',
    'size',
    'maxlength',
    'placeholder',
    'name',
    'value',
    'id',
    'class',
    'cols',
    'rows',
    'size',
    'multiple',
    'min',
    'max',
    'step',
    'checked',
    'disabled',
    'autocomplete',
  );

  // Default error context for building bootstrap form error element
  protected $errorsContext = array(
    'errorClass' => 'has-error',
    'feedbackIcon' => 'remove',
    'messageClass' => 'alert-danger',
  );

  /**
   * Constructing the object and processing
   * the context array
   */
  public function __construct($context = array()) {
    $this->buildObject($context);
    $this->assignContext();
    $this->buildElement();
    $this->buildValidator();
  }


  protected function changeClass($old, $new) {
    $context = $this->getContext('attributes');

    if (isset($context['class'])) {
      foreach ($context['class'] as $key => $class) {
        if ($class == $old) {
          unset($context['class'][$key]);
          $context['class'][] = $new;
        }
      }
    }

    $this->context['attributes']['class'] = $context['class'];

    return $this;
  }


  protected function assignContext() {
    if ($this->getContext('id') == FALSE) {
      $this->setContext(array(
        'id' => 'element-' . $this->getMachineID(),
      ));
    }

    if ($this->getContext('text')) {
      $this->addContext('label_elements.text', $this->getContext('text'));
    }

    if ($this->getContext('prefix')) {
      $this->changeClass('form-group', 'input-group');
      $this->addContext('prefix_elements.text', $this->getContext('prefix'));
    }

    if ($this->getContext('suffix')) {
      $this->changeClass('form-group', 'input-group');
      $this->addContext('suffix_elements.text', $this->getContext('suffix'));
    }

    if ($this->getContext('description')) {
      $this->addContext('description_elements.text', $this->getContext('description'));
    }

    if ($this->getContext('required')) {
      $this->addContext('label_elements.required', $this->getContext('required'));
    }

    if ($this->getContext('label_elements')) {
      $this->addContext('label_elements.attributes.for', $this->getContext('id'));
    }

    if ($this->getContext('label') == FALSE) {
      $this->addContext('label_elements.attributes.class.sr-only', 'sr-only');
    }

    foreach ($this->shortcutAttributes as $key) {
      $value = $this->getContext($key);
      if ($value === NULL) {
        continue;
      }

      if ($key != 'class') {
        $this->addContext('input_elements.attributes.' . $key, $value);
      }
      else {
        foreach ($value as $delta => $class) {
          $this->addContext('input_elements.attributes.class.auto-' . $delta, $class);
        }
      }
    }

    // Processing Grids
    if ($this->getContext('grids')) {
      $grids = new VTCore_Bootstrap_Grid_Column($this->getContext('grids'));
      $this->addClass($grids->getClass());
    }

    // Support for tooltips
    if ($this->getContext('tooltip')) {
      foreach ($this->getContext('tooltip') as $key => $data) {
        $this->addContext('input_elements.data.' . $key, $data);
      }

      $this->addContext('input_elements.data.toggle', 'tooltip');
    }

    // Support for toggle dependency
    if ($this->getContext('dependencies')) {

      if (class_exists('VTCore_Wordpress_Utility')) {
        VTCore_Wordpress_Utility::loadAsset('bootstrap-dependency-toggle');
      }

      $this->addContext('input_elements.data.dependency', $this->getContext('dependencies'));
    }

    // Moving validators to children
    if ($this->getContext('validators')) {
      $this->addContext('input_elements.validators', $this->getContext('validators'));
      $this->removeContext('validators');
    }

  }

  public function getErrorContext($type) {
    return $this->errorsContext[$type];
  }

}