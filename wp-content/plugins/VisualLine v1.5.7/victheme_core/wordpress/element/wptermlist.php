<?php
/**
 * Class for building term listing, compatible
 * when paired with WpPager and WpLoop
 *
 * TAXONOMY
 * ========
 *
 *  This is required without this the element
 *  won't build any markup.
 *  $context['taxonomy'] = 'valid_taxonomy';
 *
 *  Additional Taxonomy argument as specified
 *  in the get_terms();
 *  $context['taxargs'] = array();
 *
 * AJAX
 * ====
 *  The ajax feature in this element must follow
 *  the wp-ajax.js rules
 *  Fill all the ajax data-* attributes in the
 *  ajax context.
 *
 * Example :
 *
 *  $context['ajax'] = array(
 *    'ajax-loading-text' => 'Loading',
 *    'ajax-object' => 'VTCore_......',
 *    'ajax-group' => ......,
 *  );
 *
 *  To disable ajax feature use :
 *
 *   $context['ajax'] = false;
 *
 *  When Ajax is specified
 *  $context['id'] is required to point
 *  to the right markup for ajax manipulation
 *
 *
 *
 * REDIRECT
 * ========
 *  The term link element can be set to redirect
 *  to its term page or stay on the current page
 *  by defining $context['redirect'] = true or false
 *
 *
 * DRILL MODE
 * ==========
 *  The object can be configured to "drill" on taxonomy
 *  with children, when on drilling mode it will show
 *  parent link, self term link and child link.
 *
 *  The link content will change depending on the url
 *  or ajax request.
 *
 *  To enable the drilling mode set the $context['drill']
 *  to true or false to disable it.
 *
 *
 * SHOW ONLY CHILDREN
 * ==================
 *  It is possible to configure the object to show only
 *  the children of x terms by defining the $context['termparent']
 *  and put the value of the x term's term_id to
 *  force the object to only show the children of the
 *  terms.
 *
 * SHOW ALL BUTTON
 * ===============
 *  It is possible to hide / show the "all" button and
 *  specify custom text for it by defining the $context['all']
 *  and use string text as the button text.
 *
 * ADVANCED USE
 * ============
 *  it is advised to extend this class if you need to define
 *  custom link markup. All the link markup is separated
 *  into different methods, this is designed this way so
 *  extending class can define their own markup or logic
 *  for each different link method.
 *
 * @method WpTermList
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Element_WpTermList
extends VTCore_Html_List {

  protected $context = array(
    'type' => 'ul',
    'contents' => array(),
    'attributes' => array(
      'class' => array(
        'wp-term-list',
      ),
    ),

    'list_elements' => array(
      'type' => 'li',
      'attributes' => array(),
    ),

    'link_elements' => array(
      'raw' => true,
      'attributes' => array(),
    ),

    'taxonomy' => false,
    'taxargs' => array(),
    'termparent' => false,
    'id' => false,
    'all' => false,

    'ajax' => false,
    'redirect' => false,
    'drill' => false,
  );

  protected $terms;
  protected $currentPage;
  protected $currentTerm;
  protected $ajaxContext;



  /**
   * Override parent method
   * this is the main logic for building
   * the HTML markup
   */
  public function buildElement() {

    $this
      ->buildCurrentPage()
      ->buildGrid()
      ->buildParentTerm()
      ->buildCurrentTerm();

    if ($this->getContext('drill')) {
      $this->buildDrill();
    }

    $this->terms = get_terms($this->getContext('taxonomy'), $this->getContext('taxargs'));

    if (is_wp_error($this->terms)) {
      return $this;
    }

    // Invoke the parent build element
    // method late for true clean markup
    parent::buildElement();


    // Prepare for ajax
    if ($this->getContext('ajax')) {
      $this->buildAjax();
    }

    // All button
    if ($this->getContext('all')) {
      $this->buildLinkAll();
    }

    // Drill back link
    if ($this->getContext('drill')
        && !empty($this->currentTerm)) {
      $this->buildLinkParent();
    }

    // Self Link
    if ($this->getContext('drill')
        && !empty($this->currentTerm)) {
      $this->buildLinkSelf();
    }

    // Terms buttons
    foreach ($this->terms as $term) {
      $this->buildLinkChild($term);
    }

    // Allow other plugin to alter the object
    do_action('vtcore_wordpress_termlist_alter_object', $this);
  }


  /**
   * Intersect context for retrieving only
   * allowed value to be passed via ajax
   */
  protected function preProcessAjaxContext() {
    $this->ajaxContext = array_intersect_key($this->getContexts(), array_flip(array(
      'type',
      'attributes',
      'list_elements',
      'link_elements',
      'taxonomy',
      'taxargs',
      'id',
      'all',
      'ajax',
      'redirect',
      'drill',
      'termparent',
      'custom',
    )));

    return $this;
  }






  /**
   * Build the additional query if
   * on drilling mode
   */
  protected function buildDrill() {

    // Default mode Wordpress need
    // parent set to zero to display top level
    // only.
    $this->addContext('taxargs.parent', 0);

    // User manual set or replacement by dynamic set
    if ($this->getContext('termparent')) {
      $this->addContext('taxargs.parent', $this->getContext('termparent'));
    }

    return $this;
  }


  /**
   * Build the parent term and dynamically
   * inject the termparent context
   */
  protected function buildParentTerm() {

    if (isset($_REQUEST['term-' . $this->getContext('id')])
        && is_numeric($_REQUEST['term-' . $this->getContext('id')])) {

      $this->addContext('termparent', $_REQUEST['term-' . $this->getContext('id')]);
    }

    return $this;

  }


  /**
   * Build the current term object
   */
  protected function buildCurrentTerm() {

    if ($this->getContext('termparent')) {
      $term = get_term((int) $this->getContext('termparent'), $this->getContext('taxonomy'));
    }

    if (isset($term) && !empty($term) && !is_wp_error($term)) {
      $this->currentTerm = $term;
    }

    return $this;

  }



  /**
   * Build the current page link
   */
  protected function buildCurrentPage() {
    global $wp;
    $this->currentPage = add_query_arg($wp->query_string, '', home_url($wp->request));

    return $this;
  }



  /**
   * Prepare object for ajax operations
   */
  protected function buildAjax() {
    VTCore_Wordpress_Utility::loadAsset('wp-ajax');
    VTCore_Wordpress_Utility::loadAsset('wp-loop');

    $this
      ->preProcessAjaxContext()
      ->addData('ajax-type', 'termlist')
      ->addData('context', base64_encode(serialize($this->ajaxContext)))
      ->addData('destination', $this->getContext('id'));

    return $this;
  }





  /**
   * Build the element link depending on to redirect
   * to taxonomy term page or not
   */
  protected function buildLink($term) {
    $link = '';
    if ($this->getContext('redirect')) {
      $link = get_term_link((int)$term->term_id, $this->getContext('taxonomy'));
    }

    else {
      $args = array(
        'term-' . $this->getContext('id') => (int) $term->term_id,
        'tax-' . $this->getContext('id') => $this->getContext('taxonomy'),
      );

      $link = add_query_arg($args, $this->currentPage);
    }

    return $link;
  }




  /**
   * Build link for all buttons
   */
  protected function buildLinkAll() {

    $object = new VTCore_Html_HyperLink($this->getContext('link_elements'));
    $object
      ->addAttribute('href', $this->currentPage)
      ->addData('term-id', false)
      ->addData('taxonomy', false)
      ->addData('term-all', true)
      ->addClass('term-all')
      ->setText($this->getContext('all'));

    if (!$this->getContext('termparent') && !$this->currentTerm) {
      $object->addClass('active term-active');
    }

    $this->addContent($object);
    unset($object);

    return $this;
  }




  /**
   * Build link for parent elements;
   */
  protected function buildLinkParent() {

    $term = get_term((int) $this->currentTerm->parent, $this->getContext('taxonomy'));

    if (!is_wp_error($term)) {
      $link = $this->buildLink($term);
      $object = new VTCore_Html_HyperLink($this->getContext('link_elements'));
      $object
      ->addAttribute('href', $this->buildLink($term))
      ->addData('term-id', $term->term_id)
      ->addData('taxonomy', $this->getContext('taxonomy'))
      ->addClass('term-parent')
      ->setText($term->name);

      $this->addContent($object);
      unset($object);
    }

    return $this;
  }




  /**
   * Build element for self / current terms link
   */
  protected function buildLinkSelf() {

    $object = new VTCore_Html_HyperLink($this->getContext('link_elements'));
    $object
      ->addAttribute('href', $this->buildLink($this->currentTerm))
      ->addData('term-id', $this->currentTerm->term_id)
      ->addData('taxonomy', $this->getContext('taxonomy'))
      ->addClass('term-self')
      ->setText($this->currentTerm->name);

    $this->addContent($object);
    unset($object);

    return $this;
  }





  /**
   * Build link for child terms and normal terms
   *
   * @param object $term - wp term object
   */
  protected function buildLinkChild($term) {

    $object = new VTCore_Html_HyperLink($this->getContext('link_elements'));
    $object
      ->addAttribute('href', $this->buildLink($term))
      ->addData('term-id', (int) $term->term_id)
      ->addData('taxonomy', $term->taxonomy)
      ->addClass('term-items')
      ->setText($term->name);

    if (is_object($this->currentTerm)
        && isset($this->currentTerm->term_id)
        && ($term->term_id == $this->currentTerm->term_id || $term->term_id == $this->getContext('termparent'))) {

      $object->addClass('term-active active');
    }

    $this->addContent($object);
    unset($object);

    return $this;
  }



  /**
   * Method for building the grid css classes
   * @return VTCore_Bootstrap_Element_Base
   */
  public function buildGrid() {
    // Processing Grids
    if ($this->getContext('grids')) {
      $grids = new VTCore_Bootstrap_Grid_Column($this->getContext('grids'));
      $this->addClass($grids->getClass(), 'grids');
    }

    return $this;
  }


}