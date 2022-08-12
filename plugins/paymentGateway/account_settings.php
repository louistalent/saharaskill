<?php

function escape($value){
  return htmlentities($value,ENT_QUOTES,'UTF-8');
}

$get_payment_settings = $db->select("payment_settings");
$row_payment_settings = $get_payment_settings->fetch();
$moneygram_id_types = escape($row_payment_settings->moneygram_id_types);

$select_settings = $db->select("seller_settings",array("seller_id"=>$login_seller_id));
$row_settings = $select_settings->fetch();
$count_settings = escape($select_settings->rowCount());
$id_type = escape($row_settings->id_type);
$id_file = escape($row_settings->id_file);
$full_name = escape($row_settings->full_name);
$address = escape($row_settings->address);
$mobile_no = escape($row_settings->mobile_no);
$preferred_currency = escape($row_settings->preferred_currency);
$bank_name = escape($row_settings->bank_name);
$bank_country = escape($row_settings->bank_country);
$bank_state_province_region = escape($row_settings->bank_state_province_region);
$bank_city = escape($row_settings->bank_city);
$account_name = escape($row_settings->account_name);
$account_no = escape($row_settings->account_no);
$iban_number = escape($row_settings->iban_number);
$swift_code = escape($row_settings->swift_code);

?>
<hr>
<h5 class="mb-4"> Moneygram For Withdrawing Revenue </h5>
<?php 
$form_errors = Flash::render("moneygram_errors");
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
<form method="post" enctype="multipart/form-data" class="clearfix mb-3">
  <div class="form-group row">
    <label class="col-md-4 col-form-label"> Id Type </label>
    <div class="col-md-8">
      <select name="id_type" class="form-control" required="">
        <?php
          $moneygram_id_types = explode(",", $moneygram_id_types);
          foreach($moneygram_id_types as $type){
        ?>
        <option value="<?= escape('$type'); ?>" <?php if($id_type == $type){echo "selected";} ?>><?= escape($type); ?></option>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-md-4 col-form-label"> Id File </label>
    <div class="col-md-8">
      <input type="file" name="id_file" class="form-control" id="cover" <?= (empty($id_file)) ? 'required' : ''; ?>>
      <small class="text-muted">Please Upload Id Front And Back In Zip Format.</small>
      <?= (empty($id_file)) ? '' : '<p class="mb-0 small"><a href="plugins/paymentGateway/id_files/'.$id_file.'" class="text-primary" download><i class="fa fa-download"></i> '.$id_file.'</a></p>'; ?>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-md-4 col-form-label"> Full Name </label>
    <div class="col-md-8">
      <input type="text" name="full_name" value="<?= $full_name; ?>" class="form-control" placeholder="Full Name" required="">
    </div>
  </div>
  <div class="form-group row">
    <label class="col-md-4 col-form-label"> Address/Location </label>
    <div class="col-md-8">
      <input type="text" name="address" class="form-control" value="<?= $address; ?>" placeholder="Address" required="">
    </div>
  </div>
  <div class="form-group row">
    <label class="col-md-4 col-form-label"> Mobile No </label>
    <div class="col-md-8">
      <input type="number" name="mobile_no" class="form-control" value="<?= $mobile_no; ?>" placeholder="Mobile No" required="">
    </div>
  </div>
  <div class="form-group row">
    <label class="col-md-4 col-form-label"> Preferred Currency </label>
    <div class="col-md-8">
      <input type="text" name="preferred_currency" class="form-control" value="<?= $preferred_currency; ?>" required="">
    </div>
  </div>
  <button type="submit" name="update_moneygram" class="btn btn-success float-right">Update Moneygram Details</button>
</form>
<hr>
<h5 class="mb-4"> Bank Transfer For Withdrawing Revenue </h5>
<?php 
$form_errors = Flash::render("bank_details_errors");
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
<form method="post" class="clearfix mb-3">
  <div class="form-group row">
    <label class="col-md-4 col-form-label"> Bank Name </label>
    <div class="col-md-8">
      <input type="text" name="bank_name" value="<?= $bank_name; ?>" placeholder="Enter Your Bank Name" class="form-control" required>
    </div>
  </div>
  <div class="form-group row"><!-- form-group row Starts --> 
    <label class="col-md-4 col-form-label"> Bank Country </label>
    <div class="col-md-8">
      <select name="bank_country" class="form-control" required>
      <?php
        $get_countries = $db->select("countries");
        while($row_countries = $get_countries->fetch()){
          $name = escape($row_countries->name);
          echo "<option value='$name'".($name == $bank_country ? "selected" : "").">$name</option>";
        }
        ?>
      </select>
    </div>
  </div>
  <!-- form-group row Ends -->
  <div class="form-group row">
    <label class="col-md-4 col-form-label"> Bank State/Province/Region </label>
    <div class="col-md-8">
      <input type="text" name="bank_state_province_region" value="<?= $bank_state_province_region; ?>" placeholder="Enter Your Bank State/Province/Region" class="form-control" required>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-md-4 col-form-label"> Bank City </label>
    <div class="col-md-8">
      <input type="text" name="bank_city" value="<?= $bank_city; ?>" placeholder="Enter Your Bank City" class="form-control" required>
    </div>
  </div>
  <div class="form-group row">
    <!-- form-group row Starts -->
    <label class="col-md-4 col-form-label"> Account Holder Name </label>
    <div class="col-md-8">
      <input type="text" name="account_name" value="<?php echo $account_name; ?>" placeholder="Enter Your Account Holder Name" class="form-control" required>
    </div>
  </div>
  <!-- form-group row Ends -->
  <div class="form-group row">
    <!-- form-group row Starts -->
    <label class="col-md-4 col-form-label"> Account No </label>
    <div class="col-md-8">
      <input type="text" name="account_no" value="<?php echo $account_no; ?>" placeholder="Enter Your Account No" class="form-control" required>
    </div>
  </div>
  <!-- form-group row Ends -->
  <div class="form-group row">
    <!-- form-group row Starts -->
    <label class="col-md-4 col-form-label"> Iban Number (optional) </label>
    <div class="col-md-8">
      <input type="text" name="iban_number" value="<?php echo $iban_number; ?>" placeholder="Enter Your Iban Number" class="form-control">
    </div>
  </div>
  <!-- form-group row Ends -->
  <div class="form-group row">
    <!-- form-group row Starts -->
    <label class="col-md-4 col-form-label"> Swift Code (optional) </label>
    <div class="col-md-8">
      <input type="text" name="swift_code" value="<?php echo $swift_code; ?>" placeholder="Enter Your Swift Code" class="form-control">
    </div>
  </div>
  <!-- form-group row Ends -->
  <button type="submit" name="update_bank_details" class="btn btn-success float-right">Update Bank Details</button>
</form>
<?php

if(isset($_POST['update_moneygram'])){
  // validating the moneygram details
  $rules = array(
    "id_type" => "required",
    "full_name" => "filterName|required",
    "address" => "required",
    "mobile_no" => "number|required",
    "preferred_currency" => "required",
  );
  $val = new Validator($_POST,$rules);
  if($val->run() == false){
    Flash::add("moneygram_errors",$val->get_all_errors());
    redirect("settings?account_settings");
  }else{
    $id_file = $_FILES['id_file']['name'];
    $id_file_tmp = $_FILES['id_file']['tmp_name'];
    $allowed = array('jpeg','jpg','gif','png','tif','zip','rar');
    $file_extension = pathinfo($id_file, PATHINFO_EXTENSION);
    if(!empty($id_file)){
      if(!in_array($file_extension,$allowed)){
        messageRedirect("Your File Format Extension Is Not Supported.","settings?account_settings");
        exit();
      }
      $id_file = pathinfo($id_file, PATHINFO_FILENAME);
      $id_file = $id_file."_".time().".$file_extension";
      move_uploaded_file($id_file_tmp,"plugins/paymentGateway/id_files/$id_file");
    }else{
      $id_file = escape($row_settings->id_file);
    }
    $data = $input->post();
    unset($data['update_moneygram']);
    $data['id_file'] = $id_file;
    if($count_settings == 0){
      $data['seller_id'] = $login_seller_id;
      $update_seller = $db->insert("seller_settings",$data);
    }else{
      $update_seller = $db->update("seller_settings",$data,array("seller_id"=>$login_seller_id));
    }
    if($update_seller){
      successRedirect("Moneygram settings updated successfully.","settings?account_settings");
    }
  }
}

if(isset($_POST['update_bank_details'])){
  // validating the bank details
  $rules = array(
    "bank_name" => "required",
    "bank_country" => "required",
    "bank_state_province_region" => "required",
    "bank_city" => "required",
    "account_name" => "required",
    "account_no" => "required",
  );
  $val = new Validator($_POST,$rules);
  if($val->run() == false){
    Flash::add("bank_details_errors",$val->get_all_errors());
    redirect("settings?account_settings");
  }else{
    $data = $input->post();
    unset($data['update_bank_details']);
    if($count_settings == 0){
      $data['seller_id'] = $login_seller_id;
      $update_seller = $db->insert("seller_settings",$data);
    }else{
      $update_seller = $db->update("seller_settings",$data,array("seller_id"=>$login_seller_id));
    }
    if($update_seller){
      successRedirect("Bank Details settings updated successfully.","settings?account_settings");
    }
  }
}
?>