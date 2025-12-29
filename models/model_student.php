<?php
	class model_student{
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
			$this->fields["address"]="varchar(255)";
			$this->nullable["address"]="NO";
			$this->default_value["address"]="";
			$this->fields["created"]="datetime";
			$this->nullable["created"]="NO";
			$this->default_value["created"]="";
			$this->fields["updated"]="datetime";
			$this->nullable["updated"]="NO";
			$this->default_value["updated"]="";
			$this->fields["status"]="enum('Active','Inactive')";
			$this->nullable["status"]="NO";
			$this->default_value["status"]="Active";
		}
	}
?>