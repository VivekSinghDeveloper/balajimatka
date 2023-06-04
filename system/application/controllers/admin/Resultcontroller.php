<?php

if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Resultcontroller extends MY_AdminController {



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

    public function declareResult()

	{

		if($this->session->userdata('adminlogin') == 1)
		{

			$this->data['title'] = "Declare Result";

			$this->data['banner_title'] = "Declare Result";

			$this->data['active_menu'] = 'decleare_result';

			$this->data['master_menu'] = 'result_management';
			/* $where=array('status'=>1);
			$by='open_time_sort';
			$this->data['game_result']=$this->Adminamodel->get_data_latest_where_asc($this->tb16,$by,$where);
			 */
			
			$cur_date = date("Y-m-d");
			$sql = 'SELECT *, (select open_decleare_status from '.$this->tb21.' where game_id=a.game_id && result_date="'.$cur_date.'") as open_decleare_status, (select close_decleare_status from '.$this->tb21.' where game_id=a.game_id && result_date="'.$cur_date.'") as close_decleare_status FROM '.$this->tb16.' a WHERE a.status = 1 ORDER BY open_time_sort ASC';
			$this->data['game_result'] = $this->Adminamodel->custom_search($sql);
			
			/* echo "<pre>";print_r($this->data['game_result']);die; */
	
			/* $this->data['resultHistoryListTableFlag'] = 1; */
			
			$this->data['resultHistoryListTableLoadFlag'] = 1;
			
			$this->middle = 'admin/t'; 

			$this->layout();

		}else {

			$myurl = base_url() .admin;

			redirect($myurl);

		} 

    }
	
	public function resultHistoryListLoadData()
	{
		$date = $this->input->post('date');
		
		$sql = "SELECT id,b.game_id,result_date,date_format(result_date,'%d %b %Y') as result_date_f,date_format(open_decleare_date,'%d %b %Y %r') as open_decleare_date,date_format(close_decleare_date,'%d %b %Y %r') as close_decleare_date,b.game_name,open_number,close_number,open_decleare_status,close_decleare_status";
		$sql.=" FROM ".$this->tb21." LEFT JOIN ".$this->tb16." b ON b.game_id = ".$this->tb21.".game_id WHERE 1=1";

		if($date!=""){
			$sql.="&& result_date='".$date."'";
		}
		$tb_data =  $this->Adminamodel->data_search($sql);
		
		$i=1;
		$data = array();
		if(!empty($tb_data))
		{
			$close_res = '';
			$game_name = '';
			$open_num = '';
			$result_open = '';
			$result_close = '';
			foreach($tb_data as $rs )
			{
				$nestedData = array();
				
				$nestedData['sn'] = $i;
				$game_id = $rs->game_id;
				
				$nestedData['game_name'] = $rs->game_name;
				$nestedData['result_date'] = $rs->result_date_f;
			
				if($rs->open_number!=''){
					$open_num=$rs->open_number[0]+$rs->open_number[1]+$rs->open_number[2];
					if($open_num<10){
						if($rs->open_decleare_status == 0){
							$open_result = '<span class="td_color_1">'.$rs->open_number.'-'.$open_num.'<span>';
						}else{
							$open_result = '<span class="td_color_2">'.$rs->open_number.'-'.$open_num.'<span>';
						}
					}else if($open_num>9){
						if($rs->open_decleare_status == 0){
							$result_open = $rs->open_number.'-'.$open_num%10;
						$open_result = '<span class="td_color_1">'.$result_open.'</span>';
						}else{
							$result_open = $rs->open_number.'-'.$open_num%10;
						$open_result = '<span class="td_color_2">'.$result_open.'</span>';
						}
					}
				}else {
					$open_result= '<span class="sub_s td_color_1">***</span><span class="hyphen">-</span><span class="sub_s td_color_1">*</span>';
				}
				
				if($rs->open_decleare_date == null){
					$open_date = 'N/A';
				}else {
					$open_date = $rs->open_decleare_date;
					$open_result.='<button type="button" class="btn btn-danger waves-light btn-xs ml-1"  onclick="OpenDeleteResultConfirmData('.$rs->game_id.');" >Delete</button>';
					
				}
				$nestedData['open_result']=$open_result;
				
				$nestedData['open_date'] = $open_date;
			
				
				if($rs->close_number!=''){
					$close_num=$rs->close_number[0]+$rs->close_number[1]+$rs->close_number[2];
					if($close_num<10){
						if($rs->close_decleare_status == 0){
							$close_result='<span class="td_color_1">'.$close_num.'-'.$rs->close_number.'<span>';
						}else{
							$close_result='<span class="td_color_2">'.$close_num.'-'.$rs->close_number.'<span>';
						}
					}else if($close_num>9){
						if($rs->close_decleare_status == 0){
							$close_res = $close_num%10;
							$close_result='<span class="td_color_1">'.$close_res.'-'.$rs->close_number.'<span>';
						}else{
							$close_res = $close_num%10;
							$close_result='<span class="td_color_2">'.$close_res.'-'.$rs->close_number.'<span>';
						}
					} 
				}else {
					$close_result= '<span class="sub_s td_color_1">*</span><span class="hyphen">-</span><span class="sub_s td_color_1">***</span>';
				}
				
				if($rs->close_decleare_date == null){
					$close_date = 'N/A';
				}else {
					$close_date = $rs->close_decleare_date;
					$close_result.='<button type="button" class="btn btn-danger waves-light btn-xs ml-1"  onclick="closeDeleteResultConfirmData('.$rs->game_id.');">Delete</button>';
				}
				$nestedData['close_result']=$close_result;
				$nestedData['close_date'] = $close_date;
				
				
				$data[] = $nestedData;
				$i++;
			}
		}
		
		
		echo json_encode($data); 
	} 
	
	public function getGameListForResult()
	{
		$date = $this->input->post('date');
		$sql = 'SELECT *, (select open_decleare_status from '.$this->tb21.' where game_id=a.game_id && result_date="'.$date.'") as open_decleare_status, (select close_decleare_status from '.$this->tb21.' where game_id=a.game_id && result_date="'.$date.'") as close_decleare_status FROM '.$this->tb16.' a WHERE status = 1 ORDER BY open_time_sort ASC';
		$data['game_result'] = $this->Adminamodel->custom_search($sql);
		echo json_encode($data);
	} 
	
	
	public function winningReport()

	{

		if($this->session->userdata('adminlogin') == 1)

		{

			$this->data['title'] = "Winning Report";

			$this->data['banner_title'] = "Winning Report";

			$this->data['active_menu'] = 'winning_report';

			$this->data['master_menu'] = 'winning_report';
			$this->data['game_result']=$this->Adminamodel->getData($this->tb16);

			$this->middle = 'admin/v'; 

			$this->layout();

		}else {

			$myurl = base_url() .admin;

			redirect($myurl);

		}

    }
	
	
	

	
	public function getDecleareGameData()

	{

		$game_id = trim($this->input->post('game_id'));
		$result_dec_date = trim($this->input->post('result_dec_date'));
		 
		//$where=array('game_id'=>$game_id,'result_date'=>date('Y-m-d'));	
		$where=array('game_id'=>$game_id,'result_date'=>$result_dec_date);	
		
		
		$result = $this->Adminamodel->get_data($this->tb21,$where);
		$data['game_id']='';
		$data['open_number']='';
		$data['close_number']='';
		$data['decleare_status']='';
		$data['open_result']='';
		$data['close_result']='';
		$data['id']='';
		//echo "<pre>";print_r($result);die;
		foreach($result as $rs)
		{
			$data['game_id']=$rs->game_id;
			$data['id']=$rs->id;
			$data['open_number']=$rs->open_number;
			if($rs->open_number!='')
			{
				$open_num=$rs->open_number[0]+$rs->open_number[1]+$rs->open_number[2];
				if($open_num<10)
				$data['open_result']=$open_num;
				
				if($open_num>9)
				$data['open_result']=$open_num%10;
				
				
			}
			$data['close_number']=$rs->close_number;
			if($rs->close_number!='')
			{
				$close_num=$rs->close_number[0]+$rs->close_number[1]+$rs->close_number[2];
				
				if($close_num<10)
				$data['close_result']=$close_num;
				
				if($close_num>9)
				$data['close_result']=$close_num%10;
			}
			$data['open_decleare_date']=$rs->open_decleare_date;
			$data['close_decleare_date']=$rs->close_decleare_date;
			$data['open_decleare_status']=$rs->open_decleare_status;
			$data['close_decleare_status']=$rs->close_decleare_status;
		}
		$data['status'] = "success"; 
		echo json_encode($data);

	}
	
	public function getOpenData()
	{
		
		$open_number=$this->input->post('open_number');
		
		$open_num=$open_number[0]+$open_number[1]+$open_number[2];
		if($open_num<10)
		$data['open_result']=$open_num;
				
		if($open_num>9)
		$data['open_result']=$open_num%10;

		$data['status'] = "success"; 
		echo json_encode($data); 

	}
	
	public function saveOpenData()
	{
		
		$open_number=$this->input->post('open_number');
		$game_id=$this->input->post('game_id');
		$id=$this->input->post('id');
		$result_dec_date = trim($this->input->post('result_dec_date'));
		$insert_data = array(
				'open_number'=>$open_number,
				'game_id'=>$game_id,
				'result_date'=>$result_dec_date,
			);
			
		$where=array('game_id'=>$game_id,'result_date'=>$result_dec_date);	
		$result = $this->Adminamodel->get_data($this->tb21,$where);
		$open_decleare_status = 0;
		if(count($result)>0)
		{
			foreach($result as $rs)
			{
				$open_decleare_status = $rs->open_decleare_status;
			}
		}
		if($open_decleare_status == 1){
			$data['status'] = "success"; 
			$data['msg'] = $this->volanlib->error("Result already decleared.");
		}else {
			if(count($result)<1)
			{
				$this->Adminbmodel->insertData($insert_data,$this->tb21);
				$data['status'] = "success"; 
				$data['msg'] = $this->volanlib->success("Successfully inserted.");
			}
			else
			{
				//$where=array('id'=>$id);
				$this->Admincmodel->update_where($this->tb21,$insert_data,$where);
				$data['status'] = "success"; 
				$data['msg'] = $this->volanlib->success("Successfully updated.");

			}
			
			$open_num=$open_number[0]+$open_number[1]+$open_number[2];
			if($open_num<10)
			$data['open_result']=$open_num;
					
			if($open_num>9)
			$data['open_result']=$open_num%10;
		}
		
		echo json_encode($data); 

	}
	
	
	public function sendUserNotification($user_id,$title,$notification_content)
	{
		$where = array ('user_id' => $user_id);
		$result = $this->Adminamodel->get_data($this->tb33,$where);
		$player_id='';
		if(count($result)>0)
		{
			foreach($result as $rs)
			{
				$player_id.=','.$rs->player_id;
				
			}
			
			
			
			$player_id=trim($player_id,',');
			$to = $player_id; 
			$img = ''; 
			$type_id = '3';
			
			$this->volanlib->sendnotification($to, $title, $notification_content, $img, $type_id);
		}
	}
	
	
	public function decleareOpenData()
	{
		
		$game_id=$this->input->post('game_id');
		$id=$this->input->post('id');
		
		$result_dec_date = trim($this->input->post('result_dec_date'));
		
		$where=array('game_id'=>$game_id,'open_number!='=>"",'result_date'=>$result_dec_date);	
		$result = $this->Adminamodel->get_data($this->tb21,$where);
		
		if(count($result)<1)
		{
			$data['status'] = "error"; 
			$data['msg'] = $this->volanlib->error("Please save game result first");
		}
		else
		{
			foreach($result as $rs)
			{
					$open_number=$rs->open_number;
					$open_decleare_status=$rs->open_decleare_status;
			}
			
			if($open_decleare_status == 1)
			{
					$data['status'] = "success"; 
					$data['msg'] = $this->volanlib->error("Result already decleared.");
			}else {
					$where=array('game_id'=>$game_id);	
					$game_name_result = $this->Adminamodel->get_data($this->tb16,$where);
					foreach($game_name_result as $rs)
					{
							$game_not_name=$rs->game_name;
					}
					
					$win_number_not=$open_number[0]+$open_number[1]+$open_number[2];
					if($win_number_not>9)
						$win_number_not=$win_number_not%10;
					
					
					$game_rates=$this->Adminamodel->getData($this->tb10);
					foreach($game_rates as $rs)
					{
						$single_digit_val_2=$rs->single_digit_val_2;
						$jodi_digit_val_2=$rs->jodi_digit_val_2;
						$single_pana_val_2=$rs->single_pana_val_2;
						$double_pana_val_2=$rs->double_pana_val_2;
						$tripple_pana_val_2=$rs->tripple_pana_val_2;
						$half_sangam_val_2=$rs->half_sangam_val_2;
						$full_sangam_val_2=$rs->full_sangam_val_2;
					}
					
					$where=array($this->tb18.'.game_id'=>$game_id,'pay_status'=>0,'bid_date'=>$result_dec_date,'session'=>'Open');	
					
						$joins = array(

							array(

								'table' => $this->tb16,
								'condition' => $this->tb16.'.game_id = '.$this->tb18.'.game_id',
								'jointype' => 'LEFT'
								)

						);
						
				$columns=$this->tb16.".game_name,pana,user_id,session,digits,closedigits,points,bid_id,bid_tx_id,pay_status";
				$by = 'bid_id';

				$result= $this->Adminamodel->get_joins_where_by($this->tb18,$columns,$joins,$by,$where);
				
				
					
					$open_result_token=$this->volanlib->uniqRandom(15);
					foreach($result as $rs)
					{
						
							
						
						
						if($rs->pana=='Single Digit')
						{
							$win_number=$open_number[0]+$open_number[1]+$open_number[2];
							
							if($win_number>9)
							$win_number=$win_number%10;
							
							if($win_number==$rs->digits)
							{
								$win_amt=($single_digit_val_2/10)*$rs->points;
								
								//$msg='Amount won in '.$rs->game_name.' '.$rs->pana.' '.$rs->session.' session for Bid Number- '.$rs->bid_tx_id;
								
								$msg=$rs->game_name.' in '.$rs->pana.' '.'(Session- '.$rs->session.') for bid amount- '.$rs->points.' Won';
								$this->updateUserWallet($rs->user_id,$win_amt,$msg,$open_result_token,$rs->bid_tx_id);
								
								$where=array('bid_id'=>$rs->bid_id);
								$up_data=array('pay_status'=>1,'open_result_token'=>$open_result_token);
								$this->Admincmodel->update_where($this->tb18,$up_data,$where);
								
								$insert_data = array(
								'user_id' => $rs->user_id,
								'bid_tx_id' => $rs->bid_tx_id,
								'open_result_token'=>$open_result_token,
								'msg' => "Congratulations ,You Won in ".$rs->game_name." for Bid Number- ".$rs->bid_tx_id,
								'insert_date' => $this->insert_date
								);
								$this->Adminbmodel->insertData($insert_data,$this->tb22);
								
								//$title="Congratulations ,Winner in".$rs->game_name." for Bid Number- ".$rs->bid_tx_id;
								//$this->sendUserNotification($rs->user_id,$title,$msg);
								
								
							}
						}
						else if($rs->pana=='Triple Pana')
						{
							if($open_number==$rs->digits)
							{
								$win_amt=($tripple_pana_val_2/10)*$rs->points;
								
								//$msg='Amount won in '.$rs->game_name.' '.$rs->pana.' '.$rs->session.' session for Bid Number- '.$rs->bid_tx_id;
								
								$msg=$rs->game_name.' in '.$rs->pana.' '.'(Session- '.$rs->session.') for bid amount- '.$rs->points.' Won';
								
								$this->updateUserWallet($rs->user_id,$win_amt,$msg,$open_result_token,$rs->bid_tx_id);
								
								$where=array('bid_id'=>$rs->bid_id);
								$up_data=array('pay_status'=>1,'open_result_token'=>$open_result_token);
								$this->Admincmodel->update_where($this->tb18,$up_data,$where);
								
								$insert_data = array(
								'user_id' => $rs->user_id,
								'bid_tx_id' => $rs->bid_tx_id,
								'open_result_token'=>$open_result_token,
								'msg' => "Congratulations ,You Won in ".$rs->game_name." for Bid Number- ".$rs->bid_tx_id,
								'insert_date' => $this->insert_date
								);
								$this->Adminbmodel->insertData($insert_data,$this->tb22);
								
								//$title="Congratulations ,Winner in".$rs->game_name." for Bid Number- ".$rs->bid_tx_id;
								//$this->sendUserNotification($rs->user_id,$title,$msg);
							}
						}
						else if($rs->pana=='Double Pana')
						{
							if($open_number==$rs->digits)
							{
								$win_amt=($double_pana_val_2/10)*$rs->points;
								
								//$msg='Amount won in '.$rs->game_name.' '.$rs->pana.' '.$rs->session.' session for Bid Number- '.$rs->bid_tx_id;
								
								$msg=$rs->game_name.' in '.$rs->pana.' '.'(Session- '.$rs->session.') for bid amount- '.$rs->points.' Won';
								$this->updateUserWallet($rs->user_id,$win_amt,$msg,$open_result_token,$rs->bid_tx_id);
								
								$where=array('bid_id'=>$rs->bid_id);
								$up_data=array('pay_status'=>1,'open_result_token'=>$open_result_token);
								$this->Admincmodel->update_where($this->tb18,$up_data,$where);
								
								$insert_data = array(
								'user_id' => $rs->user_id,
								'bid_tx_id' => $rs->bid_tx_id,
								'open_result_token'=>$open_result_token,
								'msg' => "Congratulations ,You Won in ".$rs->game_name." for Bid Number- ".$rs->bid_tx_id,
								'insert_date' => $this->insert_date
								);
								$this->Adminbmodel->insertData($insert_data,$this->tb22);
								
								//$title="Congratulations ,Winner in".$rs->game_name." for Bid Number- ".$rs->bid_tx_id;
								//$this->sendUserNotification($rs->user_id,$title,$msg);
							}
						}
						
						else if($rs->pana=='Single Pana')
						{
							if($open_number==$rs->digits)
							{
								$win_amt=($single_pana_val_2/10)*$rs->points;
								
								//$msg='Amount won in '.$rs->game_name.' '.$rs->pana.' '.$rs->session.' session for Bid Number- '.$rs->bid_tx_id;
								$msg=$rs->game_name.' in '.$rs->pana.' '.'(Session- '.$rs->session.') for bid amount- '.$rs->points.' Won';
								$this->updateUserWallet($rs->user_id,$win_amt,$msg,$open_result_token,$rs->bid_tx_id);
								
								$where=array('bid_id'=>$rs->bid_id);
								$up_data=array('pay_status'=>1,'open_result_token'=>$open_result_token);
								$this->Admincmodel->update_where($this->tb18,$up_data,$where);
								
								$insert_data = array(
								'user_id' => $rs->user_id,
								'bid_tx_id' => $rs->bid_tx_id,
								'open_result_token'=>$open_result_token,
								'msg' => "Congratulations ,You Won in ".$rs->game_name." for Bid Number- ".$rs->bid_tx_id,
								'insert_date' => $this->insert_date
								);
								$this->Adminbmodel->insertData($insert_data,$this->tb22);
								
								//$title="Congratulations ,Winner in".$rs->game_name." for Bid Number- ".$rs->bid_tx_id;
								//$this->sendUserNotification($rs->user_id,$title,$msg);
							}
						}
						
					}
					
					$where=array('game_id'=>$game_id,'open_number!='=>"",'result_date'=>$result_dec_date);	
					$up_data=array('open_decleare_status'=>1,'open_decleare_date'=>$this->insert_date,'open_result_token'=>$open_result_token);
					$this->Admincmodel->update_where($this->tb21,$up_data,$where);
					
					
					$where = array('notification_status' => 1);	
					$result = $this->Adminamodel->get_data($this->tb3,$where);
					
					$msg='';				
					$to='';	
					$player_id='';			
					foreach($result as $rs)			
					{				
						$where = array ('user_id' => $rs->user_id);	
						$result = $this->Adminamodel->get_data($this->tb33,$where);	
										
						if(count($result)>0)		
						{					
							foreach($result as $rs)
							{						
								$player_id.=','.$rs->player_id;
							}
							
						}				
					}
					/* if($player_id!='')
					{
						$player_id=trim($player_id,',');
						
						
						$img = base_url().'assets/img/noti_back.jpg'; 	
						$type_id = '1';	
						$notice_title=$game_not_name;
						$notification_content=$open_number.'-'.$win_number_not;
						$this->volanlib->sendnotification($player_id, $notice_title, $notification_content, $img, $type_id);
					} */			
					//echo "<pre>";print_r($array);die;
					
					/* $url = base_url().'open-result-notification-continusly';
					$curl = curl_init();                
					$post['game_not_name'] = $game_not_name; 
					$post['open_number'] = $open_number; 
					$post['win_number_not'] = $win_number_not; 
					curl_setopt($curl, CURLOPT_URL, $url);
					curl_setopt ($curl, CURLOPT_POST, TRUE);
					curl_setopt ($curl, CURLOPT_POSTFIELDS, $post); 

					curl_setopt($curl, CURLOPT_USERAGENT, 'api');

					curl_setopt($curl, CURLOPT_TIMEOUT, 1); 
					curl_setopt($curl, CURLOPT_HEADER, 0);
					curl_setopt($curl,  CURLOPT_RETURNTRANSFER, true);
					curl_setopt($curl, CURLOPT_FORBID_REUSE, true);
					curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1);
					curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 10); 

					curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);

					curl_exec($curl);   

					curl_close($curl);  */
					
					
					$data['status'] = "success"; 
					$data['open_decleare_status'] = 1; 
					$data['open_decleare_date'] = $this->insert_date; 
					$data['msg'] = $this->volanlib->success("Successfully done.");
			}
			
		}
		

		echo json_encode($data); 

	}
	
	
	function openResultNotificationContinusly()
	{
		
		ob_end_clean(); 
		header("Connection: close\r\n"); 
		header("Content-Encoding: none\r\n"); 
		header("Content-Length: 1"); 
		ignore_user_abort(true); 
		
		$game_not_name=$_POST['game_not_name'];
		$open_number=$_POST['open_number'];
		$win_number_not=$_POST['win_number_not'];
		
		$where = array('notification_status' => 1);	
			$result = $this->Adminamodel->get_data($this->tb3,$where);
			
			$msg='';				
			foreach($result as $rs)			
			{				
				$where = array ('user_id' => $rs->user_id);	
				$result = $this->Adminamodel->get_data($this->tb33,$where);	
				$player_id='';				
				if(count($result)>0)		
				{					
					foreach($result as $rs)
					{						
						$player_id.=','.$rs->player_id;
					}
					$player_id=trim($player_id,',');
					$to = $player_id;
					$array[]=$to;
 					$img = base_url().'assets/img/noti_back.jpg'; 	
					$type_id = '1';	
					$notice_title=$game_not_name;
					$notification_content=$open_number.'-'.$win_number_not;
					$this->volanlib->sendnotification($to, $notice_title, $notification_content, $img, $type_id);
				}				
			}
	}
	
	
	
	
	
	public function decleareCloseData()
	{
		
		$game_id=$this->input->post('game_id');
		$id=$this->input->post('id');
		$result_dec_date = trim($this->input->post('result_dec_date'));
		$where=array('game_id'=>$game_id,'close_number!='=>"",'result_date'=>$result_dec_date);	
		$result = $this->Adminamodel->get_data($this->tb21,$where);
		
		if(count($result)<1)
		{
			$data['status'] = "error"; 
			$data['msg'] = $this->volanlib->error("Please save game result first");
		}
		else
		{
			foreach($result as $rs)
			{
					$open_number=$rs->open_number;
					$close_number=$rs->close_number;
					$close_decleare_status=$rs->close_decleare_status;
			}
			
			if($close_decleare_status == 1){
					$data['status'] = "success"; 
					$data['msg'] = $this->volanlib->success("Result already decleared.");
			}else {
				
			
					$where=array('game_id'=>$game_id);	
					$game_name_result = $this->Adminamodel->get_data($this->tb16,$where);
					foreach($game_name_result as $rs)
					{
							$game_not_name=$rs->game_name;
					}
					
					$win_number_not=$open_number[0]+$open_number[1]+$open_number[2];
					$win_number_close_not=$close_number[0]+$close_number[1]+$close_number[2];
					
					if($win_number_not>9)
						$win_number_not=$win_number_not%10;
					
					if($win_number_close_not>9)
						$win_number_close_not=$win_number_close_not%10;
				
					
					$game_rates=$this->Adminamodel->getData($this->tb10);
					foreach($game_rates as $rs)
					{
						$single_digit_val_2=$rs->single_digit_val_2;
						$jodi_digit_val_2=$rs->jodi_digit_val_2;
						$single_pana_val_2=$rs->single_pana_val_2;
						$double_pana_val_2=$rs->double_pana_val_2;
						$tripple_pana_val_2=$rs->tripple_pana_val_2;
						$half_sangam_val_2=$rs->half_sangam_val_2;
						$full_sangam_val_2=$rs->full_sangam_val_2;
					}
					
					$where=array($this->tb18.'.game_id'=>$game_id,'pay_status'=>0,'bid_date'=>$result_dec_date,'session!='=>'Open');	
					$joins = array(

							array(

								'table' => $this->tb16,
								'condition' => $this->tb16.'.game_id = '.$this->tb18.'.game_id',
								'jointype' => 'LEFT'
								)

						);
						
				$columns=$this->tb16.".game_name,pana,user_id,bid_id,session,digits,closedigits,points,bid_tx_id,pay_status";
				$by = 'bid_id';

				$result= $this->Adminamodel->get_joins_where_by($this->tb18,$columns,$joins,$by,$where);
				
				$close_result_token=$this->volanlib->uniqRandom(15);

					
					foreach($result as $rs)
					{
						
						
						

						
						if($rs->pana=='Single Digit')
						{
							$win_number=$close_number[0]+$close_number[1]+$close_number[2];
							if($win_number>9)
							$win_number=$win_number%10;
							if($win_number==$rs->digits)
							{
								$win_amt=($single_digit_val_2/10)*$rs->points;
								
								//$msg='Amount won in '.$rs->game_name.' '.$rs->pana.' '.$rs->session.' session for Bid Number- '.$rs->bid_tx_id;
								
								$msg=$rs->game_name.' in '.$rs->pana.' '.'(Session- '.$rs->session.') for bid amount- '.$rs->points.' Won';
								
								$this->updateCloseUserWallet($rs->user_id,$win_amt,$msg,$close_result_token,$rs->bid_tx_id);
								
								$where=array('bid_id'=>$rs->bid_id);
								$up_data=array('pay_status'=>1,"close_result_token"=>$close_result_token);
								$this->Admincmodel->update_where($this->tb18,$up_data,$where);
								
								$insert_data = array(
								'user_id' => $rs->user_id,
								'bid_tx_id' => $rs->bid_tx_id,
								'close_result_token' => $close_result_token,
								'msg' => "Congratulations ,You Won in ".$rs->game_name." for Bid Number- ".$rs->bid_tx_id,
								'insert_date' => $this->insert_date
								);
								$this->Adminbmodel->insertData($insert_data,$this->tb22);
								
								//$title="Congratulations ,Winner in".$rs->game_name." for Bid Number- ".$rs->bid_tx_id;
								//$this->sendUserNotification($rs->user_id,$title,$msg);
								
							}
						}
						else if($rs->pana=='Half Sangam')
						{
							$win_number2=$close_number[0]+$close_number[1]+$close_number[2];
							
							if($win_number2>9)
							$win_number2=$win_number2%10;
						
					if($win_number2==$rs->digits && $open_number==$rs->closedigits)
							{
								$win_amt=($half_sangam_val_2/10)*$rs->points;
								
								//$msg='Amount won in '.$rs->game_name.' '.$rs->pana.' '.$rs->session.' session for Bid Number- '.$rs->bid_tx_id;
								
								$msg=$rs->game_name.' in '.$rs->pana.' '.'(Session- '.$rs->session.') for bid amount- '.$rs->points.' Won';
								
								$this->updateCloseUserWallet($rs->user_id,$win_amt,$msg,$close_result_token,$rs->bid_tx_id);
								
								$where=array('bid_id'=>$rs->bid_id);
								$up_data=array('pay_status'=>1,"close_result_token"=>$close_result_token);
								$this->Admincmodel->update_where($this->tb18,$up_data,$where);
								
								$insert_data = array(
								'user_id' => $rs->user_id,
								'bid_tx_id' => $rs->bid_tx_id,
								'close_result_token' => $close_result_token,
								'msg' => "Congratulations ,You Won in ".$rs->game_name." for Bid Number- ".$rs->bid_tx_id,
								'insert_date' => $this->insert_date
								);
								$this->Adminbmodel->insertData($insert_data,$this->tb22);
								
								//$title="Congratulations ,Winner in".$rs->game_name." for Bid Number- ".$rs->bid_tx_id;
								//$this->sendUserNotification($rs->user_id,$title,$msg);
							}
						}
						else if($rs->pana=='Full Sangam')
						{
							$win_number=$open_number;
							$win_number=$close_number;
							
							if($open_number==$rs->digits && $close_number==$rs->closedigits)
							{
								$win_amt=($full_sangam_val_2/10)*$rs->points;
								
								//$msg='Amount won in '.$rs->game_name.' '.$rs->pana.' for Bid Number- '.$rs->bid_tx_id;;
								
								$msg=$rs->game_name.' in '.$rs->pana.' '.'(Session- N/A) for bid amount- '.$rs->points.' Won';
								
								$this->updateCloseUserWallet($rs->user_id,$win_amt,$msg,$close_result_token,$rs->bid_tx_id);
								
								$where=array('bid_id'=>$rs->bid_id);
								$up_data=array('pay_status'=>1,'close_result_token'=>$close_result_token);
								$this->Admincmodel->update_where($this->tb18,$up_data,$where);
								
								$insert_data = array(
								'user_id' => $rs->user_id,
								'bid_tx_id' => $rs->bid_tx_id,
								'close_result_token' => $close_result_token,
								'msg' => "Congratulations ,You Won in ".$rs->game_name." for Bid Number- ".$rs->bid_tx_id,
								'insert_date' => $this->insert_date
								);
								$this->Adminbmodel->insertData($insert_data,$this->tb22);
								
								//$title="Congratulations ,Winner in".$rs->game_name." for Bid Number- ".$rs->bid_tx_id;
								//$this->sendUserNotification($rs->user_id,$title,$msg);
							}
						}
						else if($rs->pana=='Triple Pana')
						{
							if($close_number==$rs->digits)
							{
								$win_amt=($tripple_pana_val_2/10)*$rs->points;
								
								//$msg='Amount won in '.$rs->game_name.' '.$rs->pana.' '.$rs->session.' session for Bid Number- '.$rs->bid_tx_id;
								
								$msg=$rs->game_name.' in '.$rs->pana.' '.'(Session- '.$rs->session.') for bid amount- '.$rs->points.' Won';
								
								$this->updateCloseUserWallet($rs->user_id,$win_amt,$msg,$close_result_token,$rs->bid_tx_id);
								
								$where=array('bid_id'=>$rs->bid_id);
								$up_data=array('pay_status'=>1,"close_result_token"=>$close_result_token);
								$this->Admincmodel->update_where($this->tb18,$up_data,$where);
								
								$insert_data = array(
								'user_id' => $rs->user_id,
								'bid_tx_id' => $rs->bid_tx_id,
								'close_result_token' => $close_result_token,
								'msg' => "Congratulations ,You Won in ".$rs->game_name." for Bid Number- ".$rs->bid_tx_id,
								'insert_date' => $this->insert_date
								);
								$this->Adminbmodel->insertData($insert_data,$this->tb22);
								
								//$title="Congratulations ,Winner in".$rs->game_name." for Bid Number- ".$rs->bid_tx_id;
								//$this->sendUserNotification($rs->user_id,$title,$msg);
							}
						}
						else if($rs->pana=='Double Pana')
						{
							if($close_number==$rs->digits)
							{
								$win_amt=($double_pana_val_2/10)*$rs->points;
								
								//$msg='Amount won in '.$rs->game_name.' '.$rs->pana.' '.$rs->session.' session for Bid Number- '.$rs->bid_tx_id;
								
								$msg=$rs->game_name.' in '.$rs->pana.' '.'(Session- '.$rs->session.') for bid amount- '.$rs->points.' Won';
								
								$this->updateCloseUserWallet($rs->user_id,$win_amt,$msg,$close_result_token,$rs->bid_tx_id);
								
								$where=array('bid_id'=>$rs->bid_id);
								$up_data=array('pay_status'=>1,"close_result_token"=>$close_result_token);
								$this->Admincmodel->update_where($this->tb18,$up_data,$where);
								
								$insert_data = array(
								'user_id' => $rs->user_id,
								'bid_tx_id' => $rs->bid_tx_id,
								'close_result_token' => $close_result_token,
								'msg' => "Congratulations ,You Won in ".$rs->game_name." for Bid Number- ".$rs->bid_tx_id,
								'insert_date' => $this->insert_date
								);
								$this->Adminbmodel->insertData($insert_data,$this->tb22);
								
								//$title="Congratulations ,Winner in".$rs->game_name." for Bid Number- ".$rs->bid_tx_id;
								//$this->sendUserNotification($rs->user_id,$title,$msg);
							}
						}
						
						else if($rs->pana=='Single Pana')
						{
							if($close_number==$rs->digits)
							{
								$win_amt=($single_pana_val_2/10)*$rs->points;
								
								//$msg='Amount won in '.$rs->game_name.' '.$rs->pana.' '.$rs->session.' session for Bid Number- '.$rs->bid_tx_id;
								
								$msg=$rs->game_name.' in '.$rs->pana.' '.'(Session- '.$rs->session.') for bid amount- '.$rs->points.' Won';
								
								$this->updateCloseUserWallet($rs->user_id,$win_amt,$msg,$close_result_token,$rs->bid_tx_id);
								
								$where=array('bid_id'=>$rs->bid_id);
								$up_data=array('pay_status'=>1,"close_result_token"=>$close_result_token);
								$this->Admincmodel->update_where($this->tb18,$up_data,$where);
								
								$insert_data = array(
								'user_id' => $rs->user_id,
								'bid_tx_id' => $rs->bid_tx_id,
								'close_result_token' => $close_result_token,
								'msg' => "Congratulations ,You Won in ".$rs->game_name." for Bid Number- ".$rs->bid_tx_id,
								'insert_date' => $this->insert_date
								);
								$this->Adminbmodel->insertData($insert_data,$this->tb22);
								
								//$title="Congratulations ,Winner in".$rs->game_name." for Bid Number- ".$rs->bid_tx_id;
								//$this->sendUserNotification($rs->user_id,$title,$msg);
								
							}
						}
						
						else if($rs->pana=='Jodi Digit')
						{
							$win_number1=$close_number[0]+$close_number[1]+$close_number[2];
							$win_number2=$open_number[0]+$open_number[1]+$open_number[2];
							
							if($win_number1>9)
							$win_number1=$win_number1%10;
						
							if($win_number2>9)
							$win_number2=$win_number2%10;
							
							$win_number=$win_number2.$win_number1;
							if($win_number==$rs->digits)
							{
								$win_amt=($jodi_digit_val_2/10)*$rs->points;
								
								//$msg='Amount won in '.$rs->game_name.' '.$rs->pana.' '.$rs->session.' session for Bid Number- '.$rs->bid_tx_id;
								
								$msg=$rs->game_name.' in '.$rs->pana.' '.'(Session- N/A) for bid amount- '.$rs->points.' Won';
								
								$this->updateCloseUserWallet($rs->user_id,$win_amt,$msg,$close_result_token,$rs->bid_tx_id);
								
								$where=array('bid_id'=>$rs->bid_id);
								$up_data=array('pay_status'=>1,"close_result_token"=>$close_result_token);
								$this->Admincmodel->update_where($this->tb18,$up_data,$where);
								
								$insert_data = array(
								'user_id' => $rs->user_id,
								'bid_tx_id' => $rs->bid_tx_id,
								'msg' => "Congratulations ,You Won in ".$rs->game_name." for Bid Number- ".$rs->bid_tx_id,
								'insert_date' => $this->insert_date
								);
								$this->Adminbmodel->insertData($insert_data,$this->tb22);
								
								//$title="Congratulations ,Winner in".$rs->game_name." for Bid Number- ".$rs->bid_tx_id;
								///$this->sendUserNotification($rs->user_id,$title,$msg);
							}
						}
						
					}
					
					
					$where=array($this->tb18.'.game_id'=>$game_id,'pay_status'=>0,'bid_date'=>$result_dec_date,'session'=>'Open','pana'=>'Half Sangam');	
					$joins = array(

										array(

											'table' => $this->tb16,
											'condition' => $this->tb16.'.game_id = '.$this->tb18.'.game_id',
											'jointype' => 'LEFT'
											)

									);
									
					$columns=$this->tb16.".game_name,pana,user_id,bid_id,session,digits,closedigits,points,bid_tx_id,pay_status";
					$by = 'bid_id';

					$result= $this->Adminamodel->get_joins_where_by($this->tb18,$columns,$joins,$by,$where);			
					foreach($result as $rs)
					{
						if($rs->pana=='Half Sangam')
						{
							$win_number2=$open_number[0]+$open_number[1]+$open_number[2];
							
							if($win_number2>9)
							$win_number2=$win_number2%10;
						
							if($close_number==$rs->closedigits && $win_number2==$rs->digits)
							{
								$win_amt=($half_sangam_val_2/10)*$rs->points;
								
								//$msg='Amount won in '.$rs->game_name.' '.$rs->pana.' '.$rs->session.' session for Bid Number- '.$rs->bid_tx_id;
								
								$msg=$rs->game_name.' in '.$rs->pana.' '.'(Session- '.$rs->session.') for bid amount- '.$rs->points.' Won';
								
								$this->updateCloseUserWallet($rs->user_id,$win_amt,$msg,$close_result_token,$rs->bid_tx_id);
								
								$where=array('bid_id'=>$rs->bid_id);
								$up_data=array('pay_status'=>1,"close_result_token"=>$close_result_token);
								$this->Admincmodel->update_where($this->tb18,$up_data,$where);
								
								$insert_data = array(
								'user_id' => $rs->user_id,
								'bid_tx_id' => $rs->bid_tx_id,
								'close_result_token' => $close_result_token,
								'msg' => "Congratulations ,You Won in ".$rs->game_name." for Bid Number-".$rs->bid_tx_id,
								'insert_date' => $this->insert_date
								);
								$this->Adminbmodel->insertData($insert_data,$this->tb22);
								
								//$title="Congratulations ,Winner in".$rs->game_name." for Bid Number- ".$rs->bid_tx_id;
								//$this->sendUserNotification($rs->user_id,$title,$msg);
							}
						}
						
						
					}
					
					$where=array('game_id'=>$game_id,'close_number!='=>"",'result_date'=>$result_dec_date);	
					$up_data=array('close_decleare_status'=>1,'close_decleare_date'=>$this->insert_date,"close_result_token"=>$close_result_token);
					$this->Admincmodel->update_where($this->tb21,$up_data,$where);
					
					
					$where = array('notification_status' => 1);	
					$result = $this->Adminamodel->get_data($this->tb3,$where);
					
					$msg='';	
					$player_id='';	
					
					foreach($result as $rs)			
					{				
						$where = array ('user_id' => $rs->user_id);	
						$result = $this->Adminamodel->get_data($this->tb33,$where);	
										
						if(count($result)>0)		
						{					
							foreach($result as $rs)
							{						
								$player_id.=','.$rs->player_id;
							}
							
						}				
					}
					
					if($player_id!='')
					{
						$player_id=trim($player_id,',');
						
						
						$img = base_url().'assets/img/noti_back.jpg'; 	
						$type_id = '1';	
						$notice_title=$game_not_name;
						$notification_content=$open_number.'-'.$win_number_not.$win_number_close_not.'-'.$close_number;
						
						$this->volanlib->sendnotification($player_id, $notice_title, $notification_content, $img, $type_id);
					}
					
					/* foreach($result as $rs)			
					{				
						$where = array ('user_id' => $rs->user_id);	
						$result = $this->Adminamodel->get_data($this->tb33,$where);	
						$player_id='';				
						if(count($result)>0)		
						{					
							foreach($result as $rs)
							{						
								$player_id.=','.$rs->player_id;
							}
							$player_id=trim($player_id,',');
							$to = $player_id;
							$array[]=$to;
							$img = base_url().'assets/img/noti_back.jpg'; 	
							$type_id = '1';	
						
							
							$notice_title=$game_not_name;
							$notification_content=$open_number.'-'.$win_number_not.$win_number_close_not.'-'.$close_number;
							$this->volanlib->sendnotification($to, $notice_title, $notification_content, $img, $type_id);
						}				
					}  */
					
					
					$data['status'] = "success"; 
					$data['close_decleare_status'] = 1; 
					$data['close_decleare_date'] = $this->insert_date; 
					$data['msg'] = $this->volanlib->success("Successfully done.");
			}
		}
		

		echo json_encode($data); 

	}
	
	
	public function updateUserWallet($user_id,$win_amount,$msg,$open_result_token,$bid_tx_id)
	{
		$where=array('user_id'=>$user_id);
		$col='wallet_balance';
		$this->Adminamodel->updateSetDataAddAmount($this->tb3,$where,$col,$win_amount);
		
		$request_number = $this->randomNumber();
		$history_data = array(
				'user_id' => $user_id,
				'amount' => $win_amount,
				'transaction_type' => 1,
				'transaction_note' => $msg,
				'amount_status' => 8,
				'tx_request_number' => $request_number,
				'open_result_token' => $open_result_token,
				'bid_tx_id' => $bid_tx_id,
				'insert_date' => $this->insert_date
		);
		$this->Adminbmodel->insertData($history_data,$this->tb14);
				

	}
	
	public function updateCloseUserWallet($user_id,$win_amount,$msg,$close_result_token,$bid_tx_id)
	{
		$where=array('user_id'=>$user_id);
		$col='wallet_balance';
		$this->Adminamodel->updateSetDataAddAmount($this->tb3,$where,$col,$win_amount);
		
		$request_number = $this->randomNumber();
		$history_data = array(
				'user_id' => $user_id,
				'amount' => $win_amount,
				'transaction_type' => 1,
				'transaction_note' => $msg,
				'amount_status' => 8,
				'tx_request_number' => $request_number,
				'close_result_token' => $close_result_token,
				'bid_tx_id' => $bid_tx_id,
				'insert_date' => $this->insert_date
		);
		$this->Adminbmodel->insertData($history_data,$this->tb14);
				

	}
	
	
	public function getCloseData()
	{
		$close_number=$this->input->post('close_number');
		$close_num=$close_number[0]+$close_number[1]+$close_number[2];
		
		if($close_num<10)
		$data['close_result']=$close_num;
				
		if($close_num>9)
		$data['close_result']=$close_num%10;
		
		$data['status'] = "success";
		echo json_encode($data); 

	}
	
	public function saveCloseData()
	{
		
		$close_number=$this->input->post('close_number');
		$game_id=$this->input->post('game_id');
		$id=$this->input->post('id');
		$result_dec_date = trim($this->input->post('result_dec_date'));
		$insert_data = array(
						'close_number'=>$close_number,
						'game_id'=>$game_id,
						'result_date'=>$result_dec_date,
						);

				
		$where=array('game_id'=>$game_id,'result_date'=>$result_dec_date);	
		$result = $this->Adminamodel->get_data($this->tb21,$where);
		$open_decleare_status = 0;
		$close_decleare_status = 0;
		if(count($result)>0)
		{
			foreach($result as $ks)
			{
				$open_decleare_status = $ks->open_decleare_status;
				$close_decleare_status = $ks->close_decleare_status;
			}
		}
		
		if($close_decleare_status == 1)
		{
			$data['status'] = "error"; 
			$data['msg'] = $this->volanlib->error("Result already decleared");
		}else {
			if(count($result)<1)
			{
				/* $this->Adminbmodel->insertData($insert_data,$this->tb21); */
				$data['status'] = "error"; 
				/* $data['msg'] = $this->volanlib->success("Successfully inserted."); */
				$data['msg'] = $this->volanlib->error("Please Declare Open Result First");
			}
			else
			{
				if($open_decleare_status == 1){
					//$where=array('id'=>$id);
					$this->Admincmodel->update_where($this->tb21,$insert_data,$where);
					$data['status'] = "success"; 
					$data['msg'] = $this->volanlib->success("Successfully Saved.");
				}else {
					$data['status'] = "error"; 
					$data['msg'] = $this->volanlib->error("Please Declare Open Result First.");
				}
				
			}
			
			$close_num=$close_number[0]+$close_number[1]+$close_number[2];
			
			if($close_num<10)
			$data['close_result']=$close_num;
					
			if($close_num>9)
			$data['close_result']=$close_num%10;
			
		}
		echo json_encode($data); 

	}
	
	
	public function getWinningHistoryData()

	{

		$result_date = $this->input->post('result_date');
		$game_name = $this->input->post('win_game_name');
		$market_status = $this->input->post('win_market_status');
		$result_date = date('Y-m-d',strtotime($result_date));
		
		
		$where=array('game_id'=>$game_name,'result_date'=>$result_date);	
		$result = $this->Adminamodel->get_data($this->tb21,$where);
		$open_decleare_status=0;
		$close_decleare_status=0;
		foreach($result as $rs)
		{
			$open_decleare_status=$rs->open_decleare_status;
			$close_decleare_status=$rs->close_decleare_status;
			$open_result_token=$rs->open_result_token;
			$close_result_token=$rs->close_result_token;
		}
		
		if($market_status==1)
		{
			
			
			if($open_decleare_status==1)
			{
				
				$where = array('DATE('.$this->tb14.'.insert_date)' => $result_date,$this->tb18.'.game_id'=>$game_name,$this->tb14.'.open_result_token'=>$open_result_token);
				
				$joins = array(
						array(

								'table' => $this->tb18,

								'condition' => $this->tb18.'.bid_tx_id = '.$this->tb14.'.bid_tx_id',

								'jointype' => 'LEFT'

							),
							array(

							'table' => $this->tb3,

							'condition' => $this->tb3.'.user_id = '.$this->tb18.'.user_id',

							'jointype' => 'LEFT'
	
						),
						

				);
				

				$columns="user_name,".$this->tb14.".user_id,".$this->tb18.".game_name,".$this->tb18.".session,".$this->tb14.".amount,transaction_note,transaction_note,tx_request_number,".$this->tb14.'.insert_date,pana,digits,closedigits,points,bid_id,'.$this->tb18.'.bid_tx_id';

				$by = 'transaction_id';

				$data['getResultHistory']= $this->Adminamodel->get_joins_where_by($this->tb14,$columns,$joins,$by,$where);
								
			}
			else
			{
				$data['getResultHistory']= array();
			}
			
			
			
		}
		else
		{
			if($close_decleare_status==1)
			{
				
				$where = array('DATE('.$this->tb14.'.insert_date)' => $result_date,$this->tb18.'.game_id'=>$game_name,$this->tb14.'.close_result_token'=>$close_result_token);
				
				$joins = array(
						array(

								'table' => $this->tb18,

								'condition' => $this->tb18.'.bid_tx_id = '.$this->tb14.'.bid_tx_id',

								'jointype' => 'LEFT'

							),
							array(

							'table' => $this->tb3,

							'condition' => $this->tb3.'.user_id = '.$this->tb18.'.user_id',

							'jointype' => 'LEFT'
	
						),
						
				);
				
				$columns="user_name,".$this->tb14.".user_id,".$this->tb18.".game_name,".$this->tb18.".session,".$this->tb14.".amount,transaction_note,transaction_note,tx_request_number,".$this->tb14.'.insert_date,pana,digits,closedigits,points,bid_id,'.$this->tb18.'.bid_tx_id';

				$by = 'transaction_id';

				$data['getResultHistory']= $this->Adminamodel->get_joins_where_by($this->tb14,$columns,$joins,$by,$where);
								
			}
			else
			{
				$data['getResultHistory']= '';
			}
		}


		echo json_encode($data);

	}

	public function resultHistory()
	{
		if($this->session->userdata('adminlogin') == 1)
		{
			$this->data['title'] = "Result History";
			$this->data['banner_title'] = "Result History";
			$this->data['banner_title2'] = "Result History";
			$this->data['active_menu'] = 'result_history';
			$this->data['master_menu'] = 'result_management';
			$this->data['resultHistoryListTableFlag'] = 1;
			$this->middle = 'admin/w'; 
			$this->layout();
		}
		else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}
    }
	
	public function resultHistoryListGridData()
	{
		$columns = array( 
			0 => 'id',
			1 => 'game_id',
			2 => 'result_date',
			3 => 'open_decleare_date',
			4 => 'close_decleare_date',
			5 => 'open_number',
			6 => 'close_number'
		);
		
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		
		$sql = "SELECT id,b.game_id,date_format(result_date,'%d %b %Y') as result_date,date_format(open_decleare_date,'%d %b %Y %r') as open_decleare_date,date_format(close_decleare_date,'%d %b %Y %r') as close_decleare_date,b.game_name,open_number,close_number,open_decleare_status,close_decleare_status";
		$sql.=" FROM ".$this->tb21." LEFT JOIN ".$this->tb16." b ON b.game_id = ".$this->tb21.".game_id WHERE 1=1";

		$totalData = $this->Adminamodel->data_search_count($sql);	
		$totalFiltered = $totalData;
		
		if(!empty($this->input->post('search')['value'])){
			$search = $this->input->post('search')['value'];
			$sql.= " AND (result_date LIKE '".$search."%' ";
			$sql.=" OR b.game_id LIKE '".$search."%' )";
				
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
			$close_res = '';
			$game_name = '';
			$open_num = '';
			$result_open = '';
			$result_close = '';
			foreach($tb_data as $rs )
			{
				$nestedData = array();
				
				$nestedData['#'] = $i;
				$game_id = $rs->game_id;
				
				$nestedData['game_name'] = $rs->game_name;
				$nestedData['result_date'] = $rs->result_date;
				if($rs->open_decleare_date == null){
					$open_date = 'N/A';
				}else {
					$open_date = $rs->open_decleare_date;
				}
				$nestedData['open_date'] = $open_date;
				if($rs->close_decleare_date == null){
					$close_date = 'N/A';
				}else {
					$close_date = $rs->close_decleare_date;
				}
				$nestedData['close_date'] = $close_date;
				if($rs->open_number!=''){
					$open_num=$rs->open_number[0]+$rs->open_number[1]+$rs->open_number[2];
					if($open_num<10){
						if($rs->open_decleare_status == 0){
							$nestedData['open_result'] = '<span class="td_color_1">'.$rs->open_number.'-'.$open_num.'<span>';
						}else{
							$nestedData['open_result'] = '<span class="td_color_2">'.$rs->open_number.'-'.$open_num.'<span>';
						}
					}else if($open_num>9){
						if($rs->open_decleare_status == 0){
							$result_open = $rs->open_number.'-'.$open_num%10;
						$nestedData['open_result'] = '<span class="td_color_1">'.$result_open.'</span>';
						}else{
							$result_open = $rs->open_number.'-'.$open_num%10;
						$nestedData['open_result'] = '<span class="td_color_2">'.$result_open.'</span>';
						}
					}
				}else {
					$nestedData['open_result']= '<span class="sub_s td_color_1">***</span><span class="hyphen">-</span><span class="sub_s td_color_1">*</span>';
				}
				
				
				if($rs->close_number!=''){
					$close_num=$rs->close_number[0]+$rs->close_number[1]+$rs->close_number[2];
					if($close_num<10){
						if($rs->close_decleare_status == 0){
							$nestedData['close_result']='<span class="td_color_1">'.$close_num.'-'.$rs->close_number.'<span>';
						}else{
							$nestedData['close_result']='<span class="td_color_2">'.$close_num.'-'.$rs->close_number.'<span>';
						}
					}else if($close_num>9){
						if($rs->close_decleare_status == 0){
							$close_res = $close_num%10;
							$nestedData['close_result']='<span class="td_color_1">'.$close_res.'-'.$rs->close_number.'<span>';
						}else{
							$close_res = $close_num%10;
							$nestedData['close_result']='<span class="td_color_2">'.$close_res.'-'.$rs->close_number.'<span>';
						}
					} 
				}else {
					$nestedData['close_result']= '<span class="sub_s td_color_1">*</span><span class="hyphen">-</span><span class="sub_s td_color_1">***</span>';
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
	
	
	public function deleteOpenResultData()
	{
		///echo "<pre>";print_r($_POST);die;
		$game_id=$this->input->post('game_id');
		$id=$this->input->post('id');
		
		$result_dec_date = trim($this->input->post('result_dec_date'));
		
		$where=array('game_id'=>$game_id,'result_date'=>$result_dec_date);	
		$result = $this->Adminamodel->get_data($this->tb21,$where);
		
		if(count($result)<1)
		{

			$data['status'] = "error"; 
			$data['msg'] = $this->volanlib->error("Game result is not decleare yet");

		}

		else
		{
			foreach($result as $rs)
			{
				$open_result_token=$rs->open_result_token;
			}
			if($open_result_token!='')
			{
				$where=array('open_result_token'=>$open_result_token);
				$up_data=array('pay_status'=>0);
				$this->Admincmodel->update_where($this->tb18,$up_data,$where);
				
				//echo "<pre>";print_r($where);die;
				
				$this->deductUserWallet($open_result_token);
				
				$where_array=array('open_result_token'=>$open_result_token);
				
				$this->Admindmodel->delete($this->tb21,$where_array);
				$this->Admindmodel->delete($this->tb22,$where_array);
			}
			
			
			$data['status'] = "success"; 
			
			$data['msg'] = $this->volanlib->success("Result Successfully done.");

		}
		

		echo json_encode($data); 

	}
	
	
	public function deductUserWallet($open_result_token)
	{
		
		$where=array('open_result_token'=>$open_result_token);	
		$result = $this->Adminamodel->get_data($this->tb14,$where);
		
		foreach($result as $rs)
		{
		
			$where=array('user_id'=>$rs->user_id);
			$col='wallet_balance';
			$this->Adminamodel->updateSetDataMinusAmount($this->tb3,$where,$col,$rs->amount);
			
			$where_array=array('user_id'=>$rs->user_id,'transaction_id'=>$rs->transaction_id);
			
			$this->Admindmodel->delete($this->tb14,$where_array);
			
		
		}
				

	}
	
	
	public function deleteCloseResultData()
	{
		$game_id=$this->input->post('game_id');
		$id=$this->input->post('id');
		
		$result_dec_date = trim($this->input->post('result_dec_date'));
		
		$where=array('game_id'=>$game_id,'result_date'=>$result_dec_date);	
		$result = $this->Adminamodel->get_data($this->tb21,$where);
		
		if(count($result)<1)
		{

			$data['status'] = "error"; 
			$data['msg'] = $this->volanlib->error("Game result is not decleare yet");

		}

		else
		{
			foreach($result as $rs)
			{
				$close_result_token=$rs->close_result_token;
			}
			if($close_result_token!='')
			{
				$where=array('close_result_token'=>$close_result_token);
				$up_data=array('pay_status'=>0,'close_result_token'=>'');
				$this->Admincmodel->update_where($this->tb18,$up_data,$where);
				
				
				
				$this->deductUserCloseWallet($close_result_token);
				
				$where_array=array('close_result_token'=>$close_result_token);
				
				
				
				$where=array('close_result_token'=>$close_result_token);	
				$up_data=array('close_number'=>'','close_decleare_status'=>0,'close_decleare_date'=>'0000-00-00 00:00:00',"close_result_token"=>'',);
				$this->Admincmodel->update_where($this->tb21,$up_data,$where);
				
				
				
				
				$this->Admindmodel->delete($this->tb22,$where_array);

			}
			
			$data['status'] = "success"; 
			
			$data['msg'] = $this->volanlib->success("Result Successfully deleted.");

		}
		

		echo json_encode($data); 

	}
	
	
	public function deductUserCloseWallet($close_result_token)
	{
		
		$where=array('close_result_token'=>$close_result_token);	
		$result = $this->Adminamodel->get_data($this->tb14,$where);
		
		foreach($result as $rs)
		{
		
			$where=array('user_id'=>$rs->user_id);
			$col='wallet_balance';
			$this->Adminamodel->updateSetDataMinusAmount($this->tb3,$where,$col,$rs->amount);
			
			$where_array=array('user_id'=>$rs->user_id,'transaction_id'=>$rs->transaction_id);
			
			$this->Admindmodel->delete($this->tb14,$where_array);
			
		
		}
				

	}
	
	
	
	
	public function getOpenWinnerList()
	{
		
		$game_id=$this->input->post('game_id');
		$id=$this->input->post('id');
		
		$result_dec_date = trim($this->input->post('result_dec_date'));
		
		$where=array('game_id'=>$game_id,'open_number!='=>"",'result_date'=>$result_dec_date);	
		$result = $this->Adminamodel->get_data($this->tb21,$where);
		
			foreach($result as $rs)
			{
					$open_number=$rs->open_number;
			}
			
			$game_rates=$this->Adminamodel->getData($this->tb10);
			foreach($game_rates as $rs)
			{
				$single_digit_val_2=$rs->single_digit_val_2;
				$jodi_digit_val_2=$rs->jodi_digit_val_2;
				$single_pana_val_2=$rs->single_pana_val_2;
				$double_pana_val_2=$rs->double_pana_val_2;
				$tripple_pana_val_2=$rs->tripple_pana_val_2;
				$half_sangam_val_2=$rs->half_sangam_val_2;
				$full_sangam_val_2=$rs->full_sangam_val_2;
			}
			
			$where=array($this->tb18.'.game_id'=>$game_id,'pay_status'=>0,'bid_date'=>$result_dec_date,'session'=>'Open');	
			
			
				$joins = array(

					array(

						'table' => $this->tb16,
						'condition' => $this->tb16.'.game_id = '.$this->tb18.'.game_id',
						'jointype' => 'LEFT'
						),
						array(

						'table' => $this->tb3,
						'condition' => $this->tb3.'.user_id = '.$this->tb18.'.user_id',
						'jointype' => 'LEFT'
						)

				);
				
		$columns=$this->tb16.".game_name,".$this->tb3.".user_id,pana,session,digits,closedigits,points,bid_id,bid_tx_id,pay_status,user_name";
		$by = 'bid_id';

		$result= $this->Adminamodel->get_joins_where_by($this->tb18,$columns,$joins,$by,$where);
		
		$data_array=array();
			$i=0;
			
			$win_amt_sum=0;
			$points_amt_sum=0;
			foreach($result as $rs)
			{
				$game_not_name=$rs->game_name;
				$win_number_not=$open_number[0]+$open_number[1]+$open_number[2];
					
				if($win_number_not>9)
				$win_number_not=$win_number_not%10;
			$win_amt=0;
			$points=0;
				
				if($rs->pana=='Single Digit')
				{
					$win_number=$open_number[0]+$open_number[1]+$open_number[2];
					
					if($win_number>9)
					$win_number=$win_number%10;
					
					if($win_number==$rs->digits)
					{
						$win_amt=($single_digit_val_2/10)*$rs->points;
						
						$points=$rs->points;
						
						$data_array[$i]['points']=$rs->points;
						$data_array[$i]['user_id']=$rs->user_id;
						$data_array[$i]['user_name']=$rs->user_name;
						$data_array[$i]['pana']=$rs->pana;
						$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
						$data_array[$i]['win_amt']=$win_amt;
						
					}
				}
				else if($rs->pana=='Triple Pana')
				{
					if($open_number==$rs->digits)
					{
						$win_amt=($tripple_pana_val_2/10)*$rs->points;
						
						$points=$rs->points;
											
						$data_array[$i]['points']=$rs->points;
						$data_array[$i]['user_id']=$rs->user_id;
						$data_array[$i]['user_name']=$rs->user_name;
						$data_array[$i]['pana']=$rs->pana;
						$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
						$data_array[$i]['win_amt']=$win_amt;
					}
				}
				else if($rs->pana=='Double Pana')
				{
					if($open_number==$rs->digits)
					{
						$win_amt=($double_pana_val_2/10)*$rs->points;
						
						$points=$rs->points;
						
						$data_array[$i]['points']=$rs->points;
						$data_array[$i]['user_id']=$rs->user_id;
						$data_array[$i]['user_name']=$rs->user_name;
						$data_array[$i]['pana']=$rs->pana;
						$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
						$data_array[$i]['win_amt']=$win_amt;
					}
				}
				
				else if($rs->pana=='Single Pana')
				{
					if($open_number==$rs->digits)
					{
						$win_amt=($single_pana_val_2/10)*$rs->points;
						
						$points=$rs->points;
						
						$data_array[$i]['user_id']=$rs->user_id;
						$data_array[$i]['points']=$rs->points;
						$data_array[$i]['user_name']=$rs->user_name;
						$data_array[$i]['pana']=$rs->pana;
						$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
						$data_array[$i]['win_amt']=$win_amt;
					}
				}
				$win_amt_sum=$win_amt+$win_amt_sum;
				$points_amt_sum=$points+$points_amt_sum;
				if($win_amt>0)
				$i++;
				
			}
						
			$data['winner_list'] = $data_array; 
			$data['win_amt_sum'] = $win_amt_sum; 
			$data['points_amt_sum'] = $points_amt_sum; 
			$data['status'] = "success"; 
			

		
		

		echo json_encode($data); 

	}
	
	
	
	
	
	public function getCloseWinnerList()
	{
		
		$game_id=$this->input->post('game_id');
		$id=$this->input->post('id');
		$result_dec_date = trim($this->input->post('result_dec_date'));
		$where=array('game_id'=>$game_id,'close_number!='=>"",'result_date'=>$result_dec_date);	
		$result = $this->Adminamodel->get_data($this->tb21,$where);
		
		if(count($result)<1)
		{

			$data['status'] = "error"; 
			$data['msg'] = $this->volanlib->error("Please save game result first");

		}

		else
		{
			foreach($result as $rs)
			{
					$open_number=$rs->open_number;
					$close_number=$rs->close_number;
			}
			
			$game_rates=$this->Adminamodel->getData($this->tb10);
			foreach($game_rates as $rs)
			{
				$single_digit_val_2=$rs->single_digit_val_2;
				$jodi_digit_val_2=$rs->jodi_digit_val_2;
				$single_pana_val_2=$rs->single_pana_val_2;
				$double_pana_val_2=$rs->double_pana_val_2;
				$tripple_pana_val_2=$rs->tripple_pana_val_2;
				$half_sangam_val_2=$rs->half_sangam_val_2;
				$full_sangam_val_2=$rs->full_sangam_val_2;
			}
			
			$where=array($this->tb18.'.game_id'=>$game_id,'pay_status'=>0,'bid_date'=>$result_dec_date,'session!='=>'Open');	
			$joins = array(

					array(

						'table' => $this->tb16,
						'condition' => $this->tb16.'.game_id = '.$this->tb18.'.game_id',
						'jointype' => 'LEFT'
						),
						array(

						'table' => $this->tb3,
						'condition' => $this->tb3.'.user_id = '.$this->tb18.'.user_id',
						'jointype' => 'LEFT'
						)

				);
				
		$columns=$this->tb16.".game_name,".$this->tb3.".user_id,pana,session,digits,closedigits,points,bid_id,bid_tx_id,pay_status,user_name";
		$by = 'bid_id';

		$result= $this->Adminamodel->get_joins_where_by($this->tb18,$columns,$joins,$by,$where);
		
		$data_array=array();
			$i=0;
			
			$win_amt_sum=0;
			$points_amt_sum=0;

			
			foreach($result as $rs)
			{
				
				
				$win_amt=0;
			$points=0;
				
				if($rs->pana=='Single Digit')
				{
					$win_number=$close_number[0]+$close_number[1]+$close_number[2];
					if($win_number>9)
					$win_number=$win_number%10;
					if($win_number==$rs->digits)
					{
						$win_amt=($single_digit_val_2/10)*$rs->points;
						
						$points=$rs->points;
						
						$data_array[$i]['points']=$rs->points;
						$data_array[$i]['user_id']=$rs->user_id;
						$data_array[$i]['user_name']=$rs->user_name;
						$data_array[$i]['pana']=$rs->pana;
						$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
						$data_array[$i]['win_amt']=$win_amt;
						
					}
				}
				else if($rs->pana=='Half Sangam')
				{
					$win_number2=$close_number[0]+$close_number[1]+$close_number[2];
					
					if($win_number2>9)
					$win_number2=$win_number2%10;
				
					if($win_number2==$rs->digits && $open_number==$rs->closedigits)
					{
						$win_amt=($half_sangam_val_2/10)*$rs->points;
						
						$points=$rs->points;
						
						$data_array[$i]['points']=$rs->points;
						$data_array[$i]['user_id']=$rs->user_id;
						$data_array[$i]['user_name']=$rs->user_name;
						$data_array[$i]['pana']=$rs->pana;
						$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
						$data_array[$i]['win_amt']=$win_amt;
						
					}
				}
				else if($rs->pana=='Full Sangam')
				{
					$win_number=$open_number;
					$win_number=$close_number;
					
					if($open_number==$rs->digits && $close_number==$rs->closedigits)
					{
						$win_amt=($full_sangam_val_2/10)*$rs->points;
						
						$points=$rs->points;
						
						$data_array[$i]['points']=$rs->points;
						$data_array[$i]['user_id']=$rs->user_id;
						$data_array[$i]['user_name']=$rs->user_name;
						$data_array[$i]['pana']=$rs->pana;
						$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
						$data_array[$i]['win_amt']=$win_amt;
					}
				}
				else if($rs->pana=='Triple Pana')
				{
					if($close_number==$rs->digits)
					{
						$win_amt=($tripple_pana_val_2/10)*$rs->points;
						
						$points=$rs->points;
						
						$data_array[$i]['points']=$rs->points;
						$data_array[$i]['user_id']=$rs->user_id;
						$data_array[$i]['user_name']=$rs->user_name;
						$data_array[$i]['pana']=$rs->pana;
						$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
						$data_array[$i]['win_amt']=$win_amt;
					}
				}
				else if($rs->pana=='Double Pana')
				{
					if($close_number==$rs->digits)
					{
						$win_amt=($double_pana_val_2/10)*$rs->points;
						
						$points=$rs->points;
						
						$data_array[$i]['points']=$rs->points;
						$data_array[$i]['user_id']=$rs->user_id;
						$data_array[$i]['user_name']=$rs->user_name;
						$data_array[$i]['pana']=$rs->pana;
						$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
						$data_array[$i]['win_amt']=$win_amt;
					}
				}
				
				else if($rs->pana=='Single Pana')
				{
					if($close_number==$rs->digits)
					{
						$win_amt=($single_pana_val_2/10)*$rs->points;
						
						$points=$rs->points;
						
						$data_array[$i]['points']=$rs->points;
						$data_array[$i]['user_id']=$rs->user_id;
						$data_array[$i]['user_name']=$rs->user_name;
						$data_array[$i]['pana']=$rs->pana;
						$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
						$data_array[$i]['win_amt']=$win_amt;
						
					}
				}
				
				else if($rs->pana=='Jodi Digit')
				{
					$win_number1=$close_number[0]+$close_number[1]+$close_number[2];
					$win_number2=$open_number[0]+$open_number[1]+$open_number[2];
					
					if($win_number1>9)
					$win_number1=$win_number1%10;
				
					if($win_number2>9)
					$win_number2=$win_number2%10;
					
					$win_number=$win_number2.$win_number1;
					if($win_number==$rs->digits)
					{
						$win_amt=($jodi_digit_val_2/10)*$rs->points;
						
						$points=$rs->points;
						
						$data_array[$i]['points']=$rs->points;
						$data_array[$i]['user_id']=$rs->user_id;
						$data_array[$i]['user_name']=$rs->user_name;
						$data_array[$i]['pana']=$rs->pana;
						$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
						$data_array[$i]['win_amt']=$win_amt;
					}
				}
				
				$win_amt_sum=$win_amt+$win_amt_sum;
				$points_amt_sum=$points+$points_amt_sum;
				if($win_amt>0)
				$i++;
				
			}
			
			
			$where=array($this->tb18.'.game_id'=>$game_id,'pay_status'=>0,'bid_date'=>$result_dec_date,'session'=>'Open','pana'=>'Half Sangam');	
			$joins = array(

								array(

									'table' => $this->tb16,
									'condition' => $this->tb16.'.game_id = '.$this->tb18.'.game_id',
									'jointype' => 'LEFT'
									),
									array(

										'table' => $this->tb3,
										'condition' => $this->tb3.'.user_id = '.$this->tb18.'.user_id',
										'jointype' => 'LEFT'
										)
									

							);
							
			$columns=$this->tb16.".game_name,pana,bid_id,session,digits,closedigits,points,bid_tx_id,pay_status,user_name,".$this->tb3.'.user_id';
			$by = 'bid_id';

			$result= $this->Adminamodel->get_joins_where_by($this->tb18,$columns,$joins,$by,$where);	
			
/* echo "<pre>";
print_r($result)		;die; */			
			$data_array2=array();
			$i=0;
			
			$win_amt_sum2=0;
			$points_amt_sum2=0;			
			foreach($result as $rs)
			{
				
				$win_amt2=0;
				$points2=0;
				
				if($rs->pana=='Half Sangam')
				{
					$win_number2=$open_number[0]+$open_number[1]+$open_number[2];
					
					if($win_number2>9)
					$win_number2=$win_number2%10;
				
					if($close_number==$rs->closedigits && $win_number2==$rs->digits)
					{
						$win_amt2=($half_sangam_val_2/10)*$rs->points;
						
							$points2=$rs->points;
						
						$data_array2[$i]['points']=$rs->points;
						$data_array2[$i]['user_id']=$rs->user_id;
						$data_array2[$i]['user_name']=$rs->user_name;
						$data_array2[$i]['pana']=$rs->pana;
						$data_array2[$i]['bid_tx_id']=$rs->bid_tx_id;
						$data_array2[$i]['win_amt']=$win_amt2;
						
					}
				}
				
				$win_amt_sum2=$win_amt2+$win_amt_sum2;
				$points_amt_sum2=$points2+$points_amt_sum2;
				if($win_amt2>0)
				$i++;
				
				
			}
			
			
			$data['winner_list'] = array_merge($data_array,$data_array2); 
			$data['win_amt_sum'] = $win_amt_sum+$win_amt_sum2; 
			$data['points_amt_sum'] = $points_amt_sum+$points_amt_sum2; 
			$data['status'] = "success";
			
			

		}
		

		echo json_encode($data); 

	}
	
	
	public function winningPrediction()
	{

		if($this->session->userdata('adminlogin') == 1)
		{
			$this->data['title'] = "Winning Prediction";
			$this->data['banner_title'] = "Winning Prediction";
			$this->data['active_menu'] = 'winning_prediction';
			$this->data['master_menu'] = 'winning_prediction';
			$where = array('status'=>1);
			$this->data['game_result']=$this->Adminamodel->get_data($this->tb16,$where);
			$this->middle = 'admin/v2'; 
			$this->layout();
		}else {
			$myurl = base_url() .admin;
			redirect($myurl);
		}

    }
	
	public function getpredictWinnerList()
	{
		
		$game_id=$this->input->post('win_game_name');
		$id=$this->input->post('id');
		$open_number=$this->input->post('winning_ank');
		$close_number=$this->input->post('close_number');
		
		$result_date = date('Y-m-d',strtotime($this->input->post('result_date')));
		$win_market_status = trim($this->input->post('win_market_status'));
			
		$game_rates=$this->Adminamodel->getData($this->tb10);
		foreach($game_rates as $rs)
		{
			$single_digit_val_2=$rs->single_digit_val_2;
			$jodi_digit_val_2=$rs->jodi_digit_val_2;
			$single_pana_val_2=$rs->single_pana_val_2;
			$double_pana_val_2=$rs->double_pana_val_2;
			$tripple_pana_val_2=$rs->tripple_pana_val_2;
			$half_sangam_val_2=$rs->half_sangam_val_2;
			$full_sangam_val_2=$rs->full_sangam_val_2;
		}
		if($win_market_status==1)
		{		
				$where=array($this->tb18.'.game_id'=>$game_id,'pay_status'=>0,'bid_date'=>$result_date,'session'=>'Open');	
				$joins = array(

					array(

						'table' => $this->tb16,
						'condition' => $this->tb16.'.game_id = '.$this->tb18.'.game_id',
						'jointype' => 'LEFT'
						),
						array(

						'table' => $this->tb3,
						'condition' => $this->tb3.'.user_id = '.$this->tb18.'.user_id',
						'jointype' => 'LEFT'
						)

				);
				
		$columns=$this->tb16.".game_name,".$this->tb3.".user_id,pana,session,digits,closedigits,points,bid_id,bid_tx_id,pay_status,user_name";
		$by = 'bid_id';

		$result= $this->Adminamodel->get_joins_where_by($this->tb18,$columns,$joins,$by,$where);
		
		$data_array=array();
			$i=0;
			
			$win_amt_sum=0;
			$points_amt_sum=0;
			foreach($result as $rs)
			{
				$game_not_name=$rs->game_name;
				$win_number_not=$open_number[0]+$open_number[1]+$open_number[2];
					
				if($win_number_not>9)
				$win_number_not=$win_number_not%10;
			$win_amt=0;
			$points=0;
				
				if($rs->pana=='Single Digit')
				{
					$win_number=$open_number[0]+$open_number[1]+$open_number[2];
					
					if($win_number>9)
					$win_number=$win_number%10;


					if($win_number==$rs->digits)
					{
						$win_amt=($single_digit_val_2/10)*$rs->points;
						
						$points=$rs->points;
						
						$data_array[$i]['points']=$rs->points;
						$data_array[$i]['user_id']=$rs->user_id;
						$data_array[$i]['user_name']=$rs->user_name;
						$data_array[$i]['pana']=$rs->pana;
						$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
						$data_array[$i]['win_amt']=$win_amt;
						$data_array[$i]['bid_id']=$rs->bid_id;
						
					}
				}
				else if($rs->pana=='Triple Pana')
				{
					if($open_number==$rs->digits)
					{
						$win_amt=($tripple_pana_val_2/10)*$rs->points;
						
						$points=$rs->points;
											
						$data_array[$i]['points']=$rs->points;
						$data_array[$i]['user_id']=$rs->user_id;
						$data_array[$i]['user_name']=$rs->user_name;
						$data_array[$i]['pana']=$rs->pana;
						$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
						$data_array[$i]['win_amt']=$win_amt;
						$data_array[$i]['bid_id']=$rs->bid_id;
					}
				}
				else if($rs->pana=='Double Pana')
				{
					if($open_number==$rs->digits)
					{
						$win_amt=($double_pana_val_2/10)*$rs->points;
						
						$points=$rs->points;
						
						$data_array[$i]['points']=$rs->points;
						$data_array[$i]['user_id']=$rs->user_id;
						$data_array[$i]['user_name']=$rs->user_name;
						$data_array[$i]['pana']=$rs->pana;
						$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
						$data_array[$i]['win_amt']=$win_amt;
						$data_array[$i]['bid_id']=$rs->bid_id;
					}
				}
				
				else if($rs->pana=='Single Pana')
				{
					if($open_number==$rs->digits)
					{
						$win_amt=($single_pana_val_2/10)*$rs->points;
						
						$points=$rs->points;
						
						$data_array[$i]['user_id']=$rs->user_id;
						$data_array[$i]['points']=$rs->points;
						$data_array[$i]['user_name']=$rs->user_name;
						$data_array[$i]['pana']=$rs->pana;
						$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
						$data_array[$i]['win_amt']=$win_amt;
						$data_array[$i]['bid_id']=$rs->bid_id;
					}
				}
				$win_amt_sum=$win_amt+$win_amt_sum;
				$points_amt_sum=$points+$points_amt_sum;
				if($win_amt>0)
				$i++;
				
			}
						
			$data['winner_list'] = $data_array; 
			$data['win_amt_sum'] = $win_amt_sum; 
			$data['points_amt_sum'] = $points_amt_sum; 
			$data['status'] = "success"; 
			

	 }
	 else{
		 	$where=array($this->tb18.'.game_id'=>$game_id,'pay_status'=>0,'bid_date'=>$result_date,'session!='=>'Open');	
			$joins = array(

					array(

						'table' => $this->tb16,
						'condition' => $this->tb16.'.game_id = '.$this->tb18.'.game_id',
						'jointype' => 'LEFT'
						),
						array(

						'table' => $this->tb3,
						'condition' => $this->tb3.'.user_id = '.$this->tb18.'.user_id',
						'jointype' => 'LEFT'
						)

				);
				
		$columns=$this->tb16.".game_name,".$this->tb3.".user_id,pana,session,digits,closedigits,points,bid_id,bid_tx_id,pay_status,user_name";
		$by = 'bid_id';

		$result= $this->Adminamodel->get_joins_where_by($this->tb18,$columns,$joins,$by,$where);
		
		$data_array=array();
			$i=0;
			
			$win_amt_sum=0;
			$points_amt_sum=0;

			
			foreach($result as $rs)
			{
				
				
				$win_amt=0;
			$points=0;
				
				if($rs->pana=='Single Digit')
				{
					$win_number=$close_number[0]+$close_number[1]+$close_number[2];
					if($win_number>9)
					$win_number=$win_number%10;
					if($win_number==$rs->digits)
					{
						$win_amt=($single_digit_val_2/10)*$rs->points;
						
						$points=$rs->points;
						
						$data_array[$i]['points']=$rs->points;
						$data_array[$i]['user_id']=$rs->user_id;
						$data_array[$i]['user_name']=$rs->user_name;
						$data_array[$i]['pana']=$rs->pana;
						$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
						$data_array[$i]['win_amt']=$win_amt;
						$data_array[$i]['bid_id']=$rs->bid_id;
						
					}
				}
				else if($rs->pana=='Half Sangam')
				{
					$win_number2=$close_number[0]+$close_number[1]+$close_number[2];
					
					if($win_number2>9)
					$win_number2=$win_number2%10;
				
					if($win_number2==$rs->digits && $open_number==$rs->closedigits)
					{
						$win_amt=($half_sangam_val_2/10)*$rs->points;
						
						$points=$rs->points;
						
						$data_array[$i]['points']=$rs->points;
						$data_array[$i]['user_id']=$rs->user_id;
						$data_array[$i]['user_name']=$rs->user_name;
						$data_array[$i]['pana']=$rs->pana;
						$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
						$data_array[$i]['win_amt']=$win_amt;
						$data_array[$i]['bid_id']=$rs->bid_id;
						
					}
				}
				else if($rs->pana=='Full Sangam')
				{
					$win_number=$open_number;
					$win_number=$close_number;
					
					if($open_number==$rs->digits && $close_number==$rs->closedigits)
					{
						$win_amt=($full_sangam_val_2/10)*$rs->points;
						
						$points=$rs->points;
						
						$data_array[$i]['points']=$rs->points;
						$data_array[$i]['user_id']=$rs->user_id;
						$data_array[$i]['user_name']=$rs->user_name;
						$data_array[$i]['pana']=$rs->pana;
						$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
						$data_array[$i]['win_amt']=$win_amt;
						$data_array[$i]['bid_id']=$rs->bid_id;
					}
				}
				else if($rs->pana=='Triple Pana')
				{
					if($close_number==$rs->digits)
					{
						$win_amt=($tripple_pana_val_2/10)*$rs->points;
						
						$points=$rs->points;
						
						$data_array[$i]['points']=$rs->points;
						$data_array[$i]['user_id']=$rs->user_id;
						$data_array[$i]['user_name']=$rs->user_name;
						$data_array[$i]['pana']=$rs->pana;
						$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
						$data_array[$i]['win_amt']=$win_amt;
						$data_array[$i]['bid_id']=$rs->bid_id;
					}
				}
				else if($rs->pana=='Double Pana')
				{
					if($close_number==$rs->digits)
					{
						$win_amt=($double_pana_val_2/10)*$rs->points;
						
						$points=$rs->points;
						
						$data_array[$i]['points']=$rs->points;
						$data_array[$i]['user_id']=$rs->user_id;
						$data_array[$i]['user_name']=$rs->user_name;
						$data_array[$i]['pana']=$rs->pana;
						$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
						$data_array[$i]['win_amt']=$win_amt;
						$data_array[$i]['bid_id']=$rs->bid_id;
					}
				}
				
				else if($rs->pana=='Single Pana')
				{
					if($close_number==$rs->digits)
					{
						$win_amt=($single_pana_val_2/10)*$rs->points;
						
						$points=$rs->points;
						
						$data_array[$i]['points']=$rs->points;
						$data_array[$i]['user_id']=$rs->user_id;
						$data_array[$i]['user_name']=$rs->user_name;
						$data_array[$i]['pana']=$rs->pana;
						$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
						$data_array[$i]['win_amt']=$win_amt;
						$data_array[$i]['bid_id']=$rs->bid_id;
						
					}
				}
				
				else if($rs->pana=='Jodi Digit')
				{
					$win_number1=$close_number[0]+$close_number[1]+$close_number[2];
					$win_number2=$open_number[0]+$open_number[1]+$open_number[2];
					
					if($win_number1>9)
					$win_number1=$win_number1%10;
				
					if($win_number2>9)
					$win_number2=$win_number2%10;
					
					$win_number=$win_number2.$win_number1;
					if($win_number==$rs->digits)
					{
						$win_amt=($jodi_digit_val_2/10)*$rs->points;
						
						$points=$rs->points;
						
						$data_array[$i]['points']=$rs->points;
						$data_array[$i]['user_id']=$rs->user_id;
						$data_array[$i]['user_name']=$rs->user_name;
						$data_array[$i]['pana']=$rs->pana;
						$data_array[$i]['bid_tx_id']=$rs->bid_tx_id;
						$data_array[$i]['win_amt']=$win_amt;
						$data_array[$i]['bid_id']=$rs->bid_id;
					}
				}
				
				$win_amt_sum=$win_amt+$win_amt_sum;
				$points_amt_sum=$points+$points_amt_sum;
				if($win_amt>0)
				$i++;
				
			}
			
			
			$where=array($this->tb18.'.game_id'=>$game_id,'pay_status'=>0,'bid_date'=>$result_date,'session'=>'Open','pana'=>'Half Sangam');	
			$joins = array(

								array(

									'table' => $this->tb16,
									'condition' => $this->tb16.'.game_id = '.$this->tb18.'.game_id',
									'jointype' => 'LEFT'
									),
								array(

								'table' => $this->tb3,
								'condition' => $this->tb3.'.user_id = '.$this->tb18.'.user_id',
								'jointype' => 'LEFT'
								)

							);
							
			$columns=$this->tb16.".game_name,pana,".$this->tb18.".user_id,bid_id,session,digits,closedigits,points,bid_tx_id,pay_status,user_name";
			$by = 'bid_id';

			$result= $this->Adminamodel->get_joins_where_by($this->tb18,$columns,$joins,$by,$where);	

			$data_array2=array();
			$i=0;
			
			$win_amt_sum2=0;
			$points_amt_sum2=0;			
			foreach($result as $rs)
			{
				
				$win_amt2=0;
				$points2=0;
				
				if($rs->pana=='Half Sangam')
				{
					$win_number2=$open_number[0]+$open_number[1]+$open_number[2];
					
					if($win_number2>9)
					$win_number2=$win_number2%10;
				
					if($close_number==$rs->closedigits && $win_number2==$rs->digits)
					{
						$win_amt2=($half_sangam_val_2/10)*$rs->points;
						
							$points2=$rs->points;
						
						$data_array2[$i]['points']=$rs->points;
						$data_array2[$i]['user_id']=$rs->user_id;
						$data_array2[$i]['user_name']=$rs->user_name;
						$data_array2[$i]['pana']=$rs->pana;
						$data_array2[$i]['bid_tx_id']=$rs->bid_tx_id;
						$data_array2[$i]['win_amt']=$win_amt2;
						$data_array2[$i]['bid_id']=$rs->bid_id;
						
					}
				}
				
				$win_amt_sum2=$win_amt2+$win_amt_sum2;
				$points_amt_sum2=$points2+$points_amt_sum2;
				if($win_amt2>0)
				$i++;
				
				
			}
			$data['winner_list'] = array_merge($data_array,$data_array2); 
			$data['win_amt_sum'] = $win_amt_sum+$win_amt_sum2; 
			$data['points_amt_sum'] = $points_amt_sum+$points_amt_sum2; 
			$data['status'] = "success";
		}
		echo json_encode($data); 
	}
	
	public function checkOpenMarketResulDeclaration()
	{
		$game_id = trim($this->input->post('game_id'));
		$result_date = trim($this->input->post('result_date'));
		$where = array('game_id'=>$game_id,'result_date'=>$result_date);
		$result = $this->Adminamodel->get_data($this->tb21,$where);
		$open_decleare_status = 0;
		$open_number = 0;
		if(count($result)>0){
			foreach($result as $rs){
				$open_decleare_status = $rs->open_decleare_status;
				$open_number = $rs->open_number;
			}
		}
		
		$data['open_decleare_status'] = $open_decleare_status; 
		$data['open_number'] = $open_number;
		echo json_encode($data); 
	}

}

