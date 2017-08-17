<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content= "<?php echo $keywords; ?>" />
<?php } ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php if ($icon) { ?>
<link href="<?php echo $icon; ?>" rel="icon" />
<?php } ?>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<link href='http://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
<script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
<script src="catalog/view/javascript/jquery/jquery-ui.js" type="text/javascript"></script>
<link href="catalog/view/javascript/jquery/css/jquery-ui.css" rel="stylesheet" media="screen" />
<script src="catalog/view/javascript/opentheme/oclayerednavigation/oclayerednavigation.js" type="text/javascript"></script>
<link href="catalog/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
<script src="catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<?php 
 if(!isset($_COOKIE['theme_color_cookie'])) {
 ?>
   <link rel="stylesheet" type="text/css" href="catalog/view/theme/tt_vanesa_home1/stylesheet/global.css" />
   <?php
 } else {
 ?>
   <link rel="stylesheet" type="text/css" href="<?php echo $_COOKIE['theme_color_cookie']; ?> " />
 <?php 
 } 
?>
<script src="catalog/view/javascript/opentheme/owlcarousel/owl.carousel.js" type="text/javascript"></script>
<link href="catalog/view/javascript/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css" />
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Anton' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<link href="catalog/view/theme/tt_vanesa_home1/stylesheet/animate.css" rel="stylesheet" type="text/css">
<link href="catalog/view/theme/tt_vanesa_home1/stylesheet/opentheme/hozmegamenu/css/custommenu.css" rel="stylesheet">
<link href="catalog/view/theme/tt_vanesa_home1/stylesheet/opentheme/ocsearchcategory.css" rel="stylesheet">
<link href="catalog/view/theme/tt_vanesa_home1/stylesheet/opentheme/ocslideshow/ocslideshow.css" rel="stylesheet">
<link href="catalog/view/theme/tt_vanesa_home1/stylesheet/opentheme/oclayerednavigation/css/oclayerednavigation.css" rel="stylesheet">
<link href="catalog/view/theme/tt_vanesa_home1/stylesheet/opentheme/vermegamenu/css/ocsvegamenu.css" rel="stylesheet">
<link href="catalog/view/theme/tt_vanesa_home1/stylesheet/opentheme/categorytabslider.css" rel="stylesheet">
<script src="catalog/view/javascript/opentheme/hozmegamenu/custommenu.js" type="text/javascript"></script>
<script src="catalog/view/javascript/opentheme/hozmegamenu/mobile_menu.js" type="text/javascript"></script>
<script src="catalog/view/javascript/opentheme/vermegamenu/custommenu.js" type="text/javascript"></script>
<!-- <script src="catalog/view/javascript/opentheme/vermegamenu/mobile_menu.js" type="text/javascript"></script> -->
<link href="catalog/view/theme/tt_vanesa_home1/stylesheet/opentheme/css/owl.carousel.css" rel="stylesheet">
<script src="catalog/view/javascript/jquery/elevatezoom/jquery.elevatezoom.js" type="text/javascript"></script>
<script src="catalog/view/javascript/bannersequence/jquery.sequence.js" type="text/javascript"></script>
<script src="catalog/view/javascript/opentheme/ocslideshow/jquery.nivo.slider.js" type="text/javascript"></script>
<?php foreach ($styles as $style) { ?>
<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script src="catalog/view/javascript/common.js" type="text/javascript"></script>
<?php foreach ($scripts as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>
<?php echo $google_analytics; ?>
</head>
<body class="<?php echo $class; ?>">
<header>
	<div class="container">
		<div class="header-links">
			<div class="header-connected">
				<div class="email infor"><i class="fa fa-envelope">&nbsp;</i><span>Email: </span>info@plazathemes.com</div>
				<div class="phone infor"><i class="fa fa-phone">&nbsp;</i><span>Phone: </span>(800)123.456.789</div>
			</div>
			<div class="box-right">
				<div id="top-links" class="nav pull-right">
					<div class="currency-language">
						<?php echo $currency; ?>
						<?php echo $language; ?>
					</div>
					<ul class="list-inline links">
					  <li class="dropdown"><a href="<?php echo $account; ?>" title="<?php echo $text_account; ?>" class="dropdown-toggle" data-toggle="dropdown"><span><?php echo $text_account; ?></span></a>
						<ul class="dropdown-menu dropdown-menu-right">
						  <?php if ($logged) { ?>
						  <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
						  <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
						  <li><a href="<?php echo $transaction; ?>"><?php echo $text_transaction; ?></a></li>
						  <li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
						  <li><a href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a></li>
						  <?php } else { ?>
						  <li><a href="<?php echo $register; ?>"><?php echo $text_register; ?></a></li>
						  <li><a href="<?php echo $login; ?>"><?php echo $text_login; ?></a></li>
						  <?php } ?>
						</ul>
					  </li>
					  <li><a href="<?php echo $wishlist; ?>" id="wishlist-total" title="<?php echo $text_wishlist; ?>"><span><?php echo $text_wishlist; ?></span></a></li>
					  <li><a href="<?php echo $shopping_cart; ?>" class="item-cart" title="<?php echo $text_shopping_cart; ?>"><span><?php echo $text_shopping_cart; ?></span></a></li>
					  <li class="last"><a href="<?php echo $checkout; ?>" title="<?php echo $text_checkout; ?>"><span><?php echo $text_checkout; ?></span></a></li>
					</ul>
				</div>
				<div class="text-welcome"><p><?php //echo $text_msg; ?></p></div>
			</div>
		</div>
	</div>
<div class="container">
  <div class="header">
  <div class="row">
	<div class="col-xs-12 col-md-3">
		<div id="logo">
		<?php if ($logo) { ?>
		  <a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" class="img-responsive" /></a>
		  <?php } else { ?>
		  <h1><a href="<?php echo $home; ?>"><?php echo $name; ?></a></h1>
		  <?php } ?>
		</div>
	</div>
	<div class="header-cart col-xs-12 col-md-9 col-sm-12">
		<div class="header-search"><?php echo $content_block5; ?></div>
		<div class="top-cart">
			<?php echo $cart; ?>
		</div>
	</div>
  </div>
</div>
</div>
</header>
<div class="menu"><div class="container"><div class="row"><?php if(isset($content_block)) { echo $content_block; } ?></div></div></div>
<div class="container"><div class="row"><div class="col-sms12 col-md-3 col-sm-12"></div><?php if(isset($content_block2)) { echo $content_block2; } ?></div></div>
<?php if ($categories) { ?>
<?php } ?>
