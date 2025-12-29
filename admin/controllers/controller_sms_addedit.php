<?php 
class _sms_addedit extends controller{
	function init(){
	}
	function onload(){
		$obj_model_subject = $this->app->load_model("sms_template");
		$rs_subject = $obj_model_subject->execute("SELECT");
		$subject = array();
		$subject[''] = "-Select Subject-";
		for($i=0;$i<count($rs_subject);$i++){
			$subject[$rs_subject[$i]['id']]=$rs_subject[$i]['subject'];
		}
		$this->assign("subject",$subject);
		if($_SESSION['admin_user_group_id']=='1'){
			//fetch branch
			$branch=$this->app->utility->get_dropdown("branch","id","name","Select Branch","","name");
			$this->assign("branch",$branch);
			//set branch_id
			$this->assign("field_branch_id",1);	
		}

		$sms_group=array("Admin User","Agent","Client","Driver","Hotel","Service Provider","Staff");
		$this->assign("sms_group",$sms_group);
	}
	function send_message(){
		//echo "<pre>";print_r($this->app->getPostVars());exit;
		$language = $this->app->getPostVar("language");
		$sms = $this->app->getPostVar("message");		
		//for single number
		if($this->app->getPostVar("single_num")!=""){
			$mobile_nums = $this->app->getPostVar("single_num");
		}
		//for selected customers
		else{
			$cust_member = $this->app->getPostVar("contact");
		    $cust_contact = array();
			if(count($cust_member)>0){
				$cust_contact = array_merge($cust_contact,$cust_member);	
			}			
			$cust_contact = array_unique($cust_contact);
			
			$mobile_nums=implode(",",$cust_contact);
		}
		//echo $mobile_nums;exit;
		
		//echo $sms."<br>".$mobile_nums;
		if($mobile_nums!=""){
			//send sms
			$msg_id = $this->app->utility->send_sms($mobile_nums,$sms,$language);
			
			//message log
			$obj_model_msg_log = $this->app->load_model("message_log");
			$add_msg_field = array();
			$add_msg_field['message'] = $sms;
			$add_msg_field['to_number'] = $mobile_nums;
			$add_msg_field['msg_id']=$msg_id;
			$add_msg_field['called_from'] = "ADMIN_SEND_SMS";			
			$obj_model_msg_log->map_fields($add_msg_field);
			$obj_model_msg_log->execute("INSERT");
			
			if($msg_id!="send message failed"){
				$this->app->utility->set_message("SMS Sent Successfully!", "SUCCESS");
				$this->app->redirect("index.php?view=sms_addedit");
			}
			else{
				$this->app->utility->set_message("Ooops...SMS Sent Failed.", "ERROR");
				$this->app->redirect("index.php?view=sms_addedit");
			}
		}
		else{
			$this->app->utility->set_message("No Mobile Numbers Selected.", "ERROR");
			$this->app->redirect("index.php?view=sms_addedit");
		}
	}
}
?>