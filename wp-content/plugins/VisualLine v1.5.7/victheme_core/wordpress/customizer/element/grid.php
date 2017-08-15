<?php
/**
 * Extending WP Customizer control for lightweight
 * grid selectors
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Customizer_Element_Grid
extends WP_Customize_Control {

  public $type = 'vtcore_grid';

  public function render_content() {

    // Build title
    $object = new VTCore_Bootstrap_Form_BsGrids(array(
      'text' => $this->label,
      'description' => $this->description,
      'value' => $this->value(),
      'name' => $this->settings['default']->id,
      'columns' => isset($this->choices['columns']) ? $this->choices['columns'] : false,
      'push' => isset($this->choices['push']) ? $this->choices['push'] : false,
      'pull' => isset($this->choices['pull']) ? $this->choices['pull'] : false,
      'offset' => isset($this->choices['offset']) ? $this->choices['offset'] : false,
      'element_grids' => array(
        'columns' => array(
          'mobile' => '12',
          'tablet' => '12',
          'small' => '12',
          'large' => '12',
        ),
      ),
    ));

    $selects = $object->findChildren('objectType', 'VTCore_Form_Select');

    foreach ($selects as $select) {
      $select->addAttribute('data-customize-setting-link', $select->getContext('attributes.name'));
    }

    $object->render();

  }

}