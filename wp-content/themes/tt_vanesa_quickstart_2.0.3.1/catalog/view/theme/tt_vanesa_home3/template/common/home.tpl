<?php echo $header; ?>
<div class="container">
	<div class="row">
	<?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?></div>
    <?php echo $column_right; ?>
	</div>
</div>
<?php if(isset($content_block4)) { echo $content_block4; } ?>
<div class="block-bottom"><div class="container"><div class="row"><?php if(isset($content_block3)) { echo $content_block3; } ?></div></div></div>
<?php echo $content_bottom; ?>
<?php echo $footer; ?>