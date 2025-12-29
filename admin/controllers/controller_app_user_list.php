<?php
class _app_user_list extends controller{		
	function init(){		
	}
	
	function onload(){
		if($this->app->getGetVar('destroy')==1){
			unset($_SESSION['app_user_search']);
			$this->app->redirect("index.php?view=app_user_list");
		}
		$this->assign("manager_for", "");			
		if($this->app->getCurrentAction()==""){
			$this->load_data();
		}
	}
	
	function search(){
		unset($_SESSION['app_user_search']);
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
		
		$obj_model_ = $this->app->load_model("");
		$obj_model_->set_paging_settings($_SESSION['records'],5);	
		
		/* Search By */		
		if($this->app->getPostVar("name")!=""){
			$_SESSION['app_user_search']['name'] = $this->app->getPostVar("name");
		}		
		$sql_where_clause = "";
		if(isset($_SESSION['app_user_search']['name'])){
			$name = $_SESSION['app_user_search']['name'];
			$sql_where_clause .=($sql_where_clause!=''?" AND ":""). "name like '%".$name."%'";
			$this->assign("field_name", $_SESSION['app_user_search']['name']);
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
			$_SESSION['order_by_field_name'] = ".id";	
			$_SESSION['order_by'] = "DESC";
			$_SESSION['view'] = $this->app->getRequestVar("view");
		}else{
			$_SESSION['order_by_field_name'] = ".id";	
			$_SESSION['order_by'] = "DESC";
			$_SESSION['view'] = $this->app->getRequestVar("view");
		}
		$order_by_field_name = $_SESSION['order_by_field_name'];
		$order_by = $_SESSION['order_by'];
		$sql_order_by_clause = "";
		if($order_by != ""){
			$sql_order_by_clause = $order_by_field_name. " " .$order_by;
		}
		
		if($this->app->getGetVar('recycle')== true){
			$sql_where_clause=($sql_where_clause==''?".status='Inactive'":".status='Inactive' and ".$sql_where_clause);
		}else{
			$sql_where_clause=($sql_where_clause==''?".status='Active'":".status='Active' and ".$sql_where_clause);
		}
	
		$rs = $obj_model_->execute("SELECT", true, "", $sql_where_clause, $sql_order_by_clause);		
		$data = $this->app->compile();
		$this->load_parser($data);
		$this->parser->assign("PAGING", $obj_model_->show_paging());
		$this->parser->assign("PAGE_NO", $this->app->getCurrentPage());
		$this->parser->assign("SHOW_HIDE", (count($rs)>0)?"none":"");

		$i = 1;
		$Sr = $obj_model_->get_serial_start();
		foreach($rs as $){
			$this->parser->assign("", $);
			$this->parser->assign("ROW_CLASS", ($i%2)==0?"even":"odd");
			$this->parser->assign("STATUS", ($['status'])=="Active"?"active.png":"inactive.png");
			$this->parser->assign("COUNT", $i);
			$this->parser->assign("SERIAL", $Sr);
			$this->parser->parse('main.app_user_table.app_user_row');
			$i++;
			$Sr++;
		}
		$this->parser->parse('main.app_user_table');		
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
			$obj_model_ = $this->app->load_model("");
			$obj_model_->map_fields($edit_field);
			$is_delete[] = $obj_model_->execute("UPDATE", false, "", "id=".$del_id[$i]);
			//add user log for DELETE
			$this->app->utility->add_user_log("",$del_id[$i],"DELETE");
		}
		
		if(count($is_delete)>0){
			$this->app->utility->set_message("Records deleted successfully", "SUCCESS");
		}else{
			$this->app->utility->set_message("Problem in delete record", "ERROR");
		}
		$this->app->redirect("index.php?view=app_user_list");
	}
	
	function single_delete(){
		$edit_field=array();
		$edit_field['status']='Inactive';
		$obj_model_ = $this->app->load_model("",  $this->app->getPostVar('id'));
		$obj_model_->map_fields($edit_field);
		if($obj_model_->execute("UPDATE")){
			//add user log for DELETE
			$this->app->utility->add_user_log("",$this->app->getPostVar('id'),"DELETE");
			$this->app->utility->set_message("Record deleted successfully", "SUCCESS");
		}else{
			$this->app->utility->set_message("Problem in delete record", "ERROR");
		}
		$this->app->redirect("index.php?pg_no=".$this->app->getPostVar('page_no')."&view=app_user_list");			
	}
	
	function recycle(){
		$edit_field=array();
		$edit_field['status']='Active';
		$obj_model_ = $this->app->load_model("",  $this->app->getPostVar('id'));
		$obj_model_->map_fields($edit_field);
		if($obj_model_->execute("UPDATE")){
			//add user log for RESTORE
			$this->app->utility->add_user_log("",$this->app->getPostVar('id'),"RESTORE");
			$this->app->utility->set_message("Record restored successfully", "SUCCESS");
		}else{
			$this->app->utility->set_message("Problem in restore record", "ERROR");
		}
		$this->app->redirect("index.php?pg_no=".$this->app->getPostVar('page_no')."&view=app_user_list");			
	}
}	
?>