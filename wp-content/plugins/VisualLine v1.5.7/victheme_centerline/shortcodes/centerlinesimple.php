<?php
/**
 * Class extending the Shortcodes base class
 * for building the centerlinesimple element
 *
 * how to use :
 *
 * [centerlinesimple
 *   image___image_attachmentid=""
 *   image___image_size=""
 *   image___image_style=""
 *   image___border_color=""
 * 
 *   left___enabled="true|false"
 *   left___data___circle_start="3"
 *   left___data___circle_end="4"
 *   left___data___circle_opaque="10"
 *   left___data___circle_opacity="0.6"
 *   left___data___line_color= "#158FBF"
 *   left___data___line_width="1"
 *   left___data___dot_color= "#158FBF"
 *   left___text=""
 *   left___content=""
 *   left___textcolor=""
 *   left___contentcolor=""
 *
 *   center___enabled="true|false"
 *   center___data___circle_start="3"
 *   center___data___circle_end="4"
 *   center___data___circle_opaque="10"
 *   center___data___circle_opacity="0.6"
 *   center___data___line_color= "#158FBF"
 *   center___data___line_width="1"
 *   center___data___dot_color= "#158FBF"
 *   center___text=""
 *   center___content=""
 *   center___textcolor=""
 *   center___contentcolor=""
 *
 *   right___enabled="true|false"
 *   right___data___circle_start="3"
 *   right___data___circle_end="4"
 *   right___data___circle_opaque="10"
 *   right___data___circle_opacity="0.6"
 *   right___data___line_color= "#158FBF"
 *   right___data___line_width="1"
 *   right___data___dot_color= "#158FBF"
 *   right___text=""
 *   right___content=""
 *   right___textcolor=""
 *   right___contentcolor=""
 * ]
 *
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_CenterLine_Shortcodes_CenterLineSimple
extends VTCore_Wordpress_Models_Shortcodes
implements VTCore_Wordpress_Interfaces_Shortcodes {

  protected $processDottedNotation = true;

  /**
   * Extending parent method.
   * @see VTCore_Wordpress_Models_Shortcodes::processCustomRules()
   */
  protected function processCustomRules() {

    // Convert the bootstrap classes into vc compatible one
    $this->convertVCGrid = !get_theme_support('bootstrap');

    $object = new VTCore_Wordpress_Objects_Array($this->atts);

    $object
      ->add('grids.columns', array(
        'mobile' => 12,
        'tablet' => 12,
        'small' => 12,
        'large' => 12,
      ))
      ->add('attributes.class.default', 'centerline-simple');

    if ($object->get('image')) {
      $object
        ->add('image.grids', array(
          'columns' => array(
            'mobile' => 12,
            'tablet' => 12,
            'small' => 12,
            'large' => 12,
          ),
        ))
        ->add('image.image_position', 'center')
        ->add('image.attributes.class.default', 'centerline-simple-image');
    }

    if ($object->get('left.enabled')) {
      $object
        ->add('left.grids', array(
          'columns' => array(
            'mobile' => 4,
            'tablet' => 3,
            'small' => 3,
            'large' => 3,
          ),
          'offset' => array(
            'mobile' => 0,
            'tablet' => 0,
            'small' => 0,
            'large' => 0,
          )
        ))
        ->add('left.data.position_start', 'left')
        ->add('left.data.position_end', 'right')
        ->add('left.data.offset_start_x', -15)
        ->add('left.data.offset_start_y', 0)
        ->add('left.data.offset_control_x', -60)
        ->add('left.data.offset_control_y', -40)
        ->add('left.data.offset_end_x', 20)
        ->add('left.data.offset_end_y', 0)
        ->add('left.data.line_type', 'round')
        ->add('left.attributes.class.default', 'centerline-simple-left');
    }

    if ($object->get('center.enabled')) {
      $object
        ->add('center.grids', array(
          'columns' => array(
            'mobile' => 4,
            'tablet' => 3,
            'small' => 3,
            'large' => 3,
          ),
          'offset' => array(
            'mobile' => 0,
            'tablet' => 1,
            'small' => 1,
            'large' => 1,
          )
        ))
        ->add('center.data.position-start', 'bottom')
        ->add('center.data.position_end', 'top')
        ->add('center.data.offset_start_x', 0)
        ->add('center.data.offset_start_y', 20)
        ->add('center.data.offset_control_x', 0)
        ->add('center.data.offset_control_y', 40)
        ->add('center.data.offset_end_x', 0)
        ->add('center.data.offset_end_y', -20)
        ->add('center.data.line_type', 'round')
        ->add('center.attributes.class.default', 'centerline-simple-center');
    }

    if ($object->get('right.enabled')) {
      $object
        ->add('right.grids', array(
          'columns' => array(
            'mobile' => 4,
            'tablet' => 3,
            'small' => 3,
            'large' => 3,
          ),
          'offset' => array(
            'mobile' => 0,
            'tablet' => 2,
            'small' => 2,
            'large' => 2,
          )
        ))
        ->add('right.data.position_start', 'right')
        ->add('right.data.position_end', 'left')
        ->add('right.data.offset_start_x', 15)
        ->add('right.data.offset_start_y', 0)
        ->add('right.data.offset_control_x', 0)
        ->add('right.data.offset_control_y', 80)
        ->add('right.data.offset_end_x', -20)
        ->add('right.data.offset_end_y', 0)
        ->add('right.data.line_type', 'round')
        ->add('right.attributes.class.default', 'centerline-simple-right');
    }

    $this->atts = $object->extract();

    $this->remove('grids');

    // Free Memory
    unset($object);
    $object = NULL;
  }



  public function buildObject() {
    $this->object = new VTCore_CenterLine_Element_ClElement($this->atts);

    $object = new VTCore_Wordpress_Objects_Array($this->atts);

    if ($object->get('image')) {
      $shortcode = new VTCore_CenterLine_Shortcodes_CenterLineImage($object->get('image'), false, 'centerlineimage');
      $shortcode->buildObject();
      $this->object->addChildren($shortcode->getMarkup());
    }

    foreach (array('left', 'center', 'right') as $position) {

      if ($object->get($position . '.enabled')) {

        $content = new VTCore_Html_Element();
        if ($object->get($position . '.text')) {

          $content
            ->addChildren(new VTCore_Html_Element(array(
              'type' => 'h2',
              'text' => $object->get($position . '.text'),
            )));

          if ($object->get($position . '.textcolor')) {
            $content->lastChild()
              ->addStyle('color', $object->get($position . '.textcolor'));
          }
        }

        if ($object->get($position . '.content')) {
          $content
            ->addChildren(new VTCore_Html_Element(array(
              'type' => 'p',
              'text' => $object->get($position . '.content'),
            )));
          if ($object->get($position . '.contentcolor')) {
            $content->lastChild()
              ->addStyle('color', $object->get($position . '.contentcolor'));
          }
        }

        $shortcode = new VTCore_CenterLine_Shortcodes_CenterLineInner($object->get($position), $content->__toString(), 'centerlineinner');
        $shortcode->buildObject();
        $this->object->addChildren($shortcode->getMarkup());
      }
    }

    // Free Memory
    unset($object);
    $object = NULL;

    if (isset($shortcode)) {
      unset($shortcode);
      $shortcode = null;
    }

  }
}