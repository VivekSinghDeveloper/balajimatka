<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Autodepositecontroller extends MY_AdminController {
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
	
	public function autoDepositeHistory()
	{
		if($this->session->userdata('adminlogin') == 1 && $this->session->userdata('admin_type') == 1)
		{
			$this->data['title'] = "Auto Deposite History";
			$this->data['banner_title'] = "Auto Deposite History";
			$this->data['active_menu'] = 'auto_deposite_hitory';
			
			$this->middle = 'admin/a6'; 
			$this->layout();
		}else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
    }
	
	public function getAutoDepositeHistory()
	{
		$bid_revert_date = trim($this->input->post('bid_revert_date'));
		
		$where = array('DATE('.$this->tb50.'.insert_date)'=>$bid_revert_date);
		
		$joins = array(
				array(
					'table' => $this->tb3,
					'condition' => $this->tb3.'.user_id = '.$this->tb50.'.user_id',
					'jointype' => 'LEFT'
				)
			);
		
		$columns = "user_name,".$this->tb50.".user_id,amount,payment_method,paid_upi,tx_request_number,txn_id,DATE_FORMAT(".$this->tb50.".insert_date,'%d %b %Y %r') as insert_date";
		
		$by=$this->tb50.'.id';
		$withdrawData = $this->Adminamodel->get_joins_where_by($this->tb50,$columns,$joins,$by,$where);
		/* echo "<pre>";print_r($withdrawData);die; */
		$list_data = '';
		if(count($withdrawData)>0)
		{
			$i=1;
			foreach($withdrawData as $rs)
			{
				$list_data .= '<tr><td>'.$i.'</td><td>'.$rs->user_name.' <a href='.base_url().admin.'/view-user/'.$rs->user_id.'><i class="bx bx-link-external"></i></a></td><td>'.$rs->amount.'</td><td>'.$rs->payment_method.'</td><td>'.$rs->paid_upi.'</td><td>'.$rs->tx_request_number.'</td><td>'.$rs->txn_id.'</td><td>'.$rs->insert_date.'</td></tr>';
				$i++;
			}
		}
		
		$data['list_data'] = $list_data;
		$data['status'] = "success"; 
		echo json_encode($data);
	}
	
}

