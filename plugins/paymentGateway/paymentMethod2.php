<?php if($enable_paypal == "yes" or $enable_stripe == "yes"){ ?>
<hr>
<?php } ?>
<div class="payment-option">
	<input type="radio" name="payment_option" id="2checkout" class="radio-custom"
	<?php
		if($current_balance < $amount){
		  if($enable_paypal == "no" and $enable_stripe == "no"){
		  	echo "checked";
		  }
		}
	?>>
	<label for="2checkout" class="radio-custom-label"></label>
	<img src="<?= $site_url; ?>/plugins/paymentGateway/images/2checkout.png" class="img-fluid">
</div>