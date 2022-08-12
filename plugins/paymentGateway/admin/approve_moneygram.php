<?php

if(!isset($_SESSION['admin_email'])){
  redirect("../../../admin/login.php");
}else{

function escape($value){
  return htmlentities($value,ENT_QUOTES,'UTF-8');
}

?>
<div class="breadcrumbs">
  <div class="col-sm-4">
  <div class="page-header float-left">
    <div class="page-title">
      <h1><i class="menu-icon fa fa-table"></i> Withdrawals</h1>
    </div>
  </div>
  </div>
  <div class="col-sm-8">
    <div class="page-header float-right">
      <div class="page-title">
        <ol class="breadcrumb text-right">
        <li class="active">Approve Withdrawal</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <!--- row Starts --->
    <div class="col-lg-12">
      <?php
      $form_errors = Flash::render("approve_withdrawal_errors");
      if(is_array($form_errors)){
      ?>
      <div class="alert alert-danger"><!--- alert alert-danger Starts --->
        <ul class="list-unstyled mb-0">
          <?php $i = 0; foreach($form_errors as $error){ $i++; ?>
            <li class="list-unstyled-item"><?= escape($i); ?>. <?= escape(ucfirst($error)); ?></li>
          <?php } ?>
        </ul>
      </div><!--- alert alert-danger Ends --->
      <?php } ?>
      <!--- col-lg-12 Starts --->
      <div class="card">
        <!--- card Starts --->
        <div class="card-header">
          <!--- card-header Starts ---> 
          <h4 class="h4">
            <!--- h4 Starts --->
            <i class="fa fa-money fa-fw"></i> Approve Moneygram Withdrawal Request
          </h4>
          <!--- h4 Ends --->
        </div>
        <!--- card-header Ends ---> 
        <div class="card-body">
          <!--- card-body Starts --->
          <form action="" method="post" enctype="multipart/form-data">
            <!---  form Starts --->
            <div class="form-group row">
              <!--- form-group row Starts --->
              <label class="col-md-3 control-label"> REF Number </label>
              <div class="col-md-6">
                <input type="text" name="ref_no" class="form-control" required="">
              </div>
            </div>
            <!--- form-group row Ends --->
            <div class="form-group row">
              <!--- form-group row Starts --->
              <label class="col-md-3 control-label"> Receipt Image </label>
              <div class="col-md-6">
                <input type="file" name="r_image" class="form-control">
                <small class="text-muted">Optional</small>
              </div>
            </div>
            <!--- form-group row Ends --->
            <div class="form-group row">
              <!--- form-group row Starts --->
              <label class="col-md-3 control-label"></label>
              <div class="col-md-6">
                <input type="submit" name="submit" value="Approve Withdrawal Request" class="btn btn-success form-control">
              </div>
            </div>
            <!--- form-group row Ends --->
          </form>
          <!---  form Ends --->
        </div>
        <!--- card-body Ends --->
      </div>
      <!--- card Ends --->
    </div>
    <!--- col-lg-12 Ends --->
  </div>
  <!--- row Ends --->
</div>
<?php
if(isset($_POST['submit'])){
  $id = $input->get('approve_moneygram');
  // validating the ref_no
  $rules = array(
    "ref_no" => "required",
  );
  $val = new Validator($_POST,$rules);
  if($val->run() == false){
    Flash::add("approve_withdrawal_errors",$val->get_all_errors());
    redirect("index?approve_moneygram=$id");
  }else{
    $ref_no = $input->post('ref_no');

    // File Upload
    $r_image = $_FILES['r_image']['name'];
    $r_image_tmp = $_FILES['r_image']['tmp_name'];
    $allowed = array('jpeg','jpg','gif','png','tif','bmp','pdf','zip','rar');
    $file_extension = pathinfo($r_image, PATHINFO_EXTENSION);
    if(!empty($r_image)){
      if(!in_array($file_extension,$allowed)){
        messageRedirect("Your File Format Extension Is Not Supported.","index?approve_moneygram=$id");
        exit();
      }
      $r_image = pathinfo($r_image, PATHINFO_FILENAME);
      $r_image = $r_image."_".time().".$file_extension";
      move_uploaded_file($r_image_tmp,"../plugins/paymentGateway/receipt_images/$r_image");
    }

    $update = $db->update("payouts",array("status"=>'completed',"ref_no"=>$ref_no,'receipt_image'=>$r_image),array("id"=>$id));
    if($update){
      $date = date("F d, Y");
      $get = $db->select("payouts",array('id'=>$id));
      $row = $get->fetch();
      $seller_id = $row->seller_id;
      $amount = $row->amount;
      $insert_notification = $db->insert("notifications",array("receiver_id" => $seller_id,"sender_id" => "admin_$admin_id","order_id" => $id,"reason" => "withdrawal_approved","date" => $date,"status" => "unread"));
      successRedirect("One Withdrawal Request Has Been Approved.","index?payouts&status=completed");
    }
  }
}
?>
<?php } ?>