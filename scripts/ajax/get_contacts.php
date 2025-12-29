<?php 
$groups=$app->getPostVar('groups');
$branch_id=$app->getPostVar('branch_id');
$grp_ids=explode(",",$groups);
$contact_arr=array();
$all_mobile_no = array();
$i=0;
$branch_admin_sql = "";
$city_account_sql = "";

$branch_admin_sql = " AND branch_id = ".$branch_id;

if(count($grp_ids)>0){
	for($j=0;$j<count($grp_ids);$j++){
		//check for admin user
		if(strtoupper($grp_ids[$j])=="ADMIN USER"){
			//get admin user
			$obj_model_admin_user = $app->load_model("admin_user");		
			$rs_admin_user=$obj_model_admin_user->execute("SELECT",false,"","status='Active' AND mobile!=''".$branch_admin_sql,"full_name ASC");				
			if(count($rs_admin_user)>0){
				//get contacts				
				foreach($rs_admin_user as $admin_user){
					$number = $app->utility->format_mobile_number($admin_user['mobile']);
					if(preg_match("/^[6-9]\d{9}$/",$number)){
						if(!in_array($number,$all_mobile_no)){
							$all_mobile_no[]=$number;
							$contact_arr[$i]['name']=$admin_user['full_name'];
							$contact_arr[$i]['mobile']=$number;
							$i++;
						}
					}
				}
			}			
		}
	}
}
if(count($contact_arr)>0){
	usort($contact_arr,'sortByOrder');	
	$data=$contact_arr;	
}else{
	$data="";
}
echo json_encode($data);

function sortByOrder($a, $b) {
    //return $a['name'] - $b['name'];
	return strnatcmp($a['name'], $b['name']);
}
?>