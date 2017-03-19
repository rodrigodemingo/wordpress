<?php
    global $VISUAL_COMPOSER_EXTENSIONS;
	
    $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element = array(
		"name"                      	=> __( "TS Icon Flex Button", "ts_visual_composer_extend" ),
		"base"                      	=> "TS_VCSC_Icon_Flex_Button",
		"icon" 	                    	=> "ts-composer-element-icon-icon-flex-button",
		"category"                  	=> __( "VC Extensions", "ts_visual_composer_extend" ),
		"description"               	=> __("Place a flex icon button element", "ts_visual_composer_extend"),
		//"js_view"     				=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorLivePreview == "true" ? "TS_VCSC_IconFlexButtonViewCustom" : ""),
		"admin_enqueue_js"            	=> "",
		"admin_enqueue_css"           	=> "",
		"params"                    	=> array(
			// Link Settings
			array(
				"type"              	=> "seperator",
				"param_name"        	=> "seperator_1",
				"seperator"				=> "Link + Title Settings",
			),
			array(
				"type"                  => "switch_button",
				"heading"			    => __( 'Use for Page Navigation', "ts_visual_composer_extend" ),
				"param_name"		    => "scroll_navigate",
				"value"                 => "false",
				"admin_label"       	=> true,
				"description"		    => __( "Switch the toggle if you want to use this button to navigate to another section on the same page.", "ts_visual_composer_extend" ),
			),
			array(
				"type" 					=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_ParameterLinkPicker['enabled'] == "false" ? "vc_link" : "advancedlinks"),
				"heading" 				=> __("Link + Title", "ts_visual_composer_extend"),
				"param_name" 			=> "button_link",
				"description" 			=> __("Provide a link to another site/page for the Icon Button.", "ts_visual_composer_extend"),
				"dependency"    		=> array( 'element' => 'scroll_navigate', 'value' => "false" ),
			),
			array(
				"type"                  => "textfield",
				"heading"               => __( "Page Scroll Target", "ts_visual_composer_extend" ),
				"param_name"            => "scroll_target",
				"value"                 => "",
				"description"           => __( "Enter the unique ID for the page section you want to scroll to.", "ts_visual_composer_extend" ),
				"dependency"            => array( 'element' => "scroll_navigate", 'value' => 'true' ),
			),
			array(
				"type" 					=> "devicetype_selectors",
				"heading"           	=> __( "Device Type Scroll Offset", "ts_visual_composer_extend" ),
				"param_name"        	=> "scroll_offset",
				"unit"  				=> "px",
				"collapsed"				=> "true",
				"devices" 				=> array(
					"Desktop"           		=> array("default" => 0, "min" => 0, "max" => 250, "step" => 1),
					"Tablet"            		=> array("default" => 0, "min" => 0, "max" => 250, "step" => 1),
					"Mobile"            		=> array("default" => 0, "min" => 0, "max" => 250, "step" => 1),
				),
				"value"					=> "desktop:0px;tablet:0px;mobile:0px",
				"description"			=> __( "Define an additional scroll offset to account for menu bars and other top fixed elements.", "ts_visual_composer_extend" ),
				"dependency"            => array( 'element' => "scroll_navigate", 'value' => 'true' ),
			),
			array(
				"type"					=> "nouislider",
				"heading"				=> __( "Page Scroll Speed", "ts_visual_composer_extend" ),
				"param_name"			=> "scroll_speed",
				"value"					=> "2000",
				"min"					=> "500",
				"max"					=> "10000",
				"step"					=> "100",
				"unit"					=> 'ms',
				"description"			=> __( "Define the speed that should be used to scroll to the section.", "ts_visual_composer_extend" ),
				"dependency"            => array( 'element' => "scroll_navigate", 'value' => 'true' ),
			),							
			array(
				"type"                 	=> "dropdown",
				"heading"               => __( "Page Scroll Easing", "ts_visual_composer_extend" ),
				"param_name"            => "scroll_effect",
				"edit_field_class"		=> "vc_col-sm-6 vc_column",
				"width"                 => 150,
				"value" 				=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CSS_Easings_Array,
				"description"           => __( "Select the easing animation that should be applied to the page scroll.", "ts_visual_composer_extend" ),
				"dependency"            => array( 'element' => "scroll_navigate", 'value' => 'true' ),
			),
			array(
				"type"                  => "switch_button",
				"heading"			    => __( 'Add Target as Hashtag', "ts_visual_composer_extend" ),
				"param_name"		    => "scroll_hashtag",
				"edit_field_class"		=> "vc_col-sm-6 vc_column",
				"value"                 => "false",
				"description"		    => __( "Switch the toggle if you want to add the scroll target to the browser URL via hashtag.", "ts_visual_composer_extend" ),
				"dependency"            => array( 'element' => "scroll_navigate", 'value' => 'true' ),
			),
			// Button Text
			array(
				"type"              	=> "seperator",
				"param_name"        	=> "seperator_2",
				"seperator"				=> "Button Text",
			),
			array(
				"type"                  => "textfield",
				"heading"               => __( "Button: Text String", "ts_visual_composer_extend" ),
				"param_name"            => "button_text",
				"value"                 => "Read More",
				"admin_label"       	=> true,
				"description"           => __( "Enter the text string that should be used for the button.", "ts_visual_composer_extend" ),
			),
			array(
				"type"          		=> 'dropdown',
				"heading"       		=> __( 'Button: Text Alignment', "ts_visual_composer_extend" ),
				"param_name"    		=> 'button_align',
				"value"         		=> array(
					__( 'Center', "ts_visual_composer_extend" )   				=> 'center', 
					__( 'Left', "ts_visual_composer_extend" )  					=> 'left', 
					__( 'Right', "ts_visual_composer_extend" )   				=> 'right', 
				),
				"std"					=> "center",
				"default"				=> "center",
				"description"   		=> __( "Select the alignment for the button text.", "ts_visual_composer_extend" ),
			),
			array(
				"type"          		=> 'dropdown',
				"heading"       		=> __( 'Button: Text Size', "ts_visual_composer_extend" ),
				"param_name"    		=> 'button_size',
				"value"         		=> array(
					__( 'Small', "ts_visual_composer_extend" )   				=> 'small', 
					__( 'Medium', "ts_visual_composer_extend" )  				=> 'medium', 
					__( 'Large', "ts_visual_composer_extend" )   				=> 'large', 
					__( 'X-Large', "ts_visual_composer_extend" ) 				=> 'xlarge',
				),
				"std"					=> "medium",
				"default"				=> "medium",
				"description"   		=> __( "Select the size for the button content (icon and text).", "ts_visual_composer_extend" ),
			),
			array(
				"type"                  => "switch_button",
				"heading"			    => __( 'Use Advanced Tooltip', "ts_visual_composer_extend" ),
				"param_name"		    => "button_tooltip",
				"value"                 => "false",
				"description"		    => __( "Switch the toggle if you want to add an advanced tooltip to the element.", "ts_visual_composer_extend" ),
			),
			// Global Styling
			array(
				"type"              	=> "seperator",
				"param_name"        	=> "seperator_3",
				"seperator"				=> "Global Styling",
				"group"					=> "Button Styling",
			),
			array(
				'type'        			=> "switch_button",
				'heading'     			=> __('Use Basic Border Style',"ts_visual_composer_extend"),
				'param_name'  			=> 'button_border',
				'value'       			=> 'false',
				"description"       	=> "Switch the toggle if you want to use the alternative basic border layout for the button instead.",
				"group"					=> "Button Styling",
			),
			array(
				"type"					=> "fontsmanager",
				"heading"				=> __( "Font Family", "ts_visual_composer_extend" ),
				"param_name"			=> "button_fontfamily",
				"value"					=> "",
				"default"				=> "true",
				"connector"				=> "button_fonttype",
				"description"			=> __( "Select the font to be used for the button text.", "ts_visual_composer_extend" ),
				"group"					=> "Button Styling",
			),
			array(
				"type"					=> "hidden_input",
				"param_name"			=> "button_fonttype",
				"value"					=> "",
				"group"					=> "Button Styling",
			),	
			array(
				'type'        			=> "switch_button",
				'heading'     			=> __('Darker Top Border',"ts_visual_composer_extend"),
				'param_name'  			=> 'button_bartop',
				'value'       			=> 'false',
				"description"       	=> "Switch the toggle if you want to show a darker top border for the button.",
				'dependency'    		=> array( 'element' => 'button_border', 'value' => "false" ),
				"edit_field_class"		=> "vc_col-sm-6 vc_column",
				"group"					=> "Button Styling",
			),
			array(
				'type'        			=> "switch_button",
				'heading'     			=> __('Darker Bottom Border',"ts_visual_composer_extend"),
				'param_name'  			=> 'button_barbottom',
				'value'       			=> 'false',
				"description"       	=> "Switch the toggle if you want to show a darker bottom border for the button.",
				'dependency'    		=> array( 'element' => 'button_border', 'value' => "false" ),
				"edit_field_class"		=> "vc_col-sm-6 vc_column",
				"group"					=> "Button Styling",
			),			
			array(
				'type'        			=> "switch_button",
				'heading'     			=> __('Darker Left Border',"ts_visual_composer_extend"),
				'param_name'  			=> 'button_barleft',
				'value'       			=> 'false',
				"description"       	=> "Switch the toggle if you want to show a darker left border for the button.",
				'dependency'    		=> array( 'element' => 'button_border', 'value' => "false" ),
				"edit_field_class"		=> "vc_col-sm-6 vc_column",
				"group"					=> "Button Styling",
			),
			array(
				'type'        			=> "switch_button",
				'heading'     			=> __('Darker Right Border',"ts_visual_composer_extend"),
				'param_name'  			=> 'button_barright',
				'value'       			=> 'false',
				"description"       	=> "Switch the toggle if you want to show a darker right border for the button.",
				'dependency'    		=> array( 'element' => 'button_border', 'value' => "false" ),
				"edit_field_class"		=> "vc_col-sm-6 vc_column",
				"group"					=> "Button Styling",
			),			
			array(
				'type'          		=> 'dropdown',
				'heading'       		=> __( 'Button: Theme', "ts_visual_composer_extend" ),
				'param_name'    		=> 'button_theme',
				'value'         		=> array(
					__( 'Light Blue', "ts_visual_composer_extend" )					=> 'lightblue',
					__( 'Dark Blue', "ts_visual_composer_extend" )					=> 'darkblue',					
					__( 'Green', "ts_visual_composer_extend" )						=> 'green',
					__( 'Orange', "ts_visual_composer_extend" )						=> 'orange',
					__( 'Yellow', "ts_visual_composer_extend" )						=> 'yellow',
					__( 'White', "ts_visual_composer_extend" )						=> 'white',
					__( 'Custom', "ts_visual_composer_extend" )						=> 'custom'
				),
				"description"   		=> __( "Select the theme you want to use for the button background.", "ts_visual_composer_extend" ),
				"group"					=> "Button Styling",
			),
			array(
				"type"          		=> 'dropdown',
				"heading"       		=> __( 'Button: Slant', "ts_visual_composer_extend" ),
				"param_name"    		=> 'button_slanted',
				"value"         		=> array(
					__( 'None', "ts_visual_composer_extend" )   					=> 'none',
					__( 'Left Slant (Large)', "ts_visual_composer_extend" )			=> 'leftboth-large',
					__( 'Left Slant (Medium)', "ts_visual_composer_extend" )		=> 'leftboth-medium',
					__( 'Left Slant (Small)', "ts_visual_composer_extend" )			=> 'leftboth-small',
					__( 'Right Slant (Large)', "ts_visual_composer_extend" )		=> 'rightboth-large',
					__( 'Right Slant (Medium)', "ts_visual_composer_extend" )		=> 'rightboth-medium',
					__( 'Right Slant (Small)', "ts_visual_composer_extend" )		=> 'rightboth-small',
				),
				"std"					=> "none",
				"default"				=> "none",
				"admin_label"       	=> true,
				"description"   		=> __( "Select an optional slant for the button.", "ts_visual_composer_extend" ),
				"group"					=> "Button Styling",
			),	
			array(
				"type"          		=> 'dropdown',
				"heading"       		=> __( 'Button: Radius', "ts_visual_composer_extend" ),
				"param_name"    		=> 'button_radius',
				"value"         		=> array(
					__( 'None', "ts_visual_composer_extend" )   				=> 'none',
					__( 'Small', "ts_visual_composer_extend" )   				=> 'small', 
					__( 'Medium', "ts_visual_composer_extend" )  				=> 'medium', 
					__( 'Large', "ts_visual_composer_extend" )   				=> 'large', 
					__( 'X-Large', "ts_visual_composer_extend" ) 				=> 'xlarge',
				),
				"std"					=> "none",
				"default"				=> "none",
				"admin_label"       	=> true,
				"description"   		=> __( "Select the size for the optional button border radius.", "ts_visual_composer_extend" ),
				"group"					=> "Button Styling",
			),	
			array(
				"type"                  => "nouislider",
				"heading"               => __( "Button: Width", "ts_visual_composer_extend" ),
				"param_name"            => "button_width",
				"value"                 => "100",
				"min"                   => "50",
				"max"                   => "100",
				"step"                  => "1",
				"unit"                  => '%',
				"description"           => __( "Define the width of the button in relation to the column it is embedded in.", "ts_visual_composer_extend" ),
				"group"					=> "Button Styling",
			),
			array(
				"type"          		=> 'dropdown',
				"heading"       		=> __( 'Button: Alignment', "ts_visual_composer_extend" ),
				"param_name"    		=> 'button_float',
				"value"         		=> array(
					__( 'Center', "ts_visual_composer_extend" )   				=> 'center',
					__( 'Left', "ts_visual_composer_extend" )   				=> 'left', 
					__( 'Right', "ts_visual_composer_extend" )  				=> 'right',
				),
				"std"					=> "center",
				"default"				=> "center",
				"description"   		=> __( "Select how the button should be aligned inside the column it is embedded in.", "ts_visual_composer_extend" ),
				"group"					=> "Button Styling",
			),		
			// Custom Styling
			array(
				"type"              	=> "seperator",
				"param_name"        	=> "seperator_4",
				"seperator"				=> "Custom Styling",
				"dependency"			=> array( 'element' => "button_theme", 'value' => 'custom' ),
				"group"					=> "Button Styling",				
			),
			array(
				'type'          		=> 'colorpicker',
				'heading'       		=> __( 'Default: Text Color', "ts_visual_composer_extend" ),
				'param_name'    		=> 'default_text',
				'value'         		=> '#ffffff',
				'dependency'    		=> array( 'element' => 'button_theme', 'value' => array( 'custom' ) ),
				"edit_field_class"		=> "vc_col-sm-6 vc_column",
				'group'         		=> "Button Styling",	
			),
			array(
				'type'          		=> 'colorpicker',
				'heading'       		=> __( 'Default: Background Color', "ts_visual_composer_extend" ),
				'param_name'    		=> 'default_background',
				'value'					=> '#1ca2f1',
				'dependency'    		=> array( 'element' => 'button_theme', 'value' => array( 'custom' ) ),
				"edit_field_class"		=> "vc_col-sm-6 vc_column",
				'group'         		=> "Button Styling",	
			),
			array(
				'type'          		=> 'colorpicker',
				'heading'       		=> __( 'Hover: Text Color', "ts_visual_composer_extend" ),
				'param_name'    		=> 'hover_text',
				'value'         		=> '#ffffff',
				'dependency'    		=> array( 'element' => 'button_theme', 'value' => array( 'custom' ) ),
				"edit_field_class"		=> "vc_col-sm-6 vc_column",
				'group'         		=> "Button Styling",	
			),
			array(
				'type'          		=> 'colorpicker',
				'heading'       		=> __( 'Hover: Background Color', "ts_visual_composer_extend" ),
				'param_name'    		=> 'hover_background',
				'value'					=> '#0094e0',
				'dependency'    		=> array( 'element' => 'button_theme', 'value' => array( 'custom' ) ),
				"edit_field_class"		=> "vc_col-sm-6 vc_column",
				'group'         		=> "Button Styling",	
			),
			// Icon Settings
			array(
				"type"              	=> "seperator",
				"param_name"        	=> "seperator_5",
				"seperator"				=> "Icon Settings",
				"group"					=> "Icon Settings",
			),
			array(
				"type" 					=> "icons_panel",
				'heading' 				=> __( 'Button: Icon', 'ts_visual_composer_extend' ),
				'param_name' 			=> 'icon_select',
				'value'					=> '',
				"settings" 				=> array(
					"emptyIcon" 				=> true,
					'emptyIconValue'			=> 'transparent',
					"type" 						=> 'extensions',
				),
				"admin_label"       	=> true,
				"description"       	=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorVisualSelector == "true" ? __( "Select the icon you want to display in button.", "ts_visual_composer_extend" ) : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorString),
				"group"         		=> "Icon Settings",
			),			
			array(
			  'type'          			=> 'dropdown',
			  'heading'       			=> __( 'Button: Icon Position', "ts_visual_composer_extend" ),
			  'param_name'    			=> 'icon_position',
			  'value'         			=> array( 
				__( 'Left', "ts_visual_composer_extend" )  						=> 'left', 
				__( 'Right', "ts_visual_composer_extend" ) 						=> 'right', 
				__( 'Top', "ts_visual_composer_extend" )   						=> 'top', 
				__( 'Bottom', "ts_visual_composer_extend" )						=> 'bottom'
			  ),
				"std"					=> "left",
				"default"				=> "left",
				"admin_label"       	=> true,
				"description"   		=> __( "Select where the icon should be placed in relation to the button text.", "ts_visual_composer_extend" ),
				"group"         		=> "Icon Settings",
			),
			array(
				"type"                  => "switch_button",
				"heading"			    => __( 'Button: Icon On Hover', "ts_visual_composer_extend" ),
				"param_name"		    => "icon_hover",
				"value"                 => "false",
				"description"		    => __( "Switch the toggle if you want to allow basic HTML code for the tooltip content.", "ts_visual_composer_extend" ),
				"group"         		=> "Icon Settings",
			),
			// Tooltip Settings
			array(
				"type"				    => "seperator",
				"param_name"		    => "seperator_6",
				"seperator"				=> "Tooltip Settings",
				"dependency"    		=> array( "element" => "button_tooltip", "value" => "true" ),
				"group" 				=> "Tooltip Settings",
			),
			array(
				"type"              	=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorBase64TinyMCE == "true" ? "wysiwyg_base64" : "textarea_raw_html"),
				"heading"           	=> __( "Tooltip Content", "ts_visual_composer_extend" ),
				"param_name"        	=> "tooltip_advanced",
				"minimal"				=> "true",
				"value"             	=> base64_encode(""),
				"description"      	 	=> __( "Enter the tooltip content here; HTML code can be used.", "ts_visual_composer_extend" ),
				"dependency"    		=> array( "element" => "button_tooltip", "value" => "true" ),
				"group" 				=> "Tooltip Settings",
			),
			array(
				"type"					=> "dropdown",
				"class"					=> "",
				"heading"				=> __( "Tooltip Position", "ts_visual_composer_extend" ),
				"param_name"			=> "tooltip_position",
				"value"					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_ToolTipster_Vertical,
				"description"			=> __( "Select the tooltip position in relation to the image.", "ts_visual_composer_extend" ),
				"dependency"    		=> array( "element" => "button_tooltip", "value" => "true" ),
				"group" 				=> "Tooltip Settings",
			),
			array(
				"type"					=> "dropdown",
				"heading"				=> __( "Tooltip Style", "ts_visual_composer_extend" ),
				"param_name"			=> "tooltip_style",
				"value"             	=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_ToolTipster_Layouts,
				"description"			=> __( "Select the tooltip style.", "ts_visual_composer_extend" ),
				"dependency"    		=> array( "element" => "button_tooltip", "value" => "true" ),
				"group" 				=> "Tooltip Settings",
			),
			array(
				"type"				    => "dropdown",
				"heading"			    => __( "Tooltip Animation", "ts_visual_composer_extend" ),
				"param_name"		    => "tooltip_animation",
				"value"                 => $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_ToolTipster_Animations,
				"description"		    => __( "Select how the tooltip entry and exit should be animated once triggered.", "ts_visual_composer_extend" ),
				"group"					=> "Tooltip Settings",
				"dependency"            => array( 'element' => "button_tooltip", 'value' => 'true' ),
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
				"dependency"    		=> array( "element" => "button_tooltip", "value" => "true" ),
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
				"dependency"    		=> array( "element" => "button_tooltip", "value" => "true" ),
				"group" 				=> "Tooltip Settings",
			),		
			// Other Settings
			array(
				"type"				    => "seperator",
				"param_name"		    => "seperator_7",
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
	}
?>