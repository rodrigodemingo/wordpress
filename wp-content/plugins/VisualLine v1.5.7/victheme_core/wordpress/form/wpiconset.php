<?php
/**
 * Helper class for building WP Icon Set Form
 * with preview, picker, sizing, styling and border
 *
 * For a single picker use WpIcon instead.
 *
 * The icon will be taken from the VTCore_Wordpress_Data_Icons_Library.
 *
 * @note this will build inline style by default, double check with plugins!
 * @author jason.xie@victheme.com
 */
class VTCore_Wordpress_Form_WpIconSet
extends VTCore_Bootstrap_Element_BsTabs {

  protected $context = array(
    'type' => 'div',
    'text' => '',
    'name' => '',
    'value' => array(
      'family' => 'fontawesome',
      'icon' => false,
      'flip' => false,
      'size' => '',
      'spin' => false,
      'rotate' => false,
      'position' => '',
      'border' => array(
        'width' => false,
        'style' => false,
        'color' => false,
        'radius' => false,
      ),
      'shape' => '',
      'color' => '',
      'background' => '',
      'lineheight' => '',
      'padding' => '',
      'margin' => '',
    ),
    'description' => false,
    'attributes' => array(
      'class' => array(
        'form-wpiconset',
        'form-group',
        'tabs-wrapper',
      ),
    ),
    'contents' => array(),
    'active' => 0,
    'prefix' => 'tabs-wpicon',
    'build' => array(
      'preview' => true,
      'picker' => true,
      'sizing' => true,
      'styling' => true,
      'border' => true,
    ),

    'ul_elements' => array(
      'attributes' => array(
        'class' => array(
          'nav',
          'nav-tabs'
        ),
      ),
    ),

    'link_elements' => array(
      'attributes' => array(
        'data-toggle' => 'tab',
      ),
    ),

    'tabs_elements' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array(
          'tab-content',
          'clearfix',
        ),
      ),
    ),

    'tabcontent_elements' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array(
          'tab-pane',
          'fade',
        ),
      ),
    ),
  );

  protected $unique = '';
  private $activeDelta = 0;

  /**
   * Overriding HTML object build element to build the
   * special element for WP Media Form
   *
   * @see VTCore_Html_Base::buildElement()
   */
  public function buildElement() {

    // Load default assets
    VTCore_Wordpress_Utility::loadAsset('wp-bootstrap');
    VTCore_Wordpress_Utility::loadAsset('wp-ajax');
    VTCore_Wordpress_Utility::loadAsset('wp-icons');


    $uid = new VTCore_Uid();
    $this->addAttributes($this->getContext('attributes'));
    $this->unique = $this->getContext('prefix') . '-' . $uid->getID();
    $this->addContext('attributes.id', 'form-' . $this->unique);

    $this->setChildren(array(
      'top-element' => new VTCore_Html_Element(),
      'header-element' => new VTCore_Html_List($this->getContext('ul_elements')),
      'content-element' => new VTCore_Bootstrap_Element_BsElement($this->getContext('tabs_elements')),
    ));

    $this->top = $this->getChildren('top-element');
    $this->header = $this->getChildren('header-element');
    $this->content = $this->getChildren('content-element');

    $this->header->addAttribute('id', 'list-' . $this->unique);

    if (!$this->getContext('ajax-id')) {
      $this->addContext('ajax-id', 'vtcore-icon-element-' . $this->getMachineID());
    }

    // Form label
    if ($this->getContext('text')) {
      $this->top
        ->addChildren(new VTCore_Form_Label(array(
          'text' => $this->getContext('text'),
          'attributes' => array(
            'for' => 'wp-media-' . $this->getMachineID(),
          ),
        )));
    }

    // Form Description
    if ($this->getContext('description')) {
      $this->top
        ->addChildren(new VTCore_Bootstrap_Form_BsDescription(array(
          'text' => $this->getContext('description'),
        )));
    }

    // Build the preview
    if ($this->getContext('build.preview')) {
      $this->top
        ->addChildren(new VTCore_Html_Element(array(
          'type' => 'div',
          'data' => array(
            'id' => 'preview',
            'icon-preview' => $this->getContext('ajax-id'),
          ),
          'attributes' => array(
            'class' => array(
              'wp-icon-picker-preview',
            ),
          ),
        )));

      if ($this->getContext('value.icon')) {
        $this->addContext('value.inline_style', false);

        // When on ajax no way to attach the custom styling plus font asset!
        if (defined('DOING_AJAX') && DOING_AJAX) {
          $this->addContext('value.inline_style', true)->addContext('value.inline_asset', true);
        }

        $this->top
          ->lastChild()
          ->addChildren(new VTCore_Wordpress_Element_WpIcon($this->getContext('value')));
      }

      $this->addClass('with-preview');

      VTCore_Wordpress_Utility::loadAsset('wp-icons-front');
    }

    if ($this->getContext('build.picker')) {
      $object = new VTCore_Wordpress_Form_WpIcon(array(
        'name' => $this->getContext('name'),
        'value' => $this->getContext('value'),
        'limit' => 10000,
        'id' => $this->getContext('ajax-id'),
      ));

      $this
        ->addHeader(__('Icon', 'victheme_core'))
        ->addContent($object)
        ->setDelta();
    }

    if ($this->getContext('build.sizing')) {

      $object = new VTCore_Bootstrap_Element_BsElement(array(
        'contextid' => 'sizing',
      ));
      $object
        ->addChildren(new VTCore_Bootstrap_Form_BsText(array(
          'text' => __('Size', 'victheme_core'),
          'name' => $this->getContext('name') . '[size]',
          'value' => $this->getContext('value.size'),
          'description' => __('Set the icon size using pixel or em, eg. 12px or 12em', 'victheme_core'),
        )))
        ->addChildren(new VTCore_Bootstrap_Form_BsSelect(array(
          'text' => __('Flip', 'victheme_core'),
          'name' => $this->getContext('name') . '[flip]',
          'value' => $this->getContext('value.flip'),
          'description' => __('Flip the icon using css3 transform method.', 'victheme_core'),
          'options' =>  array(
            false => __('None', 'victheme_core'),
            'horizontal' => __('Horizontal', 'victheme_core'),
            'vertical' => __('Vertical', 'victheme_core'),
          ),
        )))
        ->addChildren(new VTCore_Bootstrap_Form_BsSelect(array(
          'text' => __('Spin', 'victheme_core'),
          'name' => $this->getContext('name') . '[spin]',
          'value' => $this->getContext('value.spin'),
          'description' => __('Spin the icon using css3 spin effect', 'victheme_core'),
          'options' =>  array(
            false => __('No', 'victheme_core'),
            true => __('Yes', 'victheme_core'),
          ),
        )))
        ->addChildren(new VTCore_Bootstrap_Form_BsText(array(
          'text' => __('Rotate', 'victheme_core'),
          'suffix' => 'degree',
          'name' => $this->getContext('name') . '[rotate]',
          'value' => $this->getContext('value.rotate'),
          'description' => __('Rotate the icon using css3 transform rotate, enter the value in the degree', 'victheme_core'),
        )));

      $this
        ->addHeader(__('Settings', 'victheme_core'))
        ->addContent($object)
        ->setDelta();
    }

    if ($this->getContext('build.styling')) {

      $object = new VTCore_Bootstrap_Element_BsElement(array(
        'contextid' => 'styling',
      ));
      $object
        ->addChildren(new VTCore_Bootstrap_Form_BsColor(array(
          'text' => __('Icon Color', 'victheme_core'),
          'name' => $this->getContext('name') . '[color]',
          'value' => $this->getContext('value.color'),
          'description' => __('Choose the icon color', 'victheme_core'),
          'data' => array(
            'container' => true,
          ),
        )))
        ->addChildren(new VTCore_Bootstrap_Form_BsColor(array(
          'text' => __('Background Color', 'victheme_core'),
          'name' => $this->getContext('name') . '[background]',
          'value' => $this->getContext('value.background'),
          'description' => __('Choose the background color for the icon wrapper', 'victheme_core'),
          'data' => array(
            'container' => true,
          ),
        )))
        ->addChildren(new VTCore_Bootstrap_Form_BsText(array(
          'text' => __('Line Height', 'victheme_core'),
          'name' => $this->getContext('name') . '[lineheight]',
          'value' => $this->getContext('value.lineheight'),
          'description' => __('Adjust the icon line height', 'victheme_core'),
        )))
        ->addChildren(new VTCore_Bootstrap_Form_BsText(array(
          'text' => __('Padding', 'victheme_core'),
          'name' => $this->getContext('name') . '[padding]',
          'value' => $this->getContext('value.padding'),
          'description' => __('Adjust the icon inner padding, eg. 10px 10px 10px 10px', 'victheme_core'),
        )))
        ->addChildren(new VTCore_Bootstrap_Form_BsText(array(
          'text' => __('Margin', 'victheme_core'),
          'name' => $this->getContext('name') . '[margin]',
          'value' => $this->getContext('value.margin'),
          'description' => __('Adjust the icon margin, eg. 10px 10px 10px 10px', 'victheme_core'),
        )))
        ->addChildren(new VTCore_Bootstrap_Form_BsSelect(array(
          'text' => __('Position', 'victheme_core'),
          'name' => $this->getContext('name') . '[position]',
          'value' => $this->getContext('value.position'),
          'description' => __('Select the position of the icon relative to the icon wrapper.', 'victheme_core'),
          'options' =>  array(
            false => __('None', 'victheme_core'),
            'text-left' => __('Left', 'victheme_core'),
            'text-right' => __('Right', 'victheme_core'),
            'text-center' => __('Center', 'victheme_core'),
          ),
        )))
        ->addChildren(new VTCore_Bootstrap_Form_BsSelect(array(
          'text' => __('Shape', 'victheme_core'),
          'name' => $this->getContext('name') . '[shape]',
          'value' => $this->getContext('value.shape'),
          'description' => __('Choose the shape of this icon wrapper', 'victheme_core'),
          'options' =>  apply_filters('vtcore_wordpress_icon_shape', array(
            false => __('None', 'victheme_core'),
            'circle' => __('Circle', 'victheme_core'),
            'round' => __('Rounded', 'victheme_core'),
            'diamond' => __('Diamond', 'victheme_core'),
          )),
        )));

      $this
        ->addHeader(__('Styling', 'victheme_core'))
        ->addContent($object)
        ->setDelta();
      
    }

    if ($this->getContext('build.border')) {

      $object = new VTCore_Bootstrap_Element_BsElement(array(
        'contextid' => 'border',
      ));
      $object
        ->addChildren(new VTCore_Bootstrap_Form_BsText(array(
          'text' => __('Width', 'victheme_core'),
          'name' => $this->getContext('name') . '[border][width]',
          'description' => __('Input the icon border size width in pixel. eg 1px', 'victheme_core'),
          'value' => $this->getContext('value.border.width'),
        )))
        ->addChildren(new VTCore_Bootstrap_Form_BsSelect(array(
          'text' => __('Style', 'victheme_core'),
          'description' => __('Select the border style', 'victheme_core'),
          'name' => $this->getContext('name') . '[border][style]',
          'value' => $this->getContext('value.border.style'),
          'options' => array(
            '' => __('Not set', 'victheme_core'),
            'none' => __('None', 'victheme_core'),
            'inherit' => __('Inherit', 'victheme_core'),
            'solid' => __('Solid', 'victheme_core'),
            'dotted' => __('Dotted', 'victheme_core'),
            'dashed' => __('Dashed', 'victheme_core'),
            'double' => __('Double', 'victheme_core'),
            'ridge' => __('Ridge', 'victheme_core'),
            'inset' => __('Inset', 'victheme_core'),
            'outset' => __('Outset', 'victheme_core'),
            'groove' => __('Groove', 'victheme_core'),
          )
        )))
        ->addChildren(new VTCore_Bootstrap_Form_BsColor(array(
          'text' => __('Color', 'victheme_core'),
          'name' => $this->getContext('name') . '[border][color]',
          'description' => __('Choose the border color', 'victheme_core'),
          'value' => $this->getContext('value.border.color'),
          'data' => array(
            'container' => true,
          ),
        )))
        ->addChildren(new VTCore_Bootstrap_Form_BsText(array(
          'text' => __('Radius', 'victheme_core'),
          'name' => $this->getContext('name') . '[border][radius]',
          'description' => __('Set the border radius in the format of top left, top right, bottom right and bottom left eg. 1px 2px 3px 4px', 'victheme_core'),
          'value' => $this->getContext('value.border.radius'),
        )));

      $this
        ->addHeader(__('Border', 'victheme_core'))
        ->addContent($object)
        ->setDelta();
    }

    $this->setActiveTabs();

  }



}