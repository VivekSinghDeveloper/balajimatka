<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Acontroller extends MY_Controller {

	public function __construct() {
        parent::__construct();
		$this->load->helper('url');
	}
	
	public function gameResultDetailsChart()
	{
		$select = 'game_id,game_name,open_time_sort';
		$by = 'open_time_sort';
		$order_type = 'asc';
		$where = array('status'=>1);
		$this->data['games'] = $this->Frontamodel->getDataSelectByWhere($this->tb35,$select,$by,$order_type,$where);
		$this->data['totalGames'] = count($this->Frontamodel->getDataSelectByWhere($this->tb35,$select,$by,$order_type,$where));
		
		$group_by = 'result_date';
		$select = 'id,'.$this->tb36.'.game_id,result_date,GROUP_CONCAT(open_number ORDER BY open_time_sort ASC  SEPARATOR ",") as open_number,GROUP_CONCAT('.$this->tb36.'.game_id ORDER BY open_time_sort ASC  SEPARATOR ",") as game_id_main';
		$by = 'open_time_sort';
		$joins = array(
				array(
					'table' => $this->tb35,
					'condition' => $this->tb35.'.game_id = '.$this->tb36.'.game_id',
					'jointype' => 'LEFT'
				)
			);
		$where = array();
		$this->data['gamesResult'] = $this->Frontamodel->get_joins_group_by_asc($this->tb36,$select,$joins,$by,$group_by,$where);
		$this->load->view('front/g',$this->data);
	}
	
	
	public function gameResultChart()
	{
		$this->data['title']="Kalyan Super Matka";
		$this->data['meta_description']='<meta name="keywords" content="" />
        <meta name="description" content="" />';
		$this->data['banner_title']="Game Result Chart";
		
		$game_id = $this->uri->segment(2);
		$where = array ($this->tb21.'.game_id' => $game_id);
		
		$joins = array(
			array(
				'table' => $this->tb16,
				'condition' => $this->tb16.'.game_id = '.$this->tb21.'.game_id',
				'jointype' => 'LEFT'
			)
		);
		$columns = ''.$this->tb21.'.game_id,game_name,result_date,game_name,open_number,close_number,
		open_decleare_status as open_status,close_decleare_status as close_status';
		$by='id';
		$result = $this->Frontamodel->get_joins_where_asc($this->tb21,$columns,$joins,$where,$by);
		foreach($result as $rs)
		{
			$this->data['game_name'] = $rs->game_name;
		}
		$this->data['flag']=1;
		$this->data['result'] = $result;
		/* $this->middle = 'front/c'; 
		$this->frontLayout(); */
		$this->load->view('front/c',$this->data);
	}
	
		public function galidisswarResultDetailsChart()
	{
		$select = 'game_id,game_name,open_time_sort';
		$by = 'open_time_sort';
		$order_type = 'asc';
		$where = array('status'=>1);
		$this->data['games'] = $this->Frontamodel->getDataSelectByWhere($this->tb44,$select,$by,$order_type,$where);
		$this->data['totalGames'] = count($this->Frontamodel->getDataSelectByWhere($this->tb44,$select,$by,$order_type,$where));
		$group_by = 'result_date';
		$select = 'id,'.$this->tb45.'.game_id,result_date,GROUP_CONCAT(open_number ORDER BY open_time_sort ASC  SEPARATOR ",") as open_number,GROUP_CONCAT('.$this->tb45.'.game_id ORDER BY open_time_sort ASC  SEPARATOR ",") as game_id_main';
		$by = 'open_time_sort';
		$joins = array(
				array(
					'table' => $this->tb44,
					'condition' => $this->tb44.'.game_id = '.$this->tb45.'.game_id',
					'jointype' => 'LEFT'
				)
			);
		$where = array();
		$this->data['gamesResult'] = $this->Frontamodel->get_joins_group_by_asc($this->tb45,$select,$joins,$by,$group_by,$where);
		$this->load->view('front/h',$this->data);
	}

	
	public function viewtable()
	{
		
		if($this->session->userdata('adminlogin') == 1)
		{
		$by = 'user_id';
		$where_array = "1=1";
		$by="user_id";
		$select = "user_name,mobile";
		$result['userdata'] = $this->Frontamodel->get_data_latest_where_desc($this->tb3,$where_array,$by,$select);
		$this->load->view('admin/export',$result);
		}
		else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
	}
	
	public function exportCSV()
	{
		
		if($this->session->userdata('adminlogin') == 1)
		{
		$file_name = 'user_details_on_'.date('d-M-Y').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$file_name"); 
		header("Content-Type: application/csv;");

		$where_array = "1=1";
		$by="user_id";
		$select = "user_name,mobile";
		$result= $this->Frontamodel->get_data_latest_where_desc($this->tb3,$where_array,$by,$select);

		$file = fopen('php://output', 'w');
		$header = array("Username","Mobile");

		fputcsv($file, $header);
		foreach ($result as $rs)
		{
			$value['Username'] = $rs->user_name;
			$value['Mobile']= $this->volanlib->decryptMob($rs->mobile);
			fputcsv($file,(array)$value);
		}
			fclose($file); 
			exit; 
			
		}
		else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
	}

}