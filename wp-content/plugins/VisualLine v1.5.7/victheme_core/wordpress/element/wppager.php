<?php

/**
 * Class for building pagination object for wordpress using
 * paginate_links function.
 *
 * This object is designed to be paired together
 * with WpLoop and / or WpTermList, using this object
 * without WpLoop object will need additional bridge
 * to modify the related WP_Query object for retrieving
 * the $_GET[paged-{pager id}] value and inject them
 * manually into the WP_Query object.
 *
 * CONTEXT
 * =======
 *  This object is designed to play nice when multiple
 *  pager instance is visible in a single page.
 *
 *  Thus these contextes must be defined or no markup
 *  is produced :
 *
 *  $context['id'] = a unique id for marking a single
 *                   pager element, this will relate
 *                   to the $_GET query produced by this
 *                   object.
 *
 *  $context['query'] = the WP_Query object to be linked
 *                      with this pager.
 *
 *
 *  The other context variable is optional and mostly
 *  for determining the markup that this object should
 *  produce.
 *
 *
 * AJAX
 * ====
 *  This object support ajaxed pagination when paired with
 *  WpLoop object and / or WpTermList object.
 *
 *  To setup ajax for this object, you must set $context['ajax'] to true
 *
 *
 * MINI
 * ====
 *  To build a minified pager with previous and / or next link only
 *  you must define $context['mini'] = true.
 *
 *
 * INFINITE LOOP
 * =============
 *  To build infinite loop type of pager, assuming you got the context
 *  query and id setup correctly, you just need to add $context['infinite'] = true
 *
 * Supports multiple pager for different element if
 * each element has unique pager id.
 *
 * @method WpPager
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Element_WpPager
  extends VTCore_Bootstrap_Element_BsPager {

  protected $context = array(
    'type' => 'div',
    'attributes' => array(
      'class' => array(
        'pagination',
        'wp-pager',
      ),
    ),
    // Inject unique pager id here
    'id' => FALSE,
    // Inject related content id for ajax here
    'ajax' => FALSE,
    'prev_next' => TRUE,
    'prev_text' => '&laquo',
    'next_text' => '&raquo',
    'end_size' => '4',
    'mid_size' => '2',
    'add_fragment' => FALSE,
    'mini' => FALSE,
    // Infinite loop mode
    'infinite' => FALSE,
    // Inject related WP_Query object here.
    'query' => FALSE,
    'raw' => TRUE,
    'ajaxloading_element' => array(
      'type' => 'div',
      'text' => 'Processing ...',
      'attributes' => array(
        'class' => array(
          'pager-ajax-notice',
          'well'
        ),
      ),
    ),
  );


  protected $get;
  protected $baseURL;
  protected $link;
  protected $big;
  protected $pager;
  protected $ajaxContext;


  /**
   * Overriding parent method
   * The main logic for building the pager markup
   */
  public function buildElement() {

    // Don't proceed any further without
    // valid query object or valid target id
    if ($this->getContext('query')
      || $this->getContext('id')
    ) {

      $this->buildPager();

      // Break if we got no pager value and only if
      // not on ajax mode
      if (empty($this->pager)
        && !$this->getContext('ajax')
      ) {

        $this->setType(FALSE);
        return $this;
      }

      parent::buildElement();

      if ($this->getContext('infinite')) {
        $this->buildInfinite();
      }

      if ($this->getContext('ajax')) {
        $this->buildAjax();
      }

      if (is_array($this->pager)) {
        foreach ($this->pager as $pager) {
          $this->buildPagerItem($pager);
        }
      }
    }

    else {
      $this->setType(FALSE);
    }

    do_action('vtcore_wordpress_pager_object_alter', $this);

    return $this;
  }


  /**
   * Method for processing pager get entries
   */
  protected function preProcessGet() {

    $this->get = (array) filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);

    // Pickup any variables passed through request by core
    if (isset($this->getContext('query')->loopRequest)) {
      $this->request = $this->getContext('query')->loopRequest;
      $this->get = wp_parse_args($this->get, (array) $this->request);
    }

    // Clean the get variables for fixing
    // multiple pager at once
    foreach ($this->get as $key => $value) {
      // Don't pass empty value, dont use array_fitler since 0 is a valid get input

      if (is_array($value)) {
        foreach ($value as $delta => $data) {
          if ($data === '') {
            unset($value[$delta]);
          }
        }
      }

      if ($value === '' || $value === array()) {
        unset($this->get[$key]);
        continue;
      }

      $this->get[$key] = preg_replace('/\?.*/', '', $value);
    }

    // Remove double get entry
    $this->get = array_unique((array) $this->get, SORT_REGULAR);

    // Update query current page
    if (isset($this->get[$this->getContext('queryid')])) {
      $this->getContext('query')
        ->set('paged', preg_replace('/\?.*/', '', $this->get[$this->getContext('queryid')]));

      unset($this->get[$this->getContext('queryid')]);
    }

    return $this;
  }


  /**
   * Method for processing the base url for paginate_links
   */
  protected function preProcessBaseUrl() {
    global $wp_rewrite;

    $this->big = 999999999;
    $this->link = html_entity_decode($this->get_pagenum_link($this->big));
    $this->link = remove_query_arg($this->getContext('queryid'), $this->link);

    // @experimental broken in ajax, need to test with multiple pager at one page
    //$this->link = trim(preg_replace('/\?.*/', '', $this->link));
    if (!$wp_rewrite->using_permalinks() || is_admin()) {
      $this->baseURL = str_replace('paged=', $this->getContext('queryid') . '=', $this->link);
    }
    else {
      // Somehow str_replace() will screw things up if we
      // replace the string in a single line due to backslash
      // this is happens only on linux system.
      $this->baseURL = str_replace('/page/' . $this->big . '/', '?' . $this->getContext('queryid') . '=' . $this->big, $this->link);
      $this->baseURL = str_replace($this->big . '/', $this->big, $this->baseURL);
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
      'ajax',
      'infinite',
      'prev_next',
      'prev_text',
      'next_text',
      'end_size',
      'add_fragment',
      'mini',
    )));

    return $this;
  }


  /**
   * Preparing object for ajax operations
   */
  protected function buildAjax() {
    VTCore_Wordpress_Utility::loadAsset('wp-ajax');
    VTCore_Wordpress_Utility::loadAsset('wp-loop');

    $this
      ->preProcessAjaxContext()
      ->addData('context', base64_encode(serialize($this->ajaxContext)))
      ->addData('ajax-type', 'pager')
      ->addData('destination', $this->getContext('id'))
      ->prependChild(new VTCore_Html_Element($this->getContext('ajaxloading_element')));

    return $this;
  }


  /**
   * Preparing object for ajax operations
   */
  protected function buildInfinite() {

    VTCore_Wordpress_Utility::loadAsset('jquery-viewport');

    $this->preProcessInfinite();

    return $this;
  }


  /**
   * Build the single pager markup
   */
  protected function buildPagerItem($pager) {

    $pager = str_replace("'", '"', $pager);

    if ($this->getContext('mini')
      && (strpos($pager, '<a class="prev ') === FALSE && strpos($pager, '<a class="next ') === FALSE)
    ) {

      return $this;
    }

    $this->addContent(new VTCore_Html_Element(array(
      'raw' => TRUE,
      'text' => html_entity_decode($pager),
    )));

    return $this;
  }


  /**
   * Force convert the context for supporting
   * pager on mini mode.
   */
  protected function preProcessMini() {

    $this
      ->addClass('pager-mini')
      ->addContext('max', 1)
      ->addContext('show_all', TRUE)
      ->addContext('end_size', 0)
      ->addcontext('prev_next', TRUE);

    return $this;
  }


  /**
   * Preprocess context for supporting infinite pager
   */
  protected function preProcessInfinite() {
    $this
      ->addClass('pager-infinite')
      ->addContext('prev_next', TRUE)
      ->addContext('ajax', TRUE);
  }




  /**
   * Building the main pager arguments using
   * paginate_links function.
   */
  protected function buildPager() {

    $this
      ->addContext('max', 0)
      ->addContext('queryid', 'paged-' . $this->getContext('id'))
      ->preProcessGet()
      ->preProcessBaseUrl();

    $this->addContext('show_all', ($this->getContext('query')->max_num_pages < 10) ? TRUE : FALSE);

    if ($this->getContext('mini')) {
      $this->preProcessMini();
    }

    // Fix missing next button
    if ($this->getContext('infinite')) {
      $this->addContext('max', 1);
    }

    $this->pager = $this->paginate_links(array(
      'base' => str_replace($this->big, '%#%', $this->baseURL),
      'format' => '?' . $this->getContext('queryid') . '=%#%',
      'total' => $this->getContext('query')->max_num_pages,
      'current' => max($this->getContext('max'), $this->getContext('query')->query_vars['paged']),
      'type' => 'array',
      'add_args' => empty($this->get) ? FALSE : $this->get,
      'show_all' => $this->getContext('show_all'),
      'prev_next' => $this->getContext('prev_next'),
      'prev_text' => $this->getContext('prev_text'),
      'next_text' => $this->getContext('next_text'),
      'end_size' => $this->getContext('end_size'),
      'add_fragment' => $this->getContext('add_fragment'),
    ));

    return $this;
  }




  /**
   * Retrieves the link for a page number. cloned from wordress
   */
  protected function get_pagenum_link($pagenum = 1, $key = '', $escape = TRUE) {
    global $wp_rewrite;

    $pagenum = (int) $pagenum;

    $request = remove_query_arg('paged');

    // Strip all query
    $maybe_query = parse_url($request, PHP_URL_QUERY);
    $request = str_replace('?' . $maybe_query, '', $request);

    $home_root = parse_url(home_url());
    $home_root = (isset($home_root['path'])) ? $home_root['path'] : '';
    $home_root = preg_quote($home_root, '|');


    $request = preg_replace('|^' . $home_root . '|i', '', $request);
    $request = preg_replace('|^/+|', '', $request);

    if (!$wp_rewrite->using_permalinks() || is_admin()) {
      $base = trailingslashit(get_bloginfo('url'));

      if ($pagenum > 1) {
        $result = add_query_arg('paged', $pagenum, $base . $request);
      }
      else {
        $result = $base . $request;
      }
    }
    else {

      $qs_regex = '|\?.*?$|';
      preg_match($qs_regex, $request, $qs_match);

      if (!empty($qs_match[0])) {
        $query_string = $qs_match[0];
        $request = preg_replace($qs_regex, '', $request);
      }
      else {
        $query_string = '';
      }

      $request = preg_replace("|$wp_rewrite->pagination_base/\d+/?$|", '', $request);
      $request = preg_replace('|^' . preg_quote($wp_rewrite->index, '|') . '|i', '', $request);
      $request = ltrim($request, '/');

      $base = trailingslashit(get_bloginfo('url'));

      if ($wp_rewrite->using_index_permalinks() && ($pagenum > 1 || '' != $request)) {
        $base .= $wp_rewrite->index . '/';
      }

      if ($pagenum > 1) {
        $request = ((!empty($request)) ? trailingslashit($request) : $request) . user_trailingslashit($wp_rewrite->pagination_base . "/" . $pagenum, 'paged');
      }

      $result = $base . $request . $query_string;
    }

    $result = apply_filters('get_pagenum_link', $result);

    if ($escape) {
      $result =  esc_url($result);
    }
    else {
      $result =  esc_url_raw($result);
    }

    return $result;
  }


  /**
   * Build paginated url, cloned from wordpress
   * @param string $args
   * @return array|string
   */
  function paginate_links($args = '') {
    global $wp_query, $wp_rewrite;

    // Setting up default values based on the current URL.
    $pagenum_link = html_entity_decode(get_pagenum_link());
    $url_parts = explode('?', $pagenum_link);

    // Get max pages and current page out of the current query, if available.
    $total = isset($wp_query->max_num_pages) ? $wp_query->max_num_pages : 1;
    $current = get_query_var('paged') ? intval(get_query_var('paged')) : 1;

    // Append the format placeholder to the base URL.
    $pagenum_link = trailingslashit($url_parts[0]) . '%_%';

    // URL base depends on permalink settings.
    $format = $wp_rewrite->using_index_permalinks() && !strpos($pagenum_link, 'index.php') ? 'index.php/' : '';
    $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit($wp_rewrite->pagination_base . '/%#%', 'paged') : '?paged=%#%';

    $defaults = array(
      'base' => $pagenum_link,
      // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
      'format' => $format,
      // ?page=%#% : %#% is replaced by the page number
      'total' => $total,
      'current' => $current,
      'show_all' => FALSE,
      'prev_next' => TRUE,
      'prev_text' => __('&laquo; Previous'),
      'next_text' => __('Next &raquo;'),
      'end_size' => 1,
      'mid_size' => 2,
      'type' => 'plain',
      'add_args' => array(),
      // array of query args to add
      'add_fragment' => '',
      'before_page_number' => '',
      'after_page_number' => ''
    );

    $args = wp_parse_args($args, $defaults);

    if (!is_array($args['add_args'])) {
      $args['add_args'] = array();
    }

    // Who knows what else people pass in $args
    $total = (int) $args['total'];
    $r = '';

    if ($total > 1) {

      $current = (int) $args['current'];
      $end_size = (int) $args['end_size']; // Out of bounds?  Make it the default.
      if ($end_size < 1) {
        $end_size = 1;
      }
      $mid_size = (int) $args['mid_size'];
      if ($mid_size < 0) {
        $mid_size = 2;
      }
      $add_args = $args['add_args'];

      $page_links = array();
      $dots = FALSE;

      if ($args['prev_next'] && $current && 1 < $current) {
        $link = str_replace('%_%', 2 == $current ? '' : $args['format'], $args['base']);
        $link = str_replace('%#%', $current - 1, $link);
        if ($add_args) {
          $link = add_query_arg($add_args, $link);
        }
        $link .= $args['add_fragment'];

        $page_links[] = '<a class="prev page-numbers" href="' . esc_url(apply_filters('paginate_links', $link)) . '">' . $args['prev_text'] . '</a>';
      }

      for ($n = 1; $n <= $total; $n++) {
        if ($n == $current) {
          $page_links[] = "<span class='page-numbers current'>" . $args['before_page_number'] . number_format_i18n($n) . $args['after_page_number'] . "</span>";
          $dots = TRUE;
        }
        else {
          if ($args['show_all'] || ($n <= $end_size || ($current && $n >= $current - $mid_size && $n <= $current + $mid_size) || $n > $total - $end_size)) {
            $link = str_replace('%_%', 1 == $n ? '' : $args['format'], $args['base']);
            $link = str_replace('%#%', $n, $link);
            if ($add_args) {
              $link = add_query_arg($add_args, $link);
            }
            $link .= $args['add_fragment'];

            /** This filter is documented in wp-includes/general-template.php */
            $page_links[] = "<a class='page-numbers' href='" . esc_url(apply_filters('paginate_links', $link)) . "'>" . $args['before_page_number'] . number_format_i18n($n) . $args['after_page_number'] . "</a>";
            $dots = TRUE;
          }
          else {
            if ($dots && !$args['show_all']) {
              $page_links[] = '<span class="page-numbers dots">' . __('&hellip;') . '</span>';
              $dots = FALSE;
            }
          }
        }
      }

      if ($args['prev_next'] && $current && ($current < $total || -1 == $total)) {
        $link = str_replace('%_%', $args['format'], $args['base']);
        $link = str_replace('%#%', $current + 1, $link);
        if ($add_args) {
          $link = add_query_arg($add_args, $link);
        }
        $link .= $args['add_fragment'];
        $page_links[] = '<a class="next page-numbers" href="' . esc_url(apply_filters('paginate_links', $link)) . '">' . $args['next_text'] . '</a>';
      }

      switch ($args['type']) {
        case 'array' :
          return $page_links;

        case 'list' :
          $r .= "<ul class='page-numbers'>\n\t<li>";
          $r .= join("</li>\n\t<li>", $page_links);
          $r .= "</li>\n</ul>\n";
          break;

        default :
          $r = join("\n", $page_links);
          break;
      }
    }

    return $r;
  }

}