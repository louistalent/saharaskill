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
	$get_payment_settings = $db->select("payment_settings");
	$row_payment_settings = $get_payment_settings->fetch();
	$featured_fee = $row_payment_settings->featured_fee;
	$processing_fee = processing_fee($featured_fee);

	$select_proposals = $db->select("proposals",array("proposal_id" => escape($_SESSION['f_proposal_id'])));
	$row_proposals = $select_proposals->fetch();
	$proposal_title = $row_proposals->proposal_title;
	
	$payment = new Payment();
	$data = [];
	$data['type'] = "featured_listing";
	$data['product_id'] = escape($_SESSION['f_proposal_id']);
	$data['name'] = escape($proposal_title);
	$data['qty'] = 1;
	$data['price'] = escape($featured_fee);

	$payment->twoCheckout($data,$processing_fee);
}else{
	header("location: $site_url/index");
}