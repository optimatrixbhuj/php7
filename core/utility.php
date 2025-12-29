<?php

class utility extends Singleton{

	private $uploaded_file;

	public $app;

	

	public static function &get_instance() { 

		parent::$my_name = __CLASS__; 

		return parent::get_instance(); 

	}

	

	function init(){

		$this->app = &app::get_instance();

	}

	function ArraySearchRecursive($needle, $haystack){

		foreach($haystack as $value){

			if(is_array($value))

				$match=array_search_r($needle, $value);

			if($value==$needle)

				$match=1;

			if($match)

				return 1;

		}

		return 0;

	}

	function backup_tables($filename,$host=DB_HOST,$user=DB_USERNAME,$pass=DB_PASSWORD,$name=DB_DATABASE,$tables = '*'){

		$return = "";

		$link = mysqli_connect($host,$user,$pass,$name);

		//mysqli_select_db($name,$link);

		//get all of the tables

		if($tables == '*'){

			$tables = array();

			$result = mysqli_query($link,'SHOW TABLES');

			while($row = mysqli_fetch_row($result)){

				$tables[] = $row[0];

			}

		}else{

			$tables = is_array($tables) ? $tables : explode(',',$tables);

		}

		//cycle through

		foreach($tables as $table){

			$result = mysqli_query($link,'SELECT * FROM '.$table);

			$num_fields = mysqli_num_fields($result);

			$return.= 'DROP TABLE IF EXISTS '.$table.';';

			$row2 = mysqli_fetch_row(mysqli_query($link,'SHOW CREATE TABLE '.$table));

			$return.= "\n\n".$row2[1].";\n\n";

			$insert = 'INSERT INTO '.$table.' VALUES ';

			$all_records = array();

			while($row = mysqli_fetch_row($result)){

				$one_row = '(';

				for($j=0; $j<$num_fields; $j++){

					$row[$j] = addslashes($row[$j]);

					//$row[$j] = ereg_replace("\n","\\n",$row[$j]);

					$row[$j] = str_replace("\n","\\n",$row[$j]);

					if (isset($row[$j])) { 

						$one_row.= '"'.$row[$j].'"';

					} else { 

						$one_row.= '""';

					}

					if ($j<($num_fields-1)) { 

						$one_row.= ',';

					}

				}

				$one_row.= ")";

				$all_records[] = $one_row;

			}

			if(count($all_records) > 0){

				$pieces_array = array_chunk($all_records,150);

				for($i=0;$i<count($pieces_array);$i++){

					$return.=$insert.implode(",",$pieces_array[$i]).";\n";

				}

			}

			$return.="\n\n\n";

		}

		if(!$filename){

			$filename=date("YmdHis").'.sql';

		}

		//Insert into backup table		

		$obj_model_backup = $this->app->load_model("backup");

		$add_field = array();

		$add_field["file_name"]=$filename;		

		$obj_model_backup->map_fields($add_field);

		$inserted_id = $obj_model_backup->execute("INSERT");

		//add user log for INSERT

		$this->app->utility->add_user_log("backup",$inserted_id,"INSERT");		



		$handle = fopen(ABS_PATH.'/uploads/backup/'.$filename,'w+');		// NOTE : IF CHANGE PATH, DO CHANGE IN send_mail_backup_db FUNCTION ALSO	

		fwrite($handle,$return);

		fclose($handle);	

	}

	

	function send_mail_backup_db($filename){

		$dir = ABS_PATH."/uploads/backup/";	

		$filename=DB_DATABASE."_".date("YmdHis").".sql";

		$file_path=$dir.$filename;

		$this->backup_tables($filename);

		

		$obj_mailer = $this->app->load_module("mailer\sender");		

		$mail_body = "<h2>".COMPANY_NAME." Database Backup Date : ".date("d-m-Y g:i A")."</h2>";			

		$obj_mailer->create();

		$obj_mailer->subject(COMPANY_NAME." Backup");

		$obj_mailer->add_to("optimatrixbackup@gmail.com");

		$obj_mailer->mailfrom(FROM_EMAIL,FROM_NAME);

		$obj_mailer->attatch($file_path,$filename);

		$obj_mailer->htmlbody($mail_body);

		$flag = $obj_mailer->send();

		return $flag;

	}

	

	function ChangeDateFormat($Date, $FromFormat, $ToFormat){

		$KnownFormat = array("012"=>"ddmmyyyy","102"=>"mmddyyyy","210"=>"yyyymmdd");

		if(!in_array($FromFormat,$KnownFormat) || !in_array($ToFormat,$KnownFormat)){

			echo "<h3>Error in function \"ConvertDateFormat\" : Unknown Date Format";

			exit;

		}

		$Seperator="";

		if(strpos($Date,"/")===false){

		}else{

			$Seperator="/";

		}

		if(strpos($Date,"\\")===false){

		}else{

			$Seperator="\\";

		}

		if(strpos($Date,"-")===false){

		}else{

			$Seperator="-";

		}

		if($Seperator==""){

			echo "<h3>Error in function \"ChangeDateFormat\" : Unknown Date Seperator";

			exit;

		}

		$DateArr = explode($Seperator,$Date);

		$FromDateSequence = array_search($FromFormat, $KnownFormat);

		

		$Day = $DateArr[strpos($FromDateSequence,"0")];

		$Month = $DateArr[strpos($FromDateSequence,"1")];

		$Year = $DateArr[strpos($FromDateSequence,"2")];

		

		$ToDateSequence = array_search($ToFormat, $KnownFormat);

		

		$NewDate = $DateArr[substr($ToDateSequence,0,1)].$Seperator.$DateArr[substr($ToDateSequence,1,1)].$Seperator.$DateArr[substr($ToDateSequence,2,1)];

		return $NewDate;

	}

	function convert_seo_url($str){

		$var = preg_replace("!-+!","-",preg_replace("!_+!","-",strtolower(preg_replace("~[^a-z0-9_-]~i", "",str_replace(" ","_",$str)))));

		return $var;

	}	

		function DateAdd($interval, $number, $date="") {

			if($date!=""){

				$date_time_array = getdate($date);

			}else{

				$date_time_array = getdate();

			}

			$hours = $date_time_array['hours'];

			$minutes = $date_time_array['minutes'];

			$seconds = $date_time_array['seconds'];

			$month = $date_time_array['mon'];

			$day = $date_time_array['mday'];

			$year = $date_time_array['year'];



			switch ($interval) {    

				case 'yyyy':

				$year+=$number;

				break;

				case 'q':

				$year+=($number*3);

				break;

				case 'm':

				$month+=$number;

				break;

				case 'y':

				case 'd':

				case 'w':

				$day+=$number;

				break;

				case 'ww':

				$day+=($number*7);

				break;

				case 'h':

				$hours+=$number;

				break;

				case 'n':

				$minutes+=$number;

				break;

				case 's':

				$seconds+=$number; 

				break;            

			}

			$timestamp= mktime($hours,$minutes,$seconds,$month,$day,$year);

			return $timestamp;

		}

		function DateDiff($endDate, $beginDate){

			$date_parts1[0]=date("m", $beginDate);

			$date_parts1[1]=date("d", $beginDate);

			$date_parts1[2]=date("Y", $beginDate);



			$date_parts2[0]=date("m", $endDate);

			$date_parts2[1]=date("d", $endDate);

			$date_parts2[2]=date("Y", $endDate);



			$start_date=gregoriantojd($date_parts1[0], $date_parts1[1], $date_parts1[2]);

			$end_date=gregoriantojd($date_parts2[0], $date_parts2[1], $date_parts2[2]);

			return $end_date - $start_date;

		}



		function format_currency($number, $decimal_places=2, $decimal_symbol=".", $thousand_seperator=",", $currency_symbol="", $currency_symbol_position='before'){

			if(!is_numeric($number)){

				return $number;

			}else{

				$formatted_number = number_format($number, $decimal_places, $decimal_symbol, $thousand_seperator);

				if($currency_symbol!=""){

					if($currency_symbol_position=='after'){

						$formatted_number = $formatted_number." ".$currency_symbol;

					}else{

						$formatted_number = $currency_symbol." ".$formatted_number;

					}

				}

				return $formatted_number;

			}

		}

		function GenerateRandomKey($Length){

			$Key = "";

			$found = false;

			while(strlen($Key)<$Length){

				srand((double)microtime()*1000000);

				$number = rand(50,150);

				if($number>=65 && $number<=90)

					$Key = $Key.chr($number);

				elseif($number>=48 && $number<=57)

					$Key = $Key.chr($number);

			}

			return trim($Key);	

		}

		function GenerateRandomDigits($Length){

			$Key = "";

			$found = false;

			while(strlen($Key)<$Length){

				srand((double)microtime()*1000000);

				$number = rand(50,150);

				if($number>=65 && $number<=90)

					$Key = $Key.$number;

				elseif($number>=48 && $number<=57)

					$Key = $Key.$number;

			}

			return trim($Key);	

		}

