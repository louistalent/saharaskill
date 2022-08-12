<?php
  function escape($value){
    return htmlentities($value, ENT_QUOTES, 'UTF-8');
  }
  $enable_bank_transfer = escape($row_payment_settings->enable_bank_transfer);
  $enable_moneygram = escape($row_payment_settings->enable_moneygram);
  $moneygram_id_types = escape($row_payment_settings->moneygram_id_types);
?>
<div class="row">
  <!--- row Starts --->
  <div class="col-lg-12">
    <?php 
    $form_errors = Flash::render("bank_transfer_errors");
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
      <!--- card mb-5 Starts -->
      <div class="card-header">
        <!--- card-header Starts --->
        <h4 class="h4">
          <i class="fa fa-paypal"></i> Update Bank Transfer Settings
        </h4>
      </div>
      <!--- card-header Ends --->
      <div class="card-body">
        <!--- card-body Starts --->
        <form action="" method="post">
          <!--- form Starts --->
          <div class="form-group row">
            <!--- form-group row Starts --->
            <label class="col-md-3 control-label"> Enable Bank Transfer : </label>
            <div class="col-md-6">
              <select name="enable_bank_transfer" class="form-control" required="">
                <option value="yes" <?php if($enable_bank_transfer == "yes"){echo "selected";} ?>> Yes </option>
                <option value="no" <?php if($enable_bank_transfer == "no"){echo "selected";} ?>> No </option>
              </select>
              <small class="form-text text-muted mb-0">Allow users to withdraw using Bank Transfer.</small>
              <small class="form-text text-muted">In order for this to work, you need to enable manual payouts in general settings</small>
            </div>
          </div>
          <!--- form-group row Ends --->
          <!--- form-group row Ends --->
          <div class="form-group row">
            <!--- form-group row Starts --->
            <label class="col-md-3 control-label"></label>
            <div class="col-md-6">
              <input type="submit" name="update_bank_settings" value="Update Bank Transfer Settings" class="btn btn-success form-control">
            </div>
          </div>
          <!--- form-group row Ends --->
        </form>
      </div>
      <!--- card-body Ends --->
    </div>
    <!--- card mb-5 Ends -->
  </div>
  <!--- col-lg-12 Ends --->
</div>
<!---  3 row Ends --->
<div class="row">
  <!---  3 row Starts --->
  <div class="col-lg-12">
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
    <!--- col-lg-12 Starts --->
    <div class="card mb-5">
      <!--- card mb-5 Starts -->
      <div class="card-header">
        <!--- card-header Starts --->
        <h4 class="h4">
          <i class="fa fa-paypal"></i> Update Moneygram Settings
        </h4>
      </div>
      <!--- card-header Ends --->
      <div class="card-body">
        <!--- card-body Starts --->
        <form action="" method="post">
          <!--- form Starts --->
          <div class="form-group row">
            <!--- form-group row Starts --->
            <label class="col-md-3 control-label"> Enable Moneygram : </label>
            <div class="col-md-6">
              <select name="enable_moneygram" class="form-control" required="">
                <option value="yes" <?php if($enable_moneygram == "yes"){echo "selected";} ?>> Yes </option>
                <option value="no" <?php if($enable_moneygram == "no"){echo "selected";} ?>> No </option>
              </select>
              <small class="form-text text-muted mb-0">Allow users to withdraw using moneygram.</small>
              <small class="form-text text-muted">In order for this to work, you need to enable manual payouts in general settings</small>
            </div>
          </div>
          <!--- form-group row Ends --->
          <div class="form-group row">
            <label class="col-md-3 control-label"> Moneygram Id Types : </label>
            <div class="col-md-6">
              <input type="text" name="moneygram_id_types" class="form-control" value="<?= $moneygram_id_types; ?>">
              <small class="form-text text-muted">Separate Id Types with Commas</small>
            </div>
          </div>
          <!--- form-group row Ends --->
          <div class="form-group row">
            <!--- form-group row Starts --->
            <label class="col-md-3 control-label"></label>
            <div class="col-md-6">
              <input type="submit" name="update_moneygram_settings" value="Update Moneygram Settings" class="btn btn-success form-control">
            </div>
          </div>
          <!--- form-group row Ends --->
        </form>
      </div><!--- card-body Ends --->
    </div><!--- card mb-5 Ends -->
  </div> <!--- col-lg-12 Ends --->
</div><!---  3 row Ends ---> 
<?php
  if(isset($_POST['update_bank_settings'])){
    // validating the bank transfer
    $rules = array(
      "enable_bank_transfer" => "required",
    );
    $val = new Validator($_POST,$rules);
    if($val->run() == false){
      Flash::add("bank_transfer_errors",$val->get_all_errors());
      redirect("index?payment_settings");
    }else{
      $data = $input->post();
      unset($data['update_bank_settings']);
      $update_bank_settings = $db->update("payment_settings",$data);
      if($update_bank_settings){
        $insert_log = $db->insert_log($admin_id,"bank_settings","","updated");
        successRedirect("Bank Transfer Settings Updated Successfully.","index?payment_settings");
      }
    }
  }

  if(isset($_POST['update_moneygram_settings'])){
    // validating the moneygram
    $rules = array(
      "enable_moneygram" => "required",
    );
    $val = new Validator($_POST,$rules);
    if($val->run() == false){
      Flash::add("moneygram_errors",$val->get_all_errors());
      redirect("index?payment_settings");
    }else{
      $data = $input->post();
      unset($data['update_moneygram_settings']);
      $update_moneygram_settings = $db->update("payment_settings",$data);
      if($update_moneygram_settings){
        $insert_log = $db->insert_log($admin_id,"moneygram_settings","","updated");
        successRedirect("Moneygram Settings Updated Successfully.","index?payment_settings");
      }
    }
  }
?>