<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Userquerycontroller extends MY_AdminController {

    public function __construct() {
        parent::__construct();
		if ($this->session->userdata('adminlogin') == 0 )
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
    public function usersQuerys()
	{
		if($this->session->userdata('adminlogin') == 1 && $this->session->userdata('admin_type') == 1)
		{
			$this->data['title'] = "Users Query's";
			$this->data['banner_title'] = "Users Query's";
			$this->data['banner_title2'] = "Users Query List";
			$this->data['active_menu'] = 'users_query';
			$this->data['userQueryListTableFlag'] = 1;
			$this->middle = 'admin/s'; 
			$this->layout();
		}
		else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
    }
	
	public function usersQueryListGridData()
	{
		$columns = array( 
			0 => 'id',
			1 => 'user_name',
			2 => 'mobile',
			3 => 'email',
			4 => 'enquiry',
			5 => 'insert_date',
		);
		
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		
		$sql = "SELECT id,user_name,mobile,email,enquiry,date_format(insert_date,'%d %b %Y %r') as insert_date ";
		$sql.=" FROM ".$this->tb20." WHERE 1=1";
		
		$totalData = $this->Adminamodel->data_search_count($sql);	
		$totalFiltered = $totalData;
		
		if(!empty($this->input->post('search')['value'])){
			$search = $this->input->post('search')['value'];
			$sql.= " AND (user_name LIKE '".$search."%' ";
			$search=$this->volanlib->encryptMob($search);
			$sql.=" OR mobile LIKE '".$search."%' ";
			$sql.=" OR email LIKE '".$search."%' ";
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
				$nestedData['mobile'] =$this->volanlib->decryptMob($rs->mobile);
				$nestedData['email'] = $rs->email;
				$nestedData['query'] = $rs->enquiry;
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

}