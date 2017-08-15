<?php
/**
 * Class for building valid bootstrap grids system
 * form. Including the columns, push, pull and offset
 * grid mode.
 *
 * Context rule :
 *
 * {mode} : array {text} = the mode label text
 *                {description} = the mode description text
 *
 * Valid modes
 * columns: The bootstrap col-xx columns
 * push   : The bootstrap push mode
 * pull   : The bootstrap pull mode
 * offset : the bootstrap offset mode
 *
 *
 * Changing icons :
 * icons = {size} => {fontawesome icon name}
 *
 * Valid sizes :
 * mobile  = xs
 * tablet = sm
 * small = md
 * large = lg
 *
 *
 * @author jason.xie@victheme.com
 * @method BsGrids($context)
 * @see VTCore_Html_Form interface
 */
class VTCore_Bootstrap_Form_BsGrids
extends VTCore_Bootstrap_Form_Base
implements VTCore_Form_Interface {

  protected $context = array(

    'type' => 'div',
    'text' => '',
    'attributes' => array(
      'class' => array(
        'bootstrap-grid',
      ),
    ),

    // Select which grid type to build
    'columns' => false,
    'push' => false,
    'pull' => false,
    'offset' => false,

    'value' => array(),

    'togglelabel' => false,

    'icons' => array(
      'mobile' => 'mobile-phone',
      'tablet' => 'tablet',
      'small' => 'laptop',
      'large' => 'desktop',
    ),

    'element_grids' => array(
      'columns' => array(
        'mobile' => '12',
        'tablet' => '6',
        'small' => '4',
        'large' => '3',
      ),
    ),

    'input_elements' => array(
      'attributes' => array(
        'class' => array(
          'form-control',
        ),
      ),
    ),
  );



  /**
   * Overriding parent method
   * @see VTCore_Html_Base::buildElement()
   */
  public function buildElement() {

    parent::buildElement();

    VTCore_Wordpress_Utility::loadAsset('bootstrap-grids');

    if ($this->getContext('columns')) {
      $this->buildSizes('columns');
    }

    if ($this->getContext('push')) {
      $this->buildSizes('push');
    }

    if ($this->getContext('pull')) {
      $this->buildSizes('pull');
    }

    if ($this->getContext('offset')) {
      $this->buildSizes('offset');
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
   * Method for building single mode elements
   */
  protected function buildSizes($type) {

    $this->addChildren(new VTCore_Html_Element(array(
      'type' => 'div',
      'attributes' => array(
        'class' => array('bootstrap-grids-'. $type),
      )
    )));

    if ($this->getContext($type . '.text')) {
      $this->lastChild()->addChildren(new VTCore_Form_Label(array(
        'text' => $this->getContext($type . '.text'),
      )));
    }

    if ($this->getContext($type . '.description')) {
      $this->lastChild()->addChildren(new VTCore_Bootstrap_Form_BsDescription(array(
        'text' => $this->getContext($type . '.description'),
      )));
    }

    $this->rows = $this->lastChild()->addChildren(new VTCore_Bootstrap_Grid_BsRow())->lastChild();

    $options = array(
      'none' => '--',
    );

    $options += range(0,12,1);

    foreach ($this->getContext('icons') as $mode => $icon) {

      $this->addContext('input_elements.attributes.name', $this->getContext('name') . '[' . $type . '][' . $mode . ']');
      $this->addContext('input_elements.attributes.value', $this->getContext('value.' . $type . '.' . $mode));
      $this->addContext('input_elements.options', $options);

      $this->rows
        ->addChildren(new VTCore_Bootstrap_Grid_BsColumn(array(
          'type' => 'div',
          'attributes' => array(
            'class' => array(
              'input-group',
              'bootstrap-grids',
              'bootstrap-grids-'. $type . '-' . $mode,
            ),
          ),
          'grids' => $this->getContext('element_grids'),
        )))
        ->lastChild()
        ->addChildren(new VTCore_Fontawesome_faIcon(array(
          'icon' => $icon,
          'attributes' => array(
            'class' => array(
              'input-group-addon',
            ),
          ),
        )))
        ->addChildren(new VTCore_Form_Select($this->getContext('input_elements')));
    }
  }
}