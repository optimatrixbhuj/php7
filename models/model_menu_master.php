<?php
	class model_menu_master{
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
			$this->fields["label"]="varchar(255)";
			$this->nullable["label"]="NO";
			$this->default_value["label"]="";
			$this->fields["icon_class"]="varchar(50)";
			$this->nullable["icon_class"]="NO";
			$this->default_value["icon_class"]="";
			$this->fields["file_name"]="varchar(255)";
			$this->nullable["file_name"]="NO";
			$this->default_value["file_name"]="";
			$this->fields["background_color"]="varchar(255)";
			$this->nullable["background_color"]="NO";
			$this->default_value["background_color"]="";
			$this->fields["text_color"]="varchar(255)";
			$this->nullable["text_color"]="NO";
			$this->default_value["text_color"]="";
			$this->fields["sort_order"]="int(2)";
			$this->nullable["sort_order"]="NO";
			$this->default_value["sort_order"]="";
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