<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboardcontroller extends MY_AdminController {

    public function __construct() {
        parent::__construct();
		
    }
	
	/*dashboard for admin*/
    public function welcomeAdmin()
	{
		if($this->session->userdata('adminlogin') == 1)
		{
			$this->data['title'] = "Dashboard";
			$this->data['banner_title'] = "Dashboard";
			$this->data['active_menu'] = 'Dashboard';
			$this->data['dashboardPostTableFlag'] = 1;
			
			$joins = array(
				array(
					'table' => $this->tb21,
					'condition' => $this->tb21.'.game_id = '.$this->tb16.'.game_id && result_date="'.date('Y-m-d').'"',
					'jointype' => 'LEFT'
				)
			);
			$columns = ''.$this->tb16.'.game_id,game_name,open_time,close_time,market_status,open_number,close_number,
			open_decleare_status as open_status,close_decleare_status as close_status';
			$where=array('status'=>1);
			$by='open_time_sort';
			$result = $this->Adminamodel->get_joins_where_by_asc($this->tb16,$columns,$joins,$by,$where);
			$this->data['gameResultData'] = $result;
			
			
			$getUsers = $this->Adminamodel->getData($this->tb3);
			$this->data['totalUsers'] = count($getUsers);
			
			$totalGames = $this->Adminamodel->getData($this->tb16);
			$this->data['totalGames'] = count($totalGames);
			
			$getUnapprovedUsers = $this->Adminamodel->get_data($this->tb3,array('betting_status'=>0));
			$this->data['totalUnapprovedUsers'] = count($getUnapprovedUsers);
			
			$getApprovedUsers = $this->Adminamodel->get_data($this->tb3,array('betting_status !='=>0));
			$this->data['totalApprovedUsers'] = count($getApprovedUsers);
			
			$bid_amt = 0;
			$where = array('bid_date' => $this->cur_date);
			$today_bid = $this->Adminamodel->get_data($this->tb18,$where);
			if(count($today_bid)>0)
			{
				foreach($today_bid as $rs)
				{
					$bid_amt += $rs->points;
				}
				
			} 
			$this->data['today_bid_amt'] = $bid_amt;
			
			$cur_date = date("l");			
			$sql = "SELECT a.game_id,b.open_time_sort,a.game_name,b.open_time,b.close_time,b.name";
			$sql.=" FROM ".$this->tb16." a LEFT JOIN ".$this->tb48." b ON b.game_id = a.game_id WHERE a.status=1 AND b.name='$cur_date' ORDER BY b.open_time_sort";
			// $sql.=" FROM ".$this->tb16." a LEFT JOIN ".$this->tb48." b ON b.game_id = a.game_id WHERE a.status=1 AND b.name='$cur_date' GROUP BY b.game_id  ORDER BY b.open_time_sort";
			
			// echo $sql;exit;
			$this->data['game_result'] = $this->Adminamodel->custom_search($sql);
			$this->data['unApprovedUserListTableFlag'] = 1;
			$this->data['banner_title2'] = "Un-Approved Users List";
			
			$this->data['autoFundUserListTableFlag'] = 1;
			$this->middle = 'admin/b'; 
			$this->layout();
		}
		else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
    }
	
	//dashboard for admin
    public function unApprovedUsersList()
	{
		if($this->session->userdata('adminlogin') == 1)
		{
			$this->data['title'] = "Un Approved Users List";
			$this->data['banner_title'] = "Un Approved Users List";
			$this->data['active_menu'] = 'Dashboard';
			$this->data['unApprovedUserListTableFlag'] = 1;
			
			
			$this->data['banner_title2'] = "Un-Approved Users List";
			$this->middle = 'admin/b3'; 
			$this->layout();
		}
		else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
    }
	
	
	
	
	public function unApprovedUserListGridData()
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
		$con = '&& betting_status = 0';
		
		$sql = "SELECT user_id,user_name,mobile,email,wallet_balance,betting_status,transfer_point_status,status,date_format(insert_date,'%d %b %Y') as insert_date ";
		$sql.=" FROM ".$this->tb3." WHERE 1=1 $con";

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
				$nestedData['user_name'] = $rs->user_name;
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
	
	
	public function tipsManagement()
	{
		if($this->session->userdata('adminlogin') == 1)
		{
			$this->data['title'] = "Tips Managment";
			$this->data['banner_title'] = "Tips Management";
			$this->data['banner_title2'] = "Tips Management";
			$this->data['active_menu'] = 'tips_management';
			$this->data['tipsListTableFlag'] = 1;
			$this->middle = 'admin/y'; 
			$this->layout();
		}else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
	}
	
	public function addTips()
	{
		$tips_id = trim($this->input->post('tips_id'));
		$tips_title = trim($this->input->post('tips_title'));
		$description = trim($this->input->post('description'));
		$old_icon = trim($this->input->post('old_icon'));
		
		$file='';
		$path = 'uploads/file/';
		if($_FILES['file']['name']!="")
		{
			$file=$this->volanimage->upload_image($path,$_FILES['file']);
		}else {
			$file=$old_icon;
		}

		$data = array(
			'title' => $tips_title,
			'description' => $description,
			'banner_image' => $file,
			'insert_date'=>$this->insert_date
		);
		if($tips_id == ''){
			$this->Adminbmodel->insertData($data,$this->tb23);
			$data['status'] = 'success';
			$data['msg'] = $this->volanlib->success('Tips successfully added');
		}else {
			$where = array('tips_id'=>$tips_id);
			$this->Admincmodel->update_where($this->tb23,$data,$where);
			$data['status'] = 'update';
			$data['msg'] = $this->volanlib->success('Tips updated successfully.');
		}
		echo json_encode($data);
	}
	
	public function tipsListGridData()
	{
		$columns = array( 
			0 => 'tips_id',
			1 => 'title',
			2 => 'banner_image',
			3 => 'insert_date',
			4 => 'status',
			5 => 'tips_id'
		);

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];

		$sql = "SELECT tips_id,title,banner_image,status,date_format(insert_date,'%d %b %Y %r') as insert_date";
		$sql.=" FROM ".$this->tb23." WHERE 1=1";

		$totalData = $this->Adminamodel->data_search_count($sql);	
		$totalFiltered = $totalData;
		if(!empty($this->input->post('search')['value'])){
			$search = $this->input->post('search')['value'];
			$sql.= " AND (title LIKE '".$search."%' ";
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
				$banner_image='N/A';
				if($rs->banner_image!=""){
					$banner_image='<li><a class="item" href="'.base_url().'uploads/file/'.$rs->banner_image.'" data-original-title="" title=""><img class="icons" src="'.base_url().'uploads/file/'.$rs->banner_image.'"></a></li>';
				}
				
				$nestedData['banner_image'] = $banner_image;
				$nestedData['title'] = $rs->title;
				$nestedData['insert_date'] = $rs->insert_date;
				$nestedData['status'] = $rs->status;
				$nestedData['tips_id'] = $rs->tips_id;
				if($rs->status==1)
				{
					$nestedData['display_status'] = '<div id="status_show'.$rs->tips_id.'"><badge class="badge badge-success">Active</badge></div>';
				}
				else
				{
					$nestedData['display_status'] = '<div id="status_show'.$rs->tips_id.'"><badge class="badge badge-danger">Inactive</badge></div>';
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
	
	public function editTips()
	{
		if($this->session->userdata('adminlogin') != 0)
		{
			$tips_id = $this->uri->segment(3);
			$where = array ('tips_id' => $tips_id);
			$result = $this->Adminamodel->get_data($this->tb23,$where);
			foreach($result as $rs)
			{
				$this->data['tips_id'] = $rs->tips_id;
				$this->data['title'] = $rs->title;
				$this->data['banner_image'] = $rs->banner_image;
				$this->data['description'] = $rs->description;
			}
			$this->load->view('admin/z',$this->data);
		}
		else {
			$myurl = base_url() .admin.'/dashboard';
			redirect($myurl);
		}
	}

	public function viewTips()
	{
		if($this->session->userdata('adminlogin') != 0)
		{
			$tips_id = $this->uri->segment(3);
			$where = array ('tips_id' => $tips_id);
			$tipsData = $this->Adminamodel->get_data($this->tb23,$where);
			foreach($tipsData as $rs)
			{
				$this->data['tips_title'] = $rs->title;
				$this->data['banner_image'] = $rs->banner_image;
				$this->data['description'] = $rs->description;
				$this->data['insert_date'] = date('Y-m-d h:i:s A',strtotime($rs->insert_date));
				$this->data['status'] = $rs->status;
			}
			$this->data['title'] = "Tips Management";
			$this->middle = 'admin/z1';
			$this->layout();
		}
		else {
			$myurl = base_url() .admin.'/dashboard';
			redirect($myurl);
		}
	}
	
	
	public function getMarketBidDetails()
	{
		$game_name = trim($this->input->post('game_name'));
		
		if($game_name == 'all'){
			$where = array('bid_date' => $this->cur_date);
		}else if($game_name != 'all'){
			$where = array('bid_date' => $this->cur_date,'game_id' => $game_name);
		}
		
		$total_points = 0;
		
		$getBidHistory= $this->Adminamodel->get_data($this->tb18,$where);
		if(count($getBidHistory)>0)
		{
			foreach($getBidHistory as $rs)
			{
				$total_points += $rs->points; 
			}
		}
		
		
		$data['status'] = 'success';
		$data['points'] = $total_points;
		
		echo json_encode($data);
	}
	
	 public function getSearchBidDetails()
	{
		$game_name = trim($this->input->post('bid_game_name'));
		$status = trim($this->input->post('market_status'));
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
		
		$getBidHistory= $this->Adminamodel->get_data($this->tb18,$where);
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
		
		
		$data['status'] = 'success';
		$data['total_zero'] = $total_zero;
		$data['total_one'] = $total_one;
		$data['total_two'] = $total_two;
		$data['total_three'] = $total_three;
		$data['total_four'] = $total_four;
		$data['total_five'] = $total_five;
		$data['total_six'] = $total_six;
		$data['total_seven'] = $total_seven;
		$data['total_eight'] = $total_eight;
		$data['total_nine'] = $total_nine;
		$data['bid_zero'] = $bid_zero;
		$data['bid_one'] = $bid_one;
		$data['bid_two'] = $bid_two;
		$data['bid_three'] = $bid_three;
		$data['bid_four'] = $bid_four;
		$data['bid_five'] = $bid_five;
		$data['bid_six'] = $bid_six;
		$data['bid_seven'] = $bid_seven;
		$data['bid_eight'] = $bid_eight;
		$data['bid_nine'] = $bid_nine;
		
		echo json_encode($data);
	}

		public function autoFundRequestListGridData()
	{
		$columns = array( 
			0 => 'id',
			1 => 'user_id',
			2 => 'amount',
			3 => 'tx_request_number',
			4 => 'txn_id',
			5 => 'insert_date',
			6 => 'reject_remark',
			7 => 'fund_status',
			8 => 'id'
		);
		
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		
		$sql = "SELECT id,user_name,amount,tx_request_number,fund_status,reject_remark,date_format(a.insert_date,'%d %b %Y') as insert_date,a.insert_date,a.user_id,txn_id,txn_ref";
		$sql.=" FROM ".$this->tb50." a LEFT JOIN ".$this->tb3." b ON b.user_id = a.user_id WHERE fund_status=0";

		$totalData = $this->Adminamodel->data_search_count($sql);	
		$totalFiltered = $totalData;
		
		if(!empty($this->input->post('search')['value'])){
			$search = $this->input->post('search')['value'];
			$sql.= " AND (user_name LIKE '".$search."%' ";
			$sql.= " OR  amount LIKE '".$search."%' ";
			$sql.= " OR  tx_request_number LIKE '".$search."%' ";
			$sql.= " OR  txn_id LIKE '".$search."%' ";
			$sql.=" OR a.insert_date LIKE '".$search."%' )";
				
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
				$nestedData['user_name'] = '<a href="'.base_url().admin.'/view-user/'.$rs->user_id.'">'.$rs->user_name.'</a>';
				$request_amount = '&#x20b9;'.$rs->amount;
				$nestedData['amount'] = $request_amount;
				$nestedData['tx_request_number'] = $rs->tx_request_number;
				
				
				$nestedData['insert_date'] = $rs->insert_date;
				$nestedData['fund_status'] = $rs->fund_status;
				$nestedData['reject_remark'] = $rs->reject_remark;
				$nestedData['id'] = $rs->id;
				$nestedData['txn_id'] = $rs->txn_id;
				$nestedData['txn_ref'] = $rs->txn_ref;
				if($rs->fund_status==0)
				{
					$nestedData['display_status'] = '<badge class="badge badge-info">Pending</badge>';
				}
				else if($rs->fund_status==2)
				{
					$nestedData['display_status'] = '<badge class="badge badge-danger">Rejected</badge>';
				}else{
					$nestedData['display_status'] = '<badge class="badge badge-success">Accepted</badge>';
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
	
	
	public function acceptAutoFundRequest()
	{
		$id = $this->input->post('id');
		$where_id = array('id' => $id);
		$result = $this->Adminamodel->get_data_row($this->tb50,$where_id);
		if($result != '')
		{
			$user_id = $result->user_id;
			$amount = $result->amount;
			$status = $result->fund_status;
			$tx_request_number = $result->tx_request_number;
			$txn_id = $result->txn_id;
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
				'fund_status' => 1
			);
			$this->Admincmodel->update_where($this->tb50,$request_status_data,$where_id);
			
			$history_data = array(
					'user_id' => $user_id,
					'amount' => $amount,
					'transaction_type' => 1,
					'transaction_note' => 'Auto Deposit Request No.'.$tx_request_number.' Processed',
					'amount_status' => 19,
					'tx_request_number' => $txn_id,
					'insert_date' => $this->insert_date
				);
					
			$this->Adminbmodel->insertData($history_data,$this->tb14);
			
			$data['status']="success";
			$data['request_status']= 'Accepted';
			$data['msg'] = $this->volanlib->success('Request Successfully Accepted');
		}	
		echo json_encode($data); 
	}

	public function rejectAutoFundRequest()
	{
		//echo "<pre>";print_r($_POST);die;
		$id = $this->input->post('id');
		$reject_auto_remark = $this->input->post('reject_auto_remark');
		
		$where = array('id' => $id);
		$result = $this->Adminamodel->get_data_row($this->tb50,$where);
		if($result != '')
		{
			$user_id = $result->user_id;
			$amount = $result->amount;
		}
		
		$status_data = array (
			'fund_status' => 2,
			'reject_remark' => $reject_auto_remark
		);
		$this->Admincmodel->update_where($this->tb50,$status_data,$where);
		
	
		
		$data['status']="success";
		$data['request_status']= 'Rejected';
		$data['msg'] = $this->volanlib->success('Request Successfully Rejected');
	
		echo json_encode($data); 
	}
	
	
	public function deleteAutoRequestDepo()
	{
		$id = $this->input->post('id');
		$where = array('id' => $id);
		$this->Admindmodel->delete($this->tb50,$where);
		$data['status']="success";
		$data['msg'] = $this->volanlib->success('Successfully Deleted');
		echo json_encode($data);
	}
	

	

	
}