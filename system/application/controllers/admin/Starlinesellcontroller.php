<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Starlinesellcontroller extends MY_AdminController {

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
    public function starlineSellReport()
	{		if($this->session->userdata('adminlogin') == 1 && $this->session->userdata('admin_type') == 1)		{			$this->data['title'] = "Starline Sell Report";
			$this->data['banner_title'] = "Starline Sell Report";
			$this->data['banner_title2'] = "Starline Sell Report";
			$this->data['active_menu'] = 'starline_sell_report';
			$this->data['game_result']=$this->Adminamodel->getData($this->tb35);	
			
			$this->middle = 'admin/c1'; 
			$this->layout();
		}else {			$myurl = base_url() .admin;			redirect($myurl);		}
    }
	
	public function getStarlineSellReport()
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
			$joins = 
			 array(
			array(

					'table' => $this->tb37,
					'condition' => $this->tb37.'.digits = '.$this->tb26.'.single_digit && '.$this->tb37.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id="'.$game_name.'"',
					'jointype' => 'LEFT'
				)
				);
				
			$select='id,single_digit as numbers,sum(points) as total_points,bid_id,pana';
			$singe_digit_result=$this->Adminamodel->get_joins_group_by($this->tb26,$select,$joins,$order_by,$group_by);
			
		
			
			$joins2 = 
			 array(
			array(

					'table' => $this->tb37,
					'condition' => $this->tb37.'.digits = '.$this->tb31.'.numbers && '.$this->tb37.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id="'.$game_name.'"',
					'jointype' => 'LEFT'
				)
				);
				//$group_by='numbers';
			$select2='id,numbers,sum(points) as total_points,bid_id,pana';
			$double_result=$this->Adminamodel->get_joins_group_by($this->tb31,$select2,$joins2,$order_by,$group_by);
			
			
			$joins3 = 
			 array(
			array(

					'table' => $this->tb37,
					'condition' => $this->tb37.'.digits = '.$this->tb28.'.numbers && '.$this->tb37.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id="'.$game_name.'"',
					'jointype' => 'LEFT'
				)
				);
				//$group_by='numbers';
			$select3='id,numbers,sum(points) as total_points,bid_id,pana';
			$single_pana_result=$this->Adminamodel->get_joins_group_by($this->tb28,$select3,$joins3,$order_by,$group_by);
			
			
			$joins4 = 
			 array(
			array(

					'table' => $this->tb37,
					'condition' => $this->tb37.'.digits = '.$this->tb29.'.numbers && '.$this->tb37.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id="'.$game_name.'"',
					'jointype' => 'LEFT'
				)
				);
			//$group_by='numbers';
			$select4='id,numbers,sum(points) as total_points,bid_id,pana';
			$triple_pana_result=$this->Adminamodel->get_joins_group_by($this->tb29,$select4,$joins4,$order_by,$group_by);
			
		    //$result = $singe_digit_result+$jodi_digit_result+$double_result+$single_pana_result+$triple_pana_result;
			//$res=array_merge($singe_digit_result,$jodi_digit_result,$double_result,$single_pana_result,$triple_pana_result);
			 $all_result[]['single_digit'] = $singe_digit_result;
			  $all_result[]['single_pana'] = $single_pana_result;
			 $all_result[]['double_pana'] = $double_result;
			 $all_result[]['triple_pana'] = $triple_pana_result;
			 
			
		}
		else if($game_type=="Single Digit"){
			$order_by = "points";
			$where=array("bid_date" => $start_date,"session" => $session,"game_id" => $game_name, "pana" => $game_type);
			$joins = 
			 array(
			array(

					'table' => $this->tb37,
					'condition' => $this->tb37.'.digits = '.$this->tb26.'.single_digit && '.$this->tb37.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id='.$game_name.' && pana="'.$game_type.'" ',
					'jointype' => 'LEFT'
				)
				);
				$group_by='numbers';
			$select='id,single_digit as numbers,sum(points) as total_points,bid_id';
			$result=$this->Adminamodel->get_joins_group_by($this->tb26,$select,$joins,$order_by,$group_by);
			
			
		}
		else if($game_type=="Double Pana"){
			$order_by = "points";
			$where=array("bid_date" => $start_date,"session" => $session,"game_id" => $game_name, "pana" => $game_type);
			$joins = 
			 array(
			array(

					'table' => $this->tb37,
					'condition' => $this->tb37.'.digits = '.$this->tb31.'.numbers && '.$this->tb37.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id='.$game_name.' && pana="'.$game_type.'" ',
					'jointype' => 'LEFT'
				)
				);
				$group_by='numbers';
			$select='id,numbers,sum(points) as total_points,bid_id';
		 	$result=$this->Adminamodel->get_joins_group_by($this->tb31,$select,$joins,$order_by,$group_by);
			 
		}
		else if($game_type=="Single Pana"){
			$order_by = "points";
			$where=array("bid_date" => $start_date,"session" => $session,"game_id" => $game_name, "pana" => $game_type);
			$joins = 
			 array(
			array(

					'table' => $this->tb37,
					'condition' => $this->tb37.'.digits = '.$this->tb28.'.numbers && '.$this->tb37.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id='.$game_name.' && pana="'.$game_type.'" ',
					'jointype' => 'LEFT'
				)
				);
				$group_by='numbers';
			$select='id,numbers,sum(points) as total_points,bid_id';
			$result=$this->Adminamodel->get_joins_group_by($this->tb28,$select,$joins,$order_by,$group_by);
		 
		}
		else if($game_type=="Triple Pana"){
			$order_by = "points";
			$where=array("bid_date" => $start_date,"session" => $session,"game_id" => $game_name, "pana" => $game_type);
			$joins = 
			 array(
			array(

					'table' => $this->tb37,
					'condition' => $this->tb37.'.digits = '.$this->tb29.'.numbers && '.$this->tb37.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id='.$game_name.' && pana="'.$game_type.'" ',
					'jointype' => 'LEFT'
				)
				);
			$group_by='numbers';
			$select='id,numbers,sum(points) as total_points,bid_id';
			$result=$this->Adminamodel->get_joins_group_by($this->tb29,$select,$joins,$order_by,$group_by);
		}
		
		    if(count($all_result) > 0 && !empty($all_result))
			{
				 for($i=0;$i<count($all_result);$i++)
				 {   
					$result1 = $all_result[$i];
				    
					 if(key($result1) == "single_digit")
					 {
						 $game_type1="Single Digit";
					 }
					 else if(key($result1) == "single_pana")
					 {
						 $game_type1="Single Pana";
					 }
					 else if(key($result1) == "double_pana")
					 {
						 $game_type1="Double Pana";
					 }
					 else if(key($result1) == "triple_pana")
					 {
						 $game_type1="Triple Pana ";
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