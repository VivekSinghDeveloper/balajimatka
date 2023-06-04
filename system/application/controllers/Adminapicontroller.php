<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Adminapicontroller extends MY_ApiController {

	public function __construct() {
        parent::__construct();
		
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
	
	public function apiGetDashboardData()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$getUsers = $this->Frontamodel->getData($this->tb3);
				$data_json['totalUsers'] = count($getUsers);
				
				$totalGames = $this->Frontamodel->getData($this->tb16);
				$data_json['totalGames'] = count($totalGames);
				
				$getUnapprovedUsers = $this->Frontamodel->get_data($this->tb3,array('betting_status'=>0));
				$data_json['totalUnapprovedUsers'] = count($getUnapprovedUsers);
				
				$getApprovedUsers = $this->Frontamodel->get_data($this->tb3,array('betting_status !='=>0));
				$data_json['totalApprovedUsers'] = count($getApprovedUsers);
				
				$bid_amt = 0;
				$where = array('bid_date' => $this->cur_date);
				$today_bid = $this->Frontamodel->get_data($this->tb18,$where);
				if(count($today_bid)>0)
				{
					foreach($today_bid as $rs)
					{
						$bid_amt += $rs->points;
					}
					
				}
				$data_json['today_bid_amt'] = $bid_amt;
				
				$where_array=array('status'=>1);
				$select="game_id,game_name";
				$data_json['game_result']=$this->Frontamodel->get_data_select($this->tb16,$where_array,$select);
				
				
				$data_json['msg']='Success';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized  Token request';
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
	
	public function apiGetBidSingleAnk()
	{
		
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
			$game_name=$input_data->game_id;
			$status=$input_data->market_status;
			if($status==2)
			{
				$stat='Close';
				$stat_check='Open';
			}
			else
			{
				$stat='Open';
				$stat_check='Close';

			}
			$where = array('bid_date' => $this->cur_date,'game_id' => $game_name,'session'=>$stat,'pana!='=>'Jodi Digit','pana!='=>'Half Sangam','pana!='=>'Full Sangam');
			$total_zero = 0;
			$total_one = 0;
			$total_two = 0;
			$total_three = 0;
			$total_four = 0;
			$total_five = 0;
			$total_six = 0;
			$total_seven = 0;
			$total_eight = 0;
			$total_nine = 0;
		
			$getBidHistory= $this->Frontamodel->get_data($this->tb18,$where);
			/* echo "<pre>";print_r($getBidHistory);die; */
			$bid_zero=0;
			$bid_one=0;
			$bid_two=0;
			$bid_three=0;
			$bid_four=0;
			$bid_five=0;
			$bid_six=0;
			$bid_seven=0;
			$bid_eight=0;
			$bid_nine=0;
			if(count($getBidHistory)>0)
			{
				foreach($getBidHistory as $rs)
				{
					$win_number = '';
					if($rs->pana == 'Single Pana' || $rs->pana == 'Double Pana' || $rs->pana == 'Triple Pana'){
						$digit_number = $rs->digits;
						$win_number=$digit_number[0]+$digit_number[1]+$digit_number[2];
					}
					else{
						$win_number = $rs->digits;
					}
					
					
					if($win_number>9)
					{
						$win_number=$win_number%10;
					}
					
					if($win_number==0){
					$total_zero += $rs->points; 
					$bid_zero += 1; 
					
					}
					else if($win_number==1){
					$total_one += $rs->points; 
					$bid_one += 1;
					}
					else if($win_number==2){
					$total_two += $rs->points; 
					$bid_two += 1;
					}
					else if($win_number==3){
					$total_three += $rs->points;
					$bid_three += 1;
					}
					else if($win_number==4){
					$total_four += $rs->points; 
					$bid_four += 1;
					}
					else if($win_number==5){
					$total_five += $rs->points; 
					$bid_five += 1;
					}
					else if($win_number==6){
					$total_six += $rs->points; 
					$bid_six += 1;
					}
					else if($win_number==7){
					$total_seven += $rs->points; 
					$bid_seven += 1;
					}
					else if($win_number==8){
					$total_eight += $rs->points; 
					$bid_eight += 1;
					}
					else if($win_number==9){
					$total_nine += $rs->points;
					$bid_nine += 1;				
					}
				}
			}
		
			$data_json['total_zero'] = $total_zero;
			$data_json['total_one'] = $total_one;
			$data_json['total_two'] = $total_two;
			$data_json['total_three'] = $total_three;
			$data_json['total_four'] = $total_four;
			$data_json['total_five'] = $total_five;
			$data_json['total_six'] = $total_six;
			$data_json['total_seven'] = $total_seven;
			$data_json['total_eight'] = $total_eight;
			$data_json['total_nine'] = $total_nine;
			$data_json['bid_zero'] = $bid_zero;
			$data_json['bid_one'] = $bid_one;
			$data_json['bid_two'] = $bid_two;
			$data_json['bid_three'] = $bid_three;
			$data_json['bid_four'] = $bid_four;
			$data_json['bid_five'] = $bid_five;
			$data_json['bid_six'] = $bid_six;
			$data_json['bid_seven'] = $bid_seven;
			$data_json['bid_eight'] = $bid_eight;
			$data_json['bid_nine'] = $bid_nine;
		
			$data_json['msg']='Success';
			$data_json['status']=true;
		 }
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiGetMarketBidAmount()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
						$game_name=$input_data->game_id;
					
					if($game_name == 'all'){
						$where = array('bid_date' => $this->cur_date);
					}else if($game_name != 'all'){
						$where = array('bid_date' => $this->cur_date,'game_id' => $game_name);
					}
					
					$total_points = 0;
					
					$getBidHistory= $this->Frontamodel->get_data($this->tb18,$where);
					if(count($getBidHistory)>0)
					{
						foreach($getBidHistory as $rs)
						{
							$total_points += $rs->points; 
						}
					}
					
					
					$data_json['msg']='Success';
					$data_json['status']=true;
					$data_json['points'] = $total_points;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiAutoFundRequestListData()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$joins = array(
					array(
						'table' => $this->tb3,
						'condition' => $this->tb3.'.user_id = '.$this->tb50.'.user_id',
						'jointype' => 'LEFT'
					)
				);
				$columns = "id,user_name,amount,tx_request_number,fund_status,reject_remark,date_format(".$this->tb50.".insert_date,'%d %b %Y') as insert_date,".$this->tb50.".insert_date,".$this->tb3.".unique_token,txn_id,txn_ref";
				$where=array('fund_status'=>0);
				$by='id ';
				$result = $this->Frontamodel->get_joins_where_desc($this->tb50,$columns,$joins,$where,$by);
				$data_json['msg']='Success';
				$data_json['status']=true;
				$data_json['result'] = $result;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiGetContactSettingData()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$result = $this->Frontamodel->getData($this->tb19);
				$data_json['msg']='Success';
				$data_json['status']=true;
				$data_json['result'] = $result;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiGetUpdateSettingData()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$id=$input_data->id;
				$mobile_1=$input_data->mobile_1;
				$mobile_2=$input_data->mobile_2;
				$whatsapp_no=$input_data->whatsapp_no;
				$landline_1=$input_data->landline_1;
				$landline_2=$input_data->landline_2;
				$email_1=$input_data->email_1;
				$email_2=$input_data->email_2;
				$facebook=$input_data->facebook;
				$twitter=$input_data->twitter;
				$youtube=$input_data->youtube;
				$google_plus=$input_data->google_plus;
				$instagram=$input_data->instagram;
				$latitude=$input_data->latitude;
				$logitude=$input_data->logitude;
				$address=$input_data->address;
				
				$settingsData = array(
				'mobile_1' => $mobile_1,
				'mobile_2' => $mobile_2,
				'whatsapp_no' => $whatsapp_no,
				'landline_1' => $landline_1,
				'landline_2' => $landline_2,
				'email_1' => $email_1,
				'email_2' => $email_2,
				'facebook' => $facebook,
				'twitter' => $twitter,
				'youtube' => $youtube,
				'google_plus' => $google_plus,
				'instagram' => $instagram,
				'latitude' => $latitude,
				'logitude' => $logitude,
				'address' => $address,
				'insert_date'=>$this->insert_date
				);
			
				if($id == '')
				{
					$this->Frontbmodel->insertData($this->tb19,$settingsData);
					$data_json['msg']='Contact Settings Successfully Added';
					$data_json['status']=true;
						
				}else {
					$where = array('id'=>$id);
					$this->Frontcmodel->update_where($this->tb19,$settingsData,$where);
					$data_json['msg']='Contact Settings updated successfully.';
					$data_json['status']=true;
				}
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiGetAdminSettingData()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
			
			$admin_setting = $this->Frontamodel->getData($this->tb4);
		
			$data_json['admin_bank_data']=$admin_setting;
			
			$admin_setting = $this->Frontamodel->getData($this->tb25);
			
			$data_json['admin_app_data']=$admin_setting;
			
			$admin_fix_values = $this->Frontamodel->getData($this->tb15);
			$data_json['admin_fix_values']=$admin_fix_values;
			
			$data_json['msg']='Success';
			$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiUpdateAdminBankDetail()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$id=$input_data->account_id;
				$ac_name=$input_data->ac_name;
				$ac_number=$input_data->ac_number;
				$ifsc_code=$input_data->ifsc_code;
				
				$settingsData = array(
				'ac_holder_name' => ucwords($ac_name),
				'account_number' => $ac_number,
				'ifsc_code' => $ifsc_code,
				'insert_date'=>$this->insert_date
				);
			
				if($id == '')
				{
					$this->Frontbmodel->insertData($this->tb4,$settingsData);
					$data_json['msg']='Bank Details Successfully Added';
					$data_json['status']=true;
						
				}else {
					$where = array('id'=>$id);
					$this->Frontcmodel->update_where($this->tb4,$settingsData,$where);
					$data_json['msg']='Bank Details Successfully Updated.';
					$data_json['status']=true;
				}
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiAddAppMaintainence()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$value_id=$input_data->value_id;
				$app_maintainence_msg=$input_data->app_maintainence_msg;
				$maintainence_msg_status=$input_data->maintainence_msg_status;

				
				$settingsData = array(
				'app_maintainence_msg' => $app_maintainence_msg,
				'maintainence_msg_status' => $maintainence_msg_status,
				);
			
				if($value_id == '')
				{
					$this->Frontbmodel->insertData($this->tb15,$settingsData);
					$data_json['msg']='App Maintainence Data Successfully Added';
					$data_json['status']=true;
						
				}else {
					$where = array('id'=>$value_id);
					$this->Frontcmodel->update_where($this->tb15,$settingsData,$where);
					$data_json['msg']='App Maintainence Data Successfully Added';
					$data_json['status']=true;
				}
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiAddAdminUpiDetailSendOtp()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				
				$select = 'phone';
				$where=array('admin_type'=>1);
				$result = $this->Frontamodel->get_data($this->tb2,$where);
				foreach($result as $rs)
				{
					$mobile = $rs->phone;
				}
				$otp=$this->getOtp($mobile);
				$message=$otp.' use this OTP to verify your UPI-Id for updataion.Please do not share it to anyone';
				$message=$otp;
				$message=$this->replaceSpace($message);
				// $this->sendMessage($mobile,$message);
				$this->sendMessage($mobile,$otp);
				
				$mobile=substr_replace($mobile, 'XXXXXX', 0, 6);
				$data_json['mobile']=$mobile;
				$data_json['upi_otp']=$otp;
				$data_json['msg']='OTP Successfully sent to your registered mobile number enter OTP to verify it.';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiAdminUpiUpdateOtpVerified()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$id=$input_data->account_id;
				$upi_id=$input_data->upi_id;
				$google_upi_payment_id=$input_data->google_upi_payment_id;
				$phonepay_upi_payment_id=$input_data->phonepay_upi_payment_id;
				
				$where = array('id' => $id);
				$result = $this->Frontamodel->get_data($this->tb4,$where);
				
				$settingsData = array(
				'upi_payment_id' => $upi_id,
					'phonepay_upi_payment_id' => $phonepay_upi_payment_id,
					'google_upi_payment_id' => $google_upi_payment_id,
				);
			
				if(count($result)<1)
				{
					$this->Frontbmodel->insertData($this->tb4,$settingsData);
							
				}else 
				{
					$where = array('id'=>$id);
					$this->Frontcmodel->update_where($this->tb4,$settingsData,$where);
				}
				$data = array(
					'upi_id'=>$upi_id,
					'update_date'=>$this->insert_date
				);
				$this->Frontbmodel->insertData($this->tb47,$data);
				$data_json['msg']='UPI Id Successfully Updated...';
				$data_json['status']=true;
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiAddAppLink()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$id=$input_data->id;
				$app_link=$input_data->app_link;
				$content=$input_data->content;
				
				
				$settingsData = array(
				'app_link' => $app_link,
				'content' => $content
				);
			
				if($id == '')
				{
					$this->Frontbmodel->insertData($this->tb25,$settingsData);
					$data_json['msg']='App Link Successfully Added.';
					$data_json['status']=true;
							
				}
				else 
				{
					$where = array('id'=>$id);
					$this->Frontcmodel->update_where($this->tb25,$settingsData,$where);
					$data_json['msg']='App Link Successfully Updated.';
					$data_json['status']=true;
				}
				
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiAddAdminFixValues()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$value_id=$input_data->value_id;
				$min_deposite=$input_data->min_deposite;
				$max_deposite=$input_data->max_deposite;
				$min_withdrawal=$input_data->min_withdrawal;
				$max_withdrawal=$input_data->max_withdrawal;
				$min_transfer=$input_data->min_transfer;
				$max_transfer=$input_data->max_transfer;
				$min_bid_amt=$input_data->min_bid_amt;
				$max_bid_amt=$input_data->max_bid_amt;
				$welcome_bonus=$input_data->welcome_bonus;
				$withdraw_open_time=$input_data->withdraw_open_time;
				$withdraw_close_time=$input_data->withdraw_close_time;
				$global_batting_status=$input_data->global_batting_status;
				
							
				$settingsData = array(
				'min_deposite' => $min_deposite,
				'max_deposite' => $max_deposite,
				'min_withdrawal' => $min_withdrawal,
				'max_withdrawal' => $max_withdrawal,
				'min_transfer' => $min_transfer,
				'max_transfer' => $max_transfer,
				'min_bid_amount' => $min_bid_amt,
				'max_bid_amount' => $max_bid_amt,
				'welcome_bonus' => $welcome_bonus,
				'withdraw_open_time' => $withdraw_open_time,
				'withdraw_close_time' => $withdraw_close_time,
				'global_batting_status' => $global_batting_status,
				'insert_date'=>$this->insert_date
				);
			
				if($value_id == '')
				{
					$this->Frontbmodel->insertData($this->tb15,$settingsData);
					$data_json['msg']='Values Successfully Added.';
					$data_json['status']=true;
							
				}
				else 
				{
					$where = array('id'=>$value_id);
					$this->Frontcmodel->update_where($this->tb15,$settingsData,$where);
					$data_json['msg']='Values Successfully Updated.';
					$data_json['status']=true;
				}
				
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiGetRatesList()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$game_rates = $this->Frontamodel->getData($this->tb10);
				$data_json['game_rates']=$game_rates;
				$data_json['msg']='Success';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiUpdateRatesList()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$game_rate_id=$input_data->game_rate_id;
				$single_digit_val_1=$input_data->single_digit_val_1;
				$single_digit_val_2=$input_data->single_digit_val_2;
				$jodi_digit_val_1=$input_data->jodi_digit_val_1;
				$jodi_digit_val_2=$input_data->jodi_digit_val_2;
				$single_pana_val_1=$input_data->single_pana_val_1;
				$single_pana_val_2=$input_data->single_pana_val_2;
				$double_pana_val_1=$input_data->double_pana_val_1;
				$double_pana_val_2=$input_data->double_pana_val_2;
				$tripple_pana_val_1=$input_data->tripple_pana_val_1;
				$tripple_pana_val_2=$input_data->tripple_pana_val_2;
				$half_sangam_val_1=$input_data->half_sangam_val_1;
				$half_sangam_val_2=$input_data->half_sangam_val_2;
				$full_sangam_val_1=$input_data->full_sangam_val_1;
				$full_sangam_val_2=$input_data->full_sangam_val_2;
				
							
				$settingsData = array(
				'single_digit_val_1' => $single_digit_val_1,
				'single_digit_val_2' => $single_digit_val_2,
				'jodi_digit_val_1' => $jodi_digit_val_1,
				'jodi_digit_val_2' => $jodi_digit_val_2,
				'single_pana_val_1' => $single_pana_val_1,
				'single_pana_val_2' => $single_pana_val_2,
				'double_pana_val_1' => $double_pana_val_1,
				'double_pana_val_2' => $double_pana_val_2,
				'tripple_pana_val_1' => $tripple_pana_val_1,
				'tripple_pana_val_2' => $tripple_pana_val_2,
				'half_sangam_val_1' => $half_sangam_val_1,
				'half_sangam_val_2' => $half_sangam_val_2,
				'full_sangam_val_1' => $full_sangam_val_1,
				'full_sangam_val_2' => $full_sangam_val_2,
				);
			
				if($game_rate_id == '')
				{
					$this->Frontbmodel->insertData($this->tb10,$settingsData);
					$data_json['msg']='Game Rates Successfully Added.';
					$data_json['status']=true;
							
				}
				else 
				{
					$where = array('game_rate_id'=>$game_rate_id);
					$this->Frontcmodel->update_where($this->tb10,$settingsData,$where);
					$data_json['msg']='Game Rates Successfully Updated.';
					$data_json['status']=true;
				}
				
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiGameNameList()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$joins = array(
					array(
						'table' => $this->tb48,
						'condition' => $this->tb48.'.game_id = '.$this->tb16.".game_id && name='".date('l')."'",
						'jointype' => 'LEFT'
					)
				);
				$columns = $this->tb16.".game_id,game_name,game_name_hindi,".$this->tb48.".open_time,status,".$this->tb48.".close_time,market_status,weekday_status";
				$where=array();
				$by='game_id';
				$result = $this->Frontamodel->get_joins_where_desc($this->tb16,$columns,$joins,$where,$by);
				
				$data_json['game_name_result']=$result;
				$data_json['msg']='Success';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiActiveInactiveGame()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$game_id=$input_data->game_id;
				$status=$input_data->status;
						
				if($status=='1')
				{
					$status='0';				
				}
				else
				{
					$status='1';				
				}		
				$updateData = array(
				'status' => $status,
				);
				$where = array('game_id'=>$game_id);
				$this->Frontcmodel->update_where($this->tb16,$updateData,$where);
				$data_json['msg']='Game Market Status Successfully Changed.';
				$data_json['status']=true;
				
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiUpdateGameTime()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$game_id=$input_data->game_id;
				$result=$input_data->result;
				
				if(count($result)>0)
				{
					foreach($result as $rs)
					{
						$weekday_id=$rs->weekday_id;
					
						$open_time=$rs->open_time;
						$close_time=$rs->close_time;
						$weekday_status=$rs->status;
						
						$up_data = array(
						'open_time' => date('h:i A', strtotime($open_time)),
						'open_time_sort' => date('H:i:s', strtotime($open_time)),
						'close_time' => date('h:i A', strtotime($close_time)),
						'weekday_status' => $weekday_status
						);
					$where = array('weekday_id'=>$weekday_id);
					$this->Frontcmodel->update_where($this->tb48,$up_data,$where);
					}
				}
				
				$data_json['msg']='Game Details Successfully Changed.';
				$data_json['status']=true;
				
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiGameNameUpdate()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$game_id=$input_data->game_id;
				$game_name=$input_data->game_name;
				$game_name_hindi=$input_data->game_name_hindi;
						
					
				$updateData = array(
				'game_name' => $game_name,
				'game_name_hindi' => $game_name_hindi,
				);
				$where = array('game_id'=>$game_id);
				$this->Frontcmodel->update_where($this->tb16,$updateData,$where);
				$data_json['msg']='Game Name Successfully Updated.';
				$data_json['status']=true;
				
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiGameNameAdd()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$game_name=$input_data->game_name;
				$game_name_hindi=$input_data->game_name_hindi;
				$open_time=$input_data->open_time;
				$close_time=$input_data->close_time;
						
				$where_array=array('game_name' => $game_name);
				$result=$this->Frontamodel->get_data($this->tb16,$where_array);
				
				if(count($result)>0)
				{
					$data_json['msg']='Game already Added.';
					$data_json['status']=true;
				}
				else
				{
					$insert_data = array(
					'game_name' => $game_name,
					'game_name_hindi' => $game_name_hindi,
					'open_time' => date('h:i A', strtotime($open_time)),
				
					'open_time_sort' => date('H:i:s', strtotime($open_time)),
					'close_time' => date('h:i A', strtotime($close_time)),
					);
					$this->Frontbmodel->insertData($this->tb16,$insert_data);
					
					$game_id=$this->db->insert_id();
					$array=array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
					
					for($i=0;$i<7;$i++)
					{
						$game_data = array(
							'game_id' => $game_id,
							'name' => $array[$i],
							'week_name' => strtolower($array[$i]),
							'open_time' => date('h:i A', strtotime($open_time)),
							'open_time_sort' => date('H:i:s', strtotime($open_time)),
							'close_time' => date('h:i A', strtotime($close_time)),
							'weekday_status' => 1,
						);
						$this->Frontbmodel->insertData($this->tb48,$game_data);
					}
					
					$data_json['msg']='Game Name Successfully Added.';
					$data_json['status']=true;
				}
				
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	
	
	public function apiGetGameMarketOffDayData()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$game_id=$input_data->game_id;
				$where_array = array('game_id'=>$game_id);
				$week_off_day_data = $this->Frontamodel->get_data($this->tb48,$where_array);
				$data_json['week_off_day_data']=$week_off_day_data;
				$data_json['msg']='Success';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	
	public function apiGetGameListDropdown()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$where_array=array('status'=>1);
				$select="game_id,game_name";
				$game_array=$this->Frontamodel->get_data_select($this->tb16,$where_array,$select);
				
				$data_json['game_array']=$game_array;
				$data_json['msg']='Success';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiGetMainGameUserBidHistory()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$bid_date=$input_data->bid_date;
				$game_name=$input_data->game_id;
				$game_type=$input_data->game_type;
				$page=$input_data->page;
				
				$bid_date = date('Y-m-d',strtotime($bid_date));
		
				if($game_name == 'all' && $game_type == 'all'){
					$where = array('bid_date' => $bid_date);
				}else if($game_name == 'all' && $game_type != 'all'){
					$where = array('bid_date' => $bid_date,'pana' => $game_type);
				}else if($game_name != 'all' && $game_type == 'all'){
					$where = array('bid_date' => $bid_date,'game_id' => $game_name);
				}else if($game_name != 'all' && $game_type != 'all'){
					$where = array('bid_date' => $bid_date,'game_id' => $game_name,'pana' => $game_type);
				}
				
				$start = 0; 
				$limit = 20; 
				
				$total=count($this->Frontamodel->get_data($this->tb37,$where));
				
				 $page_limit = $total/$limit; 
				 
				 $start = ($page - 1) * $limit;
				
				$joins = array(
							array(
								'table' => $this->tb3,
								'condition' => $this->tb3.'.user_id = '.$this->tb18.'.user_id',
								'jointype' => 'LEFT'
							)
						);
				$columns="user_name,".$this->tb3.".unique_token,game_name,bid_id,pana,session,digits,closedigits,points,bid_tx_id,pay_status";
				$by = 'bid_id';
				
				$getBidHistory = $this->Frontamodel->get_joins_where_desc_scroll($this->tb18,$columns, $joins,$where,$by,$start,$limit);
				$data_json['getBidHistory']=$getBidHistory;
				$data_json['msg']='Success';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	
	public function apiGetUserList()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$page=$input_data->page;
				$where = array();
				
				$start = 0; 
				$limit = 20; 
				
				$total=count($this->Frontamodel->get_data($this->tb3,$where));
				
				 $page_limit = $total/$limit; 
				 
				 $start = ($page - 1) * $limit;
				
				$columns="unique_token,user_name,mobile,email,wallet_balance,betting_status,transfer_point_status,status,date_format(insert_date,'%d %b %Y') as insert_date ";
				$by = 'user_id';
				
				$user_list = $this->Frontamodel->get_where_desc_scroll($this->tb3,$columns,$where,$by,$start,$limit);
				$data_json['user_list']=$user_list;
				$data_json['msg']='Success';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiGetUnapprovedUserList()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$page=$input_data->page;
				$where = array('betting_status' => 0);
				
				$start = 0; 
				$limit = 20; 
				
				$total=count($this->Frontamodel->get_data($this->tb3,$where));
				
				 $page_limit = $total/$limit; 
				 
				 $start = ($page - 1) * $limit;
				
				$columns="unique_token,user_name,mobile,email,wallet_balance,betting_status,transfer_point_status,status,date_format(insert_date,'%d %b %Y') as insert_date ";
				$by = 'user_id';
				
				$user_list = $this->Frontamodel->get_where_desc_scroll($this->tb3,$columns,$where,$by,$start,$limit);
				$data_json['user_list']=$user_list;
				$data_json['msg']='Success';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiChangeUserBettingStatus()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$unique_token=$input_data->unique_token;
				$betting_status=$input_data->betting_status;
						
				if($betting_status=='1')
				{
					$betting_status='0';				
				}
				else
				{
					$betting_status='1';				
				}		
				$updateData = array(
				'betting_status' => $betting_status,
				);
				$where = array('unique_token'=>$unique_token);
				$this->Frontcmodel->update_where($this->tb3,$updateData,$where);
				$data_json['msg']='Betting Status Successfully Changed.';
				$data_json['status']=true;
				
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiChangeUserTransferStatus()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$unique_token=$input_data->unique_token;
				$transfer_point_status=$input_data->transfer_point_status;
						
				if($transfer_point_status=='1')
				{
					$transfer_point_status='0';				
				}
				else
				{
					$transfer_point_status='1';				
				}		
				$updateData = array(
				'transfer_point_status' => $transfer_point_status,
				);
				$where = array('unique_token'=>$unique_token);
				$this->Frontcmodel->update_where($this->tb3,$updateData,$where);
				$data_json['msg']='Transfer Status Successfully Changed.';
				$data_json['status']=true;
				
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiChangeUserActiveStatus()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$unique_token=$input_data->unique_token;
				$status=$input_data->status;
						
				if($status=='1')
				{
					$status='0';				
				}
				else
				{
					$status='1';				
				}		
				$updateData = array(
				'status' => $status,
				);
				$where = array('unique_token'=>$unique_token);
				$this->Frontcmodel->update_where($this->tb3,$updateData,$where);
				$data_json['msg']='Active Status Successfully Changed.';
				$data_json['status']=true;
				
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiGetCustomerSellReport()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$start_date=$input_data->start_date;
				$session=$input_data->session;
				$game_name=$input_data->game_id;
				$game_type=$input_data->game_type;
				
				$start_date=date('Y-m-d',strtotime($start_date));
						
				if($game_type == "all")
				{
					$order_by = "total_points";
					$group_by='numbers';
					$joins = array(
						array(
								'table' => $this->tb18,
								'condition' => $this->tb18.'.digits = '.$this->tb26.'.single_digit && '.$this->tb18.'.session="'.$session.'" && 	bid_date="'.$start_date.'" && game_id="'.$game_name.'"',
								'jointype' => 'LEFT'
							)
						);
						
					$select='id,single_digit as numbers,IFNULL(sum(points),0) as total_points';
					$singe_digit_result=$this->Frontamodel->get_joins_group_by($this->tb26,$select,$joins,$order_by,$group_by);
					
					if($session=='Open')
					{				
					  $order_by1 = "total_points";
						$group_by1='numbers';
						$joins1 = 
						 array(
						array(

								'table' => $this->tb18,
								'condition' => $this->tb18.'.digits = '.$this->tb27.'.jodi_digit && '.$this->tb18.'.bid_date="'.$start_date.'" && game_id="'.$game_name.'"',
								'jointype' => 'LEFT'
							)
							);
						$select1='id,jodi_digit as numbers,IFNULL(sum(points),0) as total_points';
						$jodi_digit_result=$this->Frontamodel->get_joins_group_by($this->tb27,$select1,$joins1,$order_by1,$group_by1); 
					}
					 else
					 {
						
						$order_by = "total_points";
						$where=array("result_date" => $start_date,"game_id" => $game_name);
						
						$game_result=$this->Frontamodel->get_data($this->tb21,$where);
						
						if(count($game_result)>0)
						{	
						
						foreach($game_result as $rs)
						{
							$open_num=$rs->open_number[0]+$rs->open_number[1]+$rs->open_number[2];
							if($open_num<10)
							$number=$open_num;
							
							if($open_num>9)
							$number=$open_num%10;
						}
						
						$where=array("bid_date" => $start_date,"game_id" => $game_name, "pana" => 'Jodi Digit');
						///echo $number;die;
						$group_by='numbers';
						$select='digits as numbers,IFNULL(sum(points),0) as total_points';
						//$number='1';
						$jodi_digit_result=$this->Frontamodel->getJodiDigitSell($this->tb18,$order_by,$where,$select,$group_by,$number); 
						}
						else
						{
							$jodi_digit_result=array();
						}
					}
					
					$joins2 = 
					 array(
					array(

							'table' => $this->tb18,
							'condition' => $this->tb18.'.digits = '.$this->tb31.'.numbers && '.$this->tb18.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id="'.$game_name.'"',
							'jointype' => 'LEFT'
						)
						);
					$select2='id,numbers,IFNULL(sum(points),0) as total_points';
					$double_result=$this->Frontamodel->get_joins_group_by($this->tb31,$select2,$joins2,$order_by,$group_by);
					
					
					$joins3 = 
					 array(
					array(

							'table' => $this->tb18,
							'condition' => $this->tb18.'.digits = '.$this->tb28.'.numbers && '.$this->tb18.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id="'.$game_name.'"',
							'jointype' => 'LEFT'
						)
						);
					$select3='id,numbers,IFNULL(sum(points),0) as total_points';
					$single_pana_result=$this->Frontamodel->get_joins_group_by($this->tb28,$select3,$joins3,$order_by,$group_by);
					
					
					$joins4 = 
					 array(
					array(

							'table' => $this->tb18,
							'condition' => $this->tb18.'.digits = '.$this->tb29.'.numbers && '.$this->tb18.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id="'.$game_name.'"',
							'jointype' => 'LEFT'
						)
						);
					$select4='id,numbers,IFNULL(sum(points),0) as total_points';
					$triple_pana_result=$this->Frontamodel->get_joins_group_by($this->tb29,$select4,$joins4,$order_by,$group_by);
					
					
					
					$select='bid_id as id,CONCAT_WS("-",digits,closedigits) as numbers,points as total_points';
					$where = array("bid_date" => $start_date,"game_id" => $game_name,'pana'=>'Half Sangam','session'=>$session);
					$half_sangam_result=$this->Frontamodel->get_data_select($this->tb18,$where,$select);
					
						$select='bid_id as id,CONCAT_WS("-",digits,closedigits) as numbers,points as total_points';
					$where = array("bid_date" => $start_date,"game_id" => $game_name,'pana'=>'Full Sangam');
					$full_sangam_result=$this->Frontamodel->get_data_select($this->tb18,$where,$select);
					
					$all_result[]['single_digit'] = $singe_digit_result;
					 $all_result[]['jodi_digit']=$jodi_digit_result;
					 $all_result[]['single_pana'] = $single_pana_result;
					 $all_result[]['double_pana'] = $double_result;
					 $all_result[]['triple_pana'] = $triple_pana_result;
					 $all_result[]['half_sangam'] = $half_sangam_result;
					 $all_result[]['full_sangam'] = $full_sangam_result;
					
					$data_json['result']=$all_result;		    
						$data_json['msg']='Success.';
						$data_json['status']=true;			
				}
				else 
				{
					if($game_type=="Single Digit"){
					$order_by = "total_points";
					$group_by='numbers';
					$joins = array(
						array(
								'table' => $this->tb18,
								'condition' => $this->tb18.'.digits = '.$this->tb26.'.single_digit && '.$this->tb18.'.session="'.$session.'" && 	bid_date="'.$start_date.'" && game_id="'.$game_name.'"',
								'jointype' => 'LEFT'
							)
						);
						
					$select='id,single_digit as numbers,IFNULL(sum(points),0) as total_points';
					$all_result[]['single_digit']=$this->Frontamodel->get_joins_group_by($this->tb26,$select,$joins,$order_by,$group_by);
					}
					else if($game_type=="Jodi Digit")
					{
						if($session=='Open')
						{				
						  $order_by1 = "total_points";
							$group_by1='numbers';
							$joins1 = 
							 array(
							array(

									'table' => $this->tb18,
									'condition' => $this->tb18.'.digits = '.$this->tb27.'.jodi_digit && '.$this->tb18.'.bid_date="'.$start_date.'" && game_id="'.$game_name.'"',
									'jointype' => 'LEFT'
								)
								);
							$select1='id,jodi_digit as numbers,IFNULL(sum(points),0) as total_points';
							$all_result[]['jodi_digit']=$this->Frontamodel->get_joins_group_by($this->tb27,$select1,$joins1,$order_by1,$group_by1); 
						}
						 else
						 {
							
							$order_by = "total_points";
							$where=array("result_date" => $start_date,"game_id" => $game_name);
							
							$game_result=$this->Frontamodel->get_data($this->tb21,$where);
							
							if(count($game_result)>0)
							{	
							
							foreach($game_result as $rs)
							{
								$open_num=$rs->open_number[0]+$rs->open_number[1]+$rs->open_number[2];
								if($open_num<10)
								$number=$open_num;
								
								if($open_num>9)
								$number=$open_num%10;
							}
							
							$where=array("bid_date" => $start_date,"game_id" => $game_name, "pana" => 'Jodi Digit');
							///echo $number;die;
							$group_by='numbers';
							$select='digits as numbers,IFNULL(sum(points),0) as total_points';
							//$number='1';
							$all_result[]['jodi_digit']=$this->Frontamodel->getJodiDigitSell($this->tb18,$order_by,$where,$select,$group_by,$number); 
							}
							else
							{
								$all_result[]['jodi_digit']=array();
							}
						}
					}
					else if($game_type=="Double Pana")
					{
						$order_by = "total_points";
						$group_by='numbers';
						$joins2 = 
						 array(
						array(

								'table' => $this->tb18,
								'condition' => $this->tb18.'.digits = '.$this->tb31.'.numbers && '.$this->tb18.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id="'.$game_name.'"',
								'jointype' => 'LEFT'
							)
							);
						$select2='id,numbers,IFNULL(sum(points),0) as total_points';
						$all_result[]['double_pana']=$this->Frontamodel->get_joins_group_by($this->tb31,$select2,$joins2,$order_by,$group_by);
					}
					else if($game_type=="Single Pana"){
						$order_by = "total_points";
						$group_by='numbers';
					$joins3 = 
					 array(
					array(

							'table' => $this->tb18,
							'condition' => $this->tb18.'.digits = '.$this->tb28.'.numbers && '.$this->tb18.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id="'.$game_name.'"',
							'jointype' => 'LEFT'
						)
						);
					$select3='id,numbers,IFNULL(sum(points),0) as total_points';
					$all_result[]['single_pana']=$this->Frontamodel->get_joins_group_by($this->tb28,$select3,$joins3,$order_by,$group_by);
					}
					else if($game_type=="Triple Pana"){
					$order_by = "total_points";
						$group_by='numbers';
					$joins4 = 
					 array(
					array(

							'table' => $this->tb18,
							'condition' => $this->tb18.'.digits = '.$this->tb29.'.numbers && '.$this->tb18.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id="'.$game_name.'"',
							'jointype' => 'LEFT'
						)
						);
					$select4='id,numbers,IFNULL(sum(points),0) as total_points';
					$all_result[]['triple_pana']=$this->Frontamodel->get_joins_group_by($this->tb29,$select4,$joins4,$order_by,$group_by);
					}
					else if($game_type=="Half Sangam"){
					$select='bid_id as id,CONCAT_WS("-",digits,closedigits) as numbers,points as total_points';
					$where = array("bid_date" => $start_date,"game_id" => $game_name,'pana'=>'Half Sangam','session'=>$session);
					$all_result[]['half_sangam']=$this->Frontamodel->get_data_select($this->tb18,$where,$select);
					}
					else if($game_type=="Full Sangam"){
						$select='bid_id as id,CONCAT_WS("-",digits,closedigits) as numbers,points as total_points';
					$where = array("bid_date" => $start_date,"game_id" => $game_name,'pana'=>'Full Sangam');
					$all_result[]['full_sangam']=$this->Frontamodel->get_data_select($this->tb18,$where,$select);
					}
					
					$data_json['result']=$all_result;		    
						$data_json['msg']='Success.';
						$data_json['status']=true;			
				}
		
		
			
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiGetViewUserProfile()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$unique_token=$input_data->unique_token;
				$where=array($this->tb3.'.unique_token'=>$unique_token);
				$joins = array(
						array(
							'table' => $this->tb8,
							'condition' => $this->tb8.'.user_id = '.$this->tb3.'.user_id',
							'jointype' => 'LEFT'
						),
						array(
							'table' => $this->tb9,
							'condition' => $this->tb9.'.user_id = '.$this->tb3.'.user_id',
							'jointype' => 'LEFT'
						),
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
				$columns = "user_name,mobile,email,password,security_pin,wallet_balance,DATE_FORMAT(".$this->tb3.".insert_date,'%d %b %Y %r') as insert_date,".$this->tb3.".status,IFNULL(bank_name,'') as bank_name,IFNULL(branch_address,'') as branch_address,IFNULL(ac_holder_name,'') as ac_holder_name,IFNULL(ac_number,'') as ac_number,IFNULL(ifsc_code,'') as ifsc_code,		IFNULL(paytm_number,'') as paytm_number,IFNULL(google_pay_number,'') as google_pay_number,IFNULL(phone_pay_number,'') as phone_pay_number,IFNULL(flat_ploat_no,'') as flat_ploat_no,IFNULL(address_lane_1,'') as address_lane_1,IFNULL(address_lane_2,'') as address_lane_2,IFNULL(area,'') as area,IFNULL(pin_code,'') as pin_code,IFNULL(state_name,'') as state_name,IFNULL(district_name,'') as district_name,".$this->tb3.".unique_token,date_format(last_update,'%d %b %Y %r') as last_update,betting_status,transfer_point_status";
				$getDetail = $this->Frontamodel->get_joins_where($this->tb3,$columns,$joins,$where);
				if(count($getDetail)>0)
				{
					foreach($getDetail as $rs)
					{
						
						$rs->password = $this->decType($rs->password);
						
					}
				}
				$data_json['getUserDetail'] = $getDetail;
				$data_json['msg']='Success';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiChangeLogoutStatus()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$unique_token=$input_data->unique_token;
				
				$user_id=$this->getUserIdFromToken($unique_token);
				$where = array('user_id' => $user_id);
				$updateData = array('logout_status'=>1);
				$this->Frontcmodel->update_where($this->tb51,$updateData,$where);
				$data_json['msg']='User Successfully logged out.';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiChangeSecurityPin()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$unique_token=$input_data->unique_token;
				$security_pin=$input_data->security_pin;
				
				$where = array('unique_token' => $unique_token);
				$updateData = array('security_pin'=>$security_pin);
				$this->Frontcmodel->update_where($this->tb3,$updateData,$where);
				
				$user_id=$this->getUserIdFromToken($unique_token);
				$where = array('user_id' => $user_id);
				$updateData = array('security_pin_status'=>1);
				$this->Frontcmodel->update_where($this->tb51,$updateData,$where);
				
				$data_json['msg']='Security PIN Successfully Changed.';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiAddFundToUser()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$unique_token=$input_data->unique_token;
				$user_amount=$input_data->user_amount;
				
				$where = array('unique_token' => $unique_token);
				
				$result = $this->Frontamodel->get_data_row($this->tb3,$where);
				if($result != '')
				{
					$wallet_balance = $result->wallet_balance;
					$user_id = $result->user_id;
				}
				$wallet_balance += $user_amount;
				$updateData = array('wallet_balance'=>$wallet_balance);
				$this->Frontcmodel->update_where($this->tb3,$updateData,$where);
				
				$request_number = $this->randomNumber();
				$history_data = array(
					'user_id' => $user_id,
					'amount' => $user_amount,
					'transaction_type' => 1,
					'transaction_note' => 'Amount Added By Admin',
					'amount_status' => 1,
					'tx_request_number' => $request_number,
					'insert_date' => $this->insert_date
				);
				$this->Frontbmodel->insertData($this->tb14,$history_data);
				$data_json['msg']='Amount successfully added.';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiWitdrawFundFromUser()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$unique_token=$input_data->unique_token;
				$user_amount=$input_data->user_amount;
				
				$where = array('unique_token' => $unique_token);
				
				$result = $this->Frontamodel->get_data_row($this->tb3,$where);
				if($result != '')
				{
					$wallet_balance = $result->wallet_balance;
					$user_id = $result->user_id;
				}
				$wallet_balance = $wallet_balance-$user_amount;
				
				if($wallet_balance<0)
				{
					$data_json['msg']='User amount is going negative';
					$data_json['status']=false;
					echo json_encode($data_json);die;
				}
		
				$updateData = array('wallet_balance'=>$wallet_balance);
				$this->Frontcmodel->update_where($this->tb3,$updateData,$where);
				
				$request_number = $this->randomNumber();
				$history_data = array(
					'user_id' => $user_id,
					'amount' => $user_amount,
					'transaction_type' => 2,
					'transaction_note' => 'Amount Withdraw By Admin',
					'amount_status' => 2,
					'tx_request_number' => $request_number,
					'insert_date' => $this->insert_date
				);
				$this->Frontbmodel->insertData($this->tb14,$history_data);
				$data_json['msg']='Amount successfully withdraw.';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiAcceptAutoFundRequest()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$id = $input_data->id;
				
				$where_id = array('id' => $id);
				$result = $this->Frontamodel->get_data_row($this->tb50,$where_id);
				if($result != '')
				{
					$user_id = $result->user_id;
					$amount = $result->amount;
					$status = $result->fund_status;
					$tx_request_number = $result->tx_request_number;
					$txn_id = $result->txn_id;
				}
				
				$where = array('user_id' => $user_id);
				
				$result = $this->Frontamodel->get_data_row($this->tb3,$where);
				if($result != '')
				{
					$wallet_balance = $result->wallet_balance;
					$user_id = $result->user_id;
				}
				$wallet_balance += $amount;
				$updateData = array('wallet_balance'=>$wallet_balance);
				$this->Frontcmodel->update_where($this->tb3,$updateData,$where);
				
				$request_status_data = array (
				'fund_status' => 1
				);
				$this->Frontcmodel->update_where($this->tb50,$request_status_data,$where_id);
				
				$request_number = $this->randomNumber();
				$history_data = array(
					'user_id' => $user_id,
					'amount' => $amount,
					'transaction_type' => 1,
					'transaction_note' => 'Auto Deposit Request No.'.$tx_request_number.' Processed',
					'amount_status' => 19,
					'tx_request_number' => $txn_id,
					'insert_date' => $this->insert_date
				);
				$this->Frontbmodel->insertData($this->tb14,$history_data);
				$data_json['msg']='Request Successfully Accepted.';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiRejectAutoFundRequest()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$id = $input_data->id;
				$reject_auto_remark = $input_data->reject_auto_remark;
				
				$where_id = array('id' => $id);
				
				$request_status_data = array (
				'fund_status' => 2,
				'reject_remark' => $reject_auto_remark
				);
				$this->Frontcmodel->update_where($this->tb50,$request_status_data,$where_id);

				$data_json['msg']='Request Rejected.';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apidDeleteAutoRequestDepo()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$id = $input_data->id;
				$where = array('id' => $id);
				$this->Frontdmodel->delete($this->tb50,$where);

				$data_json['msg']='Request Deleted.';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiUserAutoFundRequestListData()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$unique_token=$input_data->unique_token;
				$joins = array(
					array(
						'table' => $this->tb3,
						'condition' => $this->tb3.'.user_id = '.$this->tb50.'.user_id',
						'jointype' => 'LEFT'
					)
				);
				
				$user_id=$this->getUserIdFromToken($unique_token);
				$columns = "id,user_name,amount,tx_request_number,fund_status,reject_remark,date_format(".$this->tb50.".insert_date,'%d %b %Y') as insert_date,".$this->tb50.".insert_date,".$this->tb3.".unique_token,txn_id,txn_ref";
				$where=array('fund_status'=>0,$this->tb50.'.user_id'=>$user_id);
				$by='id ';
				$result = $this->Frontamodel->get_joins_where_desc($this->tb50,$columns,$joins,$where,$by);
				$data_json['msg']='Success';
				$data_json['status']=true;
				$data_json['result'] = $result;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiUserWithdrawRequestListData()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$unique_token=$input_data->unique_token;
				
				$user_id=$this->getUserIdFromToken($unique_token);
				
				$where = array('user_id' => $user_id);
				$select = 'withdraw_request_id,request_amount,request_number,request_status,payment_receipt,DATE_FORMAT(insert_date,"%d %b %Y %r") as insert_date';
				$by = 'withdraw_request_id';
				$data_json['withdrawrequestData'] = $this->Frontamodel->get_data_latest_where_desc($this->tb11,$where,$by,$select);
				
				$data_json['msg']='Success';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiUserViewWithdrawRequest()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$withdraw_request_id=$input_data->withdraw_request_id;
				
				$where = array ('withdraw_request_id' => $withdraw_request_id);
				
				$joins = array(
						array(
							'table' => $this->tb3,
							'condition' => $this->tb3.'.user_id = '.$this->tb11.'.user_id',
							'jointype' => 'LEFT'
						),
						array(
							'table' => $this->tb14,
							'condition' => $this->tb14.'.tx_request_number = '.$this->tb11.'.request_number',
							'jointype' => 'LEFT'
						)
					);
				$columns="user_name,request_amount,request_number,request_status,payment_method,bank_name,branch_address
				,ac_holder_name,ac_number,ifsc_code,paytm_number,google_pay_number,phone_pay_number,payment_receipt,DATE_FORMAT(".$this->tb11.".insert_date,'%d %b %Y %r') as insert_date,withdraw_request_id,".$this->tb11.".user_id,remark,DATE_FORMAT(".$this->tb14.".insert_date,'%d %b %Y %r') as accepte_date";
				$withdrawRequestDetails = $this->Frontamodel->get_joins_where($this->tb11,$columns,$joins,$where);
				
				$data_json['withdrawRequestDetails']=$withdrawRequestDetails;
				$data_json['msg']='Success';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiGetMainGameParticularUserBidHistory()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$unique_token=$input_data->unique_token;
				
				$user_id=$this->getUserIdFromToken($unique_token);
				
				$where = array($this->tb18.'.user_id' => $user_id);
				$page=$input_data->page;				
				$start = 0; 
				$limit = 20; 
				
				$total=count($this->Frontamodel->get_data($this->tb18,$where));
				
				 $page_limit = $total/$limit; 
				 
				 $start = ($page - 1) * $limit;
				
				$joins = array(
							array(
								'table' => $this->tb3,
								'condition' => $this->tb3.'.user_id = '.$this->tb18.'.user_id',
								'jointype' => 'LEFT'
							)
						);
				$columns="user_name,".$this->tb3.".unique_token,game_name,bid_id,pana,session,digits,closedigits,points,bid_tx_id,pay_status";
				$by = 'bid_id';
				
				$getBidHistory = $this->Frontamodel->get_joins_where_desc_scroll($this->tb18,$columns, $joins,$where,$by,$start,$limit);
				$data_json['getBidHistory']=$getBidHistory;
				$data_json['msg']='Success';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiGetUserWalletHistory()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$unique_token=$input_data->unique_token;
				
				$user_id=$this->getUserIdFromToken($unique_token);
				
				$where = array('user_id' => $user_id);
				$page=$input_data->page;				
				$start = 0; 
				$limit = 20; 
				
				$total=count($this->Frontamodel->get_data($this->tb14,$where));
				
				 $page_limit = $total/$limit; 
				 
				 $start = ($page - 1) * $limit;
				
				$select = "transaction_id,amount,transaction_type,transaction_note,transfer_note,amount_status,date_format(insert_date,'%d %b %Y %r') as insert_date,tx_request_number";
				$by = 'transaction_id';
				$wallet_history = $this->Frontamodel->get_where_desc_scroll($this->tb14,$select,$where,$by,$start,$limit);
				
				$data_json['wallet_history']=$wallet_history;
				$data_json['msg']='Success';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiGetUserWinningHistory()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$unique_token=$input_data->unique_token;
				$winning_date=$input_data->winning_date;
				
				$user_id=$this->getUserIdFromToken($unique_token);
				
				$page=$input_data->page;				
				$start = 0; 
				$limit = 20; 
				$winning_date = date('Y-m-d',strtotime($winning_date));
				
				
				$where = array('user_id'=>$user_id,'DATE('.$this->tb14.'.insert_date)' => $winning_date,'amount_status'=>8);
				$total=count($this->Frontamodel->get_data($this->tb14,$where));
				
				 $page_limit = $total/$limit; 
				 
				 $start = ($page - 1) * $limit;
				
				$select="amount,transaction_note,tx_request_number,date_format(insert_date,'%d %b %Y %r') as insert_date";
				$by = 'transaction_id';
				$winning_history = $this->Frontamodel->get_where_desc_scroll($this->tb14,$select,$where,$by,$start,$limit);
				
				$data_json['winning_history']=$winning_history;
				$data_json['msg']='Success';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiGetSearchUserList()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$search_type=$input_data->search_type;
				$search_value=$input_data->search_value;
				
				$page=$input_data->page;
				$where = array();
				
				$start = 0; 
				$limit = 20; 
				
				if($search_type==1)
				$like_col='user_name';
				else
				$like_col='mobile';

				
				
				$total=count($this->Frontamodel->get_data_like($this->tb3,$like_col,$search_value));
				
				 $page_limit = $total/$limit; 
				 
				 $start = ($page - 1) * $limit;
				
				$columns="unique_token,user_name,mobile,email,wallet_balance,betting_status,transfer_point_status,status,date_format(insert_date,'%d %b %Y') as insert_date ";
				$by = 'user_id';
				
				$user_list = $this->Frontamodel->get_like_desc_scroll($this->tb3,$columns,$by,$start,$limit,$like_col,$search_value);
				$data_json['user_list']=$user_list;
				
				$data_json['msg']='Success';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiSaveOpenResultData()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$open_number=$input_data->open_number;
				$game_id=$input_data->game_id;
				$result_dec_date=$input_data->result_dec_date;
			
				$insert_data = array(
				'open_number'=>$open_number,
				'game_id'=>$game_id,
				'result_date'=>$result_dec_date,
				);
			
				$where=array('game_id'=>$game_id,'result_date'=>$result_dec_date);	
				$result = $this->Frontamodel->get_data($this->tb21,$where);
				$open_decleare_status = 0;
				if(count($result)>0)
				{
					foreach($result as $rs)
					{
						$open_decleare_status = $rs->open_decleare_status;
					}
				}
				if($open_decleare_status == 1)
				{
					$data_json['status'] = false; 
					$data_json['msg'] = "Result already decleared.";
				}
				else 
				{
					if(count($result)<1)
					{
						$this->Frontbmodel->insertData($this->tb21,$insert_data);
						$data_json['status'] = true; 
						$data_json['msg'] = "Successfully inserted.";
					}
					else
					{
						$this->Frontcmodel->update_where($this->tb21,$insert_data,$where);
						$data_json['status'] = true; 
						$data_json['msg'] ="Successfully updated.";

					}
					
					$open_num=$open_number[0]+$open_number[1]+$open_number[2];
					if($open_num<10)
					$data_json['open_result']=$open_num;
							
					if($open_num>9)
					$data_json['open_result']=$open_num%10;
				}
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiGetOpenWinnerList()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$game_id=$input_data->game_id;
				$result_dec_date=$input_data->result_dec_date;
				
				$where=array('game_id'=>$game_id,'open_number!='=>"",'result_date'=>$result_dec_date);	
				$result = $this->Frontamodel->get_data($this->tb21,$where);
		
				foreach($result as $rs)
				{
						$open_number=$rs->open_number;
				}
				
				$game_rates=$this->Frontamodel->getData($this->tb10);
				foreach($game_rates as $rs)
				{
					$single_digit_val_2=$rs->single_digit_val_2;
					$jodi_digit_val_2=$rs->jodi_digit_val_2;
					$single_pana_val_2=$rs->single_pana_val_2;
					$double_pana_val_2=$rs->double_pana_val_2;
					$tripple_pana_val_2=$rs->tripple_pana_val_2;
					$half_sangam_val_2=$rs->half_sangam_val_2;
					$full_sangam_val_2=$rs->full_sangam_val_2;
				}
				
				$where=array($this->tb18.'.game_id'=>$game_id,'pay_status'=>0,'bid_date'=>$result_dec_date,'session'=>'Open');	
			
			
				$joins = array(

					array(

						'table' => $this->tb16,
						'condition' => $this->tb16.'.game_id = '.$this->tb18.'.game_id',
						'jointype' => 'LEFT'
						),
						array(

						'table' => $this->tb3,
						'condition' => $this->tb3.'.user_id = '.$this->tb18.'.user_id',
						'jointype' => 'LEFT'
						)

				);
				
				$columns=$this->tb16.".game_name,".$this->tb3.".unique_token,pana,session,digits,closedigits,points,bid_id,bid_tx_id,pay_status,user_name";
				$by = 'bid_id';

				$result= $this->Frontamodel->get_joins_where_desc($this->tb18,$columns,$joins,$where,$by);
				
				$data_array=array();
					$i=0;
			
				$win_amt_sum=0;
				$points_amt_sum=0;
				foreach($result as $rs)
				{
					$game_not_name=$rs->game_name;
					$win_number_not=$open_number[0]+$open_number[1]+$open_number[2];
						
					if($win_number_not>9)
					$win_number_not=$win_number_not%10;
					$win_amt=0;
					$points=0;
						
						if($rs->pana=='Single Digit')
						{
							$win_number=$open_number[0]+$open_number[1]+$open_number[2];
							
							if($win_number>9)
							$win_number=$win_number%10;
							
							if($win_number==$rs->digits)
							{
								$win_amt=($single_digit_val_2/10)*$rs->points;
								
								$points=$rs->points;
								
								$data_array[$i]['points']=$rs->points;
								$data_array[$i]['unique_token']=$rs->unique_token;
								$data_array[$i]['user_name']=$rs->user_name;
								$data_array[$i]['pana']=$rs->pana;
								$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
								$data_array[$i]['win_amt']=$win_amt;
								
							}
						}
						else if($rs->pana=='Triple Pana')
						{
							if($open_number==$rs->digits)
							{
								$win_amt=($tripple_pana_val_2/10)*$rs->points;
								
								$points=$rs->points;
													
								$data_array[$i]['points']=$rs->points;
								$data_array[$i]['unique_token']=$rs->unique_token;
								$data_array[$i]['user_name']=$rs->user_name;
								$data_array[$i]['pana']=$rs->pana;
								$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
								$data_array[$i]['win_amt']=$win_amt;
							}
						}
						else if($rs->pana=='Double Pana')
						{
							if($open_number==$rs->digits)
							{
								$win_amt=($double_pana_val_2/10)*$rs->points;
								
								$points=$rs->points;
								
								$data_array[$i]['points']=$rs->points;
								$data_array[$i]['unique_token']=$rs->unique_token;
								$data_array[$i]['user_name']=$rs->user_name;
								$data_array[$i]['pana']=$rs->pana;
								$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
								$data_array[$i]['win_amt']=$win_amt;
							}
						}
						
						else if($rs->pana=='Single Pana')
						{
							if($open_number==$rs->digits)
							{
								$win_amt=($single_pana_val_2/10)*$rs->points;
								
								$points=$rs->points;
								
								$data_array[$i]['unique_token']=$rs->unique_token;
								$data_array[$i]['points']=$rs->points;
								$data_array[$i]['user_name']=$rs->user_name;
								$data_array[$i]['pana']=$rs->pana;
								$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
								$data_array[$i]['win_amt']=$win_amt;
							}
						}
						$win_amt_sum=$win_amt+$win_amt_sum;
						$points_amt_sum=$points+$points_amt_sum;
						if($win_amt>0)
						$i++;
						
					}
							
				$data_json['winner_list'] = $data_array; 
				$data_json['win_amt_sum'] = $win_amt_sum; 
				$data_json['points_amt_sum'] = $points_amt_sum; 
				$data_json['status'] = "success"; 
			

				
				$data_json['msg']='Success';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiDeclareOpenResultData()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$game_id=$input_data->game_id;
				$result_dec_date=$input_data->result_dec_date;
				
				$where=array('game_id'=>$game_id,'open_number!='=>"",'result_date'=>$result_dec_date);	
				$result = $this->Frontamodel->get_data($this->tb21,$where);
		
				if(count($result)<1)
				{
					$data_json['status'] = false; 
					$data_json['msg'] = "Please save game result first";
				}
				else
				{
					foreach($result as $rs)
					{
							$open_number=$rs->open_number;
							$open_decleare_status=$rs->open_decleare_status;
					}
			
						if($open_decleare_status == 1)
						{
								$data_json['status'] = false; 
								$data_json['msg'] = "Result already decleared.";
						}else {
								$where=array('game_id'=>$game_id);	
								$game_name_result = $this->Frontamodel->get_data($this->tb16,$where);
								foreach($game_name_result as $rs)
								{
										$game_not_name=$rs->game_name;
								}
								
								$win_number_not=$open_number[0]+$open_number[1]+$open_number[2];
								if($win_number_not>9)
									$win_number_not=$win_number_not%10;
								
								
								$game_rates=$this->Frontamodel->getData($this->tb10);
								foreach($game_rates as $rs)
								{
									$single_digit_val_2=$rs->single_digit_val_2;
									$jodi_digit_val_2=$rs->jodi_digit_val_2;
									$single_pana_val_2=$rs->single_pana_val_2;
									$double_pana_val_2=$rs->double_pana_val_2;
									$tripple_pana_val_2=$rs->tripple_pana_val_2;
									$half_sangam_val_2=$rs->half_sangam_val_2;
									$full_sangam_val_2=$rs->full_sangam_val_2;
								}
								
								$where=array($this->tb18.'.game_id'=>$game_id,'pay_status'=>0,'bid_date'=>$result_dec_date,'session'=>'Open');	
								
									$joins = array(

										array(

											'table' => $this->tb16,
											'condition' => $this->tb16.'.game_id = '.$this->tb18.'.game_id',
											'jointype' => 'LEFT'
											)

									);
									
							$columns=$this->tb16.".game_name,pana,user_id,session,digits,closedigits,points,bid_id,bid_tx_id,pay_status";
							$by = 'bid_id';

							$result= $this->Frontamodel->get_joins_where_desc($this->tb18,$columns,$joins,$where,$by);
							
								$open_result_token=$this->volanlib->uniqRandom(15);
								foreach($result as $rs)
								{
									
									if($rs->pana=='Single Digit')
									{
										$win_number=$open_number[0]+$open_number[1]+$open_number[2];
										
										if($win_number>9)
										$win_number=$win_number%10;
										
										if($win_number==$rs->digits)
										{
											$win_amt=($single_digit_val_2/10)*$rs->points;
											
											$msg=$rs->game_name.' in '.$rs->pana.' '.'(Session- '.$rs->session.') for bid amount- '.$rs->points.' Won';
											$this->updateUserWallet($rs->user_id,$win_amt,$msg,$open_result_token,$rs->bid_tx_id);
											
											$where=array('bid_id'=>$rs->bid_id);
											$up_data=array('pay_status'=>1,'open_result_token'=>$open_result_token);
											
											$this->Frontcmodel->update_where($this->tb18,$up_data,$where);
											
											$insert_data = array(
											'user_id' => $rs->user_id,
											'bid_tx_id' => $rs->bid_tx_id,
											'open_result_token'=>$open_result_token,
											'msg' => "Congratulations ,You Won in ".$rs->game_name." for Bid Number- ".$rs->bid_tx_id,
											'insert_date' => $this->insert_date
											);
											$this->Frontbmodel->insertData($this->tb22,$insert_data);

											
										}
									}
									else if($rs->pana=='Triple Pana')
									{
										if($open_number==$rs->digits)
										{
											$win_amt=($tripple_pana_val_2/10)*$rs->points;
											
											$msg=$rs->game_name.' in '.$rs->pana.' '.'(Session- '.$rs->session.') for bid amount- '.$rs->points.' Won';
											
											$this->updateUserWallet($rs->user_id,$win_amt,$msg,$open_result_token,$rs->bid_tx_id);
											
											$where=array('bid_id'=>$rs->bid_id);
											$up_data=array('pay_status'=>1,'open_result_token'=>$open_result_token);
											
											$this->Frontcmodel->update_where($this->tb18,$up_data,$where);
											
											$insert_data = array(
											'user_id' => $rs->user_id,
											'bid_tx_id' => $rs->bid_tx_id,
											'open_result_token'=>$open_result_token,
											'msg' => "Congratulations ,You Won in ".$rs->game_name." for Bid Number- ".$rs->bid_tx_id,
											'insert_date' => $this->insert_date
											);
											$this->Frontbmodel->insertData($this->tb22,$insert_data);

											
										}
									}
									else if($rs->pana=='Double Pana')
									{
										if($open_number==$rs->digits)
										{
											$win_amt=($double_pana_val_2/10)*$rs->points;
											
											$msg=$rs->game_name.' in '.$rs->pana.' '.'(Session- '.$rs->session.') for bid amount- '.$rs->points.' Won';
											$this->updateUserWallet($rs->user_id,$win_amt,$msg,$open_result_token,$rs->bid_tx_id);
											
											$where=array('bid_id'=>$rs->bid_id);
											$up_data=array('pay_status'=>1,'open_result_token'=>$open_result_token);
											
											$this->Frontcmodel->update_where($this->tb18,$up_data,$where);
											
											$insert_data = array(
											'user_id' => $rs->user_id,
											'bid_tx_id' => $rs->bid_tx_id,
											'open_result_token'=>$open_result_token,
											'msg' => "Congratulations ,You Won in ".$rs->game_name." for Bid Number- ".$rs->bid_tx_id,
											'insert_date' => $this->insert_date
											);
											$this->Frontbmodel->insertData($this->tb22,$insert_data);

											
										}
									}
									
									else if($rs->pana=='Single Pana')
									{
										if($open_number==$rs->digits)
										{
											$win_amt=($single_pana_val_2/10)*$rs->points;
											$msg=$rs->game_name.' in '.$rs->pana.' '.'(Session- '.$rs->session.') for bid amount- '.$rs->points.' Won';
											$this->updateUserWallet($rs->user_id,$win_amt,$msg,$open_result_token,$rs->bid_tx_id);
											
											$where=array('bid_id'=>$rs->bid_id);
											$up_data=array('pay_status'=>1,'open_result_token'=>$open_result_token);
											
											$this->Frontcmodel->update_where($this->tb18,$up_data,$where);
											
											$insert_data = array(
											'user_id' => $rs->user_id,
											'bid_tx_id' => $rs->bid_tx_id,
											'open_result_token'=>$open_result_token,
											'msg' => "Congratulations ,You Won in ".$rs->game_name." for Bid Number- ".$rs->bid_tx_id,
											'insert_date' => $this->insert_date
											);
											
											$this->Frontbmodel->insertData($this->tb22,$insert_data);

											
										}
									}
									
								}
								
								$where=array('game_id'=>$game_id,'open_number!='=>"",'result_date'=>$result_dec_date);	
								$up_data=array('open_decleare_status'=>1,'open_decleare_date'=>$this->insert_date,'open_result_token'=>$open_result_token);
								
								$this->Frontcmodel->update_where($this->tb21,$up_data,$where);
								
								$data_json['status'] = true; 
								$data_json['open_declare_status'] = 1; 
								$data_json['open_declare_date'] = $this->insert_date; 
								$data_json['msg'] = "Successfully declared.";
						}
						
					}
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiSaveCloseResultData()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$close_number=$input_data->close_number;
				$game_id=$input_data->game_id;
				$result_dec_date=$input_data->result_dec_date;
			
				$insert_data = array(
				'close_number'=>$close_number,
				'game_id'=>$game_id,
				'result_date'=>$result_dec_date,
				);
			
				$where=array('game_id'=>$game_id,'result_date'=>$result_dec_date);	
				$result = $this->Frontamodel->get_data($this->tb21,$where);
				$open_decleare_status = 0;
				$close_decleare_status = 0;
				if(count($result)>0)
				{
					foreach($result as $rs)
					{
						$open_decleare_status = $rs->open_decleare_status;
						$close_decleare_status = $rs->close_decleare_status;
					}
				}
				if($close_decleare_status == 1)
				{
					$data_json['status'] = false; 
					$data_json['msg'] = "Result already decleared.";
				}
				else 
				{
					if(count($result)<1)
					{
						$data_json['status'] = false;
						$data_json['msg'] = "Please Declare Open Result First";
					}
					else
					{
						if($open_decleare_status == 1)
						{
							$this->Frontcmodel->update_where($this->tb21,$insert_data,$where);
							$data_json['status'] = true; 
							$data_json['msg'] = "Successfully inserted.";
						}
						else
						{
							
							$data_json['status'] = false; 
							$data_json['msg'] ="Please Declare Open Result First.";

						}
						
						$close_num=$close_number[0]+$close_number[1]+$close_number[2];
			
						if($close_num<10)
						$data_json['close_result']=$close_num;
								
						if($close_num>9)
						$data_json['close_result']=$close_num%10;
					
						$data_json['msg']='Success';
						$data_json['status']=true;
					}
					
				}
				
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiDeclareCloseResultData()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$game_id=$input_data->game_id;
				$result_dec_date=$input_data->result_dec_date;
				
				$where=array('game_id'=>$game_id,'close_number!='=>"",'result_date'=>$result_dec_date);	
				$result = $this->Frontamodel->get_data($this->tb21,$where);
		
				if(count($result)<1)
				{
					$data['status'] = "error"; 
					$data['msg'] = $this->volanlib->error("Please save game result first");
				}
				else
				{
					foreach($result as $rs)
					{
							$open_number=$rs->open_number;
							$close_number=$rs->close_number;
							$close_decleare_status=$rs->close_decleare_status;
					}
					
					if($close_decleare_status == 1)
					{
						$data_json['status'] = true; 
						$data_json['msg'] = "Result already decleared.";
					}
					else {
						
						$where=array('game_id'=>$game_id);	
						$game_name_result = $this->Frontamodel->get_data($this->tb16,$where);
						foreach($game_name_result as $rs)
						{
								$game_not_name=$rs->game_name;
						}
						
						$win_number_not=$open_number[0]+$open_number[1]+$open_number[2];
						$win_number_close_not=$close_number[0]+$close_number[1]+$close_number[2];
						
						if($win_number_not>9)
							$win_number_not=$win_number_not%10;
						
						if($win_number_close_not>9)
							$win_number_close_not=$win_number_close_not%10;
					
					
						$game_rates=$this->Frontamodel->getData($this->tb10);
						foreach($game_rates as $rs)
						{
							$single_digit_val_2=$rs->single_digit_val_2;
							$jodi_digit_val_2=$rs->jodi_digit_val_2;
							$single_pana_val_2=$rs->single_pana_val_2;
							$double_pana_val_2=$rs->double_pana_val_2;
							$tripple_pana_val_2=$rs->tripple_pana_val_2;
							$half_sangam_val_2=$rs->half_sangam_val_2;
							$full_sangam_val_2=$rs->full_sangam_val_2;
						}
						
						$where=array($this->tb18.'.game_id'=>$game_id,'pay_status'=>0,'bid_date'=>$result_dec_date,'session!='=>'Open');	
					
					
						$joins = array(

							array(

								'table' => $this->tb16,
								'condition' => $this->tb16.'.game_id = '.$this->tb18.'.game_id',
								'jointype' => 'LEFT'
								),
								array(

								'table' => $this->tb3,
								'condition' => $this->tb3.'.user_id = '.$this->tb18.'.user_id',
								'jointype' => 'LEFT'
								)

						);
						
						$columns=$this->tb16.".game_name,".$this->tb3.".user_id,pana,session,digits,closedigits,points,bid_id,bid_tx_id,pay_status,user_name";
						$by = 'bid_id';

						$result= $this->Frontamodel->get_joins_where_desc($this->tb18,$columns,$joins,$where,$by);
						
						$data_array=array();
							$i=0;
					
						$win_amt_sum=0;
						$points_amt_sum=0;
						$close_result_token=$this->volanlib->uniqRandom(15);
						foreach($result as $rs)
						{
						if($rs->pana=='Single Digit')
						{
							$win_number=$close_number[0]+$close_number[1]+$close_number[2];
							if($win_number>9)
							$win_number=$win_number%10;
							if($win_number==$rs->digits)
							{
								$win_amt=($single_digit_val_2/10)*$rs->points;
								
								//$msg='Amount won in '.$rs->game_name.' '.$rs->pana.' '.$rs->session.' session for Bid Number- '.$rs->bid_tx_id;
								
								$msg=$rs->game_name.' in '.$rs->pana.' '.'(Session- '.$rs->session.') for bid amount- '.$rs->points.' Won';
								
								$this->updateCloseUserWallet($rs->user_id,$win_amt,$msg,$close_result_token,$rs->bid_tx_id);
								
								$where=array('bid_id'=>$rs->bid_id);
								$up_data=array('pay_status'=>1,"close_result_token"=>$close_result_token);
								
								$this->Frontcmodel->update_where($this->tb18,$up_data,$where);
								
								$insert_data = array(
								'user_id' => $rs->user_id,
								'bid_tx_id' => $rs->bid_tx_id,
								'close_result_token' => $close_result_token,
								'msg' => "Congratulations ,You Won in ".$rs->game_name." for Bid Number- ".$rs->bid_tx_id,
								'insert_date' => $this->insert_date
								);
								
								$this->Frontbmodel->insertData($this->tb22,$insert_data);

							}
						}
						else if($rs->pana=='Half Sangam')
						{
							$win_number2=$close_number[0]+$close_number[1]+$close_number[2];
							
							if($win_number2>9)
							$win_number2=$win_number2%10;
						
							if($open_number==$rs->digits && $win_number2==$rs->closedigits)
							{
								$win_amt=($half_sangam_val_2/10)*$rs->points;
								
								$msg=$rs->game_name.' in '.$rs->pana.' '.'(Session- '.$rs->session.') for bid amount- '.$rs->points.' Won';
								
								$this->updateCloseUserWallet($rs->user_id,$win_amt,$msg,$close_result_token,$rs->bid_tx_id);
								
								$where=array('bid_id'=>$rs->bid_id);
								$up_data=array('pay_status'=>1,"close_result_token"=>$close_result_token);
								
								$this->Frontcmodel->update_where($this->tb18,$up_data,$where);
								
								$insert_data = array(
								'user_id' => $rs->user_id,
								'bid_tx_id' => $rs->bid_tx_id,
								'close_result_token' => $close_result_token,
								'msg' => "Congratulations ,You Won in ".$rs->game_name." for Bid Number- ".$rs->bid_tx_id,
								'insert_date' => $this->insert_date
								);
								$this->Frontbmodel->insertData($this->tb22,$insert_data);

							}
						}
						else if($rs->pana=='Full Sangam')
						{
							$win_number=$open_number;
							$win_number=$close_number;
							
							if($open_number==$rs->digits && $close_number==$rs->closedigits)
							{
								$win_amt=($full_sangam_val_2/10)*$rs->points;
																
								$msg=$rs->game_name.' in '.$rs->pana.' '.'(Session- N/A) for bid amount- '.$rs->points.' Won';
								
								$this->updateCloseUserWallet($rs->user_id,$win_amt,$msg,$close_result_token,$rs->bid_tx_id);
								
								$where=array('bid_id'=>$rs->bid_id);
								$up_data=array('pay_status'=>1,'close_result_token'=>$close_result_token);
								
								$this->Frontcmodel->update_where($this->tb18,$up_data,$where);
								
								$insert_data = array(
								'user_id' => $rs->user_id,
								'bid_tx_id' => $rs->bid_tx_id,
								'close_result_token' => $close_result_token,
								'msg' => "Congratulations ,You Won in ".$rs->game_name." for Bid Number- ".$rs->bid_tx_id,
								'insert_date' => $this->insert_date
								);

								$this->Frontbmodel->insertData($this->tb22,$insert_data);

							}
						}
						else if($rs->pana=='Triple Pana')
						{
							if($close_number==$rs->digits)
							{
								$win_amt=($tripple_pana_val_2/10)*$rs->points;
								
								$msg=$rs->game_name.' in '.$rs->pana.' '.'(Session- '.$rs->session.') for bid amount- '.$rs->points.' Won';
								
								$this->updateCloseUserWallet($rs->user_id,$win_amt,$msg,$close_result_token,$rs->bid_tx_id);
								
								$where=array('bid_id'=>$rs->bid_id);
								$up_data=array('pay_status'=>1,"close_result_token"=>$close_result_token);
								
								$this->Frontcmodel->update_where($this->tb18,$up_data,$where);
								
								$insert_data = array(
								'user_id' => $rs->user_id,
								'bid_tx_id' => $rs->bid_tx_id,
								'close_result_token' => $close_result_token,
								'msg' => "Congratulations ,You Won in ".$rs->game_name." for Bid Number- ".$rs->bid_tx_id,
								'insert_date' => $this->insert_date
								);
								
								
								$this->Frontbmodel->insertData($this->tb22,$insert_data);

							}
						}
						else if($rs->pana=='Double Pana')
						{
							if($close_number==$rs->digits)
							{
								$win_amt=($double_pana_val_2/10)*$rs->points;
								
								
								$msg=$rs->game_name.' in '.$rs->pana.' '.'(Session- '.$rs->session.') for bid amount- '.$rs->points.' Won';
								
								$this->updateCloseUserWallet($rs->user_id,$win_amt,$msg,$close_result_token,$rs->bid_tx_id);
								
								$where=array('bid_id'=>$rs->bid_id);
								$up_data=array('pay_status'=>1,"close_result_token"=>$close_result_token);
								
								$this->Frontcmodel->update_where($this->tb18,$up_data,$where);
								
								$insert_data = array(
								'user_id' => $rs->user_id,
								'bid_tx_id' => $rs->bid_tx_id,
								'close_result_token' => $close_result_token,
								'msg' => "Congratulations ,You Won in ".$rs->game_name." for Bid Number- ".$rs->bid_tx_id,
								'insert_date' => $this->insert_date
								);
								$this->Frontbmodel->insertData($this->tb22,$insert_data);

							}
						}
						
						else if($rs->pana=='Single Pana')
						{
							if($close_number==$rs->digits)
							{
								$win_amt=($single_pana_val_2/10)*$rs->points;
								
								
								$msg=$rs->game_name.' in '.$rs->pana.' '.'(Session- '.$rs->session.') for bid amount- '.$rs->points.' Won';
								
								$this->updateCloseUserWallet($rs->user_id,$win_amt,$msg,$close_result_token,$rs->bid_tx_id);
								
								$where=array('bid_id'=>$rs->bid_id);
								$up_data=array('pay_status'=>1,"close_result_token"=>$close_result_token);
								
								$this->Frontcmodel->update_where($this->tb18,$up_data,$where);
								
								$insert_data = array(
								'user_id' => $rs->user_id,
								'bid_tx_id' => $rs->bid_tx_id,
								'close_result_token' => $close_result_token,
								'msg' => "Congratulations ,You Won in ".$rs->game_name." for Bid Number- ".$rs->bid_tx_id,
								'insert_date' => $this->insert_date
								);
								
								$this->Frontbmodel->insertData($this->tb22,$insert_data);

								
							}
						}
						
						else if($rs->pana=='Jodi Digit')
						{
							$win_number1=$close_number[0]+$close_number[1]+$close_number[2];
							$win_number2=$open_number[0]+$open_number[1]+$open_number[2];
							
							if($win_number1>9)
							$win_number1=$win_number1%10;
						
							if($win_number2>9)
							$win_number2=$win_number2%10;
							
							$win_number=$win_number2.$win_number1;
							if($win_number==$rs->digits)
							{
								$win_amt=($jodi_digit_val_2/10)*$rs->points;
								
								$msg=$rs->game_name.' in '.$rs->pana.' '.'(Session- N/A) for bid amount- '.$rs->points.' Won';
								
								$this->updateCloseUserWallet($rs->user_id,$win_amt,$msg,$close_result_token,$rs->bid_tx_id);
								
								$where=array('bid_id'=>$rs->bid_id);
								$up_data=array('pay_status'=>1,"close_result_token"=>$close_result_token);
								
								$this->Frontcmodel->update_where($this->tb18,$up_data,$where);
								
								$insert_data = array(
								'user_id' => $rs->user_id,
								'bid_tx_id' => $rs->bid_tx_id,
								'msg' => "Congratulations ,You Won in ".$rs->game_name." for Bid Number- ".$rs->bid_tx_id,
								'insert_date' => $this->insert_date
								);								
								$this->Frontbmodel->insertData($this->tb22,$insert_data);

							}
						}
						
					}
					
					
					$where=array($this->tb18.'.game_id'=>$game_id,'pay_status'=>0,'bid_date'=>$result_dec_date,'session'=>'Open','pana'=>'Half Sangam');	
					$joins = array(

										array(

											'table' => $this->tb16,
											'condition' => $this->tb16.'.game_id = '.$this->tb18.'.game_id',
											'jointype' => 'LEFT'
											)

									);
									
					$columns=$this->tb16.".game_name,pana,user_id,bid_id,session,digits,closedigits,points,bid_tx_id,pay_status";
					$by = 'bid_id';

					$result= $this->Frontamodel->get_joins_where_desc($this->tb18,$columns,$joins,$where,$by);		
					foreach($result as $rs)
					{
						if($rs->pana=='Half Sangam')
						{
							$win_number2=$open_number[0]+$open_number[1]+$open_number[2];
							
							if($win_number2>9)
							$win_number2=$win_number2%10;
						
							if($close_number==$rs->closedigits && $win_number2==$rs->digits)
							{
								$win_amt=($half_sangam_val_2/10)*$rs->points;
								
								
								$msg=$rs->game_name.' in '.$rs->pana.' '.'(Session- '.$rs->session.') for bid amount- '.$rs->points.' Won';
								
								$this->updateCloseUserWallet($rs->user_id,$win_amt,$msg,$close_result_token,$rs->bid_tx_id);
								
								$where=array('bid_id'=>$rs->bid_id);
								$up_data=array('pay_status'=>1,"close_result_token"=>$close_result_token);
																
								$this->Frontcmodel->update_where($this->tb18,$up_data,$where);
								
								$insert_data = array(
								'user_id' => $rs->user_id,
								'bid_tx_id' => $rs->bid_tx_id,
								'close_result_token' => $close_result_token,
								'msg' => "Congratulations ,You Won in ".$rs->game_name." for Bid Number-".$rs->bid_tx_id,
								'insert_date' => $this->insert_date
								);
								
								$this->Frontbmodel->insertData($this->tb22,$insert_data);

							}
						}
						
						
					}
					
					$where=array('game_id'=>$game_id,'close_number!='=>"",'result_date'=>$result_dec_date);	
					$up_data=array('close_decleare_status'=>1,'close_decleare_date'=>$this->insert_date,"close_result_token"=>$close_result_token);
					$this->Frontcmodel->update_where($this->tb21,$up_data,$where);
					
					
					
					$data_json['close_decleare_status'] = 1; 
					$data_json['close_decleare_date'] = $this->insert_date; 
					$data_json['msg']='Success';
					$data_json['status']=true;
					}
				}
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiGetCloseWinnerList()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$game_id=$input_data->game_id;
				$result_dec_date=$input_data->result_dec_date;
				
				$where=array('game_id'=>$game_id,'open_number!='=>"",'result_date'=>$result_dec_date);	
				$result = $this->Frontamodel->get_data($this->tb21,$where);
				
				if(count($result)<1)
				{
					$data_json['status'] = false; 
					$data_json['msg'] = "Please save game result first";

				}
				else
				{
					
					foreach($result as $rs)
					{
							$open_number=$rs->open_number;
							$close_number=$rs->close_number;
					}
			
						$game_rates=$this->Frontamodel->getData($this->tb10);
						foreach($game_rates as $rs)
						{
							$single_digit_val_2=$rs->single_digit_val_2;
							$jodi_digit_val_2=$rs->jodi_digit_val_2;
							$single_pana_val_2=$rs->single_pana_val_2;
							$double_pana_val_2=$rs->double_pana_val_2;
							$tripple_pana_val_2=$rs->tripple_pana_val_2;
							$half_sangam_val_2=$rs->half_sangam_val_2;
							$full_sangam_val_2=$rs->full_sangam_val_2;
						}
						
						$where=array($this->tb18.'.game_id'=>$game_id,'pay_status'=>0,'bid_date'=>$result_dec_date,'session!='=>'Open');	
						$joins = array(

								array(

									'table' => $this->tb16,
									'condition' => $this->tb16.'.game_id = '.$this->tb18.'.game_id',
									'jointype' => 'LEFT'
									),
									array(

									'table' => $this->tb3,
									'condition' => $this->tb3.'.user_id = '.$this->tb18.'.user_id',
									'jointype' => 'LEFT'
									)

							);
							
						$columns=$this->tb16.".game_name,".$this->tb3.".unique_token,pana,session,digits,closedigits,points,bid_id,bid_tx_id,pay_status,user_name";
						$by = 'bid_id';

						$result= $this->Frontamodel->get_joins_where_desc($this->tb18,$columns,$joins,$where,$by);	
						
						$data_array=array();
						$i=0;
						
						$win_amt_sum=0;
						$points_amt_sum=0;

						
						foreach($result as $rs)
						{
							
							
							$win_amt=0;
							$points=0;
							
							if($rs->pana=='Single Digit')
							{
								$win_number=$close_number[0]+$close_number[1]+$close_number[2];
								if($win_number>9)
								$win_number=$win_number%10;
								if($win_number==$rs->digits)
								{
									$win_amt=($single_digit_val_2/10)*$rs->points;
									
									$points=$rs->points;
									
									$data_array[$i]['points']=$rs->points;
									$data_array[$i]['unique_token']=$rs->unique_token;
									$data_array[$i]['user_name']=$rs->user_name;
									$data_array[$i]['pana']=$rs->pana;
									$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
									$data_array[$i]['win_amt']=$win_amt;
									
								}
							}
							else if($rs->pana=='Half Sangam')
							{
								$win_number2=$close_number[0]+$close_number[1]+$close_number[2];
								
								if($win_number2>9)
								$win_number2=$win_number2%10;
							
								if($open_number==$rs->digits && $win_number2==$rs->closedigits)
								{
									$win_amt=($half_sangam_val_2/10)*$rs->points;
									
									$points=$rs->points;
									
									$data_array[$i]['points']=$rs->points;
									$data_array[$i]['unique_token']=$rs->unique_token;
									$data_array[$i]['user_name']=$rs->user_name;
									$data_array[$i]['pana']=$rs->pana;
									$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
									$data_array[$i]['win_amt']=$win_amt;
									
								}
							}
							else if($rs->pana=='Full Sangam')
							{
								$win_number=$open_number;
								$win_number=$close_number;
								
								if($open_number==$rs->digits && $close_number==$rs->closedigits)
								{
									$win_amt=($full_sangam_val_2/10)*$rs->points;
									
									$points=$rs->points;
									
									$data_array[$i]['points']=$rs->points;
									$data_array[$i]['unique_token']=$rs->unique_token;
									$data_array[$i]['user_name']=$rs->user_name;
									$data_array[$i]['pana']=$rs->pana;
									$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
									$data_array[$i]['win_amt']=$win_amt;
								}
							}
							else if($rs->pana=='Triple Pana')
							{
								if($close_number==$rs->digits)
								{
									$win_amt=($tripple_pana_val_2/10)*$rs->points;
									
									$points=$rs->points;
									
									$data_array[$i]['points']=$rs->points;
									$data_array[$i]['unique_token']=$rs->unique_token;
									$data_array[$i]['user_name']=$rs->user_name;
									$data_array[$i]['pana']=$rs->pana;
									$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
									$data_array[$i]['win_amt']=$win_amt;
								}
							}
							else if($rs->pana=='Double Pana')
							{
								if($close_number==$rs->digits)
								{
									$win_amt=($double_pana_val_2/10)*$rs->points;
									
									$points=$rs->points;
									
									$data_array[$i]['points']=$rs->points;
									$data_array[$i]['unique_token']=$rs->unique_token;
									$data_array[$i]['user_name']=$rs->user_name;
									$data_array[$i]['pana']=$rs->pana;
									$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
									$data_array[$i]['win_amt']=$win_amt;
								}
							}
							
							else if($rs->pana=='Single Pana')
							{
								if($close_number==$rs->digits)
								{
									$win_amt=($single_pana_val_2/10)*$rs->points;
									
									$points=$rs->points;
									
									$data_array[$i]['points']=$rs->points;
									$data_array[$i]['unique_token']=$rs->unique_token;
									$data_array[$i]['user_name']=$rs->user_name;
									$data_array[$i]['pana']=$rs->pana;
									$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
									$data_array[$i]['win_amt']=$win_amt;
									
								}
							}
							
							else if($rs->pana=='Jodi Digit')
							{
								$win_number1=$close_number[0]+$close_number[1]+$close_number[2];
								$win_number2=$open_number[0]+$open_number[1]+$open_number[2];
								
								if($win_number1>9)
								$win_number1=$win_number1%10;
							
								if($win_number2>9)
								$win_number2=$win_number2%10;
								
								$win_number=$win_number2.$win_number1;
								if($win_number==$rs->digits)
								{
									$win_amt=($jodi_digit_val_2/10)*$rs->points;
									
									$points=$rs->points;
									
									$data_array[$i]['points']=$rs->points;
									$data_array[$i]['unique_token']=$rs->unique_token;
									$data_array[$i]['user_name']=$rs->user_name;
									$data_array[$i]['pana']=$rs->pana;
									$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
									$data_array[$i]['win_amt']=$win_amt;
								}
							}
							
							$win_amt_sum=$win_amt+$win_amt_sum;
							$points_amt_sum=$points+$points_amt_sum;
							if($win_amt>0)
							$i++;
							
						}
						
						
						$where=array($this->tb18.'.game_id'=>$game_id,'pay_status'=>0,'bid_date'=>$result_dec_date,'session'=>'Open','pana'=>'Half Sangam');	
						$joins = array(

											array(

												'table' => $this->tb16,
												'condition' => $this->tb16.'.game_id = '.$this->tb18.'.game_id',
												'jointype' => 'LEFT'
												),
												array(

													'table' => $this->tb3,
													'condition' => $this->tb3.'.user_id = '.$this->tb18.'.user_id',
													'jointype' => 'LEFT'
													)
												

										);
										
						$columns=$this->tb16.".game_name,pana,bid_id,session,digits,closedigits,points,bid_tx_id,pay_status,user_name,".$this->tb3.'.unique_token';
						$by = 'bid_id';

						$result= $this->Frontamodel->get_joins_where_desc($this->tb18,$columns,$joins,$where,$by);	
						
						$data_array2=array();
						$i=0;
						
						$win_amt_sum2=0;
						$points_amt_sum2=0;			
						foreach($result as $rs)
						{
							
							$win_amt2=0;
							$points2=0;
							
							if($rs->pana=='Half Sangam')
							{
								$win_number2=$open_number[0]+$open_number[1]+$open_number[2];
								
								if($win_number2>9)
								$win_number2=$win_number2%10;
							
								if($close_number==$rs->closedigits && $win_number2==$rs->digits)
								{
									$win_amt2=($half_sangam_val_2/10)*$rs->points;
									
										$points2=$rs->points;
									
									$data_array2[$i]['points']=$rs->points;
									$data_array2[$i]['unique_token']=$rs->unique_token;
									$data_array2[$i]['user_name']=$rs->user_name;
									$data_array2[$i]['pana']=$rs->pana;
									$data_array2[$i]['bid_tx_id']=$rs->bid_tx_id;
									$data_array2[$i]['win_amt']=$win_amt2;
									
								}
							}
							
							$win_amt_sum2=$win_amt2+$win_amt_sum2;
							$points_amt_sum2=$points2+$points_amt_sum2;
							if($win_amt2>0)
							$i++;
							
							
						}
						
			
					$data_json['winner_list'] = array_merge($data_array,$data_array2); 
					$data_json['win_amt_sum'] = $win_amt_sum+$win_amt_sum2; 
					$data_json['points_amt_sum'] = $points_amt_sum+$points_amt_sum2; 
					$data_json['msg']='Success';
					$data_json['status']=true;
			
				}
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiDeleteOpenResultData()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$game_id=$input_data->game_id;
				$result_dec_date=$input_data->result_dec_date;
				
				$where=array('game_id'=>$game_id,'result_date'=>$result_dec_date);	
				$result = $this->Frontamodel->get_data($this->tb21,$where);
				
				if(count($result)<1)
				{
					$data_json['status'] = false; 
					$data_json['msg'] = "Game result is not decleare yet";

				}
				else
				{
					foreach($result as $rs)
					{
							$open_result_token=$rs->open_result_token;
					}
			
					$where=array('open_result_token'=>$open_result_token);
					$up_data=array('pay_status'=>0);
					$this->Frontcmodel->update_where($this->tb18,$up_data,$where);
					
					$this->deductUserWallet($open_result_token);
					
					$where_array=array('open_result_token'=>$open_result_token);
					
					$this->Frontdmodel->delete($this->tb21,$where_array);
					$this->Frontdmodel->delete($this->tb22,$where_array);
					
			
					$data_json['msg'] = "Result Successfully done.";
					$data_json['status']=true;
			
				}
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiDeleteCloseResultData()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$game_id=$input_data->game_id;
				$result_dec_date=$input_data->result_dec_date;
				
				$where=array('game_id'=>$game_id,'result_date'=>$result_dec_date);	
				$result = $this->Frontamodel->get_data($this->tb21,$where);
				
				if(count($result)<1)
				{
					$data_json['status'] = false; 
					$data_json['msg'] = "Game result is not decleare yet";

				}
				else
				{
					foreach($result as $rs)
					{
							$close_result_token=$rs->close_result_token;
					}
					
					if($close_result_token!='')
					{
						$where=array('close_result_token'=>$close_result_token);
						$up_data=array('pay_status'=>0,'close_result_token'=>'');
						
						$this->Frontcmodel->update_where($this->tb18,$up_data,$where);
						
						
						$this->deductUserCloseWallet($close_result_token);
						
						$where_array=array('close_result_token'=>$close_result_token);
						
						
						
						$where=array('close_result_token'=>$close_result_token);	
						$up_data=array('close_number'=>'','close_decleare_status'=>0,'close_decleare_date'=>'0000-00-00 00:00:00',"close_result_token"=>'',);
						
						$this->Frontcmodel->update_where($this->tb21,$up_data,$where);
						
						
						
						$this->Frontdmodel->delete($this->tb22,$where_array);
						

					}
					$data_json['msg'] = "Result Successfully deleted.";
					$data_json['status']=true;
					
			
				}
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiResultHistoryListLoadData()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$result_dec_date=$input_data->result_dec_date;
				
				$joins = array(
					array(
						'table' => $this->tb16,
						'condition' => $this->tb16.'.game_id = '.$this->tb21.'.game_id',
						'jointype' => 'LEFT'
					)
				);
				$columns = "id,".$this->tb16.".game_id,result_date,date_format(result_date,'%d %b %Y') as result_date_f,IFNULL(date_format(open_decleare_date,'%d %b %Y %r'),'') as open_decleare_date,IFNULL(date_format(close_decleare_date,'%d %b %Y %r'),'') as close_decleare_date,".$this->tb16.".game_name,open_number,close_number,open_decleare_status,close_decleare_status";
				$where=array('result_date'=>$result_dec_date);
				$by='id ';
				$result = $this->Frontamodel->get_joins_where_desc($this->tb21,$columns,$joins,$where,$by);
				foreach($result as $rs)
				{
					$open_number=$rs->open_number;
					
					if($open_number!='')
					{
						$win_number_not=$open_number[0]+$open_number[1]+$open_number[2];
						if($win_number_not>9)
						{
							$win_number_not=$win_number_not%10;
						}
						$rs->open_number=$open_number.'-'.$win_number_not;
					}
					
					$close_number=$rs->close_number;
					
					if($close_number!='')
					{
						$win_number_not=$close_number[0]+$close_number[1]+$close_number[2];
						if($win_number_not>9)
						{
							$win_number_not=$win_number_not%10;
						}
						$rs->close_number=$win_number_not.'-'.$close_number;
					}
				}
				$data_json['result'] = $result;
				$data_json['msg'] = "Successfully";
				$data_json['status']=true;
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiGetWinningPrediction()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$game_id=$input_data->game_id;
				$open_number=$input_data->open_number;
				$close_number=$input_data->close_number;
				$session_type=$input_data->session_type;
				$result_date=$input_data->result_date;
				
				
				$game_rates=$this->Frontamodel->getData($this->tb10);
				foreach($game_rates as $rs)
				{
					$single_digit_val_2=$rs->single_digit_val_2;
					$jodi_digit_val_2=$rs->jodi_digit_val_2;
					$single_pana_val_2=$rs->single_pana_val_2;
					$double_pana_val_2=$rs->double_pana_val_2;
					$tripple_pana_val_2=$rs->tripple_pana_val_2;
					$half_sangam_val_2=$rs->half_sangam_val_2;
					$full_sangam_val_2=$rs->full_sangam_val_2;
				}
				if($session_type==1)
				{		
						$where=array($this->tb18.'.game_id'=>$game_id,'pay_status'=>0,'bid_date'=>$result_date,'session'=>'Open');	
						$joins = array(

							array(

								'table' => $this->tb16,
								'condition' => $this->tb16.'.game_id = '.$this->tb18.'.game_id',
								'jointype' => 'LEFT'
								),
								array(

								'table' => $this->tb3,
								'condition' => $this->tb3.'.user_id = '.$this->tb18.'.user_id',
								'jointype' => 'LEFT'
								)

						);
						
				$columns=$this->tb16.".game_name,unique_token,pana,session,digits,closedigits,points,bid_id,bid_tx_id,pay_status,user_name";
				$by = 'bid_id';
				
				$result= $this->Frontamodel->get_joins_where_desc($this->tb18,$columns,$joins,$where,$by);
				
				$data_array=array();
					$i=0;
					
					$win_amt_sum=0;
					$points_amt_sum=0;
					foreach($result as $rs)
					{
						$game_not_name=$rs->game_name;
						$win_number_not=$open_number[0]+$open_number[1]+$open_number[2];
							
						if($win_number_not>9)
						$win_number_not=$win_number_not%10;
					$win_amt=0;
					$points=0;
						
						if($rs->pana=='Single Digit')
						{
							$win_number=$open_number[0]+$open_number[1]+$open_number[2];
							
							if($win_number>9)
							$win_number=$win_number%10;


							if($win_number==$rs->digits)
							{
								$win_amt=($single_digit_val_2/10)*$rs->points;
								
								$points=$rs->points;
								
								$data_array[$i]['points']=$rs->points;
								$data_array[$i]['unique_token']=$rs->unique_token;
								$data_array[$i]['user_name']=$rs->user_name;
								$data_array[$i]['pana']=$rs->pana;
								$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
								$data_array[$i]['win_amt']=$win_amt;
								$data_array[$i]['bid_id']=$rs->bid_id;
								
							}
						}
						else if($rs->pana=='Triple Pana')
						{
							if($open_number==$rs->digits)
							{
								$win_amt=($tripple_pana_val_2/10)*$rs->points;
								
								$points=$rs->points;
													
								$data_array[$i]['points']=$rs->points;
								$data_array[$i]['unique_token']=$rs->unique_token;
								$data_array[$i]['user_name']=$rs->user_name;
								$data_array[$i]['pana']=$rs->pana;
								$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
								$data_array[$i]['win_amt']=$win_amt;
								$data_array[$i]['bid_id']=$rs->bid_id;
							}
						}
						else if($rs->pana=='Double Pana')
						{
							if($open_number==$rs->digits)
							{
								$win_amt=($double_pana_val_2/10)*$rs->points;
								
								$points=$rs->points;
								
								$data_array[$i]['points']=$rs->points;
								$data_array[$i]['unique_token']=$rs->unique_token;
								$data_array[$i]['user_name']=$rs->user_name;
								$data_array[$i]['pana']=$rs->pana;
								$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
								$data_array[$i]['win_amt']=$win_amt;
								$data_array[$i]['bid_id']=$rs->bid_id;
							}
						}
						
						else if($rs->pana=='Single Pana')
						{
							if($open_number==$rs->digits)
							{
								$win_amt=($single_pana_val_2/10)*$rs->points;
								
								$points=$rs->points;
								
								$data_array[$i]['unique_token']=$rs->unique_token;
								$data_array[$i]['points']=$rs->points;
								$data_array[$i]['user_name']=$rs->user_name;
								$data_array[$i]['pana']=$rs->pana;
								$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
								$data_array[$i]['win_amt']=$win_amt;
								$data_array[$i]['bid_id']=$rs->bid_id;
							}
						}
						$win_amt_sum=$win_amt+$win_amt_sum;
						$points_amt_sum=$points+$points_amt_sum;
						if($win_amt>0)
						$i++;
						
					}
								
					$data_json['winner_list'] = $data_array; 
					$data_json['win_amt_sum'] = $win_amt_sum; 
					$data_json['points_amt_sum'] = $points_amt_sum; 
					$data_json['status'] = true; 
					$data_json['msg'] = "Success"; 
					

			 }
			 else{
					$where=array($this->tb18.'.game_id'=>$game_id,'pay_status'=>0,'bid_date'=>$result_date,'session!='=>'Open');	
					$joins = array(

							array(

								'table' => $this->tb16,
								'condition' => $this->tb16.'.game_id = '.$this->tb18.'.game_id',
								'jointype' => 'LEFT'
								),
								array(

								'table' => $this->tb3,
								'condition' => $this->tb3.'.user_id = '.$this->tb18.'.user_id',
								'jointype' => 'LEFT'
								)

						);
						
				$columns=$this->tb16.".game_name,".$this->tb3.".unique_token,pana,session,digits,closedigits,points,bid_id,bid_tx_id,pay_status,user_name";
				$by = 'bid_id';

				$result= $this->Frontamodel->get_joins_where_desc($this->tb18,$columns,$joins,$where,$by);	
				
				$data_array=array();
					$i=0;
					
					$win_amt_sum=0;
					$points_amt_sum=0;

					
					foreach($result as $rs)
					{
						
						
						$win_amt=0;
					$points=0;
						
						if($rs->pana=='Single Digit')
						{
							$win_number=$close_number[0]+$close_number[1]+$close_number[2];
							if($win_number>9)
							$win_number=$win_number%10;
							if($win_number==$rs->digits)
							{
								$win_amt=($single_digit_val_2/10)*$rs->points;
								
								$points=$rs->points;
								
								$data_array[$i]['points']=$rs->points;
								$data_array[$i]['unique_token']=$rs->unique_token;
								$data_array[$i]['user_name']=$rs->user_name;
								$data_array[$i]['pana']=$rs->pana;
								$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
								$data_array[$i]['win_amt']=$win_amt;
								$data_array[$i]['bid_id']=$rs->bid_id;
								
							}
						}
						else if($rs->pana=='Half Sangam')
						{
							$win_number2=$close_number[0]+$close_number[1]+$close_number[2];
							
							if($win_number2>9)
							$win_number2=$win_number2%10;
						
							if($open_number==$rs->digits && $win_number2==$rs->closedigits)
							{
								$win_amt=($half_sangam_val_2/10)*$rs->points;
								
								$points=$rs->points;
								
								$data_array[$i]['points']=$rs->points;
								$data_array[$i]['unique_token']=$rs->unique_token;
								$data_array[$i]['user_name']=$rs->user_name;
								$data_array[$i]['pana']=$rs->pana;
								$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
								$data_array[$i]['win_amt']=$win_amt;
								$data_array[$i]['bid_id']=$rs->bid_id;
								
							}
						}
						else if($rs->pana=='Full Sangam')
						{
							$win_number=$open_number;
							$win_number=$close_number;
							
							if($open_number==$rs->digits && $close_number==$rs->closedigits)
							{
								$win_amt=($full_sangam_val_2/10)*$rs->points;
								
								$points=$rs->points;
								
								$data_array[$i]['points']=$rs->points;
								$data_array[$i]['unique_token']=$rs->unique_token;
								$data_array[$i]['user_name']=$rs->user_name;
								$data_array[$i]['pana']=$rs->pana;
								$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
								$data_array[$i]['win_amt']=$win_amt;
								$data_array[$i]['bid_id']=$rs->bid_id;
							}
						}
						else if($rs->pana=='Triple Pana')
						{
							if($close_number==$rs->digits)
							{
								$win_amt=($tripple_pana_val_2/10)*$rs->points;
								
								$points=$rs->points;
								
								$data_array[$i]['points']=$rs->points;
								$data_array[$i]['unique_token']=$rs->unique_token;
								$data_array[$i]['user_name']=$rs->user_name;
								$data_array[$i]['pana']=$rs->pana;
								$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
								$data_array[$i]['win_amt']=$win_amt;
								$data_array[$i]['bid_id']=$rs->bid_id;
							}
						}
						else if($rs->pana=='Double Pana')
						{
							if($close_number==$rs->digits)
							{
								$win_amt=($double_pana_val_2/10)*$rs->points;
								
								$points=$rs->points;
								
								$data_array[$i]['points']=$rs->points;
								$data_array[$i]['unique_token']=$rs->unique_token;
								$data_array[$i]['user_name']=$rs->user_name;
								$data_array[$i]['pana']=$rs->pana;
								$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
								$data_array[$i]['win_amt']=$win_amt;
								$data_array[$i]['bid_id']=$rs->bid_id;
							}
						}
						
						else if($rs->pana=='Single Pana')
						{
							if($close_number==$rs->digits)
							{
								$win_amt=($single_pana_val_2/10)*$rs->points;
								
								$points=$rs->points;
								
								$data_array[$i]['points']=$rs->points;
								$data_array[$i]['unique_token']=$rs->unique_token;
								$data_array[$i]['user_name']=$rs->user_name;
								$data_array[$i]['pana']=$rs->pana;
								$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
								$data_array[$i]['win_amt']=$win_amt;
								$data_array[$i]['bid_id']=$rs->bid_id;
								
							}
						}
						
						else if($rs->pana=='Jodi Digit')
						{
							$win_number1=$close_number[0]+$close_number[1]+$close_number[2];
							$win_number2=$open_number[0]+$open_number[1]+$open_number[2];
							
							if($win_number1>9)
							$win_number1=$win_number1%10;
						
							if($win_number2>9)
							$win_number2=$win_number2%10;
							
							$win_number=$win_number2.$win_number1;
							if($win_number==$rs->digits)
							{
								$win_amt=($jodi_digit_val_2/10)*$rs->points;
								
								$points=$rs->points;
								
								$data_array[$i]['points']=$rs->points;
								$data_array[$i]['unique_token']=$rs->unique_token;
								$data_array[$i]['user_name']=$rs->user_name;
								$data_array[$i]['pana']=$rs->pana;
								$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
								$data_array[$i]['win_amt']=$win_amt;
								$data_array[$i]['bid_id']=$rs->bid_id;
							}
						}
						
						$win_amt_sum=$win_amt+$win_amt_sum;
						$points_amt_sum=$points+$points_amt_sum;
						if($win_amt>0)
						$i++;
						
					}
					
					
					$where=array($this->tb18.'.game_id'=>$game_id,'pay_status'=>0,'bid_date'=>$result_date,'session'=>'Open','pana'=>'Half Sangam');	
					$joins = array(

										array(

											'table' => $this->tb16,
											'condition' => $this->tb16.'.game_id = '.$this->tb18.'.game_id',
											'jointype' => 'LEFT'
											),
										array(

										'table' => $this->tb3,
										'condition' => $this->tb3.'.user_id = '.$this->tb18.'.user_id',
										'jointype' => 'LEFT'
										)

									);
									
					$columns=$this->tb16.".game_name,pana,unique_token,bid_id,session,digits,closedigits,points,bid_tx_id,pay_status,user_name";
					$by = 'bid_id';
					$result= $this->Frontamodel->get_joins_where_desc($this->tb18,$columns,$joins,$where,$by);					

					$data_array2=array();
					$i=0;
					
					$win_amt_sum2=0;
					$points_amt_sum2=0;			
					foreach($result as $rs)
					{
						
						$win_amt2=0;
						$points2=0;
						
						if($rs->pana=='Half Sangam')
						{
							$win_number2=$open_number[0]+$open_number[1]+$open_number[2];
							
							if($win_number2>9)
							$win_number2=$win_number2%10;
						
							if($close_number==$rs->closedigits && $win_number2==$rs->digits)
							{
								$win_amt2=($half_sangam_val_2/10)*$rs->points;
								
									$points2=$rs->points;
								
								$data_array2[$i]['points']=$rs->points;
								$data_array2[$i]['unique_token']=$rs->unique_token;
								$data_array2[$i]['user_name']=$rs->user_name;
								$data_array2[$i]['pana']=$rs->pana;
								$data_array2[$i]['bid_tx_id']=$rs->bid_tx_id;
								$data_array2[$i]['win_amt']=$win_amt2;
								$data_array2[$i]['bid_id']=$rs->bid_id;
								
							}
						}
						
						$win_amt_sum2=$win_amt2+$win_amt_sum2;
						$points_amt_sum2=$points2+$points_amt_sum2;
						if($win_amt2>0)
						$i++;
						
						
					}
					$data_json['winner_list'] = array_merge($data_array,$data_array2); 
					$data_json['win_amt_sum'] = $win_amt_sum+$win_amt_sum2; 
					$data_json['points_amt_sum'] = $points_amt_sum+$points_amt_sum2; 
					$data_json['msg'] = "Successfully";
					$data_json['status']=true;
				}
		
				
				
				
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiGetWinningReport()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$result_date=$input_data->result_date;
				$game_id=$input_data->game_id;
				$session_type=$input_data->session_type;
				$page=$input_data->page;				
				$start = 0; 
				$limit = 20; 
				
				$where=array('game_id'=>$game_id,'result_date'=>$result_date);	
				$result = $this->Frontamodel->get_data($this->tb21,$where);
				$open_decleare_status=0;
				$close_decleare_status=0;
				foreach($result as $rs)
				{
					$open_decleare_status=$rs->open_decleare_status;
					$close_decleare_status=$rs->close_decleare_status;
					$open_result_token=$rs->open_result_token;
					$close_result_token=$rs->close_result_token;
				}
				if($session_type==1)
				{
					if($open_decleare_status==1)
					{
						
						$where = array('DATE('.$this->tb14.'.insert_date)' => $result_date,$this->tb18.'.game_id'=>$game_id,$this->tb14.'.open_result_token'=>$open_result_token);
						
						$joins = array(
								array(

										'table' => $this->tb18,

										'condition' => $this->tb18.'.bid_tx_id = '.$this->tb14.'.bid_tx_id',

										'jointype' => 'LEFT'

									),
									array(

									'table' => $this->tb3,

									'condition' => $this->tb3.'.user_id = '.$this->tb18.'.user_id',

									'jointype' => 'LEFT'
			
								),
								

						);
						
						 $start = ($page - 1) * $limit;

						$columns="user_name,unique_token,".$this->tb18.".game_name,".$this->tb18.".session,".$this->tb14.".amount,transaction_note,transaction_note,tx_request_number,".$this->tb14.'.insert_date,pana,digits,closedigits,points,bid_id,'.$this->tb18.'.bid_tx_id';

						$by = 'transaction_id';

						$data_json['getWinningReport']= $this->Frontamodel->get_joins_where_desc_scroll($this->tb14,$columns, $joins,$where,$by,$start,$limit);
										
					}
					else
					{
						$data_json['getWinningReport']= array();
					}
				}
				else
				{
					if($close_decleare_status==1)
					{
						
						$where = array('DATE('.$this->tb14.'.insert_date)' => $result_date,$this->tb18.'.game_id'=>$game_id,$this->tb14.'.close_result_token'=>$close_result_token);
						
						$joins = array(
								array(

										'table' => $this->tb18,

										'condition' => $this->tb18.'.bid_tx_id = '.$this->tb14.'.bid_tx_id',

										'jointype' => 'LEFT'

									),
									array(

									'table' => $this->tb3,

									'condition' => $this->tb3.'.user_id = '.$this->tb18.'.user_id',

									'jointype' => 'LEFT'

								),
								
						);
						
						$columns="user_name,unique_token,".$this->tb18.".game_name,".$this->tb18.".session,".$this->tb14.".amount,transaction_note,transaction_note,tx_request_number,".$this->tb14.'.insert_date,pana,digits,closedigits,points,bid_id,'.$this->tb18.'.bid_tx_id';

						$by = 'transaction_id';						
						$data_json['getWinningReport']= $this->Frontamodel->get_joins_where_desc_scroll($this->tb14,$columns, $joins,$where,$by,$start,$limit);
										
					}
					else
					{
						$data_json['getWinningReport']= array();
					}
				}
				
				$data_json['msg']='Success';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	
	public function apiGetTransferPointReport()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$transfer_date=$input_data->transfer_date;
				$page=$input_data->page;				
				$start = 0; 
				$limit = 20; 
				
				$where = array('a.amount_status' => 3,'DATE(a.insert_date)' => $transfer_date);
				$joins = array(
									array(
									'table' => $this->tb3. ' c',
									'condition' =>'c.user_id = a.user_id',
									'jointype' => 'LEFT'
								),
						);
				$columns="c.unique_token as sender_unique_token,user_name as sender_name,mobile as sender_mobile,a.amount,DATE_FORMAT(a.insert_date,'%d %b %Y %r') as insert_date,tx_request_number";
				$getTransferHistory= $this->Frontamodel->get_joins_where($this->tb14. ' a',$columns,$joins,$where);
								
				$getTransferHistory = $this->Frontamodel->get_joins_where_scroll($this->tb14. ' a',$columns, $joins,$where,$start,$limit);
				
				$arrayList = array();
				$receiver_name="";
				if(count($getTransferHistory)>0)
				{
					$i = 1;
					foreach($getTransferHistory as $rs)
					{
						$wh = array('a.amount_status' => 4,'tx_request_number' => $rs->tx_request_number);
						$joins = array(
								array(
								'table' => $this->tb3. ' c',
								'condition' =>'c.user_id = a.user_id',
								'jointype' => 'LEFT'
							),
						);
						$columns="user_name as receiver_name,c.unique_token as reciver_unique_token,mobile as receiver_mobile";
						
						$getReceiver = $this->Frontamodel->get_joins_where_scroll($this->tb14. ' a',$columns, $joins,$wh,$start,$limit);
						if(count($getReceiver)>0)
						{
							foreach($getReceiver as $rs1)
							{
								$receiver_name = $rs1->receiver_name;		$reciver_unique_token = $rs1->reciver_unique_token;$receiver_mobile = $rs1->receiver_mobile;
							}
						}
						$listData['sender_name']=$rs->sender_name;
						$listData['sender_mobile']=$rs->sender_mobile;
						$listData['sender_unique_token']=$rs->sender_unique_token;
						$listData['amount']=$rs->amount;
						$listData['insert_date']=$rs->insert_date;
						$listData['receiver_name']=$receiver_name;
						$listData['receiver_mobile']=$receiver_mobile;
						$listData['reciver_unique_token']=$reciver_unique_token;
						
						$arrayList[] = $listData;

					}
						
				}
				else
				{
					$arrayList = array();
				}
				$data_json['listData']=$arrayList;
				$sel = 'IFNULL(sum(amount),0) as total_amt';
				$get_amt= $this->Frontamodel->get_data_select($this->tb14.' a' ,$where,$sel);
				$data_json['total_amt']=0;
				if(count($get_amt)>0)
				{
					foreach($get_amt as $ga)
					{
						$data_json['total_amt']  = $ga->total_amt;
					}
				}
		
				$data_json['msg']='Success';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiGetBidWinningReportDetails()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$result_date=$input_data->result_date;
				$game_id=$input_data->game_id;				
				
				$where = array('bid_date'=>$result_date,'game_id'=>$game_id);
				$select = 'bid_id,points';
				$bid_details = $this->Frontamodel->get_data_select($this->tb18,$where,$select);
				$total_bid_amt = 0;
				$total_win_amt = 0;
				$total_profit_amt = 0;
				$total_loss_amt = 0;
				if(count($bid_details)>0)
				{
					foreach($bid_details as $rs)
					{
						$total_bid_amt += $rs->points;
					}
				}

				$where = array('DATE('.$this->tb14.'.insert_date)'=>$result_date,'amount_status'=>8,'game_id'=>$game_id);
				$joins = array(
						array(
							'table'=>$this->tb18,
							'condition'=> $this->tb18.'.bid_tx_id = '.$this->tb14.'.bid_tx_id',
							'jointype' =>'LEFT'
						)
					);
				$columns = "amount,date_format(".$this->tb14.".insert_date,'%d %M %y %h:%i') as wining_date,game_name,pana,session";
				$win_details = $this->Frontamodel->get_joins_where($this->tb14,$columns,$joins,$where);

				if(count($win_details)>0)
				{
					foreach($win_details as $rs)
					{
						$total_win_amt += $rs->amount;
					}
				}

				if($total_bid_amt > $total_win_amt){
					$total_profit_amt = $total_bid_amt - $total_win_amt;
				}else {
					$total_loss_amt = $total_win_amt - $total_bid_amt;
				}
				$data_json['total_bid'] = $total_bid_amt;
				$data_json['total_win'] = $total_win_amt;
				$data_json['total_profit'] = $total_profit_amt;
				$data_json['total_loss'] = $total_loss_amt;
		
				$data_json['msg']='Success';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	
	public function apiGetBidWinReportDetails()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$bid_date=$input_data->bid_date;
				$game_id=$input_data->game_id;
				$page=$input_data->page;				
				$start = 0; 
				$limit = 20; 
				$start = ($page - 1) * $limit;
						
				$where = array('bid_date' => $bid_date,'game_id' => $game_id);
				$joins = array(
					array(
						'table' => $this->tb3,
						'condition' => $this->tb3.'.user_id = '.$this->tb18.'.user_id',
						'jointype' => 'LEFT'
					)
				);
				$columns="user_name,unique_token,game_name,bid_id,pana,session,digits,closedigits,points,bid_tx_id,pay_status";
				$by = 'bid_id';

				$data_json['getBidList']= $this->Frontamodel->get_joins_where_desc_scroll($this->tb18,$columns, $joins,$where,$by,$start,$limit);
										
					
				$data_json['msg']='Success';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiGetBidWinnerList()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$result_date=$input_data->result_date;
				$game_id=$input_data->game_id;
				$page=$input_data->page;				
				$start = 0; 
				$limit = 20; 
				$start = ($page - 1) * $limit;
				
				
				$where=array('game_id'=>$game_id,'result_date'=>$result_date);	
				$result = $this->Frontamodel->get_data($this->tb21,$where);
				$open_decleare_status=0;
				$close_decleare_status=0;
				foreach($result as $rs)
				{
					$open_decleare_status=$rs->open_decleare_status;
					$close_decleare_status=$rs->close_decleare_status;
					$open_result_token=$rs->open_result_token;
					$close_result_token=$rs->close_result_token;
				}
				$getOpenResultHistory=array();
				$getCloseResultHistory=array();
				
				if($open_decleare_status==1)
					{
						
						$where = array('DATE('.$this->tb14.'.insert_date)' => $result_date,$this->tb18.'.game_id'=>$game_id,$this->tb14.'.open_result_token'=>$open_result_token);
						
						$joins = array(
								array(

										'table' => $this->tb18,

										'condition' => $this->tb18.'.bid_tx_id = '.$this->tb14.'.bid_tx_id',

										'jointype' => 'LEFT'

									),
									array(

									'table' => $this->tb3,

									'condition' => $this->tb3.'.user_id = '.$this->tb18.'.user_id',

									'jointype' => 'LEFT'
			
								),
								

						);
						

						$columns="user_name,".$this->tb3.".unique_token,".$this->tb18.".game_name,".$this->tb18.".session,".$this->tb14.".amount,transaction_note,transaction_note,tx_request_number,".$this->tb14.'.insert_date,pana,digits,closedigits,points,bid_id,'.$this->tb18.'.bid_tx_id';
						
						

						$by = 'transaction_id';
						
						$getOpenResultHistory= $this->Frontamodel->get_joins_where_desc_scroll($this->tb14,$columns, $joins,$where,$by,$start,$limit);
										
					}
						
					if($close_decleare_status==1)
					{
						
						$where = array('DATE('.$this->tb14.'.insert_date)' => $result_date,$this->tb18.'.game_id'=>$game_id,$this->tb14.'.close_result_token'=>$close_result_token);
						
						$joins = array(
								array(

										'table' => $this->tb18,

										'condition' => $this->tb18.'.bid_tx_id = '.$this->tb14.'.bid_tx_id',

										'jointype' => 'LEFT'

									),
									array(

									'table' => $this->tb3,

									'condition' => $this->tb3.'.user_id = '.$this->tb18.'.user_id',

									'jointype' => 'LEFT'
			
								),
								
						);
						
						$columns="user_name,".$this->tb3.".unique_token,".$this->tb18.".game_name,".$this->tb18.".session,".$this->tb14.".amount,transaction_note,transaction_note,tx_request_number,".$this->tb14.'.insert_date,pana,digits,closedigits,points,bid_id,'.$this->tb18.'.bid_tx_id';

						$by = 'transaction_id';

						$getCloseResultHistory= $this->Frontamodel->get_joins_where_desc_scroll($this->tb14,$columns, $joins,$where,$by,$start,$limit);
										
					}
					$get_winning_data = array_merge($getOpenResultHistory,$getCloseResultHistory);
					$data_json['winner_list'] = $get_winning_data;
				
					
				$data_json['msg']='Success';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiGetWithdrawalList()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$withdraw_date=$input_data->withdraw_date;
				$page=$input_data->page;				
				$start = 0; 
				$limit = 20; 
				$start = ($page - 1) * $limit;
				
				$where = array('DATE('.$this->tb11.'.insert_date)'=>$withdraw_date);
		
				$joins = array(
						array(
							'table' => $this->tb3,
							'condition' => $this->tb3.'.user_id = '.$this->tb11.'.user_id',
							'jointype' => 'LEFT'
						),
						array(
							'table' => $this->tb14,
							'condition' => $this->tb14.'.tx_request_number = '.$this->tb11.'.request_number',
							'jointype' => 'LEFT'
						)
					);

				$columns = 'withdraw_request_id,user_name,mobile,request_amount,request_number,request_status,payment_receipt,date_format('.$this->tb11.'.insert_date,"%d %b %Y %r") as insert_date,unique_token,payment_method,tx_request_number,ac_number,ac_holder_name,paytm_number,google_pay_number,phone_pay_number';

				$by = 'withdraw_request_id';
						
				$withdrawData= $this->Frontamodel->get_joins_where_desc_scroll($this->tb11,$columns, $joins,$where,$by,$start,$limit);
				
				if(count($withdrawData)>0)
				{
					foreach($withdrawData as $rs)
					{
						if($rs->payment_method == 1){
							$method = 'A/c Transfer ('.$rs->ac_number.')('.$rs->ac_holder_name.')';
						}else if($rs->payment_method == 2){
							$method = 'Paytm ('.$rs->paytm_number.')';
						}else if($rs->payment_method == 3){
							$method = 'Google Pay ('.$rs->google_pay_number.')';
						}else if($rs->payment_method == 4){
							$method = 'PhonePay ('.$rs->phone_pay_number.')';
						}
						
						$rs->payment_method=$method;
					}
				}
				
				$where = array('amount_status'=>2,'DATE('.$this->tb14.'.insert_date)'=>$withdraw_date);
		
				$get_data = $this->Frontamodel->get_data($this->tb14,$where);
				$withdraw_amt = 0;
				if(count($get_data)>0){
					foreach($get_data as $rs){
						$withdraw_amt += $rs->amount;
					}
				}
				
				$where = array('request_status'=>2,'DATE('.$this->tb11.'.insert_date)'=>$withdraw_date);
				$get_withdraw = $this->Frontamodel->get_data($this->tb11,$where);
				$total_accept = 0;
				if(count($get_withdraw)>0){
					foreach($get_withdraw as $rs){
						$total_accept += $rs->request_amount;
					}
				}
				
				$where = array('request_status'=>1,'DATE('.$this->tb11.'.insert_date)'=>$withdraw_date);
				$get_reject_data = $this->Frontamodel->get_data($this->tb11,$where);
				$total_reject = 0;
				if(count($get_reject_data)>0){
					foreach($get_reject_data as $rs){
						$total_reject += $rs->request_amount;
					}
				}
				
				$data_json['total_accept'] = $total_accept;
				$data_json['total_reject'] = $total_reject;
				$data_json['withdraw_amt'] = $withdraw_amt;
				$data_json['withdrawData']=$withdrawData;
				$data_json['msg']='Success';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	
	
	public function apiApproveWithdrawRequest()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$withdraw_request_id=$input_data->withdraw_request_id;
				$remark=$input_data->remark;				
				$approve_receipt=$input_data->approve_receipt;				
				$path = 'uploads/file/';
				if($approve_receipt != 'NA'){
						 $approve_receipt = $this->fileUpload($approve_receipt,$path);}
						 else
						 {
							 $approve_receipt='';
						 }
				
				$withdrawReqdata = array(
				'request_status' => 2,
				'payment_receipt' => $approve_receipt,
				'remark' => $remark,
				);
				$where = array('withdraw_request_id'=>$withdraw_request_id);		
				$this->Frontcmodel->update_where($this->tb11,$withdrawReqdata,$where);
				
				$result = $this->Frontamodel->get_data_row($this->tb11,$where);
				if($result != '')
				{
					$user_id = $result->user_id;
					$request_amount = $result->request_amount;
					$request_number = $result->request_number;
				}
				$where = array('user_id'=>$user_id);
				$holdamtdata = array('hold_amount'=>0);
				
				$this->Frontcmodel->update_where($this->tb3,$holdamtdata,$where);

				
				$history_data = array(
						'user_id' => $user_id,
						'amount' => $request_amount,
						'transaction_type' => 2,
						'transaction_note' => 'Amount Withdraw',
						'amount_status' => 2,
						'tx_request_number' => $request_number,
						'insert_date' => $this->insert_date
					);
					
				$this->Frontbmodel->insertData($this->tb14,$history_data);
				
				$insert_data = array('user_id' => $user_id,'msg' => "Congratulations ,Your withdraw request of amount".$request_amount." is accepted",'insert_date' => $this->insert_date	);
				
				$this->Frontbmodel->insertData($this->tb22,$insert_data);
						
				$data_json['request_status'] = 'Accepted';
				$data_json['msg'] = 'Withdraw Request Approved successfully.';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiRejectWithdrawRequest()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$withdraw_request_id=$input_data->withdraw_request_id;
				$remark=$input_data->remark;
				$where = array('withdraw_request_id'=>$withdraw_request_id);

				$result = $this->Frontamodel->get_data_row($this->tb11,$where);
				if($result != '')
				{
					$user_id = $result->user_id;		
					$request_amount = $result->request_amount;
				}
				$where_user = array('user_id'=>$user_id);
				$result = $this->Frontamodel->get_data_row($this->tb3,$where_user);
				if($result!= "")
				{
					$hold_amount = $result->hold_amount;
					$wallet_balance = $result->wallet_balance;
				}
				$wallet_balance += $hold_amount;
				$addholdamtdata = array(
						'wallet_balance'=>$wallet_balance,
						'hold_amount' => 0
						);
				$this->Frontcmodel->update_where($this->tb3,$addholdamtdata,$where_user);
				$withdrawReqdata = array(
					'request_status' => 1,
					'remark' => $remark,
					);
				$where = array('withdraw_request_id'=>$withdraw_request_id);
				$this->Frontcmodel->update_where($this->tb11,$withdrawReqdata,$where);
					
					$insert_data = array(		
						'user_id' => $user_id,
						'msg' => "Sorry, Your withdraw request of amount".$request_amount." is rejected",
						'insert_date' => $this->insert_date
					);
					
				$this->Frontbmodel->insertData($this->tb22,$insert_data);
				
				$data_json['msg']='Success';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	
	public function apiAutoDepositHistory()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$bid_date=$input_data->bid_date;
				$page=$input_data->page;				
				$start = 0; 
				$limit = 20; 
				
				 $start = ($page - 1) * $limit;
				
				$where = array('DATE('.$this->tb50.'.insert_date)'=>$bid_date);
		
				$joins = array(
						array(
							'table' => $this->tb3,
							'condition' => $this->tb3.'.user_id = '.$this->tb50.'.user_id',
							'jointype' => 'LEFT'
						)
					);
				
				$columns = "user_name,unique_token,amount,payment_method,paid_upi,tx_request_number,txn_id,DATE_FORMAT(".$this->tb50.".insert_date,'%d %b %Y %r') as insert_date";
				
				$by=$this->tb50.'.id';
				
				$depositHistoryData = $this->Frontamodel->get_joins_where_desc_scroll($this->tb50,$columns, $joins,$where,$by,$start,$limit);

				$data_json['depositHistoryData']=$depositHistoryData;
				$data_json['msg']='Success';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiGetReferralAmountHistory()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$reg_date=$input_data->reg_date;
				$page=$input_data->page;				
				$start = 0; 
				$limit = 20; 
				
				 $start = ($page - 1) * $limit;
				
				$where = array('DATE('.$this->tb14.'.insert_date)'=>$reg_date,'amount_status'=>20);
		
				$joins = array(
						array(
							'table' => $this->tb3.' a',
							'condition' => 'a.user_id = '.$this->tb14.'.user_id',
							'jointype' => 'LEFT'
						),
						array(
							'table' => $this->tb3.' b',
							'condition' => 'b.user_id = '.$this->tb14.'.ref_downliner_id',
							'jointype' => 'LEFT'
						)
					);
				
				$columns = "a.user_name,b.user_name as downliner_name,ref_downliner_id,a.unique_token,amount,amount_added,transaction_note,tx_request_number,txn_id,DATE_FORMAT(".$this->tb14.".insert_date,'%d %b %Y %r') as insert_date";
				
				$by=$this->tb14.'.transaction_id ';
				 
				
				$referralHistoryData = $this->Frontamodel->get_joins_where_desc_scroll($this->tb14,$columns, $joins,$where,$by,$start,$limit);

				$data_json['referralHistoryData']=$referralHistoryData;
				$data_json['msg']='Success';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function deductUserWallet($open_result_token)
	{
		
		$where=array('open_result_token'=>$open_result_token);	
		$result = $this->Frontamodel->get_data($this->tb14,$where);
		
		foreach($result as $rs)
		{
		
			$where=array('user_id'=>$rs->user_id);
			$col='wallet_balance';
			$this->Frontamodel->updateSetDataMinusAmount($this->tb3,$where,$col,$rs->amount);
			
			$where_array=array('user_id'=>$rs->user_id,'transaction_id'=>$rs->transaction_id);
			
			$this->Frontdmodel->delete($this->tb14,$where_array);
			
		
		}
				

	}
	
	
	
	
	public function deductUserCloseWallet($close_result_token)
	{
		
		$where=array('close_result_token'=>$close_result_token);	
		$result = $this->Frontamodel->get_data($this->tb14,$where);
		
		foreach($result as $rs)
		{
		
			$where=array('user_id'=>$rs->user_id);
			$col='wallet_balance';
			$this->Frontamodel->updateSetDataMinusAmount($this->tb3,$where,$col,$rs->amount);
			
			$where_array=array('user_id'=>$rs->user_id,'transaction_id'=>$rs->transaction_id);
			
			$this->Frontdmodel->delete($this->tb14,$where_array);
			
		
		}
				

	}
	
	
	
	
	public function updateUserWallet($user_id,$win_amount,$msg,$open_result_token,$bid_tx_id)
	{
		$where=array('user_id'=>$user_id);
		$col='wallet_balance';
		$this->Frontamodel->updateSetDataAddAmount($this->tb3,$where,$col,$win_amount);
		
		$request_number = $this->randomNumber();
		$history_data = array(
				'user_id' => $user_id,
				'amount' => $win_amount,
				'transaction_type' => 1,
				'transaction_note' => $msg,
				'amount_status' => 8,
				'tx_request_number' => $request_number,
				'open_result_token' => $open_result_token,
				'bid_tx_id' => $bid_tx_id,
				'insert_date' => $this->insert_date
		);
		$this->Frontbmodel->insertData($this->tb14,$history_data);
				

	}
	
	public function updateCloseUserWallet($user_id,$win_amount,$msg,$close_result_token,$bid_tx_id)
	{
		$where=array('user_id'=>$user_id);
		$col='wallet_balance';
		$this->Frontamodel->updateSetDataAddAmount($this->tb3,$where,$col,$win_amount);
		
		$request_number = $this->randomNumber();
		$history_data = array(
				'user_id' => $user_id,
				'amount' => $win_amount,
				'transaction_type' => 1,
				'transaction_note' => $msg,
				'amount_status' => 8,
				'tx_request_number' => $request_number,
				'close_result_token' => $close_result_token,
				'bid_tx_id' => $bid_tx_id,
				'insert_date' => $this->insert_date
		);
		$this->Frontbmodel->insertData($this->tb14,$history_data);
				

	}
	
	
	////////////////////////// Starline ////////////////////////
	
	public function apiGetStarlineRatesList()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$game_rates = $this->Frontamodel->getData($this->tb34);
				$data_json['game_rates']=$game_rates;
				$data_json['msg']='Success';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiStarlineUpdateRatesList()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$game_rate_id=$input_data->game_rate_id;
				$single_digit_val_1=$input_data->single_digit_val_1;
				$single_digit_val_2=$input_data->single_digit_val_2;
				$single_pana_val_1=$input_data->single_pana_val_1;
				$single_pana_val_2=$input_data->single_pana_val_2;
				$double_pana_val_1=$input_data->double_pana_val_1;
				$double_pana_val_2=$input_data->double_pana_val_2;
				$tripple_pana_val_1=$input_data->tripple_pana_val_1;
				$tripple_pana_val_2=$input_data->tripple_pana_val_2;
				
							
				$settingsData = array(
				'single_digit_val_1' => $single_digit_val_1,
				'single_digit_val_2' => $single_digit_val_2,
				'single_pana_val_1' => $single_pana_val_1,
				'single_pana_val_2' => $single_pana_val_2,
				'double_pana_val_1' => $double_pana_val_1,
				'double_pana_val_2' => $double_pana_val_2,
				'tripple_pana_val_1' => $tripple_pana_val_1,
				'tripple_pana_val_2' => $tripple_pana_val_2,
				);
			
				if($game_rate_id == '')
				{
					$this->Frontbmodel->insertData($this->tb34,$settingsData);
					$data_json['msg']='Game Rates Successfully Added.';
					$data_json['status']=true;
							
				}
				else 
				{
					$where = array('game_rate_id'=>$game_rate_id);
					$this->Frontcmodel->update_where($this->tb34,$settingsData,$where);
					$data_json['msg']='Game Rates Successfully Updated.';
					$data_json['status']=true;
				}
				
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiStarlineGameNameList()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				
				$where_array=array();
				$result=$this->Frontamodel->get_data($this->tb35,$where_array);
				$data_json['starline_game_list']=$result;
				$data_json['msg']='Success';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiStarlineActiveInactiveGame()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$game_id=$input_data->game_id;
				$status=$input_data->status;
						
				if($status=='1')
				{
					$status='0';				
				}
				else
				{
					$status='1';				
				}		
				$updateData = array(
				'status' => $status,
				);
				$where = array('game_id'=>$game_id);
				$this->Frontcmodel->update_where($this->tb35,$updateData,$where);
				$data_json['msg']='Game Status Successfully Changed.';
				$data_json['status']=true;
				
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiStarlineGameNameUpdate()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$game_id=$input_data->game_id;
				$game_name=$input_data->game_name;
				$game_name_hindi=$input_data->game_name_hindi;
				$open_time=$input_data->open_time;
						
					
				$updateData = array(
				'game_name' => $game_name,
				'game_name_hindi' => $game_name_hindi,
				'open_time' => date('h:i A', strtotime($open_time)),
			
			'open_time_sort' => date('H:i:s', strtotime($open_time)),
				);
				$where = array('game_id'=>$game_id);
				$this->Frontcmodel->update_where($this->tb35,$updateData,$where);
				$data_json['msg']='Game Name Successfully Updated.';
				$data_json['status']=true;
				
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiStarlineGameNameAdd()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$game_name=$input_data->game_name;
				$game_name_hindi=$input_data->game_name_hindi;
				$open_time=$input_data->open_time;
							
				$updateData = array(
				'game_name' => $game_name,
				'game_name_hindi' => $game_name_hindi,
				'open_time' => date('h:i A', strtotime($open_time)),
				'open_time_sort' => date('H:i:s', strtotime($open_time)),
				);
				$this->Frontbmodel->insertData($this->tb35,$updateData);
				$data_json['msg']='Game Name Successfully Updated.';
				$data_json['status']=true;
				
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiStarlineMarketStatusGame()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$game_id=$input_data->game_id;
				$market_status=$input_data->market_status;
						
				if($market_status=='1')
				{
					$market_status='0';				
				}
				else
				{
					$market_status='1';				
				}
						
				$updateData = array(
				'market_status' => $market_status,
				);
				$where = array('game_id'=>$game_id);
				$this->Frontcmodel->update_where($this->tb35,$updateData,$where);
				$data_json['msg']='Game Status Successfully Changed.';
				$data_json['status']=true;
				
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiGetStarlineGameListDropdown()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$where_array=array('status'=>1);
				$select="game_id,game_name";
				$game_array=$this->Frontamodel->get_data_select($this->tb35,$where_array,$select);
				
				$data_json['game_array']=$game_array;
				$data_json['msg']='Success';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiGetStarlineUserBidHistory()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$bid_date=$input_data->bid_date;
				$game_name=$input_data->game_id;
				$game_type=$input_data->game_type;
				$page=$input_data->page;
				
				$bid_date = date('Y-m-d',strtotime($bid_date));
		
				if($game_name == 'all' && $game_type == 'all'){
					$where = array('bid_date' => $bid_date);
				}else if($game_name == 'all' && $game_type != 'all'){
					$where = array('bid_date' => $bid_date,'pana' => $game_type);
				}else if($game_name != 'all' && $game_type == 'all'){
					$where = array('bid_date' => $bid_date,'game_id' => $game_name);
				}else if($game_name != 'all' && $game_type != 'all'){
					$where = array('bid_date' => $bid_date,'game_id' => $game_name,'pana' => $game_type);
				}
				
				$start = 0; 
				$limit = 20; 
				
				$total=count($this->Frontamodel->get_data($this->tb37,$where));
				
				 $page_limit = $total/$limit; 
				 
				 $start = ($page - 1) * $limit;
				
				$joins = array(
							array(
								'table' => $this->tb3,
								'condition' => $this->tb3.'.user_id = '.$this->tb37.'.user_id',
								'jointype' => 'LEFT'
							)
						);
				$columns="user_name,".$this->tb3.".unique_token,game_name,pana,session,digits,closedigits,points,bid_tx_id";
				$by = 'bid_id';
				
				$getBidHistory = $this->Frontamodel->get_joins_where_desc_scroll($this->tb37,$columns, $joins,$where,$by,$start,$limit);
				$data_json['getBidHistory']=$getBidHistory;
				$data_json['msg']='Success';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiStarlineResultHistoryList()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$page=$input_data->page;
				$start = 0; 
				$limit = 20; 
				$where = array();
				
				 
				 $joins = array(
							array(
								'table' => $this->tb35.' b',
								'condition' => 'b.game_id = '.$this->tb36.'.game_id',
								'jointype' => 'LEFT'
							)
						);
				$columns="id,b.game_id,IFNULL(date_format(result_date,'%d %b %Y'),'') as result_date,result_date as result_dec_date,IFNULL(date_format(open_decleare_date,'%d %b %Y %r'),'') as open_decleare_date,b.game_name,open_number,open_decleare_status";
				$by = 'id';
				
				/* $total=count($this->Frontamodel->get_joins_where($this->tb36,$columns, $joins,$where));
				
				$page_limit = $total/$limit; */ 
				 
				 $start = ($page - 1) * $limit;
				
				$StarlineResultHistory = $this->Frontamodel->get_joins_where_desc_scroll($this->tb36,$columns, $joins,$where,$by,$start,$limit);
				$data_json['StarlineResultHistory']=$StarlineResultHistory;
				$data_json['msg']='Success';
				$data_json['status']=true;
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiGetStarlineWinningPrediction()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$game_id=$input_data->game_id;
				$open_number=$input_data->open_number;
				$result_date=$input_data->result_date;
				
				
				$game_rates=$this->Frontamodel->getData($this->tb34);
				foreach($game_rates as $rs)
				{
					$single_digit_val_2=$rs->single_digit_val_2;
					$single_pana_val_2=$rs->single_pana_val_2;
					$double_pana_val_2=$rs->double_pana_val_2;
					$tripple_pana_val_2=$rs->tripple_pana_val_2;

				}
					
					$where=array($this->tb37.'.game_id'=>$game_id,'pay_status'=>0,'bid_date'=>$result_date,'session'=>'Open');	
						$joins = array(

							array(

								'table' => $this->tb35,
						'condition' => $this->tb35.'.game_id = '.$this->tb37.'.game_id',
								'jointype' => 'LEFT'
								),
								array(

								'table' => $this->tb3,
								'condition' => $this->tb3.'.user_id = '.$this->tb37.'.user_id',
								'jointype' => 'LEFT'
								)

						);
						
				$columns=$this->tb35.".game_name,".$this->tb3.".unique_token,pana,session,digits,closedigits,points,bid_id,bid_tx_id,pay_status,user_name";
				$by = 'bid_id';
				
				$result= $this->Frontamodel->get_joins_where_desc($this->tb37,$columns,$joins,$where,$by);
				
				$data_array=array();
					$i=0;
					
					$win_amt_sum=0;
					$points_amt_sum=0;
					foreach($result as $rs)
					{
						$game_not_name=$rs->game_name;
						$win_number_not=$open_number[0]+$open_number[1]+$open_number[2];
							
						if($win_number_not>9)
						$win_number_not=$win_number_not%10;
					$win_amt=0;
					$points=0;
						
						if($rs->pana=='Single Digit')
						{
							$win_number=$open_number[0]+$open_number[1]+$open_number[2];
							
							if($win_number>9)
							$win_number=$win_number%10;


							if($win_number==$rs->digits)
							{
								$win_amt=($single_digit_val_2/10)*$rs->points;
								
								$points=$rs->points;
								
								$data_array[$i]['points']=$rs->points;
								$data_array[$i]['unique_token']=$rs->unique_token;
								$data_array[$i]['user_name']=$rs->user_name;
								$data_array[$i]['pana']=$rs->pana;
								$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
								$data_array[$i]['win_amt']=$win_amt;
								$data_array[$i]['bid_id']=$rs->bid_id;
								
							}
						}
						else if($rs->pana=='Triple Pana')
						{
							if($open_number==$rs->digits)
							{
								$win_amt=($tripple_pana_val_2/10)*$rs->points;
								
								$points=$rs->points;
													
								$data_array[$i]['points']=$rs->points;
								$data_array[$i]['unique_token']=$rs->unique_token;
								$data_array[$i]['user_name']=$rs->user_name;
								$data_array[$i]['pana']=$rs->pana;
								$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
								$data_array[$i]['win_amt']=$win_amt;
								$data_array[$i]['bid_id']=$rs->bid_id;
							}
						}
						else if($rs->pana=='Double Pana')
						{
							if($open_number==$rs->digits)
							{
								$win_amt=($double_pana_val_2/10)*$rs->points;
								
								$points=$rs->points;
								
								$data_array[$i]['points']=$rs->points;
								$data_array[$i]['unique_token']=$rs->unique_token;
								$data_array[$i]['user_name']=$rs->user_name;
								$data_array[$i]['pana']=$rs->pana;
								$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
								$data_array[$i]['win_amt']=$win_amt;
								$data_array[$i]['bid_id']=$rs->bid_id;
							}
						}
						
						else if($rs->pana=='Single Pana')
						{
							if($open_number==$rs->digits)
							{
								$win_amt=($single_pana_val_2/10)*$rs->points;
								
								$points=$rs->points;
								
								$data_array[$i]['unique_token']=$rs->unique_token;
								$data_array[$i]['points']=$rs->points;
								$data_array[$i]['user_name']=$rs->user_name;
								$data_array[$i]['pana']=$rs->pana;
								$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
								$data_array[$i]['win_amt']=$win_amt;
								$data_array[$i]['bid_id']=$rs->bid_id;
							}
						}
						$win_amt_sum=$win_amt+$win_amt_sum;
						$points_amt_sum=$points+$points_amt_sum;
						if($win_amt>0)
						$i++;
						
					}
								
					$data_json['winner_list'] = $data_array; 
					$data_json['win_amt_sum'] = $win_amt_sum; 
					$data_json['points_amt_sum'] = $points_amt_sum; 
					$data_json['status'] = true; 
					$data_json['msg'] = "Success"; 
								
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiStarlineWinningReport()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$game_name=$input_data->game_name;
				$result_date=$input_data->result_date;
				$result_date = date('Y-m-d',strtotime($result_date));
				$page=$input_data->page;
				$start = 0; 
				$limit = 20; 
				$where=array();
				
				
				
				
				 
				
				$joins = array(

								array(

									'table' => $this->tb14,

									'condition' => $this->tb14.'.open_result_token = '.$this->tb36.'.open_result_token',

									'jointype' => 'LEFT'

								),
								array(

										'table' => $this->tb37,

										'condition' => $this->tb37.'.bid_tx_id = '.$this->tb14.'.bid_tx_id',

										'jointype' => 'LEFT'

									),
									array(

									'table' => $this->tb3,

									'condition' => $this->tb3.'.user_id = '.$this->tb37.'.user_id',

									'jointype' => 'LEFT'
			
								),
								

						);
						
				$where = array('result_date' => $result_date,$this->tb37.'.game_id'=>$game_name);
				
				/* $total=count($this->Frontamodel->get_joins_where($this->tb36,$columns, $joins,$where));
				
				$page_limit = $total/$limit;  */
				 
				 $start = ($page - 1) * $limit;

				$columns="user_name,unique_token,".$this->tb37.".game_name,".$this->tb37.".session,".$this->tb14.".amount,transaction_note,transaction_note,tx_request_number,".$this->tb14.'.insert_date,pana,digits,closedigits,points,bid_id,'.$this->tb37.'.bid_tx_id';

				$by = 'transaction_id';

				$getResultHistory= $this->Frontamodel->get_joins_where_desc_scroll($this->tb36,$columns, $joins,$where,$by,$start,$limit);
				$data_json['getResultHistory']=$getResultHistory;
				$data_json['msg']='Success';
				$data_json['status']=true;
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	
	
	public function apiSaveStarlineResultData()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$open_number=$input_data->open_number;
				$game_id=$input_data->game_id;
				$result_dec_date=$input_data->result_dec_date;
				
				
				$insert_data = array(
						'open_number'=>$open_number,
						'game_id'=>$game_id,
						'result_date'=>$result_dec_date,
						);

				
				$where=array('game_id'=>$game_id,'result_date'=>$result_dec_date);	
				$result = $this->Frontamodel->get_data($this->tb36,$where);		$where=array('game_id'=>$game_id,'open_decleare_status'=>1,'result_date'=>$result_dec_date);			
				$game_dec_result = $this->Frontamodel->get_data($this->tb36,$where);		
				if(count($game_dec_result)>0)
				{						
					$data_json['status'] = false; 			
					$data_json['msg'] = "Game result already Declared";			
					echo json_encode($data_json); 
					die;	
				}
				
				if(count($result)<1)
				{
					$this->Frontbmodel->insertData($this->tb36,$insert_data);
					$data_json['status'] = true; 
					$data_json['msg'] = "Successfully inserted.";

				}
				else

				{
					$where=array('game_id'=>$game_id,'result_date'=>$result_dec_date);	
					$this->Frontcmodel->update_where($this->tb36,$insert_data,$where);
					
					$data_json['status'] = true; 
					$data_json['msg'] = "Successfully updated.";

				}
				
				$open_num=$open_number[0]+$open_number[1]+$open_number[2];
				if($open_num<10)
				$data_json['open_result']=$open_num;
						
				if($open_num>9)
				$data_json['open_result']=$open_num%10;
								
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	
	
	public function apiStarlineDeclareResult()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$game_id=$input_data->game_id;
				$result_dec_date=$input_data->result_dec_date;
				
				
				$where=array('game_id'=>$game_id,'open_number!='=>"",'result_date'=>$result_dec_date);	
			$result = $this->Frontamodel->get_data($this->tb36,$where);
			
			
			
			if(count($result)<1)
			{

				$data_json['status'] = true; 
				$data_json['msg'] = "Please save game result first";

			}

			else
			{						
				$where=array('game_id'=>$game_id,'open_decleare_status'=>1,'result_date'=>$result_dec_date);			
				$game_dec_result = $this->Frontamodel->get_data($this->tb36,$where);			
				if(count($game_dec_result)>0)
				{								
					$data_json['status'] = true; 				
					$data_json['msg'] ="Game result already Declared";				
					echo json_encode($data_json);
					die;			
				}
				foreach($result as $rs)
				{
					$open_number=$rs->open_number;
				}
			
			
			$where=array('game_id'=>$game_id);	
			$game_name_result = $this->Frontamodel->get_data($this->tb35,$where);
			foreach($game_name_result as $rs)
			{
					$game_not_name=$rs->game_name;
			}
			
			$win_number_not=$open_number[0]+$open_number[1]+$open_number[2];
			if($win_number_not>9)
				$win_number_not=$win_number_not%10;
			
			
			$game_rates=$this->Frontamodel->getData($this->tb34);
			foreach($game_rates as $rs)
			{
				$single_digit_val_2=$rs->single_digit_val_2;
				$single_pana_val_2=$rs->single_pana_val_2;
				$double_pana_val_2=$rs->double_pana_val_2;
				$tripple_pana_val_2=$rs->tripple_pana_val_2;
			}
			
			$where=array($this->tb37.'.game_id'=>$game_id,'pay_status'=>0,'bid_date'=>$result_dec_date,'session'=>'Open');	
			
				$joins = array(

					array(

						'table' => $this->tb35,
						'condition' => $this->tb35.'.game_id = '.$this->tb37.'.game_id',
						'jointype' => 'LEFT'
						)

				);
				
			$columns=$this->tb35.".game_name,pana,user_id,session,digits,closedigits,points,bid_id,bid_tx_id,pay_status";
			$by = 'bid_id';

			$result= $this->Frontamodel->get_joins_where_desc($this->tb37,$columns,$joins,$where,$by);
					
			$open_result_token=$this->volanlib->uniqRandom(15);
			foreach($result as $rs)
			{
				$game_not_name=$rs->game_name;
				$win_number_not=$open_number[0]+$open_number[1]+$open_number[2];
					
				if($win_number_not>9)
				$win_number_not=$win_number_not%10;
				
				if($rs->pana=='Single Digit')
				{
					$win_number=$open_number[0]+$open_number[1]+$open_number[2];
					
					if($win_number>9)
					$win_number=$win_number%10;
					
					if($win_number==$rs->digits)
					{
						$win_amt=($single_digit_val_2/10)*$rs->points;
						
						
						$msg=$rs->game_name.' in '.$rs->pana.' '.' for bid amount- '.$rs->points.' Won';
						$this->updateUserWallet($rs->user_id,$win_amt,$msg,$open_result_token,$rs->bid_tx_id);
						
						$where=array('bid_id'=>$rs->bid_id);
						$up_data=array('pay_status'=>1,'open_result_token'=>$open_result_token);
						
						$this->Frontcmodel->update_where($this->tb37,$up_data,$where);
						
						$insert_data = array(
						'user_id' => $rs->user_id,
						'bid_tx_id' => $rs->bid_tx_id,
						'open_result_token'=>$open_result_token,
						'msg' => "Congratulations ,You Won in ".$rs->game_name." for Bid Number- ".$rs->bid_tx_id,
						'insert_date' => $this->insert_date
						);
						
						$this->Frontbmodel->insertData($this->tb22,$insert_data);

						
					}
				}
				else if($rs->pana=='Triple Pana')
				{
					if($open_number==$rs->digits)
					{
						$win_amt=($tripple_pana_val_2/10)*$rs->points;
						
						$msg=$rs->game_name.' in '.$rs->pana.' '.' for bid amount- '.$rs->points.' Won';
						$this->updateUserWallet($rs->user_id,$win_amt,$msg,$open_result_token,$rs->bid_tx_id);
						
						$where=array('bid_id'=>$rs->bid_id);
						$up_data=array('pay_status'=>1,'open_result_token'=>$open_result_token);
						
						$this->Frontcmodel->update_where($this->tb37,$up_data,$where);
						
						$insert_data = array(
						'user_id' => $rs->user_id,
						'bid_tx_id' => $rs->bid_tx_id,
						'open_result_token'=>$open_result_token,
						'msg' => "Congratulations ,You Won in ".$rs->game_name." for Bid Number- ".$rs->bid_tx_id,
						'insert_date' => $this->insert_date
						);
						
						$this->Frontbmodel->insertData($this->tb22,$insert_data);

						
					}
				}
				else if($rs->pana=='Double Pana')
				{
					if($open_number==$rs->digits)
					{
						$win_amt=($double_pana_val_2/10)*$rs->points;
						
						
						$msg=$rs->game_name.' in '.$rs->pana.' '.' for bid amount- '.$rs->points.' Won';
						
						$this->updateUserWallet($rs->user_id,$win_amt,$msg,$open_result_token,$rs->bid_tx_id);
						
						$where=array('bid_id'=>$rs->bid_id);
						$up_data=array('pay_status'=>1,'open_result_token'=>$open_result_token);
						$this->Frontcmodel->update_where($this->tb37,$up_data,$where);
						$insert_data = array(
						'user_id' => $rs->user_id,
						'bid_tx_id' => $rs->bid_tx_id,
						'open_result_token'=>$open_result_token,
						'msg' => "Congratulations ,You Won in ".$rs->game_name." for Bid Number- ".$rs->bid_tx_id,
						'insert_date' => $this->insert_date
						);
						$this->Frontbmodel->insertData($this->tb22,$insert_data);
						
					}
				}
				
				else if($rs->pana=='Single Pana')
				{
					if($open_number==$rs->digits)
					{
						$win_amt=($single_pana_val_2/10)*$rs->points;
						
						
						$msg=$rs->game_name.' in '.$rs->pana.' '.' for bid amount- '.$rs->points.' Won';
						
						$this->updateUserWallet($rs->user_id,$win_amt,$msg,$open_result_token,$rs->bid_tx_id);
						
						$where=array('bid_id'=>$rs->bid_id);
						$up_data=array('pay_status'=>1,'open_result_token'=>$open_result_token);
						$this->Frontcmodel->update_where($this->tb37,$up_data,$where);
						$insert_data = array(
						'user_id' => $rs->user_id,
						'bid_tx_id' => $rs->bid_tx_id,
						'open_result_token'=>$open_result_token,
						'msg' => "Congratulations ,You Won in ".$rs->game_name." for Bid Number- ".$rs->bid_tx_id,
						'insert_date' => $this->insert_date
						);
						$this->Frontbmodel->insertData($this->tb22,$insert_data);
						
					}
				}
				
			}
			
			$where=array('game_id'=>$game_id,'open_number!='=>"",'result_date'=>$result_dec_date);	
			$up_data=array('open_decleare_status'=>1,'open_decleare_date'=>$this->insert_date,'open_result_token'=>$open_result_token);
			
			$this->Frontcmodel->update_where($this->tb36,$up_data,$where);
			
			$data_json['status'] = true; 
			$data_json['open_declare_status'] = 1; 
			$data_json['open_declare_date'] = $this->insert_date; 
			$data_json['msg'] = "Successfully done.";
								
			}
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	
	
	public function apiStarlineSellReport()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$start_date=$input_data->start_date;
				$game_name=$input_data->game_id;
				$game_type=$input_data->game_type;
				
				$start_date=date('Y-m-d',strtotime($start_date));
				
				$session='Open';	
				if($game_type == "all")
				{
					$order_by = "points";
					$group_by='numbers';
					$joins = array(
						array(
								'table' => $this->tb37,
								'condition' => $this->tb37.'.digits = '.$this->tb26.'.single_digit && '.$this->tb37.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id="'.$game_name.'"',
								'jointype' => 'LEFT'
							)
						);
						
					$select='id,single_digit as numbers,IFNULL(sum(points),0) as total_points';
					$singe_digit_result=$this->Frontamodel->get_joins_group_by($this->tb26,$select,$joins,$order_by,$group_by);
					
					
					
					$joins2 = 
					 array(
					array(

							'table' => $this->tb37,
							'condition' => $this->tb37.'.digits = '.$this->tb31.'.numbers && '.$this->tb37.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id="'.$game_name.'"',
							'jointype' => 'LEFT'
						)
						);
					$select2='id,numbers,IFNULL(sum(points),0) as total_points';
					$double_result=$this->Frontamodel->get_joins_group_by($this->tb31,$select2,$joins2,$order_by,$group_by);
					
					
					$joins3 = 
					 array(
					array(

							'table' => $this->tb37,
							'condition' => $this->tb37.'.digits = '.$this->tb28.'.numbers && '.$this->tb37.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id="'.$game_name.'"',
							'jointype' => 'LEFT'
						)
						);
					$select3='id,numbers,IFNULL(sum(points),0) as total_points';
					$single_pana_result=$this->Frontamodel->get_joins_group_by($this->tb28,$select3,$joins3,$order_by,$group_by);
					
					
					$joins4 = 
					 array(
					array(

							'table' => $this->tb37,
							'condition' => $this->tb37.'.digits = '.$this->tb29.'.numbers && '.$this->tb37.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id="'.$game_name.'"',
							'jointype' => 'LEFT'
						)
						);
					$select4='id,numbers,IFNULL(sum(points),0) as total_points';
					$triple_pana_result=$this->Frontamodel->get_joins_group_by($this->tb29,$select4,$joins4,$order_by,$group_by);
					
					
					
					$all_result[]['single_digit'] = $singe_digit_result;
					 $all_result[]['single_pana'] = $single_pana_result;
					 $all_result[]['double_pana'] = $double_result;
					 $all_result[]['triple_pana'] = $triple_pana_result;
					
					$data_json['result']=$all_result;		    
						$data_json['msg']='Success.';
						$data_json['status']=true;			
				}
				else 
				{
					if($game_type=="Single Digit"){
					$order_by = "total_points";
					$group_by='numbers';
					$joins = array(
						array(
								'table' => $this->tb37,
								'condition' => $this->tb37.'.digits = '.$this->tb26.'.single_digit && '.$this->tb37.'.session="'.$session.'" && 	bid_date="'.$start_date.'" && game_id="'.$game_name.'"',
								'jointype' => 'LEFT'
							)
						);
						
					$select='id,single_digit as numbers,IFNULL(sum(points),0) as total_points';
					$all_result[]['single_digit']=$this->Frontamodel->get_joins_group_by($this->tb26,$select,$joins,$order_by,$group_by);
					}
					else if($game_type=="Double Pana")
					{
					$order_by = "total_points";
					$group_by='numbers';
						$joins2 = 
						 array(
						array(

								'table' => $this->tb37,
								'condition' => $this->tb37.'.digits = '.$this->tb31.'.numbers && '.$this->tb37.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id="'.$game_name.'"',
								'jointype' => 'LEFT'
							)
							);
						$select2='id,numbers,IFNULL(sum(points),0) as total_points';
						$all_result[]['double_pana']=$this->Frontamodel->get_joins_group_by($this->tb31,$select2,$joins2,$order_by,$group_by);
					}
					else if($game_type=="Single Pana"){
						$order_by = "total_points";
					$group_by='numbers';
					$joins3 = 
					 array(
					array(

							'table' => $this->tb37,
							'condition' => $this->tb37.'.digits = '.$this->tb28.'.numbers && '.$this->tb37.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id="'.$game_name.'"',
							'jointype' => 'LEFT'
						)
						);
					$select3='id,numbers,IFNULL(sum(points),0) as total_points';
					$all_result[]['single_pana']=$this->Frontamodel->get_joins_group_by($this->tb28,$select3,$joins3,$order_by,$group_by);
					}
					else if($game_type=="Triple Pana"){
					$order_by = "total_points";
					$group_by='numbers';
					$joins4 = 
					 array(
					array(

							'table' => $this->tb37,
							'condition' => $this->tb37.'.digits = '.$this->tb29.'.numbers && '.$this->tb37.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id="'.$game_name.'"',
							'jointype' => 'LEFT'
						)
						);
					$select4='id,numbers,IFNULL(sum(points),0) as total_points';
					$all_result[]['triple_pana']=$this->Frontamodel->get_joins_group_by($this->tb29,$select4,$joins4,$order_by,$group_by);
					}
					
					$data_json['result']=$all_result;		    
						$data_json['msg']='Success.';
						$data_json['status']=true;			
				}
		
		
			
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiDeleteStarlineResultData()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$game_id=$input_data->game_id;
				$result_dec_date=$input_data->result_dec_date;
				
				$where=array('game_id'=>$game_id,'result_date'=>$result_dec_date);	
				$result = $this->Frontamodel->get_data($this->tb36,$where);
				
				if(count($result)<1)
				{
					$data_json['status'] = false; 
					$data_json['msg'] = "Game result is not decleare yet";

				}
				else
				{
					foreach($result as $rs)
					{
							$open_result_token=$rs->open_result_token;
					}
			
					$where=array('open_result_token'=>$open_result_token);
					$up_data=array('pay_status'=>0);
					$this->Frontcmodel->update_where($this->tb37,$up_data,$where);
					
					$this->deductUserWallet($open_result_token);
					
					$where_array=array('open_result_token'=>$open_result_token);
					
					$this->Frontdmodel->delete($this->tb36,$where_array);
					$this->Frontdmodel->delete($this->tb22,$where_array);
					
			
					$data_json['msg'] = "Result Successfully done.";
					$data_json['status']=true;
			
				}
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	
	
	////////////////////// Gali Desswar ///////////
	public function apiGetGaliDessawarRatesList()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$game_rates = $this->Frontamodel->getData($this->tb43);
				$data_json['game_rates']=$game_rates;
				$data_json['msg']='Success';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiGaliDessawarUpdateRatesList()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$game_rate_id=$input_data->game_rate_id;
				$single_digit_val_1=$input_data->single_digit_val_1;
				$single_digit_val_2=$input_data->single_digit_val_2;
				$single_pana_val_1=$input_data->single_pana_val_1;
				$single_pana_val_2=$input_data->single_pana_val_2;
				$double_pana_val_1=$input_data->double_pana_val_1;
				$double_pana_val_2=$input_data->double_pana_val_2;

							
				$settingsData = array(
				'single_digit_val_1' => $single_digit_val_1,
				'single_digit_val_2' => $single_digit_val_2,
				'single_pana_val_1' => $single_pana_val_1,
				'single_pana_val_2' => $single_pana_val_2,
				'double_pana_val_1' => $double_pana_val_1,
				'double_pana_val_2' => $double_pana_val_2,
				);
			
				if($game_rate_id == '')
				{
					$this->Frontbmodel->insertData($this->tb43,$settingsData);
					$data_json['msg']='Game Rates Successfully Added.';
					$data_json['status']=true;
							
				}
				else 
				{
					$where = array('game_rate_id'=>$game_rate_id);
					$this->Frontcmodel->update_where($this->tb43,$settingsData,$where);
					$data_json['msg']='Game Rates Successfully Updated.';
					$data_json['status']=true;
				}
				
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiGaliDessawarGameNameList()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				
				$where_array=array();
				$result=$this->Frontamodel->get_data($this->tb44,$where_array);
				$data_json['game_list']=$result;
				$data_json['msg']='Success';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiGaliDessawaActiveInactiveGame()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$game_id=$input_data->game_id;
				$status=$input_data->status;
						
				if($status=='1')
				{
					$status='0';				
				}
				else
				{
					$status='1';				
				}		
				$updateData = array(
				'status' => $status,
				);
				$where = array('game_id'=>$game_id);
				$this->Frontcmodel->update_where($this->tb44,$updateData,$where);
				$data_json['msg']='Game Status Successfully Changed.';
				$data_json['status']=true;
				
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiGaliDessawarMarketStatusGame()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$game_id=$input_data->game_id;
				$market_status=$input_data->market_status;
						
				if($market_status=='1')
				{
					$market_status='0';				
				}
				else
				{
					$market_status='1';				
				}
						
				$updateData = array(
				'market_status' => $market_status,
				);
				$where = array('game_id'=>$game_id);
				$this->Frontcmodel->update_where($this->tb44,$updateData,$where);
				$data_json['msg']='Game Status Successfully Changed.';
				$data_json['status']=true;
				
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiGaliDessawarNameUpdate()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$game_id=$input_data->game_id;
				$game_name=$input_data->game_name;
				$game_name_hindi=$input_data->game_name_hindi;
				$open_time=$input_data->open_time;
						
					
				$updateData = array(
				'game_name' => $game_name,
				'game_name_hindi' => $game_name_hindi,
				'open_time' => date('h:i A', strtotime($open_time)),
			
			'open_time_sort' => date('H:i:s', strtotime($open_time)),
				);
				$where = array('game_id'=>$game_id);
				$this->Frontcmodel->update_where($this->tb44,$updateData,$where);
				$data_json['msg']='Game Name Successfully Updated.';
				$data_json['status']=true;
				
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiGaliDessawarGameNameAdd()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$game_name=$input_data->game_name;
				$game_name_hindi=$input_data->game_name_hindi;
				$open_time=$input_data->open_time;
							
				$updateData = array(
				'game_name' => $game_name,
				'game_name_hindi' => $game_name_hindi,
				'open_time' => date('h:i A', strtotime($open_time)),
				'open_time_sort' => date('H:i:s', strtotime($open_time)),
				);
				$this->Frontbmodel->insertData($this->tb44,$updateData);
				$data_json['msg']='Game Name Successfully Added.';
				$data_json['status']=true;
				
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiGetGaliDessawarGameListDropdown()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$where_array=array('status'=>1);
				$select="game_id,game_name";
				$game_array=$this->Frontamodel->get_data_select($this->tb44,$where_array,$select);
				
				$data_json['game_array']=$game_array;
				$data_json['msg']='Success';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiGetGaliDessawarUserBidHistory()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$bid_date=$input_data->bid_date;
				$game_name=$input_data->game_id;
				$game_type=$input_data->game_type;
				$page=$input_data->page;
				
				$bid_date = date('Y-m-d',strtotime($bid_date));
		
				if($game_name == 'all' && $game_type == 'all'){
					$where = array('bid_date' => $bid_date);
				}else if($game_name == 'all' && $game_type != 'all'){
					$where = array('bid_date' => $bid_date,'pana' => $game_type);
				}else if($game_name != 'all' && $game_type == 'all'){
					$where = array('bid_date' => $bid_date,'game_id' => $game_name);
				}else if($game_name != 'all' && $game_type != 'all'){
					$where = array('bid_date' => $bid_date,'game_id' => $game_name,'pana' => $game_type);
				}
				
				$start = 0; 
				$limit = 20; 
				 
				 $start = ($page - 1) * $limit;
				
				$joins = array(
							array(
								'table' => $this->tb3,
								'condition' => $this->tb3.'.user_id = '.$this->tb46.'.user_id',
								'jointype' => 'LEFT'
							)
						);
				$columns="user_name,bid_id,".$this->tb3.".unique_token,game_name,pana,session,digits,closedigits,points,bid_tx_id";
				$by = 'bid_id';
				
				$getBidHistory = $this->Frontamodel->get_joins_where_desc_scroll($this->tb46,$columns, $joins,$where,$by,$start,$limit);
				$data_json['getBidHistory']=$getBidHistory;
				$data_json['msg']='Success';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiSaveGaliDessawarResultData()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$open_number=$input_data->open_number;
				$game_id=$input_data->game_id;
				$result_dec_date=$input_data->result_dec_date;
				
				
				$insert_data = array(
						'open_number'=>$open_number,
						'game_id'=>$game_id,
						'result_date'=>$result_dec_date,
						);

				
				$where=array('game_id'=>$game_id,'result_date'=>$result_dec_date);	
				$result = $this->Frontamodel->get_data($this->tb45,$where);		$where=array('game_id'=>$game_id,'open_decleare_status'=>1,'result_date'=>$result_dec_date);			
				$game_dec_result = $this->Frontamodel->get_data($this->tb36,$where);		
				if(count($game_dec_result)>0)
				{						
					$data_json['status'] = false; 			
					$data_json['msg'] = "Game result already Declared";			
					echo json_encode($data_json); 
					die;	
				}
				
				if(count($result)<1)
				{
					$this->Frontbmodel->insertData($this->tb45,$insert_data);
					$data_json['status'] = true; 
					$data_json['msg'] = "Successfully inserted.";

				}
				else

				{
					$where=array('game_id'=>$game_id,'result_date'=>$result_dec_date);	
					$this->Frontcmodel->update_where($this->tb45,$insert_data,$where);
					
					$data_json['status'] = true; 
					$data_json['msg'] = "Successfully updated.";

				}
				
				$data_json['open_result']=$open_number;
								
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiGaliDessawarDeclareResult()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$game_id=$input_data->game_id;
				$result_dec_date=$input_data->result_dec_date;
				
				
				$where=array('game_id'=>$game_id,'open_number!='=>"",'result_date'=>$result_dec_date);	
			$result = $this->Frontamodel->get_data($this->tb45,$where);
			
			
			
			if(count($result)<1)
			{

				$data_json['status'] = true; 
				$data_json['msg'] = "Please save game result first";

			}

			else
			{						
				$where=array('game_id'=>$game_id,'open_decleare_status'=>1,'result_date'=>$result_dec_date);			
				$game_dec_result = $this->Frontamodel->get_data($this->tb36,$where);			
				if(count($game_dec_result)>0)
				{								
					$data_json['status'] = true; 				
					$data_json['msg'] ="Game result already Declared";				
					echo json_encode($data_json);
					die;			
				}
				foreach($result as $rs)
				{
					$open_number=$rs->open_number;
				}
			
			
			$where=array('game_id'=>$game_id);	
			$game_name_result = $this->Frontamodel->get_data($this->tb44,$where);
			foreach($game_name_result as $rs)
			{
					$game_not_name=$rs->game_name;
			}
			
			$win_number_not=$open_number[0]+$open_number[1];
			if($win_number_not>9)
				$win_number_not=$win_number_not%10;
			
			
			$game_rates=$this->Frontamodel->getData($this->tb43);
			foreach($game_rates as $rs)
			{
				$single_digit_val_2=$rs->single_digit_val_2;
				$single_pana_val_2=$rs->single_pana_val_2;
				$double_pana_val_2=$rs->double_pana_val_2;
			}
			
			$where=array($this->tb46.'.game_id'=>$game_id,'pay_status'=>0,'bid_date'=>$result_dec_date,'session'=>'Open');	
			
				$joins = array(

					array(

						'table' => $this->tb44,
						'condition' => $this->tb44.'.game_id = '.$this->tb46.'.game_id',
						'jointype' => 'LEFT'
						)

				);
				
			$columns=$this->tb44.".game_name,pana,user_id,session,digits,closedigits,points,bid_id,bid_tx_id,pay_status";
			$by = 'bid_id';

			$result= $this->Frontamodel->get_joins_where_desc($this->tb46,$columns,$joins,$where,$by);
					
			$open_result_token=$this->volanlib->uniqRandom(15);
			foreach($result as $rs)
			{
				$game_not_name=$rs->game_name;
					
				if($rs->pana=='Left Digit')
				{
					$win_number=$open_number[0];
										
					if($win_number==$rs->digits)
					{
						$win_amt=($single_digit_val_2/10)*$rs->points;
						
						$msg=$rs->game_name.' in '.$rs->pana.' '.' for bid amount- '.$rs->points.' Won';
						$this->updateUserWallet($rs->user_id,$win_amt,$msg,$open_result_token,$rs->bid_tx_id);
						
						$where=array('bid_id'=>$rs->bid_id);
						$up_data=array('pay_status'=>1,'open_result_token'=>$open_result_token);
						$this->Frontcmodel->update_where($this->tb46,$up_data,$where);
						$insert_data = array(
						'user_id' => $rs->user_id,
						'bid_tx_id' => $rs->bid_tx_id,
						'open_result_token'=>$open_result_token,
						'msg' => "Congratulations ,You Won in ".$rs->game_name." for Bid Number- ".$rs->bid_tx_id,
						'insert_date' => $this->insert_date
						);
						$this->Frontbmodel->insertData($this->tb22,$insert_data);

												
						
					}
				}
				else if($rs->pana=='Right Digit')
				{
					$win_number=$open_number[1];
					if($win_number==$rs->digits)
					{
						$win_amt=($single_pana_val_2/10)*$rs->points;
						
						//$msg='Amount won in '.$rs->game_name.' '.$rs->pana.' for Bid Number- '.$rs->bid_tx_id;
						$msg=$rs->game_name.' in '.$rs->pana.' '.' for bid amount- '.$rs->points.' Won';
						$this->updateUserWallet($rs->user_id,$win_amt,$msg,$open_result_token,$rs->bid_tx_id);
						
						$where=array('bid_id'=>$rs->bid_id);
						$up_data=array('pay_status'=>1,'open_result_token'=>$open_result_token);
						
						$this->Frontcmodel->update_where($this->tb46,$up_data,$where);
						
						$insert_data = array(
						'user_id' => $rs->user_id,
						'bid_tx_id' => $rs->bid_tx_id,
						'open_result_token'=>$open_result_token,
						'msg' => "Congratulations ,You Won in ".$rs->game_name." for Bid Number- ".$rs->bid_tx_id,
						'insert_date' => $this->insert_date
						);
						$this->Frontbmodel->insertData($this->tb22,$insert_data);
					}
				}
				else if($rs->pana=='Jodi Digit')
				{
					if($open_number==$rs->digits)
					{
						$win_amt=($double_pana_val_2/10)*$rs->points;
											
						$msg=$rs->game_name.' in '.$rs->pana.' '.' for bid amount- '.$rs->points.' Won';
						
						$this->updateUserWallet($rs->user_id,$win_amt,$msg,$open_result_token,$rs->bid_tx_id);
						
						$where=array('bid_id'=>$rs->bid_id);
						$up_data=array('pay_status'=>1,'open_result_token'=>$open_result_token);
						$this->Frontcmodel->update_where($this->tb46,$up_data,$where);						
						$insert_data = array(
						'user_id' => $rs->user_id,
						'bid_tx_id' => $rs->bid_tx_id,
						'open_result_token'=>$open_result_token,
						'msg' => "Congratulations ,You Won in ".$rs->game_name." for Bid Number- ".$rs->bid_tx_id,
						'insert_date' => $this->insert_date
						);
						
						$this->Frontbmodel->insertData($this->tb22,$insert_data);
					}
				}
				
			}
			
			$where=array('game_id'=>$game_id,'open_number!='=>"",'result_date'=>$result_dec_date);	
			$up_data=array('open_decleare_status'=>1,'open_decleare_date'=>$this->insert_date,'open_result_token'=>$open_result_token);
			
			$this->Frontcmodel->update_where($this->tb45,$up_data,$where);
			
			$data_json['status'] = true; 
			$data_json['open_declare_status'] = 1; 
			$data_json['open_declare_date'] = $this->insert_date; 
			$data_json['msg'] = "Successfully done.";
								
			}
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiGaliDessawarSellReport()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$start_date=$input_data->start_date;
				$game_name=$input_data->game_id;
				$game_type=$input_data->game_type;
				
				$start_date=date('Y-m-d',strtotime($start_date));
				
				$session='Open';	
				if($game_type == "all")
				{
					$order_by = "points";
					$group_by='numbers';
					$game_type='Left Digit';
					$joins = array(
						array(
								'table' => $this->tb46,
								'condition' => $this->tb46.'.digits = '.$this->tb26.'.single_digit && '.$this->tb46.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id="'.$game_name.'" && pana="'.$game_type.'" ',
								'jointype' => 'LEFT'
							)
						);
						
					$select='id,single_digit as numbers,IFNULL(sum(points),0) as total_points';
					$left_digit_result=$this->Frontamodel->get_joins_group_by($this->tb26,$select,$joins,$order_by,$group_by);
					
					
					$game_type='Right Digit';
					$joins2 = 
					 array(
						array(

								'table' => $this->tb46,
								'condition' => $this->tb46.'.digits = '.$this->tb26.'.single_digit && '.$this->tb46.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id="'.$game_name.'" && pana="'.$game_type.'" ',
								'jointype' => 'LEFT'
							)
						);
					$select2='id,single_digit as numbers,IFNULL(sum(points),0) as total_points';
					$right_digit_result=$this->Frontamodel->get_joins_group_by($this->tb26,$select2,$joins2,$order_by,$group_by);
					
					
					$joins3 = 
					 array(
							array(
								'table' => $this->tb46,
								'condition' => $this->tb46.'.digits = '.$this->tb27.'.jodi_digit && '.$this->tb46.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id="'.$game_name.'"',
								'jointype' => 'LEFT'
							)
						);
					$select3='id,jodi_digit as numbers,IFNULL(sum(points),0) as total_points';
					$jodi_result=$this->Frontamodel->get_joins_group_by($this->tb27,$select3,$joins3,$order_by,$group_by);
					
					
					$all_result[]['left_digit'] = $left_digit_result;
					$all_result[]['right_digit'] = $right_digit_result;
					$all_result[]['jodi_result'] = $jodi_result;
					
					$data_json['result']=$all_result;		    
					$data_json['msg']='Success.';
					$data_json['status']=true;			
				}
				else 
				{
					if($game_type=="Left Digit")
					{
					$order_by = "total_points";
					$where=array("bid_date" => $start_date,"session" => $session,"game_id" => $game_name, "pana" => $game_type);
					$joins = 
					 array(
					array(

							'table' => $this->tb46,
							'condition' => $this->tb46.'.digits = '.$this->tb26.'.single_digit && '.$this->tb46.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id='.$game_name.' && pana="'.$game_type.'" ',
							'jointype' => 'LEFT'
						)
					);
						$group_by='numbers';
					$select='id,single_digit as numbers,IFNULL(sum(points),0) as total_points';
					$all_result[]['left_digit']=$this->Frontamodel->get_joins_group_by($this->tb26,$select,$joins,$order_by,$group_by);
					}
					else if($game_type=="Right Digit")
					{
						$order_by = "total_points";
						$where=array("bid_date" => $start_date,"session" => $session,"game_id" => $game_name, "pana" => $game_type);
						$joins2 = 
						 array(
						array(

								'table' => $this->tb46,
								'condition' => $this->tb46.'.digits = '.$this->tb26.'.single_digit && '.$this->tb46.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id='.$game_name.' && pana="'.$game_type.'" ',
								'jointype' => 'LEFT'
							)
							);
							$group_by='numbers';
						$select2='id,single_digit as numbers,IFNULL(sum(points),0) as total_points';
						$all_result[]['right_digit']=$this->Frontamodel->get_joins_group_by($this->tb26,$select2,$joins2,$order_by,$group_by);
					}
					else if($game_type=="Jodi Digit")
					{
						$order_by = "total_points";
						$joins3 = 
						 array(
							array(

								'table' => $this->tb46,
								'condition' => $this->tb46.'.digits = '.$this->tb27.'.jodi_digit && '.$this->tb46.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id='.$game_name.' && pana="'.$game_type.'" ',
								'jointype' => 'LEFT'
							)
							);
							$group_by='numbers';
							$select3='id,jodi_digit as numbers,IFNULL(sum(points),0) as total_points';
							$all_result[]['jodi_result']=$this->Frontamodel->get_joins_group_by($this->tb27,$select3,$joins3,$order_by,$group_by);
					}
					
					$data_json['result']=$all_result;		    
					$data_json['msg']='Success.';
					$data_json['status']=true;			
				}
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiGetGaliDessawarWinningPrediction()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$game_id=$input_data->game_id;
				$open_number=$input_data->open_number;
				$result_date=$input_data->result_date;
				
				
				$game_rates=$this->Frontamodel->getData($this->tb43);
				foreach($game_rates as $rs)
				{
					$single_digit_val_2=$rs->single_digit_val_2;
					$single_pana_val_2=$rs->single_pana_val_2;
					$double_pana_val_2=$rs->double_pana_val_2;

				}
					
					$where=array($this->tb46.'.game_id'=>$game_id,'pay_status'=>0,'bid_date'=>$result_date,'session'=>'Open');	
						$joins = array(

							array(

								'table' => $this->tb44,
						'condition' => $this->tb44.'.game_id = '.$this->tb46.'.game_id',
								'jointype' => 'LEFT'
								),
								array(

								'table' => $this->tb3,
								'condition' => $this->tb3.'.user_id = '.$this->tb46.'.user_id',
								'jointype' => 'LEFT'
								)

						);
						
				$columns=$this->tb44.".game_name,".$this->tb3.".unique_token,pana,session,digits,closedigits,points,bid_id,bid_tx_id,pay_status,user_name";
				$by = 'bid_id';
				
				$result= $this->Frontamodel->get_joins_where_desc($this->tb46,$columns,$joins,$where,$by);
				
				$data_array=array();
					$i=0;
					
					$win_amt_sum=0;
					$points_amt_sum=0;
					foreach($result as $rs)
					{
						$game_not_name=$rs->game_name;
						$win_number_not=$open_number[0]+$open_number[1];
							
						if($win_number_not>9)
						$win_number_not=$win_number_not%10;
					$win_amt=0;
					$points=0;
						
						if($rs->pana=='Left Digit')
						{
							$win_number=$open_number[0];
							
							if($win_number>9)
							$win_number=$win_number%10;
							if($win_number==$rs->digits)
							{
								$win_amt=($single_digit_val_2/10)*$rs->points;
								
								$points=$rs->points;
								
								$data_array[$i]['points']=$rs->points;
								$data_array[$i]['unique_token']=$rs->unique_token;
								$data_array[$i]['user_name']=$rs->user_name;
								$data_array[$i]['pana']=$rs->pana;
								$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
								$data_array[$i]['win_amt']=$win_amt;
								
							}
						}
						else if($rs->pana=='Right Digit')
						{
							$win_number=$open_number[1];
							
							if($win_number>9)
							$win_number=$win_number%10;
							if($win_number==$rs->digits)
							{
								$win_amt=($single_digit_val_2/10)*$rs->points;
								
								$points=$rs->points;
								
								$data_array[$i]['points']=$rs->points;
								$data_array[$i]['unique_token']=$rs->unique_token;
								$data_array[$i]['user_name']=$rs->user_name;
								$data_array[$i]['pana']=$rs->pana;
								$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
								$data_array[$i]['win_amt']=$win_amt;
								
							}
						}
						else if($rs->pana=='Jodi Digit')
						{
							if($open_number==$rs->digits)
							{
								$win_amt=($double_pana_val_2/10)*$rs->points;
								
								$points=$rs->points;
								
								$data_array[$i]['points']=$rs->points;
								$data_array[$i]['unique_token']=$rs->unique_token;
								$data_array[$i]['user_name']=$rs->user_name;
								$data_array[$i]['pana']=$rs->pana;
								$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
								$data_array[$i]['win_amt']=$win_amt;
							}
						}
						$win_amt_sum=$win_amt+$win_amt_sum;
						$points_amt_sum=$points+$points_amt_sum;
						if($win_amt>0)
						$i++;
						
					}
								
					$data_json['winner_list'] = $data_array; 
					$data_json['win_amt_sum'] = $win_amt_sum; 
					$data_json['points_amt_sum'] = $points_amt_sum; 
					$data_json['status'] = true; 
					$data_json['msg'] = "Success"; 
								
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiGaliDessawarResultHistoryList()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$page=$input_data->page;
				$start = 0; 
				$limit = 20; 
				$where = array();
				
				 
				 $joins = array(
							array(
								'table' => $this->tb44.' b',
								'condition' => 'b.game_id = '.$this->tb45.'.game_id',
								'jointype' => 'LEFT'
							)
						);
				$columns="id,b.game_id,IFNULL(date_format(result_date,'%d %b %Y'),'') as result_date,result_date as result_dec_date,IFNULL(date_format(open_decleare_date,'%d %b %Y %r'),'') as open_decleare_date,b.game_name,open_number,open_decleare_status";
				$by = 'id';
				 
				 
				 $start = ($page - 1) * $limit;
				
				$GaliResultHistory = $this->Frontamodel->get_joins_where_desc_scroll($this->tb45,$columns, $joins,$where,$by,$start,$limit);
				$data_json['GaliResultHistory']=$GaliResultHistory;
				$data_json['msg']='Success';
				$data_json['status']=true;
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiGaliDessawarWinningReport()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$game_name=$input_data->game_id;
				$result_date=$input_data->result_date;
				$result_date = date('Y-m-d',strtotime($result_date));
				$page=$input_data->page;
				$start = 0; 
				$limit = 20; 
				$where=array();
				$joins = array(

								array(

									'table' => $this->tb14,

									'condition' => $this->tb14.'.open_result_token = '.$this->tb45.'.open_result_token',

									'jointype' => 'LEFT'

								),
								array(

										'table' => $this->tb46,

										'condition' => $this->tb46.'.bid_tx_id = '.$this->tb14.'.bid_tx_id',

										'jointype' => 'LEFT'

									),
									array(

									'table' => $this->tb3,

									'condition' => $this->tb3.'.user_id = '.$this->tb46.'.user_id',

									'jointype' => 'LEFT'
			
								),
								

						);
						
				$where = array('result_date' => $result_date,$this->tb46.'.game_id'=>$game_name);
				
				$start = ($page - 1) * $limit;

				$columns="user_name,unique_token,".$this->tb46.".game_name,".$this->tb46.".session,".$this->tb14.".amount,transaction_note,transaction_note,tx_request_number,".$this->tb14.'.insert_date,pana,digits,closedigits,points,bid_id,'.$this->tb46.'.bid_tx_id';

				$by = 'transaction_id';

				$getWinningReport= $this->Frontamodel->get_joins_where_desc_scroll($this->tb45,$columns, $joins,$where,$by,$start,$limit);
				$data_json['getWinningReport']=$getWinningReport;
				$data_json['msg']='Success';
				$data_json['status']=true;
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiDeleteGaliDessawarResultData()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$game_id=$input_data->game_id;
				$result_dec_date=$input_data->result_dec_date;
				
				$where=array('game_id'=>$game_id,'result_date'=>$result_dec_date);	
				$result = $this->Frontamodel->get_data($this->tb45,$where);
				
				if(count($result)<1)
				{
					$data_json['status'] = false; 
					$data_json['msg'] = "Game result is not decleare yet";

				}
				else
				{
					foreach($result as $rs)
					{
							$open_result_token=$rs->open_result_token;
					}
			
					$where=array('open_result_token'=>$open_result_token);
					$up_data=array('pay_status'=>0);
					$this->Frontcmodel->update_where($this->tb46,$up_data,$where);
					
					$this->deductUserWallet($open_result_token);
					
					$where_array=array('open_result_token'=>$open_result_token);
					
					$this->Frontdmodel->delete($this->tb45,$where_array);
					$this->Frontdmodel->delete($this->tb22,$where_array);
					
			
					$data_json['msg'] = "Result Successfully done.";
					$data_json['status']=true;
			
				}
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiNoticeAdd()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$notice_title=$input_data->notice_title;
				$description=$input_data->description;
				$notice_date=$input_data->notice_date;
						
				$insert_data = array(
				'notice_title' => ucwords($notice_title),
				'notice_msg' => $description,
				'notice_date' => date("Y-m-d",strtotime($notice_date)),
				'insert_date'=>$this->insert_date
				);
				$this->Frontbmodel->insertData($this->tb12,$insert_data);
				
				$data_json['msg']='Notice Successfully Added.';
				$data_json['status']=true;
				
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiNoticeUpdate()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$notice_id=$input_data->notice_id;
				$notice_title=$input_data->notice_title;
				$description=$input_data->description;
				$notice_date=$input_data->notice_date;
						
					
				$updateData = array(
					'notice_title' => ucwords($notice_title),
					'notice_msg' => $description,
					'notice_date' => date("Y-m-d",strtotime($notice_date)),
					'insert_date'=>$this->insert_date
				);
				$where = array('notice_id'=>$notice_id);
				$this->Frontcmodel->update_where($this->tb12,$updateData,$where);
				$data_json['msg']='Notice Successfully Updated.';
				$data_json['status']=true;
				
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiActiveInactiveNotice()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$notice_id=$input_data->notice_id;
				$status=$input_data->status;
						
				if($status=='1')
				{
					$status='0';				
				}
				else
				{
					$status='1';				
				}		
				$updateData = array(
				'status' => $status,
				);
				$where = array('notice_id'=>$notice_id);
				$this->Frontcmodel->update_where($this->tb12,$updateData,$where);
				$data_json['msg']='Notice Successfully Changed.';
				$data_json['status']=true;
				
				
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiNoticeList()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$page=$input_data->page;
				$start = 0; 
				$limit = 20; 
				$where = array();
				$total=count($this->Frontamodel->get_data($this->tb12,$where));
				
				 $page_limit = $total/$limit; 
				 
				 $start = ($page - 1) * $limit;
				
				$columns="notice_title,notice_msg,status,date_format(notice_date,'%d %b %Y') as notice_date,notice_id";
				$by = 'notice_id';
				
				$getNoticeList = $this->Frontamodel->get_data_latest_where_asc_limit($this->tb12,$where, $by,$columns,$start,$limit);
				$data_json['getNoticeList']=$getNoticeList;
				$data_json['msg']='Success';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiUpdateBid()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$digit=$input_data->digit;
				$bid_id=$input_data->bid_id;
				$pana=$input_data->pana;
				$closedigits=$input_data->closedigits;
						
				if($pana=='Single Digit' or $pana=='Single Pana' or $pana=='Double Pana' or $pana=='Triple Pana')		
				{
					$userdata=array(
						'digits'=>$digit,
					);		
				}				
				if($pana=='Jodi Digit')		
				{			
					$userdata=array('digits'=>$digit);			
				}				
				if($pana=='Full Sangam' or $pana=='Half Sangam')		
				{			
					$userdata=array('digits'=>$digit,'closedigits'=>$closedigits);
				}
		
				$where=array('bid_id'=>$bid_id);
				$this->Frontcmodel->update_where($this->tb18,$userdata,$where);
				$data_json['msg']='Bid updated successfully.';
				$data_json['msg']='Success';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	public function apiUpdateGaliDessawarBid()
	{
		$json = file_get_contents('php://input');
		$input_data = json_decode($json);
		$app_key=isset($input_data->app_key)?trim($input_data->app_key):'';$env_type=isset($input_data->env_type)?trim($input_data->env_type):'';
		
		if($this->checkRequestAuth($app_key,$env_type)!=0)
		{
			$login_token=$input_data->login_token;
			$where_array=array('login_token' => $login_token);
			$result=$this->Frontamodel->get_data($this->tb2,$where_array);
			if(count($result)>0)
			{
				$digits=$input_data->digits;
				$bid_id=$input_data->bid_id;		
				$userdata=array(
						'digits'=>$digits,
					);	
		
				$where=array('bid_id'=>$bid_id);
				$this->Frontcmodel->update_where($this->tb46,$userdata,$where);
				$data_json['msg']='Bid updated successfully.';
				$data_json['msg']='Success';
				$data_json['status']=true;
			}
			else
			{
				$data_json['msg']='UnAuthorized Token request';
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
	
	
	public function apiChat()
	{
		$path = 'uploads/chat/voice-note/';
		$voice_note='';		
		if($_FILES['voice_note']['name']!="")
		{	
			$voice_note=$this->volanimage->upload_image($path,$_FILES['voice_note']);
		}
		
		$path = 'uploads/chat/attachment/';
		$attachment='';		
		if($_FILES['attachment']['name']!="")
		{	
			$attachment=$this->volanimage->upload_image($path,$_FILES['attachment']);
		}
		
		$text_message = trim($this->input->post('text_message'));
		
		$insert_data = array(
		'admin_id' => 1,
		'user_id' => 1,
		'voice_note' => $voice_note,
		'attachment' => $attachment,
		'text_message' => $text_message,
		'create_date'=>$this->insert_date
		);
		$this->Frontbmodel->insertData($this->tb53,$insert_data);
		$data_json['path']=$path.$attachment;
		$data_json['msg']='Success';
		$data_json['status']=true; 
		echo json_encode($data_json);
	}
	public function apiInsertChatData()
	{
		
		$path = 'uploads/chat/attachment/';
		$attachment='';		
		if($_FILES['attachment']['name']!="")
		{	
			$attachment=$this->volanimage->upload_image($path,$_FILES['attachment']);
		}
		$data_json['path']=$path.$attachment;
		$data_json['msg']='Success';
		$data_json['status']=true; 
		echo json_encode($data_json,JSON_FORCE_OBJECT);
	}
	
	public function apiGetChat()
	{
		$path_voice_note = base_url().'uploads/chat/voice-note/';
		$path_attachment = base_url().'uploads/chat/attachment/';
		$select="id, text_message, (CASE WHEN voice_note = '' OR voice_note IS NULL THEN '' ELSE CONCAT('".$path_voice_note."', voice_note) END) as voice_note, (CASE WHEN attachment = '' OR attachment IS NULL THEN '' ELSE CONCAT('".$path_attachment."', attachment) END) as attachment, create_date";
		$where = array();
		$result=$this->Frontamodel->get_data_select($this->tb53,$where,$select);
		$data_json['result']=$result;
		$data_json['status']=true; 
		echo json_encode($data_json);
	}	
	
}