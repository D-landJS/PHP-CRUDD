<?php
include('db.php');
include('function.php');
if(isset($_POST["operation"]))
{
	if($_POST["operation"] == "Add")
	{
		$image = '';
		if($_FILES["user_image"]["name"] != '')
		{
			$image = upload_image();
		}
		$statement = $connection->prepare("
			INSERT INTO videojuego (nombre, clasificacion, precio, imagengrande) 
			VALUES (:video_name, :rating, :price, :image)
		");
		$result = $statement->execute(
			array(
				':video_name'	=>	$_POST["video_name"],
				':rating'		=>	$_POST["rating"],
				':price'		=>	$_POST["price"],
				':image'		=>	$image
			)
		);
		if(!empty($result))
		{
			echo 'Data Inserted';
		}
	}
	if($_POST["operation"] == "get")
	{
		$query = 'select * from videojuego where idVideojuego='.$_POST['id'];
		$statement = $connection->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row){
			$data['id'] = $row['idVideojuego'];
			$data['nombre'] = $row['nombre'];
			$data['clasificacion'] = $row['clasificacion'];
			$data['precio'] = $row['precio'];
		}
		echo json_encode($data);
	}
	if($_POST["operation"] == "Edit")
	{
		// $image = '';
		// if($_FILES["user_image"]["name"] != '')
		// {
		// 	$image = upload_image();
		// }
		// else
		// {
		// 	$image = $_POST["hidden_user_image"];
		// }
		$statement = $connection->prepare(
			"UPDATE videojuego 
			SET nombre = :video_name, clasificacion = :rating, precio = :precio
			WHERE idVideojuego = :id
			"
		);
		$result = $statement->execute(
			array(
				':video_name'	=>	$_POST["video_name"],
				':rating'		=>	$_POST["rating"],
				':price'		=>	$_POST["price"],
				':id'			=>	$_POST["user_id"]
			)
		);
		if(!empty($result))
		{
			echo 'Data Updated';
		}
	}
}

?>