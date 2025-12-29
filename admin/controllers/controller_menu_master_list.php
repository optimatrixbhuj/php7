<?php
class _menu_master_list extends controller{		
	function init(){		
	}
	
	function onload(){
		if($this->app->getGetVar('destroy')==1){
			unset($_SESSION['menu_master_search']);
			$this->app->redirect("index.php?view=menu_master_list");
		}
		$this->assign("manager_for", "menu master");			
		if($this->app->getCurrentAction()==""){
			$this->load_data();
		}
	}
	
	function search(){
		unset($_SESSION['menu_master_search']);
		$this->load_data();
	}
	
	function load_data(){
		if($this->app->getGetVar('recycle')== true){
			$recycle = $this->app->getGetVar('recycle');
			$this->assign("recycle", true);
		}else{
			$recycle = false;
			$this->assign("recycle", false);
		}
		
		$obj_model_menu_master = $this->app->load_model("menu_master");
		$obj_model_menu_master->set_paging_settings($_SESSION['records'],5);	
		
		/* Search By */		
		if($this->app->getPostVar("label")!=""){
			$_SESSION['menu_master_search']['label'] = $this->app->getPostVar("label");
		}		
		$sql_where_clause = "";
		if(isset($_SESSION['menu_master_search']['label'])){
			$label = $_SESSION['menu_master_search']['label'];
			$sql_where_clause .=($sql_where_clause!=''?" AND ":""). "label like '%".$label."%'";
			$this->assign("field_label", $_SESSION['menu_master_search']['label']);
		}
		
		/* Search For Order By */
		if($this->app->getRequestVar("order_by_field_name") != "" && $this->app->getRequestVar("order_by") != "")
		{
			$order_by=$this->app->getRequestVar("order_by");
			$_SESSION['order_by_field_name'] = $this->app->getRequestVar("order_by_field_name");	
			$_SESSION['order_by'] = $order_by;
			$_SESSION['view'] = $this->app->getRequestVar("view");
			$this->assign("order_by",($order_by=='' || $order_by=='DESC'?'ASC':'DESC'));
		}elseif(isset($_SESSION['order_by_field_name']) && $_SESSION['order_by_field_name'] != "" && isset($_SESSION['order_by']) && $_SESSION['order_by'] != "" && isset($_SESSION['view']) && $_SESSION['view'] != $this->app->getRequestVar("view")){
			$_SESSION['order_by_field_name'] = "menu_master.sort_order";	
			$_SESSION['order_by'] = "ASC";
			$_SESSION['view'] = $this->app->getRequestVar("view");
		}else{
			$_SESSION['order_by_field_name'] = "menu_master.sort_order";	
			$_SESSION['order_by'] = "ASC";
			$_SESSION['view'] = $this->app->getRequestVar("view");
		}
		$order_by_field_name = $_SESSION['order_by_field_name'];
		$order_by = $_SESSION['order_by'];
		$sql_order_by_clause = "";
		if($order_by != ""){
			$sql_order_by_clause = $order_by_field_name. " " .$order_by;
		}
		
		if($this->app->getGetVar('recycle')== true){
			$sql_where_clause=($sql_where_clause==''?"menu_master.status='Inactive'":"menu_master.status='Inactive' and ".$sql_where_clause);			
		}else{
			$sql_where_clause=($sql_where_clause==''?"menu_master.status='Active'":"menu_master.status='Active' and ".$sql_where_clause);			
		}
		
		$rs = $obj_model_menu_master->execute("SELECT", true, "", $sql_where_clause, $sql_order_by_clause);
		$data = $this->app->compile();
		$this->load_parser($data);
		$this->parser->assign("PAGING", $obj_model_menu_master->show_paging());
		$this->parser->assign("PAGE_NO", $this->app->getCurrentPage());
		$this->parser->assign("SHOW_HIDE", (count($rs)>0)?"none":"");

		$i = 1;
		$Sr = $obj_model_menu_master->get_serial_start();
		foreach($rs as $menu_master){
			$this->parser->assign("menu_master", $menu_master);
			$this->parser->assign("ROW_CLASS", $i%2==0?"even":"odd");
			$this->parser->assign("OWN_ID_CLASS", "data-tt-id='".$menu_master['id']."'");
			$this->parser->assign("PARENT_ID_CLASS", $menu_master['parent_id']==0?"":"data-tt-parent-id='".$menu_master['parent_id']."'");
			$this->parser->assign("align", $menu_master['parent_id']==0?"style='padding-left:10px'":"style='padding-left:10px'");
			$this->parser->assign("STATUS", ($menu_master['status'])=="Active"?"active.png":"inactive.png");
			$this->parser->assign("COUNT", $i);
			$this->parser->assign("SERIAL", $Sr);
			$this->parser->parse('main.menu_master_table.menu_master_row');
			$i++;
			$Sr++;
		}
		$this->parser->parse('main.menu_master_table');		
		$this->parser->parse('main');			
		$this->update_ouput($this->parser->text('main'));
		$this->unload_parser();	
	}
	