		function get_file_info($file){

			$file_name = basename($file);

			$tmparr = explode(".", $file_name);

			$fileinfo = (object)NULL;

			$file_name = "";

			for($i=0; $i<(count($tmparr)-1); $i++){

				$file_name.=".".$tmparr[$i];

			}

			if(strlen($file_name)>0){

				$file_name = substr($file_name, 1);

			}

			$fileinfo->filename = $file_name;

			$fileinfo->extension = $tmparr[count($tmparr)-1];	

			return $fileinfo;

		}

		function get_message(){	

			if(isset($_SESSION['msg']) && isset($_SESSION['type'])){

				if(VIR_DIR==""){

					if($_SESSION['type']=='SUCCESS'){

						$message =  '<div class="alert alert-success hide_print" role="alert">&nbsp;'.$_SESSION['msg'].'</div>';

					}else if($_SESSION['type']=='ERROR'){

						$message =  '<div class="alert alert-danger hide_print">&nbsp;'.$_SESSION['msg'].'</div>';

					}else if($_SESSION['type']=='WARNING'){

						$message =  '<div class="alert alert-warning hide_print">&nbsp;'.$_SESSION['msg'].'</div>';

					}

				}else{

					if($_SESSION['type']=='SUCCESS'){

						$message =  '<div style="border:#009900 1px solid; background:#e3ffdf url(images/yes.png) no-repeat 5px 5px; padding-top:5px; width:100%; padding-top:5px; padding-bottom:5px; margin-bottom:20px" class="hide_print success_msg">

						<div style="margin-left:25px; color:#009900; line-height:16px">&nbsp;'.$_SESSION['msg'].'</div><div style="clear:both"></div>

						</div>';

					}else if($_SESSION['type']=='ERROR'){

						$message =  '<div style="border:#cc3300 1px solid; background:#ffe1e1 url(images/not.png) no-repeat 5px 5px; padding-top:5px; width:100%; padding-top:5px; padding-bottom:5px; margin-bottom:20px" class="hide_print error_msg">

						<div style="margin-left:25px; color:#cc3300; line-height:16px">'.$_SESSION['msg'].'</div><div style="clear:both"></div>

						</div>';

					}else if($_SESSION['type']=='WARNING'){

						$message =  '<div style="border:#c69e00 1px solid; width:100%; background:#fffbcc url(images/Message.png) no-repeat 5px 5px; padding-top:5px; padding-bottom:5px; margin-bottom:20px" class="hide_print warning_msg">

						<div style="margin-left:25px; color:#c69e00; line-height:16px">&nbsp;'.$_SESSION['msg'].'</div><div style="clear:both"></div>

						</div>';

					}

				}

				unset($_SESSION['msg']);

				unset($_SESSION['type']);

				return $message;		

			}

		}

		function get_uploaded_file(){

			return $this->uploaded_file;

		}

		function GetContentType($file_extension){

			switch(strtolower($file_extension)){

				case "pdf": $ctype="application/pdf"; break;

				case "exe": $ctype="application/octet-stream"; break;

				case "zip": $ctype="application/zip"; break;

				case "doc": $ctype="application/msword"; break;

				case "xls": $ctype="application/vnd.ms-excel"; break;

				case "ppt": $ctype="application/vnd.ms-powerpoint"; break;

				case "gif": $ctype="image/gif"; break;

				case "png": $ctype="image/png"; break;

				case "jpeg":

				case "jpg": $ctype="image/jpg"; break;

				case "mp3": $ctype="audio/mpeg"; break;

				case "wav": $ctype="audio/x-wav"; break;

				case "mpeg":

				case "mpg":

				case "mpe": $ctype="video/mpeg"; break;

				case "mov": $ctype="video/quicktime"; break;

				case "avi": $ctype="video/x-msvideo"; break;

				case "php":

				case "htm":

				case "html":

				case "txt": die("<b>Cannot be used for ". $file_extension ." files!</b>"); break;

				default: $ctype="application/x-download";

			}

			return $ctype;

		}

		function GetPageName(){

			$tmpArray = explode(DS,$_SERVER['SCRIPT_FILENAME']);

			$pagename = $tmpArray[sizeof($tmpArray)-1];

			return $pagename;

		}

		function GetPageURL(){

			$pageURL = 'http://';

			if(array_key_exists("HTTPS", $_SERVER)){

				if(strtoupper($_SERVER["HTTPS"])=="ON"){

					$pageURL = 'https://';

				}

			}

			$pageURL .= $_SERVER['HTTP_HOST']."/".$_SERVER["REQUEST_URI"];

			return $pageURL;

		}

		function addOrUpdateUrlParam($name, $value)

		{

			$params = $this->app->getGetVars();

			unset($params[$name]);

			$params[$name] = $value;

			print_r($params);

			return basename($_SERVER['PHP_SELF']).'?'.http_build_query($params);

		}

		function html2txt ( $document ){

			$search = array ("'<script[^>]*?>.*?</script>'si",	// strip out javascript

					"'<[\/\!]*?[^<>]*?>'si",		// strip out html tags

					"'([\r\n])[\s]+'",			// strip out white space

					"'@<![\s\S]*?â??[ \t\n\r]*>@'",

					"'&(quot|#34|#034|#x22);'i",		// replace html entities

					"'&(amp|#38|#038|#x26);'i",		// added hexadecimal values

					"'&(lt|#60|#060|#x3c);'i",

					"'&(gt|#62|#062|#x3e);'i",

					"'&(nbsp|#160|#xa0);'i",

					"'&(iexcl|#161);'i",

					"'&(cent|#162);'i",

					"'&(pound|#163);'i",

					"'&(copy|#169);'i",

					"'&(reg|#174);'i",

					"'&(deg|#176);'i",

					"'&(#39|#039|#x27);'",

					"'&(euro|#8364);'i",			// europe

					"'&a(uml|UML);'",			// german

					"'&o(uml|UML);'",

					"'&u(uml|UML);'",

					"'&A(uml|UML);'",

					"'&O(uml|UML);'",

					"'&U(uml|UML);'",

					"'&szlig;'i",

				);

			$replace = array (	"",

				"",

				" ",

				"\"",

				"&",

				"<",

				">",

				" ",

				chr(161),

				chr(162),

				chr(163),

				chr(169),

				chr(174),

				chr(176),

				chr(39),

				chr(128),

				"Ã¤",

				"Ã¶",

				"Ã¼",

				"Ã?",

				"Ã?",

				"Ã?",

				"Ã?",

			);



			$text = preg_replace($search,$replace,$document);



			return trim ( $text );

		}

		function HTMLSafeString($Input, $QuotedString=true){

			$Output = "";

			$Output = strip_tags($Input);

			if($QuotedString)

				$Output = str_replace("\"","",$Output);

			return $Output;

		}

		function NormalizeURL($URL, $tolower = true){

			$find = array("/\s+/", "/[-]+/", "/\\\/", "/'/");

			$replace_with = array("-", "-", "", "");

			$URL = preg_replace($find, $replace_with, $URL);

			if($tolower){

				$URL = strtolower($URL);

			}

			return strtolower($URL);

		}

		function ParseMailTemplate($Template, $Custom=""){	

			$GeneralKywords = array();

			$GeneralKywords["SERVER_ROOT"]=SERVER_ROOT;



			$f = fopen(ABS_PATH.DS.MAIL_TEMPLATE_PATH."/".$Template,"r");

			if(!$f){

				return NULL;

			}

			$TemplateBody = fread($f,filesize(ABS_PATH.DS.MAIL_TEMPLATE_PATH."/".$Template));

			fclose($f);	



			$HTMLBody=$TemplateBody;



			if(is_array($Custom)){

				foreach($Custom as $Find=>$ReplaceWith){

					$TemplateBody = str_replace("{".$Find."}",$ReplaceWith,$TemplateBody);

				}

			}



			foreach($GeneralKywords as $Find=>$ReplaceWith){

				$TemplateBody = str_replace("{".$Find."}",$ReplaceWith,$TemplateBody);

			}



			return $TemplateBody;

		}

		function ParseMailText($Text, $Custom=""){	

			$GeneralKywords = array();

			$GeneralKywords["SERVER_ROOT"]=SERVER_ROOT;



			$TemplateBody = $Text;



			$HTMLBody=$TemplateBody;



			if(is_array($Custom)){

				foreach($Custom as $Find=>$ReplaceWith){

					$TemplateBody = str_replace("{".$Find."}",$ReplaceWith,$TemplateBody);

				}

			}



			foreach($GeneralKywords as $Find=>$ReplaceWith){

				$TemplateBody = str_replace("{".$Find."}",$ReplaceWith,$TemplateBody);

			}



			return $TemplateBody;

		}

		function random_color(){

			mt_srand((double)microtime()*1000000);

			$c = '';

			while(strlen($c)<6){

				$c .= sprintf("%02X", mt_rand(0, 255));

			}

			return $c;

		}

		function remove_uploaded_file(){

			@unlink($this->uploaded_file);

		}	

		function set_message($message, $type){

			$_SESSION['msg'] = $message;

			$_SESSION['type'] = $type;

		}

