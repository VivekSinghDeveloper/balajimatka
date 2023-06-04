<?php
if (!defined('BASEPATH'))	exit('No direct script access allowed');
class Transfercontroller extends MY_AdminController {
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
	public function transferPointReport()
	{
		if($this->session->userdata('adminlogin') == 1 && $this->session->userdata('admin_type') == 1)
		{
			$this->data['title'] = "Transfer Point Report";
			$this->data['banner_title'] = "Transfer Point Report";
			$this->data['active_menu'] = 'Transfer Point Report';
			$this->middle = 'admin/report/c'; 
			$this->layout();
		}else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
    }
	public function getTransferReport()
	{
		$transfer_date = date('Y-m-d',strtotime($this->input->post('transfer_date')));
		$where = array('a.amount_status' => 3,'DATE(a.insert_date)' => $transfer_date);
		$joins = array(
							array(
							'table' => $this->tb3. ' c',
							'condition' =>'c.user_id = a.user_id',
							'jointype' => 'LEFT'
						),
				);
		$columns="c.user_id as sender_user_id,user_name as sender_name,mobile as sender_mobile,a.amount,DATE_FORMAT(a.insert_date,'%d %b %Y %r') as insert_date,tx_request_number";
		$getTransferHistory= $this->Adminamodel->get_joins_where($this->tb14. ' a',$columns,$joins,$where);
		$listData = "";
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
				$columns="user_name as receiver_name,a.user_id as reciver_user_id,mobile as receiver_mobile";
				$getReceiver= $this->Adminamodel->get_joins_where($this->tb14. ' a',$columns,$joins,$wh);
				if(count($getReceiver)>0)
				{
					foreach($getReceiver as $rs1)
					{
						$receiver_name = $rs1->receiver_name;						$reciver_user_id = $rs1->reciver_user_id;						$receiver_mobile = $this->volanlib->decryptMob($rs1->receiver_mobile);
					}
				}
				$sender_mobile=$this->volanlib->decryptMob($rs->sender_mobile);
				$listData .= '<tr><td>'.$i.'</td><td>'.$rs->sender_name.' ( '.$sender_mobile.' ) <a href="'.base_url().admin.'/view-user/'.$rs->sender_user_id.'"><i class="bx bx-link-external"></i></a></td><td>'.$receiver_name.' ( '.$receiver_mobile.' ) <a href="'.base_url().admin.'/view-user/'.$reciver_user_id.'"><i class="bx bx-link-external"></i></a></td><td>'.$rs->amount.'</td><td>'.$rs->insert_date.'</td>
				</tr>';
				$i++;
			}
		}
		$sel = 'sum(amount) as total_amt';
		$get_amt= $this->Adminamodel->get_data_select($this->tb14.' a' ,$where,$sel);
		if(count($get_amt)>0)
		{
			foreach($get_amt as $ga)
			{
				$data['total_amt']  = $ga->total_amt;
			}
		}
		 $data['status'] = 'success';
		$data['listData'] = $listData;
		echo json_encode($data);
	}
}