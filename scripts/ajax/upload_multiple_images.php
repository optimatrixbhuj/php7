<?php 
define("VIR_DIR","scripts/ajax/");
require("../../core/app.php");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
$app = & app::get_instance();
$app->initialize();
ini_set('max_execution_time', 800);
ini_set('memory_limit', '512M');
$original_path_config=$app->getGetVar("original_path_config");
$resize_path_config=$app->getGetVar("resize_path_config");
if($app->getGetVar('ftp')=='Yes'){
	if(!empty($_FILES['file']['name']) && $original_path_config!=''){
		$image_name=basename($_FILES['file']['name']);
		$image_info=$app->utility->get_file_info($image_name);
		$new_image_name=time()."_".$image_info->filename.".".$image_info->extension;
		if(strtolower($image_info->extension) == "jpg" || strtolower($image_info->extension) == "png" || strtolower($image_info->extension) == "gif" || strtolower($image_info->extension) == "jpeg"){	
			if($app->utility->upload_file($_FILES['file'])){
				if($app->utility->store_uploaded_file_ktt($app->get_user_config($original_path_config),$new_image_name,"","","")){
					if($resize_path_config!=''){
						$app->utility->store_uploaded_file_ktt($app->get_user_config($resize_path_config),$new_image_name,$app->get_user_config($resize_path_config."_width"),$app->get_user_config($resize_path_config."_height"));
					}
					echo $new_image_name;
				}
				$app->utility->remove_uploaded_file();
			}else{
				echo "error ".$_FILES['file']['error']." --- ".$_FILES['file']['tmp_name'];
			}
		}
	}
}else{
	if(!empty($_FILES['file']['name']) && $original_path_config!=''){
		$image_name=basename($_FILES['file']['name']);
		$image_info=$app->utility->get_file_info($image_name);
		$new_image_name=time()."_".$image_info->filename.".".$image_info->extension;
		if(strtolower($image_info->extension) == "jpg" || strtolower($image_info->extension) == "png" || strtolower($image_info->extension) == "gif" || strtolower($image_info->extension) == "jpeg"){	
			if($app->utility->upload_file($_FILES['file'])){
				if($app->utility->store_uploaded_file($app->get_user_config($original_path_config),$new_image_name,"","","")){
					if($resize_path_config!=''){
						$app->utility->store_uploaded_file($app->get_user_config($resize_path_config),$new_image_name,$app->get_user_config($resize_path_config."_width"),$app->get_user_config($resize_path_config."_height"));
					}
					echo $new_image_name;
				}
				$app->utility->remove_uploaded_file();
			}else{
				echo "error ".$_FILES['file']['error']." --- ".$_FILES['file']['tmp_name'];
			}
		}
	}
}
?>