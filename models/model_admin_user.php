<?php
	class model_admin_user{
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
			$this->fields["branch_id"]="int(11)";
			$this->nullable["branch_id"]="NO";
			$this->default_value["branch_id"]="";
			$this->fields["username"]="varchar(255)";
			$this->nullable["username"]="NO";
			$this->default_value["username"]="";
			$this->fields["password"]="varchar(255)";
			$this->nullable["password"]="NO";
			$this->default_value["password"]="";
			$this->fields["full_name"]="varchar(255)";
			$this->nullable["full_name"]="NO";
			$this->default_value["full_name"]="";
			$this->fields["email"]="varchar(255)";
			$this->nullable["email"]="NO";
			$this->default_value["email"]="";
			$this->fields["mobile"]="varchar(255)";
			$this->nullable["mobile"]="NO";
			$this->default_value["mobile"]="";
			$this->fields["photo"]="varchar(255)";
			$this->nullable["photo"]="NO";
			$this->default_value["photo"]="";
			$this->fields["last_login"]="datetime";
			$this->nullable["last_login"]="NO";
			$this->default_value["last_login"]="";
			$this->fields["pwd_change_date"]="datetime";
			$this->nullable["pwd_change_date"]="NO";
			$this->default_value["pwd_change_date"]="";
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