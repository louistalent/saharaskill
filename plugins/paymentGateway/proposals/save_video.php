<?php

session_start();
require_once("../../../includes/db.php");
if(!isset($_SESSION['seller_user_name'])){
	header("location: $site_url/login");
}

if(isset($_POST["proposal_id"])){
	$data = $input->post();
	unset($data['proposal_id']);

	function removeJava($html){
		$attrs = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavaible', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragdrop', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterupdate', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmoveout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
		$dom = new DOMDocument;
		$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
		$nodes = $dom->getElementsByTagName('*');//just get all nodes, 
		foreach($nodes as $node){
		  foreach ($attrs as $attr){
			  if($node->hasAttribute($attr)){
			  	$node->removeAttribute($attr); 
			  } 
		  }
		}
		return strip_tags($dom->saveHTML(),"<iframe>");
	}

	if(!empty($_FILES["proposal_file"]["name"])){
		$file = $_FILES["proposal_file"]["name"];
		$file_tmp = $_FILES["proposal_file"]["tmp_name"];

		$file_extension = pathinfo($file, PATHINFO_EXTENSION);
		$file = pathinfo($file, PATHINFO_FILENAME);
		$file = $file."_".time().".$file_extension";
		move_uploaded_file($file_tmp, "../../../proposals/proposal_files/$file");

		$data['proposal_video_type'] = "uploaded";
		$data['proposal_video'] = $file;
	}else{
		$data['proposal_video'] = removeJava($_POST['proposal_video']);
		$data['proposal_video_type'] = "embedded";
	}

	$proposal_id = strip_tags($input->post('proposal_id'));
	$update_proposal = $db->update("proposals",$data,array("proposal_id"=>$proposal_id));

	echo htmlspecialchars($data['proposal_video'],ENT_QUOTES,'UTF-8');
}