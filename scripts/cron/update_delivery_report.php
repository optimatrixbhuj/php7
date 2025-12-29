<?php 
	define("VIR_DIR","scripts/cron/");
	require("../../core/app.php");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	
	$app = & app::get_instance();
	$app->initialize();
	
	ini_set('max_execution_time', 800);
	ini_set('memory_limit', '512M');
	
	//$date="2018-12-05";
	$date=date("Y-m-d");
	$html='';
	
	$obj_model_message_log=$app->load_model("message_log");
	$rs_message_log=$obj_model_message_log->execute("SELECT",false,"","date='".$date."' AND (delivery_report='' OR delivery_report='Sent')","id ASC");
	$cnt=0;
	if(count($rs_message_log)>0){
		foreach($rs_message_log as $message_log){
			$delivery_report =$app->utility->delivery_report($message_log['msg_id']);
			if($delivery_report!=""){
				$obj_model_sms = $app->load_model("message_log");
				$sql_update = "UPDATE message_log SET delivery_report='".$delivery_report."' WHERE id=".$message_log['id'];
				$rs_update = $obj_model_sms->execute("UPDATE",false,$sql_update);
				if($rs_update){
					$cnt++;
					$html.=($html!=''?", ":"").$message_log['to_number'];	
				}
			}
		}
		if($cnt>0){
			$html="Total ".$cnt." records updated for delivery report for date : ".date("d-m-Y",strtotime($date))." Numbers are \n".$html;
		}else{
			$html="Can't update delivery report for date : ".date("d-m-Y",strtotime($date));
		}
	}else{
		$html='No update for delivery report for date : '.date("d-m-Y",strtotime($date));
	}
	echo $html;
?>