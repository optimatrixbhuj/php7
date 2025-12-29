<?php 
		define("VIR_DIR","scripts/ajax/");
		require("../../core/app.php");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		$app = & app::get_instance();
		$app->initialize();
		if(!empty($_FILES['file']['name'])){
			$image_name=basename($_FILES['file']['name']);
			$image_info=$app->utility->get_file_info($image_name);
			$new_image_name=time()."_".$image_info->filename.".".$image_info->extension;
			if(strtolower($image_info->extension) == "jpg" || strtolower($image_info->extension) == "png" || strtolower($image_info->extension) == "gif" || strtolower($image_info->extension) == "jpeg"){	
			if($app->utility->upload_file($_FILES['file'])){
			  if($app->utility->store_uploaded_file($app->get_user_config('transaction_image'),$new_image_name,"","","")){
				  echo $new_image_name;
			  }
			  $app->utility->remove_uploaded_file();
		   }else{
			   echo "error ".$_FILES['file']['error']." --- ".$_FILES['file']['tmp_name'];
		   }
			}
		}
?>