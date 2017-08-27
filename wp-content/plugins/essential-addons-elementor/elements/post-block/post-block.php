<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Eael_Post_Block extends Widget_Base {

	public function get_name() {
		return 'eael-post-block';
	}

	public function get_title() {
		return __( 'EA Post Block', 'essential-addons-elementor' );
	}

	public function get_icon() {
		return 'eicon-posts-grid';
	}

	public function get_categories() {
		return [ 'essential-addons-elementor' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'eael_section_post_block_filters',
			[
				'label' => __( 'Post Settings', 'essential-addons-elementor' )
			]
		);


		$this->add_control(
            'eael_post_type',
            [
                'label' => __( 'Post Type', 'essential-addons-elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => eael_get_post_types(),
                'default' => 'post',

            ]
        );

        $this->add_control(
            'category',
            [
                'label' => __( 'Categories', 'essential-addons-elementor' ),
                'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => eael_post_type_categories(),
                'condition' => [
                       'eael_post_type' => 'post'
                ]
            ]
        );


        $this->add_control(
            'eael_posts_count',
            [
                'label' => __( 'Number of Posts', 'essential-addons-elementor' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '4'
            ]
        );


        $this->add_control(
            'eael_post_offset',
            [
                'label' => __( 'Post Offset', 'essential-addons-elementor' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '0'
            ]
        );

        $this->add_control(
            'eael_post_orderby',
            [
                'label' => __( 'Order By', 'essential-addons-elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => eael_get_post_orderby_options(),
                'default' => 'date',

            ]
        );

        $this->add_control(
            'eael_post_order',
            [
                'label' => __( 'Order', 'essential-addons-elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'asc' => 'Ascending',
                    'desc' => 'Descending'
                ],
                'default' => 'desc',

            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
			'eael_section_post_block_layout',
			[
				'label' => __( 'Layout Settings', 'essential-addons-elementor' )
			]
		);

		$this->add_control(
			'eael_post_block_grid_style',
			[
				'label' => esc_html__( 'Post Block Style Preset', 'essential-addons-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'post-block-style-default',
				'options' => [
					'post-block-style-default' => esc_html__( 'Default', 'essential-addons-elementor' ),
					'post-block-style-overlay' => esc_html__( 'Overlay',   'essential-addons-elementor' ),
				],
			]
		);


        $this->add_control(
            'eael_show_image',
            [
                'label' => __( 'Show Image', 'essential-addons-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
					'1' => [
						'title' => __( 'Yes', 'essential-addons-elementor' ),
						'icon' => 'fa fa-check',
					],
					'0' => [
						'title' => __( 'No', 'essential-addons-elementor' ),
						'icon' => 'fa fa-ban',
					]
				],
				'default' => '1'
            ]
        );
        $this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'image',
				'exclude' => [ 'custom' ],
				'default' => 'medium',
				'condition' => [
                    'eael_show_image' => '1',
                ]
			]
		);


		$this->add_control(
            'eael_show_title',
            [
                'label' => __( 'Show Title', 'essential-addons-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
					'1' => [
						'title' => __( 'Yes', 'essential-addons-elementor' ),
						'icon' => 'fa fa-check',
					],
					'0' => [
						'title' => __( 'No', 'essential-addons-elementor' ),
						'icon' => 'fa fa-ban',
					]
				],
				'default' => '1'
            ]
        );

		$this->add_control(
            'eael_show_excerpt',
            [
                'label' => __( 'Show excerpt', 'essential-addons-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
					'1' => [
						'title' => __( 'Yes', 'essential-addons-elementor' ),
						'icon' => 'fa fa-check',
					],
					'0' => [
						'title' => __( 'No', 'essential-addons-elementor' ),
						'icon' => 'fa fa-ban',
					]
				],
				'default' => '1'
            ]
        );


        $this->add_control(
            'eael_excerpt_length',
            [
                'label' => __( 'Excerpt Words', 'essential-addons-elementor' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '10',
                'condition' => [
                    'eael_show_excerpt' => '1',
                ]

            ]
        );


		$this->add_control(
            'eael_show_meta',
            [
                'label' => __( 'Show Meta', 'essential-addons-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
					'1' => [
						'title' => __( 'Yes', 'essential-addons-elementor' ),
						'icon' => 'fa fa-check',
					],
					'0' => [
						'title' => __( 'No', 'essential-addons-elementor' ),
						'icon' => 'fa fa-ban',
					]
				],
				'default' => '1'
            ]
        );


		$this->add_control(
			'eael_post_block_meta_position',
			[
				'label' => esc_html__( 'Meta Position', 'essential-addons-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'meta-entry-footer',
				'options' => [
					'meta-entry-header' => esc_html__( 'Entry Header', 'essential-addons-elementor' ),
					'meta-entry-footer' => esc_html__( 'Entry Footer',   'essential-addons-elementor' ),
				],
                'condition' => [
                    'eael_show_meta' => '1',
                ]
			]
		);

        
		$this->end_controls_section();

        $this->start_controls_section(
            'eael_section_post_block_style',
            [
                'label' => __( 'Post Block Style', 'essential-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );


        $this->add_control(
			'eael_post_block_bg_color',
			[
				'label' => __( 'Post Background Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .eael-post-block-item' => 'background-color: {{VALUE}}',
				]

			]
		);


        $this->add_control(
			'eael_thumbnail_overlay_color',
			[
				'label' => __( 'Thumbnail Overlay Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(0,0,0, .5)',
				'selectors' => [
					'{{WRAPPER}} .eael-entry-overlay, {{WRAPPER}} .eael-post-block.post-block-style-overlay .eael-entry-wrapper' => 'background-color: {{VALUE}}',
				]

			]
		);

		$this->add_responsive_control(
			'eael_post_block_spacing',
			[
				'label' => esc_html__( 'Spacing Between Items', 'essential-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .eael-post-block-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'eael_post_block_border',
				'label' => esc_html__( 'Border', 'essential-addons-elementor' ),
				'selector' => '{{WRAPPER}} .eael-post-block-item',
			]
		);

		$this->add_control(
			'eael_post_block_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'essential-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .eael-post-block-item' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'eael_post_block_box_shadow',
				'selector' => '{{WRAPPER}} .eael-post-block-item',
			]
		);

		$this->end_controls_section();

        $this->start_controls_section(
            'eael_section_typography',
            [
                'label' => __( 'Color & Typography', 'essential-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

		$this->add_control(
			'eael_post_block_title_style',
			[
				'label' => __( 'Title Style', 'essential-addons-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
			'eael_post_block_title_color',
			[
				'label' => __( 'Title Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '#303133',
				'selectors' => [
					'{{WRAPPER}} .eael-entry-title, {{WRAPPER}} .eael-entry-title a' => 'color: {{VALUE}};',
				]

			]
		);

        $this->add_control(
			'eael_post_block_title_hover_color',
			[
				'label' => __( 'Title Hover Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '#23527c',
				'selectors' => [
					'{{WRAPPER}} .eael-entry-title:hover, {{WRAPPER}} .eael-entry-title a:hover' => 'color: {{VALUE}};',
				]

			]
		);

		$this->add_responsive_control(
			'eael_post_block_title_alignment',
			[
				'label' => __( 'Title Alignment', 'essential-addons-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'essential-addons-elementor' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'essential-addons-elementor' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'essential-addons-elementor' ),
						'icon' => 'fa fa-align-right',
					]
				],
				'selectors' => [
					'{{WRAPPER}} .eael-entry-title' => 'text-align: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'eael_post_block_title_typography',
				'label' => __( 'Typography', 'essential-addons-elementor' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .eael-entry-title',
			]
		);

		$this->add_control(
			'eael_post_block_excerpt_style',
			[
				'label' => __( 'Excerpt Style', 'essential-addons-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
			'eael_post_block_excerpt_color',
			[
				'label' => __( 'Excerpt Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '',
				'selectors' => [
					'{{WRAPPER}} .eael-grid-post-excerpt p' => 'color: {{VALUE}};',
				]
			]
		);

        $this->add_responsive_control(
			'eael_post_block_excerpt_alignment',
			[
				'label' => __( 'Excerpt Alignment', 'essential-addons-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'essential-addons-elementor' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'essential-addons-elementor' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'essential-addons-elementor' ),
						'icon' => 'fa fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'essential-addons-elementor' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .eael-grid-post-excerpt p' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'eael_post_block_excerpt_typography',
				'label' => __( 'excerpt Typography', 'essential-addons-elementor' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .eael-grid-post-excerpt p',
			]
		);


		$this->add_control(
			'eael_post_block_meta_style',
			[
				'label' => __( 'Meta Style', 'essential-addons-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
			'eael_post_block_meta_color',
			[
				'label' => __( 'Meta Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '',
				'selectors' => [
					'{{WRAPPER}} .eael-entry-meta, .eael-entry-meta a' => 'color: {{VALUE}};',
				]
			]
		);

        $this->add_responsive_control(
			'eael_post_block_meta_alignment_footer',
			[
				'label' => __( 'Meta Alignment', 'essential-addons-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => __( 'Left', 'essential-addons-elementor' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'essential-addons-elementor' ),
						'icon' => 'fa fa-align-center',
					],
					'flex-end' => [
						'title' => __( 'Right', 'essential-addons-elementor' ),
						'icon' => 'fa fa-align-right',
					],
					'stretch' => [
						'title' => __( 'Justified', 'essential-addons-elementor' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .eael-entry-footer' => 'justify-content: {{VALUE}};',
				],
                'condition' => [
                    'eael_post_block_meta_position' => 'meta-entry-footer',
                ]
			]
		);

        $this->add_responsive_control(
			'eael_post_block_meta_alignment_header',
			[
				'label' => __( 'Meta Alignment', 'essential-addons-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'essential-addons-elementor' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'essential-addons-elementor' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'essential-addons-elementor' ),
						'icon' => 'fa fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'essential-addons-elementor' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .eael-entry-meta' => 'text-align: {{VALUE}};',
				],
                'condition' => [
                    'eael_post_block_meta_position' => 'meta-entry-header',
                ]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'eael_post_block_meta_typography',
				'label' => __( 'Excerpt Typography', 'essential-addons-elementor' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .eael-entry-meta > div, {{WRAPPER}} .eael-entry-meta > span',
			]
		);


		$this->end_controls_section();

	}


	protected function render( ) {
        $settings = $this->get_settings();

        $post_args = eael_get_post_settings($settings);

        $posts = eael_get_post_data($post_args);

        ?>

		<div id="eael-post-block-<?php echo esc_attr($this->get_id()); ?>" class="eael-post-block <?php echo esc_attr($settings['eael_post_block_grid_style'] ); ?>">
		    <div class="eael-post-block-grid">
		    <?php
		        if(count($posts)){
		            global $post;
		            ?>
		                <?php
		                    foreach($posts as $post){
		                        setup_postdata($post);
		                    ?>


		                    <?php if($settings['eael_post_block_grid_style'] == 'post-block-style-default'){ ?>

		                    <article class="eael-post-block-item eael-post-block-column">
		                    	<div class="eael-post-block-item-holder">
			                    	<div class="eael-post-block-item-holder-inner">

			                    		<?php if($settings['eael_show_image'] == 1){ ?>
			                    		<div class="eael-entry-media">
			                    			<div class="eael-entry-overlay">
			                    				<i class="fa fa-long-arrow-right" aria-hidden="true"></i>
			                    				<a href="<?php echo get_permalink(); ?>"></a>
			                    			</div>
				                    		<div class="eael-entry-thumbnail">
				                    		<?php if ($thumbnail_exists = has_post_thumbnail()): ?>
				                    			<img src="<?php echo wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size'])?>">
				                    		<?php endif; ?>
				                    		</div>
			                    		</div>
			                    		<?php } ?>
			                    

			                    		<div class="eael-entry-wrapper">
			                    			<header class="eael-entry-header">
			                    				<?php if($settings['eael_show_title']){ ?>
			                    				<h2 class="eael-entry-title"><a class="eael-grid-post-link" href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
			                    				<?php } ?>

			                    				<?php if($settings['eael_show_meta'] && $settings['eael_post_block_meta_position'] == 'meta-entry-header'){ ?>
				                    			<div class="eael-entry-meta">
				                    				<span class="eael-posted-by"><?php the_author_posts_link(); ?></span>
				                    				<span class="eael-posted-on"><time datetime="<?php echo get_the_date(); ?>"><?php echo get_the_date(); ?></time></span>
				                    			</div>
				                    			<?php } ?>
			                    			</header>

			                    			<div class="eael-entry-content">
					                            <?php if($settings['eael_show_excerpt']){ ?>
					                            <div class="eael-grid-post-excerpt">
					                                <p><?php echo  eael_get_excerpt_by_id(get_the_ID(),$settings['eael_excerpt_length']);?></p>
					                            </div>
					                            <?php } ?>
			                    			</div>

			                    		</div>
			                    		<?php if($settings['eael_show_meta'] && $settings['eael_post_block_meta_position'] == 'meta-entry-footer'){ ?>
			                    		<div class="eael-entry-footer">
			                    			<div class="eael-author-avatar">
			                    				<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><?php echo get_avatar( get_the_author_meta( 'ID' ), 96 ); ?> </a>
			                    			</div>
			                    			<div class="eael-entry-meta">
			                    				<div class="eael-posted-by"><?php the_author_posts_link(); ?></div>
			                    				<div class="eael-posted-on"><time datetime="<?php echo get_the_date(); ?>"><?php echo get_the_date(); ?></time></div>
			                    			</div>
			                    		</div>
				                    	<?php } ?>
			                    	</div>
		                    	</div>
		                    </article>
		                    <?php } ?>

		                    <?php if($settings['eael_post_block_grid_style'] == 'post-block-style-overlay'){ ?>

		                    <article class="eael-post-block-item eael-post-block-column">
		                    	<div class="eael-post-block-item-holder">
			                    	<div class="eael-post-block-item-holder-inner">

			                    		<?php if($settings['eael_show_image'] == 1){ ?>
			                    		<div class="eael-entry-media">
				                    		<div class="eael-entry-thumbnail">
				                    		<?php if ($thumbnail_exists = has_post_thumbnail()): ?>
				                    			<img src="<?php echo wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size'])?>">
				                    		<?php endif; ?>
				                    		</div>
			                    		</div>
			                    		<?php } ?>
			                    

			                    		<div class="eael-entry-wrapper">
			                    			<header class="eael-entry-header">
			                    				<?php if($settings['eael_show_title']){ ?>
			                    				<h2 class="eael-entry-title"><a class="eael-grid-post-link" href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
			                    				<?php } ?>

			                    				<?php if($settings['eael_show_meta'] && $settings['eael_post_block_meta_position'] == 'meta-entry-header'){ ?>
				                    			<div class="eael-entry-meta">
				                    				<span class="eael-posted-by"><?php the_author_posts_link(); ?></span>
				                    				<span class="eael-posted-on"><time datetime="<?php echo get_the_date(); ?>"><?php echo get_the_date(); ?></time></span>
				                    			</div>
				                    			<?php } ?>
			                    			</header>

			                    			<div class="eael-entry-content">
					                            <?php if($settings['eael_show_excerpt']){ ?>
					                            <div class="eael-grid-post-excerpt">
					                                <p><?php echo  eael_get_excerpt_by_id(get_the_ID(),$settings['eael_excerpt_length']);?></p>
					                            </div>
					                            <?php } ?>
			                    			</div>
				                    		<?php if($settings['eael_show_meta'] && $settings['eael_post_block_meta_position'] == 'meta-entry-footer'){ ?>
				                    		<div class="eael-entry-footer">
				                    			<div class="eael-author-avatar">
				                    				<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><?php echo get_avatar( get_the_author_meta( 'ID' ), 96 ); ?> </a>
				                    			</div>
				                    			<div class="eael-entry-meta">
				                    				<div class="eael-posted-by"><?php the_author_posts_link(); ?></div>
				                    				<div class="eael-posted-on"><time datetime="<?php echo get_the_date(); ?>"><?php echo get_the_date(); ?></time></div>
				                    			</div>
				                    		</div>
					                    	<?php } ?>
			                    			<div class="eael-entry-overlay">
			                    				<i class="fa fa-long-arrow-right" aria-hidden="true"></i>
			                    				<a href="<?php echo get_permalink(); ?>"></a>
			                    			</div>
			                    		</div>

			                    	</div>
		                    	</div>
		                    </article>
		                    <?php } ?>

		                    <?php
		                    }
		                    wp_reset_postdata();
		                ?>
		            <?php
		        }
		    ?>
		    </div>
		</div>



        <?php
	}

	protected function content_template() {
		?>

		<?php
	}
}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_Eael_Post_Block() );