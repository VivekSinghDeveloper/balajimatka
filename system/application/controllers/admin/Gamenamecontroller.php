<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gamenamecontroller extends MY_AdminController {

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
    public function gameNameManagement()
	{
		if($this->session->userdata('adminlogin') == 1 && $this->session->userdata('admin_type') == 1)
		{
			$this->data['title'] = "Game Name Managment";
			$this->data['banner_title'] = " Game Name Managment";
			$this->data['banner_title2'] = "Game Name List";
			$this->data['active_menu'] = 'game_name';
			$this->data['gameNameListTableFlag'] = 1;
			$this->middle = 'admin/z2'; 
			$this->layout();
		}

		else {

			$myurl = base_url() .admin;

			redirect($myurl);

		}
	}
	
	public function gameNameListGridData()
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
		
		
		$sql = "SELECT ".$this->tb16.".game_id,game_name,game_name_hindi,b.open_time,status,b.close_time,market_status,weekday_status";
	   // $sql.=" FROM ".$this->tb16." LEFT JOIN ".$this->tb48." b ON b.game_id = ".$this->tb16.".game_id WHERE 1=1";
	    $sql.=" FROM ".$this->tb16." LEFT JOIN ".$this->tb48." b ON b.game_id = ".$this->tb16.".game_id && name='".date('l')."' WHERE 1=1";

		$totalData = $this->Adminamodel->data_search_count($sql);	
		$totalFiltered = $totalData;
		
		if(!empty($this->input->post('search')['value'])){
			$search = $this->input->post('search')['value'];
			$sql.= " AND (game_name LIKE '".$search."%' ";
			$sql.= " OR  b.open_time LIKE '".$search."%' ";
			$sql.=" OR b.close_time LIKE '".$search."%' )";
				
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
				$nestedData['close_time'] = $rs->close_time;
				$nestedData['status'] = $rs->status;
				$nestedData['market_status'] = $rs->market_status;
				$nestedData['game_id'] = $rs->game_id;
					$nestedData['weekday_status'] = $rs->weekday_status;
				
				
				
				if($rs->status==1){
					$nestedData['display_status'] = '<a role="button" class="activeDeactive" id="success-'.$rs->game_id.'-tb_games-game_id-status"><span class="badge badge-pill badge-soft-success font-size-12">Yes</span></a>';
				}else{
					$nestedData['display_status'] = '<a role="button" class="activeDeactive"  id="danger-'.$rs->game_id.'-tb_games-game_id-status"><span class="badge badge-pill badge-soft-danger font-size-12">No</span></a>';
				}
				
				
				
				if($rs->weekday_status==1)
				{
					$nestedData['display_market_status'] = '<div id="status_market'.$rs->game_id.'"><span class="badge badge-pill badge-soft-success font-size-12">Open Today</span></div>';
				}
				else
				{
					$nestedData['display_market_status'] = '<div id="status_show'.$rs->game_id.'"><span class="badge badge-pill badge-soft-danger font-size-12">Close Today</span></div>';
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
	
	public function addgame()
	{
		$game_id = trim($this->input->post('game_id'));
		$game_name = trim($this->input->post('game_name'));
		$game_name_hindi = trim($this->input->post('game_name_hindi'));
		$open_time = trim($this->input->post('open_time'));
		$open_time_sort = trim($this->input->post('open_time'));
		$close_time = trim($this->input->post('close_time'));
		$userdata = array(
			'game_name' => ucwords($game_name),
			'game_name_hindi' => $game_name_hindi,
			'open_time' => date('h:i A', strtotime($open_time)),
			
			'open_time_sort' => date('H:i:s', strtotime($open_time_sort)),
			'close_time' => date('h:i A', strtotime($close_time)),
			);
		if($game_id == '')
		{
			$this->Adminbmodel->insertData($userdata,$this->tb16);
			$game_id=$this->db->insert_id();
			$array=array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
			
			for($i=0;$i<7;$i++)
			{
				$game_data = array(
					'game_id' => $game_id,
					'name' => $array[$i],
					'week_name' => strtolower($array[$i]),
					'open_time' => date('h:i A', strtotime($open_time)),
					'open_time_sort' => date('H:i:s', strtotime($open_time_sort)),
					'close_time' => date('h:i A', strtotime($close_time)),
					'weekday_status' => 1,
				);
				
				$this->Adminbmodel->insertData($game_data,$this->tb48);
			}
			
			$data['status'] = 'success';
			$data['msg'] = $this->volanlib->success('Game added successfully ');
		}else {
			$where = array('game_id'=>$game_id);
			$this->Admincmodel->update_where($this->tb16,$userdata,$where);
			$data['status'] = 'update';
			$data['msg'] = $this->volanlib->success('Game updated successfully.');
		}
		echo json_encode($data);
	}
	
	public function editgame()
	{
			
			$game_id = $this->uri->segment(3);
			$where = array ('game_id' => $game_id);
			$result = $this->Adminamodel->get_data($this->tb16,$where);
			foreach($result as $rs)
			{
				$this->data['game_id'] = $rs->game_id;
				$this->data['game_name'] = $rs->game_name;
				$this->data['game_name_hindi'] = $rs->game_name_hindi;
				$this->data['open_time'] =  date('H:i', strtotime($rs->open_time));
				$this->data['close_time'] =  date('H:i', strtotime($rs->close_time));
			}
			$this->load->view('admin/m1',$this->data);
			
	}
	
	public function offdaygame()
	{
			$game_id = $this->uri->segment(3);
			$where = array('game_id'=>$game_id);
			$this->data['result']=$this->Adminamodel->get_data($this->tb48,$where);
			/* echo "<pre>";print_r($result);die;
			foreach($result as $rs)
			{
				$weekday_status=$rs->weekday_status;
				$open_time=$rs->open_time;
				$close_time=$rs->close_time;
			} 
			
			
			$this->data['game_id'] = $game_id;
			$this->data['market_off_day'] = explode(',',$market_off_day);*/
			$this->data['game_id'] = $game_id;
			$this->load->view('admin/m4',$this->data);
			
	}
	public function addoffday()
	{
		$game_id = trim($this->input->post('game_id'));
		$day = $this->input->post('day[]');
		$open_time = $this->input->post('open_time[]');
		$open_time_sort = $this->input->post('open_time[]');
		$close_time = $this->input->post('close_time[]');
		/* echo "<pre>";print_r($open_time);die; */
		/* $market_off_day=implode(',',$day); 
		$userdata = array(
				'market_off_day' => $market_off_day
			);
		$where = array('game_id'=>$game_id);
		$this->Admincmodel->update_where($this->tb16,$userdata,$where); */
		$where = array('game_id'=>$game_id);
		$result = $this->Adminamodel->get_data($this->tb48,$where);
		if(count($result)>0){
			/* for($i=0;$i<count($result);)
			{ */
				$i=0;
				foreach($result as $rs)
				{
					$week_name = $rs->week_name;
					$weekday_id = $rs->weekday_id;
					/* $open_time = date('h:i A', strtotime($open_time[$i]));
					$open_time_sort = date('H:i:s', strtotime($open_time_sort[$i]));
					$close_time = date('h:i A', strtotime($close_time[$i])); */
					$where = array('weekday_id'=>$weekday_id);
					if(in_array($week_name,$day)){
						$weekday_status = 1;
					}else {
						$weekday_status = 0;
					}
					$up_data = array(
						'open_time' => date('h:i A', strtotime($open_time[$i])),
						'open_time_sort' => date('H:i:s', strtotime($open_time_sort[$i])),
						'close_time' => date('h:i A', strtotime($close_time[$i])),
						'weekday_status' => $weekday_status
					);
					$this->Admincmodel->update_where($this->tb48,$up_data,$where);
					$i++;
				}
			/* } */
			$data['status'] = 'success';
			$data['msg'] = $this->volanlib->success('Market Off Day Updated Successfully.');
		}else {
			for($i=0;$i<count($day);$i++)
			{
				$up_data = array(
					'game_id'=>$game_id,
					'name'=>ucwords($day[$i]),
					'week_name'=>$day[$i],
					'open_time' => date('h:i A', strtotime($open_time[$i])),
					'open_time_sort' => date('H:i:s', strtotime($open_time_sort[$i])),
					'close_time' => date('h:i A', strtotime($close_time[$i])),
					'weekday_status'=>1
				);
				$this->Adminbmodel->insertData($up_data,$this->tb48);
			}
			
			$data['status'] = 'success';
			$data['msg'] = $this->volanlib->success('Market Off Day Add Successfully.');
		}
		
		echo json_encode($data);
	}		

}
