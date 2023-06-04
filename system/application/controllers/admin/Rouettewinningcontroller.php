<?php

if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Rouettewinningcontroller extends MY_AdminController {



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

   
	
	public function rouletteWinningReport()

	{

		if($this->session->userdata('adminlogin') == 1 && $this->session->userdata('admin_type') == 1)		{

			$this->data['title'] = "Roulette Winning Report";

			$this->data['banner_title'] = "Roulette Winning Report";

			$this->data['active_menu'] = 'Roulette winning_report';

			$this->data['master_menu'] = 'roulette_winning_report';
			$this->data['game_result']=$this->Adminamodel->getData($this->tb40);

			$this->middle = 'admin/b2'; 

			$this->layout();

		}else {

			$myurl = base_url() .admin;

			redirect($myurl);

		}

    }

	public function getRouletteWinningReport()

	{
		
		$result_date = trim($this->input->post('result_date'));
		$game_name = $this->input->post('win_game_name');
		$result_date = date('Y-m-d',strtotime($result_date));

		 
		
		$group_by="tx_request_number";
		$joins = array(

						array(

							'table' => $this->tb14,

							'condition' => $this->tb14.'.open_result_token = '.$this->tb42.'.result_token',

							'jointype' => 'LEFT'

						),
						array(

								'table' => $this->tb41,

								'condition' => $this->tb41.'.bid_tx_id = '.$this->tb14.'.bid_tx_id',

								'jointype' => 'LEFT'

							),
							array(

							'table' => $this->tb3,

							'condition' => $this->tb3.'.user_id = '.$this->tb41.'.user_id',

							'jointype' => 'LEFT'
	
						),
						

				);
				
		$where = array('result_date' => $result_date,$this->tb41.'.game_id'=>$game_name);

		$columns="user_name,".$this->tb14.".user_id,".$this->tb41.".game_name,".$this->tb14.".amount,transaction_note,transaction_note,tx_request_number,".$this->tb14.'.insert_date,digits,points,bid_id,'.$this->tb41.'.bid_tx_id';

		$by = 'transaction_id';

		$data['getResultHistory']= $this->Adminamodel->get_joins_where_by($this->tb42,$columns,$joins,$by,$where);


		//echo "<pre>";
		///print_r($data['getResultHistory']);

		echo json_encode($data);

	}
	

}

