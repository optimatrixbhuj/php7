<?php
class _student_addedit extends controller{
	
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
		$this->assign("manager_for", "student");
	}
	
	function load_data(){
		$obj_model_student = $this->app->load_model("student", $this->app->getGetVar('id'));
		$rs_student = $obj_model_student->execute("SELECT",false,"","","","");
		if(count($rs_student)>0){
			$this->app->assign_form_data("frm_student_addedit", $rs_student[0]);
		}else{
			$this->app->redirect("index.php?view=student_list");
		}
	}
	
	function addedit_data(){			
		if($this->app->getPostVar('id')!=""){
			$obj_model_student = $this->app->load_model("student", $this->app->getPostVar('id'));
			$edit_field = array();
			$edit_field['name']=ucwords($this->app->getPostVar("name"));
			$obj_model_student->map_fields($edit_field);
			if($obj_model_student->execute("UPDATE")>0){
				//add user log for UPDATE
				$this->app->utility->add_user_log("student",$this->app->getPostVar('id'),"UPDATE",$this->app->getPostVars());
				$this->app->utility->set_message("Record updated successfully", "SUCCESS");
				if($this->app->getPostVar('apply_x') != ""){
					$this->app->redirect("index.php?view=student_addedit&id=".$this->app->getPostVar('id'));
				}else{
					$this->app->redirect("index.php?view=student_list&pg_no=".$this->app->getGetVar('page_no'));
				}
			}else{
				$this->app->utility->set_message("Ooops... There was a problem in update records", "ERROR");
				$this->app->redirect("index.php?view=student_list&pg_no=".$this->app->getGetVar('page_no'));
			}
		}else{					
			$obj_model_student = $this->app->load_model("student");
			$add_field = array();
			$add_field['admin_user_id']=$_SESSION['admin_user_id'];	
			$add_field['name']=ucwords($this->app->getPostVar("name"));
			$obj_model_student->map_fields($add_field);
			$inserted_id = $obj_model_student->execute("INSERT");
			if($inserted_id>0){
				//add user log for INSERT
				$this->app->utility->add_user_log("student",$inserted_id,"INSERT",$this->app->getPostVars());
				$this->app->utility->set_message("Record inserted successfully", "SUCCESS");
				if($this->app->getPostVar('apply_x') != ""){
					$this->app->redirect("index.php?view=student_addedit&id=".$inserted_id);
				}else{
					$this->app->redirect("index.php?view=student_list");
				}
			}else{
				$this->app->utility->set_message("Ooops... There was a problem in insert records", "ERROR");
				$this->app->redirect("index.php?view=student_list");
			}
		}
	}		
}	
?>