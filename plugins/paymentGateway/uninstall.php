<?php

function delete_plugin(){
	global $db;
	$db->query("
	ALTER TABLE `payment_settings`
	DROP `enable_bank_transfer`,
	DROP `enable_moneygram`,
	DROP `moneygram_id_types`,
	DROP `enable_2checkout`,
	DROP `checkout_number`,
	DROP `checkout_publishable_key`,
	DROP `checkout_private_key`,
	DROP `checkout_secret_word`,
	DROP `checkout_currency_code`,
	DROP `checkout_sandbox`;
	ALTER TABLE `payouts`
	DROP `ref_no`,
	DROP `receipt_image`;
	ALTER TABLE `proposals` DROP `proposal_video_type`;
	DROP TABLE `seller_settings`;
	");
}
delete_plugin();
