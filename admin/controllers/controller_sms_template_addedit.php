<?php
class _sms_template_addedit extends controller{
	
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
			$this->assign("image",'');
		}
		$this->assign("manager_for", "SMS Template");
	}
	
	function load_data(){
		$obj_model_sms_template = $this->app->load_model("sms_template", $this->app->getGetVar('id'));
		$rs_sms_template = $obj_model_sms_template->execute("SELECT",false,"","","","");
		if(count($rs_sms_template)>0){			
			$this->app->assign_form_data("frm_sms_template_addedit", $rs_sms_template[0]);
		}else{
			$this->app->redirect("index.php?view=sms_template_list");
		}
	}
	
	function addedit_data(){
		if($this->app->getPostVar('id')!=""){
			$obj_model_sms_template = $this->app->load_model("sms_template", $this->app->getPostVar('id'));	
			$edit_field = array();
			$edit_field['subject']=strtoupper($this->app->getPostVar("subject"));
			$obj_model_sms_template->map_fields($edit_field);		
			if($obj_model_sms_template->execute("UPDATE")>0){
				//add user log for UPDATE
				$this->app->utility->add_user_log("sms_template",$this->app->getPostVar('id'),"UPDATE",$this->app->getPostVars());
				$this->app->utility->set_message("Record updated successfully", "SUCCESS");
				if($this->app->getPostVar('apply_x') != ""){
					$this->app->redirect("index.php?view=sms_template_addedit&id=".$this->app->getPostVar('id'));
				}else{
					$this->app->redirect("index.php?view=sms_template_list");
				}
			}else{
				$this->app->utility->set_message("Ooops... There was a problem in update records", "ERROR");
				$this->app->redirect("index.php?view=sms_template_list");
			}
		}else{					
			$obj_model_sms_template = $this->app->load_model("sms_template");
			$add_field = array();
			$add_field['subject']=strtoupper($this->app->getPostVar("subject"));
			$obj_model_sms_template->map_fields($add_field);			
			$inserted_id = $obj_model_sms_template->execute("INSERT");
			if($inserted_id>0){
				//add user log for INSERT
				$this->app->utility->add_user_log("sms_template",$inserted_id,"INSERT",$this->app->getPostVars());
				$this->app->utility->set_message("Record inserted successfully", "SUCCESS");
				if($this->app->getPostVar('apply_x') != ""){
					$this->app->redirect("index.php?view=sms_template_addedit&id=".$inserted_id);
				}else{
					$this->app->redirect("index.php?view=sms_template_list");
				}
			}else{
				$this->app->utility->set_message("Ooops... There was a problem in insert records", "ERROR");
				$this->app->redirect("index.php?view=sms_template_list");
			}
		}
	
	}		
}	
?>