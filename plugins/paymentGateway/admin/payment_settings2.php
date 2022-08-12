<?php
  $enable_checkout = escape($row_payment_settings->enable_2checkout);
  $checkout_number = escape($row_payment_settings->checkout_number);
  $checkout_private_key = escape($row_payment_settings->checkout_private_key);
  $checkout_secret_word = escape($row_payment_settings->checkout_secret_word);
  $checkout_sandbox = escape($row_payment_settings->checkout_sandbox);
  $checkout_currency_code = escape($row_payment_settings->checkout_currency_code);
?>
<div class="row">
  <!--- row Starts --->
  <div class="col-lg-12">
    <?php 
    $form_errors = Flash::render("2checkout_errors");
    if(is_array($form_errors)){
    ?>
    <div class="alert alert-danger"><!--- alert alert-danger Starts --->
      <ul class="list-unstyled mb-0">
        <?php $i = 0; foreach ($form_errors as $error) { $i++; ?>
          <li class="list-unstyled-item"><?= escape($i); ?>. <?= escape(ucfirst($error)); ?></li>
        <?php } ?>
      </ul>
    </div><!--- alert alert-danger Ends --->
    <?php } ?>
    <!--- col-lg-12 Starts --->
    <div class="card mb-5">
      <!--- card mb-5 Starts --->
      <div class="card-header">
        <!--- card-header Starts --->
        <h4 class="h4"><i class="fa fa-money fa-fw"></i> Update 2Checkout Settings</h4>
      </div>
      <!--- card-header Ends --->
      <div class="card-body">
        <!--- card-body Starts --->
        <form action="" method="post">
          <!--- form Starts --->
          <div class="form-group row">
            <!--- form-group row Starts --->
            <label class="col-md-3 control-label"> Enable 2Checkout : </label>
            <div class="col-md-6">
              <select name="enable_2checkout" class="form-control" required="">
                <?php if($enable_checkout == "yes"){ ?>
                <option value="yes"> Yes </option>
                <option value="no"> No </option>
                <?php }elseif($enable_checkout == "no"){ ?>
                <option value="no"> No </option>
                <option value="yes"> Yes </option>
                <?php } ?>
              </select>
              <small class="form-text text-muted">ALLOW BUYERS TO PAY USING STRIPE</small>
            </div>
          </div>
          <!--- form-group row Ends --->
          <div class="form-group row">
            <!--- form-group row Starts --->
            <label class="col-md-3 control-label"> 2Checkout Account Number : </label>
            <div class="col-md-6">
              <input type="text" name="checkout_number" class="form-control" value="<?= $checkout_number; ?>">
              <small class="form-text text-muted">YOUR 2Checkout Account Number ASSIGNED TO YOU</small>
            </div>
          </div>
          <!--- form-group row Ends --->
          <div class="form-group row ">
            <!--- form-group row Starts --->
            <label class="col-md-3 control-label"> 2Checkout Private Key : </label>
            <div class="col-md-6">
              <input type="text" name="checkout_private_key" class="form-control" value="<?= $checkout_private_key; ?>">
              <small class="form-text text-muted">YOUR 2Checkout Private KEY ASSIGNED TO YOU</small>
            </div>
          </div>
          <!--- form-group row Ends ---> 
          <div class="form-group row ">
            <!--- form-group row Starts --->
            <label class="col-md-3 control-label"> 2Checkout Secret Word : </label>
            <div class="col-md-6">
              <input type="text" name="checkout_secret_word" class="form-control" value="<?= $checkout_secret_word; ?>">
              <small class="form-text text-muted">YOUR 2Checkout Secret Word ASSIGNED TO YOU</small>
            </div>
          </div>
          <!--- form-group row Ends --->
          <div class="form-group row"><!--- form-group row Starts --->
            <label class="col-md-3 control-label"> 2Checkout Currency Code : </label>
            <div class="col-md-6">
              <input type="text" name="checkout_currency_code" class="form-control" value="<?= $checkout_currency_code; ?>">
              <small class="form-text text-muted">CURRENCY USED FOR 2Checkout PAYMENTS <a href="https://stripe.com/docs/currencies" target="_blank"> CLICK HERE TO GET ALL 2Checkout CURRENCY CODES </a> </small>
            </div>
          </div><!--- form-group row Ends --->
          <div class="form-group row">
            <!--- form-group row Starts --->
            <label class="col-md-3 control-label"> 2Checkout Sandbox : </label>
            <div class="col-md-6">
              <input type="radio" name="checkout_sandbox" value="on" <?php if($checkout_sandbox=='on'){echo "checked";} ?> required>
              <label> On </label>
              <input type="radio" name="checkout_sandbox" value="off" <?php if($checkout_sandbox=='off'){echo "checked";} ?> required>
              <label> Off </label>
            </div>
          </div>
          <!--- form-group row Ends --->
          <div class="form-group row">
            <!--- form-group row Starts --->
            <label class="col-md-3 control-label"></label>
            <div class="col-md-6">
              <input type="submit" name="update_2checkout_settings" class="btn btn-success form-control" value="Update 2Checkout Settings">
            </div>
          </div>
          <!--- form-group row Ends --->
        </form>
        <!--- form Ends --->
      </div>
      <!--- card-body Ends --->
    </div>
    <!--- card mb-5 Ends --->
  </div>
  <!--- col-lg-12 Ends --->
</div>
<?php

if(isset($_POST['update_2checkout_settings'])){
  // validating the 2checkout
  $rules = array(
    "enable_2checkout" => "required",
  );
  $val = new Validator($_POST,$rules);
  if($val->run() == false){
    Flash::add("2checkout_errors",$val->get_all_errors());
    redirect("index?payment_settings");
  }else{
    $data = $input->post();
    unset($data['update_2checkout_settings']);
    $update_stripe_settings = $db->update("payment_settings",$data);
    if($update_stripe_settings){
      $insert_log = $db->insert_log($admin_id,"2checkout_settings","","updated");   
      successRedirect("2Checkout Settings Updated Successfully.","index?payment_settings"); 
    }
  }
}

?>