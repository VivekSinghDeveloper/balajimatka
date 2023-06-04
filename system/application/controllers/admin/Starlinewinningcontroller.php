<?php

if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Starlinewinningcontroller extends MY_AdminController {



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

   
	
	public function starlineWinningReport()

	{

		if($this->session->userdata('adminlogin') == 1 && $this->session->userdata('admin_type') == 1)		{

			$this->data['title'] = "Starline Winning Report";

			$this->data['banner_title'] = "Starline Winning Report";

			$this->data['active_menu'] = 'Starline winning_report';

			$this->data['master_menu'] = 'starline_winning_report';
			$this->data['game_result']=$this->Adminamodel->getData($this->tb35);

			$this->middle = 'admin/d1'; 

			$this->layout();

		}else {

			$myurl = base_url() .admin;

			redirect($myurl);

		}

    }

	public function getStarlineWinningReport()

	{

		$result_date = trim($this->input->post('result_date'));
		$game_name = $this->input->post('win_game_name');
		$result_date = date('Y-m-d',strtotime($result_date));

		 
		
		$group_by="tx_request_number";
		$joins = array(

						array(

							'table' => $this->tb14,

							'condition' => $this->tb14.'.open_result_token = '.$this->tb36.'.open_result_token',

							'jointype' => 'LEFT'

						),
						array(

								'table' => $this->tb37,

								'condition' => $this->tb37.'.bid_tx_id = '.$this->tb14.'.bid_tx_id',

								'jointype' => 'LEFT'

							),
							array(

							'table' => $this->tb3,

							'condition' => $this->tb3.'.user_id = '.$this->tb37.'.user_id',

							'jointype' => 'LEFT'
	
						),
						

				);
				
		$where = array('result_date' => $result_date,$this->tb37.'.game_id'=>$game_name);

		$columns="user_name,".$this->tb14.".user_id,".$this->tb37.".game_name,".$this->tb37.".session,".$this->tb14.".amount,transaction_note,transaction_note,tx_request_number,".$this->tb14.'.insert_date,pana,digits,closedigits,points,bid_id,'.$this->tb37.'.bid_tx_id';

		$by = 'transaction_id';

		$data['getResultHistory']= $this->Adminamodel->get_joins_where_by($this->tb36,$columns,$joins,$by,$where);


		//echo "<pre>";
		///print_r($data['getResultHistory']);

		echo json_encode($data);

	}
	
	
	public function starlineResultHistory()
	{
		if($this->session->userdata('adminlogin') == 1)
		{
			$this->data['title'] = "Starline Result History";
			$this->data['banner_title'] = "Starline Result History";
			$this->data['banner_title2'] = "Starline Result History";
			$this->data['active_menu'] = 'starline_result_history';
			$this->data['starlineResultHistoryListTableFlag'] = 1;
			$this->middle = 'admin/e1'; 
			$this->layout();
		}
		else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
    }
	
	public function starlineResultHistoryListGridData()
	{
		$columns = array( 
			0 => 'id',
			1 => 'game_id',
			2 => 'result_date',
			3 => 'open_decleare_date',
			4 => 'close_decleare_date',
			5 => 'open_number',
			6 => 'close_number'
		);
		
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		
		$sql = "SELECT id,b.game_id,date_format(result_date,'%d %b %Y') as result_date,date_format(open_decleare_date,'%d %b %Y %r') as open_decleare_date,date_format(close_decleare_date,'%d %b %Y %r') as close_decleare_date,b.game_name,open_number,close_number,open_decleare_status,close_decleare_status";
		$sql.=" FROM ".$this->tb36." LEFT JOIN ".$this->tb35." b ON b.game_id = ".$this->tb36.".game_id WHERE 1=1";

		$totalData = $this->Adminamodel->data_search_count($sql);	
		$totalFiltered = $totalData;
		
		if(!empty($this->input->post('search')['value'])){
			$search = $this->input->post('search')['value'];
			$sql.= " AND (result_date LIKE '".$search."%' ";
			$sql.=" OR b.game_name LIKE '".$search."%' ";
			$sql.=" OR b.game_id LIKE '".$search."%' )";
				
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
			$close_res = '';
			$game_name = '';
			$open_num = '';
			$result_open = '';
			$result_close = '';
			foreach($tb_data as $rs )
			{
				$nestedData = array();
				
				$nestedData['#'] = $i;
				$game_id = $rs->game_id;
				
				$nestedData['game_name'] = $rs->game_name;
				$nestedData['result_date'] = $rs->result_date;
				if($rs->open_decleare_date == null){
					$open_date = 'N/A';
				}else {
					$open_date = $rs->open_decleare_date;
				}
				$nestedData['open_date'] = $open_date;
				if($rs->open_number!=''){
					$open_num=$rs->open_number[0]+$rs->open_number[1]+$rs->open_number[2];
					if($open_num<10){
						if($rs->open_decleare_status == 0){
							$nestedData['open_result'] = '<span class="td_color_1">'.$rs->open_number.'-'.$open_num.'<span>';
						}else{
							$nestedData['open_result'] = '<span class="td_color_2">'.$rs->open_number.'-'.$open_num.'<span>';
						}
					}else if($open_num>9){
						if($rs->open_decleare_status == 0){
							$result_open = $rs->open_number.'-'.$open_num%10;
						$nestedData['open_result'] = '<span class="td_color_1">'.$result_open.'</span>';
						}else{
							$result_open = $rs->open_number.'-'.$open_num%10;
						$nestedData['open_result'] = '<span class="td_color_2">'.$result_open.'</span>';
						}
					}
				}else {
					$nestedData['open_result']= '<span class="sub_s td_color_1">***</span><span class="hyphen">-</span><span class="sub_s td_color_1">*</span>';
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
	
	public function starlineWinningPrediction()
	{
			$this->data['title'] = "Starline Winning Prediction";
			$this->data['banner_title'] = "Starline Winning Prediction";
			$this->data['game_result']=$this->Adminamodel->getData($this->tb35);
			$this->middle = 'admin/a3'; 
			$this->layout();

	}
	public function getStarlineWinnerList()
	{
		
		$game_id=$this->input->post('win_game_name');
		$open_number=$this->input->post('winning_ank');
		$result_date = date('Y-m-d',strtotime($this->input->post('result_date')));
		
			$game_rates=$this->Adminamodel->getData($this->tb34);
		foreach($game_rates as $rs)
		{
			$single_digit_val_2=$rs->single_digit_val_2;
			$single_pana_val_2=$rs->single_pana_val_2;
			$double_pana_val_2=$rs->double_pana_val_2;
			$tripple_pana_val_2=$rs->tripple_pana_val_2;
			 
		}
		$where=array($this->tb37.'.game_id'=>$game_id,'pay_status'=>0,'bid_date'=>$result_date);	
				$joins = array(
					array(

						'table' => $this->tb35,
						'condition' => $this->tb35.'.game_id = '.$this->tb37.'.game_id',
						'jointype' => 'LEFT'
						),
						array(

						'table' => $this->tb3,
						'condition' => $this->tb3.'.user_id = '.$this->tb37.'.user_id',
						'jointype' => 'LEFT'
						)

				);
				
		$columns=$this->tb35.".game_name,".$this->tb3.".user_id,pana,digits,closedigits,points,bid_id,bid_tx_id,pay_status,user_name";
		$by = 'bid_id';

		$result= $this->Adminamodel->get_joins_where_by($this->tb37,$columns,$joins,$by,$where);
		$data_array=array();
		$i=0;
		$win_amt_sum = 0;
		$points_amt_sum=0;
		
		foreach($result as $rs)
		{
			    $game_not_name=$rs->game_name;
				$win_number_not=$open_number[0]+$open_number[1]+$open_number[2];
					
				if($win_number_not>9)
					$win_number_not=$win_number_not%10;
				
				$win_amt=0;
				$points=0;
				
				if($rs->pana=='Single Digit')
				{
					$win_number=$open_number[0]+$open_number[1]+$open_number[2];
					
					if($win_number>9)
					$win_number=$win_number%10;


					if($win_number==$rs->digits)
					{
						$win_amt=($single_digit_val_2/10)*$rs->points;
						
						$points=$rs->points;
						
						$data_array[$i]['points']=$rs->points;
						$data_array[$i]['user_id']=$rs->user_id;
						$data_array[$i]['user_name']=$rs->user_name;
						$data_array[$i]['pana']=$rs->pana;
						$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
						$data_array[$i]['win_amt']=$win_amt;
						
					}
				}
				else if($rs->pana=='Triple Pana')
				{
					if($open_number==$rs->digits)
					{
						$win_amt=($tripple_pana_val_2/10)*$rs->points;
						
						$points=$rs->points;
											
						$data_array[$i]['points']=$rs->points;
						$data_array[$i]['user_id']=$rs->user_id;
						$data_array[$i]['user_name']=$rs->user_name;
						$data_array[$i]['pana']=$rs->pana;
						$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
						$data_array[$i]['win_amt']=$win_amt;
					}
				}
				else if($rs->pana=='Double Pana')
				{
					if($open_number==$rs->digits)
					{
						$win_amt=($double_pana_val_2/10)*$rs->points;
						
						$points=$rs->points;
						
						$data_array[$i]['points']=$rs->points;
						$data_array[$i]['user_id']=$rs->user_id;
						$data_array[$i]['user_name']=$rs->user_name;
						$data_array[$i]['pana']=$rs->pana;
						$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
						$data_array[$i]['win_amt']=$win_amt;
					}
				}
				
				else if($rs->pana=='Single Pana')
				{
					if($open_number==$rs->digits)
					{
						$win_amt=($single_pana_val_2/10)*$rs->points;
						
						$points=$rs->points;
						
						$data_array[$i]['user_id']=$rs->user_id;
						$data_array[$i]['points']=$rs->points;
						$data_array[$i]['user_name']=$rs->user_name;
						$data_array[$i]['pana']=$rs->pana;
						$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
						$data_array[$i]['win_amt']=$win_amt;
					}
				}
				$win_amt_sum=$win_amt+$win_amt_sum;
				$points_amt_sum=$points+$points_amt_sum;
				if($win_amt>0)
				$i++;
				
			}
						
			$data['winner_list'] = $data_array; 
			$data['win_amt_sum'] = $win_amt_sum; 
			$data['points_amt_sum'] = $points_amt_sum; 
			$data['status'] = "success"; 
			
		

		echo json_encode($data);
	}
	
		public function starlineResultHistoryListLoadData()
	{
		$date = $this->input->post('date');
		
		$sql = "SELECT id,b.game_id,result_date,date_format(result_date,'%d %b %Y') as result_date_f,date_format(open_decleare_date,'%d %b %Y %r') as open_decleare_date,b.game_name,open_number,open_decleare_status";
		$sql.=" FROM ".$this->tb36." LEFT JOIN ".$this->tb35." b ON b.game_id = ".$this->tb36.".game_id WHERE 1=1";

		if($date!=""){
			$sql.="&& result_date='".$date."'";
		}
		$tb_data =  $this->Adminamodel->data_search($sql);
		
		$i=1;
		$data = array();
		if(!empty($tb_data))
		{
			$close_res = '';
			$game_name = '';
			$open_num = '';
			$result_open = '';
			$result_close = '';
			foreach($tb_data as $rs )
			{
				$nestedData = array();
				
				$nestedData['sn'] = $i;
				$game_id = $rs->game_id;
				
				$nestedData['game_name'] = $rs->game_name;
				$nestedData['result_date'] = $rs->result_date_f;
			
				if($rs->open_number!=''){
					$open_num=$rs->open_number[0]+$rs->open_number[1]+$rs->open_number[2];
					if($open_num<10){
						if($rs->open_decleare_status == 0){
							$open_result = '<span class="td_color_1">'.$rs->open_number.'-'.$open_num.'<span>';
						}else{
							$open_result = '<span class="td_color_2">'.$rs->open_number.'-'.$open_num.'<span>';
						}
					}else if($open_num>9){
						if($rs->open_decleare_status == 0){
							$result_open = $rs->open_number.'-'.$open_num%10;
						$open_result = '<span class="td_color_1">'.$result_open.'</span>';
						}else{
							$result_open = $rs->open_number.'-'.$open_num%10;
						$open_result = '<span class="td_color_2">'.$result_open.'</span>';
						}
					}
				}else {
					$open_result= '<span class="sub_s td_color_1">***</span><span class="hyphen">-</span><span class="sub_s td_color_1">*</span>';
				}
				
				if($rs->open_decleare_date == null){
					$open_date = 'N/A';
				}else {
					$open_date = $rs->open_decleare_date;
					$open_result.='<button type="button" class="btn btn-danger waves-light btn-xs ml-1"  onclick="OpenDeleteStarlineResultConfirmData('.$rs->game_id.');">Delete</button>';
					
				}
				$nestedData['open_result']=$open_result;
				$nestedData['open_date'] = $open_date;
				$data[] = $nestedData;
				$i++;
			}
		}
		
		
		echo json_encode($data); 
	} 

}

