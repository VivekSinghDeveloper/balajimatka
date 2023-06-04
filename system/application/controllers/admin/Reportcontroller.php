<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Reportcontroller extends MY_AdminController {
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

    public function bidWinningReport()
	{
		if($this->session->userdata('adminlogin') == 1 && $this->session->userdata('admin_type') == 1)
		{
			$this->data['title'] = "Bid Win Report";
			$this->data['banner_title'] = "Bid Winning Report";
			$this->data['active_menu'] = 'bid_winning_report';
			$this->data['master_menu'] = 'bid_winning_report';
			$where = array('status'=>1);
			$this->data['game_result']=$this->Adminamodel->get_data($this->tb16,$where);
			$this->middle = 'admin/report/a'; 
			$this->layout();
		}else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
    }
	
	public function getBidWinningReportDetails()
	{
		/* echo "<pre>";
		print_r($_POST);die;  */
		
		$result_date = trim($this->input->post('result_date'));
		$win_game_name = trim($this->input->post('win_game_name'));
		
		$where = array('bid_date'=>$result_date,'game_id'=>$win_game_name);
		$select = 'bid_id,points';
		$bid_details = $this->Adminamodel->get_data_select($this->tb18,$where,$select);
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
		
		$where = array('DATE('.$this->tb14.'.insert_date)'=>$result_date,'amount_status'=>8,'game_id'=>$win_game_name);
		$joins = array(
				array(
					'table'=>$this->tb18,
					'condition'=> $this->tb18.'.bid_tx_id = '.$this->tb14.'.bid_tx_id',
					'jointype' =>'LEFT'
				)
			);
		$columns = "amount,date_format(".$this->tb14.".insert_date,'%d %M %y %h:%i') as wining_date,game_name,pana,session";
		$win_details = $this->Adminamodel->get_joins_where($this->tb14,$columns,$joins,$where);
		
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
		$data['total_bid'] = $total_bid_amt;
		$data['total_win'] = $total_win_amt;
		$data['total_profit'] = $total_profit_amt;
		$data['total_loss'] = $total_loss_amt;
		$data['status'] = "success"; 
		echo json_encode($data);

	}
	
	 public function withdrawReport()
	{
		if($this->session->userdata('adminlogin') == 1)
		{
			$this->data['title'] = "Withdraw Report";
			$this->data['banner_title'] = "Withdraw Report";
			$this->data['active_menu'] = 'Withdraw_report';
			$this->data['master_menu'] = 'withdraw_report_report';
			
			$this->middle = 'admin/report/b'; 
			$this->layout();
		}else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
    }
	
	public function getWithdrawReportDetails()
	{
		$withdraw_date = trim($this->input->post('withdraw_date'));
		
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
		
		$columns = 'withdraw_request_id,user_name,mobile,request_amount,request_number,request_status,payment_receipt,date_format('.$this->tb11.'.insert_date,"%d %b %Y %r") as insert_date,'.$this->tb11.'.user_id,payment_method,tx_request_number,ac_number,ac_holder_name,paytm_number,google_pay_number,phone_pay_number';
		
		$withdrawData = $this->Adminamodel->get_joins_where($this->tb11,$columns,$joins,$where);
		/* echo "<pre>";print_r($withdrawData);die; */
		$list_data = '';
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
				
				$rs->mobile=$this->volanlib->decryptMob($rs->mobile);
				
				if($rs->request_status==0)
				{
					$display_status = '<badge class="badge badge-pill badge-soft-info font-size-12">Pending</badge>';
				}
				else if($rs->request_status==1)
				{
					$display_status = '<badge class="badge badge-pill badge-soft-danger font-size-12">Rejected</badge>';
				}else{
					$display_status = '<badge class="badge badge-pill badge-soft-success font-size-12">Accepted</badge>';
				}
				
				$view = '<a role="button" data-href="'.base_url().admin.'/view-withdraw-request/'.$rs->withdraw_request_id.'" class="mr-3 text-primary openViewWithdrawRequest" data-toggle="tooltip" data-placement="top" title="" data-original-title="View Details"><i class="mdi mdi-eye font-size-18"></i></a>';
				
				if($rs->request_status == 1 || $rs->request_status == 2) {
					$action='<button class="btn btn-primary btn-sm w-xs mr-1"  data-withdraw_request_id="'.$rs->withdraw_request_id.'" disabled>Approve</button><button class="btn btn-danger btn-sm w-xs" data-withdraw_request_id="'.$rs->withdraw_request_id.'" disabled >Reject</button>';
				}else {
					$action='<button class="btn btn-primary btn-sm w-xs mr-1" id="accept"  data-withdraw_request_id="'.$rs->withdraw_request_id.'" data-user_name="'.$rs->user_name.'" data-mobile="'.$rs->mobile.'" data-request_amount="'.$rs->request_amount.'" data-request_number="'.$rs->request_number.'">Approve</button><button class="btn btn-danger btn-sm w-xs" id="reject"  data-withdraw_request_id="'.$rs->withdraw_request_id.'">Reject</button>';
				}
				
				
				$list_data .= '<tr><td>'.$rs->user_name.' <a href='.base_url().admin.'/view-user/'.$rs->user_id.'><i class="bx bx-link-external"></i></a></td><td>'.$rs->mobile.'</td><td>'.$rs->request_amount.'</td><td>'.$method.'</td><td>'.$rs->tx_request_number.'</td><td>'.$rs->insert_date.'</td><td>'.$display_status.'</td><td>'.$view.'</td><td>'.$action.'</td></tr>';
			}
		}
		
		$where = array('amount_status'=>2,'DATE('.$this->tb14.'.insert_date)'=>$withdraw_date);
		
		$get_data = $this->Adminamodel->get_data($this->tb14,$where);
		$withdraw_amt = 0;
		if(count($get_data)>0){
			foreach($get_data as $rs){
				$withdraw_amt += $rs->amount;
			}
		}
		
		$where = array('request_status'=>2,'DATE('.$this->tb11.'.insert_date)'=>$withdraw_date);
		$get_withdraw = $this->Adminamodel->get_data($this->tb11,$where);
		$total_accept = 0;
		if(count($get_withdraw)>0){
			foreach($get_withdraw as $rs){
				$total_accept += $rs->request_amount;
			}
		}
		
		$where = array('request_status'=>1,'DATE('.$this->tb11.'.insert_date)'=>$withdraw_date);
		$get_reject_data = $this->Adminamodel->get_data($this->tb11,$where);
		$total_reject = 0;
		if(count($get_reject_data)>0){
			foreach($get_reject_data as $rs){
				$total_reject += $rs->request_amount;
			}
		}
		
		$data['total_accept'] = $total_accept;
		$data['total_reject'] = $total_reject;
		$data['withdraw_amt'] = $withdraw_amt;
		$data['list_data'] = $list_data;
		$data['status'] = "success"; 
		echo json_encode($data);
	}
	
	public function getBidReportList()
	{
		$result_date = $this->input->post('result_date');
		$game_id = trim($this->input->post('game_id'));
		
		$bid_date = date('Y-m-d',strtotime($result_date));
		
		$where = array('bid_date' => $bid_date,'game_id' => $game_id);
		$joins = array(
			array(
				'table' => $this->tb3,
				'condition' => $this->tb3.'.user_id = '.$this->tb18.'.user_id',
				'jointype' => 'LEFT'
			)
		);
		$columns="user_name,".$this->tb18.".user_id,game_name,bid_id,pana,session,digits,closedigits,points,bid_tx_id,pay_status";
		$by = 'bid_id';
		$data['getBidHistory']= $this->Adminamodel->get_joins_where_by($this->tb18,$columns,$joins,$by,$where);
		
		echo json_encode($data);
	}
	
	public function getWinningReportDetails()
	{
		$result_date = $this->input->post('result_date');
		$game_name = trim($this->input->post('game_id'));
		
		$bid_date = date('Y-m-d',strtotime($result_date));
		$where=array('game_id'=>$game_name,'result_date'=>$result_date);	
		$result = $this->Adminamodel->get_data($this->tb21,$where);
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
				
				$where = array('DATE('.$this->tb14.'.insert_date)' => $result_date,$this->tb18.'.game_id'=>$game_name,$this->tb14.'.open_result_token'=>$open_result_token);
				
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
				

				$columns="user_name,".$this->tb14.".user_id,".$this->tb18.".game_name,".$this->tb18.".session,".$this->tb14.".amount,transaction_note,transaction_note,tx_request_number,".$this->tb14.'.insert_date,pana,digits,closedigits,points,bid_id,'.$this->tb18.'.bid_tx_id';
				
				

				$by = 'transaction_id';

				$getOpenResultHistory= $this->Adminamodel->get_joins_where_by($this->tb14,$columns,$joins,$by,$where);
								
			}
				
			if($close_decleare_status==1)
			{
				
				$where = array('DATE('.$this->tb14.'.insert_date)' => $result_date,$this->tb18.'.game_id'=>$game_name,$this->tb14.'.close_result_token'=>$close_result_token);
				
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
				
				$columns="user_name,".$this->tb14.".user_id,".$this->tb18.".game_name,".$this->tb18.".session,".$this->tb14.".amount,transaction_note,transaction_note,tx_request_number,".$this->tb14.'.insert_date,pana,digits,closedigits,points,bid_id,'.$this->tb18.'.bid_tx_id';

				$by = 'transaction_id';

				$getCloseResultHistory= $this->Adminamodel->get_joins_where_by($this->tb14,$columns,$joins,$by,$where);
								
			}
			
		
		
		 ///echo "<pre>";print_r($getCloseResultHistory);die;
		$get_winning_data = array_merge($getOpenResultHistory,$getCloseResultHistory);
		$data['getResultHistory'] = $get_winning_data;
		echo json_encode($data); 
	}
}

