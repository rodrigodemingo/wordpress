<div id="blog_home" class="menu-recent col-xs-12 col-md-6 col-ms-6">
		  <div class="blog-title module-title2">
			   <h2><?php echo $text_headingtitle; ?></h2>
		  </div>
	 <?php if ($articles) { ?>
      <div class="articles-container">
        <?php foreach ($articles as $article) { ?>
          <div class="articles-inner item-inner">
			   <div class="articles-image"><img src="<?php echo $article['image']; ?>" alt="" /></div>
			   <div class="blog-content">
				<div class="articles-date">
					<?php echo $article['date_added']; ?><?php if($article['author'] != null && $article['author'] != ""): ?>
					<?php echo " | ".$article['author']; ?>
				<?php endif; ?>
				</div>
				<a class="articles-name" href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a>
				<div class="articles-intro"><?php echo $article['intro_text']; ?></div>
				<div class="readmore"><a href="<?php echo $article['href']; ?>"><?php echo $button_read_more; ?></a></div>
			   </div>
          </div>
        <?php } ?>
      </div>
      <!--<div class="row">
        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
        <div class="col-sm-6 text-right"><?php echo $results; ?></div>
      </div>-->
      <?php } ?>
	  
      <?php if (!$articles) { ?>
      <p><?php echo $text_empty; ?></p>
      <?php } ?>
	 <script>
	 $(document).ready(function() { 
		  $(".articles-container").owlCarousel({
				autoPlay : false,
				items : 1,
				itemsDesktop : [1199,1],
				itemsDesktopSmall : [991,1],
				itemsTablet: [700,1],
				itemsMobile : [400,1],
				slideSpeed : 1000,
				paginationSpeed : 1000,
				rewindSpeed : 1000,
				navigation : true,
				stopOnHover : true,
				pagination : false,
				scrollPerPage:true,
		  });
	 });
	 </script>
</div>
