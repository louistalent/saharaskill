<?php if($enable_paypal == "yes" or $enable_stripe == "yes"){ ?>
<hr>
<?php } ?>
<div class="row">
  <div class="col-1">
    <input id="2checkout" type="radio" name="method" class="form-control radio-input"
    <?php
      if($current_balance < $sub_total){
	      if($enable_paypal == "no" and $enable_stripe == "no" and $enable_2checkout == "yes"){ echo "checked"; }
      }
    ?>>
  </div>
  <div class="col-11">
    <img src="plugins/paymentGateway/images/2checkout.png" height="50" class="ml-2 width-xs-100">
  </div>
</div>