<?php
/**
 * Class for creating Wordpress tax_query
 * compliant form
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Wordpress_Form_Query_Taxonomy
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
        'wp-query-taxonomy',
      ),
    ),

    'value' => array(),
    'get_taxonomies_args' => array('name' => 'category'),

    // Internal use, Only override if needed
    'label_elements' => array(),
    'description_elements' => array(),
  );

  protected $taxonomies = array();

  /**
   * Overriding parent method
   * @return $this|void
   */
  public function buildElement() {

    VTCore_Wordpress_Utility::loadAsset('jquery-table-manager');

    parent::buildElement();

    $this->buildTaxonomyOptions();

    if ($this->getContext('label_elements')) {
      $this->addChildren(new VTCore_Form_Label($this->getContext('label_elements')));
    }

    if ($this->getContext('description_elements')) {
      $this->addChildren(new VTCore_Bootstrap_Form_BsDescription(($this->getContext('description_elements'))));
    }

    $this
      ->addChildren(new VTCore_Bootstrap_Form_BsSelect(array(
        'text' => __('Relation', 'victheme_core'),
        'description' => __('Database relation between each taxonomy terms entry.', 'victheme_core'),
        'name' => $this->getContext('name') . '[taxonomy][relation]',
        'value' => $this->getContext('value.relation'),
        'options' => array(
          'AND' => __('And', 'victheme_core'),
          'OR' => __('Or', 'victheme_core'),
        ),
      )))
      ->addChildren(new VTCore_Html_Element(array(
        'type' => 'div',
        'attributes' => array(
          'class' => array(
            'table-manager'
          ),
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
            'wp-query-form-taxonomy-table'
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
   * Building the table rows array
   * @return array
   */
  public function buildRows() {

    if (!$this->getContext('value')) {
      $this->addContext('value.0', array(
        'taxonomy' => '',
        'field' => '',
        'terms' => '',
        'include_children' => '',
        'operator' => '',
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
          'text' => __('Terms', 'victheme_core'),
          'description' => __('Taxonomy term name, id or slug.', 'victheme_core'),
          'name' => $this->getContext('name') . '[taxonomy][' . $delta . '][terms]',
          'value' => $object->get('terms'),
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
          'text' => __('Taxonomy', 'victheme_core'),
          'description' => __('The terms taxonomy name.', 'victheme_core'),
          'name' => $this->getContext('name') . '[taxonomy][' . $delta . '][taxonomy]',
          'options' => $this->taxonomies,
          'value' => $object->get('taxonomy'),
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
          'text' => __('Field', 'victheme_core'),
          'description' => __('Term data type.', 'victheme_core'),
          'name' => $this->getContext('name') . '[taxonomy][' . $delta . '][field]',
          'options' => array(
            'term_id' => __('Term Id', 'victheme_core'),
            'name' => __('Name', 'victheme_core'),
            'slug' => __('Slug', 'victheme_core'),
          ),
          'value' => $object->get('field'),
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
          'text' => __('Compare', 'victheme_core'),
          'description' => __('Term comparison mode.', 'victheme_core'),
          'name' => $this->getContext('name') . '[taxonomy][' . $delta . '][operator]',
          'options' => array(
            'IN' => 'IN',
            'NOT IN' => 'NOT IN',
            'AND' => 'AND',
            'EXISTS' => 'EXISTS',
            'NOT EXISTS' => 'NOT EXISTS',
          ),
          'value' => $object->get('operator'),
          'grids' => array(
            'columns' => array(
              'mobile' => 12,
              'small' => 6,
              'medium' => 6,
              'large' => 6,
            ),
          ),
        )))
        ->addChildren(new VTCore_Bootstrap_Form_BsCheckbox(array(
          'text' => __('Include Children', 'victheme_core'),
          'description' => __('Include the taxonomy term children if available.', 'victheme_core'),
          'name' => $this->getContext('name') . '[taxonomy][' . $delta . '][include_children]',
          'switch' => false,
          'value' => (boolean) $object->get('include_children'),
          'grids' => array(
            'columns' => array(
              'mobile' => 12,
              'small' => 12,
              'medium' => 12,
              'large' => 12,
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


  /**
   * Method for building the taxonomies options.
   *
   * @return $this
   */
  protected function buildTaxonomyOptions() {
    $taxonomies = get_taxonomies(array(), 'objects');
    $banned = $this->getContext('taxonomies__not_in');
    $strict = $this->getContext('taxonomies__in');

    foreach ($taxonomies as $taxonomy => $object) {
      if (!empty($banned) && in_array($taxonomy, $banned)) {
        continue;
      }

      if (!empty($strict) && !in_array($taxonomy, $strict)) {
        continue;
      }

      $name = $object->name;
      if (isset($object->label) && !empty($object->label)) {
        $name = $object->label;
      }

      if (isset($object->labels) && isset($object->labels->name) && !empty($object->labels->name)) {
        $name = $object->labels->name;
      }

      $this->taxonomies[$taxonomy] = $name;
    }

    return $this;
  }

}