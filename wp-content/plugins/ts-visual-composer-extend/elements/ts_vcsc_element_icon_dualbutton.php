<?php
    global $VISUAL_COMPOSER_EXTENSIONS;
	if ((class_exists('WPBakeryShortCode')) && (!class_exists('WPBakeryShortCode_TS_VCSC_Icon_Dual_Button'))) {
		class WPBakeryShortCode_TS_VCSC_Icon_Dual_Button extends WPBakeryShortCode {};
	};
    $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element = array(
		"name"                      	=> __( "TS Icon Dual Button", "ts_visual_composer_extend" ),
		"base"                      	=> "TS_VCSC_Icon_Dual_Button",
		"icon" 	                    	=> "ts-composer-element-icon-icon-dual-button",
		"category"                  	=> __( "VC Extensions", "ts_visual_composer_extend" ),
		"description"               	=> __("Place a dual button with icon", "ts_visual_composer_extend"),
		"js_view"     					=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorLivePreview == "true" ? "TS_VCSC_IconDualButtonsViewCustom" : ""),
		"admin_enqueue_js"            	=> "",
		"admin_enqueue_css"           	=> "",
		"params"                    	=> array(
			// General Settings
			array(
				"type"              	=> "seperator",
				"param_name"        	=> "seperator_1",
				"seperator"             => "General Settings",
			),
			array(
				"type"              	=> "dropdown",
				"heading"           	=> __( "Button Align", "ts_visual_composer_extend" ),
				"param_name"        	=> "button_align",
				"width"             	=> 300,
				"value"             	=> array(
					__( 'Center', "ts_visual_composer_extend" )      	=> "ts-dual-buttons-center",
					__( 'Left', "ts_visual_composer_extend" )			=> "ts-dual-buttons-left",
					__( 'Right', "ts_visual_composer_extend" )  		=> "ts-dual-buttons-right",
				),
				"description"       	=> __( "Select how the dual buttons should be aligned.", "ts_visual_composer_extend" ),
			),
			array(
				"type"                  => "nouislider",
				"heading"               => __( "Button Width", "ts_visual_composer_extend" ),
				"param_name"            => "button_width",
				"value"                 => "100",
				"min"                   => "0",
				"max"                   => "100",
				"step"                  => "1",
				"unit"                  => '%',
				"description"       	=> __( "Define the button width in percent (responsive).", "ts_visual_composer_extend" ),
			),
			array(
				"type"					=> "dropdown",
				"class"					=> "",
				"heading"				=> __( "Button Radius", "ts_visual_composer_extend" ),
				"param_name"			=> "button_radius",
				"value"					=> array(
					__( "Large", "ts_visual_composer_extend" )			=> "ts-dual-buttons-radius-large",
					__( "Medium", "ts_visual_composer_extend" )			=> "ts-dual-buttons-radius-medium",
					__( "Small", "ts_visual_composer_extend" )			=> "ts-dual-buttons-radius-small",
					__( "None", "ts_visual_composer_extend" )			=> "ts-dual-buttons-radius-none",
				),
				"description"			=> __( "Select the border radius that should be applied to the dual buttons.", "ts_visual_composer_extend" ),
			),
			array(
				"type"              	=> "dropdown",
				"heading"           	=> __( "Button Viewport", "ts_visual_composer_extend" ),
				"param_name"        	=> "button_effects",
				"width"             	=> 300,
				"value"             	=> array(
					__( 'No Animation', "ts_visual_composer_extend" )      	=> "none",
					__( 'Overall Button', "ts_visual_composer_extend" )		=> "single",
					__( 'Button Sections', "ts_visual_composer_extend" )	=> "sections",
				),
				"description"       	=> __( "Select if and how the button or its sections can be animated upon viewport.", "ts_visual_composer_extend" ),
			),		
			array(
				"type"					=> "css3animations",
				"heading"				=> __("Viewport Animation", "ts_visual_composer_extend"),
				"param_name"			=> "button_animation",
				"prefix"				=> "ts-viewport-css-",
				"connector"				=> "button_string",
				"noneselect"			=> "true",
				"default"				=> "",
				"value"					=> "",
				"admin_label"			=> false,
				"description"			=> __("Select the viewport animation for this button.", "ts_visual_composer_extend"),
				"dependency"			=> array( 'element' => "button_effects", 'value' => 'single' ),
			),
			array(
				"type"					=> "hidden_input",
				"heading"				=> __( "Viewport Animation", "ts_visual_composer_extend" ),
				"param_name"			=> "button_string",
				"value"					=> "",
				"dependency"			=> array( 'element' => "button_effects", 'value' => 'single' ),
			),
			array(
				"type"              	=> "nouislider",
				"heading"           	=> __( "Animation Delay", "ts_visual_composer_extend" ),
				"param_name"        	=> "button_delay",
				"value"             	=> "0",
				"min"               	=> "0",
				"max"               	=> "10000",
				"step"              	=> "100",
				"unit"              	=> 'ms',
				"description"       	=> __( "Define an optional delay for the viewport animation.", "ts_visual_composer_extend" ),
				"dependency"        	=> array( 'element' => "button_animation", 'not_empty' => true ),
			),
			// Separator Settings
			array(
				"type"              	=> "seperator",
				"param_name"        	=> "seperator_2",
				"seperator"             => "Separator Settings",
			),
			array(
				"type"					=> "dropdown",
				"class"					=> "",
				"heading"				=> __( "Separator: Content", "ts_visual_composer_extend" ),
				"param_name"			=> "separator_content",
				"value"					=> array(
					__( "Text", "ts_visual_composer_extend" )				=> "text",
					__( "Icon", "ts_visual_composer_extend" )				=> "icon",
					__( "Empty", "ts_visual_composer_extend" )				=> "empty",
					__( "No Separator", "ts_visual_composer_extend" )		=> "none",
				),
				"admin_label"       	=> true,
				"description"			=> __( "Select the content for the button separator.", "ts_visual_composer_extend" ),
			),
			array(
				"type"              	=> "colorpicker",
				"heading"           	=> __( "Separator: Icon / Text Color", "ts_visual_composer_extend" ),
				"param_name"        	=> "separator_color",
				"value"             	=> "#444444",
				"description"       	=> __( "Define the color of the icon or text for the button separator.", "ts_visual_composer_extend" ),
				"edit_field_class"		=> "vc_col-sm-6 vc_column",
				"dependency"			=> array( 'element' => "separator_content", 'value' => array('icon', 'text') ),
			),
			array(
				"type"              	=> "colorpicker",
				"heading"           	=> __( "Separator: Background Color", "ts_visual_composer_extend" ),
				"param_name"        	=> "separator_background",
				"value"             	=> "#ffffff",
				"description"       	=> __( "Define the background color for the button separator.", "ts_visual_composer_extend" ),
				"edit_field_class"		=> "vc_col-sm-6 vc_column",
				"dependency"			=> array( 'element' => "separator_content", 'value' => array('icon', 'text', 'empty') ),
			),
			array(
				"type" 					=> "icons_panel",
				'heading' 				=> __( 'Separator: Icon', 'ts_visual_composer_extend' ),
				'param_name' 			=> 'separator_icon',
				'value'					=> '',
				"settings" 				=> array(
					"emptyIcon" 				=> false,
					'emptyIconValue'			=> 'transparent',
					"type" 						=> 'extensions',
				),
				"description"       	=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorVisualSelector == "true" ? __( "Select the icon you want to display in the button separator.", "ts_visual_composer_extend" ) : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorString),
				"dependency"			=> array( 'element' => "separator_content", 'value' => 'icon' ),
			),			
			array(
				"type"                  => "textfield",
				"heading"               => __( "Separator: Text", "ts_visual_composer_extend" ),
				"param_name"            => "separator_text",
				"value"                 => "or",
				"description"           => __( "Enter a SHORT text string to be used for the separator.", "ts_visual_composer_extend" ),
				"dependency"			=> array( 'element' => "separator_content", 'value' => 'text' ),
			),			
			array(
				"type"					=> "css3animations",
				"heading"				=> __("Separator: Viewport Animation", "ts_visual_composer_extend"),
				"param_name"			=> "separator_animation",
				"prefix"				=> "ts-viewport-css-",
				"connector"				=> "separator_string",
				"noneselect"			=> "true",
				"default"				=> "",
				"value"					=> "",
				"admin_label"			=> false,
				"description"			=> __("Select the viewport animation for this button.", "ts_visual_composer_extend"),
				"dependency"			=> array( 'element' => "button_effects", 'value' => 'sections' ),
			),
			array(
				"type"					=> "hidden_input",
				"heading"				=> __( "Separator: Viewport Animation", "ts_visual_composer_extend" ),
				"param_name"			=> "separator_string",
				"value"					=> "",
				"dependency"			=> array( 'element' => "button_effects", 'value' => 'sections' ),
			),
			array(
				"type"              	=> "nouislider",
				"heading"           	=> __( "Separator: Animation Delay", "ts_visual_composer_extend" ),
				"param_name"        	=> "separator_delay",
				"value"             	=> "0",
				"min"               	=> "0",
				"max"               	=> "10000",
				"step"              	=> "100",
				"unit"              	=> 'ms',
				"description"       	=> __( "Define an optional delay for the viewport animation.", "ts_visual_composer_extend" ),
				"dependency"        	=> array( 'element' => "separator_animation", 'not_empty' => true ),
			),			
			// Button #1 Settings
			array(
				"type"              	=> "seperator",
				"param_name"        	=> "seperator_3",
				"seperator"            	=> "Button #1 Settings",
				"group" 				=> "Button #1",
			),
			array(
				"type"                  => "switch_button",
				"heading"			    => __( 'Use for Page Navigation #1', "ts_visual_composer_extend" ),
				"param_name"		    => "scroll_navigate1",
				"value"                 => "false",
				"description"		    => __( "Switch the toggle if you want to use button #1 to navigate to another section on the same page.", "ts_visual_composer_extend" ),
				"group" 				=> "Button #1",
			),
			array(
				"type" 					=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_ParameterLinkPicker['enabled'] == "false" ? "vc_link" : "advancedlinks"),
				"heading" 				=> __("Link + Title #1", "ts_visual_composer_extend"),
				"param_name" 			=> "button_link1",
				"description" 			=> __("Provide a link to another site/page for Button #1.", "ts_visual_composer_extend"),
				"dependency"    		=> array( 'element' => 'scroll_navigate1', 'value' => "false" ),
				"group" 				=> "Button #1",
			),
			array(
				"type"                  => "textfield",
				"heading"               => __( "Page Scroll Target #1", "ts_visual_composer_extend" ),
				"param_name"            => "scroll_target1",
				"value"                 => "",
				"description"           => __( "Enter the unique ID for the page section you want to scroll to.", "ts_visual_composer_extend" ),
				"dependency"            => array( 'element' => "scroll_navigate1", 'value' => 'true' ),
				"group" 				=> "Button #1",
			),
			array(
				"type" 					=> "devicetype_selectors",
				"heading"           	=> __( "Device Type Scroll Offset #1", "ts_visual_composer_extend" ),
				"param_name"        	=> "scroll_offset1",
				"unit"  				=> "px",
				"collapsed"				=> "true",
				"devices" 				=> array(
					"Desktop"           		=> array("default" => 0, "min" => 0, "max" => 250, "step" => 1),
					"Tablet"            		=> array("default" => 0, "min" => 0, "max" => 250, "step" => 1),
					"Mobile"            		=> array("default" => 0, "min" => 0, "max" => 250, "step" => 1),
				),
				"value"					=> "desktop:0px;tablet:0px;mobile:0px",
				"description"			=> __( "Define an additional scroll offset to account for menu bars and other top fixed elements.", "ts_visual_composer_extend" ),
				"dependency"            => array( 'element' => "scroll_navigate1", 'value' => 'true' ),
				"group" 				=> "Button #1",
			),
			array(
				"type"					=> "nouislider",
				"heading"				=> __( "Page Scroll Speed #1", "ts_visual_composer_extend" ),
				"param_name"			=> "scroll_speed1",
				"value"					=> "2000",
				"min"					=> "500",
				"max"					=> "10000",
				"step"					=> "100",
				"unit"					=> 'ms',
				"description"			=> __( "Define the speed that should be used to scroll to the section.", "ts_visual_composer_extend" ),
				"dependency"            => array( 'element' => "scroll_navigate1", 'value' => 'true' ),
				"group" 				=> "Button #1",
			),							
			array(
				"type"                 	=> "dropdown",
				"heading"               => __( "Page Scroll Easing #1", "ts_visual_composer_extend" ),
				"param_name"            => "scroll_effect1",
				"edit_field_class"		=> "vc_col-sm-6 vc_column",
				"width"                 => 150,
				"value" 				=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CSS_Easings_Array,
				"description"           => __( "Select the easing animation that should be applied to the page scroll.", "ts_visual_composer_extend" ),
				"dependency"            => array( 'element' => "scroll_navigate1", 'value' => 'true' ),
				"group" 				=> "Button #1",
			),
			array(
				"type"                  => "switch_button",
				"heading"			    => __( 'Add Target as Hashtag #1', "ts_visual_composer_extend" ),
				"param_name"		    => "scroll_hashtag1",
				"edit_field_class"		=> "vc_col-sm-6 vc_column",
				"value"                 => "false",
				"description"		    => __( "Switch the toggle if you want to add the scroll target to the browser URL via hashtag.", "ts_visual_composer_extend" ),
				"dependency"            => array( 'element' => "scroll_navigate1", 'value' => 'true' ),
				"group" 				=> "Button #1",
			),
			array(
				"type"              	=> "textfield",
				"heading"           	=> __( "Button #1: Text", "ts_visual_composer_extend" ),
				"param_name"        	=> "button_text1",
				"value"             	=> "Read More 1",
				"description"       	=> __( "Enter a text for button #1.", "ts_visual_composer_extend" ),
				"group" 				=> "Button #1",
			),
			array(
				"type"              	=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorBase64TinyMCE == "true" ? "wysiwyg_base64" : "textarea_raw_html"),
				"heading"           	=> __( "Button #1: Tooltip Content", "ts_visual_composer_extend" ),
				"param_name"        	=> "tooltip_content1",
				"minimal"				=> "true",
				"value"             	=> base64_encode(""),
				"description"      	 	=> __( "Enter the tooltip content for button #1 here; HTML code can be used.", "ts_visual_composer_extend" ),
				"group" 				=> "Button #1",
			),
			array(
				"type"                  => "dropdown",
				"heading"               => __( "Button #1: General Style", "ts_visual_composer_extend" ),
				"param_name"            => "button_style1",
				"width"                 => 300,
				"value"                 => array_merge($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Flat_Button_Default_Colors, $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Flat_Button_Default_Custom),
				"admin_label"           => true,
				"description"           => __( "Select the general color style for button #1.", "ts_visual_composer_extend" ),
				"group" 				=> "Button #1",
			),
			array(
				"type"                  => "dropdown",
				"heading"               => __( "Button #1: Hover Style", "ts_visual_composer_extend" ),
				"param_name"            => "button_hover1",
				"width"                 => 300,
				"value"                 => array_merge($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Flat_Button_Hover_Colors, $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Flat_Button_Hover_Custom),
				"description"           => __( "Select the general hover style for button #1.", "ts_visual_composer_extend" ),
				"group" 				=> "Button #1",
			),
			array(
				"type"              	=> "colorpicker",
				"heading"           	=> __( "Button #1: General Background Color", "ts_visual_composer_extend" ),
				"param_name"        	=> "custom1_dual_color1",
				"value"             	=> "#f9f9f9",
				"description"       	=> __( "Define the general background color for the button.", "ts_visual_composer_extend" ),
				"dependency"			=> array( 'element' => "button_style1", 'value' => 'ts-dual-buttons-color-custom-flat' ),
				"edit_field_class"		=> "vc_col-sm-6 vc_column",
				"group" 				=> "Button #1",
			),
			array(
				"type"              	=> "colorpicker",
				"heading"           	=> __( "Button #1: General Shadow Color", "ts_visual_composer_extend" ),
				"param_name"        	=> "custom1_dual_shadow1",
				"value"             	=> "#dadedf",
				"description"       	=> __( "Define the general background color for the button.", "ts_visual_composer_extend" ),
				"dependency"			=> array( 'element' => "button_style1", 'value' => 'ts-dual-buttons-color-custom-flat' ),
				"edit_field_class"		=> "vc_col-sm-6 vc_column",
				"group" 				=> "Button #1",
			),
			array(
				"type"              	=> "colorpicker",
				"heading"           	=> __( "Button #1: General Text Color", "ts_visual_composer_extend" ),
				"param_name"        	=> "custom1_dual_text1",
				"value"             	=> "#454545",
				"description"       	=> __( "Define the color of the text for the button.", "ts_visual_composer_extend" ),
				"dependency"			=> array( 'element' => "button_style1", 'value' => 'ts-dual-buttons-color-custom-flat' ),
				"edit_field_class"		=> "vc_col-sm-6 vc_column",
				"group" 				=> "Button #1",
			),
			array(
				"type"              	=> "colorpicker",
				"heading"           	=> __( "Button #1: Hover Background Color", "ts_visual_composer_extend" ),
				"param_name"        	=> "custom1_dual_color2",
				"value"             	=> "#f9f9f9",
				"description"       	=> __( "Define the hover background color for the button.", "ts_visual_composer_extend" ),
				"dependency"			=> array( 'element' => "button_hover1", 'value' => 'ts-dual-buttons-preview-custom-flat ts-dual-buttons-hover-custom-flat' ),
				"edit_field_class"		=> "vc_col-sm-6 vc_column",
				"group" 				=> "Button #1",
			),
			array(
				"type"              	=> "colorpicker",
				"heading"           	=> __( "Button #1: Hover Shadow Color", "ts_visual_composer_extend" ),
				"param_name"        	=> "custom1_dual_shadow2",
				"value"             	=> "#dadedf",
				"description"       	=> __( "Define the hover shadow color for the button.", "ts_visual_composer_extend" ),
				"dependency"			=> array( 'element' => "button_hover1", 'value' => 'ts-dual-buttons-preview-custom-flat ts-dual-buttons-hover-custom-flat' ),
				"edit_field_class"		=> "vc_col-sm-6 vc_column",
				"group" 				=> "Button #1",
			),
			array(
				"type"              	=> "colorpicker",
				"heading"           	=> __( "Button #1: Hover Text Color", "ts_visual_composer_extend" ),
				"param_name"        	=> "custom1_dual_text2",
				"value"             	=> "#454545",
				"description"       	=> __( "Define the color of the text for the button.", "ts_visual_composer_extend" ),
				"dependency"			=> array( 'element' => "button_hover1", 'value' => 'ts-dual-buttons-preview-custom-flat ts-dual-buttons-hover-custom-flat' ),
				"edit_field_class"		=> "vc_col-sm-6 vc_column",
				"group" 				=> "Button #1",
			),
			array(
				"type"					=> "css3animations",
				"heading"				=> __("Button #1: Viewport Animation", "ts_visual_composer_extend"),
				"param_name"			=> "animation_button1",
				"prefix"				=> "ts-viewport-css-",
				"connector"				=> "animation_string1",
				"noneselect"			=> "true",
				"default"				=> "",
				"value"					=> "",
				"admin_label"			=> false,
				"description"			=> __("Select the viewport animation for this button.", "ts_visual_composer_extend"),
				"dependency"			=> array( 'element' => "button_effects", 'value' => 'sections' ),
				"group" 				=> "Button #1",
			),
			array(
				"type"					=> "hidden_input",
				"heading"				=> __( "Button #1: Viewport Animation", "ts_visual_composer_extend" ),
				"param_name"			=> "animation_string1",
				"value"					=> "",
				"dependency"			=> array( 'element' => "button_effects", 'value' => 'sections' ),
				"group" 				=> "Button #1",
			),
			array(
				"type"              	=> "nouislider",
				"heading"           	=> __( "Button #1: Animation Delay", "ts_visual_composer_extend" ),
				"param_name"        	=> "animation_delay1",
				"value"             	=> "0",
				"min"               	=> "0",
				"max"               	=> "10000",
				"step"              	=> "100",
				"unit"              	=> 'ms',
				"description"       	=> __( "Define an optional delay for the viewport animation.", "ts_visual_composer_extend" ),
				"dependency"        	=> array( 'element' => "animation_button1", 'not_empty' => true ),
				"group" 				=> "Button #1",
			),
			// Button #2 Settings
			array(
				"type"              	=> "seperator",
				"param_name"        	=> "seperator_4",
				"seperator"            	=> "Button #2 Settings",
				"group" 				=> "Button #2",
			),
			array(
				"type"                  => "switch_button",
				"heading"			    => __( 'Use for Page Navigation #2', "ts_visual_composer_extend" ),
				"param_name"		    => "scroll_navigate2",
				"value"                 => "false",
				"description"		    => __( "Switch the toggle if you want to use button #2 to navigate to another section on the same page.", "ts_visual_composer_extend" ),
				"group" 				=> "Button #2",
			),
			array(
				"type" 					=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_ParameterLinkPicker['enabled'] == "false" ? "vc_link" : "advancedlinks"),
				"heading" 				=> __("Link + Title #2", "ts_visual_composer_extend"),
				"param_name" 			=> "button_link2",
				"description" 			=> __("Provide a link to another site/page for Button #2.", "ts_visual_composer_extend"),
				"dependency"    		=> array( 'element' => 'scroll_navigate2', 'value' => "false" ),
				"group" 				=> "Button #2",
			),
			array(
				"type"                  => "textfield",
				"heading"               => __( "Page Scroll Target #2", "ts_visual_composer_extend" ),
				"param_name"            => "scroll_target2",
				"value"                 => "",
				"description"           => __( "Enter the unique ID for the page section you want to scroll to.", "ts_visual_composer_extend" ),
				"dependency"            => array( 'element' => "scroll_navigate2", 'value' => 'true' ),
				"group" 				=> "Button #2",
			),
			array(
				"type" 					=> "devicetype_selectors",
				"heading"           	=> __( "Device Type Scroll Offset #2", "ts_visual_composer_extend" ),
				"param_name"        	=> "scroll_offset2",
				"unit"  				=> "px",
				"collapsed"				=> "true",
				"devices" 				=> array(
					"Desktop"           		=> array("default" => 0, "min" => 0, "max" => 250, "step" => 1),
					"Tablet"            		=> array("default" => 0, "min" => 0, "max" => 250, "step" => 1),
					"Mobile"            		=> array("default" => 0, "min" => 0, "max" => 250, "step" => 1),
				),
				"value"					=> "desktop:0px;tablet:0px;mobile:0px",
				"description"			=> __( "Define an additional scroll offset to account for menu bars and other top fixed elements.", "ts_visual_composer_extend" ),
				"dependency"            => array( 'element' => "scroll_navigate2", 'value' => 'true' ),
				"group" 				=> "Button #2",
			),
			array(
				"type"					=> "nouislider",
				"heading"				=> __( "Page Scroll Speed #2", "ts_visual_composer_extend" ),
				"param_name"			=> "scroll_speed2",
				"value"					=> "2000",
				"min"					=> "500",
				"max"					=> "10000",
				"step"					=> "100",
				"unit"					=> 'ms',
				"description"			=> __( "Define the speed that should be used to scroll to the section.", "ts_visual_composer_extend" ),
				"dependency"            => array( 'element' => "scroll_navigate2", 'value' => 'true' ),
				"group" 				=> "Button #2",
			),							
			array(
				"type"                 	=> "dropdown",
				"heading"               => __( "Page Scroll Easing #2", "ts_visual_composer_extend" ),
				"param_name"            => "scroll_effect2",
				"edit_field_class"		=> "vc_col-sm-6 vc_column",
				"width"                 => 150,
				"value" 				=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CSS_Easings_Array,
				"description"           => __( "Select the easing animation that should be applied to the page scroll.", "ts_visual_composer_extend" ),
				"dependency"            => array( 'element' => "scroll_navigate2", 'value' => 'true' ),
				"group" 				=> "Button #2",
			),
			array(
				"type"                  => "switch_button",
				"heading"			    => __( 'Add Target as Hashtag #2', "ts_visual_composer_extend" ),
				"param_name"		    => "scroll_hashtag2",
				"edit_field_class"		=> "vc_col-sm-6 vc_column",
				"value"                 => "false",
				"description"		    => __( "Switch the toggle if you want to add the scroll target to the browser URL via hashtag.", "ts_visual_composer_extend" ),
				"dependency"            => array( 'element' => "scroll_navigate2", 'value' => 'true' ),
				"group" 				=> "Button #2",
			),
			array(
				"type"              	=> "textfield",
				"heading"           	=> __( "Button #2: Text", "ts_visual_composer_extend" ),
				"param_name"        	=> "button_text2",
				"value"             	=> "Read More 2",
				"description"       	=> __( "Enter a text for button #2.", "ts_visual_composer_extend" ),
				"group" 				=> "Button #2",
			),
			array(
				"type"              	=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorBase64TinyMCE == "true" ? "wysiwyg_base64" : "textarea_raw_html"),
				"heading"           	=> __( "Button #2: Tooltip Content", "ts_visual_composer_extend" ),
				"param_name"        	=> "tooltip_content2",
				"minimal"				=> "true",
				"value"             	=> base64_encode(""),
				"description"      	 	=> __( "Enter the tooltip content for button #1  here; HTML code can be used.", "ts_visual_composer_extend" ),
				"group" 				=> "Button #2",
			),
			array(
				"type"                  => "dropdown",
				"heading"               => __( "Button #2: General Style", "ts_visual_composer_extend" ),
				"param_name"            => "button_style2",
				"width"                 => 300,
				"value"                 => array_merge($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Flat_Button_Default_Colors, $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Flat_Button_Default_Custom),
				"admin_label"           => true,
				"description"           => __( "Select the general color style for button #2.", "ts_visual_composer_extend" ),
				"group" 				=> "Button #2",
			),
			array(
				"type"                  => "dropdown",
				"heading"               => __( "Button #2: Hover Style", "ts_visual_composer_extend" ),
				"param_name"            => "button_hover2",
				"width"                 => 300,
				"value"                 => array_merge($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Flat_Button_Hover_Colors, $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Flat_Button_Hover_Custom),
				"description"           => __( "Select the general hover style for button #2.", "ts_visual_composer_extend" ),
				"group" 				=> "Button #2",
			),
			array(
				"type"              	=> "colorpicker",
				"heading"           	=> __( "Button #2: General Background Color", "ts_visual_composer_extend" ),
				"param_name"        	=> "custom2_dual_color1",
				"value"             	=> "#f9f9f9",
				"description"       	=> __( "Define the general background color for the button.", "ts_visual_composer_extend" ),
				"dependency"			=> array( 'element' => "button_style2", 'value' => 'ts-dual-buttons-color-custom-flat' ),
				"edit_field_class"		=> "vc_col-sm-6 vc_column",
				"group" 				=> "Button #2",
			),
			array(
				"type"              	=> "colorpicker",
				"heading"           	=> __( "Button #2: General Shadow Color", "ts_visual_composer_extend" ),
				"param_name"        	=> "custom2_dual_shadow1",
				"value"             	=> "#dadedf",
				"description"       	=> __( "Define the general background color for the button.", "ts_visual_composer_extend" ),
				"dependency"			=> array( 'element' => "button_style2", 'value' => 'ts-dual-buttons-color-custom-flat' ),
				"edit_field_class"		=> "vc_col-sm-6 vc_column",
				"group" 				=> "Button #2",
			),
			array(
				"type"              	=> "colorpicker",
				"heading"           	=> __( "Button #2: General Text Color", "ts_visual_composer_extend" ),
				"param_name"        	=> "custom2_dual_text1",
				"value"             	=> "#454545",
				"description"       	=> __( "Define the color of the text for the button.", "ts_visual_composer_extend" ),
				"dependency"			=> array( 'element' => "button_style2", 'value' => 'ts-dual-buttons-color-custom-flat' ),
				"edit_field_class"		=> "vc_col-sm-6 vc_column",
				"group" 				=> "Button #2",
			),
			array(
				"type"              	=> "colorpicker",
				"heading"           	=> __( "Button #2: Hover Background Color", "ts_visual_composer_extend" ),
				"param_name"        	=> "custom2_dual_color2",
				"value"             	=> "#f9f9f9",
				"description"       	=> __( "Define the hover background color for the button.", "ts_visual_composer_extend" ),
				"dependency"			=> array( 'element' => "button_hover2", 'value' => 'ts-dual-buttons-preview-custom-flat ts-dual-buttons-hover-custom-flat' ),
				"edit_field_class"		=> "vc_col-sm-6 vc_column",
				"group" 				=> "Button #2",
			),
			array(
				"type"              	=> "colorpicker",
				"heading"           	=> __( "Button #2: Hover Shadow Color", "ts_visual_composer_extend" ),
				"param_name"        	=> "custom2_dual_shadow2",
				"value"             	=> "#dadedf",
				"description"       	=> __( "Define the hover shadow color for the button.", "ts_visual_composer_extend" ),
				"dependency"			=> array( 'element' => "button_hover2", 'value' => 'ts-dual-buttons-preview-custom-flat ts-dual-buttons-hover-custom-flat' ),
				"edit_field_class"		=> "vc_col-sm-6 vc_column",
				"group" 				=> "Button #2",
			),
			array(
				"type"              	=> "colorpicker",
				"heading"           	=> __( "Button #2: Hover Text Color", "ts_visual_composer_extend" ),
				"param_name"        	=> "custom2_dual_text2",
				"value"             	=> "#454545",
				"description"       	=> __( "Define the color of the text for the button.", "ts_visual_composer_extend" ),
				"dependency"			=> array( 'element' => "button_hover2", 'value' => 'ts-dual-buttons-preview-custom-flat ts-dual-buttons-hover-custom-flat' ),
				"edit_field_class"		=> "vc_col-sm-6 vc_column",
				"group" 				=> "Button #2",
			),
			array(
				"type"					=> "css3animations",
				"heading"				=> __("Button #2: Viewport Animation", "ts_visual_composer_extend"),
				"param_name"			=> "animation_button2",
				"prefix"				=> "ts-viewport-css-",
				"connector"				=> "animation_string2",
				"noneselect"			=> "true",
				"default"				=> "",
				"value"					=> "",
				"admin_label"			=> false,
				"description"			=> __("Select the viewport animation for this button.", "ts_visual_composer_extend"),
				"dependency"			=> array( 'element' => "button_effects", 'value' => 'sections' ),
				"group" 				=> "Button #2",
			),
			array(
				"type"					=> "hidden_input",
				"heading"				=> __( "Button #2: Viewport Animation", "ts_visual_composer_extend" ),
				"param_name"			=> "animation_string2",
				"value"					=> "",
				"dependency"			=> array( 'element' => "button_effects", 'value' => 'sections' ),
				"group" 				=> "Button #2",
			),
			array(
				"type"              	=> "nouislider",
				"heading"           	=> __( "Button #2: Animation Delay", "ts_visual_composer_extend" ),
				"param_name"        	=> "animation_delay2",
				"value"             	=> "0",
				"min"               	=> "0",
				"max"               	=> "10000",
				"step"              	=> "100",
				"unit"              	=> 'ms',
				"description"       	=> __( "Define an optional delay for the viewport animation.", "ts_visual_composer_extend" ),
				"dependency"        	=> array( 'element' => "animation_button2", 'not_empty' => true ),
				"group" 				=> "Button #2",
			),
			// Tooltip Settings
			array(
				"type"              	=> "seperator",
				"param_name"        	=> "seperator_5",
				"seperator"            	=> "Tooltip Settings",
				"group" 				=> "Tooltip Settings",
			),
			array(
				"type"					=> "dropdown",
				"heading"				=> __( "Tooltip Position", "ts_visual_composer_extend" ),
				"param_name"			=> "tooltip_position",
				"value"					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_ToolTipster_Vertical,
				"description"			=> __( "Select the tooltip position in relation to the image.", "ts_visual_composer_extend" ),
				"group" 				=> "Tooltip Settings",
			),
			array(
				"type"					=> "dropdown",
				"heading"				=> __( "Tooltip Style", "ts_visual_composer_extend" ),
				"param_name"			=> "tooltip_style",
				"value"             	=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_ToolTipster_Layouts,
				"description"			=> __( "Select the tooltip style.", "ts_visual_composer_extend" ),
				"group" 				=> "Tooltip Settings",
			),
			array(
				"type"				    => "dropdown",
				"heading"			    => __( "Tooltip Animation", "ts_visual_composer_extend" ),
				"param_name"		    => "tooltip_animation",
				"value"                 => $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_ToolTipster_Animations,
				"description"		    => __( "Select how the tooltip entry and exit should be animated once triggered.", "ts_visual_composer_extend" ),
				"group"					=> "Tooltip Settings",
			),
			array(
				"type"					=> "nouislider",
				"heading"				=> __( "Tooltip X-Offset", "ts_visual_composer_extend" ),
				"param_name"			=> "tooltipster_offsetx",
				"value"					=> "0",
				"min"					=> "-100",
				"max"					=> "100",
				"step"					=> "1",
				"unit"					=> 'px',
				"description"			=> __( "Define an optional X-Offset for the tooltip position.", "ts_visual_composer_extend" ),
				"group" 				=> "Tooltip Settings",
			),
			array(
				"type"					=> "nouislider",
				"heading"				=> __( "Tooltip Y-Offset", "ts_visual_composer_extend" ),
				"param_name"			=> "tooltipster_offsety",
				"value"					=> "0",
				"min"					=> "-100",
				"max"					=> "100",
				"step"					=> "1",
				"unit"					=> 'px',
				"description"			=> __( "Define an optional Y-Offset for the tooltip position.", "ts_visual_composer_extend" ),
				"group" 				=> "Tooltip Settings",
			),
			// Other Settings
			array(
				"type"				    => "seperator",
				"param_name"		    => "seperator_6",
				"seperator"				=> "Other Settings",
				"group" 				=> "Other Settings",
			),
			array(
				"type"                  => "nouislider",
				"heading"               => __( "Margin: Top", "ts_visual_composer_extend" ),
				"param_name"            => "margin_top",
				"value"                 => "20",
				"min"                   => "0",
				"max"                   => "200",
				"step"                  => "1",
				"unit"                  => 'px',
				"description"           => __( "Select the top margin for the element.", "ts_visual_composer_extend" ),
				"group" 				=> "Other Settings",
			),
			array(
				"type"                  => "nouislider",
				"heading"               => __( "Margin: Bottom", "ts_visual_composer_extend" ),
				"param_name"            => "margin_bottom",
				"value"                 => "20",
				"min"                   => "0",
				"max"                   => "200",
				"step"                  => "1",
				"unit"                  => 'px',
				"description"           => __( "Select the bottom margin for the element.", "ts_visual_composer_extend" ),
				"group" 				=> "Other Settings",
			),
			array(
				"type"                  => "textfield",
				"heading"               => __( "Define ID Name", "ts_visual_composer_extend" ),
				"param_name"            => "el_id",
				"value"                 => "",
				"description"           => __( "Enter an unique ID for the element.", "ts_visual_composer_extend" ),
				"group" 				=> "Other Settings",
			),
			array(
				"type"                  => "tag_editor",
				"heading"           	=> __( "Extra Class Names", "ts_visual_composer_extend" ),
				"param_name"            => "el_class",
				"value"                 => "",
				"description"      		=> __( "Enter additional class names for the element.", "ts_visual_composer_extend" ),
				"group" 				=> "Other Settings",
			),
		)
	);		
	if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_LeanMap == "true") {
		return $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element;
	} else {			
		vc_map($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element);
	};
?>