<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Starlinebidhistorycontroller extends MY_AdminController {
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
    public function userBidHistory()
	{
		if($this->session->userdata('adminlogin') == 1 && $this->session->userdata('admin_type') == 1)		{
			$this->data['title'] = "Bid History Managment";
			$this->data['banner_title'] = "Bid History Managment";
			$this->data['banner_title2'] = "Bid History";
			$this->data['active_menu'] = 'user_bid_history';
			
			$where=array('status'=>1);
			$this->data['game_result']=$this->Adminamodel->get_data($this->tb35,$where);
			
			$this->middle = 'admin/s1'; 
			$this->layout();
		}
		else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
    }
	
	public function getStarlineBidHistoryData()
	{
		$bid_date = $this->input->post('bid_date');
		$game_name = trim($this->input->post('game_name'));
		$game_type = trim($this->input->post('game_type'));
		
		if($game_type == 1){
			$type = 'Single Digit';
		}else if($game_type == 3){
			$type = 'Single Pana';
		}else if($game_type == 4){
			$type = 'Double Pana';
		}else if($game_type == 5){
			$type = 'Triple Pana';
		}
		
		$bid_date = date('Y-m-d',strtotime($bid_date));
		
		if($game_name == 'All' && $game_type == 10){
			$where = array('bid_date' => $bid_date);
		}else if($game_name == 'All' && $game_type != 10){
			$where = array('bid_date' => $bid_date,'pana' => $type);
		}else if($game_name != 'All' && $game_type == 10){
			$where = array('bid_date' => $bid_date,'game_id' => $game_name);
		}else if($game_name != 'All' && $game_type != 10){
			$where = array('bid_date' => $bid_date,'game_id' => $game_name,'pana' => $type);
		}
		
		$joins = array(
					array(
						'table' => $this->tb3,
						'condition' => $this->tb3.'.user_id = '.$this->tb37.'.user_id',
						'jointype' => 'LEFT'
					)
				);
		$columns="user_name,".$this->tb37.".user_id,game_name,pana,session,digits,closedigits,points,bid_tx_id";
		$by = 'bid_id';
		$data['getBidHistory']= $this->Adminamodel->get_joins_where_by($this->tb37,$columns,$joins,$by,$where);
		
		echo json_encode($data);
	}
	public function exportOptionBidHistoryData()
	{
		$bid_date = $this->input->post('bid_date');
		$game_name = trim($this->input->post('game_name'));
		$game_type = trim($this->input->post('game_type'));
		
		if($game_type == 1){
			$type = 'Single Digit';
		}else if($game_type == 3){
			$type = 'Single Pana';
		}else if($game_type == 4){
			$type = 'Double Pana';
		}else if($game_type == 5){
			$type = 'Triple Pana';
		}
		
		$bid_date = date('Y-m-d',strtotime($bid_date));
		
		if($game_name == 10 && $game_type == 10){
			$where = array('bid_date' => $bid_date);
		}else if($game_name == 10 && $game_type != 10){
			$where = array('bid_date' => $bid_date,'pana' => $type);
		}else if($game_name != 10 && $game_type == 10){
			$where = array('bid_date' => $bid_date,'game_id' => $game_name);
		}else if($game_name != 10 && $game_type != 10){
			$where = array('bid_date' => $bid_date,'game_id' => $game_name,'pana' => $type);
		}
		
		$joins = array(
			array(
				'table' => $this->tb3,
				'condition' => $this->tb3.'.user_id = '.$this->tb37.'.user_id',
				'jointype' => 'LEFT'
			)
		);
		$columns="user_name as User Name,game_name as Game Name,pana,session as Session,digits as Digit,closedigits,points as Points,bid_date as Bid Date";
		$this->excel->setActiveSheetIndex(0);
		$currentTimeinSeconds = time();  
		$currentDate = date('Y-m-d', $currentTimeinSeconds); 
		$name= "Starline_Bid_History_Data_".date("Y-m-d H i s");   
		$result=$this->Adminamodel->get_joins_where($this->tb37,$columns,$joins,$where);
			foreach($result as $rs)
			{
				if($rs->pana=='Single Digit')
				{
					if($rs->Session=='Open')
					{
						$rs->Open_Digit=$rs->Digit;
						$rs->Close_Digit='N/A';
						$rs->Open_Pana='N/A';
						$rs->Close_Pana='N/A';
					}
				}
				
				
				
				if($rs->pana=='Single Pana' || $rs->pana == 'Double Pana' || $rs->pana == 'Triple Pana')
				{
					if($rs->Session=='Open')
					{
						$total_digits = $rs->Digit[0] + $rs->Digit[1] + $rs->Digit[2];
						if($total_digits < 10)
						{
							$digits = $total_digits;
						}
						else if($total_digits > 9)
						{
							$digits = $total_digits%10;
						}
						$rs->Open_Digit= $digits;
						$rs->Close_Digit= 'N/A';
						$rs->Open_Pana= $rs->Digit;
						$rs->Close_Pana= 'N/A';
					}
					
				}
				
				
			unset($rs->Digit);
			unset($rs->closedigits);
			unset($rs->Session);
		}		
		$this->excel->stream($name.'.xls', $result);
	}
}