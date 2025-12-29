<?php
class _class_addedit extends controller{
	
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
		$this->assign("manager_for", "class");
	}
	
	function load_data(){
		$obj_model_class = $this->app->load_model("class", $this->app->getGetVar('id'));
		$rs_class = $obj_model_class->execute("SELECT",false,"","","","");
		if(count($rs_class)>0){
			$this->app->assign_form_data("frm_class_addedit", $rs_class[0]);
		}else{
			$this->app->redirect("index.php?view=class_list");
		}
	}
	
	function addedit_data(){			
		if($this->app->getPostVar('id')!=""){
			$obj_model_class = $this->app->load_model("class", $this->app->getPostVar('id'));
			$edit_field = array();
			$edit_field['name']=ucwords($this->app->getPostVar("name"));
			$obj_model_class->map_fields($edit_field);
			if($obj_model_class->execute("UPDATE")>0){
				//add user log for UPDATE
				$this->app->utility->add_user_log("class",$this->app->getPostVar('id'),"UPDATE",$this->app->getPostVars());
				$this->app->utility->set_message("Record updated successfully", "SUCCESS");
				if($this->app->getPostVar('apply_x') != ""){
					$this->app->redirect("index.php?view=class_addedit&id=".$this->app->getPostVar('id'));
				}else{
					$this->app->redirect("index.php?view=class_list&pg_no=".$this->app->getGetVar('page_no'));
				}
			}else{
				$this->app->utility->set_message("Ooops... There was a problem in update records", "ERROR");
				$this->app->redirect("index.php?view=class_list&pg_no=".$this->app->getGetVar('page_no'));
			}
		}else{					
			$obj_model_class = $this->app->load_model("class");
			$add_field = array();
			$add_field['admin_user_id']=$_SESSION['admin_user_id'];	
			$add_field['name']=ucwords($this->app->getPostVar("name"));
			$obj_model_class->map_fields($add_field);
			$inserted_id = $obj_model_class->execute("INSERT");
			if($inserted_id>0){
				//add user log for INSERT
				$this->app->utility->add_user_log("class",$inserted_id,"INSERT",$this->app->getPostVars());
				$this->app->utility->set_message("Record inserted successfully", "SUCCESS");
				if($this->app->getPostVar('apply_x') != ""){
					$this->app->redirect("index.php?view=class_addedit&id=".$inserted_id);
				}else{
					$this->app->redirect("index.php?view=class_list");
				}
			}else{
				$this->app->utility->set_message("Ooops... There was a problem in insert records", "ERROR");
				$this->app->redirect("index.php?view=class_list");
			}
		}
	}		
}	
?>