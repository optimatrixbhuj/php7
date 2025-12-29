<?php
	class model_message_log{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function __CONSTRUCT($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["branch_id"]="int(11)";
			$this->nullable["branch_id"]="NO";
			$this->default_value["branch_id"]="";
			$this->fields["msg_id"]="varchar(255)";
			$this->nullable["msg_id"]="NO";
			$this->default_value["msg_id"]="";
			$this->fields["called_from"]="varchar(255)";
			$this->nullable["called_from"]="NO";
			$this->default_value["called_from"]="";
			$this->fields["datetime"]="datetime";
			$this->nullable["datetime"]="NO";
			$this->default_value["datetime"]="";
			$this->fields["message"]="text";
			$this->nullable["message"]="NO";
			$this->default_value["message"]="";
			$this->fields["to_number"]="text";
			$this->nullable["to_number"]="NO";
			$this->default_value["to_number"]="";
			$this->fields["date"]="date";
			$this->nullable["date"]="NO";
			$this->default_value["date"]="";
			$this->fields["time"]="time";
			$this->nullable["time"]="NO";
			$this->default_value["time"]="";
			$this->fields["delivery_report"]="varchar(255)";
			$this->nullable["delivery_report"]="NO";
			$this->default_value["delivery_report"]="";
		}
	}
?>