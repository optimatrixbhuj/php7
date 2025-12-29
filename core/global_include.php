<?php

class global_include{

	private $settings = array();

	private $app;

	private $initialized = false;

	private $system_acl_permission = array();



	public function __construct(){

		$this->app = &app::get_instance();

	}



	public function initalize(){

		if(!$this->initialized){

			$this->initialized=true;	

			if(VIR_DIR=="admin/"){

				$this->app->setTitle(DEFAULT_TITLE." - Administrator");

				if(!defined("JS_CSS_VER")){

					define("JS_CSS_VER", "001");

				}

				if($this->app->getCurrentView()!="forgot_password" && $this->app->getCurrentView()!="reset_password" && $this->app->getCurrentView()!="error"){

					if($this->app->getCurrentView()!="default" && (empty($_SESSION["admin_user_id"]))){

						$this->app->redirect($this->app->root_relative.VIR_DIR."index.php");

					}else if($this->app->getCurrentView()=="default" && isset($_SESSION["admin_user_id"]) && $this->app->getCurrentAction()!="do_logout"){

						$this->app->redirect($this->app->root_relative.VIR_DIR."index.php?view=home");

					}else{

						if($this->app->getCurrentView()!="change_password" && isset($_SESSION['change_pwd']) && $_SESSION['change_pwd']==false){

							$this->app->addheadertag("<script>change_pwd_alert();</script>");

						}

						//print_r($_SESSION);

						if($this->app->getCurrentView()=="service_provider_vehicle"){

							if(empty($_SESSION['f9_records'])){

								$_SESSION['records'] =500;

							}

							if(empty($_SESSION['records'])){

								$_SESSION['records'] = ($this->app->getPostVar("record_per_page")==NULL?500:$this->app->getPostVar("record_per_page"));

							}else{

								if($this->app->getPostVar("record_per_page") != NULL){

									$_SESSION['records'] = $this->app->getPostVar("record_per_page");

									$_SESSION['f9_records']=$this->app->getPostVar("record_per_page");

								}else if(!empty($_SESSION['f9_records'])){

									$_SESSION['records']=$_SESSION['f9_records'];

								}

							}

							$rs  = array();

							$val = 50;

							for($i=0;$i<10;$i++){

								$rs[$val] = $val;

								$val = $val+50;

							}

							$this->app->assign("record", $rs);							

							$this->app->assign("field_record_per_page", $_SESSION['records']);

						}else if($this->app->getCurrentView()=="gurudev_birthday_list"){

							if(empty($_SESSION['f9_records'])){

								$_SESSION['records'] =500;

							}

							if(empty($_SESSION['records'])){

								$_SESSION['records'] = ($this->app->getPostVar("record_per_page")==NULL?500:$this->app->getPostVar("record_per_page"));

							}else{

								if($this->app->getPostVar("record_per_page") != NULL){

									$_SESSION['records'] = $this->app->getPostVar("record_per_page");

									$_SESSION['f9_records']=$this->app->getPostVar("record_per_page");

								}else if(!empty($_SESSION['f9_records'])){

									$_SESSION['records']=$_SESSION['f9_records'];

								}

							}

							$rs  = array();

							$val = 500;

							for($i=0;$i<5;$i++){

								$rs[$val] = $val;

								$val = $val+500;

							}

							$this->app->assign("record", $rs);							

							$this->app->assign("field_record_per_page", $_SESSION['records']);

						}else{

							if(empty($_SESSION['records']) || $_SESSION['view']=="service_provider_vehicle"){

								$_SESSION['records'] = ($this->app->getPostVar("record_per_page")==NULL?50:$this->app->getPostVar("record_per_page"));

							}else{

								if($this->app->getPostVar("record_per_page") != NULL){

									$_SESSION['records'] = $this->app->getPostVar("record_per_page");

								}

							}

							$rs  = array();

							$val = 5;

							for($i=0;$i<10;$i++){

								$rs[$val] = $val;

								$val = $val+5;

							}

							$this->app->assign("record", $rs);							

							$this->app->assign("field_record_per_page", $_SESSION['records']);

						}

					}

						//$this->app->bodyonload("");

				}

				// menu code START

				if($_SESSION['admin_user_id'] != '1' && $_SESSION['admin_user_group_id'] != ''){

					$obj_model_menu_user_access=$this->app->load_model("menu_user_access");

					$rs_menu_user_access=$obj_model_menu_user_access->execute("SELECT",false,"","status='Active' AND admin_user_group_id = ".$_SESSION['admin_user_group_id']);

				}

				if($_SESSION['admin_user_group_id'] != ''){

					if(count($rs_menu_user_access)>0){

						$main_menu = array_column($rs_menu_user_access,'menu_master_id');

						$sub_menu = array_column($rs_menu_user_access, 'menu_file_label_id');

						if (($key = array_search('0', $main_menu)) !== false) {

							unset($main_menu[$key]);

						}

						if (($key = array_search('0', $sub_menu)) !== false) {

							unset($sub_menu[$key]);

						}

					}

					$sql_main_menu_whare = "";

					$sql_sub_menu_where = "";

					if(count($main_menu)>0){

						$sql_main_menu_whare = " AND menu_master.id IN (".implode(",",$main_menu).")";

					}

					if(count($sub_menu)>0){

						$sql_sub_menu_where = " AND menu_detail.menu_file_label_id IN (".implode(",",$sub_menu).")";	

					}



					$obj_model_menu_master = $this->app->load_model("menu_master");

					$obj_model_menu_master->set_fields_to_get(array("label","icon_class","file_name","sort_order"));

					$rs_menu_master = $obj_model_menu_master->execute("SELECT",false,"","status = 'Active' ".$sql_main_menu_whare,"sort_order ASC","");	

					for($i=0;$i<count($rs_menu_master);$i++){

						$obj_model_menu_detail = $this->app->load_model("menu_detail");

						$obj_model_menu_detail->join_table("menu_file_label","left",array("file_name","file_label","parameters"),array("menu_file_label_id"=>"id"));

						$obj_model_menu_detail->set_fields_to_get(array("sort_order"));

						$rs_menu_detail = $obj_model_menu_detail->execute("SELECT",false,"","menu_detail.status = 'Active' AND show_in_menu = 'Yes' AND menu_master_id = ".$rs_menu_master[$i]['id']." ".$sql_sub_menu_where,"sort_order ASC","");

						$rs_menu_master[$i]['menu_detail'] = $rs_menu_detail;

					}

					//print_r($rs_menu_master);

					$this->app->assign("menu",$rs_menu_master);

				}

			      	// menu code END

				if(!in_array($this->app->getCurrentView(),array("default","change_password","change_profile","access_denied","generate_files","mould_addedit","mould_list","error"))){

					if(isset($_SESSION['admin_user_group_id']) && $_SESSION['admin_user_group_id']!="1"){

						$obj_model_menu_user_access=$this->app->load_model("menu_user_access");

						$obj_model_menu_user_access->join_table("menu_file_label","left",array("file_name","file_label"),array("menu_file_label_id"=>"id"));

						$rs_menu_user_access=$obj_model_menu_user_access->execute("SELECT",true,"","menu_file_label.file_name='".$this->app->getCurrentView()."' AND admin_user_group_id=".$_SESSION['admin_user_group_id']);

						if(count($rs_menu_user_access)>0){

							$this->app->assign("active_menu",$this->app->utility->get_active_menu());

						}else{

							$this->app->redirect("index.php?view=access_denied");

						}

					}else{

						$this->app->assign("active_menu",$this->app->utility->get_active_menu());

					}

				}

			}

			if(VIR_DIR == ""){

				if(!defined("JS_CSS_VER")){

					define("JS_CSS_VER", "001");

				}
				/* =================================== CODE FOR CHANGING PAGE TITLES ON ALL THE PAGES ================================ */
				$title = array(
					"default"=>"Optimatrix",
				);
				/* =================================== CODE FOR CHANGING META DESCRIPTION ON ALL THE PAGEs ================================ */
				$meta_description = array(
					"default"=>"Optimatrix PHP 7 Structure",					
				);
				/* ================ CODE FOR CHANGING META KEYWORDS ON ALL THE PAGEs =================== */
				$meta_keywords = array(
					"default"=>"",					
				);
				$cur_view = $this->app->getCurrentView();
				$this->app->setTitle($title[$cur_view]);
				$this->app->setKeywords($meta_keywords[$cur_view]);
				$this->app->setDescription($meta_description[$cur_view]);
				/* =================================================================== */				

			}			

		}		

	}					

}	



