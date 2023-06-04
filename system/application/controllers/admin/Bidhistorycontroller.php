<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Bidhistorycontroller extends MY_AdminController {
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
			$this->data['active_menu'] = 'user_bid_history';
			
			$where=array('status'=>1);
			$this->data['game_result']=$this->Adminamodel->get_data($this->tb16,$where);
			
			$this->middle = 'admin/q'; 
			$this->layout();
		}
		else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
    }
	
	public function getBidHistoryData()
	{
		$bid_date = $this->input->post('bid_date');
		$game_name = trim($this->input->post('game_name'));
		$game_type = trim($this->input->post('game_type'));
		
		if($game_type == 1){
			$type = 'Single Digit';
		}else if($game_type == 2){
			$type = 'Jodi Digit';
		}else if($game_type == 3){
			$type = 'Single Pana';
		}else if($game_type == 4){
			$type = 'Double Pana';
		}else if($game_type == 5){
			$type = 'Triple Pana';
		}else if($game_type == 6){
			$type = 'Half Sangam';
		}else if($game_type == 7){
			$type = 'Full Sangam';
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
						'condition' => $this->tb3.'.user_id = '.$this->tb18.'.user_id',
						'jointype' => 'LEFT'
					)
				);
		$columns="user_name,".$this->tb18.".user_id,game_name,bid_id,pana,session,digits,closedigits,points,bid_tx_id,pay_status";
		$by = 'bid_id';
		$data['getBidHistory']= $this->Adminamodel->get_joins_where_by($this->tb18,$columns,$joins,$by,$where);
		
		echo json_encode($data);
	}
	public function exportOptionBidHistoryData()
	{
		$bid_date = $this->input->post('bid_date');
		$game_name = trim($this->input->post('game_name'));
		$game_type = trim($this->input->post('game_type'));
		
		if($game_type == 1){
			$type = 'Single Digit';
		}else if($game_type == 2){
			$type = 'Jodi Digit';
		}else if($game_type == 3){
			$type = 'Single Pana';
		}else if($game_type == 4){
			$type = 'Double Pana';
		}else if($game_type == 5){
			$type = 'Triple Pana';
		}else if($game_type == 6){
			$type = 'Half Sangam';
		}else if($game_type == 7){
			$type = 'Full Sangam';
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
				'condition' => $this->tb3.'.user_id = '.$this->tb18.'.user_id',
				'jointype' => 'LEFT'
			)
		);
		$columns="user_name as User Name,game_name as Game Name,pana,session as Session,digits as Digit,closedigits,points as Points,bid_date as Bid Date";
		$this->excel->setActiveSheetIndex(0);
		$currentTimeinSeconds = time();  
		$currentDate = date('Y-m-d', $currentTimeinSeconds); 
		$name= "Bid_History_Data_".date("Y-m-d H i s");   
		$result=$this->Adminamodel->get_joins_where($this->tb18,$columns,$joins,$where);
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
					else
					{
						$rs->Open_Digit='N/A';
						$rs->Close_Digit=$rs->Digit;
						$rs->Open_Pana='N/A';
						$rs->Close_Pana='N/A';
					}
				}
				
				if($rs->pana=='Jodi Digit')
				{
					$rs->Open_digit=$rs->Digit[0];
					$rs->close_digit=$rs->Digit%10;
					$rs->Open_pana='N/A';
					$rs->Close_pana='N/A';
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
					else
					{
						$total_digits = $rs->Digit[0] + $rs->Digit[1] + $rs->Digit[2];
						if($total_digits < 10)
						{
							$digits = $total_digits;
						}else if($total_digits > 9)
						{
							$digits = $total_digits%10;
						}
						$rs->Open_Digit='N/A';
						$rs->Close_Digit= $digits;
						$rs->Open_Pana= 'N/A';
						$rs->Close_Pana= $rs->Digit;
					}
				}
				
				if($rs->pana=='Half Sangam')
				{
					if($rs->Session=='Open')
					{
						$rs->Open_Digit=$rs->Digit;
						$rs->Close_Digit='N/A';
						$rs->Open_Pana='N/A';
						$rs->Close_Pana=$rs->closedigits;
					}
					else
					{
						$rs->Open_Digit='N/A';
						$rs->Close_Digit=$rs->Digit;
						$rs->Open_Pana=$rs->closedigits;
						$rs->Close_Pana='N/A';
					}
				}
				
				if($rs->pana=='Full Sangam')
				{
					$rs->Open_Digit="N/A";
					$rs->Close_Digit="N/A";
					$rs->Open_Pana=$rs->Digit;
					$rs->Close_Pana=$rs->closedigits;
				}
				
			unset($rs->Digit);
			unset($rs->closedigits);
		}		
		$this->excel->stream($name.'.xls', $result);
	}
	
	public function editBidHistory(){
		$bid_id=$this->uri->segment(3);
		$where =array('bid_id'=>$bid_id);
		$result= $this->Adminamodel->get_data($this->tb18,$where);
		
		
		
		foreach($result as $rs){
			if($rs->session=="Open")
			{
			    $this->data['digits']=$rs->digits;
			}else{
				$this->data['digits']=$rs->digits;
			}
			
			if($rs->session==""){
				 $this->data['digits']=$rs->digits;
			}
			 $this->data['closedigits']=$rs->closedigits;
			 $this->data['session']=$rs->session;
			
			
			$this->data['pana']=$rs->pana;
			$this->data['amount']=$rs->points;
			$this->data['bid_id']=$rs->bid_id;
			$this->data['market_status']=$rs->session;
			
			$digits=$rs->digits;
			$closedigits=$rs->closedigits;
			
		}
		
		$result_2=explode(',','000,100,110,111,112,113,114,115,116,117,118,119,120,122,123,124,125,126,127,128,129,130,133,134,135,136,137,138,139,140,144,145,146,147,148,149,150,155,156,157,158,159,160,166,167,168,169,170,177,178,179,180,188,189,190,199,200,220,222,223,224,225,226,227,228,229,230,233,234,235,236,237,238,239,240,244,245,246,247,248,249,250,255,256,257,258,259,260,266,267,268,269,270,277,278,279,280,288,289,290,299,300,330,333,334,335,336,337,338,339,340,344,345,346,347,348,349,350,355,356,357,358,359,360,366,367,368,369,370,377,378,379,380,388,389,390,399,400,440,444,445,446,447,448,449,450,455,456,457,458,459,460,466,467,468,469,470,477,478,479,480,488,489,490,499,500,550,555,556,557,558,559,560,566,567,568,569,570,577,578,579,580,588,589,590,599,600,660,666,667,668,669,670,677,678,679,680,688,689,690,699,700,770,777,778,779,780,788,789,790,799,800,880,888,889,890,899,900,990,999');
		
		
		
		if($this->data['pana']=="Single Digit"){
			$select='id,single_digit as numbers';
			$result=$this->Adminamodel->getDataSelect($this->tb26,$select);
		}
		else if($this->data['pana']=="Full Sangam"){
			$result=$result_2;
			$this->data['result2']=$result_2;
		}
		else if($this->data['pana']=="Jodi Digit"){
			$select='id,jodi_digit as numbers';
			$result=$this->Adminamodel->getDataSelect($this->tb27,$select);
		}
		else if($this->data['pana']=="Double Pana"){
			$result=$this->Adminamodel->getData($this->tb31);
		}
		else if($this->data['pana']=="Half Sangam"){
			
			if($this->data['session']=='Open')
			{
				$this->data['result2']=$result_2;
				$select='id,single_digit as numbers';
				$result=explode(',','0,1,2,3,4,5,6,7,8,9');
			}
			else
			{
				$result=$result_2;
				$select='id,single_digit as numbers';
				$this->data['result2']=explode(',','0,1,2,3,4,5,6,7,8,9');
				
				$this->data['digits']= $digits;
				$this->data['closedigits']=$closedigits;
				
			}
			
			
		}
		else if($this->data['pana']=="Single Pana"){
			$result=$this->Adminamodel->getData($this->tb28);
		}
		else if($this->data['pana']=="Triple Pana"){
			$result=$this->Adminamodel->getData($this->tb29);
		}
//		echo $this->data['closedigits'];die;
		
		$this->data['result']=$result;
		//echo "<pre>";print_r($this->data);die;
		$this->load->view("admin/m3",$this->data); 
		
		
	}
}