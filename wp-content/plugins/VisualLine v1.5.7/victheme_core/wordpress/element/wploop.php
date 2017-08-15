<?php
/**
 * Object for simulating Wordpress Loop
 * this object can handle :
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
 * AJAX
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
 * ISOTOPE
 * =======
 *
 * This class is capable to invoking isotope js directly if user
 * specifies the correct isotope options via context['isotope']
 *
 * Common Isotope options
 * $context['data']['isotope-options'] = array(
 *   // This must be the same as the item defined in the template
 *   'itemSelector' => '.item',
 *
 *   // the VTCoreIsotopeTermIdFilter can be used
 *   // if you link this with WpTermList and put the matching data-term-id
 *   // attributes in the template
 *   'filter' => 'VTCoreIsotopeTermIdFilter',
 *
 *   // This probably the most used options
 *   'layoutMode' => 'fitRows',
 *
 *   // See isotope.metafizzy.co/options.html for more options
 * );
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
 * @method WpLoop
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Element_WpLoop
extends VTCore_Wordpress_Models_Element {

  protected $context = array(
    'type' => 'div',
    'attributes' => array(
      'class' => array(
        'wp-loop',
        'row',
      ),
    ),

    'id' => false,

    'query' => false,
    'queryMain' => false,
    'queryArgs' => array(),

    'ajax' => false,
    'ajaxData' => array(
      'ajax-mode' => 'selfData',
      'ajax-object' => 'loop',
      'ajax-loading-text' => 'Loading...',
      'ajax-target' => false,
      'ajax-action' => 'vtcore_ajax_framework',
      'ajax-value' => 'loop',
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

    'data' => array(
      'isotope-options' => false,
    ),
    'template' => array(
      'items' => false,
      'empty' => false,
    ),

    'custom' => array(),

    'loopQuery' => array(),

    // Allow user to disable the automated build
    // process items via context args.
    'process' => array(
      'query' => true,
      'filter' => true,
      'isotope' => true,
      'ajax' => true,
      'loop' => true,
    )

  );


  public $get;
  public $post;
  public $request;
  public $metaQuery = array('relation' => 'OR');
  public $taxQuery = array('relation' => 'OR');
  public $ajaxContext;
  protected $actionKey = 'vtcore_wordpress_loop_';


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

    // Build the container grids, use the container.grids context array
    $this->buildGrid();

    // Process query when configured to do so
    if ($this->getContext('process.query')) {

      // Attempt to autodetect which query to use
      $this->detectQueryObject();
      do_action($this->actionKey . 'detect_query', $this);

      // Break if no useful query object
      if (!$this->getContext('query')) {
        return $this;
      }
    }


    // Do the query filtering for taxonomy, metas and pagination
    if ($this->getContext('process.filter')) {

      // Preprocess the query object
      $this->preprocessQueryObject();
      do_action($this->actionKey . 'process_query', $this);


      // Finalize query object
      $this->finalizeQueryObject();
      do_action($this->actionKey . 'finalize_query', $this);

    }


    // Isotope auto loading mode
    if ($this->getContext('data.isotope-options') && $this->getContext('process.isotope')) {
      $this->prepareIsotope();
      do_action($this->actionKey . 'prepare_isotope', $this);
    }

    // Ajax mode
    if ($this->getContext('ajax') && $this->getContext('process.ajax')) {
      $this->prepareAjax();
      do_action($this->actionKey . 'prepare_ajax', $this);
    }

    // Build the markup using loop
    if ($this->getContext('process.loop')) {

      // Build the WP Loop
      $this->prepareBeforeLoop();
      do_action($this->actionKey . 'before_loop', $this);

      // Looping
      $this->doLoop();
      do_action($this->actionKey . 'after_loop', $this);
    }

    return $this;
  }


  /**
   * Method for building the grid css classes
   * @return VTCore_Bootstrap_Element_Base
   */
  public function buildGrid() {
    // Processing Grids
    if ($this->getContext('container.grids')) {
      $grids = new VTCore_Bootstrap_Grid_Column($this->getContext('container.grids'));
      $this->addClass($grids->getClass(), 'grids');
    }

    return $this;
  }



  /**
   * This method will attempt to detect the correct
   * query object. The detection is in this order :
   *
   * 1. Use the context query object if found
   * 2. Fallback to main query if defined in the context
   *    and not on single page
   * 3. Try to build new query object if the queryArgs
   *    is populated with valid query args.
   *
   * @return VTCore_Wordpress_Element_WpLoop
   */
  protected function detectQueryObject() {

    if (!$this->getContext('query')
        || $this->getContext('query') instanceof WP_Query == false) {

      // Fallback to main query
      // Only if not on single page
      if ($this->getContext('queryMain')
          && !is_singular()) {

        global $wp_query;
        $this->addContext('query', $wp_query);
      }

      // Try to build new query
      elseif ($this->getContext('queryArgs')) {

        // Detect if the array is taken directly from query form results
        $this->maybeConvertQueryArgs();
        $this->addContext('query', new WP_Query($this->getContext('queryArgs')));
      }
    }

    // Set the id marker to the query object
    // This will be available on pre_get_posts hook.
    if ($this->getContext('id') && $this->getContext('query')) {
      $this->getContext('query')->set('vtcore_queryid', $this->getContext('id'));
    }

    // Set the object marker for the query object
    // This will be available on pre_get_posts hook
    if ($this->getContext('query')) {
      $this->getContext('query')->set('vtcore_object', 'wploop');
    }

    return $this;
  }




  /**
   * Preprocess query object
   * This is useful for adding dynamic query
   * variables such as for sane pagination
   * or dynamic filter.
   *
   * If need more filtering, please extend
   * the method in an extended class.
   *
   * Always fill the $metaQuery and $taxQuery
   * for metafield and taxonomy query.
   *
   */
  protected function preprocessQueryObject() {

    $this->get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
    $this->post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $this->request = VTCore_Wordpress_Utility::arrayMergeRecursiveDistinct($this->post, $this->request);

    if ($this->getContext('loopQuery')) {
      $this->request = VTCore_Wordpress_Utility::arrayMergeRecursiveDistinct($this->request, (array) $this->getContext('loopQuery'));
    }

    // Processing pager
    // this has to be linked with wppager to
    // work properly and both object context id
    // must be the same
    if ($this->getContext('id')
        && isset($this->get['paged-' . $this->getContext('id')])
        && is_numeric($this->get['paged-' . $this->getContext('id')])) {

      $this->getContext('query')->set('paged', $this->get['paged-' . $this->getContext('id')]);
    }


    // Processing WpTermList
    // This must be linked to WpTermLIst object
    // to get the term_id
    if (isset($this->get['term-' . $this->getContext('id')])
        && is_numeric($this->get['term-' . $this->getContext('id')])
        && !empty($this->get['term-' . $this->getContext('id')])
        && isset($this->get['tax-' . $this->getContext('id')])) {

      $this->taxQuery[] = array(
        'taxonomy' => $this->get['tax-' . $this->getContext('id')],
        'field' => 'term_id',
        'terms' => (int) $this->get['term-' . $this->getContext('id')],
      );
    }

    return $this;
  }





  /**
   * Finalizing the query arguments
   */
  protected function finalizeQueryObject() {
    // Inject the meta and tax query
    if (count($this->metaQuery) > 1) {
      $this->getContext('query')->set('meta_query', $this->metaQuery);
    }

    // Inject the tax and tax query
    if (count($this->taxQuery) > 1) {
      $this->getContext('query')->set('tax_query', $this->taxQuery);
    }

    // Refresh the query object
    $this->getContext('query')->query($this->getContext('query')->query_vars);

    // Custom data attributes for helping
    // with fancy pagination
    $this->addData('max-pagination', $this->getContext('query')->max_num_pages);
    $this->addData('current-page', max(1, $this->getContext('query')->query_vars['paged']));

    // Mark as last page
    if ($this->getData('max-pagination') == $this->getData('current-page')) {
      $this->addContext('lastpage', true);
    }

    // User may have posted something for this loop
    // mark in the query object so other VTCore element such as pagination
    // can forward the request.
    if (!empty($this->request)) {
      $this->getContext('query')->loopRequest = $this->request;
      $this->addContext('loopQuery', $this->request);
    }

    return $this;
  }





  /**
   * Helper function for detecting template.
   * Detection sequence :
   * 1. Valid PHP file - include the file
   * 2. Valid HTML Object - direct include
   * 3. Valid HTML class  - build new object and direct include
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
      $this->addChildren($content);
    }

    // Direct inject if template is VTCore object
    elseif (is_object($template)
        && $template instanceof VTCore_Html_Base) {

      $template->addContext('grids', $this->getContext('grids'));
      $this->addChildren($template);

    }

    // Try to build a new object if the template
    // is  a class name.
    elseif (class_exists($template, true)) {
      $this->addChildren(new $template(array('grids' => $this->getContext('grids'))));
    }

    return $this;
  }


  /**
   * Intersect context for retrieving only
   * allowed value to be passed via ajax
   */
  protected function preProcessAjaxContext() {
    $this->ajaxContext = array_intersect_key($this->getContexts(), array_flip(array(
      'type',
      'attributes',
      'id',
      'queryArgs',
      'ajax',
      'ajaxData',
      'grids',
      'data',
      'template',
      'custom',
      'loopQuery',
    )));

    return $this;
  }




  /**
   * Method for adding extra markup to integrate
   * with wp-ajax
   *
   * @see VTCore_Wordpress_Ajax_Processor_Loop
   */
  protected function prepareAjax() {

    VTCore_Wordpress_Utility::loadAsset('jquery-viewport');
    VTCore_Wordpress_Utility::loadAsset('wp-ajax');
    VTCore_Wordpress_Utility::loadAsset('wp-loop');

    $args = $this->getContext('query')->query_vars;
    $args = array_filter($args);
    $this
      ->addContext('queryArgs', $args)
      ->preProcessAjaxContext()
      ->addData('context', base64_encode(serialize($this->ajaxContext)))
      ->addData('ajax-type', 'loop')
      ->addData('nonce', wp_create_nonce('vtcore-ajax-nonce-admin'))
      ->addClass('btn-ajax-content')
      ->addData('ajax-marker', array(
        'id' => $this->getContext('id'),
        'mode' => 'wp-loop',
      ));

    foreach ($this->getContext('ajaxData') as $key => $data) {
      $this->addData($key, $data);
    }

    return $this;
  }




  /**
   * Prepare object for isotope integration
   */
  protected function prepareIsotope() {

    VTCore_Wordpress_Utility::loadAsset('jquery-isotope');
    $this->addClass('js-isotope');

    if ($this->getContext('ajax')) {
      $this->addData('ajax-marker', array(
        'isotope' => true,
        'id' => $this->getContext('id'),
        'mode' => 'wp-loop',
      ));

      // @bugfix pagination breaks isotope!
      $this->addContext('ajaxData.ajax-marker', array(
        'isotope' => true,
        'id' => $this->getContext('id'),
        'mode' => 'wp-loop',
      ));
    }


    return $this;
  }




  /**
   * Final preparation before the object
   * build the loops, extend this method
   * if you need additional logic to be
   * performed before loops starts.
   */
  protected function prepareBeforeLoop() {

    parent::buildElement();

    $this
      ->addContext('objects.columns', new VTCore_Bootstrap_Grid_Column($this->getContext('grids')))
      ->addData('arrival', $this->getContext('id'));

    return $this;
  }





  /**
   * Method for creating wordpress loop and
   * performing the standard wordpress loop
   *
   * This method will also inject the template
   * and / or vtcore objects
   */
  protected function doLoop() {

    if ($this->getContext('query')->have_posts()) {
      global $post;

      $delta = 1;
      while ($this->getContext('query')->have_posts()) {
        $this->getContext('query')->the_post();
        $post->post_delta = $delta;
        $this->buildTemplate($this->getContext('template.items'));
        $delta++;

        // @since 1.7.34, use this to clear any object that can cause memory leaks!
        do_action($this->actionKey . 'before_next_post', $post);

      }

      // Reset back stupid global post
      wp_reset_postdata();

    }

    // Nothing found, fallback to empty message
    else {
      $this->buildTemplate($this->getContext('template.empty'));

    }

    return $this;
  }

  /**
   * Try and detect if the array is taken directly
   * from wpquery form and convert them into valid
   * WP_Query array arguments.
   */
  protected function maybeConvertQueryArgs() {

    // Process the grouped posts parameter
    if ($this->getContext('queryArgs.posts')) {

      foreach ((array) $this->getContext('queryArgs.posts') as $key => $value) {
        $this->addContext('queryArgs.' . $key, $value);
      }

      $this->removeContext('queryArgs.posts');

    }

    // Process the grouped author parameters
    if ($this->getContext('queryArgs.authors')) {
      foreach ((array) $this->getContext('queryArgs.authors') as $key => $value) {
        $this->addContext('queryArgs.' . $key, $value);
      }
    }

    // Process the grouped orders parameters
    if ($this->getContext('queryArgs.orders')) {
      foreach ((array) $this->getContext('queryArgs.orders') as $key => $value) {

        // Custom orderby
        if ($key == 'orderby') {
          if (strpos($value, 'metanum_') !== false) {
            $meta = str_replace('metanum_', '', $value);
            $value = 'meta_value_num';
            $this->addContext('queryArgs.meta_key', $meta);
          }

          if (strpos($value, 'metaval_') !== false) {
            $meta = str_replace('metaval_', '', $value);
            $value = 'meta_value';
            $this->addContext('queryArgs.meta_key', $meta);
          }
        }

        $this->addContext('queryArgs.' . $key, $value);
      }
    }

    // Process the grouped pagination parameters
    if ($this->getContext('queryArgs.pagination')) {
      foreach ((array) $this->getContext('queryArgs.pagination') as $key => $value) {
        if (!$this->getContext('queryArgs.' . $key)) {
          $this->addContext('queryArgs.' . $key, $value);
        }
      }
    }


    // Process the grouped taxonomy parameters
    if ($this->getContext('queryArgs.taxonomy')) {
      foreach ((array) $this->getContext('queryArgs.taxonomy') as $key => $data) {

        if (is_numeric($key)) {
          if (!empty($data['terms'])
              && !empty($data['taxonomy'])) {

            $this->addContext('queryArgs.tax_query.' . $key, $data);
          }
        }
        else {
          $this->addContext('queryArgs.tax_query.' . $key, $data);
        }
      }
    }

    // Process the grouped metas parameter
    if ($this->getContext('queryArgs.meta')) {
      foreach ((array) $this->getContext('queryArgs.meta') as $key => $data) {

        if (is_numeric($key)) {
          if (!empty($data['key'])
              && !empty($data['value'])) {

            $this->addContext('queryArgs.meta_query.' . $key, $data);
          }
        }
        else {
          $this->addContext('queryArgs.meta_query.' . $key, $data);
        }
      }
    }

    return $this;
  }

}