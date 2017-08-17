        <div class="pos-demo-wrap">
		<h2 class="pos-demo-title">Theme Options</h2>
		<div class="pos-demo-option">
			<div class="cl-wrapper">
				<div class="cl-container">
					<div class="cl-table">
						<div class="cl-tr cl-tr-style">
							<div class="cl-td-l cl-td-layout cl-td-layout1"><a href="#" id="red_green" title=""><span class="cl2"></span><span class="cl1"></span>Red Green</a></div>
							<div class="cl-td-l cl-td-layout cl-td-layout2"><a href="#" id="blue_red" title=""><span class="cl2"></span><span class="cl1"></span>Blue Red</a></div>
						</div>
						<div class="cl-tr cl-tr-style">
							<div class="cl-td-l cl-td-layout cl-td-layout3"><a href="#" id="orange_green" title=""><span class="cl2"></span><span class="cl1"></span>Orange Green</a></div>
							<div class="cl-td-l cl-td-layout cl-td-layout4"><a href="#" id="orange_red" title=""><span class="cl2"></span><span class="cl1"></span>Orange Red</a></div>
						</div>
						<div class="cl-tr cl-tr-style">
							<div class="cl-td-l cl-td-layout cl-td-layout5"><a href="#" id="red_lightseagreen" title=""><span class="cl2"></span><span class="cl1"></span>Red Lightseagreen</a></div>
							<div class="cl-td-l cl-td-layout cl-td-layout6"><a href="#" id="teal_brown" title=""><span class="cl2"></span><span class="cl1"></span>Teal Brown</a></div>
						</div>

                        <div class="cl-tr cl-tr-main">
                            <div class="cl-td-l">Background Color:</div>
                            <div class="cl-td-r">
                                <div id="bodyBackgroundColor" class="colorSelector cl-tool">
                                    <div style="background-color: #0000ff"></div>
                                </div>
                            </div>
                        </div>
                        <div class="cl-tr cl-tr-main">
                            <div class="cl-td-l">Main Color:</div>
                            <div class="cl-td-r">
                                <div id="mainColor" class="colorSelector cl-tool">
                                    <div style="background-color: #ff0000"></div>
                                </div>
                            </div>
                        </div>
                        <div class="cl-tr cl-tr-main">
                            <div class="cl-td-l">Link Color:</div>
                            <div class="cl-td-r">
                                <div id="linkColor" class="colorSelector cl-tool">
                                    <div style="background-color: #aa0000"></div>
                                </div>
                            </div>
                        </div>

                        <div class="cl-tr">
                            <div class="cl-td-l">Background Image:</div>
                            <div class="cl-td-bg">
                                <div class="cl-pattern">
                                  <?php for ($id = 1; $id <= 30; $id++) { ?>
                                        <div class="cl-image pattern<?php echo $id;?>" id="pattern<?php echo $id; ?>"></div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="cl-tr cl-row-reset">
                            <span class="cl-reset"></span>
                        </div>
					</div>
                </div>
			</div>
		</div>
		<div class="control inactive"><a href="javascript:void(0)"></a></div>
		<script type="text/javascript">
			$(document).ready( function(){
			
				if ($.cookie('bodyBackgroundColor_cookie')!=''){
					$("#content").css('background-color','#'+$.cookie('bodyBackgroundColor_cookie'));
				}
				if ($.cookie('mainColor_cookie')!=''){
					$(".box").css('background-color','#'+ $.cookie('mainColor_cookie'));
				}
				if ($.cookie('backgroundimage_cookie')!=''){
				   $("#container").css('background-image','url("'+$.cookie('backgroundimage_cookie')+'")');
				}

				$('.control').click(function(){
					if($(this).hasClass('inactive')) {
						$(this).removeClass('inactive');
						$(this).addClass('active');
						$('.pos-demo-wrap').animate({left:'0'}, 500);
					} else {
						$(this).addClass('inactive');
						$('.pos-demo-wrap').animate({left:'-228px'}, 500);
					}
				});
				var date = new Date();
				date.setTime(date.getTime() + (1440 * 60 * 1000));
			   <?php for ($id = 1; $id <= 30; $id++) { ?>
				$('#pattern<?php echo $id;?>').click(function(){
				       $("#container").css('background-image','url("<?php echo $layout_url; ?>stylesheet/opentheme/themeoption/colortool/images/pattern/pattern<?php echo $id; ?>.png")');
						$.cookie('backgroundimage_cookie', '<?php echo $layout_url; ?>stylesheet/opentheme/themeoption/colortool/images/pattern/pattern<?php echo $id; ?>.png' , { expires: date });
						 $.cookie('id','<?php echo $id; ?>');
				});
				 <?php } ?>
				
				 $('#bodyBackgroundColor,#mainColor, #linkColor').each(function() {
						var $el = $(this);
						/* set time */
						var date = new Date();
						date.setTime(date.getTime() + (1440 * 60 * 1000));
						$el.ColorPicker({
							color: '#0000ff',
							onChange: function (hsb, hex, rgb) {
								$el.find('div').css('backgroundColor', '#' + hex);
								switch ($el.attr("id")) {
									// main color
								  case 'mainColor' :
									$(".box").css('background-color', '#' + hex);
									// set cookie
									$.cookie('mainColor_cookie', hex , { expires: date });
									break;
									case 'bodyBackgroundColor' :
										$("#content").css('background-color', '#' + hex);
										$.cookie('bodyBackgroundColor_cookie', hex , { expires: date });
									case 'linkColor' :
									$("a").css('background-color', '#' + hex);
									// set cookie
									$.cookie('linkColor_cookie', hex , { expires: date });
									break;	
								}
							}
						});
					});

					$('<link rel="stylesheet" type="text/css" href="'+$.cookie('theme_color_cookie')+'" />').appendTo('head');
					$('.cl-td-layout a').click(function(){
						$('<link rel="stylesheet" type="text/css" href="<?php echo $layout_url;?>stylesheet/global_'+this.id+'.css" />').appendTo('head');
						$.cookie('theme_color_cookie', '<?php echo $layout_url;?>stylesheet/global_'+this.id+'.css', { expires: date });
					});
					
					//reset button
					$('.cl-reset').click(function(){
						$.cookie('font_cookie','');
						$.cookie('bodyBackgroundColor_cookie','');
						$.cookie('link_color_cookie','');
						$.cookie('mainColor_cookie','');
						$.cookie('backgroundimage_cookie','');
						$("#container").css('background-image', '');
					   //reset main
						$(".box").css('background-color', '<?php echo $color_main;?>');
						//reset background
						$("#content").css('background-color', '<?php echo $color_bg;?>');
						$("a").css('color', '<?php echo $color_link;?>');
					});

					
				
			});
		</script>
		
		     <style type="text/css">

					<?php if(isset($color_main) && $color_main !='') { ?>
					   .box {
						   background-color:<?php echo $color_main; ?> ;
					   }
					<?php } ?>

					<?php if(isset($color_bg) && $color_bg !='') { ?>
					#content{
					   background-color: <?php echo $color_bg; ?>
					   };
					<?php } ?>

					<?php if(isset($color_link) && $color_link !='') { ?>
					a{
					   color: <?php echo $color_link; ?>
					   };
					<?php } ?>
							   
            </style>
	   
	</div>



