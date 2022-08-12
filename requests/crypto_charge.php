<?php 
session_start();
include("../includes/db.php");
include("../functions/payment.php");
include("../functions/functions.php");
if(!isset($_SESSION['seller_user_name'])){
echo "<script>window.open('../login.php','_self');</script>";
}

if(isset($_POST['coinpayments'])){

	$select_offers = $db->select("send_offers",array("offer_id" => $_SESSION['c_offer_id']));
	$row_offers = $select_offers->fetch();
	$request_id = $row_offers->request_id;
	$proposal_id = $row_offers->proposal_id;
	$amount = $row_offers->amount;
	$processing_fee = processing_fee($amount);

	$select_proposals = $db->select("proposals",array("proposal_id" => $proposal_id));
	$row_proposals = $select_proposals->fetch();
	$proposal_title = $row_proposals->proposal_title;

	$reference_no = mt_rand();

	$data = [];
	$data['type'] = "request_offer";
	$data['content_id'] = $_SESSION['c_offer_id'];
	$reference_no = mt_rand();
	$data['reference_no'] = $reference_no;
	$data['name'] = $proposal_title;
	$data['qty'] = 1;
	$data['sub_total'] = $amount;
	$data['total'] = $amount+$processing_fee;

	$data['cancel_url'] = "$site_url/cancel_payment?reference_no=$reference_no";

	$payment = new Payment();
	$payment->coinpayments($data,$processing_fee);

}else{
	echo "<script>window.open('../index','_self');</script>";
}