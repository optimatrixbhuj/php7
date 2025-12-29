<?php
	class _generate_files_multiple extends controller{
		
		function init(){
			
		}
		
		function onload(){
			$this->assign("to_do", "Create");
			$this->assign("manager_for", "Generate Files Multiple Field & Table");
		}
		
		function create_data(){				
			
			$filename = strtolower($this->app->getPostVar('filename'));
			$tablename = strtolower($this->app->getPostVar('tablename'));
			
			// Create connection
			$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);exit;
			} 		
			
			$name_arr = $this->app->getPostVar('name');
			$type = $this->app->getPostVar('type');
			$length = $this->app->getPostVar('length');	
			$required = $this->app->getPostVar('required');	
			$list = $this->app->getPostVar('list');	
			$search = $this->app->getPostVar('search');	
			$order_by = $this->app->getPostVar('order_by');	
			//Table Creation
			$sql ="";		
			$sql = "CREATE TABLE `".$tablename."` (
			  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,";
			  foreach($name_arr as $i=>$name){
					if($name!=""){
						$name = strtolower($name);
						if($type[$i]=="TEXT" || $type[$i]=="DATE" || $type[$i]=="DATETIME" || $type[$i]=="YEAR" || $type[$i]=="TIME"){
							$sql.= "`".$name."` ".$type[$i]." NOT NULL,";
						}else{
							$sql.= "`".$name."` ".$type[$i]."(".$length[$i].") NOT NULL,";
						}
					}				  
			  }			  
			$sql.= " `admin_user_id` int(11) NOT NULL,
			  `status` enum('Active','Inactive') NOT NULL,
			  `created` datetime NOT NULL,
			  `updated` datetime NOT NULL
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

			//Form Creation Addedit Page			
			$INSERT_FORM="";			
			$count = 1;
			$total_length = count($name_arr);		
			$INSERT_FORM.='<tr class="table_field_value">';
			$INSERT_FORM.="\n";
			foreach($name_arr as $i=>$name){
					if($name!=""){
						$name = strtolower($name);
              $INSERT_FORM.='<td width="8%" height="35" align="left" valign="middle" style="padding-left:10px;">'.ucwords(str_ireplace("_"," ",$name)).'</td>';
			  $INSERT_FORM.="\n";
			  
			  if($count%3==0){
			  	$INSERT_FORM.='<td width="24%" height="35" align="left" valign="middle" style="padding-left:10px;">';
				$INSERT_FORM.="\n";
			  }else{
			  	$INSERT_FORM.='<td width="25%" height="35" align="left" valign="middle" style="padding-left:10px;">';
				$INSERT_FORM.="\n";
			  }
			  switch($type[$i]){
				case "VARCHAR":
					$INSERT_FORM.='<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"textbox","style"=>"text-transform: capitalize;"), "'.$name.'");?></td>';
					$INSERT_FORM.="\n";
					break;
				case "INT":
				case "FLOAT":
				case "DECIMAL":	
					$INSERT_FORM.='<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"textbox allow_num"), "'.$name.'");?></td>';
					$INSERT_FORM.="\n";
					break;						
				case "DATE":
				case "TIME":
				case "DATETIME":
				case "YEAR":								
					$INSERT_FORM.='<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"textbox"), "'.$name.'");?></td>';
					$INSERT_FORM.="\n";
					break;
				case "TEXT":				
					$INSERT_FORM.='<?php $this->htmlBuilder->buildTag("textarea", array("class"=>"textbox"), "'.$name.'");?></td>';
					$INSERT_FORM.="\n";
					break;
				case "ENUM":
				 $arr.= "$".$name."_arr = array(''=>'-Select ".ucwords(str_ireplace("_"," ",$name))."-'";				 
				 $length_arr = explode(",",$length[$i]);
				for ($i=0; $i < sizeof($length_arr); $i++)
				{
					$arr.=",".$length_arr[$i]."=>".$length_arr[$i];				  				  
				}				
				$arr.=")";
				 $INSERT_FORM.='<?php '.$arr.' ?>';
				 $INSERT_FORM.="\n";
				 $INSERT_FORM.='<?php $this->htmlBuilder->buildTag("select", array("class"=>"textbox","values"=>$'.$name.'_arr), "'.$name.'") ?></td>';				
				 $INSERT_FORM.="\n";	
					break;								
			}
              
               if($count%3==0){
				   $INSERT_FORM.='</tr>';
				   $INSERT_FORM.="\n";
					if($count < $total_length){
						$INSERT_FORM.='<tr class="table_field_value">';
						$INSERT_FORM.="\n";
					}
			   }
			   $count++;
					}
				}
				$INSERT_FORM.='</tr>';				
				$INSERT_FORM.="\n";
				
			//Form Validation  Addedit Page
			$FORM_VALIDATE_RULES="";
			$FORM_VALIDATE_MSGS="";
			
			foreach($name_arr as $i=>$name){
				if($name!="" && $required[$i]=='Yes'){
					$name = strtolower($name);
					$FORM_VALIDATE_RULES.=$name.': "required",';
					$FORM_VALIDATE_RULES.="\n\t\t\t";
					switch($type[$i]){
						case "VARCHAR":							
						case "INT":
						case "FLOAT":
						case "DECIMAL":							
						case "DATE":
						case "TIME":
						case "DATETIME":
						case "YEAR":
						case "TEXT":
							$FORM_VALIDATE_MSGS.=$name.': "Please Enter '.ucwords(str_ireplace("_"," ",$name)).'",';	
							$FORM_VALIDATE_MSGS.="\n\t\t\t";
							break;
						case "ENUM":
							$FORM_VALIDATE_MSGS.=$name.': "Please Select '.ucwords(str_ireplace("_"," ",$name)).'",';	
							$FORM_VALIDATE_MSGS.="\n\t\t\t";
							break;
					}
				}
			}			
			//List , Order By, Search By List Page
			$LIST_NAME="";
			$LIST_VALUE="";
			$COLSPAN_VALUE = 3;
			$SEARCH_BY_VIEW="";
			$SEARCH_BY_CONTROLLER_NAME="";
			$SEARCH_BY_CONTROLLER_SEARCH="";
			foreach($name_arr as $i=>$name){
				//List , Order By
				if($name!="" && $list[$i]=='Yes'){
					$COLSPAN_VALUE++;
					$name = strtolower($name);
					$LIST_NAME.='<td width="10%" height="25" align="center" valign="middle">';
					if($order_by[$i]=='Yes'){
						$LIST_NAME.='<a href="index.php?view=FILENAME_list&order_by_field_name='.$name.'&order_by=<?php echo ($_SESSION[\'order_by_field_name\']==\''.$name.'\' && $this->order_by!=\'\' ?$this->order_by:\'ASC\') ; ?>">'.ucwords(str_ireplace("_"," ",$name)).'</a></td>';
					}else{
						$LIST_NAME.=ucwords(str_ireplace("_"," ",$name)).'</td>';
					}
					$LIST_NAME.="\n";
					$LIST_VALUE.='<td align="center" valign="middle">{TABLENAME.'.$name.'}</td>';
					$LIST_VALUE.="\n";
				}
				//Search By List Page View
				if($name!="" && $search[$i]=='Yes'){
					$name = strtolower($name);
					$SEARCH_BY_VIEW.='<td width="15%" height="40" align="left" valign="middle">';
					switch($type[$i]){
						case "VARCHAR":							
						case "INT":
						case "FLOAT":
						case "DECIMAL":													
						case "TIME":						
						case "YEAR":
						case "TEXT":
							$SEARCH_BY_VIEW.='<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"textbox", "style"=>"width:90%","placeholder"=>"'.ucwords(str_ireplace("_"," ",$name)).'"), "'.$name.'") ?>';							
							break;
						case "DATE":
						case "DATETIME":
							$SEARCH_BY_VIEW.='<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"textbox date", "style"=>"width:90%","placeholder"=>"'.ucwords(str_ireplace("_"," ",$name)).'"), "'.$name.'") ?>';
							break;
						case "ENUM":							
							 $SEARCH_BY_VIEW.='<?php '.$arr.' ?>';
							 $SEARCH_BY_VIEW.="\n";
							 $SEARCH_BY_VIEW.='<?php $this->htmlBuilder->buildTag("select", array("class"=>"textbox","values"=>$'.$name.'_arr), "'.$name.'") ?>';			
							break;
					}	
					$SEARCH_BY_VIEW.="\n";		
					$SEARCH_BY_CONTROLLER_NAME.='if($this->app->getPostVar("'.$name.'")!=""){';
					$SEARCH_BY_CONTROLLER_NAME.="\n\t\t\t";
					$SEARCH_BY_CONTROLLER_NAME.='$_SESSION["FILENAME_search"]["'.$name.'"] = $this->app->getPostVar("'.$name.'");';
					$SEARCH_BY_CONTROLLER_NAME.="\n\t\t}\n\t\t";					
				
					$SEARCH_BY_CONTROLLER_SEARCH.='if(isset($_SESSION["FILENAME_search"]["'.$name.'"])){';
					$SEARCH_BY_CONTROLLER_SEARCH.="\n\t\t\t";
					$SEARCH_BY_CONTROLLER_SEARCH.='$'.$name.' = $_SESSION["FILENAME_search"]["'.$name.'"];';
					$SEARCH_BY_CONTROLLER_SEARCH.="\n\t\t\t";
					switch($type[$i]){
						case "VARCHAR":							
						case "INT":
						case "FLOAT":
						case "DECIMAL":													
						case "TIME":						
						case "YEAR":
						case "TEXT":
							$SEARCH_BY_CONTROLLER_SEARCH.='$sql_where_clause .=($sql_where_clause!=""?" AND ":""). "TABLENAME.'.$name.' like \'%".$'.$name.'."%\'";';					
							break;
						case "DATE":
							$SEARCH_BY_CONTROLLER_SEARCH.='$sql_where_clause .=($sql_where_clause!=""?" AND ":""). "TABLENAME.'.$name.' = \'".date("Y-m-d",strtotime($'.$name.'))."\'";';									
							break;
						case "DATETIME":
							$SEARCH_BY_CONTROLLER_SEARCH.='$sql_where_clause .=($sql_where_clause!=""?" AND ":""). "DATE(TABLENAME.'.$name.') = \'".date("Y-m-d",strtotime($'.$name.'))."\'";';									
							break;
						case "ENUM":
							$SEARCH_BY_CONTROLLER_SEARCH.='$sql_where_clause .=($sql_where_clause!=""?" AND ":""). "TABLENAME.'.$name.' = \'".$'.$name.'."\'";';		
							break;
					}	
					
					$SEARCH_BY_CONTROLLER_SEARCH.="\n\t\t\t";
					$SEARCH_BY_CONTROLLER_SEARCH.='$this->assign("field_'.$name.'", $_SESSION["FILENAME_search"]["'.$name.'"]);'					;
					$SEARCH_BY_CONTROLLER_SEARCH.="\n\t\t}\n\t\t";					
				}
			}
			if ($conn->query($sql) === TRUE) {
				$conn->close();
				file_get_contents(SERVER_ROOT."/scripts/system/build_models.php");
				$flag = 0;	
				if ($handle = opendir('views')) {
					while (false !== ($file = readdir($handle))) {
						if ($file != "." && $file != "..") {
							if($file == "view_".$filename."_addedit.php"){
								$flag = 1;
								break;
							}
						}
					}
					closedir($handle);
				}
				if ($handle = opendir('views')) {
					while (false !== ($file = readdir($handle))) {
						if ($file != "." && $file != "..") {
							if($file == "view_".$filename."_list.php"){
								$flag = 1;
								break;
							}
						}
					}
					closedir($handle);
				}
				if ($handle = opendir('controllers')) {
					while (false !== ($file = readdir($handle))) {
						if ($file != "." && $file != "..") {
							if($file == "controller_".$filename."_addedit.php"){
								$flag = 1;
								break;
							}
						}
					}
					closedir($handle);
				}
				if ($handle = opendir('controllers')) {
					while (false !== ($file = readdir($handle))) {
						if ($file != "." && $file != "..") {
							if($file == "controller_".$filename."_list.php"){
								$flag = 1;
								break;
							}
						}
					}
					closedir($handle);
				}
				if($flag == 1){
					$this->app->utility->set_message("Ooops... There was a problem to create records as same name's controller and view already exist. ", "ERROR");	
				}else{
					$originalfile_controller_addedit = "controllers/controller_mould_multiple_addedit.php";
					$originalfile_controller_list = "controllers/controller_mould_multiple_list.php";
					$originalfile_view_addedit = "views/view_mould_multiple_addedit.php";
					$originalfile_view_list = "views/view_mould_multiple_list.php";
					$newfile_controller_addedit = str_replace("_mould_multiple_","_".$filename."_",$originalfile_controller_addedit);
					if (!copy($originalfile_controller_addedit, $newfile_controller_addedit)) {
						$flag = 2;
					}else{
						$file = file_get_contents($newfile_controller_addedit);
						$filename_added = str_replace("FILENAME",$filename,$file);
						$tablename_added = str_replace("TABLENAME",$tablename,$filename_added);
						file_put_contents($newfile_controller_addedit,$tablename_added);
					}
					$newfile_controller_list = str_replace("_mould_multiple_","_".$filename."_",$originalfile_controller_list);
					if (!copy($originalfile_controller_list, $newfile_controller_list)) {
						$flag = 2;
					}else{
						$file = file_get_contents($newfile_controller_list);						
						$SEARCH_BY_CONTROLLER_NAME_added = str_replace("SEARCH_BY_CONTROLLER_NAME",$SEARCH_BY_CONTROLLER_NAME,$file);
						$SEARCH_BY_CONTROLLER_SEARCH_added = str_replace("SEARCH_BY_CONTROLLER_SEARCH",$SEARCH_BY_CONTROLLER_SEARCH,$SEARCH_BY_CONTROLLER_NAME_added);
						$filename_added = str_replace("FILENAME",$filename,$SEARCH_BY_CONTROLLER_SEARCH_added);
						$tablename_added = str_replace("TABLENAME",$tablename,$filename_added);
						file_put_contents($newfile_controller_list,$tablename_added);
					}
					$newfile_view_addedit = str_replace("_mould_multiple_","_".$filename."_",$originalfile_view_addedit);
					if (!copy($originalfile_view_addedit, $newfile_view_addedit)) {
						$flag = 2;
					}else{
						$file = file_get_contents($newfile_view_addedit);
						$filename_added = str_replace("FILENAME",$filename,$file);
						$tablename_added = str_replace("TABLENAME",$tablename,$filename_added);
						$INSERT_FORM_added = str_replace("INSERT_FORM",$INSERT_FORM,$tablename_added);
						$FORM_VALIDATE_RULES_added = str_replace("FORM_VALIDATE_RULES",$FORM_VALIDATE_RULES,$INSERT_FORM_added);
						$FORM_VALIDATE_MSGS_added = str_replace("FORM_VALIDATE_MSGS",$FORM_VALIDATE_MSGS,$FORM_VALIDATE_RULES_added);
						file_put_contents($newfile_view_addedit,$FORM_VALIDATE_MSGS_added);
					}
					$newfile_view_list = str_replace("_mould_multiple_","_".$filename."_",$originalfile_view_list);
					if (!copy($originalfile_view_list, $newfile_view_list)) {
						$flag = 2;
					}else{
						$file = file_get_contents($newfile_view_list);						
						$LIST_NAME_added = str_replace("LIST_NAME",$LIST_NAME,$file);
						$LIST_VALUE_added = str_replace("LIST_VALUE",$LIST_VALUE,$LIST_NAME_added);
						$COLSPAN_VALUE_added = str_replace("COLSPAN_VALUE",$COLSPAN_VALUE,$LIST_VALUE_added);
						$SEARCH_BY_VIEW_added = str_replace("SEARCH_BY_VIEW",$SEARCH_BY_VIEW,$COLSPAN_VALUE_added);
						$filename_added = str_replace("FILENAME",$filename,$SEARCH_BY_VIEW_added);
						$tablename_added = str_replace("TABLENAME",$tablename,$filename_added);
						file_put_contents($newfile_view_list,$tablename_added);
					}
					if($flag == 2){
						$this->app->utility->set_message("Ooops... There was a problem to create some files, please try again. ", "ERROR");						
					}else{
						$this->app->utility->set_message("Great... Files has been created successfully with name: . ".$filename, "SUCCESS");										
					}
				}
			}else{
				$this->app->utility->set_message("Ooops... There was a problem to create table: " . $conn->error, "ERROR");				
			}			
			//print_r($this->app->getPostVars());exit;	
			$this->app->redirect("index.php?view=generate_files_multiple");		
		}
		
	}	
?>