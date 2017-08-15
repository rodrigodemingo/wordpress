<?php
/**
 * Class for extending WpLoop to build a carousel element
 * using slick carousel javascript instead of an isotope element.
 *
 * WP_QUERY OBJECT
 * ===============
 * 1. Direct WP_Query object injection via context
 *    with key query
 *
 * 2. Fallback to global $wp_query on non single page
 *    if no Direct WP Query Object defined and no
 *    queryArgs defined
 *
 * 3. Build a new WP_Query Object if it cannot use
 *    Direct or Global WP_Query object, provided
 *    user specify the WP_Query object args via
 *    queryArgs context.
 *
 * Without valid object, the class will not produce any markups
 *
 * AJAX (not yet implemented)
 * ====
 * This class is compatible with wp-ajax.js to invoke the integration
 * witht wp-ajax, it will need the :
 *
 *   $context['ajax'] = true;
 *
 * GRIDS
 * =====
 *
 * The class will provide columns object for processing
 * bootstrap object grids defined in context into a valid
 * css class for the bootstrap grids.
 *
 * The object can be accessed via $this->getContext('object.columns')->getClass()
 * when in template or directly injected to object when template is specified
 * as a valid VTCore_Html_Base object (or its children).
 *
 *
 * SLICK CAROUSEL
 * ==============
 *
 * This class is capable to invoking slick carousel js directly if user
 * specifies the correct carousel options via context['slick']
 *
 * TEMPLATING
 * ==========
 *
 * This class supports :
 * 1. Pure php file as template
 * 2. VTCore_Html_Base child objects as template
 * 3. class name for valid VTCore_Html_Base as template
 *
 * user should define the template in the context :
 *
 * $context['template']['items'] = the template for items inside the loop
 * $context['template']['empty'] = the template when loop found no posts.
 *
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Element_WpCarousel
extends VTCore_Wordpress_Element_WpLoop {

  protected $context = array(
    'type' => 'div',
    'attributes' => array(
      'class' => array(
        'wp-carousel',
        //'slick-carousel', // Autoload via js
      ),
    ),

    // Slick options
    'slick' => array(
      'accessibility' => true,
      'autoplay' => false,
      'autoplaySpeed' => 3000,
      'arrows' => true,
      'dots' => true,
      'centerMode' => false,
      'centerPadding' => '50px',
      'cssEase' => 'ease',
      'draggable' => true,
      'fade' => false,
      'easing' => 'linear',
      'infinite' => true,
      //'lazyLoad' => 'ondemand',
      'pauseOnHover' => true,
      //'slidesToShow' => 1, // disabling this will invoke auto format based on grid
      'slidesToScroll' => 1,
      'speed' => 300,
      'swipe' => true,
      'touchMove' => true,
      'touchThreshold' => 5,
      'vertical' => false,
      'variableWidth' => false,
      'adaptiveHeight' => false,
      'lazyloader' => false,
    ),

    'breakpoints' => array(
      'mobile' => 768,
      'tablet' => 990,
      'small' => 1199,
    ),

    // Direct markup inject via markup context
    'contents' => array(),
    'content_element' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array('slick-items'),
      ),
    ),

    // WpLoop Contexts
    'id' => false,
    'query' => false,
    'queryMain' => false,
    'queryArgs' => array(),

    // @todo Implement Slick carousel ajax to wploop integration
    'ajax' => false,
    'ajaxData' => array(
      'ajax-mode' => 'selfData',
      'ajax-object' => 'carousel',
      'ajax-loading-text' => 'Loading...',
      'ajax-target' => false,
      'ajax-action' => 'vtcore_ajax_framework',
      'ajax-value' => 'carousel',
      'ajax-queue' => array(
        'replace',
      ),
    ),

    'grids' => array(
      'columns' => array(
        'mobile' => 12,
        'tablet' => 6,
        'small' => 4,
        'large' => 3,
      ),
    ),

    'template' => array(
      'items' => false,
      'empty' => false,
    ),

    'custom' => array(),

    'loopQuery' => array(),

    // Build data-filter with related taxonomy terms as value
    'filters' => false,

    // Allow user to disable the automated build
    // process items via context args.
    'process' => array(
      'query' => true,
      'filter' => true,
      'isotope' => true,
      'ajax' => true,
      'loop' => true,
      'queryform' => false,
    ),

    'convert_grids' => true,

  );

  protected $booleans = array(
    'slick.accessibility',
    'slick.autoplay',
    'slick.arrows',
    'slick.dots',
    'slick.centerMode',
    'slick.draggable',
    'slick.fade',
    'slick.infinite',
    'slick.pauseOnHover',
    'slick.swipe',
    'slick.touchMove',
    'slick.vertical',
    'slick.variableWidth',
    'slick.adaptiveHeight',
    'slick.lazyloader',
  );


  protected $int = array(
    'slick.slidesToShow',
    'slick.slidesToScroll',
    'slick.speed',
    'slick.touchTreshold',
    'slick.autoplaySpeed',
  );


  /**
   * Overriding parent
   * @param array $context
   */
  public function buildObject($context) {

    $object = new VTCore_Wordpress_Objects_Array($context);

    // Convert to booleans
    foreach ($this->booleans as $key) {
      if ($object->get($key)) {
        $object->mutate($key, filter_var($object->get($key), FILTER_VALIDATE_BOOLEAN));
      }
    }

    foreach ($this->int as $key) {
      if ($object->get($key)) {
        $object->mutate($key, (int) $object->get($key));
      }
    }

    $context = $object->extract();

    // Populate $this->context
    parent::buildObject($context);

    $this->processBooleans();

  }


  /**
   * Preparing for slick carousel
   */
  protected function prepareSlick() {

    VTCore_Wordpress_Utility::loadAsset('jquery-slick');
    $this->addClass('slick-carousel');

    // Fade mode can only slide a single items and not compatible
    // with centerMode, variable width and the grid system!
    if ($this->getContext('slick.fade')) {
      $this->addContext('slick.slidesToScroll', 1);
      $this->addContext('slick.slidesToShow', 1);
      $this->addContext('slick.centerMode', false);
      $this->removeContext('grids');
      $this->addContext('slick.variableWidth', false);
    }

    // Adaptive height can only show a single slide
    if ($this->getContext('slick.adaptiveHeight')) {
      $this->addContext('slick.slidesToShow', 1);
      $this->addContext('slick.slidesToScroll', 1);
    }

    // Auto format slides to show
    if ($this->getContext('grids.columns.large')
        && !$this->getContext('slick.slidesToShow')
        && !$this->getContext('slick.fade')) {

      if ($this->getContext('convert_grids')) {
        $this->addContext('slick.slidesToShow', (int) 12 / $this->getContext('grids.columns.large'));
      }
      else {
        $this->addContext('slick.slidesToShow', (int) $this->getContext('grids.columns.large'));
      }

      // Automated grid cannot use variable width!
      $this->addContext('slick.variableWidth', false);
    }

    // Auto format responsiveness
    if (!$this->getContext('slick.resposive')
        && !$this->getContext('slick.fade')
        && $this->getContext('grids.columns')) {

      $responsive = array();
      foreach ($this->getContext('grids.columns') as $mediaSize => $size) {

        if (!$this->getContext('breakpoints.' . $mediaSize)) {
          continue;
        }

        $object = new stdClass();
        $object->breakpoint = $this->getContext('breakpoints.' . $mediaSize);
        $object->settings = new stdClass();

        if ($this->getContext('convert_grids')) {
          $object->settings->slidesToShow = (int) 12 / $size;
        }
        else {
          $object->settings->slidesToShow = (int) $size;
        }

        // Don't use center mode on small screen
        if ($size == 12 && $mediaSize == 'mobile') {
          $object->settings->centerMode = false;
        }

        $responsive[] = $object;
      }

      if (!empty($responsive)) {
        $this->addContext('slick.responsive', $responsive);
      }
    }

    if ($this->getContext('convert_grids')) {
      $this->addContext('content_element.grids', $this->getContext('grids'));
    }
    $this->removeContext('grids');

    $this->addData('settings', $this->getContext('slick'));

    if ($this->getContext('ajax')) {
      $this->addData('ajax-marker', array(
        'slick' => true,
        'id' => $this->getContext('id'),
        'mode' => 'wp-loop',
      ));
    }

    $this->addAdditionalStylingClass();

    return $this;
  }



  /**
   * Overriding parent method
   *
   * This is where the main logic invocation
   * for building the loop object.
   *
   * It is advisable to extends other method
   * when trying to customize this object and
   * leave this main logic intact if possible.
   *
   * @see VTCore_Html_Base::buildElement()
   */
  public function buildElement() {

    parent::buildElement();

    $this->prepareSlick();

    foreach ($this->getContext('contents') as $content) {
      $this->addSlide($content);
    }

    return $this;
  }


  /**
   * Helper function for detecting template.
   * Detection sequence :
   * 1. Valid PHP file - include the file
   * 2. Valid HTML Object - direct include
   * 3. Valid HTML class  - build new object and direct include
   *
   * Overriding parent method to use addSlide instead of addChildren
   * method for injecting the carousel slide.
   */
  protected function buildTemplate($template) {

    global $post;

    if (is_string($template)
      && strpos($template, '.php') !== false) {

      // Template can access $this for retrieiving context
      // and information.
      ob_start();
      include VTCore_Wordpress_Utility::locateTemplate($template);
      $content = ob_get_clean();

      if ($this->getContext('slick.lazyloader')) {
        $content = str_replace(' srcset="', ' data-srcset="', $content);
        $content = str_replace(' src="', ' data-lazy="', $content);
      }

      $this->addSlide($content, $post);
    }

    // Direct inject if template is VTCore object
    elseif (is_object($template)
      && $template instanceof VTCore_Html_Base) {

      $this->addSlide($template, $post);

    }

    // Try to build a new object if the template
    // is  a class name.
    elseif (class_exists($template, true)) {
      $this->addSlide(new $template(array('grids' => $this->getContext('grids'))), $post);
    }

    return $this;
  }


  /**
   * Allow user to inject slide object or context array
   * after the object created
   *
   * @param $object
   * @return $this
   */
  public function addSlide($object, $post = false) {

    if (is_array($object)) {
      $object = new VTCore_VTCore_Bootstrap_Element_BsElement($object);
    }

    $arguments = new VTCore_Wordpress_Objects_Array($this->getContext('content_element'));

    $filters = (array) $this->getContext('filters');

    if (!empty($filters) && isset($post->ID)) {

      $filterTax = new VTCore_Wordpress_Objects_Array();

      foreach ($filters as $taxonomy) {
        $terms = wp_get_post_terms((int) $post->ID, trim($taxonomy));

        if (!is_wp_error($terms)) {
          foreach ($terms as $term) {
            $filterTax->add('terms.' . $term->term_id, $term->term_id);
          }
        }
      }

      if ($filterTax->get('terms')) {
        $arguments->add('data.filter', implode(', ',$filterTax->get('terms')));
      }
    }

    $this
      ->addChildren(new VTCore_Bootstrap_Element_BsElement($arguments->extract()))
      ->lastChild()
      ->addChildren($object);

    $arguments = null;
    unset($arguments);

    return $this;
  }


  /**
   * Additional class for styling purposes only.
   */
  protected function addAdditionalStylingClass() {
    if ($this->getContext('slick.centerMode')) {
      $this->addClass('slick-centermode');
    }

    if ($this->getContext('slick.variableWidth')) {
      $this->addClass('slick-variablewidth');
    }
  }
}