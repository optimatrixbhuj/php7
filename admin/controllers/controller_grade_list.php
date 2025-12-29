<?php

class _grade_list extends controller{		

	function init(){		

	}

	

	function onload(){

		if($this->app->getGetVar('destroy')==1){

			unset($_SESSION['grade_search']);

			$this->app->redirect("index.php?view=grade_list");

		}

		$this->assign("manager_for", "grade");			

		if($this->app->getCurrentAction()==""){

			$this->load_data();

		}

	}

	

	function search(){

		unset($_SESSION['grade_search']);

		$this->load_data();

	}

	

	function load_data(){

		if($this->app->getGetVar('recycle')== true){

			$recycle = $this->app->getGetVar('recycle');

			$this->assign("recycle", true);

		}else{

			$recycle = false;

			$this->assign("recycle", false);

		}

		

		$obj_model_grade = $this->app->load_model("grade");

		$obj_model_grade->set_paging_settings($_SESSION['records'],5);	

		

		/* Search By */		

		if($this->app->getPostVar("name")!=""){

			$_SESSION['grade_search']['name'] = $this->app->getPostVar("name");

		}		

		$sql_where_clause = "";

		if(isset($_SESSION['grade_search']['name'])){

			$name = $_SESSION['grade_search']['name'];

			$sql_where_clause .=($sql_where_clause!=''?" AND ":""). "name like '%".$name."%'";

			$this->assign("field_name", $_SESSION['grade_search']['name']);

		}

		

		/* Search For Order By */

		if($this->app->getRequestVar("order_by_field_name") != "" && $this->app->getRequestVar("order_by") != "")

		{

			$order_by=$this->app->getRequestVar("order_by");

			$_SESSION['order_by_field_name'] = $this->app->getRequestVar("order_by_field_name");	

			$_SESSION['order_by'] = $order_by;

			$_SESSION['view'] = $this->app->getRequestVar("view");

			$this->assign("order_by",($order_by=='' || $order_by=='DESC'?'ASC':'DESC'));

		}elseif(isset($_SESSION['order_by_field_name']) && $_SESSION['order_by_field_name'] != "" && isset($_SESSION['order_by']) && $_SESSION['order_by'] != "" && isset($_SESSION['view']) && $_SESSION['view'] != $this->app->getRequestVar("view")){

			$_SESSION['order_by_field_name'] = "grade.id";	

			$_SESSION['order_by'] = "DESC";

			$_SESSION['view'] = $this->app->getRequestVar("view");

		}else{

			$_SESSION['order_by_field_name'] = "grade.id";	

			$_SESSION['order_by'] = "DESC";

			$_SESSION['view'] = $this->app->getRequestVar("view");

		}

		$order_by_field_name = $_SESSION['order_by_field_name'];

		$order_by = $_SESSION['order_by'];

		$sql_order_by_clause = "";

		if($order_by != ""){

			$sql_order_by_clause = $order_by_field_name. " " .$order_by;

		}

		

		if($this->app->getGetVar('recycle')== true){

			$sql_where_clause=($sql_where_clause==''?"grade.status='Inactive'":"grade.status='Inactive' and ".$sql_where_clause);

		}else{

			$sql_where_clause=($sql_where_clause==''?"grade.status='Active'":"grade.status='Active' and ".$sql_where_clause);

		}

	

		$rs = $obj_model_grade->execute("SELECT", true, "", $sql_where_clause, $sql_order_by_clause);		

		$data = $this->app->compile();

		$this->load_parser($data);

		$this->parser->assign("PAGING", $obj_model_grade->show_paging());

		$this->parser->assign("PAGE_NO", $this->app->getCurrentPage());

		$this->parser->assign("SHOW_HIDE", (count($rs)>0)?"none":"");



		$i = 1;

		$Sr = $obj_model_grade->get_serial_start();

		foreach($rs as $grade){

			$this->parser->assign("grade", $grade);

			$this->parser->assign("ROW_CLASS", ($i%2)==0?"even":"odd");

			$this->parser->assign("STATUS", ($grade['status'])=="Active"?"active.png":"inactive.png");

			$this->parser->assign("COUNT", $i);

			$this->parser->assign("SERIAL", $Sr);

			$this->parser->parse('main.grade_table.grade_row');

			$i++;

			$Sr++;

		}

		$this->parser->parse('main.grade_table');		

		$this->parser->parse('main');			

		$this->update_ouput($this->parser->text('main'));

		$this->unload_parser();	

	}

	

	function multi_delete(){

		$del_id = $this->app->getPostVar('del');

		$is_delete = array();

		$edit_field=array();

		$edit_field['status']='Inactive';

		$del_status = 'True';

		for($i=0;$i<count($del_id);$i++){
			$is_exist=$this->app->utility->check_record_used_delete("grade",$del_id[$i],"grade");
			if ($is_exist=='Yes') {
				$del_status = 'False';
			}else{

				$obj_model_grade = $this->app->load_model("grade");

				$obj_model_grade->map_fields($edit_field);

				$is_delete[] = $obj_model_grade->execute("UPDATE", false, "", "id=".$del_id[$i]);

				//add user log for DELETE

				$this->app->utility->add_user_log("grade",$del_id[$i],"DELETE");
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

		$this->app->redirect("index.php?view=grade_list");

	}

	

	function single_delete(){
		$is_exist=$this->app->utility->check_record_used_delete("grade",$this->app->getPostVar('id'),"grade");
		if ($is_exist=='Yes') {
			$this->app->utility->set_message("This Record is Already in Use. You Can Not Delete", "ERROR");
		}else{

			$edit_field=array();

			$edit_field['status']='Inactive';

			$obj_model_grade = $this->app->load_model("grade",  $this->app->getPostVar('id'));

			$obj_model_grade->map_fields($edit_field);

			if($obj_model_grade->execute("UPDATE")){

				//add user log for DELETE

				$this->app->utility->add_user_log("grade",$this->app->getPostVar('id'),"DELETE");

				$this->app->utility->set_message("Record deleted successfully", "SUCCESS");

			}else{

				$this->app->utility->set_message("Problem in delete record", "ERROR");

			}
		}

		$this->app->redirect("index.php?pg_no=".$this->app->getPostVar('page_no')."&view=grade_list");			

	}

	

	function recycle(){
		$is_exist=$this->app->utility->check_record_exist_recycle("grade",$this->app->getPostVar('id'),'name');
		if ($is_exist=='Yes') {
			$this->app->utility->set_message("You can not restore this record. record already exist", "ERROR");
		}else{
			$edit_field=array();

			$edit_field['status']='Active';

			$obj_model_grade = $this->app->load_model("grade",  $this->app->getPostVar('id'));

			$obj_model_grade->map_fields($edit_field);

			if($obj_model_grade->execute("UPDATE")){

				//add user log for RESTORE

				$this->app->utility->add_user_log("grade",$this->app->getPostVar('id'),"RESTORE");

				$this->app->utility->set_message("Record restored successfully", "SUCCESS");

			}else{

				$this->app->utility->set_message("Problem in restore record", "ERROR");

			}
		}

		$this->app->redirect("index.php?pg_no=".$this->app->getPostVar('page_no')."&view=grade_list");			

	}

}	


?>