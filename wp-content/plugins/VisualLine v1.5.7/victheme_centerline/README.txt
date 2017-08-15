Welcome to VicTheme CenterLine.
============================

This plugin is created for adding centerline element
shortcodes to the visual composer.

The plugin will implement custom canvas javascript
for linking between elements.



Requirements
============

This plugin has 2 dependencies :
1. VicTheme Core Plugin
2. Visual Composer Plugin

Before the dependencies are installed and enabled, this plugin won't activate
itself to prevent site crash.

DEPENDENCIES
============

Version branch 1.5.x and below is compatible with Visual Composer before 1.7.x
Version branch 1.6.x is compatible with Visual Composer after 1.7.x

INSTALLATION
============

This plugin has no special installation instruction, just download the plugin
and its dependencies and upload them to wp-content/plugin directory then
activate this plugin and its dependencies via WordPress plugin manager page.


AVAILABLE SHORTCODES
====================

Note: The example shown is formatted for easy reading. it is NOT a valid
      WordPress Shortcode API format. The valid format doesn't allow any
      spaces or new line in the content, sub content and attributes.
      
      
CenterLine
-------

     
Shortcode Tags :
      
  [centerline
    class="some class"
    id="someid"
    grids___columns___mobile="X"
    grids___columns___tablet="X"
    grids___columns___small="X"
    grids___columns___large="X"
    grids___offset___mobile="X"
    grids___offset___tablet="X"
    grids___offset___small="X"
    grids___offset___large="X"
    grids___push___mobile="X"
    grids___push___tablet="X"
    grids___push___small="X"
    grids___push___large="X"
    grids___pull___mobile="X"
    grids___pull___tablet="X"
    grids___pull___small="X"
    grids___pull___large="X"
    data___circle_start="x"
    data___circle_end="X"
    data___circle_opaque="X"
    data___circle_opacity="X"
    data___line_color="X"
    data___line_width="X"
    data___line_type="X"
    data___dot_color="X"
  ]
  
    [centerlineimage
      class="some class"
      id="someid"
      image_attachmentid="the wp attachment id to serve as the center image"
      image_size="the size for center image"
      image_position="the position of the image"
      image_style="the style for the image"
      border_color="the border color for the image"
      grids___columns___mobile="X"
      grids___columns___tablet="X"
      grids___columns___small="X"
      grids___columns___large="X"
      grids___offset___mobile="X"
      grids___offset___tablet="X"
      grids___offset___small="X"
      grids___offset___large="X"
      grids___push___mobile="X"
      grids___push___tablet="X"
      grids___push___small="X"
      grids___push___large="X"
      grids___pull___mobile="X"
      grids___pull___tablet="X"
      grids___pull___small="X"
      grids___pull___large="X"
    ]
      
      This shortcode is capable to have child shortcode.
   
    [/centerlineimage]
 
  [centerlineinner
    id="x"
    class="class_one class_two"
    mobile="X" tablet="X" small="X" large="X"
    mobile_offset="X" tablet_offset="X" small_offset="X" large_offset="X"
    mobile_push="X" tablet_push="X" small_push="X" large_push="X"
    mobile_pull="X" tablet_pull="X" small_pull="X" large_pull="X"
    data___circle_start="3"
    data___circle_end="4"
    data___circle_opaque="10"
    data___circle_opacity="0.6"
    data___line_color= "#158FBF"
    data___line_width="1"
    data___line_type= "round"
    data___dot_color= "#158FBF"
    data___position_start= "center"
    data___position_end= "top"
    data___offset_control_x="0"
    data___offset_control_y="100"
    data___offset_start_x="0"
    data___offset_start_y="0"
    data___offset_end_x="0"
    data___offset_end_y="0"
  ]
 
    some content for the inner shortcodes allowed
 
  [/centerlineinner]
 
  [/centerline]


CenterLine Image
----------------

Shortcode Tags :

  [centerlineimage
    class="some class"
    id="someid"
    image_attachmentid="the wp attachment id to serve as the center image"
    image_size="the size for center image"
    image_position="the position of the image"
    image_style="the style for the image"
    border_color="the border color for the image"
    grids___columns___mobile="X"
    grids___columns___tablet="X"
    grids___columns___small="X"
    grids___columns___large="X"
    grids___offset___mobile="X"
    grids___offset___tablet="X"
    grids___offset___small="X"
    grids___offset___large="X"
    grids___push___mobile="X"
    grids___push___tablet="X"
    grids___push___small="X"
    grids___push___large="X"
    grids___pull___mobile="X"
    grids___pull___tablet="X"
    grids___pull___small="X"
    grids___pull___large="X"
  ]
 
  [/centerlineimage]

CenterLine Inner
----------------

Shortcode Tags :


   [centerlineinner
     id="x"
     class="class_one class_two"
     mobile="X" tablet="X" small="X" large="X"
     mobile_offset="X" tablet_offset="X" small_offset="X" large_offset="X"
     mobile_push="X" tablet_push="X" small_push="X" large_push="X"
     mobile_pull="X" tablet_pull="X" small_pull="X" large_pull="X"
     data___circle_start="3"
     data___circle_end="4"
     data___circle_opaque="10"
     data___circle_opacity="0.6"
     data___line_color= "#158FBF"
     data___line_width="1"
     data___line_type= "round"
     data___dot_color= "#158FBF"
     data___position_start= "center"
     data___position_end= "top"
     data___offset_control_x="0"
     data___offset_control_y="100"
     data___offset_start_x="0"
     data___offset_start_y="0"
     data___offset_end_x="0"
     data___offset_end_y="0"
   ]
  
     some content for the inner shortcodes allowed
  
   [/centerlineinner]
  
 

SUPPORT
=======

You can contact support@victheme.com to request support for this plugin.