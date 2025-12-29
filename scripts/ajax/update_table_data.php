<?php 
$table_id = $app->getPostVar('table_id');
$table_name = $app->getPostVar("table_name");
$field_name = $app->getPostVar("field_name");
$field_value = $app->getPostVar("field_value");
$fields_map = array();
if($table_id>0 && $table_name!='' && $field_name!='' && $field_value!=''){
	$obj_model_table = $app->load_model($table_name, $table_id);
	if($field_name=='nick_name' || $field_name=='name') $field_value=ucwords($field_value);
	$fields_map[$field_name] = $field_value;
	$obj_model_table->map_fields($fields_map);
	if($obj_model_table->execute("UPDATE")){
			// add log for update
		$app->utility->add_user_log($table_name,$table_id,"UPDATE",$fields_map);
		if($table_name=='account_group_relation' && $field_name=='is_disabled'){
			if($field_value=='Yes'){
		// if Agent Role is disabled
				$obj_model_table = $app->load_model($table_name, $table_id);
				$rs_table=$obj_model_table->execute("SELECT");
				if($rs_table[0]["acc_group_id"]==4){
				// update is_default to Yes for Client or Service Provider
					$obj_model_check_default=$app->load_model("account_group_relation");
				// check for client role
					$role_id=$obj_model_check_default->record_exists(array("account_id"=>$rs_table[0]["account_id"],"acc_group_id"=>"3","is_default"=>"No","status"=>"Active"),"id");
				// check for Service provider role
					if(!$role_id){
						$role_id=$obj_model_check_default->record_exists(array("account_id"=>$rs_table[0]["account_id"],"acc_group_id"=>"5","is_default"=>"No","status"=>"Active"),"id");
					}
					if($role_id && $role_id>0){
						$sql_updt="UPDATE account_group_relation SET is_default='".($rs_table[0]['is_default']=='Yes'?'Yes':'No')."' WHERE id=".$role_id." AND status='Active'";
						$obj_model_account_group_relation=$app->load_model("account_group_relation");						
						if($obj_model_account_group_relation->execute("UPDATE",false,$sql_updt)>0){
							//add user log for UPDATE
							$app->utility->add_user_log("account_group_relation",$role_id,"UPDATE",array("is_default"=>($rs_table[0]['is_default']=='Yes'?'Yes':'No'),"account_id"=>$rs_table[0]["account_id"]));
							if($rs_table[0]['is_default']=='Yes'){
							// update is_default to No if Agent Role is disabled
								$obj_model_table = $app->load_model($table_name, $table_id);
								$sql_updt_me="UPDATE account_group_relation SET is_default='No' WHERE id=".$table_id." AND status='Active'";
								if($obj_model_table->execute("UPDATE",false,$sql_updt_me)){
								//add user log for UPDATE
									$app->utility->add_user_log("account_group_relation",$table_id,"UPDATE",array("is_default"=>'No',"account_id"=>$rs_table[0]["account_id"]));
								}
							}
						}					
					}
				}
			}else if($field_value=='No'){
		// if Agent Role is enabled
				$obj_model_table = $app->load_model($table_name, $table_id);
				$rs_table=$obj_model_table->execute("SELECT");
				if($rs_table[0]["acc_group_id"]==4){
				// update is_default to No for Client
					$obj_model_check_default=$app->load_model("account_group_relation");
				// check for client role
					$role_id=$obj_model_check_default->record_exists(array("account_id"=>$rs_table[0]["account_id"],"acc_group_id"=>"3","is_default"=>"Yes","status"=>"Active"),"id");
					if($role_id && $role_id>0){
						$sql_updt="UPDATE account_group_relation SET is_default='".($rs_table[0]['is_default']=='Yes'?'Yes':'No')."' WHERE id=".$role_id." AND status='Active'";
						$obj_model_account_group_relation=$app->load_model("account_group_relation");						
						if($obj_model_account_group_relation->execute("UPDATE",false,$sql_updt)>0){
							//add user log for UPDATE
							$app->utility->add_user_log("account_group_relation",$role_id,"UPDATE",array("is_default"=>($rs_table[0]['is_default']=='Yes'?'Yes':'No'),"account_id"=>$rs_table[0]["account_id"]));
							if($rs_table[0]['is_default']=='No'){
							// update is_default to Yes if Agent Role is disabled
								$obj_model_table = $app->load_model($table_name, $table_id);
								$sql_updt_me="UPDATE account_group_relation SET is_default='Yes' WHERE id=".$table_id." AND status='Active'";
								if($obj_model_table->execute("UPDATE",false,$sql_updt_me)){
								//add user log for UPDATE
									$app->utility->add_user_log("account_group_relation",$table_id,"UPDATE",array("is_default"=>'Yes',"account_id"=>$rs_table[0]["account_id"]));
								}
							}
						}					
					}
				}

			}
		}
		if($table_name=='booking_inquiry' && $field_name=='inquiry_status'){
			// delete notification
			$app->utility->notification_action('Inquiry',$table_id,'DELETE');
		}
		echo "OK";
	}else{
		echo "CANCEL";
	}
}else{
	echo "Oops... Problem in update record. Please try again."; 
}		
?>
