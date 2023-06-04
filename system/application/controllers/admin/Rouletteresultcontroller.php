<?php

if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Rouletteresultcontroller extends MY_AdminController {



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

	
 
	public function rouletteResultHistory()
	{
		if($this->session->userdata('adminlogin') == 1 && $this->session->userdata('admin_type') == 1)		{
			$this->data['title'] = "Roulette Result History";
			$this->data['banner_title'] = "Roulette Result History";
			$this->data['banner_title2'] = "Roulette Result History";
			$this->data['active_menu'] = 'roulette_result_history';
			$this->data['master_menu'] = 'roulette_management';
			$this->data['rouletteResultHistoryListTableFlag'] = 1;
			$this->middle = 'admin/x1'; 
			$this->layout();
		}
		else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
    }
	
	public function rouletteResultHistoryListGridData()
	{
		$columns = array( 
			0 => 'id',
			1 => 'game_id',
			2 => 'result_date',
			3 => 'declare_date',
			4 => 'number'
		);
		
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		
		$sql = "SELECT id,b.game_id,date_format(result_date,'%d %b %Y') as result_date,date_format(declare_date,'%d %b %Y %r') as declare_date,b.game_name,number";
		$sql.=" FROM ".$this->tb42." LEFT JOIN ".$this->tb40." b ON b.game_id = ".$this->tb42.".game_id WHERE 1=1";
		
		
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
			foreach($tb_data as $rs )
			{
				$nestedData = array();
				
				$nestedData['#'] = $i;
				 
				
				$nestedData['game_name'] = $rs->game_name;
				$nestedData['result_date'] = $rs->result_date;
				if($rs->declare_date == null){
					$open_date = 'N/A';
				}else {
					$open_date = $rs->declare_date;
				}
			 
				$nestedData['game_id'] =  $rs->game_id;
				$nestedData['number'] = $rs->number;
				$nestedData['open_date'] = $open_date;
						 
				 
				
			 
				
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
	
	 

	
	
	
	
	
	
}	
	
	
	
	



