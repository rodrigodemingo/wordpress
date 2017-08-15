<?php
/**
 * Building form range slider with bootstrap rules
 *
 * Shortcut Method : BsRange($context)
 *
 * Shortcut context available :
 *
 * text          : (string) The text for the Legend element
 * prefix        : (string) Prefix element in front of the text input element
 * suffix        : (string) Suffix element in the end of the text input element
 * description   : (string) Text of decription printed after the input element
 * required      : (boolean) Flag for marking element as required
 * placeholder   : (string) The placeholder text for the input element
 * max           : (numeric) The maximum acceptable value
 * min           : (numeric) the minimum acceptable value
 * step          : (numeric) incremental value
 * name          : (string) The name attributes for the input element
 * value         : (string) The value attributes for the input element
 * id            : (string) The id used for the input element and object machine id
 * class         : (array) Classes used for the input element
 * label         : (boolean) Flag for hiding the label element via CSS
 * togglelabel   : (boolean) set to true to hide the label and show it when input has value
 *
 * usejs         : (boolean) force to build the slider using javascript
 * animate       : (boolean) tell javascript to animate the slider
 * orientation   : (vertical|horizontal) tell javascript to build the slider orientation
 * tooltips      : (boolean) tell javascript to attach tooltips to slide button
 * mintext       : (string) use this to define a "minimum" label, only valid when on
 *                          javascript mode and no text string defined in context
 * maxtext       : (string) use this to define a "maximum" label, only valid when on
 *                          javascript mode and no text string defined in context
 *
 * ranged        : (boolean) build a min and max element when set to true or just
 *                           single element with html5 range element
 * max_elements  : (array) define custom context for max elements, only used if ranged
 *                         is defined as true.
 * min_elements  : (array) define custom context for min elements, only used if ranged
 *                         is defined as true.
 * separator_elements  : (array) define custom context for separator elements, only used if ranged
 *                         is defined as true.
 *
 *
 * @author jason.xie@victheme.com
 * @method BsRange($context)
 * @see VTCore_Html_Form interface
 */
