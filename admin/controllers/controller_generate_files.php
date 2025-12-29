<?php
	class _generate_files extends controller{
		
		function init(){
			//$this->app->enable_cache("home.html");
			//$obj_model_product = $this->app->load_model("product");
			//print_r($obj_model_product);exit;  
		}
		
		function onload(){
			$this->assign("to_do", "Create");
			$this->assign("manager_for", "Generate Files");
		}
		
		function create_data(){	
			$filename = strtolower($this->app->getPostVar('filename'));
			$tablename = strtolower($this->app->getPostVar('tablename'));
			$flag = 0;	
			if ($handle = opendir('views')) {
				while (false !== ($file = readdir($handle))) {
					if ($file != "." && $file != "..") {
						if($file == "view_".$filename."_addedit.php"){
							$flag = 1;
							break;
						}
					}
				}
				closedir($handle);
			}
			if ($handle = opendir('views')) {
				while (false !== ($file = readdir($handle))) {
					if ($file != "." && $file != "..") {
						if($file == "view_".$filename."_list.php"){
							$flag = 1;
							break;
						}
					}
				}
				closedir($handle);
			}
			if ($handle = opendir('controllers')) {
				while (false !== ($file = readdir($handle))) {
					if ($file != "." && $file != "..") {
						if($file == "controller_".$filename."_addedit.php"){
							$flag = 1;
							break;
						}
					}
				}
				closedir($handle);
			}
			if ($handle = opendir('controllers')) {
				while (false !== ($file = readdir($handle))) {
					if ($file != "." && $file != "..") {
						if($file == "controller_".$filename."_list.php"){
							$flag = 1;
							break;
						}
					}
				}
				closedir($handle);
			}
			if($flag == 1){
				$this->app->utility->set_message("Ooops... There was a problem to create records as same name's controller and view already exist. ", "ERROR");	
			}else{
				$originalfile_controller_addedit = "controllers/controller_mould_addedit.php";
				$originalfile_controller_list = "controllers/controller_mould_list.php";
				$originalfile_view_addedit = "views/view_mould_addedit.php";
				$originalfile_view_list = "views/view_mould_list.php";
				$newfile_controller_addedit = str_replace("_mould_","_".$filename."_",$originalfile_controller_addedit);
				if (!copy($originalfile_controller_addedit, $newfile_controller_addedit)) {
					$flag = 2;
				}else{
					$file = file_get_contents($newfile_controller_addedit);
					$filename_added = str_replace("FILENAME",$filename,$file);
					$tablename_added = str_replace("TABLENAME",$tablename,$filename_added);
					file_put_contents($newfile_controller_addedit,$tablename_added);
				}
				$newfile_controller_list = str_replace("_mould_","_".$filename."_",$originalfile_controller_list);
				if (!copy($originalfile_controller_list, $newfile_controller_list)) {
					$flag = 2;
				}else{
					$file = file_get_contents($newfile_controller_list);
					$filename_added = str_replace("FILENAME",$filename,$file);
					$tablename_added = str_replace("TABLENAME",$tablename,$filename_added);
					file_put_contents($newfile_controller_list,$tablename_added);
				}
				$newfile_view_addedit = str_replace("_mould_","_".$filename."_",$originalfile_view_addedit);
				if (!copy($originalfile_view_addedit, $newfile_view_addedit)) {
					$flag = 2;
				}else{
					$file = file_get_contents($newfile_view_addedit);
					$filename_added = str_replace("FILENAME",$filename,$file);
					$tablename_added = str_replace("TABLENAME",$tablename,$filename_added);
					file_put_contents($newfile_view_addedit,$tablename_added);
				}
				$newfile_view_list = str_replace("_mould_","_".$filename."_",$originalfile_view_list);
				if (!copy($originalfile_view_list, $newfile_view_list)) {
					$flag = 2;
				}else{
					$file = file_get_contents($newfile_view_list);
					$filename_added = str_replace("FILENAME",$filename,$file);
					$tablename_added = str_replace("TABLENAME",$tablename,$filename_added);
					file_put_contents($newfile_view_list,$tablename_added);
				}
				if($flag == 2){
					$this->app->utility->set_message("Ooops... There was a problem to create some files, please try again. ", "ERROR");						
				}else{
					$this->app->utility->set_message("Great... Files has been created successfully. ", "SUCCESS");										
				}
			}
			//print_r($this->app->getPostVars());exit;	
		}
		
	}	
?>