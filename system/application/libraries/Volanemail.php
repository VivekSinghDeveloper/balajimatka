<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Volanemail {
	public function __construct() 
		{			
			
		}
		public function sendMail($user,$sub,$message)
		{
			$logo_path=base_url().'assets/img/logo/logo.png';	
				$fromadmin = "info@globalbitco.in";
				$replyadmin = "info@globalbitco.in";
				$headeradmin = "From: globalbitco <" . $fromadmin . ">\r\n";
				$headeradmin .= "Reply-To: " . $replyadmin . "\r\n";
				$headeradmin .= "MIME-Version: 1.0\r\n";
				$headeradmin .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				$messageadmin='<html>
	<head>
	<meta charset="UTF-8">
		<title>globalbitco</title>
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
												
												<td style="border-collapse:collapse;font-family:Helvetica Neue,Arial,Helvetica,sans-serif; background-color: #071635;">
													
													<div align="center" style="margin:10px;padding: 0px 0;margin-bottom: 28px;">
														<div style=" background-color: #fff; display: inline-block;   border-radius: 5px; position: absolute;  padding: 8px 15px;">
															<a href="https://globalbitco.in/" style="text-decoration:none" target="_blank">
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
                                                                                                <span>©2019 <a href="https://globalbitco.in">https://globalbitco.in</a> - All Rights Reserved.</span>
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
				if(mail($user, $sub, $messageadmin, $headeradmin))
				{
					return 1;
				}
		}
}