Welcome to VicTheme History.
============================

This plugin is created for adding history element
shortcodes to the visual composer.

The plugin will implement custom canvas javascript
for linking between elements.

The canvas will look for css class .startpoint and .endpoint
to determine the link path. By default the shortcode
object will attach the startpoint to the title element
and the endpoint to the icon element.

The goal is to provide super simple shortcodes for user,
thus advanced user may need to alter the objects to 
utilize more customized layouts.



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
      
      
History
-------

Shortcode Tags :
      
  [history
    class="some class"
    id="someid"
    gradientone="hex to serve as gradient one fallback"
    gradienttwo="hex to serve as gradient two fallback"
    curvex="curve x fallback"
    curvey="curve y fallback"
    startx="start x fallback"
    starty="start y fallback"
    endx="end x fallback"
    endy="end y fallback"
    linewidth="line width fallback"
    linetype=" line type fallback"
    connector="true|false"]
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
         
   [historyinner
     id="x"
     class="class_one class_two"
     direction="left|right|center"
     image_attachmentid="wp attachment id or image url"
     image_size="the image size using numeric widthxheight or wp image size"
     image_position="the position for the image"
     border_color="the border color as vc border color"
     image_style="extra css class to style the image"
     icon_icon="fontawesome icon class"
     icon_size="the icon size utilizing fontawesome icon sizing"
     icon_rotate="rotate value for the icon"
     icon_flip="flip the icon or not"
     icon_spin="spin the icon"
     icon_border="the border value for the icon wrapper"
     icon_shape="the custom shape for the icon"
     icon_position="the position for the icon"
     icon_inner_padding="the padding for the icon"
     icon_font="the fontsize for the icon overriding the fontawesome icon size rule"
     icon_width="the width for the icon wrapper"
     icon_height="the height for the icon wrapper"
     icon_color="the color for the icon"
     icon_background="the background color for the wrapper element"
     icon_border_color="the border color for the icon"
     label_type="the type for the label according to bootstrap label types"
     label_fontcolor="the font color for the label element"
     label_text="the text for the label"
     label_background="the label background color"
     title="some title"
     title_class="extra css class for title"
     subtitle="some subtitle"
     subtitle_class="extra css class for subtitle"
     data_curve_x="numeric representing pixel value for quadratic curve control point x relative to starting point x"
     data_curve_y="numeric representing pixel value for quadratic curve control point y relative to starting point y"
     data_offset_start_x="numeric representing pixel value for offsetting the start x"
     data_offset_start_y="numeric representing pixel value for offsetting the start y"
     data_offset_end_x="numeric representing pixel value for offsetting the end x"
     data_offset_end_y="numeric representing pixel value for offsetting the end y"
     data_gradientone="hex value for gradient value one"
     data_gradienttwo="hex value for gradient value two"
     data_linewidth="numeric representing the width of the conneting line"
     data_linetype="butt|round|square"
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
     left_grids___columns___mobile="X"
     left_grids___columns___tablet="X"
     left_grids___columns___small="X"
     left_grids___columns___large="X"
     left_grids___offset___mobile="X"
     left_grids___offset___tablet="X"
     left_grids___offset___small="X"
     left_grids___offset___large="X"
     left_grids___push___mobile="X"
     left_grids___push___tablet="X"
     left_grids___push___small="X"
     left_grids___push___large="X"
     left_grids___pull___mobile="X"
     left_grids___pull___tablet="X"
     left_grids___pull___small="X"
     left_grids___pull___large="X"
     right_grids___columns___mobile="X"
     right_grids___columns___tablet="X"
     right_grids___columns___small="X"
     right_grids___columns___large="X"
     right_grids___offset___mobile="X"
     right_grids___offset___tablet="X"
     right_grids___offset___small="X"
     right_grids___offset___large="X"
     right_grids___push___mobile="X"
     right_grids___push___tablet="X"
     right_grids___push___small="X"
     right_grids___push___large="X"
     right_grids___pull___mobile="X"
     right_grids___pull___tablet="X"
     right_grids___pull___small="X"
     right_grids___pull___large="X"
   ]
     some content for the inner shortcodes allowed

   [/historyinner]
   
[/history]




History Inner
-------------

Shortcode Tags :


   [historyinner
     id="x"
     class="class_one class_two"
     direction="left|right|center"
     image_attachmentid="wp attachment id or image url"
     image_size="the image size using numeric widthxheight or wp image size"
     image_position="the position for the image"
     border_color="the border color as vc border color"
     image_style="extra css class to style the image"
     icon_icon="fontawesome icon class"
     icon_size="the icon size utilizing fontawesome icon sizing"
     icon_rotate="rotate value for the icon"
     icon_flip="flip the icon or not"
     icon_spin="spin the icon"
     icon_border="the border value for the icon wrapper"
     icon_shape="the custom shape for the icon"
     icon_position="the position for the icon"
     icon_inner_padding="the padding for the icon"
     icon_font="the fontsize for the icon overriding the fontawesome icon size rule"
     icon_width="the width for the icon wrapper"
     icon_height="the height for the icon wrapper"
     icon_color="the color for the icon"
     icon_background="the background color for the wrapper element"
     icon_border_color="the border color for the icon"
     label_type="the type for the label according to bootstrap label types"
     label_fontcolor="the font color for the label element"
     label_text="the text for the label"
     label_background="the label background color"
     title="some title"
     title_class="extra css class for title"
     subtitle="some subtitle"
     subtitle_class="extra css class for subtitle"
     data_curve_x="numeric representing pixel value for quadratic curve control point x relative to starting point x"
     data_curve_y="numeric representing pixel value for quadratic curve control point y relative to starting point y"
     data_offset_start_x="numeric representing pixel value for offsetting the start x"
     data_offset_start_y="numeric representing pixel value for offsetting the start y"
     data_offset_end_x="numeric representing pixel value for offsetting the end x"
     data_offset_end_y="numeric representing pixel value for offsetting the end y"
     data_gradientone="hex value for gradient value one"
     data_gradienttwo="hex value for gradient value two"
     data_linewidth="numeric representing the width of the conneting line"
     data_linetype="butt|round|square"
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
     left_grids___columns___mobile="X"
     left_grids___columns___tablet="X"
     left_grids___columns___small="X"
     left_grids___columns___large="X"
     left_grids___offset___mobile="X"
     left_grids___offset___tablet="X"
     left_grids___offset___small="X"
     left_grids___offset___large="X"
     left_grids___push___mobile="X"
     left_grids___push___tablet="X"
     left_grids___push___small="X"
     left_grids___push___large="X"
     left_grids___pull___mobile="X"
     left_grids___pull___tablet="X"
     left_grids___pull___small="X"
     left_grids___pull___large="X"
     right_grids___columns___mobile="X"
     right_grids___columns___tablet="X"
     right_grids___columns___small="X"
     right_grids___columns___large="X"
     right_grids___offset___mobile="X"
     right_grids___offset___tablet="X"
     right_grids___offset___small="X"
     right_grids___offset___large="X"
     right_grids___push___mobile="X"
     right_grids___push___tablet="X"
     right_grids___push___small="X"
     right_grids___push___large="X"
     right_grids___pull___mobile="X"
     right_grids___pull___tablet="X"
     right_grids___pull___small="X"
     right_grids___pull___large="X"
   ]

     some content for the inner shortcodes allowed

   [/historyinner]
 

SUPPORT
=======

You can contact support@victheme.com to request support for this plugin.