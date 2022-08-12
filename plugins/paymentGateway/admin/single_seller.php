<?php
  function escape($value){
    return htmlentities($value, ENT_QUOTES, 'UTF-8');
  }
  $select_settings = $db->select("seller_settings",array("seller_id" => $seller_id));
  $row_settings = $select_settings->fetch();

  $id_type = escape( ucfirst(str_replace("_"," ",$row_settings->id_type)) );
  $id_file = escape($row_settings->id_file);
  $full_name = escape($row_settings->full_name);
  $address = escape($row_settings->address);
  $mobile_no = escape($row_settings->mobile_no);
  $preferred_currency = escape($row_settings->preferred_currency);

  $bank_name = escape(escape($row_settings->bank_name));
  $bank_country = escape($row_settings->bank_country);
  $bank_state_province_region = escape($row_settings->bank_state_province_region);
  $bank_city = escape($row_settings->bank_city);
  $account_name = escape($row_settings->account_name);
  $account_no = escape($row_settings->account_no);
  $iban_number = escape($row_settings->iban_number);
?>
<h2> Moneygram Details </h2>
<div class="box mt-3">
  <?php if(empty($id_type) or empty($id_file) or empty($full_name) or empty($address) or empty($mobile_no) or empty($preferred_currency)){ ?>
    <h4 class="mt-2 text-center"> Bank Details Are Not Added Yet. </h4>
  <?php }else{ ?>
    <p> Id Type : <span class="font-weight-bold float-right"><?= $id_type; ?></span> </p>
    <p class="mt-3 mb-3"> Id File : 
    <span class="font-weight-bold float-right">
      <a class="btn-link" href="../plugins/paymentGateway/id_files/<?= $id_file; ?>" download><?= $id_file; ?></a>
    </span>
    </p>
    <p class="mt-3 mb-3">Full Name : <span class="font-weight-bold float-right"><?= $account_no; ?></span> </p>
    <p class="mt-3 mb-3">Address : <span class="font-weight-bold float-right"><?= $address; ?></span> </p>
    <p class="mt-3 mb-3">Mobile No : <span class="font-weight-bold float-right"><?= $mobile_no; ?></span> </p>
    <p class="mt-3 mb-3">Preferred Currency : <span class="font-weight-bold float-right"><?= $preferred_currency; ?></span> </p>
  <?php } ?>
</div>

<h2> Seller Bank Account Details </h2>
<div class="box mt-3">
  <?php if(empty($bank_name) or empty($bank_country) or empty($bank_state_province_region) or empty($bank_city) or empty($account_name) or empty($account_no) or empty($iban_number)){ ?>
    <h4 class="mt-2 text-center"> Bank Details Are Not Added Yet. </h4>
  <?php }else{ ?>
    <p> Bank Name : <span class="font-weight-bold float-right"><?= $bank_name; ?></span> </p>
    <p> Bank Country : <span class="font-weight-bold float-right"><?= $bank_country; ?></span> </p>
    <p> Bank State/Province/Region : <span class="font-weight-bold float-right"><?= $bank_state_province_region; ?></span> </p>
    <p> Bank City : <span class="font-weight-bold float-right"><?= $bank_city; ?></span> </p>
    <p class="mt-3 mb-3"> Account Holder Name : <span class="font-weight-bold float-right"><?= $account_name; ?></span> </p>
    <p class="mt-3 mb-3"> Account No : <span class="font-weight-bold float-right"><?= $account_no; ?></span> </p>
    <p class="mt-3 mb-3"> Iban No : <span class="font-weight-bold float-right"><?= $iban_number; ?></span> </p>
  <?php } ?>
</div>