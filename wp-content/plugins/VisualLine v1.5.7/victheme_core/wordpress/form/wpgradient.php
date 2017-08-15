<?php
/**
 * Building form for picking gradient rules
 * This form will save the gradient value in
 * an array format. To convert it to css
 * please use CSSBuilder gradient object set.
 *
 * @todo improve this class so user can inject more
 *       data after the class is initialized.
 * @author jason.xie@victheme.com
 * @method WpGradient($context)
 * @see VTCore_Html_Form interface
 */
class VTCore_Wordpress_Form_WpGradient
extends VTCore_Bootstrap_Form_Base
implements VTCore_Form_Interface {

  protected $context = array(

    // Shortcut method
    // @see VTCore_Bootstrap_Form_Base::assignContext()
    'text' => false,
    'description' => false,
    'required' => false,

    'name' => false,
    'id' => false,
    'class' => array('form-control'),

    'preview' => true,

    // Bootstrap Rules
    'label' => true,

    // Wrapper element
    'type' => 'div',
    'attributes' => array(
      'class' => array(
        'form-group',
        'wp-gradient-picker'
       ),
    ),

    'value' => array(),
  );

  protected $gradients = array(
    'type' => 'linear',
    'repeat' => false,
    'settings' => array(
      'direction' => 'top',
      'size' => '',
      'shape' => '',
      'position' => '',
    ),
    'colors' => array(
      array(
        'stop' => '',
        'color' => '',
      )
    ),
  );


  public function buildElement() {

    $this->gradients = VTCore_Utility::arrayMergeRecursiveDistinct($this->context['value'], $this->gradients);

    // Load assets
    VTCore_Wordpress_Utility::loadAsset('bootstrap-colorpicker');
    VTCore_Wordpress_Utility::loadAsset('jquery-table-manager');
    VTCore_Wordpress_Utility::loadAsset('wp-gradientpicker');

    $this->addAttributes($this->getContext('attributes'));


    if ($this->getContext('label_elements')) {
      $this->Label($this->getContext('label_elements'));
    }

    if ($this->getContext('description_elements')) {
      $this->addChildren(new VTCore_Bootstrap_Form_BsDescription(($this->getContext('description_elements'))));
    }

    // Build the css rule for previewer
    if ($this->getContext('preview')) {
      $cssbuilder = new VTCore_CSSBuilder_Gradient($this->gradients);
      $this
        ->BsElement(array(
          'type' => 'div',
          'attributes' => array(
            'class' => array(
              'wp-gradient-picker-preview'
            ),
            'style' => $cssbuilder->render(),
          ),
        ));
    }


    // Build the form
    $this
      ->BsElement(array(
        'type' => 'div',
        'attributes' => array(
          'class' => array(
            'wp-gradient-picker-controller'
          ),
        ),
      ))
      ->lastChild()
      ->BsRow()
      ->lastChild()
      ->BsSelect(array(
        'text' => __('Mode', 'victheme_core'),
        'name' => $this->getContext('name') . '[gradient][type]',
        'value' => $this->getGradient('type'),
        'label' => true,
        'data' => array(
          'gradient-pairing' => array(
            'radial' => 'radials',
            'linear' => 'linears',
          ),
        ),
        'options' => array(
          false => __('Disable', 'victheme_core'),
          'linear' => __('Linear', 'victheme_core'),
          'radial' => __('Radial', 'victheme_core'),
        ),
        'grids' => array(
          'columns' => array(
            'mobile' => 12,
            'tablet' => 6,
            'small' => 6,
            'large' => 6,
          ),
        ),
      ))
      ->BsCheckbox(array(
        'name' => $this->getContext('name') . '[gradient][repeat]',
        'text' => __('Repeat', 'victheme_core'),
        'checked' => (boolean) $this->getGradient('repeat'),
        'switch' => true,
        'grids' => array(
          'columns' => array(
            'mobile' => 12,
            'tablet' => 6,
            'small' => 6,
            'large' => 6,
          ),
        ),
      ))
      ->getParent()
      ->BsText(array(
        'text' => __('Direction', 'victheme_core'),
        'description' => __('left | right | top | bottom | 45deg', 'victheme_core'),
        'data' => array(
          'gradient-pairing-active' => 'linears',
        ),
        'name' => $this->getContext('name') . '[gradient][settings][direction]',
        'value' => $this->getGradientSettings('direction'),
      ))
      ->BsRow()
      ->lastChild()
      ->BsText(array(
        'text' => __('Position', 'victheme_core'),
        'data' => array(
          'gradient-pairing-active' => 'radials',
        ),
        'tooltip' => array(
          'placement' => 'bottom',
          'title' => __('center | top | left | right | bottom | (100px 100px)', 'victheme_core'),
        ),
        'name' => $this->getContext('name') . '[gradient][settings][position]',
        'value' => $this->getGradientSettings('position'),
        'grids' => array(
          'columns' => array(
            'mobile' => 12,
            'tablet' => 4,
            'small' => 4,
            'large' => 4,
          ),
        ),
      ))
      ->BsSelect(array(
        'text' => __('Shape', 'victheme_core'),
        'name' => $this->getContext('name') . '[gradient][settings][shape]',
        'value' => $this->getGradientSettings('shape'),
        'data' => array(
          'gradient-pairing-active' => 'radials',
        ),
        'options' => array(
          'circle' => __('Circle', 'victheme_core'),
          'ellipse' => __('Ellipse', 'victheme_core'),
        ),
        'grids' => array(
          'columns' => array(
            'mobile' => 12,
            'tablet' => 4,
            'small' => 4,
            'large' => 4,
          ),
        ),
      ))
      ->BsSelect(array(
        'text' => __('Size', 'victheme_core'),
        'name' => $this->getContext('name') . '[gradient][settings][size]',
        'value' => $this->getGradientSettings('size'),
        'data' => array(
          'gradient-pairing-active' => 'radials',
        ),
        'options' => array(
          'farthest-corner' => __('Farthest Corner', 'victheme_core'),
          'farthest-side' => __('Farthest Side', 'victheme_core'),
          'closest-corner' => __('Closest Corner', 'victheme_core'),
          'closest-side' => __('Closest Side', 'victheme_core'),
          'contain' => __('Contain', 'victheme_core'),
          'cover' => __('Cover', 'victheme_core'),
        ),
        'grids' => array(
          'columns' => array(
            'mobile' => 12,
            'tablet' => 4,
            'small' => 4,
            'large' => 4,
          ),
        ),
      ))
      ->getParent()
      ->getParent()
      ->BsElement(array(
        'type' => 'div',
        'attributes' => array(
          'class' => array('table-manager'),
        ),
      ))
      ->lastChild()
      ->Table(array(
        'headers' => array(
          '',
          __('Stop', 'victheme_core'),
          __('Color', 'victheme_core'),
          '',
        ),
        'rows' => $this->buildRows(),
      ))
      ->BsButton(array(
        'text' => __('Add Color', 'victheme_core'),
        'attributes' => array(
          'data-tablemanager-type' => 'addrow',
        ),
      ));

  }


  /**
   * Helper function for easily retrieving
   * gradient setting value by its key
   */
  private function getGradientSettings($key) {
    return (isset($this->gradients['settings'][$key])) ? $this->gradients['settings'][$key] : NULL;
  }



  /**
   * Helper function for easily retrieving
   * gradients array value based on its key
   */
  private function getGradient($type) {
    return (isset($this->gradients[$type])) ? $this->gradients[$type] : NULL;
  }



  /**
   * Helper function for building the
   * table manager rows.
   */
  private function buildRows() {
    $rows = array();
    foreach ($this->getGradient('colors') as $key => $data) {

      // Draggable Icon
      $rows[$key][] = array(
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

      $rows[$key][] = array(
        'attributes' => array(
          'class' => array('wp-picker-stop-point'),
        ),
        'content' => new VTCore_Bootstrap_Form_BsText(array(
          'label' => false,
          'name' => $this->getContext('name') . '[gradient][colors][' . $key . '][stop]',
          'value' => $data['stop'],
        )),
      );


      $rows[$key][] = array(
        'attributes' => array(
          'class' => array('wp-picker-color-picker'),
        ),
        'content' => new VTCore_Bootstrap_Form_BsColor(array(
          'label' => false,
          'name' => $this->getContext('name') . '[gradient][colors][' . $key . '][color]',
          'value' => $data['color'],
          'data' => array(
            'container' => true,
          ),
        )),
      );


      // Remove button
      $rows[$key][] = new VTCore_Form_Button(array(
        'text' => 'X',
        'attributes' => array(
          'data-tablemanager-type' => 'removerow',
          'class' => array('button', 'button-mini', 'form-button'),
        ),
      ));

    }

    return $rows;
  }
}