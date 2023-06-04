<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Roulettegamebidcontroller extends MY_AdminController {
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
    public function rouletteBidHistory()
	{
		if($this->session->userdata('adminlogin') == 1 && $this->session->userdata('admin_type') == 1)		{
			$this->data['title'] = "Bid History Managment";
			$this->data['banner_title'] = "Bid History Managment";
			$this->data['banner_title2'] = "Bid History";
			$this->data['active_menu'] = 'roulette_bid_history';
			
			$where=array('status'=>1);
			$this->data['game_result']=$this->Adminamodel->get_data($this->tb40,$where);
			
			$this->middle = 'admin/w1'; 
			$this->layout();
		}
		else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
    }
	
	public function getRouletteBidHistoryData()
	{
		$bid_date = $this->input->post('bid_date');
		$game_name = trim($this->input->post('game_name'));
	
		$bid_date = date('Y-m-d',strtotime($bid_date));
		
		 if($game_name == "0")
		 {
			$where = array('bid_date' => $bid_date);
		 }
		 else
		 {
			 $where = array('bid_date' => $bid_date,'game_id' => $game_name);
		 }
		
		$joins = array(
					array(
						'table' => $this->tb3,
						'condition' => $this->tb3.'.user_id = '.$this->tb41.'.user_id',
						'jointype' => 'LEFT'
					)
				);
		$columns="user_name,".$this->tb41.".user_id,game_name,digits,points,bid_tx_id";
		$by = 'bid_id';
		$data['getBidHistory']= $this->Adminamodel->get_joins_where_by($this->tb41,$columns,$joins,$by,$where);
		
		
		
	
		
		echo json_encode($data);
	}
	public function exportOptionBidHistoryData()
	{
		$bid_date = $this->input->post('bid_date');
		$game_name = trim($this->input->post('game_name'));

		$bid_date = date('Y-m-d',strtotime($bid_date));
		 
		 if($game_name=="0")
		 {
			$where = array('bid_date' => $bid_date);
		 }
		 else
		 {
			 $where = array('bid_date' => $bid_date,'game_id' => $game_name);
		 }
		
		$joins = array(
			array(
				'table' => $this->tb3,
				'condition' => $this->tb3.'.user_id = '.$this->tb41.'.user_id',
				'jointype' => 'LEFT'
			)
		);
		$columns="user_name as User Name,game_name as Game Name,digits as Digit,points as Points,bid_date as Bid Date";
		$this->excel->setActiveSheetIndex(0);
		$currentTimeinSeconds = time();  
		$currentDate = date('Y-m-d', $currentTimeinSeconds); 
		$name= "Roulette_Bid_History_Data_".date("Y-m-d H i s");   
		$result=$this->Adminamodel->get_joins_where($this->tb41,$columns,$joins,$where);	
		$this->excel->stream($name.'.xls', $result);
	}
}