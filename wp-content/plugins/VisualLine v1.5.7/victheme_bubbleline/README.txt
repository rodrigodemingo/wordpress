Welcome to VicTheme BubbleLine.
============================

This plugin is created for adding bubbleline element
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
      
      
BubbleLine
----------

     
Shortcode Tags :
      
[bubbleline
  class="some class"
  id="someid"
]

  [bubblelineitem
    id="x"
    class="class_one class_two"
    bubble___date="2016"
    bubble___text="the context text"
    bubble___color=""
    bubble___size="small"
    bubble___style="point"
    dot___radius=''
    dot___color=''
    dot___border_color=''
    dot___border_size=''
    line___color=''
    line___width=''
    line___type=''
  ]

    some content for the inner shortcodes allowed

  [/bubblelineitem]

[/bubbleline]
 

SUPPORT
=======

You can contact support@victheme.com to request support for this plugin.