<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>AdminLTE 2 | Blank Page</title>
	<?php include "../layout/header.php" ?>
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				TUTORIAL PHP CRUD
				<small>visit <a href="https://seegatesite.com">seegatesite.com</a> for more tutorial</small>
			</h1>
		</section>
		<!-- Main content -->
		<section class="content">
			<!-- Default box -->
			<div class="box">
				<div class="box-body">
					<button class="btn btn-primary margin" id="btn-add" title="New button"><i class="fa fa-plus"></i> New Customer</button>
					<div class="table-responsive margin">
						<table id="table-customer" class="table table-bordered">
							<thead>
								<tr>
									<th style="width: 10px">#</th>
									<th style="width: 150px">Name</th>
									<th style="width: 50px">Gender</th>
									<th style="width: 50px">Country</th>
									<th style="width: 25px;">Phone</th>
									<th style="width: 50px;"></th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
	<!-- Modal -->
	<div class="modal fade" id="modal-customer" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Form Customer</h4>
				</div>
				<div class="modal-body">
					<div class="box-body">
						<div class="form-horizontal">
							<div class="form-group">
								<label class="col-sm-3 control-label">Name</label>
								<div class="col-sm-9">
									<input type="hidden" id="crud">
									<input type="hidden" id="txtcode">
									<input type="text" class="form-control" id="txtname" placeholder="Customer Name">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Gender</label>
								<div class="col-sm-9">
									<select class="form-control" id="cbogender">
										<option value="Male">Male</option>
										<option value="Female">Female</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Country</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="txtcountry" placeholder="Country Name">
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label">Phone</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="txtphone" placeholder="phone number">
								</div>
							</div>

						</div>
					</div>						
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" title="save button" id="btn-save"> <i class="fa fa-save"></i> Save</button>
				</div>
			</div>
		</div>
	</div>
	<?php include "../layout/footer.php" ?>
	<script src="../../bower_components/bootstrap-sweetalert/dist/sweetalert.min.js"></script>
	<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){

			// function to repair keyboard tab in modal dialog adminlte
			(function (){
				var close = window.swal.close;
				var previousWindowKeyDown = window.onkeydown;
				window.swal.close = function() {
					close();
					window.onkeydown = previousWindowKeyDown;
				};
			})();


			$('#table-customer').DataTable({
				"paging": true,
				"lengthChange": false,
				"searching": false,
				"processing": true,
				"ordering": false,
				"info": false,
				"responsive": true,
				"autoWidth": false,
				"pageLength": 100,
				"dom": '<"top"f>rtip',
				"fnDrawCallback": function( oSettings ) {
				},
				"ajax": {
					"url": "customer.php",
					"type": "POST",
					"data" : {
						method : "list_customer"
					},
					error: function (request, textStatus, errorThrown) {
						swal(request.responseJSON.message);
					}
				},

				columns: [
				{ "data": null,render :  function ( data, type, full, meta ) {
					return  meta.row + 1;
				}},
				{ "data": "name" },
				{ "data": "gender" },
				{ "data": "country" },
				{ "data": "phone" },
				{ "data": null, render : function(data,type,row){
					return "<button title='Edit' class='btn btn-edit btn-warning btn-xs'><i class='fa fa-pencil'></i> Edit</button>  <button title='Delete' class='btn btn-hapus  btn-danger btn-xs'><i class='fa fa-remove'></i> Delete</button> ";
				} 		},
				]
			});

			$("#btn-save").click(function(){
				if($("#txtname").val() == ''){
					swal("Please enter name");
					return;
				}
				if($("#txtcountry").val() == ''){
					swal("Please enter country");
					return;
				}
				if($("#txtphone").val() == ''){
					swal("PLease enter contact number");
					return;
				}


				if($("#crud").val() == 'N'){
					swal({
						title: "New",
						text: "Create new customer ?",
						type: "warning",
						showCancelButton: true,
						confirmButtonClass: "btn-primary",
						confirmButtonText: "Save",
						closeOnConfirm: false,
						showLoaderOnConfirm: true
					},
					function(){

						add_customer($("#txtname").val(),$("#txtcountry").val(),$("#cbogender").val(),$("#txtphone").val());
					});
				}else{
					swal({
						title: "Edit",
						text: "Edit customer ?",
						type: "warning",
						showCancelButton: true,
						confirmButtonClass: "btn-primary",
						confirmButtonText: "Update",
						closeOnConfirm: false,
						showLoaderOnConfirm: true
					},
					function(){
						edit_customer($("#txtcode").val(),$("#txtname").val(),$("#txtcountry").val(),$("#cbogender").val(),$("#txtphone").val());

					});
				}
			});

			$("#btn-add").click(function(){
				$("#modal-customer").modal("show");
				$("#txtname").val("");
				$("#txtcountry").val("");
				$("#txtphone").val("");
				$("#crud").val("N");
			});
		});



		$(document).on("click",".btn-edit",function(){
			var current_row = $(this).parents('tr'); 
			if (current_row.hasClass('child')) { 
				current_row = current_row.prev(); 
			}
			var table = $('#table-customer').DataTable(); 
			var data = table.row( current_row).data();
			$("#txtname").val(data.name);
			$("#txtcode").val(data.id_cust);
			$("#txtcountry").val(data.country);
			$("#cbogender").val(data.gender)
			$("#txtphone").val(data.phone)
			$("#modal-customer").modal("show");
			setTimeout(function(){ 
				$("#txtname").focus()
			}, 1000);

			$("#crud").val("E");

		});

		$(document).on("click",".btn-hapus",function(){
			let current_row = $(this).parents('tr'); 
			if (current_row.hasClass('child')) { 
				current_row = current_row.prev(); 
			}
			let table = $('#table-customer').DataTable(); 
			let data = table.row( current_row).data();
			let idcust = data.id_cust;
			swal({
				title: "Delete",
				text: "Delete customer ?",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Delete",
				closeOnConfirm: false,
				showLoaderOnConfirm: true
			},
			function(){

				let ajax = {
					method : "delete_customer",
					id_cust : idcust,
				}
				$.ajax({
					url:"customer.php",
					type: "POST",
					data: ajax,
					success: function(data, textStatus, jqXHR)
					{
						$resp = JSON.parse(data);
						if($resp['status'] == true){
							swal("Success delete customer");
							let xtable = $('#table-customer').DataTable(); 
							xtable.ajax.reload( null, false );
						}else{
							swal("Error delete customer : "+$resp['message'])
						}
						
					},
					error: function (request, textStatus, errorThrown) {
						swal("Error ", request.responseJSON.message, "error");
					}
				});
			});
		});


		function add_customer(nm,ctr,gdr,phn){
			let ajax = {
				method: "new_customer",
				name : nm,
				country:ctr,
				gender:gdr,
				phone:phn

			}
			$.ajax({
				url: "customer.php",
				type: "POST",
				data: ajax,
				success: function(data, textStatus, jqXHR)
				{
					$resp = JSON.parse(data);
					if($resp['status'] == true){
						$("#txtname").val("");
						$("#txtcountry").val("");
						$("#txtphone").val("");
						$("#txtcode").val("");
						$("#txtcode").focus();
						let xtable = $('#table-customer').DataTable(); 
						xtable.ajax.reload( null, false );
						swal("Success save new customer");
					}else{
						swal("Error save customer : "+$resp['message'])
					}
				},
				error: function (request, textStatus, errorThrown) {
					swal("Error ", request.responseJSON.message, "error");
				}
			});
		}
		
		function edit_customer(id,nm,ctr,gdr,phn){
			let ajax = {
				method: "edit_customer",
				id_cust :  id,
				name : nm,
				country:ctr,
				gender:gdr,
				phone:phn

			}
			$.ajax({
				url:  "customer.php",
				type: "POST",
				data: ajax,
				success: function(data, textStatus, jqXHR)
				{
					$resp = JSON.parse(data);

					if($resp['status'] == true){
						$("#modal-customer").modal("hide");
						swal("Success edit customer ");
						let xtable = $('#table-customer').DataTable(); 
						xtable.ajax.reload( null, false );
					}else{
						swal("Error save customer : "+$resp['message'])
					}
				},
				error: function (request, textStatus, errorThrown) {
					swal("Error ", request.responseJSON.message, "error");

				}
			});
		}
	</script>
</body>
</html>
