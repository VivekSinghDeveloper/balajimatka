<table id="withdrawreqtable" class="table table-bordered table-striped">
	<thead>						
		<tr>					
			<th class="w-25">Name</th>
			<th>Details</th> 		
			<th class="w-25">Name</th>
			<th>Details</th> 			
		</tr>
	</thead>
	<tbody>		
		<tr>
			<td>User Name</td>
			<td><?php if(isset($user_name)){ echo $user_name; } ?></td>
			<td>Request Amount</td>
			<td><?php if(isset($request_amount)){ echo $request_amount; ?>
			<a role="button" class="dataCopy" data-text="<?php echo $request_amount?>"><i class="bx bx-copy"></i></a>
			<?php } ?></td>
		</tr>
		<tr>
			<td>Request Number</td>
			<td><?php if(isset($request_number)){ echo $request_number; } ?></td>
			<td>Payment Method</td>
			<td><?php if(isset($payment_method) && $payment_method == 2 ) { echo '<badge class="badge badge-pill badge-soft-info">Paytm Transfer</badge>'; } else if($payment_method == 3) { echo '<badge class="badge badge-pill badge-soft-info">Google Pay Transfer</badge>'; } else if($payment_method == 4){ echo '<badge class="badge badge-pill badge-soft-info">PhonePe Transfer</badge>'; } else if($payment_method == 1) { echo '<badge class="badge badge-pill badge-soft-info">Bank Transfer</badge>'; }?></td>
		</tr>
		<?php if($payment_method == 1) { ?>
		<tr>
			<td>Bank Name</td>
			<td><?php if(isset($bank_name)){ echo $bank_name; } ?></td>
			<td>Branch Address</td>
			<td><?php if(isset($branch_address)){ echo $branch_address; } ?></td>
		</tr>
		<tr>
			<td>A/C Holder Name</td>
			<td><?php if(isset($ac_holder_name)){ echo $ac_holder_name; } ?></td>
			<td>Account Number</td>
			<td><?php if(isset($ac_number)){ echo $ac_number; ?>
			<a role="button" class="dataCopy" data-text="<?php echo $ac_number?>"><i class="bx bx-copy"></i></a>
			<?php } ?></td>
		</tr>
		<tr>
			<td>IFSC Code</td>
			<td><?php if(isset($ifsc_code)){ echo $ifsc_code; ?>
				<a role="button" class="dataCopy" data-text="<?php echo $ifsc_code?>"><i class="bx bx-copy"></i></a>
				<?php } ?> 
			</td>
			<td>Request Date</td>
			<td><?php if(isset($insert_date)){ echo $insert_date; } ?></td>
		</tr>
		<?php } ?>
		<?php if($payment_method != 1 ) { ?>
		<tr>
			<td><?php if($payment_method == 3 ) { echo 'Google Pay Number'; } else if($payment_method == 4) { echo 'PhonePe Number'; }else if($payment_method == 2){ echo 'Paytm Number' ;} ?></td>
			<td><?php if($payment_method == 2 && $paytm_number != '' ) { echo $paytm_number; ?>					<a role="button" class="dataCopy" data-text="<?php echo $paytm_number?>"><i class="bx bx-copy"></i></a>				<?php } else if($payment_method == 3 && $google_pay_number != '') { echo $google_pay_number; ?> 					<a role="button" class="dataCopy" data-text="<?php echo $google_pay_number?>"><i class="bx bx-copy"></i></a>				<?php }else if($payment_method == 4 && $phone_pay_number!='' ){ echo $phone_pay_number; ?> 					<a role="button" class="dataCopy" data-text="<?php echo $phone_pay_number?>"><i class="bx bx-copy"></i></a>				<?php } ?></td>
			<td>Request Date</td>
			<td><?php if(isset($insert_date)){ echo $insert_date; } ?></td>
		</tr>
		<?php } ?>
		<tr>
			<td>Request Accept Date</td>
			<td><?php if(isset($accepte_date)){ echo $accepte_date; } else { echo 'N/A'; } ?></td>
			<td>Remark</td>
			<td><?php if(isset($remark)){ echo $remark; } ?></td>
		</tr>
		<tr>
			<td>Payment Receipt</td>
			<td><?php if(isset($payment_receipt) && $payment_receipt!='') { ?>
				<a class="item" target="_blank" href="<?php echo base_url();?>uploads/file/<?php echo $payment_receipt; ?>">
					<img src="<?php echo base_url();?>uploads/file/<?php echo $payment_receipt; ?>" width="50">
				</a>
				
			<?php } else { echo "N/A"; } ?>
			</td>
			<td></td>
			<td></td>
		</tr>
	</tbody>
</table>