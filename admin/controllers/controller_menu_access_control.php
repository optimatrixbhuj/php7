<?php
class _menu_access_control extends controller{
	
	function init(){
	}
	
	function onload(){
		$obj_model_menu = $this->app->load_model("menu_master");	
		$rs_menu = $obj_model_menu->execute("SELECT",false,"","status='Active'","sort_order ASC");
		for($i=0;$i<count($rs_menu);$i++){
			$obj_model_menu_detail = $this->app->load_model("menu_detail");
			$obj_model_menu_detail->join_table("menu_file_label","left",array(),array("menu_file_label_id"=>"id"));
			$rs_menu_detail=$obj_model_menu_detail->execute("SELECT",false,"","menu_master_id=".$rs_menu[$i]['id']." AND menu_detail.status='Active'","sort_order ASC");
			$rs_menu[$i]['children']=$rs_menu_detail;
		}
		$this->assign("access_menu",$rs_menu);
		
		$group=array();
		$group[0]="-- Select User Group --";
		$obj_model_user_group=$this->app->load_model("admin_user_group");
		$rs_user_group=$obj_model_user_group->execute("SELECT",false,"","status='Active'");
		for($i=0;$i<count($rs_user_group);$i++){
			$group[$rs_user_group[$i]['id']]=$rs_user_group[$i]['group_name'];
		}
		$this->assign("user_group",$group);	
		
		$sql_clause='';		
		if($this->app->getGetVar("group_id")!="" && $this->app->getGetVar("group_id")!= 0){
			$this->assign("group_num",$this->app->getGetVar("group_id"));
			$sql_clause.=($sql_clause!=''?" AND ":"")."admin_user_group_id=".$this->app->getGetVar("group_id");			
		}
		if($sql_clause!=''){
			$obj_model_user_access = $this->app->load_model("menu_user_access");
			$rs_user_access = $obj_model_user_access->execute("SELECT",false,"",$sql_clause);
			$menu_check=array();
			$page_check=array();
			foreach($rs_user_access as $user_access){
				if(!in_array($user_access['menu_file_label_id'],$page_check) && $user_access['menu_file_label_id']>0){
					$page_check[]=$user_access['menu_file_label_id'];	
				}
				if(!in_array($user_access['menu_master_id'],$menu_check) && $user_access['menu_master_id']>0){
					$menu_check[]=$user_access['menu_master_id'];	
				}
			}
			$this->assign("menu_check",$menu_check);
			$this->assign("page_check",$page_check);
		}else{
			$rs_user_access = array();
		}
		
		if(count($rs_user_access)>0){			
			$this->assign("to_do", "Edit");			
		}else{
			$this->assign("to_do", "Add");
		}		
		$this->assign("manager_for", "User Access");
	}
		
	function addedit_data(){	
		//echo "<pre>";print_r($this->app->getPostVars());exit;		
		if($this->app->getPostVar('id')!=""){
			
		}else{					
			$menu_file_label_ids=$this->app->getPostVar("page_name");
			$menu_master_ids=$this->app->getPostVar("modlue_id");
			$sql_clause='';			
			$obj_model_delete_user_access = $this->app->load_model("menu_user_access");
			$rs_delete_access=$obj_model_delete_user_access->execute("DELETE",false,"","admin_user_group_id=".$this->app->getGetVar("group_id").$sql_clause);
			
			for($i=0;$i<count($menu_master_ids);$i++){				
				$obj_model_user_access = $this->app->load_model("menu_user_access");
				$add_field = array();
				$add_field['admin_user_group_id']=$this->app->getGetVar("group_id");
				$add_field['menu_master_id']=$menu_master_ids[$i];
				$add_field['permission']="Yes";
				$obj_model_user_access->map_fields($add_field);
				$inserted_id = $obj_model_user_access->execute("INSERT");
				//add user log for INSERT
				//$this->app->utility->add_user_log("menu_user_access",$inserted_id,"INSERT",$this->app->getPostVars());
			}
			for($i=0;$i<count($menu_file_label_ids);$i++){				
				$obj_model_user_access = $this->app->load_model("menu_user_access");
				$add_field = array();
				$add_field['admin_user_group_id']=$this->app->getGetVar("group_id");
				$add_field['menu_file_label_id']=$menu_file_label_ids[$i];
				$add_field['permission']="Yes";
				$obj_model_user_access->map_fields($add_field);
				$inserted_id = $obj_model_user_access->execute("INSERT");
				//add user log for INSERT
				//$this->app->utility->add_user_log("menu_user_access",$inserted_id,"INSERT",$this->app->getPostVars());
			}
			if($inserted_id>0){
				$this->app->utility->set_message("Record inserted successfully", "SUCCESS");
				if($this->app->getPostVar('apply_x') != ""){
					$this->app->redirect("index.php?view=menu_access_control&id=".$inserted_id);
				}else{
					$this->app->redirect("index.php?view=menu_access_control");
				}
			}else{
				$this->app->utility->set_message("Ooops... There was a problem in insert records", "ERROR");
				$this->app->redirect("index.php?view=menu_access_control");
			}
		}
	}		
}	
?>