<?php

session_start();
require_once("../../includes/db.php");
require_once("functions/payment.php");
if(!isset($_SESSION['seller_user_name'])){
	header("location: $site_url/login");
}
	
$payment = new Payment();
$payment->twoCheckout_execute();