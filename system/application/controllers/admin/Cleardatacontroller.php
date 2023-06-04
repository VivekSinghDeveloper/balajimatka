<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Cleardatacontroller extends MY_AdminController {
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

    public function clearData()
	{
		if($this->session->userdata('adminlogin') == 1 && $this->session->userdata('admin_type') == 1)
		{
			$this->data['title'] = "Clean Data";
			$this->data['banner_title'] = "Clean Data";
			$this->data['active_menu'] = 'clean_data';
			$this->middle = 'admin/clear/a'; 
			$this->layout();
		}else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
    }
	
	public function clearDataDateWise()
	{
		$result_date = trim($this->input->post('result_date'));
		$temp = $this->uri->segment(2);
		if($temp != ""){
			$result_date = $temp;
		}
		$where = array('bid_date <'=>$result_date);
		$joins = array(
			array(
				'table' => $this->tb3,
				'condition' => $this->tb3.'.user_id = '.$this->tb18.'.user_id',
				'jointype' => 'LEFT'
			)
		);
		$columns = "user_name as User_Name,game_name as Game_Name,pana as Pana,session as Session,digits as Open_Digit,closedigits as Close_Digits,points as Points,bid_date as Bid_Date,bid_tx_id as Bid_Tx_ID,DATE_FORMAT(".$this->tb18.".insert_date,'%d %b %Y %r') as Insert_Date";				$this->excel->setActiveSheetIndex(0);		$currentTimeinSeconds = time();  		$currentDate = date('Y-m-d', $currentTimeinSeconds); 		$name= "Bid_History_Details".date("Y-m-d-H i s");   		$result=$this->Adminamodel->get_joins_where($this->tb18,$columns,$joins,$where);
		/* echo "<pre>";print_r($result);die; */		$this->excel->stream($name.'.xls', $result);		//$data['success'] = 'success';
		//echo json_encode($data);
	}
	public function walletTransactionBackup()	{				$result_date = trim($this->input->post('result_date'));		$temp = $this->uri->segment(2);		if($temp != ""){			$result_date = $temp;		}				$where_d = array('DATE('.$this->tb14.'.insert_date) <'=>$result_date);		$joins2 = array(			array(				'table' => $this->tb3,				'condition' => $this->tb3.'.user_id = '.$this->tb14.'.user_id',				'jointype' => 'LEFT'			)		);				$columns_1 = "user_name as User_Name,amount as Amount,(CASE when transaction_type = 1 then 'CREDIT' when transaction_type = 2 then 'Debit' END) as Transaction_Type,transaction_note as Transaction_Note,tx_request_number as Txn_Request_No,DATE_FORMAT(".$this->tb14.".insert_date,'%d %b %Y %r') as Insert_Date";				$this->excel->setActiveSheetIndex(0);		$currentTimeinSeconds = time();  		$currentDate = date('Y-m-d', $currentTimeinSeconds); 		$name2= "Wallet_transaction_Details".date("Y-m-d-H i s");   		$result_new=$this->Adminamodel->get_joins_where($this->tb14,$columns_1,$joins2,$where_d);		/* echo "<pre>";print_r($result_new);die; */		$this->excel->stream($name2.'.xls', $result_new);	}
	public function cleanDatabaseData()
	{
		/* echo "<pre>";
		print_r($_POST);die; */
		$result_date = trim($this->input->post('date'));
		$where = array('bid_date <'=>$result_date);
		$this->Admindmodel->delete($this->tb18,$where);
		$where = array('DATE(insert_date) <'=>$result_date);
		$this->Admindmodel->delete($this->tb14,$where);
		$data['msg'] = 'Data Successfully Clean';
		$data['status'] = 'success';
		echo json_encode($data);
	}
}