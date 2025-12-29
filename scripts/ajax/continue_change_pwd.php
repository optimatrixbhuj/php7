<?php
	define("VIR_DIR","../scripts/ajax/");
	require("../../core/app.php");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	
	$app = & app::get_instance();
	$app->initialize();
	unset($_SESSION['change_pwd']);
	unset($_SESSION['change_pwd_msg']);
?>