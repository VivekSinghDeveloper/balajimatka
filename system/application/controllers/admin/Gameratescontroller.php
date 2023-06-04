<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gameratescontroller extends MY_AdminController {

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
    public function gameRatesManagement()
	{
		if($this->session->userdata('adminlogin') == 1 && $this->session->userdata('admin_type') == 1)
		{
			$this->data['title'] = "Game Rates Managment";
			$this->data['banner_title'] = "Game Rates Management";
			$this->data['active_menu'] = 'game_rates';
			$this->data['master_menu'] = 'games_management';
			
			$game_rates = $this->Adminamodel->getData($this->tb10);
			if(count($game_rates)>0)
			{
				foreach($game_rates as $rs)
				{
					$this->data['game_rate_id']=$rs->game_rate_id;
					$this->data['single_digit_val_1']=$rs->single_digit_val_1;
					$this->data['single_digit_val_2']=$rs->single_digit_val_2;
					$this->data['jodi_digit_val_1']=$rs->jodi_digit_val_1;
					$this->data['jodi_digit_val_2']=$rs->jodi_digit_val_2;
					$this->data['single_pana_val_1']=$rs->single_pana_val_1;
					$this->data['single_pana_val_2']=$rs->single_pana_val_2;
					$this->data['double_pana_val_1']=$rs->double_pana_val_1;
					$this->data['double_pana_val_2']=$rs->double_pana_val_2;
					$this->data['tripple_pana_val_1']=$rs->tripple_pana_val_1;
					$this->data['tripple_pana_val_2']=$rs->tripple_pana_val_2;
					$this->data['half_sangam_val_1']=$rs->half_sangam_val_1;
					$this->data['half_sangam_val_2']=$rs->half_sangam_val_2;
					$this->data['full_sangam_val_1']=$rs->full_sangam_val_1;
					$this->data['full_sangam_val_2']=$rs->full_sangam_val_2;
				}
			}
			
			$this->middle = 'admin/h'; 
			$this->layout();
		}else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
    }
	
	
	public function addGameRates()
	{
		$game_rate_id = trim($this->input->post('game_rate_id'));
		$single_digit_1 = trim($this->input->post('single_digit_1'));
		$single_digit_2 = trim($this->input->post('single_digit_2'));
		$jodi_digit_1 = trim($this->input->post('jodi_digit_1'));
		$jodi_digit_2 = trim($this->input->post('jodi_digit_2'));
		$single_pana_1 = trim($this->input->post('single_pana_1'));
		$single_pana_2 = trim($this->input->post('single_pana_2'));
		$double_pana_1 = trim($this->input->post('double_pana_1'));
		$double_pana_2 = trim($this->input->post('double_pana_2'));
		$tripple_pana_1 = trim($this->input->post('tripple_pana_1'));
		$tripple_pana_2 = trim($this->input->post('tripple_pana_2'));
		$half_sangam_1 = trim($this->input->post('half_sangam_1'));
		$half_sangam_2 = trim($this->input->post('half_sangam_2'));
		$full_sangam_1 = trim($this->input->post('full_sangam_1'));
		$full_sangam_2 = trim($this->input->post('full_sangam_2'));
		
		$gamesRatesData = array(
			'single_digit_val_1' => $single_digit_1,
			'single_digit_val_2' => $single_digit_2,
			'jodi_digit_val_1' => $jodi_digit_1,
			'jodi_digit_val_2'=>$jodi_digit_2,
			'single_pana_val_1'=>$single_pana_1,
			'single_pana_val_2'=>$single_pana_2,
			'double_pana_val_1'=>$double_pana_1,
			'double_pana_val_2'=>$double_pana_2,
			'tripple_pana_val_1'=>$tripple_pana_1,
			'tripple_pana_val_2'=>$tripple_pana_2,
			'half_sangam_val_1'=>$half_sangam_1,
			'half_sangam_val_2'=>$half_sangam_2,
			'full_sangam_val_1'=>$full_sangam_1,
			'full_sangam_val_2'=>$full_sangam_2,
			'insert_date'=>$this->insert_date
			);
		
		if($game_rate_id == ''){
			$this->Adminbmodel->insertData($gamesRatesData,$this->tb10);
			$data['status'] = 'success';
			$data['msg'] = $this->volanlib->success('Game Rates Successfully Added.');
		}else{
			$where = array('game_rate_id' => $game_rate_id);
			$this->Admincmodel->update_where($this->tb10,$gamesRatesData,$where);
			$data['status'] = 'update';
			$data['msg'] = $this->volanlib->success('Game Rates Successfully Updated.');
		}
		echo json_encode($data);
	}

	public function gamesTimeManagement()
	{
		if($this->session->userdata('adminlogin') == 1)
		{
			$this->data['title'] = "Games Time Managment";
			$this->data['banner_title'] = "Games Time Management";
			$this->data['active_menu'] = 'games_time_management';
			$this->data['master_menu'] = 'games_management';
			
			$where=array('status'=>1);
			$this->data['game_result']=$this->Adminamodel->get_data($this->tb16,$where);
			
			$this->middle = 'admin/n'; 
			$this->layout();
		}else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
	}
	
	public function addGamesTime()
	{
		$games_time_id=$this->input->post('games_time_id');
		$seridevi_open_time=$this->input->post('seridevi_open_time');
		$seridevi_close_time=$this->input->post('seridevi_close_time');
		$madhur_m_open_time=$this->input->post('madhur_m_open_time');
		$madhur_m_close_time=$this->input->post('madhur_m_close_time');
		$gold_d_open_time=$this->input->post('gold_d_open_time');
		$gold_d_close_time=$this->input->post('gold_d_close_time');
		$madhur_d_open_time=$this->input->post('madhur_d_open_time');
		$madhur_d_close_time=$this->input->post('madhur_d_close_time');
		$super_milan_open=$this->input->post('super_milan_open');
		$super_milan_close=$this->input->post('super_milan_close');
		$rajdhani_d_open=$this->input->post('rajdhani_d_open');
		$rajdhani_d_close=$this->input->post('rajdhani_d_close');
		$supreme_d_open=$this->input->post('supreme_d_open');
		$supreme_d_close=$this->input->post('supreme_d_close');
		$sridevi_night_open=$this->input->post('sridevi_night_open');
		$sridevi_night_close=$this->input->post('sridevi_night_close');
		$gold_night_open=$this->input->post('gold_night_open');
		$gold_night_close=$this->input->post('gold_night_close');
		$madhure_night_open=$this->input->post('madhure_night_open');
		$madhure_night_close=$this->input->post('madhure_night_close');
		$supreme_night_open=$this->input->post('supreme_night_open');
		$supreme_night_close=$this->input->post('supreme_night_close');
		$rajhdhani_night_open=$this->input->post('rajhdhani_night_open');
		$rajhdhani_night_close=$this->input->post('rajhdhani_night_close');
		
		$insert_data = array(
					'sridevi_open_time'=>$seridevi_open_time,
					'sridevi_close_time'=>$seridevi_close_time,
					'madhur_morning_open_time'=>$madhur_m_open_time,
					'madhur_morning_close_time'=>$madhur_m_close_time,
					'gold_day_open_time'=>$gold_d_open_time,
					'gold_day_close_time'=>$gold_d_close_time,
					'madhur_day_open_time'=>$madhur_d_open_time,
					'madhur_day_close_time'=>$madhur_d_close_time,
					'super_milan_open_time'=>$super_milan_open,
					'super_milan_close_time'=>$super_milan_close,
					'rajdhani_day_open_time'=>$rajdhani_d_open,
					'rajdhani_day_close_time'=>$rajdhani_d_close,
					'supreme_day_open_time'=>$supreme_d_open,
					'supreme_day_close_time'=>$supreme_d_close,
					'sri_devi_night_open_time'=>$sridevi_night_open,
					'sri_devi_night_close_time'=>$sridevi_night_close,
					'gold_night_open_time'=>$gold_night_open,
					'gold_night_close_time'=>$gold_night_close,
					'madhur_night_open_time'=>$madhure_night_open,
					'madhur_night_close_time'=>$madhure_night_close,
					'supreme_night_open_time'=>$supreme_night_open,
					'supreme_night_close_time'=>$supreme_night_close,
					'rajdhani_night_open_time'=>$rajhdhani_night_open,
					'rajdhani_night_close_time'=>$rajhdhani_night_close
				);
				
		if($games_time_id =='')
		{
			$this->Adminbmodel->insertData($insert_data,$this->tb16);
			$data['status'] = "success"; 
			$data['msg'] = $this->volanlib->success("Games times successfully inserted.");
		}
		else
		{
			$where=array('id'=>$games_time_id);
			$this->Admincmodel->update_where($this->tb16,$insert_data,$where);
			$data['status'] = "update"; 
			$data['msg'] = $this->volanlib->success("Games times successfully updated.");
		}
		echo json_encode($data); 
	}
	
	public function changeGameTime()
	{
		$games_id=$this->input->post('id');
		$open_time=$this->input->post('open_time');
		$close_time=$this->input->post('close_time');
		
		$data = array(
			'game_id'=>$games_id,
			'open_time'=>$open_time,
			'open_time_sort'=>date("H:i:s",strtotime($open_time)),
			'close_time'=>$close_time
		);
		
		$where=array('game_id'=>$games_id);
		$this->Admincmodel->update_where($this->tb16,$data,$where);
		$data['status'] = "update"; 
		$data['msg'] = $this->volanlib->success("Game time successfully updated.");
		echo json_encode($data); 
	}
	public function howToPlay()
	{
		if($this->session->userdata('adminlogin') == 1)
		{
			$this->data['title'] = "How To Play";
			$this->data['banner_title'] = "How To Play";
			$this->data['active_menu'] = 'how_to_play';
			$this->data['master_menu'] = 'games_management';
			
			$admin_setting = $this->Adminamodel->getData($this->tb13);
			if(count($admin_setting)>0)
			{
				foreach($admin_setting as $rs)
				{
					$this->data['id']=$rs->id;
					$this->data['content']=$rs->how_to_play_content;
					$this->data['video_link']=$rs->video_link;
				}
			}
			$this->middle = 'admin/k'; 
			$this->layout();
		}
		else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
	}
	
	public function tinymceUploadImage()
	{
		$imageFolder = "uploads/file/";
		reset($_FILES);
		$temp = current($_FILES);
		if(is_uploaded_file($temp['tmp_name'])){
			if(preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])){
				header("HTTP/1.1 400 Invalid file name.");
				return;
			}
			if(!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "jpeg", "png"))){
				header("HTTP/1.1 400 Invalid extension.");
				return;
			}
			$newfilename = rand() * time();
			$ext = strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION));
			$filename=$imageFolder . $newfilename.'.'.$ext;
			$filetowrite = $imageFolder . $temp['name'];
			move_uploaded_file($temp['tmp_name'], $filename);
			echo json_encode(array('location' => base_url().$filename));
		} else {
			header("HTTP/1.1 500 Server Error");
		}
	}
	
	public function addHowToPlayData()
	{
		$id = trim($this->input->post('id'));
		$description = trim($this->input->post('description'));
		$video_link = trim($this->input->post('video_link'));
		
		$playData = array(
			'how_to_play_content' => $description,
			'video_link' => $video_link,
			'insert_date'=>$this->insert_date
			);
		
		if($id == ''){
			$this->Adminbmodel->insertData($playData,$this->tb13);
			$data['status'] = 'success';
			$data['msg'] = $this->volanlib->success('Play Content Successfully Added.');
		}else{
			$where = array('id' => $id);
			$this->Admincmodel->update_where($this->tb13,$playData,$where);
			$data['status'] = 'update';
			$data['msg'] = $this->volanlib->success('Play Content Successfully Updated.');
		}
		echo json_encode($data);
	}

}