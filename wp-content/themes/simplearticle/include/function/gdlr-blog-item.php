<?php
	/*	
	*	Goodlayers Blog Item Management File
	*	---------------------------------------------------------------------
	*	This file contains functions that help you get blog item
	*	---------------------------------------------------------------------
	*/
	
	if( !function_exists('gdlr_carousel_grid_nav') ){
		function gdlr_carousel_grid_nav(){
			$ret  = '<div class="gdlr-outer-nav gdlr-nav-container">';
			$ret .= '<span class="gdlr-flex-prev" ><i class="icon-angle-left"></i></span>';
			$ret .= '<span class="gdlr-flex-next" ><i class="icon-angle-right"></i></span>';
			$ret .= '</div>';
			
			return $ret;
		}
	}
	
	if( !function_exists('gdlr_get_blog_item') ){
		function gdlr_get_blog_item( $settings = array() ){
			$item_id = empty($settings['page-item-id'])? '': ' id="' . $settings['page-item-id'] . '" ';

			global $gdlr_spaces;
			$margin = (!empty($settings['margin-bottom']) && 
				$settings['margin-bottom'] != $gdlr_spaces['bottom-blog-item'])? 'margin-bottom: ' . $settings['margin-bottom'] . ';': '';
			$margin_style = (!empty($margin))? ' style="' . $margin . '" ': '';
			
			$ret  = gdlr_get_item_title($settings);
			$ret .= '<div class="blog-item-wrapper gdlr-' . $settings['blog-style'] . '-type"  ' . $item_id . $margin_style . '>';

			if( strpos($settings['blog-style'], 'blog-1-') !== false && $settings['blog-layout'] == 'carousel' ){
				$ret .= gdlr_carousel_grid_nav();
			}
			
			// query post and sticky post
			$args = array('post_type' => 'post', 'suppress_filters' => false);
			if( !empty($settings['category']) || !empty($settings['tag']) ){
				$args['tax_query'] = array('relation' => 'OR');
				
				if( !empty($settings['category']) ){
					array_push($args['tax_query'], array('terms'=>explode(',', $settings['category']), 'taxonomy'=>'category', 'field'=>'slug'));
				}
				if( !empty($settings['tag']) ){
					array_push($args['tax_query'], array('terms'=>explode(',', $settings['tag']), 'taxonomy'=>'post_tag', 'field'=>'slug'));
				}				
			}

			if( $settings['enable-sticky'] == 'enable' ){
				if( get_query_var('paged') <= 1 ){
					$sticky_args = $args;
					$sticky_args['post__in'] = get_option('sticky_posts');
					if( !empty($sticky_args['post__in']) ){
						$sticky_query = new WP_Query($sticky_args);	
					}
				}
				$args['post__not_in'] = get_option('sticky_posts', '');
			}else{
				$args['ignore_sticky_posts'] = 1;
			}
			$args['posts_per_page'] = (empty($settings['num-fetch']))? '5': $settings['num-fetch'];
			$args['orderby'] = (empty($settings['orderby']))? 'post_date': $settings['orderby'];
			$args['order'] = (empty($settings['order']))? 'desc': $settings['order'];
			$args['paged'] = (get_query_var('paged'))? get_query_var('paged') : get_query_var('page');
			$args['paged'] = empty($args['paged'])? 1: $args['paged'];
			$args['offset'] = (empty($settings['offset']))? "": $settings['offset'];			
			$query = new WP_Query( $args );

			// merge query
			if( !empty($sticky_query) ){
				$query->posts = array_merge($sticky_query->posts, $query->posts);
				$query->post_count = $sticky_query->post_count + $query->post_count;
			}

			// set the excerpt length
			if( !empty($settings['num-excerpt']) ){
				global $gdlr_excerpt_length; $gdlr_excerpt_length = $settings['num-excerpt'];
				add_filter('excerpt_length', 'gdlr_set_excerpt_length');
			} 
			
			// get blog by the blog style
			global $gdlr_post_settings, $gdlr_lightbox_id;
			$gdlr_lightbox_id++;
			$gdlr_post_settings['excerpt'] = intval($settings['num-excerpt']);
			$gdlr_post_settings['thumbnail-size'] = $settings['thumbnail-size'];			
			$gdlr_post_settings['blog-style'] = $settings['blog-style'];			
			
			// filter option
			if( !empty($settings['enable-jquery-filter']) && $settings['enable-jquery-filter'] == 'enable' ){
				$ret .= gdlr_get_blog_filter($settings, $args);
			}
			 
			$ret .= '<div class="blog-item-holder">';
			if($settings['blog-style'] == 'blog-full'){
				$ret .= gdlr_get_blog_full($query);
			}else if($settings['blog-style'] == 'blog-medium'){
				$ret .= gdlr_get_blog_medium($query);			
			}else{
				$blog_size = str_replace('blog-1-', '', $settings['blog-style']);
				$ret .= gdlr_get_blog_grid($query, $blog_size, $settings['blog-layout']);
			}
			
			if( $settings['pagination'] == 'enable' ){
				if( !empty($settings['enable-jquery-filter']) && $settings['enable-jquery-filter'] == 'enable' ){
					$ret .= gdlr_get_ajax_pagination($query->max_num_pages, $args['paged']);
				}else{
					$ret .= gdlr_get_pagination($query->max_num_pages, $args['paged']);
				}
			}
			$ret .= '<div class="clear"></div>';
			$ret .= '</div>'; // blog-item-holder

			$ret .= '</div>'; // blog-item-wrapper
			
			remove_filter('excerpt_length', 'gdlr_set_excerpt_length');
			return $ret;
		}
	}

	add_action('wp_ajax_gdlr_get_blog_ajax', 'gdlr_get_blog_ajax');
	add_action('wp_ajax_nopriv_gdlr_get_blog_ajax', 'gdlr_get_blog_ajax');
	if( !function_exists('gdlr_get_blog_ajax') ){
		function gdlr_get_blog_ajax(){
			$settings = $_POST['args'];
		
			// query post and sticky post
			$args = array('post_type' => 'post', 'suppress_filters' => false);
			$args['category_name'] = $settings['category'];
			if( $settings['enable-sticky'] == 'enable' ){
				if( $settings['paged'] <= 1 ){
					$sticky_args = $args;
					$sticky_args['post__in'] = get_option('sticky_posts');
					if( !empty($sticky_args['post__in']) ){
						$sticky_query = new WP_Query($sticky_args);	
					}
				}
				$args['post__not_in'] = get_option('sticky_posts', '');
			}else{
				$args['ignore_sticky_posts'] = 1;
			}
			$args['posts_per_page'] = (empty($settings['num-fetch']))? '5': $settings['num-fetch'];
			$args['orderby'] = (empty($settings['orderby']))? 'post_date': $settings['orderby'];
			$args['order'] = (empty($settings['order']))? 'desc': $settings['order'];
			$args['paged'] = $settings['paged'];		
			$query = new WP_Query( $args );

			// merge query
			if( !empty($sticky_query) ){
				$query->posts = array_merge($sticky_query->posts, $query->posts);
				$query->post_count = $sticky_query->post_count + $query->post_count;
			}

			// set the excerpt length
			if( !empty($settings['num-excerpt']) ){
				global $gdlr_excerpt_length; $gdlr_excerpt_length = $settings['num-excerpt'];
				add_filter('excerpt_length', 'gdlr_set_excerpt_length');
			} 
			
			// get blog by the blog style
			global $gdlr_post_settings, $gdlr_lightbox_id;
			$gdlr_lightbox_id++;
			$gdlr_post_settings['excerpt'] = intval($settings['num-excerpt']);
			$gdlr_post_settings['thumbnail-size'] = $settings['thumbnail-size'];			
			$gdlr_post_settings['blog-style'] = $settings['blog-style'];			
			 
			$ret  = '<div class="blog-item-holder">';
			if($settings['blog-style'] == 'blog-full'){
				$ret .= gdlr_get_blog_full($query);
			}else if($settings['blog-style'] == 'blog-medium'){
				$ret .= gdlr_get_blog_medium($query);			
			}else{
				$blog_size = str_replace('blog-1-', '', $settings['blog-style']);
				$ret .= gdlr_get_blog_grid($query, $blog_size, $settings['blog-layout']);
			}
			
			$ret .= gdlr_get_ajax_pagination($query->max_num_pages, $args['paged']);
			$ret .= '<div class="clear"></div>';
			$ret .= '</div>'; // blog-item-holder
			die($ret);			
		}
	}

	if( !function_exists('gdlr_get_blog_filter') ){
		function gdlr_get_blog_filter( $settings, $args ){

			// ajax infomation
			$ret  = '<div class="gdlr-ajax-info" data-num-fetch="' . $args['posts_per_page'] . '" data-num-excerpt="' . $settings['num-excerpt'] . '" ';
			$ret .= 'data-orderby="' . $args['orderby'] . '" data-order="' . $args['order'] . '" ';
			$ret .= 'data-thumbnail-size="' .  $settings['thumbnail-size'] . '" data-blog-style="' . $settings['blog-style'] . '" ';
			$ret .= 'data-blog-layout="' .  $settings['blog-layout'] . '" data-sticky="' . $settings['enable-sticky'] . '" ';
			$ret .= 'data-ajax="' . admin_url('admin-ajax.php') . '" data-category="' . $settings['category'] . '" ></div>';
		
			// category filter
			if( empty($settings['category']) ){
				$parent = array('gdlr-all'=>__('All', 'gdlr_translate'));
				$settings['category-id'] = '';
			}else{
				$term = get_term_by('slug', $settings['category'], 'category');
				$parent = array($settings['category']=>$term->name);
				$settings['category-id'] = $term->term_id;
			}
			
			$filters = $parent + gdlr_get_term_list('category', $settings['category-id']);
			$filter_active = 'active';
			$ret .= '<div class="blog-item-filter-wrapper gdlr-title-font">';
			$ret .= '<div class="blog-item-filter">';
			foreach($filters as $filter_id => $filter){
				$filter_id = ($filter_id == 'gdlr-all')? '': $filter_id;
				
				$ret .= '<span class="gdlr-separator">/</span>';
				$ret .= '<a class="' . $filter_active . '" href="#" ';
				$ret .= 'data-category="' . $filter_id . '" >' . $filter . '</a>';
				$filter_active = '';
			}
			$ret .= '</div>';
			$ret .= '</div>';
			
			return $ret;
		}
	}
	
	if( !function_exists('gdlr_get_blog_info') ){
		function gdlr_get_blog_info( $array = array(), $wrapper = true, $sep = '' ){
			global $theme_option; $ret = '';
			$exclude_meta = empty($theme_option['post-meta-data'])? array(): $theme_option['post-meta-data'];
			
			foreach($array as $post_info){
				if( in_array($post_info, $exclude_meta) ) continue;
				switch( $post_info ){
					case 'date':
						$ret .= $sep;
						$ret .= '<div class="blog-info blog-date"><i class="icon-calendar-empty"></i>';
						$ret .= '<a href="' . get_day_link( get_the_time('Y'), get_the_time('m'), get_the_time('d')) . '">';
						//$ret .= '<time date-time="' . get_the_time('Y-m-d') . '" pubdate>';
						$ret .= get_the_time($theme_option['date-format']);
						//$ret .= '</time>';
						$ret .= '</a>';
						$ret .= '</div>';
						break;
					case 'tag':
						$tag = get_the_term_list(get_the_ID(), 'post_tag', '', '<span class="sep">,</span> ' , '' );
						if(empty($tag)) break;					
						
						$ret .= $sep;
						$ret .= '<div class="blog-info blog-tag"><i class="icon-tags"></i>';
						$ret .= $tag;						
						$ret .= '</div>';						
						break;
					case 'category':
						$category = get_the_term_list(get_the_ID(), 'category', '', '<span class="sep">,</span> ' , '' );
						if(empty($category)) break;
						
						$ret .= $sep;
						$ret .= '<div class="blog-info blog-category"><i class="icon-folder-close-alt"></i>';
						$ret .= $category;					
						$ret .= '</div>';					
						break;
					case 'comment':
						$ret .= $sep;
						$ret .= '<div class="blog-info blog-comments"><i class="icon-comments-alt"></i>';
						$ret .= '<a href="' . get_permalink() . '#respond" >' . get_comments_number() . '</a>';						
						$ret .= '</div>';						
						break;
					case 'author':
						ob_start();
						the_author_posts_link();
						$author = ob_get_contents();
						ob_end_clean();
						
						$ret .= $sep;
						$ret .= '<div class="blog-info blog-author"><i class="icon-user"></i>';
						$ret .= $author;
						$ret .= '</div>';						
						break;						
				}
			}
			
			
			if($wrapper && !empty($ret)){
				return '<div class="gdlr-blog-info gdlr-title-font gdlr-info">' . $ret . '<div class="clear"></div></div>';
			}else if( !empty($ret) ){
				return $ret . '<div class="clear"></div>';
			}
			return '';
		}
	}
	
	if( !function_exists('gdlr_get_blog_grid') ){
		function gdlr_get_blog_grid($query, $size, $blog_layout = 'fitRows'){
			if($blog_layout == 'carousel'){ return gdlr_get_blog_grid_carousel($query, $size); }
		
			$ret = ''; $current_size = 0;
			
			$ret .= '<div class="gdlr-isotope" data-type="blog" data-layout="' . $blog_layout  . '" >';
			while($query->have_posts()){ $query->the_post();
				if( $current_size % $size == 0 ){
					$ret .= '<div class="clear"></div>';
				}

				$ret .= '<div class="' . gdlr_get_column_class('1/' . $size) . '">';
				$ret .= '<div class="gdlr-item gdlr-blog-grid">';
				$ret .= '<div class="gdlr-ux gdlr-blog-grid-ux">';
				ob_start();
				
				get_template_part('single/content');
				$ret .= ob_get_contents();
				
				ob_end_clean();			
				$ret .= '</div>'; // gdlr-ux			
				$ret .= '</div>'; // gdlr-item			
				$ret .= '</div>'; // column_class
				$current_size ++;
			}
			$ret .= '<div class="clear"></div>';
			$ret .= '</div>'; // close the gdlr-isotope
			wp_reset_postdata();
			
			return $ret;
		}
	}		
	
	if( !function_exists('gdlr_get_blog_grid_carousel') ){
		function gdlr_get_blog_grid_carousel($query, $size){
			$ret = ''; 
			
			$ret .= '<div class="gdlr-blog-carousel-item gdlr-item" >';
			$ret .= '<div class="flexslider" data-type="carousel" data-nav-container="blog-item-holder" data-columns="' . $size . '" >';	
			$ret .= '<ul class="slides" >';			
			while($query->have_posts()){ $query->the_post();
				$ret .= '<li class="gdlr-item gdlr-blog-grid">';
				ob_start();
				
				get_template_part('single/content');
				$ret .= ob_get_contents();
				
				ob_end_clean();					
				$ret .= '</li>'; // gdlr-item
			}
			$ret .= '</ul>';
			$ret .= '<div class="clear"></div>';
			$ret .= '</div>'; // close the flexslider
			$ret .= '</div>'; // close the gdlr-item
			wp_reset_postdata();
			
			return $ret;
		}
	}		
	
	if( !function_exists('gdlr_get_blog_medium') ){
		function gdlr_get_blog_medium($query){
			$ret = '';

			while($query->have_posts()){ $query->the_post();
				$ret .= '<div class="gdlr-item gdlr-blog-medium">';
				$ret .= '<div class="gdlr-ux gdlr-blog-medium-ux">';
				ob_start();
				
				get_template_part('single/content');
				$ret .= ob_get_contents();
				
				ob_end_clean();			
				$ret .= '</div>'; // gdlr-ux			
				$ret .= '</div>'; // gdlr-item
			}
			wp_reset_postdata();
			
			return $ret;
		}
	}		
	
	if( !function_exists('gdlr_get_blog_full') ){
		function gdlr_get_blog_full($query){
			$ret = '';
			$count = $query->post_count; $last = '';
			while($query->have_posts()){ $query->the_post(); $count--;
				if( $count == 0 ){ $last = 'gdlr-last'; }
				$ret .= '<div class="gdlr-item gdlr-blog-full ' . $last . '">';
				$ret .= '<div class="gdlr-ux gdlr-blog-full-ux">';
				ob_start();
				
				get_template_part('single/content');
				$ret .= ob_get_contents();
				
				ob_end_clean();			
				$ret .= '</div>'; // gdlr-ux
				$ret .= '</div>'; // gdlr-item
			}
			wp_reset_postdata();
			
			return $ret;
		}
	}	

?>