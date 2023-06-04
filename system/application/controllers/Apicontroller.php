<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Apicontroller extends MY_ApiController {

	public function __construct() {
        parent::__construct();
		
    }
	public function generateUserId(){
		
		$user_id=$this->getRandomString(50);
		
		$where=array('user_id'=>$user_id);
			$result=$this->Frontamodel->get_data($this->tb3,$where);
			if(count($result)>0)
			{
				$this->generateUserId();
			}else
			{
				return $user_id;
			}
		
	}
	
	public function apiGetAppKey()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		if($env_type=='1')
		{
			$data_json['app_key']=$this->config->item('app_key');
			$data_json['msg']='Success';
			$data_json['status']=true;
		}
		else if($env_type=='Prod')
		{
			$key=$this->getProductionAppKey();
			$data_json['app_key']=$key;
			$data_json['msg']='Success';
			$data_json['status']=true;
		}
		else
		{
			$data_json['msg']='Error';
			$data_json['status']=false;
		}
		
		echo json_encode($data_json);die;
	}
	
	public function apiGetSocialData()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$result = $this->Frontamodel->getData($this->tb19);
			$telegram='';
			foreach ($result as $rs)
			{
				$phone = $rs->whatsapp_no;
				$telegram = $rs->mobile_2;
				$phone2 = $rs->mobile_1;
			}
			
			$data_json['mobile_no']=$phone;
			$data_json['telegram_no']=$telegram;
			$data_json['mobile_1']=$phone2;
			$data_json['msg']='Success';
			$data_json['status']=true;
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiCheckMobile()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$mobile=$input_data->mobile;
			$mobile_enc=$this->volanlib->encryptMob($mobile);
			$where=array('mobile'=>$mobile_enc);
			$result=$this->Frontamodel->get_data($this->tb3,$where);
			if(count($result)>0)
			{
				$data_json['msg'] = "Mobile number is already registered. Try Login.";
				$data_json['status']=false;
			}
			else
			{
				$otp=$this->getOtp($mobile);
				if($otp!=1234)
				{
					$message=$otp.' use this to complete your registration .Please do not share it to anyone';
					$message=$otp;
					$message=$this->replaceSpace($message);
					$this->sendMessage($mobile,$message);
				}
				$data_json['otp']=$otp;
				$data_json['msg'] = "Mobile number is not registered";
				$data_json['status']="true";
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	
	public function apiValidateBank()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$unique_token=$input_data->unique_token;
			$where=array('unique_token'=>$unique_token);
			$result=$this->Frontamodel->get_data($this->tb3,$where);
			if(count($result)<0)
			{
				$data_json['msg'] = "Mobile number is not found";
				$data_json['status']=false;
			}
			else
			{
				foreach($result as $rs)
				{
					$mobile=$rs->mobile;
				}
				$mobile=$this->volanlib->decryptMob($mobile);
				$otp=$this->getOtp($mobile);
				if($otp!=1234)
				{
					
					$message=$otp;
					$message=$this->replaceSpace($message);
					$this->sendMessage($mobile,$message);
				}
				$data_json['otp']=$otp;
				$data_json['msg'] = "Success";
				$data_json['status']="true";
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	
	public function apiCheckSecurityPin()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$unique_token=$input_data->unique_token;
			$security_pin=$input_data->security_pin;
			$where=array('unique_token'=>$unique_token);
			$result=$this->Frontamodel->get_data($this->tb3,$where);
			$security_pin_db='';
			foreach($result as $rs)
			{
				$security_pin_db=$rs->security_pin;
			}
			
			if($security_pin==$security_pin_db)
			{
				$data_json['msg'] = "Success";
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg'] = "Security Pin is invalid";
				$data_json['status']=false;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function getUserIdFromToken($unique_token)
	{
		$where=array('unique_token'=>$unique_token);
		$result=$this->Frontamodel->get_data_row($this->tb3,$where);
		if($result!='')
		{
			return $result->user_id;
		}
		else
		{
			return 0;
		}
	
	}
	
	public function apiOtpSent()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$mobile=$input_data->mobile;
			$otp=$this->getOtp($mobile);
			if($otp!=1234)
			{
				$message=$otp;
				$message=$otp.' use this to complete your registration .Please do not share it to anyone';
				$message=$this->replaceSpace($message);
				$this->sendMessage($mobile,$message);
			}
			
			$data_json['otp']=$otp;
			$data_json['status']=true;
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiResendOtp()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$mobile=$input_data->mobile;
			
			$otp=$this->getOtp($mobile);
			if($otp!=1234)
			{
				$message=$otp.' use this to complete your registration .Please do not share it to anyone';
				$message=$otp;
				$message=$this->replaceSpace($message);
				$this->sendMessage($mobile,$message);
			}
			
			$data_json['msg']='Otp Re-Sent';
			$data_json['otp']=$otp;
			$data_json['status']=true;
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiUserRegistration()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$name=$input_data->name;
			$email=$input_data->email;
			$mobile=$input_data->mobile;
			$password=$input_data->password;
			$security_pin=$input_data->security_pin;
			$mobile=$this->volanlib->encryptMob($mobile);
				$where = array('mobile' => $mobile);
			
			$result=$this->Frontamodel->get_data($this->tb3,$where);
			if(count($result)>0)
			{
				$data_json['msg'] = "Mobile number is already registered. Try Login.";
				$data_json['status']=false;
			}
			else
			{
			
			$referral_code=isset($input_data->referral_code)?trim($input_data->referral_code):'';
			
			$where_refferal = array('referral_code' => $referral_code);
			$result_sponser = $this->Frontamodel->get_data_row($this->tb3,$where_refferal);
			$reffer_id = 0;
			if($result_sponser != "")
			{
				$reffer_id = $result_sponser->user_id;
				$up_user_name = $result_sponser->user_name;
			}
			
			$code = $this->generateReffereslCode(6);
			
			
			$result = $this->Frontamodel->getData($this->tb15);
			foreach($result as $rs)
			{
				$welcome_bonus = $rs->welcome_bonus;
				$global_batting_status = $rs->global_batting_status;
			}
			$unique_token=$this->getUserRandomToken(30);
			$user_id=$this->generateUserId();
			$userData = array(
					'referral_code' => $code,
					'reffer_id' => $reffer_id,
					'user_id' => $user_id,
					'user_name' => ucwords($name),
					'email' => $email,
					'mobile' => $mobile,
					'password' => $this->encType($password),
					'security_pin' => $security_pin,
					'betting_status' => $global_batting_status,
					'unique_token' => $unique_token,
					'insert_date' => $this->insert_date
				);
			$this->Frontbmodel->insertData($this->tb3,$userData);
			//$user_id = $this->db->insert_id();
			
			$result = $this->Frontamodel->getData($this->tb19);
			foreach ($result as $rs)
			{
				$phone = $rs->mobile_1;
			}
			
			/* $message='A new user registered with mobile number '.$mobile.' on DSL App. Check and approve account.';
			$message=$this->replaceSpace($message);
			$this->sendMessage($phone,$message); */
			
			
			
			$where = array('unique_token'=>$unique_token);
			$data = array ('wallet_balance'=>$welcome_bonus);
			$this->Frontcmodel->update_where($this->tb3,$data,$where);
			
			$request_number = $this->randomNumber();
			$history_data_2 = array(
					'user_id' => $user_id,
					'amount' => $welcome_bonus,
					'transaction_type' => 1,
					'transaction_note' => 'User Welcome Bonus',
					'amount_status' => 6,
					'tx_request_number' => $request_number,
					'insert_date' => $this->insert_date
				);
			$this->Frontbmodel->insertData($this->tb14,$history_data_2);
			
			$data_json['unique_token']=$unique_token;
			$data_json['user_name']=ucwords($name);
			$data_json['mobile']=$mobile;
			$data_json['email']=$email;
			$data_json['msg']='You are successfully register.';
			$data_json['status']=true;	
		 }
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiUserLogin()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$mobile=$input_data->mobile;
			$password=$input_data->password;
			$device_id=$input_data->device_id;
			$mobile=$this->volanlib->encryptMob($mobile);
			$where_array=array('mobile' => $mobile);
			$result = $this->Frontamodel->get_data($this->tb3,$where_array);
			
			$db_pass='';
			if(count($result)>0)
			{
				foreach($result as $rs)
				{
					$unique_token=$rs->unique_token;
					$user_id=$rs->user_id;
					$user_name=$rs->user_name;
					$mobile=$rs->mobile;
					$email=$rs->email;
					$betting_status=$rs->betting_status;
					$security_pin=$rs->security_pin;
					$status=$rs->status;
					$unique_token=$rs->unique_token;
					$notification_status=$rs->notification_status;
					$db_pass=$this->decType($rs->password);
				}
				$result = $this->Frontamodel->getData($this->tb19);
				foreach ($result as $rs)
				{
					$phone = $rs->whatsapp_no;
				}
				if($status==0)
				{
					$data_json['msg']='Account is blocked By admin. Please contact to admin.';
					$data_json['status']=false;
				}
				else
				{
					if ($db_pass!=$password){
					  $data_json['msg'] = "Invalid login details"; 
					  $data_json['status']=false;
					}else{
						$data_json['msg'] = "Login successful.. Redirecting..";
						$data_json['unique_token']=$unique_token;
						$data_json['user_name']=$user_name;
						$mobile=$this->volanlib->decryptMob($mobile);
						$data_json['mobile']=$mobile;
						$data_json['notification_status']=$notification_status;
						$data_json['email']=$email;
						$data_json['mobile_no']=$phone;
						$data_json['betting_status']=$betting_status;
						
						$where = array('user_id' => $user_id,'device_id'=>$device_id);
						$result = $this->Frontamodel->get_data($this->tb51,$where);
						if(count($result)<1)
						{
							$data = array('user_id' => $user_id,'device_id'=>$device_id);
							$this->Frontbmodel->insertData($this->tb51,$data);
							
						}
						$where = array('user_id' => $user_id,'device_id'=>$device_id);
						$up_data=array('logout_status'=>0,'security_pin_status'=>0);
						$this->Frontcmodel->update_where($this->tb51,$up_data,$where);
						
						$data_json['status']=true;
					}
				}
			}
			else
			{
				$data_json['msg']='Mobile not found';
				$data_json['status']=false;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}

	public function apiChangePassword()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$old_pass=$input_data->old_pass;
			$new_pass=$input_data->new_pass;
			$unique_token=$input_data->unique_token;
			$where = array('unique_token' => $unique_token);
			$result = $this->Frontamodel->get_data($this->tb3,$where);
			if(count($result)>0)
			{
				foreach($result as $rs)
				{
					$old_password=$rs->password;
				}
				if($this->decType($old_password) == $old_pass)
				{
					$up_data=array('password'=>$this->encType($new_pass));
					$this->Frontcmodel->update_where($this->tb3,$up_data,$where);
					$data_json['msg']='Password updated successfully.';
					$data_json['status']=true;
				}
				else
				{
					$data_json['msg']='Old password does not matched.';
					$data_json['status']=false;
				}
			}
			else
			{
				$data_json['msg']='Data not found';
				$data_json['status']=false;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	} 
	
	public function apiForgotPassword()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$mobile = $input_data->mobile;
			$new_pass = $input_data->new_pass;
			$mobile=$this->volanlib->encryptMob($mobile);
			$where_array=array('mobile' => $mobile);
			$result = $this->Frontamodel->get_data($this->tb3,$where_array);
			if(count($result) < 1){
				$data_json['msg'] ="This Mobile Number is Not Registered";
				$data_json['status']=false;
			}
			else
			{	
				foreach($result as $rs)
				{
					$unique_token=$rs->unique_token;
				}
				$where = array('unique_token'=>$unique_token);
				$passData = array('password' => $this->encType($new_pass));
				$this->Frontcmodel->update_where($this->tb3,$passData,$where);
				$data_json['status']=true;
				$data_json['msg'] = "Password Successfully Changed.";
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	} 
	
	public function apiForgetCheckmobile()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$mobile=$input_data->mobile;
			$mobile_enc=$this->volanlib->encryptMob($mobile);
			$where=array('mobile'=>$mobile_enc);
			$result=$this->Frontamodel->get_data($this->tb3,$where);
			if(count($result)>0)
			{
				$otp=$this->getOtp($mobile);
				if($otp!=1234)
				{
					$message=$otp.' use this OTP to change your password.Please do not share it to anyone';
					$message=$otp;
					$message=$this->replaceSpace($message);
					$this->sendMessage($mobile,$message);
				}
				$data_json['otp']=$otp;
				$data_json['msg'] = "Mobile number is registered. Try Login.";
				$data_json['status']=True;
			}
			else
			{
				$data_json['msg'] = "Mobile number is not registered";
				$data_json['status']=false;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiAdminBankDetails()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$select="ac_holder_name,account_number,ifsc_code,upi_payment_id,google_upi_payment_id,phonepay_upi_payment_id";
			$bank_details=$this->Frontamodel->getDataSelect($this->tb4,$select);
			
			if(count($bank_details)>0)
			{
				$data_json['bank_details']=$bank_details;
				$data_json['msg'] = "Admin Bank Detail";
				$data_json['status']=True;
			}
			else
			{
				$data_json['bank_details']=$bank_details;
				$data_json['msg'] = "Data Not Found";
				$data_json['status']=false;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiFundRequestAdd()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$unique_token=$input_data->unique_token;
			$request_amount=$input_data->request_amount;
			$request_number = $this->randomNumber();
			
			$user_id=$this->getUserIdFromToken($unique_token);
			$fund_request_data = array(
						'user_id'=> $user_id,
						'request_amount' => $request_amount,
						'request_number' => $request_number,
						'insert_date' => $this->insert_date
					);
			$this->Frontbmodel->insertData($this->tb5,$fund_request_data);
			$fund_request_id = $this->db->insert_id();
			
			$data_json['msg']='Request Successfully Added';
			$data_json['fund_request_id']=$fund_request_id;
			$data_json['status']=true;
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiLastFundRequestDetail()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$unique_token = $input_data->unique_token;
			
			$user_id=$this->getUserIdFromToken($unique_token);
			
			$by = 'fund_request_id';
			$limit=1;
			$select = "fund_request_id,request_amount,request_number,request_status,date_format(insert_date,'%d %b %Y') as insert_date";
			$where = array('user_id'=>$user_id,'request_status'=>0);
			$result = $this->Frontamodel->get_trend_post($this->tb5,$where,$select,$by,$limit);
			if(count($result)> 0)
			{
				$data_json['last_req_detail'] = $result;
				$data_json['min_amt'] = min_deposite;
				$data_json['max_amt'] = max_deposite;
				$data_json['status']=true;
			}else {
				$data_json['last_req_detail'] = $result;
				$data_json['min_amt'] = min_deposite;
				$data_json['max_amt'] = max_deposite;
				$data_json['status']=false;
			}
			
			$data_json['google_upi_option'] = 1;
			$data_json['phone_upi_option'] = 1;
			$data_json['other_upi_option'] = 1;
			
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	
	
	public function apiFundPaymentSlipUpload()
	{
		if($_POST)
		{
			$app_key=trim($this->input->post('app_key'));
			
			if($this->checkRequestAuth($app_key,$env_type)!=0)
			{
				$fund_request_id=$this->input->post('fund_request_id');
				
				if($fund_request_id != '')
				{
					$file='';
					$path = 'uploads/file/';
					$front_status=1;
					if(isset($_FILES['payment_slip']['name']) && $_FILES['payment_slip']['name']!='blank.jpg' )
					{
						$ext = substr($_FILES['payment_slip']['name'], strrpos($_FILES['payment_slip']['name'], '.') + 1);
						if($ext=="jpeg" || $ext=="jpg" || $ext=="png")
						{
							$file=$this->volanimage->upload_image($path,$_FILES['payment_slip']);
						}
						else
						{
							$front_status=0;
						}
					}
				
					if($front_status != 0) 
					{
						$where = array('fund_request_id'=> $fund_request_id);
						$payment_receipt_data = array(
								'fund_payment_receipt' =>$file,
							);
						$this->Frontcmodel->update_where($this->tb5,$payment_receipt_data,$where);
						
						$result = $this->Frontamodel->get_data_row($this->tb5,$where);
						if($result != '')
						{
							$request_status = $result->request_status;
						}
						$data_json['request_status'] = $request_status;
						$data_json['msg'] = "Payment Slip Uploded Successfully.";
						$data_json['status']=true;
					} else {
						$data_json['msg']='File type invalid';
						$data_json['status']=false;
					}
				}else {
					$data_json['msg']='Fund Request ID Not Available';
					$data_json['status']=false;
				}
			}
			else
			{
				$data_json['msg']='UnAuthorized request';
				$data_json['status']=false;
			}
			echo json_encode($data_json);
		}
	}
	
	public function apiGetState()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$by = 'state_name';
			$result = $this->Frontamodel->getDataLatest($this->tb6,$by);
			if(count($result)>0)
			{
				$data_json['states'] = $result;
				$data_json['status'] = true;
			}else{
				$data_json['states'] = $result;
				$data_json['status'] = false;
			} 
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiGetDistrict()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$state_id = $input_data->state_id;
			$where = array('state_id'=>$state_id,'status !=' =>0);
			$by = 'district_name';
			$result = $this->Frontamodel->getDataLatestWhere($this->tb7,$where,$by);
			if(count($result)>0)
			{
				$data_json['district'] = $result;
				$data_json['status'] = true;
			}else{
				$data_json['district'] = $result;
				$data_json['status'] = false;
			} 
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiAddUserAddress()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$unique_token = $input_data->unique_token;
			$state_id = $input_data->state_id;
			$district_id = $input_data->district_id;
			$flat_ploat_no = $input_data->flat_ploat_no;
			$address_lane_1 = $input_data->address_lane_1;
			$address_lane_2 = $input_data->address_lane_2;
			$area = $input_data->area;
			$pin_code = $input_data->pin_code;
			
			$user_id=$this->getUserIdFromToken($unique_token);
			
			$userAddData = array(
					'user_id' => $user_id,
					'flat_ploat_no' =>$flat_ploat_no,
					'address_lane_1' => $address_lane_1,
					'address_lane_2' => $address_lane_2,
					'area' => $area,
					'pin_code' => $pin_code,
					'state_id' => $state_id,
					'district_id' => $district_id,
					'insert_date' => $this->insert_date
				);
			$where = array('user_id'=>$user_id);
			$result=$this->Frontamodel->get_data($this->tb8,$where);
			
			if(count($result)>0){
				$this->Frontcmodel->update_where($this->tb8,$userAddData,$where);
				$data_json['msg']='Address updated successfully.';
				$data_json['status']=true;
			}else {
				$this->Frontbmodel->insertData($this->tb8,$userAddData);
				$address_id = $this->db->insert_id();
				$data_json['msg']='Your Address successfully register.';
				$data_json['status']=true;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiGetUserAddress()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$unique_token = $input_data->unique_token;
			$where = array('unique_token'=>$unique_token);
			$joins = array(
				array(
					'table' => $this->tb6,
					'condition' => $this->tb6.'.state_id = '.$this->tb8.'.state_id',
					'jointype' => 'LEFT'
				),
				array(
					'table' => $this->tb7,
					'condition' => $this->tb7.'.district_id = '.$this->tb8.'.district_id',
					'jointype' => 'LEFT'
				)
			);
			
			$columns = 'state_name,district_name,'.$this->tb8.'.state_id,'.$this->tb8.'.district_id,flat_ploat_no,
			address_lane_1,address_lane_2,area,pin_code';
			$result = $this->Frontamodel->get_joins_where($this->tb8,$columns,$joins,$where);
			if(count($result)>0){
				$data_json['user_address'] = $result;
				$data_json['msg'] = 'User Address Detail';
				$data_json['status'] = true;
			}else{
				$data_json['user_address'] = $result;
				$data_json['msg'] = 'Address Not Added Yet';
				$data_json['status'] = false;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiAddUserBankDetails()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$unique_token = $input_data->unique_token;
			$bank_name = $input_data->bank_name;
			$branch_address = $input_data->branch_address;
			$ac_holder_name = $input_data->ac_holder_name;
			$ac_number = $input_data->ac_number;
			$ifsc_code = $input_data->ifsc_code;
			
			$user_id=$this->getUserIdFromToken($unique_token);
			
			$userBankData = array(
					'user_id' => $user_id,
					'bank_name' =>ucwords($bank_name),
					'branch_address' => $branch_address,
					'ac_holder_name' => ucwords($ac_holder_name),
					'ac_number' => $ac_number,
					'ifsc_code' => $ifsc_code,
					'insert_date' => $this->insert_date
				);
			$where = array('user_id'=>$user_id);
			$result=$this->Frontamodel->get_data($this->tb9,$where);
			
			if(count($result)>0){
				$this->Frontcmodel->update_where($this->tb9,$userBankData,$where);
				$data_json['msg']='Bank Detail updated successfully.';
				$data_json['status']=true;
			}else {
				$this->Frontbmodel->insertData($this->tb9,$userBankData);
				$bank_id = $this->db->insert_id();
				$data_json['bank_id'] = $bank_id;
				$data_json['msg']='Bank Detail successfully register.';
				$data_json['status']=true;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiAddUserUpiDetails()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$unique_token = $input_data->unique_token;
			$upi_type = $input_data->upi_type;
			$paytm_no = $input_data->paytm_no;
			$google_pay_no = $input_data->google_pay_no;
			$phon_pay_no = $input_data->phon_pay_no;
			
			
			$user_id=$this->getUserIdFromToken($unique_token);
			
			if($upi_type == 1)
			{
				$where = array('user_id'=>$user_id);
				$result=$this->Frontamodel->get_data($this->tb9,$where);
				
				$upi_data = array (
					'user_id' => $user_id,
					'paytm_number'=>$paytm_no,
					'insert_date' => $this->insert_date
					);
				
				if(count($result)>0)
				{
					$this->Frontcmodel->update_where($this->tb9,$upi_data,$where);
					$data_json['msg']='Paytm Number updated successfully.';
					$data_json['status']=true;
				}
				else
				{
					$this->Frontbmodel->insertData($this->tb9,$upi_data);
					$data_json['msg']='Paytm Number successfully register.';
					$data_json['status']=true;
				}
			}
			else if($upi_type == 2)
			{
				$where = array('user_id'=>$user_id);
				$result=$this->Frontamodel->get_data($this->tb9,$where);
				
				$upi_data = array (
					'user_id' => $user_id,
					'google_pay_number'=>$google_pay_no,
					'insert_date' => $this->insert_date
					);
				
				if(count($result)>0)
				{
					$this->Frontcmodel->update_where($this->tb9,$upi_data,$where);
					$data_json['msg']='Google Pay Number updated successfully.';
					$data_json['status']=true;
				}
				else
				{
					$this->Frontbmodel->insertData($this->tb9,$upi_data);
					$data_json['msg']='Google Pay Number successfully register.';
					$data_json['status']=true;
				}
			}
			else if($upi_type == 3)
			{
				$where = array('user_id'=>$user_id);
				$result=$this->Frontamodel->get_data($this->tb9,$where);
				
				$upi_data = array (
					'user_id' => $user_id,
					'phone_pay_number'=>$phon_pay_no,
					'insert_date' => $this->insert_date
					);
				
				if(count($result)>0)
				{
					$this->Frontcmodel->update_where($this->tb9,$upi_data,$where);
					$data_json['msg']='PhonePe Number updated successfully.';
					$data_json['status']=true;
				}
				else
				{
					$this->Frontbmodel->insertData($this->tb9,$upi_data);
					$data_json['msg']='PhonePe Number successfully register.';
					$data_json['status']=true;
				}
			}else {
				$data_json['msg']='This UPI Type Is Not Valid';
				$data_json['status']=false;
			}
			
			
			/* $where = array('user_id'=>$user_id);
				$result=$this->Frontamodel->get_data($this->tb9,$where);
				
				$upi_data = array (
					'user_id' => $user_id,
					'phone_pay_number'=>$phon_pay_no,
					'google_pay_number'=>$google_pay_no,
					'paytm_number'=>$paytm_no,
					'insert_date' => $this->insert_date
					);
				
				if(count($result)>0)
				{
					$this->Frontcmodel->update_where($this->tb9,$upi_data,$where);
					$data_json['msg']='UPI Number updated successfully.';
					$data_json['status']=true;
				}
				else
				{
					$this->Frontbmodel->insertData($this->tb9,$upi_data);
					$data_json['msg']='UPI Number updated successfully.';
					$data_json['status']=true;
				} */
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiGetUserPaymentDetails()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$unique_token = $input_data->unique_token;
			
			$user_id=$this->getUserIdFromToken($unique_token);
			$where = array('user_id'=>$user_id);
			$select='ac_holder_name,paytm_number,google_pay_number,phone_pay_number,insert_date';
			$result=$this->Frontamodel->get_data_select($this->tb9,$where,$select);
			if(count($result)>0){
				$data_json['payment_details'] = $result;
				$data_json['msg'] = 'User Payment Detail';
				$data_json['status'] = true;
			}else{
				$data_json['payment_details'] = $result;
				$data_json['msg'] = 'Payment Detail Not Added Yet';
				$data_json['status'] = false;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiGameRates()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$result=$this->Frontamodel->getData($this->tb10);
			if(count($result)>0){
				$data_json['game_rates'] = $result;
				$data_json['msg'] = 'Game Rates';
				$data_json['status'] = true;
			}else{
				$data_json['game_rates'] = $result;
				$data_json['msg'] = 'Game Rates Not Added Yet';
				$data_json['status'] = false;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiFundRequestHistory()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$unique_token = $input_data->unique_token;
			$path = base_url().'uploads/file/';
			$where = array('unique_token'=>$unique_token,'request_status!='=>0,);
			$select = "fund_request_id,request_amount,request_number,request_status,concat('$path',fund_payment_receipt) as fund_payment_receipt,date_format(insert_date,'%d %b %Y') as insert_date";
			$by = 'fund_request_id';
			$type = 'desc';
			$result = $this->Frontamodel->get_data_select_type($this->tb5,$where,$select,$by,$type);
			if(count($result)>0)
			{
				$data_json['fund_req_history'] = $result;
				$data_json['msg'] = 'Fund Request History Data';
				$data_json['status'] = true;
			}else {
				$data_json['fund_req_history'] = $result;
				$data_json['msg'] = 'Data Not Available';
				$data_json['status'] = false;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
    public function apiUserWalletBalance()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$unique_token = $input_data->unique_token;
			$where = array('unique_token'=>$unique_token);
			$result = $this->Frontamodel->get_data_row($this->tb3,$where);
			if($result!='')
			{
				$data_json['wallet_amt'] = $result->wallet_balance;
				$data_json['hold_amt'] = $result->hold_amount;
				$data_json['transfer_point_status'] = $result->transfer_point_status;

			}
			
			
			
			$result = $this->Frontamodel->getData($this->tb15);
			foreach ($result as $rs)
			{
				$data_json['min_withdrawal'] = $rs->min_withdrawal;
				$data_json['max_withdrawal'] = $rs->max_withdrawal;
				$data_json['min_transfer'] = $rs->min_transfer;
				$data_json['max_transfer'] = $rs->max_transfer;
				$data_json['withdraw_open_time'] = date('h:i A',strtotime($rs->withdraw_open_time));
				$data_json['withdraw_close_time'] = date('h:i A',strtotime($rs->withdraw_close_time));
			}
			
			$data_json['msg'] = 'User Wallet Balance';
			$data_json['status'] = true;
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiCheckUserForTransferAmt()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$mobile_no = $input_data->mobile_no;
			$mobile_enc=$this->volanlib->encryptMob($mobile_no);
			$where = array('mobile'=>$mobile_enc);
			$result = $this->Frontamodel->get_data_row($this->tb3,$where);
			if($result!='')
			{
				$data_json['user_name'] = $result->user_name;
				$data_json['msg'] = 'Account found ';
				$data_json['status'] = true;
			}else {
				$data_json['user_name'] = '';
				$data_json['msg'] = 'Account not found ';
				$data_json['status'] = false;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiUserTransferWalletBalance()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$unique_token = $input_data->unique_token;
			$mobile_no = $input_data->mobile_no;
			$amount = $input_data->amount;
			$transfer_note = $input_data->transfer_note;
			
			$where = array('unique_token'=>$unique_token);
			$result = $this->Frontamodel->get_data_row($this->tb3,$where);
			if($result!='')
			{
				$user_wallet_amt = $result->wallet_balance;
				$sender_user_name = $result->user_name;
			}
			
			if($user_wallet_amt < $amount)
			{
				$data_json['msg']= 'Sorry, Your Transfer Amount Is Greater Then Your Wallet Balance';
				$data_json['status']=false;
			}else{
				$new_wallet_amt = $user_wallet_amt - $amount;
				$user_new_balance = array('wallet_balance'=>$new_wallet_amt);
				$this->Frontcmodel->update_where($this->tb3,$user_new_balance,$where);
				
				$mobile_enc=$this->volanlib->encryptMob($mobile_no);
				$where = array ('mobile'=>$mobile_enc);
				$result = $this->Frontamodel->get_data_row($this->tb3,$where);
				if($result!='')
				{
					$user_wallet_amt = $result->wallet_balance;
					$reciever_user_id = $result->user_id;
					$user_name = $result->user_name;
				}
				$user_wallet_amt += $amount;
				$user_balance = array('wallet_balance'=>$user_wallet_amt);
				$this->Frontcmodel->update_where($this->tb3,$user_balance,$where);
				$request_number = $this->randomNumber();
				
				$user_id=$this->getUserIdFromToken($unique_token);
				
				$history_data = array(
						'user_id' => $user_id,
						'amount' => $amount,
						'transaction_type' => 2,
						'transaction_note' => 'Amount Transfer To '.$user_name,
						'transfer_note' => $transfer_note,
						'amount_status' => 3,
						'tx_request_number' => $request_number,
						'insert_date' => $this->insert_date
				);
				$this->Frontbmodel->insertData($this->tb14,$history_data);
				
				$history_data_2 = array(
						'user_id' => $reciever_user_id,
						'amount' => $amount,
						'transaction_type' => 1,
						'transaction_note' => 'Amount Received From '.$sender_user_name,
						'transfer_note' => $transfer_note,
						'amount_status' => 4,
						'tx_request_number' => $request_number,
						'insert_date' => $this->insert_date
				);
				$this->Frontbmodel->insertData($this->tb14,$history_data_2);
				
				$this->giveMoneyToReferral($user_id,$amount);
				
				$data_json['msg']= 'Amount Successfully Transferred';
				$data_json['status']= true;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiUserPaymentMethodList()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$unique_token=$input_data->unique_token;
			
			$user_id=$this->getUserIdFromToken($unique_token);
			$where = array('user_id'=>$user_id);
			$result = $this->Frontamodel->get_data($this->tb9,$where);
			if(count($result)>0)
			{
				foreach($result as $rs)
				{
					$ac_number = $rs->ac_number;
					$paytm = $rs->paytm_number;
					$google_pay = $rs->google_pay_number;
					$phone_pay = $rs->phone_pay_number;
				}
				$arry=array();
				if($ac_number!='')
				{
					$arry[]=array('type'=>1,'value'=>$ac_number,'name'=>"Account number");
				}
				if($paytm!='')
				{
					$arry3[]=array('type'=>2,'value'=>$paytm,'name'=>"PayTM");
					$arry=array_merge($arry,$arry3);
				}
					
				if($google_pay!='')
				{
					$arry4[]=array('type'=>3,'value'=>$google_pay,'name'=>"Google Pay");
					$arry=array_merge($arry,$arry4);
				}
				if($phone_pay!='')
				{
					$arry6[]=array('type'=>4,'value'=>$phone_pay,'name'=>"PhonePe");
					$arry=array_merge($arry,$arry6);
				}
				$data_json['result']=$arry;
				$data_json['min_amt']=min_withdrawal;
				$data_json['msg']='User Payment Method List';
				$data_json['status']=true;
			}else {
				$data_json['result']=$result;
				$data_json['min_amt']=max_withdrawal;
				$data_json['msg']='User Payment Method Not Added Yet';
				$data_json['status']=false;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiUserWithdrawFundRequest()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$unique_token=$input_data->unique_token;
			$request_amount=$input_data->request_amount;
			$payment_method=$input_data->payment_method;
			
			$user_id=$this->getUserIdFromToken($unique_token);
			
			$result = $this->Frontamodel->getData($this->tb15);
			foreach ($result as $rs)
			{
				$saat = new DateTime(); 
		
				$open = new DateTime( $saat->format('Y-m-d ').$rs->withdraw_open_time);
				$withdraw_close_time = new DateTime( $saat->format('Y-m-d ').$rs->withdraw_close_time);
				
				
			}
			if (($saat > $open) && ($saat < $withdraw_close_time)) 
			{
				$where = array('user_id'=>$user_id);
				$result = $this->Frontamodel->get_data_row($this->tb3,$where);
				if($result!='')
				{
					$user_wallet_amt = $result->wallet_balance;
				}
				
				$result = $this->Frontamodel->get_data_row($this->tb9,$where);
				if($result!='')
				{
					$bank_name = $result->bank_name;
					$branch_address = $result->branch_address;
					$ac_holder_name = $result->ac_holder_name;
					$ac_number = $result->ac_number;
					$ifsc_code = $result->ifsc_code;
					$paytm_number = $result->paytm_number;
					$google_pay_number = $result->google_pay_number;
					$phone_pay_number = $result->phone_pay_number;
				}
				
				if($user_wallet_amt < $request_amount)
				{
					$data_json['msg']= 'Sorry, You Dont Have Sufficient Amount For Withdraw';
					$data_json['status']=false;
				}else{
					$request_number = $this->randomNumber();
					/*if($payment_method == 1)
					{
						$withdraw_request_data = array(
							'user_id'=> $user_id,
							'request_amount' => $request_amount,
							'request_number' => $request_number,
							'payment_method' => $payment_method,
							'bank_name' => $bank_name,
							'branch_address' => $branch_address,
							'ac_holder_name' => $ac_holder_name,
							'ac_number' => $ac_number,
							'ifsc_code' => $ifsc_code,
							'insert_date' => $this->insert_date
						);
					}else*/ if($payment_method == 2)
					{
						$withdraw_request_data = array(
							'user_id'=> $user_id,
							'request_amount' => $request_amount,
							'request_number' => $request_number,
							'payment_method' => $payment_method,
							'paytm_number' => $paytm_number,
							'insert_date' => $this->insert_date
						);
					}else if($payment_method == 3)
					{
						$withdraw_request_data = array(
							'user_id'=> $user_id,
							'request_amount' => $request_amount,
							'request_number' => $request_number,
							'payment_method' => $payment_method,
							'google_pay_number' => $google_pay_number,
							'insert_date' => $this->insert_date
						);
					}else if($payment_method == 4)
					{
						$withdraw_request_data = array(
							'user_id'=> $user_id,
							'request_amount' => $request_amount,
							'request_number' => $request_number,
							'payment_method' => $payment_method,
							'phone_pay_number' => $phone_pay_number,
							'insert_date' => $this->insert_date
						);
					}
					$this->Frontbmodel->insertData($this->tb11,$withdraw_request_data);
					$withdraw_request_id = $this->db->insert_id();
					
					$current_balance = $user_wallet_amt - $request_amount;
					
					$amountData = array(
						'wallet_balance' => $current_balance,
						'hold_amount'=>$request_amount
					);
					
					$where = array('user_id'=>$user_id);
					$this->Frontcmodel->update_where($this->tb3,$amountData,$where);
					
					$data_json['msg']='Withdraw Request Successfully Submitted';
					$data_json['fund_request_id']=$withdraw_request_id;
					$data_json['status']=true;
				}
			}
			else
			{
				$data_json['msg']= 'Sorry, You can Withdraw only in given withdraw time';
				$data_json['status']=false;
			}
			
			
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiGetProfile()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$unique_token=$input_data->unique_token;
			$where = array('unique_token'=>$unique_token);
			
			$select='mobile,wallet_balance,email,user_name';
			$result=$this->Frontamodel->get_data_select($this->tb3,$where,$select);
			if(count($result)>0)
			{
				foreach($result as $rs)
				{
					$rs->mobile=$this->volanlib->decryptMob($rs->mobile);
				}
				$data_json['profile']=$result;
				$data_json['msg']='User Profile Data.';
				$data_json['status']=true;
			}else{
				$data_json['profile']=$result;
				$data_json['msg']='User ID is not valid.';
				$data_json['status']=false;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiGetNotices()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$current_date = date('Y-m-d');
			$result = $this->Frontamodel->getData($this->tb19);
			foreach ($result as $rs)
			{
				$phone = $rs->whatsapp_no;
			}
			$type = 'desc';
			$by = 'notice_id';
			$where = array('status !='=>0,'notice_date <='=>$current_date);
			$select = "notice_title,notice_msg,date_format(notice_date,'%d %b %Y') as notice_date,date_format(insert_date,'%d %b %Y %r') as insert_date";
			$result=$this->Frontamodel->get_data_select_type($this->tb12,$where,$select,$by,$type);
			if(count($result)>0)
			{
				$data_json['notices']=$result;
				$data_json['mobile_no']=$phone;
				$data_json['msg']='Notice Data.';
				$data_json['status']=true;
			}else{
				$data_json['notices']=$result;
				$data_json['mobile_no']=$phone;
				$data_json['msg']='Data Not Found.';
				$data_json['status']=false;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiProfileUpdate()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$unique_token=$input_data->unique_token;
			$user_name=$input_data->user_name;
			$email=$input_data->email;
			
			if($email != '')
				{
					$where=array('email'=>$email,'unique_token!='=>$unique_token);
					$result=$this->Frontamodel->get_data($this->tb3,$where);
					if(count($result)>0){
						$data_json['msg']='This email already exist';
						$data_json['status']=false;
					}else{
						$userData = array(
							'user_name' => ucwords($user_name),
							'email' => $email,
						);
						$where = array('unique_token'=>$unique_token);
						$this->Frontcmodel->update_where($this->tb3,$userData,$where);
						$data_json['msg']='Your Profile Successfully Updated.';
						$data_json['status']=true;
					}
				}	
				else
				{
						$userData = array(
							'user_name' => ucwords($user_name),
							'email' => '',
						);
						$where = array('unique_token'=>$unique_token);
						$this->Frontcmodel->update_where($this->tb3,$userData,$where);
						$data_json['msg']='Your Profile Successfully Updated.';
						$data_json['status']=true;
				}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiHowToPlay()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$select = "how_to_play_content,video_link";
			$result=$this->Frontamodel->getDataSelect($this->tb13,$select);
			if(count($result)>0)
			{
				$data_json['content']=$result;
				$data_json['msg']='Content Available.';
				$data_json['status']=true;
			}else{
				$data_json['content']=$result;
				$data_json['msg']='Content Not Available.';
				$data_json['status']=false;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiWalletTransactionHistory()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$unique_token=$input_data->unique_token;
			
			$user_id=$this->getUserIdFromToken($unique_token);
			
			$where = array('user_id'=>$user_id);
			$result = $this->Frontamodel->get_data_row($this->tb3,$where);
			if($result!='')
			{
				$data_json['wallet_amt'] = $result->wallet_balance;
				$data_json['hold_amt'] = $result->hold_amount;
			}
			$select = "transaction_id,amount,transaction_type,transaction_note,transfer_note,amount_status,
			date_format(insert_date,'%d %b %Y %r') as insert_date,tx_request_number";
			$by = 'transaction_id';
			$type = 'desc';
			$allresult = $this->Frontamodel->get_data_select_type($this->tb14,$where,$select,$by,$type);
			$where_array = array('user_id'=>$user_id,'transaction_type'=>1);
			$inresult = $this->Frontamodel->get_data_select_type($this->tb14,$where_array,$select,$by,$type);
			$where_type = array('user_id'=>$user_id,'transaction_type'=>2);
			$outresult = $this->Frontamodel->get_data_select_type($this->tb14,$where_type,$select,$by,$type);
			if(count($allresult)>0)
			{
				$data_json['transaction_history'] = $allresult;
				$data_json['in_history'] = $inresult;
				$data_json['out_history'] = $outresult;
				$data_json['msg'] = 'Wallet Trasaction History';
				$data_json['status'] = true;
			}else {
				$data_json['transaction_history'] = $allresult;
				$data_json['in_history'] = $inresult;
				$data_json['out_history'] = $outresult;
				$data_json['msg'] = 'Wallet Trasaction History Data Not Available';
				$data_json['status'] = false;
			}
				$result = $this->Frontamodel->getData($this->tb15);
			foreach ($result as $rs)
			{
				$data_json['withdraw_open_time'] = date('h:i A',strtotime($rs->withdraw_open_time));
				$data_json['withdraw_close_time'] = date('h:i A',strtotime($rs->withdraw_close_time));
			}
			
			$where_array = array('user_id'=>$user_id);
			$by='id';
			$limit=device_limit;
			$device_result = $this->Frontamodel->get_data_desc($this->tb51,$where_array,$by,$limit);
			$data_json['device_result']=$device_result;
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiViewWalletTransactionHistory()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$unique_token=$input_data->unique_token;
			$transaction_id=$input_data->transaction_id;
			
			$user_id=$this->getUserIdFromToken($unique_token);
			$where = array($this->tb14.'.user_id'=>$user_id,'transaction_id'=>$transaction_id);
			
			$result = $this->Frontamodel->get_data_row($this->tb14,$where);
			if($result != '')
			{
				$amount_status = $result->amount_status;
				if($amount_status == 1)
				{
					$path = base_url().'uploads/file/';
					$joins = array(
							array(
								'table'=>$this->tb5,
								'condition'=> $this->tb5.'.request_number = '.$this->tb14.'.tx_request_number',
								'jointype' =>'LEFT'
							)
						);
					$columns = "amount,transaction_type,transaction_note,transfer_note,tx_request_number,amount_status,concat('$path',fund_payment_receipt) as fund_payment_receipt,date_format(".$this->tb14.".insert_date,'%d %b %Y %r') as insert_date";
					$transaction_Data = $this->Frontamodel->get_joins_where($this->tb14,$columns,$joins,$where);
				}else if($amount_status == 2)
				{
					$path = base_url().'uploads/file/';
					$joins = array(
							array(
								'table'=>$this->tb11,
								'condition'=> $this->tb11.'.request_number = '.$this->tb14.'.tx_request_number',
								'jointype' =>'LEFT'
							)
						);
					$columns = "amount,transaction_type,transaction_note,transfer_note,tx_request_number,amount_status,concat('$path',payment_receipt) as payment_receipt,date_format(".$this->tb14.".insert_date,'%d %b %Y %r') as insert_date,payment_method,bank_name,branch_address,ac_holder_name,ac_number,ifsc_code,paytm_number,google_pay_number,phone_pay_number,concat('$path',payment_receipt) as payment_receipt,remark";
					$transaction_Data = $this->Frontamodel->get_joins_where($this->tb14,$columns,$joins,$where);
				}else if($amount_status == 3 || $amount_status == 4 || $amount_status == 6 || $amount_status == 8)
				{
					$select = "amount,transaction_type,transaction_note,transfer_note,amount_status,date_format(insert_date,'%d %b %Y %r') as insert_date,tx_request_number";
					$transaction_Data = $this->Frontamodel->get_data_select($this->tb14,$where,$select);
				}else if($amount_status == 5)
				{
					$joins = array(
							array(
								'table'=>$this->tb18,
								'condition'=> $this->tb18.'.bid_tx_id = '.$this->tb14.'.tx_request_number',
								'jointype' =>'LEFT'
							)
						);
					$columns = "amount,transaction_type,transaction_note,transfer_note,tx_request_number,amount_status,
					date_format(".$this->tb14.".insert_date,'%d %b %Y %r') as insert_date,game_name,pana,session,digits,
					closedigits,bid_date";
					$transaction_Data = $this->Frontamodel->get_joins_where($this->tb14,$columns,$joins,$where);
				}
				
				if(count($transaction_Data)>0)
				{
					$data_json['transaction_Data'] = $transaction_Data;
					$data_json['msg'] = 'Wallet Trasaction Data';
					$data_json['status'] = true;
				}else {
					$data_json['transaction_Data'] = $transaction_Data;
					$data_json['msg'] = 'Trasaction Data Not Available';
					$data_json['status'] = false;
				}
			}else {
				$data_json['msg'] = 'Something Is Wrong Please Check';
				$data_json['status'] = false;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiUserWithdrawTransactionHistory()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$path = base_url().'uploads/file/';
			$unique_token=$input_data->unique_token;
			
			$user_id=$this->getUserIdFromToken($unique_token);
			$where = array('user_id'=>$user_id);
			$select = "withdraw_request_id,request_amount,request_number,request_status,payment_method,bank_name,
			branch_address,ac_holder_name,ac_number,ifsc_code,paytm_number,google_pay_number,phone_pay_number,remark,concat('$path',payment_receipt) as payment_receipt,date_format(insert_date,'%d %b %Y %r') as insert_date";
			$by = 'withdraw_request_id';
			$type = 'desc';
			$withdrawdata = $this->Frontamodel->get_data_select_type($this->tb11,$where,$select,$by,$type);
			
			$request_status = '';
			$by = 'withdraw_request_id';
			$limit=1;
			$select = "request_status";
			$result = $this->Frontamodel->get_trend_post($this->tb11,$where,$select,$by,$limit);
			if(count($result)>0)
			{
				foreach($result as $rs)
				{
					$request_status = $rs->request_status;
				}
			}
			
			$result = $this->Frontamodel->getData($this->tb15);
			foreach ($result as $rs)
			{
				$data_json['withdraw_open_time'] = date('h:i A',strtotime($rs->withdraw_open_time));
				$data_json['withdraw_close_time'] = date('h:i A',strtotime($rs->withdraw_close_time));
			}
			
			
			
			
			
			if(count($withdrawdata)>0)
			{
				$data_json['withdrawdata'] = $withdrawdata;
				$data_json['last_request_status'] = $request_status;
				$data_json['msg'] = 'Withdraw Trasaction Data';
				$data_json['status'] = true;
			}else {
				$data_json['withdrawdata'] = $withdrawdata;
				$data_json['last_request_status'] = $request_status;
				$data_json['msg'] = 'Withdraw Trasaction Data Not Available';
				$data_json['status'] = false;
			}
			
			$result = $this->Frontamodel->get_data_row($this->tb3,$where);
			if($result!='')
			{
				$data_json['wallet_amt'] = $result->wallet_balance;
			}else {
				$data_json['wallet_amt'] = '';
			}
			
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function getMsgAccordingToTimeRoulette($open_time,$close_time)
	{
		$cur_time = new DateTime(); 
		
			$open = new DateTime( $cur_time->format('Y-m-d ').$open_time);

		  $close = new DateTime($cur_time->format('Y-m-d ').$close_time);

			if (($cur_time >= $open) && ($cur_time <= $close)) {
				$data['msg']= 'Market Running';
				$data['msg_status']= 1;
			}else{
				$data['msg']= 'Betting is closed for today';
				$data['msg_status']= 2;
			}
			return $data;
	}
	
	
	public function getMsgAccordingToTimeRouletteActive($open_time,$close_time)
	{
		$cur_time = new DateTime(); 
		
			$open = new DateTime( $cur_time->format('Y-m-d ').$open_time);

		  $close = new DateTime($cur_time->format('Y-m-d ').$close_time);

			if (($cur_time >= $open) && ($cur_time <= $close)) {
				$data['msg']= 'Betting is running for today';
				$data['msg_status']= 1;
			}else{
				$data['msg']= 'Betting will open soon';
				$data['msg_status']= 2;
			}
			return $data;
	}
	
	public function getMsgAccordingToTime($open_time,$close_time)
	{
		$saat = new DateTime(); 
		
			$open = new DateTime( $saat->format('Y-m-d ').$open_time);

		  $close = new DateTime($saat->format('Y-m-d ').$close_time);

			//if (($saat >= $open) && ($saat <= $close)) {
			if ($saat <= $close) {
				$data['msg']= 'Market Running';
				$data['msg_status']= 1;
			}else{
				$data['msg']= 'Market Closed';
				$data['msg_status']= 2;
			}
			return $data;
	}
	
	public function getMsgAccordingToOpenTime($open_time)
	{
		$saat = new DateTime(); 
		
			$open = new DateTime( $saat->format('Y-m-d ').$open_time);


			//if (($saat >= $open) && ($saat <= $close)) {
			if ($saat < $open) {
				$data['msg']= 'Market Running';
				$data['msg_status']= 1;
			}else{
				$data['msg']= 'Market Closed';
				$data['msg_status']= 2;
			}
			return $data;
	}
	
	
	public function apiGetDashboardData()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			
			
			$unique_token=$input_data->unique_token;
			
			$player_id=isset($input_data->player_id)?trim($input_data->player_id):'';
			
			$user_id=$this->getUserIdFromToken($unique_token);
			
			$where_array = array('player_id'=>$player_id);
			$result = count($this->Frontamodel->get_data($this->tb33,$where_array));
			if($result==0){
				$player_data=array('user_id'=>$user_id,'player_id'=>$player_id);
				$this->Frontbmodel->insertData($this->tb33,$player_data);
			}else {
				$player_data=array('user_id'=>$user_id,'player_id'=>$player_id);
				$this->Frontcmodel->update_where($this->tb33,$player_data,$where_array);
			}
			
			
			$where = array('user_id'=>$user_id);
			$user_data = array(
				'last_update'=>$this->insert_date
				);
			$this->Frontcmodel->update_where($this->tb3,$user_data,$where);
			
			$ref_admin_result = $this->Frontamodel->getDataRow($this->tb52);
			if($ref_admin_result!='')
			{
				$referral_first_bonus = $ref_admin_result->referral_first_bonus;
				$referral_first_bonus_max = $ref_admin_result->referral_first_bonus_max;
				$referral_second_bonus = $ref_admin_result->referral_second_bonus;
				$referral_second_bonus_max = $ref_admin_result->referral_second_bonus_max;
			}
			
			$app_data = $this->Frontamodel->getData($this->tb25);
			if(count($app_data)>0)
			{
				foreach($app_data as $rs)
				{
					$data_json['app_link'] = $rs->app_link;
					$data_json['share_msg'] = $rs->content;
					$data_json['share_referral_content'] = $rs->share_referral_content;
					
					$data_json['display_referral_content'] = 'Share your referral code with your friends/ family to get awesome referral bonus. '.$referral_first_bonus.'% on first deposit(upto '.$referral_first_bonus_max.') and '.$referral_second_bonus.'% on next deposits(upto '.$referral_second_bonus_max.').
Do not wait now and share your referral code now. ';
				}
			}else {
				$data_json['app_link'] = '';
				$data_json['share_msg'] = '';
			}
			
			$result = $this->Frontamodel->getData($this->tb15);
			foreach ($result as $rs)
			{
				$saat = new DateTime(); 
		
				$open = new DateTime( $saat->format('Y-m-d ').$rs->withdraw_open_time);
				$withdraw_close_time = new DateTime( $saat->format('Y-m-d ').$rs->withdraw_close_time);
				
				if (($saat > $open) && ($saat < $withdraw_close_time)) 
				{
					$data_json['withdraw_status'] = 1;
				}
				else
				{
					$data_json['withdraw_status'] = 0;
				}
					$data_json['app_maintainence_msg'] = $rs->app_maintainence_msg;
					$data_json['maintainence_msg_status'] = $rs->maintainence_msg_status;
			}
			
			
			$version_data = $this->Frontamodel->getData($this->tb24);
			if(count($version_data)>0)
			{
				foreach($version_data as $rs)
				{
					$data_json['user_current_version'] = $rs->user_current_version;
					$data_json['user_minimum_version'] = $rs->user_minimum_version;
					$data_json['pop_status'] = $rs->pop_status;
					$data_json['message'] = $rs->message;
					$data_json['link'] = $rs->link;
					$data_json['link_btn_text'] = $rs->link_btn_text;
					$data_json['action_type'] = $rs->action_type;
					$data_json['action_btn_text'] = $rs->action_btn_text;
					$data_json['app_date'] = date('d M Y',strtotime($rs->app_date));
				}
			}
			
			
			$result = $this->Frontamodel->get_data_row($this->tb3,$where);
			if($result!='')
			{
				$data_json['wallet_amt'] = $result->wallet_balance;
				$data_json['user_name'] = $result->user_name;
				$mobile=$this->volanlib->decryptMob($result->mobile);
				$data_json['mobile'] = $mobile;
				$data_json['transfer_point_status'] = $result->transfer_point_status;
				$data_json['betting_status'] = $result->betting_status;
				$data_json['account_block_status'] = $result->status;
					$data_json['referral_code'] = $result->referral_code;
			}else {
				$data_json['wallet_amt'] = '';
				$data_json['betting_status'] = '';
				$data_json['transfer_point_status'] = '';
				$data_json['account_block_status'] = '';
				$data_json['referral_code'] = '';
				$data_json['mobile'] ='';
				$data_json['user_name'] = '';


			}
			
			
			$result = $this->Frontamodel->getData($this->tb19);
			$telegram='';
			foreach ($result as $rs)
			{
				$phone = $rs->whatsapp_no;
				$telegram = $rs->mobile_2;
				$phone2 = $rs->mobile_1;
			}

			
		
					$open = strtotime(date('Y-m-d H:i:s'));
					$close = strtotime(date('Y-m-d 08:00:00'));
					
				/* $open = new DateTime( $saat->format('Y-m-d H:i:s'));
				$close = new DateTime( $saat->format('Y-m-d 08:00:00')); */
				//echo "<pre>"; print_r($open);die;
				if ($open > $close)
				{
					$date=date('Y-m-d');
				}	
				else
				{
					$date = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 day'));

				}
			
			$joins = array(
					array(
						'table' => $this->tb21,
							'condition' => $this->tb21.'.game_id = '.$this->tb16.'.game_id && result_date="'.$date.'"',
						'jointype' => 'LEFT'
					)
				);
			$columns = ''.$this->tb16.'.game_id,game_name,game_name_hindi,open_time,open_time_sort,close_time,market_status,open_number,close_number,
			open_decleare_status,close_decleare_status';
			$where=array('status'=>1);
			$by='open_time_sort';
			$result = $this->Frontamodel->get_joins_where_asc($this->tb16,$columns,$joins,$where,$by);
			//echo "<pre>";print_r($result);die;
			foreach($result as $rs)
			{
				$game_id = $rs->game_id;
				$open_number = $rs->open_number;
				
				$rs->game_name_letter=substr($rs->game_name,0,1);

				$close_number=$rs->close_number;
				$open_decleare_status=$rs->open_decleare_status;
				$close_decleare_status=$rs->close_decleare_status;
				
				$where_array_time = array('game_id'=>$game_id,'name'=>date('l'));
				$game_day_result = $this->Frontamodel->get_data_row($this->tb48,$where_array_time);
				//echo "<pre>";print_r($game_day_result);die;
				if($game_day_result!='')
				{
					 $rs->open_time= $game_day_result->open_time;
					 $rs->open_time_sort= $game_day_result->open_time_sort;
					 $rs->close_time= $game_day_result->close_time;
					 $rs->market_status= $game_day_result->weekday_status;
					 
				}
				
				if($rs->market_status==0){
					$rs->msg='Market closed';
					$rs->msg_status=2;
				}else{
					$data=$this->getMsgAccordingToTime($rs->open_time,$rs->close_time);
					$rs->msg=$data['msg'];
					$rs->msg_status=$data['msg_status'];
				}
				
				
				if($rs->open_number!=''){
					$open_num=$rs->open_number[0]+$rs->open_number[1]+$rs->open_number[2];
					if($open_num<10){
						$rs->open_result=$open_number.'-'.$open_num;
					}else if($open_num>9){
						$rs->open_result=$open_number.'-'.$open_num%10;
					}
				}else{
					$rs->open_result='';
				}
				
				if($rs->close_number!=''){
					$close_num=$rs->close_number[0]+$rs->close_number[1]+$rs->close_number[2];
					
					if($close_num<10){
						$rs->close_result=$close_num.'-'.$close_number;
					}else if($close_num>9){
						$close_res = $close_num%10;
						$rs->close_result=$close_res.'-'.$close_number;
					}
				}else{
					$rs->close_result='';
				}
				
				$cur_time = new DateTime(); 
		
				$start_date = new DateTime(date("H:i:s"));
				$since_start = $start_date->diff(new DateTime(date("H:i:s",strtotime($rs->open_time))));
				

				$hour=$since_start->h;
				$min=$since_start->i;
				$sec=$since_start->s+$min*60+($hour*60*60);
				
				$rs->open_duration=$sec*1000;
				
				$start_date = new DateTime(date("H:i:s"));
				$since_close = $start_date->diff(new DateTime(date("H:i:s",strtotime($rs->close_time))));
				

				$hour=$since_close->h;
				$min=$since_close->i;
				$sec=$since_close->s+$min*60+($hour*60*60);
				
				$rs->close_duration=$sec*1000;
				
				
				$rs->time_srt=strtotime($rs->open_time_sort);
				$rs->close_time_srt=strtotime($rs->close_time);
				
				//$rs->hour=$hour;
				
				unset($rs->market_status);
				unset($rs->open_number);
				unset($rs->close_number);
				unset($rs->open_decleare_status);
				unset($rs->close_decleare_status);
				
				$rs->web_chart_url=base_url().'game-result-chart/'.$rs->game_id;
			}
			
			
		
			
			 $open_time_sort = array_column($result, 'time_srt');

			array_multisort($open_time_sort, SORT_ASC, $result);
			
		//usort($result, '$this->date_compare');
		
			$where_array = array('user_id'=>$user_id);
			$by='id';
			$limit=device_limit;
			$device_result = $this->Frontamodel->get_data_desc($this->tb51,$where_array,$by,$limit);
			
			$data_json['device_result'] = $device_result;
			
			$data_json['result'] = $result;
			$data_json['mobile_no']=$phone;
			$data_json['telegram_no']=$telegram;
			$data_json['mobile_1']=$phone2;
			$data_json['msg'] = 'Success';
			$data_json['status'] = true;
			
			$current_date = date('Y-m-d');
			$result = $this->Frontamodel->getData($this->tb19);
			foreach ($result as $rs)
			{
				$phone = $rs->whatsapp_no; 
			}
			$where = array('status !='=>0,'notice_date <='=>$current_date);
			$select = "notice_title,notice_msg,date_format(notice_date,'%d %b %Y') as notice_date,date_format(insert_date,'%d %b %Y %r') as insert_date";
			$result=$this->Frontamodel->get_data_select($this->tb12,$where,$select);
			$data_json['notice_count']=count($result);

			$select2 = "msg,date_format(insert_date,'%d %b %Y %r') as insert_date";
			$by2 = 'id';
			$type2 = 'desc';
			$where2 = array('is_seen'=>0,'user_id'=>$user_id);
			
			$result2 = $this->Frontamodel->get_data_select_type($this->tb22,$where2,$select2,$by2,$type2);
			
			$data_json['notification_count']=count($result2);
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	
	function date_compare($a, $b)
	{
		$t1 = strtotime($a['open_time_sort']);
		$t2 = strtotime($b['open_time_sort']);
		return $t1 - $t2;
	}    
	
	public function apiGetSliderImages()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$path = base_url().'uploads/file/slider_image/';
			$where = array('status' =>1);
			$select = "image_id,concat('$path',slider_image) as slider_image";
			$by = 'display_order';
			$type = 'asc';
			$result = $this->Frontamodel->get_data_select_type($this->tb17,$where,$select,$by,$type);
			if(count($result)>0)
			{
				$data_json['sliderdata'] = $result;
				$data_json['msg'] = 'Slider Images Data';
				$data_json['status'] = true;
			}else {
				$data_json['sliderdata'] = $result;
				$data_json['msg'] = 'Data Not Available';
				$data_json['status'] = false;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiGetCurrentDate()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$unique_token = $input_data->unique_token;
			$game_id = $input_data->game_id;
			
			$where = array('unique_token'=>$unique_token);
			$result = $this->Frontamodel->get_data_row($this->tb3,$where);
			if($result!='')
			{
				$data_json['wallet_amt'] = $result->wallet_balance;
			}
			$result = $this->Frontamodel->getData($this->tb15);
			foreach ($result as $rs)
			{
				$data_json['min_bid_amount'] = $rs->min_bid_amount;
				$data_json['max_bid_amount'] = $rs->max_bid_amount;
				$data_json['min_deposite'] = $rs->min_deposite;
				$data_json['max_deposite'] = $rs->max_deposite;
				$data_json['min_withdrawal'] = $rs->min_withdrawal;
				$data_json['max_withdrawal'] = $rs->max_withdrawal;
				$data_json['min_transfer'] = $rs->min_transfer;
				$data_json['max_transfer'] = $rs->max_transfer;
			}
			$date = date('D d-M-Y');
			$new_date = date('d-M-Y');
			$data_json['date']= $date;
			$data_json['new_date']= $new_date;
			
			
			
			$where = array('game_id'=>$game_id);
			
			$select = 'open_time,close_time';
			$result = $this->Frontamodel->get_data_select($this->tb16,$where,$select);
			$min=0;
			$sec=0;
			$web_time=0;
			foreach($result as $rs)
			{
				$cur_time = new DateTime(); 
		
				$start_date = new DateTime(date("H:i:s"));
				$since_start = $start_date->diff(new DateTime(date("H:i:s",strtotime($rs->open_time))));
				

				$hour=$since_start->h;
				$min=$since_start->i;
				$sec=$since_start->s+$min*60+($hour*60*60);
				$open_sec=$sec-60;
				
				$start_date = new DateTime(date("H:i:s"));
				$since_start2 = $start_date->diff(new DateTime(date("H:i:s",strtotime($rs->close_time))));
				

				$hour2=$since_start2->h;
				$min2=$since_start2->i;
				$sec2=$since_start2->s+$min2*60+($hour2*60*60);
				$close_sec=$sec2-60;
				
			}
			
			$data_json['open_duration']=$open_sec*1000;
			$data_json['close_duration']=$close_sec*1000;
			
			$data_json['status']=true;
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function checkGameStatus($open_time,$close_time)
	{
		$saat = new DateTime(); 
		
		$open = new DateTime( $saat->format('Y-m-d ').$open_time);
		$close = new DateTime($saat->format('Y-m-d ').$close_time);

		//if (($saat >= $open) && ($saat <= $close)) {
		if (($saat <= $close)) {
			$data['msg']= 'Betting Is Running.';
			$data['game_status']= 1;
			$data['status']= true;
		}else{
			$data['msg']= 'Sorry Betting Is Closed';
			$data['game_status']= 2;
			$data['status']= false;
		}
		return $data;
	}
	
	
	
	public function checkGameOpenStatus($open_time)
	{
		$saat = new DateTime(); 
		
		$open = new DateTime( $saat->format('Y-m-d ').$open_time);

		//if (($saat >= $open) && ($saat <= $close)) {
		if (($saat < $open)) {
			$data['msg']= 'Betting Is Running.';
			$data['game_status']= 1;
			$data['status']= true;
		}else{
			$data['msg']= 'Sorry Betting Is Closed';
			$data['game_status']= 2;
			$data['status']= false;
		}
		return $data;
	}
	
	
	
	
	public function checkGameStatusForBid($open_time,$close_time,$session)
	{
		$saat = new DateTime(); 
		
		$open = new DateTime( $saat->format('Y-m-d ').$open_time);
		$close = new DateTime($saat->format('Y-m-d ').$close_time);

		//if (($saat >= $open) && ($saat <= $close)) {
			
		if($session=='Open' && ($saat > $open))
		{
			$data['msg']= 'Sorry Open session for this Betting Is Closed';
			$data['game_status']= 2;
			$data['status']= false;
		}			
		else if (($saat <= $close)) {
			$data['msg']= 'Betting Is Running.';
			$data['game_status']= 1;
			$data['status']= true;
		}else{
			$data['msg']= 'Betting Closed for close Session ';
			$data['game_status']= 2;
			$data['status']= false;
		}
		
		return $data;
	}
	
	public function apiCheckGamesActiveInactive()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$game_id=$input_data->game_id;
			$where = array('game_id'=>$game_id);
			
			$select = 'open_time,close_time';
			$result = $this->Frontamodel->get_data_select($this->tb16,$where,$select);
			foreach($result as $rs)
			{
				$data=$this->checkGameStatus($rs->open_time,$rs->close_time);
				$rs->msg=$data['msg'];
				$rs->game_status=$data['game_status'];
				$rs->status=$data['status'];
			}
			
			$data_json['result'] = $result; 
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiSubmitBid()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$new_result = $input_data->new_result;
			$json_result1 = json_decode(json_encode($new_result,true));
			$unique_token = $json_result1->unique_token;
			$game_id = $json_result1->gameid;
			$Gamename = $json_result1->Gamename;
			$pana = $json_result1->pana;
			$bid_date = $json_result1->bid_date;
			$totalbit = $json_result1->totalbit;
			$session = $json_result1->session;
			$bid_result = $json_result1->result;
			
			$where = array('unique_token'=>$unique_token);
			$result = $this->Frontamodel->get_data_row($this->tb3,$where);
			if($result!='')
			{
				$user_wallet_amt = $result->wallet_balance;
			}
			
		$where_array_time = array('game_id'=>$game_id,'name'=>date('l'));
		$select = 'open_time,close_time,weekday_status';
			$result = $this->Frontamodel->get_data_select($this->tb48,$where_array_time,$select);
			foreach($result as $rs)
			{
			    	if($rs->weekday_status==0)
						{
							$data_json['msg']= 'Sorry Betting Is Closed';
							$data_json['game_status']= 2;
							$data_json['status']= false;
							echo json_encode($data_json);die;
						}
						
				$data=$this->checkGameStatusForBid($rs->open_time,$rs->close_time,$session);
				$game_status=$data['game_status'];
				
				if($game_status == 1)
				{
				  if($pana=='Jodi Digit' or $pana=='Full Sangam' or $pana=='Half Sangam')
				  {					  
					$saat = new DateTime(); 
		
						$open = new DateTime( $saat->format('Y-m-d ').$rs->open_time);
							
						if(($saat > $open))
						{
							$data_json['msg']= 'Sorry Betting Is Closed';
							$data_json['game_status']= 2;
							$data_json['status']= false;
							echo json_encode($data_json);die;
						}
				  }
				}
				$msg=$data['msg'];
			}
			
			if($game_status == 1)
			{
				$json_result = json_decode(json_encode($bid_result,true));
				$totalbit=0;
				foreach($json_result as $result)
				{
					$totalbit=$totalbit+$result->points;
				}
				
				foreach($json_result as $result)
				{
					$session = $result->session;
					$digits = $result->digits;
					$closedigits = $result->closedigits;
					$points = $result->points;
					
					$pana = $json_result1->pana;
					
					if($pana == 'SpDpTpMotors')
					{
						$pana = $result->pana;
					}
					else
					{
						$pana = $pana;
					}
					if($totalbit<0)
					{
						$data_json['msg'] = "Sorry something went wrong";
						$data_json['status'] = false;
					}
					else
					{
					
						if($user_wallet_amt >= $totalbit)
						{
							$com_date=date('Y-m-d',strtotime($bid_date));
							$cur_date=date('Y-m-d');
							if($com_date==$cur_date)
							{
								if($pana=='सिंगल डिजिट')
								{
									$pana='Single Digit';
								}
								else if($pana=='सिंगल पाना')
								{
									$pana='Single Pana';
								}
								else if($pana=='डबल पाना')
								{
									$pana='Double Pana';
								}
								else if($pana=='ट्रिपल पाना')
								{
									$pana='Triple Pana';
								}
								else if($pana=='हाफ संगम')
								{
									$pana='Half Sangam';
								}
								else if($pana=='फुल संगम')
								{
									$pana='Full Sangam';
								}
								
								$request_number = $this->randomNumber();
								
								$user_id=$this->getUserIdFromToken($unique_token);
								
								$bid_data = array(
										'user_id'=>$user_id,
										'game_id'=>$game_id,
										'game_name'=>$Gamename,
										'pana'=>$pana,
										'session'=>$session,
										'digits'=>$digits,
										'closedigits'=>$closedigits,
										'points'=>$points,
										'bid_date'=>date('Y-m-d',strtotime($bid_date)),
										'bid_tx_id' => $request_number,
										'insert_date'=>$this->insert_date
									);
								
								$wallet_amt = $user_wallet_amt - $totalbit;
								$where = array('unique_token'=>$unique_token);
								$wallet_data = array('wallet_balance'=>$wallet_amt);
								$this->Frontcmodel->update_where($this->tb3,$wallet_data,$where);
								
								$this->Frontbmodel->insertData($this->tb18,$bid_data);
								
								$history_data_2 = array(
										'user_id' => $user_id,
										'amount' => $points,
										'transaction_type' => 2,
										'transaction_note' => 'Bid Placed For '.$Gamename.'('.$pana.')',
										'amount_status' => 5,
										'tx_request_number' => $request_number,
										'insert_date' => $this->insert_date
								);
								$this->Frontbmodel->insertData($this->tb14,$history_data_2);
								
								$data_json['msg'] = "Bid Successfully Submitted";
								$data_json['status'] = true;
							  }
							  else 
							  {
								$data_json['msg'] = "Sorry, back date bidding is not allowed. Your account can be blocked for this.";
								$data_json['status'] = false;
							   }
							
						}else {
							$data_json['msg'] = "Sorry You Don't Have Sufficient Amount For This Bid";
							$data_json['status'] = false;
						}
					}
				}
			}else {
				/* $data_json['msg'] = 'Sorry Betting Closed For Today'; */
				$data_json['msg'] = $msg;
				$data_json['status'] = false; 
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiBidHistoryData()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$unique_token = $input_data->unique_token;
			$bid_from = $input_data->bid_from;
			$bid_to = $input_data->bid_to;
			
			$user_id=$this->getUserIdFromToken($unique_token);
			
			$select = "game_name,pana,session,digits,closedigits,points,bid_tx_id,
			date_format(insert_date,'%d %b %Y %r') as bid_date";
			$by = 'bid_id';
			$type = 'desc';
			
			if($bid_from == '' && $bid_to == '')
			{
				$today = $this->insert_date;
				$today_date = date('Y-m-d',strtotime($today));
				$where = array('user_id'=>$user_id,'bid_date'=>$today_date);
			}else {
				$date_from = date('Y-m-d',strtotime($bid_from));
				$date_to = date('Y-m-d',strtotime($bid_to));
				$where = array('user_id'=>$user_id,'bid_date >='=>$date_from,'bid_date <='=>$date_to);			
			}
			$result = $this->Frontamodel->get_data_select_type($this->tb18,$where,$select,$by,$type);
			
			if(count($result)>0)
			{
				$data_json['bid_data'] = $result;
				$data_json['msg'] = 'Bid History Data Available';
				$data_json['status'] = true;
			}else {
				$data_json['bid_data'] = $result;
				$data_json['msg'] = 'Bid History Data Not Available';
				$data_json['status'] = false;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiGetContactDetails()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$result = $this->Frontamodel->getData($this->tb19);
			
			if(count($result)>0)
			{
				foreach($result as $rs)
				{
					$data_json['mobile_1'] = $rs->mobile_1;
					$data_json['mobile_2'] = $rs->mobile_2;
					$data_json['whatsapp_no'] = $rs->whatsapp_no;
					$data_json['email_1'] = $rs->email_1;
					$data_json['email_2'] = $rs->email_2;
					$data_json['facebook'] = $rs->facebook;
					$data_json['twitter'] = $rs->twitter;
					$data_json['youtube'] = $rs->youtube;
					$data_json['google_plus'] = $rs->google_plus;
					$data_json['instagram'] = $rs->instagram;
				}
				$data_json['msg'] = 'Contact Data Available';
				$data_json['status'] = true;
			}else {
				$data_json['msg'] = 'Contact Data Not Available';
				$data_json['status'] = false;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiSubmitContactUs()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$user_name = $input_data->user_name;
			$mobile = $input_data->mobile;
			$email = $input_data->email;
			$enquiry = $input_data->enquiry;
			$contactData = array(
				'user_name' => ucwords($user_name),
				'mobile' =>$mobile,
				'email' => $email,
				'enquiry' => $enquiry,
				'insert_date' => $this->insert_date
			);
			$this->Frontbmodel->insertData($this->tb20,$contactData);
			$data_json['msg']='Successfully Submitted. Please Wait For The Response';
			$data_json['status']=true;
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
public function apiWiningHistoryData() 
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$unique_token = $input_data->unique_token;
			$date_from = $input_data->date_from;
			$date_to = $input_data->date_to;
			
			$user_id=$this->getUserIdFromToken($unique_token);
			
			$select = "amount,transaction_type,transaction_note,amount_status,tx_request_number,
			date_format(insert_date,'%d %b %Y %r') as wining_date";
			$by = 'transaction_id';
			$type = 'desc';
			
			if($date_from == '' && $date_to == '')
			{
				$today = $this->insert_date;
				$today_date = date('Y-m-d',strtotime($today));
				$where = array($this->tb14.'.user_id'=>$user_id,'DATE('.$this->tb14.'.insert_date)'=>$today_date,'amount_status'=>8);
			}else {
				$date_from = date('Y-m-d',strtotime($date_from));
				$date_to = date('Y-m-d',strtotime($date_to));
				$where = array($this->tb14.'.user_id'=>$user_id,'DATE('.$this->tb14.'.insert_date) >='=>$date_from,'DATE('.$this->tb14.'.insert_date) <='=>$date_to,'amount_status'=>8);			
			}
			
			$joins = array(
							array(
								'table'=>$this->tb18,
								'condition'=> $this->tb18.'.bid_tx_id = '.$this->tb14.'.bid_tx_id',
								'jointype' =>'LEFT'
							)
						);
					$columns = "amount,transaction_type,transaction_note,amount_status,tx_request_number,
			date_format(".$this->tb14.".insert_date,'%d %M %y %h:%i') as wining_date,game_name,pana,session,digits,closedigits";
					$result = $this->Frontamodel->get_joins_where_desc($this->tb14,$columns,$joins,$where,$by);
					
					//echo "<pre>";print_r($result);die;
			
			//$result = $this->Frontamodel->get_data_select_type($this->tb14,$where,$select,$by,$type);
			
			if(count($result)>0)
			{
				$data_json['win_data'] = $result;
				$data_json['msg'] = 'Wining History Data Available';
				$data_json['status'] = true;
			}else {
				$data_json['win_data'] = $result;
				$data_json['msg'] = 'Wining History Data Not Available';
				$data_json['status'] = false;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiGetNotification() 
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$unique_token = $input_data->unique_token;
			
			$user_id=$this->getUserIdFromToken($unique_token);
			
			$select = "msg,date_format(insert_date,'%d %b %Y %r') as insert_date";
			$by = 'id';
			$type = 'desc';
			$where = array('is_seen'=>0,'user_id'=>$user_id);
			$wheren = array('user_id'=>$user_id);
			
			$result = $this->Frontamodel->get_data_select_type($this->tb22,$wheren,$select,$by,$type);
			
			$this->Frontamodel->updateSetDataIsSeen($this->tb22,$where,'is_seen',1);

			if(count($result)>0)
			{
				$data_json['notification'] = $result;
				$data_json['msg'] = 'Notification Data Available';
				$data_json['status'] = true;
			}else {
				$data_json['notification'] = $result;
				$data_json['msg'] = 'Notification Data Not Available';
				$data_json['status'] = false;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiGetTipsList()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$path = base_url().'uploads/file/';
			$where = array ('status'=>1);
			$select = "tips_id,title,concat('$path',banner_image) as banner_image,date_format(insert_date,'%d %b %Y') as insert_date";
			$result=$this->Frontamodel->get_data_select($this->tb23,$where,$select);
			if(count($result)>0)
			{
				$data_json['tips']=$result;
				$data_json['msg']='Notice Data.';
				$data_json['status']=true;
			}else{
				$data_json['msg']='Data Not Found.';
				$data_json['status']=false;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiViewTipsDetails()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$tips_id = $input_data->tips_id;
			$path = base_url().'uploads/file/';
			$where = array ('tips_id'=>$tips_id,'status'=>1);
			$select = "title,concat('$path',banner_image) as banner_image,description,date_format(insert_date,'%d %b %Y') as insert_date";
			$result=$this->Frontamodel->get_data_select($this->tb23,$where,$select);
			if(count($result)>0)
			{
				$data_json['tipsDetails']=$result;
				$data_json['msg']='Tips Data.';
				$data_json['status']=true;
			}else{
				$data_json['msg']='Data Not Found.';
				$data_json['status']=false;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiGetAppVersionDetails()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$result = $this->Frontamodel->getData($this->tb24);
			if(count($result)>0)
			{
				$data_json['versionDetails']=$result;
				$data_json['msg']='App Version Data.';
				$data_json['status']=true;
			}else{
				$data_json['msg']='Data Not Found.';
				$data_json['status']=false;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiCheckGameStatus()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$game_id=$input_data->game_id;
			$unique_token=$input_data->unique_token;
			$user_id=$this->getUserIdFromToken($unique_token);
		//	$where = array('game_id'=>$game_id);
			
			//$select = 'open_time,close_time';
		//	$result = $this->Frontamodel->get_data_select($this->tb16,$where,$select);
	$select = 'open_time,close_time,weekday_status';
			$where_array_time = array('game_id'=>$game_id,'name'=>date('l'));
			$result = $this->Frontamodel->get_data_select($this->tb48,$where_array_time,$select);
			foreach($result as $rs)
			{
			    if ($rs->weekday_status==0 )
				{
					$data_json['msg']= 'Sorry Betting Is closed.';
					$data_json['game_status']= 2;
					$data['status']= false;
				}
				else
				{
    				$saat = new DateTime(); 
    		
    				$open = new DateTime( $saat->format('Y-m-d ').$rs->open_time);
    				
    				if (($saat > $open)) 
    				{
    					$data_json['msg']= 'Sorry Betting Is closed.';
    					$data_json['game_status']= 2;
    					$data['status']= false;
    				}
    				else{
    					$data_json['msg']= 'Betting Is Open';
    					$data_json['game_status']= 1;
    					$data_json['status']= true;
    				}
				}
			}
			
			$where_array = array('user_id'=>$user_id);
			$by='id';
			$limit=device_limit;
			$device_result = $this->Frontamodel->get_data_desc($this->tb51,$where_array,$by,$limit);
			$data_json['device_result']= $device_result;
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	
	public function apiNotificationSetting()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$unique_token=$input_data->unique_token;
			$notification_status=$input_data->notification_status;
			
			$where = array('unique_token'=>$unique_token);
			$data = array ('notification_status'=>$notification_status);
			$this->Frontcmodel->update_where($this->tb3,$data,$where);
			$data_json['msg']= 'Notification setting successfully updated';
			$data_json['status']= true;
			
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	
	public function apiGetStatement()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$unique_token=$input_data->unique_token;
			$date_from=$input_data->date_from;
			$date_to=$input_data->date_to;
			
			$user_id=$this->getUserIdFromToken($unique_token);
			
			$date_from = date('Y-m-d',strtotime($date_from));
			$date_to = date('Y-m-d',strtotime($date_to));
			$where = array('user_id'=>$user_id,'DATE(insert_date) >='=>$date_from,'DATE(insert_date) <='=>$date_to);			
			
			$select = "transaction_id,amount,transaction_type,transaction_note,transfer_note,amount_status,
			date_format(insert_date,'%d %b %Y %r') as insert_date,tx_request_number";
			$by = 'transaction_id';
			$type = 'desc';
			$allresult = $this->Frontamodel->get_data_select_type($this->tb14,$where,$select,$by,$type);
			if(count($allresult)>0)
			{
				$data_json['transaction_history'] = $allresult;
				$data_json['msg'] = 'Wallet Trasaction History';
				$data_json['status'] = true;
			}else {
				$data_json['transaction_history'] = $allresult;
				$data_json['msg'] = 'Wallet Trasaction History Data Not Available';
				$data_json['status'] = false;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	
	public function apiAddMoneyViaUpi()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$unique_token=$input_data->unique_token;
			$amount=$input_data->amount;
			$txn_id=$input_data->txn_id;
			$txn_ref=$input_data->txn_ref;	
			
			$user_id=$this->getUserIdFromToken($unique_token);
			
			$upigpay=isset($input_data->upigpay)?trim($input_data->upigpay):'';			
			$upiphonepe=isset($input_data->upiphonepe)?trim($input_data->upiphonepe):'';			
			$otherupi=isset($input_data->otherupi)?trim($input_data->otherupi):'';	
			$paid_upi=isset($input_data->paid_upi)?trim($input_data->paid_upi):'';	


				
			
			if($upigpay==1 or $upiphonepe==1)
			{
				
				$where = array('user_id'=>$user_id);
				$result = $this->Frontamodel->get_data_row($this->tb3,$where);
				$wallet_amt=0;
				if($result!='')
				{
					$wallet_amt = $result->wallet_balance;
					$reffer_id = $result->reffer_id;
				}
			
			
				$new_wallet_amt = $wallet_amt + $amount;
				$user_new_balance = array('wallet_balance'=>$new_wallet_amt);
				$this->Frontcmodel->update_where($this->tb3,$user_new_balance,$where);

				$request_number = $this->randomNumber();
				$history_data_2 = array(
					'user_id' => $user_id,
					'amount' => $amount,
					'transaction_type' => 1,
					'transaction_note' => 'Points added via UPI Tx ID '.$txn_id,
					'amount_status' => 19,
					'tx_request_number' => $request_number,
					'txn_id' => $txn_id,
					'txn_ref' => $txn_ref,
					
					'insert_date' => $this->insert_date
				);
				$this->Frontbmodel->insertData($this->tb14,$history_data_2);
				
				$data_json['msg'] = 'Points Added Successfully';
				$data_json['status'] = true;
				
				if($upigpay==1)
				{
					$payment_method='Google Pay';
				}
				if($upiphonepe==1)
				{
					$payment_method='Phone Pe';
				}
				
				
				$request_number = $this->randomNumber();
				$history_data_2 = array(
					'user_id' => $user_id,
					'amount' => $amount,
					'tx_request_number' => $request_number,
					'txn_id' => $txn_id,
					'txn_ref' => $txn_ref,
					'payment_method' => $payment_method,
					'paid_upi' => $paid_upi,
					'fund_status' => 1,
					'deposit_type' => 1,
					'insert_date' => $this->insert_date
				);
				$this->Frontbmodel->insertData($this->tb50,$history_data_2);
				
				$result = $this->Frontamodel->getData($this->tb19);
				foreach ($result as $rs)
				{
					$phone = $rs->mobile_1;
				}
				///$phone=8387998048;
				$where=array('user_id'=>$user_id);
				$result = $this->Frontamodel->get_data_row($this->tb3,$where);
				if($result!='')
				{
					$user_name = $result->user_name;
					$mobile = $result->mobile;
					
					
					
				}
				
				/* $message='New Auto-Deposit Request('.$request_number.') Processed from '.$user_name.'-'.$mobile.' for '.$amount.'.';
				
				$message=$this->replaceSpace($message);
				$this->sendMessage($phone,$message); */
			}
			else
			{
			
				$request_number = $this->randomNumber();
				$history_data_2 = array(
					'user_id' => $user_id,
					'amount' => $amount,
					'tx_request_number' => $request_number,
					'txn_id' => $txn_id,
					'payment_method' => 'Others',
					'paid_upi' => $paid_upi,
					'txn_ref' => $txn_ref,
					'insert_date' => $this->insert_date
				);
				$this->Frontbmodel->insertData($this->tb50,$history_data_2);
				
				
				
				$data_json['msg'] = 'Points Added Successfully. Please Wait for admin Approval';
				$data_json['status'] = true;
				
				$result = $this->Frontamodel->getData($this->tb19);
				foreach ($result as $rs)
				{
					$phone = $rs->mobile_1;
				}
				///$phone=8387998048;
				$where=array('user_id'=>$user_id);
				$result = $this->Frontamodel->get_data_row($this->tb3,$where);
				if($result!='')
				{
					$user_name = $result->user_name;
					$mobile = $result->mobile;
						
				}
				
				/* $message='New Auto-Deposit Request('.$request_number.') submitted from '.$user_name.'-'.$mobile.' for '.$amount.'.';
				
				$message=$this->replaceSpace($message);
				$this->sendMessage($phone,$message); */
			}
			
			$this->giveMoneyToReferral($user_id,$amount);
			
			
			
			
			
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function checkNotifiation()
	{
		//$to = $player_ids; 
		$to = '6f74087b-3eb2-4841-b218-51d2c111cc7e'; 
				$title = 'Demo ';
				$message = 'Demo Data';
				$img = ''; 
				$type_id = '';
				
				$this->volanlib->sendnotification($to, $title, $message, $img, $type_id);
	}
	
	
	
	/////////////////////////////////////////STAR LINE
	
	public function apiStarlineGame()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$joins = array(
					array(
						'table' => $this->tb36,
						'condition' => $this->tb36.'.game_id = '.$this->tb35.'.game_id && result_date="'.date('Y-m-d').'"',
						'jointype' => 'LEFT'
					)
				);
			$columns = ''.$this->tb35.'.game_id,game_name,game_name_hindi,open_time,open_time_sort,close_time,market_status,open_number,close_number,
			open_decleare_status,close_decleare_status';
			$where=array('status'=>1);
			$by='open_time_sort';
			$result = $this->Frontamodel->get_joins_where_asc($this->tb35,$columns,$joins,$where,$by);
			//echo "<pre>";print_r($result);die;
			foreach($result as $rs)
			{
				$game_id = $rs->game_id;
				$open_number = $rs->open_number;
				$close_number=$rs->close_number;
				$open_decleare_status=$rs->open_decleare_status;
				$close_decleare_status=$rs->close_decleare_status;
				
				if($rs->market_status==0){
					$rs->msg='Market closed';
					$rs->msg_status=2;
				}else{
					$data=$this->getMsgAccordingToOpenTime($rs->open_time);
					$rs->msg=$data['msg'];
					$rs->msg_status=$data['msg_status'];
				}
				
					
				if($rs->open_number!=''){
					$open_num=$rs->open_number[0]+$rs->open_number[1]+$rs->open_number[2];
					if($open_num<10){
						$rs->open_result=$open_number.'-'.$open_num;
					}else if($open_num>9){
						$rs->open_result=$open_number.'-'.$open_num%10;
					}
				}else{
					$rs->open_result='';
				}
				$rs->time_srt=strtotime($rs->open_time_sort);
				$rs->close_time_srt=strtotime($rs->open_time_sort);
					$rs->close_result='';				
				unset($rs->market_status);
				unset($rs->open_number);
				unset($rs->close_number);
				unset($rs->open_decleare_status);
				unset($rs->close_decleare_status);
			}
			
			$data_json['web_starline_chart_url']=base_url().'game-result-chart-details';
			
			$data_json['result'] = $result;
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	
	public function apiStarlineGameRates()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$result=$this->Frontamodel->getData($this->tb34);
			if(count($result)>0){
				$data_json['game_rates'] = $result;
				$data_json['msg'] = 'Game Rates';
				$data_json['status'] = true;
			}else{
				$data_json['game_rates'] = $result;
				$data_json['msg'] = 'Game Rates Not Added Yet';
				$data_json['status'] = false;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	
	public function apiCheckStarLineGameStatus()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$game_id=$input_data->game_id;
			$where = array('game_id'=>$game_id);
			
			$select = 'open_time,close_time';
			$result = $this->Frontamodel->get_data_select($this->tb35,$where,$select);
			foreach($result as $rs)
			{
				$saat = new DateTime(); 
		
				$open = new DateTime( $saat->format('Y-m-d ').$rs->open_time);
				
				if (($saat > $open)) 
				{
					$data_json['msg']= 'Sorry Betting Is closed.';
					$data_json['game_status']= 2;
					$data['status']= false;
				}
				else{
					$data_json['msg']= 'Betting Is Open';
					$data_json['game_status']= 1;
					$data_json['status']= true;
				}
			}
			
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	
	public function apiCheckStarLineGamesActiveInactive()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$game_id=$input_data->game_id;
			$where = array('game_id'=>$game_id);
			
			$select = 'open_time,close_time';
			$result = $this->Frontamodel->get_data_select($this->tb35,$where,$select);
			foreach($result as $rs)
			{
				$data=$this->checkGameOpenStatus($rs->open_time);
				$rs->msg=$data['msg'];
				$rs->game_status=$data['game_status'];
				$rs->status=$data['status'];
			}
			
			$data_json['result'] = $result; 
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiStarlineSubmitBid()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$new_result = $input_data->new_result;
			$json_result1 = json_decode(json_encode($new_result,true));
			$unique_token = $json_result1->unique_token;
			$game_id = $json_result1->gameid;
			$Gamename = $json_result1->Gamename;
			$pana = $json_result1->pana;
			$bid_date = $json_result1->bid_date;
			$totalbit = $json_result1->totalbit;
			$session = $json_result1->session;
			$bid_result = $json_result1->result;
			
			$where = array('unique_token'=>$unique_token);
			$result = $this->Frontamodel->get_data_row($this->tb3,$where);
			if($result!='')
			{
				$user_wallet_amt = $result->wallet_balance;
			}
			
			$user_id=$this->getUserIdFromToken($unique_token);
			
			$where = array('game_id'=>$game_id);
			$select = 'open_time,close_time';
			$result = $this->Frontamodel->get_data_select($this->tb35,$where,$select);
			$open_time='';
			foreach($result as $rs)
			{
				$open_time=$rs->open_time;
				$data=$this->checkGameOpenStatus($rs->open_time);
				$game_status=$data['game_status'];
				$msg=$data['msg'];
			}
			
			if($game_status == 1)
			{
				$json_result = json_decode(json_encode($bid_result,true));
				$totalbit=0;
				foreach($json_result as $result)
				{
					$totalbit=$totalbit+$result->points;
				}
				
				foreach($json_result as $result)
				{
					$session = $result->session;
					$digits = $result->digits;
					$closedigits = $result->closedigits;
					$points = $result->points;
					
					if($totalbit<0)
					{
						$data_json['msg'] = "Sorry something went wrong";
						$data_json['status'] = false;
					}
					else
					{
					
						if($user_wallet_amt >= $totalbit)
						{
							if($pana=='सिंगल डिजिट')
							{
								$pana='Single Digit';
							}
							else if($pana=='सिंगल पाना')
							{
								$pana='Single Pana';
							}
							else if($pana=='डबल पाना')
							{
								$pana='Double Pana';
							}
							else if($pana=='ट्रिपल पाना')
							{
								$pana='Triple Pana';
							}
							
							$request_number = $this->randomNumber();
							$bid_data = array(
									'user_id'=>$user_id,
									'game_id'=>$game_id,
									'game_name'=>$Gamename,
									'pana'=>$pana,
									'session'=>$session,
									'digits'=>$digits,
									'closedigits'=>$closedigits,
									'points'=>$points,
									'bid_date'=>date('Y-m-d',strtotime($bid_date)),
									'bid_tx_id' => $request_number,
									'insert_date'=>$this->insert_date
								);
							
							$wallet_amt = $user_wallet_amt - $totalbit;
							$where = array('user_id'=>$user_id);
							$wallet_data = array('wallet_balance'=>$wallet_amt);
							$this->Frontcmodel->update_where($this->tb3,$wallet_data,$where);
							
							$this->Frontbmodel->insertData($this->tb37,$bid_data);
							
							$history_data_2 = array(
									'user_id' => $user_id,
									'amount' => $points,
									'transaction_type' => 2,
									'transaction_note' => 'Bid Placed For '.$Gamename.'('.$open_time.')',
									'amount_status' => 5,
									'tx_request_number' => $request_number,
									'insert_date' => $this->insert_date
							);
							$this->Frontbmodel->insertData($this->tb14,$history_data_2);
							
							$data_json['msg'] = "Bid Successfully Submitted";
							$data_json['status'] = true;
							
						}else {
							$data_json['msg'] = "Sorry You Don't Have Sufficient Amount For This Bid";
							$data_json['status'] = false;
						}
					}
				}
			}else {
				/* $data_json['msg'] = 'Sorry Betting Closed For Today'; */
				$data_json['msg'] = $msg;
				$data_json['status'] = false; 
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiStarlineBidHistoryData()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$unique_token = $input_data->unique_token;
			$bid_from = $input_data->bid_from;
			$bid_to = $input_data->bid_to;
			
			$user_id=$this->getUserIdFromToken($unique_token);
			
			$select = "game_name,pana,session,digits,closedigits,points,bid_tx_id,
			date_format(insert_date,'%d %b %Y %r') as bid_date";
			$by = 'bid_id';
			$type = 'desc';
			
			if($bid_from == '' && $bid_to == '')
			{
				$today = $this->insert_date;
				$today_date = date('Y-m-d',strtotime($today));
				$where = array('user_id'=>$user_id,'bid_date'=>$today_date);
			}else {
				$date_from = date('Y-m-d',strtotime($bid_from));
				$date_to = date('Y-m-d',strtotime($bid_to));
				$where = array('user_id'=>$user_id,'bid_date >='=>$date_from,'bid_date <='=>$date_to);			
			}
			$result = $this->Frontamodel->get_data_select_type($this->tb37,$where,$select,$by,$type);
			
			if(count($result)>0)
			{
				$data_json['bid_data'] = $result;
				$data_json['msg'] = 'Bid History Data Available';
				$data_json['status'] = true;
			}else {
				$data_json['bid_data'] = $result;
				$data_json['msg'] = 'Bid History Data Not Available';
				$data_json['status'] = false;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	
	
	public function apiStarlineWiningHistoryData() 
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$unique_token = $input_data->unique_token;
			$date_from = $input_data->date_from;
			$date_to = $input_data->date_to;
			
			$user_id=$this->getUserIdFromToken($unique_token);
			
			$select = "amount,transaction_type,transaction_note,amount_status,tx_request_number,
			date_format(insert_date,'%d %b %Y %r') as wining_date";
			$by = 'transaction_id';
			$type = 'desc';
			
			if($date_from == '' && $date_to == '')
			{
				$today = $this->insert_date;
				$today_date = date('Y-m-d',strtotime($today));
				$where = array($this->tb14.'.user_id'=>$user_id,'DATE('.$this->tb14.'.insert_date)'=>$today_date,'amount_status'=>12);
			}else {
				$date_from = date('Y-m-d',strtotime($date_from));
				$date_to = date('Y-m-d',strtotime($date_to));
				
				$where = array($this->tb14.'.user_id'=>$user_id,'DATE('.$this->tb14.'.insert_date) >='=>$date_from,'DATE('.$this->tb14.'.insert_date) <='=>$date_to,'amount_status'=>12);	
			}
			
			$joins = array(
							array(
								'table'=>$this->tb37,
								'condition'=> $this->tb37.'.bid_tx_id = '.$this->tb14.'.bid_tx_id',
								'jointype' =>'LEFT'
							)
						);
					$columns = "amount,transaction_type,transaction_note,amount_status,tx_request_number,
			date_format(".$this->tb14.".insert_date,'%d %b %Y %r') as wining_date,game_name,pana,session,digits,closedigits";
					$result = $this->Frontamodel->get_joins_where_desc($this->tb14,$columns,$joins,$where,$by);
			
			
			if(count($result)>0)
			{
				$data_json['win_data'] = $result;
				$data_json['msg'] = 'Wining History Data Available';
				$data_json['status'] = true;
			}else {
				$data_json['win_data'] = $result;
				$data_json['msg'] = 'Wining History Data Not Available';
				$data_json['status'] = false;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}

	public function apiChatApp()
	{
		if($_POST)
		{
			$app_key=trim($this->input->post('app_key'));
			
			if($this->checkRequestAuth($app_key,$env_type)!=0)
			{
				$unique_token=$this->input->post('unique_token');
				$msg=$this->input->post('msg');
				
					$file='';
					$path = 'uploads/chat/';
					if(isset($_FILES['file']['name']) && $_FILES['file']['name']!='blank.jpg' )
					{
						$ext = substr($_FILES['file']['name'], strrpos($_FILES['file']['name'], '.') + 1);
						if($ext=="jpeg" || $ext=="jpg" || $ext=="png")
						{
							$file=$this->volanimage->upload_image($path,$_FILES['file']);
						}
					}
				
						 $user_id=$this->getUserIdFromToken($unique_token);
						$insert_data = array(
								'user_id' =>$user_id,
								'reply' => $msg,
								'file' => $file,
								'support_id' => 1,
								'reply_type' => 2,
								'insert_date' => $this->insert_date
							);
						$this->Frontbmodel->insertData($this->tb39,$insert_data);
						$data_json['msg'] = "Message Successfully Added";
						$data_json['status']=true;
					 
				 
			}
			else
			{
				$data_json['msg']='UnAuthorized request';
				$data_json['status']=false;
			}
			echo json_encode($data_json);
		}
	}
	public function apiGetChatApp()
	{
		if($_POST)
		{
			$app_key=trim($this->input->post('app_key'));
			
			if($this->checkRequestAuth($app_key,$env_type)!=0)
			{
				$unique_token=$this->input->post('unique_token');

					$where=array("unique_token" => $unique_token);
					$path= base_url()."uploads/chat/";
					$select = "support_id,reply,concat('$path',file) as file,date_format(insert_date,'%d %b %Y') as insert_date,reply_type,support_id";
					$result=$this->Frontamodel->get_data_select($this->tb39,$where,$select);
					if(count($result)>0){
						$data_json['user_data'] = $result;
						$data_json['msg'] = 'User Detail';
						$data_json['status'] = true;
					}else
					{
						$data_json['payment_details'] = $result;
						$data_json['msg'] = 'msg not found';
						$data_json['status'] = false;
					}
				 
			}
			else
			{
				$data_json['msg']='UnAuthorized request';
				$data_json['status']=false;
			}
			echo json_encode($data_json);
		}
	}
	
	
	public function apiRouletteGame()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			
			
			$unique_token=$this->input->post('unique_token');
			
			$user_id=$this->getUserIdFromToken($unique_token);

			$where=array("user_id" => $user_id);
			
			
			
			
			
			$select = $this->tb40.'.game_id,game_name,open_time,open_time_sort,close_time,market_status';
			$where=array('status'=>1,'close_time_sort>'=>date("H:i:s"));
			
			$by='open_time_sort';
			$active_result = $this->Frontamodel->get_data_latest_where_asc($this->tb40,$where,$by,$select);
			
			foreach($active_result as $rs)
			{
				$game_id = $rs->game_id;
				
				if($rs->market_status==0){
					$rs->msg='Market is closed for today';
					$rs->msg_status=2;
				}else{
					$data=$this->getMsgAccordingToTimeRouletteActive($rs->open_time,$rs->close_time);
					$rs->msg=$data['msg'];
					$rs->msg_status=$data['msg_status'];
				}
				
				
				
				
				unset($rs->market_status);
			}
			
			$date=date('Y-m-d');
			
			$joins = array(
					array(
						'table' => $this->tb42,
						//	'condition' => $this->tb42.'.game_id = '.$this->tb40.'.game_id && result_date="'.$date.'"',
							'condition' => $this->tb42.'.game_id = '.$this->tb40.'.game_id',
						'jointype' => 'LEFT'
					)
				);
			$columns = ''.$this->tb40.'.game_id,game_name,,open_time,open_time_sort,close_time,market_status,number as result';
			$where=array('status'=>1,'result_date'=>$date);
			$by='open_time_sort';
			$dec_result = $this->Frontamodel->get_joins_where_asc($this->tb40,$columns,$joins,$where,$by);

			foreach($dec_result as $rs)
			{
				$game_id = $rs->game_id;
				if($rs->result=='')
				{
					$rs->result='';
				}
				
				if($rs->market_status==0){
					$rs->msg='Market closed';
					$rs->msg_status=2;
				}else{
					$data=$this->getMsgAccordingToTimeRoulette($rs->open_time,$rs->close_time);
					$rs->msg=$data['msg'];
					$rs->msg_status=$data['msg_status'];
				}
				
				
				
				
				unset($rs->market_status);
			}
			
			$data_json['active_result'] = $active_result;
			
			
			$data_json['declare_result'] = $dec_result;
			$data_json['msg'] = 'Success';
			$data_json['status'] = true;
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	
	
	public function apiCheckRouletteGameStatus()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$game_id=$input_data->game_id;
			$where = array('game_id'=>$game_id);
			
			$select = 'open_time,close_time';
			$result = $this->Frontamodel->get_data_select($this->tb40,$where,$select);
			foreach($result as $rs)
			{
				$cur_time = new DateTime(); 
		
				$open = new DateTime( $cur_time->format('Y-m-d ').$rs->open_time);
				$close = new DateTime( $cur_time->format('Y-m-d ').$rs->close_time);
				
				if (($cur_time >= $open) && ($cur_time <= $close)) {
					$data_json['msg']= 'Betting is running for today';
					$data_json['game_status']= 1;
					$data_json['status']= true;
				}else{
					$data_json['msg']= 'Market Closed';
					$data_json['game_status']= 2;
					$data_json['status']= false;
				}
				
			}
			
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	
	
	public function apiGetRouletteGameInfo()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$game_id=$input_data->game_id;
			$unique_token=$input_data->unique_token;
			$where = array('game_id'=>$game_id);
			
			$select = 'open_time,close_time';
			$result = $this->Frontamodel->get_data_select($this->tb40,$where,$select);
			$min=0;
			$sec=0;
			$web_time=0;
			foreach($result as $rs)
			{
				$cur_time = new DateTime(); 
		
				$start_date = new DateTime(date("H:i:s"));
				$since_start = $start_date->diff(new DateTime(date("H:i:s",strtotime($rs->close_time))));
				

				$min=$since_start->i;
				$sec=$since_start->s+$min*60;
				$web_time=$sec;
				$sec=$sec-60;
				
				
				
			}
			$where = array('unique_token'=>$unique_token);
			$result = $this->Frontamodel->get_data_row($this->tb3,$where);
			if($result!='')
			{
				$data_json['wallet_amt'] = $result->wallet_balance;
				$data_json['account_block_status'] = $result->status;
			}else {
				$data_json['wallet_amt'] = '';
				$data_json['account_block_status'] = '';
			}
			
			
			$user_id=$this->getUserIdFromToken($unique_token);
			
				$where = array('game_id'=>$game_id,'user_id'=>$user_id,'bid_date'=>$this->cur_date);
				$select = 'points,digits';
				$result = $this->Frontamodel->get_data_select($this->tb41,$where,$select);
				
				$data_json['bid_data']=$result;
						
				$data_json['min']=$min;
				//$data_json['duration']=$min*60000;
				$data_json['duration']=$sec*1000;
				$data_json['web_time_duration']=($web_time-$sec)*1000;
			
			$data_json['msg']='Success';
				$data_json['status']=true;
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	
	public function apiRouletteSubmitBid()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$unique_token = $input_data->unique_token;
			$game_id = $input_data->game_id;
			$game_name = $input_data->game_name;
			
			$digits = $input_data->digits;
			$points = $input_data->points;
			
			$where = array('unique_token'=>$unique_token);
			$result = $this->Frontamodel->get_data_row($this->tb3,$where);
			if($result!='')
			{
				$user_wallet_amt = $result->wallet_balance;
			}
			
			$where = array('game_id'=>$game_id);
			$select = 'open_time,close_time';
			$result = $this->Frontamodel->get_data_select($this->tb40,$where,$select);
			$open_time='';
			foreach($result as $rs)
			{
				$open_time=$rs->open_time;
				
				$cur_time = new DateTime(); 
				$open = new DateTime( $cur_time->format('Y-m-d ').$rs->open_time);
				$close = new DateTime( $cur_time->format('Y-m-d ').$rs->close_time);
				
				if (($cur_time >= $open) && ($cur_time <$close)) {
					
					$cur_time = new DateTime(); 
		
					$start_date = new DateTime(date("H:i:s"));
					$since_start = $start_date->diff(new DateTime(date("H:i:s",strtotime($rs->close_time))));
					$min=$since_start->i;
					$sec=$since_start->s+$min*60;
					
					if($sec<60)
					{
						$msg= 'Betting is closed for today';
						$game_status= 2;
					}
					else
					{
						$msg= 'Market Running';
						$game_status= 1;
					}
				}else{
					$msg= 'Betting is closed for today';
					$game_status= 2;
				}
				
			}
			
			if($game_status == 1)
			{
				
					
					if($user_wallet_amt >= $points)
					{
						$user_id=$this->getUserIdFromToken($unique_token);
						$where = array('game_id'=>$game_id,'user_id'=>$user_id,'digits'=>$digits,'bid_date'=>$this->cur_date);
						$select = 'points,bid_id,bid_tx_id';
						$result = $this->Frontamodel->get_data_select($this->tb41,$where,$select);
						
						if(count($result)>0)
						{
							foreach($result as $rs)
							{
								$old_points=$rs->points;
								$bid_id=$rs->bid_id;
								$bid_tx_id=$rs->bid_tx_id;
							}
							
							$wallet_amt = $user_wallet_amt - $points+$old_points;
							
							$where = array('unique_token'=>$unique_token);
							$wallet_data = array('wallet_balance'=>$wallet_amt);
							$this->Frontcmodel->update_where($this->tb3,$wallet_data,$where);
							
							
							$where = array('bid_id'=>$bid_id);
							$bid_data = array('digits'=>$digits,'points'=>$points);
							$this->Frontcmodel->update_where($this->tb41,$bid_data,$where);
							
							$where = array('tx_request_number'=>$bid_tx_id);
							$bid_data = array('amount'=>$points);
							$this->Frontcmodel->update_where($this->tb14,$bid_data,$where);
						}
						else
						{
							$request_number = $this->randomNumber();
							
							$user_id=$this->getUserIdFromToken($unique_token);
							$bid_data = array(
									'user_id'=>$user_id,
									'game_id'=>$game_id,
									'game_name'=>$game_name,
									'digits'=>$digits,
									'points'=>$points,
									'bid_date'=>$this->cur_date,
									'bid_tx_id' => $request_number,
									'insert_date'=>$this->insert_date
								);
							
							$wallet_amt = $user_wallet_amt - $points;
							
							$where = array('unique_token'=>$unique_token);
							$wallet_data = array('wallet_balance'=>$wallet_amt);
							$this->Frontcmodel->update_where($this->tb3,$wallet_data,$where);
							
							$this->Frontbmodel->insertData($this->tb41,$bid_data);
							
							$history_data_2 = array(
									'user_id' => $user_id,
									'amount' => $points,
									'transaction_type' => 2,
									'transaction_note' => 'Bid Placed For '.$game_name,
									'amount_status' => 5,
									'tx_request_number' => $request_number,
									'insert_date' => $this->insert_date
							);
							$this->Frontbmodel->insertData($this->tb14,$history_data_2);
						}	
							
						$data_json['msg'] = "Bid Successfully Submitted";
						$data_json['status'] = true;
						
					}else {
						$data_json['msg'] = "Sorry You Don't Have Sufficient Amount For This Bid";
						$data_json['status'] = false;
					}
				
			}else {
				/* $data_json['msg'] = 'Sorry Betting Closed For Today'; */
				$data_json['msg'] = $msg;
				$data_json['status'] = false; 
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	
	public function apiGetRouletteGameWinningNumber()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			
			
			$game_id=$input_data->game_id;
			$unique_token=$input_data->unique_token;
			if($game_id==96)
			{
				$where = array('game_id'=>$game_id);
			}
			else
			{
				$where = array('game_id'=>$game_id,'result_date'=>date('Y-m-d'));
			}
			
			$select = 'number';
			$result = $this->Frontamodel->get_data_select($this->tb42,$where,$select);
			if(count($result)>0)
			{
				foreach($result as $rs)
				{		
					$number=$rs->number;
				}
				$data_json['msg'] = "Result declared";
				$data_json['status'] = true;
				$data_json['winning_number'] = $number;
				
				$user_id=$this->getUserIdFromToken($unique_token);
				
				$where = array('game_id'=>$game_id,'user_id'=>$user_id,'digits'=>$number,'bid_date'=>$this->cur_date);
				$bidresult = $this->Frontamodel->get_data($this->tb41,$where);
				
				if(count($bidresult)>0)
				{
					$data_json['winning_status'] = 1;
				}
				else
				{
					$data_json['winning_status'] = 0;
				}
				
						
			}
			else
			{
				$data_json['msg'] = "Result not declared yet";
				$data_json['winning_status'] = 0;
				$data_json['status'] = false;
						
			}
			
			
			$where = array('game_id'=>$game_id);
			
			$select = 'open_time,close_time';
			$result = $this->Frontamodel->get_data_select($this->tb40,$where,$select);
			$min=0;
			foreach($result as $rs)
			{
				$cur_time = new DateTime(); 
		
				$start_date = new DateTime(date("H:i:s"));
				$since_start = $start_date->diff(new DateTime(date("H:i:s",strtotime($rs->close_time))));
				$min=$since_start->i;
			}
			
			$data_json['min']=$min;
			$data_json['duration']=$min*60000;
			
			
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	
	
	
	public function rouletteResultDeclare()
	{
		
		/* $where=array('open_time_sort<='=>date("H:i:s"),'close_time_sort>='=>date("H:i:s"));	
		//$where=array('game_id'=>75);	
		$result = $this->Frontamodel->get_data($this->tb40,$where); */
		
		$result_date=$this->cur_date;
		//$result_date='2020-10-09';
		
		$new_date = date("Y-m-d H:i:s");
		//$new_date = '2020-10-09 00:00:02';
		
		$where=array('result_date'=>$result_date);	
		$by='id';
		$limit=1;
		$result = $this->Frontamodel->get_data_desc($this->tb42,$where,$by,$limit);
		if(count($result)>0)
		{
			foreach($result as $rs)
			{
				$game_id=$rs->game_id+1;
			}
			
		}
		else
		{
			 $where=array();	
			$by='id';
			$limit=1;
			$game_id='';
			$result = $this->Frontamodel->get_data_desc($this->tb42,$where,$by,$limit);
			foreach($result as $rs)
			{
				$game_id=$rs->game_id;
				$new_result_date=$rs->result_date;
			}
			///$game_id=95;
			if($game_id==95)
			{
				$game_id=96;
				$result_date=$new_result_date;
				$date = date("Y-m-d H:i:s");
				$time = strtotime($date);
				$time = $time - (10);
				$new_date = date("Y-m-d H:i:s", $time);
				
			}
			else 
			{
				$game_id=1;
			}
		}
		
		
		
		//$game_id='65';
		//$result_date='2020-10-09';
	
		$i=0;
		
			$where=array('game_id'=>$game_id,'result_date'=>$result_date);	
			$result = $this->Frontamodel->get_data($this->tb42,$where);
			
			
			if(count($result)<1)
			{

				$where=array('game_id'=>$game_id,'bid_date'=>$result_date,'pay_status'=>0);	
				$result = $this->Frontamodel->get_data($this->tb41,$where);
				
				
				
				if(count($result)>0)
				{
					$query="SELECT sum(points) as my_points, `digits` FROM `tb_roulette_bid_history` WHERE `game_id` = '$game_id' AND `bid_date` = '$result_date' AND `pay_status` = 0 GROUP BY `digits`";
					
					//$query="SELECT min(points) as min_points, digits from (SELECT digit_id as digits, digit_value as points FROM tb_digit WHERE digit_id NOT IN(SELECT digits FROM tb_roulette_bid_history WHERE `game_id` = '$game_id' AND bid_date = '$result_date') UNION SELECT digits, points FROM tb_roulette_bid_history WHERE `game_id` = 58 AND bid_date = '$result_date') as t";
					
					$query="SELECT t.points as min_points, digits from (SELECT digit_id as digits, digit_value as points FROM tb_digit WHERE digit_id NOT IN (SELECT digits FROM tb_roulette_bid_history WHERE `game_id` = '$game_id' AND bid_date = '$result_date') UNION SELECT digits, SUM(points) as points FROM tb_roulette_bid_history WHERE `game_id` = '$game_id' AND bid_date = '$result_date' GROUP BY digits) as t order by min_points asc Limit 1";
					$get_winning_numebr = $this->Frontamodel->custom_query($query);
					
					
					// echo "<pre>";print_r($get_winning_numebr);die;
					
					/*for($k=0;$k<10;$k++)
					{
						foreach($get_winning_numebr as $res)
						{
							if($res->digits!=$k)
							{
								
							}
						}
					} */
					
					foreach($get_winning_numebr as $res)
					{
						$min_points=$res->min_points;
						$win_digits=$res->digits;
						
					}
					
					/* $where=array('game_id'=>$game_id,'points'=>$min_points,'bid_date'=>$result_date);	
					$winne = $this->Frontamodel->get_data($this->tb41,$where);
					
					foreach($winne as $res)
					{
						$win_digits=$res->digits;
					} */
					
				///	echo "<pre>";print_r($get_winning_numebr);die;
					
					$where=array('game_id'=>$game_id,'digits'=>$win_digits,'bid_date'=>$result_date,'pay_status'=>0);	
					$bid_result = $this->Frontamodel->get_data($this->tb41,$where);
					 //echo "<pre>";print_r($bid_result);die;
					
					$open_result_token=$this->volanlib->uniqRandom(15);
					
					if(count($bid_result)>0)
					{
						foreach($bid_result as $rs)
						{
							$win_amt=10*$rs->points;
							
							$where=array('unique_token'=>$rs->unique_token);
							$col='wallet_balance';
							$this->Frontamodel->updateSetDataAddAmount($this->tb3,$where,$col,$win_amt);
							
							$msg='Amount won in Roulette '.$rs->game_name.' for Bid Number- '.$rs->bid_tx_id;
							
							$user_id=$this->getUserIdFromToken($unique_token);
							$request_number = $this->randomNumber();
							$history_data = array(
									'user_id' => $rs->user_id,
									'amount' => $win_amt,
									'transaction_type' => 1,
									'transaction_note' => $msg,
									'amount_status' => 81,
									'tx_request_number' => $request_number,
									'open_result_token' => $open_result_token,
									'bid_tx_id' => $rs->bid_tx_id,
									'insert_date' => $new_date
							);
							$this->Frontbmodel->insertData($this->tb14,$history_data);
							
							$where = array('bid_tx_id'=>$rs->bid_tx_id);
							$bid_data = array('pay_status'=>1,'result_token'=>$open_result_token);
							$this->Frontcmodel->update_where($this->tb41,$bid_data,$where);
						}
					}
					
					$result_data = array(
								'game_id' => $game_id,
								'number' => $win_digits,
								'result_date' => $result_date,
								'result_token' => $open_result_token,
								'declare_date' => $new_date
						);
						$this->Frontbmodel->insertData($this->tb42,$result_data);
				
					
					
				}
				else
				{
					$open_result_token=$this->volanlib->uniqRandom(15);
					$win_digits=rand(0,9);
					$result_data = array(
								'game_id' => $game_id,
								'number' => $win_digits,
								'result_date' => $result_date,
								'result_token' => $open_result_token,
								'declare_date' => $new_date
						);
						$this->Frontbmodel->insertData($this->tb42,$result_data);
					
				}
				
			
				
			}
	
		
		///$message='Cron check rouletteResultDeclare';
			//	$message=$this->replaceSpace($message);
				//$this->sendMessage(8387998048,$message);
		
	}
	
	public function apiRouletteBidHistoryData()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$unique_token = $input_data->unique_token;
			$bid_from = $input_data->bid_from;
			$bid_to = $input_data->bid_to;
			
			$select = "game_name,digits,points,bid_tx_id,
			date_format(insert_date,'%d %b %Y %r') as bid_date";
			$by = 'bid_id';
			$type = 'desc';
			
			$user_id=$this->getUserIdFromToken($unique_token);
			
			if($bid_from == '' && $bid_to == '')
			{
				$today = $this->insert_date;
				$today_date = date('Y-m-d',strtotime($today));
				$where = array('user_id'=>$user_id,'bid_date'=>$today_date);
			}else {
				$date_from = date('Y-m-d',strtotime($bid_from));
				$date_to = date('Y-m-d',strtotime($bid_to));
				$where = array('user_id'=>$user_id,'bid_date >='=>$date_from,'bid_date <='=>$date_to);			
			}
			$result = $this->Frontamodel->get_data_select_type($this->tb41,$where,$select,$by,$type);
			
			if(count($result)>0)
			{
				$data_json['bid_data'] = $result;
				$data_json['msg'] = 'Bid History Data Available';
				$data_json['status'] = true;
			}else {
				$data_json['bid_data'] = $result;
				$data_json['msg'] = 'Bid History Data Not Available';
				$data_json['status'] = false;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	
	public function apiRouletteWiningHistoryData() 
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$unique_token = $input_data->unique_token;
			$date_from = $input_data->date_from;
			$date_to = $input_data->date_to;
			
			$select = "amount,transaction_type,transaction_note,amount_status,tx_request_number,
			date_format(insert_date,'%d %b %Y %r') as wining_date";
			$by = 'transaction_id';
			$type = 'desc';
			
			$user_id=$this->getUserIdFromToken($unique_token);
			
			if($date_from == '' && $date_to == '')
			{
				$today = $this->insert_date;
				$today_date = date('Y-m-d',strtotime($today));
				$where = array('user_id'=>$user_id,'DATE(insert_date)'=>$today_date,'amount_status'=>81);
			}else {
				$date_from = date('Y-m-d',strtotime($date_from));
				$date_to = date('Y-m-d',strtotime($date_to));
				$where = array('user_id'=>$user_id,'DATE(insert_date) >='=>$date_from,'DATE(insert_date) <='=>$date_to,'amount_status'=>81);			
			}
			
			$result = $this->Frontamodel->get_data_select_type($this->tb14,$where,$select,$by,$type);
			
			if(count($result)>0)
			{
				$data_json['win_data'] = $result;
				$data_json['msg'] = 'Wining History Data Available';
				$data_json['status'] = true;
			}else {
				$data_json['win_data'] = $result;
				$data_json['msg'] = 'Wining History Data Not Available';
				$data_json['status'] = false;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	
	
	public function apiUpdatePin()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			// $mobile = $input_data->mobile;
			$mobile=$this->volanlib->encryptMob($input_data->mobile);
			$security_pin = $input_data->security_pin;
			$where_array=array('mobile' => $mobile);
			$result = $this->Frontamodel->get_data($this->tb3,$where_array);
			if(count($result) < 1){
				$data_json['msg'] ="This Mobile Number is Not Registered";
				$data_json['status']=false;
			}
			else
			{	
				foreach($result as $rs)
				{
					$unique_token=$rs->unique_token;
				}
				$where = array('unique_token'=>$unique_token);
				$passData = array('security_pin' => $security_pin);
				$this->Frontcmodel->update_where($this->tb3,$passData,$where);
				$data_json['status']=true;
				$data_json['msg'] = "Pin Successfully Changed.";
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	
	public function apiGetSpDPMotorCombination()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$unique_token = $input_data->unique_token;
			$type = $input_data->type;
			$number = $input_data->number;
			$points = $input_data->points;
			
			
			$where = array('unique_token'=>$unique_token);
			$result = $this->Frontamodel->get_data_row($this->tb3,$where);
			if($result!='')
			{
				$user_wallet_amt = $result->wallet_balance;
			}
			
			
			for($i=0; $i < strlen($number); $i++)
			{
				$list[]=$number[$i]; 
			}
			$chars = $list;
			$output = $this->getPossibleCombination($chars, 3);
			$my_combination=array();
			if(count($output)>0)
			{
				$result = count($output);
				if($type==8)
				{
					$tb=$this->tb28;
				}
				else
				{
					$tb=$this->tb31;
				}
				
				for($i=0; $i < $result; $i++)
				{
					$comb = $output[$i];
					$where = array('numbers'=>$comb);
					
					$data = $this->Frontamodel->get_data($tb,$where);
					if(count($data)>0)
					{
						foreach($data as $rs)
						{
							$my_combination[] = $rs->numbers;
						}
					}
				}
			}
			
			$posssible_array=array_values(array_unique($my_combination));
			
			if(count($posssible_array)<1)
			{
				$data_json['msg']="No Possible combination found";
				$data_json['status']=false;
			}
			else if(count($posssible_array)*$points>$user_wallet_amt)
			{
				$data_json['msg']="You don't have sufficient balance to place this bid";
				$data_json['status']=false;
			}
			else
			{
				for($i=0;$i<count($posssible_array);$i++)
				{
					$posssible_ass_array[$i]['number']=$posssible_array[$i];
					$posssible_ass_array[$i]['points']=$points;
				}
				
				$data_json['posssible_array']=$posssible_ass_array;
				$data_json['total_bid_amount']=count($posssible_array)*$points;
				$data_json['wallet_amt_after_bid']=$user_wallet_amt-count($posssible_array)*$points;
				$data_json['status']=true;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	
	function getPossibleCombination($chars, $size, $combinations = array())
	{
		if (empty($combinations)) {
			$combinations = $chars;
		}

		if ($size == 1) {
			return $combinations;
		}

		$new_combinations = array();

		foreach ($combinations as $combination) {
			foreach ($chars as $char) {
				$new_combinations[] = $combination . $char;
			}
		}

		return $this->getPossibleCombination($chars, $size - 1, $new_combinations);

	}
	
	
	Public function apiGetSpDpTpCombination()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$unique_token = $input_data->unique_token;
			$number = $input_data->number;
			$sp_flag = $input_data->sp_flag;
			$dp_flag = $input_data->dp_flag;
			$tp_flag = $input_data->tp_flag;
			$points = $input_data->points;
			
			$where = array('unique_token'=>$unique_token);
			$result = $this->Frontamodel->get_data_row($this->tb3,$where);
			if($result!='')
			{
				$user_wallet_amt = $result->wallet_balance;
			}
			
			$sp_array = array();
			$dp_array = array();
			$tp_array = array();
			$my_combination = array();
			$select = 'numbers';
			if($sp_flag == 1){
				$where = array('single_digit'=>$number);
				$sp_array = $this->Frontamodel->get_data_select($this->tb28,$where,$select);
				if(count($sp_array)>0)
				{
					foreach($sp_array as $rs)
					{
						$my_combination[] = $rs->numbers;
						$pana[] = 'Single Pana';
					}
				}
			} 
			if($dp_flag == 1){
				$where = array('single_digit'=>$number);
				$dp_array = $this->Frontamodel->get_data_select($this->tb31,$where,$select);
				if(count($dp_array)>0)
				{
					foreach($dp_array as $vs)
					{
						$my_combination[] = $vs->numbers;
						$pana[] = 'Double Pana';
					}
				}
			}
			if($tp_flag == 1){
				$tp_array = $this->Frontamodel->getDataSelect($this->tb29,$select);
				if(count($tp_array)>0)
				{
					foreach($tp_array as $ks)
					{
						$result_number = $ks->numbers;
						$open_num= $result_number[0]+$result_number[1]+$result_number[2];
						if($open_num<10){
							$open_result=$open_num;
						}else if($open_num>9){
							$open_result=$open_num%10;
						}
						if($open_result == $number)
						{
							$my_combination[] = $result_number;
							$pana[] = 'Triple Pana';
						}
					}
				}
			}
			
			$posssible_array = array_values($my_combination);
			
			if(count($posssible_array)<1)
			{
				$data_json['msg']="No Possible combination found";
				$data_json['status']=false;
			}
			else if(count($posssible_array)*$points>$user_wallet_amt)
			{
				$data_json['msg']="You don't have sufficient balance to place this bid";
				$data_json['status']=false;
			}
			else
			{
				for($i=0;$i<count($posssible_array);$i++)
				{
					$posssible_ass_array[$i]['number']=$posssible_array[$i];
					$posssible_ass_array[$i]['points']=$points;
					$posssible_ass_array[$i]['pana']=$pana[$i];
				}
				
				$data_json['posssible_array']=$posssible_ass_array;
				$data_json['total_bid_amount']=count($posssible_array)*$points;
				$data_json['wallet_amt_after_bid']=$user_wallet_amt-count($posssible_array)*$points;
				$data_json['status']=true;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	
	
	/////////////////////////////////////////GALI DISSWAR//////////////////////////////
	
	public function apiGaliDisswarGame()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$joins = array(
					array(
						'table' => $this->tb45,
						'condition' => $this->tb45.'.game_id = '.$this->tb44.'.game_id && result_date="'.date('Y-m-d').'"',
						'jointype' => 'LEFT'
					)
				);
			$columns = ''.$this->tb44.'.game_id,game_name,game_name_hindi,open_time,open_time_sort,close_time,market_status,open_number,close_number,
			open_decleare_status,close_decleare_status';
			$where=array('status'=>1);
			$by='open_time_sort';
			$result = $this->Frontamodel->get_joins_where_asc($this->tb44,$columns,$joins,$where,$by);
			//echo "<pre>";print_r($result);die;
			foreach($result as $rs)
			{
				$game_id = $rs->game_id;
				$open_number = $rs->open_number;
				$close_number=$rs->close_number;
				$open_decleare_status=$rs->open_decleare_status;
				$close_decleare_status=$rs->close_decleare_status;
				
				if($rs->market_status==0){
					$rs->msg='Market closed';
					$rs->msg_status=2;
				}else{
					$data=$this->getMsgAccordingToOpenTime($rs->open_time);
					$rs->msg=$data['msg'];
					$rs->msg_status=$data['msg_status'];
				}
				
					
				
				$rs->open_result=isset($rs->open_number)?$rs->open_number:'';
				
				
					$rs->close_result='';				
				unset($rs->market_status);
				unset($rs->open_number);
				unset($rs->close_number);
				unset($rs->open_decleare_status);
				unset($rs->close_decleare_status);
			}
			
			$data_json['web_galidessar_chart_url']=base_url().'game-result-galidessar-chart-details';
			
			$data_json['result'] = $result;
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	
	public function apiGaliDisswarGameRates()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$result=$this->Frontamodel->getData($this->tb43);
			if(count($result)>0){
				$data_json['game_rates'] = $result;
				$data_json['msg'] = 'Game Rates';
				$data_json['status'] = true;
			}else{
				$data_json['game_rates'] = $result;
				$data_json['msg'] = 'Game Rates Not Added Yet';
				$data_json['status'] = false;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	
	public function apiCheckGaliDisswarGameStatus()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$game_id=$input_data->game_id;
			$where = array('game_id'=>$game_id);
			
			$select = 'open_time,close_time';
			$result = $this->Frontamodel->get_data_select($this->tb44,$where,$select);
			foreach($result as $rs)
			{
				$saat = new DateTime(); 
		
				$open = new DateTime( $saat->format('Y-m-d ').$rs->open_time);
				
				if (($saat > $open)) 
				{
					$data_json['msg']= 'Sorry Betting Is closed.';
					$data_json['game_status']= 2;
					$data['status']= false;
				}
				else{
					$data_json['msg']= 'Betting Is Open';
					$data_json['game_status']= 1;
					$data_json['status']= true;
				}
			}
			
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	
	public function apiCheckGaliDisswarGamesActiveInactive()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$game_id=$input_data->game_id;
			$where = array('game_id'=>$game_id);
			
			$select = 'open_time,close_time';
			$result = $this->Frontamodel->get_data_select($this->tb44,$where,$select);
			foreach($result as $rs)
			{
				$data=$this->checkGameOpenStatus($rs->open_time);
				$rs->msg=$data['msg'];
				$rs->game_status=$data['game_status'];
				$rs->status=$data['status'];
			}
			
			$data_json['result'] = $result; 
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiGaliDisswarSubmitBid()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$new_result = $input_data->new_result;
			$json_result1 = json_decode(json_encode($new_result,true));
			$unique_token = $json_result1->unique_token;
			$game_id = $json_result1->gameid;
			$Gamename = $json_result1->Gamename;
			$pana = $json_result1->pana;
			$bid_date = $json_result1->bid_date;
			$totalbit = $json_result1->totalbit;
			$session = $json_result1->session;
			$bid_result = $json_result1->result;
			
			$where = array('unique_token'=>$unique_token);
			$result = $this->Frontamodel->get_data_row($this->tb3,$where);
			if($result!='')
			{
				$user_wallet_amt = $result->wallet_balance;
			}
			
			$where = array('game_id'=>$game_id);
			$select = 'open_time,close_time';
			$result = $this->Frontamodel->get_data_select($this->tb44,$where,$select);
			$open_time='';
			foreach($result as $rs)
			{
				$open_time=$rs->open_time;
				$data=$this->checkGameOpenStatus($rs->open_time);
				$game_status=$data['game_status'];
				$msg=$data['msg'];
			}
			
			if($game_status == 1)
			{
				$json_result = json_decode(json_encode($bid_result,true));
				$totalbit=0;
				foreach($json_result as $result)
				{
					$totalbit=$totalbit+$result->points;
				}
				
				foreach($json_result as $result)
				{
					$session = $result->session;
					$digits = $result->digits;
					$closedigits = $result->closedigits;
					$points = $result->points;
					
					if($totalbit<0)
					{
						$data_json['msg'] = "Sorry something went wrong";
						$data_json['status'] = false;
					}
					else
					{
					
						if($user_wallet_amt >= $totalbit)
						{
							
							$request_number = $this->randomNumber();
							$user_id=$this->getUserIdFromToken($unique_token);
							$bid_data = array(
									'user_id'=>$user_id,
									'game_id'=>$game_id,
									'game_name'=>$Gamename,
									'pana'=>$pana,
									'session'=>$session,
									'digits'=>$digits,
									'closedigits'=>$closedigits,
									'points'=>$points,
									'bid_date'=>date('Y-m-d',strtotime($bid_date)),
									'bid_tx_id' => $request_number,
									'insert_date'=>$this->insert_date
								);
							
							$wallet_amt = $user_wallet_amt - $totalbit;
							$where = array('unique_token'=>$unique_token);
							$wallet_data = array('wallet_balance'=>$wallet_amt);
							$this->Frontcmodel->update_where($this->tb3,$wallet_data,$where);
							
							$this->Frontbmodel->insertData($this->tb46,$bid_data);
							
							$history_data_2 = array(
									'user_id' => $user_id,
									'amount' => $points,
									'transaction_type' => 2,
									'transaction_note' => 'Bid Placed For '.$Gamename.'('.$open_time.')',
									'amount_status' => 5,
									'tx_request_number' => $request_number,
									'insert_date' => $this->insert_date
							);
							$this->Frontbmodel->insertData($this->tb14,$history_data_2);
							
							$data_json['msg'] = "Bid Successfully Submitted";
							$data_json['status'] = true;
							
						}else {
							$data_json['msg'] = "Sorry You Don't Have Sufficient Amount For This Bid";
							$data_json['status'] = false;
						}
					}
				}
			}else {
				/* $data_json['msg'] = 'Sorry Betting Closed For Today'; */
				$data_json['msg'] = $msg;
				$data_json['status'] = false; 
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiGaliDisswarBidHistoryData()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$unique_token = $input_data->unique_token;
			$bid_from = $input_data->bid_from;
			$bid_to = $input_data->bid_to;
			
			$select = "game_name,pana,session,digits,closedigits,points,bid_tx_id,
			date_format(insert_date,'%d %b %Y %r') as bid_date";
			$by = 'bid_id';
			$type = 'desc';
			
			$user_id=$this->getUserIdFromToken($unique_token);
			if($bid_from == '' && $bid_to == '')
			{
				$today = $this->insert_date;
				$today_date = date('Y-m-d',strtotime($today));
				$where = array('user_id'=>$user_id,'bid_date'=>$today_date);
			}else {
				$date_from = date('Y-m-d',strtotime($bid_from));
				$date_to = date('Y-m-d',strtotime($bid_to));
				$where = array('user_id'=>$user_id,'bid_date >='=>$date_from,'bid_date <='=>$date_to);			
			}
			$result = $this->Frontamodel->get_data_select_type($this->tb46,$where,$select,$by,$type);
			
			if(count($result)>0)
			{
				$data_json['bid_data'] = $result;
				$data_json['msg'] = 'Bid History Data Available';
				$data_json['status'] = true;
			}else {
				$data_json['bid_data'] = $result;
				$data_json['msg'] = 'Bid History Data Not Available';
				$data_json['status'] = false;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	
	
	public function apiGaliDisswarWiningHistoryData() 
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$unique_token = $input_data->unique_token;
			$date_from = $input_data->date_from;
			$date_to = $input_data->date_to;
			
			$select = "amount,transaction_type,transaction_note,amount_status,tx_request_number,
			date_format(insert_date,'%d %b %Y %r') as wining_date";
			$by = 'transaction_id';
			$type = 'desc';
			
			$user_id=$this->getUserIdFromToken($unique_token);
			
			if($date_from == '' && $date_to == '')
			{
				$today = $this->insert_date;
				$today_date = date('Y-m-d',strtotime($today));
				$where = array($this->tb14.'.user_id'=>$user_id,'DATE('.$this->tb14.'.insert_date)'=>$today_date,'amount_status'=>13);
			}else {
				$date_from = date('Y-m-d',strtotime($date_from));
				$date_to = date('Y-m-d',strtotime($date_to));
				$where = array($this->tb14.'.user_id'=>$user_id,'DATE('.$this->tb14.'.insert_date) >='=>$date_from,'DATE('.$this->tb14.'.insert_date) <='=>$date_to,'amount_status'=>13);					
			}
			
			$joins = array(
							array(
								'table'=>$this->tb46,
								'condition'=> $this->tb46.'.bid_tx_id = '.$this->tb14.'.bid_tx_id',
								'jointype' =>'LEFT'
							)
						);
					$columns = "amount,transaction_type,transaction_note,amount_status,tx_request_number,
			date_format(".$this->tb14.".insert_date,'%d %M %y %h:%i') as wining_date,game_name,pana,session,digits,closedigits";
					$result = $this->Frontamodel->get_joins_where_desc($this->tb14,$columns,$joins,$where,$by);
					
						//$result = $this->Frontamodel->get_data_select_type($this->tb14,$where,$select,$by,$type);
			
			if(count($result)>0)
			{
				$data_json['win_data'] = $result;
				$data_json['msg'] = 'Wining History Data Available';
				$data_json['status'] = true;
			}else {
				$data_json['win_data'] = $result;
				$data_json['msg'] = 'Wining History Data Not Available';
				$data_json['status'] = false;
			}
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	
	public function apiGetAutoDepositList()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$unique_token=$input_data->unique_token;
			$user_id=$this->getUserIdFromToken($unique_token);
			$where = array('user_id'=>$user_id);
			$by='id';
			$result = $this->Frontamodel->getDataWhereDesc($this->tb50,$where,$by);
			
			$data_json['msg']='Success';
			$data_json['status']=true;
			$data_json['result']=$result;
			
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiCheckReferValid()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$referral_code=$input_data->referral_code;
			$where=array('referral_code'=>$referral_code);
			$result=$this->Frontamodel->get_data($this->tb3,$where);
			if(count($result)>0)
			{
				foreach($result as $rs)
				{
					$data_json['user_name'] = $rs->user_name;
				}
				$data_json['msg'] = "Valid";
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg'] = "Not Valid";
				$data_json['status']=false;
			}
			
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function apiGetUserNetwork()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$unique_token=$input_data->unique_token;
			$user_id=$this->getUserIdFromToken($unique_token);
			
			$where = array ('reffer_id'=>$user_id);
			$select = "user_name,date_format(insert_date,'%d %b %Y') as insert_date";
			$type='desc';
			$by='user_id ';
			$result=$this->Frontamodel->get_data_select_type($this->tb3,$where,$select,$by,$type);
			if(count($result)>0)
			{
				$data_json['result']=$result;
				$data_json['msg']='Network Data.';
				$data_json['status']=true;
			}else{
				$data_json['msg']='Data Not Found.';
				$data_json['status']=false;
			}
			
		}
		else
		{
			$data_json['msg']='UnAuthorized request';
			$data_json['status']=false;
		}
		echo json_encode($data_json);
	}
	
	public function giveMoneyToReferral($user_id,$amount)
	{
				$where = array('user_id'=>$user_id);
				$result = $this->Frontamodel->get_data_row($this->tb3,$where);
				$wallet_amt=0;
				if($result!='')
				{
					$reffer_id = $result->reffer_id;
					$no_of_payment = $result->no_of_payment;
					$user_name = $result->user_name;
				}
				if($reffer_id!=0)
				{
					$where = array('user_id'=>$reffer_id);
					$ref_result = $this->Frontamodel->get_data_row($this->tb3,$where);
					$wallet_amt=0;
					if($ref_result!='')
					{
						$ref_wallet_amt = $ref_result->wallet_balance;
					}
					
					
					$ref_admin_result = $this->Frontamodel->getDataRow($this->tb52);
					if($ref_admin_result!='')
					{
						$referral_first_bonus = $ref_admin_result->referral_first_bonus;
						$referral_first_bonus_max = $ref_admin_result->referral_first_bonus_max;
						$referral_second_bonus = $ref_admin_result->referral_second_bonus;
						$referral_second_bonus_max = $ref_admin_result->referral_second_bonus_max;
					}
					$ref_amount=0;
					if($no_of_payment==0)
					{
						if($referral_first_bonus>0)
						{
							$ref_amount=$amount*$referral_first_bonus/100;
							
							if($ref_amount>=$referral_first_bonus_max)
							{
								$ref_amount=$referral_first_bonus_max;
							}
						}
						$no_of_payment=1;
					}
					else
					{
						if($referral_second_bonus>0)
						{
							$ref_amount=$amount*$referral_second_bonus/100;
							
							if($ref_amount>=$referral_second_bonus_max)
							{
								$ref_amount=$referral_second_bonus_max;
							}
						}
						$no_of_payment=$no_of_payment+1;
					}
					
					if($ref_amount>0)
					{				
						$ref_amount=round($ref_amount);
						$new_wallet_amt = $ref_wallet_amt + $ref_amount;
						$user_new_balance = array('wallet_balance'=>$new_wallet_amt);
						$where = array('user_id'=>$reffer_id);
						
						$this->Frontcmodel->update_where($this->tb3,$user_new_balance,$where);

						$request_number = $this->randomNumber();
						$history_data_2 = array(
							'user_id' => $reffer_id,
							'ref_downliner_id' => $user_id,
							'amount_added' => $amount,
							'amount' => $ref_amount,
							'transaction_type' => 1,
							'transaction_note' => 'Point '.$ref_amount.' referral bonus from '.$user_name,
							'amount_status' => 20,
							'tx_request_number' => $request_number,
							
							'insert_date' => $this->insert_date
						);
						$this->Frontbmodel->insertData($this->tb14,$history_data_2);
						
						$user_data = array('no_of_payment'=>$no_of_payment);
						$where = array('user_id'=>$user_id);
						
						$this->Frontcmodel->update_where($this->tb3,$user_data,$where);
						
					}
					
				}
	}
	
	
	
}