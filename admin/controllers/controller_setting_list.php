<?php
class _setting_list extends controller{		
	function init(){
		if($_SESSION['admin_user_group_id']!='1'){
			$this->app->redirect("index.php?view=access_denied");
		}
	}
	
	function onload(){
		if($this->app->getGetVar('destroy')==1){
			unset($_SESSION['setting_search']);
			$this->app->redirect("index.php?view=setting_list");
		}
		$this->assign("manager_for", "setting");			
		if($this->app->getCurrentAction()==""){
			$this->load_data();
		}
	}
	
	function search(){
		unset($_SESSION['setting_search']);
		$this->load_data();
	}
	
	function load_data(){
		$obj_model_setting = $this->app->load_model("setting");
		$obj_model_setting->set_paging_settings($_SESSION['records'],5);	
		
		/* Search By */
		if($this->app->getPostVar("object_field")!=""){
			$_SESSION['setting_search']['object_field'] = $this->app->getPostVar("object_field");
		}
		if($this->app->getPostVar("object_value")!=""){
			$_SESSION['setting_search']['object_value'] = $this->app->getPostVar("object_value");
		}				
		$sql_where_clause = "";
		if(isset($_SESSION['setting_search']['object_field'])){
			$object_field = $_SESSION['setting_search']['object_field'];
			$sql_where_clause .=($sql_where_clause!=''?" AND ":"")."object_field like '%".$object_field."%'";
			$this->assign("field_object_field", $_SESSION['setting_search']['object_field']);
		}
		if(isset($_SESSION['setting_search']['object_value'])){
			$object_value = $_SESSION['setting_search']['object_value'];
			$sql_where_clause .=($sql_where_clause!=''?" AND ":"")."object_value like '%".$object_value."%'";
			$this->assign("field_object_value", $_SESSION['setting_search']['object_value']);
		}		
		
		/* Search For Order By */
		if($this->app->getRequestVar("order_by_field_name") != "" && $this->app->getRequestVar("order_by") != "")
		{
			$_SESSION['order_by_field_name'] = $this->app->getRequestVar("order_by_field_name");	
			$_SESSION['order_by'] = $this->app->getRequestVar("order_by");
			$_SESSION['view'] = $this->app->getRequestVar("view");
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
		$sql_where_clause=($sql_where_clause==''?"setting.status='Active'":"setting.status='Active' and ".$sql_where_clause);
		
		$rs = $obj_model_setting->execute("SELECT", true, "", $sql_where_clause, $sql_order_by_clause);		
		$data = $this->app->compile();
		$this->load_parser($data);
		$this->parser->assign("PAGING", $obj_model_setting->show_paging());
		$this->parser->assign("PAGE_NO", $this->app->getCurrentPage());
		$this->parser->assign("SHOW_HIDE", (count($rs)>0)?"none":"");

		$i = 1;
		$Sr = $obj_model_setting->get_serial_start();
		foreach($rs as $setting){
			if(in_array($setting['id'],array(10,11)) && $setting['object_value']!=""){
				$setting['object_value']='<img src="'.SERVER_ROOT.'/'.$this->app->get_user_config('icon').$setting['object_value'].'" style="max-width:95%;max-height:100px;" />';
			}else{
				$sufix='';
				$setting['object_value'].=($setting['object_value']!=''?$sufix:"");
			}
			$this->parser->assign("setting", $setting);
			$this->parser->assign("ROW_CLASS", ($i%2)==0?"even":"odd");
			$this->parser->assign("STATUS", ($setting['status'])=="Active"?"active.png":"inactive.png");
			$this->parser->assign("COUNT", $i);
			$this->parser->assign("SERIAL", $Sr);
			$this->parser->parse('main.setting_table.setting_row');
			$i++;
			$Sr++;
		}
		$this->parser->parse('main.setting_table');		
		$this->parser->parse('main');			
		$this->update_ouput($this->parser->text('main'));
		$this->unload_parser();	
	}	
}	
?>