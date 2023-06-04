<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_ApiController extends CI_Controller
{

    public function __construct() {
        parent::__construct();
       $this->load->library(array('session','Volanemail','Curl','Volanimage','Volanlib','encryption'));
		$this->load->helper('url');
		$this->load->Model(array('Frontamodel','Frontbmodel','Frontcmodel','Frontdmodel'));
		$this->insert_date = date("Y-m-d H:i:s");
		
		$result = $this->Frontamodel->getData($this->tb15);
		foreach($result as $rs)
		{
			$min_deposite = $rs->min_deposite;
			$max_deposite = $rs->max_deposite;
			$min_withdrawal = $rs->min_withdrawal;
			$max_withdrawal = $rs->max_withdrawal;
			$min_transfer = $rs->min_transfer;
			$max_transfer = $rs->max_transfer;
			$min_bid_amount = $rs->min_bid_amount;
			$max_bid_amount = $rs->max_bid_amount;
			$welcome_bonus = $rs->welcome_bonus;
		}
		define('min_deposite', $min_deposite);
		define('max_deposite', $max_deposite);
		define('min_withdrawal', $min_withdrawal);
		define('max_withdrawal', $max_withdrawal);
		define('min_transfer', $min_transfer);
		define('max_transfer', $max_transfer);
		define('min_bid_amount', $min_bid_amount);
		define('max_bid_amount', $max_bid_amount);
		define('welcome_bonus', $welcome_bonus);
		define('device_limit', 50);
    }
	public function checkRequestAuth($app_key,$env_type)
	{
		$db_app_key='';
		if($env_type==1)
		{
			$db_app_key=$this->config->item('app_key');
		}
		if($env_type=='Prod')
		{
			$db_app_key=$this->config->item('production_app_key_app').$this->config->item('production_app_key_server');
		}
		
		if($db_app_key==$app_key && $app_key!='')
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	public function getProductionAppKey()
	{
		$str = $this->config->item('production_app_key_server');
		$arr1 = str_split($str);
		$n=3;
		 $new_str='';
		foreach($arr1 as $x => $val){
		  $assci=ord($val);
		  if($assci >= 97 && $assci <= 122){
			$new_number= $assci + $n;
			if($new_number > 122){
			  $extra=$new_number - 122;
			  $final=96 + $extra;
			  $new_str.= chr($final);
			 }
			else{
			 $new_str.= chr($new_number);
			}
		  } 
		  else{
			$new_number= $assci + $n;
			if($new_number > 90){
			  $extra=$new_number - 90;
			  $final=64 + $extra;
			  $new_str.= chr($final);
			 }
			else{
			  $new_str.= chr($new_number);
			}
		  }
		};
		$new_str= $this->config->item('production_app_key_app').$new_str;
		return $new_str;
	}
	
	
	public function decType($string)
	{
		return $this->encryption->decrypt($string);
	}
	
	public function encType($string)
	{
		return $this->encryption->encrypt($string);
	}
	
	public function randomNumber()
	{
		return mt_rand(100000, 9999999);
	}
	
	public function getOtp($mobile)
	{
		$mobile_array = array("9988554433", "9944332211", "9966332211", "9955332211");

		if (in_array($mobile, $mobile_array))
		{
		  return 1234;
		}
		else
		{
			return rand(1111,9999);
		}
		
		/* return '1234'; */
	}
	public function sendNotification($message,$image,$fcm_device_id,$type,$title,$auth_key) 
	{
		
			$Activity = "true";

				  $msg = [
				 'message' =>$message,
				 'title' => $title,
				 'image' =>  $image,
				 'type' =>  $type,
				 'activity' =>$Activity
				 ] ;

				$registrationIds[] = $fcm_device_id;
				 $fields = [
					'registration_ids' => $registrationIds,
					'data' => $msg
				 ]; 
				 

				 $headers = [
				 'Authorization:key='.$auth_key,
				  'Content-Type: application/json'
				 ]; 
				   $fields = json_encode($fields);
					
				  $ch = curl_init();
				 curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
				 curl_setopt($ch, CURLOPT_POST, true);
				 curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
				curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
				$result = curl_exec($ch); 
				//echo "<pre>";
				//print_r($result);
			
	}
	
	
	public function sendTestNotification($message,$image,$fcm_device_id,$type,$title,$auth_key) 
	{
		
			$Activity = "true";

				  $msg = [
				 'message' =>$message,
				 'title' => $title,
				 'image' =>  $image,
				 'type' =>  $type,
				 'activity' =>$Activity
				 ] ;

				$registrationIds[] = $fcm_device_id;
				 $fields = [
					'registration_ids' => $registrationIds,
					'data' => $msg
				 ]; 
				 

				 $headers = [
				 'Authorization:key='.$auth_key,
				  'Content-Type: application/json'
				 ]; 
				   $fields = json_encode($fields);
					
				  $ch = curl_init();
				 curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
				 curl_setopt($ch, CURLOPT_POST, true);
				 curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
				curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
				$result = curl_exec($ch); 
				echo "<pre>";
				print_r($result);
			
	}
	
	public function replaceSpace($message)
	{
		return str_replace(" ","%20",$message);
	}
	
	public function sendMessage($mobile,$message)
	{
		//$url=('http://alerts.prioritysms.com/api/web2sms.php?workingkey=Ae4b1ddb8a9898e0f75b7d41194992fda&to='.$mobile.'&sender=VFRESH&'.'message='.$message.' DEEPMATKA');
		// $url=('http://2factor.in/API/V1/46882ac9-80b8-11eb-a9bc-0200cd936042/SMS/'.$mobile.'/'.$message);
		$url = ('https://www.fast2sms.com/dev/bulkV2?authorization=ClbnHeWRjPsFYwv4iQ37NfDk6pKo2A0TtMGd5B9hIOaJmrZuE88g6os0nYXzOQe5pv73ctIqmrxPdZK1&route=otp&variables_values=' . $message . '&flash=0&numbers=' . $mobile);
		$result = $this->curl->simple_get($url); 
		return "1";
	}
	public function btcToInrandUsd()
	{
		$url=('https://blockchain.info/ticker');
		$result = $this->curl->simple_get($url); 
		return $result;
	}
	
	public function fileUpload($fileName,$filePath)
	{
		$newfilename = rand() * time();		
		$image_name=$newfilename.'.jpg';
		$decoded_string = base64_decode($fileName);
		$path = $filePath.$image_name;
		$file=fopen($path,'wb');
		$is_written=fwrite($file,$decoded_string);
		fclose($file);
		return $image_name;
	}
	
	function getRandomString($n) 
	{ 
		$characters = '0123456789'; 
		$randomString = '';
		for ($i = 0; $i < $n; $i++) { 
			$index = rand(0, strlen($characters) - 1); 
			$randomString .= $characters[$index]; 
		} 
		return $randomString;
	} 
	function generateReffereslCode($length = 6) 
	{
		$characters = '0123456789';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
    }
	
	function getUserRandomToken($n) 
	{ 
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
		$randomString = '';
		for ($i = 0; $i < $n; $i++) { 
			$index = rand(0, strlen($characters) - 1); 
			$randomString .= $characters[$index]; 
		} 
		return $randomString;
	}
}