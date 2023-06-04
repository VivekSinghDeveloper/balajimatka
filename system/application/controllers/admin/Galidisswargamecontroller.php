<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Galidisswargamecontroller extends MY_AdminController {

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
	
    public function GalidisswarGameNameManagement()
	{		if($this->session->userdata('adminlogin') == 1 && $this->session->userdata('admin_type') == 1)		{
			$this->data['title'] = "Galidisswar Game Name Managment";
			$this->data['banner_title'] = "Galidisswar Game Name Managment";
			$this->data['banner_title2'] = "Galidisswar Game Name List";
			$this->data['active_menu'] = 'galidisswar_games_management';
			$this->data['galidisswarGameNameListTableFlag'] = 1;
			$this->middle = 'galidisswar/a'; 
			$this->layout();		}		else {			$myurl = base_url() .admin;			redirect($myurl);		}
	}
	
	public function galidisswarGameNameListGridData()
	{
		$columns = array( 
			0 => 'game_id',
			1 => 'game_name',
			2 => 'game_name_hindi',
			3 => 'open_time',
			4 => 'close_time',
			5 => 'status',
			6 => 'market_status',
			7 => 'game_id'
		);
		
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		
		
		$sql = "SELECT game_id,game_name,game_name_hindi,open_time,status,close_time,market_status";
		$sql.=" FROM ".$this->tb44." WHERE 1=1 ";

		$totalData = $this->Adminamodel->data_search_count($sql);	
		$totalFiltered = $totalData;
		
		if(!empty($this->input->post('search')['value'])){
			$search = $this->input->post('search')['value'];
			$sql.= " AND (game_name LIKE '".$search."%' ";
			$sql.= " OR  game_name_hindi LIKE '".$search."%' ";
			$sql.= " OR  open_time LIKE '".$search."%' ";
			$sql.= " OR  market_status LIKE '".$search."%' ";
			$sql.=" OR close_time LIKE '".$search."%' )";
				
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
				$nestedData['game_name'] = $rs->game_name;
				$nestedData['game_name_hindi'] = $rs->game_name_hindi;
				$nestedData['open_time'] = $rs->open_time;
				//$nestedData['close_time'] = $rs->close_time;
				$nestedData['status'] = $rs->status;
				$nestedData['market_status'] = $rs->market_status;
				$nestedData['game_id'] = $rs->game_id;
			/*	if($rs->status==1)
				{
					$nestedData['display_status'] = '<div id="status_show'.$rs->game_id.'"><badge class="badge badge-success">Active</badge></div>';
				}
				else
				{
					$nestedData['display_status'] = '<div id="status_show'.$rs->game_id.'"><badge class="badge badge-danger">Inactive</badge></div>';
				}*/
				
				if($rs->status==1){
					$nestedData['display_status'] = '<a role="button" class="activeDeactive" id="success-'.$rs->game_id.'-tb_gali_disswar_games-game_id-status"><span class="badge badge-pill badge-soft-success font-size-12">Yes</span></a>';
				}else{
					$nestedData['display_status'] = '<a role="button" class="activeDeactive"  id="danger-'.$rs->game_id.'-tb_gali_disswar_games-game_id-status"><span class="badge badge-pill badge-soft-danger font-size-12">No</span></a>';
				}
				
				/*
				if($rs->market_status==1)
				{
					$nestedData['display_market_status'] = '<div id="status_market'.$rs->game_id.'"><badge class="badge badge-success">Market Open</badge></div>';
				}
				else
				{
					$nestedData['display_market_status'] = '<div id="status_show'.$rs->game_id.'"><badge class="badge badge-danger">Market Close</badge></div>';
				}*/
				
				if($rs->market_status==1)
				{
					$nestedData['display_market_status'] = '<div id="status_market'.$rs->game_id.'"><span class="badge badge-pill badge-soft-success font-size-12">Market Open</span></div>';
				}
				else
				{
					$nestedData['display_market_status'] = '<div id="status_show'.$rs->game_id.'"><span class="badge badge-pill badge-soft-danger font-size-12">Market Close</span></div>';
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
	
	public function addGalidisswarGame()
	{
		$game_id = trim($this->input->post('game_id'));
		$game_name = trim($this->input->post('game_name'));
		$game_name_hindi = trim($this->input->post('game_name_hindi'));
		$open_time = trim($this->input->post('open_time'));
		$open_time_sort = trim($this->input->post('open_time'));
		//$close_time = trim($this->input->post('close_time'));
		$userdata = array(
			'game_name' => ucwords($game_name),
			'game_name_hindi' => $game_name_hindi,
			'open_time' => date('h:i A', strtotime($open_time)),
			
			'open_time_sort' => date('H:i:s', strtotime($open_time_sort)),
			//'close_time' => date('h:i A', strtotime($close_time)),
			);
		if($game_id == '')
		{
			$this->Adminbmodel->insertData($userdata,$this->tb44);
			$data['status'] = 'success';
			$data['msg'] = $this->volanlib->success('Game added successfully ');
		}else {
			$where = array('game_id'=>$game_id);
			$this->Admincmodel->update_where($this->tb44,$userdata,$where);
			$data['status'] = 'update';
			$data['msg'] = $this->volanlib->success('Game updated successfully.');
		}
		echo json_encode($data);
	}
	
	public function editgame()
	{
			
			$game_id = $this->uri->segment(3);
			$where = array ('game_id' => $game_id);
			$result = $this->Adminamodel->get_data($this->tb44,$where);
			foreach($result as $rs)
			{
				$this->data['game_id'] = $rs->game_id;
				$this->data['game_name'] = $rs->game_name;
				$this->data['game_name_hindi'] = $rs->game_name_hindi;
				$this->data['open_time'] =  date('H:i', strtotime($rs->open_time));
				///$this->data['close_time'] =  date('H:i', strtotime($rs->close_time));
			}
			$this->load->view('galidisswar/b',$this->data);
			
	}
	
	
	public function galidisswarGameRatesManagement()
	{
		if($this->session->userdata('adminlogin') == 1)
		{
			$this->data['title'] = "galidisswar Game Rates Managment";
			$this->data['banner_title'] = "galidisswar Game Rates Management";
			$this->data['active_menu'] = 'galidisswar_game_rates';
			$this->data['master_menu'] = 'galidisswar_games_management';
			
			$game_rates = $this->Adminamodel->getData($this->tb43);
			if(count($game_rates)>0)
			{
				foreach($game_rates as $rs)
				{
					$this->data['game_rate_id']=$rs->game_rate_id;
					$this->data['single_digit_val_1']=$rs->single_digit_val_1;
					$this->data['single_digit_val_2']=$rs->single_digit_val_2;

					$this->data['single_pana_val_1']=$rs->single_pana_val_1;
					$this->data['single_pana_val_2']=$rs->single_pana_val_2;
					$this->data['double_pana_val_1']=$rs->double_pana_val_1;
					$this->data['double_pana_val_2']=$rs->double_pana_val_2;
					
				}
			}
			
			$this->middle = 'galidisswar/c'; 
			$this->layout();
		}else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
    }
	
	
	public function addgalidisswarGameRates()
	{
		$game_rate_id = trim($this->input->post('game_rate_id'));
		$single_digit_1 = trim($this->input->post('single_digit_1'));
		$single_digit_2 = trim($this->input->post('single_digit_2'));
		$single_pana_1 = trim($this->input->post('single_pana_1'));
		$single_pana_2 = trim($this->input->post('single_pana_2'));
		$double_pana_1 = trim($this->input->post('double_pana_1'));
		$double_pana_2 = trim($this->input->post('double_pana_2'));
		
		$gamesRatesData = array(
			'single_digit_val_1' => $single_digit_1,
			'single_digit_val_2' => $single_digit_2,
			'single_pana_val_1'=>$single_pana_1,
			'single_pana_val_2'=>$single_pana_2,
			'double_pana_val_1'=>$double_pana_1,
			'double_pana_val_2'=>$double_pana_2,
			'insert_date'=>$this->insert_date
			);
		
		if($game_rate_id == ''){
			$this->Adminbmodel->insertData($gamesRatesData,$this->tb43);
			$data['status'] = 'success';
			$data['msg'] = $this->volanlib->success('Game Rates Successfully Added.');
		}else{
			$where = array('game_rate_id' => $game_rate_id);
			$this->Admincmodel->update_where($this->tb43,$gamesRatesData,$where);
			$data['status'] = 'update';
			$data['msg'] = $this->volanlib->success('Game Rates Successfully Updated.');
		}
		echo json_encode($data);
	}
		
	public function galidisawarOffdayGame()
	{
	    $game_id = $this->uri->segment(3);
		$where = array('game_id'=>$game_id);
		$result=$this->Adminamodel->get_data($this->tb44,$where);

		foreach($result as $rs)
		{
			$market_off_day=$rs->market_off_day;
		}
		
		
		$this->data['game_id'] = $game_id;
		$this->data['market_off_day'] = explode(',',$market_off_day);
			
		$this->load->view('galidisswar/i',$this->data);
	}
}
	
	
	
	
	
    
	
	
	
