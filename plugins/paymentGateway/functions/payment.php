<?php

$dir = "$dir/plugins/paymentGateway";
class Payment{
	/// 2checkout Payment Code Starts ////

	public function escape($value){
  	return htmlentities($value,ENT_QUOTES,'UTF-8');
	}

	public function twoCheckout($data,$processing_fee){
		global $db;
		global $dir;

		$login_seller_user_name = $this->escape($_SESSION['seller_user_name']);
		$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
		$row_login_seller = $select_login_seller->fetch();
		$login_seller_id = $row_login_seller->seller_id;
		$login_seller_name = $row_login_seller->seller_name;
		$login_seller_email = $row_login_seller->seller_email;
		$login_seller_country = $row_login_seller->seller_country;

		$get_payment_settings = $db->select("payment_settings");
		$row_payment_settings = $get_payment_settings->fetch();
		$checkout_private_key = $row_payment_settings->checkout_private_key;
		$checkout_number = $row_payment_settings->checkout_number;
		$checkout_currency_code = $row_payment_settings->checkout_currency_code;
		$checkout_sandbox = $row_payment_settings->checkout_sandbox;

		// Include 2Checkout PHP library
	  require_once(ROOTPATH."/vendor/2checkout-php/Twocheckout.php");
	  
	  // Set API key
	  Twocheckout::privateKey($checkout_private_key);
	  Twocheckout::sellerId($checkout_number);
	  if($checkout_sandbox == 'on'){
	  	Twocheckout::sandbox(true);
		}elseif($checkout_sandbox == 'off'){
			Twocheckout::sandbox(false);
		}

		try {
			$params = array(
			  'sid' => $checkout_number,
			  'mode' => '2CO',
			  'currency_code' => $checkout_currency_code,
			  'li_0_name' => $data['name'],
			  'li_0_product_id' => $data['product_id'],
			  'li_0_price' => $data['price'],
			  'li_0_quantity' => $data['qty'],
			  'li_1_name' => 'Processing Fee',
			  'li_1_price' => $processing_fee,
			  'li_1_quantity' => '1',
			  'card_holder_name' => $login_seller_name,
			  'email' => $login_seller_email,
			  'country' => $login_seller_country,
			  'content_type' => $data['type'],
			);
			if(isset($data['extras'])){
				$params['proposal_extras'] = $data['extras'];
			}
			if(isset($data['proposal_minutes'])){
				$params['proposal_minutes'] = $data['proposal_minutes'];
			}
			Twocheckout_Charge::redirect($params);
	  }catch(Twocheckout_Error $e){
	    $statusMsg = '<h2>Transaction failed!</h2>';
	    $statusMsg .= '<p>'.$e->getMessage().'</p>';
	  }
	}

	public function twoCheckout_execute(){
		global $db;
		global $dir;
		global $input;
		global $site_url;

		$get_payment_settings = $db->select("payment_settings");
		$row_payment_settings = $get_payment_settings->fetch();
		$checkout_sandbox = $row_payment_settings->checkout_sandbox;
		$checkout_private_key = $row_payment_settings->checkout_private_key;
		$checkout_number = $row_payment_settings->checkout_number;
		$checkout_currency_code = $row_payment_settings->checkout_currency_code;
		$checkout_secret_word = $row_payment_settings->checkout_secret_word;

		// Include 2Checkout PHP library
	  require_once(ROOTPATH."/vendor/2checkout-php/Twocheckout.php");
	  
	  // Set API key
	  Twocheckout::privateKey($checkout_private_key);
	  Twocheckout::sellerId($checkout_number);
	  if($checkout_sandbox == 'on'){
	  	Twocheckout::sandbox(true);
		}elseif($checkout_sandbox == 'off'){
			Twocheckout::sandbox(false);
		}

		$login_seller_user_name = $this->escape($_SESSION['seller_user_name']);
		$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
		$row_login_seller = $select_login_seller->fetch();
		$login_seller_id = $row_login_seller->seller_id;

		try{
		  // Execute the payment
		  $params = array();
			foreach($_REQUEST as $k => $v){
			  $params[$k] = $v;
			}
			$result = Twocheckout_Return::check($params,$checkout_secret_word);
		  if($result['response_code'] = "Success"){
				$type = $input->get("content_type");
				if($type == "proposal"){
					$_SESSION['checkout_seller_id'] = $login_seller_id;
					$_SESSION['proposal_id'] = $input->get('li_0_product_id');
					$_SESSION['proposal_qty'] = $input->get('li_0_quantity');
					$_SESSION['proposal_price'] = $input->get('li_0_price')*$input->get('li_0_quantity');
					if(isset($_GET['proposal_extras'])){
						$_SESSION['proposal_extras'] = $input->get('proposal_extras');
					}
				   if(isset($_GET['proposal_minutes'])){
						$_SESSION['proposal_minutes'] = $input->get('proposal_minutes');
				   }
			  }elseif($type == "cart"){
			  	$_SESSION['cart_seller_id'] = $login_seller_id;
			  }elseif($type == "featured_listing"){
			   $_SESSION['featured_listing'] = "1";
			   $_SESSION['proposal_id'] = $input->get('li_0_product_id');
			  }elseif($type == "offer"){
			  	$_SESSION['offer_id'] = $input->get('li_0_product_id');
			  	$_SESSION['offer_buyer_id'] = $login_seller_id;
			  }elseif($type == "message_offer"){
				$_SESSION['message_offer_id'] = $input->get('li_0_product_id');
				$_SESSION['message_offer_buyer_id'] = $login_seller_id;
			  }

				$_SESSION['method'] = "2checkout";

		      if($type == "featured_listing"){
				  redirect("$site_url/proposals/featured_proposal");
				}elseif($type == "orderExtendTime"){
			  		redirect("$site_url/plugins/videoPlugin/extendTime/charge/order/2Checkout?extendTime=1");
			  	}else{
					redirect("$site_url/order");
				}

		  }else{
		  	redirect("$site_url/index");
		  }
	  }catch(Twocheckout_Error $e){
	    $e->getMessage();
	  }
	}
	/// 2checkout Payment Code Ends ////
}