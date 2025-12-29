<?php
$table_name = $app->getPostVar('table_name');
$old_positions = $app->getPostVar('old_position');
$new_positions = $app->getPostVar('new_position');
$id = $app->getPostVar('id');
$old_index = $app->getPostVar("old_in");
$new_index = $app->getPostVar("new_in");
$type_field = $app->getPostVar("type_field");
$type_value = $app->getPostVar("type_value");
$sql_type_clause=($type_field!='' && $type_value!=''?" AND ".$type_field."='".$type_value."'":"");
if(is_numeric($old_index) && is_numeric($new_index) && $id>0){
	if($new_index < $old_index){
		for($i=$old_index;$i>$new_index;$i--){
			$obj_model_table = $app->load_model($table_name);
			$sql = "update ".$table_name." SET sort_order = ".$old_positions[$i]." WHERE sort_order = ".$new_positions[$i].$sql_type_clause;
			$rs_sort_order=$obj_model_table->execute("UPDATE",false,$sql);
		}
	}
	if($new_index > $old_index){
		for($i=$old_index;$i<$new_index;$i++){
			$obj_model_table = $app->load_model($table_name);
			$sql = "update ".$table_name." SET sort_order = ".$old_positions[$i]." WHERE sort_order = ".$new_positions[$i].$sql_type_clause;
			$rs_sort_order=$obj_model_table->execute("UPDATE",false,$sql);
		}
	}
	$new_order=$old_positions[$new_index];
	if($new_order>0){
		$obj_model_table = $app->load_model($table_name, $id);
		$edit_field = array();
		$edit_field["sort_order"] = $new_order;	
		$obj_model_table->map_fields($edit_field);
		if($obj_model_table->execute("UPDATE",false,"","id=".$id.$sql_type_clause)){
			//add user log for UPDATE
			$app->utility->add_user_log($table_name,$id,"UPDATE",$edit_field);
			echo "OK";
		}
	}
}
?>