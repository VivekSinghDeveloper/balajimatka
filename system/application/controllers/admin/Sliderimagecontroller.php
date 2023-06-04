<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sliderimagecontroller extends MY_AdminController {

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

	public function sliderImagesManagement()
	{
		if($this->session->userdata('adminlogin') == 1 && $this->session->userdata('admin_type') == 1)		{
			$this->data['title'] = "Slider Image Managment";
			$this->data['banner_title'] = "Slider Image Management";
			$this->data['banner_title2'] = "Slider Image Management";
			$this->data['active_menu'] = 'slider_images_management';
			$this->data['imageSliderListTableFlag'] = 1;
			$this->middle = 'admin/o'; 
			$this->layout();
		
		}else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
	}
	
	public function addSliderImage()
	{
		$display_order = trim($this->input->post('display_order'));
		$file='';
		$path = 'uploads/file/slider_image/';
		$allowed = array('jpeg', 'png', 'jpg');
		$filename = $_FILES['file']['name'];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		$ext= strtolower($ext);
		if (!in_array($ext, $allowed)) {
			$data['status'] = 'error';
		$data['msg'] = $this->volanlib->error('Allow Only.jpeg,.jpg,.png');
		}
		
		else{
		$file=$this->volanimage->upload_image($path,$_FILES['file']);
		$sliderdata = array(
			'slider_image' => $file,
			'display_order' => $display_order,
			'insert_date'=>$this->insert_date
			);
		
		
		$this->Adminbmodel->insertData($sliderdata,$this->tb17);
		$data['status'] = 'success';
		$data['msg'] = $this->volanlib->success('Slider Image successfully added');
		}

		echo json_encode($data);
	}

	public function sliderImagesListGridData()
	{
		$columns = array( 
			0 => 'image_id',
			1 => 'slider_image',
			2 => 'display_order',
			3 => 'insert_date',
			4 => 'status',
			5 => 'image_id'
		);
		
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		
		$sql = "SELECT image_id,display_order,slider_image,status,date_format(insert_date,'%d %b %Y %r') as insert_date";
		$sql.=" FROM ".$this->tb17." WHERE 1=1";
		
		$totalData = $this->Adminamodel->data_search_count($sql);	
		$totalFiltered = $totalData;
		
		if(!empty($this->input->post('search')['value'])){
			$search = $this->input->post('search')['value'];
			$sql.= " AND (display_order LIKE '".$search."%' ";
			$sql.=" OR insert_date LIKE '".$search."%' )";
				
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
				$slider_image='N/A';
				if($rs->slider_image!=""){
					$slider_image='<a class="item" target="_BLANK" href="'.base_url().'uploads/file/slider_image/'.$rs->slider_image.'" data-original-title="" title=""><img  width="200" class="icons" src="'.base_url().'uploads/file/slider_image/'.$rs->slider_image.'"></a>';
				}
				
				$nestedData['slider_image'] = $slider_image;
				$nestedData['display_order'] = $rs->display_order;
				$nestedData['insert_date'] = $rs->insert_date;
				$nestedData['status'] = $rs->status;
				$nestedData['image_id'] = $rs->image_id;
				if($rs->status==1)
				{
					$nestedData['display_status'] = '<div id="status_show'.$rs->image_id.'"><badge class="badge badge-success">Active</badge></div>';
				}
				else
				{
					$nestedData['display_status'] = '<div id="status_show'.$rs->image_id.'"><badge class="badge badge-danger">Inactive</badge></div>';
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
	
	public function deleteImage()
	{
		$image_id = $this->input->post('id');
		$where = array('image_id' => $image_id);
		$this->Admindmodel->delete($this->tb17,$where);
		$data['status']="success";
		$data['msg'] = $this->volanlib->success('Image Successfully Deleted');
		echo json_encode($data); 
	}

}