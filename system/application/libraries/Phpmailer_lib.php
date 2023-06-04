<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class Phpmailer_lib
{
    public function __construct(){
        
    }

    public function load(){
        require_once APPPATH.'third_party/phpmailer/src/Exception.php';
        require_once APPPATH.'third_party/phpmailer/src/PHPMailer.php';
        require_once APPPATH.'third_party/phpmailer/src/SMTP.php';
        
        $mail = new PHPMailer;
        return $mail;
    } 
	
	function sendMail($to,$subject,$message)
	{
		$mail = $this->load();
        
        $mail->isSMTP();
        $mail->Host     = 'mail.volansoftlab.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'no-reply@volansoftlab.com';
        $mail->Password = 'P27*6NEBB6dA';
		$mail->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);
        $mail->SMTPSecure = 'tls';
        $mail->Port     = 587;
        
        $mail->setFrom('info@volansoftlab.com', 'volansoftlab.com');
        $mail->addReplyTo('info@volansoftlab.com', 'volansoftlab.com');
        
        // Add a recipient
        $mail->addAddress($to);
        
        // Add cc or bcc 
        /* $mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com'); */
        
        // Email subject
        $mail->Subject = $subject;
        
        // Set email format to HTML
        $mail->isHTML(true);
        
        // Email body content
		$logo_path=base_url().'assets/img/logo.png';
		$messageadmin='<html>
			<head>
			<meta charset="UTF-8">
				<title>Femora</title>
			</head>
		<body>
			<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#eff0f2">
				<tbody>
					<tr style="border-collapse:collapse">
						<td align="center" bgcolor="#EFF0F2" style="border-collapse:collapse;font-family:Helvetica Neue,Arial,Helvetica,sans-serif">
							<table style="margin:0 10px" width="640" cellpadding="0" cellspacing="0" border="0">
								<tbody>
									<tr style="border-collapse:collapse">
										<td width="640" align="center" bgcolor="#EFF0F2" style="border-collapse:collapse;font-family:Helvetica Neue,Arial,Helvetica,sans-serif">
											
											<table width="640" cellpadding="0" cellspacing="0" border="0">
												<tbody>
													<tr style="border-collapse:collapse">
														
														<td style="border-collapse:collapse;font-family:Helvetica Neue,Arial,Helvetica,sans-serif; background-color: #dedcdc;">
															
															<div align="center" style="margin:10px;padding: 0px 0;margin-bottom: 28px;">
																<div style="display: inline-block;   border-radius: 5px; position: absolute;  padding: 8px 15px;">
																	<a href="http://volansoftlab.com/femora/femora-admin" style="text-decoration:none" target="_blank">
																		<img src="'.$logo_path.'" style="height: 57px;">
																		
																	</a>
																</div>
															</div>
														</td>
														
													</tr>
												</tbody>
											</table>
											
											
											
										</td>
									</tr>
									<tr style="border-collapse:collapse">
										<td width="640" bgcolor="#ffffff" style="border-collapse:collapse;font-family:Helvetica Neue,Arial,Helvetica,sans-serif;padding-top: 20px;">
											<table width="640" cellpadding="0" cellspacing="0" border="0">
												<tbody>
													<tr style="border-collapse:collapse">
														<div align="left" style="font-size:15px;line-height:21px;color:#676c70;margin:20px 50px;font-family:Helvetica Neue,Arial,Helvetica,sans-serif;font-weight:400">';
														
														
						$messageadmin.=$message;
						
						$messageadmin.='</div>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>		
									
									<tr style="border-collapse:collapse">
										<td width="640" align="center" bgcolor="#EFF0F2" style="border-collapse:collapse;font-family:Helvetica Neue,Arial,Helvetica,sans-serif">
											
											<table width="640" cellpadding="0" cellspacing="0" border="0">
												<tbody>
													<tr style="border-collapse:collapse">
														
														<td style="border-collapse:collapse;font-family:Helvetica Neue,Arial,Helvetica,sans-serif">
															
															<div align="center" style="margin: 20px 0;">
																<p align="center" style="font-size:11px;line-height:15px;color:#888;margin-top:0;margin-bottom:3px;white-space:normal">
																										<span>©2020 <a href="http://volansoftlab.com/femora/femora-admin">femora</a> - All Rights Reserved.</span>
																								</p>
															</div>
														</td>
														
													</tr>
												</tbody>
											</table>
											
											
											
										</td>
									</tr>
									
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</body>
		</html>';
		$mail->Body = $messageadmin;
		
        // Send email
        if(!$mail->send()){
            return 0;
        }else{
			return 1;
        }
    }
}