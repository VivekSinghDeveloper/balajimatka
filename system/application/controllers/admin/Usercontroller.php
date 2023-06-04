<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usercontroller extends MY_AdminController {

    public function __construct() {
        parent::__construct();
		 
    }
	
	public function userManagement()
	{
		if($this->session->userdata('adminlogin') == 1)
		{
			$this->data['title'] = "User Managment";
			$this->data['banner_title'] = "User Managment";
			$this->data['banner_title2'] = "User List";
			$this->data['active_menu'] = 'user_management';
			$this->data['userListTableFlag'] = 1;
			$this->middle = 'admin/d'; 
			$this->layout();
		}
		else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
    }
	
	public function userListGridData()
	{
		$columns = array( 
			0 => 'u_id',
			1 => 'user_name',
			2 => 'mobile',
			3 => 'email',
			4 => 'insert_date',
			5 => 'wallet_balance',
			6 => 'betting_status',
			7 => 'transfer_point_status',
			8 => 'status',
			9 => 'u_id'
		);
		
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		
		$sql = "SELECT user_id,user_name,mobile,email,wallet_balance,betting_status,transfer_point_status,status,date_format(insert_date,'%d %b %Y') as insert_date ";
		$sql.=" FROM ".$this->tb3." WHERE 1=1";

		$totalData = $this->Adminamodel->data_search_count($sql);	
		$totalFiltered = $totalData;
		
		if(!empty($this->input->post('search')['value'])){
			$search = $this->input->post('search')['value'];
			$sql.= " AND (user_name LIKE '".$search."%' ";
			$search=$this->volanlib->encryptMob($search);
			$sql.= " OR mobile LIKE '".$search."%' ";
			$sql.= " OR email LIKE '".$search."%' ";
			$sql.= " OR wallet_balance LIKE '".$search."%' ";
			$sql.=" OR insert_date LIKE '".$search."%' )";
				
			$tb_data =  $this->Adminamodel->data_search($sql);
			$totalFiltered = $this->Adminamodel->data_search_count($sql);
		}else{
			$sql.=" ORDER BY ". $order."   ".$dir."  LIMIT ".$start." ,".$limit."   ";
			$tb_data =  $this->Adminamodel->data_search($sql);
		}
		
		$i=$start+1;
		$data = array();
		if(!empty($tb_data))
		{
			foreach($tb_data as $rs )
			{
				$nestedData = array();
				
				$nestedData['#'] = $i;
				$nestedData['user_name'] = '<a href="'.base_url().admin.'/view-user/'.$rs->user_id.'" class="mr-3 text-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="View Details">'.$rs->user_name.'</a>';
				$nestedData['mobile'] = $this->volanlib->decryptMob($rs->mobile);
				$nestedData['email'] = $rs->email != "" ? $rs->email : 'N/A';
				$nestedData['insert_date'] = $rs->insert_date;
				$nestedData['wallet_balance'] = $rs->wallet_balance;
				$nestedData['status'] = $rs->status;
				$nestedData['user_id'] = $rs->user_id;
				if($rs->betting_status==1){
					$nestedData['betting_status'] = '<a role="button" class="activeDeactive" id="success-'.$rs->user_id.'-tb_user-user_id-betting_status"><span class="badge badge-pill badge-soft-success font-size-12">Yes</span></a>';
				}else{
					$nestedData['betting_status'] = '<a role="button" class="activeDeactive" id="danger-'.$rs->user_id.'-tb_user-user_id-betting_status"><span class="badge badge-pill badge-soft-danger font-size-12">No</span></a>';
				}
				
				if($rs->transfer_point_status==1){
					$nestedData['transfer_status'] = '<a role="button" class="activeDeactive" id="success-'.$rs->user_id.'-tb_user-user_id-transfer_point_status"><span class="badge badge-pill badge-soft-success font-size-12">Yes</span></a>';
				}else{
					$nestedData['transfer_status'] = '<a role="button" class="activeDeactive" id="danger-'.$rs->user_id.'-tb_user-user_id-transfer_point_status"><span class="badge badge-pill badge-soft-danger font-size-12">No</span></a>';
				}
				
				if($rs->status==1){
					$nestedData['active_status'] = '<a role="button" class="activeDeactive" id="success-'.$rs->user_id.'-tb_user-user_id-status"><span class="badge badge-pill badge-soft-success font-size-12">Yes</span></a>';
				}else{
					$nestedData['active_status'] = '<a role="button" class="activeDeactive"  id="danger-'.$rs->user_id.'-tb_user-user_id-status"><span class="badge badge-pill badge-soft-danger font-size-12">No</span></a>';
				}
				
				$nestedData['view_details'] = '<a href="'.base_url().admin.'/view-user/'.$rs->user_id.'" class="mr-3 text-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="View Details"><i class="mdi mdi-eye font-size-18"></i></a>';
				
				$data[] = $nestedData;
				$i++;
			}
		}
		$json_data = array(
					"draw"            => intval($this->input->post('draw')),  
					"recordsTotal"    => intval($totalData),  
					"recordsFiltered" => intval($totalFiltered), 
					"data"            => $data   
					);
			
		echo json_encode($json_data); 
	}
	
	public function viewUser()
	{
		if($this->session->userdata('adminlogin') != 1)
		{
			$myurl = base_url() .admin;
			redirect($myurl);
		}
		$this->data['title'] = "View User";
		$this->data['banner_title'] = "View User";
		$user_id=$this->uri->segment(3);
		$where=array($this->tb3.'.user_id'=>$user_id);
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
		$columns = "user_name,mobile,email,password,security_pin,wallet_balance,DATE_FORMAT(".$this->tb3.".insert_date,'%d %b %Y %r') as insert_date,".$this->tb3.".status,bank_name,branch_address,ac_holder_name,ac_number,ifsc_code,		paytm_number,google_pay_number,phone_pay_number,flat_ploat_no,address_lane_1,address_lane_2,area,pin_code,state_name,district_name,".$this->tb3.".user_id,date_format(last_update,'%d %b %Y %r') as last_update,betting_status,transfer_point_status";
		$this->data['getDetail'] = $this->Adminamodel->get_joins_where($this->tb3,$columns,$joins,$where);
		
		if(count($this->data['getDetail'])>0)
		{
			foreach($this->data['getDetail'] as $rs)
			{
				$this->data['user_id'] = $rs->user_id;
				$this->data['user_name'] = $rs->user_name;
				$this->data['mobile'] = $this->volanlib->decryptMob($rs->mobile);
				$this->data['email'] = $rs->email;
				$this->data['password'] = $this->decType($rs->password);
				$this->data['security_pin'] = $rs->security_pin;
				$this->data['wallet_balance'] = $rs->wallet_balance;
				$this->data['insert_date'] = $rs->insert_date;
				$this->data['last_update'] = $rs->last_update;
				$this->data['status'] = $rs->status;
				$this->data['bank_name'] = $rs->bank_name;
				$this->data['branch_address'] = $rs->branch_address;
				$this->data['ac_holder_name'] = $rs->ac_holder_name;
				$this->data['ac_number'] = $rs->ac_number;
				$this->data['ifsc_code'] = $rs->ifsc_code;
				$this->data['paytm_number'] = $rs->paytm_number;
				$this->data['google_pay_number'] = $rs->google_pay_number;
				$this->data['phone_pay_number'] = $rs->phone_pay_number;
				$this->data['flat_ploat_no'] = $rs->flat_ploat_no;
				$this->data['address_lane_1'] = $rs->address_lane_1;
				$this->data['address_lane_2'] = $rs->address_lane_2;
				$this->data['area'] = $rs->area;
				$this->data['pin_code'] = $rs->pin_code;
				$this->data['state_name'] = $rs->state_name;
				$this->data['district_name'] = $rs->district_name;
				$this->data['betting_status'] = $rs->betting_status;
				$this->data['transfer_point_status'] = $rs->transfer_point_status;
			}
			
			$where = array('user_id' => $user_id);
			$select = 'fund_request_id,request_amount,request_number,request_status,fund_payment_receipt,
			DATE_FORMAT(insert_date,"%d %b %Y") as insert_date';
			$by = 'fund_request_id';
			$this->data['fundrequestData'] = $this->Adminamodel->get_data_latest_where_desc($this->tb5,$where,$by,$select);
			
			$select = 'withdraw_request_id,request_amount,request_number,request_status,payment_receipt,
			DATE_FORMAT(insert_date,"%d %b %Y %r") as insert_date';
			$by = 'withdraw_request_id';
			$this->data['withdrawrequestData'] = $this->Adminamodel->get_data_latest_where_desc($this->tb11,$where,$by,$select);
			$this->data['user_wallet_transaction_data_flag_data']=1;
			$this->data['user_credit_transaction_data_flag_data']=1;
			$this->data['user_debit_transaction_data_flag_data']=1;
			$this->data['user_bid_history_data_flag_data']=1;
			$this->data['active_menu'] = 'user_management';
			$this->middle = 'admin/e';
			$this->layout();
		}else{
			$myurl = base_url().admin.'/dashboard';
			redirect($myurl);
		}
	}
	
	public function allowedBetting()
	{
		$user_id = trim($this->input->post('user_id'));
		$where = array('user_id' => $user_id);
		$data = array('betting_status'=>1);
		$this->Admincmodel->update_where($this->tb3,$data,$where);
		
		$result = $this->Adminamodel->get_data_row($this->tb3,$where);
		if($result != '')
		{
			$user_name = $result->user_name;
			$mobile = $result->mobile;
		}
		
		
		$data['status'] = 'success';
		echo json_encode($data);
	}
	
	
	public function changeLogoutStatus()
	{
		$user_id = trim($this->input->post('user_id'));
		$where = array('user_id' => $user_id);
		$data = array('logout_status'=>1);
		$this->Admincmodel->update_where($this->tb51,$data,$where);		
		
		$data['status'] = 'success';
		echo json_encode($data);
	}
	
	
	public function acceptFundRequest()
	{
		$fund_request_id = $this->input->post('id');
		$where_id = array('fund_request_id' => $fund_request_id);
		$result = $this->Adminamodel->get_data_row($this->tb5,$where_id);
		if($result != '')
		{
			$user_id = $result->user_id;
			$amount = $result->request_amount;
			$status = $result->request_status;
			$request_number = $result->request_number;
		}
		if($status == 0)
		{
			$where_user = array('user_id' => $user_id);
			$user_data=$this->Adminamodel->get_data($this->tb3,$where_user);
			if(count($user_data)>0)
			{
				foreach($user_data as $rs)
				{
					$wallet_balance = $rs->wallet_balance;
				}
			}
			$wallet_balance += $amount;
			
			$user_wallet_data=array(
					'wallet_balance'=>$wallet_balance,
					);
			$this->Admincmodel->update_where($this->tb3,$user_wallet_data,$where_user);
			
			$request_status_data = array (
				'request_status' => 2
			);
			$this->Admincmodel->update_where($this->tb5,$request_status_data,$where_id);
			
			$history_data = array(
					'user_id' => $user_id,
					'amount' => $amount,
					'transaction_type' => 1,
					'transaction_note' => 'Request No.'.$request_number.' Processed',
					'amount_status' => 1,
					'tx_request_number' => $request_number,
					'insert_date' => $this->insert_date
				);
			$this->Adminbmodel->insertData($history_data,$this->tb14);
			
			$insert_data = array(
				'user_id' => $user_id,
				'msg' => "Congratulations ,Your fund request of amount".$amount." is accepted.",
				'insert_date' => $this->insert_date
			);
			$this->Adminbmodel->insertData($insert_data,$this->tb22);
			
			
				$where = array ('user_id' => $user_id);
				$result = $this->Adminamodel->get_data($this->tb33,$where);
				$player_id='';
				if(count($result)>0)
				{
					foreach($result as $rs)
					{
						$player_id.=','.$rs->player_id;
						
					}
					
					
					
					$player_id=trim($player_id,',');
					$to = $player_id; 
					$img = ''; 
					$type_id = '2';
					$title='Request No.'.$request_number.' For Points Processed';
					$notification_content="Congratulations ,Your point add request of points ".$amount." is accepted.";
					
					$this->volanlib->sendnotification($to, $title, $notification_content, $img, $type_id);
				}
			
			$data['status']="success";
			$data['request_status']= 'Accepted';
			$data['msg'] = $this->volanlib->success('Request Successfully Accepted');
		}	
		echo json_encode($data); 
	}

	public function rejectFundRequest()
	{
		$fund_request_id = $this->input->post('id');
		
		$where = array('fund_request_id' => $fund_request_id);
		$result = $this->Adminamodel->get_data_row($this->tb5,$where);
		if($result != '')
		{
			$user_id = $result->user_id;
			$amount = $result->request_amount;
		}
		
		$status_data = array (
			'request_status' => 1
		);
		$this->Admincmodel->update_where($this->tb5,$status_data,$where);
		
		$insert_data = array(
				'user_id' => $user_id,
				'msg' => "Sorry, Your fund request of amount".$amount." is rejected.",
				'insert_date' => $this->insert_date
			);
			$this->Adminbmodel->insertData($insert_data,$this->tb22);
		
		$data['status']="success";
		$data['request_status']= 'Rejected';
		$data['msg'] = $this->volanlib->success('Request Successfully Rejected');
	
		echo json_encode($data); 
	}
	
	public function allTransactionTableGridData()
	{
		$columns = array( 
			0 => 'transaction_id',
			1 => 'amount',
			2 => 'transaction_note',
			3 => 'transfer_note',
			4 => 'insert_date',
			5 => 'tx_request_number',
		);
		
		$user_id = $this->input->post('user_id');
		
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$con = '&& user_id='.$user_id.'';
		
		$sql = "SELECT transaction_id,amount,transaction_type,transaction_note,transfer_note,amount_status,tx_request_number,
		date_format(insert_date,'%d %b %Y %r') as insert_date ";
		$sql.=" FROM ".$this->tb14." WHERE 1=1 $con";

		$totalData = $this->Adminamodel->data_search_count($sql);	
		$totalFiltered = $totalData;
		
		if(!empty($this->input->post('search')['value'])){
			$search = $this->input->post('search')['value'];
			$sql.= " AND (amount LIKE '".$search."%' ";
			$sql.= " OR  transaction_type LIKE '".$search."%' ";
			$sql.= " OR  tx_request_number LIKE '".$search."%' ";
			$sql.=" OR insert_date LIKE '".$search."%' )";
				
			$tb_data =  $this->Adminamodel->data_search($sql);
			$totalFiltered = $this->Adminamodel->data_search_count($sql);
		}else{
			$sql.=" ORDER BY ". $order."   ".$dir."  LIMIT ".$start." ,".$limit."   ";
			$tb_data =  $this->Adminamodel->data_search($sql);
		}
		
		$i=$start+1;
		$data = array();
		if(!empty($tb_data))
		{
			foreach($tb_data as $rs )
			{
				$nestedData = array();
				
				$nestedData['#'] = $i;
				if($rs->transaction_type == 1)
				{
					$amount = '+ '.($rs->amount).' &#x20b9;';
				}else {
					$amount = '- '.($rs->amount).' &#x20b9;';
				} 
				$nestedData['amount'] = $amount;
				$nestedData['tx_note'] = $rs->transaction_note;
				if($rs->transfer_note != '')
				{
					$nestedData['transfer_note'] = $rs->transfer_note;
				
				}else {
					$nestedData['transfer_note'] = 'N/A';
				}
				$nestedData['insert_date'] = $rs->insert_date;
				if($rs->tx_request_number != '')
				{
					$nestedData['tx_req_no'] = $rs->tx_request_number;
				}else {
					$nestedData['tx_req_no'] = 'N/A';
				}
				$data[] = $nestedData;
				$i++;
			}
		}
		$json_data = array(
					"draw"            => intval($this->input->post('draw')),  
					"recordsTotal"    => intval($totalData),  
					"recordsFiltered" => intval($totalFiltered), 
					"data"            => $data   
					);
			
		echo json_encode($json_data); 
	}
	
	public function creditTransactionTableGridData()
	{
		$columns = array( 
			0 => 'transaction_id',
			1 => 'amount',
			2 => 'transaction_note',
			3 => 'transfer_note',
			4 => 'insert_date',
			5 => 'tx_request_number',
		);
		
		$user_id = $this->input->post('user_id');
		
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$con = '&& user_id='.$user_id.' && transaction_type = 1';
		
		$sql = "SELECT transaction_id,amount,transaction_type,transaction_note,transfer_note,amount_status,tx_request_number,
		date_format(insert_date,'%d %b %Y %r') as insert_date ";
		$sql.=" FROM ".$this->tb14." WHERE 1=1 $con";

		$totalData = $this->Adminamodel->data_search_count($sql);	
		$totalFiltered = $totalData;
		
		if(!empty($this->input->post('search')['value'])){
			$search = $this->input->post('search')['value'];
			$sql.= " AND (amount LIKE '".$search."%' ";
			$sql.= " OR  transaction_type LIKE '".$search."%' ";
			$sql.= " OR  tx_request_number LIKE '".$search."%' ";
			$sql.=" OR insert_date LIKE '".$search."%' )";
				
			$tb_data =  $this->Adminamodel->data_search($sql);
			$totalFiltered = $this->Adminamodel->data_search_count($sql);
		}else{
			$sql.=" ORDER BY ". $order."   ".$dir."  LIMIT ".$start." ,".$limit."   ";
			$tb_data =  $this->Adminamodel->data_search($sql);
		}
		
		$i=$start+1;
		$data = array();
		if(!empty($tb_data))
		{
			foreach($tb_data as $rs )
			{
				$nestedData = array();
				
				$nestedData['#'] = $i;
				if($rs->transaction_type == 1)
				{
					$amount = '+ '.($rs->amount).' &#x20b9;';
				}else {
					$amount = '- '.($rs->amount).' &#x20b9;';
				} 
				$nestedData['amount'] = $amount;
				$nestedData['tx_note'] = $rs->transaction_note;
				if($rs->transfer_note != '')
				{
					$nestedData['transfer_note'] = $rs->transfer_note;
				
				}else {
					$nestedData['transfer_note'] = 'N/A';
				}
				$nestedData['insert_date'] = $rs->insert_date;
				if($rs->tx_request_number != '')
				{
					$nestedData['tx_req_no'] = $rs->tx_request_number;
				}else {
					$nestedData['tx_req_no'] = 'N/A';
				}
				$data[] = $nestedData;
				$i++;
			}
		}
		$json_data = array(
					"draw"            => intval($this->input->post('draw')),  
					"recordsTotal"    => intval($totalData),  
					"recordsFiltered" => intval($totalFiltered), 
					"data"            => $data   
					);
			
		echo json_encode($json_data); 
	}
	
	public function debitTransactionTableGridData()
	{
		$columns = array( 
			0 => 'transaction_id',
			1 => 'amount',
			2 => 'transaction_note',
			3 => 'transfer_note',
			4 => 'insert_date',
			5 => 'tx_request_number',
		);
		
		$user_id = $this->input->post('user_id');
		
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$con = '&& user_id='.$user_id.' && transaction_type = 2';
		
		$sql = "SELECT transaction_id,amount,transaction_type,transaction_note,transfer_note,amount_status,tx_request_number,
		date_format(insert_date,'%d %b %Y %r') as insert_date ";
		$sql.=" FROM ".$this->tb14." WHERE 1=1 $con";

		$totalData = $this->Adminamodel->data_search_count($sql);	
		$totalFiltered = $totalData;
		
		if(!empty($this->input->post('search')['value'])){
			$search = $this->input->post('search')['value'];
			$sql.= " AND (amount LIKE '".$search."%' ";
			$sql.= " OR  transaction_type LIKE '".$search."%' ";
			$sql.= " OR  tx_request_number LIKE '".$search."%' ";
			$sql.=" OR insert_date LIKE '".$search."%' )";
				
			$tb_data =  $this->Adminamodel->data_search($sql);
			$totalFiltered = $this->Adminamodel->data_search_count($sql);
		}else{
			$sql.=" ORDER BY ". $order."   ".$dir."  LIMIT ".$start." ,".$limit."   ";
			$tb_data =  $this->Adminamodel->data_search($sql);
		}
		
		$i=$start+1;
		$data = array();
		if(!empty($tb_data))
		{
			foreach($tb_data as $rs )
			{
				$nestedData = array();
				
				$nestedData['#'] = $i;
				if($rs->transaction_type == 1)
				{
					$amount = '+ '.($rs->amount).' &#x20b9;';
				}else {
					$amount = '- '.($rs->amount).' &#x20b9;';
				} 
				$nestedData['amount'] = $amount;
				$nestedData['tx_note'] = $rs->transaction_note;
				if($rs->transfer_note != '')
				{
					$nestedData['transfer_note'] = $rs->transfer_note;
				
				}else {
					$nestedData['transfer_note'] = 'N/A';
				}
				$nestedData['insert_date'] = $rs->insert_date;
				if($rs->tx_request_number != '')
				{
					$nestedData['tx_req_no'] = $rs->tx_request_number;
				}else {
					$nestedData['tx_req_no'] = 'N/A';
				}
				$data[] = $nestedData;
				$i++;
			}
		}
		$json_data = array(
					"draw"            => intval($this->input->post('draw')),  
					"recordsTotal"    => intval($totalData),  
					"recordsFiltered" => intval($totalFiltered), 
					"data"            => $data   
					);
			
		echo json_encode($json_data); 
	}
	
	public function userBidHistoryTableGridData()
	{
		$columns = array( 
			0 => 'bid_id',
			1 => 'game_name',
			2 => 'pana',
			3 => 'session',
			4 => 'digits',
			5 => 'closedigits',
			6 => 'points',
			7 => 'insert_date',
		);
		
		$user_id = $this->input->post('user_id');
		
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$con = '&& user_id='.$user_id.'';
		
		$sql = "SELECT bid_id,game_name,pana,session,digits,closedigits,points,date_format(insert_date,'%d %b %Y %r') as insert_date ";
		$sql.=" FROM ".$this->tb18." WHERE 1=1 $con";

		$totalData = $this->Adminamodel->data_search_count($sql);	
		$totalFiltered = $totalData;
		
		if(!empty($this->input->post('search')['value'])){
			$search = $this->input->post('search')['value'];
			$sql.= " AND (game_name LIKE '".$search."%' ";
			$sql.= " OR  pana LIKE '".$search."%' ";
			$sql.= " OR  session LIKE '".$search."%' ";
			$sql.= " OR  digits LIKE '".$search."%' ";
			$sql.= " OR  closedigits LIKE '".$search."%' ";
			$sql.= " OR  points LIKE '".$search."%' ";
			$sql.=" OR insert_date LIKE '".$search."%' )";
				
			$tb_data =  $this->Adminamodel->data_search($sql);
			$totalFiltered = $this->Adminamodel->data_search_count($sql);
		}else{
			$sql.=" ORDER BY ". $order."   ".$dir."  LIMIT ".$start." ,".$limit."   ";
			$tb_data =  $this->Adminamodel->data_search($sql);
		}
		
		$i=$start+1;
		$data = array();
		if(!empty($tb_data))
		{
			foreach($tb_data as $rs )
			{
				$nestedData = array();
				
				$nestedData['#'] = $i;
				$nestedData['game_name'] = $rs->game_name;
				$nestedData['game_type'] = $rs->pana;
				$nestedData['session'] = $rs->session;
				$nestedData['digits'] = $rs->digits;
				$nestedData['close_digits'] = $rs->closedigits;
				$nestedData['points'] = $rs->points;
				$nestedData['insert_date'] = $rs->insert_date;
				
				$data[] = $nestedData;
				$i++;
			}
		}
		$json_data = array(
					"draw"            => intval($this->input->post('draw')),  
					"recordsTotal"    => intval($totalData),  
					"recordsFiltered" => intval($totalFiltered), 
					"data"            => $data   
					);
			
		echo json_encode($json_data); 
	}
	
	public function addFundUserWalletManagement()
	{
		if($this->session->userdata('adminlogin') == 1)
		{
			$this->data['title'] = "User Wallet Management";
			$this->data['banner_title'] = "User Wallet Management";
			$this->data['active_menu'] = 'user_wallet';
			$this->data['master_menu'] = 'wallet_management';
			$select = 'user_id,user_name,mobile,wallet_balance';
			$user_data = $this->Adminamodel->getDataSelect($this->tb3,$select);
			foreach($user_data as $rs)
			{
				$rs->mobile=$this->volanlib->decryptMob($rs->mobile);
			}
			$this->data['user_data'] = $user_data;
			$this->middle = 'admin/p'; 
			$this->layout();
		}
		else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
    }
	
	public function addBalanceUserWallet()
	{
		$user_id = trim($this->input->post('user_id'));
		$user_amount = trim($this->input->post('user_amount'));
		
		$where = array('user_id'=>$user_id);
		$result = $this->Adminamodel->get_data_row($this->tb3,$where);
		if($result != '')
		{
			$wallet_balance = $result->wallet_balance;
		}
		$wallet_balance += $user_amount;
		$walletdata = array('wallet_balance'=>$wallet_balance);
		$this->Admincmodel->update_where($this->tb3,$walletdata,$where);
		
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
		$this->Adminbmodel->insertData($history_data,$this->tb14);
		$data['status'] = 'success';
		$data['msg'] = $this->volanlib->success('Amount successfully added');
		echo json_encode($data);
	}
	
	public function withdrawBalanceUserWallet()
	{
		$user_id = trim($this->input->post('user_id'));
		$user_amount = trim($this->input->post('amount'));
		
		$where = array('user_id'=>$user_id);
		$result = $this->Adminamodel->get_data_row($this->tb3,$where);
		if($result != '')
		{
			$wallet_balance = $result->wallet_balance;
		}
		$wallet_balance = $wallet_balance-$user_amount;
		
		if($wallet_balance<0)
		{
			$data['status'] = 'error';
			$data['msg'] = $this->volanlib->error('User amount is going negative');
		}
		else
		{
			$walletdata = array('wallet_balance'=>$wallet_balance);
			$this->Admincmodel->update_where($this->tb3,$walletdata,$where);
			
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
			$this->Adminbmodel->insertData($history_data,$this->tb14);
			$data['status'] = 'success';
			$data['msg'] = $this->volanlib->success('Amount successfully withdraw');
		}
		echo json_encode($data);

	}
	
	public function changeSecurityPin()
	{
		$user_id = trim($this->input->post('user_id'));
		$security_pin = trim($this->input->post('security_pin'));
		
		$where = array('user_id'=>$user_id);
		
		$wadata = array('security_pin'=>$security_pin);
		$this->Admincmodel->update_where($this->tb3,$wadata,$where);
		
		
		$where = array('user_id'=>$user_id);
		
		$wadata = array('security_pin_status'=>1);
		$this->Admincmodel->update_where($this->tb51,$wadata,$where);
		
		
		$data['status'] = 'success';
		$data['security_pin'] = $security_pin;
		$data['msg'] = "Security PIN successfully changed";
		echo json_encode($data);
	}
	
	public function userWinningHistoryData()
	{
		$result_date = $this->input->post('result_date');
		$user_id = $this->input->post('user_id');
		$result_date = date('Y-m-d',strtotime($result_date));
		
		$joins = array();
		$where = array('user_id'=>$user_id,'DATE('.$this->tb14.'.insert_date)' => $result_date,'amount_status'=>8);

		$columns="amount,transaction_note,tx_request_number,date_format(insert_date,'%d %b %Y %r') as insert_date";
		$by = 'transaction_id';
		$data['getResultHistory']= $this->Adminamodel->get_joins_where_by($this->tb14,$columns,$joins,$by,$where);

		echo json_encode($data);
	}
}