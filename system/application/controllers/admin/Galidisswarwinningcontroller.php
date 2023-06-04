<?php

if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Galidisswarwinningcontroller extends MY_AdminController {



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

   
	
	public function galidisswarWinningReport()

	{

		if($this->session->userdata('adminlogin') == 1 && $this->session->userdata('admin_type') == 1)

		{

			$this->data['title'] = "galidisswar Winning Report";

			$this->data['banner_title'] = "galidisswar Winning Report";

			$this->data['active_menu'] = 'galidisswar winning_report';

			$this->data['master_menu'] = 'galidisswar_winning_report';
			$this->data['game_result']=$this->Adminamodel->getData($this->tb44);

			$this->middle = 'galidisswar/h'; 

			$this->layout();

		}else {

			$myurl = base_url() .admin;

			redirect($myurl);

		}

    }

	public function getgalidisswarWinningReport()

	{

		$result_date = trim($this->input->post('result_date'));
		$game_name = $this->input->post('win_game_name');
		$result_date = date('Y-m-d',strtotime($result_date));

		 
		
		$group_by="tx_request_number";
		$joins = array(

						array(

							'table' => $this->tb14,

							'condition' => $this->tb14.'.open_result_token = '.$this->tb45.'.open_result_token',

							'jointype' => 'LEFT'

						),
						array(

								'table' => $this->tb46,

								'condition' => $this->tb46.'.bid_tx_id = '.$this->tb14.'.bid_tx_id',

								'jointype' => 'LEFT'

							),
							array(

							'table' => $this->tb3,

							'condition' => $this->tb3.'.user_id = '.$this->tb46.'.user_id',

							'jointype' => 'LEFT'
	
						),
						

				);
				
		$where = array('result_date' => $result_date,$this->tb46.'.game_id'=>$game_name);

		$columns="user_name,".$this->tb14.".user_id,".$this->tb46.".game_name,".$this->tb46.".session,".$this->tb14.".amount,transaction_note,transaction_note,tx_request_number,".$this->tb14.'.insert_date,pana,digits,closedigits,points,bid_id,'.$this->tb46.'.bid_tx_id';

		$by = 'transaction_id';

		$data['getResultHistory']= $this->Adminamodel->get_joins_where_by($this->tb45,$columns,$joins,$by,$where);


		//echo "<pre>";
		///print_r($data['getResultHistory']);

		echo json_encode($data);

	}
	
	
	public function galidisswarResultHistory()
	{
		if($this->session->userdata('adminlogin') == 1)
		{
			$this->data['title'] = "galidisswar Result History";
			$this->data['banner_title'] = "galidisswar Result History";
			$this->data['banner_title2'] = "galidisswar Result History";
			$this->data['active_menu'] = 'galidisswar_games_management';
			///$this->data['galidisswarResultHistoryListTableFlag'] = 1;
			$this->middle = 'galidisswar/f'; 
			$this->layout();
		}
		else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
    }
	
	public function galidisswarResultHistoryListGridData()
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
		$sql.=" FROM ".$this->tb45." LEFT JOIN ".$this->tb44." b ON b.game_id = ".$this->tb45.".game_id WHERE 1=1";

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
					if($rs->open_decleare_status == 0){
						$nestedData['open_result'] = '<span class="td_color_1">'.$rs->open_number.'<span>';
					}else{
						$nestedData['open_result'] = '<span class="td_color_2">'.$rs->open_number.'<span>';
					}
				}else {
					$nestedData['open_result']= '<span class="sub_s td_color_1">**</span>';
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

	public function galidisswarWinningPrediction()
	{
			$this->data['title'] = "Galidissawar Winning Prediction";
			$this->data['banner_title'] = "Galidissawar Winning Prediction";
			$this->data['game_result']=$this->Adminamodel->getData($this->tb44);
			$this->data['jodi_data']=$this->Adminamodel->getData($this->tb27);
			
			$this->middle = 'admin/a4'; 
			$this->layout();

	}
	public function getGalidissarWinnerList()
	{
		
		$game_id=$this->input->post('win_game_name');
		$open_number=$this->input->post('winning_ank');
		$result_date = date('Y-m-d',strtotime($this->input->post('result_date')));
		
		$game_rates=$this->Adminamodel->getData($this->tb43);
		foreach($game_rates as $rs)
		{
			$single_digit_val_2=$rs->single_digit_val_2;
			$single_pana_val_2=$rs->single_pana_val_2;
			$double_pana_val_2=$rs->double_pana_val_2;
			 
			 
		}
		$where=array($this->tb46.'.game_id'=>$game_id,'pay_status'=>0,'bid_date'=>$result_date);	
				$joins = array(
					array(

						'table' => $this->tb44,
						'condition' => $this->tb44.'.game_id = '.$this->tb46.'.game_id',
						'jointype' => 'LEFT'
						),
						array(

						'table' => $this->tb3,
						'condition' => $this->tb3.'.user_id = '.$this->tb46.'.user_id',
						'jointype' => 'LEFT'
						)

				);
				
		$columns=$this->tb44.".game_name,".$this->tb3.".user_id,pana,digits,closedigits,points,bid_id,bid_tx_id,pay_status,user_name";
		$by = 'bid_id';

		$result= $this->Adminamodel->get_joins_where_by($this->tb46,$columns,$joins,$by,$where);
		$data_array=array();
		$i=0;
		$win_amt_sum = 0;
		$points_amt_sum=0;
		
		foreach($result as $rs)
		{
			    $game_not_name=$rs->game_name;
				$win_number_not=$open_number[0]+$open_number[1];
					
				if($win_number_not>9)
					$win_number_not=$win_number_not%10;
				
				$win_amt=0;
				$points=0;
				
				if($rs->pana=='Left Digit')
				{
					$win_number=$open_number[0];
					
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
				else if($rs->pana=='Right Digit')
				{
					$win_number=$open_number[1];
					
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
				else if($rs->pana=='Jodi Digit')
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

				public function galidisswarResultHistoryListLoadData()	{		$date = $this->input->post('date');				$sql = "SELECT id,b.game_id,result_date,date_format(result_date,'%d %b %Y') as result_date_f,date_format(open_decleare_date,'%d %b %Y %r') as open_decleare_date,b.game_name,open_number,open_decleare_status";		$sql.=" FROM ".$this->tb45." LEFT JOIN ".$this->tb44." b ON b.game_id = ".$this->tb45.".game_id WHERE 1=1";		if($date!=""){			$sql.="&& result_date='".$date."'";		}		$tb_data =  $this->Adminamodel->data_search($sql);				$i=1;		$data = array();		if(!empty($tb_data))		{			$close_res = '';			$game_name = '';			$open_num = '';			$result_open = '';			$result_close = '';			foreach($tb_data as $rs )			{				$nestedData = array();								$nestedData['sn'] = $i;				$game_id = $rs->game_id;								$nestedData['game_name'] = $rs->game_name;				$nestedData['result_date'] = $rs->result_date_f;							if($rs->open_number!=''){						if($rs->open_decleare_status == 0){							$open_result = '<span class="td_color_1">'.$rs->open_number.'<span>';						}else{							$open_result = '<span class="td_color_2">'.$rs->open_number.'<span>';						}				}				else {					$open_result= '<span class="sub_s td_color_1">**</span>';				}								if($rs->open_decleare_date == null){					$open_date = 'N/A';				}else {					$open_date = $rs->open_decleare_date;					$open_result.='<button type="button" class="btn btn-danger waves-light btn-xs ml-1"  onclick="OpenDeleteGalidisswarResultConfirmData('.$rs->game_id.');">Delete</button>';									}				$nestedData['open_result']=$open_result;				$nestedData['open_date'] = $open_date;				$data[] = $nestedData;				$i++;			}		}						echo json_encode($data); 	}

	 
	
	 
	
	

	 
	
	 
	
	
	 
	 
	
 
	
	
	

}

