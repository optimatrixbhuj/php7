<?php
class _setting_addedit extends controller{
	
	function init(){
		if($_SESSION['admin_user_group_id']!='1'){
			$this->app->redirect("index.php?view=access_denied");
		}
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
		$this->assign("manager_for", "setting");
	}
	
	function load_data(){
		$obj_model_setting = $this->app->load_model("setting", $this->app->getGetVar('id'));
		$rs_setting = $obj_model_setting->execute("SELECT",false,"","status='Active'","","");
		if(count($rs_setting)>0){
			$this->assign("setting",$rs_setting);
			if(in_array($rs_setting[0]['id'],array(10,11)) && $rs_setting[0]['object_value']!=""){
				$this->app->assign("icon",'<img src="'.SERVER_ROOT.'/'.$this->app->get_user_config('icon').$rs_setting[0]['object_value'].'" height="100" >');
			}
			$this->app->assign_form_data("frm_setting_addedit", $rs_setting[0]);
		}else{
			$this->app->redirect("index.php?view=setting_list");
		}
	}
	
	function addedit_data(){			
		if($this->app->getPostVar('id')!=""){
			$obj_model_setting = $this->app->load_model("setting", $this->app->getPostVar('id'));
			$result=$obj_model_setting->execute("SELECT",false,"","status='Active'");
			$edit_field = array();
			if($this->app->getPostVar('id')==10 || $this->app->getPostVar('id')==11)
				if(!empty($_FILES['object_value']['name']) && $this->app->getPostVar("photo")!=""){
					if(count($result)>0){				
						if($result[0]['object_value'] != NULL){
							if(file_exists(ABS_PATH."/".$this->app->get_user_config('icon').$result[0]['object_value'])){
								@unlink(ABS_PATH."/".$this->app->get_user_config('icon').$result[0]['object_value']);
							}
						}
					}
					$data = $this->app->getPostVar("photo");
					list($type, $data) = explode(';', $data);
					list(, $data)      = explode(',', $data);
					$extension_arr=explode("/",$type);
					$extension=$extension_arr[count($extension_arr)-1];
					$data = base64_decode($data);
					$imageName = ($this->app->getPostVar('id')==10?"BUS":"AUTORAKSHAW")."-".time().".".$extension;
					file_put_contents(ABS_PATH."/".$this->app->get_user_config('icon').$imageName, $data);
					$edit_field['object_value']=$imageName;			
				}
				$obj_model_setting->map_fields($edit_field);
				if($obj_model_setting->execute("UPDATE")>0){
				//add user log for UPDATE
					$this->app->utility->add_user_log("setting",$this->app->getPostVar('id'),"UPDATE",$this->app->getPostVars());
					$this->app->utility->set_message("Record updated successfully", "SUCCESS");
					if($this->app->getPostVar('apply_x') != ""){
						$this->app->redirect("index.php?view=setting_addedit&id=".$this->app->getPostVar('id'));
					}else{
						$this->app->redirect("index.php?view=setting_list");
					}
				}else{
					$this->app->utility->set_message("Ooops... There was a problem in update records", "ERROR");
					$this->app->redirect("index.php?view=setting_list");
				}
			}else{					
				$obj_model_setting = $this->app->load_model("setting");
				$add_field = array();
				$obj_model_setting->map_fields($add_field);
				$inserted_id = $obj_model_setting->execute("INSERT");
				if($inserted_id>0){
				//add user log for INSERT
					$this->app->utility->add_user_log("setting",$inserted_id,"INSERT",$this->app->getPostVars());
					$this->app->utility->set_message("Record inserted successfully", "SUCCESS");
					if($this->app->getPostVar('apply_x') != ""){
						$this->app->redirect("index.php?view=setting_addedit&id=".$inserted_id);
					}else{
						$this->app->redirect("index.php?view=setting_list");
					}
				}else{
					$this->app->utility->set_message("Ooops... There was a problem in insert records", "ERROR");
					$this->app->redirect("index.php?view=setting_list");
				}
			}
		}		
	}	
	?>