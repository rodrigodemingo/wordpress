<?php
/**
 * Building form for configuring Fotorama Element
 *
 * The output will be valid arrays for use with
 * VTCore_Wordpress_Element_WpFotorama object
 *
 *
 * @author jason.xie@victheme.com
 * @method WpFotorama($context)
 * @see VTCore_Html_Form interface
 */
class VTCore_Wordpress_Form_WpFotorama
extends VTCore_Bootstrap_Form_Base
implements VTCore_Form_Interface {

  protected $context = array(

    // Wrapper element
    'type' => 'div',
    'attributes' => array(
      'class' => array(
        'form-multi-group',
        'wp-fotorama-form'
      ),
    ),

    // Shortcut method
    // @see VTCore_Bootstrap_Form_Base::assignContext()
    'text' => false,
    'description' => false,

    'name' => false,
    'id' => false,
    'class' => array('form-control'),

    // Bootstrap Rules
    'label' => true,

    // Array of values, User should
    // populate this when injecting
    // values to the form.
    'fotorama' => array(

      // Dimensions
      'width' => '',
      'height' => '',
      'ratio' => '',
      'minwidth' => '',
      'maxwidth' => '',
      'minheight' => '',
      'maxheight' => '',
      'captions' => false,
      'margin' => '',
      'glimpse' => '',

      // Animations
      'loop' => true,
      'shuffle' => true,
      'startindex' => '',
      'autoplay' => '',
      'stopautoplayontouch' => true,
      'shadows' => true,
      'transition' => 'slide', // slide | crossfade | disolve
      'clicktransition' => 'crossfade', // slide | crossfade | disolve
      'transitionduration' => '',

      // Key operations
      'arrows' => 'true',
      'keyboard' => true,
      'click' => true,
      'swipe' => true,
      'trackpad' => true,


      // Navigations
      'navposition' => 'bottom', // bottom | top
      'direction' => 'rtl', // rtl || ltr
      'nav' => 'thumbs', // false | thumbs | dot
      'navwidth' => '',

      // Full screens
      'allowfullscreen' => 'false', // false | true | native

      // Thumbnails
      'thumbwidth' => '80',
      'thumbheight' => '80',
      'thumbmargin' => '',
      'thumbborderwidth' => '',

      // Image fitting
      'fit' => 'contain', // contain | cover | scaledown | none
      'thumbfit' => 'cover', // contain | cover | scaledown | none
    ),
  );


  private $accordion;
  private $object;


  /**
   * Overriding parent method
   */
  protected function assignContext() {

    if ($this->getContext('value')) {
      $this->mergeContext(array('fotorama' => $this->getContext('value')));
    }

    parent::assignContext();
  }


  /**
   * Method for generating fotorama form element name attributes
   */
  private function convertElementName($key) {
    return $this->getContext('name') . '[fotorama][' . $key . ']';
  }



  /**
   * Overriding parent method
   * @see VTCore_Html_Base::buildElement()
   */
  public function buildElement() {

    parent::buildElement();

    if ($this->getContext('label_elements')) {
      $this->Label($this->getContext('label_elements'));
    }

    if ($this->getContext('description_elements')) {
      $this->addChildren(new VTCore_Bootstrap_Form_BsDescription(($this->getContext('description_elements'))));
    }

    $this->accordion = $this->BsAccordion(array(
        'active' => 'dimension',
      ))
      ->lastChild();

    $this->object = new VTCore_Bootstrap_Form_Base();

    // Dimension Panel
    $this->object
      ->BsRow()
      ->lastChild()
      ->BsText(array(
        'text' => __('Min Width', 'victheme_core'),
        'description' => __('Stage container minimum width in pixels or percents.', 'victheme_core'),
        'name' => $this->convertElementName('minwidth'),
        'value' => $this->getContext('fotorama.minwidth'),
        'validators' => array(
          'csssize' => __('Invalid size.', 'victheme_core'),
        ),
        'grids' => array(
          'columns' => array(
            'mobile' => '12',
            'tablet' => '4',
            'small' => '4',
            'large' => '4',
          ),
        ),
      ))
      ->BsText(array(
        'text' => __('Width', 'victheme_core'),
        'description' => __('Stage container width in pixels or percents.', 'victheme_core'),
        'name' => $this->convertElementName('width'),
        'value' => $this->getContext('fotorama.width'),
        'validators' => array(
          'csssize' => __('Invalid size.', 'victheme_core'),
        ),
        'grids' => array(
          'columns' => array(
            'mobile' => '12',
            'tablet' => '4',
            'small' => '4',
            'large' => '4',
          ),
        ),
      ))
      ->BsText(array(
        'text' => __('Max Width', 'victheme_core'),
        'description' => __('Stage container maximum width in pixels or percents.', 'victheme_core'),
        'name' => $this->convertElementName('maxwidth'),
        'value' => $this->getContext('fotorama.maxwidth'),
        'validators' => array(
          'csssize' => __('Invalid size.', 'victheme_core'),
        ),
        'grids' => array(
          'columns' => array(
            'mobile' => '12',
            'tablet' => '4',
            'small' => '4',
            'large' => '4',
          ),
        ),
      ))
      ->getParent()
      ->BsRow()
      ->lastChild()
      ->BsText(array(
        'text' => __('Min Height', 'victheme_core'),
        'description' => __('Stage container minimum height in pixels or percents.', 'victheme_core'),
        'name' => $this->convertElementName('minheight'),
        'value' => $this->getContext('fotorama.minheight'),
        'validators' => array(
          'csssize' => __('Invalid size.', 'victheme_core'),
        ),
        'grids' => array(
          'columns' => array(
            'mobile' => '12',
            'tablet' => '4',
            'small' => '4',
            'large' => '4',
          ),
        ),
      ))
      ->BsText(array(
        'text' => __('Height', 'victheme_core'),
        'description' => __('Stage container height in pixels or percents.', 'victheme_core'),
        'name' => $this->convertElementName('height'),
        'value' => $this->getContext('fotorama.height'),
        'validators' => array(
          'csssize' => __('Invalid size.', 'victheme_core'),
        ),
        'grids' => array(
          'columns' => array(
            'mobile' => '12',
            'tablet' => '4',
            'small' => '4',
            'large' => '4',
          ),
        ),
      ))
      ->BsText(array(
        'text' => __('Max Height', 'victheme_core'),
        'description' => __('Stage container maximum height in pixels or percents.', 'victheme_core'),
        'name' => $this->convertElementName('maxheight'),
        'value' => $this->getContext('fotorama.maxheight'),
        'validators' => array(
          'csssize' => __('Invalid size.', 'victheme_core'),
        ),
        'grids' => array(
          'columns' => array(
            'mobile' => '12',
            'tablet' => '4',
            'small' => '4',
            'large' => '4',
          ),
        ),
      ));

    $this->accordion->addPanel('dimension', array(
      'title' => __('Dimension', 'victheme_core'),
      'content' => $this->object->getChildrens(),
    ));


    // Media Panel
    $this->object
    ->resetChildren()
    ->BsRow()
    ->lastChild()
    ->BsCheckbox(array(
      'text' => __('Captions', 'victheme_core'),
      'description' => __('Captions visibility.', 'victheme_core'),
      'name' => $this->convertElementName('captions'),
      'checked' => (boolean) $this->getContext('fotorama.captions'),
      'switch' => true,
      'grids' => array(
        'columns' => array(
          'mobile' => '12',
          'tablet' => '6',
          'small' => '6',
          'large' => '6',
        ),
      ),
    ))
    ->BsCheckbox(array(
      'text' => __('Shadows', 'victheme_core'),
      'description' => __('Enables shadows.', 'victheme_core'),
      'name' => $this->convertElementName('shadows'),
      'checked' => (boolean) $this->getContext('fotorama.shadows'),
      'switch' => true,
      'grids' => array(
        'columns' => array(
          'mobile' => '12',
          'tablet' => '6',
          'small' => '6',
          'large' => '6',
        ),
      ),
    ))
    ->getParent()
    ->BsSelect(array(
      'text' => __('Allow Full Screen', 'victheme_core'),
      'description' => __('Allows fullscreen', 'victheme_core'),
      'options' => array(
        'false' => __('No Full Screen', 'victheme_core'),
        'true' => __('Allow Full Screen', 'victheme_core'),
        'native' => __('Native', 'victheme_core'),

      ),
      'name' => $this->convertElementName('allowfullscreen'),
      'value' => $this->getContext('fotorama.allowfullscreen'),
    ))
    ->BsSelect(array(
      'text' => __('Fit', 'victheme_core'),
      'description' => __('How to fit an image into a fotorama', 'victheme_core'),
      'options' => array(
        'contain' => __('Contain', 'victheme_core'),
        'cover' => __('Cover', 'victheme_core'),
        'scaledown' => __('Scale Down', 'victheme_core'),
        'none' => __('None', 'victheme_core'),
      ),
      'name' => $this->convertElementName('fit'),
      'value' => $this->getContext('fotorama.fit'),
    ))
    ->BsText(array(
      'text' => __('Ratio', 'victheme_core'),
      'description' => __('Width divided by height. Recommended if you’re using percentage width.', 'victheme_core'),
      'name' => $this->convertElementName('ratio'),
      'value' => $this->getContext('fotorama.ratio'),
    ))
    ->BsText(array(
      'text' => __('Margin', 'victheme_core'),
      'description' => __('Horizontal margins for frames in pixels.', 'victheme_core'),
      'name' => $this->convertElementName('margin'),
      'value' => $this->getContext('fotorama.margin'),
      'suffix' => 'px',
      'validators' => array(
        'number' => __('Only numeric character allowed', 'victheme_core'),
      )
    ))
    ->BsText(array(
      'text' => __('Glimpse', 'victheme_core'),
      'description' => __('Glimpse size of nearby frames in pixels or percents.', 'victheme_core'),
      'name' => $this->convertElementName('glimpse'),
      'value' => $this->getContext('fotorama.glimpse'),
      'validators' => array(
        'csssize' => __('Invalid size', 'victheme_core'),
      )
    ));

    $this->accordion->addPanel('media', array(
      'title' => __('Media', 'victheme_core'),
      'content' => $this->object->getChildrens(),
    ));

    // Navigation Panel
    $this->object
      ->resetChildren()
      ->BsRow()
      ->lastChild()
      ->BsCheckbox(array(
        'text' => __('Keyboard', 'victheme_core'),
        'description' => __('Enables keyboard navigation.', 'victheme_core'),
        'name' => $this->convertElementName('keyboard'),
        'checked' => (boolean) $this->getContext('fotorama.keyboard'),
        'switch' => true,
        'grids' => array(
          'columns' => array(
            'mobile' => '12',
            'tablet' => '6',
            'small' => '6',
            'large' => '6',
          ),
        ),
      ))

      ->BsCheckbox(array(
        'text' => __('Click', 'victheme_core'),
        'description' => __('Moving between frames by clicking.', 'victheme_core'),
        'name' => $this->convertElementName('click'),
        'checked' => (boolean) $this->getContext('fotorama.click'),
        'switch' => true,
        'grids' => array(
          'columns' => array(
            'mobile' => '12',
            'tablet' => '6',
            'small' => '6',
            'large' => '6',
          ),
        ),
      ))
      ->BsCheckbox(array(
        'text' => __('Swipe', 'victheme_core'),
        'description' => __('Moving between frames by swiping.', 'victheme_core'),
        'name' => $this->convertElementName('swipe'),
        'checked' => (boolean) $this->getContext('fotorama.swipe'),
        'switch' => true,
        'grids' => array(
          'columns' => array(
            'mobile' => '12',
            'tablet' => '6',
            'small' => '6',
            'large' => '6',
          ),
        ),
      ))
      ->BsCheckbox(array(
        'text' => __('Trackpad', 'victheme_core'),
        'description' => __('Enables trackpad support and horizontal mouse wheel as well.', 'victheme_core'),
        'name' => $this->convertElementName('trackpad'),
        'checked' => (boolean) $this->getContext('fotorama.trackpad'),
        'switch' => true,
        'grids' => array(
          'columns' => array(
            'mobile' => '12',
            'tablet' => '6',
            'small' => '6',
            'large' => '6',
          ),
        ),
      ))
      ->getParent()
      ->BsSelect(array(
        'text' => __('Nav', 'victheme_core'),
        'description' => __('Navigation style.', 'victheme_core'),
        'options' => array(
          'dots' => __('iPhone Style Dots', 'victheme_core'),
          'thumbs' => __('Thumbnails', 'victheme_core'),
          'false' => __('Nothing', 'victheme_core'),
        ),
        'name' => $this->convertElementName('nav'),
        'value' => $this->getContext('fotorama.nav'),
      ))
      ->BsText(array(
        'text' => __('Nav Width', 'victheme_core'),
        'description' => __('Navigation width.', 'victheme_core'),
        'name' => $this->convertElementName('navwidth'),
        'value' => $this->getContext('fotorama.navwidth'),
      ))
      ->BsSelect(array(
        'text' => __('Arrows', 'victheme_core'),
        'description' => __('Turns on navigation arrows over the frames.', 'victheme_core'),
        'options' => array(
          'true' => __('Enable', 'victheme_core'),
          'false' => __('Disable', 'victheme_core'),
          'always' => __('Always', 'victheme_core'),
        ),
        'name' => $this->convertElementName('arrows'),
        'value' => $this->getContext('fotorama.arrows'),
      ))
      ->BsSelect(array(
        'text' => __('Nav Position', 'victheme_core'),
        'description' => __('Navigation container position relative to stage.', 'victheme_core'),
        'options' => array(
          'false' => __('None', 'victheme_core'),
          'top' => __('Top', 'victheme_core'),
          'bottom' => __('Bottom', 'victheme_core'),

        ),
        'name' => $this->convertElementName('navposition'),
        'value' => $this->getContext('fotorama.navposition'),
      ));

    $this->accordion->addPanel('navigation', array(
      'title' => __('Navigation', 'victheme_core'),
      'content' => $this->object->getChildrens(),
    ));


    // Thumbnail panel
    $this->object
      ->resetChildren()
      ->BsText(array(
        'text' => __('Thumbnail Width', 'victheme_core'),
        'description' => __('Thumbnail width in pixels.', 'victheme_core'),
        'name' => $this->convertElementName('thumbwidth'),
        'value' => $this->getContext('fotorama.thumbwidth'),
        'suffix' => 'px',
        'validators' => array(
          'number' => __('Only numeric character allowed', 'victheme_core'),
        )
      ))
      ->BsText(array(
        'text' => __('Thumbnail Height', 'victheme_core'),
        'description' => __('Thumbnail height in pixels.', 'victheme_core'),
        'name' => $this->convertElementName('thumbheight'),
        'value' => $this->getContext('fotorama.thumbheight'),
        'suffix' => 'px',
        'validators' => array(
          'number' => __('Only numeric character allowed', 'victheme_core'),
        )
      ))
      ->BsText(array(
        'text' => __('Thumbnail Margin', 'victheme_core'),
        'description' => __('Size of thumbnail margins.', 'victheme_core'),
        'name' => $this->convertElementName('thumbmargin'),
        'value' => $this->getContext('fotorama.thumbmargin'),
        'suffix' => 'px',
        'validators' => array(
          'number' => __('Only numeric character allowed', 'victheme_core'),
        )
      ))
      ->BsText(array(
        'text' => __('Thumbnail Border Width', 'victheme_core'),
        'description' => __('Border width of the active thumbnail.', 'victheme_core'),
        'name' => $this->convertElementName('thumbborderwidth'),
        'value' => $this->getContext('fotorama.thumbborderwidth'),
        'suffix' => 'px',
        'validators' => array(
          'number' => __('Only numeric character allowed', 'victheme_core'),
        )
      ))
      ->BsSelect(array(
        'text' => __('Thumb Fit', 'victheme_core'),
        'description' => __('How to fit thumbnail into its frame', 'victheme_core'),
        'options' => array(
          'contain' => __('Contain', 'victheme_core'),
          'cover' => __('Cover', 'victheme_core'),
          'scaledown' => __('Scale Down', 'victheme_core'),
          'none' => __('None', 'victheme_core'),
        ),
        'name' => $this->convertElementName('thumbfit'),
        'value' => $this->getContext('fotorama.thumbfit'),
      ));

    $this->accordion->addPanel('thumbnail', array(
      'title' => __('Thumbnail', 'victheme_core'),
      'content' => $this->object->getChildrens(),
    ));


    // Animation Panel
    $this->object
      ->resetChildren()
      ->BsRow()
      ->lastChild()
      ->BsCheckbox(array(
        'text' => __('Loop', 'victheme_core'),
        'description' => __('Enables loop.', 'victheme_core'),
        'name' => $this->convertElementName('loop'),
        'checked' => (boolean) $this->getContext('fotorama.loop'),
        'switch' => true,
        'grids' => array(
          'columns' => array(
            'mobile' => '12',
            'tablet' => '6',
            'small' => '6',
            'large' => '6',
          ),
        ),
      ))
      ->BsCheckbox(array(
        'text' => __('Stop Autoplay on touch', 'victheme_core'),
        'description' => __('Stops slideshow at any user action with the fotorama.', 'victheme_core'),
        'name' => $this->convertElementName('stopautoplayontouch'),
        'checked' => (boolean) $this->getContext('fotorama.stopautoplayontouch'),
        'switch' => true,
        'grids' => array(
          'columns' => array(
            'mobile' => '12',
            'tablet' => '6',
            'small' => '6',
            'large' => '6',
          ),
        ),
      ))
      ->BsCheckbox(array(
        'text' => __('Shuffle', 'victheme_core'),
        'description' => __('Shuffles frames at launch.', 'victheme_core'),
        'name' => $this->convertElementName('shuffle'),
        'checked' => (boolean) $this->getContext('fotorama.shuffle'),
        'switch' => true,
        'grids' => array(
          'columns' => array(
            'mobile' => '12',
            'tablet' => '6',
            'small' => '6',
            'large' => '6',
          ),
        ),
      ))
      ->getParent()
      ->BsSelect(array(
        'text' => __('Transition', 'victheme_core'),
        'description' => __('Defines what transition to use', 'victheme_core'),
        'options' => array(
          'slide' => __('Slide', 'victheme_core'),
          'crossfade' => __('Crossfade', 'victheme_core'),
          'dissolve' => __('Dissolve', 'victheme_core'),
        ),
        'name' => $this->convertElementName('transition'),
        'value' => $this->getContext('fotorama.transition'),
      ))
      ->BsSelect(array(
        'text' => __('Click Transition', 'victheme_core'),
        'description' => __('Defines alternative transition to use on click.', 'victheme_core'),
        'options' => array(
          'slide' => __('Slide', 'victheme_core'),
          'crossfade' => __('Crossfade', 'victheme_core'),
          'dissolve' => __('Dissolve', 'victheme_core'),
        ),
        'name' => $this->convertElementName('clicktransition'),
        'value' => $this->getContext('fotorama.clicktransition'),
      ))
      ->BsSelect(array(
        'text' => __('Direction', 'victheme_core'),
        'description' => __('Sets the frames direction: ltr or rtl.', 'victheme_core'),
        'options' => array(
          'ltr' => __('Left to right', 'victheme_core'),
          'rtl' => __('Right to left', 'victheme_core'),
        ),
        'name' => $this->convertElementName('direction'),
        'value' => $this->getContext('fotorama.direction'),
      ))
      ->BsText(array(
        'text' => __('Transition Duration', 'victheme_core'),
        'description' => __('Animation length in milliseconds.', 'victheme_core'),
        'name' => $this->convertElementName('transitionduration'),
        'value' => $this->getContext('fotorama.transitionduration'),
        'suffix' => 'miliseconds',
        'validators' => array(
          'number' => __('Only numeric character allowed', 'victheme_core'),
        )
      ))
      ->BsText(array(
        'text' => __('Start Index', 'victheme_core'),
        'description' => __('Index or id of the frame that will be shown upon initialization of the fotorama.', 'victheme_core'),
        'name' => $this->convertElementName('startindex'),
        'value' => $this->getContext('fotorama.startindex'),
        'validators' => array(
          'alphanumeric' => __('Only alphanumeric character allowed', 'victheme_core'),
        ),
      ))
      ->BsText(array(
        'text' => __('Autoplay', 'victheme_core'),
        'description' => __('Enables slideshow. Turn it on with true or any interval in milliseconds.', 'victheme_core'),
        'name' => $this->convertElementName('autoplay'),
        'value' => $this->getContext('fotorama.autoplay'),
        'validators' => array(
          'alphanumeric' => __('Only alphanumeric character allowed', 'victheme_core'),
        )
      ));

    $this->accordion->addPanel('transition', array(
      'title' => __('Animation', 'victheme_core'),
      'content' => $this->object->getChildrens(),
    ));


    unset($this->accordion);

    $this->object = NULL;
    unset($this->object);
  }

}