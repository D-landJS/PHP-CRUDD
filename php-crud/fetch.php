<?php
include('db.php');
include('function.php');
$query = '';
$output = array();
$query .= "SELECT * FROM videojuego ";

/*if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE video_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR rating LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR price LIKE "%'.$_POST["search"]["value"].'%" ';
}
if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY id DESC ';
}	
if($_POST["length"] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}*/



$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();

foreach($result as $row)
{
	$image = '';
	if($row["imagengrande"] != '')
	{
		$image = '<img src="'.$row["imagengrande"].'" class="img-thumbnail" width="50" height="35" />';
	}
	else
	{
		$image = '';
	}
	$sub_array = array();
	$sub_array[] = $image;
	$sub_array[] = $row["nombre"];
	$sub_array[] = $row["clasificacion"];
	$sub_array[] = $row["precio"];
	$sub_array[] = '<button type="button" name="update" id="'.$row["idVideojuego"].'" class="btn btn-warning btn-xs update">Update</button>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["idVideojuego"].'" class="btn btn-danger btn-xs delete">Delete</button>';
	$data[] = $sub_array;
}
$output = array(
	"draw"				=>	1,
	"recordsTotal"		=> 	$filtered_rows,
	//"recordsFiltered"	=>	get_total_all_records(),
	"recordsFiltered"	=>	$filtered_rows,
	"data"				=>	$data
);
echo json_encode($output);
?>