<?php
/**
 * Ajax callback class for WpCarousel Object
 *
 * The WpLoop Object can be paired with
 * WpTermList.

 *
 * Additional context outside the wp-ajax api context needed
 * for building the proper ajax results :
 *
 * WpCarousel
 * ==========
 * context : serialized base64_encoded strings containing
 *           array of arguments for WP_Query Object
 * id      : the id for the destination target
 *
 *
 * @see VTCore_Wordpress_Element_WpLoop
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Ajax_Processor_WpCarousel
extends VTCore_Wordpress_Models_Ajax {

  protected $render = array();
  protected $post;


  protected $context;
  protected $loop;
  protected $pager;


  /**
   * Ajax callback function
   *
   * $post will hold all the data passed by ajax.
   * - taxonomies = array or string of taxonomies,
   * - elval = the taxonomy term id
   */
  protected function processAjax() {

    $this->context = unserialize(base64_decode($this->post['data']['context']));

    // Clean context, This is a bug fix where
    // old context keep carried forward and
    // throwing some plugins search results off.
    if (isset($this->context['queryArgs']['tax_query'])) {
      unset($this->context['queryArgs']['tax_query']);
    }

    if (isset($this->context['queryArgs']['meta_query'])) {
      unset($this->context['queryArgs']['meta_query']);
    }

    // Preprocess Context
    $this
      ->processPager()
      ->processTerms();

    $this->context = apply_filters('vtcore_wordpress_carousel_ajax_context_alter', $this->context);
    $this->loop = new VTCore_Wordpress_Element_WpCarousel($this->context);
    $this->loop->setClean(false);

    // Replace pager
    if (isset($this->post['data']['pagedContext'])) {

      $context = unserialize(base64_decode($this->post['data']['pagedContext']));
      $context['query'] = $this->loop->getContext('query');

      $this->pager = new VTCore_Wordpress_Element_WpCarousel($context);
    }

    // Replace term lists
    // Only do this if not show all button pressed
    if (isset($this->post['data']['termContext'])) {

      $context = unserialize(base64_decode($this->post['data']['termContext']));
      $context['termparent'] = $this->post['data']['termId'];
      $context['query'] = $this->loop->getContext('query');

      // Reset Drill
      if ($this->post['data']['termAll'] == 'true') {
        $context['termparent'] = false;
      }

      $this->terms = new VTCore_Wordpress_Element_WpTermList($context);

      $this->render['action'][] = array(
        'mode' => 'replace',
        'target' => '[data-ajax-type="termlist"][data-destination="' . $this->loop->getContext('id') . '"]',
        'content' => $this->terms->__toString(),
      );

    }

    switch ($this->post['queue']) {

      // Replace the slick content
      case 'replace' :
        $this->loop->setType(false);
        $this->render['action'][] = array(
          'mode' => 'wploop-replace',
          'target' => '[data-arrival="' . $this->loop->getContext('id') . '"]',
          'content' => $this->loop->__toString(),
        );

        if (!empty($this->pager)) {
          $this->render['action'][] = array(
            'mode' => 'wploop-replace',
            'target' => '[data-ajax-type="pager"][data-destination="' . $this->loop->getContext('id') . '"]',
            'content' => $this->pager->__toString(),
          );
        }

      break;

      // Add new slick content
      case 'append' :

        $this->loop->setType(false);
        $this->render['action'][] = array(
          'mode' => 'wploop-append',
          'target' => '[data-arrival="' . $this->loop->getContext('id') . '"]',
          'content' => $this->loop->__toString(),
        );

        if (!empty($this->pager)) {
          $this->render['action'][] = array(
            'mode' => 'wploop-append',
            'target' => '[data-ajax-type="pager"][data-destination="' . $this->loop->getContext('id') . '"]',
            'content' => $this->pager->__toString(),
          );
        }

        break;

    }


    // No more posts
    if ($this->loop->getContext('lastpage')) {
      $this->render['action'][] = array(
        'mode' => 'data',
        'target' => '[data-arrival="' . $this->loop->getContext('id') . '"]',
        'key' => 'ajax-last-page',
        'content' => true,
      );
    }

    // Allow plugin to inject their own process
    do_action('vtcore_wordpress_carousel_ajax_result_alter', $this->render, $this);

    return $this->render;
  }



  /**
   * Method for processing wptermlist taxonomy
   * filters.
   */
  protected function processTerms() {

    if (isset($this->post['data']['termId'])
        && isset($this->post['data']['taxonomy'])) {

      if ($this->post['data']['taxonomy'] == 'false'
          && $this->post['data']['termId'] == 'false') {

        if (isset($this->context['queryArgs']['tax_query']['ajax'])) {
          unset($this->context['queryArgs']['tax_query']['ajax']);
        }
      }

      else {
        $this->context['queryArgs']['tax_query'] = array(
          'ajax' => array(
            'taxonomy' => $this->post['data']['taxonomy'],
            'terms' => (int) $this->post['data']['termId'],
          ),
        );
      }
    }


    return $this;
  }


  /**
   * Method for injecting pager related
   * query to the main loop context
   */
  protected function processPager() {
    if (isset($this->post['data']['paged'])) {

      if (is_numeric($this->post['data']['paged'])) {
        $this->context['queryArgs']['paged'] = $this->post['data']['paged'];
      }

      elseif ($this->post['data']['paged'] == 'false') {
        $this->context['queryArgs']['paged'] = 1;
      }

      else {
        $this->pagerVars = wp_parse_args(parse_url($this->post['data']['paged'], PHP_URL_QUERY));
        if (isset($this->pagerVars['paged-' . $this->context['id']])) {
          $this->context['queryArgs']['paged'] = $this->pagerVars['paged-' . $this->context['id']];
        }
      }
    }

    return $this;
  }

}