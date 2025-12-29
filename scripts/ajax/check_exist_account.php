<?php
	define("VIR_DIR","scripts/ajax/");
	require("../../core/app.php");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	
	$app = & app::get_instance();
	$app->initialize();
	$valid = "true";
	//print_r($app->getPostVars());
	$field_name = $app->getGetVar('field_name');
	$field_value = $app->getGetVar('field_value');	
	$mobile=$app->getPostVar('mobile');
	$email=$app->getPostVar('email');
	$name=$app->getPostVar("name");
	$id=$app->getPostVar('id');
	
	$obj_account = $app->load_model("account");
	if(!is_numeric($name) && $name!=''){
		$sql_where = "account.name='".$name."' AND account.status='Active'";
		if($mobile!='' && $email!=''){
			$sql_where.=" AND (account.mobile='".$mobile."' OR account.email='".$email."')";	
		}else{
			if($mobile!=''){
				$sql_where.=" AND account.mobile='".$mobile."'";	
			}
			if($email!=''){
				$sql_where.=" AND account.email='".$email."'";	
			}
		}
		if($id!='' && $id>0){
			$sql_where.=" AND account.id != ".$id;
		}
		$rs = $obj_account->execute("SELECT",false,"",$sql_where,"","");	
		//echo $obj_account->sql;
		if(count($rs) > 0){
			$valid = "false";
		}
	}
	echo $valid;
	
?>