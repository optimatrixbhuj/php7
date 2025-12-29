<?php
	class model_admin_user_group{
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
			$this->fields["group_name"]="varchar(255)";
			$this->nullable["group_name"]="NO";
			$this->default_value["group_name"]="";
			$this->fields["description"]="varchar(255)";
			$this->nullable["description"]="NO";
			$this->default_value["description"]="";
			$this->fields["status"]="enum('Active','Inactive')";
			$this->nullable["status"]="NO";
			$this->default_value["status"]="Active";
			$this->fields["created"]="datetime";
			$this->nullable["created"]="NO";
			$this->default_value["created"]="";
		}
	}
?>