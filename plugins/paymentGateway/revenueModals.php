<?php

function escape($value){
  return htmlentities($value, ENT_QUOTES, 'UTF-8');
}

$select_settings = $db->select("seller_settings",array("seller_id" => $login_seller_id));
$row_settings = $select_settings->fetch();
@$id_type = escape($row_settings->id_type);
@$id_file = escape($row_settings->id_file);
@$full_name = escape($row_settings->full_name);
@$address = escape($row_settings->address);
@$mobile_no = escape($row_settings->mobile_no);
@$preferred_currency = escape($row_settings->preferred_currency);

@$bank_name = escape($row_settings->bank_name);
@$bank_country = escape($row_settings->bank_country);
@$bank_state_province_region = escape($row_settings->bank_state_province_region);
@$bank_city = escape($row_settings->bank_city);
@$account_name = escape($row_settings->account_name);
@$account_no = escape($row_settings->account_no);
@$iban_number = escape($row_settings->iban_number);

?>
<div id="bank_account_modal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"> Withdraw/Transfer Funds To Bank Account </h5>
				<button class="close" data-dismiss="modal"><span> &times; </span></button>
			</div>
			<div class="modal-body"><!-- modal-body Starts -->
				<center><!-- center Starts -->
					<?php if(empty($bank_name) or empty($bank_country) or empty($bank_state_province_region) or empty($bank_city) or empty($account_name) or empty($account_no)){ ?>
					<p class="lead">
						In order to transfer funds to your Bank account, you will need to add your Bank details in your
						<a href="<?= escape($site_url); ?>/settings?account_settings" class="text-success">account settings</a> tab.
					</p>
	        <?php }else{ ?>
					<p class="lead">
						Your revenue funds will be transferred to: 
						<br> Bank Name : <strong><?= $bank_name; ?></strong>
						<br> Account No : <strong><?= $account_no; ?></strong>
					</p>
					<form action="withdraw_manual" method="post">
						<input type="hidden" name="method" value="bank_transfer">
						<div class="form-group row">
							<label class="col-md-3 col-form-label font-weight-bold">Amount</label>
							<div class="col-md-8">
								<div class="input-group">
									<span class="input-group-addon font-weight-bold"> $ </span>
									<input type="number" name="amount" class="form-control input-lg" min="<?= escape($withdrawal_limit); ?>" max="<?= escape($current_balance); ?>"placeholder="<?= escape($withdrawal_limit); ?> Minimum" required>
								</div>
						  </div>
						</div>
						<div class="form-group row">
							<div class="col-md-8 offset-md-3">
							  <input type="submit" name="withdraw" value="Transfer" class="btn btn-success form-control" >
							</div>
						</div>
					</form>
	        <?php } ?>
				</center>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div id="moneygram_modal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"> Withdraw/Transfer Funds To Moneygram </h5>
				<button class="close" data-dismiss="modal"><span> &times; </span></button>
			</div>
			<div class="modal-body"><!-- modal-body Starts -->
				<center><!-- center Starts -->
	       <?php if(empty($id_type) or empty($id_file) or empty($full_name) or empty($address) or empty($mobile_no) or empty($preferred_currency)){ ?>
					<p class="lead">
						In order to transfer funds to your moneygram, you will need to add your moneygram details in your
						<a href="<?= escape($site_url); ?>/settings?account_settings" class="text-success">
							account settings
						</a> tab.
					</p>
	        <?php }else{ ?>
					<p class="lead mb-2">Your revenue funds will be transferred to:</p>
					<p class="mt-0 ">
						Full Name : <strong><?= $full_name; ?></strong>
						<br> Address/Location : <strong><?= $address; ?></strong>
						<br> Mobile No : <strong><?= $mobile_no; ?></strong>
						<br> Currency : <strong><?= $preferred_currency; ?></strong>
					</p>
					<form action="withdraw_manual" method="post">
						<input type="hidden" name="method" value="moneygram">
						<div class="form-group row">
							<label class="col-md-3 col-form-label font-weight-bold">Amount</label>
							<div class="col-md-8">
								<div class="input-group">
									<span class="input-group-addon font-weight-bold"> $ </span>
									<input type="number" name="amount" class="form-control input-lg" min="<?= escape($withdrawal_limit); ?>" max="<?= escape($current_balance); ?>"placeholder="<?= escape($withdrawal_limit); ?> Minimum" required>
								</div>
						  </div>
						</div>
						<div class="form-group row">
							<div class="col-md-8 offset-md-3">
							  <input type="submit" name="withdraw" value="Transfer" class="btn btn-success form-control" >
							</div>
						</div>
					</form>
	       <?php } ?>
				</center>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>