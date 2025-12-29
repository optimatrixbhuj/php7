<?php
define("VIR_DIR","WebServices");
include("../core/app.php");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept'); 
header('Content-Type: text/plain'); 

if((ENV_VER!='TEST') && ($_SERVER['REQUEST_METHOD']=='GET')) {
   // Up to you which header to send, some prefer 404 even if the files does exist for security
    header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );

	// choose the appropriate page to redirect users
	die( header( 'location: ../access_denied.html' ) );

}

$app = & app::get_instance();
$app->initialize();

$jsonclass = $app->load_module("Services_JSON");
$obj_JSON = new $jsonclass(SERVICES_JSON_LOOSE_TYPE);

$records = array();

function android_notification($deviceToken,$message){
		$gcm = new GCM();
		$registatoin_ids = array();
		$registatoin_ids[] = $deviceToken;
		$message = array("price" => $message);
		$result = $gcm->send_notification($registatoin_ids, $message);
		//print_r($result);exit;
}

if($app->getRequestVar("type") !=''){
	switch($app->getRequestVar("type")){
		// ----------------------------------------- client_list START --------------------------------------------- //
		//http://192.168.1.25/php7/WebServices/WS.php?type=client_list
		case "client_list":
			$obj_model_client_branch = $app->load_model("client_branch");
			$obj_model_client_branch->join_table("client_master","left",array("id","client_name"),array("client_master_id"=>"id"));
			$obj_model_client_branch->set_fields_to_get(array("id","city"));			
			$rs_client_branch=$obj_model_client_branch->execute("SELECT",false,"","client_master.status='Active' AND client_branch.status='Active'","client_name ASC");			
			if(count($rs_client_branch)>0){			
				$data[0]['result']='success';
				$data[0]['msg']='CRM Client Data';			
				$data[0]['client_list']=$rs_client_branch;
			}else{
				$data[0]['result']='fail';
				$data[0]['msg']='CRM Client Data Not Available';
			}	
			$records=$data;	
			break;
		//------------------- client_list END -------------------------------//	

			// ----------------------------------------- client_list START --------------------------------------------- //
		//http://192.168.1.25/php7/WebServices/WS.php?type=client_list
		case "user_list":
			$obj_model_client_branch = $app->load_model("admin_user");
			$obj_model_client_branch->join_table("admin_user_group","left",array("id","group_name"),array("admin_user_group_id"=>"id"));
			$obj_model_client_branch->join_table("branch","left",array("id","name"),array("branch_id"=>"id"));
			// $obj_model_client_branch->set_fields_to_get(array(			"id","city"));			
			$rs_client_branch=$obj_model_client_branch->execute("SELECT",false,"","admin_user.status='Active'","full_name ASC");			
			if(count($rs_client_branch)>0){			
				$data[0]['result']='success';
				$data[0]['msg']='CRM Client Data';			
				$data[0]['user_list']=$rs_client_branch;
			}else{
				$data[0]['result']='fail';
				$data[0]['msg']='CRM Client Data Not Available';
			}	
			$records=$data;	
			break;
		//------------------- client_list END -------------------------------//	
	}
	echo $obj_JSON->encode(array("DATA"=>$records));			
}
?>