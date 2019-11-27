<?php

include('db.php');
include("function.php");

if(isset($_GET["user_id"]))
{
	$image = get_image_name($_GET["user_id"]);
	if($image != '')
	{
		@unlink($image);
	}
	$statement = $connection->prepare(
		"DELETE FROM videojuego WHERE idVideojuego = :id"
	);
	$result = $statement->execute(
		array(
			':id'	=>	$_GET["user_id"]
		)
	);
	
	if(!empty($result))
	{
		echo 'Data Deleted';
	}
}



?>