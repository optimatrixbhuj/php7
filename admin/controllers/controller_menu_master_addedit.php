<?php
class _menu_master_addedit extends controller{
	
	function init(){
	}
	
	function onload(){
		$this->assign("id", $this->app->getGetVar('id'));
		// files
		$files_arr=array();
		$files_arr[""]="Blank (Parent Menu Item)";
		$sub_menu=array();
		$sub_menu[""]="Select Page Label";
		$obj_model_menu_file = $this->app->load_model("menu_file_label");
		$rs_menu_file = $obj_model_menu_file->execute("SELECT",false,"","status='Active'","file_label ASC");		
		foreach($rs_menu_file as $menu_file){
			$file_link=$menu_file['file_name'].($menu_file['parameters']!=''?"&".$menu_file['parameters']:"");
			$files_arr[$file_link]=$menu_file['file_label'];
			$sub_menu[$menu_file['id']]=$menu_file['file_label'];
		}
		/*$path=ABS_PATH.DS.VIR_DIR.DS.'views';
		if ($handle = opendir($path)) { 
		   foreach(scandir($path) as $entry){
				if ($entry != "." && $entry != ".." && $entry!='index.html') {
					$file=substr($entry,5,-4);
					if($file != "access_denied" &&  $file != "default" &&  $file != "change_profile" &&  $file != "change_password" &&  $file != "forgot_password" &&  $file != "mould_addedit" &&  $file != "mould_list" &&  $file != "generate_files" ){
						$files_arr[$file]=$file;
					}
				}
		   }
		}*/
		$this->app->assign("files",$files_arr);
		$this->app->assign("sub_menu",$sub_menu);
				
		if($this->app->getGetVar('id')!=""){
			if($this->app->getGetVar('record') == "copy"){
				$this->assign("to_do", "Copy");
				$this->assign("id", "");
			}else{
				$this->assign("to_do", "Edit");
			}
			$this->load_data();
		}else{
			$this->assign("to_do", "Add");
		}
		$this->assign("manager_for", "menu master");
	}
	
	function load_data(){
		$obj_model_menu_master = $this->app->load_model("menu_master", $this->app->getGetVar('id'));
		$rs_menu_master = $obj_model_menu_master->execute("SELECT",false,"","","","");
		if(count($rs_menu_master)>0){
			$obj_model_menu_detail = $this->app->load_model("menu_detail");
			$rs_menu_detail=$obj_model_menu_detail->execute("SELECT",false,"","menu_master_id=".$rs_menu_master[0]['id']." AND status='Active'","sort_order ASC");
			$this->assign("menu_detail",$rs_menu_detail);
			$this->app->assign_form_data("frm_menu_master_addedit", $rs_menu_master[0]);
		}else{
			$this->app->redirect("index.php?view=menu_master_list");
		}
	}
	
