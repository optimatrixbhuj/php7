<?php
	class _change_password extends controller{
		
		function init(){
			//$this->app->enable_cache("home.html");
		}
		
		function onload(){
			/*$data = $this->app->compile();
			$this->load_parser($data);
			$this->parser->assign("MESSAGE", $this->app->utility->get_message());
			$this->parser->parse('main');			
			$this->update_ouput($this->parser->text('main'));
			$this->unload_parser();*/
		}
		
		function change_password(){
			$obj_model_user = $this->app->load_model("admin_user");
			$admin_id="";
			$admin_id = $obj_model_user->record_exists(array("password"=>md5($this->app->getPostVar("password")),"id"=>$_SESSION['admin_user_id']),"id");
			if($this->app->getPostVar("new_password") == $this->app->getPostVar("password")){
				$this->app->utility->set_message("You have enter same Password Please Enter New password", "ERROR");
				$this->app->redirect("index.php?view=change_password");
			}else{
			if($admin_id!=NULL){
				$rs_admin = $obj_model_user->execute("SELECT", false, "", "id=".$admin_id);
				/*================= Change Paasword =================*/
				if(count($rs_admin)>0){
					$obj_model_user = $this->app->load_model("admin_user", $admin_id);
					$edit_field = array();
					$edit_field["password"]=md5($this->app->getPostVar("new_password"));
					$edit_field["pwd_change_date"]=date('Y-m-d H:i:s');
					$obj_model_user->map_fields($edit_field);
					if($obj_model_user->execute("UPDATE")>0){
						$_SESSION['change_pwd']=true;
						unset($_SESSION['change_pwd_msg']);
						$this->app->utility->set_message("Password changed successfully", "SUCCESS");
						$obj_model_user = $this->app->load_model("admin_user", $admin_id);
						$rs_user=$obj_model_user->execute("SELECT");
					/***********************Mail For Change Password**************************/
					/*
					$mailer = $this->app->load_module("mailer\sender");
					$mail_body = $this->app->utility->ParseMailTemplate("user_change_password.html", array("password"=>$edit_field['password'],"user_name"=>$rs_user[0]['user_name']));
					if($mail_body==NULL){
						$this->app->display_error(NULL, "Could not parse the mail template");
					}				
					$mailer->create();			
					$mailer->subject('Change Password for Administrator');																		
					$mailer->add_to($this->app->getPostVar("email_id"));	
					$mailer->add_cc(REGISTRATION_EMAIL);
					$mailer->htmlbody($mail_body);					
					$flag = $mailer->send();
					if($flag){
						//$this->app->utility->set_message("Your Password sent to your Email address", "SUCCESS");
						//$this->app->redirect($_SERVER['HTTP_REFERER']);
					}
					*/
					/******************************************************************************/

						$this->app->redirect("index.php?view=change_password");
					}
				
				}
			
				/*==========================================================*/							
				
			}else{
					$this->app->utility->set_message("Please insert correct old password", "ERROR");
					$this->app->redirect("index.php?view=change_password");
			}
		}
		}
	}	
?>