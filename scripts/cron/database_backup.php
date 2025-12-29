<?php	
	define("VIR_DIR","scripts/cron/");
	require("../../core/app.php");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

	$app = & app::get_instance();
	$app->initialize();
	
	ini_set('max_execution_time', 0);
	ini_set('memory_limit', '4096M');
	
	$file_name = DB_DATABASE."_".date("YmdHis").".sql.gz";
	$backupFile = ABS_PATH.'/uploads/backup/'.$file_name;	
	if (file_exists($backupFile)) {
		unlink($backupFile);
	}
	$command = 'mysqldump --opt -h ' . DB_HOST . ' -u ' . DB_USERNAME . ' -p\'' . DB_PASSWORD . '\' ' . DB_DATABASE . ' | gzip > ' . $backupFile;
	//$command = 'mysqldump -u' . $user . ' -p' . $pass . ' ' . $name . ' >' . $backupFile;
	system($command,$output);
	
	if(file_exists($backupFile)){
		$obj_mailer = $app->load_module("mailer\sender");	
		$mail_body = "<h2>".DEFAULT_TITLE." Database Backup Date : ".date("d-m-Y g:i A")."</h2>";
		$obj_mailer->create();
		$obj_mailer->subject(DEFAULT_TITLE." Backup");
		$obj_mailer->add_to("optimatrixbackup@gmail.com");
		//$obj_mailer->add_to("jay@optiinfo.com");		
		$obj_mailer->mailfrom(FROM_EMAIL,FROM_NAME);
		$obj_mailer->attatch($backupFile,$file_name);
		$obj_mailer->htmlbody($mail_body);
		$flag = $obj_mailer->send();
		if($flag){
			unlink($backupFile);
			echo "Email send successfully !";	
		}else{
			unlink($backupFile);
			echo "Problem in send email.";
		}
	}
?>