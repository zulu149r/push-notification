<?php
	set_time_limit(0);
	/* Database Connection Part */ 
	define('DBHOST','');
	define('DBUSER','');
	define('DBPASS','');
	define('DBNAME','');
	define('DBPORT','');
	$db_conn_var=mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME,DBPORT);
	if(!$db_conn_var)
	{
		die('Database Connection failed');
	}
	else
	{
		echo "Success";
	}
	$sql="SELECT * FROM tablename";
	$rs=mysqli_query($db_conn_var,$sql);
	$android_device_token=array();
	$apple_device_token=array();
	//$regId = array();
	while ($row = mysqli_fetch_object($rs))
	{
		if($row->DeviceType=='apple')
		{
			 array_push($apple_device_token, $row->DeviceRegistrationID);
		}
		elseif($row->DeviceType=='android')
		{
			array_push($android_device_token, $row->DeviceRegistrationID);
		}
	}*/
	/* Android Part */
	//$android_device_token=array(1,2,3,4,5,6,7,8);
	//$apple_device_token=array(9,10,11,12,13,14,15,16);
	if($_POST['submit']=='Send Push')
	{
		if($_POST['platform']=='android')
		{
			$splitarray=array_chunk($android_device_token,2);
			$i=0;
			$headers = array(
				'Authorization: key=AIzaSyA28LfE9vvVjVf0T-WYfWP04pPODa3kBeM',
				'Content-Type: application/json'
			);
			foreach($splitarray as $key=>$reg_ids)
			{
				//$registration_ids=$reg_ids;
				$message = array();
				$message['data']['type'] = 'NexAEI';
				$message['data']['message'] = $_POST['message'];
				$fields = array(
					"registration_ids" => $reg_ids, 
					"data" => $message
				);
				$url = 'https://android.googleapis.com/gcm/send';
				$ch = curl_init();
				//Set the url, number of POST vars, POST data
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				//Disabling SSL Certificate support temporarly
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
				//Execute post
				$result = curl_exec($ch);
				if ($result === FALSE) {
					die('Curl failed: ' . curl_error($ch));
				}
				curl_close($ch);
				echo $result;
				echo "<br />";
				
			}
		}
		/* Apple part */
		if($_POST['platform']=='ios')
		{
				//$deviceToken=$apple_device_token;
				$message=$_POST['message'];
				$type='NexAEI';
				$extra='';
				$silent=false;
				define('SERVER_ENV','DEV');

				$ctx = stream_context_create();
				if(SERVER_ENV=='PRODUCTION'){
					stream_context_set_option($ctx, 'ssl', 'local_cert', 'Certificates_Apns_NexAEI_Prod.pem');
				}else{
					stream_context_set_option($ctx, 'ssl', 'local_cert', 'Certificates_DEV_APNS_NEXAEI.pem');
				}

				stream_context_set_option($ctx, 'ssl', 'passphrase', '#nexaei123');

				if(SERVER_ENV=='PRODUCTION'){
					$fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
				}else{
					$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
				}

				if($silent==false){
					$body['aps'] = array('alert' => $message,'type'=>$type,'extra'=>$extra,'sound' => 'default');
				}else{
					$body['aps'] = array('content-available' => 1,'message'=>$message);
				}
			foreach($apple_device_token as $deviceToken)
			{
				echo "{";
				echo $deviceToken;
				echo "<br />";
				$payload = json_encode($body);
				echo $payload;
				echo "<br />";
				$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
				echo $msg;
				echo "<br />";
				//$result = fwrite($fp, $msg, strlen($msg));
				try {
					$result = fwrite($fp, $msg, strlen($msg));
				} catch (Exception $ex) {
					sleep(1); //sleep for 5 seconds
					$result = fwrite($fp, $msg, strlen($msg));
				}
				
				echo "<br />";
				echo "}";
				echo "<br/>";
			}
			fclose($fp);
		}
		if($_POST['platform']=='both')
		{
			$splitarray=array_chunk($android_device_token,2);
			$i=0;
			$headers = array(
				'Authorization: key=AIzaSyA28LfE9vvVjVf0T-WYfWP04pPODa3kBeM',
				'Content-Type: application/json'
			);
			foreach($splitarray as $key=>$reg_ids)
			{
				//$registration_ids=$reg_ids;
				$message = array();
				$message['data']['type'] = 'NexAEI';
				$message['data']['message'] = $_POST['message'];
				$fields = array(
					"registration_ids" => $reg_ids, 
					"data" => $message
				);
				$url = 'https://android.googleapis.com/gcm/send';
				$ch = curl_init();
				//Set the url, number of POST vars, POST data
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				//Disabling SSL Certificate support temporarly
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
				//Execute post
				$result = curl_exec($ch);
				if ($result === FALSE) {
					die('Curl failed: ' . curl_error($ch));
				}
				curl_close($ch);
				echo $result;
				echo "<br />";
			}
			$message=$_POST['message'];
			$type='NexAEI';
			$extra='';
			$silent=false;
			define('SERVER_ENV','DEV');
			$ctx = stream_context_create();
			if(SERVER_ENV=='PRODUCTION'){
				stream_context_set_option($ctx, 'ssl', 'local_cert', 'Certificates_Apns_NexAEI_Prod.pem');
			}else{
				stream_context_set_option($ctx, 'ssl', 'local_cert', 'Certificates_DEV_APNS_NEXAEI.pem');
			}
			stream_context_set_option($ctx, 'ssl', 'passphrase', '#nexaei123');
			if(SERVER_ENV=='PRODUCTION'){
			$fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
			}else{
				$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
			}
			if($silent==false){
				$body['aps'] = array('alert' => $message,'type'=>$type,'extra'=>$extra,'sound' => 'default');
			}else{
				$body['aps'] = array('content-available' => 1,'message'=>$message);
			}
			foreach($apple_device_token as $deviceToken)
			{
				echo "{";
				echo $deviceToken;
				echo "<br />";
				$payload = json_encode($body);
				echo $payload;
				echo "<br />";
				$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
				echo $msg;
				echo "<br />";
				//$result = fwrite($fp, $msg, strlen($msg));
				try {
					$result = fwrite($fp, $msg, strlen($msg));
				} catch (Exception $ex) {
					sleep(1); //sleep for 5 seconds
					$result = fwrite($fp, $msg, strlen($msg));
				}
				echo "}";
				echo "<br/>";
			}
			fclose($fp);
		}
	}
?>