	function multi_delete(){
		$del_id = $this->app->getPostVar('del');
		$is_delete = array();
		$edit_field=array();
		$edit_field['status']='Inactive';
		for($i=0;$i<count($del_id);$i++){
			$obj_model_menu_master = $this->app->load_model("menu_master");
			$obj_model_menu_master->map_fields($edit_field);
			$is_delete[] = $obj_model_menu_master->execute("UPDATE", false, "", "id=".$del_id[$i]);
			//add user log for DELETE
			$this->app->utility->add_user_log("menu_master",$del_id[$i],"DELETE");
			// delete from menu_detail
			$obj_model_menu_detail=$this->app->load_model("menu_detail");
			$obj_model_menu_detail->map_fields($edit_field);
			$obj_model_menu_detail->execute("UPDATE",false,"","status='Active' AND menu_master_id=".$del_id[$i]);
		}
		
		if(count($is_delete)>0){
			$this->app->utility->set_message("Records deleted successfully", "SUCCESS");
		}else{
			$this->app->utility->set_message("Problem in delete record", "ERROR");
		}
		$this->app->redirect("index.php?view=menu_master_list");
	}
	
	function single_delete(){
		$edit_field=array();
		$edit_field['status']='Inactive';
		$obj_model_menu_master = $this->app->load_model("menu_master",  $this->app->getPostVar('id'));
		$obj_model_menu_master->map_fields($edit_field);
		if($obj_model_menu_master->execute("UPDATE")){
			//add user log for DELETE
			$this->app->utility->add_user_log("menu_master",$this->app->getPostVar('id'),"DELETE");
			// delete from menu_detail
			$obj_model_menu_detail=$this->app->load_model("menu_detail");
			$obj_model_menu_detail->map_fields($edit_field);
			$obj_model_menu_detail->execute("UPDATE",false,"","status='Active' AND menu_master_id=".$this->app->getPostVar('id'));
			$this->app->utility->set_message("Record deleted successfully", "SUCCESS");
		}else{
			$this->app->utility->set_message("Problem in delete record", "ERROR");
		}
		$this->app->redirect("index.php?pg_no=".$this->app->getPostVar('page_no')."&view=menu_master_list");			
	}
	
	function recycle(){
		$edit_field=array();
		$edit_field['status']='Active';
		$obj_model_menu_master = $this->app->load_model("menu_master",  $this->app->getPostVar('id'));
		$obj_model_menu_master->map_fields($edit_field);
		if($obj_model_menu_master->execute("UPDATE")){
			//add user log for RESTORE
			$this->app->utility->add_user_log("menu_master",$this->app->getPostVar('id'),"RESTORE");
			$this->app->utility->set_message("Record restored successfully", "SUCCESS");
		}else{
			$this->app->utility->set_message("Problem in restore record", "ERROR");
		}
		$this->app->redirect("index.php?pg_no=".$this->app->getPostVar('page_no')."&view=menu_master_list");			
	}
	
	function fetch_nested_menu($sql_where_clause="",$order="",$parent_field="",$parent_id = 0, $spacing = '', $list_array = '') {	 	
	  if (!is_array($list_array))
		$list_array = array();
	 	if($parent_field==""){
			echo "<h2>Function Error </h2><hr><br>.You must provide the name of Parent Field";
		}
		else{
			//$obj_model_table=$this->app->load_model($table);
			$obj_model_table = $this->app->load_model("menu_master");			
			$rs_table=$obj_model_table->execute("SELECT",false,"", $sql_where_clause==''?$parent_field."=".$parent_id:$parent_field."=".$parent_id." and ".$sql_where_clause,$order);		
		  	//echo $obj_model_table->sql."<br>";
			if(count($rs_table) > 0) {
				for($i=0; $i<count($rs_table); $i++){					
					$rs_table[$i]['label']=$spacing .$rs_table[$i]['label'];
					$list_array[] = $rs_table[$i];
					$list_array = $this->fetch_nested_menu($sql_where_clause,$order,$parent_field,$rs_table[$i]['id'], $spacing . '&emsp;&emsp;&emsp;', $list_array);
				}
			}
			return $list_array;
		}
	}	
}	
?>