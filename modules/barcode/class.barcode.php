<?php
class Barcode {
	function Barcode(){
		
	}
	
	function generate_barcode($barcode_type , $text , $save_to_file){
		$class_file_name = dirname(__FILE__).'/class/'.$barcode_type.'.barcode.php';
	
		if(file_exists($class_file_name)){
			require_once($class_file_name);
			require_once(dirname(__FILE__).'/class/BCGDrawing.php'); 
			// Loading Font
			$font =& new BCGFont(dirname(__FILE__).'/class/font/ARIALBD.TTF', 24);
			
			// The arguments are R, G, B for color.
			$color_black =& new BCGColor(0, 0, 0);
			$color_white =& new BCGColor(255, 255, 255); 
			
			$code =& new $barcode_type();
			$code->setScale(2); // Resolution
			$code->setThickness(30); // Thickness
			$code->setForegroundColor($color_black); // Color of bars
			$code->setBackgroundColor($color_white); // Color of spaces
			$code->setFont($font); // Font (or 0)
			$code->parse($text); // Text

			/* Here is the list of the arguments
			1 - Filename (empty : display on screen)
			2 - Background color */
			
			$drawing =& new BCGDrawing($save_to_file , $color_white);
			$drawing->setBarcode($code);
			$drawing->draw();

			// Draw (or save) the image into PNG format.
			$drawing->finish(2);
		}else{
			trigger_error("Invalid barcode type",E_USER_ERROR);				
		}
	}
	
	function check_barcode_validation($barcode_type){
		switch($barcode_type){
			case 'BCGcode39':
				$keys = array('0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','-','.',' ','$','/','+','%','*');
				$_POST['sku_barcode'] = strtoupper($_POST['sku_barcode']);
				$c = strlen($_POST['sku_barcode']);	
				$tmp_flag = true;
				for ($i = 0; $i < $c; $i++) {
					if(array_search($_POST['sku_barcode'][$i], $keys) === false) {
						setError("Some of the characters Are not allowed in this barcode format");
						$tmp_flag = false;
					}
				}
				if(strpos($_POST['sku_barcode'], '*') !== false) {
					setError("'*' Character is not allowed in barcode format");
					$tmp_flag = false;
				}
				if($tmp_flag)
					return true;
				break;
				
			case 'BCGcode128':
				return true;
				break;
			
			case 'BCGi25':
				$keys = array('0','1','2','3','4','5','6','7','8','9');
				$c = strlen($_POST['sku_barcode']);
				$tmp_flag = true;	
				for ($i = 0; $i < $c; $i++) {
					if (array_search($_POST['sku_barcode'][$i], $keys) === false) {
						setError("Characters Are not allowed in this barcode format");
						$tmp_flag = false;
					}
				}
				if($tmp_flag)
					return true;
				break;
				
			case 'BCGean13':
				$keys = array('0','1','2','3','4','5','6','7','8','9');
				$c = strlen($_POST['sku_barcode']);
				for($i = 0; $i < $c; $i++) {
					if(array_search($_POST['sku_barcode'][$i], $keys) === false) {
						setError("Characters Are not allowed in this barcode format");
					}
				}
				// If we have 13 chars just flush the last one
				if($c === 13) {
					$_POST['sku_barcode'] = substr($_POST['sku_barcode'], 0, 12);
					return true;
				} elseif($c === 12) {
					return true;
				} else{
					setError("Must provide 12 or 13 digits.");
				}
				break;
				
			case 'BCGean8':
				$keys = array('0','1','2','3','4','5','6','7','8','9');
				$c = strlen($_POST['sku_barcode']);
				$tmp_flag = true;
				for($i = 0; $i < $c; $i++) {
					if(array_search($_POST['sku_barcode'][$i], $keys) === false) {
						setError("Characters Are not allowed in this barcode format");
						$tmp_flag = false;
					}
				}
				// If we have 13 chars just flush the last one
				if($c != 7) {
					setError(" Barcode Must contain 7 chars, the 8th digit is automatically added.");
					$tmp_flag = false;
				} 
				if($tmp_flag)
					return true;
				break;
				
			case 'BCGupcext2':
				$keys = array('0','1','2','3','4','5','6','7','8','9');
				$c = strlen($_POST['sku_barcode']);
				$tmp_flag = true;
				for($i = 0; $i < $c; $i++) {
					if(array_search($_POST['sku_barcode'][$i], $keys) === false) {
						setError("Characters Are not allowed in this barcode format");
						$tmp_flag = false;
					}
				}
				// If we have 13 chars just flush the last one
				if($c !== 2) {
					setError("Barcode Must contain 2 numbers only.");
					$tmp_flag = false;
				} 
				if($tmp_flag)
					return true;
				break;
				
			case 'BCGupcext5':
				$keys = array('0','1','2','3','4','5','6','7','8','9');
				$c = strlen($_POST['sku_barcode']);
				$tmp_flag = true;
				for($i = 0; $i < $c; $i++) {
					if(array_search($_POST['sku_barcode'][$i], $keys) === false) {
						setError("Characters Are not allowed in this barcode format.");
						$tmp_flag = false;
					}
				}
				// If we have 13 chars just flush the last one
				if($c !== 5) {
					setError("Barcode Must contain 5 numbers only.");
				} 
				if($tmp_flag)
					return true;
				break;
				
			case 'BCGupca':
				$keys = array('0','1','2','3','4','5','6','7','8','9');
				$c = strlen($_POST['sku_barcode']);
				$tmp_flag = true;
				for($i = 0; $i < $c; $i++) {
					if(array_search($_POST['sku_barcode'][$i], $keys) === false) {
						setError("Characters Are not allowed in this barcode format");
						$tmp_flag = false;
					}
				}
				// If we have 13 chars just flush the last one
				if($c !== 11) {
					setError("Barcode Must contain 11 chars, the 12th digit is automatically added.");
					$tmp_flag = false;
				} 
				if($tmp_flag)
					return true;
				break;
				
			case 'BCGupce':
				$keys = array('0','1','2','3','4','5','6','7','8','9');
				$c = strlen($_POST['sku_barcode']);
				$tmp_flag = true;
				for($i = 0; $i < $c; $i++) {
					if(array_search($_POST['sku_barcode'][$i], $keys) === false) {
						setError("Characters Are not allowed in this barcode format");
					}
				}
				// If we have 13 chars just flush the last one
				if($c !== 11 && $c !== 6) {
					setError("Barcode Provide an UPC-A (11 chars) only");
					$tmp_flag = false;
				} 
				elseif($_POST['sku_barcode'][0] !== '0' && $_POST['sku_barcode'][0] !== '1' && $c !== 6) {
					setError("Barcode Must start with 0 or 1.");
					$tmp_flag = false;
				}
				if($tmp_flag)
					return true;
				break;
				
					
		}
			
	}
}
?>