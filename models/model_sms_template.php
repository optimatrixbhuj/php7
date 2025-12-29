<?php
	class model_sms_template{
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
			$this->fields["subject"]="varchar(255)";
			$this->nullable["subject"]="NO";
			$this->default_value["subject"]="";
			$this->fields["message"]="text";
			$this->nullable["message"]="NO";
			$this->default_value["message"]="";
			$this->fields["status"]="enum('Active','Inactive')";
			$this->nullable["status"]="NO";
			$this->default_value["status"]="Active";
		}
	}
?>