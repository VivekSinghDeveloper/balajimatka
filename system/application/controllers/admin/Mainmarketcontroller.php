<?php

if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Mainmarketcontroller extends MY_AdminController {



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

	

	
	public function mainMarket()

	{

		if($this->session->userdata('adminlogin') == 1 && $this->session->userdata('admin_type') == 1)
		{
			$this->data['title'] = "Main Market";

			$this->data['banner_title'] = "Main Market";

			$this->data['active_menu'] = 'Main Market';

			$this->data['master_menu'] = 'Main Market';
			$this->data['bidreportListTableFlag'] = 1;
			
			$this->data['game_result']=$this->Adminamodel->getData($this->tb16);
			$where = array("bid_date" => $this->cur_date);
			$result=$this->Adminamodel->get_data($this->tb18,$where);
			$this->data['bidsingle']=0;
			$this->data['bidjodi']=0;
			$this->data['biddouble']=0;
			$this->data['bidsinglepana']=0;
			$this->data['bidtripple']=0;
			$this->data['bidhalf']=0;
			$this->data['bidfull']=0;
			foreach($result as $rs){
				if($rs->pana=="Single Digit"){
					$this->data['bidsingle']=$this->data['bidsingle']+$rs->points;
					
				}
				else if($rs->pana=="Full Sangam"){
					$this->data['bidfull']=$this->data['bidfull']+$rs->points;
					
				}
				else if($rs->pana=="Jodi Digit"){
					$this->data['bidjodi']=$this->data['bidjodi']+$rs->points;
					
				}
				else if($rs->pana=="Double Pana"){
					$this->data['biddouble']=$this->data['biddouble']+$rs->points;
					
				}
				else if($rs->pana=="Single Pana"){
					$this->data['bidsinglepana']=$this->data['bidsinglepana']+$rs->points;
					
				}
				else if($rs->pana=="Triple Pana"){
					$this->data['bidtripple']=$this->data['bidtripple']+$rs->points;
					
				}
				else if($rs->pana=="Half Sangam"){
					$this->data['bidhalf']=$this->data['bidhalf']+$rs->points;
					
				}
				
			}

			$this->middle = 'admin/y1'; 

			$this->layout();
		}else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
		
    }
	
	/* public function bidAdminListGridData()
	{
		$columns = array( 
			0 => 'bid_id',
			1 => 'user_name',
			2 => 'game_name',
			3 => 'market_status',
			4 => 'Single_Ank',
			5 => 'numbers',
			6 => 'points',
			7 => 'bid_date'
		);
		
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		
		
		$sql = "SELECT bid_id,user_name,game_name,market_status,date_format(bid_date,'%d %b %Y %r') as bid_date ";
		$sql.=" FROM ".$this->tb18."LEFT JOIN ".$this->tb3."
		ON ".$this->tb3.".user_id = ".$this->tb16.".user_id WHERE 1=1";

		$totalData = $this->Adminamodel->data_search_count($sql);	
		$totalFiltered = $totalData;
		
		if(!empty($this->input->post('search')['value'])){
			$search = $this->input->post('search')['value'];
			$sql.= " AND (user_name LIKE '".$search."%' ";
			$sql.= " OR  game_name '".$search."%' ";
			$sql.= " OR  market_status LIKE '".$search."%' ";
			$sql.=" OR Single_Ank LIKE '".$search."%' )";
			$sql.=" OR numbers LIKE '".$search."%' )";
			$sql.=" OR points LIKE '".$search."%' )";
			$sql.=" OR bid_date LIKE '".$search."%' )";
				
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
				$nestedData['game_name'] = $rs->game_name;
				$nestedData['market_status'] = $rs->market_status;
				$nestedData['Single_Ank'] = $rs->Single_Ank;
				$nestedData['numbers'] = $rs->numbers;
				$nestedData['bid_date'] = $rs->bid_date;
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
	
	 */
	public function showDigit(){
		$game_type=$this->input->post('game_type');
		$result="";
		if($game_type=="Single Digit"){
			$select='id,single_digit as numbers';
			$result=$this->Adminamodel->getDataSelect($this->tb26,$select);
		}
		else if($game_type=="Full Sangam"){
			$result=$this->Adminamodel->getData($this->tb32);
		}
		else if($game_type=="Jodi Digit"){
			$select='id,jodi_digit as numbers';
			$result=$this->Adminamodel->getDataSelect($this->tb27,$select);
		}
		else if($game_type=="Double Pana"){
			$result=$this->Adminamodel->getData($this->tb31);
		}
		else if($game_type=="Half Sangam"){
			$result=$this->Adminamodel->getData($this->tb30);
		}
		else if($game_type=="Single Pana"){
			$result=$this->Adminamodel->getData($this->tb28);
		}
		else if($game_type=="Triple Pana"){
			$result=$this->Adminamodel->getData($this->tb29);
		}
		$data['result']="<option value=''>--Select Digit--</option>";
		foreach($result as $rs){
			$data['result'].="<option value=".$rs->numbers.">".$rs->numbers."</option>";
			
		}
		echo json_encode($data); 
	}
	public function mainMarketreport(){
		$start_date=date('y-m-d',strtotime($this->input->post('start_date')));
		$end_date=date('y-m-d',strtotime($this->input->post('end_date')));
		$market_status=$this->input->post('market_status');
		$game_name=$this->input->post('game_name');
		$game_type=$this->input->post('game_type');
		$digit=$this->input->post('digit');
			$joins = array(

					array(

						'table' => $this->tb3,
						'condition' => $this->tb3.'.user_id = '.$this->tb18.'.user_id',
						'jointype' => 'LEFT'
						)
					
				);
				
		$columns="bid_id,game_name,digits,session,closedigits,user_name,pana,bid_date,points";

		 
		 
			if($market_status=='Open'){
			$where=array('bid_date >='=>$start_date,
						'bid_date <='=>$end_date,'game_id'=>$game_name,'pana'=>$game_type,'session'=>$market_status,'digits'=>$digit);
						}
			else{
				$where=array('bid_date >='=>$start_date,
						'bid_date <='=>$end_date,'game_id'=>$game_name,'pana'=>$game_type,'session'=>$market_status,'closedigits'=>$digit);
			
			}
		
		
		$result= $this->Adminamodel->get_joins_where($this->tb18,$columns,$joins,$where);
		$i=1;
		$listdata="";
		if(count($result)>0){
		foreach($result as $rs){
			if($rs->pana=='Single Digit'&& $rs->session=='Open'){
				$single_ank=$rs->digits;
			}
			else if($rs->pana=='Double Pana'||$rs->pana=='Single Pana'||$rs->pana=='Triple Pana'&& $rs->session=='Open'){
				$a=$rs->digits%10;
				$b=intdiv($rs->digits,10);
				$c=$b%10;
				$d=intdiv($rs->digits,100);
				$e=$a+$c+$d;
				$single_ank=$e%10;
			}
			else if($rs->pana=='Single Digit'&& $rs->session=='Close'){
				$single_ank=$rs->closedigits;
			}
			else if($rs->pana=='Double Pana'||$rs->pana=='Half Sangam'||$rs->pana=='Single Pana'||$rs->pana=='Triple Pana'&& $rs->session=='Close'){
				$a=$rs->closedigits%10;
				$b=intdiv($rs->closedigits,10);
				$c=$b%10;
				$d=intdiv($rs->closedigits,100);
				$e=$a+$c+$d;
				$single_ank=$e%10;
			
			}
			
			if($rs->session=="Open"){
				$pana=$rs->digits;
			}
			else{
				$pana=$rs->closedigits;
			}
			$action='<a title="Edit" href="javascript:void(0);" data-href="'.base_url().admin.'/edit-bid/'.$rs->bid_id.'" class="openpopupeditbid"><button  class="btn btn-outline-primary btn-xs m-l-5" type="button"  title="edit">Edit</button></a>';
			
			$listdata.="<tr><td>".$i."</td><td>".$rs->user_name."</td><td>".$rs->game_name."</td><td>".$rs->pana."</td><td>".$single_ank."</td><td>".$pana."</td><td>".$rs->points."</td><td>".$rs->bid_date."</td><td>".$action."</td></tr>";
			$i++;
		}
		}
		$data['listdata']=$listdata;
		echo json_encode($data);
	}
	
	/* public function editBid(){
		$bid_id=$this->uri->segment(3);
		$where =array('bid_id'=>$bid_id);
		$result= $this->Adminamodel->get_data($this->tb18,$where);
		foreach($result as $rs){
			if($rs->session=="Open"){
			$this->data['digits']=$rs->digits;
			}else{
				$this->data['digits']=$rs->closedigits;
			}
			$this->data['pana']=$rs->pana;
			$this->data['amount']=$rs->points;
			$this->data['bid_id']=$rs->bid_id;
			$this->data['market_status']=$rs->session;
		}
		if($this->data['pana']=="Single Digit"){
			$select='id,single_digit as numbers';
			$result=$this->Adminamodel->getDataSelect($this->tb26,$select);
		}
		else if($this->data['pana']=="Full Sangam"){
			$result=$this->Adminamodel->getData($this->tb32);
		}
		else if($this->data['pana']=="Jodi Digit"){
			$select='id,jodi_digit as numbers';
			$result=$this->Adminamodel->getDataSelect($this->tb27,$select);
		}
		else if($this->data['pana']=="Double Pana"){
			$result=$this->Adminamodel->getData($this->tb31);
		}
		else if($this->data['pana']=="Half Sangam"){
			$result=$this->Adminamodel->getData($this->tb30);
		}
		else if($this->data['pana']=="Single Pana"){
			$result=$this->Adminamodel->getData($this->tb28);
		}
		else if($this->data['pana']=="Triple Pana"){
			$result=$this->Adminamodel->getData($this->tb29);
		}
		$this->data['result']=$result;
		
		$this->load->view("admin/m2",$this->data); 
		
		
	} */
	
	public function updateBid(){
		
		$digit=$this->input->post('digit');
		$bid_id=$this->input->post('bid_id');
		$market_status=$this->input->post('market_status');		$pana=$this->input->post('pana');		$closedigits=$this->input->post('closedigits');				if($pana=='Single Digit' or $pana=='Single Pana' or $pana=='Double Pana' or $pana=='Triple Pana')		{
				$userdata=array(
						'digits'=>$digit,
					);		}				if($pana=='Jodi Digit')		{			$userdata=array(			'digits'=>$digit,			);			}				if($pana=='Full Sangam' or $pana=='Half Sangam')		{			$userdata=array(			'digits'=>$digit,			'closedigits'=>$closedigits,			);			}
		
		$where=array('bid_id'=>$bid_id);
		$this->Admincmodel->update_where($this->tb18,$userdata,$where);
		$data['status'] = 'update';
		$data['digit'] = $digit;
		$data['msg'] = $this->volanlib->success('Bid updated successfully.');

		echo json_encode($data);


	}
}

