<?php

class _default extends controller{



	function init(){

		/*$dir = $_SERVER['DOCUMENT_ROOT'].'/../www.kutchtoursandtravels.com';

		$d = dir($dir);

		echo "Handle: " . $d->handle . "\n";

		echo "Path: " . $d->path . "\n";

		while (false !== ($entry = $d->read())) {

		   echo $entry."\n";

		}

		$d->close();*/

	}

	

	function onload(){	

		$me = $this->app->getGetVar('me');

		if($me == "logout"){

			$this->app->assign("me",$me);

		}

	}

	

	function do_login(){

		$obj_model_login = $this->app->load_model("admin_user");

		$sql="SELECT * FROM admin_user WHERE BINARY username = '".$this->app->getPostVar("username")."' AND BINARY password =  '".md5($this->app->getPostVar("password"))."' AND status='Active'";

		//echo $sql;exit;

		$rs = $obj_model_login->execute("SELECT",false,$sql);
		
		if(count($rs)>0){

			$admin_id = $rs[0]['id'];

		}

		if($admin_id!=NULL){

			$obj_model_user = $this->app->load_model("admin_user",$admin_id);

			$rs_user=$obj_model_user->execute("SELECT");

			if(count($rs_user)>0){

				$_SESSION['admin_user_id'] = $admin_id;

				$_SESSION['user_name']=$rs_user[0]['full_name'];

				$_SESSION['admin_user_group_id']=$rs_user[0]['admin_user_group_id'];

				$_SESSION['last_login_time']=$rs_user[0]['last_login'];

				$_SESSION['branch_id'] = $rs_user[0]['branch_id'];

				if($rs_user[0]['photo']!=""){

					$_SESSION['user_photo']=SERVER_ROOT."/".$this->app->get_user_config("admin_user").$rs_user[0]['photo'];

				}else{

					$_SESSION['user_photo']="";

				}

				$_SESSION['timestamp']=time();

								

				$sql_update_last_login="UPDATE admin_user SET last_login='".date("Y-m-d H:i:s")."' WHERE id=".$admin_id;

				$obj_model_user->execute("UPDATE",false,$sql_update_last_login);				

				// check password change date

				$now = time();

				$pwd_date = strtotime($rs_user[0]['pwd_change_date']);      //password change date

				$datediff = $now - $pwd_date;

				$total_days = round($datediff / (60 * 60 * 24));

				//echo $total_days;exit;

				if($total_days >= 90 && $_SERVER['HTTP_HOST'] != "192.168.1.111"){

					$_SESSION['change_pwd']=false;

					$_SESSION['change_pwd_msg']="Your password is older than 90 or more days. Please change it for security purpose.";

					$this->app->redirect("index.php?view=change_password");

				}else{

					$this->app->redirect("index.php?view=home");

				}

			}

		}else{

			$this->app->utility->set_message("Username and Password does not match", "ERROR"); 

			$this->app->redirect("index.php");

		}		

	}	

	

	function do_logout(){

		session_unset();

		session_destroy();

		session_start();

		//$this->app->utility->set_message("You have successfully logged out of the system", "SUCCESS");

		$this->app->redirect("index.php?view=default&me=logout");

	}	

}	

?>