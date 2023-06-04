<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Volanlib {
	
	public function __construct() 
	{
		$CI =& get_instance();
		$CI->cur_date = date("Y-m-d");
		$CI->cur_date2 = date("d-M-Y");
		$CI->insert_date = date("Y-m-d H:i:s");
		$CI->ip = $_SERVER['REMOTE_ADDR'];
		$CI->tb2="tb_admin";
		$CI->tb3="tb_user";
		$CI->tb4="tb_admin_bank_detail";
		$CI->tb5="tb_add_fund_request";
		$CI->tb6="tb_state";
		$CI->tb7="tb_district";
		$CI->tb8="tb_user_address";
		$CI->tb9="tb_user_bank_details";
		$CI->tb10="tb_game_rates";
		$CI->tb11="tb_withdraw_fund_request";
		$CI->tb12="tb_notice";
		$CI->tb13="tb_how_to_play";
		$CI->tb14="tb_wallet_trans_history";
		$CI->tb15="tb_fix_values"; 
		$CI->tb16="tb_games";
		/* $CI->tb16="tb_game_name"; */
		$CI->tb17="tb_slider_images";
		$CI->tb18="tb_bid_history";
		$CI->tb19="tb_contact_settings";
		$CI->tb20="tb_user_enquiry";
		$CI->tb21="tb_game_result_history";
		$CI->tb22="tb_user_notification";
		$CI->tb23="tb_tips";
		$CI->tb24="app_setting";
		$CI->tb25="tb_app_link";
		$CI->tb26="tb_single_digit_number";
		$CI->tb27="tb_jodi_digit_numbers";
		$CI->tb28="tb_single_pana_numbers";
		$CI->tb29="tb_tripple_pana_numbers";
		$CI->tb30="tb_half_sangam_numbers";
		$CI->tb31="tb_double_pana_numbers";
		$CI->tb32="tb_full_sangam_numbers";
		
		$CI->tb33="tb_player_ids";
		$CI->tb34="tb_starline_game_rates";
		$CI->tb35="tb_starline_games";
		$CI->tb36="tb_starline_game_result_history";
		$CI->tb37="tb_starline_bid_history";
		$CI->tb38="tb_chat_ques";
		$CI->tb39="tb_chat_msg";
		$CI->tb40="tb_roulette_game";
		$CI->tb41="tb_roulette_bid_history";
		$CI->tb42="tb_roulette_result_hisory";
		
		$CI->tb43="tb_gali_disswar_game_rates";
		$CI->tb44="tb_gali_disswar_games";
		$CI->tb45="tb_gali_disswar_game_result_history";
		$CI->tb46="tb_gali_disswar_bid_history";
		
		$CI->tb47="tb_admin_upi_update_record";
		$CI->tb48="tb_weekday_games";
		$CI->tb49="tb_callback";
		$CI->tb50="tb_auto_deposit";
		$CI->tb51="tb_user_device_record";
		$CI->tb52="tb_referral_bouns";
		$CI->tb53="tb_chat";
		
		
		
		$CI->present_date = date("Y-m-d");
		$CI->insert_date2=date("Y-m-d");
	}
	
		
	function error($msg)
	{
		return "<p class='alert alert-danger'><strong>Error : </strong> ".$msg."</p>";
	}

	function success($msg)
	{
		return "<p class='alert alert-success'>".$msg."</p>";
	}
	
	function uniqRandom($lenght = 7)
	{
		srand ((double) microtime() * 1000000);
		$random = rand();
		$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$num_len=$lenght-2;
		$rand_str = substr(str_shuffle($characters),0,2);
		return $rand_str.substr($random,0,$num_len);
		
	}
	
	function getRandomString($length = 20) 
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
    }


	public function time_ago_in_php($timestamp){
  
	  /* date_default_timezone_set("Asia/Kolkata"); */         
	  $time_ago        = strtotime($timestamp);
	  $current_time    = time();
	  $time_difference = $current_time - $time_ago;
	  $seconds         = $time_difference;
	  
	  $minutes = round($seconds / 60); // value 60 is seconds  
	  $hours   = round($seconds / 3600); //value 3600 is 60 minutes * 60 sec  
	  $days    = round($seconds / 86400); //86400 = 24 * 60 * 60;  
	  $weeks   = round($seconds / 604800); // 7*24*60*60;  
	  $months  = round($seconds / 2629440); //((365+365+365+365+366)/5/12)*24*60*60  
	  $years   = round($seconds / 31553280); //(365+365+365+365+366)/5 * 24 * 60 * 60
					
	  if ($seconds <= 60){

		return "Just Now";

	  } else if ($minutes <= 60){

		if ($minutes == 1){

		  return "one minute ago";

		} else {

		  return "$minutes minutes ago";

		}

	  } else if ($hours <= 24){

		if ($hours == 1){

		  return "an hour ago";

		} else {

		  return "$hours hrs ago";

		}

	  } else if ($days <= 7){

		if ($days == 1){

		  return "yesterday";

		} else {

		  return "$days days ago";

		}

	  } else if ($weeks <= 4.3){

		if ($weeks == 1){

		  return "a week ago";

		} else {

		  return "$weeks weeks ago";

		}

	  } else if ($months <= 12){

		if ($months == 1){

		  return "a month ago";

		} else {

		  return "$months months ago";

		}

	  } else {
		
		if ($years == 1){

		  return "one year ago";

		} else {

		  return "$years years ago";

		}
	  }
	}
	
	
	function sendnotification($to, $title, $message, $img, $type_id)
	{
		
		$logo_path=base_url().'assets/img/logo.png';
		
		$msg = $message;
		$content = array(
			"en" => $msg
		);
		$headings = array(
			"en" => $title
		);
		
		/* echo "<pre>";
		print_r(array($to));die;
		 */
		 
		 $img = base_url().'assets/img/noti_back.jpg'; 
			$fields = array(
				'app_id' => '4c000f57-a9cc-4e5c-bf77-f1c970b3226a',
				"headings" => $headings,
				'include_player_ids' => explode(',',$to),
				//"big_picture" => $img,
				//'include_player_ids' => array($to),
				'large_icon' => "".$logo_path."",
				'content_available' => true,
				'data' => array("type_id" => $type_id),
				'contents' => $content
			);

		
			/* $ios_img = array(
				"id1" => $img
			);
			
			$fields = array(
				'app_id' => '27fd5007-2672-4936-87b6-db87343e97d3',
				"headings" => $headings,
				'include_player_ids' => explode(',',$to),
				'contents' => $content,
				"big_picture" => $img,
				'large_icon' => "".$logo_path."",
				'content_available' => true,
				'data' => array("type_id" => $type_id,'horoscope_type'=>$horoscope_type),
				"ios_attachments" => $ios_img
			); */

		
		
		$headers = array(
			'Authorization: key=ZTIxZjc4YjgtYzIzMi00NzAwLTlkMDMtOTQzZTUxMjNkMjRm',
			'Content-Type: application/json; charset=utf-8'
		);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://onesignal.com/api/v1/notifications');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		$result = curl_exec($ch);
		curl_close($ch);
		//return $result;
		// echo "<pre>";
	//	print_r($result);die; 
		
	}
	
	function encryptMob($plainText) {
        $secretKey = md5(MOB_KEY);
        $iv = substr( hash( 'sha256', "aaaabbbbcccccddddeweee" ), 0, 16 );
        $encryptedText = openssl_encrypt($plainText, 'AES-128-CBC', $secretKey, OPENSSL_RAW_DATA, $iv);
        return base64_encode($encryptedText);
    }

    //Decrypt Function
  function decryptMob($encryptedText) {
        $key = md5(MOB_KEY);
        $iv = substr( hash( 'sha256', "aaaabbbbcccccddddeweee" ), 0, 16 );
        $decryptedText = openssl_decrypt(base64_decode($encryptedText), 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
        return $decryptedText;
    }



	
}