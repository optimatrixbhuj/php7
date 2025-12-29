<?php
class _admin_user_list extends controller{
	function init(){
	}
	function onload(){
		$type = $this->app->getGetVar('type');
		$this->assign("type",$type);
		//fetch branch
		$branch=$this->app->utility->get_dropdown("branch","id","name","All Branch","","name","","ALL");
		$this->assign("branch",$branch);
		if($this->app->getGetVar('destroy')==1){
			unset($_SESSION[$type.'admin_user_search']);
			$this->app->redirect("index.php?view=admin_user_list".($type!=''?"&type=".$type:""));
		}
		$this->assign("manager_for", "admin user");
		if($this->app->getCurrentAction()==""){
			$this->load_data();
		}
	}
	function search(){
		$type = $this->app->getGetVar('type');
		$this->assign("type",$type);
		unset($_SESSION[$type.'admin_user_search']);
		$this->load_data();
	}
	function load_data(){
		// print_r($_SESSION);
		if($this->app->getGetVar('recycle')== true){
			$recycle = $this->app->getGetVar('recycle');
			$this->assign("recycle", true);
		}else{
			$recycle = false;
			$this->assign("recycle", false);
		}
		$type = $this->app->getGetVar('type');
		$this->assign("type",$type);
		/* Search By */
		if($this->app->getPostVar("group_name")!=""){
			$_SESSION[$type.'admin_user_search']['group_name'] = $this->app->getPostVar("group_name");
		}
		if($this->app->getPostVar("full_name")!=""){
			$_SESSION[$type.'admin_user_search']['full_name'] = $this->app->getPostVar("full_name");
		}
		if($this->app->getPostVar("username")!=""){
			$_SESSION[$type.'admin_user_search']['username'] = $this->app->getPostVar("username");
		}
		if($this->app->getPostVar("email")!=""){
			$_SESSION[$type.'admin_user_search']['email'] = $this->app->getPostVar("email");
		}
		if($this->app->getPostVar("mobile")!=""){
			$_SESSION[$type.'admin_user_search']['mobile'] = $this->app->getPostVar("mobile");
		}
		if($this->app->getPostVar("branch_id")!=""){
			$_SESSION[$type.'admin_user_search']['branch_id'] = $this->app->getPostVar("branch_id");
		}
		$sql_where_clause = "";
		if(isset($_SESSION[$type.'admin_user_search']['group_name'])){
			$group_name = $_SESSION[$type.'admin_user_search']['group_name'];
			$sql_where_clause .=($sql_where_clause!=''?" AND ":"")."group_name like '%".$group_name."%'";
			$this->assign("field_group_name", $_SESSION[$type.'admin_user_search']['group_name']);
		}
		if(isset($_SESSION[$type.'admin_user_search']['full_name'])){
			$full_name = $_SESSION[$type.'admin_user_search']['full_name'];
			$sql_where_clause .=($sql_where_clause!=''?" AND ":"")."full_name like '%".$full_name."%'";
			$this->assign("field_full_name", $_SESSION[$type.'admin_user_search']['full_name']);
		}
		if(isset($_SESSION[$type.'admin_user_search']['username'])){
			$username = $_SESSION[$type.'admin_user_search']['username'];
			$sql_where_clause .=($sql_where_clause!=''?" AND ":"")."username like '%".$username."%'";
			$this->assign("field_username", $_SESSION[$type.'admin_user_search']['username']);
		}
		if(isset($_SESSION[$type.'admin_user_search']['email'])){
			$email = $_SESSION[$type.'admin_user_search']['email'];
			$sql_where_clause .=($sql_where_clause!=''?" AND ":"")."email like '%".$email."%'";
			$this->assign("field_email", $_SESSION[$type.'admin_user_search']['email']);
		}
		if(isset($_SESSION[$type.'admin_user_search']['mobile'])){
			$mobile = $_SESSION[$type.'admin_user_search']['mobile'];
			$sql_where_clause .=($sql_where_clause!=''?" AND ":"")."mobile like '%".$mobile."%'";
			$this->assign("field_mobile", $_SESSION[$type.'admin_user_search']['mobile']);
		}
		if(isset($_SESSION[$type.'admin_user_search']['branch_id'])){
			$branch_id = $_SESSION[$type.'admin_user_search']['branch_id'];
			if($branch_id!='ALL'){
				$sql_where_clause .=($sql_where_clause!=''?" AND ":""). "admin_user.branch_id =".$branch_id;
			}
			$this->assign("field_branch_id", $_SESSION[$type.'admin_user_search']['branch_id']);
		}
		/* Search For Order By */
		if($this->app->getRequestVar("order_by_field_name") != "" && $this->app->getRequestVar("order_by") != "")
		{
			$order_by = $this->app->getRequestVar("order_by");
			$_SESSION['order_by_field_name'] = $this->app->getRequestVar("order_by_field_name");
			$_SESSION['order_by'] = $this->app->getRequestVar("order_by");
			$_SESSION['view'] = $this->app->getRequestVar("view");
			$this->assign("order_by",($order_by=='' || $order_by=='DESC'?'ASC':'DESC'));
		}elseif(isset($_SESSION['order_by_field_name']) && $_SESSION['order_by_field_name'] != "" && isset($_SESSION['order_by']) && $_SESSION['order_by'] != "" && isset($_SESSION['view']) && $_SESSION['view'] != $this->app->getRequestVar("view")){
			$_SESSION['order_by_field_name'] = "admin_user.id";
			$_SESSION['order_by'] = "DESC";
			$_SESSION['view'] = $this->app->getRequestVar("view");
		}else{
			$_SESSION['order_by_field_name'] = "admin_user.id";
			$_SESSION['order_by'] = "DESC";
			$_SESSION['view'] = $this->app->getRequestVar("view");
		}
		$order_by_field_name = $_SESSION['order_by_field_name'];
		$order_by = $_SESSION['order_by'];
		$sql_order_by_clause = "";
		if($order_by != ""){
			$sql_order_by_clause = $order_by_field_name. " " .$order_by;
		}
		/*if($type!=='' && $type=='application_user'){
			$sql_where_clause .=($sql_where_clause!=''?" AND ":""). "admin_user_group_id=3";		// show application_user
		}else{
			$sql_where_clause .=($sql_where_clause!=''?" AND ":""). "admin_user_group_id!=3";		// show other than application_user
		}*/
		if($this->app->getGetVar('recycle')== true){
			$sql_where_clause=($sql_where_clause==''?"admin_user.status='Inactive'":"admin_user.status='Inactive' and ".$sql_where_clause);
		}else{
			$sql_where_clause=($sql_where_clause==''?"admin_user.status='Active'":"admin_user.status='Active' and ".$sql_where_clause);
		}
		if($_SESSION['admin_user_group_id']!='1'){
			$sql_where_clause.=($sql_where_clause!=''?" AND ":"")." admin_user.branch_id=".$_SESSION['branch_id'];
		}
		$obj_model_admin_user = $this->app->load_model("admin_user");
		$obj_model_admin_user->join_table('admin_user_group','left',array('group_name'),array('admin_user_group_id'=>'id'));
		$obj_model_admin_user->join_table('branch','left',array('name'),array('branch_id'=>'id'));
		$obj_model_admin_user->set_paging_settings($_SESSION['records'],5);
		// $obj_model_admin_user->set_fields_to_get(array("name","email","mobile"));
		$rs = $obj_model_admin_user->execute("SELECT", true, "", $sql_where_clause, $sql_order_by_clause);
		// echo "<pre>";print_r($rs);
		// echo $obj_model_admin_user->sql;
		$data = $this->app->compile();
		$this->load_parser($data);
		$this->parser->assign("PAGING", $obj_model_admin_user->show_paging());
		$this->parser->assign("PAGE_NO", $this->app->getCurrentPage());
		$this->parser->assign("SHOW_HIDE", (count($rs)>0)?"none":"");
		$i = 1;
		$Sr = $obj_model_admin_user->get_serial_start();
		foreach($rs as $admin_user){
			$this->parser->assign("admin_user", $admin_user);
			$this->parser->assign("ROW_CLASS", ($i%2)==0?"even":"odd");
			$this->parser->assign("STATUS", ($admin_user['is_verified'])=="Active"?"active.png":"inactive.png");
			if($admin_user['photo']!=""){
				$this->parser->assign("photo",'<img src="../uploads/admin_user/'.$admin_user['photo'].'" width="50" height="50"/>');
			}else{
				$this->parser->assign("photo",'');
			}
			$this->parser->assign("option_show_hide", ($admin_user['admin_user_group_id']==1)?"none":"");
			$this->parser->assign("SHOW_HIDE_DELETE", ($admin_user['id']==1)?"none":"");
			$this->parser->assign("COUNT", $i);
			$this->parser->assign("SERIAL", $Sr);
			$this->parser->parse('main.admin_user_table.admin_user_row');
			$i++;
			$Sr++;
		}
		$this->parser->parse('main.admin_user_table');
		$this->parser->parse('main');
		$this->update_ouput($this->parser->text('main'));
		$this->unload_parser();
	}
	function multi_delete(){
		// echo "<pre>";print_r($this->app->getPostVars());exit;
		$type = $this->app->getGetVar('type');
		$this->assign("type",$type);
		$del_id = $this->app->getPostVar('del');
		$is_delete = array();
		$edit_field=array();
		$edit_field['status']='Inactive';
		$del_status = 'True';
		for($i=0;$i<count($del_id);$i++){
			$is_exist=$this->app->utility->check_record_used_delete("admin_user",$del_id[$i],"admin_user");
			if ($is_exist=='Yes') {
				$del_status = 'False';
			}else{
				$obj_model_admin_user = $this->app->load_model("admin_user");
				$obj_model_admin_user->map_fields($edit_field);
				$is_delete[] = $obj_model_admin_user->execute("UPDATE", false, "", "id=".$del_id[$i]);
				//add user log for DELETE
				$this->app->utility->add_user_log("admin_user",$del_id[$i],"DELETE");
			}
		}
		if($del_status == 'False'){
			$this->app->utility->set_message("Some Records Already in Use You Can Not Delete", "ERROR");
		}else{
			if(count($is_delete)>0){
				$this->app->utility->set_message("Records deleted successfully", "SUCCESS");
			}else{
				$this->app->utility->set_message("Problem in delete record", "ERROR");
			}
		}
		$this->app->redirect("index.php?view=admin_user_list".($type!=''?"&type=".$type:""));
	}
	function single_delete(){
		$type = $this->app->getGetVar('type');
		$this->assign("type",$type);
		$obj_model_admin_user = $this->app->load_model("admin_user",  $this->app->getPostVar('id'));
		$rs_user=$obj_model_admin_user->execute("SELECT",false,"","id=".$this->app->getPostVar('id'));
		// check for super admin
		if($rs_user[0]['admin_user_group_id']==1){
			$obj_model_super_admin = $this->app->load_model("admin_user");
			$super_admin=$obj_model_super_admin->execute("SELECT",false,"","admin_user_group_id=1 AND status='Active'");
			if(count($super_admin)<=1){
				$this->app->utility->set_message("There Must be one Super Admin. You can not delete it.", "ERROR");
				$this->app->redirect("index.php?pg_no=".$this->app->getPostVar('page_no')."&view=admin_user_list".($type!=''?"&type=".$type:""));
			}
		}
		$is_exist=$this->app->utility->check_record_used_delete("admin_user",$this->app->getPostVar('id'),"admin_user");
		if ($is_exist=='Yes') {
			$this->app->utility->set_message("This Record is Already in Use. You Can Not Delete", "ERROR");
		}else{
			$obj_model_admin_user = $this->app->load_model("admin_user",  $this->app->getPostVar('id'));
			$edit_field=array();
			$edit_field['status']='Inactive';
			$obj_model_admin_user->map_fields($edit_field);
			if($obj_model_admin_user->execute("UPDATE")){
				//add user log for DELETE
				$this->app->utility->add_user_log("admin_user",$this->app->getPostVar('id'),"DELETE");
				$this->app->utility->set_message("Record deleted successfully", "SUCCESS");
			}else{
				$this->app->utility->set_message("Problem in delete record", "ERROR");
			}
		}
		$this->app->redirect("index.php?pg_no=".$this->app->getPostVar('page_no')."&view=admin_user_list".($type!=''?"&type=".$type:""));
	}
	function recycle(){
		$type = $this->app->getGetVar('type');
		$this->assign("type",$type);
		// check if other user exists
		$is_exist=$this->app->utility->check_record_exist_recycle("admin_user",$this->app->getPostVar('id'),'mobile');
		if ($is_exist=='Yes') {
			$this->app->utility->set_message("You can not restore this record. mobile already exist", "ERROR");
		}else{
			$is_exist=$this->app->utility->check_record_exist_recycle("admin_user",$this->app->getPostVar('id'),'email');
			if ($is_exist=='Yes') {
				$this->app->utility->set_message("You can not restore this record. e mail already exist", "ERROR");
			}else{
				$is_exist=$this->app->utility->check_record_exist_recycle("admin_user",$this->app->getPostVar('id'),'username');
				if ($is_exist=='Yes') {
					$this->app->utility->set_message("You can not restore this record. username already exist", "ERROR");
				}else{
					$obj_model_admin_user = $this->app->load_model("admin_user",  $this->app->getPostVar('id'));
					$edit_field=array();
					$edit_field['status']='Active';
					$obj_model_admin_user->map_fields($edit_field);
					if($obj_model_admin_user->execute("UPDATE")){
				//add user log for RESTORE
						$this->app->utility->add_user_log("admin_user",$this->app->getPostVar('id'),"RESTORE");
						$this->app->utility->set_message("Record restored successfully", "SUCCESS");
					}else{
						$this->app->utility->set_message("Problem in restore record", "ERROR");
					}
				}
			}
		}
			$this->app->redirect("index.php?pg_no=".$this->app->getPostVar('page_no')."&view=admin_user_list".($type!=''?"&type=".$type:""));
		}
	}
	?>