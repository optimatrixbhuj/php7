<?php 

/*===== Do PHP Version check. We need at least PHP 5.0.0 ========= */

if (version_compare(PHP_VERSION, '5.0.0', '<')){

	trigger_error("This system requires PHP 5.0.0 or above to work. <br/>You have PHP ".PHP_VERSION." in this system", E_USER_ERROR);

}

/*=================================================================*/

define("__CONFIG__","1");

ini_set("display_errors", "on");

ini_set("max_execution_time", 0);

ini_set("date.timezone", "Asia/Kolkata");

	//ini_set('max_execution_time', 800);

ini_set('memory_limit', '512M');

	//@set_magic_quotes_runtime(false);

error_reporting(E_ALL);

	// echo $_SERVER['DOCUMENT_ROOT'];
	// echo $_SERVER['HTTP_HOST'];

$check = stream_get_wrappers();

/*echo 'openssl: ',  extension_loaded  ('openssl') ? 'isload':'noload','<br>';

echo 'http: ', in_array('http', $check) ? 'ok':'no','<br>';

echo 'https: ', in_array('https', $check) ? 'ok':'no','<br>';*/



if($_SERVER['HTTP_HOST'] == "192.168.1.25:8074"){

	/*==================== Absolute path ====================*/

	define("ABS_PATH","F:\\wwwseven\\php7");


	/*=======================================================*/

	/*================= DB Connection Info ==================*/

	define("DB_HOST","localhost");

	define("DB_DATABASE","php7");

	define("DB_USERNAME","root");

	define("DB_PASSWORD","rootadmin");

	/*=======================================================*/

	/*==== Access URL or Server Root of the application =====*/

	define("SERVER_ROOT","http://192.168.1.25:8074/php7");

	/*=======================================================*/

	define("DISPLAY_XPM4_ERRORS", false);

	if(!defined("ERROR_LOG")){

		define("ERROR_LOG", ABS_PATH."\\logs\\error_log.txt");

	}

	define("ENV_VER", "TEST");

}elseif($_SERVER['HTTP_HOST'] == "192.168.1.111"){

	/*==================== Absolute path ====================*/

	define("ABS_PATH","D:\\AppServ\\www\\php7");


	/*=======================================================*/

	/*================= DB Connection Info ==================*/

	define("DB_HOST","localhost");

	define("DB_DATABASE","php7");

	define("DB_USERNAME","root");

	define("DB_PASSWORD","rootadmin");

	/*=======================================================*/

	/*==== Access URL or Server Root of the application =====*/

	define("SERVER_ROOT","http://192.168.1.111/php7");

	/*=======================================================*/

	define("DISPLAY_XPM4_ERRORS", false);

	if(!defined("ERROR_LOG")){

		define("ERROR_LOG", ABS_PATH."\\logs\\error_log.txt");

	}

}elseif($_SERVER['HTTP_HOST'] == "192.168.1.108"){

	/*==================== Absolute path ====================*/

	define("ABS_PATH","D:\wamp\\www\\php7");


	/*=======================================================*/

	/*================= DB Connection Info ==================*/

	define("DB_HOST","localhost");

	define("DB_DATABASE","php7");

	define("DB_USERNAME","root");

	define("DB_PASSWORD","rootadmin");

	/*=======================================================*/

	/*==== Access URL or Server Root of the application =====*/

	define("SERVER_ROOT","http://192.168.1.108/php7");

	/*=======================================================*/

	define("DISPLAY_XPM4_ERRORS", false);

	if(!defined("ERROR_LOG")){

		define("ERROR_LOG", ABS_PATH."\\logs\\error_log.txt");

	}


}elseif($_SERVER['HTTP_HOST'] == "103.96.14.10"){

	/*==================== Absolute path ====================*/

	define("ABS_PATH","D:\\AppServ\\www\\php7");

	/*=======================================================*/

	/*================= DB Connection Info ==================*/

	define("DB_HOST","localhost");

	define("DB_DATABASE","php7");

	define("DB_USERNAME","root");

	define("DB_PASSWORD","rootadmin");

	/*=======================================================*/

	/*==== Access URL or Server Root of the application =====*/

	define("SERVER_ROOT","http://103.96.14.10/structure");

	/*=======================================================*/

	define("DISPLAY_XPM4_ERRORS", false);

	if(!defined("ERROR_LOG")){

		define("ERROR_LOG", ABS_PATH."\\logs\\error_log.txt");

	}

}elseif($_SERVER['HTTP_HOST'] == "192.168.1.103"){

	/*==================== Absolute path ====================*/

	define("ABS_PATH","D:\\websites\\AppServ\\www\\structure");

	/*=======================================================*/

	/*================= DB Connection Info ==================*/

	define("DB_HOST","localhost");

	define("DB_DATABASE","structure");

	define("DB_USERNAME","root");

	define("DB_PASSWORD","admin");

	/*=======================================================*/

	/*==== Access URL or Server Root of the application =====*/

	define("SERVER_ROOT","http://192.168.1.103/structure");

	/*=======================================================*/

	define("DISPLAY_XPM4_ERRORS", false);

	if(!defined("ERROR_LOG")){

		define("ERROR_LOG", ABS_PATH."\\logs\\error_log.txt");

	}

}elseif($_SERVER['HTTP_HOST'] == "198.57.187.165"){

	/*==================== Absolute path ====================*/

	define("ABS_PATH","/home/demotest/public_html/");

	/*=======================================================*/

	/*================= DB Connection Info ==================*/

	define("DB_HOST","localhost");

	define("DB_DATABASE","");

	define("DB_USERNAME","");

	define("DB_PASSWORD",'');

	/*=======================================================*/

	/*==== Access URL or Server Root of the application =====*/

	define("SERVER_ROOT","http://198.57.187.165/");

	/*=======================================================*/

	define("DISPLAY_XPM4_ERRORS", false);

	if(!defined("ERROR_LOG")){

		define("ERROR_LOG", ABS_PATH."\\logs\\error_log.txt");

	}

}else{

	/*==================== Absolute path ====================*/

	define("ABS_PATH","/home/php7optimatrix/public_html/");

	

	/*=======================================================*/

	/*================= DB Connection Info ==================*/

	define("DB_HOST","localhost");

	define("DB_DATABASE","php7opti_stracture7");

	define("DB_USERNAME","php7opti_php7optimatrix");

	define("DB_PASSWORD",'8JUJ1Ezk.NP=');

	/*=======================================================*/

	/*==== Access URL or Server Root of the application =====*/

	define("SERVER_ROOT","https://php7.optimatrix.in");

	

	/*=======================================================*/

	define("DISPLAY_XPM4_ERRORS", false);

	if(!defined("ERROR_LOG")){

		define("ERROR_LOG", ABS_PATH."/logs/error_log.txt");

	}

	define("ENV_VER", "LIVE");
}

