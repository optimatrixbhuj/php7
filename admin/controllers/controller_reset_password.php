<?php
class _reset_password extends controller{
	
	function init(){		
		if(!isset($_SESSION['reset_user_id']) || !isset($_SESSION['reset_otp'])){
			//$_SESSION['reset_otp']="885268";
			$this->app->redirect("index.php?view=forgot_password");
		}
	}
	
	function onload(){
		$admin_id=$_SESSION['reset_user_id'];
		$obj_model_admin = $this->app->load_model("admin_user",$admin_id);
		$rs = $obj_model_admin->execute("SELECT");
		if(count($rs)>0){
			$this->assign("user_name",$rs[0]['full_name']);
			$this->assign('user_image',($rs[0]['photo']!=''?SERVER_ROOT.'/'.$this->app->get_user_config("admin_user").$rs[0]['photo']:"images\user_img1.jpg"));
		}
	}
	
	function reset_password(){
		if(isset($_SESSION['reset_otp']) && $this->app->getPostVar("otp")!=$_SESSION['reset_otp']){
			$this->app->utility->set_message("Wrong OTP code. Please try again.", "ERROR");
			$this->app->redirect("index.php?view=reset_password");
		}else{			
			$admin_id=$_SESSION['reset_user_id'];		
			if($admin_id!=NULL && $admin_id!=''){
				$obj_model_user = $this->app->load_model("admin_user",$admin_id);
				$rs_admin = $obj_model_user->execute("SELECT", false, "", "id=".$admin_id);
				/*================= Change Paasword =================*/
				if(count($rs_admin)>0){
					$obj_model_user = $this->app->load_model("admin_user", $admin_id);
					$edit_field = array();
					$edit_field["password"]=md5($this->app->getPostVar("password"));
					$edit_field["pwd_change_date"]=date('Y-m-d H:i:s');
					$obj_model_user->map_fields($edit_field);
					if($obj_model_user->execute("UPDATE")>0){
						unset($_SESSION['reset_user_id']);
						unset($_SESSION['reset_otp']);
						$this->app->utility->set_message("Password reset successfully", "SUCCESS");								
						$this->app->redirect("index.php?view=home");
					}			
				}			
			}else{			
				$this->app->redirect("index.php?view=forgot_password");
			}
		}
	}	
}	
?>