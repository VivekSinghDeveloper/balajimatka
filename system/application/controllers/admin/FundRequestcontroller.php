<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class FundRequestcontroller extends MY_AdminController {

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
    public function fundRequestManagement()
	{
		if($this->session->userdata('adminlogin') == 1)
		{
			$this->data['title'] = "Fund Request Managment";
			$this->data['banner_title'] = "Fund Request Managment";
			$this->data['banner_title2'] = "Fund Request List";
			$this->data['active_menu'] = 'fund_request_management';
			$this->data['master_menu'] = 'wallet_management';
			$this->data['fundRequestListTableFlag'] = 1;
			$this->middle = 'admin/g'; 
			$this->layout();
		}
		else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
    }
	
	public function fundRequestListGridData()
	{
		$columns = array( 
			0 => 'fund_request_id',
			1 => 'user_id',
			2 => 'request_amount',
			3 => 'request_number',
			3 => 'fund_payment_receipt',
			4 => 'insert_date',
			5 => 'request_status',
			6 => 'fund_request_id'
		);
		
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		
		$sql = "SELECT fund_request_id,user_name,request_amount,request_number,request_status,fund_payment_receipt,
		date_format(a.insert_date,'%d %b %Y') as insert_date,a.user_id";
		$sql.=" FROM ".$this->tb5." a LEFT JOIN ".$this->tb3." b ON b.user_id = a.user_id WHERE 1=1";

		$totalData = $this->Adminamodel->data_search_count($sql);	
		$totalFiltered = $totalData;
		
		if(!empty($this->input->post('search')['value'])){
			$search = $this->input->post('search')['value'];
			$sql.= " AND (user_name LIKE '".$search."%' ";
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
				$nestedData['user_name'] = '<a href="'.base_url().admin.'/view-user/'.$rs->user_id.'">'.$rs->user_name.'</a>';
				$request_amount = '&#x20b9;'.$rs->request_amount;
				$nestedData['request_amount'] = $request_amount;
				$nestedData['request_number'] = $rs->request_number;
				$receipt_img='N/A';
				if($rs->fund_payment_receipt!=""){
					$receipt_img='<li><a class="item" href="'.base_url().'uploads/file/'.$rs->fund_payment_receipt.'" data-original-title="" title=""><img class="icons" src="'.base_url().'uploads/file/'.$rs->fund_payment_receipt.'"></a></li>';
				}
				
				$nestedData['receipt_img'] = $receipt_img;
				$nestedData['insert_date'] = $rs->insert_date;
				$nestedData['request_status'] = $rs->request_status;
				$nestedData['fund_request_id'] = $rs->fund_request_id;
				if($rs->request_status==0)
				{
					$nestedData['display_status'] = '<badge class="badge badge-info">Pending</badge>';
				}
				else if($rs->request_status==1)
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
}