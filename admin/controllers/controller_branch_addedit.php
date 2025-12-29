<?php
class _branch_addedit extends controller{
	
	function init(){
	}
	
	function onload(){
		$this->assign("id", $this->app->getGetVar('id'));

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
		$this->assign("manager_for", "branch");
	}
	
	function load_data(){
		$obj_model_branch = $this->app->load_model("branch", $this->app->getGetVar('id'));
		$rs_branch = $obj_model_branch->execute("SELECT",false,"","","","");
		if(count($rs_branch)>0){
			$this->app->assign_form_data("frm_branch_addedit", $rs_branch[0]);			
		}else{
			$this->app->redirect("index.php?view=branch_list");
		}
	}
	
	function addedit_data(){
		//echo "<pre>";print_r($this->app->getPostVars());exit();
		if($this->app->getPostVar('id')!=""){
			$obj_model_branch = $this->app->load_model("branch", $this->app->getPostVar('id'));
			$edit_field = array();
			$edit_field['name']=ucwords($this->app->getPostVar("name"));
			$obj_model_branch->map_fields($edit_field);
			if($obj_model_branch->execute("UPDATE")>0){
				//add user log for UPDATE
				$this->app->utility->add_user_log("branch",$this->app->getPostVar('id'),"UPDATE",$this->app->getPostVars());
				$this->app->utility->set_message("Record updated successfully", "SUCCESS");
				if($this->app->getPostVar('apply_x') != ""){
					$this->app->redirect("index.php?view=branch_addedit&id=".$this->app->getPostVar('id'));
				}else{
					if($this->app->getPostVar("is_child_page")!='' && $this->app->getPostVar("is_child_page")=='yes'){ ?>
						<script>
							var isInIframe = self != top;                        
							if(isInIframe) {
								parent.location.reload(true);
								parent.jQuery.fancybox.close();                        
							}
						</script>
					<?php }else{
						$this->app->redirect("index.php?view=branch_list&pg_no=".$this->app->getGetVar('page_no'));
					}
				}
			}else{
				$this->app->utility->set_message("Ooops... There was a problem in update records", "ERROR");
				$this->app->redirect("index.php?view=branch_list&pg_no=".$this->app->getGetVar('page_no'));
			}
		}else{					
			$obj_model_branch = $this->app->load_model("branch");
			$add_field = array();
			$add_field['admin_user_id']=$_SESSION['admin_user_id'];	
			$add_field['name']=ucwords($this->app->getPostVar("name"));
			$obj_model_branch->map_fields($add_field);
			$inserted_id = $obj_model_branch->execute("INSERT");
			if($inserted_id>0){
				//add user log for INSERT
				$this->app->utility->add_user_log("branch",$inserted_id,"INSERT",$this->app->getPostVars());
				$this->app->utility->set_message("Record inserted successfully", "SUCCESS");
				if($this->app->getPostVar('apply_x') != ""){
					$this->app->redirect("index.php?view=branch_addedit&id=".$inserted_id);
				}else{						
					if($this->app->getPostVar("is_child_page")!='' && $this->app->getPostVar("is_child_page")=='yes'){
						$inserted_name=ucwords($this->app->getPostVar("name"));
						?>
						<script>
							var isInIframe = self != top;                        
							if(isInIframe) {
								window.onload = function(){
									parent.$('#branch_id').selectize()[0].selectize.destroy();
									var optionExists = (parent.$('#branch_id').find('option[value="<?php echo $inserted_id; ?>"]').length > 0);
									if(!optionExists){
										parent.$('#branch_id').append($('<option>', {
											value:  "<?php echo $inserted_id; ?>" ,
											text:  "<?php echo $inserted_name; ?>"
										}));
									}
									parent.$('#branch_id').selectize({								
										openOnFocus:true,
									});
									parent.$('#branch_id')[0].selectize.setValue("<?php echo $inserted_id; ?>");
								}
								parent.jQuery.fancybox.close();                        
							}
						</script>
					<?php }else{
						$this->app->redirect("index.php?view=branch_list");
					}
				}
			}else{
				$this->app->utility->set_message("Ooops... There was a problem in insert records", "ERROR");
				$this->app->redirect("index.php?view=branch_list");
			}
		}
	}
}	
?>