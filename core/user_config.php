<?php

	class userconfig{

		var $config;



		/*==================================================================================*/

		/*  WRITE ALL USER CONFIG VARIABLE IN THIS FILE WHICH IS USED MORE THEN ONE TIME 	*/

		/*	FOR EXAMPLE , is given below , THIS VARIABLE IS DEFINED FOR UPLOADING FILE PATH */

		/*==================================================================================*/

		

		function __CONSTRUCT(){

			$this->config["admin_user"]="uploads/admin_user/";

			$this->config["admin_user_width"]='450'; 

			$this->config["admin_user_height"]='330';

		}

	}

?>