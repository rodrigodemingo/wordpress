<?php
/**
 * Building form for selecting background images, it
 * will supports Multiple Background Image CSS rules.
 *
 * The output will be valid arrays for CSSBuilder_Rules_Background
 * object. You can use CSSBuilder_Factory to build the final
 * CSS string output.
 *
 * @author jason.xie@victheme.com
 * @method WpBackground($context)
 * @see VTCore_Html_Form interface
 */
class VTCore_Wordpress_Form_WpBackground
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
        'wp-background-picker'
       ),
    ),

    'value' => array(
      'background' => array(
        'masking' => '',
        'color' => '',
        'image' => array(),
        'repeat' => array(),
        'size' => array(),
        'position' => array(),
        'attachment' => array(),
      ),

      'animation' => array(),
      'keyframe' => array(),
    ),
  );


  public function buildElement() {

    // Load assets
    VTCore_Wordpress_Utility::loadAsset('jquery-parallax');
    VTCore_Wordpress_Utility::loadAsset('bootstrap-colorpicker');
    VTCore_Wordpress_Utility::loadAsset('jquery-table-manager');
    VTCore_Wordpress_Utility::loadAsset('wp-background-picker');


    $this->addAttributes($this->getContext('attributes'));


    if ($this->getContext('label_elements')) {
      $this->Label($this->getContext('label_elements'));
    }

    if ($this->getContext('description_elements')) {
      $this->addChildren(new VTCore_Bootstrap_Form_BsDescription(($this->getContext('description_elements'))));
    }

    // Build the css rule for previewer
    if ($this->getContext('preview')) {

      $cssbuilder = new VTCore_CSSBuilder_Factory();
      $cssbuilder
        ->Background($this->getContext('value.background'));

      $maskingbuilder = new VTCore_CSSBuilder_Factory();
      $maskingbuilder
        ->Background(array(
          'color' => $this->getContext('value.background.masking')
        ));

      $this
        ->BsElement(array(
          'type' => 'div',
          'attributes' => array(
            'class' => array(
              'wp-background-picker-preview'
            ),
            'style' => $cssbuilder->buildInlineStyle(),
          ),
        ))
        ->lastChild()
        ->BsElement(array(
          'type' => 'div',
          'attributes' => array(
            'class' => array(
              'wp-background-picker-masking'
            ),
            'style' => $cssbuilder->buildInlineStyle(),
          ),
        ));
    }


    // Build the form
    $this
      ->BsRow()
      ->lastChild()
      ->BsColor(array(
        'text' => __('Background Color', 'victheme_core'),
        'name' => $this->getContext('name') . '[background][color]',
        'value' => $this->getContext('value.background.color'),
        'label' => true,
        'attributes' => array(
          'id' => 'background-color-selector-' . $this->getMachineID(),
        ),
        'data' => array(
          'background' => 'color',
          'container' => '#background-color-selector-' . $this->getMachineID(),
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
      ->BsColor(array(
        'text' => __('Background Masking', 'victheme_core'),
        'name' => $this->getContext('name') . '[background][masking]',
        'value' => $this->getContext('value.background.masking'),
        'label' => true,
        'attributes' => array(
          'id' => 'background-masking-selector-' . $this->getMachineID(),
        ),
        'data' => array(
          'background' => 'color',
          'container' => '#background-masking-selector-' . $this->getMachineID(),
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
        'text' => __('Parallax Mode', 'victheme_core'),
        'name' => $this->getContext('name') . '[background][parallax]',
        'options' => array(
          'none' => __('Disable Parallax', 'victheme_core'),
          'parallax-vertical' => __('Vertical Parallax', 'victheme_core'),
          'parallax-horizontal' => __('Horizontal Parallax', 'victheme_core'),
          'parallax-diagonal' => __('Diagonal Parallax', 'victheme_core'),
        ),
        'value' => $this->getContext('value.background.parallax'),
        'grids' => array(
          'columns' => array(
            'mobile' => 12,
            'tablet' => 4,
            'small' => 4,
            'large' => 4,
          ),
        ),
      ))
      ->BsElement(array(
        'type' => 'div',
        'attributes' => array(
          'class' => array('table-manager'),
        ),
        'grids' => array(
          'columns' => array(
            'mobile' => 12,
            'tablet' => 12,
            'small' => 12,
            'large' => 12,
          ),
        ),
      ))
      ->lastChild()
      ->Table(array(
        'headers' => array(
          '',
          __('Image', 'victheme_core'),
          __('Settings', 'victheme_core'),
          '',
        ),
        'rows' => $this->buildRows(),
      ))
      ->BsButton(array(
        'text' => __('Add Background', 'victheme_core'),
        'attributes' => array(
          'data-tablemanager-type' => 'addrow',
        ),
      ))
      ->getParent()
      ->getParent()
      ->BsPanel(array(
        'text' => __('Animation', 'victheme_core'),
      ))
      ->lastChild()
      ->setChildrenPointer('content')
      ->addOverloaderPrefix('VTCore_Wordpress_Form_')
      ->WpAnimation(array(
        'name' => $this->getContext('name'),
        'value' => $this->getContext('value.animation'),
      ));

  }



  /**
   * Helper function for building the
   * table manager rows.
   */
  private function buildRows() {
    $rows = array();

    // Give empty default for first timer
    if (!$this->getContext('value.background.image')
        || $this->getContext('value.background.image') == array()) {

      $this->addContext('value.background.image', array(0 => ''));
    }

    foreach ($this->getContext('value.background.image') as $key => $image) {

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
          'class' => array('wp-background-image'),
        ),
        'content' => new VTCore_Wordpress_Form_WpMedia(array(
          'label' => false,
          'name' => $this->getContext('name') . '[background][image][]',
          'value' => $image,
        )),
      );

      $row = new VTCore_Bootstrap_Element_BsElement();
      $row
        ->BsRow()
        ->lastChild()
        ->BsSelect(array(
          'text' => __('Repeat', 'victheme_core'),
          'name' => $this->getContext('name') . '[background][repeat][]',
          'value' => $this->getContext('value.background.repeat.' . $key),
          'options' => array(
            '' => __('Not set', 'victheme_core'),
            'no-repeat' => __('No Repeat', 'victheme_core'),
            'repeat' => __('Repeat All', 'victheme_core'),
            'repeat-x' => __('Repeat Horizontally', 'victheme_core'),
            'repeat-y' => __('Repeat Vertically', 'victheme_core'),
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
        ->BsSelect(array(
          'text' => __('Attachment', 'victheme_core'),
          'name' => $this->getContext('name') . '[background][attachment][]',
          'value' => $this->getContext('value.background.attachment.' . $key),
          'options' => array(
            'initial' => __('Initial', 'victheme_core'),
            'scroll' => __('Scroll', 'victheme_core'),
            'fixed' => __('Fixed', 'victheme_core'),
            'local' => __('Local', 'victheme_core'),
            'inherit' => __('Inherit', 'victheme_core'),
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
        ->getParent()
        ->BsRow()
        ->lastChild()
        ->BsText(array(
          'text' => __('Position', 'victheme_core'),
          'name' => $this->getContext('name') . '[background][position][]',
          'value' => $this->getContext('value.background.position.' . $key),
          'grids' => array(
            'columns' => array(
              'mobile' => 12,
              'tablet' => 6,
              'small' => 6,
              'large' => 6,
            ),
          ),
        ))
        ->BsText(array(
          'text' => __('Size', 'victheme_core'),
          'name' => $this->getContext('name') . '[background][size][]',
          'value' => $this->getContext('value.background.size.' . $key),
          'grids' => array(
            'columns' => array(
              'mobile' => 12,
              'tablet' => 6,
              'small' => 6,
              'large' => 6,
            ),
          ),
        ))
        ->BsElement(array(
          'type' => 'h4',
          'text' => __('Animation Frame', 'victheme_core'),
          'grids' => array(
            'columns' => array(
              'mobile' => 12,
              'tablet' => 12,
              'small' => 12,
              'large' => 12,
            ),
          ),
        ))
        ->BsText(array(
          'text' => __('From', 'victheme_core'),
          'name' => $this->getContext('name') . '[keyframe][frames][from][background][position][]',
          'value' => $this->getContext('value.keyframe.frames.from.background.position.' . $key),
          'grids' => array(
            'columns' => array(
              'mobile' => 12,
              'tablet' => 6,
              'small' => 6,
              'large' => 6,
            ),
          ),
        ))
        ->BsText(array(
          'text' => __('To', 'victheme_core'),
          'name' => $this->getContext('name') . '[keyframe][frames][to][background][position][]',
          'value' => $this->getContext('value.keyframe.frames.to.background.position.' . $key),
          'grids' => array(
            'columns' => array(
              'mobile' => 12,
              'tablet' => 6,
              'small' => 6,
              'large' => 6,
            ),
          ),
        ));

      $rows[$key][] = array(
        'attributes' => array(
          'class' => array('wp-background-picker-settings'),
        ),
        'content' => $row
      );

      // Free memory
      unset($row);

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