<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Blockdatacontroller extends MY_AdminController {

    public function __construct() {
        parent::__construct();
     	
    }
		
		
		public function blockDataFunction() 
		{
				$id = $this->input->post('id');
			    $table = $this->input->post('table');
			    $id_name = $this->input->post('table_id');
				$status_name = $this->input->post('status_name');
				
				
				$where=array($id_name => $id);
				 $result = $this->Adminamodel->get_data($table,$where);
				$status='';
				foreach($result as $register)
				{
					$status=$register->$status_name;	
				}
				
				if($status=='1')
				{
					$status='0';				
					$msg='Inactive';
				}
				else
				{
					$status='1';				
					$msg='Active';
				}
				$data=array($status_name=>$status);
				$this->Admincmodel->update_where($table,$data,$where);
				echo $this->volanlib->success($msg." Successfully");
				die;
		}
		
		public function marketOpenCloseFunction() 
		{
				$id = $this->input->post('id');
			    $table = $this->input->post('table');
			    $id_name = $this->input->post('table_id');
				$status_name = $this->input->post('status_name');
				
				
				$where=array($id_name => $id);
				 $result = $this->Adminamodel->get_data($table,$where);
				$status='';
				foreach($result as $register)
				{
					$status=$register->$status_name;	
				}
				
				if($status=='1')
				{
					$status='0';				
					$msg='Market Successfully Close For Today';
				}
				else
				{
					$status='1';				
					$msg='Market Successfully Open For Today';
				}
				$data=array($status_name=>$status);
				$this->Admincmodel->update_where($table,$data,$where);
				echo $this->volanlib->success($msg);
				die;
		}
		
		public function userBlockDataFunction() 
		{
				$id = $this->input->post('id');
			    $table = $this->input->post('table');
			    $id_name = $this->input->post('table_id');
				$status_name = $this->input->post('status_name');
				
				
				$where=array($id_name => $id);
				 $result = $this->Adminamodel->get_data($table,$where);
				$status='';
				foreach($result as $register)
				{
					$status=$register->$status_name;	
				}
				
				if($status=='0')
				{
					$status='1';				
					$msg='UnBlock Successfully';
				}
				else if($status=='2')
				{
					$status='1';				
					$msg='UnBlock Successfully';
				}
				else if($status=='3')
				{
					$status='3';				
					$msg='Can Not Unblock Now';
				}
				else
				{
					$status='0';				
					$msg='Block Successfully';
				}
				$data=array($status_name=>$status);
				$this->Admincmodel->update_where($table,$data,$where);
				echo $this->volanlib->success($msg);
				die;
		}
	
}