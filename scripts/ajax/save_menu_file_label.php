<?php //print_r($app->getPostVars());exit;
	$file_name = $app->getPostVar('file_name');
	$parameters = $app->getPostVar('parameters');
	$file_label = ucwords($app->getPostVar("file_label"));
	$fields_map = array();	
	if($file_label!='' && $file_name!=''){
		$updated=false;
		//check if file_name added for module
		$obj_model_access = $app->load_model("menu_file_label");
		$access_id=$obj_model_access->record_exists(array("file_name"=>$file_name,"parameters"=>$parameters,"status"=>"Active"),"id");		
		if($access_id>0){
			$obj_model_access = $app->load_model("menu_file_label",$access_id);
			$fields_map['file_name'] = $file_name;
			$fields_map['file_label'] = $file_label;
			$fields_map['parameters'] = $parameters;
			$obj_model_access->map_fields($fields_map);			
			if($obj_model_access->execute("UPDATE",false,"","id=".$access_id)){
				$updated=true;
				// add user log for update
				$app->utility->add_user_log("menu_file_label",$access_id,"UPDATE",$fields_map);
			}
		}else{
			$obj_model_access = $app->load_model("menu_file_label");
			$fields_map['file_name'] = $file_name;
			$fields_map['file_label'] = $file_label;
			$fields_map['parameters'] = $parameters;
			$fields_map['admin_user_id']=$_SESSION['admin_user_id'];	
			$obj_model_access->map_fields($fields_map);
			$inserted_id=$obj_model_access->execute("INSERT");
			if($inserted_id>0){
				$updated=true;
				// add user log for insert
				$app->utility->add_user_log("menu_file_label",$inserted_id,"INSERT",$fields_map);
			}
		}
		if($updated){
			echo "OK";
		}else{
			echo "CANCEL";
		}
	}else{
		echo "Ooops... Problem in update record. Please try again."; 
	}		
?>
