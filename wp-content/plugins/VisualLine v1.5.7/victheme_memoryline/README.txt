Welcome to VicTheme MemoryLine.
============================

This plugin is created for adding memoryline element
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

Version branch 1.4.x and below is compatible with Visual Composer before 1.7.x
Version branch 1.5.x is compatible with Visual Composer after 1.7.x


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
      
      
MemoryLine
-------

     
Shortcode Tags :
      
[memoryline
  class="some class"
  id="someid"
  data___line_color="x"
  data___line_width="x"
  data___line_type="x"
  data___line_offset_x="x"
  data___line_offset_y="y"
]
 
  [memorylineinner
    id="x"
    class="class_one class_two"
    dotcolor="the color for the dotted end"
    titlecolor="the title color"
    textcolor="the text color"
    title="the title text"
    mobile="X" tablet="X" small="X" large="X"
    mobile_offset="X" tablet_offset="X" small_offset="X" large_offset="X"
    mobile_push="X" tablet_push="X" small_push="X" large_push="X"
    mobile_pull="X" tablet_pull="X" small_pull="X" large_pull="X"
    data___dot_direction="x"
    data___dot_radius="x"
    data___dot_color="x"
    data___dot_offset_x="x"
    data___dot_offset_y="x"
    data___line_color="x"
    data___line_width="x"
    data___line_type="x"
  ]
 
    some content for the inner shortcodes allowed
 
  [/memorylineinner]
 
[/memoryline]




MemoryLine Inner
-------------

Shortcode Tags :


[memorylineinner
  id="x"
  class="class_one class_two"
  dotcolor="the color for the dotted end"
  titlecolor="the title color"
  textcolor="the text color"
  title="the title text"
  mobile="X" tablet="X" small="X" large="X"
  mobile_offset="X" tablet_offset="X" small_offset="X" large_offset="X"
  mobile_push="X" tablet_push="X" small_push="X" large_push="X"
  mobile_pull="X" tablet_pull="X" small_pull="X" large_pull="X"
  data___dot_direction="x"
  data___dot_radius="x"
  data___dot_color="x"
  data___dot_offset_x="x"
  data___dot_offset_y="x"
  data___line_color="x"
  data___line_width="x"
  data___line_type="x"
  newrow="true|false"
]

  some content for the inner shortcodes allowed

[/memorylineinner]
 

SUPPORT
=======

You can contact support@victheme.com to request support for this plugin.