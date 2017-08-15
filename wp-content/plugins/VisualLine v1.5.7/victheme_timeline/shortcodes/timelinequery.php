<?php
/**
 * Class extending the Shortcodes base class
 * for building the timeline query element
 *
 * how to use :
 *
 * [timelinequery
 *   icon="the icon class name for fontawesome"
 *   align="left|right|centered"
 *   layout="horizontal|vertical"
 *   queryargs="url encoded json format valid query args for wp_query object"
 *   timeselect="modified|created"
 * ]
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Timeline_Shortcodes_TimeLineQuery
extends VTCore_Wordpress_Models_Shortcodes
implements VTCore_Wordpress_Interfaces_Shortcodes {

  protected $processDottedNotation = true;


  protected function processCustomRules() {

    global $post;

    // Convert the bootstrap classes into vc compatible one
    $this->convertVCGrid = !get_theme_support('bootstrap');

    if (!$this->get('layout')) {
      $this->add('layout', 'vertical');
    }

    if (!$this->get('align')) {
      $this->add('align', 'center');
    }

    if (!$this->get('ordersort')) {
      $this->add('ordersort', 'latest');
    }

    $this
      ->processArgs()
      ->add('data.layout', $this->get('layout'))
      ->add('data.align', $this->get('align'))
      ->add('attributes.class.default', 'timeline-query')
      ->add('query', new WP_Query($this->get('args')));


    if ($this->get('query')->have_posts()) {

      $delta = 0;
      foreach ($this->get('query')->get_posts() as $post) {

        // Get the date source
        $date = $post->post_date;
        $time = mysql2date('U', $date);
        $icon = $this->get('icon.odd');

        if ($this->get('timeselect') == 'modified') {
          $date = $post->post_modified;
        }

        if ($delta % 2 == 0) {
          $icon = $this->get('icon.even');
        }

        $this
          ->add('contents.' . $time . '.icon', $icon)
          ->add('contents.' . $time . '.text', wp_kses_post($post->post_title))
          ->add('contents.' . $time . '.image', get_post_thumbnail_id($post->post_id))
          ->add('contents.' . $time . '.size', 'large')
          ->add('contents.' . $time . '.content', $this->generateExcerpt($post))
          ->add('contents.' . $time . '.datetime', mysql2date('Y-m-dTG:i', $date))
          ->add('contents.' . $time . '.day', mysql2date('l', $date))
          ->add('contents.' . $time . '.month', mysql2date('F', $date))
          ->add('contents.' . $time . '.year', mysql2date('Y', $date))
          ->add('contents.' . $time . '.date', mysql2date('d', $date));


        // Alternate on center, vertical and odd number
        if ($this->get('align') == 'center'
            && $this->get('layout') == 'vertical'
            && $delta % 2 == 0) {

          $this->add('contents.' . $time . '.direction', 'left');
        }

        // Alternate on center, vertical and even number
        elseif ($this->get('align') == 'center'
          && $this->get('layout') == 'vertical'
          && $delta % 2 != 0) {

          $this->add('contents.' . $time . '.direction', 'right');
        }

        // Alternate on center, horizontal and odd number
        elseif ($this->get('align') == 'center'
          && $this->get('layout') == 'horizontal'
          && $delta % 2 == 0) {

          $this->add('contents.' . $time . '.direction', 'top');
        }

        // Alternate on center, horizontal and even number
        elseif ($this->get('align') == 'center'
          && $this->get('layout') == 'horizontal'
          && $delta % 2 != 0) {

          $this->add('contents.' . $time . '.direction', 'bottom');
        }

        // Dont alternate at all
        else {
          $this->add('contents.' . $time . '.direction', $this->get('align'));
        }

        $delta++;

      }


      // Sort the content
      if ($this->get('contents')) {
        $timelines = $this->get('contents');

        if ($this->get('ordersort') == 'latest') {
          krsort($timelines);
        }
        else {
          ksort($timelines);
        }

        $this->add('contents', $timelines);

        unset($timelines);
        $timelines = null;
      }
    }

  }


  public function generateExcerpt($post) {

    setup_postdata($post);
    $content = '';
    if (isset($post->post_excerpt) && !empty($post->post_excerpt)) {
      $content = do_shortcode($post->post_excerpt);
    }

    if (empty($content)) {
      $content = get_the_excerpt();
    }

    wp_reset_postdata();
    return $content;
  }



  public function buildObject() {
    $this->object = new VTCore_Timeline_Element_TimeLine($this->atts);

    $object = new VTCore_Wordpress_Objects_Array($this->atts);

    $align = $object->get('align');
    if ($object->get('layout') == 'horizontal') {
      $align = 'center';
    }

    if ($object->get('start')) {
      $this->object->addStart(array(
        'text' => $object->get('start'),
        'direction' => $align,
      ));
    }

    if ($object->get('contents')) {
      foreach ($object->get('contents') as $delta => $content) {
        $this->object->addEvent($content);
      }
    }

    if ($object->get('end')) {
      $this->object->addEnd(array(
        'text' => $object->get('end'),
        'direction' => $align,
      ));
    }

    // Free Memory
    unset($object);
    $object = NULL;
  }


  /**
   * Helper function for translating the queryargs
   * shortcode value into valid arrays for wp_query
   * object.
   *
   * @return $this
   */
  protected function processArgs() {

    $args = $this->get('queryargs');

    // Try json first
    if (is_string($args)) {
      $converted = json_decode(html_entity_decode($args), true);

      if (is_array($converted)) {
        $args = $converted;
      }
    }

    // Maybe in url query format
    if (is_string($args)) {
      $converted = wp_parse_args(html_entity_decode($args));

      if (is_array($converted)) {
        $args = $converted;
      }
    }

    // Use empty array if all fails
    if (!is_array($args)) {
      $args = array();
    }

    $queryArgs = new VTCore_Wordpress_Objects_Array($args);

    if ($queryArgs->get('query')) {

      $object = new VTCore_Wordpress_Objects_Array();

      foreach ($queryArgs->get('query') as $key => $data) {
        if ($key == 'taxonomy') {
          foreach ($data as $delta => $value) {
            if (is_numeric($delta)) {
              if (empty($value['terms']) || empty($value['taxonomy'])) {
                unset($data[$delta]);
              }
            }
          }

          if (count($data) > 1) {
            $object->add('tax_query', $data);
          }
        }

        elseif ($key == 'meta') {
          foreach ($data as $delta => $value) {
            if (is_numeric($delta)) {
              if (empty($value['key']) || empty($value['value'])) {
                unset($data[$delta]);
              }
            }
          }

          if (count($data) > 1) {
            $object->add('meta_query', $data);
          }
        }
        else {
          $object->merge($data);
        }

      }

      $this->add('args', $object->extract());

      // Free Memory
      unset($object);
      $object = NULL;
    }

    return $this;
  }
}