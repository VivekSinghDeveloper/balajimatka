<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Galidisswarbidhistorycontroller extends MY_AdminController {
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
		if($this->session->userdata('adminlogin') == 1 && $this->session->userdata('admin_type') == 1)
		{
			$this->data['title'] = "Bid History Managment";
			$this->data['banner_title'] = "Bid History Managment";
			$this->data['banner_title2'] = "Bid History";
			$this->data['active_menu'] = 'galidisswar_games_management';
			
			$where=array('status'=>1);
			$this->data['game_result']=$this->Adminamodel->get_data($this->tb44,$where);
			
			$this->middle = 'galidisswar/d'; 
			$this->layout();
		}
		else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
    }
	
	public function getgalidisswarBidHistoryData()
	{
		$bid_date = $this->input->post('bid_date');
		$game_name = trim($this->input->post('game_name'));
		$game_type = trim($this->input->post('game_type'));
		
		if($game_type == 1){
			$type = 'Left Digit';
		}else if($game_type == 2){
			$type = 'Right Digit';
		}else if($game_type == 3){
			$type = 'Jodi Digit';
		}
		
		$bid_date = date('Y-m-d',strtotime($bid_date));
		
		if($game_name == 'all' && $game_type == 'all'){
			$where = array('bid_date' => $bid_date);
		}else if($game_name == 'all' && $game_type != 'all'){
			$where = array('bid_date' => $bid_date,'pana' => $type);
		}else if($game_name != 'all' && $game_type == 'all'){
			$where = array('bid_date' => $bid_date,'game_id' => $game_name);
		}else if($game_name != 'all' && $game_type != 'all'){
			$where = array('bid_date' => $bid_date,'game_id' => $game_name,'pana' => $type);
		}
		
		$joins = array(
					array(
						'table' => $this->tb3,
						'condition' => $this->tb3.'.user_id = '.$this->tb46.'.user_id',
						'jointype' => 'LEFT'
					)
				);
		$columns="user_name,".$this->tb46.".user_id,game_name,pana,session,digits,closedigits,points,bid_tx_id,pay_status,bid_id";
		$by = 'bid_id';
		$data['getBidHistory']= $this->Adminamodel->get_joins_where_by($this->tb46,$columns,$joins,$by,$where);
		
		echo json_encode($data);
	}
	public function exportOptionBidHistoryData()
	{
		$bid_date = $this->input->post('bid_date');
		$game_name = trim($this->input->post('game_name'));
		$game_type = trim($this->input->post('game_type'));
		
		if($game_type == 1){
			$type = 'Left Digit';
		}else if($game_type == 2){
			$type = 'Right Digit';
		}else if($game_type == 3){
			$type = 'Jodi Digit';
		}
		
		$bid_date = date('Y-m-d',strtotime($bid_date));
		
		if($game_name == 'all' && $game_type == 'all'){
			$where = array('bid_date' => $bid_date);
		}else if($game_name == 'all' && $game_type != 'all'){
			$where = array('bid_date' => $bid_date,'pana' => $type);
		}else if($game_name != 'all' && $game_type == 'all'){
			$where = array('bid_date' => $bid_date,'game_id' => $game_name);
		}else if($game_name != 'all' && $game_type != 'all'){
			$where = array('bid_date' => $bid_date,'game_id' => $game_name,'pana' => $type);
		}
		
		$joins = array(
			array(
				'table' => $this->tb3,
				'condition' => $this->tb3.'.user_id = '.$this->tb46.'.user_id',
				'jointype' => 'LEFT'
			)
		);
		$columns="user_name as User Name,game_name as Game Name,pana,digits as Digit,points as Points,bid_date as Bid Date";
		$this->excel->setActiveSheetIndex(0);
		$currentTimeinSeconds = time();  
		$currentDate = date('Y-m-d', $currentTimeinSeconds); 
		$name= "Galidisswar_Bid_History_Data_".date("Y-m-d H i s");   
		$result=$this->Adminamodel->get_joins_where($this->tb46,$columns,$joins,$where);
				
		$this->excel->stream($name.'.xls', $result);
	}
	
	
	public function editgalidisswarBidHistory(){
		$bid_id=$this->uri->segment(3);
		$where =array('bid_id'=>$bid_id);
		$result= $this->Adminamodel->get_data($this->tb46,$where);
		
		
		
		foreach($result as $rs)
		{
			
			 $this->data['digits']=$rs->digits;
			
			
			$this->data['pana']=$rs->pana;
			$this->data['amount']=$rs->points;
			$this->data['bid_id']=$rs->bid_id;
			$this->data['market_status']=$rs->session;
			
			$digits=$rs->digits;
			
		}
		if($this->data['pana']=="Right Digit" or $this->data['pana']=="Left Digit")
		{
			$arry_result=explode(',','0,1,2,3,4,5,6,7,8,9');
		}
		else
		{
			for($i=0;$i<100;$i++)
			{
				 if($i<10)
				 $arry_result[]='0'.$i;
				 else
				 $arry_result[]=$i;
			}
		}
		
		
		$this->data['result']=$arry_result;
		//echo "<pre>";print_r($this->data);die;
		$this->load->view("galidisswar/j",$this->data);
		
		
	}
	
	public function updateGaliDissawarBid(){
		
		$digit=$this->input->post('digits');
		$bid_id=$this->input->post('bid_id');
		$market_status=$this->input->post('market_status');		
				$userdata=array(
						'digits'=>$digit,
					);	
		
		$where=array('bid_id'=>$bid_id);
		$this->Admincmodel->update_where($this->tb46,$userdata,$where);
		$data['status'] = 'update';
		$data['digit'] = $digit;
		$data['msg'] = $this->volanlib->success('Bid updated successfully.');

		echo json_encode($data);


	}
}