		function set_tz_by_name($name) { 

			$abbrarray = timezone_abbreviations_list(); 

			foreach ($abbrarray as $abbr) {  

				foreach ($abbr as $city) { 

					if (stripos($city['timezone_id'], $name)!==false){	

						date_default_timezone_set($city['timezone_id']); 

						return true; 

					} 

				} 

			} 

			date_default_timezone_set("UTC"); 

			return false; 

		} 

		function set_tz_by_offset($offset) { 

			$offset = $offset*60*60; 

			$abbrarray = timezone_abbreviations_list(); 

			foreach ($abbrarray as $abbr) {  

				foreach ($abbr as $city) { 

					if ($city['offset'] == $offset) {

						date_default_timezone_set($city['timezone_id']); 

						return true; 

					} 

				} 

			} 

			date_default_timezone_set("UTC"); 

			return false; 

		} 

		function store_uploaded_file($uploaddir, $uploadfilename="", $width=0, $height=0,$watermark="", $chmod=""){

			if($uploadfilename==""){

				$uploadfilename = basename($local_file);

			}

			$tmpname = $this->uploaded_file;

			if($width!=0 && $height!=0){

				$is = $this->app->load_module("imageresizer");

				if($is == NULL){

					trigger_error("Could not load Image Resizer Module", E_USER_ERROR);

				}

				$is->changeBaseDir(ABS_PATH.DS."temp");				

				$is->loadImage(basename($this->uploaded_file));

				$is->resizeImage($width, $height);

				$is->addWatermark($watermark);

				$is->keepAspectRatio=true;

				$is->dontMakeBigger=true;

				$tmpname = dirname($this->uploaded_file).DS."resized_".basename($this->uploaded_file);

				$is->saveToFile($tmpname);

			}

			if(USE_FTP){

				$ftp = $this->app->load_module("ftp");

				if($ftp != NULL){

					$ftp = new $ftp_class();

				}else{

					trigger_error("Could not load ftp module", E_USER_ERROR);

				}			

				if(!$ftp->SetServer(FTP_HOST)) {

					$ftp->quit();

					return false;

				}

				if (!$ftp->connect()) {

					$ftp->quit();

					return false;

				}

				if (!$ftp->login(FTP_USERNAME, FTP_PASSWORD)) {

					$ftp->quit();

					return false;

				}

				$ftp->SetType(FTP_AUTOASCII);

				$ftp->Passive(FALSE);



				$ftp->chdir(FTP_WWWDIR.$uploaddir);

				$ftp->pwd();



				if(FALSE === $ftp->put($tmpname, $uploadfilename)){

					if($this->uploaded_file!=$tmpname){

						@unlink($tmpname);

					}

					$ftp->quit();

					return false;

				}else{

					if($this->uploaded_file!=$tmpname){

						@unlink($tmpname);

					}

					if(is_numeric($chmod)){

						$ftp->chmod($uploadfilename, $chmod);

					}

					$ftp->quit();

					return true;

				}

			}else{
				/*======= code update by Reema on 31-12-2020 
					check for file mime type. If file extension and its mime type do not match then go to else block and remove file from temp folder
					========= */

					include(ABS_PATH.'/resources/Mimey/mime.types.php');
					$mimes=$mapping['extensions'];
					$mime_extension=$mimes[mime_content_type($tmpname)];

					$file_info = $this->app->utility->get_file_info($tmpname);

					if(($width!=0 && $height!=0) || in_array(strtolower($file_info->extension),$mime_extension)){
						if(copy($tmpname, ABS_PATH.DS.$uploaddir.DS.$uploadfilename)){

							if($this->uploaded_file!=$tmpname){

								@unlink($tmpname);

							}

							return true;

						}else{

							if($this->uploaded_file!=$tmpname){

								@unlink($tmpname);

							}

							return false;

						}
					}else{
						@unlink($tmpname);
						return false;
					}
				}

			}



		function store_uploaded_file_ktt($uploaddir, $uploadfilename="", $width=0, $height=0,$watermark="", $chmod=""){

			if($uploadfilename==""){

				$uploadfilename = basename($local_file);

			}

			$tmpname = $this->uploaded_file;

			if($width!=0 && $height!=0){

				$is = $this->app->load_module("imageresizer");

				if($is == NULL){

					trigger_error("Could not load Image Resizer Module", E_USER_ERROR);

				}

				$is->changeBaseDir(ABS_PATH.DS."temp");				

				$is->loadImage(basename($this->uploaded_file));

				$is->resizeImage($width, $height);

				$is->addWatermark($watermark);

				$is->keepAspectRatio=true;

				$is->dontMakeBigger=true;

				$tmpname = dirname($this->uploaded_file).DS."resized_".basename($this->uploaded_file);

				$is->saveToFile($tmpname);

			}

			/* Remote File Name and Path */

			$remote_file = FTP_WWWDIR_KTT.$uploaddir.$uploadfilename;

			/* File and path to send to remote FTP server */

			$local_file = $tmpname;



			if(copy($local_file,$remote_file)){

				if($this->uploaded_file!=$tmpname){

					@unlink($tmpname);

				}

				return true;

			}else{

				if($this->uploaded_file!=$tmpname){

					@unlink($tmpname);

				}

				return false;

			}

		}



		function time_diff_in_seconds($firstTime, $lastTime){

			$firstTime=strtotime($firstTime);

			$lastTime=strtotime($lastTime);		

			$timeDiff=$lastTime-$firstTime;

			return $timeDiff;

		}

		function TimeDiff($bigTime,$smallTime){



			list($h1,$m1,$s1)=split(":",$bigTime);

			list($h2,$m2,$s2)=split(":",$smallTime);

			

			$second1=$s1+($h1*3600)+($m1*60);//converting it into seconds

			$second2=$s2+($h2*3600)+($m2*60);

			

			

			if ($second1==$second2)

			{

				$resultTime="00:00:00";

				return $resultTime;

				exit();

			}

			

			

			

			if ($second1<$second2) // 

			{

				$second1=$second1+(24*60*60);//adding 24 hours to it.

			}

			

			

			

			$second3=$second1-$second2;

			

			//print $second3;

			if ($second3==0)

			{

				$h3=0;

			}

			else

			{

				$h3=floor($second3/3600);//find total hours

			}



			$remSecond=$second3-($h3*3600);//get remaining seconds

			if ($remSecond==0)

			{

				$m3=0;

			}

			else

			{

				$m3=floor($remSecond/60);// for finding remaining  minutes

			}



			$s3=$remSecond-(60*$m3);

			

			if($h3==0)//formating result.

			{

				$h3="00";

			}

			if($m3==0)

			{

				$m3="00";

			}

			if($s3==0)

			{

				$s3="00";

			}



			$resultTime=array($h3,$m3,$s3);

			

			

			return $resultTime;



		}

		function upload_file($file){

			$file_info = $this->get_file_info($file['name']);

			$tmpname = time()."_".mt_rand(1000, 2000).".".$file_info->extension;

			if(!move_uploaded_file($file['tmp_name'], ABS_PATH.DS."temp".DS.$tmpname)){

				return false;

			}else{

				$this->uploaded_file = ABS_PATH.DS."temp".DS.$tmpname;

				return true;

			}

		}



		function addhttp($url) {

			if ($url!='' && !preg_match("~^(?:f|ht)tps?://~i", $url)) {

				$url = "http://" . $url;

			}

			return $url;

		}



		function add_user_log($table_name,$table_id,$action,$post_data_arr=array()){

			$description='';

			$not_take_fields=array("id","act","save_x","save_y","apply_x","apply_y","OPTI_MATRIX_SOLUTIONS_REF_VIEW","password","photo","crop_photo");

			if(VIR_DIR==""){

				$admin_user_id="";

			}else{

				$admin_user_id=$_SESSION['admin_user_id'];

			}

			$ip_address=$_SERVER['REMOTE_ADDR'];

			$description.=strtoupper($action)."ED data in ".$table_name." \n";

			foreach($post_data_arr as $key=>$val){

				if(!in_array($key,$not_take_fields) && $val!='' && stripos($key, 'password') === false){

					if(is_array($val)){

						foreach($val as $sub_key=>$sub_val){

							if(!in_array($key,$not_take_fields) && $sub_val!=''){

								$description.=$key." = ".$sub_val.",\n";

							}

						}

					}else{

						$description.=$key." = ".$val.",\n";

					}

				}

			}

		//insert into user_log table

			$add_log=array();

			$add_log['admin_user_id']=$admin_user_id;

			$add_log['ip_address']=$ip_address;

			$add_log['table_name']=$table_name;

			$add_log['table_id']=$table_id;

			$add_log['action']=ucwords($action);

			$add_log['description']=$description;

			$add_log['inserted_from']=$_SERVER['REQUEST_URI'].(VIR_DIR=='scripts/ajax/'?"<br>".$_SERVER['HTTP_REFERER']:'');

			$obj_model_user_log=$this->app->load_model("user_logs");

			$obj_model_user_log->map_fields($add_log);

			$obj_model_user_log->execute("INSERT");

		}



