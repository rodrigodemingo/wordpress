<?php
/**
 * Extended version of WP_User_Query class
 * for implementing missing features in the
 * original class.
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Queries_Users
extends WP_User_Query {

  public $get;
  public $post;
  public $request;
  public $query;
  public $max_num_pages;
  public $loopRequest;




  /**
   * Overriding parent construct method.
   * @param string $query
   */
  public function __construct($query = NULL) {

    $this->query = (array) $query;

    if (!empty($this->query) && !$this->query['noquery']) {
      $this->processObject();
    }
  }



  /**
   * Decouple the auto invocation from
   * construct so user can choose when
   * to actually perform the query parsing
   * and database querieing
   *
   * @return VTCore_Wordpress_Queries_Users
   */
  public function processObject() {
    // Prepare additional query
    $this->alterQueryArgs();

    // Standard wordpress invocation
    $this->prepare_query($this->query);
    $this->query();

    // Modify user object after queried
    $this->afterQuery();

    return $this;

  }


  /**
   * Additional method for altering the query args
   * This must be invoked before preprare query.
   *
   * Populate the $this->query object for additional query
   *
   * Supports $this->query['meta_query'] for user metas
   * and $this->query['tax_query'] for user linked taxonomy
   */
  protected function alterQueryArgs() {

    $this->get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
    $this->post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $this->request = VTCore_Wordpress_Utility::arrayMergeRecursiveDistinct($this->post, $this->get);

    $this->request = array_filter((array) $this->request);
    $this->request = array_unique((array) $this->request, SORT_REGULAR);

    // Processing ajax callback
    if (isset($this->request['value'])
        && $this->request['value'] == 'userloop'
        && isset($this->request['data'])) {

      $this->request['data'] = VTCore_Wordpress_Utility::wpParseLargeArgs($this->request['data']);

    }

    // Make WP_User_Query behaves like WP_Query
    if ($this->query['number']) {

      // Pagination with paged as WP_Query does
      if (!isset($this->query['paged'])) {
        $this->query['paged'] = 1;
      }

      // WpPager needs this for sane pagination
      $this->set('paged', $this->query['paged']);

      // Build the offset based on page and number per page
      $this->query['offset'] = $this->query['number'] * max(0, ($this->query['paged'] - 1));
    }

    do_action('vtcore_wordpress_user_query_args_alter', $this);

  }




  /**
   * Overriding parent prepare query method
   * @see WP_User_Query::prepare_query()
   */
  public function prepare_query($query = array()) {
    global $wpdb;

    // Invoking parent method to build the query string
    parent::prepare_query($query);

    // Injecting custom query string for taxonomy
    if (isset($this->query['tax_query'])) {

      $tax_query = new WP_Tax_Query($this->query['tax_query']);
      $taxsql = $tax_query->get_sql($wpdb->users, 'ID');

      if (!empty($taxsql['join'])) {
        $this->query_from .= $taxsql['join'];
        $this->query_where .= $taxsql['where'];
      }
    }

    if (isset($this->query['distinct']) && $this->query['distinct'] == true) {
      $this->query_where .= ' GROUP BY ' . $wpdb->users . '.ID ';
    }
  }


  /**
   * Allow plugins to add extra property in the user object
   *
   * The hook action vtcore_wordpress_pre_get_user will
   * supply the valid user object (WP_User), plugin can
   * piggy back their own custom object into the user object
   * which will be available in the loop.
   *
   */
  protected function afterQuery() {

    // Make WP_User_Query behaves like WP_Query
    if ($this->query['number'] && $this->total_users) {
      $this->max_num_pages = ceil($this->total_users / $this->query['number']);
    }

    foreach ($this->results as $key => $user) {
      if ($user instanceof WP_User) {
        do_action('vtcore_wordpress_pre_get_user_object', $this->results[$key]);
      }
    }
  }


  /**
   * Set query variable.
   */
  public function set( $query_var, $value ) {

    if ($query_var == 'meta_query' || $query_var == 'tax_query') {
      $this->query[$query_var] = $value;
    }
    else {
      $this->query_vars[$query_var] = $value;
    }
  }


}