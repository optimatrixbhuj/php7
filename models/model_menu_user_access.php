<?php
	class model_menu_user_access{
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
			$this->fields["admin_user_group_id"]="int(11)";
			$this->nullable["admin_user_group_id"]="NO";
			$this->default_value["admin_user_group_id"]="";
			$this->fields["menu_master_id"]="int(11)";
			$this->nullable["menu_master_id"]="NO";
			$this->default_value["menu_master_id"]="";
			$this->fields["menu_file_label_id"]="int(11)";
			$this->nullable["menu_file_label_id"]="NO";
			$this->default_value["menu_file_label_id"]="";
			$this->fields["permission"]="varchar(255)";
			$this->nullable["permission"]="NO";
			$this->default_value["permission"]="";
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