<?php
namespace Aepro;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Aepro_Custom_Field extends Widget_Base {

	public function get_name() {
		return 'ae-custom-field';
	}

	public function get_title() {
		return __( 'AE - Custom Field', 'ae-pro' );
	}

	public function get_icon() {
		return 'eicon-type-tool';
	}

	public function get_categories() {
        return [ 'ae-template-elements' ];
    }

	protected function _register_controls() {
		$this->start_controls_section(
			'section_title',
			[
				'label' => __( 'Custom Field', 'ae-pro' ),
			]
		);

		$this->add_control(
				'custom-field',
				[
						'label' => __( 'Name', 'ae-pro' ),
						'type' => Controls_Manager::TEXT,
						'placeholder' => __( 'Enter your custom field name', 'ae-pro' ),
						'default' => __( 'my_key', 'ae-pro' ),
				]
		);

		$this->add_control(
			'cf_type',
			[
				'label' => __( 'Type', 'ae-pro' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'text' => __( 'Default', 'ae-pro' ),
					'html' => __( 'Html', 'ae-pro' ),
					'link' => __( 'Link', 'ae-pro' ),
					'image' => __( 'Image', 'ae-pro' ),
					'video' => __( 'Video', 'ae-pro' ),
					'audio' => __( 'Audio', 'ae-pro' ),
					'oembed' => __( 'oEmbed', 'ae-pro' ),
				],
				'default' => 'text'
			]
		);

		if(class_exists('acf')){
			$this->add_control(
					'acf_support',
					[
							'label'	=> __('ACF Formatting','ae-pro'),
							'type'	=> Controls_Manager::SWITCHER,
							'label_off' => __( 'No', 'ae-pro' ),
							'label_on' => __( 'Yes', 'ae-pro' ),
							'condition' => [
									'cf_type' => ['text','link']
							],

					]
			);
		}


		$this->add_control(
			'cf_video_type',
			[
				'label' => __( 'Video Type', 'ae-pro' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'youtube' => __( 'Youtube Video', 'ae-pro' ),
					'vimeo' => __( 'Vimeo Video', 'ae-pro' ),
				],
				'default' => 'youtube',
				'condition' => [
					'cf_type' => 'video',
				]
			]
		);

		$this->add_control(
				'aspect_ratio',
				[
						'label' => __( 'Aspect Ratio', 'ae-pro' ),
						'type' => Controls_Manager::SELECT,
					'frontend_available' => true,
						'options' => [
								'169' => '16:9',
								'43' => '4:3',
								'32' => '3:2',
						],
						'default' => '169',
						'condition' => [
							'cf_type' => 'video',
						]
				]
		);

		$this->youtube_video_options();
		$this->vimeo_video_options();

		$this->add_control(
			'cf_link_text',
			[
				'label' => __( 'Link Text', 'ae-pro' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter Link Text', 'ae-pro' ),
				'default' => __( '', 'ae-pro' ),
				'condition' => [
					'cf_type' => 'link',
				]
			]
		);

		$this->add_control(
				'cf_link_target',
				[
					'label' => __('Open in new tab','ae-pro'),
					'type'  => Controls_Manager::SWITCHER,
					'label_off' => __( 'No', 'ae-pro' ),
					'label_on' => __( 'Yes', 'ae-pro' ),
					'condition' => [
							'cf_type' => 'link',
					]
				]
		);

		$this->add_control(
			'cf_label',
			[
				'label' => __( 'Label', 'ae-pro' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter Label', 'ae-pro' ),
				'default' => __( '', 'ae-pro' ),
				'condition' => [
					'cf_type' => ['text','link'],
				]
			]
		);

		$this->add_control(
			'cf_icon',
			[
				'label' => __( 'Icon', 'ae-pro' ),
				'type' => Controls_Manager::ICON,
				'label_block' => true,
				'default' => '',
				'condition' => [
					'cf_type' => ['text','link'],
				]
			]
		);

		$this->add_control(
			'header_size',
			[
				'label' => __( 'HTML Tag', 'ae-pro' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => __( 'H1', 'ae-pro' ),
					'h2' => __( 'H2', 'ae-pro' ),
					'h3' => __( 'H3', 'ae-pro' ),
					'h4' => __( 'H4', 'ae-pro' ),
					'h5' => __( 'H5', 'ae-pro' ),
					'h6' => __( 'H6', 'ae-pro' ),
					'div' => __( 'div', 'ae-pro' ),
					'span' => __( 'span', 'ae-pro' ),
					'p' => __( 'p', 'ae-pro' ),
				],
				'default' => 'h3',
				'condition' => [
					'cf_type' => 'text',
				]
			]
		);

		$this->add_responsive_control(
			'align',
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
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
				'condition'=> [
					'cf_type!'=>'video',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'image', // Actually its `image_size`
				'label' => __( 'Image Size', 'ae-pro' ),
				'default' => 'large',
				'exclude' => [ 'custom' ],
				'condition' => [
					'cf_type' => 'image',
				]

			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_custom_field_style',
			[
				'label' => __( 'Custom Field', 'ae-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition'=> [
					'cf_type!'=>'video',
				]

			]
		);

		$this->add_control(
			'custom_field_color',
			[
				'label' => __( 'Color', 'ae-pro' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
				    'type' => Scheme_Color::get_type(),
				    'value' => Scheme_Color::COLOR_4,
				],
				'selectors' => [
					'{{WRAPPER}} .ae-element-custom-field' => 'color: {{VALUE}};',
				],
				'condition' => [
					'cf_type' => ['text','html','link'],
				],
			]
		);

		$this->add_control(
			'cf_hover_color',
			[
				'label' => __( 'Text Hover Color', 'ae-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ae-element-custom-field:hover' => 'color: {{VALUE}};',
				],
				'condition' => [
						'cf_type' => ['text','link'],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .ae-element-custom-field',
				'condition' => [
						'cf_type' => ['text','link'],
				],
			]
		);

		$this->add_control(
			'icon_settings',
			[
				'label' => __( 'Icon Settings', 'ae-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
						'cf_icon!' => '',
						'cf_type' => ['text','link'],
				]
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => __( 'Icon Color', 'ae-pro' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .icon-wrapper i' => 'color: {{VALUE}};',
				],
				'condition' => [
					'cf_icon!' => '',
					'cf_type' => ['text','link'],
				]
			]
		);

		$this->add_control(
			'icon_hover_color',
			[
				'label' => __( 'Icon Hover Color', 'ae-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .icon-wrapper i:hover' => 'color: {{VALUE}};',
				],
				'condition' => [
					'cf_icon!' => '',
					'cf_type' => ['text','link'],
				]
			]
		);

		$this->add_control(
			'icon_spacing',
			[
				'label' => __( 'Icon Spacing', 'ae-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .icon-wrapper i' => 'padding-right: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'cf_icon!' => '',
					'cf_type' => ['text','link'],
				]
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label' => __( 'Icon Size', 'ae-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .icon-wrapper i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'cf_icon!' => '',
					'cf_type' => ['text','link'],
				]
			]
		);

		$this->add_control(
			'cf_label_settings',
			[
				'label' => __( 'Label Settings', 'ae-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
						'cf_label!' => '',
						'cf_type' => ['text','link'],
				]
			]
		);

		$this->add_control(
			'cf_label_color',
			[
				'label' => __( 'Label Color', 'ae-pro' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'selectors' => [
					'{{WRAPPER}} .ae-element-custom-field-label' => 'color: {{VALUE}};',
				],
				'condition' => [
						'cf_label!' => '',
						'cf_type' => ['text','link'],
				]

			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'cf_label_typography',
				'label' => __( 'Label Typography', 'ae-pro' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .ae-element-custom-field-label',
				'condition' => [
						'cf_label!' => '',
						'cf_type' => ['text','link'],
				]
			]
		);

		$this->add_control(
			'cf_spacing',
			[
				'label' => __( 'Label Spacing', 'ae-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ae-element-custom-field-label' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
						'cf_type' => ['text','link'],
				]
			]
		);

		$this->add_control(
				'cf_space',
				[
						'label' => __( 'Size (%)', 'ae-pro' ),
						'type' => Controls_Manager::SLIDER,
						'default' => [
								'size' => 100,
								'unit' => '%',
						],
						'size_units' => [ '%' ],
						'range' => [
								'%' => [
										'min' => 1,
										'max' => 100,
								],
						],
						'selectors' => [
								'{{WRAPPER}} .ae-element-custom-field img' => 'max-width: {{SIZE}}{{UNIT}};',
						],
						'condition' => [
								'cf_type' => 'image',
						]
				]
		);


		$this->add_control(
				'cf_opacity',
				[
						'label' => __( 'Opacity (%)', 'ae-pro' ),
						'type' => Controls_Manager::SLIDER,
						'default' => [
								'size' => 1,
						],
						'range' => [
								'px' => [
										'max' => 1,
										'min' => 0.10,
										'step' => 0.01,
								],
						],
						'selectors' => [
								'{{WRAPPER}} .ae-element-custom-field img' => 'opacity: {{SIZE}};',
						],
						'condition' => [
								'cf_type' => 'image',
						]
				]
		);

		$this->add_control(
			'cf_bg',
			[
				'label' => __( 'Background Color', 'ae-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ae-element-custom-field' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'cf_type!' => 'video',
				]
			]
		);

		$this->add_group_control(
				Group_Control_Border::get_type(),
				[
						'name' => 'border',
						'label' => __( 'Border', 'ae-pro' ),
						'selector' => '{{WRAPPER}} .ae-element-custom-field',
						'condition' => [
								'cf_type!' => 'video',
						]
				]
		);

		$this->add_control(
				'image_border_radius',
				[
						'label' => __( 'Border Radius', 'ae-pro' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%' ],
						'selectors' => [
								'{{WRAPPER}} .ae-element-custom-field' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
						'condition' => [
								'cf_type!' => 'video',
						]
				]
		);
		$this->add_control(
			'cf_text_padding',
			[
				'label' => __( 'Padding', 'ae-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ae-element-custom-field' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'cf_type!' => 'video',
				]
			]
		);

		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings();
		if(!isset($settings['cf_type']) || $settings['cf_type'] == ''){
			$settings['cf_type'] = 'text';
		}

		$helper = new Helper();
		$post_data = $helper->get_demo_post_data();
		$post_id = $post_data->ID;

		$custom_field = $settings['custom-field'];

		if(class_exists('acf') && in_array($settings['cf_type'],['text','link']) && $settings['acf_support'] == 'yes'){
			$custom_field_val = get_field($custom_field,$post_id);
		}else{
			$custom_field_val = get_post_meta($post_id,$custom_field,true);
		}


		$this->add_render_attribute( 'cf-wrapper','class','cf-type-'.$settings['cf_type'] );
		$this->add_render_attribute( 'custom-field-class', 'class', 'ae-element-custom-field' );
		$this->add_render_attribute( 'custom-field-label-class', 'class', 'ae-element-custom-field-label' );
		$this->add_render_attribute( 'post-cf-icon-class','class','icon-wrapper' );
		$this->add_render_attribute( 'post-cf-icon-class','class','ae-element-custom-field-icon' );
		$this->add_render_attribute( 'post-cf-icon','class',$settings['cf_icon'] );

		if($settings['cf_link_target'] == 'yes'){
			$this->add_render_attribute( 'custom-field-class', 'target', '_blank' );
		}

		$cf_type = $settings['cf_type'];
		$eid = $this->get_id();
		switch ($cf_type) {

			case "html": 	if(!empty($custom_field_val)){
								$custom_field_html = '<div '.$this->get_render_attribute_string( 'custom-field-class' ).'>'.wpautop(do_shortcode($custom_field_val)).'</div>';
							}
							break;

			case "link":	if(!empty($settings['cf_link_text'])){
								$custom_field_html = '<a '.$this->get_render_attribute_string( 'custom-field-class' ).'  href="'.$custom_field_val.'">'.$settings['cf_link_text'].'</a>';
							}else{
								$custom_field_html = '<a '.$this->get_render_attribute_string( 'custom-field-class' ).' href="'.$custom_field_val.'">'.$custom_field_val.'</a>';
							}
							break;

			case "image":	$post_image_size = $settings['image_size'];
							
							if(is_numeric($custom_field_val)){
								$custom_field_html =  '<div '.$this->get_render_attribute_string( 'custom-field-class' ).'>'.wp_get_attachment_image( $custom_field_val, $post_image_size ).'</div>';
							}else{
								$custom_field_html =  '<div '.$this->get_render_attribute_string( 'custom-field-class' ).'><img src="'.$custom_field_val.'" /></div>';
							}

							break;

			case "video":  add_filter( 'oembed_result', [ $this, 'ae_filter_oembed_result' ], 50, 3 );

						   $custom_field_html = wp_oembed_get( $custom_field_val, wp_embed_defaults() );
						   $custom_field_html .= "<script type='text/javascript'>
												     jQuery(document).ready(function(){
												     	jQuery(document).trigger('elementor/render/cf-video',['".$eid."','".$settings['aspect_ratio']."']);
												     });
												     jQuery(window).resize(function(){
    													jQuery(document).trigger('elementor/render/cf-video',['".$eid."','".$settings['aspect_ratio']."']);
													 });
												     jQuery(document).trigger('elementor/render/cf-video',['".$eid."','".$settings['aspect_ratio']."']);
												     </script>";
						   remove_filter( 'oembed_result', [ $this, 'ae_filter_oembed_result' ], 50 );
						   break;

			case "audio": $custom_field_html = wp_audio_shortcode([
													'src' => $custom_field_val
												]);
						   break;

			case "oembed": $custom_field_html = wp_oembed_get( $custom_field_val, wp_embed_defaults() );
				           break;

			default:	//echo $custom_field_val;
						$custom_field_html = sprintf( '<%1$s %2$s>%3$s</%1$s>', $settings['header_size'], $this->get_render_attribute_string( 'custom-field-class' ), $custom_field_val );
						break;
		}?>

		<div <?php echo $this->get_render_attribute_string('cf-wrapper');?>>
            <?php if(($settings['cf_type']=='text') || ($settings['cf_type']=='link')){ ?>

                <?php if(!empty($settings['cf_icon']) && !empty($custom_field_val)){ ?>
                    <span <?php echo $this->get_render_attribute_string( 'post-cf-icon-class' ); ?>>
					<i <?php echo $this->get_render_attribute_string( 'post-cf-icon' ); ?>></i>
				</span>
                <?php }

                if(!empty($settings['cf_label']) && !empty($custom_field_val)){ ?>
                    <span <?php echo $this->get_render_attribute_string('custom-field-label-class');?>>
					<?php echo $settings['cf_label'];?>
				</span>
                <?php }

            }
            echo $custom_field_html;?>
        </div>
    <?php
	}

	public function ae_filter_oembed_result($html){
		$settings = $this->get_settings();

		$params = [];

		if ( 'youtube' === $settings['cf_video_type'] ) {
			$youtube_options = [ 'autoplay', 'rel', 'controls', 'showinfo' ];

			foreach ( $youtube_options as $option ) {
				//if ( 'autoplay' === $option && $this->has_image_overlay() )
				//	continue;

				$value = ( 'yes' === $settings[ 'cf_yt_' . $option ] ) ? '1' : '0';
				$params[ $option ] = $value;
			}

			$params['wmode'] = 'opaque';
		}

		if ( 'vimeo' === $settings['cf_video_type'] ) {
			$vimeo_options = [ 'autoplay', 'loop', 'title', 'portrait', 'byline' ];

			foreach ( $vimeo_options as $option ) {
				//if ( 'autoplay' === $option && $this->has_image_overlay() )
				//	continue;

				$value = ( 'yes' === $settings[ 'vimeo_' . $option ] ) ? '1' : '0';
				$params[ $option ] = $value;
			}

			$params['color'] = str_replace( '#', '', $settings['vimeo_color'] );

		}

		if ( ! empty( $params ) ) {
			preg_match( '/<iframe.*src=\"(.*)\".*><\/iframe>/isU', $html, $matches );
			$url = esc_url( add_query_arg( $params, $matches[1] ) );

			$html = str_replace( $matches[1], $url, $html );
		}

		return $html;
	}

	public function youtube_video_options(){
		$this->add_control(
				'heading_youtube',
				[
						'label' => __( 'Youtube Video Options', 'ae-pro' ),
						'type' => Controls_Manager::HEADING,
						'separator' => 'before',
						'condition' => [
								'cf_type' => 'video',
								'cf_video_type' => 'youtube',
						],
				]
		);

		// YouTube
		$this->add_control(
				'cf_yt_autoplay',
				[
						'label' => __( 'Autoplay', 'ae-pro' ),
						'type' => Controls_Manager::SWITCHER,
						'label_off' => __( 'No', 'ae-pro' ),
						'label_on' => __( 'Yes', 'ae-pro' ),
						'condition' => [
								'cf_type' => 'video',
								'cf_video_type' => 'youtube',
						],
				]
		);

		$this->add_control(
				'cf_yt_rel',
				[
						'label' => __( 'Suggested Videos', 'ae-pro' ),
						'type' => Controls_Manager::SWITCHER,
						'label_off' => __( 'Hide', 'ae-pro' ),
						'label_on' => __( 'Show', 'ae-pro' ),
						'condition' => [
								'cf_type' => 'video',
								'cf_video_type' => 'youtube',
						],
				]
		);

		$this->add_control(
				'cf_yt_controls',
				[
						'label' => __( 'Player Control', 'ae-pro' ),
						'type' => Controls_Manager::SWITCHER,
						'label_off' => __( 'Hide', 'ae-pro' ),
						'label_on' => __( 'Show', 'ae-pro' ),
						'default' => 'yes',
						'condition' => [
								'cf_type' => 'video',
								'cf_video_type' => 'youtube',
						],
				]
		);

		$this->add_control(
				'cf_yt_showinfo',
				[
						'label' => __( 'Player Title & Actions', 'ae-pro' ),
						'type' => Controls_Manager::SWITCHER,
						'label_off' => __( 'Hide', 'ae-pro' ),
						'label_on' => __( 'Show', 'ae-pro' ),
						'default' => 'yes',
						'condition' => [
								'cf_type' => 'video',
								'cf_video_type' => 'youtube',
						],
				]
		);
	}
	public function vimeo_video_options(){
		$this->add_control(
				'heading_vimeo',
				[
						'label' => __( 'Vimeo Video Options', 'ae-pro' ),
						'type' => Controls_Manager::HEADING,
						'separator' => 'before',
						'condition' => [
								'cf_type' => 'video',
								'cf_video_type' => 'vimeo',
						],
				]
		);

		// Vimeo
		$this->add_control(
				'vimeo_autoplay',
				[
						'label' => __( 'Autoplay', 'ae-pro' ),
						'type' => Controls_Manager::SWITCHER,
						'label_off' => __( 'No', 'ae-pro' ),
						'label_on' => __( 'Yes', 'ae-pro' ),
						'condition' => [
								'cf_type' => 'video',
								'cf_video_type' => 'vimeo',
						],
				]
		);

		$this->add_control(
				'vimeo_loop',
				[
						'label' => __( 'Loop', 'ae-pro' ),
						'type' => Controls_Manager::SWITCHER,
						'label_off' => __( 'No', 'ae-pro' ),
						'label_on' => __( 'Yes', 'ae-pro' ),
						'condition' => [
								'cf_type' => 'video',
								'cf_video_type' => 'vimeo',
						],
				]
		);

		$this->add_control(
				'vimeo_title',
				[
						'label' => __( 'Intro Title', 'ae-pro' ),
						'type' => Controls_Manager::SWITCHER,
						'label_off' => __( 'Hide', 'ae-pro' ),
						'label_on' => __( 'Show', 'ae-pro' ),
						'default' => 'yes',
						'condition' => [
								'cf_type' => 'video',
								'cf_video_type' => 'vimeo',
						],
				]
		);

		$this->add_control(
				'vimeo_portrait',
				[
						'label' => __( 'Intro Portrait', 'ae-pro' ),
						'type' => Controls_Manager::SWITCHER,
						'label_off' => __( 'Hide', 'ae-pro' ),
						'label_on' => __( 'Show', 'ae-pro' ),
						'default' => 'yes',
						'condition' => [
								'cf_type' => 'video',
								'cf_video_type' => 'vimeo',
						],
				]
		);

		$this->add_control(
				'vimeo_byline',
				[
						'label' => __( 'Intro Byline', 'ae-pro' ),
						'type' => Controls_Manager::SWITCHER,
						'label_off' => __( 'Hide', 'ae-pro' ),
						'label_on' => __( 'Show', 'ae-pro' ),
						'default' => 'yes',
						'condition' => [
								'cf_type' => 'video',
								'cf_video_type' => 'vimeo',
						],
				]
		);

		$this->add_control(
				'vimeo_color',
				[
						'label' => __( 'Controls Color', 'ae-pro' ),
						'type' => Controls_Manager::COLOR,
						'scheme' => [
							'type' => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_4,
						],
						'condition' => [
								'cf_type' => 'video',
								'cf_video_type' => 'vimeo',
						],
				]
		);
	}
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Aepro_Custom_Field() );