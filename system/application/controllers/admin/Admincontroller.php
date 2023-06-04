<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admincontroller extends MY_AdminController {

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
    public function subAdminManagement()
	{
		if($this->session->userdata('adminlogin') == 1 && $this->session->userdata('admin_type') == 1)
		{
			$this->data['title'] = "Sub Admin Managment";
			$this->data['banner_title'] = "Sub Admin Managment";
			$this->data['banner_title2'] = "Sub Admin List";
			$this->data['active_menu'] = 'sub_admin_management';
			$this->data['subAdminListTableFlag'] = 1;
			$this->middle = 'admin/x'; 
			$this->layout();
		}
		else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
    }
	
	public function subAdminListGridData()
	{
		$columns = array( 
			0 => 'id',
			1 => 'full_name',
			2 => 'username',
			3 => 'admin_email',
			4 => 'insert_date',
			5 => 'status',
			6 => 'id'
		);
		
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		
		
		$sql = "SELECT id,full_name,username,admin_email,status,date_format(insert_date,'%d %b %Y %r') as insert_date ";
		$sql.=" FROM ".$this->tb2." WHERE 1=1 && id != 1";

		$totalData = $this->Adminamodel->data_search_count($sql);	
		$totalFiltered = $totalData;
		
		if(!empty($this->input->post('search')['value'])){
			$search = $this->input->post('search')['value'];
			$sql.= " AND (username LIKE '".$search."%' ";
			$sql.= " OR  phone LIKE '".$search."%' ";
			$sql.= " OR  admin_email LIKE '".$search."%' ";
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
				$nestedData['full_name'] = $rs->full_name;
				$nestedData['user_name'] = $rs->username;
				$nestedData['email'] = $rs->admin_email;
				$nestedData['insert_date'] = $rs->insert_date;
				$nestedData['status'] = $rs->status;
				$nestedData['user_id'] = $rs->id;
				if($rs->status==1)
				{
					$nestedData['display_status'] = '<div id="status_show'.$rs->id.'"><badge class="badge badge-success">Active</badge></div>';
				}
				else
				{
					$nestedData['display_status'] = '<div id="status_show'.$rs->id.'"><badge class="badge badge-danger">Inactive</badge></div>';
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
	
	public function addSubAdmin()
	{
		$admin_id = trim($this->input->post('admin_id'));
		$sub_admin_name = trim($this->input->post('sub_admin_name'));
		$email = trim($this->input->post('email'));
		$user_name = trim($this->input->post('user_name'));
		$password = trim($this->input->post('password'));
		
		$userdata = array(
			'full_name' => ucwords($sub_admin_name),
			'admin_email' => $email,
			'username' => $user_name,
			'password' => $this->encType($password),
			'admin_type'=>2,
			'insert_date'=>$this->insert_date
			);
		
		$where=array('username' => $user_name);
		$result=$this->Adminamodel->get_data($this->tb2,$where);
		if(count($result)>0)
		{
			$data['status'] = 'error';
			$data['msg'] = $this->volanlib->error('Username is already registered');
		}
		else
		{
			if($admin_id == '')
			{
				$this->Adminbmodel->insertData($userdata,$this->tb2);
				$data['status'] = 'success';
				$data['msg'] = $this->volanlib->success('Sub Admin successfully added');
			}else {
				$where = array('id'=>$admin_id);
				$this->Admincmodel->update_where($this->tb2,$userdata,$where);
				$data['status'] = 'update';
				$data['msg'] = $this->volanlib->success('Sub Admin updated successfully.');
			}
		}
		echo json_encode($data);
	}
}