<?php 
session_start();
include("../../../includes/db.php");
include("../functions/payment.php");
require_once("../../../functions/processing_fee.php");
if(!isset($_SESSION['seller_user_name'])){
	header("location: $site_url/login");
}

function escape($value){
  return htmlentities($value,ENT_QUOTES,'UTF-8');
}

if(isset($_POST['2Checkout'])){
	$select_offers = $db->select("send_offers",array("offer_id" => escape($_SESSION['c_offer_id'])));
	$row_offers = $select_offers->fetch();
	$proposal_id = $row_offers->proposal_id;
	$amount = $row_offers->amount;
	$processing_fee = processing_fee($amount);

	$select_proposals = $db->select("proposals",array("proposal_id" => $proposal_id));
	$row_proposals = $select_proposals->fetch();
	$proposal_title = $row_proposals->proposal_title;

	$data = [];
	$data['type'] = "offer";
	$data['product_id'] = escape($_SESSION['c_offer_id']);
	$data['name'] = escape($proposal_title);
	$data['qty'] = 1;
	$data['price'] = escape($amount);
	$data['sub_total'] = escape($amount);

	$payment = new Payment();
	$payment->twoCheckout($data,$processing_fee);
}else{
	header("location: $site_url/index");
}