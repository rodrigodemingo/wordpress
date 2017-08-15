<?php
/**
 * Registering Theme Default Layout templates
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Centerline_Filters_VC__Load__Default__Templates
extends VTCore_Wordpress_Models_Hook {

  public function hook($templates = NULL) {

    // Center line block
    array_unshift($templates, array(
      'name' => __('* CenterLine Elements', 'victheme_centerline'),
      'custom_class' => 'vtcore-centerline',
      'content' =>
<<<CONTENT
[vc_row][vc_column][centerline data___circle_start="3" data___circle_end="3" data___circle_opaque="10" data___circle_opacity="0.6" data___line_width="1" data___line_color="#158fbf" data___dot_color="#158fbf" grids___columns___mobile="12" grids___columns___tablet="12" grids___columns___small="12" grids___columns___large="12" grids___offset___mobile="0" grids___offset___tablet="0" grids___offset___small="0" grids___offset___large="0" grids___push___mobile="0" grids___push___tablet="0" grids___push___small="0" grids___push___large="0" grids___pull___mobile="0" grids___pull___tablet="0" grids___pull___small="0" grids___pull___large="0"][centerlineimage image_attachmentid="1823" image_size="200x200" image_position="center" grids___columns___mobile="12" grids___columns___tablet="12" grids___columns___small="12" grids___columns___large="12" grids___offset___mobile="0" grids___offset___tablet="0" grids___offset___small="0" grids___offset___large="0" grids___push___mobile="0" grids___push___tablet="0" grids___push___small="0" grids___push___large="0" grids___pull___mobile="0" grids___pull___tablet="0" grids___pull___small="0" grids___pull___large="0"][/centerlineimage][centerlineinner data___position_start="left" data___position_end="right" data___offset_start_x="0" data___offset_start_y="0" data___offset_end_x="0" data___offset_end_y="0" data___offset_control_x="-60" data___offset_control_y="-100" data___circle_start="3" data___circle_end="3" data___circle_opaque="10" data___circle_opacity="0.6" data___line_width="1" data___line_color="#158fbf" data___dot_color="#158fbf" columns_mobile="12" columns_tablet="3" columns_small="3" columns_large="3" offset_mobile="0" offset_tablet="0" offset_small="0" offset_large="0" push_mobile="0" push_tablet="0" push_small="0" push_large="0" pull_mobile="0" pull_tablet="0" pull_small="0" pull_large="0" css=".vc_custom_1442669826420{margin-top: -20px !important;}"][vc_column_text]

I am text block.

[/vc_column_text][/centerlineinner][centerlineinner data___position_start="bottom" data___offset_start_x="0" data___offset_start_y="0" data___offset_end_x="0" data___offset_end_y="0" data___offset_control_x="50" data___offset_control_y="100" data___circle_start="3" data___circle_end="3" data___circle_opaque="10" data___circle_opacity="0.6" data___line_width="1" data___line_color="#158fbf" data___dot_color="#158fbf" columns_mobile="12" columns_tablet="3" columns_small="3" columns_large="3" offset_mobile="0" offset_tablet="1" offset_small="1" offset_large="1" push_mobile="0" push_tablet="0" push_small="0" push_large="0" pull_mobile="0" pull_tablet="0" pull_small="0" pull_large="0" css=".vc_custom_1437353981750{margin-top: 180px !important;}"][vc_column_text]

I am text block.

[/vc_column_text][/centerlineinner][centerlineinner data___position_start="right" data___offset_start_x="0" data___offset_start_y="0" data___offset_end_x="0" data___offset_end_y="0" data___offset_control_x="0" data___offset_control_y="100" data___circle_start="3" data___circle_end="3" data___circle_opaque="10" data___circle_opacity="0.6" data___line_width="1" data___line_color="#158fbf" data___dot_color="#158fbf" columns_mobile="12" columns_tablet="3" columns_small="3" columns_large="3" offset_mobile="0" offset_tablet="2" offset_small="2" offset_large="2" push_mobile="0" push_tablet="0" push_small="0" push_large="0" pull_mobile="0" pull_tablet="0" pull_small="0" pull_large="0" css=".vc_custom_1437354064760{margin-top: 20px !important;}"][vc_column_text]

I am text block.

[/vc_column_text][/centerlineinner][/centerline][/vc_column][/vc_row]
CONTENT
    ));

    return $templates;
  }
}