<?php
class FCMNotification{ 	

	public function __construct(){		
	}
	
	public function sendPushNotification($token, $title, $body, $photo, $notification_type, $data_id){
		if($title===''){
			$title="AYO AYO";
		}
		
		$path_to_firebase_cm = 'https://fcm.googleapis.com/fcm/send';
		
		$fields = array(
			'to' => $token,
			/*'notification' => array('title' => $title, 'body' => $body, 'photo' => $photo, 'deal_id' => $deal_id),*/
			'data' => array('title' => $title, 'body' => $body, 'photo' => $photo, 'notification_from' => $notification_type, 'id' => $data_id),
			'priority' => 'high'
		);

		$headers = array(
			'Authorization:key=' . FCM_SERVER_KEY,
			'Content-Type:application/json'
		);
		//print_r($fields);
		//print_r($headers);		
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $path_to_firebase_cm); 
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 ); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    	//print_r($ch);exit;
		$result = curl_exec($ch);
		curl_close($ch);
		//print_r($result);
		return $result;
	}
}
?>