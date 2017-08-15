<?php
/**
 * Class for building Icon element.
 * This class will caccept the array results from
 * WpIcon and WpIconSet form.
 *
 * This class will utilize the icon data from
 * VTCore_Wordpress_Data_Icons_Library
 *
 * Valid array structure :
 * id         : unique id for css styling
 * family     : the icon family as registered in the library
 * icon       : the actual icon class
 * size       : the icon size
 * rotate     : degree value to rotate the icon element
 * spin       : spin the icon indefinetely
 * flip       : flip the icon
 * position   : the icon element position relative to the wrapper
 * border     : the border styling for the icon effect wrapper
 * shape      : the special shape for the icon effect wrapper
 * color      : the icon text color
 * background : the icon effect wrapper background color
 * lineheight : the lineheight for the icon element
 * padding    : the inner padding for the effect wrapper
 * margin     : the margin for the effect wrapper
 *
 * Markup results :
 *
 * // Unique class id will be applied here
 * <div class="wp-icons-wrapper">
 *
 *  // Border, positioning, background, spin, shape, padding and margin css will be applied here
 *  <span class="wp-icons-effect">
 *
 *    // the icon elements, lineheight, flip, size, icon, rotate and color css will be applied here
 *    <i />  / <span></span>
 *  </span>
 * <div>
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Wordpress_Element_WpIcon
extends VTCore_Wordpress_Models_Element {

  protected $context = array(
    'type' => 'div',
    'id' => '',
    'family' => 'fontawesome',
    'icon' => false,
    'flip' => false,
    'size' => '',
    'spin' => false,
    'rotate' => '',
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
    'attributes' => array(
      'class' => array(
        'wp-icons-wrapper',
        'clearfix',
      ),
    ),
    'inline_style' => false,
    'inner_elements' => array(
      'attributes' => array(
        'class' => array(
          'wp-icons-effect',
        )
      )
    )
  );

  protected $booleans = array(
    'spin',
  );

  // Direct css class injection
  protected $classes = array(
    'flip',
    'spin',
    'shape',
    'position',
  );

  protected $styles = array(
    'rotate',
    'size',
    'border',
    'color',
    'background',
    'lineheight',
    'padding',
    'margin',
  );

  protected $styling = '';


  // Cache library for performance!
  protected static $library;

  public function buildElement() {

    // Build the unique id when needed
    if (!$this->getContext('id')) {
      $this->addContext('id', uniqid('vtcore-icon-element-'));
    }

    // Boot library object when needed
    if (empty(self::$library)) {
      self::$library = new VTCore_Wordpress_Data_Icons_Library();
    }

    // Load required css assets
    VTCore_Wordpress_Utility::loadAsset('wp-icons-front');
    VTCore_Wordpress_Utility::loadAsset(
      self::$library->get($this->getContext('family') . '.asset')
    );

    // Fix that icon will have minimum height as set by size.
    $lineheight = $this->getContext('lineheight');
    if (empty($lineheight) && $this->getContext('size')) {
      $this->addContext('lineheight', $this->getContext('size'));
    }

    // Build the Icon
    $this
      ->buildIconClasses()
      ->buildIconStyling()
      ->addContext('attributes.class.id', $this->getContext('id'))
      ->addAttributes($this->getContext('attributes'))
      ->addChildren(new VTCore_Html_Element(array(
        'type' => 'span',
        'attributes' => array(
          'class' => array(
            'wp-icons-effect',
          ),
        )
      )))
      ->lastChild()
      ->addChildren(new VTCore_Html_Element(array(
        'type' => self::$library->get($this->getContext('family') . '.element'),
        'attributes' => array(
          'class' => array(
            'wp-icons',
            self::$library->get($this->getContext('family') . '.base'),
            self::$library->get($this->getContext('family') . '.prefix') . $this->getContext('icon'),
          )
        )
      )));

    // Force to load the icon family asset
    if ($this->getContext('inline_asset')) {
      $this
        ->addChildren(new VTCore_Html_Link(array(
          'attributes' => array(
            'type' => 'text/css',
            'href' => VTCore_Wordpress_Init::getFactory('assets')
              ->get('library')
              ->get( self::$library->get($this->getContext('family') . '.asset') . '.css.' .  self::$library->get($this->getContext('family') . '.asset') . '-css.url'),
          ),
        )));
    }

    // Inject custom styling if available
    if (!empty($this->styling)) {

      if (!VTCore_Wordpress_Init::getFactory('assets')) {
        $this-addContext('inline_style', true);
      }

      if ($this->getContext('inline_style')) {
        $this
          ->addChildren(new VTCore_Html_Style())
          ->lastChild()
          ->addChildren($this->styling);
      }
      else {
        VTCore_Wordpress_Init::getFactory('assets')
          ->get('library')
          ->add('wp-icons-front.css.wp-icons-front-css.dynamic.' . $this->getContext('id'), $this->styling);

        // Bug Fix only one asset ever queued
        // Force to requeue updated library
        VTCore_Wordpress_Init::getFactory('assets')
          ->get('queues')
          ->removeProcessed('wp-icons-front')
          ->add('wp-icons-front', array('footer' => true));
      }
    }

    return $this;
  }
  



  protected function buildIconStyling() {
    foreach ($this->styles as $key) {
      $value = $this->getContext($key);
      if (empty($value)) {
        continue;
      }

      switch ($key) {
        case 'rotate' :

          if (strpos('deg', $value) === false) {
            $value = $value . 'deg';
          }

          $object = new VTCore_CSSBuilder_Factory(array(
            '.' . $this->getContext('id') . ' > .wp-icons-effect > .wp-icons'
          ));
          $object
            ->Transform(array(
              'rotate' => $value,
            ));
          break;

        case 'lineheight' :
        case 'color' :
        case 'size' :

          if ($key == 'lineheight') {
            $key = 'height';
          }

          $object = new VTCore_CSSBuilder_Factory(array(
            '.' . $this->getContext('id') . ' > .wp-icons-effect > .wp-icons'
          ));
          $object
            ->Font(array(
              $key => $value,
            ));

          break;

        case 'padding' :
        case 'margin' :
        case 'background' :

          $object = new VTCore_CSSBuilder_Factory(array(
            '.' . $this->getContext('id') . ' > .wp-icons-effect'
          ));
          $object
            ->Abstract(array(
              $key => $value,
            ));
          break;

        case 'border' :

          $value = array_filter($value);
          if (!empty($value)) {
            $object = new VTCore_CSSBuilder_Factory(array(
              '.' . $this->getContext('id') . ' > .wp-icons-effect'
            ));
            $object
              ->Border($value);
          }
          break;
      }

      if (isset($object)) {
        $this->styling .= $object->__toString();
      }
    }

    return $this;
  }


  protected function buildIconClasses() {
    foreach ($this->classes as $key) {
      if ($this->getContext($key)) {
        $value = $this->getContext($key);
        if (empty($value)) {
          continue;
        }

        if ($key == 'position' && strpos($value, 'text-') === false) {
          $value = 'text-' . $value;
        }
        $this->addContext('attributes.class.' . $key, is_bool($value) ? $key : $value);
      }
    }

    return $this;
  }
}