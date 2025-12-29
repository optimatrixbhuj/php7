<?php
define("VIR_DIR","../scripts/ajax/");
require("../../core/app.php");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

$app = & app::get_instance();
$app->initialize();

$field_name = $app->getGetVar('field_name');
$field_value = $app->getPostVar($field_name);
$id=$app->getGetVar('id');
$branch_id=$app->getGetVar("branch_id");
if($app->getPostVar("branch_id")!=""){
	$branch_id=$app->getPostVar("branch_id");
}
$table_name = $app->getGetVar('table_name');
$sql_clause='';

if($table_name=='menu_file_label'){
	$parameters = $app->getPostVar('parameters');
	if($parameters!=''){
		$sql_clause.=" AND (menu_file_label.parameters='".$parameters."')";
	}
}
$where_query='';
if (($field_name=='mobile' || $field_name=='contact_number') && $table_name=='account') {
	$where_query="(mobile='".$field_value."' OR contact_number='".$field_value."')";
}else{
	$where_query=$field_name."='".$field_value."'";
}

$obj_model = $app->load_model($table_name);
if($id!=""){
	$rs = $obj_model->execute("SELECT",false,"",$where_query." AND status='Active' AND id!=".$id.(isset($branch_id) && $branch_id!=''?" AND branch_id IN ('0','".$branch_id."')":"").$sql_clause,"","");
}else{
	$rs = $obj_model->execute("SELECT",false,"",$where_query." and status='Active'".(isset($branch_id) && $branch_id!=''?" AND branch_id IN ('0','".$branch_id."')":"").$sql_clause,"","");	
}
$valid = "true";
if(count($rs) > 0){
	$valid = "false";
}
echo $valid;
?>