/*==================== Absolute path ====================*/





/*=============== Debug leve (1 to 4) ===================*/

if(!defined("DEBUG")){

	define("DEBUG",3);

}



/*======= Cache directory (to store cached files) =======*/

if(!defined("CACHE_DIR")){

	define("CACHE_DIR", ABS_PATH."\\cache");

}



/*============= Cache time in seconds  ==================*/

if(!defined("CACHE_TIME")){

	define("CACHE_TIME", 60);

}



/*================= DB Connection Info ==================*/





/*==========Default paramters for paging ================*/

define("RECORD_PER_PAGE",20);

define("SEGMENT_LENGTH",5);



/*============== Default Meta Tags ======================*/

define("DEFAULT_TITLE","OPTIMATRIX Structure PHP7");

define("DEFAULT_KEYWORDS","OPTIMATRIX Structure PHP7");

define("DEFAULT_DESCRIPTION","OPTIMATRIX Structure PHP7");	



/*=============== Relative to ABS_PATH path ============*/

if(!defined("VIR_DIR")){

	define("VIR_DIR","");

}



/*==== Access URL or Server Root of the application =====*/



define("SQL_STATEMENTS_LOG", "no"); // yes or no



/*=== FTP Information - Needed for fileupload process ===*/

if(!defined("USE_FTP")){

	define("USE_FTP", false);

}

if(!defined("FTP_HOST")){

	define("FTP_HOST", "localhost");

}

if(!defined("FTP_USERNAME")){

	define("FTP_USERNAME", "");

}

if(!defined("FTP_PASSWORD")){

	define("FTP_PASSWORD", "");

}

if(!defined("FTP_WWWDIR")){

	define("FTP_WWWDIR", "");

}



/*============== mail template storage path =============*/

define("MAIL_TEMPLATE_PATH", "mail_templates");



/*== Automatically TRIM Post Variables in MySQL Query ===*/

define("AUTO_TRIM", true);



/*================= Mail server settings ================*/

if(!defined("SMTPDIRECT")){

	define("SMTPDIRECT", "0");

}

if(!defined("SMTPHOST")){

	define("SMTPHOST", "");

}

if(!defined("SMTPPORT")){

	define("SMTPPORT", "25");

}

//SMTP Connection encryption type. Possible values are: tls, ssl, sslv2 or sslv3

if(!defined("SMTPSECURITY")){

	define("SMTPSECURITY", "");

}

if(!defined("SMTPUSER")){

	define("SMTPUSER", "");

}

if(!defined("SMTPPASS")){

	define("SMTPPASS", "");

}

if(!defined("FROM_EMAIL")){

	define("FROM_EMAIL", "support@optiinfo.com");		

}

if(!defined("FROM_NAME")){

	define("FROM_NAME", "OPTIMATRIX Structure PHP7");

}



/* ============ Company/Firm Details ================== */

define("COMPANY_NAME", "COMPANY NAME");

define("COMPANY_ADDRESS", "YOUR ADDRESS HERE");

define("COMPANY_EMAIL", FROM_EMAIL);

define("COMPANY_PHONE", "MOBILE NUMBER");

define("COMPANY_WEBSITE", SERVER_ROOT);

define("COMPANY_GSTIN", "");

define("COMPANY_PAN", "");

define("BANK_AC_NAME", "");

define("BANK_NAME", "");

define("BANK_BRANCH", "");

define("BANK_AC_NUMBER", "");

define("BANK_IFSC", "");

define("JURIDICTION_CITY", "CITY");

define("FILE_PREFIX", "CompanyName");

/* ============ Company/Firm Details ================== */


/*======= SMS environment version :: TEST/LIVE ========*/
if(!defined("SMS_VER")){
	define("SMS_VER", "TEST");
	//define("SMS_VER", "LIVE");
}
/*======= SMS environment version :: TEST/LIVE ========*/
/* ======= TRANSACTIONAL SMS Details UNDER 8000701803 ====== */

/*define("SMS_MOBILE_NUMBER","9408484421");

define("SMS_PASSWORD","oyo@rental");

define("SMS_SENDER_ID","AYOAYO");

define("SMS_URL","http://msg.optimatrix.in/");

/*=========================== */

?>