<?php
$table_name = $app->getPostVar('table_name');
$key = $app->getPostVar('key');
$value = $app->getPostVar('value');
$where_condition=$app->getPostVar('where_condition');	
$where_sql = ($where_condition!=""?" AND ".$where_condition:"");

$obj_model_table = $app->load_model($table_name);
$rs_table = $obj_model_table->execute("SELECT",false,"","status='Active'".$where_sql."".$where_clause,$value);	
$data = array();
$x=0;
if($table_name=='sp_driver' && strpos($where_condition, 'service_provider_id=') === 0){
	$sp_id=end(explode("=", $where_condition));
	// get service provider as driver
	$obj_model_sp=$app->load_model("account",$sp_id);
	$obj_model_sp->join_table("account_group_relation","left",array("id"),array("id"=>"account_id"));
	$rs_sp=$obj_model_sp->execute("SELECT",false,"","account.status='Active' AND account_group_relation.acc_group_id=5 AND account_group_relation.status='Active' AND account.is_user='Yes'");
	if(count($rs_sp)>0){
		$data[$x][$key] = 'sp_'.$sp_id;
		$data[$x][$value] = ($app->getPostVar("from")!='admin'?"You - ":"Service Provider - ").$rs_sp[0]['name']." (".$rs_sp[0]['mobile'].")";
		$x++;
	}
}
if(count($rs_table)>0){
	foreach ($rs_table as $table) {
		$data[$x][$key] = $table[$key];
		$data[$x][$value] = ucwords($table[$value]).($table_name=='sp_driver' && $value=='name' && $table['mobile']!=''?" (".$table['mobile'].")":"");
		$x++;
	}
}
echo json_encode($data);
?>