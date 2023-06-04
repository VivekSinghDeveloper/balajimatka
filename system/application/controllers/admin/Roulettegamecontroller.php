<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Roulettegamecontroller extends MY_AdminController {

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
    public function rouletteGameName()
	{		if($this->session->userdata('adminlogin') == 1 && $this->session->userdata('admin_type') == 1)		{
			$this->data['title'] = "Game Name Managment";
			$this->data['banner_title'] = " Game Name Managment";
			$this->data['banner_title2'] = "Game Name List";
			$this->data['active_menu'] = 'game_name';
			$this->data['rouletteGameNameListTableFlag'] = 1;
			$this->middle = 'admin/t1'; 
			$this->layout();		}		else {			$myurl = base_url() .admin;			redirect($myurl);		}
	}
	public function addRouletteGame()
	{
		
		$game_id = $this->uri->segment(3);
			$where = array ('game_id' => $game_id);
			$result = $this->Adminamodel->get_data($this->tb40,$where);
			foreach($result as $rs)
			{
				$this->data['game_id'] = $rs->game_id;
				$this->data['game_name'] = $rs->game_name;
				$this->data['open_time'] =  date('H:i', strtotime($rs->open_time));
				$this->data['close_time'] =  date('H:i', strtotime($rs->close_time));
			}
		$this->load->view("admin/v1",$this->data);
	}
	
	
	public function rouletteGameNameListGridData()
	{
		$columns = array( 
			0 => 'game_id',
			1 => 'game_name',
			2 => 'open_time',
			3 => 'close_time',
			4 => 'status',
			5 => 'market_status',
			6 => 'game_id'
		);
		
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		
		
		$sql = "SELECT game_id,game_name,open_time,status,close_time,market_status";
		$sql.=" FROM ".$this->tb40." WHERE 1=1 ";

		$totalData = $this->Adminamodel->data_search_count($sql);	
		$totalFiltered = $totalData;
		
		if(!empty($this->input->post('search')['value'])){
			$search = $this->input->post('search')['value'];
			$sql.= " AND (game_name LIKE '".$search."%' ";
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
				$nestedData['open_time'] = $rs->open_time;
				$nestedData['close_time'] = $rs->close_time;
				$nestedData['status'] = $rs->status;
				$nestedData['market_status'] = $rs->market_status;
				$nestedData['game_id'] = $rs->game_id;
				if($rs->status==1)
				{
					$nestedData['display_status'] = '<div id="status_show'.$rs->game_id.'"><badge class="badge badge-success">Active</badge></div>';
				}
				else
				{
					$nestedData['display_status'] = '<div id="status_show'.$rs->game_id.'"><badge class="badge badge-danger">Inactive</badge></div>';
				}
				if($rs->market_status==1)
				{
					$nestedData['display_market_status'] = '<div id="status_market'.$rs->game_id.'"><badge class="badge badge-success">Market Open</badge></div>';
				}
				else
				{
					$nestedData['display_market_status'] = '<div id="status_show'.$rs->game_id.'"><badge class="badge badge-danger">Market Close</badge></div>';
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
	
	public function submitRouletteGame()
	{
		$game_id = trim($this->input->post('game_id'));
		$game_name = trim($this->input->post('game_name'));
		$open_time = trim($this->input->post('open_time'));
		$open_time_sort = trim($this->input->post('open_time'));
		$close_time = trim($this->input->post('close_time'));
		$userdata = array(
			'game_name' => ucwords($game_name),
			'open_time' => date('h:i A', strtotime($open_time)),
			'open_time_sort' => date('H:i:s', strtotime($open_time_sort)),
			'close_time' => date('h:i A', strtotime($close_time)),
			);
		if($game_id == '')
		{
			$this->Adminbmodel->insertData($userdata,$this->tb40);
			$data['status'] = 'success';
			$data['msg'] = $this->volanlib->success('Game added successfully ');
		}else {
			$where = array('game_id'=>$game_id);
			$this->Admincmodel->update_where($this->tb40,$userdata,$where);
			$data['status'] = 'update';
			$data['msg'] = $this->volanlib->success('Game updated successfully.');
		}
		echo json_encode($data);
	}
	
	 
		
	}
	
	
	
	
	
    
	
	
	
