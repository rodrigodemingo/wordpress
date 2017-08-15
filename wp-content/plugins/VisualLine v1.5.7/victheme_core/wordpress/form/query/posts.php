<?php
/**
 * Class for building wp_query post query
 * compliant form
 *
 * @todo implement ajax search for modifying
 *       post select box depending on post type
 * @author jason.xie@victheme.com
 */
class VTCore_Wordpress_Form_Query_Posts
extends VTCore_Bootstrap_Form_Base
implements VTCore_Form_Interface  {

  static protected $postCache = array();

  protected $context = array(
    'text' => false,
    'description' => false,

    'name' => false,
    'id' =>  false,
    'class' => array(
      'form-control'
    ),
    'label' => true,

    'type' => 'div',

    // Wrapper Element
    'type' => 'div',
    'attributes' => array(
      'class' => array(
        'form-group',
        'wp-query-posts',
      ),
    ),

    'post_type_args' => array(
      'public' => true,
    ),

    'value' => array(
      'post_type' => array(),
      'post_parent__in' => array(),
      'post_parent__not_in' => array(),
      'post__in' => array(),
      'post__not_in' => array(),
      'post_status' => array(),
      'posts_per_page' => 10,
      'ignore_sticky_posts' => 1,
    ),

    // Internal use, Only override if needed
    'label_elements' => array(),
    'description_elements' => array(),
  );

  protected $postTypes = array();

  public function buildElement() {

    parent::buildElement();

    $this->postTypes = get_post_types($this->getContext('post_type_args'));

    if ($this->getContext('label_elements')) {
      $this->addChildren(new VTCore_Form_Label($this->getContext('label_elements')));
    }

    if ($this->getContext('description_elements')) {
      $this->addChildren(new VTCore_Bootstrap_Form_BsDescription(($this->getContext('description_elements'))));
    }

    $this
      ->addChildren(new VTCore_Bootstrap_Form_BsSelect(array(
        'text' => __('Post Type', 'victheme_core'),
        'description' => __('Select one or multiple post type for filtering the query results', 'victheme_core'),
        'name' => $this->getContext('name') . '[posts][post_type]',
        'value' => $this->getContext('value.post_type'),
        'multiple' => true,
        'selectpicker' => array(
          'live-search' => 'true',
          'container' => 'body',
          'show-tick' => true,
        ),
        'options' => $this->postTypes,
      )))
      ->addChildren(new VTCore_Bootstrap_Form_BsSelect(array(
        'text' => __('Post Status', 'victheme_core'),
        'description' => __('Select one or multiple post status for filtering the query results', 'victheme_core'),
        'name' => $this->getContext('name') . '[posts][post_status]',
        'value' => $this->getContext('value.post_status'),
        'multiple' => true,
        'selectpicker' => array(
          'live-search' => 'true',
          'container' => 'body',
          'show-tick' => true,
        ),
        'options' => array(
          'publish' => __('A Published post or page', 'victheme_core'),
          'pending' => __('Post is pending review', 'victheme_core'),
          'draft' => __('A post in draft status', 'victheme_core'),
          'future' => __('A post to publish in the future', 'victheme_core'),
          'private' => __('Not Visible to users who are not logged in', 'victheme_core'),
          'inherit' => __('A Revision', 'victheme_core'),
          'trash' => __('Post is in trashbin', 'victheme_core'),
          'any' => __('Retrieves any status except those from post types with exclude_from_search set to true', 'victheme_core'),
        ),
      )))
      ->addChildren(new VTCore_Bootstrap_Form_BsSelect(array(
        'text' => __('Post Parent In', 'victheme_core'),
        'description' => __('Select one or multiple post as the parent value for filtering the query results', 'victheme_core'),
        'name' => $this->getContext('name') . '[posts][post_parent__in]',
        'value' => $this->getContext('value.post_parent__in'),
        'options' => $this->getPosts(),
        'multiple' => true,
        'selectpicker' => array(
          'live-search' => 'true',
          'container' => 'body',
          'show-tick' => true,
        ),
      )))
      ->addChildren(new VTCore_Bootstrap_Form_BsSelect(array(
        'text' => __('Post Parent Not In', 'victheme_core'),
        'description' => __('Select one or multiple post as the not included parent value for filtering the query results', 'victheme_core'),
        'name' => $this->getContext('name') . '[posts][post_parent__not_in]',
        'value' => $this->getContext('value.post_parent__not_in'),
        'options' => $this->getPosts(),
        'multiple' => true,
        'selectpicker' => array(
          'live-search' => 'true',
          'container' => 'body',
          'show-tick' => true,
        ),
      )))
      ->addChildren(new VTCore_Bootstrap_Form_BsSelect(array(
        'text' => __('Post In', 'victheme_core'),
        'description' => __('Select one or multiple post to include in the result', 'victheme_core'),
        'name' => $this->getContext('name') . '[posts][post__in]',
        'value' => $this->getContext('value.post__in'),
        'options' => $this->getPosts(),
        'multiple' => true,
        'selectpicker' => array(
          'live-search' => 'true',
          'container' => 'body',
          'show-tick' => true,
        ),
      )))
      ->addChildren(new VTCore_Bootstrap_Form_BsSelect(array(
        'text' => __('Post Not In', 'victheme_core'),
        'description' => __('Select one or multiple post to exclude in the result', 'victheme_core'),
        'name' => $this->getContext('name') . '[posts][post__not_in]',
        'value' => $this->getContext('value.post__not_in'),
        'options' => $this->getPosts(),
        'multiple' => true,
        'selectpicker' => array(
          'live-search' => 'true',
          'container' => 'body',
          'show-tick' => true,
        ),
      )))
      ->addChildren(new VTCore_Bootstrap_Form_BsCheckbox(array(
        'text' => __('Ignore Sticky Post', 'victheme_core'),
        'description' => __('Ignore or honor the post that is marked as a sticky post', 'victheme_core'),
        'switch' => true,
        'name' => $this->getContext('name') . '[posts][ignore_sticky_posts]',
        'checked' => (boolean) $this->getContext('value.ignore_sticky_posts'),
      )));

  }


  /**
   * Method for retrieving all available
   * posts.
   * @return array
   */
  protected function getPosts() {

    if (empty(self::$postCache)) {
      global $wpdb;
      $placeholder = implode(', ',array_fill(0, count($this->postTypes), '%s'));
      $replacement = array('publish');
      $replacement += $this->postTypes;

      $results = $wpdb->get_results(
        $wpdb->prepare("
          SELECT ID, post_title, post_type
          FROM $wpdb->posts
          WHERE post_status = %s
          AND post_type IN ($placeholder)
          LIMIT 10000
        ", $replacement));

      foreach ($results as $key => $post) {

        self::$postCache[(int) $post->ID] = array(
          'text' => $post->post_title,
          'attributes' => array(
            'value' => $post->ID,
            'data-post-type' => $post->post_type,
          ),
        );
      }
    }

    return self::$postCache;
  }

}