<?php
/**
 * Building form input with bootstrap date picker
 *
 * Shortcut Method : BsDate($context)
 *
 * This class must be called from VTCore_Bootstrap_Form_BsInstance() as
 * the main form wrapper class if shortcut method is used.
 *
 * Otherwise a full invocation of the class name must be used
 * when building the object, and addChildren() method must be
 * used for registering the object into the parent form wrapper.
 *
 * Shortcut context available :
 *
 * text          : (string) The text for the Legend element
 * description   : (string) Text of decription printed after the input element
 * prefix        : (string) Prefix element in front of the text input element
 * suffix        : (string) Prefix element in end of the text input element
 * required      : (boolean) Flag for marking element as required
 * placeholder   : (string) The placeholder text for the input element
 * name          : (string) The name attributes for the input element
 * value         : (string) The value attributes for the input element
 * id            : (string) The id used for the input element and object machine id
 * class         : (array) Classes used for the input element
 * label         : (boolean) Flag for hiding the label element via CSS
 *
 * datepicker arrays
 * mode          : (string) range | component, The type of date picker markup to build.
 * separator     : (string) the string text for the date picker range mode separator element.
 * format        : (string) mm/dd/yyyy the default date format
 * weekStart     : (numeric) 0 - 7 the day number to start the calendar week
 * startDate     : (mixed) boolean false to disable and string date with the format of mm/dd/yyyy
 *                         to mark the calendar starting date
 * endDate       : (mixed) boolean false to disable and string date with the format of mm/dd/yyyy
 *                         to mark the calendar end date
 * startView     : (numeric) the starting view mode:
 *                           0 = month
 *                           1 = year
 *                           2 = decade
 * minView       : (numeric) the minimum calendar viewing mode
 *                           0 = days
 *                           1 = months
 *                           2 = years
 * todayBtn      : (mixed) format or disable the today button selector
 *                           false = disable the button
 *                           true = enabled the button
 *                           linked = link the button to the input element
 * clearBtn      : (boolean) enable or disable the clear button
 * language      : (string) the language for the calendar
 * orientation   : (string) the position of the calendar popup, valid choices are
 *                          auto, top auto, bottom auto, auto left, top left, bottom left, auto right,
 *                          top right, bottom right.
 * autoclose     : (boolean) disable or enable the auto close after selection mode
 * todayHighlight: (boolean) disable or enable the calendar highlight for today element
 * calendarWeeks : (boolean) disable or enable the calendar showing year weeks number mode
 *
 *
 * Special Note :
 *
 * RANGE MODE CONTEXT
 * When injecting context under calendar mode range, object will not use the default VTCore_Bootstrap_Form_Base
 * preprocessing function that targets the input_elements context entry, instead it will try to parse the context
 * value and assign them to start_elements, end_elements and separator_elements context. So if you want to override
 * the input context under the range mode use start_elements, end_elements and separator_elements context instead.
 *
 * RANGE MODE NAME ATTRIBUTES
 * Object will append the [start] or [end] as the form input name for the start and end input elements when using
 * the range mode, please ensure that the context values content arrays of :
 *  'value' => array(
 *    'start' => value,
 *    'end' => value,
 *  )
 *
 * for the range elements.
 *
 *
 * @author jason.xie@victheme.com
 * @method BsDate($context)
 * @see VTCore_Html_Form interface
 */
