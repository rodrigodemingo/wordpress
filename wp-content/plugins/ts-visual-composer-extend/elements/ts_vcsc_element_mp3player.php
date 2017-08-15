<?php
    global $VISUAL_COMPOSER_EXTENSIONS;
	
    $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element = array(
		"name"                          	=> __( "TS MP3 Audio Player", "ts_visual_composer_extend" ),
		"base"                          	=> "TS_VCSC_MP3_Player",
		"icon" 	                        	=> "ts-composer-element-icon-mp3-player",
		"category"                      	=> __( "VC Extensions", "ts_visual_composer_extend" ),
		"description"                   	=> __("Place a MP3 audio player element", "ts_visual_composer_extend"),
		"admin_enqueue_js"              	=> "",
		"admin_enqueue_css"             	=> "",
		"params"                        	=> array(
			// Audio Sources
			array(
				"type"                  	=> "seperator",
				"param_name"            	=> "seperator_1",
				"seperator"					=> "Audio Sources",
			),
			array(
				'type' 						=> 'param_group',
				'heading' 					=> __( 'Playlist Data', 'ts_visual_composer_extend' ),
				'param_name' 				=> 'mp3_playlist',
				'description' 				=> __( 'Provide the information for each playlist entry. At least one entry is required for the player to work.', 'ts_visual_composer_extend' ),
				'save_always' 				=> true,
				'value' 					=> urlencode(json_encode(array(
					array(
						'audio_mp3_title'			=> '',
						'audio_mp3_author'			=> '',
						'audio_mp3_source' 			=> "false",
						'audio_mp3_local' 			=> '',
						'audio_mp3_remote'			=> '',
						'audio_mp3_image'			=> '',
						'audio_mp3_lyrics'			=> '',
					),
				))),
				'params' 					=> array(
					array(
						"type"                  => "textfield",
						"heading"               => __( "MP3 Audio Title", "ts_visual_composer_extend" ),
						"param_name"            => "audio_mp3_title",
						"value"                 => "",
						"description"           => __( "Enter a title for this audio track.", "ts_visual_composer_extend" ),
						'admin_label' 			=> true,
					),
					array(
						"type"                  => "textfield",
						"heading"               => __( "MP3 Audio Author", "ts_visual_composer_extend" ),
						"param_name"            => "audio_mp3_author",
						"value"                 => "",
						"description"           => __( "Enter the name of the author for this audio track.", "ts_visual_composer_extend" ),
					),	
					array(
						"type"                  => "switch_button",
						"heading"			    => __( "MP3 Audio Source", "ts_visual_composer_extend" ),
						"param_name"		    => "audio_mp3_source",
						"value"                 => "false",
						"description"		    => __( "Switch the toggle if you want to use a local or remote MP4 audio file.", "ts_visual_composer_extend" )
					),
					array(
						"type"                  => "audioselect",
						"heading"               => __( "MP3 Audio Local", "ts_visual_composer_extend" ),
						"param_name"            => "audio_mp3_local",
						"audio_format"			=> "mp3,mpeg",
						"value"                 => "",
						"description"           => __( "Select a local MP3 audio from WordPress.", "ts_visual_composer_extend" ),
						"dependency"            => array( 'element' => "audio_mp3_source", 'value' => 'true' ),
					),
					array(
						"type"                  => "textfield",
						"heading"               => __( "MP3 Audio Remote", "ts_visual_composer_extend" ),
						"param_name"            => "audio_mp3_remote",
						"value"                 => "",
						"description"           => __( "Enter the remote path to the MP3 version of the audio.", "ts_visual_composer_extend" ),
						"dependency"            => array( 'element' => "audio_mp3_source", 'value' => 'false' ),
					),
					array(
						"type"                  => "attach_image",
						"heading"               => __( "MP3 Audio Image", "ts_visual_composer_extend" ),
						"param_name"            => "audio_mp3_image",
						"value"                 => "",
						"description"           => __( "Select the image you want to use with this audio track.", "ts_visual_composer_extend" )
					),
					array(
						"type"                  => "textfield",
						"heading"               => __( "MP3 Audio Lyrics", "ts_visual_composer_extend" ),
						"param_name"            => "audio_mp3_lyrics",
						"value"                 => "",
						"description"           => __( "Enter the remote path to an optional .lrc file containing lyrics for this audio track.", "ts_visual_composer_extend" ),
					),
				),
			),
			// Other Settings
			array(
				"type"				    	=> "seperator",
				"param_name"		    	=> "seperator_2",
				"seperator"					=> "Player Settings",
			),
			array(
				"type"              		=> "dropdown",
				"heading"           		=> __( "Player: Preload Method", "ts_visual_composer_extend" ),
				"param_name"        		=> "player_preload",
				"value"             		=> array(
					__( "Metadata Only", "ts_visual_composer_extend" )							=> "metadata",
					__( "Automatic", "ts_visual_composer_extend" )								=> "auto",
					__( "None", "ts_visual_composer_extend" )                 					=> "none",
				),
				"admin_label"				=> true,
				"description"				=> __( "Define if and how the player should preload the audio track(s).", "ts_visual_composer_extend" ),
			),	
			array(
				"type"              		=> "dropdown",
				"heading"           		=> __( "Player: Play Mode", "ts_visual_composer_extend" ),
				"param_name"        		=> "player_mode",
				"value"             		=> array(
					__( "Circulation (Loop)", "ts_visual_composer_extend" )						=> "circulation",
					__( "Order (No Loop)", "ts_visual_composer_extend" )						=> "order",
					__( "Single Track", "ts_visual_composer_extend" )							=> "single",
					__( "Random Track", "ts_visual_composer_extend" )							=> "random",
				),
				"admin_label"				=> true,
				"description"				=> __( "Define how the player should play the audio track(s).", "ts_visual_composer_extend" ),
			),
			array(
				"type"              		=> "nouislider",
				"heading"           		=> __( "Player: Initial Track", "ts_visual_composer_extend" ),
				"param_name"        		=> "player_start",
				"value"             		=> "1",
				"min"               		=> "1",
				"max"               		=> "99",
				"step"              		=> "1",
				"unit"              		=> 'x',
				"description"       		=> __( "Define the initial track for the player; only applicable if more than one track in playlist.", "ts_visual_composer_extend" ),
			),
			array(
				"type"              		=> "nouislider",
				"heading"           		=> __( "Player: Initial Volume", "ts_visual_composer_extend" ),
				"param_name"        		=> "player_volume",
				"value"             		=> "0",
				"min"               		=> "90",
				"max"               		=> "100",
				"step"              		=> "1",
				"unit"              		=> '%',
				"description"       		=> __( "Define the initial volume level for the player.", "ts_visual_composer_extend" ),
			),
			array(
				"type"              		=> "dropdown",
				"heading"           		=> __( "Player: Auto-Play", "ts_visual_composer_extend" ),
				"param_name"        		=> "player_auto",
				"value"             		=> array(
					__( "No Auto-Play", "ts_visual_composer_extend" )							=> "false",
					__( "Play once initialized", "ts_visual_composer_extend" )					=> "init",
					__( "Play ONLY in Browser View (Repeat)", "ts_visual_composer_extend" )		=> "inviewall",
					__( "Play ONLY in Browser View (Once)", "ts_visual_composer_extend" )		=> "inviewsingle",
					__( "Play once in Browser View (Repeat)", "ts_visual_composer_extend" )		=> "viewportall",
					__( "Play once in Browser View (Once)", "ts_visual_composer_extend" )		=> "viewportsingle",
				),
				"admin_label"				=> true,
				"description"				=> __( "Define if and how the player should automaticaly start playing.", "ts_visual_composer_extend" ),
			),	
			array(
				"type"                  	=> "switch_button",
				"heading"			    	=> __( 'Player: Stop Others', "ts_visual_composer_extend" ),
				"param_name"		    	=> "player_mutex",
				"edit_field_class"			=> "vc_col-sm-6 vc_column",
				"value"                 	=> "true",
				"description"		    	=> __( "Switch the toggle if you want to stop all other MP3 players on the page once this one starts playing.", "ts_visual_composer_extend" ),
			),
			array(
				"type"                  	=> "switch_button",
				"heading"			    	=> __( 'Player: Mini Layout', "ts_visual_composer_extend" ),
				"param_name"		    	=> "player_narrow",
				"edit_field_class"			=> "vc_col-sm-6 vc_column",
				"value"                 	=> "false",
				"description"		    	=> __( "Switch the toggle if you want to use the mini layout for the player; only applicable for a playlist with a single track.", "ts_visual_composer_extend" ),
			),
			array(
				"type"              		=> "nouislider",
				"heading"           		=> __( "Player: Playlist Height", "ts_visual_composer_extend" ),
				"param_name"        		=> "player_height",
				"value"             		=> "513",
				"min"               		=> "200",
				"max"               		=> "1000",
				"step"              		=> "1",
				"unit"              		=> 'px',
				"description"       		=> __( "Define the maximum height for the track playlist below the player; only applicable if more than one track in playlist.", "ts_visual_composer_extend" ),
			),
			array(
				"type"                  	=> "switch_button",
				"heading"			    	=> __( 'Player: Show Playlist', "ts_visual_composer_extend" ),
				"param_name"		    	=> "player_showlist",
				"edit_field_class"			=> "vc_col-sm-6 vc_column",
				"value"                 	=> "true",
				"description"		    	=> __( "Switch the toggle if you want to use initially show the track playlist, or keep it collapsed.", "ts_visual_composer_extend" ),
			),
			array(
				"type"                  	=> "switch_button",
				"heading"			    	=> __( 'Player: Show Lyrics', "ts_visual_composer_extend" ),
				"param_name"		    	=> "player_showlrc",
				"edit_field_class"			=> "vc_col-sm-6 vc_column",
				"value"                 	=> "true",
				"description"		    	=> __( "Switch the toggle if you want to use scrolling lyrics for audio tracks with that have a .lrc file assigned to them.", "ts_visual_composer_extend" ),
			),
			array(
				"type"              		=> "colorpicker",
				"heading"           		=> __( "Player: Theme Color", "ts_visual_composer_extend" ),
				"param_name"        		=> "player_theme",
				"value"             		=> "#b7daff",
				"description"       		=> __( "Define the common theme color for progress and volume bars.", "ts_visual_composer_extend" ),
				"edit_field_class"			=> "vc_col-sm-6 vc_column",
			),
			array(
				"type"                  	=> "textfield",
				"heading"               	=> __( "Player: Loading Message", "ts_visual_composer_extend" ),
				"param_name"            	=> "player_loading",
				"value"                 	=> "Loading ...",
				"description"           	=> __( "Enter the text string to be shown while any lyric files are loaded into the player.", "ts_visual_composer_extend" ),
				"edit_field_class"			=> "vc_col-sm-6 vc_column",
			),
			// Tooltip Settings
			array(
				"type"              		=> "seperator",
				"param_name"        		=> "seperator_3",
				"seperator"            		=> "Tooltip Settings",
				"group" 					=> "Tooltip Settings",
			),
			array(
				"type"						=> "switch_button",
				"heading"           		=> __( "Tooltip Addition", "ts_visual_composer_extend" ),
				"param_name"        		=> "tooltip_usage",
				"value"            	 		=> "false",
				"description"       		=> __( "Switch the toggle if you want to add an optional tooltip to the element.", "ts_visual_composer_extend" ),
				"group" 					=> "Tooltip Settings",
			),
			array(
				"type"              		=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorBase64TinyMCE == "true" ? "wysiwyg_base64" : "textarea_raw_html"),
				"heading"           		=> __( "Tooltip Content", "ts_visual_composer_extend" ),
				"param_name"        		=> "tooltip_content",
				"minimal"					=> "true",
				"value"             		=> base64_encode(""),
				"description"      	 		=> __( "Enter the tooltip content for the element; basic HTML code can be used.", "ts_visual_composer_extend" ),
				"dependency"        		=> array( 'element' => "tooltip_usage", 'value' => 'true' ),
				"group" 					=> "Tooltip Settings",
			),
			array(
				"type"						=> "switch_button",
				"heading"           		=> __( "Tooltip Arrow", "ts_visual_composer_extend" ),
				"param_name"        		=> "tooltip_arrow",
				"value"             		=> "true",
				"description"       		=> __( "Switch the toggle to either show or hide the tooltip arrow.", "ts_visual_composer_extend" ),
				"dependency"        		=> array( 'element' => "tooltip_usage", 'value' => 'true' ),
				"group" 					=> "Tooltip Settings",
			),
			array(
				"type"						=> "dropdown",
				"heading"					=> __( "Tooltip Position", "ts_visual_composer_extend" ),
				"param_name"				=> "tooltip_position",
				"value"						=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_ToolTipster_Positions,
				"description"				=> __( "Select the tooltip position in relation to the element.", "ts_visual_composer_extend" ),
				"edit_field_class"			=> "vc_col-sm-6 vc_column",
				"dependency"        		=> array( 'element' => "tooltip_usage", 'value' => 'true' ),
				"group" 					=> "Tooltip Settings",
			),
			array(
				"type"				    	=> "dropdown",
				"heading"			    	=> __( "Tooltip Animation", "ts_visual_composer_extend" ),
				"param_name"		   	 	=> "tooltip_animation",
				"value"                 	=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_ToolTipster_Animations,
				"description"		    	=> __( "Select how the tooltip entry and exit should be animated once triggered.", "ts_visual_composer_extend" ),
				"edit_field_class"			=> "vc_col-sm-6 vc_column",
				"dependency"        		=> array( 'element' => "tooltip_usage", 'value' => 'true' ),
				"group"						=> "Tooltip Settings",
			),	
			array(
				"type"						=> "dropdown",
				"heading"					=> __( "Tooltip Style", "ts_visual_composer_extend" ),
				"param_name"				=> "tooltip_style",
				"value"             		=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_ToolTipster_Styles,
				"description"				=> __( "Select the tooltip style.", "ts_visual_composer_extend" ),
				"edit_field_class"			=> "vc_col-sm-6 vc_column",
				"dependency"        		=> array( 'element' => "tooltip_usage", 'value' => 'true' ),
				"group" 					=> "Tooltip Settings",
			),
			array(
				"type"              		=> "colorpicker",
				"heading"           		=> __( "Tooltip Font Color", "ts_visual_composer_extend" ),
				"param_name"        		=> "tooltip_color",
				"value"             		=> "#ffffff",
				"description"       		=> __( "Define the custom font color for the tooltip.", "ts_visual_composer_extend" ),
				"dependency"        		=> array( 'element' => "tooltip_style", 'value' => array('tooltipster-custom', 'ts-simptip-style-custom') ),
				"edit_field_class"			=> "vc_col-sm-6 vc_column",
				"group" 					=> "Tooltip Settings",
			),		
			array(
				"type"              		=> "colorpicker",
				"heading"           		=> __( "Tooltip Background Color", "ts_visual_composer_extend" ),
				"param_name"        		=> "tooltip_background",
				"value"             		=> "#000000",
				"description"       		=> __( "Define the custom background color for the tooltip.", "ts_visual_composer_extend" ),
				"dependency"        		=> array( 'element' => "tooltip_style", 'value' => array('tooltipster-custom', 'ts-simptip-style-custom') ),
				"edit_field_class"			=> "vc_col-sm-6 vc_column",
				"group" 					=> "Tooltip Settings",
			),
			array(
				"type"              		=> "colorpicker",
				"heading"           		=> __( "Tooltip Border Color", "ts_visual_composer_extend" ),
				"param_name"        		=> "tooltip_border",
				"value"             		=> "#000000",
				"description"       		=> __( "Define the custom border color for the tooltip.", "ts_visual_composer_extend" ),
				"dependency"        		=> array( 'element' => "tooltip_style", 'value' => array('tooltipster-custom', 'ts-simptip-style-custom') ),
				"edit_field_class"			=> "vc_col-sm-6 vc_column",
				"group" 					=> "Tooltip Settings",
			),	
			array(
				"type"						=> "nouislider",
				"heading"					=> __( "Tooltip X-Offset", "ts_visual_composer_extend" ),
				"param_name"				=> "tooltip_offsetx",
				"value"						=> "0",
				"min"						=> "-100",
				"max"						=> "100",
				"step"						=> "1",
				"unit"						=> 'px',
				"description"				=> __( "Define an optional X-Offset for the tooltip position.", "ts_visual_composer_extend" ),
				"dependency"        		=> array( 'element' => "tooltip_usage", 'value' => 'true' ),
				"group" 					=> "Tooltip Settings",
			),
			array(
				"type"						=> "nouislider",
				"heading"					=> __( "Tooltip Y-Offset", "ts_visual_composer_extend" ),
				"param_name"				=> "tooltip_offsety",
				"value"						=> "0",
				"min"						=> "-100",
				"max"						=> "100",
				"step"						=> "1",
				"unit"						=> 'px',
				"description"				=> __( "Define an optional Y-Offset for the tooltip position.", "ts_visual_composer_extend" ),
				"dependency"        		=> array( 'element' => "tooltip_usage", 'value' => 'true' ),
				"group" 					=> "Tooltip Settings",
			),
			// Other Settings
			array(
				"type"				    	=> "seperator",
				"param_name"		    	=> "seperator_4",
				"seperator"					=> "Other Settings",
				"group" 					=> "Other Settings",
			),
			array(
				"type"                  	=> "nouislider",
				"heading"               	=> __( "Margin: Top", "ts_visual_composer_extend" ),
				"param_name"            	=> "margin_top",
				"value"                 	=> "0",
				"min"                   	=> "0",
				"max"                   	=> "200",
				"step"                  	=> "1",
				"unit"                  	=> 'px',
				"description"          	 	=> __( "Select the top margin for the element.", "ts_visual_composer_extend" ),
				"group" 					=> "Other Settings",
			),
			array(
				"type"                  	=> "nouislider",
				"heading"               	=> __( "Margin: Bottom", "ts_visual_composer_extend" ),
				"param_name"            	=> "margin_bottom",
				"value"                 	=> "0",
				"min"                   	=> "0",
				"max"                   	=> "200",
				"step"                  	=> "1",
				"unit"                  	=> 'px',
				"description"           	=> __( "Select the bottom margin for the element.", "ts_visual_composer_extend" ),
				"group" 					=> "Other Settings",
			),
			array(
				"type"                  	=> "textfield",
				"heading"               	=> __( "Define ID Name", "ts_visual_composer_extend" ),
				"param_name"            	=> "el_id",
				"value"                 	=> "",
				"description"           	=> __( "Enter an unique ID for the element.", "ts_visual_composer_extend" ),
				"group" 					=> "Other Settings",
			),
			array(
				"type"                  	=> "tag_editor",
				"heading"           		=> __( "Extra Class Names", "ts_visual_composer_extend" ),
				"param_name"            	=> "el_class",
				"value"                 	=> "",
				"description"      			=> __( "Enter additional class names for the element.", "ts_visual_composer_extend" ),
				"group" 					=> "Other Settings",
			),
		)
	);

	if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_LeanMap == "true") {
		return $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element;
	} else {			
		vc_map($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element);
	}
?>