<?php
class _admin_user_group_addedit extends controller{
	function init(){
	}
	function onload(){
		$this->assign("id", $this->app->getGetVar('id'));
		if($this->app->getGetVar('id')!=""){
			if($this->app->getGetVar('record') == "copy"){
				$this->assign("to_do", "Copy");
				$this->assign("id", "");
			}else{
				$this->assign("to_do", "Edit");
			}
			$this->load_data();
		}else{
			$this->assign("to_do", "Add");
		}
		$this->assign("manager_for", "User Group");
	}
	function load_data(){
		$obj_model_admin_user_group = $this->app->load_model("admin_user_group", $this->app->getGetVar('id'));
		$rs_admin_user_group = $obj_model_admin_user_group->execute("SELECT",false,"","","","");
		if(count($rs_admin_user_group)>0){
			$this->app->assign_form_data("frm_admin_user_group_addedit", $rs_admin_user_group[0]);
		}else{
			$this->app->redirect("index.php?view=admin_user_group_list");
		}
	}
	function addedit_data(){
		if($this->app->getPostVar('id')!=""){
			$obj_model_admin_user_group = $this->app->load_model("admin_user_group", $this->app->getPostVar('id'));
			$edit_field = array();
			$edit_field['group_name']=ucwords($this->app->getPostVar("group_name"));
			$edit_field['description']=ucwords($this->app->getPostVar("description"));
			$obj_model_admin_user_group->map_fields($edit_field);
			if($obj_model_admin_user_group->execute("UPDATE")>0){
				//add user log for UPDATE
				$this->app->utility->add_user_log("admin_user_group",$this->app->getPostVar('id'),"UPDATE",$this->app->getPostVars());
				$this->app->utility->set_message("Record updated successfully", "SUCCESS");
				if($this->app->getPostVar('apply_x') != ""){
					$this->app->redirect("index.php?view=admin_user_group_addedit&id=".$this->app->getPostVar('id'));
				}else{
					$this->app->redirect("index.php?view=admin_user_group_list&pg_no=".$this->app->getPostVar('page_no'));
				}
			}else{
				$this->app->utility->set_message("Ooops... There was a problem in update records", "ERROR");
				$this->app->redirect("index.php?view=admin_user_group_list&pg_no=".$this->app->getPostVar('page_no'));
			}
		}else{
			$obj_model_admin_user_group = $this->app->load_model("admin_user_group");
			$add_field = array();
			$add_field['group_name']=ucwords($this->app->getPostVar("group_name"));
			$add_field['description']=ucwords($this->app->getPostVar("description"));
			$obj_model_admin_user_group->map_fields($add_field);
			$inserted_id = $obj_model_admin_user_group->execute("INSERT");
			if($inserted_id>0){
				//add user log for INSERT
				$this->app->utility->add_user_log("admin_user_group",$inserted_id,"INSERT",$this->app->getPostVars());
				$this->app->utility->set_message("Record inserted successfully", "SUCCESS");
				if($this->app->getPostVar('apply_x') != ""){
					$this->app->redirect("index.php?view=admin_user_group_addedit&id=".$inserted_id);
				}else{
					$this->app->redirect("index.php?view=admin_user_group_list");
				}
			}else{
				$this->app->utility->set_message("Ooops... There was a problem in insert records", "ERROR");
				$this->app->redirect("index.php?view=admin_user_group_list");
			}
		}
	}
}
?>