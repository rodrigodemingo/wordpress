<?php
/**
 * Class for building a wordpress meta_query
 * compatible form.
 *
 * @todo implement ajax search for the meta key
 * @author jason.xie@victheme.com
 */
class VTCore_Wordpress_Form_Query_Meta
extends VTCore_Bootstrap_Form_Base
implements VTCore_Form_Interface  {

  protected $context = array(
    'text' => false,
    'description' => false,

    'name' => false,
    'id' =>  false,
    'class' => array(
      'form-control'
    ),
    'label' => true,

    // Wrapper Element
    'type' => 'div',
    'attributes' => array(
      'class' => array(
        'form-group',
        'wp-query-meta',
      ),
    ),

    'value' => array(),

    // Internal use, Only override if needed
    'label_elements' => array(),
    'description_elements' => array(),
  );


  /**
   * Overriding parent method
   *
   * @return $this|void
   */
  public function buildElement() {

    VTCore_Wordpress_Utility::loadAsset('jquery-table-manager');

    parent::buildElement();

    if ($this->getContext('label_elements')) {
      $this->addChildren(new VTCore_Form_Label($this->getContext('label_elements')));
    }

    if ($this->getContext('description_elements')) {
      $this->addChildren(new VTCore_Bootstrap_Form_BsDescription(($this->getContext('description_elements'))));
    }

    $this
      ->addChildren(new VTCore_Bootstrap_Form_BsSelect(array(
        'text' => __('Relation', 'victheme_core'),
        'description' => __('Database relation between each meta entry.', 'victheme_core'),
        'name' => $this->getContext('name') . '[meta][relation]',
        'value' => $this->getContext('value.relation'),
        'options' => array(
          'AND' => __('And', 'victheme_core'),
          'OR' => __('Or', 'victheme_core'),
        ),
      )))
      ->addChildren(new VTCore_Html_Element(array(
        'type' => 'div',
        'attributes' => array(
          'class' => array('table-manager'),
        ),
      )))
      ->lastChild()
      ->addChildren(new VTCore_Html_Table(array(
        'headers' => array(
          '',
          __('Data', 'victheme_core'),
          '',
        ),
        'rows' => $this->buildRows(),
        'attributes' => array(
          'class' => array(
            'wp-query-form-table',
            'wp-query-form-meta-table'
          ),
        ),
      )))
      ->addChildren(new VTCore_Bootstrap_Form_BsButton(array(
        'text' => __('Add Entry', 'victheme_core'),
        'attributes' => array(
          'data-tablemanager-type' => 'addrow',
        ),
      )));


  }


  /**
   * Build the table row array
   * @return array
   */
  public function buildRows() {

    // Set initial row if no value defined
    if (!$this->getContext('value')) {
      $this->addContext('value.0', array(
        'key' => '',
        'value' => '',
        'type' => '',
        'compare' => '',
      ));
    }

    $rows = array();
    foreach ($this->getContext('value') as $delta => $term) {

      if ($delta === 'relation') {
        continue;
      }

      $object = new VTCore_Wordpress_Objects_Array($term);

      // Drag icon
      $rows[$delta][] = array(
        'content' => new VTCore_Bootstrap_Element_BsElement(array(
          'type' => 'span',
          'attributes' => array(
            'class' => array('drag-icon'),
          ),
        )),
        'attributes' => array(
          'class' => array('drag-element'),
        ),
      );

      $form  = new VTCore_Bootstrap_Form_Base();
      $form
        ->addChildren(new VTCore_Bootstrap_Grid_BsRow())
        ->lastChild()
        ->addChildren(new VTCore_Bootstrap_Form_BsText(array(
          'text' => __('Meta Key', 'victheme_core'),
          'description' => __('Valid post meta key name.', 'victheme_core'),
          'name' => $this->getContext('name') . '[meta][' . $delta . '][key]',
          'value' => $object->get('key'),
          'grids' => array(
            'columns' => array(
              'mobile' => 12,
              'small' => 6,
              'medium' => 6,
              'large' => 6,
            ),
          ),
        )))
        ->addChildren(new VTCore_Bootstrap_Form_BsText(array(
          'text' => __('Meta Value', 'victheme_core'),
          'description' => __('Valid post meta value.', 'victheme_core'),
          'name' => $this->getContext('name') . '[meta][' . $delta . '][value]',
          'value' => $object->get('value'),
          'grids' => array(
            'columns' => array(
              'mobile' => 12,
              'small' => 6,
              'medium' => 6,
              'large' => 6,
            ),
          ),
        )))
        ->getParent()
        ->addChildren(new VTCore_Bootstrap_Grid_BsRow())
        ->lastChild()
        ->addChildren(new VTCore_Bootstrap_Form_BsSelect(array(
          'text' => __('Field Type', 'victheme_core'),
          'description' => __('Meta value data type.', 'victheme_core'),
          'name' => $this->getContext('name') . '[meta][' . $delta . '][type]',
          'options' => array(
            'NUMERIC' => __('Numeric', 'victheme_core'),
            'BINARY' => __('Binary', 'victheme_core'),
            'CHAR' => __('Char', 'victheme_core'),
            'DATE' => __('Date', 'victheme_core'),
            'DATETIME' => __('DateTime', 'victheme_core'),
            'DECIMAL' => __('Decimal', 'victheme_core'),
            'SIGNED' => __('Signed', 'victheme_core'),
            'TIME' => __('Time', 'victheme_core'),
            'UNSIGNED' => __('Unsigned', 'victheme_core'),
          ),
          'value' => $object->get('type'),
          'grids' => array(
            'columns' => array(
              'mobile' => 12,
              'small' => 6,
              'medium' => 6,
              'large' => 6,
            ),
          ),
        )))
        ->addChildren(new VTCore_Bootstrap_Form_BsSelect(array(
          'text' => __('Comparison', 'victheme_core'),
          'description' => __('Meta value data comparison mode.', 'victheme_core'),
          'name' => $this->getContext('name') . '[meta][' . $delta . '][compare]',
          'options' => array(
            '=' => 'Equal',
            '!=' => 'Not Equal',
            '>' => 'Larger',
            '>=' => 'Larger Than',
            '<' => 'Smaller',
            '<=' => 'Smaller Than',
            'LIKE' => 'LIKE',
            'NOT LIKE' => 'NOT LIKE',
            'IN' => 'IN',
            'NOT IN' => 'NOT IN',
            'BETWEEN' => 'BETWEEN',
            'NOT BETWEEN' => 'NOT BETWEEN',
            'EXISTS' => 'EXISTS',
            'NOT EXISTS' => 'NOT EXISTS',
          ),
          'value' => $object->get('compare'),
          'grids' => array(
            'columns' => array(
              'mobile' => 12,
              'small' => 6,
              'medium' => 6,
              'large' => 6,
            ),
          ),
        )));


      // Data cell
      $rows[$delta][] = array(
        'content' => $form,
        'attributes' => array(
          'class' => array('data-element'),
        ),
      );

      // Remove button
      $rows[$delta][] = array(
        'content' => new VTCore_Form_Button(array(
          'text' => 'X',
          'attributes' => array(
            'data-tablemanager-type' => 'removerow',
            'class' => array('button', 'button-mini', 'form-button'),
          ),
        )),
        'attributes' => array(
          'class' => array('remove-element'),
        ),
      );
    }

    return $rows;

  }

}