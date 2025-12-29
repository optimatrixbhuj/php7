<?php 
$value=$app->getPostVar('value');
$field=$app->getPostVar('field');
$table=$app->getPostVar('table');
$branch_id=$app->getPostVar("branch_id");
$type=$app->getPostVar("type"); 			// Cargo / Courier
$sql_where = $field." like '%".$value."%'";	
if($app->getPostVar('value') != NULL && $app->getPostVar('field') != NULL){
	if($branch_id!=''){
		$sql_where.=" and branch_id=".$branch_id;
	}
	if($type!=''){
		$sql_where.=" and type='".$type."'";
	}
	if($branch_id!='' && $branch_id>0){
		$sql_where.=" and branch_id IN (0,".$branch_id.")";
	}
	
	$obj_model_table = $app->load_model($table);
	$rs_table = $obj_model_table->execute("SELECT",false,"",$sql_where.($table!='state_code'?" and status='Active'":""),$field." ASC",$field);
	//echo $obj_model_table->sql;
	if(count($rs_table)>0){
		$data = $rs_table;
	}else{
		$data  = "";	
	}				
	echo json_encode($data);
}
//echo $user;
?>