		function save_change_logs($table_name,$table_id,$change_reason,$post_data_arr=array()){

			$description='';

			$not_take_fields=array("id","act","save_x","save_y","apply_x","apply_y","OPTI_MATRIX_SOLUTIONS_REF_VIEW","password","photo","crop_photo");

			if(VIR_DIR==""){

				$admin_user_id="";

			}else{

				$admin_user_id=$_SESSION['admin_user_id'];

			}

			foreach($post_data_arr as $key=>$val){

				if(!in_array($key,$not_take_fields) && $val!=''){

					if(is_array($val)){

						foreach($val as $sub_key=>$sub_val){

							if(!in_array($key,$not_take_fields) && $sub_val!=''){

								$description.=$key." = ".$sub_val.",\n";

							}

						}

					}else{

						$description.=$key." = ".$val.",\n";

					}

				}

			}

		//insert into user_log table

			$add_log=array();

			$add_log['admin_user_id']=$admin_user_id;

			$add_log['table_name']=$table_name;

			$add_log['table_id']=$table_id;

			$add_log['change_reason']=strtoupper($change_reason);

			$add_log['change_detail']=$description;

			$obj_model_change_logs=$this->app->load_model("change_logs");

			$obj_model_change_logs->map_fields($add_log);

			$obj_model_change_logs->execute("INSERT");

		}



		function get_string_time($datetime){

			$datetime=strtotime($datetime);

		/*$past_time = $datetime;

		$cur_time = time();

	    $diff_time = $cur_time - $past_time;

	    if($diff_time < 60){

			return $diff_time." seconds ago";

	    }else if($diff_time >= 60 && $diff_time < 3600){

			return floor(($diff_time/60))." minutes ago";

	    }else if($diff_time >= 3600 && $diff_time < 86400){

			return floor(($diff_time/3600))." hours ago";

	    }else if($diff_time >= 86400 && $diff_time < 172800){

			return "Yesterday";

	    }else{

			 return floor(($diff_time/86400))." days ago";

			}*/



			if (!defined('SECOND')) define("SECOND",   1);

			if (!defined('MINUTE')) define("MINUTE", 60 * SECOND);

			if (!defined('HOUR')) define("HOUR",60 * MINUTE);

			if (!defined('DAY')) define("DAY", 24 * HOUR);

			if (!defined('MONTH')) define("MONTH",30 * DAY);

 		//return strtotime(date("2013-01-01"));

		//$delta = strtotime(date('Y-m-d H:i:s')) - $time;

			$past_time = $datetime;

			$cur_time = time();

			$delta = $cur_time - $past_time;

        // $delta = date('Y-m-d H:i:s')- $time;

			if ($delta < 1 * MINUTE){

				return $delta == 1 ? "1 second ago" : $delta . " seconds ago";

			}

			if ($delta < 2 * MINUTE){

				return "a minute ago";

			}

			if ($delta < 45 * MINUTE)

			{

				return floor($delta / MINUTE) . " minutes ago";

			}

			if ($delta < 90 * MINUTE)

			{

				return "an hour ago";

			}

			if ($delta < 24 * HOUR)

			{

				return floor($delta / HOUR) . " hours ago";

			}

			if ($delta < 48 * HOUR)

			{

				return "yesterday";

			}

			if ($delta < 30 * DAY)

			{

				return floor($delta / DAY) . " days ago";

			}

			if ($delta < 12 * MONTH)

			{

				$months = floor($delta / DAY / 30);

				return $months <= 1 ? "1 month ago" : $months . " months ago";

			}

			else

			{

				$years = floor($delta / DAY / 365);

				return $years <= 1 ? "1 year ago" : $years . " years ago";

			}



		}



		function format_mobile_number($number){

			if (substr($number, 0, 3)=='+91' || substr($number, 0, 3)=='+97') {

				$number = substr($number, 3, strlen($number)-3);

			}

			else if (substr($number,0,2)=='91' && strlen($number)>10) {

				$number = substr($number, 2, strlen($number)-2);

			}

			else if (substr($number,0,1)=='0') {

				$number = substr($number, 1, strlen($number)-1);

			}

			$number=preg_replace('/\D/', '', $number);

			if(strlen($number)>10){

				$number=substr($number,0,10);	

			}

			return $number;

		}



		function format_vehicle_number($number){

		$number=preg_replace("/[^A-Z0-9]+/i", " ", $number);			// remove special characters

		$number=wordwrap($number,2, " ",true);							// add space after each 2 letters

		$number=preg_replace('/(?<=\d)\s+(?=\d)/', '', $number);		// remove space between digits

		return $number;

	}

	

	//****************** functions for SMS API [START] **************************//

	

	function send_sms($to,$message,$language="en"){				

		/*$obj_setting=$this->app->load_model('setting_master');

		$rs_setting=$obj_setting->execute("SELECT",false,"","status='Active'","","");

		$setting=array();

		for($i=0; $i<count($rs_setting); $i++){

			$setting[$rs_setting[$i]['object_name']]=$rs_setting[$i]['object_value'];

		}

		if($setting['SMS_MOBILE_NUMBER']!=""){

			$mobile = $setting['SMS_MOBILE_NUMBER'];	

		}

		if($setting['SMS_PASSWORD']!=""){

			$pass = $setting['SMS_PASSWORD'];	

		}

		if($setting['SMS_SENDER_ID']!=""){

			$sender_id = $setting['SMS_SENDER_ID'];	

		}

		if($setting['SMS_URL']!=""){

			$baseurl = $setting['SMS_URL']."SmsStatuswithId.aspx";	

		}*/

		// Logic for SEND SMS

		$mobile = SMS_MOBILE_NUMBER;

		$pass = SMS_PASSWORD;

		$sender_id = SMS_SENDER_ID;

		$baseurl = SMS_URL."SmsStatuswithId.aspx";

		$text = urlencode($message);
		$text = str_replace("0D%","",$text);
		$to = $to;



		// auth call

		if($language!="en"){

			$url = "$baseurl?mobile=$mobile&pass=$pass&senderid=$sender_id&to=$to&msg=$text&msgtype=uc";

		}

		else{

			$url = "$baseurl?mobile=$mobile&pass=$pass&senderid=$sender_id&to=$to&msg=$text";

		}

		//echo $url;exit;

		

		// do auth call

		$ret = file($url);

		// explode our response. return string is on first line of the data returned

		//print_r($ret);exit;

		$sess = explode(":",$ret[0]);

		

		/*if ($sess[0] == "1 SMS Sent. Message Id") {

			return trim($sess[1]);

		} else {

			return "send message failed";

		}*/

		if(strpos($sess[0],"SMS Sent. Message Id")!==false){			

			return trim($sess[1]);			

		} else {

			return "send message failed";

		}

	}



	function get_balance(){

		/*$obj_setting=$this->app->load_model('setting_master');

		$rs_setting=$obj_setting->execute("SELECT",false,"","status='Active'","","");

		$setting=array();

		for($i=0; $i<count($rs_setting); $i++){

			$setting[$rs_setting[$i]['object_name']]=$rs_setting[$i]['object_value'];

		}

		if($setting['SMS_MOBILE_NUMBER']!=""){

			$mobile = $setting['SMS_MOBILE_NUMBER'];	

		}

		if($setting['SMS_PASSWORD']!=""){

			$pass = $setting['SMS_PASSWORD'];	

		}

		if($setting['SMS_SENDER_ID']!=""){

			$sender_id = $setting['SMS_SENDER_ID'];	

		}

		if($setting['SMS_URL']!=""){

			$baseurl = $setting['SMS_URL']."getBalance.aspx";	

		}*/

		

		$mobile = SMS_MOBILE_NUMBER;

		$pass = SMS_PASSWORD;

		$sender_id = SMS_SENDER_ID;

		$baseurl =SMS_URL."getBalance.aspx";



		// auth call

		$url = "$baseurl?mobile=$mobile&pass=$pass";



		// do auth call

		$ret = file($url);

		return $ret[0];

	}

	

	function delivery_report($return_id){

		/*$obj_setting=$this->app->load_model('setting_master');

		$rs_setting=$obj_setting->execute("SELECT",false,"","status='Active'","","");

		$setting=array();

		for($i=0; $i<count($rs_setting); $i++){

			$setting[$rs_setting[$i]['object_name']]=$rs_setting[$i]['object_value'];

		}

		if($setting['SMS_MOBILE_NUMBER']!=""){

			$mobile = $setting['SMS_MOBILE_NUMBER'];	

		}

		if($setting['SMS_PASSWORD']!=""){

			$pass = $setting['SMS_PASSWORD'];	

		}

		if($setting['SMS_SENDER_ID']!=""){

			$sender_id = $setting['SMS_SENDER_ID'];	

		}

		if($setting['SMS_URL']!=""){

			$baseurl = $setting['SMS_URL']."MsgStatus.aspx";	

		}*/

		if($return_id=="send message failed"){

			return "send message failed";

		}else{

			$mobile = SMS_MOBILE_NUMBER;

			$pass = SMS_PASSWORD;

			$sender_id = SMS_SENDER_ID;

			$baseurl =SMS_URL."MsgStatus.aspx";

			$return_id = $return_id;

		 	//echo "<pre>";

			// auth call

			$url = "$baseurl?mobile=$mobile&pass=$pass&msgtempid=$return_id";

			//echo $url;

			// do auth call

			/*$ret = file($url);

			print_r($ret);*/

			$ret=file_get_contents($url);

			//echo $ret;

			//$final_report = str_replace(' ', '',strip_tags(preg_replace('/[0-9]+/', '', $ret[16])));

			//echo $final_report;exit;

			//return $final_report;

			//echo $ret[16];

			$arr=json_decode($ret,true);

			$status=array();

			foreach($arr as $res){

				$status[]=$res['Status'];

			}

			if(count($status)>0){

				return implode(", ",$status);

			}else{

				return "";	

			}

		}

	}

