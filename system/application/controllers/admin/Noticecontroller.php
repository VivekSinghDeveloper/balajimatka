<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Noticecontroller extends MY_AdminController {

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
    public function noticeManagement()
	{
		if($this->session->userdata('adminlogin') == 1)
		{
			$this->data['title'] = "Notice Managment";
			$this->data['banner_title'] = "Notice Managment";
			$this->data['banner_title2'] = "Notice Managment";
			$this->data['active_menu'] = 'notice_management';
			$this->data['noticeListTableFlag'] = 1;
			$this->middle = 'admin/l'; 
			$this->layout();
		}
		else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
    }
	
	public function addNotice()
	{
		$notice_id = trim($this->input->post('notice_id'));
		$notice_title = trim($this->input->post('notice_title'));
		$description = trim($this->input->post('description'));
		$notice_date = trim($this->input->post('notice_date'));
		
		$noticedata = array(
			'notice_title' => ucwords($notice_title),
			'notice_msg' => $description,
			'notice_date' => date("Y-m-d",strtotime($notice_date)),
			'insert_date'=>$this->insert_date
			);
		
		if($notice_id == '')
		{		
			$this->Adminbmodel->insertData($noticedata,$this->tb12);
			$data['status'] = 'success';
			$data['msg'] = $this->volanlib->success('Notice successfully added');
		}else {
			$where = array('notice_id'=>$notice_id);
			$this->Admincmodel->update_where($this->tb12,$noticedata,$where);
			$data['status'] = 'update';
			$data['msg'] = $this->volanlib->success('Notice updated successfully.');
		}
		echo json_encode($data);
	}
	
	public function editNotice()
	{
		if($this->session->userdata('adminlogin') != 0)
		{
			$notice_id = $this->uri->segment(3);
			$where = array ('notice_id' => $notice_id);
			$result = $this->Adminamodel->get_data($this->tb12,$where);
			foreach($result as $rs)
			{
				$this->data['notice_id'] = $rs->notice_id;
				$this->data['notice_title'] = $rs->notice_title;
				$this->data['notice_msg'] = $rs->notice_msg;
				$this->data['notice_date'] = $rs->notice_date;
			}
			$this->load->view('admin/l1',$this->data);
		}
		else {
			$myurl = base_url() .admin.'/dashboard';
			redirect($myurl);
		}
	}
	
	public function noticeListGridData()
	{
		$columns = array( 
			0 => 'notice_id',
			1 => 'notice_title',
			2 => 'notice_msg',
			3 => 'notice_date',
			4 => 'status',
			5 => 'notice_id'
		);
		
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		
		$sql = "SELECT notice_title,notice_msg,status,date_format(notice_date,'%d %b %Y') as notice_date,notice_id";
		$sql.=" FROM ".$this->tb12." WHERE 1=1";
		
		$totalData = $this->Adminamodel->data_search_count($sql);	
		$totalFiltered = $totalData;
		
		if(!empty($this->input->post('search')['value'])){
			$search = $this->input->post('search')['value'];
			$sql.= " AND (notice_title LIKE '".$search."%' ";
			$sql.=" OR notice_date LIKE '".$search."%' )";
				
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
				$nestedData['notice_title'] = $rs->notice_title;
				$nestedData['content'] = $rs->notice_msg;
				$nestedData['notice_date'] = $rs->notice_date;
				$nestedData['status'] = $rs->status;
				$nestedData['notice_id'] = $rs->notice_id;
				if($rs->status==1)
				{
					$nestedData['display_status'] = '<div id="status_show'.$rs->notice_id.'"><badge class="badge badge-success">Active</badge></div>';
				}
				else
				{
					$nestedData['display_status'] = '<div id="status_show'.$rs->notice_id.'"><badge class="badge badge-danger">Inactive</badge></div>';
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
	public function sendNotification()	
	{		
		if($this->session->userdata('adminlogin') == 1)		
		{			
			$this->data['title'] = "Send Notification";	
			$this->data['banner_title'] = "Send Notification";
			$this->data['banner_title2'] = "Send Notification";		
			$this->data['active_menu'] = 'notice_management';		
			$where = array ('notification_status' => 1);			
			$by='user_name';		
			$result = $this->Adminamodel->get_data_latest_where_asc($this->tb3,$by,$where);	
			$this->data['user_result'] = $result;		
			$this->middle = 'admin/n1'; 		
			$this->layout();		
		}
		else 
		{			
			$myurl = base_url() .admin;			
			redirect($myurl);		
		}    
	}		
	
	public function userSendNotification()	
	{		
		if($this->session->userdata('adminlogin') != 0)		
		{			
			$user_id = $this->input->post('user_id');			
			$notice_title = $this->input->post('notice_title');			
			$notification_content = $this->input->post('notification_content');						
			if($user_id=='all')			
			{				
				$where = array('notification_status' => 1);			
			}			
			else			
			{				
				$where = array ('user_id' => $user_id,'notification_status' => 1);			
			}			
			$result = $this->Adminamodel->get_data($this->tb3,$where);	
			if(count($result)<1)
			{
				$data['status'] = 'error';
				$data['msg'] = $this->volanlib->error('No User found .');
			}
			else
			{				
				$msg='';				
				foreach($result as $rs)			
				{				
					$where = array ('user_id' => $rs->user_id);	
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
						$img = base_url().'assets/img/noti_back.jpg'; 	
						$type_id = '1';	
						$this->volanlib->sendnotification($to, $notice_title, $notification_content, $img, $type_id);
						$data['status'] = 'success';
						$data['msg'] = $this->volanlib->success('Notification successfully send.');
					}				
					else				
					{					
						$data['status'] = 'error';					
						$msg.='<br/>'.'Notification cant send to.'.$rs->user_name;	
						$data['msg'] = $this->volanlib->error($msg);
					}						
				}
			}		
				echo json_encode($data);		
		}	
	}			
}