<?php

class _message_log_list extends controller{		

	function init(){		

	}

	

	function onload(){

		ini_set('max_execution_time', 800);

		

		if($this->app->getGetVar('destroy')==1){

			unset($_SESSION['message_log_search']);

			$this->app->redirect("index.php?view=message_log_list");

		}

		

		if($_SESSION['admin_user_group_id']=='1'){

			//fetch branch

			$branch=$this->app->utility->get_dropdown("branch","id","name","All Branch","","name","","ALL");

			$this->assign("branch",$branch);

		}



		$this->assign("manager_for", "SMS Log");			

		if($this->app->getCurrentAction()==""){

			$this->load_data();

		}

	}

	

	function search(){

		unset($_SESSION['message_log_search']);

		$this->load_data();

	}

	

	function load_data(){

		$obj_model_message_log = $this->app->load_model("message_log");

		$obj_model_message_log->join_table('branch','left',array('name'),array('branch_id'=>'id'));

		$obj_model_message_log->set_paging_settings($_SESSION['records'],5);	

		

		/* Search By */

		if($this->app->getPostVar("to_number")!=""){

			$_SESSION['message_log_search']['to_number'] = $this->app->getPostVar("to_number");

		}

		if($this->app->getPostVar("message")!=""){

			$_SESSION['message_log_search']['message'] = $this->app->getPostVar("message");

		}

		if($this->app->getPostVar("datetime")!=""){

			$_SESSION['message_log_search']['datetime'] = $this->app->getPostVar("datetime");

		}

		if($this->app->getPostVar("branch_id")!=""){

			$_SESSION['message_log_search']['branch_id'] = $this->app->getPostVar("branch_id");

		}			

		$sql_where_clause = "";

		if(isset($_SESSION['message_log_search']['to_number'])){

			$to_number = $_SESSION['message_log_search']['to_number'];

			$sql_where_clause .=($sql_where_clause!=''?" AND ":"")."to_number like '%".$to_number."%'";

			$this->assign("field_to_number", $_SESSION['message_log_search']['to_number']);

		}

		if(isset($_SESSION['message_log_search']['message'])){

			$message = $_SESSION['message_log_search']['message'];

			$sql_where_clause .=($sql_where_clause!=''?" AND ":"")."message like '%".$message."%'";

			$this->assign("field_message", $_SESSION['message_log_search']['message']);

		}

		if(isset($_SESSION['message_log_search']['datetime'])){

			$datetime = date("Y-m-d",strtotime($_SESSION['message_log_search']['datetime']));

			$sql_where_clause .=($sql_where_clause!=''?" AND ":"")."DATE(message_log.datetime) = '".$datetime."'";

			$this->assign("field_datetime", $_SESSION['message_log_search']['datetime']);

		}

		if(isset($_SESSION['message_log_search']['branch_id'])){

			$branch_id = $_SESSION['message_log_search']['branch_id'];

			if($branch_id!='ALL'){

				$sql_where_clause .=($sql_where_clause!=''?" AND ":""). "branch_id =".$branch_id;	

			}			

			$this->assign("field_branch_id", $_SESSION['message_log_search']['branch_id']);

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

			$_SESSION['order_by_field_name'] = "message_log.id";	

			$_SESSION['order_by'] = "DESC";

			$_SESSION['view'] = $this->app->getRequestVar("view");

		}else{

			$_SESSION['order_by_field_name'] = "message_log.id";	

			$_SESSION['order_by'] = "DESC";

			$_SESSION['view'] = $this->app->getRequestVar("view");

		}

		$order_by_field_name = $_SESSION['order_by_field_name'];

		$order_by = $_SESSION['order_by'];

		$sql_order_by_clause = "";

		if($order_by != ""){

			$sql_order_by_clause = $order_by_field_name. " " .$order_by;

		}		

		if($_SESSION['admin_user_group_id']!='1'){

			$sql_where_clause.=($sql_where_clause!=''?" AND ":"")." branch_id=".$_SESSION['branch_id'];

		}

		$rs = $obj_model_message_log->execute("SELECT", true, "", $sql_where_clause, $sql_order_by_clause);		

		$data = $this->app->compile();

		$this->load_parser($data);

		$this->parser->assign("PAGING", $obj_model_message_log->show_paging());

		$this->parser->assign("PAGE_NO", $this->app->getCurrentPage());

		$this->parser->assign("SHOW_HIDE", (count($rs)>0)?"none":"");



		$i = 1;

		$Sr = $obj_model_message_log->get_serial_start();

		foreach($rs as $message_log){

			$message_log['datetime'] = date('d-m-Y g:i A',strtotime($message_log['datetime']));

			$message_log['to_number'] = str_replace(",", ", ", $message_log['to_number']);			

			$this->parser->assign("message_log", $message_log);	

			if($message_log['delivery_report'] == "" || $message_log['delivery_report'] == "Sent"){

				$delivery_report =$this->app->utility->delivery_report($message_log['msg_id']);

				if($delivery_report!=""){

					$obj_model_sms = $this->app->load_model("message_log");

					$sql_update = "UPDATE message_log SET delivery_report='".$delivery_report."' WHERE id=".$message_log['id'];

					$rs_update = $obj_model_sms->execute("UPDATE",false,$sql_update);

				}else{

					$delivery_report = $message_log['delivery_report'];

				}

			}else{

				$delivery_report = $message_log['delivery_report'];

			}

			$this->parser->assign("delivery_report",$delivery_report);		

			$this->parser->assign("ROW_CLASS", ($i%2)==0?"even":"odd");

			$this->parser->assign("COUNT", $i);

			$this->parser->assign("SERIAL", $Sr);

			$this->parser->parse('main.message_log_table.message_log_row');

			$i++;

			$Sr++;

		}

		$this->parser->parse('main.message_log_table');		

		$this->parser->parse('main');			

		$this->update_ouput($this->parser->text('main'));

		$this->unload_parser();	

	}

}	

?>