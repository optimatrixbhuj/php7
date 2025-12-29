<?php	
if($app->getPostVar('sms_template_id') != NULL){
	$obj_sms_template = $app->load_model("sms_template");
	$rs_sms_template = $obj_sms_template->execute("SELECT", false, "", "id=".$app->getPostVar('sms_template_id'));
	if(count($rs_sms_template)>0){
		$data = $rs_sms_template;
	}
	else{
		$data  = "";	
	}				
	echo json_encode($data);			 	
}	
?>