function format_indian_money($number) 

{ 

	if(strstr($number,"-")) 

	{ 

		$number = str_replace("-","",$number); 

		$negative = "-"; 

	} 

	$number=sprintf("%.2f",$number);

	$split_number = @explode(".",$number); 



	$rupee = $split_number[0]; 

	$paise = @$split_number[1]; 



	if($paise==""){

		$paise="00";

	}



	if(@strlen($rupee)>3) 

	{ 

		$hundreds = substr($rupee,strlen($rupee)-3); 

		$thousands_in_reverse = strrev(substr($rupee,0,strlen($rupee)-3)); 

		for($i=0; $i<(strlen($thousands_in_reverse)); $i=$i+2) 

		{ 

			$thousands .= $thousands_in_reverse[$i].$thousands_in_reverse[$i+1].","; 

		} 

		$thousands = strrev(trim($thousands,",")); 

		$formatted_rupee = $thousands.",".$hundreds; 



	} 

	else 

	{ 

		$formatted_rupee = $rupee; 

	} 



	if((int)$paise>0) 

	{ 

		$formatted_paise = ".".substr($paise,0,2); 

	}



	return $negative.$formatted_rupee.$formatted_paise; 

	

}



function check_if_date($date){

	if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date))

	{

		return true;

	}else{

		return false;

	}

}



function sortBySubArrayValue(&$array, $key, $dir='asc') { 

	$sorter=array();

	$rebuilt=array();



		//make sure we start at the beginning of $array

	reset($array);



		//loop through the $array and store the $key's value

	foreach($array as $ii => $value) {

		if(check_if_date($value[$key])){

			$sorter[$ii]=strtotime($value[$key]);

		}else{

			$sorter[$ii]=$value[$key];

		}

	}



		//sort the built array of key values

	if ($dir == 'asc') asort($sorter);

	if ($dir == 'desc') arsort($sorter);



		//build the returning array and add the other values associated with the key

	foreach($sorter as $ii => $value) {

		$rebuilt[]=$array[$ii];

	}



		//assign the rebuilt array to $array

	$array=$rebuilt;

}

?>