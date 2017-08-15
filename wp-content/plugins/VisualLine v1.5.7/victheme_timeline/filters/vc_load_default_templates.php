<?php
/**
 * Registering Theme Default Layout templates
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_TimeLine_Filters_VC__Load__Default__Templates
extends VTCore_Wordpress_Models_Hook {

  public function hook($templates = NULL) {

    // Lapas team member details block
    array_unshift($templates, array(
      'name' => __('* TimeLine Elements', 'victheme_timeline'),
      'custom_class' => 'vtcore-timeline',
      'content' =>
<<<CONTENT
[vc_row][vc_column][timeline][timestart]Ready Go[/timestart][timeevents datetime="10.10" day="Monday" month="August" year="2015" date="15" text="timeline" icon="angle-up" direction="right"][vc_column_text]I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.

[/vc_column_text][/timeevents][timemajor]Major Events[/timemajor][timeevents day="Saturday" month="November" year="2015" date="13" text="Timeline " icon="angle-down" direction="left"][vc_column_text]I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.

[/vc_column_text][/timeevents][timeevents day="Saturday" month="November" year="2015" date="13" text="Timeline " icon="angle-down" direction="right"][vc_column_text]I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.

[/vc_column_text][/timeevents][timeend direction="center"][vc_column_text]Stop Here[/vc_column_text][/timeend][/timeline][/vc_column][/vc_row]
CONTENT
    ));

    return $templates;
  }
}