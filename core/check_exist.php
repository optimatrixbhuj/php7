<?php
	class checkexist{
		var $exist;

		/*==================================================================================*/
		/*  WRITE ALL USER CONFIG VARIABLE IN THIS FILE WHICH IS USED MORE THEN ONE TIME 	*/
		/*	FOR EXAMPLE , is given below , THIS VARIABLE IS DEFINED FOR UPLOADING FILE PATH */
		/*==================================================================================*/
		
		function __CONSTRUCT(){
			$this->exist["admin_user"]=array( 
					array("branch","admin_user_id"), 
			    array("menu_detail","admin_user_id"), 
			    array("menu_file_label","admin_user_id"), 
			    array("menu_master","admin_user_id")			    
			);
			$this->exist["admin_user_group"]=array( 
			    array("admin_user","	admin_user_group_id"),
			    array("menu_user_access","	admin_user_group_id")
			);		
			$this->exist["branch"]=array( 
			    array("admin_user","branch_id"),
			);	
		}
	}
?>