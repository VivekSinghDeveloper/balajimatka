<?php
if (!defined('BASEPATH'))	exit('No direct script access allowed');
class Bidrevertcontroller extends MY_AdminController {
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
	
	public function bidRevert()
	{
		if($this->session->userdata('adminlogin') == 1)
		{
			$this->data['title'] = "Bid Revert";
			$this->data['banner_title'] = "Bid Revert";
			$this->data['game_result']=$this->Adminamodel->getData($this->tb16);
			$this->middle = 'admin/a5'; 
			$this->layout();
        }
		else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
    }
		
		public function getBidRevertData()
		{
			 $game_id=$this->input->post('win_game_name');
			$bid_revert_date = date('Y-m-d',strtotime($this->input->post('bid_revert_date')));
			
			 
			$where=array('bid_date'=>$bid_revert_date,'game_id' => $game_id);	
				$joins = array(
						array(

						'table' => $this->tb3,
						'condition' => $this->tb3.'.user_id = '.$this->tb18.'.user_id',
						'jointype' => 'LEFT'
						)

				);
				
			$columns="points,DATE_FORMAT(bid_date,'%d %b %Y') as bid_date,user_name";
			$result= $this->Adminamodel->get_joins_where($this->tb18,$columns,$joins,$where);
			
			$listData = "";
			
			if(count($result)>0)
			{
				$i=1;
				foreach($result as $rs)
				{
					$listData .= '<tr><td>'.$i.'</td><td>'.$rs->user_name.'</td><td>'.$rs->points.'</td><td>'.$rs->bid_date.'</td></tr>'; 
					$i++;
				}
			}
			 
			 
		$data['status'] = 'success';
		$data['listData'] = $listData;
		
		echo json_encode($data);
		}
		
		public function refundAmount()
		{
			 $game_id=$this->input->post('win_game_name');
			$bid_revert_date = date('Y-m-d',strtotime($this->input->post('bid_revert_date')));
			
			 
			$where=array('bid_date'=>$bid_revert_date,'game_id' => $game_id);
				$joins = array(
						array(

						'table' => $this->tb3,
						'condition' => $this->tb3.'.user_id = '.$this->tb18.'.user_id',
						'jointype' => 'LEFT'
						)

				);
				
			$columns="points,DATE_FORMAT(bid_date,'%d %b %Y') as bid_date,".$this->tb18.".user_id,wallet_balance,game_name,pana,bid_id";
			$result= $this->Adminamodel->get_joins_where($this->tb18,$columns,$joins,$where);
			
			if(count($result)>0)
			{
				foreach($result as $rs)
				{
					     $user_id=$rs->user_id;
					     $bid_id=$rs->bid_id;
					      $game_name=$rs->game_name;
					       $pana=$rs->pana;
						 $user_wallet_amt = $rs->wallet_balance;
						 $points = $rs->points;
						 $user_wallet_amt += $points;
						 
						 $wh_bal=array('user_id' => $user_id);
						$user_balance = array('wallet_balance'=>$user_wallet_amt);
						$this->Admincmodel->update_where_set($this->tb3,'wallet_balance',$points,$wh_bal);
					
						$request_number = $this->randomNumber();
						$history_data_2 = array(
						'user_id' => $rs->user_id,
						'amount' => $points,
						'transaction_type' => 1,
						'transaction_note' => 'Bid Amount is reverted for '.$game_name.'-'.$pana,
						'amount_status' => 25,
						'tx_request_number' => $request_number,
						'insert_date' => $this->insert_date
				);
				$this->Adminbmodel->insertData($history_data_2,$this->tb14);

				$wh = array('bid_date'=>$bid_revert_date,'game_id' => $game_id,'user_id' => $user_id,'bid_id' => $bid_id);
				$this->Admindmodel->delete($this->tb18,$wh);
				}
			}
			
			
			 
		$data['msg'] = $this->volanlib->success("Succesfully Refundable...!!!");
		$data['status'] = 'success';
	 
		
		echo json_encode($data);
		}
		

}

	
