<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Adminsettingcontroller extends MY_AdminController {

    public function __construct() {
        parent::__construct();
		if ($this->session->userdata('adminlogin') == 0)
		{
			$allowed = array('login');
			if ( ! in_array($this->router->fetch_method(), $allowed))
			{
				$myurl = base_url() .admin;
				redirect($myurl);
			}
        }  
    }
		
    public function mainSettings()
	{
		if($this->session->userdata('adminlogin') == 1 && $this->session->userdata('admin_type') == 1)
		{
			$this->data['title'] = "Settings";
			$this->data['banner_title'] = "Settings";
			$this->data['active_menu'] = 'admin_setting';
			$this->data['master_menu'] = 'settings';
			$admin_setting = $this->Adminamodel->getData($this->tb2);
			if(count($admin_setting)>0)
			{
				foreach($admin_setting as $rs)
				{
					$this->data['mobile'] = $rs->phone;
				}
			}
			
			$admin_setting = $this->Adminamodel->getData($this->tb4);
			if(count($admin_setting)>0)
			{
				foreach($admin_setting as $rs)
				{
					$this->data['id']=$rs->id;
					$this->data['ac_holder_name']=$rs->ac_holder_name;
					$this->data['account_number']=$rs->account_number;
					$this->data['ifsc_code']=$rs->ifsc_code;
					$this->data['upi_payment_id']=$rs->upi_payment_id;
					$this->data['google_upi_payment_id']=$rs->google_upi_payment_id;
					$this->data['phonepay_upi_payment_id']=$rs->phonepay_upi_payment_id;
				}
			}
			
			$admin_setting = $this->Adminamodel->getData($this->tb52);
			if(count($admin_setting)>0)
			{
				foreach($admin_setting as $rs)
				{
					$this->data['id']=$rs->id;
					$this->data['referral_first_bonus']=$rs->referral_first_bonus;
					$this->data['referral_first_bonus_max']=$rs->referral_first_bonus_max;
					$this->data['referral_second_bonus']=$rs->referral_second_bonus;
					$this->data['referral_second_bonus_max']=$rs->referral_second_bonus_max;
				}
			}
			
			$admin_setting = $this->Adminamodel->getData($this->tb25);
			if(count($admin_setting)>0)
			{
				foreach($admin_setting as $rs)
				{
					$this->data['id']=$rs->id;
					$this->data['app_link']=$rs->app_link;
					$this->data['content']=$rs->content;
					$this->data['share_referral_content']=$rs->share_referral_content;
				}
			}
			
			$admin_fix_values = $this->Adminamodel->getData($this->tb15);
			if(count($admin_fix_values)>0)
			{
				foreach($admin_fix_values as $rs)
				{
					$this->data['value_id']=$rs->id;
					$this->data['min_deposite']=$rs->min_deposite;
					$this->data['max_deposite']=$rs->max_deposite;
					$this->data['min_withdrawal']=$rs->min_withdrawal;
					$this->data['max_withdrawal']=$rs->max_withdrawal;
					$this->data['min_transfer']=$rs->min_transfer;
					$this->data['max_transfer']=$rs->max_transfer;
					$this->data['min_bid_amt']=$rs->min_bid_amount;
					$this->data['max_bid_amt']=$rs->max_bid_amount;
					$this->data['welcome_bonus']=$rs->welcome_bonus;
					$this->data['withdraw_open_time']=date('H:i', strtotime($rs->withdraw_open_time));
					$this->data['withdraw_close_time']=date('H:i', strtotime($rs->withdraw_close_time));
					$this->data['global_batting_status']=$rs->global_batting_status;
					$this->data['app_maintainence_msg']=$rs->app_maintainence_msg;
					$this->data['maintainence_msg_status']=$rs->maintainence_msg_status;
				}
			}
			
			$this->middle = 'admin/f'; 
			$this->layout();
		}
		else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
    }
	
	public function addAdminBankDetail()
	{
		$id = trim($this->input->post('account_id'));
		$ac_name = trim($this->input->post('ac_name'));
		$ac_number = trim($this->input->post('ac_number'));
		$ifsc_code = trim($this->input->post('ifsc_code'));
		/* $upi_payment_id = trim($this->input->post('upi_payment_id')); */
		
		$adminData = array(
			'ac_holder_name' => ucwords($ac_name),
			'account_number' => $ac_number,
			/* 'upi_payment_id' => $upi_payment_id, */
			'ifsc_code' => $ifsc_code,
			'insert_date'=>$this->insert_date
			);
		
		if($id == ''){
			$this->Adminbmodel->insertData($adminData,$this->tb4);
			$data['status'] = 'success';
			$data['msg'] = $this->volanlib->success('Bank Details Successfully Added.');
		}else{
			$where = array('id' => $id);
			$this->Admincmodel->update_where($this->tb4,$adminData,$where);
			$data['status'] = 'update';
			$data['msg'] = $this->volanlib->success('Bank Details Successfully Updated.');
		}
		echo json_encode($data);
	}
	
	public function addAdminUpiDetail()
	{
		$select = 'phone';
		$where=array('admin_type'=>1);
		$result = $this->Adminamodel->get_data($this->tb2,$where);
		foreach($result as $rs)
		{
			$mobile = $rs->phone;
		}
		$otp=$this->getOtp();
		$message=$otp.' use this OTP to verify your UPI-Id for updataion.Please do not share it to anyone';
		$message=$otp;
		$message=$this->replaceSpace($message);
		// $this->sendMessage($mobile,$message);
		$this->sendMessage($mobile,$otp);
		
		$this->session->set_userdata('upi_otp', $otp);
		$mobile=substr_replace($mobile, 'XXXXXX', 0, 6);
		$data['status'] = 'success';
		$data['mobile']=$mobile;
		$data['msg'] = $this->volanlib->success('OTP Successfully sent to your registered mobile number enter OTP to verify it.');
		echo json_encode($data);
	}
	
	public function addAdminUpiUpdateOtpCheck()
	{
		$id = trim($this->input->post('account_id'));
		$upi_id = trim($this->input->post('upi_id'));
		$google_upi_payment_id = trim($this->input->post('up_google_upi_payment_id'));
		$phonepay_upi_payment_id = trim($this->input->post('up_phonepay_upi_payment_id'));
		$otp_code = trim($this->input->post('otp_code'));
		
		$code = $this->session->userdata('upi_otp');
		
		if($otp_code == $code){
			
			
			$where = array('id' => $id);
			$result = $this->Adminamodel->get_data($this->tb4,$where);
			
			$adminData = array(
					'upi_payment_id' => $upi_id,
					'phonepay_upi_payment_id' => $phonepay_upi_payment_id,
					'google_upi_payment_id' => $google_upi_payment_id,
				);
			if(count($result)<1)
			{
				$this->Adminbmodel->insertData($adminData,$this->tb4);
			}
			else
			{
				$this->Admincmodel->update_where($this->tb4,$adminData,$where);
			}
			
			$data = array(
					'upi_id'=>$upi_id,
					'update_date'=>$this->insert_date
				);
			$this->Adminbmodel->insertData($data,$this->tb47);
			$data['status'] = 'success';
			$data['msg'] = $this->volanlib->success('UPI Id Successfully Updated...');
		}else {
			$data['status'] = 'update';
			$data['msg'] = $this->volanlib->error('You entered wrong OTP.Please check your phone and enter again..');
		}
		echo json_encode($data);
	}
	
	public function addAppLink()
	{
		$id = trim($this->input->post('id'));
		$app_link = trim($this->input->post('app_link'));
		$content = trim($this->input->post('content'));
		$share_referral_content = trim($this->input->post('share_referral_content'));
		
		$adminData = array(
			'app_link' => $app_link,
			'content' => $content,
			'share_referral_content' => $share_referral_content
			);
		
		if($id == ''){
			$this->Adminbmodel->insertData($adminData,$this->tb25);
			$data['status'] = 'success';
			$data['msg'] = $this->volanlib->success('App Link Successfully Added.');
		}else{
			$where = array('id' => $id);
			$this->Admincmodel->update_where($this->tb25,$adminData,$where);
			$data['status'] = 'update';
			$data['msg'] = $this->volanlib->success('App Link Successfully Updated.');
		}
		echo json_encode($data);
	}
	
	public function addAdminFixValues()
	{
		$value_id = trim($this->input->post('value_id'));
		$min_deposite = trim($this->input->post('min_deposite'));
		$max_deposite = trim($this->input->post('max_deposite'));
		$min_withdrawal = trim($this->input->post('min_withdrawal'));
		$max_withdrawal = trim($this->input->post('max_withdrawal'));
		$min_transfer = trim($this->input->post('min_transfer'));
		$max_transfer = trim($this->input->post('max_transfer'));
		$min_bid_amt = trim($this->input->post('min_bid_amt'));
		$max_bid_amt = trim($this->input->post('max_bid_amt'));
		$welcome_bonus = trim($this->input->post('welcome_bonus'));
		
		$withdraw_open_time = trim($this->input->post('withdraw_open_time'));
		$withdraw_close_time = trim($this->input->post('withdraw_close_time'));
		$global_batting_status = trim($this->input->post('global_batting_status'));
		
		if(isset($global_batting_status) && $global_batting_status!='')
		{
			$global_batting_status=1;
		}
		else
		{
			$global_batting_status=0;
		}
		
		$adminData = array(
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
		
		if($value_id == ''){
			$this->Adminbmodel->insertData($adminData,$this->tb15);
			$data['status'] = 'success';
			$data['msg'] = $this->volanlib->success('Values Successfully Added.');
		}else{
			$where = array('id' => $value_id);
			$this->Admincmodel->update_where($this->tb15,$adminData,$where);
			$data['status'] = 'update';
			$data['msg'] = $this->volanlib->success('Values Successfully Updated.');
		}
		echo json_encode($data);
	}
	
	public function addAppMaintainence()
	{
		$value_id = trim($this->input->post('value_id'));
		$app_maintainence_msg = trim($this->input->post('app_maintainence_msg'));
		$maintainence_msg_status = trim($this->input->post('maintainence_msg_status'));
		
		if(isset($maintainence_msg_status) && $maintainence_msg_status!='')
		{
			$maintainence_msg_status=1;
		}
		else
		{
			$maintainence_msg_status=0;
		}
		
		$adminData = array(
			'app_maintainence_msg' => $app_maintainence_msg,
			'maintainence_msg_status' => $maintainence_msg_status,
			);
		
		if($value_id == ''){
			$this->Adminbmodel->insertData($adminData,$this->tb15);
			$data['status'] = 'success';
			$data['msg'] = $this->volanlib->success('App Maintainence Msg Successfully Added.');
		}else{
			$where = array('id' => $value_id);
			$this->Admincmodel->update_where($this->tb15,$adminData,$where);
			$data['status'] = 'update';
			$data['msg'] = $this->volanlib->success('App Maintainence Msg Successfully Updated.');
		}
		echo json_encode($data);
	}
	
	public function referralBonusSettingsUpdate()
	{
		$id = trim($this->input->post('id'));
		$referral_first_bonus = trim($this->input->post('referral_first_bonus'));
		$referral_first_bonus_max = trim($this->input->post('referral_first_bonus_max'));
		$referral_second_bonus = trim($this->input->post('referral_second_bonus'));
		$referral_second_bonus_max = trim($this->input->post('referral_second_bonus_max'));
		
		$adminData = array(
			'referral_first_bonus' => $referral_first_bonus,
			'referral_first_bonus_max' => $referral_first_bonus_max,
			'referral_second_bonus' => $referral_second_bonus,
			'referral_second_bonus_max' => $referral_second_bonus_max,
			'insert_date'=>$this->insert_date
			);
		
		if($id == ''){
			$this->Adminbmodel->insertData($adminData,$this->tb52);
			$data['status'] = 'success';
			$data['msg'] = $this->volanlib->success('Details Successfully Added.');
		}else{
			$where = array('id' => $id);
			$this->Admincmodel->update_where($this->tb52,$adminData,$where);
			$data['status'] = 'update';
			$data['msg'] = $this->volanlib->success('Details Successfully Updated.');
		}
		echo json_encode($data);
	}
	
	

}