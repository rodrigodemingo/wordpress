<?php
	/*	
	*	Goodlayers Framework File
	*	---------------------------------------------------------------------
	*	This file contains the homepage loading button in page option area
	*	---------------------------------------------------------------------
	*/
	
	add_action('add_meta_boxes', 'gdlr_init_demo_page_option');
	if( !function_exists('gdlr_init_demo_page_option') ){
		function gdlr_init_demo_page_option(){
			add_meta_box( 'demo-page-option', 
				__('Load Demo Page', 'gdlr_translate'), 
				'gdlr_create_demo_page_option',
				'page',
				'side',
				'default'
			);
		}
	}
	
	if( !function_exists('gdlr_create_demo_page_option') ){
		function gdlr_create_demo_page_option(){
			global $post;
		
			$buttons = array(
				'homepage' => __('Homepage', 'gdlr_translate'),
				'author' => __('Author', 'gdlr_translate'),
				'about' => __('About Us', 'gdlr_translate'),
				'contact' => __('Contact', 'gdlr_translate'),
				'pricing' => __('Pricing', 'gdlr_translate'),
			);
			
			echo '<div id="gdlr-load-demo-wrapper" data-ajax="' . AJAX_URL . '" data-id="' . $post->ID . '" data-action="load_demo_pagebuilder">';
			echo '<em>';
			echo __('*This option allow you to set page item to following pages with one click. Note that to use this option will replace all your current page item setting in this page and <strong>This Can\'t Be Undone</strong>. ( Images are not included. )', 'gdlr_translate');
			echo '</em><div class="clear"></div>';
			foreach( $buttons as $button_slug => $button_title ){
				echo '<input type="button" data-slug="' . $button_slug . '" value="' . $button_title . '" />';
			}
			echo '</div>';

		}
	}
	
	add_action('wp_ajax_load_demo_pagebuilder', 'gdlr_load_demo_pagebuilder');
	if( !function_exists('gdlr_load_demo_pagebuilder') ){
		function gdlr_load_demo_pagebuilder(){
			$default_data = array(
				'homepage' => array(
					'above-sidebar'=>'[{"item-type":"wrapper","item-builder-title":"Color Wrapper","type":"color-wrapper","items":[{"item-type":"item","item-builder-title":"Post Slider","type":"post-slider","option":{"page-item-id":"","category":"post-slider","num-excerpt":"25","num-fetch":"8","thumbnail-size":"full-slider","style":"no-excerpt","caption-style":"post-bottom post-slider","orderby":"date","order":"desc","margin-bottom":"0px"}}],"option":{"page-item-id":"","background-type":"transparent","background":"#ffffff","skin":"no-skin","show-section":"gdlr-show-all","border":"none","border-top-color":"#e9e9e9","border-bottom-color":"#e9e9e9","padding-top":"30px","padding-bottom":"10px"}}]',
					'below-sidebar'=>'[]',
					'content-with-sidebar'=>'[{"item-type":"item","item-builder-title":"Blog","type":"blog","option":{"page-item-id":"","title-type":"none","title":"","caption":"","right-text":"Read All News","right-text-link":"","category":"sunday-morning","tag":"","num-excerpt":"-1","num-fetch":"9","blog-style":"blog-full","blog-layout":"fitRows","enable-jquery-filter":"disable","thumbnail-size":"post-thumbnail-size","orderby":"date","order":"desc","offset":"","pagination":"disable","enable-sticky":"enable","margin-bottom":"0px"}}]',
					'post-option'=>'{"sidebar":"right-sidebar","left-sidebar":"Footer 1","right-sidebar":"homepage","page-style":"normal","show-title":"disable","page-caption":"","show-content":"enable"}'
				),
				'author' => array(
					'above-sidebar'=>'[]',
					'below-sidebar'=>'[]',
					'content-with-sidebar'=>'[{"item-type":"item","item-builder-title":"Author","type":"author","option":{"page-item-id":"","column":"1/3","margin-bottom":"40px"}}]',
					'post-option'=>'{"sidebar":"no-sidebar","left-sidebar":"Footer 1","right-sidebar":"Footer 1","page-style":"normal","show-title":"enable","page-caption":"You can list authors easily!","show-content":"enable"}'
				),
				'about' => array(
					'above-sidebar'=>'[{"item-type":"wrapper","item-builder-title":"Background/Parallax Wrapper","type":"parallax-bg-wrapper","items":[{"item-type":"item","item-builder-title":"Service With Image","type":"service-with-image","option":{"page-item-id":"","image":"3161","thumbnail-size":"full","align":"left","title":"My Name Is John Doe","content":"<p>An Autralian blogger and a father of 2 sons.</p>","margin-bottom":"20px"}}],"option":{"page-item-id":"","type":"image","background":"3162","background-mobile":"","background-speed":"0","pattern":"1","video":"","video-overlay":"0.5","video-player":"enable","skin":"gdlr-skin-dark-skin","show-section":"gdlr-show-all","border":"none","border-top-color":"#e9e9e9","border-bottom-color":"#e9e9e9","padding-top":"70px","padding-bottom":"40px"}}]',
					'below-sidebar'=>'[]',
					'content-with-sidebar'=>'[{"item-type":"item","item-builder-title":"Content","type":"content","option":{"page-item-id":"","title-type":"none","title":"","caption":"","right-text":"Read All News","right-text-link":"","content":"","margin-bottom":"65px"}},{"item-type":"wrapper","item-builder-title":"Column Item","type":"column1-4","items":[{"item-type":"item","item-builder-title":"Column Service","type":"column-service","option":{"page-item-id":"","icon":"icon-eye-open","title":"Inceptos Dolor Mollis","style":"type-2","content":"<p>Aenean lacinia bibendum nulla sed consectetur. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit.</p>","margin-bottom":"65px"}}],"option":{},"size":"1/3"},{"item-type":"wrapper","item-builder-title":"Column Item","type":"column1-4","items":[{"item-type":"item","item-builder-title":"Column Service","type":"column-service","option":{"page-item-id":"","icon":"icon-screenshot","title":"Dolor Fusce Ligula","style":"type-2","content":"<p>Aenean lacinia bibendum nulla sed consectetur. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit.</p>","margin-bottom":"65px"}}],"option":{},"size":"1/3"},{"item-type":"wrapper","item-builder-title":"Column Item","type":"column1-2","items":[{"item-type":"item","item-builder-title":"Column Service","type":"column-service","option":{"page-item-id":"","icon":"icon-star","title":"Tortor Tellus Cras","style":"type-2","content":"<p>Aenean lacinia bibendum nulla sed consectetur. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit.</p>","margin-bottom":"65px"}}],"option":{},"size":"1/3"},{"item-type":"wrapper","item-builder-title":"Color Wrapper","type":"color-wrapper","items":[{"item-type":"wrapper","item-builder-title":"Column Item","type":"column1-2","items":[{"item-type":"item","item-builder-title":"Content","type":"content","option":{"page-item-id":"","title-type":"left","title":"My Biography","caption":"","right-text":"Read All News","right-text-link":"","content":"<p>[gdlr_dropcap color=|gq2|#333|gq2| ]S[/gdlr_dropcap] re consectetur est at lobortis. Curabitur blandit tempus porttitor. Donec ullamcorper nulla non metus auctor fringilla. Nullam quis risus eget urna mollis ornare vel eu leo. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Curabitur blandit tempus porttitor. Praesent commodo cursus magna, vel scelerisque nisl consectetur et.</p><p>Maecenas faucibus mollis interdum. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Maecenas faucibus mollis interdum. Donec id elit non mi porta gravida at eget metus. Etiam porta sem malesuada magna mollis euismod. Sed posuere consectetur est at lobortis. Aenean lacinia bibendum nulla sed consectetur.</p>","margin-bottom":"20px"}}],"option":{},"size":"1/2"},{"item-type":"wrapper","item-builder-title":"Column Item","type":"column1-2","items":[{"item-type":"item","item-builder-title":"Title","type":"title","option":{"page-item-id":"","title-type":"center-divider","title":"My Skills","caption":"","right-text":"Read All News","right-text-link":"","margin-bottom":"20px"}},{"item-type":"item","item-builder-title":"Skill Bar","type":"skill-bar","option":{"page-item-id":"","content":"Photoshop","percent":"100","size":"medium","icon":"icon-picture","text-color":"#ffffff","background-color":"#e9e9e9","progress-color":"#39dde3","margin-bottom":"30px"}},{"item-type":"item","item-builder-title":"Skill Bar","type":"skill-bar","option":{"page-item-id":"","content":"HTML/CSS","percent":"80","size":"medium","icon":"icon-code","text-color":"#ffffff","background-color":"#e9e9e9","progress-color":"#39dde3","margin-bottom":"30px"}},{"item-type":"item","item-builder-title":"Skill Bar","type":"skill-bar","option":{"page-item-id":"","content":"Typography","percent":"85","size":"medium","icon":"icon-text-height","text-color":"#ffffff","background-color":"#e9e9e9","progress-color":"#39dde3","margin-bottom":"30px"}},{"item-type":"item","item-builder-title":"Skill Bar","type":"skill-bar","option":{"page-item-id":"","content":"Logo Design","percent":"75","size":"medium","icon":"icon-ok-circle","text-color":"#ffffff","background-color":"#e9e9e9","progress-color":"#39dde3","margin-bottom":"30px"}}],"option":{},"size":"1/2"}],"option":{"page-item-id":"","background-type":"full-color","background":"#ffffff","skin":"no-skin","show-section":"gdlr-show-all","border":"none","border-top-color":"#e9e9e9","border-bottom-color":"#e9e9e9","padding-top":"80px","padding-bottom":"60px"}},{"item-type":"wrapper","item-builder-title":"Color Wrapper","type":"color-wrapper","items":[{"item-type":"item","item-builder-title":"Twitter","type":"twitter","option":{"page-item-id":"","title-type":"center","title":"Twitter Feed","caption":"","twitter-name":"goodlayers_demo","show-num":"5","consumer-key":"wKopeDIlHw85713Q4iJRDg","consumer-secret":"2QMwxnQNg6OtMGDfPQ5aRM9hsG0rcnJQiZ7pQNpIk","access-token":"2407358941-Yn8YgQNF4DjwQoZR1uAoMWwWr4gYKlWDnqOqPzz","access-token-secret":"4tVAPHp1tUCsywnJzCyke6Mo0r52za4uXJk01ofeUgadw","cache-time":"1","margin-bottom":"20px"}}],"option":{"page-item-id":"","background-type":"full-color","background":"#363636","skin":"gdlr-skin-dark-skin","show-section":"gdlr-show-all","border":"none","border-top-color":"#e9e9e9","border-bottom-color":"#e9e9e9","padding-top":"80px","padding-bottom":"40px"}}]',
					'post-option'=>'{"sidebar":"no-sidebar","left-sidebar":"blog","right-sidebar":"blog","page-style":"normal","show-title":"disable","page-caption":"Example Of About Us Page","show-content":"disable"}'
				),
				'contact' => array(
					'above-sidebar'=>'[]',
					'below-sidebar'=>'[]',
					'content-with-sidebar'=>'[{"item-type":"wrapper","item-builder-title":"Color Wrapper","type":"color-wrapper","items":[{"item-type":"item","item-builder-title":"Content","type":"content","option":{"page-item-id":"","title-type":"left-divider","title":"Before contacting me","caption":"","right-text":"Read All News","right-text-link":"","content":"<p><span style=|gq2|color: #808080;|gq2|>[gdlr_icon type=|gq2|icon-envelope-alt|gq2| size=|gq2|22px|gq2| color=|gq2|#333333|gq2|] johnSnow@SimpleArticleWP.com</span></p><p><span style=|gq2|color: #808080;|gq2|>[gdlr_icon type=|gq2|icon-phone|gq2| size=|gq2|22px|gq2| color=|gq2|#333333|gq2|] (1)978-2342-23</span></p><p><span style=|gq2|color: #808080;|gq2|>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Cras mattis consectetur purus sit amet fermentum. Donec id elit non mi porta gravida at eget metus. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor.</span></p>","margin-bottom":"60px"}},{"item-type":"item","item-builder-title":"Content","type":"content","option":{"page-item-id":"","title-type":"left-divider","title":"Or just fill this form","caption":"","right-text":"Read All News","right-text-link":"","content":"<p>[contact-form-7 id=|gq2|2256|gq2| title=|gq2|Contact form 1|gq2|]</p>","margin-bottom":"0px"}}],"option":{"page-item-id":"","background-type":"color","background":"#ffffff","skin":"no-skin","show-section":"gdlr-show-all","border":"none","border-top-color":"#e9e9e9","border-bottom-color":"#e9e9e9","padding-top":"0px","padding-bottom":"30px"}}]',
					'post-option'=>'{"sidebar":"right-sidebar","left-sidebar":"Footer 1","right-sidebar":"contact","page-style":"normal","show-title":"enable","page-caption":"Praesent commodo cursus magna vel scelerisque","show-content":"enable"}'
				),
				'pricing' => array(
					'above-sidebar'=>'[]',
					'below-sidebar'=>'[]',
					'content-with-sidebar'=>'[{"item-type":"wrapper","item-builder-title":"Background/Parallax Wrapper","type":"parallax-bg-wrapper","items":[{"item-type":"item","item-builder-title":"Title","type":"title","option":{"page-item-id":"","title-type":"center-large","title":"Example Of Pricing Page","caption":"Nullam id dolor id nibh ultricies vehicula ut id elit. Donec ullamcorper nulla non metus auctor fringilla.","right-text":"Read All News","right-text-link":"","margin-bottom":"40px"}}],"option":{"page-item-id":"","type":"image","background":"3162","background-mobile":"","background-speed":"0","pattern":"1","video":"","video-overlay":"0.5","video-player":"enable","skin":"gdlr-skin-dark-skin","show-section":"gdlr-show-all","border":"none","border-top-color":"#dddddd","border-bottom-color":"#dddddd","padding-top":"105px","padding-bottom":"50px"}},{"item-type":"wrapper","item-builder-title":"Color Wrapper","type":"color-wrapper","items":[{"item-type":"item","item-builder-title":"Price Table","type":"price-table","option":{"page-item-id":"","price-table":"[{|gq2|gdl-tab-title|gq2|:|gq2|Basic|gq2|,|gq2|gdl-tab-price|gq2|:|gq2|$29.99/mo|gq2|,|gq2|gdl-tab-content|gq2|:|gq2|<ul>|g2n||g2t|<li>30 GB</li>|g2n||g2t|<li>12 Email Accounts</li>|g2n||g2t|<li>50 GB Bandwidth</li>|g2n||g2t|<li>Live Chat Support</li>|g2n||g2t|<li>Enchanced SSL Security</li>|g2n|</ul>|gq2|,|gq2|gdl-tab-active|gq2|:|gq2|no|gq2|,|gq2|gdl-tab-link|gq2|:|gq2|#|gq2|},{|gq2|gdl-tab-title|gq2|:|gq2|Deluxe|gq2|,|gq2|gdl-tab-price|gq2|:|gq2|$39.99/mo|gq2|,|gq2|gdl-tab-content|gq2|:|gq2|<ul>|g2n||g2t|<li>30 GB</li>|g2n||g2t|<li>12 Email Accounts</li>|g2n||g2t|<li>50 GB Bandwidth</li>|g2n||g2t|<li>Live Chat Support</li>|g2n||g2t|<li>Enchanced SSL Security</li>|g2n|</ul>|gq2|,|gq2|gdl-tab-active|gq2|:|gq2|no|gq2|,|gq2|gdl-tab-link|gq2|:|gq2|#|gq2|},{|gq2|gdl-tab-title|gq2|:|gq2|Premium|gq2|,|gq2|gdl-tab-price|gq2|:|gq2|$49.99/mo|gq2|,|gq2|gdl-tab-content|gq2|:|gq2|<ul>|g2n||g2t|<li>30 GB</li>|g2n||g2t|<li>12 Email Accounts</li>|g2n||g2t|<li>50 GB Bandwidth</li>|g2n||g2t|<li>Live Chat Support</li>|g2n||g2t|<li>Enchanced SSL Security</li>|g2n|</ul>|gq2|,|gq2|gdl-tab-active|gq2|:|gq2|yes|gq2|,|gq2|gdl-tab-link|gq2|:|gq2|#|gq2|},{|gq2|gdl-tab-title|gq2|:|gq2|Advance|gq2|,|gq2|gdl-tab-price|gq2|:|gq2|$59.99/mo|gq2|,|gq2|gdl-tab-content|gq2|:|gq2|<ul>|g2n||g2t|<li>30 GB</li>|g2n||g2t|<li>12 Email Accounts</li>|g2n||g2t|<li>50 GB Bandwidth</li>|g2n||g2t|<li>Live Chat Support</li>|g2n||g2t|<li>Enchanced SSL Security</li>|g2n|</ul>|gq2|,|gq2|gdl-tab-active|gq2|:|gq2|no|gq2|,|gq2|gdl-tab-link|gq2|:|gq2|#|gq2|}]","columns":"4","margin-bottom":"50px"}}],"option":{"page-item-id":"","background-type":"full-color","background":"#ffffff","skin":"no-skin","show-section":"gdlr-show-all","border":"none","border-top-color":"#dddddd","border-bottom-color":"#dddddd","padding-top":"110px","padding-bottom":"40px"}},{"item-type":"wrapper","item-builder-title":"Color Wrapper","type":"color-wrapper","items":[{"item-type":"item","item-builder-title":"Stunning Text","type":"stunning-text","option":{"page-item-id":"","title":"Check Out Special Promotion Here!","caption":"Lorem ipsum dolor sit amet, consectetur adipisici elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua. Nihil hic munitissimus habendi senatus locus, nihil horum? Vivamus sagittis lacus vel augue laoreet rutrum faucibus.","button-text":"Buy Now","button-link":"#","style":"center","margin-bottom":"20px"}}],"option":{"page-item-id":"","background-type":"full-color","background":"#f3f3f3","skin":"no-skin","show-section":"gdlr-show-all","border":"none","border-top-color":"#dddddd","border-bottom-color":"#dddddd","padding-top":"70px","padding-bottom":"30px"}}]',
					'post-option'=>'{"sidebar":"no-sidebar","left-sidebar":"blog","right-sidebar":"blog","page-style":"normal","show-title":"disable","page-caption":"Lorem ipsum dolor sit amet, consectetur adipisici elit, sed eiusmod tempor.","show-content":"disable"}'
				)				
			);

			$loaded_data = $default_data[$_POST['slug']];
			foreach( $loaded_data as $meta_key => $meta_value ){
				update_post_meta($_POST['post_id'], $meta_key, $meta_value);
			}
		}
	}
?>