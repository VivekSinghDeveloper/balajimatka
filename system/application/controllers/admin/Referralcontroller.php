<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Referralcontroller extends MY_AdminController {
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
	
	public function getReferralAmountData()
	{
		if($this->session->userdata('adminlogin') == 1 && $this->session->userdata('admin_type') == 1)
		{
			$this->data['title'] = "Get Referral Amount report";
			$this->data['banner_title'] = "Get Referral Amount report";
			$this->data['active_menu'] = 'reports';
			
			$this->middle = 'admin/b4'; 
			$this->layout();
		}else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
    }
	
	public function getReferralAmountHistory()
	{
		$check_date = trim($this->input->post('check_date'));
		
		$where = array('DATE('.$this->tb14.'.insert_date)'=>$check_date,'amount_status'=>20);
		
		$joins = array(
				array(
					'table' => $this->tb3.' a',
					'condition' => 'a.user_id = '.$this->tb14.'.user_id',
					'jointype' => 'LEFT'
				),
				array(
					'table' => $this->tb3.' b',
					'condition' => 'b.user_id = '.$this->tb14.'.ref_downliner_id',
					'jointype' => 'LEFT'
				)
			);
		
		$columns = "a.user_name,b.user_name as downliner_name,ref_downliner_id,".$this->tb14.".user_id,amount,amount_added,transaction_note,tx_request_number,txn_id,DATE_FORMAT(".$this->tb14.".insert_date,'%d %b %Y %r') as insert_date";
		
		$by=$this->tb14.'.transaction_id ';
		$result = $this->Adminamodel->get_joins_where_by($this->tb14,$columns,$joins,$by,$where);
		 
		$list_data = '';
		if(count($result)>0)
		{
			$i=1;
			foreach($result as $rs)
			{
				$list_data .= '<tr><td>'.$i.'</td><td><a href='.base_url().admin.'/view-user/'.$rs->user_id.'>'.$rs->user_name.' </a></td><td><a href='.base_url().admin.'/view-user/'.$rs->ref_downliner_id.'>'.$rs->downliner_name.' </a></td><td>'.$rs->amount.'</td><td>'.$rs->amount_added.'</td><td>'.$rs->transaction_note.'</td><td>'.$rs->tx_request_number.'</td><td>'.$rs->tx_request_number.'</td><td>'.$rs->insert_date.'</td></tr>';
				$i++;
			}
		}
		
		$data['list_data'] = $list_data;
		$data['status'] = "success"; 
		echo json_encode($data);
	}
	
}

