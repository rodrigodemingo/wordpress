<div class="banner7 col-sms12 col-md-6 col-sm-12">
<div class= "oc-banner7-container">
	<div class="flexslider oc-nivoslider">
        <div class="oc-loading"></div>
		<div id="oc-inivoslider" class="slides">
			<?php
				$slides = $data['ocslideshows']; 
				$config = $slide_setting[0]; 
				$i = 1;
				foreach($slides as $s) {
			?>
				<img style="display: none;" src="<?php echo $s['image']; ?>" alt="#banner7-caption<?php echo $i; ?>" title="#banner7-caption<?php echo $i; ?>"/>
			<?php 		
				$i ++;				
				} 
			?>
		</div>
	<?php
	$i = 1;
	foreach($slides as $s) {
		$class ="";
		if($s['type']==1){ $class = "slider-1"; }
		if($s['type']==2){ $class = "slider-2"; }
		if($s['type']==3){ $class = "slider-3"; }
	?>
		<div id="banner7-caption<?php echo $i; ?>" class="banner7-caption nivo-html-caption nivo-caption">
			<div class="timeloading"></div>
			<div class="banner7-content <?php echo $class; ?>  hidden-xs">
				<div class="text-content">
					<?php if($s['title']): ?>
					<h1 class="title1"><span><?php echo $s['title']; ?></span></h1>
					<?php endif; ?>
					<h2 class="sub-title"><span><?php echo $s['sub_title']; ?></span></h2>
					<div class="banner7-des">
						<?php echo $s['description']; ?>
					</div>
					<?php if( $s['link'] ) { ?>
						<div class="banner7-readmore">
							<a href="<?php echo $s['link']?>" title="<?php echo 'shopping now' ?>"><?php echo 'shopping now'; ?></a>	
						</div>
					<?php } ?>
				</div>
				<!--<img class="img1" src="<?php echo $s['small_image']; ?>" alt="#banner7-caption<?php echo $i; ?>" />-->
			</div>
			
		</div>
	<?php
	$i++;
	}
	?>
<script type="text/javascript">
	$(window).load(function() {
		$('#oc-inivoslider').nivoSlider({
			effect: '<?php if($config['effect']) { echo $config['effect'];} else { echo 'random'; } ?>',
			slices: 15,
			boxCols: 8,
			boxRows: 4,
			animSpeed:500,
			pauseTime: '<?php  if($config['delay']) { echo $config['delay']; } else { echo 3000;} ?>',
			startSlide: 0,
			controlNav: false,
			directionNav:  <?php  if(isset($config['nextback'])&& $config['nextback'] == 1) { echo 'true' ; } else { echo 'false';} ?>,
			controlNavThumbs: false,
			pauseOnHover:  <?php  if(isset($config['hover'])&& $config['hover'] == 1) { echo 'true' ; } else { echo 'false';} ?>,
			manualAdvance: false,
			prevText: 'Prev',
			nextText: 'Next',
			afterLoad: function(){
				$('.oc-loading').css("display","none");
				},     
			beforeChange: function(){ 
				$('.banner7-title, .banner7-des').css("left","-550px" );
				$('.banner7-readmore').css("left","-1500px"); 
			}, 
			afterChange: function(){ 
				$('.banner7-title, .banner7-des, .banner7-readmore').css("left","100px") 
			}
		});
	});
</script>
	</div>
</div>
</div>