	//****************** functions for SMS API [END] **************************//
	function sms_send_by_template($number,$subject,$var=array()){
		// fetch from sms_template
		$obj_model_sms_template = $this->app->load_model("sms_template");
		$rs_template =$obj_model_sms_template->execute("SELECT",false,"","subject='".$subject."' AND status='Active'");
		if(count($rs_template)>0){
			$message=$rs_template[0]['message'];
			if(count($var)>0){
				array_walk($var, create_function('&$value', '$value = ($value!=""?$value:".");'));	
				$sms = strtr($message, $var);
			}else{
				$sms=$message;
			}

			if(SMS_VER!='TEST'){
				$msg_id = $this->send_sms($number,$sms);
			}
			if($msg_id!='' || SMS_VER=='TEST'){
				//message log
				$obj_model_msg_log = $this->app->load_model("message_log");
				$add_msg_field = array();
				$add_msg_field['message'] = $sms;
				$add_msg_field['to_number'] = $number;
				$add_msg_field['msg_id']=$msg_id;
				$add_msg_field['date'] = date('Y-m-d');
				$add_msg_field['time'] = date("H:i:s");
				$add_msg_field['called_from'] = $subject."<br>".$_SERVER['REQUEST_URI'].(VIR_DIR=='scripts/ajax/'?"<br>".$_SERVER['HTTP_REFERER']:'');
				$obj_model_msg_log->map_fields($add_msg_field);
				$obj_model_msg_log->execute("INSERT");
				if($msg_id!="send message failed"){
					return true;
				}else{
					return false;
				}
			}
		}
	}

	

	//****************** functions for SMS API [END] **************************//

	//****************** functions for WHATSAPP API [START] **************************//
	function send_whatsapp_message($to,$message,$image="",$pdf="",$caption=""){
		// echo "in";exit;

		// if(in_array('WhatsApp',$this->app->updates_on)){

			// echo "in";exit;

			$username = urlencode(WA_USERNAME);

			$pass = WA_PASSWORD;

			$baseurl = WA_LINK;

			$to = $to;

			$text = urlencode($message);
			$filePathUrl = urlencode($image);
			$ftpFilePathUrl = "";

			// auth call
			$url = "$baseurl?username=$username&password=$pass&receiverMobileNo=$to&message=$text&filePathUrl=$filePathUrl&ftpFilePathUrl=$ftpFilePathUrl&caption=$caption";
			// echo $url;exit;
			// do auth call

			$ret = file($url);

			// echo "<pre>";print_r($ret);exit;

			// explode our response. return string is on first line of the data returned

			$sess = explode(":",$ret[0]);

			//echo "<pre>";print_r($sess);exit;

			if(strpos($sess[2],"success")!==false){

			$see_msg = explode(",",$sess[4]);

			return trim($see_msg[0]);

			} else {

			return "send message failed";

			}
		//}

	}

	//****************** functions for WHATSAPP API [END] **************************//

	

	function no_to_words($no){   

		//echo $no." > ";//exit;

		$words = array('0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five','6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten','11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fouteen','15' => 'fifteen','16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty','30' => 'thirty','40' => 'fourty','50' => 'fifty','60' => 'sixty','70' => 'seventy','80' => 'eighty','90' => 'ninty','100' => 'hundred','1000' => 'thousand','100000' => 'lakh','10000000' => 'crore');

		if($no == 0){

			return ' ';

		}else{           

			$novalue='';

			$highno=$no;

			$remainno=0;

			$value=100;

			$value1=1000;        

			while($no>=100)    {

				if(($value <= $no) &&($no  < $value1))    {

					$novalue=$words[$value];

					$highno = (int)($no/$value);

					$remainno = $no % $value;

					break;

				}

				$value= $value1;

				$value1 = $value * 100;

			}        

			if(array_key_exists($highno,$words)){

				return $words[$highno]." ".$novalue." ".$this->no_to_words($remainno);

			}else{ 

				$unit=$highno%10;

				$ten =(int)($highno/10)*10;             

				return $words[$ten]." ".$words[$unit]." ".$novalue." ".$this->no_to_words($remainno);

			}

		}

	}

	

	function convert_number_to_words($number){

		//echo $number;//exit;

		$str=$this->no_to_words($number);

		return strtoupper(" ".$str." Rupees Only ");

	}

	

