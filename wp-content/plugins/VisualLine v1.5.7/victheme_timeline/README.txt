Welcome to VicTheme TimeLine
=====================================

This plugin is created for adding Timeline element shortcodes and integration to 
Visual composer plugin


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


DEPENDENCIES
============

Version branch 1.4.x and below is compatible with Visual Composer before 1.7.x
Version branch 1.5.x is compatible with Visual Composer after 1.7.x


BUILD USING PHP OBJECTS EXAMPLE
================================

$timeline = new VTCore_Timeline_Element();

$timeline->addStart(array(
  'text' => 'Some Starting Text',
  'direction' => 'center',
));

$timeline->addMajor(array(
  'text' => 'Major text',
  'direction' => 'center',
));

$timeline->addEvent(array(
  'datetime' => the datetime attribute for time element,
  'time' => the text for the time span,
  'date' => the text for the date span,
  'icon' => fontawesome font class,
  'text' => string of text for event heading,
  'content' => string of text for event content,
  'direction' => left|right,
));

$timeline->addEnd(array(
  'text' => 'End',
  'direction' => 'center',
));



AVAILABLE SHORTCODES
====================

Time Start
----------


Shortcode Tags :

Note :  This shortcode must be placed inside the [timeline] shortcode otherwise it will produce invalid HTML markup

[timestart direction="top|left|right|bottom|center"]
  Some text to represent major events
[/timestart]


Time Events
-----------


Shortcode Tags :

Note :  This shortcode must be placed inside the [timeline] shortcode otherwise it will produce invalid HTML markup


[timeevents
   datetime="YYYY-MM-DDTHH:MM"
   day="eg. Monday"
   month="eg. January"
   year="eg. 2014"
   date="eg. 12"
   icon="fontawesome icon name"
   text="the event title"
   direction="left|right"
]

 Some content representing the event content

[/timeevents]





Time Line
---------

Note :  This shortcode must be have [timestart], [timeends], [timeevents] or [timemajor] as its direct children to avoid invalid markups or styling.


Shortcode Tags :

[timeline class="some class" id="someid" align="left|right|empty for center" ending_text="text for the end bubble"]
  
    [timemajor]Some text to represent major events[/timemajor]
    
    [timeevents
      datetime="YYYY-MM-DDTHH:MM"
      date="the date text"
      time="the time text"
      icon="fontawesome icon name"
      text="the event title"
      direction="left|right" // only applicable if the parent didn't specify align (centered)
      ]
      Some content representing the event content
    [/timeevents]
    
[/timeline]





Time Major
----------


Note :  This shortcode must be placed inside the [timeline] shortcode otherwise it will produce invalid HTML markup


Shortcode Tags :

[timemajor]Some text to represent major events[/timemajor]





Time End
--------


Note :  This shortcode must be placed inside the [timeline] shortcode otherwise it will produce invalid HTML markup


Shortcode Tags :

[timeend direction="left|right|top|bottom|center"]
  Some text to represent end text
[/timeend]





Time Query
-----------

Building a timeline using post query, this shortcode is recommended to be used with visualcomposer.

Shortcode Tags :

[timelinesimple
   icon="the icon class name for fontawesome"
   align="left|right|centered"
   layout="horizontal|vertical"
   queryargs="url encoded json format valid query args for wp_query object"
   timeselect="modified|created"
]



Time Simple
-----------

Building simple timeline, this shortcode is recommended to be used with visualcomposer


Shortcode Tags :

[timelinesimple
  align="left|right|centered"
  layout="horizontal|vertical"
  contentargs="url encoded json format"
]



SUPPORT
=======

You can contact support@victheme.com to request support for this plugin.