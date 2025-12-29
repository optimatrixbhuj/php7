<?php
	class model_user_logs{
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
			$this->fields["admin_user_id"]="int(11)";
			$this->nullable["admin_user_id"]="NO";
			$this->default_value["admin_user_id"]="";
			$this->fields["account_user_id"]="int(11)";
			$this->nullable["account_user_id"]="NO";
			$this->default_value["account_user_id"]="";
			$this->fields["ip_address"]="varchar(255)";
			$this->nullable["ip_address"]="NO";
			$this->default_value["ip_address"]="";
			$this->fields["table_name"]="varchar(255)";
			$this->nullable["table_name"]="NO";
			$this->default_value["table_name"]="";
			$this->fields["table_id"]="int(11)";
			$this->nullable["table_id"]="NO";
			$this->default_value["table_id"]="";
			$this->fields["action"]="enum('Insert','Update','Delete','Restore')";
			$this->nullable["action"]="NO";
			$this->default_value["action"]="Insert";
			$this->fields["changed_on"]="datetime";
			$this->nullable["changed_on"]="NO";
			$this->default_value["changed_on"]="";
			$this->fields["description"]="text";
			$this->nullable["description"]="NO";
			$this->default_value["description"]="";
			$this->fields["inserted_from"]="varchar(255)";
			$this->nullable["inserted_from"]="NO";
			$this->default_value["inserted_from"]="";
		}
	}
?>