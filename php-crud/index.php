<?php
include('db.php');
include('function.php');
$query = '';
$output = array();
$query .= "SELECT * FROM videojuego ";
$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
?>
<html>
	<head>
		<title>CRUD</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>		
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<style>
			body
			{
				margin:0;
				padding:0;
				background-color:#f1f1f1;
			}
			.box
			{
				width:1270px;
				padding:20px;
				background-color:#fff;
				border:1px solid #ccc;
				border-radius:5px;
				margin-top:25px;
			}
		</style>
	</head>
	<body>
		<div class="container box">
			<h1 align="center">Mantenimiento de videojuegos</h1>
			<br />
			<div class="table-responsive">
				<br />
				<div align="right">
					<button type="button" id="add_button" data-toggle="modal" data-target="#userModal" class="btn btn-info btn-lg">Add</button>
				</div>
				<br /><br />
				<table id="user_data" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th width="10%">Image</th>
							<th width="35%">Nombre</th>
							<th width="35%">Clasificación</th>
							<th width="35%">Precio</th>
							<th width="20%">Acciones</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($result as $row){ ?>
							<tr>
								<td><img src="<?php echo $row['imagengrande'];?>" width="100"></td>
								<td><?php echo $row['nombre'];?></td>
								<td><?php echo $row['clasificacion'];?></td>
								<td><?php echo $row['precio'];?></td>
								<td>
									<a class="btn btn-warning btn-block  edit-row" href="#" data-id="<?php echo $row['idVideojuego'];?>"">Editar</a>
									<a class="btn btn-danger btn-block delete" href="delete.php?user_id=<?php echo $row['idVideojuego'];?>">Eliminar</a>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
				
			</div>
		</div>
	</body>
</html>

<div id="userModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="user_form" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add User</h4>
				</div>
				<div class="modal-body">
					<label>Enter Nombre</label>
					<input type="text" name="video_name" id="video_name" class="form-control" />
					<br />
					<label>Enter Clasificación</label>
					<input type="text" name="rating" id="rating" class="form-control" />
					<br />
					<label>Enter Precio</label>
					<input type="text" name="price" id="price" class="form-control" />
					<br />
					<label>Select User Image</label>
					<input type="file" name="user_image" id="user_image" />
					<span id="user_uploaded_image"></span>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="user_id" id="user_id" />
					<input type="hidden" name="operation" id="operation" />
					<input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>

<div id="userModalEdit" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="user_form_edit" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Modify User</h4>
				</div>
				<div class="modal-body">
					<label>Enter Nombre</label>
					<input type="text" name="video_name" id="video_name" class="form-control" />
					<br />
					<label>Enter Clasificación</label>
					<input type="text" name="rating" id="rating" class="form-control" />
					<br />
					<label>Enter Precio</label>
					<input type="text" name="price" id="price" class="form-control" />
				</div>
				<div class="modal-footer">
					<input type="hidden" name="id" id="id" />
					<input type="hidden" name="operation" id="operation"/>
					<input type="submit" name="action" id="action" class="btn btn-success" value="Edit" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript" language="javascript" >
$(document).ready(function(){
	$('#add_button').click(function(){   
		$('#user_form')[0].reset();   
		$('.modal-title').text("Add User");
		$('#action').val("Add");
		$('#operation').val("Add");
		$('#user_uploaded_image').html('');
	});

	$('.edit-row').click(function(e){
		e.preventDefault();
		var element = $(this);
		var id = element.data('id');
		$.post('insert.php', {
			id: id,
			operation:'get' 
		}, function(response){
			console.log(response)
			var form = $('#user_form_edit');
			form.find('#id').val(response.id);
			form.find('#video_name').val(response.nombre);
			form.find('#rating').val(response.clasificacion);
			form.find('#price').val(response.precio);
			$('#userModalEdit').modal('show');
		}, 'json');

		/*$('#user_form')[0].reset();
		$('.modal-title').text("Add User");
		$('#action').val("Add");
		$('#operation').val("Add");
		$('#user_uploaded_image').html('');*/
	});
	$('#user_data').DataTable();
	/*var dataTable = $('#user_data').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"fetch.php",
			type:"GET"
		},
		"columnDefs":[
			{
				"targets":[0, 3, 4],
				"orderable":false,
			},
		],

	});*/

	$(document).on('submit', '#user_form', function(event){
		event.preventDefault();
		var firstName = $('#video_name').val();
		var lastName = $('#rating').val();
		var lastName = $('#price').val();
		var extension = $('#user_image').val().split('.').pop().toLowerCase();
		if(extension != '')
		{
			if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
			{
				alert("Invalid Image File");
				$('#user_image').val('');
				return false;
			}
		}	
		if(firstName != '' && lastName != '')
		{
			$.ajax({
				url:"insert.php",
				method:'POST',
				data:new FormData(this),
				contentType:false,
				processData:false,
				success:function(data)
				{
					alert(data);
					$('#user_form')[0].reset();
					$('#userModal').modal('hide');
					dataTable.ajax.reload();
				}
			});
		}
		else
		{
			alert("Both Fields are Required");
		}
	});

	// EDIT 

	$(document).on('submit', '#user_form_edit', function(event){
		event.preventDefault();
			
			$('#user_form_edit').find('#video_name').val();
			$('#user_form_edit').find('#clasificacion').val();
			$('#user_form_edit').find('#precio').val();
		

		
			$.ajax({
				url:"insert.php",
				method:'POST',
				data:new FormData(this),
				contentType:false,
				processData:false,
				success:function(data)
				{
					
					$('#user_form_edit')[0].reset();
					$('#userModalEdit').modal('hide');
					$('#action').val("Edit");
					$('#operation').val("Edit");
					dataTable.ajax.reload();
				}
			});
		
	
	});



	
	// $(document).on('click', '.#user_form_edit', function(){
	// 	var user_id = $(this).attr("id");
	// 	$.ajax({
	// 		url:"fetch_single.php",
	// 		method:"POST",
	// 		data:{user_id:user_id},
	// 		dataType:"json",
	// 		success:function(data)
	// 		{
	// 			$('#user_form_edit').modal('show');
	// 			$('#video_name').val(data.video_name);
	// 			$('#rating').val(data.rating);
	// 			$('#price').val(data.price);
	// 			$('.modal-title').text("Edit User");
	// 			$('#user_id').val(user_id);
	// 			$('#action').val("Edit");
	// 			$('#operation').val("Edit");
	// 		}
	// 	})
	// });
	
	$(document).on('click', '.delete', function(){
		var user_id = $(this).attr("id");
		if(confirm("Are you sure you want to delete this?"))
		{
			$.ajax({
				url:"delete.php",
				method:"POST",
				data:{user_id:user_id},
				success:function(data)
				{
					alert(data);
					dataTable.ajax.reload();
				}
			});
		}
		else
		{
			return false;	
		}
	});
	
	
});
</script>