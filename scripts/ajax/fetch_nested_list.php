<?php
	$branch_id = $app->getPostVar('branch_id');
	$skip_group_array=explode(",", $app->getPostVar('skip_group'));

	$acc_group=array();
	$acc_group[0]["id"]="";
	$acc_group[0]["group_name"]="-- Select Account Group --";

	if($branch_id>0){
		$acc_group_arr=$app->utility->fetch_nested_list("account_group","group_name","parent_id",$branch_id);	
		foreach($acc_group_arr as $group){
			//Skip Groups
			if(in_array($group['parent_id'], $skip_group_array) || in_array($group['id'], $skip_group_array)){

			}else{
				$temp=array();
				$temp['id']=$group['id'];
				$temp['group_name']=$group['group_name'];
				$acc_group[]=$temp;			
			}			
		}	
	}
	echo json_encode($acc_group);
?>