<?php
/**
 * Class for building wp_query author compliant
 * forms.
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Wordpress_Form_Query_Authors
extends VTCore_Bootstrap_Form_Base
implements VTCore_Form_Interface  {

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

    'get_user_args' => array(),

    'value' => array(
      'author__in' => array(),
      'author__not_in' => array(),
    ),

    // Internal use, Only override if needed
    'label_elements' => array(),
    'description_elements' => array(),
  );


  /**
   * Overriding parent method
   *
   * @return $this|void
   */
  public function buildElement() {

    parent::buildElement();

    $users = get_users($this->getContext('get_user_args'));
    $options = array();
    foreach ($users as $user) {
      $options[$user->ID] = $user->user_login;
    }

    if ($this->getContext('label_elements')) {
      $this->addChildren(new VTCore_Form_Label($this->getContext('label_elements')));
    }

    if ($this->getContext('description_elements')) {
      $this->addChildren(new VTCore_Bootstrap_Form_BsDescription(($this->getContext('description_elements'))));
    }

    $this
      ->addChildren(new VTCore_Bootstrap_Form_BsSelect(array(
        'text' => __('Author In', 'victheme_core'),
        'description' => __('Select one or multiple author, only posts made by these selected author will be retrieved by the query.', 'victheme_core'),
        'name' => $this->getContext('name') . '[authors][author__in]',
        'value' => $this->getContext('value.author__in'),
        'multiple' => true,
        'selectpicker' => array(
          'live-search' => 'true',
          'container' => 'body',
          'show-tick' => true,
        ),
        'options' => $options,
      )))
      ->addChildren(new VTCore_Bootstrap_Form_BsSelect(array(
        'text' => __('Author Not In', 'victheme_core'),
        'description' => __('Select one or multiple author, posts made by these selected author will not be retrieved by the query.', 'victheme_core'),
        'name' => $this->getContext('name') . '[authors][author__not_in]',
        'value' => $this->getContext('value.author__not_in'),
        'multiple' => true,
        'selectpicker' => array(
          'live-search' => 'true',
          'container' => 'body',
          'show-tick' => true,
        ),
        'options' => $options,
      )));

  }


}