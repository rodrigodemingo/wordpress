<?php
/**
 * Class extending the Shortcodes base class
 * for building simple history line. This is created
 * for a very simple history line object.
 *
 * how to use :
 *
 * [historysimple
 *   class="some class"
 *   id="someid"
 *   contentargs="url decoded arrays of content"
 *   gradientone="hex to serve as gradient one fallback"
 *   gradienttwo="hex to serve as gradient two fallback"
 *   linewidth="line width fallback"
 *   linetype=" line type fallback"
 * ]
 *
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_History_Shortcodes_HistorySimple
extends VTCore_Wordpress_Models_Shortcodes
implements VTCore_Wordpress_Interfaces_Shortcodes {

  protected $processDottedNotation = true;
  /**
   * Extending parent method.
   * @see VTCore_Wordpress_Models_Shortcodes::processCustomRules()
   */
  protected function processCustomRules() {

    if ($this->get('contentargs')) {
      $this->add('contents', json_decode(urldecode($this->get('contentargs')), true));
    }

    $this
      ->add('attributes.class.shortcode', 'historyline-simple')
      ->add('connector', true)
      ->add('grids', array(
        'columns' => array(
          'mobile' => 12,
          'small' => 12,
          'tablet' => 12,
          'large' => 12,
        ),
      ));

    // Processing content
    foreach ($this->get('contents') as $delta => $content) {
      $odd = ($delta % 2 == 1);
      $object = new VTCore_Wordpress_Objects_Array($content);

      $object
        ->add('data_gradientone', $this->get('gradientone'))
        ->add('data_gradienttwo', $this->get('gradienttwo'))
        ->add('data_linewidth', $this->get('linewidth'))
        ->add('data_linetype', $this->get('linetype'))
        ->add('icon_position', 'center')
        ->add('image_position', 'center');

      // Build Icon
      if ($this->get('icon.icon')) {
        $object
          ->add('enable___icon', true)
          ->add('icon_icon', $this->get('icon.icon'))
          ->add('icon_width', '40px')
          ->add('icon_height', '40px')
          ->add('icon_shape', 'circle')
          ->add('icon_inner_padding', '10px')
          ->add('icon_font', '20px')
          ->add('icon_color', $this->get('icon.color'))
          ->add('icon_background', $this->get('icon.background'));
      }

      // Build Label
      if ($object->get('label_text')) {
        $object
          ->add('enable___label', true)
          ->add('label_background', $this->get('label.background'))
          ->add('label_fontcolor', $this->get('label.color'));
      }

      // Build Image
      if ($object->get('image_attachmentid')) {
        $object
          ->add('enable___image', true)
          ->add('image_style', $this->get('image.style'))
          ->add('image_size', $this->get('image.size'));
      }

      // Build Grids
      $object
        ->add('grids', array(
          'columns' => array(
            'mobile' => 12,
            'tablet' => 12,
            'small' => 12,
            'large' => 12,
          ),
        ))
        ->add('left_grids', array(
          'columns' => array(
            'mobile' => 12,
            'tablet' => 6,
            'small' => 6,
            'large' => 6,
          ),
        ))
        ->add('right_grids', array(
          'columns' => array(
            'mobile' => 9,
            'tablet' => 6,
            'small' => 6,
            'large' => 6,
          ),
          'offset' => array(
            'mobile' => 3,
            'tablet' => 0,
            'small' => 0,
            'large' => 0,
          )
        ));

      if ($odd) {
        $object
          ->add('direction', 'right')
          ->add('data_curve_x', 70)
          ->add('data_curve_y', 200);
      }

      else {
        $object
          ->add('direction', 'left')
          ->add('data_curve_x', -70)
          ->add('data_curve_y', 200);
      }

      $this->add('contents.' .$delta, $object->extract());
      unset($object);
      $object = null;

    }
  }


  public function buildObject() {
    
    $this->object = new VTCore_History_Element_HsElement($this->atts);

    if ($this->get('contents')) {
      $markup = '';
      foreach ($this->get('contents') as $delta => $content) {
        $data = new VTCore_Wordpress_Objects_Array($content);
        $shortcode = new VTCore_History_Shortcodes_HistoryInner($data->extract(), $data->get('content'), 'historyinner');
        $shortcode->buildObject();
        $markup .= $shortcode->getMarkup();

        unset($data);
        $data = NULL;

        unset($shortcode);
        $shortcode = NULL;
      }

      if (!empty($markup)) {
        $this->object->addChildren($markup);
      }
    }
  }
}


