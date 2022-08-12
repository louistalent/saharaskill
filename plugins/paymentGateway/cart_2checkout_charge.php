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

if(isset($_POST['2Checkout'])){
	$payment = new Payment();
	$data = [];
	$data['type'] = "cart";
	
	$select_cart =  $db->select("cart",array("seller_id" => $login_seller_id));
	$count_cart = $select_cart->rowCount();
	$sub_total = 0;
	while($row_cart = $select_cart->fetch()){
		$proposal_price = $row_cart->proposal_price;
		$proposal_qty = $row_cart->proposal_qty;
		$cart_total = $proposal_price * $proposal_qty;
		$sub_total += $cart_total;
	}
	$amount = $sub_total;

	$processing_fee = processing_fee($amount);
	$data['name'] = "All Cart Proposals Payment";
	$data['qty'] = "1";
	$data['price'] = escape($amount);
	$data['sub_total'] = escape($amount);
	$payment->twoCheckout($data,$processing_fee);
}else{
	header("location: $site_url/index");
}