<?php
class _user_logs_list extends controller{		
	function init(){
		
	}
	
	function onload(){
		if($this->app->getGetVar('destroy')==1){
			unset($_SESSION['user_logs_search']);
			$this->app->redirect("index.php?view=user_logs_list");
		}

		if($_SESSION['admin_user_group_id']=='1'){
			//fetch branch
			$branch=$this->app->utility->get_dropdown("branch","id","name","All Branch","","name","","ALL");
			$this->assign("branch",$branch);
		}		

		// fetch User Names
		$user_where = (($_SESSION['admin_user_group_id']!='1')?"branch_id = ".$_SESSION['branch_id']:"");
		
		$users=$this->app->utility->get_dropdown("admin_user","id","full_name","Select User",$user_where,"full_name");
		$this->assign("users",$users);				
		
		$this->assign("manager_for", "User Logs");			
		if($this->app->getCurrentAction()==""){
			$this->load_data();
		}
	}
	
	function search(){
		unset($_SESSION['user_logs_search']);
		$this->load_data();
	}
	
	function load_data(){
		$obj_model_user_logs = $this->app->load_model("user_logs");
		$obj_model_user_logs->join_table("admin_user","left",array("full_name","branch_id"),array("admin_user_id"=>"id"));
		$obj_model_user_logs->set_paging_settings($_SESSION['records'],5);	
		
		/* ===== SEARCH RECORD CODE STARTS HERE ===== */
		if($this->app->getPostVar("user_id")!=""){
			$_SESSION['user_logs_search']['user_id'] = $this->app->getPostVar("user_id");
		}
		if($this->app->getPostVar("table_name")!=""){
			$_SESSION['user_logs_search']['table_name'] = $this->app->getPostVar("table_name");
		}
		if($this->app->getPostVar("table_id")!=""){
			$_SESSION['user_logs_search']['table_id'] = $this->app->getPostVar("table_id");
		}
		if($this->app->getPostVar("action")!=""){
			$_SESSION['user_logs_search']['action'] = $this->app->getPostVar("action");
		}
		if($this->app->getPostVar("date")!=""){
			$_SESSION['user_logs_search']['date'] = $this->app->getPostVar("date");
		}
		if($this->app->getPostVar("description")!=""){
			$_SESSION['user_logs_search']['description'] = $this->app->getPostVar("description");
		}
		if($this->app->getPostVar("branch_id")!=""){
			$_SESSION['user_logs_search']['branch_id'] = $this->app->getPostVar("branch_id");
		}		
		$sql_where_clause = "";
		if(isset($_SESSION['user_logs_search']['user_id'])){
			$user_id = $_SESSION['user_logs_search']['user_id'];
			$sql_where_clause .=($sql_where_clause!=''?" AND ":"")."admin_user_id =".$user_id;
			$this->assign("field_user_id", $_SESSION['user_logs_search']['user_id']);
		}
		if(isset($_SESSION['user_logs_search']['table_name'])){
			$table_name = $_SESSION['user_logs_search']['table_name'];
			$sql_where_clause .=($sql_where_clause!=''?" AND ":"")."table_name like '%".$table_name."%'";
			$this->assign("field_table_name", $_SESSION['user_logs_search']['table_name']);
		}
		if(isset($_SESSION['user_logs_search']['table_id'])){
			$table_id = $_SESSION['user_logs_search']['table_id'];
			$sql_where_clause .=($sql_where_clause!=''?" AND ":"")."table_id =".$table_id;
			$this->assign("field_table_id", $_SESSION['user_logs_search']['table_id']);
		}
		if(isset($_SESSION['user_logs_search']['action'])){
			$action = $_SESSION['user_logs_search']['action'];
			$sql_where_clause .=($sql_where_clause!=''?" AND ":"")."action like '%".$action."%'";
			$this->assign("field_action", $_SESSION['user_logs_search']['action']);
		}
		if(isset($_SESSION['user_logs_search']['date'])){
			$date = date("Y-m-d",strtotime($_SESSION['user_logs_search']['date']));
			$sql_where_clause .=($sql_where_clause!=''?" AND ":"")."DATE(user_logs.changed_on) = '".$date."'";
			$this->assign("field_date", $_SESSION['user_logs_search']['date']);
		}
		if(isset($_SESSION['user_logs_search']['description'])){
			$description = $_SESSION['user_logs_search']['description'];
			$sql_where_clause .=($sql_where_clause!=''?" AND ":"")."description like '%".$description."%'";
			$this->assign("field_description", $_SESSION['user_logs_search']['description']);
		}
		if(isset($_SESSION['user_logs_search']['branch_id'])){
			$branch_id = $_SESSION['user_logs_search']['branch_id'];
			if($branch_id!="ALL"){
				$sql_where_clause .=($sql_where_clause!=''?" AND ":""). "admin_user.branch_id =".$branch_id;
			}
			$this->assign("field_branch_id", $_SESSION['user_logs_search']['branch_id']);
		}		
		/* ===== SEARCH RECORD CODE END HERE ===== */
		
		/* ===== IF REQUIRED TO SET ORDER BY FOR RECORDS ======== */
		if($this->app->getRequestVar("order_by_field_name") != "" && $this->app->getRequestVar("order_by") != "")
		{
			$order_by = $this->app->getRequestVar("order_by");
			$_SESSION['order_by_field_name'] = $this->app->getRequestVar("order_by_field_name");	
			$_SESSION['order_by'] = $this->app->getRequestVar("order_by");
			$_SESSION['view'] = $this->app->getRequestVar("view");
			$this->assign("order_by",($order_by=='' || $order_by=='DESC'?'ASC':'DESC'));
		}elseif(isset($_SESSION['order_by_field_name']) && $_SESSION['order_by_field_name'] != "" && isset($_SESSION['order_by']) && $_SESSION['order_by'] != "" && isset($_SESSION['view']) && $_SESSION['view'] != $this->app->getRequestVar("view")){
			$_SESSION['order_by_field_name'] = "user_logs.id";	
			$_SESSION['order_by'] = "DESC";
			$_SESSION['view'] = $this->app->getRequestVar("view");
		}else{
			$_SESSION['order_by_field_name'] = "user_logs.id";	
			$_SESSION['order_by'] = "DESC";
			$_SESSION['view'] = $this->app->getRequestVar("view");
		}
		$order_by_field_name = $_SESSION['order_by_field_name'];
		$order_by = $_SESSION['order_by'];
		$sql_order_by_clause = "";
		if($order_by != ""){
			$sql_order_by_clause = $order_by_field_name. " " .$order_by;
		}
		/* ===== IF REQUIRED TO SET ORDER BY  RECORDS ======== */
		
		if($_SESSION['admin_user_group_id']!='1'){
			$sql_where_clause.=($sql_where_clause!=''?" AND ":"")." admin_user.branch_id=".$_SESSION['branch_id'];
		}
		
		$rs = $obj_model_user_logs->execute("SELECT", true, "", $sql_where_clause, $sql_order_by_clause);		
		$data = $this->app->compile();
		$this->load_parser($data);
		$this->parser->assign("PAGING", $obj_model_user_logs->show_paging());
		$this->parser->assign("PAGE_NO", $this->app->getCurrentPage());
		$this->parser->assign("SHOW_HIDE", (count($rs)>0)?"none":"");

		$i = 1;
		$Sr = $obj_model_user_logs->get_serial_start();
		foreach($rs as $user_logs){
			if($_SESSION['admin_user_group_id']=='1' && $user_logs['admin_user_full_name']!=""){
				$obj_model_branch = $this->app->load_model("branch",$user_logs['admin_user_branch_id']);
				$rs_branch = $obj_model_branch->execute("SELECT");		
				if(count($rs_branch)>0){
					$user_logs['admin_user_full_name']=$user_logs['admin_user_full_name']."<br>(".$rs_branch[0]['name'].")";
				}
			}
			$this->parser->assign("user_logs", $user_logs);
			$this->parser->assign("CHANGED_ON", date("d-m-Y g:i A",strtotime($user_logs['changed_on'])));
			$this->parser->assign("ROW_CLASS", ($i%2)==0?"even":"odd");
			$this->parser->assign("COUNT", $i);
			$this->parser->assign("SEARIAL", $Sr);
			$this->parser->parse('main.user_logs_table.user_logs_row');
			$i++;
			$Sr++;
		}
		$this->parser->parse('main.user_logs_table');		
		$this->parser->parse('main');			
		$this->update_ouput($this->parser->text('main'));
		$this->unload_parser();	
	}		
}	
?>