	function convertToIndianCurrency($number) {		

		$decimal = round($number - ($no = floor($number)), 2) * 100;

		$hundred = null;

		$digits_length = strlen($no);

		$decimal_length = strlen($decimal);

		$i = 0;

		$str = array();	

		$str_decimal = array();	

		$words = array(

			0 => '',

			1 => 'One',

			2 => 'Two',

			3 => 'Three',

			4 => 'Four',

			5 => 'Five',

			6 => 'Six',

			7 => 'Seven',

			8 => 'Eight',

			9 => 'Nine',

			10 => 'Ten',

			11 => 'Eleven',

			12 => 'Twelve',

			13 => 'Thirteen',

			14 => 'Fourteen',

			15 => 'Fifteen',

			16 => 'Sixteen',

			17 => 'Seventeen',

			18 => 'Eighteen',

			19 => 'Nineteen',

			20 => 'Twenty',

			30 => 'Thirty',

			40 => 'Forty',

			50 => 'Fifty',

			60 => 'Sixty',

			70 => 'Seventy',

			80 => 'Eighty',

			90 => 'Ninety');

		$digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');

		while( $i < $digits_length ) {

			$divider = ($i == 2) ? 10 : 100;

			$number = floor($no % $divider);

			$no = floor($no / $divider);

			$i += $divider == 10 ? 1 : 2;

			if ($number) {

				$plural = (($counter = count($str)) && $number > 9) ? 's' : null;

				$hundred = ($counter == 1 && $str[0]) ? ' and ' : null;

				$str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;

			} else $str[] = null;

		}

		$Rupees = implode('', array_reverse($str));		

		//$paise = ($decimal) ? "And Paise " . ($words[$decimal - $decimal%10]) ." " .($words[$decimal%10])  : '';

		$j=0;

		while( $j < $decimal_length ) {

			$divider = ($j == 2) ? 10 : 100;

			$number = floor($decimal % $divider);

			$decimal = floor($decimal / $divider);

			$j += $divider == 10 ? 1 : 2;

			if ($number) {

				$plural = (($counter = count($str_decimal)) && $number > 9) ? 's' : null;

				$hundred = ($counter == 1 && $str_decimal[0]) ? ' and ' : null;

				$str_decimal [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;

			} else $str_decimal[] = null;

		}		

		$paise = ($str_decimal[0]!='') ? "And Paise " . implode('', array_reverse($str_decimal)) : '';

		return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise .' Only' ;

	}

	

	function get_start_end_year_range($date){

		$year=date("Y",strtotime($date));		

		$cur_month=date("m",strtotime($date));			

		if($cur_month<4){

			$start=date("Y-m-d",mktime(0,0,0,4,1,$year-1));

			$start_year=$year-1;

		}else{

			$start=date("Y-m-d",mktime(0,0,0,4,1,$year));

			$start_year=$year;

		}

		$end=date("Y-m-d",strtotime($start." +1 year"));

		$end=date("Y-m-d",strtotime($end." -1 day"));

		$data=array();

		$data['start']=$start;

		$data['end']=$end;

		$data['start_year']=$start_year;

		return $data;

	}



	function fetch_nested_list($table="",$field="",$parent_field="",$branch_id=0,$parent_id = 0, $spacing = '', $list_array = '') {



		if (!is_array($list_array))

			$list_array = array();

		if($table==""){

			echo "<h2>Function Error </h2><hr><br>.You must provide the name of Table";

		}

		else if($field==""){

			echo "<h2>Function Error </h2><hr><br>.You must provide the name of Field";

		}

		else if($parent_field==""){

			echo "<h2>Function Error </h2><hr><br>.You must provide the name of Parent Field";

		}

		else{

			$obj_model_table=$this->app->load_model($table);

			$rs_table=$obj_model_table->execute("SELECT",false,"",$parent_field."=".$parent_id." and status='Active'".($branch_id>0?" AND (branch_id=0 OR branch_id=".$branch_id.")":""),$field." ASC");		



			if(count($rs_table) > 0) {

				for($i=0; $i<count($rs_table); $i++){

					$list_array[$rs_table[$i]['id']] = array("id" => $rs_table[$i]['id'], $field => $spacing . $rs_table[$i][$field],"parent_id"=>$parent_id);

					$list_array = $this->fetch_nested_list($table,$field,$parent_field,$branch_id,$rs_table[$i]['id'], $spacing . '-->&nbsp;', $list_array);

				}

			}

			return $list_array;

		}

	}



	function get_year_range_for_table($table_name,$field_name,$branch_id=0,$SQL=''){

		$obj_model_table=$this->app->load_model($table_name);

		if($SQL!=''){

			$rs_min_max=$obj_model_table->execute("SELECT",false,$SQL);			

		}else{

			//get minimum & maximum date

			$sql_min_max="SELECT MIN(".$field_name.") as min_date, MAX(".$field_name.") as max_date FROM ".$table_name." WHERE status='Active'".($branch_id!='' && $branch_id>0?" AND branch_id=".$branch_id:"");			

			$rs_min_max=$obj_model_table->execute("SELECT",false,$sql_min_max);

		}

		if($rs_min_max[0]['min_date']!='' && $rs_min_max[0]['max_date']!=''){

			$min_year=date("Y",strtotime($rs_min_max[0]['min_date']));

			$min_month=date("m",strtotime($rs_min_max[0]['min_date']));			

			if($min_month<4){

				$min_year=$min_year-1;

			}

			//$rs_max[0]['max_date']="2017-04-08";	

			$max_year=date("Y",strtotime($rs_min_max[0]['max_date']));

			$max_month=date("m",strtotime($rs_min_max[0]['max_date']));

			if($max_month<4){

				$max_year=$max_year-1;

			}	

		}

		$year_range=array();	

		if($min_year!='' && $max_year!=''){	

			do{

				$year=$max_year;			

				$start_year=$year;

				$end_year=$year+1;

				$year_range[$start_year."-".$end_year]=$start_year."-".$end_year;

				$max_year--;

			}while($max_year>=$min_year);

		}

		$year_range['ALL']="-All Year-";

		return $year_range;

	}



 	function add_remove_value_string($string,$add_value='',$remove_value=''){

 		$string_arr=explode(",",$string);

 		if($add_value!=''){

 			if(!in_array($add_value,$string_arr)){

 				if (($key = array_search($add_value, $string_arr)) === false) {

 					$string_arr[]=$add_value;

 				}

 			}

 		}

 		if($remove_value!=''){

 			if(in_array($remove_value,$string_arr)){	

 				if (($key = array_search($remove_value, $string_arr)) !== false) {

 					unset($string_arr[$key]);

 				}

 			}

 		}

 		return implode(',', $string_arr);

 	}



 	function get_dropdown($table_name,$key,$value,$first_option="",$where_condition="",$order_by="",$group_by="",$select_all=""){

 		$where_sql = ($where_condition!=""?" AND ".$where_condition:"");

 		



 		$obj_model_table = $this->app->load_model($table_name);

 		$rs_table = $obj_model_table->execute("SELECT",false,"","status='Active'".$where_sql,$order_by,$group_by);

 		$dropdown_arr = array();

 		if($first_option!=""){

 			$dropdown_arr[($select_all!=""?'ALL':'')] = $first_option;

 		}

 		for($x=0;$x<count($rs_table);$x++){

 			if($rs_table[$x][$value]!=""){

 				$dropdown_arr[$rs_table[$x][$key]] = ucfirst($rs_table[$x][$value]);

 			}

 		}

 		return $dropdown_arr;

 	}



	/****************** APP NOTIFICATION FUNCTIONS :: START (by Reema) ********************/

	function check_update_device_id($account_id,$acc_group_id,$device_id,$device_type=''){

		if($account_id>0 && $acc_group_id>0){

			$obj_model_user_device=$this->app->load_model("user_devices");

			$rs_user_device=$obj_model_user_device->execute("SELECT",false,"","status='Active' AND account_id=".$account_id." AND acc_group_id=".$acc_group_id,"id ASC");

			$devices=array_column($rs_user_device, "device_id");

			if(!in_array($device_id, $devices)){

				// insert new device

				$add_device=array();

				$add_device['account_id']=$account_id;

				$add_device['acc_group_id']=$acc_group_id;

				$add_device['device_id']=$device_id;

				$add_device['device_type']=$device_type;

				$obj_model_user_device=$this->app->load_model("user_devices");

				$obj_model_user_device->map_fields($add_device);

				$inserted_id=$obj_model_user_device->execute("INSERT");

				if($inserted_id>0){

					//add user log for INSERT

					$this->app->utility->add_user_log("user_devices",$inserted_id,"INSERT",$add_device);

					// check if devices are more than 5 then remove first device record

					if(count($rs_user_device)>=5){

						$obj_model_user_device=$this->app->load_model("user_devices",$rs_user_device[0]['id']);

						if($obj_model_user_device->execute("DELETE",false,"","status='Active' AND id=".$rs_user_device[0]['id'])){

							//add user log for DELETE

							$this->app->utility->add_user_log("user_devices",$rs_user_device[0]['id'],"DELETE");

						}

					}

				}

			}

		}

	}



	function android_notification($deviceToken,$message,$title="",$image=""){

		$gcm = new GCM();

		$registeration_ids = array();

		$registeration_ids[] = $deviceToken;

		$message_list = array("message" => $message,"title" => $title,"image" => $image);

		$result = $gcm->send_notification($registeration_ids, $message_list);

	   // print_r($result);exit;

	}



	function send_notification_to_driver($title, $desc, $photo='', $notification_type, $data_id, $table_ids){

		$obj_notification = $this->app->load_module("FCMNotification");

		/*$photo = "http://cdn.arstechnica.net/wp-content/uploads/2016/02/5718897981_10faa45ac3_b-640x624.jpg";

		$desc = "Go to our website to view the Deal";

		$title = "10% Discount";

		$notification_type = "Test";*/

		$obj_drivers = $this->app->load_model("vehicle_location");

		$drivers = $obj_drivers->execute("SELECT",false,"","status='Active' AND device_id!='' AND current_status='Available'".($table_ids!=''?" AND sp_driver_id IN (".$table_ids.")":""),"");

		//echo $obj_drivers->sql;echo "1<br>";

		$total = count($drivers);

		$page = 1;

		$rec_limit = 800;

		$tot_page = ceil($total/$rec_limit);

		for($j=0;$j<$tot_page;$j++){				

			$start=($page-1)*$rec_limit;

			$obj_drivers = $this->app->load_model("vehicle_location");

			$rs_driver = $obj_drivers->execute("SELECT",false,"","status='Active' AND device_id!='' AND current_status='Available'".($table_ids!=''?" AND sp_driver_id IN (".$table_ids.")":"")," id LIMIT ".$start.", ".$rec_limit);

			//echo $obj_drivers->sql;echo "2<br>";				

			for($i=0;$i<count($rs_driver);$i++){			

				/////$device_id = "cAR_sbjM0kU:APA91bH5XR81Bs3zLZ-HqPHRIUDPRM9iZmnQ4faIeX1WHnLL_vsBttJAF_EV8723sWXqzT_FAHSZV0c7ZPtBfBjVZOxoVg7nJ4ahqnDzLAa5zfMIwOGfDATjL45ai_xxf-bMBCcOs8To";//binny

				/////$device_id = "fjODnRSb7Jg:APA91bGbOXZrYuuTvwdZqLzlHmLUc54QXWGRENFUDZ61gszu0wCU1mJ-R6p2SGayTzjtR6HD-UDOa7RSJUsv4obw8BGoTWWetw8vmiKllzDyRkTLXrTCd3LH-BC0oWwbNTSY8YykYBo6";//dhaval

				//$device_id = "d4UjSyRgG2Y:APA91bGPNzkqzke4ezsZD82WMqSPCxveiqBr6n7KL5arTEtLYdD5v38rJsKAsC9ZS2OyKC0FzWd4eR9a1VbBmJ5tEI9qIwJT3yyhnfeoH9zRTANq-FVZtTd48JtZRpnMu62p7wlYrs-W";//harshal

				//$device_id = "cKAsT07gwbI:APA91bFe37PyiWfzqT95EoEHey1fubGLAapcyhjCkWB5pC3ShxqyWOiNEii36ugHIDSNxlegn-3uFUbASpu5sTGYp1fdsT6L-oagawd1cq4fsBxDlyZAkeVQtwgD6pCz1fgRk3MFWduQ";

				$device_id = $rs_driver[$i]['device_id'];

				//echo $device_id."<br>";

				if($device_id != "" ){

					if($rs_driver[$i]['device_type']=='ios' && strlen($device_id) > 30){

						$result = $this->iphone_operator_notification($device_id,$title,$desc,$photo,$notification_type,$data_id);

						$obj_model_insert_notification = $this->app->load_model('push_notification');

						$add_field = array();

						$add_field['title'] = $title;

						$add_field['description'] = $desc;

						$add_field['photo'] = $photo;

						$add_field['notification_type'] = $notification_type;

						$add_field['data_id'] = $data_id;

						$add_field['created'] = date("Y-m-d H:i:s");

						$add_field['table_name'] = "driver";

						$add_field['table_id'] = $rs_driver[$i]['sp_driver_id'];

						$add_field['success'] = ($result>0?"1":"0");

						$add_field['failure'] = ($result>0?"0":"1");

						$obj_model_insert_notification->map_fields($add_field);

						$obj_model_insert_notification->execute("INSERT");

					}else{

						//echo "harshal";

						$result = $obj_notification->sendPushNotification($device_id,$title,$desc,$photo,$notification_type,$data_id);

						$json = json_decode($result,true);

						//print_r($result);exit;

						$obj_model_insert_notification = $this->app->load_model('push_notification');

						$add_field = array();

						$add_field['title'] = $title;

						$add_field['description'] = $desc;

						$add_field['photo'] = $photo;

						$add_field['notification_type'] = $notification_type;

						$add_field['data_id'] = $data_id;

						$add_field['created'] = date("Y-m-d H:i:s");

						$add_field['table_name'] = "driver";

						$add_field['table_id'] = $rs_driver[$i]['sp_driver_id'];

						$add_field['success'] = $json['success'];

						$add_field['failure'] = $json['failure'];

						$obj_model_insert_notification->map_fields($add_field);

						$obj_model_insert_notification->execute("INSERT");

					}

				}

			}

		}

		return $json;

	}

	

	function iphone_operator_notification($deviceToken,$title,$message,$photo='',$not_type,$data_id,$app_type="free_live"){

		if($app_type == "free_dev" || $app_type == "paid_dev"){

			$pem_file = ABS_PATH."/modules/iOSNotification/dev/GujaratBhatiyaMahajan-dev.pem"; // VALUES OR APP_TYPE CAN BE ... free_live, paid_live, free_dev, paid_dev

		}else{

			$pem_file = ABS_PATH."/modules/iOSNotification/live/SamstBhatiyaMahajan.pem";

		}

		$passphrase = 'optiinfo@123';

		$ctx = stream_context_create();

		stream_context_set_option($ctx, 'ssl', 'local_cert', $pem_file);

		stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

		if($app_type == "free_dev" || $app_type == "paid_dev"){

			// If send notification for DEVELOPMENT purpose use below...

			$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

		}else{

			// If send notification for LIVE(means uploaded app on app store) purpose use below...

			$fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

		}

		$body['aps'] = array('alert' => $message, 'sound' => "Default");

		$body['title'] = $title;

		$body['photo']=$photo;

		$body['notification_type'] = $not_type; // If 1 = news, 99 = other

		$body['id']=$data_id;

		//echo $err."<br><br>".$errstr;

		$payload = json_encode($body);

		//echo $payload."<br><br>";//exit;

		$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

		$result = fwrite($fp, $msg, strlen($msg));

		fclose($fp);

		//echo $result;exit;

		return $result;

	}

	/*********************** APP NOTIFICATION FUNCTIONS :: END *************************/

	

	/********** FOR DYNAMIC MENU :: ACTIVE MENU (by Reema) ********/

	function get_active_menu(){

		$main_menu='';

		$sub_menu='';

		if(!in_array($this->app->getCurrentView(),array("default","change_password","change_profile","access_denied","generate_files","mould_addedit","mould_list","error"))){

			if(isset($_SESSION['admin_user_group_id'])){

				$obj_model_menu_file=$this->app->load_model("menu_file_label");

				$obj_model_menu_file->join_table("menu_detail","left",array("id","menu_master_id"),array("id"=>"menu_file_label_id"));

				$obj_model_menu_file->set_fields_to_get(array("id","parameters"));

				$rs_menu_file=$obj_model_menu_file->execute("SELECT",false,"","file_name='".$this->app->getCurrentView()."' AND menu_detail.status='Active'","parameters DESC");

				//print_r($rs_menu_file);

				foreach ($rs_menu_file as $menu_file) {

					//print_r($menu_file);

					if($menu_file['parameters']!=''){

						parse_str($menu_file['parameters'],$parameters);

						//print_r($parameters);

						$url_params=$this->app->getGetVars();

						unset($url_params['view']);

						//print_r($url_params);

						$match=array_intersect($url_params,$parameters);

						//print_r($match);

						if($match==$parameters){

							$main_menu=$menu_file['menu_detail_menu_master_id'];

							$sub_menu=$menu_file['menu_detail_id'];

						}

					}

					//echo $main_menu." : ".$sub_menu;

					if($main_menu=='' && $sub_menu=='' && $menu_file['parameters']==''){

						$main_menu=$menu_file['menu_detail_menu_master_id'];

						$sub_menu=$menu_file['menu_detail_id'];

					}

				}

			}

		}

		return array("main_menu"=>$main_menu,"sub_menu"=>$sub_menu);

	}



	/********** FOR GET NEXT AUTO-INCREMENT VALUE (by Reema) ********/

	function get_next_autoincrement($table_name,$prefix='',$length=0){

		if($table_name==""){

			trigger_error("<h2>Function Error </h2><hr><br>You must provide the name of Table", E_USER_ERROR);

		}else{

			$SQL = "SHOW TABLE STATUS LIKE '".$table_name."'";

			//echo $SQL;

			$result_query = mysqli_query($this->app->objDB->getConnection(),$SQL);

			$rs_next_number = mysqli_fetch_array($result_query);

			//echo '<pre>';print_r($rs_next_number);

			$next_id = $rs_next_number['Auto_increment'];

			if($length!='' && $length>0){

				$next_number = str_pad($next_id, intval($length), "0", STR_PAD_LEFT);

			}else{

				$next_number=$next_id;

			}

			$final_number=$prefix.$next_number;

			//echo $final_number;exit;

			return $final_number;

		}

	}

	public function send_notification_to_all($title, $desc, $photo,$id,$notification_type,$user_ids=""){
		//echo $title.":".$desc.":".$photo.":".$id.":".$notification_type;exit;
		// print_r($notification_type);exit();
		
		/*$photo = "http://cdn.arstechnica.net/wp-content/uploads/2016/02/5718897981_10faa45ac3_b-640x624.jpg";
		$desc = "Go to our website to view the Deal";
		$title = "10% Discount";
		$notification_type = "Test";*/
		$success_cnt=0;
		$obj_model_app_user = $this->app->load_model("app_user");
		$obj_model_app_user->set_fields_to_get(array("id","device_id"));
		$rs_app_user = $obj_model_app_user->execute("SELECT",false,"","status='Active' AND device_id!=''".($user_ids!=''?" AND id IN (".implode(",", $user_ids).")":""));			
		/*echo "<pre>";
		print_r($rs_app_user);exit();*/
		$num = count($rs_app_user);
		//$num = 1;
		for($i=0;$i<$num;$i++){
			/////$device_id = "cAR_sbjM0kU:APA91bH5XR81Bs3zLZ-HqPHRIUDPRM9iZmnQ4faIeX1WHnLL_vsBttJAF_EV8723sWXqzT_FAHSZV0c7ZPtBfBjVZOxoVg7nJ4ahqnDzLAa5zfMIwOGfDATjL45ai_xxf-bMBCcOs8To";//binny
			/////$device_id = "fjODnRSb7Jg:APA91bGbOXZrYuuTvwdZqLzlHmLUc54QXWGRENFUDZ61gszu0wCU1mJ-R6p2SGayTzjtR6HD-UDOa7RSJUsv4obw8BGoTWWetw8vmiKllzDyRkTLXrTCd3LH-BC0oWwbNTSY8YykYBo6";//dhaval
		    //$device_id = "d4UjSyRgG2Y:APA91bGPNzkqzke4ezsZD82WMqSPCxveiqBr6n7KL5arTEtLYdD5v38rJsKAsC9ZS2OyKC0FzWd4eR9a1VbBmJ5tEI9qIwJT3yyhnfeoH9zRTANq-FVZtTd48JtZRpnMu62p7wlYrs-W";//harshal
			$device_id = $rs_app_user[$i]['device_id'];
			//print_r($device_id);
			if($device_id != ""){
				//echo "vidhi";
				$obj_notification = $this->app->load_module("FCMNotification");
				$result = $obj_notification->sendPushNotification($device_id,$title,$desc,$photo,$notification_type,$id);
				//print_r($i." : ".$result);
				$json = json_decode($result,true);
				//print_r($json);
			}else{
				$json['success'] = 0;
				$json['failure'] = 0;
			}
			//exit;
			$success_cnt+=$json['success'];
			$obj_model_insert_not_view = $this->app->load_model('push_notification_view');
			$add_field_view = array();
			$add_field_view['push_notification_id'] = $id;
			$add_field_view['app_user_id'] = $rs_app_user[$i]['id'];
			$add_field_view['success'] = $json['success'];
			$add_field_view['failure'] = $json['failure'];
			$obj_model_insert_not_view->map_fields($add_field_view);
			$inserted_id = $obj_model_insert_not_view->execute("INSERT");
			if($inserted_id>0){
				//add user log for INSERT
				$this->app->utility->add_user_log("push_notification_view",$inserted_id,"INSERT",$add_field_view);
			}
			
		}
		return $success_cnt;			
	}
	/********** FOR GET NEXT AUTOMATED VALUE (by Reema) ********/
	function get_next_autonumber($table_name,$field_name,$start_num,$prefix='',$where_condition=''){
		if($table_name==""){
			trigger_error("<h2>Function Error </h2><hr><br>You must provide the name of Table", E_USER_ERROR);
		}else{
			$no_length=intval(strlen($start_num));
			$prefix_length=intval(strlen($prefix))+1;
			$obj_model_table = $this->app->load_model($table_name);
			$sql="SELECT MAX(CAST(SUBSTRING(".$field_name.", ".$prefix_length.",length(".$field_name.")) AS UNSIGNED)) as max_number FROM ".$table_name." WHERE 1".($where_condition!=''?" AND ":"").$where_condition;
			$rs_max_no = $obj_model_table->execute("SELECT",false,$sql);
			// echo "<pre>"; print_r($rs_max_no);exit();
			if(count($rs_max_no) >0){	
				if($rs_max_no[0]['max_number']=="" || $rs_max_no[0]['max_number']==NULL){
					$next_number = $start_num;
				}else{
					$next_number = $rs_max_no[0]['max_number']+1;	
				}
			}
			$final_next_num=str_pad($next_number, $no_length, "0", STR_PAD_LEFT);
			$final_number=$prefix.$final_next_num;
			return $final_number;
		}
	}

	function get_order_payment_status($order_no){
		$working_key = 'C7B0A9386C7CC392E3F03EF755FE193B'; //Shared by CCAVENUES
		$access_code = 'AVTO11IG44AQ11OTQA';

		$merchant_json_data =array('order_no' => $order_no);
		    // print_r($merchant_json_data);

		$merchant_data = json_encode($merchant_json_data);
		$encrypted_data = $this->encrypt($merchant_data, $working_key);
		$final_data = 'enc_request='.$encrypted_data.'&access_code='.$access_code.'&command=orderStatusTracker&request_type=JSON&response_type=JSON';
		$ch = curl_init();
		// curl_setopt($ch, CURLOPT_URL, "https://apitest.ccavenue.com/apis/servlet/DoWebTrans");
		curl_setopt($ch, CURLOPT_URL, "https://api.ccavenue.com/apis/servlet/DoWebTrans");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER,'Content-Type: application/json') ;
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $final_data);
		// Get server response ...
		$result = curl_exec($ch);
		curl_close($ch);
		$status = '';
		$information = explode('&', $result);

