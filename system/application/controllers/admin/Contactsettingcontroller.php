<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contactsettingcontroller extends MY_AdminController {

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
    public function contactSettings()
	{
		if($this->session->userdata('adminlogin') == 1 && $this->session->userdata('admin_type') == 1)
		{
			$this->data['title'] = "Contact Settings Management";
			$this->data['banner_title'] = "Contact Settings Management";
			$this->data['active_menu'] = 'contact_setting';
			$this->data['master_menu'] = 'settings';
			$result = $this->Adminamodel->getData($this->tb19);
			if(count($result)>0)
			{
				foreach($result as $rs)
				{
					$this->data['id'] = $rs->id;
					$this->data['mobile_1'] = $rs->mobile_1;
					$this->data['mobile_2'] = $rs->mobile_2;
					$this->data['whatsapp_no'] = $rs->whatsapp_no;
					$this->data['landline_1'] = $rs->landline_1;
					$this->data['landline_2'] = $rs->landline_2;
					$this->data['email_1'] = $rs->email_1;
					$this->data['email_2'] = $rs->email_2;
					$this->data['facebook'] = $rs->facebook;
					$this->data['twitter'] = $rs->twitter;
					$this->data['youtube'] = $rs->youtube;
					$this->data['google_plus'] = $rs->google_plus;
					$this->data['instagram'] = $rs->instagram;
					$this->data['latitude'] = $rs->latitude;
					$this->data['logitude'] = $rs->logitude;
					$this->data['address'] = $rs->address;
				}
			}
			$this->middle = 'admin/r'; 
			$this->layout();
		}
		else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
    }
	
	public function addContactSettings()
	{
		$id = trim($this->input->post('id'));
		$mobile_1 = trim($this->input->post('mobile_1'));
		$mobile_2=trim($this->input->post('mobile_2'));
		$whats_mobile=trim($this->input->post('whats_mobile'));
		$landline_1=trim($this->input->post('landline_1'));
		$landline_2=trim($this->input->post('landline_2'));
		$email_1=trim($this->input->post('email_1'));
		$email_2=trim($this->input->post('email_2'));
		$facebook=trim($this->input->post('facebook'));
		$twitter=trim($this->input->post('twitter'));
		$youtube=trim($this->input->post('youtube'));
		$google_plus=trim($this->input->post('google_plus'));
		$instagram=trim($this->input->post('instagram'));
		$latitude=trim($this->input->post('latitude'));
		$longitude=trim($this->input->post('longitude'));
		$address=trim($this->input->post('address'));
		
		$settingsData = array(
			'mobile_1' => $mobile_1,
			'mobile_2' => $mobile_2,
			'whatsapp_no' => $whats_mobile,
			'landline_1' => $landline_1,
			'landline_2' => $landline_2,
			'email_1' => $email_1,
			'email_2' => $email_2,
			'facebook' => $facebook,
			'twitter' => $twitter,
			'youtube' => $youtube,
			'google_plus' => $google_plus,
			'instagram' => $instagram,
			'latitude' => $latitude,
			'logitude' => $longitude,
			'address' => $address,
			'insert_date'=>$this->insert_date
			);
		
		if($id == '')
		{
			$this->Adminbmodel->insertData($settingsData,$this->tb19);
			$data['status'] = 'success';
			$data['msg'] = $this->volanlib->success('Contact Settings Successfully Added');
				
		}else {
			$where = array('id'=>$id);
			$this->Admincmodel->update_where($this->tb19,$settingsData,$where);
			$data['status'] = 'update';
			$data['msg'] = $this->volanlib->success('Contact Settings updated successfully.');
		}
		echo json_encode($data);
	}
	

}