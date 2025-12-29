<?php
class _menu_file_label_addedit extends controller{
	
	function init(){
	}
	
	function onload(){
		$this->assign("id", $this->app->getGetVar('id'));
		$files_arr=array();
		$files_arr[""]="-Select Page-";
		$path=ABS_PATH.DS.VIR_DIR.DS.'views';
		if ($handle = opendir($path)) { 
		   foreach(scandir($path) as $entry){
				if ($entry != "." && $entry != ".." && $entry!='index.html') {
					$file=substr($entry,5,-4);
					if($file != "access_denied" &&  $file != "default" &&  $file != "change_profile" &&  $file != "change_password" &&  $file != "forgot_password" &&  $file != "mould_addedit" &&  $file != "mould_list" &&  $file != "generate_files" ){
						$files_arr[$file]=$file;
					}
				}
		   }
		}
		$this->app->assign("files",$files_arr);
		
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
		$this->assign("manager_for", "file label");
	}
	
	function load_data(){
		$obj_model_menu_file_label = $this->app->load_model("menu_file_label", $this->app->getGetVar('id'));
		$rs_menu_file_label = $obj_model_menu_file_label->execute("SELECT",false,"","","","");
		if(count($rs_menu_file_label)>0){
			$this->app->assign_form_data("frm_menu_file_label_addedit", $rs_menu_file_label[0]);
		}else{
			$this->app->redirect("index.php?view=menu_file_label");
		}
	}
	
	function addedit_data(){			
		if($this->app->getPostVar('id')!=""){
			$obj_model_menu_file_label = $this->app->load_model("menu_file_label", $this->app->getPostVar('id'));
			$edit_field = array();
			$edit_field['file_label']=ucwords($this->app->getPostVar("file_label"));
			$obj_model_menu_file_label->map_fields($edit_field);
			if($obj_model_menu_file_label->execute("UPDATE")>0){
				//add user log for UPDATE
				$this->app->utility->add_user_log("menu_file_label",$this->app->getPostVar('id'),"UPDATE",$this->app->getPostVars());
				$this->app->utility->set_message("Record updated successfully", "SUCCESS");
				if($this->app->getPostVar('apply_x') != ""){
					$this->app->redirect("index.php?view=menu_file_label_addedit&id=".$this->app->getPostVar('id'));
				}else{
					$this->app->redirect("index.php?view=menu_file_label&pg_no=".$this->app->getGetVar('page_no'));
				}
			}else{
				$this->app->utility->set_message("Ooops... There was a problem in update records", "ERROR");
				$this->app->redirect("index.php?view=menu_file_label&pg_no=".$this->app->getGetVar('page_no'));
			}
		}else{					
			$obj_model_menu_file_label = $this->app->load_model("menu_file_label");
			$add_field = array();
			$add_field['admin_user_id']=$_SESSION['admin_user_id'];	
			$add_field['file_label']=ucwords($this->app->getPostVar("file_label"));
			$obj_model_menu_file_label->map_fields($add_field);
			$inserted_id = $obj_model_menu_file_label->execute("INSERT");
			if($inserted_id>0){
				//add user log for INSERT
				$this->app->utility->add_user_log("menu_file_label",$inserted_id,"INSERT",$this->app->getPostVars());
				$this->app->utility->set_message("Record inserted successfully", "SUCCESS");
				if($this->app->getPostVar('apply_x') != ""){
					$this->app->redirect("index.php?view=menu_file_label_addedit&id=".$inserted_id);
				}else{
					//$this->app->redirect("index.php?view=menu_file_label");
					?>
                    <script>
					parent.jQuery.fancybox.close();
					parent.location.reload(true);
					</script>
                    <?php
				}
			}else{
				$this->app->utility->set_message("Ooops... There was a problem in insert records", "ERROR");
				$this->app->redirect("index.php?view=menu_file_label");
			}
		}
	}		
}	
?>