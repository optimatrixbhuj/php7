<?php
class _admin_user_addedit extends controller{
	function init(){
	}
	function onload(){
		$type = $this->app->getGetVar('type');
		$this->assign("type",$type);
		if($_SESSION['admin_user_group_id']=='1'){
			// fetch branch
			$branch=$this->app->utility->get_dropdown("branch","id","name","Select Branch","","name");
			$this->assign("branch",$branch);
		}
		// fetch User Group Names
		$user_group_where = (($_SESSION['admin_user_group_id']=='1')?"":"id NOT IN('1')");
		$user_group=$this->app->utility->get_dropdown("admin_user_group","id","group_name","Select User Group",$user_group_where,"group_name");
		$this->assign("user_group",$user_group);
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
			if($_SESSION['admin_user_group_id']=='1'){
				$this->assign("field_branch_id", "1");
			}
		}
		$this->assign("manager_for", "admin user");
	}
	function load_data(){
		$type = $this->app->getGetVar('type');
		$this->assign("type",$type);
		$obj_model_admin_user = $this->app->load_model("admin_user", $this->app->getGetVar('id'));
		$rs_admin_user = $obj_model_admin_user->execute("SELECT",false,"","","","");
		if(count($rs_admin_user)>0){
			$this->assign("photo", $rs_admin_user[0]['photo']!=''?"<img src='".SERVER_ROOT."/".$this->app->get_user_config("admin_user").$rs_admin_user[0]['photo']."' width=50 height=50 />":"" );
			$this->app->assign_form_data("frm_admin_user_addedit", $rs_admin_user[0]);
		}else{
			$this->app->redirect("index.php?view=admin_user_list".($type!=''?"&type=".$type:""));
		}
	}
	function addedit_data(){
		$type = $this->app->getGetVar('type');
		$this->assign("type",$type);
		if($this->app->getPostVar('id')!=""){
			$obj_model_admin_user = $this->app->load_model("admin_user", $this->app->getPostVar('id'));
			$result=$obj_model_admin_user->execute("SELECT",false,"","status='Active'");
			// check for super admin
			if($result[0]['admin_user_group_id']==1 && $this->app->getPostVar('admin_user_group_id')!="1"){
				$obj_model_super_admin = $this->app->load_model("admin_user");
				$super_admin=$obj_model_super_admin->execute("SELECT",false,"","admin_user_group_id=1 AND status='Active'");
				if(count($super_admin)<=1){
					$this->app->utility->set_message("There Must be one Super Admin. You can not change it.", "ERROR");
					$this->app->redirect("index.php?view=admin_user_addedit&id=".$this->app->getPostVar('id')."&pg_no=".$this->app->getPostVar('page_no'));
				}
			}
			$obj_model_admin_user = $this->app->load_model("admin_user", $this->app->getPostVar('id'));
			$edit_field = array();
			if(!empty($_FILES['photo']['name'])){
				if(count($result)>0){
				if($result[0]["photo"]!=NULL){
					if(file_exists($this->app->get_user_config("admin_user").$result[0]["photo"])){
							@unlink(SERVER_ROOT.$this->app->get_user_config("admin_user").$result[0]["photo"]);
						}
					}
				}
				$file_name = basename($_FILES['photo']['name']);
				$file_info = $this->app->utility->get_file_info($file_name);
				if(strtoupper($file_info->extension)=="JPG" || strtoupper($file_info->extension)=="GIF" || strtoupper($file_info->extension)=="PNG" || strtoupper($file_info->extension)=="JPEG"){
					$new_name = time().".".$file_info->extension;
					if($this->app->utility->upload_file($_FILES['photo'])){
					if($this->app->utility->store_uploaded_file($this->app->get_user_config("admin_user"), $new_name,$this->app->get_user_config("admin_user_width"),$this->app->get_user_config("admin_user_height"))){
							$edit_field["photo"] = $new_name;
						}
						$this->app->utility->remove_uploaded_file();
					}
				}
			}
			$edit_field['full_name']=ucwords($this->app->getPostVar("full_name"));
			if($this->app->getPostVar("password")!=$result[0]['password']){
				$edit_field['password']=md5($this->app->getPostVar("password"));
				$edit_field['pwd_change_date']=date("Y-m-d H:i:s",strtotime("-90 days"));  //add 90 days before date to redirect on change password page.
			}
			$obj_model_admin_user->map_fields($edit_field);
			if($obj_model_admin_user->execute("UPDATE",false,"","id=".$this->app->getPostVar("id"))>0){
				//add user log for UPDATE
				$this->app->utility->add_user_log("admin_user",$this->app->getPostVar('id'),"UPDATE",$this->app->getPostVars());
				$this->app->utility->set_message("Record updated successfully", "SUCCESS");
				if($this->app->getPostVar('apply_x') != ""){
					$this->app->redirect("index.php?view=admin_user_addedit&id=".$this->app->getPostVar('id').($type!=''?"&type=".$type:""));
				}else{
					$this->app->redirect("index.php?view=admin_user_list&pg_no=".$this->app->getPostVar('page_no').($type!=''?"&type=".$type:""));
				}
			}else{
				$this->app->utility->set_message("Ooops... There was a problem in update records", "ERROR");
				$this->app->redirect("index.php?view=admin_user_list&pg_no=".$this->app->getPostVar('page_no').($type!=''?"&type=".$type:""));
			}
		}else{
			$obj_model_admin_user = $this->app->load_model("admin_user");
			$add_field = array();
			if(!empty($_FILES['photo']['name'])){
				$file_name = basename($_FILES['photo']['name']);
				$file_info = $this->app->utility->get_file_info($file_name);
				if(strtoupper($file_info->extension)=="JPG" || strtoupper($file_info->extension)=="GIF" || strtoupper($file_info->extension)=="PNG" || strtoupper($file_info->extension)=="JPEG"){
					$new_name = time().".".$file_info->extension;
					if($this->app->utility->upload_file($_FILES['photo'])){
					if($this->app->utility->store_uploaded_file($this->app->get_user_config("admin_user"), $new_name,$this->app->get_user_config("admin_user_width"),$this->app->get_user_config("admin_user_height"))){
							$add_field["photo"] = $new_name;
						}
						$this->app->utility->remove_uploaded_file();
					}
				}
			}
			$add_field['full_name']=ucwords($this->app->getPostVar("full_name"));
			$add_field['password']=md5($this->app->getPostVar("password"));
			$add_field['pwd_change_date']=date("Y-m-d H:i:s",strtotime("-90 days"));  //add 90 days before date to redirect on change password page.
			$obj_model_admin_user->map_fields($add_field);
			$inserted_id = $obj_model_admin_user->execute("INSERT");
			if($inserted_id>0){
				//add user log for INSERT
				$this->app->utility->add_user_log("admin_user",$inserted_id,"INSERT",$this->app->getPostVars());
				$this->app->utility->set_message("Record inserted successfully", "SUCCESS");
				if($this->app->getPostVar('apply_x') != ""){
					$this->app->redirect("index.php?view=admin_user_addedit&id=".$inserted_id.($type!=''?"&type=".$type:""));
				}else{
					$this->app->redirect("index.php?view=admin_user_list".($type!=''?"&type=".$type:""));
				}
			}else{
				$this->app->utility->set_message("Ooops... There was a problem in insert records", "ERROR");
				$this->app->redirect("index.php?view=admin_user_list".($type!=''?"&type=".$type:""));
			}
		}
	}
}
?>