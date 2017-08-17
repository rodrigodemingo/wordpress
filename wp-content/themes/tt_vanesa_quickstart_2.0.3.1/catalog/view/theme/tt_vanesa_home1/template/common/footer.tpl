<div class="footer-top">
	<div class="container">
		<div class="row">
			<?php if(isset($content_block6)) { echo $content_block6; } ?>
			<div class="link col-sm-4 col-md-4 col-sms-12">
				<ul class="link-follow">
					<li class="first"><a class="facebook fa fa-facebook" href="https://www.facebook.com/plazathemes"><span>facebook</span></a></li>
					<li><a class="google fa fa-google-plus" href="#"><span>google </span></a></li>
					<li><a class="twitter fa fa-twitter" href="https://twitter.com/plazathemes"><span>twitter</span></a></li>
					<li><a class="youtube fa fa-youtube" href="https://www.youtube.com/user/plazathemes"><span>youtube </span></a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
  <div id="footer">
	<div class="container">
		<div class="row">
			<div class="column col1 col-sm-6 col-md-3 col-sms-6 col-smb-12">
			  <div class="footer-title"><h3><?php echo $text_service; ?></h3></div>
			  <div class="footer-content">
			   <ul class="toggle-footer">
				 <li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
				 <li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
				 <li><a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a></li>
				 <li><a href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a></li>
				 <li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
			   </ul>
			  </div>
			</div>
			<div class="column col2 col-sm-6 col-md-3 col-sms-6 col-smb-12">
			   <div class="footer-title"><h3><?php echo $text_extra; ?></h3></div>
			  <div class="footer-content">
			   <ul class="toggle-footer">
				 <li><a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>
				 <li><a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>
				 <li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
				 <li><a href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a></li>
				 <li><a href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
			   </ul>
			  </div>
			</div>
			<div class="column col3 col-sm-6 col-md-3 col-sms-6 col-smb-12">
			  <div class="footer-title"><h3><?php echo $text_account; ?></h3></div>
			  <div class="footer-content">
			   <ul class="toggle-footer">
				 <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
				 <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
				 <li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
				 <li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
				 <li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
			   </ul>
			  </div>
			</div>
			<div class="f-col f-col4 col-sm-6 col-md-3 col-sms-6 col-smb-12">
				<div class="footer-title">
				<h3>contact us</h3>
				</div>
				<div class="footer-static-content">
					<ul>
						<li class="first"><em class="fa fa-map-marker">&nbsp;</em><span>Addresss:</span>Lorem ipsum dolor sit amet, consectetuer adipiscing elit</li>
						<li><em class="fa fa-envelope">&nbsp;</em><span>Email:</span>info@towerthemes.com</li>
						<li class="last"><em class="fa fa-phone">&nbsp;</em><span>Phone:</span>+123.456.789</li>
					</ul>
				</div>
			</div>
		</div>
    </div>
  </div>
<div class="footer-bottom">
	<div class="container">
		<div class="row">
			<div class="powered">
				<div class="bottom-footer col-sm-6 col-md-6 col-sms-6 col-smb-12">
					<div class="footer-link">
						<ul>
							<li><a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a></li>
							<li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
							<li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
						</ul>
					</div>
					<div class="left-powered"><h2><?php echo $powered; ?></h2></div>
				</div>
				<div class="right-powered col-sm-6 col-md-6 col-sms-6 col-smb-12">
					<ul class="payment">
						<li><a href="#"><img src="image/catalog/payment.png" alt=""></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="back-top" class="hidden-phone" style="display: block;"> </div>
<!--
OpenCart is open source software and you are free to remove the powered by OpenCart if you want, but its generally accepted practise to make a small donation.
Please donate via PayPal to donate@opencart.com
//--> 

<!-- Theme created by Welford Media for OpenCart 2.0 www.welfordmedia.co.uk -->
<script type="text/javascript">
	$(document).ready(function(){

	 // hide #back-top first
	 $("#back-top").hide();
	 
	 // fade in #back-top
	 $(function () {
	  $(window).scroll(function () {
	   if ($(this).scrollTop() > 100) {
		$('#back-top').fadeIn();
	   } else {
		$('#back-top').fadeOut();
	   }
	  });
	  // scroll body to 0px on click
	  $('#back-top').click(function () {
	   $('body,html').animate({
		scrollTop: 0
	   }, 800);
	   return false;
	  });
	 });

	});
</script>
</body></html>