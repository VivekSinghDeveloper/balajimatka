<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customersellcontroller extends MY_AdminController {

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
    public function customerSellReport()
	{
		 
		if($this->session->userdata('adminlogin') == 1 && $this->session->userdata('admin_type') == 1)
		{
			$this->data['title'] = "Custmomer Sell Report";
			$this->data['banner_title'] = "Custmomer Sell Report";
			$this->data['banner_title2'] = "Custmomer Sell Report";
			$this->data['active_menu'] = 'customer_sell_report';
			$this->data['game_result']=$this->Adminamodel->getData($this->tb16);	
			
			$this->middle = 'admin/a1'; 
			$this->layout();
		}
		else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
    }
	
	public function getCustomerSellReport()
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
		 	$order_by = "total_points";
			$group_by='numbers';
			$joins = array(
				array(
						'table' => $this->tb18,
						'condition' => $this->tb18.'.digits = '.$this->tb26.'.single_digit && '.$this->tb18.'.session="'.$session.'" && 	bid_date="'.$start_date.'" && game_id="'.$game_name.'"',
						'jointype' => 'LEFT'
					)
				);
				
			$select='id,single_digit as numbers,sum(points) as total_points,bid_id,pana';
			$singe_digit_result=$this->Adminamodel->get_joins_group_by($this->tb26,$select,$joins,$order_by,$group_by);
			
			if($session=='Open')
			{				
			  $order_by1 = "total_points";
				$group_by1='numbers';
				$joins1 = 
				 array(
				array(

						'table' => $this->tb18,
						'condition' => $this->tb18.'.digits = '.$this->tb27.'.jodi_digit && '.$this->tb18.'.bid_date="'.$start_date.'" && game_id="'.$game_name.'"',
						'jointype' => 'LEFT'
					)
					);
				$select1='id,jodi_digit as numbers,sum(points) as total_points,bid_id,pana';
				$jodi_digit_result=$this->Adminamodel->get_joins_group_by($this->tb27,$select1,$joins1,$order_by1,$group_by1); 
			}
			 else
			 {
				
				$order_by = "total_points";
				$where=array("result_date" => $start_date,"game_id" => $game_name);
				
				$game_result=$this->Adminamodel->get_data($this->tb21,$where);
				
				if(count($game_result)>0)
				{	
				
				foreach($game_result as $rs)
				{
					$open_num=$rs->open_number[0]+$rs->open_number[1]+$rs->open_number[2];
					if($open_num<10)
					$number=$open_num;
					
					if($open_num>9)
					$number=$open_num%10;
				}
				
				$where=array("bid_date" => $start_date,"game_id" => $game_name, "pana" => 'Jodi Digit');
				///echo $number;die;
				$group_by='numbers';
				$select='digits as numbers,sum(points) as total_points,bid_id,bid_id as id,bid_id,pana';
				//$number='1';
				$jodi_digit_result=$this->Adminamodel->getJodiDigitSell($this->tb18,$order_by,$where,$select,$group_by,$number); 
				}
				else
				{
					$jodi_digit_result=array();
				}
			//echo "<pre>";print_r($jodi_digit_result);die;
			}
			
			$joins2 = 
			 array(
			array(

					'table' => $this->tb18,
					'condition' => $this->tb18.'.digits = '.$this->tb31.'.numbers && '.$this->tb18.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id="'.$game_name.'"',
					'jointype' => 'LEFT'
				)
				);
				//$group_by='numbers';
			$select2='id,numbers,sum(points) as total_points,bid_id,pana';
			$double_result=$this->Adminamodel->get_joins_group_by($this->tb31,$select2,$joins2,$order_by,$group_by);
			
			
			$joins3 = 
			 array(
			array(

					'table' => $this->tb18,
					'condition' => $this->tb18.'.digits = '.$this->tb28.'.numbers && '.$this->tb18.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id="'.$game_name.'"',
					'jointype' => 'LEFT'
				)
				);
				//$group_by='numbers';
			$select3='id,numbers,sum(points) as total_points,bid_id,pana';
			$single_pana_result=$this->Adminamodel->get_joins_group_by($this->tb28,$select3,$joins3,$order_by,$group_by);
			
			
			$joins4 = 
			 array(
			array(

					'table' => $this->tb18,
					'condition' => $this->tb18.'.digits = '.$this->tb29.'.numbers && '.$this->tb18.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id="'.$game_name.'"',
					'jointype' => 'LEFT'
				)
				);
			//$group_by='numbers';
			$select4='id,numbers,sum(points) as total_points,bid_id,pana';
			$triple_pana_result=$this->Adminamodel->get_joins_group_by($this->tb29,$select4,$joins4,$order_by,$group_by);
			
			/* $joins5 = 
			 array(
			array(

					'table' => $this->tb18,
					'condition' => $this->tb18.'.digits = '.$this->tb30.'.numbers && '.$this->tb18.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id="'.$game_name.'"',
					'jointype' => 'LEFT'
				)
				);
			//$group_by='numbers';
			$select5='id,numbers,sum(points) as total_points,bid_id,pana';
			$half_sangam_result=$this->Adminamodel->get_joins_group_by($this->tb30,$select5,$joins5,$order_by,$group_by); */
			
			$where = array("bid_date" => $start_date,"game_id" => $game_name,'pana'=>'Half Sangam','session'=>$session);
			$half_sangam_result=$this->Adminamodel->get_data($this->tb18,$where);
			
			/* echo "<pre>";
			print_r($half_sangam_result);die; */
		   	/*$joins6 = 
			 array(
			array(

					'table' => $this->tb18,
					'condition' => $this->tb18.'.digits = '.$this->tb32.'.numbers && '.$this->tb18.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id="'.$game_name.'"',
					'jointype' => 'LEFT'
				)
				);
			//$group_by='numbers';
			$select6='id,numbers,sum(points) as total_points,bid_id,pana';
			$full_sangam_result=$this->Adminamodel->get_joins_group_by($this->tb32,$select6,$joins6,$order_by,$group_by); */
			
			$where = array("bid_date" => $start_date,"game_id" => $game_name,'pana'=>'Full Sangam');
			$full_sangam_result=$this->Adminamodel->get_data($this->tb18,$where);
			
		    //$result = $singe_digit_result+$jodi_digit_result+$double_result+$single_pana_result+$triple_pana_result;
			//$res=array_merge($singe_digit_result,$jodi_digit_result,$double_result,$single_pana_result,$triple_pana_result);
			 $all_result[]['single_digit'] = $singe_digit_result;
			 $all_result[]['jodi_digit']=$jodi_digit_result;
			 $all_result[]['single_pana'] = $single_pana_result;
			 $all_result[]['double_pana'] = $double_result;
			 $all_result[]['triple_pana'] = $triple_pana_result;
			 $all_result[]['half_sangam'] = $half_sangam_result;
			 $all_result[]['full_sangam'] = $full_sangam_result;
			 
			
		}
		else if($game_type=="Single Digit"){
			$order_by = "total_points";
			$where=array("bid_date" => $start_date,"session" => $session,"game_id" => $game_name, "pana" => $game_type);
			$joins = 
			 array(
			array(

					'table' => $this->tb18,
					'condition' => $this->tb18.'.digits = '.$this->tb26.'.single_digit && '.$this->tb18.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id='.$game_name.' && pana="'.$game_type.'" ',
					'jointype' => 'LEFT'
				)
				);
				$group_by='numbers';
			$select='id,single_digit as numbers,sum(points) as total_points,bid_id';
			$result=$this->Adminamodel->get_joins_group_by($this->tb26,$select,$joins,$order_by,$group_by);
			
			
		}
		else if($game_type=="Jodi Digit"){
			
			/* $order_by = "total_points";
			$where=array("bid_date" => $start_date,"game_id" => $game_name, "pana" => $game_type);
			$joins = 
			 array(
			array(

					'table' => $this->tb18,
					'condition' => $this->tb18.'.digits = '.$this->tb27.'.jodi_digit && '.$this->tb18.'.bid_date="'.$start_date.'" && game_id='.$game_name.' && pana="'.$game_type.'" ',
					'jointype' => 'LEFT'
				)
				);
				$group_by='numbers';
			$select='id,jodi_digit as numbers,sum(points) as total_points,bid_id';
			$result=$this->Adminamodel->get_joins_group_by($this->tb27,$select,$joins,$order_by,$group_by); */
			
			$order_by = "total_points";
			$where=array("result_date" => $start_date,"game_id" => $game_name);
			
			$result=$this->Adminamodel->get_data($this->tb21,$where);
			
			if(count($result)>0)
			
			{
			foreach($result as $rs)
			{
				$open_num=$rs->open_number[0]+$rs->open_number[1]+$rs->open_number[2];
				if($open_num<10)
				$number=$open_num;
				
				if($open_num>9)
				$number=$open_num%10;
			}
			
			$where=array("bid_date" => $start_date,"game_id" => $game_name, "pana" => $game_type);
			///echo $number;die;
			$group_by='numbers';
			$select='digits as numbers,sum(points) as total_points,bid_id';
			//$number='1';
			$result=$this->Adminamodel->getJodiDigitSell($this->tb18,$order_by,$where,$select,$group_by,$number);
			}
				else
				{
					$result=array();
				}
			
			
			 
		}
		else if($game_type=="Double Pana"){
			$order_by = "total_points";
			$where=array("bid_date" => $start_date,"session" => $session,"game_id" => $game_name, "pana" => $game_type);
			$joins = 
			 array(
			array(

					'table' => $this->tb18,
					'condition' => $this->tb18.'.digits = '.$this->tb31.'.numbers && '.$this->tb18.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id='.$game_name.' && pana="'.$game_type.'" ',
					'jointype' => 'LEFT'
				)
				);
				$group_by='numbers';
			$select='id,numbers,sum(points) as total_points,bid_id';
		 	$result=$this->Adminamodel->get_joins_group_by($this->tb31,$select,$joins,$order_by,$group_by);
			 
		}
		else if($game_type=="Single Pana"){
			$order_by = "total_points";
			$where=array("bid_date" => $start_date,"session" => $session,"game_id" => $game_name, "pana" => $game_type);
			$joins = 
			 array(
			array(

					'table' => $this->tb18,
					'condition' => $this->tb18.'.digits = '.$this->tb28.'.numbers && '.$this->tb18.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id='.$game_name.' && pana="'.$game_type.'" ',
					'jointype' => 'LEFT'
				)
				);
				$group_by='numbers';
			$select='id,numbers,sum(points) as total_points,bid_id';
			$result=$this->Adminamodel->get_joins_group_by($this->tb28,$select,$joins,$order_by,$group_by);
		 
		}
		else if($game_type=="Triple Pana"){
			$order_by = "total_points";
			$where=array("bid_date" => $start_date,"session" => $session,"game_id" => $game_name, "pana" => $game_type);
			$joins = 
			 array(
			array(

					'table' => $this->tb18,
					'condition' => $this->tb18.'.digits = '.$this->tb29.'.numbers && '.$this->tb18.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id='.$game_name.' && pana="'.$game_type.'" ',
					'jointype' => 'LEFT'
				)
				);
			$group_by='numbers';
			$select='id,numbers,sum(points) as total_points,bid_id';
			$result=$this->Adminamodel->get_joins_group_by($this->tb29,$select,$joins,$order_by,$group_by);
		}
		else if($game_type=="Half Sangam"){
			$order_by = "total_points";
			$where=array("bid_date" => $start_date,"session" => $session,"game_id" => $game_name, "pana" => $game_type);
			/* $joins = 
			 array(
			array(

					'table' => $this->tb18,
					'condition' => $this->tb18.'.digits = '.$this->tb30.'.numbers && '.$this->tb18.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id='.$game_name.' && pana="'.$game_type.'" ',
					'jointype' => 'LEFT'
				)
				);
			$group_by='numbers';
			$select='id,numbers,sum(points) as total_points,bid_id';
			$result=$this->Adminamodel->get_joins_group_by($this->tb30,$select,$joins,$order_by,$group_by); */
			
			$result=$this->Adminamodel->get_data($this->tb18,$where);
			/* echo "<pre>";
			print_r($result);die; */
		}
		else if($game_type=="Full Sangam"){
			$order_by = "total_points";
			$where=array("bid_date" => $start_date,"game_id" => $game_name, "pana" => $game_type);
			/* $joins = 
			 array(
			array(

					'table' => $this->tb18,
					'condition' => $this->tb18.'.digits = '.$this->tb32.'.numbers && '.$this->tb18.'.session="'.$session.'" && bid_date="'.$start_date.'" && game_id='.$game_name.' && pana="'.$game_type.'" ',
					'jointype' => 'LEFT'
				)
				);
			$group_by='numbers';
			$select='id,numbers,sum(points) as total_points,bid_id';
			$result=$this->Adminamodel->get_joins_group_by($this->tb32,$select,$joins,$order_by,$group_by); */
			$result=$this->Adminamodel->get_data($this->tb18,$where);
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
					else if(key($result1) == "jodi_digit")
					 {
						 $game_type1="Jodi Digit";
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
						 $game_type1="Triple Pana";
					 }
					 else if(key($result1) == "half_sangam")
					 {
						 $game_type1="Half Sangam";
					 }
					 else if(key($result1) == "full_sangam")
					 {
						 $game_type1="Full Sangam";
					 }
					 if(count($result1)>0)
					 {
					     if(key($result1) == "half_sangam")
					     {
					         $c=0;
							
							 if($c==0){
    							  $listData .= '<div class="row"><div class="col-md-12 sr_title"><h5>'.$game_type1.'</h5></div></div>';
    						 }
    						 $listData .= '<div class="row sr_td_data">';
							 
							 foreach($result1 as $res)
								 
								 {
									 foreach($res as $rs)
									 {
										 if($session=='Open'){
											$listData .='<div class="form-group bord st_br_l col-md-3"><div class="dt-ext table-responsive"><table class="table table-striped"><thead><th><h5  class="st_br_ht">Open Digit</h5></th><th><h5  class="st_br_ht">Close Pana</h5></th><th> <h5  class="st_br_ht">Point</h5></th></thead><tbody><td><h5  class="st_br_ht">'.$rs->digits.'</h5></td><td><h5  class="st_br_ht">'.$rs->closedigits.'</h5></td><td><badge class="badge badge-primary">'.$rs->points.'</badge></td><tbody></table></div></div>';
										 }else {
											$listData .='<div class="form-group bord st_br_l col-md-3"><div class="dt-ext table-responsive"><table class="table table-striped"><thead><th><h5  class="st_br_ht">Open Pana</h5></th><th><h5  class="st_br_ht">Close Digit</h5></th><th> <h5  class="st_br_ht">Point</h5></th></thead><tbody><td><h5  class="st_br_ht">'.$rs->digits.'</h5></td><td><h5  class="st_br_ht">'.$rs->closedigits.'</h5></td><td><badge class="badge badge-primary">'.$rs->points.'</badge></td><tbody></table></div></div>';
										 }
										 $c++;
									 }
								 }
								 $listData .= "</div>"; 
					     }else if(key($result1) == "full_sangam"){
							 $c=0;
							 
							 if($c==0){
    							  $listData .= '<div class="row"><div class="col-md-12 sr_title"><h5>'.$game_type1.'</h5></div></div>';
    						 }
    						 $listData .= '<div class="row sr_td_data">';
							 
							 foreach($result1 as $res)
								 
								 {
									 foreach($res as $rs)
									 {
										 $listData .='<div class="form-group bord st_br_l col-md-3"><div class="dt-ext table-responsive"><table class="table table-striped"><thead><th><h5  class="st_br_ht">Open Pana</h5></th><th><h5  class="st_br_ht">Close Pana</h5></th><th> <h5  class="st_br_ht">Point</h5></th></thead><tbody><td><h5  class="st_br_ht">'.$rs->digits.'</h5></td><td><h5  class="st_br_ht">'.$rs->closedigits.'</h5></td><td><badge class="badge badge-primary">'.$rs->points.'</badge></td><tbody></table></div></div>';
										 
										 $c++;
									 }
								 }
								 $listData .= "</div>"; 
						 }else {
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
			}
			
			
			
			if($game_type == 'Half Sangam'){
				if(count($result) > 0 && !empty($result))
				 {
					$c=0;
					 if($c==0){
						  $listData .= '<div class="row"><div class="col-md-12 sr_title"><h5>'.$game_type.'</h5></div></div>';
					 }
					 $listData .= '<div class="row sr_td_data">';
					 
					 foreach($result as $rs)
					 {
						 if($session=='Open'){
							$listData .='<div class="form-group bord st_br_l col-md-3"><div class="dt-ext table-responsive"><table class="table table-striped"><thead><th><h5  class="st_br_ht">Open Digit</h5></th><th><h5  class="st_br_ht">Close Pana</h5></th><th> <h5  class="st_br_ht">Point</h5></th></thead><tbody><td><h5  class="st_br_ht">'.$rs->digits.'</h5></td><td><h5  class="st_br_ht">'.$rs->closedigits.'</h5></td><td><badge class="badge badge-primary">'.$rs->points.'</badge></td><tbody></table></div></div>';
						 }else {
							$listData .='<div class="form-group bord st_br_l col-md-3"><div class="dt-ext table-responsive"><table class="table table-striped"><thead><th><h5  class="st_br_ht">Open Pana</h5></th><th><h5  class="st_br_ht">Close Digit</h5></th><th> <h5  class="st_br_ht">Point</h5></th></thead><tbody><td><h5  class="st_br_ht">'.$rs->digits.'</h5></td><td><h5  class="st_br_ht">'.$rs->closedigits.'</h5></td><td><badge class="badge badge-primary">'.$rs->points.'</badge></td><tbody></table></div></div>';
						 }
						 $c++;
					 }
					 $listData .= "</div>";
				 }
				 else{
					  $listData .= '<div class="row"><div class="col-md-12 sr_title"><h5>No Data Found</h5></div></div>';
				 }
			}else if($game_type == 'Full Sangam'){
				if(count($result) > 0 && !empty($result))
				 {
					$c=0;
					 if($c==0){
						  $listData .= '<div class="row"><div class="col-md-12 sr_title"><h5>'.$game_type.'</h5></div></div>';
					 }
					 $listData .= '<div class="row sr_td_data">';
					 
					 foreach($result as $rs)
					 {
						 $listData .='<div class="form-group bord st_br_l col-md-3"><div class="dt-ext table-responsive"><table class="table table-striped"><thead><th><h5  class="st_br_ht">Open Pana</h5></th><th><h5  class="st_br_ht">Close Pana</h5></th><th> <h5  class="st_br_ht">Point</h5></th></thead><tbody><td><h5  class="st_br_ht">'.$rs->digits.'</h5></td><td><h5  class="st_br_ht">'.$rs->closedigits.'</h5></td><td><badge class="badge badge-primary">'.$rs->points.'</badge></td><tbody></table></div></div>';
						 
						 $c++;
					 }
				 $listData .= "</div>"; 
				 }
			}else {
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
			}
	 
		$data['status'] = 'success';
		$data['listData'] = $listData;
		echo json_encode($data);
	}

}