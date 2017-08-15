<?php
/**
 * Building form multiple social icon with
 * text and links
 *
 * @author jason.xie@victheme.com
 * @method WpSocial($context)
 * @see VTCore_Html_Form interface
 */
class VTCore_Wordpress_Form_WpSocial
extends VTCore_Bootstrap_Form_Base
implements VTCore_Form_Interface {

  protected $context = array(

    // Shortcut method
    // @see VTCore_Bootstrap_Form_Base::assignContext()
    'text' => false,
    'description' => false,
    'required' => true,

    'name' => false,
    'id' => false,
    'class' => array(
      'form-control'
    ),

      // Bootstrap Rules
    'label' => true,

    // Wrapper element
    'type' => 'div',
    'attributes' => array(
      'class' => array(
        'form-group',
        'wp-social'
       ),
    ),

    'filter' => 1,

    'value' => false,

    'iconset' => array(
      'tumblr',
      'facebook',
      'google-plus',
      'pinterest',
      'linkedin',
      'github',
      'twitter',
      'flickr' ,
      'youtube',
      'dribbble',
      'instagram',
      'weibo',
      'bitbucket',
      'dropbox',
      'foursquare',
      'gittip',
      'renren',
      'skype',
      'stack-exchange',
      'trello',
      'vk',
      'vimeo-square',
      'xing',
    ),
  );


  /**
   * Overriding parent method
   */
  public function buildElement() {

    VTCore_Wordpress_Utility::loadAsset('jquery-table-manager');

    parent::buildElement();

    if ($this->getContext('label_elements')) {
      $this->addChildren(new VTCore_Form_Label($this->getContext('label_elements')));
    }

    if ($this->getContext('description_elements')) {
      $this->addChildren(new VTCore_Bootstrap_Form_BsDescription(($this->getContext('description_elements'))));
    }

    $this
      ->addChildren(new VTCore_Bootstrap_Element_BsElement(array(
        'type' => 'div',
        'attributes' => array(
          'class' => array('table-manager'),
        ),
      )))
      ->lastChild()
      ->addChildren(new VTCore_Html_Table(array(
        'headers' => array(
          ' ',
          __('Icon', 'victheme_core'),
          __('Link', 'victheme_core'),
          ' ',
        ),
        'rows' => $this->buildRows(),
        'data' => array(
          'filter' => $this->getContext('filter'),
        ),
      )))
      ->addChildren(new VTCore_Bootstrap_Form_BsButton(array(
        'text' => __('Add New Entry', 'victheme_core'),
        'attributes' => array(
          'data-tablemanager-type' => 'addrow',
          'class' => array('button', 'button-large', 'button-primary'),
        ),
      )));
  }




  /**
   * Building the table manager rows
   */
  private function buildRows() {

    // Add empty line if no value available.
    if (!$this->getContext('value')) {
      $this->addContext('value', array(
        array('icon' => '', 'href' => ''),
      ));
    }

    $rows = array();
    foreach ($this->getContext('value') as $key => $link) {

      // Draggable Icon
      $rows[$key]['drag'] = array(
        'content' => new VTCore_Bootstrap_Element_BsElement(array(
          'type' => 'span',
          'attributes' => array(
            'class' => array('drag-icon'),
          ),
        )),
        'attributes' => array(
          'class' => array('drag-element'),
        ),
      );


      // Icon selector
      $rows[$key]['icon'] = new VTCore_Fontawesome_Form_faIcon(array(
        'iconset' => $this->getContext('iconset'),
        'text' => __('Icon', 'victheme_core'),
        'name' => $this->getContext('name') . '[' . $key . '][icon]',
        'value' => $link['icon'],
      ));


      $rows[$key]['link'] = new VTCore_Bootstrap_Form_BsUrl(array(
        'text' => __('Link URL', 'victheme_core'),
        'name' => $this->getContext('name') . '[' . $key . '][href]',
        'value' => $link['href'],
        'required' => $this->getContext('required'),
      ));


      // Remove button
      $rows[$key]['button'] = array(
        'content' => new VTCore_Form_Button(array(
          'text' => 'X',
          'attributes' => array(
            'data-tablemanager-type' => 'removerow',
            'class' => array('button', 'button-mini', 'form-button'),
          ),
        )),
        'attributes' => array(
          'class' => array('remove-button')
        ),
      );
    }

    return $rows;
  }


}