<div class="page-content">
<div class="container-fluid">

	<div class="row">

		<div class="col-sm-12 col-xl-12 col-md-12">

            <div class="row">

				<div class="col-sm-12">

                    <div class="card">

						<div class="card-body">
						<h5>Transfer Point Report</h5>

							<form class="theme-form mega-form" id="transferReportFrm" name="transferReportFrm" method="post">

							<div class="row">
                                   <div class="form-group col-md-4">
										<label>Date</label>
										<?php $date = date('Y-m-d');?>
										<div class="date-picker">
											<div class="input-group">
											  <input class="form-control digits" type="date" value="<?php echo $date;?>" name="transfer_date" id="transfer_date" max="<?php echo $date;?>" >
											</div>
										</div>
									</div>
							
								<div class="form-group col-md-2">
									<label>&nbsp;</label>
									<button type="submit" class="btn btn-primary btn-block" id="submitBtn" name="submitBtn">Submit</button>

								</div>
	</div>
							</div>

								<div class="form-group">

									<div id="error_msg"></div>

								</div>

							</form>

						</div>

                    </div>

                </div>

			</div>

		</div>

	</div>




<div class="container-fluid">

	<div class="row"> 

		<div class="col-12">

			<div class="card">

				<div class="card-body">

					<h4 class="card-title d-flex align-items-center justify-content-between">Transfer List
					<badge class="btn btn-primary waves-effect waves-light btn-sm">Total Transfer Amount:<i class="bx bx-rupee" aria-hidden="true"></i><span class="totalamt">0</span></badge>
					</h4>

					<div class="dt-ext table-responsive">

						<table id="resultHistory" class="table table-striped table-bordered">

							<thead> 

								<tr>
								<th>#</th>

									<th>Sender Name</th>

									

									<th>Receiver Name</th>
									<th>Amount</th>
									<th>Date</th>
								</tr>

							</thead>

							<tbody id="transfer_data">

							

							</tbody>

						</table>

					</div>

				</div>

			</div>

		</div>

	</div>

</div>

</div>