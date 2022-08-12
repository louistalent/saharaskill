<?php 

session_start();
include("../../includes/db.php");
include("functions/payment.php");
require_once("../../functions/processing_fee.php");
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
$processing_fee = processing_fee($_SESSION['c_sub_total']);

if(isset($_POST['2Checkout'])){
	$payment = new Payment();
	$data = [];
	$data['type'] = "proposal";
	
	$select_proposals = $db->select("proposals",array("proposal_id" => escape($_SESSION['c_proposal_id'])));
	$row_proposals = $select_proposals->fetch();
	$proposal_title = $row_proposals->proposal_title;

	$data['product_id'] = escape($_SESSION['c_proposal_id']);
	$data['name'] = escape($proposal_title);
	$data['qty'] = escape($_SESSION['c_proposal_qty']);
	$data['price'] = escape($_SESSION['c_proposal_price']);

	if(isset($_SESSION['c_proposal_extras'])){
		$data['extras'] = $_SESSION['c_proposal_extras'];
	}

	if(isset($_SESSION['c_proposal_minutes'])){
		$data['proposal_minutes'] = $_SESSION['c_proposal_minutes'];
	}

	$payment->twoCheckout($data,$processing_fee);
	
}else{
	header("location: $site_url/index");
}