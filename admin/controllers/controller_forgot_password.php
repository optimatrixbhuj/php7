<?php
class _forgot_password extends controller{
	
	function init(){
		
	}
	
	function onload(){
		
	}
	
	function forgot_password(){
		/*======== Send Email ======== */
		$otp=$this->app->utility->GenerateRandomDigits("4");
		//$message = "Hello, your opt code for reset password is {code}. Use this code to reset your password.";
		if($this->app->getPostVar("get_pwd_by")=="by_email"){
			$admin_id = "";
			$obj_model_admin = $this->app->load_model("admin_user");
			$admin_id = $obj_model_admin->record_exists(array("email"=>$this->app->getPostVar("email")),"id");
			if($admin_id!=NULL){
				$rs_admin = $obj_model_admin->execute("SELECT", false, "", "id=".$admin_id);			
				/*================= Send admin mail =================*/
				if(count($rs_admin)>0){
					if($rs_admin[0]["email"]!=""){
						$mail_body = $this->app->utility->ParseMailTemplate("admin_otp_for_password.html", array("otp_code"=>$otp,"full_name"=>$rs_admin[0]["full_name"]));
						
						if($mail_body==NULL){
							$this->app->display_error(NULL, "Could not parse the mail template");
						}
						$obj_mailer = $this->app->load_module("mailer\sender");
						$obj_mailer->create();
						$obj_mailer->subject("OTP for Reset Password");
						$obj_mailer->add_to($rs_admin[0]["email"]);
						$obj_mailer->mailfrom(FROM_EMAIL,FROM_NAME);
						$obj_mailer->htmlbody($mail_body);
						$flag = $obj_mailer->send();
						if($flag){
							$_SESSION['reset_user_id']=$rs_admin[0]['id'];
							$_SESSION['reset_otp']=$otp;
							$this->app->utility->set_message("Your OPT sent to your Email address", "SUCCESS");
							$this->app->redirect("index.php?view=reset_password");
						}else{
							$this->app->utility->set_message("Oops..Problem in Sending Email", "ERROR");
							$this->app->redirect("index.php?view=forgot_password");
						}
					}
				}
				/*==========================================================*/							
			}else{
				$this->app->utility->set_message("Your Email address in not authenticated. Enter valid Email address", "ERROR");
				$this->app->redirect("index.php?view=forgot_password");
			}
		}
		/*=========== Send SMS ===============*/
		else if($this->app->getPostVar("get_pwd_by")=="by_mobile"){
			$admin_id = "";
			$obj_model_admin = $this->app->load_model("admin_user");
			$admin_id = $obj_model_admin->record_exists(array("mobile"=>$this->app->getPostVar("mobile")),"id");
			if($admin_id!=NULL){
				$rs_admin = $obj_model_admin->execute("SELECT", false, "", "id=".$admin_id);			
				/*================= Send admin mail =================*/
				if(count($rs_admin)>0){
					if($rs_admin[0]["mobile"]!=""){
						$mobile=$rs_admin[0]['mobile'];
						$sms = "Hello, your OTP code for reset password is ".$otp.". Use this code to reset your password.";
						$msg_id = $this->app->utility->send_sms($mobile,$sms,"1");						
						//message log
						$obj_model_msg_log = $this->app->load_model("message_log");
						$add_msg_field = array();
						$add_msg_field['branch_id'] = $rs_admin[0]['branch_id'];
						$add_msg_field['message'] = $sms;
						$add_msg_field['to_number'] = $mobile;
						$add_msg_field['date'] = date('Y-m-d');
						$add_msg_field['time'] = date("H:i:s");
						$add_msg_field['msg_id']=$msg_id;
						$add_msg_field['called_from'] = "PASSWORD_OTP";
						$obj_model_msg_log->map_fields($add_msg_field);
						$obj_model_msg_log->execute("INSERT");
						if($msg_id!="send message failed"){
							$_SESSION['reset_user_id']=$rs_admin[0]['id'];
							$_SESSION['reset_otp']=$otp;
							$this->app->utility->set_message("Your OTP sent to your Mobile Number", "SUCCESS");
							$this->app->redirect("index.php?view=reset_password");
						}else{
							$this->app->utility->set_message("Oops..Problem in Sending SMS", "ERROR");
							$this->app->redirect("index.php?view=forgot_password");
						}
					}
				}
				/*==========================================================*/							
			}else{
				$this->app->utility->set_message("Your Mobile Number in not authenticated. Enter valid Mobile Number", "ERROR");
				$this->app->redirect("index.php?view=forgot_password");
			}
		}else{
			$this->app->utility->set_message("Please Select an Option to get your password.", "ERROR");
			$this->app->redirect("index.php?view=forgot_password");	
		}		
	}		
}	
?>