class VTCore_Bootstrap_Form_BsRange
extends VTCore_Bootstrap_Form_Base
implements VTCore_Form_Interface {

  protected $context = array(

    // Shortcut method
    // @see VTCore_Bootstrap_Form_Base::assignContext()
    'text' => false,
    'prefix' => false,
    'suffix' => false,
    'description' => false,
    'required' => false,

    // Min and max must have value for javascript mode
    'max' => false,
    'min' => false,
    'step' => false,

    // Toggle build min and max element
    'ranged' => true,

    // Force to use javascript slider
    'usejs' => true,
    'maxtext' => false,
    'mintext' => false,
    'animate' => true,
    'orientation' => 'horizontal',
    'tooltips' => true,

    'placeholder' => false,
    'name' => false,
    'value' => false,
    'id' => false,
    'class' => array('form-control'),

    // Bootstrap Rules
    'label' => true,

    'togglelabel' => false,

    // Wrapper element
    'type' => 'div',
    'attributes' => array(
      'class' => array('form-group', 'bootstrap-range'),
    ),

    'min_elements' => array(
      'label' => false,
    ),
    'max_elements' => array(
      'label' => false,
    ),
    'separator_elements' => array(
      'type' => 'span',
      'text' => '-',
      'attributes' => array(
        'class' => array(
          'input-group-addon'
        ),
      ),
    ),

    // Internal use, Only override if needed
    'input_elements' => array(),
    'label_elements' => array(),
    'description_elements' => array(),
    'prefix_elements' => array(),
    'suffix_elements' => array(),
    'required_elements' => array(),

  );



  public function buildElement() {


    // Build the min and max label text
    $this->buildRangedText();

    if ($this->getContext('label_elements')) {
      $this->addChildren(new VTCore_Form_Label($this->getContext('label_elements')));
    }

    if ($this->getContext('prefix_elements')) {
      $this->addChildren(new VTCore_Bootstrap_Form_BsPrefix(($this->getContext('prefix_elements'))));
    }

    if ($this->getContext('ranged')) {
      $this->buildRangedElement();
    }
    else {
      $this->addChildren(new VTCore_Form_Range($this->getContext('input_elements')));
    }

    $this
      ->buildRangedJavascriptElement()
      ->addAttributes($this->getContext('attributes'));

    if ($this->getContext('suffix_elements')) {
      $this->addChildren(new VTCore_Bootstrap_Form_BsSuffix(($this->getContext('suffix_elements'))));
    }

    if ($this->getContext('description_elements')) {
      $this->addChildren(new VTCore_Bootstrap_Form_BsDescription(($this->getContext('description_elements'))));
    }

    if ($this->getContext('togglelabel')) {

      if (class_exists('VTCore_Wordpress_Utility')) {
        VTCore_Wordpress_Utility::loadAsset('bootstrap-toggle-label');
      }

      $this->addData('toggle-label', array(
        'parent' => false,
      ));
    }
  }





  /**
   * Build and format the element to suit the ranged slider
   * javascript markup.
   *
   * @return $this
   */
  protected function buildRangedJavascriptElement() {

    if ($this->getContext('usejs')
      && $this->getContext('min') !== FALSE
      && $this->getContext('max') !== FALSE) {


      if (class_exists('VTCore_Wordpress_Utility')) {
        VTCore_Wordpress_Utility::loadAsset('jquery-nouislider');
        VTCore_Wordpress_Utility::loadAsset('bootstrap-range');
      }

      $this
        ->lastChild()
        ->addClass('hidden');

      $this
        ->addChildren(new VTCore_Html_Element(array(
          'type' => 'div',
          'attributes' => array(
            'class' => array(
              'form-control',
              'form-range-slider',
            ),
          ),
        )))
        ->lastChild()
        ->addChildren(new VTCore_Html_Element(array(
          'type' => 'div',
          'data' => array(
            'trigger' => 'bootstrap-range',
            'slider-options' => $this->buildRangedOptions()
          )
        )));
    }

    return $this;
  }






  /**
   * Build the ranged min and max element
   * @return $this
   */
  protected function buildRangedElement() {
    $this
      ->assignRangedContext()
      ->addChildren(new VTCore_Html_Element(array(
        'type' => 'div',
        'attributes' => array(
          'class' => array(
            'input-group'
          ),
        ),
      )))
      ->lastChild()
      ->addChildren(new VTCore_Bootstrap_Form_BsNumber($this->getContext('min_elements')))
      ->addChildren(new VTCore_Html_Element($this->getContext('separator_elements')))
      ->addChildren(new VTCore_Bootstrap_Form_BsNumber($this->getContext('max_elements')));

    return $this;
  }





  /**
   * Attempt to format form label using the mintext and maxtext
   * @return $this
   */
  protected function buildRangedText() {

    if (!$this->getContext('text')
      && $this->getContext('usejs')
      && ($this->getContext('mintext') || $this->getContext('maxtext'))) {

      $text = new VTCore_Html_Element();

      if ($this->getContext('mintext')) {
        $text->addChildren(new VTCore_Html_Element(array(
          'type' => 'span',
          'text' => $this->getContext('mintext'),
          'attributes' => array(
            'class' => array(
              'form-range-min-label',
            ),
          ),
        )));

        $this->addContext('label_elements.attributes.for', 'element-' . $this->getMachineID() . '-min');
      }

      if ($this->getContext('maxtext')) {
        $text->addChildren(new VTCore_Html_Element(array(
          'type' => 'span',
          'text' => $this->getContext('maxtext'),
          'attributes' => array(
            'class' => array(
              'form-range-max-label',
            ),
          ),
        )));

        $this->addContext('label_elements.attributes.for', 'element-' . $this->getMachineID() . '-max');
      }

      $this->addContext('label_elements.text', $text);

    }

    return $this;
  }





  /**
   * Additional method for moving bootstrap
   * shortcut attributes as in base class
   * into min and max input element.
   *
   * @return $this
   */
  protected function assignRangedContext() {
    $assignContext = array(
      'required',
      'min',
      'max',
      'step',
      'disabled',
    );

    foreach ($assignContext as $key) {
      $value = $this->getContext($key);

      if ($value === NULL) {
        continue;
      }

      $this
        ->addContext('min_elements.' . $key, $value)
        ->addContext('max_elements.' . $key, $value);
    }

    $this
      ->addContext('min_elements.id', 'element-' . $this->getMachineID() . '-min')
      ->addContext('max_elements.id', 'element-' . $this->getMachineID() . '-max');

    if ($this->getContext('value.min')) {
      $this
        ->addContext('min_elements.value', $this->getContext('value.min'));
    }

    if ($this->getContext('value.max')) {
      $this->addContext('max_elements.value', $this->getContext('value.max'));
    }

    return $this;
  }





  /**
   * Method for generating object for the slider options
   * @return \stdClass
   */
  protected function buildRangedOptions() {

    $options = new stdClass();
    $options->start = array();

    $options->range = new stdClass();
    $options->range->min = array((int) $this->getContext('min'));
    $options->range->max = array((int) $this->getContext('max'));
    $options->orientation = $this->getContext('orientation');
    $options->animate = $this->getContext('animate');
    $options->tooltips = $this->getContext('tooltips');
    $options->step = $this->getContext('step');

    if ($this->getContext('ranged')) {
      $options->connect = TRUE;

      if ($this->getContext('min_elements.value')) {
        $options->start[] = $this->getContext('min_elements.value');
      }
      else {
        $options->start[] = $this->getContext('min');
      }

      if ($this->getContext('max_elements.value')) {
        $options->start[] = $this->getContext('max_elements.value');
      }
      else {
        $options->start[] = $this->getContext('max');
      }
    }
    else {
      $options->connect = 'lower';

      if ($this->getContext('value')) {
        $options->start[] = $this->getContext('value');
      }
      else {
        $options->start[] = (int) $this->getContext('max') / 2;
      }

    }

    return $options;

  }

}