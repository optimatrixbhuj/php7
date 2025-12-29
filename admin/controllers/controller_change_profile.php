<?php
class _change_profile extends controller{
	
	function init(){
	}
	
	function onload(){		
		$this->load_data();
	}
	
	function load_data(){
		$obj_model_users = $this->app->load_model("admin_user", $_SESSION['admin_user_id']);
		$rs_users = $obj_model_users->execute("SELECT",false,"","","","");
		if(count($rs_users)>0){
			$this->app->assign_form_data("frm_change_profile", $rs_users[0]);
			if($rs_users[0]['photo'] != ""){
					$this->assign('photo','<img src="'.SERVER_ROOT.'/'.$this->app->get_user_config("admin_user").$rs_users[0]['photo'].'" height="100">'); 
			}else{
				$this->assign("photo","");
			}		
		}else{
			$this->app->redirect("index.php?view=change_profile");
		}
	}
	function change_profile(){
		$obj_model_users = $this->app->load_model("admin_user",$_SESSION['admin_user_id']);
		$update_field=array();
		if(!empty($_FILES['photo']['name'])){
			$image_name=basename($_FILES['photo']['name']);
			$image_info=$this->app->utility->get_file_info($image_name);
			$new_image_name=time().".".$image_info->extension;
			if(strtolower($image_info->extension) == "jpg" || strtolower($image_info->extension) == "png" || strtolower($image_info->extension) == "gif" || strtolower($image_info->extension) == "jpeg"){	
				//===== delete exists image ======/					
				$result = $obj_model_users->execute("SELECT");					
				if(count($result)>0){
					if(file_exists($this->app->get_user_config("admin_user").$result[0]["photo"])){
						if($result[0]["photo"]!=NULL){
							@unlink($this->app->get_user_config("admin_user").$result[0]["photo"]);
						}	
					}
				}
				//===== delete exists image ======/
				if($this->app->utility->upload_file($_FILES['photo'])){
					if($this->app->utility->store_uploaded_file($this->app->get_user_config('admin_user'),$new_image_name,"140","80","")){
						$update_field['photo']=$new_image_name;
					}
					$this->app->utility->remove_uploaded_file();
				}
			}else{
				$this->app->utility->set_message("Please upload only image", "ERROR");
				$this->app->redirect("index.php?view=change_profile");
			}
		}
		$update_field['full_name']=ucwords($this->app->getPostVar("full_name"));
		$obj_model_users->map_fields($update_field);
		$update_id=$obj_model_users->execute("UPDATE");
		if($update_id>0){
			$this->app->utility->set_message("Profile Changed successfully", "SUCCESS");
			$this->app->redirect("index.php?view=change_profile");
		}else{
			$this->app->utility->set_message("Ooops... There was a problem in change profile", "ERROR");
			$this->app->redirect("index.php?view=change_profile");
		}
	}	
}	
?>