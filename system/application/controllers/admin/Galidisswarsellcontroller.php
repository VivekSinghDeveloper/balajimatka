<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Galidisswarsellcontroller extends MY_AdminController {

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
    public function galidisswarSellReport()
	{
		 
		if($this->session->userdata('adminlogin') == 1 && $this->session->userdata('admin_type') == 1)
		{
			$this->data['title'] = "GaliDisswar Sell Report";
			$this->data['banner_title'] = "GaliDisswar Sell Report";
			$this->data['banner_title2'] = "GaliDisswar Sell Report";
			$this->data['active_menu'] = 'galidisswar_sell_report';
			$this->data['game_result']=$this->Adminamodel->getData($this->tb44);	
			
			$this->middle = 'galidisswar/g'; 
			$this->layout();
		}
		else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
    }
	
	public function getgalidisswarSellReport()
	{	
	     
	
		$start_date=date('Y-m-d',strtotime($this->input->post('start_date')));
		$session=$this->input->post('market_status');
		$game_name=$this->input->post('game_name');
		$game_type=$this->input->post('game_type');
		
		
		 
		 $result=array();
		 $all_result=array();
		$counter=0;
		$listData="";
		if($game_type == "0")
		{
		 
			
			$order_by = "points";
			$group_by='numbers';
			$game_type='Left Digit';
			$joins = 
			 array(
			array(

					'table' => $this->tb46,
					'condition' => $this->tb46.'.digits = '.$this->tb26.'.single_digit && '.$this->tb46.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id="'.$game_name.'" && pana="'.$game_type.'" ',
					'jointype' => 'LEFT'
				)
				);
				
			$select='id,single_digit as numbers,sum(points) as total_points,bid_id,pana';
			$left_digit_result=$this->Adminamodel->get_joins_group_by($this->tb26,$select,$joins,$order_by,$group_by);
			
			/* echo "<pre>";print_r($left_digit_result);die; */
			$game_type='Right Digit';
			$joins = 
			 array(
			array(

					'table' => $this->tb46,
					'condition' => $this->tb46.'.digits = '.$this->tb26.'.single_digit && '.$this->tb46.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id="'.$game_name.'" && pana="'.$game_type.'" ',
					'jointype' => 'LEFT'
				)
				);
				
			$select='id,single_digit as numbers,sum(points) as total_points,bid_id,pana';
			$right_digit_result=$this->Adminamodel->get_joins_group_by($this->tb26,$select,$joins,$order_by,$group_by);
			
		
			
			$joins2 = 
			 array(
			array(

					'table' => $this->tb46,
					'condition' => $this->tb46.'.digits = '.$this->tb27.'.jodi_digit && '.$this->tb46.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id="'.$game_name.'"',
					'jointype' => 'LEFT'
				)
				);
				//$group_by='numbers';
			$select2='id,jodi_digit as numbers,sum(points) as total_points,bid_id,pana';
			$jodi_result=$this->Adminamodel->get_joins_group_by($this->tb27,$select2,$joins2,$order_by,$group_by);
			
			
			 $all_result[]['left_digit'] = $left_digit_result;
			  $all_result[]['right_digit'] = $right_digit_result;
			 $all_result[]['jodi_result'] = $jodi_result;
			 
			/* echo "<pre>";print_r($all_result);die; */
			 
			
		}
		else if($game_type=="Left Digit"){
			$order_by = "points";
			$where=array("bid_date" => $start_date,"session" => $session,"game_id" => $game_name, "pana" => $game_type);
			$joins = 
			 array(
			array(

					'table' => $this->tb46,
					'condition' => $this->tb46.'.digits = '.$this->tb26.'.single_digit && '.$this->tb46.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id='.$game_name.' && pana="'.$game_type.'" ',
					'jointype' => 'LEFT'
				)
				);
				$group_by='numbers';
			$select='id,single_digit as numbers,sum(points) as total_points,bid_id';
			$result=$this->Adminamodel->get_joins_group_by($this->tb26,$select,$joins,$order_by,$group_by);
			
			
		}
		else if($game_type=="Right Digit"){
			$order_by = "points";
			$where=array("bid_date" => $start_date,"session" => $session,"game_id" => $game_name, "pana" => $game_type);
			$joins = 
			 array(
			array(

					'table' => $this->tb46,
					'condition' => $this->tb46.'.digits = '.$this->tb26.'.single_digit && '.$this->tb46.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id='.$game_name.' && pana="'.$game_type.'" ',
					'jointype' => 'LEFT'
				)
				);
				$group_by='numbers';
			$select='id,single_digit as numbers,sum(points) as total_points,bid_id';
		 	$result=$this->Adminamodel->get_joins_group_by($this->tb26,$select,$joins,$order_by,$group_by);
			 
		}
		else if($game_type=="Jodi Digit"){
			$order_by = "points";
			$where=array("bid_date" => $start_date,"session" => $session,"game_id" => $game_name, "pana" => $game_type);
			$joins = 
			 array(
			array(

					'table' => $this->tb46,
					'condition' => $this->tb46.'.digits = '.$this->tb27.'.jodi_digit && '.$this->tb46.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id='.$game_name.' && pana="'.$game_type.'" ',
					'jointype' => 'LEFT'
				)
				);
				$group_by='numbers';
			$select='id,jodi_digit as numbers,sum(points) as total_points,bid_id';
			$result=$this->Adminamodel->get_joins_group_by($this->tb27,$select,$joins,$order_by,$group_by);
		 
		}
		
		
		    if(count($all_result) > 0 && !empty($all_result))
			{
				 for($i=0;$i<count($all_result);$i++)
				 {   
					$result1 = $all_result[$i];
				    
					 if(key($result1) == "left_digit")
					 {
						 $game_type1="Left Digit";
					 }
					 else if(key($result1) == "right_digit")
					 {
						 $game_type1="Right Digit";
					 }
					 else if(key($result1) == "jodi_result")
					 {
						 $game_type1="Jodi Digit";
					 }
					 if(count($result1)>0)
					 {
						 
						          $c=0;
								 $count = 0;
								 $counter = 0;
								 
								 if($c==0){
									  $listData .= '<div class="row"><div class="col-md-12 sr_title"><h5>'.$game_type1.'</h5></div></div>';
								 }
								 
								 $listData .= '<div class="row sr_td_data">';
								 
								 foreach($result1 as $res)
								 
								 {
									 foreach($res as $rs)
									 {
									 
									       
											 if($count==10){
												$count=0;
												
											}
											if($count == 0)
											{
												
													 $listData .= '<div class="form-group bord st_br_l col-md-2"><h5  class="st_br_ht">Digit</h5><h5 class="st_br_hb">Point</h5></div>';
													
													$counter = 0;
											}
											
											
											
											 if($rs->total_points == "")
											 {
												 $total_points ="<badge class='badge badge-danger'>0</badge>";
												  
											
											 }
											 else
											 {
												 
												$total_points = '<badge class="badge badge-primary">'.$rs->total_points.'</badge>';
												 
											 }
											  $listData .= '<div class="form-group bord col-md-1"><h5 class="st_br_ht">'.$rs->numbers.'</h5><h5 class="st_br_hb">'.$total_points.'</h5>
											</div>';
											
											
											
											$counter=$counter+1;
											$c++;
											$count++; 
									 }
								 } 
								 
								 $listData .= "</div>"; 
									 
					 }
				 }
			}
	 
	     
		 	 if(count($result) > 0 && !empty($result))
				 {
					 $c=0;
					 $count = 0;
					 $counter = 0;
					 
					 if($c==0){
						  $listData .= '<div class="row"><div class="col-md-12 sr_title"><h5>'.$game_type.'</h5></div></div>';
					 }
					 
					 $listData .= '<div class="row sr_td_data">';
					 
					 foreach($result as $rs)
					 {
						 
						 
						if($count==10){
							$count=0;
							
						}
						if($count == 0)
						{
							
								 $listData .= '<div class="form-group bord st_br_l col-md-2"><h5  class="st_br_ht">Digit</h5><h5 class="st_br_hb">Point</h5></div>';
								
								$counter = 0;
						}
						
						
						
						 if($rs->total_points == "")
						 {
							 $total_points ="<badge class='badge badge-danger'>0</badge>";
							  
						
						 }
						 else
						 {
							 
							$total_points = '<badge class="badge badge-primary">'.$rs->total_points.'</badge>';
							 
						 }
						  $listData .= '<div class="form-group bord col-md-1"><h5 class="st_br_ht">'.$rs->numbers.'</h5><h5 class="st_br_hb">'.$total_points.'</h5>
						</div>';
						
						
						
						$counter=$counter+1;
						$c++;
						$count++;
					 } 
					 
					 $listData .= "</div>";
				 }
			 
			 
			 
		 
	 
		  $data['status'] = 'success';
		$data['listData'] = $listData;
		echo json_encode($data);
	}

}