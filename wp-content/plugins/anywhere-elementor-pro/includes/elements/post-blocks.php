<?php

namespace Aepro;


use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Utils;
use Elementor\Plugin;
use ElementorPro\Modules\Woocommerce\Widgets\Elements;
use WP_Query;


class Aepro_Post_Blocks extends Widget_Base{
    public function get_name() {
        return 'ae-post-blocks';
    }

    public function get_title() {
        return __( 'AE - Post Blocks', 'ae-pro' );
    }

    public function get_icon() {
        return 'eicon-post-list';
    }

    public function get_categories() {
        return [ 'ae-template-elements' ];
    }

    protected function _register_controls() {
		$helper = new Helper();

		$ae_post_types = $helper->get_rule_post_types();
		$ae_post_types_options = $ae_post_types;
		$ae_post_types_options['ae_by_id'] = _x( 'Manual Selection','ae-pro' );
        $this->start_controls_section(
            'section_query',
            [
                'label' => __( 'Query', 'ae-pro' ),
            ]
        );
		$this->add_control(
            'ae_post_type',
            [
                'label'         => __('Source','ae-pro'),
                'type'          => Controls_Manager::SELECT,
                'options'       => $ae_post_types_options,
                'default' => key( $ae_post_types ),
            ]
        );

        $this->add_control(
            'template',
            [
                'label'     =>  __('Template','ae-pro'),
                'type'      =>  Controls_Manager::SELECT,
                'options'   =>  $helper->ae_block_layouts()
            ]
        );
		
		$this->add_control(
            'ae_post_ids',
            [
                'label'         => __('Post IDs','ae-pro'),
                'type'          => Controls_Manager::SELECT2,
                'multiple'    => true,
                'label_block' => true,
                'placeholder' => __( 'Enter Post ID Separated by Comma', 'ae-pro' ),
                'default' => __( '', 'ae-pro' ),
				'condition' => [
					'ae_post_type' => 'ae_by_id',
				],
            ]
        );

        $ae_taxonomy_filter_args = [
            'show_in_nav_menus' => true,
        ];

        $ae_taxonomies = get_taxonomies( $ae_taxonomy_filter_args, 'objects' );

        foreach ( $ae_taxonomies as $ae_taxonomy => $object ) {
            $this->add_control(
                $ae_taxonomy . '_ae_ids',
                [
                    'label'       => $object->label,
                    'type'        => Controls_Manager::SELECT2,
                    'multiple'    => true,
                    'label_block' => true,
                    'placeholder' => __( 'Enter ' .$object->label. ' ID Separated by Comma', 'ae-pro' ),
                    'object_type' => $ae_taxonomy,
                    'options'     => Post_Helper::instance()->get_taxonomy_terms($ae_taxonomy),
                    'condition' => [
                        'ae_post_type' => $object->object_type,
                    ],
                ]
            );
        }

        $this->add_control(
            'current_post',
            [
                'label' => __( 'Exclude Current Post', 'ae-pro' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __( 'Show', 'ae-pro' ),
                'label_off' => __( 'Hide', 'ae-pro' ),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'advanced',
            [
                'label'   => __( 'Advanced', 'ae-pro' ),
                'type'    => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'   => __( 'Order By', 'ae-pro' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'post_date',
                'options' => [
                    'post_date'  => __( 'Date', 'ae-pro' ),
                    'post_title' => __( 'Title', 'ae-pro' ),
                    'menu_order' => __( 'Menu Order', 'ae-pro' ),
                    'rand'       => __( 'Random', 'ae-pro' ),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label'   => __( 'Order', 'ae-pro' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'desc',
                'options' => [
                    'asc'  => __( 'ASC', 'ae-pro' ),
                    'desc' => __( 'DESC', 'ae-pro' ),
                ],
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label'   => __( 'Posts Count', 'ae-pro' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 6,
            ]
        );

        $this->add_control(
            'offset',
            [
                'label'   => __( 'Offset', 'ae-pro' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 0,
                'condition' => [
                    'ae_post_type!' => 'ae_by_id',
                ],
                'description' => __( 'Use this setting to skip over posts (e.g. \'2\' to skip over 2 posts).', 'ae-pro' ),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
          'section_layout',
          [
              'label' => __( 'Layout', 'ae-pro' ),
          ]
        );

        $this->add_control(
            'layout_mode',
            [
                'label' => __('Layout Mode','ae-pro'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'list'  => __('List','ae-pro'),
                    'grid'  => __('Grid', 'ae-pro')
                ],
                'default' => 'grid',
                'prefix_class' => 'ae-post-layout-'
            ]
        );

        $this->add_responsive_control(
          'columns',
          [
              'label' => __('Columns', 'ae-pro'),
              'type'  => Controls_Manager::NUMBER,
              'desktop_default' => '3',
              'tablet_default' => '2',
              'mobile_default' => '1',
              'min' => 2,
              'max' => 6,
              'condition' => [
                    'layout_mode' => 'grid'
              ],
              'selectors' => [
                  '{{WRAPPER}} .ae-post-list-item' => 'width: calc(100%/{{ value }})',
               ]
          ]
        );

        $this->add_responsive_control(
            'item_col_gap',
            [
                'label' => __('Column Gap', 'ae-pro'),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'condition' => [
                    'layout_mode' => 'grid'
                ],
                'selectors' => [
                    '{{WRAPPER}}.ae-post-layout-grid article.ae-post-list-item' => 'padding-left:{{SIZE}}{{UNIT}}; padding-right:{{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.ae-post-layout-grid .ae-pagination-wrapper' => 'padding-right:{{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .ae-pagination-wrapper' => 'padding-left:{{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'item_row_gap',
            [
                'label' => __('Row Gap', 'ae-pro'),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} article.ae-post-list-item' => 'margin-bottom:{{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();

        $this->pagination_controls();

        $this->start_controls_section(
            'layout_style',
            [
                'label' => __( 'Layout', 'ae-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'item_bg',
                'label' => __( 'Item Background', 'ae-pro' ),
                'types' => [ 'none','classic','gradient' ],
                'selector' => '{{WRAPPER}} .ae-article-inner',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'label' => __( 'Border', 'ae-pro' ),
                'selector' => '{{WRAPPER}} .ae-article-inner',
            ]
        );

        $this->add_control(
            'item_border_radius',
            [
                'label' => __( 'Border Radius', 'ae-pro' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .ae-article-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_box_shadow',
                'label' => __( 'Item Shadow', 'ae-pro' ),
                'selector' => '{{WRAPPER}} .ae-article-inner',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'pagination_style',
            [
                'label' => __( 'Pagination', 'ae-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'item_gap',
            [
                'label' => __('Item Gap','ae-pro'),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .ae-pagination-wrapper *' => 'margin-left:{{SIZE}}{{UNIT}}; margin-right:{{SIZE}}{{UNIT}};',
                ]

            ]
        );

        $this->add_responsive_control(
            'pi_padding',
            [
                'label' => __( 'Padding', 'ae-pro' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .ae-pagination-wrapper *' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'pi_color',
            [
                'label' => __('Color','ae-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ae-pagination-wrapper *' => 'color:{{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'pi_bg',
            [
                'label' => __('Backround','ae-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ae-pagination-wrapper *' => 'background-color:{{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'pi_hover_color',
            [
                'label' => __('Hover/Current Color','ae-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ae-pagination-wrapper .current' => 'color:{{VALUE}}',
                    '{{WRAPPER}} .ae-pagination-wrapper span:hover' => 'color:{{VALUE}}',
                    '{{WRAPPER}} .ae-pagination-wrapper a:hover' => 'color:{{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'pi_hover_bg',
            [
                'label' => __('Hover/Current Background','ae-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ae-pagination-wrapper .current' => 'background-color:{{VALUE}}',
                    '{{WRAPPER}} .ae-pagination-wrapper span:hover' => 'background-color:{{VALUE}}',
                    '{{WRAPPER}} .ae-pagination-wrapper a:hover' => 'background-color:{{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'pi_border',
                'label' => __( 'Border', 'ae-pro' ),
                'selector' => '{{WRAPPER}} .ae-pagination-wrapper *',
            ]
        );

        $this->add_control(
            'pi_border_hover_color',
            [
                'label' => __('Border Hover Color','ae-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ae-pagination-wrapper *:hover' => 'border-color: {{VALUE}}'
                ],
                'condition' => [
                    'pi_border_border!' => ''
                ]
            ]
        );

        $this->add_control(
            'pi_border_radius',
            [
                'label' => __( 'Border Radius', 'ae-pro' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .ae-pagination-wrapper *' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'overlay_style',
            [
                'label' => __( 'Loading Overlay', 'ae-pro' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'overlay_color',
                'label' => __( 'Color', 'elementor' ),
                'types' => [ 'none', 'classic','gradient' ],
                'selector' => '{{WRAPPER}} .ae-post-overlay',
            ]
        );


        $this->end_controls_section();


    }

    protected function render() {
        $settings = $this->get_settings();
        if(!isset($settings['template']) || empty($settings['template'])){
            echo __('Please select a template first','ae-pro');
        }else{
            $this->generate_output($settings);
        }

    }

    function generate_output($settings,$with_wrapper = true){

        $helper = new Helper();
        $post_type = $settings['ae_post_type'];

        $ae_post_ids = $settings['ae_post_ids'];

        if(isset($_POST['pid'])){
            $current_post_id = $_POST['pid'];
        }else{
            $current_post_id = get_the_ID();
        }

        $base_url = get_permalink($current_post_id);

        $query_args = [
            'orderby' => $settings['orderby'],
            'order' => $settings['order'],
            'ignore_sticky_posts' => 1,
            'post_status' => 'publish', // Hide drafts/private posts for admins
        ];

        if ( 'ae_by_id' === $post_type ) {
            $query_args['post_type'] = 'any';
            $query_args['post__in']  = $ae_post_ids;

            if ( empty( $query_args['post__in'] ) ) {
                // If no selection - return an empty query
                $query_args['post__in'] = [ -1 ];
            }
        }else{
            $query_args['post_type'] = $post_type;
            $query_args['offset'] = $settings['offset'];
            $query_args['posts_per_page'] = $settings['posts_per_page'];
            $query_args['tax_query'] = [];

            if(is_singular() && ($settings['current_post']=='yes')){
                $query_args['post__not_in'] = array($current_post_id);
            }
            $taxonomies = get_object_taxonomies( $post_type, 'objects' );
            foreach ( $taxonomies as $object ) {
                $setting_key = $object->name . '_ae_ids';

                if ( ! empty( $settings[ $setting_key ] ) ) {
                    $query_args['tax_query'][] = [
                        'taxonomy' => $object->name,
                        'field'    => 'term_id',
                        'terms'    => $settings[ $setting_key ],
                    ];
                }
            }
        }

        if(isset($_POST['page_num'])){
            $query_args['offset'] = ($query_args['posts_per_page'] * ($_POST['page_num']-1)) + $query_args['offset'];
        }
        
        $post_items = new WP_Query( $query_args );


        $this->add_render_attribute( 'post-list-wrapper', 'class', 'ae-post-list-wrapper' );

        $this->add_render_attribute( 'post-widget-wrapper', 'data-pid', get_the_ID() );
        $this->add_render_attribute( 'post-widget-wrapper', 'data-wid', $this->get_id() );
        $this->add_render_attribute( 'post-widget-wrapper', 'class', 'ae-post-widget-wrapper' );

        $this->add_render_attribute( 'post-list-item', 'class', 'ae-post-list-item' );

        $with_css = false;
        if ( is_customize_preview() || Utils::is_ajax() ) {
            $with_css = true;
        }

        ?>
        <div class="ae-post-overlay"></div>
        <?php if($with_wrapper){ ?>
        <div <?php echo $this->get_render_attribute_string('post-widget-wrapper'); ?>>
        <?php } ?>
            <div <?php echo $this->get_render_attribute_string('post-list-wrapper'); ?>>
                <?php while($post_items->have_posts()){
                    $post_items->the_post();
                    ?>
                    <article <?php echo $this->get_render_attribute_string('post-list-item'); ?>>
                        <div class="ae-article-inner">
                            <?php //echo Frontend::instance()->render_insert_elementor($settings['template'],$with_css); ?>
                            <div class="ae_data elementor elementor-<?php echo $settings['template']; ?>">
                                <?php echo Plugin::instance()->frontend->get_builder_content( $settings['template'],$with_css ); ?>
                            </div>
                        </div>
                    </article>
                <?php }
                wp_reset_postdata(); ?>
            </div>

            <?php if($settings['show_pagination'] == 'yes'){
                $this->add_render_attribute('pagination-wrapper','class','ae-pagination-wrapper');
                ?>
                <div <?php echo $this->get_render_attribute_string('pagination-wrapper'); ?>>
                    <?php
                    $current = 1;
                    if(isset($_POST['page_num'])){
                        $current = $_POST['page_num'];
                    }
                    $paginate_args = [
                        'base'  => $base_url.'%_%',
                        'total' => $post_items->max_num_pages,
                        'current' => $current
                    ];

                    if($settings['show_prev_next'] == 'yes'){
                        $paginate_args['prev_next'] = true;
                        $paginate_args['prev_text'] = $settings['prev_text'];
                        $paginate_args['next_text'] = $settings['next_text'];
                    }else{
                        $paginate_args['prev_next'] = false;
                    }

                    echo paginate_links($paginate_args);
                    ?>
                </div>
            <?php } ?>

        <?php if($with_wrapper){ ?>
        </div>
        <?php } ?>

        <?php
    }

    function pagination_controls(){

        $this->start_controls_section(
            'pagination_contols',
            [
                'label' => __( 'Pagination', 'ae-pro' )
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label' => __('Show Pagination','ae-pro'),
                'type'  => Controls_Manager::SELECT,
                'options' => [
                    'yes' =>   __( 'Yes', 'ae-pro' ),
                    'no'  =>   __( 'No', 'ae-pro' )
                ],
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'show_prev_next',
            [
                'label' => __('Show Prev/Next','ae-pro'),
                'type'  => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __( 'Show', 'ae-pro' ),
                'label_off' => __( 'Hide', 'ae-pro' ),
                'return_value' => 'yes',
                'condition' => [
                    'show_pagination' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'prev_text',
            [
                'label' => __('Previous Text','ae-pro'),
                'type'  => Controls_Manager::TEXT,
                'default' => __('&laquo; Previous','ae-pro'),
                'condition' => [
                    'show_pagination' => 'yes',
                    'show_prev_next' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'next_text',
            [
                'label' => __('Previous Text','ae-pro'),
                'type'  => Controls_Manager::TEXT,
                'default' => __('Next &raquo;','ae-pro'),
                'condition' => [
                    'show_pagination' => 'yes',
                    'show_prev_next' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'pagination_align',
            [
                'label' => __( 'Alignment', 'ae-pro' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'ae-pro' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'ae-pro' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'ae-pro' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => '',
                'condition' => [
                    'show_pagination' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} .ae-pagination-wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_section();
    }
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Aepro_Post_Blocks() );