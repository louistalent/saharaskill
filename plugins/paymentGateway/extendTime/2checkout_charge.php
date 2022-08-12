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
	
	$extendId = $_SESSION['extendId'];
	$order_id = $_SESSION['extendOrderId'];
	$proposal_id = $_SESSION['extendProposalId'];
	
	// proposal
	$select_proposals = $db->select("proposals",array("proposal_id"=>$proposal_id));
	$row_proposal = $select_proposals->fetch();
	// extend_time
	$extend_time = $db->select("order_extend_time",array("id"=>$extendId,"order_id"=>$order_id))->fetch();
	$amount = $extend_time->extended_minutes*$extend_time->price_per_minute;

	$processing_fee = processing_fee($amount);

	$payment = new Payment();
	$data = [];
	$data['type'] = "orderExtendTime";
	$data['product_id'] = escape($extendId);
	$data['name'] = escape($row_proposal->proposal_title);
	$data['qty'] = 1;
	$data['price'] = escape($amount);

	$payment->twoCheckout($data,$processing_fee);
	
}else{
	header("location: $site_url/index");
}