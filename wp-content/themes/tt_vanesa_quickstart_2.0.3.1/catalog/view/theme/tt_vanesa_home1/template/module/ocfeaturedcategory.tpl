<?php $limit = $config_slide['limit']; $count = 0; ?>
<div class="featured-cat-thumb">
<div class="featured-categories-container">
<div class="featured-categories-title"><h2><?php echo $heading_title; ?></h2></div>
		<div class="owl-featured-categories row">
			<?php foreach ($categories as $category): ?>
			<div class="col-xs-12 col-md-4 col-sm-12">
				<div class="fcategory-content">
					<div class="catlist_level_top">
						<a href="<?php echo $category['href'] ?>"><h2 class="name"><?php echo $category['name']; ?></h2></a>
						<!-- <p class="dec"><?php echo $category['description']; ?></p> -->
						<?php if($category['children']): ?>
						<?php $sub_count = 0; ?>
						<ul class="sub-featured-categories">
							<?php foreach($category['children'] as $subcate): ?>
								<?php if($sub_count >= 4) break; ?>
								<li><a href="<?php echo $subcate['href'] ?>"><?php echo $subcate['name']; ?></a></li>
								<?php $sub_count++; ?>
							<?php endforeach; ?>
						</ul>
						<?php endif; ?>
					</div>
					<div class="cat_image"><img src="<?php echo $category['homethumb_image'] ?>" alt="" /></div>
				</div>
			</div>
			<?php $count++; if($count == $limit) break; ?>
			<?php endforeach; ?>
		</div>
</div>
</div>