class VTCore_Bootstrap_Form_BsDate
extends VTCore_Bootstrap_Form_Base
implements VTCore_Form_Interface {

  protected $context = array(

    // Shortcut method
    // @see VTCore_Bootstrap_Form_Base::assignContext()
    'text' => false,
    'description' => false,
    'prefix' => false,
    'suffix' => false,
    'required' => false,
    'placeholder' => false,
    'name' => false,
    'value' => false,
    'id' => false,
    'class' => array(
      'form-control'
    ),

    // Bootstrap Rules
    'label' => true,

    'togglelabel' => false,

    // Wrapper element
    'type' => 'div',
    'attributes' => array(
      'class' => array(
        'datepicker-group',
      ),
    ),

    'icon' => 'th',

    // Clockpicker rules
    'datepicker' => array(
      'mode' => 'component',
      'separator' => 'to',
      'format' => 'mm/dd/yyyy',
      'weekStart' => '0',
      'startDate' => false,
      'endDate' => false,
      'startView' => 0,
      'minView' => 0,
      'todayBtn' => 'linked',
      'clearBtn' => true,
      'language' => 'en',
      'orientation' => 'top auto',
      'autoclose' => true,
      'todayHighlight' => true,
      'calendarWeeks' => false,
    ),

    // Internal use, Only override if needed
    'input_elements' => array(),
    'label_elements' => array(),
    'description_elements' => array(),
    'prefix_elements' => array(),
    'suffix_elements' => array(),
    'required_elements' => array(),

    // Special markup for date picker range mode
    'start_elements' => array(
      'attributes' => array(
        'class' => array(
          'form-control',
        ),
      ),
    ),
    'end_elements' => array(
      'attributes' => array(
        'class' => array(
          'form-control',
        ),
      ),
    ),
    'separator_elements' => array(
      'type' => 'span',
      'attributes' => array(
        'class' => array(
          'input-group-addon',
        ),
      ),
    ),
  );


  /**
   * Overriding parent method
   * @return $this
   */
  public function buildElement() {

    // Only accept component or range as the mode
    if (!$this->getContext('datepicker.mode')) {
      $this->addContext('datepicker.mode', 'component');
    }

    // Datepicker in self container mode instead of body
    if ($this->getContext('datepicker.container') == 'self') {
      if (!$this->getContext('attributes.id')) {
        $this->addContext('attributes.id', uniqid('date-picker-container-'));
      }

      $this->addContext('datepicker.container', '#' . $this->getContext('attributes.id'));
      $this->addContext('attributes.class.wrapped', 'datepicker-grouped-inside');
    }

    if (class_exists('VTCore_Wordpress_Utility')) {
      VTCore_Wordpress_Utility::loadAsset('bootstrap-datepicker');

      if ($this->getContext('datepicker.mode') == 'component') {
        VTCore_Wordpress_Utility::loadAsset('bootstrap-glyphicon');
      }
    }

    $this
      ->addAttributes($this->getContext('attributes'));


    if ($this->getContext('label_elements')) {
      $this->addChildren(new VTCore_Form_Label($this->getContext('label_elements')));
    }

    if ($this->getContext('prefix_elements')) {
      $this->addChildren(new VTCore_Bootstrap_Form_BsPrefix(($this->getContext('prefix_elements'))));
    }

    switch ($this->getContext('datepicker.mode')) {
      case 'text' :
        $this->dateText();
        break;

      case 'component' :
        $this->dateComponent();
        break;

      case 'range' :
        $this->dateRange();
        break;
    }

    if ($this->getContext('suffix_elements')) {
      $this->addChildren(new VTCore_Bootstrap_Form_BsPrefix(($this->getContext('suffix_elements'))));
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

    return $this;
  }



  /**
   * Method for building the date text markup
   */
  protected function dateText() {

    $this
      ->addClass('form-group')
      ->addContext('input_elements.attributes.data-options', json_encode($this->getContext('datepicker')))
      ->addContext('input_elements.attributes.class.datepicker-javascript', 'js-datepicker')
      ->addChildren(new VTCore_Form_Text($this->getContext('input_elements')));

    return $this;
  }



  /**
   * Method for building the date component markup
   */
  protected function dateComponent() {

    $this
      ->addClass('date')
      ->addClass('input-group')
      ->addClass('js-datepicker')
      ->addData('options', json_encode($this->getContext('datepicker')))
      ->addChildren(new VTCore_Form_Text($this->getContext('input_elements')))
      ->addChildren(new VTCore_Bootstrap_Form_BsSuffix(($this->getContext('suffix_elements'))))
      ->lastChild()
      ->addChildren(new VTCore_Bootstrap_Element_BsGlyphicon(array(
        'type' => 'i',
        'icon' => $this->getContext('icon'),
      )));

    return $this;
  }


  /**
   * Method for building the date range markup
   */
  protected function dateRange() {

    $this
      ->addClass('input-group')
      ->addClass('input-daterange')
      ->addClass('js-datepicker')
      ->addData('options', json_encode($this->getContext('datepicker')))
      ->addContext('start_elements.attributes.value', $this->getContext('value.start'))
      ->addContext('start_elements.attributes.name', $this->getContext('name') . '[start]')
      ->addContext('separator_elements.text', $this->getContext('datepicker.separator'))
      ->addContext('end_elements.attributes.name', $this->getContext('name') . '[end]')
      ->addContext('end_elements.attributes.value', $this->getContext('value.end'))
      ->addChildren(new VTCore_Form_Text($this->getContext('start_elements')))
      ->addChildren(new VTCore_Html_Element($this->getContext('separator_elements')))
      ->addChildren(new VTCore_Form_Text($this->getContext('end_elements')));

    return $this;
  }



}