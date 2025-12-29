<?php
	class model_branch{
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
			$this->fields["name"]="varchar(255)";
			$this->nullable["name"]="NO";
			$this->default_value["name"]="";
			$this->fields["address"]="text";
			$this->nullable["address"]="NO";
			$this->default_value["address"]="";
			$this->fields["person_name"]="varchar(255)";
			$this->nullable["person_name"]="NO";
			$this->default_value["person_name"]="";
			$this->fields["contact_number"]="varchar(255)";
			$this->nullable["contact_number"]="NO";
			$this->default_value["contact_number"]="";
			$this->fields["email"]="varchar(255)";
			$this->nullable["email"]="NO";
			$this->default_value["email"]="";
			$this->fields["admin_user_id"]="int(11)";
			$this->nullable["admin_user_id"]="NO";
			$this->default_value["admin_user_id"]="";
			$this->fields["status"]="enum('Active','Inactive')";
			$this->nullable["status"]="NO";
			$this->default_value["status"]="Active";
			$this->fields["created"]="datetime";
			$this->nullable["created"]="NO";
			$this->default_value["created"]="";
			$this->fields["updated"]="datetime";
			$this->nullable["updated"]="NO";
			$this->default_value["updated"]="";
		}
	}
?>