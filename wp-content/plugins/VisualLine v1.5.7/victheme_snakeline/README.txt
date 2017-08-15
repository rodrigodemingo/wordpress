Welcome to VicTheme SnakeLine.
============================

This plugin is created for adding snakeline element
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
      
      
SnakeLine
----------

     
Shortcode Tags :
      
[snakeline
  class="some class"
  id="someid"
  line___color=""
  line___width=""
  line___type=""
]

  [snakelineitem
    id="x"
    class="class_one class_two"
    date___text="2016"
    date___color=""
    content___text="the context text"
    content___color=""
    dot___link=""
    dot___color=""
    dot___background=""
    dot___text=""
  ]

    some content for the inner shortcodes allowed

  [/snakelineitem]

[/snakeline]
 

SUPPORT
=======

You can contact support@victheme.com to request support for this plugin.