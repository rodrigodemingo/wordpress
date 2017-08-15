<?php
/**
 * Class extending the Shortcodes base class
 * for building simple memory line. This is created
 * for a very simple memory line object for advanced
 * usage please us the normal memoryline shortcode instead.
 *
 * how to use :
 *
 * [memorylinesimple
 *   class="some class"
 *   id="someid"
 *   data___line_color="x"
 *   data___line_width="x"
 *   data___line_type="x"
 *   data___line_offset_x="x"
 *   data___line_offset_y="y"
 *   columns="1-5"
 *   contentargs="url decoded arrays of content"
 * ]
 *
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_MemoryLine_Shortcodes_MemoryLineSimple
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
    if ($object->get('data')) {
      foreach ($object->get('data') as $key => $value) {
        $newkey = str_replace('_', '-', $key);
        $object->remove('data.' . $key);
        $object->add('data.' . $newkey, $value);
      }
    }

    if (!$object->get('columns')) {
      $object->add('columns', 3);
    }

    $grids = array();
    $left_space = 2;
    $right_space = 2;

    switch ($object->get('columns')) {
      case 1:
        $grids = array(
          'columns' => array(
            'mobile' => 10,
            'tablet' => 8,
            'small' => 8,
            'large' => 8,
          ),
          'offset' => array(
            'mobile' => 2,
            'tablet' => '0',
            'small' => '0',
            'large' => '0',
          )
        );

        $left_space = 2;
        $right_space = 0;
        break;
      case 2:

        $grids = array(
          'columns' => array(
            'mobile' => 10,
            'tablet' => 4,
            'small' => 4,
            'large' => 4,
          ),
          'offset' => array(
            'mobile' => 2,
            'tablet' => '0',
            'small' => '0',
            'large' => '0',
          )
        );

        $left_space = 2;
        $right_space = 1;

        break;
      case 3:

        $grids = array(
          'columns' => array(
            'mobile' => 10,
            'tablet' => 3,
            'small' => 3,
            'large' => 3,
          ),
          'offset' => array(
            'mobile' => 2,
            'tablet' => '0',
            'small' => '0',
            'large' => '0',
          )
        );

        $left_space = 2;
        $right_space = 0;

        break;
      case 4:

        $grids = array(
          'columns' => array(
            'mobile' => 10,
            'tablet' => 2,
            'small' => 2,
            'large' => 2,
          ),
          'offset' => array(
            'mobile' => 2,
            'tablet' => '0',
            'small' => '0',
            'large' => '0',
          )
        );

        $left_space = 2;
        $right_space = 0;

        break;
      case 5:

        $grids = array(
          'columns' => array(
            'mobile' => 10,
            'tablet' => 2,
            'small' => 2,
            'large' => 2,
          ),
          'offset' => array(
            'mobile' => 2,
            'tablet' => '0',
            'small' => '0',
            'large' => '0',
          )
        );

        $left_space = 1;
        $right_space = 0;

        break;
    }

    $object
      ->add('data.line_type', 'round')
      ->add('attributes.class.default', 'memoryline-simple')
      ->add('elements.grids', $grids)
      ->add('left_space', $left_space)
      ->add('right_space', $right_space);

    if ($object->get('contentargs')) {
      $object->add('contents', json_decode(urldecode($object->get('contentargs')), true));
    }

    $this->atts = $object->extract();
    unset($object);
    $object = null;
  }


  public function buildObject() {
    $this->object = new VTCore_MemoryLine_Element_MlElement($this->atts);

    if (isset($this->atts['contents']) && is_array($this->atts['contents'])) {

      $object = new VTCore_Wordpress_Objects_Array($this->atts);

      $direction = 'forward';
      $totalPerRow = $column = $object->get('columns');
      $markup = '';
      foreach ($object->get('contents') as $delta => $content) {

        $data = new VTCore_Wordpress_Objects_Array($content);
        $data->add('grids', $object->get('elements.grids'));

        $newrow = false;
        // Switch direction
        if ($column == 0) {

          if ($direction == 'forward') {
            $direction = 'reverse';


          }
          else {
            $direction = 'forward';
            $data->add('grids.offset', array(
              'mobile' => '2',
              'tablet' => $object->get('left_space'),
              'small' => $object->get('left_space'),
              'large' => $object->get('left_space'),
            ));
          }

          // Refresh count
          $column = $totalPerRow;
          $newrow = true;
        }

        if ($object->get('right_space') && $direction == 'reverse') {
          $data->add('grids.pull', array(
            'mobile' => '0',
            'tablet' => $object->get('right_space'),
            'small' => $object->get('right_space'),
            'large' => $object->get('right_space'),
          ));
        }
        $data
          ->add('data.dot_direction', $direction)
          ->add('newrow', $newrow)
          ->add('text_element.grids', array(
            'columns' => array(
              'mobile' => 12,
              'tablet' => 12,
              'small' => 12,
              'large' => 12,
            ),
          ))
          ->add('title_element.grids', array(
            'columns' => array(
              'mobile' => 12,
              'tablet' => 12,
              'small' => 12,
              'large' => 12,
            ),
          ));

        $shortcode = new VTCore_MemoryLine_Shortcodes_MemoryLineInner($data->extract(), $data->get('content'), 'memorylineinner');
        $shortcode->buildObject();

        $markup .= $shortcode->getMarkup();

        unset($shortcode);
        $shortcode = NULL;

        unset($data);
        $data = NULL;

        $column--;
      }

      if (!empty($markup)) {
        $this->object->addChildren($markup);
      }

      // Free Memory
      unset($object);
      $object = NULL;
    }
  }
}


