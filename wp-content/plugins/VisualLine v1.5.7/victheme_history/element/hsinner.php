<?php
/**
 * Class for building the history inner content.
 *
 * @todo Fix this mess! separate into smaller objects!
 * @author jason.xie@victheme.com
 * @method HsInner($context)
 */
class VTCore_History_Element_HsInner
extends VTCore_Bootstrap_Grid_BsColumn {

  protected $context = array(
    'type' => 'div',
    'text' => '',
    'attributes' => array(
      'class' => array(
        'history-content',
      ),
    ),
    'grids' => array(
      'columns' => array(
        'mobile' => 12,
        'tablet' => 12,
        'small' => 12,
        'large' => 12,
      ),
    ),

    'left_grids' => array(
      'columns' => array(
        'mobile' => 4,
        'tablet' => 4,
        'small' => 4,
        'large' => 4,
      ),
    ),
    'right_grids' => array(
      'columns' => array(
        'mobile' => 8,
        'tablet' => 8,
        'small' => 8,
        'large' => 8,
      ),
    ),

    'left_element' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array(
          'history-left',
        ),
      ),
    ),

    'right_element' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array(
          'history-right',
        ),
      ),
    ),

    'label_element' => array(
      'attributes' => array(
        'class' => array('history-label'),
      ),
    ),
    'image_wrapper_element' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array('history-left-inner'),
      ),
    ),
    'image_element' => array(
      'attributes' => array(
        'class' => array('history-image'),
      ),
    ),
    'icon_element' => array(
      'attributes' => array(
        'class' => array(
          'history-icon',
        ),
      ),
    ),
    'title_element' => array(
      'type' => 'h2',
      'attributes' => array(
        'class' => array(
          'history-title',
        )
      ),
    ),
    'subtitle_element' => array(
      'type' => 'h3',
      'attributes' => array(
        'class' => array(
          'history-subtitle',
        )
      ),
    ),

    'startpoint_element' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array(
          'startpoint',
        )
      ),
    ),

    'endpoint_element' => array(
      'type' => 'span',
      'attributes' => array(
        'class' => array(
          'endpoint',
        )
      ),
    ),
    'direction' => 'left',
    'content' => false,

    'enable' => array(
      'title' => true,
      'subtitle' => true,
      'icon' => true,
      'label' => true,
      'image' => true,
    ),
  );


  private $grids;
  private $left;
  private $right;
  private $startpoint;
  private $label;
  private $icon;
  private $image;
  private $leftGrids;
  private $rightGrids;

  public function buildElement() {

    $this->grids = new VTCore_Bootstrap_Grid_Column($this->getContext('grids'));
    $this->rightGrids = new VTCore_Bootstrap_Grid_Column($this->getContext('right_grids'));
    $this->leftGrids = new VTCore_Bootstrap_Grid_Column($this->getContext('left_grids'));

    $this->addAttributes($this->getContext('attributes'));
    $this->addClass($this->getGrid()->getClass());

    if ($this->getContext('direction')) {
      $this->addData('direction', $this->getContext('direction'));
    }

    $this->left = $this->BsElement($this->getContext('left_element'))->lastChild();
    $this->left
      ->addClass($this->getLeftGrid()->getClass());

    if ($this->getContext('direction') == 'right') {
      $this->left
        ->addClass('pull-right text-right');
    }

    $this->left = $this->left
      ->BsElement($this->getContext('image_wrapper_element'))
      ->lastChild();

    $this->right = $this->BsElement($this->getContext('right_element'))->lastChild();
    $this->right
      ->addClass($this->getRightGrid()->getClass());

    if ($this->getContext('enable.title')) {

      $text = $this->getContext('title_element.text');
      $this->removeContext('title_element.text');

      $this->right
        ->Element($this->getContext('title_element'))
        ->lastChild()
        ->Element(array(
          'type' => 'span',
          'text' => $text,
          'attributes' => array(
            'class' => array(
              'title-text',
            )
          ),
        ));
    }

    if ($this->getContext('direction') == 'right') {
      $this->right
        ->addClass('pull-right text-right')
        //->lastChild()
        ->prependChild(new VTCore_Html_Element($this->getContext('endpoint_element')));
    }

    elseif ($this->getContext('direction') == 'left') {
      $this->right
        //->lastChild()
        ->addChildren(new VTCore_Html_Element($this->getContext('endpoint_element')));
    }
    elseif ($this->getContext('direction') == 'center') {

    }


    if ($this->findContext('attachment_id') && $this->getContext('enable.image')) {


      $style = $this->getContext('image_style');
      if (strpos($style, '_circle_2') !== false || $style == 'diamond') {
        $this->addContext('image_element.force.square', true);
        $style = str_replace('_circle_2', '_circle', $style);
      }

      $styleClass = array(
        'wrapper' => 'vc_single_image-wrapper',
        'style' => $style,
      );

      $style_box3d = '';
      if ($style == 'vc_box_shadow_3d') {
        $style_box3d = 'vc_box_shadow_3d_wrap';
      }

      if ($this->getContext('border_color')) {
        $styleClass['border'] = ' vc_box_border_' . $this->getContext('border_color');
      }

      $this->image = $this->left
        ->Element(array(
          'type' => 'div',
          'attributes' => array(
            'class' => array(
              'wpb_single_image'
            )
          )
        ));

      $this->image
        ->lastChild()
        ->Element(array(
          'type' => 'div',
          'attributes' => array(
            'class' => $styleClass,
          ),
        ))
        ->lastChild()
        ->Element(array(
          'type' => 'span',
          'attributes' => array(
            'class' => array(
              $style_box3d,
            ),
          ),
        ))
        ->lastChild()
        ->addChildren(new VTCore_Wordpress_Element_WpImage($this->getContext('image_element')));
    }

    if ($this->findContext('label') && $this->getContext('enable.label')) {
      $this->label = $this->left
        ->BsLabel($this->getContext('label_element'));
    }

    $this->startpoint = new VTCore_Html_Element($this->getContext('startpoint_element'));

    if ($this->getContext('direction') != 'center') {
      $this->left->addChildren($this->startpoint);
    }
    else {
      $this->startpoint->addClass('clearboth clearfix');
      $this->addChildren($this->startpoint);
    }

    if ($this->getContext('enable.icon')) {
      $this->addContext('icon_element.attributes.class.startpoint', 'startpoint');
      $this->icon = new VTCore_Fontawesome_faIcon($this->getContext('icon_element'));
      $this->startpoint->addChildren($this->icon)->removeClass('startpoint');
    }


    if ($this->getContext('enable.subtitle')) {
      $this->right
        ->Element($this->getContext('subtitle_element'));
    }

    $this->right
      ->Element(array(
        'type' => 'div',
        'attributes' => array(
          'class' => array(
            'history-text',
          ),
        ),
        'text' => $this->getContext('content'),
        'raw' => true,
      ));


    // Allow user to hijack and alter the history element.
    do_action('vtcore_history_alter_history_content_object', $this);
  }

  public function getGrid() {
    return $this->grids;
  }

  public function getLeftGrid() {
    return $this->leftGrids;
  }

  public function getRightGrid() {
    return $this->rightGrids;
  }

  public function getLeft() {
    return $this->left;
  }

  public function getRight() {
    return $this->right;
  }

  public function getIcon() {
    return $this->icon;
  }

  public function getLabel() {
    return $this->label;
  }

  public function getImage() {
    return $this->image;
  }
}