		$dataSize = sizeof($information);
		for ($i = 0; $i < $dataSize; $i++) {
	    $info_value = explode('=', $information[$i]);
	    if ($info_value[0] == 'enc_response') {
				$status = $this->decrypt(trim($info_value[1]), $working_key);
	    }
		}

		// echo 'Status revert is: ' . $status.'<pre>';
		 // $obj = json_decode($status);
		 // print_r($obj);exit();
		 return $status;
	}
	function encrypt($plainText,$key)
	{
		$key = $this->hextobin(md5($key));
		$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
		$openMode = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
		$encryptedText = bin2hex($openMode);
		return $encryptedText;
	}
	function decrypt($encryptedText,$key)
	{
		$key = $this->hextobin(md5($key));
		$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
		$encryptedText = $this->hextobin($encryptedText);
		$decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
		return $decryptedText;
	}
	function hextobin($hexString) 
 	{ 
  	$length = strlen($hexString); 
  	$binString="";   
  	$count=0; 
  	while($count<$length) 
  	{       
	    $subString =substr($hexString,$count,2);           
	    $packedString = pack("H*",$subString); 
	    if ($count==0)
	    {
			$binString=$packedString;
	    } 
      	    
	    else 
	    {
			$binString.=$packedString;
	    } 
      	    
	    $count+=2; 
  	} 
    return $binString; 
  }



	function mail_send_by_template($template,$type,$email,$customer_id,$code=""){
  	$flag="";
		if($email!=''){
			$store_logo='';
			$store_logo='<img src="'.SERVER_ROOT.STORE_LOGO.'" alt="'.STORE_NAME.'" style="float:left;margin:0 10px;" height="70" />';
			/*}else if(file_exists("images/logo.png")) {
				$store_logo='<img src="'.SERVER_ROOT.'/images/logo.png" alt="'.$this->app->storeinfo['name'].'" style="float:left;margin:0 10px;" height="70" />';
			} */
			$store_name=STORE_NAME;
			$otp_code=$code;
			$store_email=STORE_EMAIL;
			$store_contact=STORE_PHONE;
			if($customer_id>0){
				$obj_model_customer=$this->app->load_model("app_user",$customer_id);
				$rs_customer=$obj_model_customer->execute("SELECT",false,"","status='Active' AND id=".$customer_id);
				$otp_code=$rs_customer[0]['otp'];
			}
			$data=array('store_logo'=>$store_logo,'store_name'=>$store_name,'store_email'=>$store_email,'store_contact'=>$store_contact);
			switch ($type) {
				case 'send_otp_by_email':
					$subject="Your verification code - ".$store_name;
					$data['mail_title']="Verify Your Account";
					$data['mail_subject_line']="To verify your account, please use the following One Time Password (OTP):";
					$data['mail_footer']="Thank you for visiting our website! We hope to see you again soon.";
					$data['send_data']=$otp_code;
					break;
				case 'forgot_password':
					$subject="Forgot Password - ".$store_name;
					$data['mail_title']="Forgot Your Password?";
					$data['mail_subject_line']="<b>Hello,</b><br>You are receiving this email because we received a forgot password request for your account. To get your password, please use the following One Time Password (OTP):";
					$data['mail_footer']="If you did not request this, you can just ignore this email.";
					$data['send_data']=$rs_customer[0]['otp_code'];
					break;
				case 'account_detail':
					$subject="Account Details - ".$store_name;
					$data['mail_title']="Your Requested Account Details";
					$data['mail_subject_line']="Hello ".$rs_customer[0]['name'].", Your ".$store_name." Account Password :";
					$data['mail_footer']="For Security Purpose, Please Change Your Password Immediately after login.";
					$data['send_data']=$this->app->utility->my_decrypt($rs_customer[0]['password']);
					break;
				default:
					# code...
					break;
			}
			$mail_body = $this->app->utility->ParseMailTemplate($template, $data);
			if($mail_body==NULL){
				$this->app->display_error(NULL, "Could not parse the mail template");
			}
			echo $mail_body;exit;
			if(EMAIL_VER=='TEST'){
				$flag=true;
			}else{
				$obj_mailer = $this->app->load_module("mailer\sender");
				$obj_mailer->create();
				$obj_mailer->subject($subject);
				$obj_mailer->add_to($email);
				$obj_mailer->mailfrom(FROM_EMAIL,FROM_NAME);
				$obj_mailer->htmlbody($mail_body);	
				$flag = $obj_mailer->send();
			}
		}
		return $flag;
	}
	
	function check_record_used_delete($table_name,$id,$var_check_exist){

 		$is_exist="No";
 		$table_list=array();
 		$table_list=$this->app->get_check_exist($var_check_exist);
 		// echo "<pre>";print_r($table_list);exit();

 		
 		// if ($table_name=='service_master') {
 		// 	$table_list = array( 
			//     array("service_documents","service_master_id"), 
			//     array("commission_master","service_master_id"), 
			// );
 		// }
 		// if ($table_name=='document_type') {
 		// 	$table_list = array( 
			//     array("app_user_details","document_type_id"), 
			// );
 		// }
 		for($i=0;$i<count($table_list);$i++){
			$table_name_list=$table_list[$i][0];
			$table_field=$table_list[$i][1];
			$sql_query="";
			if (($table_name_list=='qc_test_order' && $table_name=='delivery_challan') || ($table_name_list=='qc_test_order' && $table_name=='sample_entry')) {
				$sql_query=" AND test_result!='Pending'";
			}

			$obj_model_table_name_list = $this->app->load_model($table_name_list);
			$rs_table_name_list = $obj_model_table_name_list->execute("SELECT",false,"","status = 'Active' AND (".$table_field."=".$id." OR FIND_IN_SET(".$id.",".$table_field.")) ".$sql_query);
			// echo "<pre>";print_r($obj_model_table_name_list->sql);exit();
			if (count($rs_table_name_list)>0) {
				$is_exist="Yes";
				break;
			}
		}
 		return $is_exist;		
 	}

 	function check_record_exist_recycle($table_name,$id,$field_name){
 		$is_exist="No";
 		$obj_model_table_name = $this->app->load_model($table_name);
		$rs_table_name = $obj_model_table_name->execute("SELECT",false,"","id=".$id);
		if (count($rs_table_name)>0) {
			$obj_model_table_name = $this->app->load_model($table_name);
			$rs_table_name1 = $obj_model_table_name->execute("SELECT",false,"","status='Active' AND ".$field_name."!='' AND ".$field_name."='".$rs_table_name[0][$field_name]."'");
			if (count($rs_table_name1)>0) {
				$is_exist="Yes";
			}
		}
 		return $is_exist;		
 	}
}

?>