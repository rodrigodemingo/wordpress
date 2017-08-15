<?php
/**
 * Class extending the Shortcodes base class
 * for building the timeline element
 *
 * how to use :
 *
 * [timeline class="some class" id="someid" align="left|right|empty for center" ending_text="text for the end bubble"]
 * [timemajor]Some text to represent major events[/timemajor]
 * [timeevents
 *   datetime="YYYY-MM-DDTHH:MM"
 *   date="the date text"
 *   time="the time text"
 *   icon="fontawesome icon name"
 *   text="the event title"
 *   direction="left|right" // only applicable if the parent didn't specify align (centered)
 *   ending_text="text for the ending line bubble"
 * ]
 * Some content representing the event content
 * [/timeevents]
 * [/timeline]
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Timeline_Shortcodes_TimeLine
extends VTCore_Wordpress_Models_Shortcodes
implements VTCore_Wordpress_Interfaces_Shortcodes {

  protected function processCustomRules() {

    // Convert the bootstrap classes into vc compatible one
    $this->convertVCGrid = !get_theme_support('bootstrap');

    // Compatibility with old shortcode
    if (!isset($this->atts['layout'])) {
      $this->atts['layout'] = 'vertical';

      if (!isset($this->atts['align']) || empty($this->atts['align'])) {
        $this->atts['align'] = 'center';
      }
    }

    if (isset($this->atts['layout'])) {
      $this->atts['data']['layout'] = $this->atts['layout'];
    }
    if (isset($this->atts['align'])) {
      $this->atts['data']['align'] = $this->atts['align'];
    }

    // Vertical doesn't support top or bottom
    if ($this->atts['layout'] == 'vertical') {
      $this->content = str_replace(array('direction="top"', 'direction="bottom"'), array('direction="left"', 'direction="right"'), $this->content);
    }

    // Horizontal doesn't support left or right
    if ($this->atts['layout'] == 'horizontal') {
      $this->content = str_replace(array('direction="left"', 'direction="right"'), array('direction="top"', 'direction="bottom"'), $this->content);
    }
  }

  public function buildObject() {
    $this->object = new VTCore_Timeline_Element_TimeLine($this->atts);
    $this->object->addChildren(do_shortcode($this->content));
  }
}