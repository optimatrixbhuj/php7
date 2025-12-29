<?php
class _sms_template_list extends controller{		
	function init(){		
	}
	
	function onload(){
		if($this->app->getGetVar('destroy')==1){
			unset($_SESSION['sms_template_search']);
			$this->app->redirect("index.php?view=sms_template_list");
		}
		$this->assign("manager_for", "SMS Template");			
		if($this->app->getCurrentAction()==""){
			$this->load_data();
		}
	}
	
	function search(){
		unset($_SESSION['sms_template_search']);
		$this->load_data();
	}
	
	function load_data(){
		$obj_model_sms_template = $this->app->load_model("sms_template");
		$obj_model_sms_template->set_paging_settings($_SESSION['records'],5);	
		
		/* Search By */
		if($this->app->getPostVar("subject")!=""){
			$_SESSION['sms_template_search']['subject'] = $this->app->getPostVar("subject");
		}
		if($this->app->getPostVar("message")!=""){
			$_SESSION['sms_template_search']['message'] = $this->app->getPostVar("message");
		}
		$sql_where_clause = "";
		if(isset($_SESSION['sms_template_search']['subject'])){
			$subject = $_SESSION['sms_template_search']['subject'];
			$sql_where_clause .=($sql_where_clause!=''?" AND ":"")."subject like '%".$subject."%'";
			$this->assign("field_subject", $_SESSION['sms_template_search']['subject']);
		}
		if(isset($_SESSION['sms_template_search']['message'])){
			$message = $_SESSION['sms_template_search']['message'];
			$sql_where_clause .=($sql_where_clause!=''?" AND ":"")."message like '%".$message."%'";
			$this->assign("field_message", $_SESSION['sms_template_search']['message']);
		}
		
		/* Search For Order By */
		if($this->app->getRequestVar("order_by_field_name") != "" && $this->app->getRequestVar("order_by") != "")
		{
			$order_by=$this->app->getRequestVar("order_by");
			$_SESSION['order_by_field_name'] = $this->app->getRequestVar("order_by_field_name");	
			$_SESSION['order_by'] = $this->app->getRequestVar("order_by");
			$_SESSION['view'] = $this->app->getRequestVar("view");
			$this->assign("order_by",($order_by=='' || $order_by=='DESC'?'ASC':'DESC'));
		}elseif(isset($_SESSION['order_by_field_name']) && $_SESSION['order_by_field_name'] != "" && isset($_SESSION['order_by']) && $_SESSION['order_by'] != "" && isset($_SESSION['view']) && $_SESSION['view'] != $this->app->getRequestVar("view")){
			$_SESSION['order_by_field_name'] = "id";	
			$_SESSION['order_by'] = "ASC";
			$_SESSION['view'] = $this->app->getRequestVar("view");
		}else{
			$_SESSION['order_by_field_name'] = "id";	
			$_SESSION['order_by'] = "ASC";
			$_SESSION['view'] = $this->app->getRequestVar("view");
		}
		$order_by_field_name = $_SESSION['order_by_field_name'];
		$order_by = $_SESSION['order_by'];
		$sql_order_by_clause = "";
		if($order_by != ""){
			$sql_order_by_clause = $order_by_field_name. " " .$order_by;
		}
	
		$rs = $obj_model_sms_template->execute("SELECT", true, "", $sql_where_clause, $sql_order_by_clause);		
		$data = $this->app->compile();
		$this->load_parser($data);
		$this->parser->assign("PAGING", $obj_model_sms_template->show_paging());
		$this->parser->assign("PAGE_NO", $this->app->getCurrentPage());
		$this->parser->assign("SHOW_HIDE", (count($rs)>0)?"none":"");

		$i = 1;
		$Sr = $obj_model_sms_template->get_serial_start();
		foreach($rs as $sms_template){
			$this->parser->assign("sms_template", $sms_template);			
			$this->parser->assign("ROW_CLASS", ($i%2)==0?"even":"odd");
			$this->parser->assign("STATUS", ($sms_template['status'])=="Active"?"active.png":"inactive.png");
			$this->parser->assign("COUNT", $i);
			$this->parser->assign("SERIAL", $Sr);
			$this->parser->parse('main.sms_template_table.sms_template_row');
			$i++;
			$Sr++;
		}
		$this->parser->parse('main.sms_template_table');		
		$this->parser->parse('main');			
		$this->update_ouput($this->parser->text('main'));
		$this->unload_parser();	
	}
	
	function multi_delete(){
		$del_id = $this->app->getPostVar('del');
		$is_delete = array();
		$obj_model_sms_template = $this->app->load_model("sms_template");
		for($i=0;$i<count($del_id);$i++){			
			$is_delete[] = $obj_model_sms_template->execute("DELETE", false, "", "id=".$del_id[$i]);
		}
		
		if(count($is_delete)>0){
			$this->app->utility->set_message("Records deleted successfully", "SUCCESS");
		}else{
			$this->app->utility->set_message("Problem in delete record", "ERROR");
		}
		$this->app->redirect("index.php?view=sms_template_list");
	}
	
	function single_delete(){
		$obj_model_sms_template = $this->app->load_model("sms_template",  $this->app->getPostVar('id'));
		$rs_image=$obj_model_sms_template->execute("SELECT");
		if($obj_model_sms_template->execute("DELETE")){
			$this->app->utility->set_message("Record deleted successfully", "SUCCESS");
		}else{
			$this->app->utility->set_message("Problem in delete record", "ERROR");
		}
		$this->app->redirect("index.php?pg_no=".$this->app->getPostVar('page_no')."&view=sms_template_list");			
	}
}	
?>