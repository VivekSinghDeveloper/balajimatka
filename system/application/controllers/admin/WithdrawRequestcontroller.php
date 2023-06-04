<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class WithdrawRequestcontroller extends MY_AdminController {
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
	//dashboard for admin
    public function withdrawRequestManagement()
	{
		if($this->session->userdata('adminlogin') == 1)
		{
			$this->data['title'] = "Withdraw Request Managment";
			$this->data['banner_title'] = "Withdraw Request Managment";
			$this->data['banner_title2'] = "Withdraw Request List";
			$this->data['active_menu'] = 'withdraw_request_management';
			$this->data['master_menu'] = 'wallet_management';
			$this->data['withdrawRequestListTableFlag'] = 1;
			$this->middle = 'admin/i'; 
			$this->layout();
		}
		else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
    }
	
	public function withdrawRequestListGridData()
	{
		$columns = array( 
			0 => 'withdraw_request_id',
			1 => 'user_name',
			2 => 'mobile',
			3 => 'request_amount',
			4 => 'request_number',
			5 => 'insert_date',
			6 => 'request_status',
			7 => 'withdraw_request_id',
			8 => 'withdraw_request_id'
		);
		
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		
		$sql = "SELECT withdraw_request_id,user_name,mobile,request_amount,request_number,request_status,payment_receipt,
		date_format(a.insert_date,'%d %b %Y %r') as insert_date,a.user_id";
		$sql.=" FROM ".$this->tb11." a LEFT JOIN ".$this->tb3." b ON b.user_id = a.user_id WHERE 1=1";

		$totalData = $this->Adminamodel->data_search_count($sql);	
		$totalFiltered = $totalData;
		
		if(!empty($this->input->post('search')['value'])){
			$search = $this->input->post('search')['value'];
			$sql.= " AND (user_name LIKE '".$search."%' ";
			$search=$this->volanlib->encryptMob($search);
			$sql.= " OR  mobile LIKE '".$search."%' ";
			$sql.= " OR  request_amount LIKE '".$search."%' ";
			$sql.= " OR  request_number LIKE '".$search."%' ";
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
				$nestedData['user_name'] = $rs->user_name.' <a href="'.base_url().admin.'/view-user/'.$rs->user_id.'"><i class="bx bx-link-external"></i></a>';
				$nestedData['mobile'] = $this->volanlib->decryptMob($rs->mobile);
				$request_amount = $rs->request_amount;
				$nestedData['request_amount'] = $request_amount;
				$nestedData['request_number'] = $rs->request_number;
				$receipt_img='N/A';
				if($rs->payment_receipt!=""){
					$receipt_img='<li><a class="item" href="'.base_url().'uploads/file/'.$rs->payment_receipt.'" data-original-title="" title=""><img class="icons" src="'.base_url().'uploads/file/'.$rs->payment_receipt.'"></a></li>';
				}
				
				$nestedData['receipt_img'] = $receipt_img;
				$nestedData['insert_date'] = $rs->insert_date;
				$nestedData['request_status'] = $rs->request_status;
				$nestedData['withdraw_request_id'] = $rs->withdraw_request_id;
				if($rs->request_status==0)
				{
					$nestedData['display_status'] = '<badge class="badge badge-pill badge-soft-info font-size-12">Pending</badge>';
				}
				else if($rs->request_status==1)
				{
					$nestedData['display_status'] = '<badge class="badge badge-pill badge-soft-danger font-size-12">Rejected</badge>';
				}else{
					$nestedData['display_status'] = '<badge class="badge badge-pill badge-soft-success font-size-12">Accepted</badge>';
				}
				
				$nestedData['view'] = '<a role="button" data-href="'.base_url().admin.'/view-withdraw-request/'.$rs->withdraw_request_id.'" class="mr-3 text-primary openViewWithdrawRequest" data-toggle="tooltip" data-placement="top" title="" data-original-title="View Details"><i class="mdi mdi-eye font-size-18"></i></a>';
				
				$mobile=$this->volanlib->decryptMob($rs->mobile);

				if($rs->request_status == 1 || $rs->request_status == 2) {
					$action='<button class="btn btn-primary btn-sm w-xs mr-1"  data-withdraw_request_id="'.$rs->withdraw_request_id.'" disabled>Approve</button><button class="btn btn-danger btn-sm w-xs" data-withdraw_request_id="'.$rs->withdraw_request_id.'" disabled >Reject</button>';
				}else {
					$action='<button class="btn btn-primary btn-sm w-xs mr-1" id="accept"  data-withdraw_request_id="'.$rs->withdraw_request_id.'" data-user_name="'.$rs->user_name.'" data-mobile="'.$mobile.'" data-request_amount="'.$rs->request_amount.'" data-request_number="'.$rs->request_number.'">Approve</button><button class="btn btn-danger btn-sm w-xs" id="reject"  data-withdraw_request_id="'.$rs->withdraw_request_id.'">Reject</button>';
				}
				
				$nestedData['action'] = $action;
				
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
	
	public function viewWithdrawRequest()
	{
		if($this->session->userdata('adminlogin') != 0)
		{
			$withdraw_request_id = $this->uri->segment(3);
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
			$withdrawRequestData = $this->Adminamodel->get_joins_where($this->tb11,$columns,$joins,$where);
			foreach($withdrawRequestData as $rs)
			{
				$this->data['withdraw_request_id'] = $rs->withdraw_request_id;
				$this->data['user_id'] = $rs->user_id;
				$this->data['user_name'] = '<a href="'.base_url().admin.'/view-user/'.$rs->user_id.'">'.$rs->user_name.'</a>';
				$this->data['request_amount'] = $rs->request_amount;
				$this->data['request_number'] = $rs->request_number;
				$this->data['request_status'] = $rs->request_status;
				$this->data['payment_method'] = $rs->payment_method;
				$this->data['bank_name'] = $rs->bank_name;
				$this->data['branch_address'] = $rs->branch_address;
				$this->data['ac_holder_name'] = $rs->ac_holder_name;
				$this->data['ac_number'] = $rs->ac_number;
				$this->data['ifsc_code'] = $rs->ifsc_code;
				$this->data['paytm_number'] = $rs->paytm_number;
				$this->data['google_pay_number'] = $rs->google_pay_number;
				$this->data['phone_pay_number'] = $rs->phone_pay_number;
				$this->data['payment_receipt'] = $rs->payment_receipt;
				$this->data['remark'] = $rs->remark;
				$this->data['insert_date'] = $rs->insert_date;
				$this->data['accepte_date'] = $rs->accepte_date;
			}
			$where = array('user_id'=>$this->data['user_id']);
			$result = $this->Adminamodel->get_data_row($this->tb3,$where);
			if($result != '')
			{
				$this->data['wallet_balance'] = $result->wallet_balance;
			}
			$this->load->view('admin/j', $this->data);
		}
		else {
			$myurl = base_url() .admin.'/dashboard';
			redirect($myurl);
		}
	}
	
	public function approveWithdrawRequest()
	{
		$withdraw_req_id = trim($this->input->post('withdraw_req_id'));
		$remark = trim($this->input->post('remark'));
        $file='';
		if(isset($_FILES['file']['tmp_name']) && $_FILES['file']['tmp_name']!='')
		{
		$path2 = 'uploads/file/';
		$allowed = array('jpeg', 'png', 'jpg');
		$filename = $_FILES['file']['name'];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		$ext= strtolower($ext);
		    if (!in_array($ext, $allowed))
            {
                $data['status'] = 'error';
                $data['msg'] = $this->volanlib->error('Allow Only.jpeg,.jpg,.png');
                echo json_encode($data);die;
		    }
            $file=$this->volanimage->upload_image($path2,$_FILES['file']);
        }
		$withdrawReqdata = array(
				'request_status' => 2,
				'payment_receipt' => $file,
				'remark' => $remark,
			);
		$where = array('withdraw_request_id'=>$withdraw_req_id);
		$this->Admincmodel->update_where($this->tb11,$withdrawReqdata,$where);
		$result = $this->Adminamodel->get_data_row($this->tb11,$where);
		if($result != '')
		{
			$user_id = $result->user_id;
			$request_amount = $result->request_amount;
			$request_number = $result->request_number;
		}
		$where = array('user_id'=>$user_id);
		$holdamtdata = array('hold_amount'=>0);
		$this->Admincmodel->update_where($this->tb3,$holdamtdata,$where);
		
		$history_data = array(
				'user_id' => $user_id,
				'amount' => $request_amount,
				'transaction_type' => 2,
				'transaction_note' => 'Amount Withdraw',
				'amount_status' => 2,
				'tx_request_number' => $request_number,
				'insert_date' => $this->insert_date
			);
		$this->Adminbmodel->insertData($history_data,$this->tb14);
				$insert_data = array(			'user_id' => $user_id,			'msg' => "Congratulations ,Your withdraw request of amount".$request_amount." is accepted",			'insert_date' => $this->insert_date		);		$this->Adminbmodel->insertData($insert_data,$this->tb22);		
		$data['status'] = 'success';
		$data['request_status'] = 'Accepted';
		$data['msg'] = $this->volanlib->success('Withdraw Request Approved successfully.');
		echo json_encode($data);
	}
	public function rejectWithdrawRequest()
	{
		$withdraw_req_id = trim($this->input->post('withdraw_req_id'));
		$remark = trim($this->input->post('remark'));
		$where = array('withdraw_request_id'=>$withdraw_req_id);
		$result = $this->Adminamodel->get_data_row($this->tb11,$where);
		if($result != '')
		{
			$user_id = $result->user_id;		
			$request_amount = $result->request_amount;
		}
		$where_user = array('user_id'=>$user_id);
		$result = $this->Adminamodel->get_data_row($this->tb3,$where_user);
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
		$this->Admincmodel->update_where($this->tb3,$addholdamtdata,$where_user);
		
		$withdrawReqdata = array(
			'request_status' => 1,
			'remark' => $remark,
			);
		$where = array('withdraw_request_id'=>$withdraw_req_id);
		$this->Admincmodel->update_where($this->tb11,$withdrawReqdata,$where);
			$insert_data = array(		
				'user_id' => $user_id,
				'msg' => "Sorry, Your withdraw request of amount".$request_amount." is rejected",
				'insert_date' => $this->insert_date
			);
		$this->Adminbmodel->insertData($insert_data,$this->tb22);		
		 /* $history_data = array(
				'user_id' => $user_id,
				'amount' => $hold_amount,
				'transaction_type' => 1,
				'transaction_note' => 'Withdraw Request Rejected',
				'amount_status' => 1,
				'tx_request_number' => $request_number,
				'insert_date' => $this->insert_date
			);
		$this->Adminbmodel->insertData($history_data,$this->tb14); */
		
		$data['status'] = 'success';
		$data['request_status'] = 'Rejected';
		$data['msg'] = $this->volanlib->success('Withdraw Request Rejected successfully.');
		echo json_encode($data);
	}
}