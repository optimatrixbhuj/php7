<?php
	class htmlBuilder extends Singleton{	
		var $app;
		var $current_form;
		var $optgroup_stack;
		
		public static function &get_instance() { 
			parent::$my_name = __CLASS__; 
			return parent::get_instance(); 
		}
		
		function init(){
			$this->app = &app::get_instance();
			$this->current_form = "";
			$this->optgroup_stack = array();
		}
		
		function buildTag($tag, $properties, $field_name=""){
			global $app;
			if(is_array($field_name)){
				foreach($field_name as $key=>$val){
					$id = $key;
					$name = $val;
				}
			}else{
				$name = $field_name;
				$id = $field_name;
			}
			$tag = strtolower($tag);
			$tmpStr="";
			if(isset($properties["type"])){
				$type = $properties["type"];
			}else{
				$type = "";
			}
			$post_back_value = NULL;
			if($app->isPostBack){
				$post_back_value = $app->getPostVar(str_replace("[]","",$name));
			}
			$auto_field = "field_".str_replace("[]","",$name);
			switch($tag){
				case "iframe";
					$tmpStr = "<".$tag;
					if($name!=""){
						$tmpStr.=" name=\"".$name."\" id=\"".$id."\"";
					}
					foreach($properties as $key=>$val){
						if(strtolower($key)!="value"){
							$tmpStr.=" ".strtolower($key)."=\"".$val."\"";
						}
					}
					$tmpStr.=">";
					$tmpStr.="</".$tag.">";
				case "textarea";
					$tmpStr = "<".$tag;
					if($name!=""){
						$tmpStr.=" name=\"".$name."\" id=\"".$id."\"";
					}
					foreach($properties as $key=>$val){
						if(strtolower($key)!="value"){
							$tmpStr.=" ".strtolower($key)."=\"".$val."\"";
						}
					}
					$tmpStr.=">";
					if(isset($properties["value"])){
						$tmpStr.=$properties["value"];
					}else if(isset($this->app->$auto_field)){
						$tmpStr.=$this->app->$auto_field;
					}else if($this->current_form!=""){
						if(array_key_exists($this->current_form, $this->app->form_data)){
							if(array_key_exists($name, $this->app->form_data[$this->current_form])){
								$tmpStr.=$this->app->form_data[$this->current_form][$name];
							}
						}else if($post_back_value!=NULL){
							$tmpStr.=$post_back_value;
						}
					}
					$tmpStr.="</".$tag.">";
				break;
				case "form":
					$this->current_form = $name;
					$tmpStr = "<".$tag;
					if($name!=""){
						$tmpStr.=" name=\"".$name."\" id=\"".$id."\" method=\"post\" enctype=\"multipart/form-data\"";
					}
					if(!isset($properties["action"])){
						$tmpStr.=" action=\"index.php?view=".$this->app->getCurrentView()."\"";
					}
					foreach($properties as $key=>$val){
						$tmpStr.=" ".strtolower($key)."=\"".$val."\"";
					}
					$tmpStr.=">\n";
					$tmpStr.="<input type=\"hidden\" name=\"".__PRODUCT__."_REF_VIEW\" value=\"".$this->app->getCurrentView()."\">\n";
				break;
				case "select":
					$tmpStr = "<".$tag;
					if($name!=""){
						$tmpStr.=" name=\"".$name."\" id=\"".$id."\"";
					}
					foreach($properties as $key=>$val){
						if(strtolower($key)!="values" && strtolower($key)!="selected"){
							$tmpStr.=" ".strtolower($key)."=\"".$val."\"";
						}
					}
					$tmpStr.=" >";
					if(array_key_exists("values", $properties)){
						if(is_array($properties["values"])){
							foreach($properties["values"] as $option=>$text){
								$group_name = "";
								if(is_array($text)){
									$type = strtoupper($text["TYPE"]);
									if(array_key_exists("GROUPNAME", $text)){
										$group_name = $text["GROUPNAME"];
									}
									$text = $text["TEXT"];
								}else{
									$type = "ITEM";
								}
								if($type == "GROUP"){
									if($group_name == "" && sizeof($this->optgroup_stack)>0){
										foreach($this->optgroup_stack as $optgroup){
											$tmpStr.="\n</optgroup>";
										}
										$this->optgroup_stack = array();
									}else{
										while(sizeof($this->optgroup_stack)>0 && $this->optgroup_stack[sizeof($this->optgroup_stack)-1] != $group_name){
											array_pop($this->optgroup_stack);
											$tmpStr.="\n</optgroup>";
											if(sizeof($this->optgroup_stack)==0){
												break;
											}
										}
									}
									array_push($this->optgroup_stack, $text);
									if(sizeof($this->optgroup_stack)>1){
										$tmpStr.="\n<optgroup label=\"&nbsp;&nbsp;&nbsp;&nbsp;".$text."\">";
									}else{
										$tmpStr.="\n<optgroup label=\"".$text."\">";
									}
								}else{
									if($type=="ITEM"){
										foreach($this->optgroup_stack as $optgroup){
											$tmpStr.="\n</optgroup>";
										}
										$this->optgroup_stack = array();
									}else if($type=="GROUPITEM"){
										if($group_name == ""){
											if(sizeof($this->optgroup_stack)>0){
												$group_name = $this->optgroup_stack[sizeof($this->optgroup_stack)-1];
											}
										}
										if($group_name!="" && $group_name != $this->optgroup_stack[sizeof($this->optgroup_stack)-1]){
											while(sizeof($this->optgroup_stack)>0 && $this->optgroup_stack[sizeof($this->optgroup_stack)-1] != $group_name){
												array_pop($this->optgroup_stack);
												$tmpStr.="\n</optgroup>";
												if(sizeof($this->optgroup_stack)==0){
													break;
												}
											}
											if(sizeof($this->optgroup_stack)==0){
												array_push($this->optgroup_stack, $group_name);
												$tmpStr.="\n<optgroup label=\"".$group_name."\">";
											}
										}
									}
									$tmpStr.="\n<option ";
									if(isset($this->app->$auto_field)){
										if(is_array($this->app->$auto_field)){
											if(in_array($option, $this->app->$auto_field)){
												$tmpStr.=" selected";
											}
										}else{
											if($this->app->$auto_field==$option){
												$tmpStr.=" selected";
											}
										}
									}else if(isset($properties["selected"])){
										if(is_array($properties["selected"])){
											if(in_array($option, $properties["selected"])){
												$tmpStr.=" selected";
											}
										}else{
											if($properties["selected"]==$option){
												$tmpStr.=" selected";
											}
										}
									}else if($this->current_form!=""){
										if(array_key_exists($this->current_form, $this->app->form_data)){
											if(array_key_exists($name, $this->app->form_data[$this->current_form])){
												if(is_array($this->app->form_data[$this->current_form][$name])){
													if(in_array($option, $this->app->form_data[$this->current_form][$name])){
														$tmpStr.=" selected";
													}
												}else{
													if($option == $this->app->form_data[$this->current_form][$name]){
														$tmpStr.=" selected";
													}
												}
											}
										}else if($post_back_value!=NULL){
											if(is_array($post_back_value)){
												if(in_array($option, $post_back_value)){
													$tmpStr.=" selected";
												}
											}else{
												if($post_back_value==$option){
													$tmpStr.=" selected";
												}
											}
										}
									}
									$tmpStr.=" value=\"".$option."\">".$text."</option>";
								}
							}
							foreach($this->optgroup_stack as $optgroup){
								$tmpStr.="\n</optgroup>";
							}
							$this->optgroup_stack = array();
						}
					}
					$tmpStr.="</".$tag.">";
				break;
				default:
					$tmpStr = "<".$tag;
					if($name!=""){
						$tmpStr.=" name=\"".$name."\" id=\"".$id."\"";
					}
					foreach($properties as $key=>$val){
						$tmpStr.=" ".strtolower($key)."=\"".$val."\"";
					}
					if($type=="text" || $type=="password" || $type=="hidden" || $type=="number" || $type=="email" || $type=="tel"){
						if(!isset($properties["value"])){
							if(isset($this->app->$auto_field)){
								$tmpStr.=" value=\"".$this->app->$auto_field."\"";
							}else if($this->current_form!=""){
								if(array_key_exists($this->current_form, $this->app->form_data)){
									if(array_key_exists($name, $this->app->form_data[$this->current_form])){
										$tmpStr.=" value=\"".$this->app->form_data[$this->current_form][$name]."\"";
									}
								}else if($post_back_value!=NULL){
									$tmpStr.=" value=\"".$post_back_value."\"";
								}
							}
						}
					}else if($type=="checkbox"){
						if(isset($properties["value"])){
							if(isset($this->app->$auto_field)){
								if(is_array($this->app->$auto_field)){
									if(in_array($properties["value"], $this->app->$auto_field)){
										$tmpStr.=" checked=\"checked\"";
									}
								}else{
									if($this->app->$auto_field==$properties["value"]){
										$tmpStr.=" checked=\"checked\"";
									}
								}
							}else if(isset($properties["selected"])){
								if(is_array($properties["selected"])){
									if(in_array($properties["value"], $properties["selected"])){
										$tmpStr.=" checked=\"checked\"";
									}
								}else{
									if($properties["selected"]==$properties["value"]){
										$tmpStr.=" checked=\"checked\"";
									}
								}
							}else if($this->current_form!=""){
								if(array_key_exists($this->current_form, $this->app->form_data)){
									if(array_key_exists($name, $this->app->form_data[$this->current_form])){
										if(is_array($this->app->form_data[$this->current_form][$name])){
											if(in_array($properties["value"], $this->app->form_data[$this->current_form][$name])){
												$tmpStr.=" checked=\"checked\"";
											}
										}else{
											if($this->app->form_data[$this->current_form][$name]==$properties["value"]){
												$tmpStr.=" checked=\"checked\"";
											}
										}
									}
								}else if($post_back_value!=NULL){
									if(is_array($post_back_value)){
										if(in_array($properties["value"], $post_back_value)){
											$tmpStr.=" checked=\"checked\"";
										}
									}else{
										if($post_back_value==$properties["value"]){
											$tmpStr.=" checked=\"checked\"";
										}
									}
								}								
							}
						}
					}else if($type=="radio"){
						if(isset($this->app->$auto_field) && isset($properties["value"])){
							if($properties["value"]==$this->app->$auto_field){
								$tmpStr.=" checked=\"checked\"";
							}
						}else if($this->current_form!="" && isset($properties["value"])){
							if(array_key_exists($this->current_form, $this->app->form_data)){
								if(array_key_exists($name, $this->app->form_data[$this->current_form])){
									if($properties["value"]==$this->app->form_data[$this->current_form][$name]){
										$tmpStr.=" checked=\"checked\"";
									}
								}
							}else if($post_back_value!=NULL && isset($properties["value"])){
								if($properties["value"]==$post_back_value){
									$tmpStr.=" checked=\"checked\"";
								}
							}
						}
					}
					$tmpStr.=" />";
				break;
			}
			echo $tmpStr;
		}
		
		function closeForm(){
			echo "</form>";
			$this->current_form = "";
		}
	}
?>