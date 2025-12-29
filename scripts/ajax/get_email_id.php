<?php
	$table=$app->getPostVar("table_name");
	$id=$app->getPostVar("id");
	$email="";	
	if($table=='invoice_master'){
		$obj_model_invoice_master = $app->load_model("invoice_master",$id);
		$obj_model_invoice_master->join_table("customer_detail","left",array("email_id"),array("bill_party_id"=>"id"));
		$rs_invoice_master = $obj_model_invoice_master->execute("SELECT");		
		if(count($rs_invoice_master)>0){
			$email=$rs_invoice_master[0]['customer_detail_email_id'];
		}
	}
	echo $email;
?>