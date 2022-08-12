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

$login_seller_user_name = escape($_SESSION['seller_user_name']);
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;

if(isset($_POST['2Checkout'])){
	$payment = new Payment();
	$data = [];
	$data['type'] = "message_offer";
	
	$select_offers = $db->select("messages_offers",array("offer_id" => escape($_SESSION['c_message_offer_id'])));
	$row_offers = $select_offers->fetch();
	$proposal_id = $row_offers->proposal_id;
	$amount = $row_offers->amount;
	$processing_fee = processing_fee($amount);

	$select_proposals = $db->select("proposals",array("proposal_id" => $proposal_id));
	$row_proposals = $select_proposals->fetch();
	$proposal_title = $row_proposals->proposal_title;

	$data['product_id'] = escape($_SESSION['c_message_offer_id']);
	$data['name'] = escape($proposal_title);
	$data['qty'] = 1;
	$data['price'] = escape($amount);
	
	$payment->twoCheckout($data,$processing_fee);
}else{
	header("location: $site_url/index");
}