	function addedit_data(){		
		if($this->app->getPostVar('id')!=""){
			//echo "<pre>";print_r($this->app->getPostVars());exit;
			$obj_model_menu_master = $this->app->load_model("menu_master", $this->app->getPostVar('id'));
			$rs_menu = $obj_model_menu_master->execute("SELECT",false,"","id=".$this->app->getPostVar('id'));
			
			$obj_model_menu_master = $this->app->load_model("menu_master", $this->app->getPostVar('id'));
			$edit_field = array();
			$edit_field['label']=ucwords($this->app->getPostVar("label"));
			$edit_field['sort_order']=$rs_menu[0]['sort_order'];
			$obj_model_menu_master->map_fields($edit_field);
			if($obj_model_menu_master->execute("UPDATE")>0){
				// delete from menu detail
				$obj_model_menu_detail = $this->app->load_model("menu_detail");
				$obj_model_menu_detail->execute("DELETE",false,"","menu_master_id=".$rs_menu[0]['id']." AND status='Active'");
				// insert for menu detail
				$menu_file_label_ids=$this->app->getPostVar("menu_file_label_id");
				$sort_order=$this->app->getPostVar("sort_order");
				$show_in_menu=$this->app->getPostVar("show_in_menu");
				foreach($menu_file_label_ids as $i=>$menu_file_label_id){
					if($menu_file_label_id>0){
						$add_detail=array();
						$add_detail['menu_master_id']=$rs_menu[0]['id'];
						$add_detail['menu_file_label_id']=$menu_file_label_id;
						$add_detail['sort_order']=$sort_order[$i];
						$add_detail['show_in_menu']=$show_in_menu[$i];
						$add_detail['admin_user_id']=$_SESSION['admin_user_id'];	
						$obj_model_menu_detail=$this->app->load_model("menu_detail");
						$obj_model_menu_detail->map_fields($add_detail);
						$obj_model_menu_detail->execute("INSERT");
					}
				}
				//add user log for UPDATE
				$this->app->utility->add_user_log("menu_master",$this->app->getPostVar('id'),"UPDATE",array_merge($this->app->getPostVars(),$edit_field));
				$this->app->utility->set_message("Record updated successfully", "SUCCESS");
				if($this->app->getPostVar('apply_x') != ""){
					$this->app->redirect("index.php?view=menu_master_addedit&id=".$this->app->getPostVar('id'));
				}else{
					$this->app->redirect("index.php?view=menu_master_list&pg_no=".$this->app->getGetVar('page_no'));
				}
			}else{
				$this->app->utility->set_message("Ooops... There was a problem in update records", "ERROR");
				$this->app->redirect("index.php?view=menu_master_list&pg_no=".$this->app->getGetVar('page_no'));
			}
		}else{
			//get max sort order			
			$obj_model_max_order = $this->app->load_model("menu_master");
			$sql="SELECT max(sort_order) AS max_order from menu_master where status='Active'";			
			$rs_sort_order=$obj_model_max_order->execute("SELECT",false,$sql);
			$final_sort_ord=$rs_sort_order[0]['max_order']+1;
			
			$obj_model_menu_master = $this->app->load_model("menu_master");
			$add_field = array();
			$add_field['admin_user_id']=$_SESSION['admin_user_id'];	
			$add_field['label']=ucwords($this->app->getPostVar("label"));			
			$add_field['sort_order']=$final_sort_ord;
			$obj_model_menu_master->map_fields($add_field);
			$inserted_id = $obj_model_menu_master->execute("INSERT");
			if($inserted_id>0){
				// insert for menu detail
				$menu_file_label_ids=$this->app->getPostVar("menu_file_label_id");
				$sort_order=$this->app->getPostVar("sort_order");
				$show_in_menu=$this->app->getPostVar("show_in_menu");
				foreach($menu_file_label_ids as $i=>$menu_file_label_id){
					if($menu_file_label_id>0){
						$add_detail=array();
						$add_detail['menu_master_id']=$inserted_id;
						$add_detail['menu_file_label_id']=$menu_file_label_id;
						$add_detail['sort_order']=$sort_order[$i];
						$add_detail['show_in_menu']=$show_in_menu[$i];
						$add_detail['admin_user_id']=$_SESSION['admin_user_id'];	
						$obj_model_menu_detail=$this->app->load_model("menu_detail");
						$obj_model_menu_detail->map_fields($add_detail);
						$obj_model_menu_detail->execute("INSERT");
					}
				}
				//add user log for INSERT
				$this->app->utility->add_user_log("menu_master",$inserted_id,"INSERT",array_merge($this->app->getPostVars(),$add_field));
				$this->app->utility->set_message("Record inserted successfully", "SUCCESS");
				if($this->app->getPostVar('apply_x') != ""){
					$this->app->redirect("index.php?view=menu_master_addedit&id=".$inserted_id);
				}else{
					$this->app->redirect("index.php?view=menu_master_addedit");
				}
			}else{
				$this->app->utility->set_message("Ooops... There was a problem in insert records", "ERROR");
				$this->app->redirect("index.php?view=menu_master_addedit");
			}
		}
	}		
}	
?>