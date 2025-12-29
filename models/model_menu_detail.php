<?php
	class model_menu_detail{
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
			$this->fields["menu_master_id"]="int(11)";
			$this->nullable["menu_master_id"]="NO";
			$this->default_value["menu_master_id"]="";
			$this->fields["menu_file_label_id"]="int(11)";
			$this->nullable["menu_file_label_id"]="NO";
			$this->default_value["menu_file_label_id"]="";
			$this->fields["sort_order"]="int(2)";
			$this->nullable["sort_order"]="NO";
			$this->default_value["sort_order"]="";
			$this->fields["show_in_menu"]="enum('No','Yes')";
			$this->nullable["show_in_menu"]="NO";
			$this->default_value["show_in_menu"]="No";
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